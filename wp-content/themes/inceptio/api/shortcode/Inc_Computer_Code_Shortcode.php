<?php


class Inc_Computer_Code_Shortcode extends Abstract_Inc_Shortcode implements Inc_Shortcode_Designer
{

    function render($attr, $inner_content = null, $code = "")
    {
        $content = '';
        if (isset($inner_content) && !empty($inner_content)) {
            $core_attributes = $this->get_core_attributes($attr);

            $inner_content = htmlspecialchars($inner_content, ENT_QUOTES);
            $content = "<code" . $core_attributes . ">$inner_content</code>";
        }
        return $content;
    }

    function get_names()
    {
        return 'code';
    }

    function get_visual_editor_form()
    {
        $content = '<form id="sc-cc-form" class="generic-form" method="post" action="#" data-sc="code">';
        $content .= '<fieldset>';
        $content .= '<div>';
        $content .= '<label for="sc-cc-content">' . __('Content', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<textarea id="sc-cc-content" name="sc-cc-content" class="required" data-attr-type="content"></textarea>';
        $content .= '</div>';
        $content .= '<div >';
        $content .= '<input id="sc-cc-form-submit" type="submit" name="submit" value="' . __('Insert Computer Code', INCEPTIO_THEME_NAME) . '" class="button-primary">';
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
        return __('Computer Code', INCEPTIO_THEME_NAME);
    }

}