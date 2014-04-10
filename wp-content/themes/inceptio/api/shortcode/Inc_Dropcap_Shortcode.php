<?php


class Inc_Dropcap_Shortcode extends Abstract_Inc_Shortcode implements Inc_Shortcode_Designer
{

    static $TYPE_ATTR = "type";
    static $WRAP_ATTR = "wrap";

    function render($attr, $inner_content = null, $code = "")
    {
        $content = '';
        if (isset($inner_content) && strlen($inner_content) > 0) {
            extract(shortcode_atts(array(
                Inc_Dropcap_Shortcode::$TYPE_ATTR => 'simple',
                Inc_Dropcap_Shortcode::$WRAP_ATTR => ''), $attr));
            $inner_content = do_shortcode($this->prepare_content($inner_content));
            $first_letter = $inner_content[0];
            $rest_of = substr($inner_content, 1);

            $classes = array('dropcap', $type);
            $core_attributes = $this->get_core_attributes($attr, array('class' => $classes));

            $content .= "<span$core_attributes>$first_letter</span>$rest_of";
            if (!empty($wrap)) {
                $content = "<$wrap>$content</$wrap>";
            }
        }
        return $content;
    }

    function get_names()
    {
        return array('dropcap', 'dc');
    }

    function get_visual_editor_form()
    {
        $content = '<form id="sc-dropcap-form" class="generic-form" method="post" action="#" data-sc="dc">';
        $content .= '<fieldset>';
        $content .= '<div>';
        $content .= '<label for="sc-dropcap-type">' . __('Type', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="sc-dropcap-type" name="sc-dropcap-type" data-attr-name="' . Inc_Dropcap_Shortcode::$TYPE_ATTR . '" data-attr-type="attr">';
        $content .= '<option value="simple">' . __('Simple', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="with-bg">' . __('With Background', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-dropcap-wrap">' . __('Content Wrapper', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="sc-dropcap-wrap" name="sc-dropcap-wrap" data-attr-name="' . Inc_Dropcap_Shortcode::$WRAP_ATTR . '" data-attr-type="attr">';
        $content .= '<option value="">' . __('None', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="p">' . __('Paragraph', INCEPTIO_THEME_NAME) . ' (&lt;p&gt;)</option>';
        $content .= '<option value="div">' . __('Div', INCEPTIO_THEME_NAME) . ' (&lt;div&gt;)</option>';
        $content .= '<option value="span">' . __('Span', INCEPTIO_THEME_NAME) . ' (&lt;span&gt;)</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-dropcap-content">' . __('Content', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<textarea id="sc-dropcap-content" name="sc-dropcap-content" class="required" data-attr-type="content"></textarea>';
        $content .= '</div>';
        $content .= '<div >';
        $content .= '<input id="sc-dropcap-form-submit" type="submit" name="submit" value="' . __('Insert Dropcap', INCEPTIO_THEME_NAME) . '" class="button-primary">';
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
        return __('Dropcap', INCEPTIO_THEME_NAME);
    }

}