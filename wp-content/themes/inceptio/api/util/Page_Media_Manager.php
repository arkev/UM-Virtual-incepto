<?php


class Page_Media_Manager
{

    function __construct()
    {
        if (is_user_logged_in()) {
            add_action('media_buttons', array($this, 'add_edit_slider_button_to_editor'), 20);

            add_action('wp_ajax_inc-display-slider-editor', array($this, 'render_page_slider_editor_form'));
            add_action('wp_ajax_inc-save-slider-settings', array($this, 'save_page_slider_settings'));

            add_action('wp_ajax_inc-display-video-editor', array($this, 'render_page_video_editor_form'));
            add_action('wp_ajax_inc-save-video-settings', array($this, 'save_page_video_settings'));
        }
    }

    function add_edit_slider_button_to_editor()
    {
        global $post;
        if ($post) {
            $post_id = get_the_ID();
            $post_type = get_post_type();

            $edit_slider_button_title = __('Edit Slider', INCEPTIO_THEME_NAME);
            $edit_slider_button_url = get_option('siteurl') . '/wp-admin/admin-ajax.php?action=inc-display-slider-editor&post_id=' . $post_id . '&post_type=' . $post_type;
            echo '<a style="display: none;" id="slider-editor-button" title="' . $edit_slider_button_title . '" class="button slider-editor" href="' . $edit_slider_button_url . '">';
            echo '<span class="wp-sc-buttons-icon"></span> ' . $edit_slider_button_title;
            echo '</a>';

            $edit_video_button_title = __('Edit Video', INCEPTIO_THEME_NAME);
            $edit_video_button_url = get_option('siteurl') . '/wp-admin/admin-ajax.php?action=inc-display-video-editor&post_id=' . $post_id . '&post_type=' . $post_type;
            echo '<a style="display: none;" id="video-editor-button" title="' . $edit_video_button_title . '" class="button video-editor" href="' . $edit_video_button_url . '">';
            echo '<span class="wp-sc-buttons-icon"></span> ' . $edit_video_button_title;
            echo '</a>';
        }
    }

