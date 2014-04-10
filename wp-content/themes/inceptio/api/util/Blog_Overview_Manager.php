<?php

class Blog_Overview_Manager
{
    function __construct()
    {
        if (is_user_logged_in()) {
            add_action('media_buttons', array($this, 'add_configure_button_to_editor'), 20);

            add_action('wp_ajax_inc-display-blog-overview-editor', array($this, 'render_editor_form'));
            add_action('wp_ajax_inc-save-blog-overview-settings', array($this, 'save_settings'));
        }
    }

    function add_configure_button_to_editor()
    {
        global $post;
        if ($post) {
            $post_id = get_the_ID();
            $post_type = get_post_type();

            $edit_blog_overview_button_title = __('Configure', INCEPTIO_THEME_NAME);
            $edit_blog_overview_button_url = get_option('siteurl') . '/wp-admin/admin-ajax.php?action=inc-display-blog-overview-editor&post_id=' . $post_id . '&post_type=' . $post_type;
            echo '<a style="display: none;" id="blog-overview-editor-button" title="' . $edit_blog_overview_button_title . '" class="button settings-editor" href="' . $edit_blog_overview_button_url . '">';
            echo '<span class="wp-sc-buttons-icon"></span> ' . $edit_blog_overview_button_title;
            echo '</a>';
        }
    }

    function render_editor_form()
    {
        $post_id = $_REQUEST['post_id'];
        $settings = inc_get_blog_overview_settings($post_id);
        $terms_type = array_key_exists('terms_type', $settings) ? $settings['terms_type'] : 'category';
        $terms = array_key_exists('terms', $settings) ? $settings['terms'] : '';
        $terms_order_by = array_key_exists('terms_order_by', $settings) ? $settings['terms_order_by'] : 'DESC';
        $terms_order = array_key_exists('terms_order', $settings) ? $settings['terms_order'] : 'date';

        $term_type_values = array(
            'category' => __('Categories', INCEPTIO_THEME_NAME),
            'tag' => __('Tags', INCEPTIO_THEME_NAME)
        );
        $order_values = array(
            'DESC' => __('Descending', INCEPTIO_THEME_NAME),
            'ASC' => __('Ascending', INCEPTIO_THEME_NAME)
        );
        $order_by_values = array(
            'date' => __('Terms Order', INCEPTIO_THEME_NAME),
            'ID' => __('Post ID', INCEPTIO_THEME_NAME),
            'author' => __('Author', INCEPTIO_THEME_NAME),
            'title' => __('Title', INCEPTIO_THEME_NAME),
            'name' => __('Post Name', INCEPTIO_THEME_NAME),
            'modified' => __('Last Modified Date', INCEPTIO_THEME_NAME),
            'parent' => __('Page Parent ID', INCEPTIO_THEME_NAME),
            'rand' => __('Random Order', INCEPTIO_THEME_NAME),
            'comment_count' => __('Number of Comments', INCEPTIO_THEME_NAME),
            'none' => __('None', INCEPTIO_THEME_NAME)
        );

        $content = '<form id="blog-overview-editor-form" class="generic-form" method="post" action="#">';
        $content .= '<fieldset>';
        $content .= '<div>';
        $content .= '<label for="blog-overview-editor-terms-type">' . __('Terms Type', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="blog-overview-editor-terms-type" name="blog-overview-editor-terms-type">';
        foreach ($term_type_values as $value => $label) {
            $selected = ($terms_type == $value) ? ' selected' : '';
            $content .= '<option value="' . $value . '"' . $selected . '>' . $label . '</option>';
        }
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="blog-overview-editor-terms">' . __('Terms ID (comma separated values like: 5,8,14)', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="blog-overview-editor-terms" name="blog-overview-editor-terms" type="text" value="' . $terms . '">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="blog-overview-editor-terms-order-by">' . __('Order By', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="blog-overview-editor-terms-order-by" name="blog-overview-editor-terms-order-by">';
        foreach ($order_by_values as $value => $label) {
            $selected = ($terms_order_by == $value) ? ' selected' : '';
            $content .= '<option value="' . $value . '"' . $selected . '>' . $label . '</option>';
        }
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="blog-overview-editor-terms-order">' . __('Order Type', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="blog-overview-editor-terms-order" name="blog-overview-editor-terms-order">';
        foreach ($order_values as $value => $label) {
            $selected = ($terms_order == $value) ? ' selected' : '';
            $content .= '<option value="' . $value . '"' . $selected . '>' . $label . '</option>';
        }
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<input id="blog-overview-editor-form-submit" type="button" value="' . __('Save', INCEPTIO_THEME_NAME) . '" class="button-primary">';
        $content .= '<input id="blog-overview-editor-form-cancel" type="button" value="' . __('Cancel', INCEPTIO_THEME_NAME) . '" class="button-secondary">';
        $content .= '</div>';
        $content .= '</fieldset>';
        $content .= '</form>';

        echo $content;
        die();
    }

    function save_settings()
    {
        $post_id = $_REQUEST['post-id'];
        $terms_type = $_REQUEST['terms-type'];
        $terms = $_REQUEST['terms'];
        $terms_order_by = $_REQUEST['terms-order-by'];
        $terms_order = $_REQUEST['terms-order'];

        $settings = array(
            'type' => 'blog-overview-settings',
            'config' => array(
                'terms_type' => $terms_type,
                'terms' => $terms,
                'terms_order_by' => $terms_order_by,
                'terms_order' => $terms_order));
        $settings_json = json_encode($settings);
        update_post_meta($post_id, SETTINGS_PAGE_MEDIA_SETTINGS, $settings_json);
        echo $settings_json;
        die();
    }
}
