<?php


class Posts_Overview_Manager
{

    function __construct()
    {
        if (is_user_logged_in()) {
            add_action('media_buttons', array($this, 'add_configure_button_to_editor'), 20);

            add_action('wp_ajax_inc-display-posts-overview-editor', array($this, 'render_posts_overview_editor_form'));
            add_action('wp_ajax_inc-save-posts-overview-settings', array($this, 'save_posts_overview_settings'));
        }
    }

    function add_configure_button_to_editor()
    {
        global $post;
        if ($post) {
            $post_id = get_the_ID();
            $post_type = get_post_type();

            $edit_posts_overview_button_title = __('Configure', INCEPTIO_THEME_NAME);
            $edit_posts_overview_button_url = get_option('siteurl') . '/wp-admin/admin-ajax.php?action=inc-display-posts-overview-editor&post_id=' . $post_id . '&post_type=' . $post_type;
            echo '<a style="display: none;" id="posts-overview-editor-button" title="' . $edit_posts_overview_button_title . '" class="button settings-editor" href="' . $edit_posts_overview_button_url . '">';
            echo '<span class="wp-sc-buttons-icon"></span> ' . $edit_posts_overview_button_title;
            echo '</a>';
        }
    }

    function render_posts_overview_editor_form()
    {
        $post_id = $_REQUEST['post_id'];
        $settings = inc_get_posts_overview_settings($post_id);
        $columns = $settings['columns'];
        $terms = $settings['terms'];
        $display_filter_all = $settings['display_filter_all'];
        $thumb_click_action = array_key_exists('thumb_click_action', $settings) ? $settings['thumb_click_action'] : 'lightbox';
        $items_count = array_key_exists('items_count', $settings) ? $settings['items_count'] : '-1';
        $terms_order = array_key_exists('terms_order', $settings) ? $settings['terms_order'] : '';

        $trueFilterAllSelected = ($display_filter_all == 'true') ? ' selected' : '';
        $falseFilterAllSelected = ($display_filter_all == 'false') ? ' selected' : '';
        $cols2Selected = ($columns == '2') ? ' selected' : '';
        $cols3Selected = ($columns == '3') ? ' selected' : '';
        $cols4Selected = ($columns == '4') ? ' selected' : '';
        $lightboxSelected = ($thumb_click_action == 'lightbox') ? ' selected' : '';
        $linkSelected = ($thumb_click_action == 'link') ? ' selected' : '';
        $when_sidebar_displayed_text = __('when the sidebar is displayed', INCEPTIO_THEME_NAME);

        $content = '<form id="posts-overview-editor-form" class="generic-form" method="post" action="#">';
        $content .= '<fieldset>';
        $content .= '<div>';
        $content .= '<label for="posts-overview-editor-cols">' . __('No. of Columns', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="posts-overview-editor-cols" name="posts-overview-editor-cols">';
        $content .= '<option value="2"' . $cols2Selected . '>2 (1 '.$when_sidebar_displayed_text.')</option>';
        $content .= '<option value="3"' . $cols3Selected . '>3 (2 '.$when_sidebar_displayed_text.')</option>';
        $content .= '<option value="4"' . $cols4Selected . '>4 (3 '.$when_sidebar_displayed_text.')</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="posts-overview-editor-tca">' . __('Thumbnail Click Action', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="posts-overview-editor-tca" name="posts-overview-editor-tca">';
        $content .= '<option value="lightbox"' . $lightboxSelected . '>' . __('Open the Lightbox Gallery', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="link"' . $linkSelected . '>' . __('Open the Associated Post', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="posts-overview-editor-noi">' . __('No. of Items (-1 for all)', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="posts-overview-editor-noi" name="posts-overview-editor-noi" type="text" value="' . $items_count . '" class="required number">';
        $content .= '<span>&nbsp;('.__('When pagination is used, this field represents the number of items per page. Use -1 for the default value.', INCEPTIO_THEME_NAME).')</span>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="posts-overview-editor-terms">' . __('Categories (comma separated slugs)', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="posts-overview-editor-terms" name="posts-overview-editor-terms" type="text" value="' . $terms . '">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="posts-overview-editor-terms-order">' . __('Categories Order', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="posts-overview-editor-terms-order" name="posts-overview-editor-terms-order" type="text" value="' . $terms_order . '">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="posts-overview-editor-filter-all">' . __('All Filter Button', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="posts-overview-editor-filter-all" name="posts-overview-editor-filter-all">';
        $content .= '<option value="true"' . $trueFilterAllSelected . '>' . __('Display', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="false"' . $falseFilterAllSelected . '>' . __('Hide', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<input id="posts-overview-editor-form-submit" type="button" value="' . __('Save', INCEPTIO_THEME_NAME) . '" class="button-primary">';
        $content .= '<input id="posts-overview-editor-form-cancel" type="button" value="' . __('Cancel', INCEPTIO_THEME_NAME) . '" class="button-secondary">';
        $content .= '</div>';
        $content .= '</fieldset>';
        $content .= '</form>';
        //post_ID
        echo $content;
        die();
    }

    function save_posts_overview_settings()
    {
        $post_id = $_REQUEST['post-id'];
        $post_type = $_REQUEST['post-type'];
        $columns = $_REQUEST['columns'];
        $terms = array_key_exists('terms', $_REQUEST) ? $_REQUEST['terms'] : '';
        $terms_order = array_key_exists('terms-order', $_REQUEST) ? $_REQUEST['terms-order'] : '';
        $items = array_key_exists('items', $_REQUEST) ? $_REQUEST['items'] : '-1';
        $display_filter_all = $_REQUEST['display-filter-all'];
        $thumb_click_action = $_REQUEST['thumb-click-action'];
        $settings = array(
            'type' => 'posts-overview-settings',
            'config' => array(
                'columns' => $columns,
                'terms' => $terms,
                'terms_order' => $terms_order,
                'items_count' => $items,
                'thumb_click_action' => $thumb_click_action,
                'display_filter_all' => $display_filter_all));
        $settings_json = json_encode($settings);
        update_post_meta($post_id, SETTINGS_PAGE_MEDIA_SETTINGS, $settings_json);
        echo $settings_json;
        die();
    }
}