<?php

class Basic_Page_Customizer extends Page_Customizer
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
        return 'page';
    }

    function visit(&$setting)
    {
        $page = $this->get_page_location();
        if ($setting['id'] == 'page_seo_settings') {
            array_push($setting['location'], $page);
//            $setting[$page . '_slider_type'] = 'flexSlider';
        } elseif ($setting['id'] == 'page_footer_featured') {
            array_push($setting['location'], $page);
        }elseif ($setting['id'] == 'page_content_featured') {
            array_push($setting['location'], $page);
        } elseif ($setting['id'] == 'page_sidebar_settings') {
            array_push($setting['location'], $this->get_page_location());
            $setting[$page . '_callback'] = array($this, 'render_sidebar_settings');
        }elseif ($setting['id'] == 'page_title_bar_settings') {
            array_push($setting['location'], $this->get_page_location());
            $setting[$page . '_callback'] = array($this, 'render_page_title_bar_settings');
        }
    }

}
