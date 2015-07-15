<?php

class Inc_Toggles_Shortcode extends Abstract_Inc_Shortcode implements Inc_Shortcode_Designer
{

    static $TOGGLES_TYPE_ATTR = "type";
    static $TOGGLE_TITLE_ATTR = "title";
    static $TOGGLE_STATE_ATTR = "state";
    static $TOGGLE_DISABLED_ATTR = "disabled";
    static $TOGGLE_HSTYLE_ATTR = "height_style";
    var $toggles = array();

    private function reset()
    {
        unset($this->toggles);
        $this->toggles = array();
    }

    function render($attr, $inner_content = null, $code = "")
    {
        $content = '';
        switch ($code) {
            case "toggles":
                do_shortcode($this->prepare_content($inner_content));
                $content .= $this->render_toggles($attr);
                $this->reset();
                break;
            case "toggle":
                $inner_content = do_shortcode($this->prepare_content($inner_content));
                $this->render_toggle($attr, $inner_content);
                break;
        }
        return $content;
    }

    private function render_toggles($attr)
    {
        extract(shortcode_atts(array(Inc_Toggles_Shortcode::$TOGGLES_TYPE_ATTR => 'default',
            Inc_Toggles_Shortcode::$TOGGLE_DISABLED_ATTR => '',
            Inc_Toggles_Shortcode::$TOGGLE_HSTYLE_ATTR => '',), $attr));
        if ($type == 'accordion') {
            $data_disabled_attr = $this->get_attribute('data-disabled', $disabled);
            $data_hstyle_attr = $this->get_attribute('data-height-style', $height_style);
            $active = '';
            foreach ($this->toggles as $index => $v) {
                if (empty($active) && $v['active'] == 'true') {
                    $active = $index + 1;
                }
            }
            $data_active_attr = $this->get_attribute('data-active', $active);
            $classes = array('accordion');
            $core_attributes = $this->get_core_attributes($attr, array('class' => $classes));

            $content = '<div' . $core_attributes . $data_active_attr . $data_disabled_attr . $data_hstyle_attr . '>';
            foreach ($this->toggles as $v) {
                $content .= '<div>';
                $content .= "<span class=\"accordion-title\">" . $v['title'] . "</span>";
                $content .= '<div class="accordion-inner">';
                $content .= $v['value'];
                $content .= '</div>';
                $content .= '</div>';
            }
            $content .= '</div>';
        } else {
            $content = '';
            foreach ($this->toggles as $index => $v) {
                $data_active_attr = $this->get_attribute('data-active', $v['active']);
                $data_disabled_attr = $this->get_attribute('data-disabled', $v['disabled']);
                $data_hstyle_attr = $this->get_attribute('data-height-style', $v['height_style']);
                $content .= '<div class="toggle toggle-' . ($index + 1) . '"' . $data_active_attr . $data_disabled_attr . $data_hstyle_attr . '>';
                $content .= "<span class=\"toggle-title\">" . $v['title'] . "</span>";
                $content .= '<div class="toggle-inner">';
                $content .= $v['value'];
                $content .= '</div>';
                $content .= '</div>';
            }
        }
        return $content;
    }

    private function render_toggle($attr, $inner_content = null)
    {
        extract(shortcode_atts(array(
            Inc_Toggles_Shortcode::$TOGGLE_TITLE_ATTR => '',
            Inc_Toggles_Shortcode::$TOGGLE_DISABLED_ATTR => '',
            Inc_Toggles_Shortcode::$TOGGLE_HSTYLE_ATTR => '',
            Inc_Toggles_Shortcode::$TOGGLE_STATE_ATTR => 'closed'), $attr));
        $title = __inc($title);
        $inner_content = __inc($inner_content);
        array_push($this->toggles, array('title' => $title,
            'value' => $inner_content,
            'active' => ($state == 'closed') ? 'false' : 'true',
            'disabled' => $disabled,
            'height_style' => $height_style
        ));
    }

    function get_names()
    {
        return array('toggles', 'toggle');
    }

    function get_visual_editor_form()
    {
        $toogle_example = '[toggles]';
        $toogle_example .= '[toggle title="Title 1" state="opened"]Content 1[/toggle]';
        $toogle_example .= '[toggle title="Title 2"]Content 2[/toggle]';
        $toogle_example .= '[toggle title="Title 3" state="opened"]Content 3[/toggle]';
        $toogle_example .= '[/toggles]';
        $toogle_example = str_replace(array('[', ']'), array('&#91;', '&#93;'), $toogle_example);

        $accordion_example = '[toggles type="accordion"]';
        $accordion_example .= '[toggle title="Title 1" state="opened"]Content 1[/toggle]';
        $accordion_example .= '[toggle title="Title 2"]Content 2[/toggle]';
        $accordion_example .= '[toggle title="Title 3"]Content 3[/toggle]';
        $accordion_example .= '[/toggles]';
        $accordion_example = str_replace(array('[', ']'), array('&#91;', '&#93;'), $accordion_example);

        $content = '<form id="sc-toggles-form" class="generic-form" method="post" action="#" data-sc="toggles">';
        $content .= '<fieldset>';
        $content .= '<div>';
        $content .= '<label for="sc-toggles-type">' . __('Example Type', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="sc-toggles-type" name="sc-toggles-type" data-default="' . esc_textarea($toogle_example) . '" data-accordion="' . esc_textarea($accordion_example) . '">';
        $content .= '<option value="">' . __('Choose Example ...', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="default">' . __('Default', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="accordion">' . __('Accordion', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-toggles-content">' . __('Template', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<textarea id="sc-toggles-content" name="sc-toggles-content" class="required"></textarea>';
        $content .= '</div>';
        $content .= '<div >';
        $content .= '<input id="sc-toggle-form-submit" type="submit" name="submit" value="' . __('Insert Toggles', INCEPTIO_THEME_NAME) . '" class="button-primary">';
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
        return __('Toggles', INCEPTIO_THEME_NAME);
    }
}
