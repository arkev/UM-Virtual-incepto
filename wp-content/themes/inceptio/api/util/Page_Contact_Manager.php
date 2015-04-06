<?php


class Page_Contact_Manager
{

    function __construct()
    {
        if (is_user_logged_in()) {
            add_action('media_buttons', array($this, 'add_edit_slider_button_to_editor'), 20);

            add_action('wp_ajax_inc-display-contact-editor', array($this, 'render_page_contact_editor_form'));
            add_action('wp_ajax_inc-save-contact-settings', array($this, 'save_page_contact_settings'));
        }
    }

    function add_edit_slider_button_to_editor()
    {
        global $post;
        if ($post) {
            $post_id = get_the_ID();
            $post_type = get_post_type();

            $edit_contact_button_title = __('Edit Contact', INCEPTIO_THEME_NAME);
            $edit_contact_button_url = get_option('siteurl') . '/wp-admin/admin-ajax.php?action=inc-display-contact-editor&post_id=' . $post_id . '&post_type=' . $post_type;
            echo '<a style="display: none;" id="contact-editor-button" title="' . $edit_contact_button_title . '" class="button contact-editor" href="' . $edit_contact_button_url . '">';
            echo '<span class="wp-sc-buttons-icon"></span> ' . $edit_contact_button_title;
            echo '</a>';
        }
    }

