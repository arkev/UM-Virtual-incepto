<?php

abstract class Abstract_Plugin
{
    public function __construct()
    {
        if (is_user_logged_in()) {
            global $pagenow;
            if (isset($_GET['activated']) && $pagenow == 'themes.php') {
                $this->activate();
            }
        }
        $this->register_actions();
    }

    abstract function register_actions();

    protected abstract function activate();

    abstract function render();

    abstract function get_title();

    abstract function get_slug();

    function register_plugins_left_menu()
    {
        $plugin_title = $this->get_title();
        $plugin_slug = $this->get_slug();
        add_theme_page($plugin_title, $plugin_title, 'manage_options', $plugin_slug,
            array($this, 'render'));
    }
}
