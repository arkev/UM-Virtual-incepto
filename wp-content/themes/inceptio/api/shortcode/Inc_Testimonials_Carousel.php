<?php

class Inc_Testimonials_Carousel extends Abstract_Inc_Shortcode implements Inc_Shortcode_Designer
{
    static $POST_ID_ATTR = "post_id";
    static $COUNT_ATTR = "count";

    function render($attr, $inner_content = null, $code = "")
    {
        $default_attr = array(
            Inc_Testimonials_Carousel::$POST_ID_ATTR => '',
            Inc_Testimonials_Carousel::$COUNT_ATTR => '3',
            Inc_Carousel_Settings::$CS_AUTO_ATTR => '5',);
        extract(shortcode_atts($default_attr, $attr));

        $content = '';
        if (empty($post_id)) {
            if (isset($inner_content) && !empty($inner_content)) {
                $inner_content = str_replace("[bq", "<li>[bq", $inner_content);
                $inner_content = str_replace("[/bq]", "[/bq]</li>", $inner_content);
                $inner_content = do_shortcode($this->prepare_content($inner_content));
            }
        } else {
            $inner_content = '';
            $post = Post_Util::get_post_by_id($post_id);
            if ($post) {
                $count = empty($count) ? 9999 : intval($count);
                $shortcodes = Post_Util::get_all_shortcodes_of_type('bq', $post);
                if (count($shortcodes) > 0) {
                    $i = 0;
                    foreach ($shortcodes as $sc) {
                        if ($i < $count) {
                            $inner_content .= '<li>' . do_shortcode($sc) . '</li>';
                        }
                        $i++;
                    }
                }
            } else {
                return $this->get_error("No post find with the ID: " . $post_id);
            }
        }

        if (isset($inner_content) && !empty($inner_content)) {
            $id = uniqid('tc-');
            $content .= "<ul id=\"$id\" class=\"testimonial-carousel\">$inner_content</ul>";
            $carousel_setting = new Inc_Carousel_Settings('#' . $id, $attr, $default_attr);
            $content .= $carousel_setting->get_carousel_settings();
        }
        return $content;
    }

    function get_names()
    {
        return array('testimonials_carousel');
    }

    function get_visual_editor_form()
    {
        $content = '<form id="sc-testimonials-carousel-form" class="generic-form" method="post" action="#" data-sc="testimonials_carousel">';
        $content .= '<fieldset>';
        $content .= '<p>' . __('Insert the page ID which contains the testimonials', INCEPTIO_THEME_NAME) . '</p>';
        $content .= '<div>';
        $content .= '<label for="sc-testimonials-carousel-postid">' . __('Post ID', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-testimonials-carousel-postid" name="sc-testimonials-carousel-postid" type="text" data-attr-name="' . Inc_Testimonials_Carousel::$POST_ID_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-testimonials-carousel-count">' . __('No. of Testimonials', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-testimonials-carousel-count" name="sc-testimonials-carousel-count" type="text" value="3" data-attr-name="' . Inc_Testimonials_Carousel::$COUNT_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div >';
        $content .= '<input id="sc-testimonials-carousel-form-submit" type="submit" name="submit" value="' . __('Insert Testimonials Carousel', INCEPTIO_THEME_NAME) . '" class="button-primary">';
        $content .= '</div>';
        $content .= '</fieldset>';
        $content .= '</form>';

        return $content;
    }

    function get_group_title()
    {
        return __('Dynamic Elements', INCEPTIO_THEME_NAME);
    }

    function get_title()
    {
        return __('Testimonials Carousel', INCEPTIO_THEME_NAME);
    }

}
