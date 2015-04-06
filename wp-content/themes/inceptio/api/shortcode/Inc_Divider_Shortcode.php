<?php


class Inc_Divider_Shortcode extends Abstract_Inc_Shortcode implements Inc_Shortcode_Designer
{
    static $TYPE_ATTR = "type";

    function render($attr, $inner_content = null, $code = "")
    {
        extract(shortcode_atts(array(
            Inc_Divider_Shortcode::$TYPE_ATTR => 'simple'), $attr));


        if ($type == 'simple') {
            $core_attributes = $this->get_core_attributes($attr);

            $content = '<hr' . $core_attributes . '>';
        } elseif ($type == 'double') {
            $classes = array('divider-double-line');
            $core_attributes = $this->get_core_attributes($attr, array('class' => $classes));

            $content = '<div' . $core_attributes . '></div>';
        } else {
            $content = $this->get_error('Wrong type value. The value of the ' . Inc_Divider_Shortcode::$TYPE_ATTR . ' attribute must be: simple or double.');
        }
        return $content;
    }

    function get_names()
    {
        return array('hr');
    }

    function get_visual_editor_form()
    {
        $content = '<form id="sc-hr-form" class="generic-form" method="post" action="#" data-sc="hr">';
        $content .= '<fieldset>';
        $content .= '<div>';
        $content .= '<label for="sc-hr-type">' . __('Type', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="sc-hr-type" name="sc-hr-type" data-attr-name="' . Inc_Divider_Shortcode::$TYPE_ATTR . '" data-attr-type="attr">';
        $content .= '<option value="simple">' . __('Simple', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="double">' . __('Double', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div >';
        $content .= '<input id="sc-hr-form-submit" type="submit" name="submit" value="' . __('Insert Divider', INCEPTIO_THEME_NAME) . '" class="button-primary">';
        $content .= '</div>';
        $content .= '</fieldset>';
        $content .= '</form>';
        return $content;
    }

    function get_group_title()
    {
        return __('Typography', INCEPTIO_THEME_NAME);
    }

    function get_title()
    {
        return __('Divider', INCEPTIO_THEME_NAME);
    }
}