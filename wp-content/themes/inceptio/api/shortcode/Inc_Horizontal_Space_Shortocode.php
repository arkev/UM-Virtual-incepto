<?php


class Inc_Horizontal_Space_Shortocode extends Abstract_Inc_Shortcode implements Inc_Shortcode_Designer
{

    function render($attr, $inner_content = null, $code = '')
    {
        extract(shortcode_atts(array('size' => '20'), $attr));
        $classes = array('space' . $size);
        $core_attributes = $this->get_core_attributes($attr, array('class' => $classes));
        return '<div' . $core_attributes . '></div>';
    }

    function get_names()
    {
        return array('hs');
    }

    function get_visual_editor_form()
    {
        $content = '<form id="sc-hs-form" class="generic-form" method="post" action="#" data-sc="hs">';
        $content .= '<fieldset>';
        $content .= '<div>';
        $content .= '<label for="sc-hs-size">' . __('Size', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="sc-hs-size" name="sc-hs-size">';
        $content .= '<option value="20">20</option>';
        $content .= '<option value="40">40</option>';
        $content .= '</select>';
        $content .= '</div>';

        $content .= '<div >';
        $content .= '<input id="sc-hs-form-submit" type="submit" name="submit" value="' . __('Insert Space', INCEPTIO_THEME_NAME) . '" class="button-primary">';
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
        return __('Horizontal Space', INCEPTIO_THEME_NAME);
    }
}