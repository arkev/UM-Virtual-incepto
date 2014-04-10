<?php


class Post_Util
{

    static function get_post_attachments_id($post_id)
    {
        $attachments = get_posts(
            array('post_type' => 'attachment',
                'post_parent' => $post_id,
                'post_status' => null,
                'numberposts' => -1));
        $ids = array();
        foreach ($attachments as $attachment) {
            array_push($ids, $attachment->ID);
        }
        return $ids;
    }

    static function get_post_by_id($post_id)
    {
        if (strlen($post_id) > 0 && is_numeric($post_id)) {
            return get_post($post_id);
        } elseif (strlen($post_id) > 0) {
            global $wpdb;
            $post_id = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_title = '" . $post_id . "'");
            if (is_numeric($post_id)) {
                return get_post($post_id);
            }
        }
        return null;
    }


    static function get_post_format($post = null)
    {
        $post = isset($post) ? $post : $GLOBALS['post'];
        if (isset($post)) {
            $post_format = get_post_format($post);
            if (false == $post_format) {
                return 'standard';
            } else {
                return $post_format;
            }
        } else {
            return 'standard';
        }
    }

    static function get_post_excerpt($limit = 350, $read_more_symbol = '&hellip;')
    {
        $post_format = Post_Util::get_post_format();
        if ($post_format == 'quote') {
            $sc = Post_Util::get_first_shortcode_of_type('bq');
            if ($sc) {
                return do_shortcode($sc);
            }
        }
        $excerpt = do_shortcode(get_the_excerpt());
        return inc_shrink($excerpt, $limit, $read_more_symbol);
    }

    static function get_first_shortcode_of_type($shortcode_name, $post = null)
    {
        $post = isset($post) ? $post : $GLOBALS['post'];
        if (isset($post) && $post) {
            $sc_pattern = '/\[(\[?)(' . $shortcode_name . ')(?![\w-])([^\]\/]*(?:\/(?!\])[^\]\/]*)*?)(?:(\/)\]|\](?:([^\[]*+(?:\[(?!\/\2\])[^\[]*+)*+)\[\/\2\])?)(\]?)/s';
            $post_content = $post->post_content;
            if (function_exists('qtrans_useCurrentLanguageIfNotFoundShowAvailable')) {
                $post_content = qtrans_useCurrentLanguageIfNotFoundShowAvailable($post_content);
            }
            preg_match_all($sc_pattern, $post_content, $matches);

            if (array_key_exists(2, $matches) && in_array($shortcode_name, $matches[2])) {
                foreach ($matches[0] as $sc) {
                    if (start_with($sc, '[' . $shortcode_name)) {
                        return $sc;
                    }
                }
            }
        }
        return false;
    }

    static function get_all_shortcodes_of_type($shortcode_name, $post = null)
    {
        $shortcodes = array();
        $post = isset($post) ? $post : $GLOBALS['post'];
        if (isset($post) && $post) {
            $sc_pattern = '/\[(\[?)(' . $shortcode_name . ')(?![\w-])([^\]\/]*(?:\/(?!\])[^\]\/]*)*?)(?:(\/)\]|\](?:([^\[]*+(?:\[(?!\/\2\])[^\[]*+)*+)\[\/\2\])?)(\]?)/s';
            $post_content = $post->post_content;
            if (function_exists('qtrans_useCurrentLanguageIfNotFoundShowAvailable')) {
                $post_content = qtrans_useCurrentLanguageIfNotFoundShowAvailable($post_content);
            }
            preg_match_all($sc_pattern, $post_content, $matches);

            if (array_key_exists(2, $matches) && in_array($shortcode_name, $matches[2])) {
                foreach ($matches[0] as $sc) {
                    if (inc_start_with($sc, '[' . $shortcode_name)) {
                        array_push($shortcodes, $sc);
                    }
                }
            }
        }
        return $shortcodes;
    }

    static function override_shortcode_attribute($sc, $attr_name, $attr_value)
    {
        $sc = str_replace($attr_name . ' =', $attr_name . '_old=', $sc);
        $sc = str_replace($attr_name . '=', $attr_name . '_old=', $sc);

        $a = explode(' ', $sc);
        $sc_begin = $a[0] . ' ';
        $sc = str_replace($sc_begin, $sc_begin . $attr_name . '="' . $attr_value . '" ', $sc);

        return $sc;
    }

    static function get_shortcode_attribute($shortcode, $attr_name)
    {
        $re = '/' . preg_quote($attr_name) . '=([\'"])?((?(1).+?|[^\s>]+))(?(1)\1)/is';
        if (preg_match($re, $shortcode, $match)) {
            return urldecode($match[2]);
        }
        return false;
    }

    static function get_associated_media($post_id = null)
    {
        $images = array();
        global $post;
        if (!isset($post_id) && isset($post)) {
            $post_id = get_the_ID();
        }
        if (isset($post_id)) {
            $post_format = get_post_format($post_id);
            if ($post_format == 'gallery') {
                $slider_config = inc_get_page_slider($post_id);

                if ($slider_config) {
                    if ($slider_config['type'] == SETTINGS_FLEX_SLIDER_TYPE) {
                        global $flex_slider_manager;
                        $slides = $flex_slider_manager->get_slides($slider_config['id']);
                        foreach ($slides as $slide) {
                            $images[] = $slide;
                        }
                    }
                }
            } elseif ($post_format == 'video') {
                $video_config = inc_get_page_video($post_id);
                if ($video_config) {
                    $video_meta = $video_config['video_meta'];
                    if ($video_meta) {
                        $images[] = array('type' => 'video', 'meta' => $video_meta);
                    }
                }
            } else {
                if (has_post_thumbnail($post_id)) {
                    $thumbnail_id = get_post_thumbnail_id($post_id);
                    $images[] = array('type' => 'img', 'id' => $thumbnail_id);
                } else {
                    $attachments = Post_Util::get_post_attachments_id($post_id);
                    foreach ($attachments as $id) {
                        $images[] = array('type' => 'img', 'id' => $id);
                    }
                }
            }
        }
        return $images;
    }
}