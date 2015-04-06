<?php

class Inc_Shortcode_Manager
{
    private $shortcodes = array();

    function __construct()
    {
        if (is_user_logged_in()) {
            add_action('media_buttons', array($this, 'add_shortcode_button_to_editor'), 20);
            add_action('wp_ajax_display-sc-editor', array($this, 'render_shortcode_editor_form'));
        }
        add_filter('the_content', array($this, 'fix_empty_paragraph'));
    }

    function add_shortcode_button_to_editor()
    {
        $title = __('Add Shortcode', INCEPTIO_THEME_NAME);
        $url = get_option('siteurl') . '/wp-admin/admin-ajax.php?action=display-sc-editor';
        echo '<a id="shortcode-editor-button-id" title="' . $title . '" class="button shortcode-editor" href="' . $url . '">';
        echo '<span class="wp-sc-buttons-icon"></span> ' . $title;
        echo '</a>';
    }

    function fix_empty_paragraph($content)
    {
        $array = array(
            '<p>[' => '[',
            ']</p>' => ']',
            ']<br />' => ']'
        );
        $content = strtr($content, $array);
        return $content;
    }

    function add_shortcode($shortcode)
    {
        array_push($this->shortcodes, $shortcode);
    }

    function register_shortcodes()
    {
        foreach ($this->shortcodes as $shortcode) {
            if ($shortcode instanceof Abstract_Inc_Shortcode) {
                $shortcode->register_shortcode();
            }
        }
    }

    function render_shortcode_editor_form()
    {
        $shortcodes_groups = array();
        foreach ($this->shortcodes as $shortcode) {
            if ($shortcode instanceof Inc_Shortcode_Designer) {
                $group_name = $shortcode->get_group_title();
                if (!array_key_exists($group_name, $shortcodes_groups)) {
                    $shortcodes_groups[$group_name] = array();
                }
                array_push($shortcodes_groups[$group_name], $shortcode);
            }
        }

        $content = '[tabs]';
        foreach ($shortcodes_groups as $key => $value) {
            $content .= '[tab title=\'' . $key . '\']';
            $content .= '[toggles type="accordion"]';
            foreach ($value as $shortcode) {
                $title = $shortcode->get_title();
                $content .= '[toggle title="' . $title . '" state="closed"]';
                $content .= $shortcode->get_visual_editor_form();
                $content .= '[/toggle]';
            }
            $content .= '[/toggles]';
            $content .= '[/tab]';
        }
        $content .= '[/tabs]';

        echo do_shortcode($content);
        die();
    }
}
