<?php

class Portfolio_Page_Customizer extends Page_Customizer
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
        return 'portfolio';
    }

    function visit(&$setting)
    {
        $page = $this->get_page_location();
        if ($setting['id'] == 'page_seo_settings') {
            array_push($setting['location'], $page);
        } elseif ($setting['id'] == 'page_footer_featured') {
            array_push($setting['location'], $page);
        } elseif ($setting['id'] == 'portfolio_project_details') {
            array_push($setting['location'], $page);
        } elseif ($setting['id'] == 'portfolio_page_attributes') {
            array_push($setting['location'], $this->get_page_location());
            $setting[$page . '_callback'] = array($this, 'render_portfolio_page_attributes');
        }
    }

    function render_portfolio_page_attributes()
    {
        $templates = array(
            "default" => __('Right Sidebar - Style 1', INCEPTIO_THEME_NAME),
            "rsidebar2" => __('Right Sidebar - Style 2', INCEPTIO_THEME_NAME),
            "fullwidth" => __('Full Width', INCEPTIO_THEME_NAME),
            "nosidebar" => __('No Sidebar', INCEPTIO_THEME_NAME)
        );
        $templates = apply_filters("inc_portfolio_templates", $templates);

        $selected_template = inc_get_portfolio_template();
        $content = '<p><strong>' . __('Template', INCEPTIO_THEME_NAME) . '</strong></p>';
        $content .= '<label for="inc-template-name-id" class="screen-reader-text">' . __('Template', INCEPTIO_THEME_NAME) . '</label>';
        $content .= '<select id="inc-template-name-id" name="' . SETTINGS_PORTFOLIO_TEMPLATE . '">';
        foreach ($templates as $value => $label) {
            $selected = ($selected_template == $value) ? 'selected' : '';
            $content .= "<option $selected value=\"$value\" class=\"level-0\">$label</option>";
        }
        $content .= '</select>';
        echo $content;
    }

}