    function render_page_slider_editor_form()
    {
        $post_id = $_REQUEST['post_id'];
        $page_slider = inc_get_page_slider($post_id);
        $post_type = get_post_type($post_id);
        $slider_type = 'none';
        $slider_id = '';
        $slider_layout = ($post_type == 'page') ? 'boxed' : 'wide';
        $slider_display_on = 'all';
        if ($page_slider) {
            $slider_type = $page_slider['type'];
            $slider_id = $page_slider['id'];
            if (array_key_exists('layout', $page_slider)) {
                $slider_layout = $page_slider['layout'];
            }
            if (array_key_exists('display_on', $page_slider)) {
                $slider_display_on = $page_slider['display_on'];
            }
        }
        $noneSliderTypeSelected = ($slider_type == 'none') ? ' selected' : '';
        $flexSliderTypeSelected = ($slider_type == SETTINGS_FLEX_SLIDER_TYPE) ? ' selected' : '';
        $revSliderTypeSelected = ($slider_type == SETTINGS_REV_SLIDER_TYPE) ? ' selected' : '';
        $sliderIdWrapperStyle = ($slider_type == 'none') ? ' style="display:none;"' : '';
        $wideSliderLayoutSelected = ($slider_layout == 'wide') ? ' selected' : '';
        $boxedSliderLayoutSelected = ($slider_layout == 'boxed') ? ' selected' : '';

        $slider_display_on_all_selected = ($slider_display_on == 'all') ? ' selected' : '';
        $slider_display_on_computer_selected = ($slider_display_on == 'computer') ? ' selected' : '';
        $slider_display_on_tablet_computer_selected = ($slider_display_on == 'tablet,computer') ? ' selected' : '';

        $content = '<form id="page-slider-editor-form" class="generic-form" method="post" action="#">';
        $content .= '<fieldset>';
        $content .= '<div>';
        $content .= '<label for="page-slider-editor-slider-type">' . __('Slider Type', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="page-slider-editor-slider-type" name="page-slider-editor-slider-type">';
        $content .= '<option value="none"' . $noneSliderTypeSelected . '>None</option>';
        $content .= '<option value="' . SETTINGS_FLEX_SLIDER_TYPE . '"' . $flexSliderTypeSelected . '>Flex Slider</option>';
        if ($post_type && $post_type == 'page') {
            $content .= '<option value="' . SETTINGS_REV_SLIDER_TYPE . '"' . $revSliderTypeSelected . '>Revolution Slider</option>';
        }
        $content .= '</select>';
        $content .= '</div>';
        if ($post_type && $post_type == 'page') {
            $content .= '<div' . $sliderIdWrapperStyle . '>';
            $content .= '<label for="page-slider-editor-slider-layout">' . __('Slider Layout', INCEPTIO_THEME_NAME) . ':</label>';
            $content .= '<select id="page-slider-editor-slider-layout" name="page-slider-editor-slider-layout">';
            $content .= '<option value="wide"' . $wideSliderLayoutSelected . '>' . __('Wide', INCEPTIO_THEME_NAME) . '</option>';
            $content .= '<option value="boxed"' . $boxedSliderLayoutSelected . '>' . __('Boxed', INCEPTIO_THEME_NAME) . '</option>';
            $content .= '</select>';
            $content .= '</div>';
        }
        $content .= '<div' . $sliderIdWrapperStyle . '>';
        $content .= '<label for="page-slider-editor-slider-id">' . __('Slider ID', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="page-slider-editor-slider-id" name="page-slider-editor-slider-id" type="text" value="' . $slider_id . '" class="small required">';
        $content .= '</div>';

        $content .= '<div' . $sliderIdWrapperStyle . '>';
        $content .= '<label for="page-slider-editor-slider-display">' . __('Display the Slider', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="page-slider-editor-slider-display" name="page-slider-editor-slider-display">';
        $content .= '<option value="all"' . $slider_display_on_all_selected . '>' . __('On all devices', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="computer"' . $slider_display_on_computer_selected . '>' . __('Only on computers', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="tablet,computer"' . $slider_display_on_tablet_computer_selected . '>' . __('Only on computers and tablets', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';

        $content .= '<input id="page-slider-editor-form-submit" type="button" value="' . __('Save', INCEPTIO_THEME_NAME) . '" class="button-primary">';
        $content .= '<input id="page-slider-editor-form-cancel" type="button" value="' . __('Cancel', INCEPTIO_THEME_NAME) . '" class="button-secondary">';
        $content .= '</div>';
        $content .= '</fieldset>';
        $content .= '</form>';
        //post_ID
        echo $content;
        die();
    }

    function save_page_slider_settings()
    {
        $post_id = $_REQUEST['post-id'];
        $post_type = $_REQUEST['post-type'];
        $slider_type = $_REQUEST['slider-type'];
        $slider_id = $_REQUEST['slider-id'];
        if (array_key_exists('slider-layout', $_REQUEST)) {
            $slider_layout = $_REQUEST['slider-layout'];
        } else {
            $slider_layout = ($post_type == 'page') ? 'boxed' : 'wide';
        }
        if (array_key_exists('slider-display-on', $_REQUEST)) {
            $slider_display_on = $_REQUEST['slider-display-on'];
        } else {
            $slider_display_on = 'all';
        }
        $page_slider_settings = array(
            'type' => 'slider',
            'config' => array(
                'type' => $slider_type,
                'display_on' => $slider_display_on,
                'layout' => $slider_layout,
                'id' => $slider_id));
        $page_slider_settings_json = json_encode($page_slider_settings);
        update_post_meta($post_id, SETTINGS_PAGE_MEDIA_SETTINGS, $page_slider_settings_json);
        echo $page_slider_settings_json;
        die();
    }

    function render_page_video_editor_form()
    {
        $post_id = $_REQUEST['post_id'];
        $page_video = inc_get_page_video($post_id);
        $video_content = '';
        $video_id = '';
        $video_thumb = '';
        if ($page_video) {
            $video_id = $page_video['video_id'];
            $video_content = base64_decode($page_video['video_content']);
            $video_meta = $page_video['video_meta'];
            if ($video_meta) {
                $video_thumb = $video_meta['thumb'];
            }
        }

        $content = '<form id="page-video-editor-form" class="generic-form" method="post" action="#">';
        $content .= '<fieldset>';
        $content .= '<div>';
        $content .= '<label for="page-video-editor-video-id">' . __('Video ID', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="page-video-editor-video-id" name="page-video-editor-video-id" type="text" value="' . $video_id . '" class="required">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="page-video-editor-video-content">' . __('Video Content', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<textarea id="page-video-editor-video-content" name="page-video-editor-video-content" rows="5" cols="10" class="required">' . $video_content . '</textarea>';
        $content .= '</div>';
        if (!empty($video_thumb)) {
            $content .= '<div>';
            $content .= '<label for="page-video-editor-video-thumb">' . __('Video Thumbnail', INCEPTIO_THEME_NAME) . ':</label>';
            $content .= '<a id="page-video-editor-video-thumb" href="' . $video_thumb . '" target="_blank">' . $video_thumb . '</textarea>';
            $content .= '</div>';
        }
        $content .= '<input id="page-video-editor-form-submit" type="button" value="' . __('Save', INCEPTIO_THEME_NAME) . '" class="button-primary">';
        $content .= '<input id="page-video-editor-form-cancel" type="button" value="' . __('Cancel', INCEPTIO_THEME_NAME) . '" class="button-secondary">';
        $content .= '</div>';
        $content .= '</fieldset>';
        $content .= '</form>';
        echo $content;
        die();
    }

    function save_page_video_settings()
    {
        $post_id = $_REQUEST['post-id'];
        $post_type = $_REQUEST['post-type'];
        $video_id = trim($_REQUEST['video-id']);
        $video_content = $_REQUEST['video-content'];

        $video_meta = Media_Util::get_embedded_video_metadata($video_id, base64_decode($video_content));
        $page_slider_settings = array(
            'type' => 'video',
            'config' => array(
                'video_id' => $video_id,
                'video_content' => $video_content,
                'video_meta' => $video_meta));
        $page_slider_settings_json = json_encode($page_slider_settings);
        update_post_meta($post_id, SETTINGS_PAGE_MEDIA_SETTINGS, $page_slider_settings_json);
        echo $page_slider_settings_json;
        die();
    }

    static function render_page_slider($page_slider_config = null)
    {
        $post_type = get_post_type();
        if (!isset($page_slider_config) || !is_array($page_slider_config)) {
            $page_slider_config = inc_get_page_slider();
        }
        global $flex_slider_manager;
        if (array_key_exists('display_on', $page_slider_config)) {
            $slider_display_on = $page_slider_config['display_on'];
        } else {
            $slider_display_on = 'all';
        }
        $content = '';
        if(inc_is_device_type_of($slider_display_on)){
            if ($page_slider_config['type'] == SETTINGS_FLEX_SLIDER_TYPE) {
                if (array_key_exists('layout', $page_slider_config)) {
                    $slider_layout = $page_slider_config['layout'];
                } else {
                    $slider_layout = ($post_type == 'page') ? 'boxed' : 'wide';
                }
                $container_class = ($slider_layout == 'boxed') ? 'container' : '';
                $content = $flex_slider_manager->render_slider(array(
                    'slider_id' => $page_slider_config['id'],
                    'container_class' => $container_class));
            } elseif ($page_slider_config['type'] == SETTINGS_REV_SLIDER_TYPE) {
                $content = do_shortcode('[rev_slider ' . $page_slider_config['id'] . ']');
                $slider_layout = array_key_exists('layout', $page_slider_config) ? $page_slider_config['layout'] : 'wide';
                if ($slider_layout == 'boxed') {
                    $content = '<div class="container">' . $content . '</div>';
                }
            }
        }
        $content = apply_filters('inc_render_page_slider', $content, $page_slider_config);
        return $content;
    }

    static function render_page_video($page_video_config = null)
    {
        if (!isset($page_video_config) || !is_array($page_video_config)) {
            $page_video_config = inc_get_page_video();
        }
        $content = base64_decode($page_video_config['video_content']);
        $content = apply_filters('inc_render_page_video', $content, $page_video_config);
        return $content;
    }

    static function render_page_image($img_id)
    {
        $settings = array(
            'img_id' => $img_id,
            'img_size' => '',
            'lightbox' => 'true',
            'img_link' => '',
            'url_target' => '');
        $settings = apply_filters("inc_page_image_settings", $settings);
        $img_id = $settings['img_id'];
        $img_size = $settings['img_size'];
        $lightbox = $settings['lightbox'];
        $img_link = $settings['img_link'];
        $url_target = $settings['url_target'];

        $content = do_shortcode('[img src="' . $img_id . '" lightbox="' . $lightbox . '" size="' . $img_size . '" href="' . $img_link . '" target="' . $url_target . '"][/img]');
        $content = apply_filters('inc_render_page_image', $content, $img_id, $img_size);
        return $content;
    }

}