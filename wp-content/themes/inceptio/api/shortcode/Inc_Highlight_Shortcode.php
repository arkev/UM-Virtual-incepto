<?php


class Inc_Highlight_Shortcode extends Abstract_Inc_Shortcode implements Inc_Shortcode_Designer
{

    static $TYPE_ATTR = "type";

    function render($attr, $inner_content = null, $code = "")
    {
        $content = '';
        if (isset($inner_content) && strlen($inner_content) > 0) {
            extract(shortcode_atts(array(
                Inc_Highlight_Shortcode::$TYPE_ATTR => 'colored'), $attr));
            $inner_content = do_shortcode($this->prepare_content($inner_content));

            $classes = array('highlight', $type);
            $core_attributes = $this->get_core_attributes($attr, array('class' => $classes));

            $content .= "<mark" . $core_attributes . ">$inner_content</mark>";
        }
        return $content;
    }

    function get_names()
    {
        return array('highlight', 'hl');
    }

    function get_visual_editor_form()
    {
        $content = '<form id="sc-highlight-form" class="generic-form" method="post" action="#" data-sc="hl">';
        $content .= '<fieldset>';
        $content .= '<div>';
        $content .= '<label for="sc-highlight-type">' . __('Type', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="sc-highlight-type" name="sc-highlight-type" data-attr-name="' . Inc_Highlight_Shortcode::$TYPE_ATTR . '" data-attr-type="attr">';
        $content .= '<option value="colored">' . __('Colored', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="black">' . __('Black', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-highlight-content">' . __('Content', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<textarea id="sc-highlight-content" name="sc-highlight-content" class="required" data-attr-type="content"></textarea>';
        $content .= '</div>';
        $content .= '<div >';
        $content .= '<input id="sc-highlight-form-submit" type="submit" name="submit" value="' . __('Insert Highlight Text', INCEPTIO_THEME_NAME) . '" class="button-primary">';
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
        return __('Highlight Text', INCEPTIO_THEME_NAME);
    }

}