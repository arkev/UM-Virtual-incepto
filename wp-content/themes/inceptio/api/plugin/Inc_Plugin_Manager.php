<?php


class Inc_Plugin_Manager {

    var $plugins = array();

    function register_plugin($plugin)
    {
        array_push($this->plugins, $plugin);
    }

    function load_plugins()
    {
        add_action('admin_menu', array($this, 'register_plugins_left_menu'));
    }

    function register_plugins_left_menu()
    {
        foreach ($this->plugins as $plugin) {
            $plugin->register_plugins_left_menu();
        }
    }

    function custom_menu_page(){
        echo "Admin Page Test";
    }
}