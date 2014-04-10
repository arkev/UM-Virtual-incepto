<?php

class Media_Util
{
    static function get_all_uploaded_images()
    {
        global $wpdb;
        return $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE post_type = 'attachment' and post_mime_type like '%image/%'");
    }

    static function get_original_post($id)
    {
        if (is_numeric($id)) {
            $post = get_post($id);
        } else {
            $post = get_page_by_title($id, OBJECT, 'attachment');
        }
        if (!$post) {
            $post = Media_Util::get_page_by_guid($id, OBJECT, 'attachment');
        }
        return $post;
    }

    private static function get_page_by_guid($page_title, $output = OBJECT, $post_type = 'page')
    {
        global $wpdb;
        $page = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid = %s AND post_type= %s", $page_title, $post_type));
        if ($page) {
            return get_post($page, $output);
        }

        return null;
    }

    static function get_external_image_src($src)
    {
        if (inc_start_with($src, '/')) {
            $template_uri = get_template_directory_uri();
            return $template_uri . $src;
        } else {
            return $src;
        }
    }

    static function get_image_src($src, $thumbnail_size = 'full')
    {
        if (is_a($src, 'WP_Post')) {
            $post = $src;
        } else {
            $post = Media_Util::get_original_post($src);
        }
        if ($post) {
            if ($thumbnail_size == 'full') {
                return Media_Util::get_post_guid($post);
            } else {
                $image = wp_get_attachment_image_src($post->ID, $thumbnail_size, false);
                if ($image) {
                    return $image[0];
                } else {
                    return Media_Util::get_post_guid($post);
                }
            }
        } else {
            return Media_Util::get_external_image_src($src);
        }
    }

    static function get_media_url($url)
    {
        if (inc_start_with($url, 'http://') || inc_start_with($url, 'https://')) {
            return $url;
        } else {
            $post = Media_Util::get_original_post($url);
            if ($post) {
                return Media_Util::get_post_guid($post);
            } elseif (inc_start_with($url, '/')) {
                return get_template_directory_uri() . '/' . $url;
            } else {
                return $url;
            }
        }
    }

    static function get_embedded_video_id($embedded_video)
    {
        $id = '';
        $pos = strrpos($embedded_video, "?");
        if ($pos) {
            $embedded_video = substr($embedded_video, 0, $pos);
        }
        $pos = strrpos($embedded_video, "/");
        if ($pos) {
            $id = substr($embedded_video, $pos + 1, strlen($embedded_video) - $pos);
        }
        $id = apply_filters('inc_embedded_video_id', $id, $embedded_video);
        return $id;
    }

    static function get_embedded_video_type($embedded_video)
    {
        $embedded_video = strtolower($embedded_video);
        $type = '';
        if (strpos($embedded_video, 'vimeo')) {
            $type = 'vimeo';
        }
        if (empty($type) && strpos($embedded_video, 'youtube')) {
            $type = 'youtube';
        }
        $type = apply_filters('inc_embedded_video_type', $type, $embedded_video);
        return $type;
    }

    static function get_embedded_video_metadata($video_id, $embedded_video)
    {
        $video_type = Media_Util::get_embedded_video_type($embedded_video);
//        $video_id = Media_Util::get_embedded_video_id($embedded_video);
        $video_metadata = '';
        if (!class_exists('WP_Http')) {
            include_once(ABSPATH . WPINC . '/class-http.php');
        }
        $request = new WP_Http;
        if ($video_type == 'youtube') {
            $video_metadata = $request->request('http://gdata.youtube.com/feeds/api/videos/' . $video_id . '?v=2&prettyprint=true&alt=json');
        } elseif ($video_type == 'vimeo') {
            $video_metadata = $request->request('http://vimeo.com/api/v2/video/' . $video_id . '.json');
        }
        $video_metadata = apply_filters('inc_embedded_video_metadata', $video_metadata, $embedded_video);

        if (is_array($video_metadata) && array_key_exists('response', $video_metadata)) {
            $response_code = $video_metadata['response']['code'];
            if ($response_code == '200') {
                $video_metadata = json_decode($video_metadata['body'], true);
                if ($video_type == 'youtube') {
                    $video_thumb = '';
                    $video_title = $video_metadata['entry']['title']['$t'];
                    $media_thumbnail = $video_metadata['entry']['media$group']['media$thumbnail'];
                    $thumb_w = 0;
                    $thumb_h = 0;
                    foreach ($media_thumbnail as $thumb) {
                        if ($thumb['width'] > $thumb_w && $thumb['height'] > $thumb_h) {
                            $video_thumb = $thumb['url'];
                            $thumb_w = $thumb['width'];
                            $thumb_h = $thumb['height'];
                        }
                    }
                    $attach_title = 'youtube_' . $video_id;
                    $attach_id = Media_Util::upload_image($video_thumb, $attach_title, $video_title);
                    return array('id' => $video_id,
                        'type' => $video_type,
                        'title' => $video_title,
                        'thumb' => $video_thumb,
                        'url' => 'http://www.youtube.com/watch?v=' . $video_id,
                        'attach_id' => $attach_id,
                        'attach_title' => $attach_id ? $attach_title : false);
                } elseif ($video_type == 'vimeo') {
                    $video_thumb = $video_metadata[0]['thumbnail_large'];
                    $video_link = $video_metadata[0]['url'];
                    $video_title = $video_metadata[0]['title'];
                    $attach_title = 'vimeo_' . $video_id;
                    $attach_id = Media_Util::upload_image($video_thumb, $attach_title, $video_title);
                    return array('id' => $video_id,
                        'type' => $video_type,
                        'title' => $video_title,
                        'thumb' => $video_thumb,
                        'url' => $video_link,
                        'attach_id' => $attach_id,
                        'attach_title' => $attach_id ? $attach_title : false);
                }

            }
        }
        return false;
    }

    static function upload_image($img_url, $img_title, $img_descr = '')
    {
        $post = Media_Util::get_original_post($img_title);
        if ($post) {
            return $post->ID;
        } else {
            $tmp = download_url($img_url);
            $post_id = 0;
            // Set variables for storage
            // fix file filename for query strings
            preg_match('/[^\?]+\.(jpg|JPG|jpe|JPE|jpeg|JPEG|gif|GIF|png|PNG)/', $img_url, $matches);
            $file_array['name'] = basename($matches[0]);
            $file_array['tmp_name'] = $tmp;

            // If error storing temporarily, unlink
            if (is_wp_error($tmp)) {
                @unlink($file_array['tmp_name']);
                $file_array['tmp_name'] = '';
            }

            // do the validation and storage stuff
            $id = media_handle_sideload($file_array, $post_id, $img_title, array('post_content' => $img_descr,));
            // If error storing permanently, unlink
            if (is_wp_error($id)) {
                @unlink($file_array['tmp_name']);
                return false;
            } else {
                return $id;
            }
        }
    }

    private static function get_post_guid($post)
    {
        $guid = $post->guid;
        if (is_ssl()) {
            $guid = str_replace('http://', 'https://', $guid);
        }
        return $guid;
    }
}
