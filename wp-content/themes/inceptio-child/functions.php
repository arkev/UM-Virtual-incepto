<?php

if (!function_exists('inc_after_enqueue_all_child')) {
    function inc_after_enqueue_all_child()
    {
        $child_template_uri = get_stylesheet_directory_uri();
        wp_enqueue_style('custom-style-child', $child_template_uri . '/custom.css', array('custom-style'), INCEPTIO_THEME_VERSION);
    }
}
add_action('inc_after_enqueue_all', 'inc_after_enqueue_all_child');

/* Your custom code must be added below this line */