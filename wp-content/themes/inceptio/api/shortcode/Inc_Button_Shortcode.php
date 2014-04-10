<?php

class Inc_Button_Shortcode extends Abstract_Inc_Shortcode implements Inc_Shortcode_Designer
{
    static $HREF_ATTR = "href";
    static $CLASS_ATTR = "class";
    static $COLOR_ATTR = "color";
    static $SIZE_ATTR = "size";
    static $TARGET_ATTR = "target";
    static $REL_ATTR = "rel";
    static $TOOLTIP_ATTR = "tooltip";
    static $predefined_colors = array(
        'Use the Theme Color' => '',
        'Green' => 'green',
        'Retro-Green' => 'retro-green',
        'Teal' => 'teal',
        'Orange' => 'orange',
        'Yellow' => 'yellow',
        'Blue' => 'blue',
        'Indigo' => 'indigo',
        'Red' => 'red',
        'Pink' => 'pink',
        'Purple' => 'purple',
        'Black' => 'black');

    function render($attr, $inner_content = null, $code = "")
    {
        $default_attr = array(
            Inc_Button_Shortcode::$HREF_ATTR => '#',
            Inc_Button_Shortcode::$CLASS_ATTR => '',
            Inc_Button_Shortcode::$COLOR_ATTR => '',
            Inc_Button_Shortcode::$SIZE_ATTR => '',
            Inc_Button_Shortcode::$TOOLTIP_ATTR => '');
        $attr = array_merge($default_attr, $attr);
        extract($attr);

        $class_attr_value = 'button';
        if (!empty($size)) {
            $class_attr_value .= ' ' . $size;
        }
        if (!empty($color)) {
            $class_attr_value .= ' ' . $color;
        }
        if (!empty($class)) {
            $class_attr_value .= ' ' . $class;
        }
        if (!empty($tooltip)) {
            $class_attr_value .= ' inc-tooltip';
        }
        $href_attr = $this->get_attribute('href', $href);
        $title_attr = $this->get_attribute('title', $tooltip);
        $a_attr = '';
        foreach ($attr as $key => $val) {
            $key = strtolower($key);
            if ($key != Inc_Button_Shortcode::$CLASS_ATTR) {
                $a_attr .= $this->get_attribute($key, $val);
            }
        }
        return "<a class=\"$class_attr_value\" $href_attr $title_attr $a_attr>$inner_content</a>";
    }

    function get_names()
    {
        return array('button', 'btn');
    }

    function get_visual_editor_form()
    {
        $content = '<form id="sc-button-form" class="generic-form" method="post" action="#" data-sc="btn">';
        $content .= '<fieldset>';
        $content .= '<div>';
        $content .= '<label for="sc-button-href">' . __('URL', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-button-href" name="sc-button-href" type="text" class="required" data-attr-name="' . Inc_Button_Shortcode::$HREF_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-button-text">' . __('Text', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-button-text" name="sc-button-text" type="text" class="required" data-attr-type="content">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label>' . __('Bg Color', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<ul data-ref="sc-bg-color" class="color-thumbs">';
        foreach (Inc_Button_Shortcode::$predefined_colors as $key => $value) {
            $content .= "<li><a class=\"$value\" title=\"$key\" href=\"#\" data-color=\"$value\"></a></li>";
        }
        $content .= '</ul>';
        $content .= '<input id="sc-bg-color" name="sc-bg-color" type="hidden" data-attr-name="' . Inc_Button_Shortcode::$COLOR_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-button-type">' . __('Size', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="sc-button-type" name="sc-button-type" data-attr-name="' . Inc_Button_Shortcode::$SIZE_ATTR . '" data-attr-type="attr">';
        $content .= '<option value="">' . __('Normal Button', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="large">' . __('Large Button', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-button-target">' . __('Target Window', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="sc-button-target" name="sc-button-target" data-attr-name="' . Inc_Button_Shortcode::$TARGET_ATTR . '" data-attr-type="attr">';
        $content .= '<option value="_self">' . __('Same Window', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="_blank">' . __('New Window', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="_parent">' . __('Parent Window', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="_top">' . __('Full Body of the Window', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-button-tooltip">' . __('Tooltip', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-button-tooltip" name="sc-button-tooltip" type="text" data-attr-name="' . Inc_Button_Shortcode::$TOOLTIP_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div >';
        $content .= '<input id="sc-button-form-submit" type="submit" name="submit" value="' . __('Insert Button', INCEPTIO_THEME_NAME) . '" class="button-primary">';
        $content .= '</div>';
        $content .= '</fieldset>';
        $content .= '</form>';
        return $content;
    }

    function get_group_title()
    {
        return __('Elements', INCEPTIO_THEME_NAME);
    }

    function get_title()
    {
        return __('Button', INCEPTIO_THEME_NAME);
    }
}
