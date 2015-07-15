<?php

class Post_Page_Customizer extends Page_Customizer
{

    public function __construct()
    {
        parent::__construct();
    }

    function register_actions()
    {
    }

    function get_page_location()
    {
        return 'post';
    }

    function visit(&$setting)
    {
        $page = $this->get_page_location();
        if ($setting['id'] == 'page_seo_settings') {
            array_push($setting['location'], $page);
        } elseif ($setting['id'] == 'page_footer_featured') {
            array_push($setting['location'], $page);
        } elseif ($setting['id'] == 'page_sidebar_settings') {
            array_push($setting['location'], $this->get_page_location());
            $setting[$page . '_callback'] = array($this, 'render_sidebar_settings');
        }
    }

    protected function supports_no_sidebar(){
        return true;
    }


}
