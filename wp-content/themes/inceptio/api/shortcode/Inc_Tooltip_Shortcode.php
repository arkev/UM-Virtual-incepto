<?php

class Inc_Tooltip_Shortcode extends Abstract_Inc_Shortcode implements Inc_Shortcode_Designer
{

    static $WRAPPER_ATTR = "wrapper";
    static $VALUE_ATTR = "value";

    function render($attr, $inner_content = null, $code = "")
    {
        extract(shortcode_atts(array(
            Inc_Tooltip_Shortcode::$WRAPPER_ATTR => 'span',
            Inc_Tooltip_Shortcode::$VALUE_ATTR => ''), $attr));

        if (empty($value)) {
            return $this->get_error('The value of the ' . Inc_Tooltip_Shortcode::$VALUE_ATTR . ' attribute must not be empty.');
        }

        $inner_content = do_shortcode($this->prepare_content($inner_content));
        $classes = array('inc-tooltip');
        $core_attributes = $this->get_core_attributes($attr, array('class' => $classes));

        return '<' . $wrapper . $core_attributes . ' title="' . $value . '">' . $inner_content . '</' . $wrapper . '>';

    }

    function get_names()
    {
        return array('tooltip');
    }

    function get_visual_editor_form()
    {
        $content = '<form id="sc-tooltip-form" class="generic-form" method="post" action="#" data-sc="tooltip">';
        $content .= '<fieldset>';
        $content .= '<div>';
        $content .= '<label for="sc-tooltip-type">' . __('Wrapper Type', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="sc-tooltip-type" name="sc-tooltip-type" data-attr-name="' . Inc_Tooltip_Shortcode::$WRAPPER_ATTR . '" data-attr-type="attr">';
        $content .= '<option value="span">SPAN</option>';
        $content .= '<option value="div">DIV</option>';
        $content .= '</select>';
        $content .= '</div>';

        $content .= '<div id="sc-tooltip-value-wrapper">';
        $content .= '<label for="sc-tooltip-value">' . __('Value', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-tooltip-value" name="sc-tooltip-value" type="text" class="required" data-attr-name="' . Inc_Tooltip_Shortcode::$VALUE_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';

        $content .= '<div>';
        $content .= '<label for="sc-tooltip-content">' . __('Content', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<textarea id="sc-tooltip-content" name="sc-tooltip-content" data-attr-type="content"></textarea>';
        $content .= '</div>';

        $content .= '<div >';
        $content .= '<input id="sc-tooltip-form-submit" type="submit" name="submit" value="' . __('Insert Tooltip', INCEPTIO_THEME_NAME) . '" class="button-primary">';
        $content .= '</div>';
        $content .= '</fieldset>';
        $content .= '</form>';

        return $content;
    }

    function get_group_title()
    {
        return __('Others', INCEPTIO_THEME_NAME);
    }

    function get_title()
    {
        return __('Tooltip', INCEPTIO_THEME_NAME);
    }

}