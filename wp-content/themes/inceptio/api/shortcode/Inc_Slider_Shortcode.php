<?php

class Inc_Slider_Shortcode extends Abstract_Inc_Shortcode implements Inc_Shortcode_Designer
{

    static $POST_ID_ATTR = "post_id";
    static $IDS_ATTR = "ids";
    static $SIZE_ATTR = "size";
    static $SRC_ATTR = "src";
    static $TITLE_ATTR = "title";
    static $ALIGN_ATTR = "align";
    static $ANIMATION_ATTR = "animation";
    static $SLIDESHOW_ATTR = "slideshow";
    static $CONTROL_NAV_ATTR = "control_nav";
    static $DIRECTION_NAV_ATTR = "direction_nav";
    static $SLIDESHOW_SPEED_ATTR = "slideshow_speed";
    static $ANIMATION_SPEED_ATTR = "animation_speed";

    var $items = array();

    private function reset()
    {
        unset($this->items);
        $this->items = array();
    }

    function render($attr, $inner_content = null, $code = "")
    {
        $content = '';
        switch ($code) {
            case "slider":
                do_shortcode($this->prepare_content($inner_content));
                $content .= $this->render_slider($attr);
                $this->reset();
                break;
            case "slider_item":
                $inner_content = do_shortcode($this->prepare_content($inner_content));
                $this->process_slider_item($attr, $inner_content);
                break;
        }
        return $content;
    }

    private function render_slider($attr)
    {
        extract(shortcode_atts(array(Inc_Slider_Shortcode::$IDS_ATTR => '',
            Inc_Slider_Shortcode::$POST_ID_ATTR => '',
            Inc_Slider_Shortcode::$SIZE_ATTR => 'full',
            Inc_Slider_Shortcode::$ALIGN_ATTR => '',
            Inc_Slider_Shortcode::$ANIMATION_ATTR => 'slide',
            Inc_Slider_Shortcode::$SLIDESHOW_ATTR => 'false',
            Inc_Slider_Shortcode::$CONTROL_NAV_ATTR => 'true',
            Inc_Slider_Shortcode::$DIRECTION_NAV_ATTR => 'true',
            Inc_Slider_Shortcode::$SLIDESHOW_SPEED_ATTR => '7000',
            Inc_Slider_Shortcode::$ANIMATION_SPEED_ATTR => '600'), $attr));

        if (empty($ids) && empty($post_id) && count($this->items) == 0) {
            $post_id = get_the_ID();
        }

        if (!empty($post_id)) {
            $post_id = intval($post_id);
            $attachments_id = Post_Util::get_post_attachments_id($post_id);
            if (!empty($attachments_id)) {
                $ids = $attachments_id;
            }
        }

        $slider_id = uniqid('slider-');
        $classes = array('entry-slider');
        if ($align == 'right') {
            array_push($classes, "alignright");
        } elseif ($align == 'left') {
            array_push($classes, "alignleft");
        }
        $core_attributes = $this->get_core_attributes($attr, array('class' => $classes));

        $content = "<div" . $core_attributes . ">";
        $content .= "<div id=\"$slider_id\" class=\"flex-container\">";
        $content .= "<div class=\"flexslider\">";
        $content .= "<ul class=\"slides\">";
        if (!empty($ids)) {
            $img_ids = is_array($ids) ? $ids : explode(',', $ids);
            for ($i = 0; $i < count($img_ids); $i++) {
                $img_id = $img_ids[$i];
                $post = Media_Util::get_original_post($img_id);
                if ($post) {
                    $title = get_the_title($post);
                    $img_src = Media_Util::get_image_src($img_id, $size);
                    $content .= "<li><img src=\"$img_src\" alt=\"$title\" title=\"$title\"></li>";
                }
            }
        }
        for ($i = 0; $i < count($this->items); $i++) {
            $item = $this->items[$i];
            $content .= $item->get_slide($size);
        }
        $content .= "</ul>";
        $content .= "</div>";
        $content .= "</div>";
        $content .= "</div>";
        $content .= "<script type=\"text/javascript\">
            if(!document['slidersSettings']){
                document['slidersSettings'] = [];
            }
            document['slidersSettings'].push({
                controlsContainer: '#" . $slider_id . "',
                animation: '" . $animation . "',
                slideshow: $slideshow,
                controlNav: $control_nav,
                directionNav: $direction_nav,
                slideshowSpeed: $slideshow_speed,
                animationSpeed: $animation_speed
            });
		</script>";
        return $content;
    }

    private function process_slider_item($attr, $inner_content)
    {
        array_push($this->items, new Inc_Slider_Item($attr, $inner_content));
    }

    function get_names()
    {
        return array('slider', 'slider_item');
    }