    function render_page_contact_editor_form()
    {
        $post_id = $_REQUEST['post_id'];
        $address = inc_get_contact_details(OPTION_CONTACT_ADDRESS);
        $change_address_link = site_url() . '/wp-admin/themes.php?page=inc-theme-options&amp;tab=general-settings&amp;expand=contact-details';
        $page_contact_settings = inc_get_page_contact_settings($post_id);
        if ($page_contact_settings) {
            $display = $page_contact_settings['display'];
            $loc_type = $page_contact_settings['loc_type'];
            $latitude = $page_contact_settings['lat'];
            $longitude = $page_contact_settings['long'];
            $map_zoom = $page_contact_settings['map_zoom'];
            $map_height = $page_contact_settings['map_height'];
        } else {
            $display = true;
            $loc_type = 'address';
            $latitude = '';
            $longitude = '';
            $map_zoom = '17';
            $map_height = '400';
        }
        $display_checked = $display ? ' checked' : '';
        $address_selected = ($loc_type == 'address') ? ' selected' : '';
        $coordinates_selected = ($loc_type == 'coordinates') ? ' selected' : '';

        $map_settings_style = $display ? '' : ' style="display:none;"';
        $address_style = ($display && ($loc_type == 'address')) ? '' : ' style="display:none;"';
        $lat_long_style = ($display && ($loc_type == 'coordinates')) ? '' : ' style="display:none;"';

        $content = '<form id="page-contact-editor-form" class="generic-form" method="post" action="#">';
        $content .= '<fieldset>';

        $content .= '<div>';
        $content .= '<a id="page-contact-retrieval" href="#" data-content="'.esc_textarea(Page_Contact_Manager::get_default_contact_page_content()).'">Get Contact Page Content for Editing</a>';
        $content .= '</div>';

        $content .= '<div>';
        $content .= '<input id="page-contact-editor-display" name="page-contact-editor-display" type="checkbox"' . $display_checked . '>';
        $content .= '<label for="page-contact-editor-display">' . __('Display Google map', INCEPTIO_THEME_NAME) . '</label>';
        $content .= '</div>';

        $content .= '<div id="page-contact-editor-settings"' . $map_settings_style . '>';
        $content .= '<div>';
        $content .= '<label for="page-contact-editor-localization-type">' . __('Localization Type', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="page-contact-editor-localization-type" name="page-contact-editor-localization-type">';
        $content .= '<option value="address"' . $address_selected . '>' . __('By Address', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="coordinates"' . $coordinates_selected . '>' . __('By Coordinates', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';

        $content .= '<div' . $address_style . '>';
        $content .= '<label for="page-contact-editor-address">' . __('Address', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="page-contact-editor-address" name="page-contact-editor-address" type="text" value="' . $address . '">';
        $content .= '<a href="' . $change_address_link . '">' . __('Change Address', INCEPTIO_THEME_NAME) . '</a>';
        $content .= '</div>';
        $content .= '<div' . $lat_long_style . '>';
        $content .= '<label for="page-contact-editor-lat">' . __('Latitude', INCEPTIO_THEME_NAME) . '</label>';
        $content .= '<input id="page-contact-editor-lat" name="page-contact-editor-lat" type="text" class="required" value="' . $latitude . '">';
        $content .= '</div>';
        $content .= '<div' . $lat_long_style . '>';
        $content .= '<label for="page-contact-editor-long">' . __('Longitude', INCEPTIO_THEME_NAME) . '</label>';
        $content .= '<input id="page-contact-editor-long" name="page-contact-editor-long" type="text" class="required" value="' . $longitude . '">';
        $content .= '</div>';

        $content .= '<div>';
        $content .= '<label for="page-contact-editor-zoom">' . __('Map zoom', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="page-contact-editor-zoom" name="page-contact-editor-zoom" type="text" class="required number" value="' . $map_zoom . '">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="page-contact-editor-height">' . __('Map height (px)', INCEPTIO_THEME_NAME) . '</label>';
        $content .= '<input id="page-contact-editor-height" name="page-contact-editor-height" type="text" class="required number" value="' . $map_height . '">';
        $content .= '</div>';
        $content .= '</div>';

        $content .= '<input id="page-contact-editor-form-submit" type="button" value="' . __('Save', INCEPTIO_THEME_NAME) . '" class="button-primary">';
        $content .= '<input id="page-contact-editor-form-cancel" type="button" value="' . __('Cancel', INCEPTIO_THEME_NAME) . '" class="button-secondary">';
        $content .= '</div>';
        $content .= '</fieldset>';
        $content .= '</form>';

        echo $content;
        die();
    }

    function save_page_contact_settings()
    {
        $post_id = $_REQUEST['post-id'];

        $display = ($_REQUEST['display'] == 'true') ? true : false;
        $loc_type = $_REQUEST['loc-type'];
        $address = $_REQUEST['address'];
        $lat = $_REQUEST['lat'];
        $long = $_REQUEST['long'];
        $map_zoom = $_REQUEST['map-zoom'];
        $map_height = $_REQUEST['map-height'];
        $page_contact_settings = array(
            'type' => 'contact',
            'config' => array(
                'display' => $display,
                'loc_type' => $loc_type,
                'address' => $address,
                'lat' => $lat,
                'long' => $long,
                'map_zoom' => $map_zoom,
                'map_height' => $map_height));
        $page_contact_settings_json = json_encode($page_contact_settings);
        update_post_meta($post_id, SETTINGS_PAGE_MEDIA_SETTINGS, $page_contact_settings_json);
        echo $page_contact_settings_json;
        die();
    }

    static function get_map($post_id = null, $default_config = array())
    {
        $content = '';
        $page_contact_settings = inc_get_page_contact_settings($post_id);
        if ($page_contact_settings) {
            $display = $page_contact_settings['display'];
            $loc_type = $page_contact_settings['loc_type'];
            $address = base64_decode($page_contact_settings['address']);
            $lat = $page_contact_settings['lat'];
            $long = $page_contact_settings['long'];
            $map_zoom = $page_contact_settings['map_zoom'];
            $map_height = $page_contact_settings['map_height'];
        } else {
            $default_config = array_merge(array(
                'display' => true,
                'loc_type' => 'address',
                'address' => '40 Broadway, London',
                'lat' => '',
                'long' => '',
                'map_zoom' => '17',
                'map_height' => '400'), $default_config);
            $display = $default_config['display'];
            $loc_type = $default_config['loc_type'];
            $address = $default_config['address'];
            $lat = $default_config['lat'];
            $long = $default_config['long'];
            $map_zoom = $default_config['map_zoom'];
            $map_height = $default_config['map_height'];
        }
        if ($display) {
            if ($loc_type == 'address') {
                $data = 'data-address="' . $address . '"';
            } else {
                $data = 'data-lat="' . $lat . '" data-lng="' . $long . '"';
            }
            $content = '<section><div class="map" ' . $data . ' data-zoom="' . $map_zoom . '" style="width: 100%; height: ' . $map_height . 'px;"></div></section>';
        }
        return $content;
    }

    static function get_default_contact_page_content($evaluate = false)
    {
        $submit_label = __('Send Message', INCEPTIO_THEME_NAME);
        $success_msg = __('Your message has been successfully sent. We will get back to you as soon as possible.', INCEPTIO_THEME_NAME);
        $error_msg = __('Your message couldn\'t be sent because a server error occurred. Please try again.', INCEPTIO_THEME_NAME);
        $form_sc = '[form action="process_contact_form" display_legend="true" submit_label="' . $submit_label . '" success="' . $success_msg . '" error="' . $error_msg . '"]';
        $form_sc .= '[input label="' . __('Name:', INCEPTIO_THEME_NAME) . '" type="text" name="name" required="true"][/input]';
        $form_sc .= '[input label="' . __('Email:', INCEPTIO_THEME_NAME) . '" type="email" name="email" required="true"][/input]';
        $form_sc .= '[input label="' . __('Website:', INCEPTIO_THEME_NAME) . '" type="url" name="url" required="false"][/input]';
        $form_sc .= '[input label="' . __('Subject:', INCEPTIO_THEME_NAME) . '" type="text" name="subject" required="true"][/input]';
        $form_sc .= '[input label="' . __('Message:', INCEPTIO_THEME_NAME) . '" type="textarea" name="message" required="true"][/input]';
        $form_sc .= '[/form]';

        $content = '<h2>' . __('Contact Us', INCEPTIO_THEME_NAME) . '</h2>';
        $content .= '<p>' . __('We would be glad to have feedback from you. Drop us a line, whether it is a comment, a question, a work proposition or just a hello. You can use either the form below or the contact details on the right.', INCEPTIO_THEME_NAME) . '</p>';
        if ($evaluate) {
            $content .= do_shortcode($form_sc);
        } else {
            $content .= $form_sc;
        }
        return $content;
    }
}