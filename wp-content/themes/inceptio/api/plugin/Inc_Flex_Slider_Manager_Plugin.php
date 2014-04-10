<?php


class Inc_Flex_Slider_Manager_Plugin extends Inc_Abstract_Slider_Manager_Plugin
{

    private $messages;

    public function __construct()
    {
        parent::__construct();
        $this->messages = array(
            's1' => __('Slider updated', INCEPTIO_THEME_NAME));
    }

    function register_actions()
    {
        add_action('wp_ajax_inc-add-flex-slider-form', array($this, 'render_add_slider_form'));
        add_action('wp_ajax_inc-add-flex-slider', array($this, 'process_add_slider'));
        add_action('wp_ajax_inc-update-flex-slider', array($this, 'process_update_slider'));
        add_action('wp_ajax_inc-del-flex-slider', array($this, 'process_remove_slider'));
        add_action('wp_ajax_inc-duplicate-flex-slider', array($this, 'process_duplicate_slider'));
    }

    protected function activate()
    {
    }

    function render()
    {
        if (array_key_exists('action', $_REQUEST)) {
            if ($_REQUEST['action'] == 'edit') {
                $this->render_edit_slider_form();
            }
        } else {
            echo '<div class="wrap">';
            echo '<div class="icon32" id="icon-themes"></div>';
            echo '<h2>Inceptio - ' . __('Slider Manager', INCEPTIO_THEME_NAME) . '<a class="thickbox add-new-h2" href="admin-ajax.php?action=inc-add-flex-slider-form" title="' . __('Add New Slider', INCEPTIO_THEME_NAME) . '">' . __('Add New', INCEPTIO_THEME_NAME) . '</a></h2>';
            echo '<div class="plugin-content">';
            echo '<div id="slider-list">';
            echo $this->get_slider_list();
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    }

    function get_title()
    {
        return __('Flex Slider', INCEPTIO_THEME_NAME);
    }

    function get_slug()
    {
        return 'inc-flex-slider';
    }

    private function render_edit_slider_form()
    {
        $page_slug = $this->get_slug();
        $id = $_REQUEST['id'];
        $slider = $this->get_slider(SETTINGS_FLEX_SLIDER_TYPE, $id);
        $slider_name = $slider['name'];
        $slider_slides = $slider['config']['slides'];
        $slider_settings = $slider['config']['settings'];
        $image_not_available = Media_Util::get_external_image_src('/admin/images/image-not-available.png');
        $content = '<div class="wrap">';
        $content .= '<div class="icon32" id="icon-upload"></div>';
        $content .= '<h2>' . __('Edit Slider', INCEPTIO_THEME_NAME) . ' - ' . $slider_name . '<a class="add-new-h2 upload-slide-img" href="#" title="' . __('Add Image Slide', INCEPTIO_THEME_NAME) . '">' . __('Add Image Slide', INCEPTIO_THEME_NAME) . '</a></h2>';
        if (array_key_exists('message', $_REQUEST) && array_key_exists($_REQUEST['message'], $this->messages)) {
            $div_class = inc_start_with($_REQUEST['message'], 's') ? 'updated' : 'error';
            $content .= '<div class="' . $div_class . ' below-h2" id="message"><p>' . $this->messages[$_REQUEST['message']] . '</p></div>';
        }

        $content .= '<div class="plugin-content">';
        $content .= '<form id="slider-manager-form" action="admin-ajax.php" method="post">';
        $content .= '<input type="hidden" value="' . $id . '" name="id">';
        $content .= '<input id="slider-manager-slides-content" type="hidden" value="" name="slides">';
        $content .= '<input type="hidden" name="action" value="inc-update-flex-slider">';
        $content .= '<input id="_wpnonce" type="hidden" value="' . wp_create_nonce('update') . '" name="_wpnonce">';
        $content .= '<input type="hidden" value="' . admin_url() . 'themes.php?page=' . $page_slug . '&action=edit&id=' . $id . '" name="_wp_http_referer">';

        $content .= '<p>';
        $content .= '<label for="inc-slider-name" > Slider Name: </label>';
        $content .= '<input style="width: 25em" type="text" id="slider-manager-slider-name" value="' . $slider_name . '" name="slider-name" class="required">';
        $content .= '</p><br />';

        $content .= '<div id="slider-manager-container" class="slider-manager-container ui-droppable">';
        $content .= '[tabs]';
        $content .= '[tab title=\'' . __('Designer', INCEPTIO_THEME_NAME) . '\']';
        $content .= "<ul id=\"slider-manager-slides\" class=\"thumbs\">\n";
        if (count($slider_slides) > 0) {
            foreach ($slider_slides as $slide) {
                $slide_type = $slide['type'];
                $slide_id = $slide['id'];
                if ($slide_type == 'img') {
                    $slide_link = $slide['img_link'];
                    $slide_caption_title = $slide['caption_title'];
                    $slide_caption_content = $slide['caption_content'];
                    $image = Media_Util::get_image_src($slide_id, 'thumbnail');
                    if ($image) {
                        $title = '';
                        $img_src = $image;
                    } else {
                        $title = __('No Image Available', INCEPTIO_THEME_NAME);
                        $img_src = $image_not_available;
                    }
                    $content .= '<li data-type="' . $slide_type . '" data-id="' . $slide_id . '" data-caption-title="' . $slide_caption_title . '" data-caption-content="' . $slide_caption_content . '" data-img-link="' . $slide_link . '">';
                    $content .= '<div class="img-wrap">';
                    $content .= '<img src="' . $img_src . '" title="' . $title . '">';
                    $content .= '<span class="type-' . $slide_type . '"></span>';
                    $content .= '<a class="delete-slider-slide-button" href="#" title="' . __('Delete Slide', INCEPTIO_THEME_NAME) . '">' . __('Delete Slide', INCEPTIO_THEME_NAME) . '</a>';
                    $content .= '</div>';
                    $content .= '<a class="edit-meta-slider-slide-button" href="#" title="' . __('Edit Meta', INCEPTIO_THEME_NAME) . '">' . __('Edit Meta', INCEPTIO_THEME_NAME) . '</a>';
                    $content .= '</li>';
                }
            }
        }
        $content .= "</ul>";
        $content .= '[/tab]';
        $content .= '[tab title=\'' . __('Settings', INCEPTIO_THEME_NAME) . '\']';
        $content .= $this->get_slider_settings_form($slider_settings);
        $content .= '[/tab]';
        $content .= '[/tabs]';

        $content .= '</div>';
        $content .= '<p class="submit"><input id="slider-manager-form-save" type="submit" value="' . __('Save Changes', INCEPTIO_THEME_NAME) . '" class="button button-primary" id="submit" name="submit"></p>';
        $content .= '</form>';
        $content .= '</div>';
        $content .= '</div>';
        $content .= $this->get_edit_meta_dialog();
        echo do_shortcode($content);
    }

    private function get_slider_settings_form($slider_settings)
    {

        if (array_key_exists('animation', $slider_settings)) {
            $animation_fade = $slider_settings['animation'] == 'fade' ? ' selected' : '';
            $animation_slide = $slider_settings['animation'] == 'slide' ? ' selected' : '';
        } else {
            $animation_fade = '';
            $animation_slide = '';
        }

        if (array_key_exists('animationSpeed', $slider_settings)) {
            $animation_speed = $slider_settings['animationSpeed'];
        } else {
            $animation_speed = 600;
        }

        if (array_key_exists('slideshow', $slider_settings)) {
            $slide_show = $slider_settings['slideshow'] ? ' checked' : '';
        } else {
            $slide_show = ' checked';
        }

        if (array_key_exists('slideshowSpeed', $slider_settings)) {
            $slide_show_speed = $slider_settings['slideshowSpeed'];
        } else {
            $slide_show_speed = 7000;
        }

        if (array_key_exists('pauseOnHover', $slider_settings)) {
            $pause_on_hover = $slider_settings['pauseOnHover'] ? ' checked' : '';
        } else {
            $pause_on_hover = ' checked';
        }

        $content = '<fieldset>';
        $content .= '<div>';
        $content .= '<label for="slider-manager-slider-settings-animation">' . __('Animation', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="slider-manager-slider-settings-animation" name="settings-animation" class="required">';
        $content .= '<option value="fade"' . $animation_fade . '>' . __('Fade', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="slide"' . $animation_slide . '>' . __('Slide', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="slider-manager-slider-settings-animspeed">' . __('Animation speed', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="slider-manager-slider-settings-animspeed" name="settings-animation-speed" type="text" value="' . $animation_speed . '" class="required number">';
        $content .= '</div>';
//        $content .= '<div>';
//        $content .= '<label for="slider-manager-slider-settings-easing">' . __('Easing', INCEPTIO_THEME_NAME) . ':</label>';
//        $content .= '<select id="slider-manager-slider-settings-easing" name="settings-easing" class="required">';
//        $content .= '<option value="swing"' . $easing_swing . '>' . __('Swing', INCEPTIO_THEME_NAME) . '</option>';
//        $content .= '<option value="linear"' . $easing_linear . '>' . __('Linear', INCEPTIO_THEME_NAME) . '</option>';
//        $content .= '</select>';
//        $content .= '</div>';
//        $content .= '<div>';
//        $content .= '<input id="slider-manager-slider-settings-animloop" name="settings-animloop" type="checkbox"' . $animation_loop . '>';
//        $content .= '<label for="slider-manager-slider-settings-animloop">' . __('Animation loop', INCEPTIO_THEME_NAME) . '</label>';
//        $content .= '</div>';
        $content .= '<div>';
        $content .= '<input id="slider-manager-slider-settings-slideshow" name="settings-slideshow" type="checkbox"' . $slide_show . '>';
        $content .= '<label for="slider-manager-slider-settings-slideshow">' . __('Slideshow', INCEPTIO_THEME_NAME) . '</label>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<input id="slider-manager-slider-settings-slideshowspeed" name="settings-slideshow-speed" type="text" value="' . $slide_show_speed . '" class="required number">';
        $content .= '<label for="slider-manager-slider-settings-slideshowspeed">' . __('Slideshow speed', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '</div>';
//        $content .= '<div>';
//        $content .= '<input id="slider-manager-slider-settings-random" name="settings-random" type="checkbox"' . $randomize . '>';
//        $content .= '<label for="slider-manager-slider-settings-random">' . __('Randomize slide order', INCEPTIO_THEME_NAME) . '</label>';
//        $content .= '</div>';
        $content .= '<div>';
        $content .= '<input id="slider-manager-slider-settings-pausehover" name="settings-pause-hover" type="checkbox"' . $pause_on_hover . '>';
        $content .= '<label for="slider-manager-slider-settings-pausehover">' . __('Pause on hover', INCEPTIO_THEME_NAME) . '</label>';
        $content .= '</div>';
        $content .= '</fieldset>';
        return $content;
    }

    function render_add_slider_form()
    {
        $content = '<form id="fsm-add-slider-form" class="generic-form" method="post" action="admin-ajax.php">';
        $content .= '<fieldset>';
        $content .= '<div>';
        $content .= '<label for="fsm-slider-title">' . __('Slider Title', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input type="text" id="fsm-slider-title" name="title" class="required">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<input type="hidden" name="action" value="inc-add-flex-slider" >';
        $content .= '<input type="hidden" name="nonce" value="' . wp_create_nonce('inc-add-flex-slider') . '" />';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<input type="submit" id="fsm-add-slider-form-submit" value="' . __('Add Slider', INCEPTIO_THEME_NAME) . '" class="button-primary button-secondary">';
        $content .= '</div>';
        $content .= '</fieldset>';
        $content .= '</form>';
        echo $content;
        die();
    }

    function process_add_slider()
    {
        try {
            if (!isset($_POST['title']) || empty($_POST['title'])) {
                throw new Exception(__('The slider title must not be empty', INCEPTIO_THEME_NAME));
            }
            $slider_title = $_POST['title'];
            $slider = array(
                "settings" => array(
                    "animation" => "fade",
                    "pauseOnHover" => true,
                    "slideshow" => true,
                    "slideshowSpeed" => 7000,
                    "animationSpeed" => 600,
                ),
                "slides" => array());
            $this->save_slider(SETTINGS_FLEX_SLIDER_TYPE, $slider_title, $slider);
            echo $this->get_slider_list();
        } catch (Exception $e) {
            header($_SERVER['SERVER_PROTOCOL'] . " 500 Internal Server Error");
            echo $e->getMessage();
        }
        die();
    }

    function process_update_slider()
    {
        $slider_id = $_REQUEST['id'];
        $slides_as_json = $_REQUEST['slides'];
        $new_slider_name = $_REQUEST['slider-name'];
        $new_slider_id = sanitize_title($new_slider_name);

        $settings = array(
            'animation' => $_REQUEST['settings-animation'],
            'pauseOnHover' => (array_key_exists('settings-pause-hover', $_REQUEST) && $_REQUEST['settings-pause-hover'] == 'on') ? true : false,
            'slideshow' => (array_key_exists('settings-slideshow', $_REQUEST) && $_REQUEST['settings-slideshow'] == 'on') ? true : false,
            'slideshowSpeed' => intval($_REQUEST['settings-slideshow-speed']),
            'animationSpeed' => intval($_REQUEST['settings-animation-speed']),
        );
        $slides_as_json = str_replace('\"', '"', $slides_as_json);
        $slider_slides = json_decode($slides_as_json, true);

        $slider = $this->get_slider(SETTINGS_FLEX_SLIDER_TYPE, $slider_id);
        if ($slider) {
            $slider['id'] = $new_slider_id;
            $slider['name'] = $new_slider_name;
            $slider['config']['slides'] = $slider_slides;
            $slider['config']['settings'] = $settings;
        }

        $this->update_slider(SETTINGS_FLEX_SLIDER_TYPE, $slider_id, $slider);
        $http_referer = $_REQUEST['_wp_http_referer'] . '&message=s1';
        $http_referer = str_replace('id=' . $slider_id, 'id=' . $new_slider_id, $http_referer);
        header("Location: $http_referer");
        die();
    }

    function process_duplicate_slider()
    {
        try {
            if (!isset($_POST['id']) || empty($_POST['id'])) {
                throw new Exception(__('The slider ID must not be empty', INCEPTIO_THEME_NAME));
            }
            $id = $_POST['id'];
            $this->duplicate_slider(SETTINGS_FLEX_SLIDER_TYPE, $id);
            echo $this->get_slider_list();
        } catch (Exception $e) {
            header($_SERVER['SERVER_PROTOCOL'] . " 500 Internal Server Error");
            echo $e->getMessage();
        }
        die();
    }

    function process_remove_slider()
    {
        try {
            if (!isset($_POST['id']) || empty($_POST['id'])) {
                throw new Exception(__('The slider ID must not be empty', INCEPTIO_THEME_NAME));
            }
            $id = $_POST['id'];
            $this->delete_slider(SETTINGS_FLEX_SLIDER_TYPE, $id);
            echo $this->get_slider_list();
        } catch (Exception $e) {
            header($_SERVER['SERVER_PROTOCOL'] . " 500 Internal Server Error");
            echo $e->getMessage();
        }
        die();
    }

    private function get_slider_list()
    {
        $page_slug = $this->get_slug();
        $content = '<table cellspacing="0" class="wp-list-table widefat fixed media">';
        $content .= '<thead>';
        $content .= '<tr>';
        $content .= '<th style="" class="manage-column column-response" scope="col"><span>ID</span></a></th>';
        $content .= '<th style="" class="manage-column column-response" scope="col"><span>Name</span></a></th>';
        $content .= '</tr>';
        $content .= '</thead>';

        $content .= '<tfoot>';
        $content .= '<tr>';
        $content .= '<th style="" class="manage-column column-response" scope="col"><span>ID</span></a></th>';
        $content .= '<th style="" class="manage-column column-response" scope="col"><span>Name</span></a></th>';
        $content .= '</tr>';
        $content .= '</tfoot>';
        $content .= '<tbody id="the-list">';
        $sliders = $this->get_flex_sliders();
        foreach ($sliders as $i => $slider) {
            $delete_url = 'action=inc-del-flex-slider&amp;id=' . $slider['id'];
            $duplicate_url = 'action=inc-duplicate-flex-slider&amp;id=' . $slider['id'];
            $edit_url = 'themes.php?page=' . $page_slug . '&amp;action=edit&amp;id=' . $slider['id'];
            $alternate_class = ($i % 2 == 0) ? 'alternate' : '';
            $content .= "<tr valign=\"top\" class=\"$alternate_class author-self status-inherit\">";
            $content .= '<td class="title column-title"><strong>' . $slider['id'] . '</strong>';
            $content .= '<div class="row-actions"><span class="edit"><a title="Edit" href="' . $edit_url . '">Edit</a> | </span><span class="edit"><a class="fsm-delete-slider" href="' . $duplicate_url . '">Duplicate</a> | </span><span class="delete"><a class="fsm-delete-slider" href="' . $delete_url . '">Delete</a></span></div>';
            $content .= '</td>';
            $content .= '<td class="title column-title"><strong>' . $slider['name'] . '</strong></td>';
        }
        $content .= '</tbody>';
        $content .= '</table>';
        return $content;
    }

    private function get_edit_meta_dialog()
    {
        $content = '<div id="page-media-add-slide-meta-dialog" title="Edit Slide Meta" style="display: none">';
        $content .= '<form id="page-media-add-slide-meta-form" class="generic-form" method="post" action="#">';
        $content .= '<fieldset>';
        $content .= '<div>';
        $content .= '<label for="page-media-add-slide-id">' . __('Image ID', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="page-media-add-slide-id" name="page-media-add-slide-id" type="text">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="page-media-add-slide-meta-link">' . __('Image Link', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="page-media-add-slide-meta-link" name="page-media-add-slide-meta-link" type="text">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="page-media-add-slide-meta-title">' . __('Caption Title', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="page-media-add-slide-meta-title" name="page-media-add-slide-meta-title" type="text">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="page-media-add-slide-meta-content">' . __('Caption Content', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<textarea id="page-media-add-slide-meta-content" name="page-media-add-slide-meta-content"></textarea>';
        $content .= '</div>';
        $content .= '<div >';
        $content .= '<input id="page-media-add-slide-meta-form-submit" type="button" value="' . __('Save', INCEPTIO_THEME_NAME) . '" class="button-primary">';
        $content .= '<input id="page-media-add-slide-meta-form-cancel" type="button" value="' . __('Cancel', INCEPTIO_THEME_NAME) . '" class="button-secondary">';
        $content .= '</div>';
        $content .= '</fieldset>';
        $content .= '</form>';
        $content .= '</div>';
        return $content;
    }

    function render_slider($settings)
    {
        $settings = array_merge(array(
            'slider_id' => '',
            'img_size' => '',
            'container_class' => '',
            'link' => ''), $settings);
        $settings = apply_filters("inc_flex_slider_settings", $settings);
        $slider_id = $settings['slider_id'];
        $img_size = $settings['img_size'];
        $container_class = $settings['container_class'];
        $link = $settings['link'];

        $content = '';
        $slider = $this->get_slider(SETTINGS_FLEX_SLIDER_TYPE, $slider_id);
        if ($slider) {
            $slider_id = ($img_size == 'inc-home-slider') ? 'flexslider-home' : $slider_id;
            $slides = $slider['config']['slides'];
            $settings = $slider['config']['settings'];
            $container_class = empty($container_class) ? 'flex-container' : 'flex-container ' . $container_class;
            $content .= "<div id=\"$slider_id\" class=\"$container_class\">\n";
            $content .= "<div class=\"flexslider\">\n";
            if (count($slides) > 0) {
                $content .= "<ul class=\"slides\">\n";
                foreach ($slides as $slide) {
                    $slide_type = $slide['type'];
                    $slide_id = $slide['id'];
                    if ($slide_type == 'img') {
                        if (empty($link)) {
                            $slide_link = base64_decode($slide['img_link']);
                            if (!empty($slide_link) && is_numeric($slide_link)) {
                                $slide_link = get_permalink($slide_link);
                            }
                        } else {
                            if ($link == 'inherited') {
                                $slide_link = get_permalink();
                            } else {
                                $slide_link = $link;
                            }
                        }
                        $slide_caption_title = base64_decode($slide['caption_title']);
                        $slide_caption_content = base64_decode($slide['caption_content']);
                        $has_caption = !empty($slide_caption_title) || !empty($slide_caption_content);
                        $image = Media_Util::get_image_src($slide_id, $img_size);
                        if ($image) {
                            $img_alt_text = get_post_meta($slide_id , '_wp_attachment_image_alt', true);
                            $content .= "<li>\n";
                            if (empty($slide_link)) {
                                $content .= "<img src=\"$image\" alt=\"$img_alt_text\">\n";
                            } else {
                                $content .= "<a href=\"$slide_link\"><img src=\"$image\" alt=\"$img_alt_text\"></a>\n";
                            }

                            if ($has_caption) {
                                $content .= "<div class=\"flex-caption\">\n";
                                if (!empty($slide_caption_title)) {
                                    $slide_caption_title = __inc(do_shortcode($slide_caption_title));
                                    $content .= "<h1>$slide_caption_title</h1>\n";
                                }
                                if (!empty($slide_caption_content)) {
                                    $slide_caption_content = __inc(do_shortcode($slide_caption_content));
                                    $content .= "<div>$slide_caption_content</div>\n";
                                }
                                $content .= "</div>\n";
                            }
                            $content .= "</li>\n";
                        }
                    }
                }
                $content .= "</ul>\n";
            }
            $content .= "</div>\n";
            $content .= "</div>\n";

            if (count($slides) > 0) {
                $content .= "<script type=\"text/javascript\">
                if(!document['slidersSettings']){
                    document['slidersSettings'] = [];
                }
                document['slidersSettings'].push({
                    controlsContainer: '#" . $slider_id . "',
                    animation: '" . $settings['animation'] . "',
                    pauseOnHover: '" . $settings['pauseOnHover'] . "',
                    slideshow: '" . $settings['slideshow'] . "',
                    slideshowSpeed: '" . $settings['slideshowSpeed'] . "',
                    animationSpeed: '" . $settings['animationSpeed'] . "'
                });
            </script>\n";
            }

        }
        return $content;
    }

    function get_slides($slider_id)
    {
        $slides_array = array();
        $slider = $this->get_slider(SETTINGS_FLEX_SLIDER_TYPE, $slider_id);
        if ($slider) {
            $slides = $slider['config']['slides'];
            if (count($slides) > 0) {
                foreach ($slides as $slide) {
                    $slide_type = $slide['type'];
                    $slide_id = $slide['id'];
                    if ($slide_type == 'img') {
                        $slides_array[] = array('type' => 'img', 'id' => $slide_id);
                    }
                }
            }
        }
        return $slides_array;
    }

//    function register_plugins_left_menu()
//    {
//        $title = $this->get_title();
//        $slug = $this->get_slug();
////        add_theme_page( $title, $title, 'manage_options', $slug, array($this, 'render') );
//        add_menu_page($title, $title, 'manage_options', $slug, array($this, 'render'), plugins_url('myplugin/images/icon.png'), 110);
////        add_submenu_page($slug, 'All Sliders', 'All Sliders', 'manage_options', $slug, array($this, 'render'));
////        add_submenu_page($slug, "Add New", "Add New", 'manage_options', "flex-slider-add-new", array($this, 'render_add_slider_form'));
//    }

    private function get_flex_sliders()
    {
        $all_sliders = $this->get_sliders();
        $sliders = array();
        foreach ($all_sliders as $slider) {
            if ($slider['type'] == SETTINGS_FLEX_SLIDER_TYPE) {
                array_push($sliders, $slider);
            }
        }
        return $sliders;
    }

}