    function get_visual_editor_form()
    {
        $content = '<form id="sc-slider-form" class="generic-form" method="post" action="#">';
        $content .= '<fieldset>';
        $content .= '<div>';
        $content .= '<label for="sc-slider-size">' . __('Image Size', INCEPTIO_THEME_NAME) . '</label>';
        $content .= '<select id="sc-slider-size" name="sc-slider-size">';
        $content .= '<option value="full">' . __('Original Size', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="thumbnail">' . __('Thumbnail Size (150 x 150)', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="inc-small">' . __('Small Size (220 x 140)', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="medium">' . __('Medium Size (300 x 300)', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="large">' . __('Large Size (640 x 640)', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-slider-align">' . __('Align', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="sc-slider-align" name="sc-slider-align">';
        $content .= '<option value="" >' . __('None', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="left">' . __('Left', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="right">' . __('Right', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-slider-animation">' . __('Animation', INCEPTIO_THEME_NAME) . '</label>';
        $content .= '<select id="sc-slider-animation" name="sc-slider-animation">';
        $content .= '<option value="slide">' . __('Slide', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="fade">' . __('Fade', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-slider-animspeed">' . __('Animation Speed', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-slider-animspeed" name="sc-slider-animspeed" type="text" value="600">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<input id="sc-slider-slideshow" name="sc-slider-slideshow" type="checkbox">';
        $content .= '<label for="sc-slider-slideshow">' . __('Enable Slideshow', INCEPTIO_THEME_NAME) . '</label>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<input id="sc-slider-controlnav" name="sc-slider-controlnav" type="checkbox" checked>';
        $content .= '<label for="sc-slider-controlnav">' . __('Show Navigation Arrows', INCEPTIO_THEME_NAME) . '</label>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<input id="sc-slider-directionnav" name="sc-slider-directionnav" type="checkbox" checked>';
        $content .= '<label for="sc-slider-directionnav">' . __('Show Pagination', INCEPTIO_THEME_NAME) . '</label>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-slider-slideshowspeed">' . __('Slideshow Speed', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-slider-slideshowspeed" name="sc-slider-slideshowspeed" type="text" value="7000">';
        $content .= '</div>';


        $content .= '<div>';
        $content .= '<ul id="sc-slider-slides" class="slides sortable-slides"></ul>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<input id="sc-slider-form-submit" type="submit" name="submit" value="' . __('Insert Image Gallery', INCEPTIO_THEME_NAME) . '" class="button-primary">';
        $content .= '<input id="sc-slider-form-add" type="submit" name="submit" value="' . __('Add New Slide', INCEPTIO_THEME_NAME) . '" class="button-secondary">';
        $content .= '</div>';
        $content .= '</fieldset>';
        $content .= '</form>';

        $content .= '<div id="sc-slider-slide-dialog" title="' . __('Add New Slide', INCEPTIO_THEME_NAME) . '" style="display: none">';
        $content .= '<form id="sc-slider-slide-form" class="generic-form" method="post" action="#">';
        $content .= '<fieldset>';
        $content .= '<div class="image-tab-content">';
        $content .= '<div class="image-tab-content-left">';
        $content .= '<div>';
        $content .= '<label for="sc-slider-slide-type">' . __('Slide Type', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="sc-slider-slide-type" name="sc-slider-slide-type">';
        $content .= '<option value="image" >' . __('Image', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="video">' . __('Video', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-slider-slide-src">' . __('Image Source', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="sc-slider-slide-src" name="sc-slider-slide-src" class="required image-selector">';
        $content .= '<option value="">' . __('Select Image ...', INCEPTIO_THEME_NAME) . '</option>';
        $images = Media_Util::get_all_uploaded_images();
        foreach ($images as $img) {
            $images = wp_get_attachment_image_src($img->ID);
            $content .= '<option value="' . $img->post_title . '" data-src="' . $images[0] . '">' . $img->post_title . '</option>';
        }
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-slider-slide-title">' . __('Title', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-slider-slide-title" name="sc-slider-slide-title" type="text">';
        $content .= '</div>';
        $content .= '<div style="display: none">';
        $content .= '<label for="sc-slider-slide-video">' . __('Embedded Video', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<textarea id="sc-slider-slide-video" name="sc-slider-slide-video" class="required"></textarea>';
        $content .= '</div>';
        $content .= '<div >';
        $content .= '<input id="sc-slider-slide-form-submit" type="submit" name="submit" value="' . __('Add Slide', INCEPTIO_THEME_NAME) . '" class="button-primary">';
        $content .= '<input id="sc-slider-slide-form-cancel" type="submit" name="submit" value="' . __('Cancel', INCEPTIO_THEME_NAME) . '" class="button-secondary">';
        $content .= '</div>';
        $content .= '</div>';

        $content .= '<div class="image-tab-content-right">';
        $content .= '<img id="sc-slider-slide-src-preview" src="#" alt="">';
        $content .= '</div>';

        $content .= '</div>';
        $content .= '</fieldset>';
        $content .= '</form>';
        $content .= '</div>';

        return $content;
    }

    function get_group_title()
    {
        return __('Media', INCEPTIO_THEME_NAME);
    }

    function get_title()
    {
        return __('Media Slider', INCEPTIO_THEME_NAME);
    }
}

class Inc_Slider_Item
{
    private $attr;
    private $inner_content;

    function __construct($attr, $inner_content)
    {
        $this->attr = $attr;
        $this->inner_content = $inner_content;
    }

    function get_slide($size)
    {
        extract(shortcode_atts(array(
            Inc_Slider_Shortcode::$SRC_ATTR => '',
            Inc_Slider_Shortcode::$TITLE_ATTR => ''), $this->attr));
        if (!empty($this->inner_content)) {
            return "<li>" . $this->inner_content . "</li>";
        } else {
            $img_src = Media_Util::get_image_src($src, $size);
            return "<li><img src=\"$img_src\" alt=\"$title\" title=\"$title\"></li>";
        }
    }

}