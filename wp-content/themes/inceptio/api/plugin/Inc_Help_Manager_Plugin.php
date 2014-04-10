<?php

class Inc_Help_Manager_Plugin extends Abstract_Plugin
{

    public function __construct()
    {
        parent::__construct();
    }

    function register_actions()
    {

    }

    protected function activate()
    {
    }

    function render()
    {
        echo '<iframe src="http://www.ixtendo.com/doc/inceptio-wp/' . INCEPTIO_THEME_VERSION . '/" style="position: absolute; width: 100%; height: 100%"></iframe>';
    }

    function get_title()
    {
        return __('Documentation', INCEPTIO_THEME_NAME);
    }

    function get_slug()
    {
        return 'inc-documentation';
    }

}