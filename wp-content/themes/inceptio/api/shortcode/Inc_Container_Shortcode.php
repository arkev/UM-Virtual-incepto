<?php


class Inc_Container_Shortcode extends Abstract_Inc_Shortcode implements Inc_Shortcode_Designer
{
    static $ID_ATTR = "id";
    static $TYPE_ATTR = "type";
    static $STYLE_ATTR = "style";
    static $TITLE_ATTR = "title";
    static $TITLE_TAG_ATTR = "title_tag";

    private $types = array('section', 'div');
    private $styles = array('full', 'centered');

    function render($attr, $inner_content = null, $code = "")
    {
        $inner_content = do_shortcode($this->prepare_content($inner_content));
        extract(shortcode_atts(array(
            Inc_Container_Shortcode::$ID_ATTR => '',
            Inc_Container_Shortcode::$TYPE_ATTR => 'section',
            Inc_Container_Shortcode::$STYLE_ATTR => 'full',
            Inc_Container_Shortcode::$TITLE_ATTR => '',
            Inc_Container_Shortcode::$TITLE_TAG_ATTR => 'h2'), $attr));

        if (!in_array($type, $this->types)) {
            return $this->get_error('The value of the ' . Inc_Container_Shortcode::$TYPE_ATTR . ' attribute must be: ' . implode(',', $this->types));
        }

        if (!in_array($style, $this->styles)) {
            return $this->get_error('The value of the ' . Inc_Container_Shortcode::$STYLE_ATTR . ' attribute must be: ' . implode(',', $this->styles));
        }

        $id_attr = empty($id) ? "" : " id=\"$id\"";
        $class_attr = ($style == 'centered') ? " class=\"container clearfix\"" : "";
        if ($type == 'section') {
            if (empty($title_tag)) {
                return $this->get_error('The value of the ' . Inc_Container_Shortcode::$TITLE_TAG_ATTR . ' attribute must not be empty.');
            }

            $content = "<section" . $id_attr . $class_attr . ">";
            if (!empty($title)) {
                $content .= "<$title_tag>$title</$title_tag>";
            }
            $content .= $inner_content;
            $content .= "</section>";
            return $content;
        } else {
            return "<div" . $id_attr . $class_attr . ">$inner_content</div>";
        }
    }

    function get_names()
    {
        return array('container');
    }

    function get_visual_editor_form()
    {
        $content = '<form id="sc-container-form" class="generic-form" method="post" action="#" data-sc="container">';
        $content .= '<fieldset>';
        $content .= '<div>';
        $content .= '<label for="sc-container-id">' . __('ID', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-container-id" name="sc-container-id" type="text" data-attr-name="' . Inc_Container_Shortcode::$ID_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-container-type">' . __('Type', INCEPTIO_THEME_NAME) . '</label>';
        $content .= '<select id="sc-container-type" name="sc-container-type" data-attr-name="' . Inc_Container_Shortcode::$TYPE_ATTR . '" data-attr-type="attr">';
        $content .= '<option value="section">Section</option>';
        $content .= '<option value="div">Div</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-container-style">' . __('Style', INCEPTIO_THEME_NAME) . '</label>';
        $content .= '<select id="sc-container-style" name="sc-container-style" data-attr-name="' . Inc_Container_Shortcode::$STYLE_ATTR . '" data-attr-type="attr">';
        $content .= '<option value="full">' . __('Full Width', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="centered">' . __('Centered', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-container-title">' . __('Title', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-container-title" name="sc-container-title" type="text" data-attr-name="' . Inc_Container_Shortcode::$TITLE_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-container-titletag">' . __('Title HTML Tag', INCEPTIO_THEME_NAME) . '</label>';
        $content .= '<select id="sc-container-titletag" name="sc-container-titletag" data-attr-name="' . Inc_Container_Shortcode::$TITLE_TAG_ATTR . '" data-attr-type="attr">';
        $content .= '<option value="h1">H1</option>';
        $content .= '<option value="h2" selected>H2</option>';
        $content .= '<option value="h3">H3</option>';
        $content .= '<option value="h4">H4</option>';
        $content .= '<option value="h5">H5</option>';
        $content .= '<option value="h6">H6</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div >';
        $content .= '<input id="sc-container-content" name="sc-container-content" type="hidden" value="YOUR_CONTENT_HERE" data-attr-type="content"></textarea>';
        $content .= '<input id="sc-container-form-submit" type="submit" name="submit" value="' . __('Insert Container', INCEPTIO_THEME_NAME) . '" class="button-primary">';
        $content .= '</div>';
        $content .= '</fieldset>';
        $content .= '</form>';
        return $content;
    }

    function get_group_title()
    {
        return __('Layout', INCEPTIO_THEME_NAME);
    }

    function get_title()
    {
        return __('Container / Wrapper', INCEPTIO_THEME_NAME);
    }
}