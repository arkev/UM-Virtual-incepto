<?php

abstract class Page_Customizer
{
    public function __construct()
    {
        $this->register_actions();
    }

    abstract function register_actions();

    abstract function get_page_location();

    abstract function visit(&$setting);

    function render_sidebar_settings()
    {
        $all_sidebars = inc_get_all_sidebars();
        if($this->supports_no_sidebar()){
            array_push($all_sidebars, array('id' => sanitize_title(INCEPTIO_SIDEBAR_NONE), 'name' => INCEPTIO_SIDEBAR_NONE, 'description' => ''));
        }
        $page_sidebar = inc_get_page_sidebar();
        $content = '<p><strong>' . __('Sidebar', INCEPTIO_THEME_NAME) . '</strong></p>';
        $content .= '<select id="inc-sidebar-name-id" name="' . SETTINGS_PAGE_SIDEBAR_NAME . '">';
        $content .= '<option value="">' . __('Default Sidebar', INCEPTIO_THEME_NAME) . '</option>';
        foreach ($all_sidebars as $sidebar) {
            $sidebar_name = $sidebar['name'];
            $selected = ($page_sidebar == $sidebar_name) ? 'selected' : '';
            $content .= "<option $selected value=\"$sidebar_name\" class=\"level-0\">$sidebar_name</option>";
        }
        $content .= '</select>';

        $page_title_visible = inc_is_page_title_bar_visible();
        $on_selected = $page_title_visible ? ' selected' : '';
        $off_selected = $page_title_visible ? '' : ' selected';
        $content .= '<p><strong>' . __('Title Bar Visibility', INCEPTIO_THEME_NAME) . '</strong></p>';
        $content .= '<select id="inc-title-bar-visibility" name="' . SETTINGS_PAGE_TITLE_BAR_VISIBLE . '">';
        $content .= '<option value="on"' . $on_selected . '>' . __('Visible', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="off"' . $off_selected . '>' . __('Hidden', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        echo $content;
    }

    protected function supports_no_sidebar(){
        return false;
    }

}
