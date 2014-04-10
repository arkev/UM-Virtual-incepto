<?php

class Inc_Tabs_Shortcode extends Abstract_Inc_Shortcode implements Inc_Shortcode_Designer
{
    static $TAB_TITLE_ATTR = "title";
    static $TAB_ACTIVE_ATTR = "active";
    static $TAB_DISABLED_ATTR = "disabled";
    static $TAB_HSTYLE_ATTR = "height_style";
    var $tabs = array();

    private function reset()
    {
        unset($this->tabs);
        $this->tabs = array();
    }

    function render($attr, $inner_content = null, $code = "")
    {
        $content = '';
        switch ($code) {
            case "tabs":
                $inner_content = do_shortcode($this->prepare_content($inner_content));
                $content .= $this->render_tabs($attr, $inner_content);
                $this->reset();
                break;
            case "tab":
                $inner_content = do_shortcode($this->prepare_content($inner_content));
                $content .= $this->render_tab($attr, $inner_content);
                break;
        }
        return $content;
    }

    private function render_tabs($attr, $inner_content = null)
    {
        extract(shortcode_atts(array(
            Inc_Tabs_Shortcode::$TAB_ACTIVE_ATTR => '',
            Inc_Tabs_Shortcode::$TAB_DISABLED_ATTR => '',
            Inc_Tabs_Shortcode::$TAB_HSTYLE_ATTR => ''), $attr));

        $data_active_attr = $this->get_attribute('data-active', $active);
        $data_disabled_attr = $this->get_attribute('data-disabled', $disabled);
        $data_hstyle_attr = $this->get_attribute('data-height-style', $height_style);

        $classes = array('tabs');
        $core_attributes = $this->get_core_attributes($attr, array('class' => $classes));

        $content = '<div' . $core_attributes . $data_active_attr . $data_disabled_attr . $data_hstyle_attr . '>';
        $content .= '<ul class="tabs-nav clearfix">';
        foreach ($this->tabs as $k => $v) {
            $content .= $k;
        }
        $content .= '</ul>';
        foreach ($this->tabs as $k => $v) {
            $content .= $v;
        }
        $content .= '</div>';
        return $content;
    }

    private function render_tab($attr, $inner_content = null)
    {
        extract(shortcode_atts(array(Inc_Tabs_Shortcode::$TAB_TITLE_ATTR => ''), $attr));
        $i = count($this->tabs) + 1;
        $key = "<li><a href=\"#tab-$i\">$title</a></li>";
        $value = "<div id=\"tab-$i\" class=\"tab\">$inner_content</div>";
        $this->tabs[$key] = $value;
        return '';
    }

    function get_names()
    {
        return array('tabs', 'tab');
    }

    function get_visual_editor_form()
    {
        $ex1 = '[tabs active="2"]';
        $ex1 .= '[tab title="Tab 1"]Content 1[/tab]';
        $ex1 .= '[tab title="Tab 2"]Content 2[/tab]';
        $ex1 .= '[tab title="Tab 3"]Content 3[/tab]';
        $ex1 .= '[tab title="Tab 4"]Content 4[/tab]';
        $ex1 .= '[/tabs]';
        $ex1 = str_replace(array('[', ']'), array('&#91;', '&#93;'), $ex1);

        $ex2 = '[tabs active="1" disabled="3,4"]';
        $ex2 .= '[tab title="Tab 1"]Content 1[/tab]';
        $ex2 .= '[tab title="Tab 2"]Content 2[/tab]';
        $ex2 .= '[tab title="Tab 3"]Content 3[/tab]';
        $ex2 .= '[tab title="Tab 4"]Content 4[/tab]';
        $ex2 .= '[/tabs]';
        $ex2 = str_replace(array('[', ']'), array('&#91;', '&#93;'), $ex2);

        $content = '<form id="sc-tabs-form" class="generic-form" method="post" action="#" data-sc="tabs">';
        $content .= '<fieldset>';
        $content .= '<div>';
        $content .= '<label for="sc-tabs-ex">' . __('Example Type', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="sc-tabs-ex" name="sc-tabs-ex" data-ex1="' . esc_textarea($ex1) . '" data-ex2="' . esc_textarea($ex2) . '">';
        $content .= '<option value="">' . __('Choose Example ...', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="ex1">' . __('Default Example', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="ex2">' . __('With Disabled Tabs', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-tabs-content">' . __('Template', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<textarea id="sc-tabs-content" name="sc-tabs-content" class="required" data-attr-type="content"></textarea>';
        $content .= '</div>';
        $content .= '<div >';
        $content .= '<input id="sc-tabs-form-submit" type="submit" name="submit" value="' . __('Insert Tabs', INCEPTIO_THEME_NAME) . '" class="button-primary">';
        $content .= '</div>';
        $content .= '</fieldset>';
        $content .= '</form>';
        return $content;
    }

    function get_group_title()
    {
        return __('Dynamic Elements', INCEPTIO_THEME_NAME);
    }

    function get_title()
    {
        return __('Tabs', INCEPTIO_THEME_NAME);
    }
}
