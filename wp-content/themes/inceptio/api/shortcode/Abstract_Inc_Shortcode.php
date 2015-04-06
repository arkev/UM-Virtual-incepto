<?php

abstract class Abstract_Inc_Shortcode
{
    static $core_attributes = array('id', 'class');
    static $DISPLAY_ON_ATTR = "display_on";

    function register_shortcode()
    {
        $names = $this->get_names();
        if (is_array($names)) {
            foreach ($names as $name) {
                $register = apply_filters('inc_register_shortcode', true, $name);
                if ($register) {
                    add_shortcode($name, array($this, 'render_shortcode'));
                }
            }
        } else {
            $register = apply_filters('inc_register_shortcode', true, $names);
            if ($register) {
                add_shortcode($names, array($this, 'render_shortcode'));
            }
        }
    }

    final function render_shortcode($attr, $inner_content = null, $code = "")
    {
        if (!is_array($attr)) {
            $attr = array();
        }
        $new_attr = shortcode_atts(array(Abstract_Inc_Shortcode::$DISPLAY_ON_ATTR => 'all'), $attr);
        if ($this->is_displayable($new_attr[Abstract_Inc_Shortcode::$DISPLAY_ON_ATTR])) {
            return $this->render($attr, $inner_content, $code);
        } else {
            return '';
        }
    }

    abstract function render($attr, $inner_content = null, $code = "");

    abstract function get_names();

    protected function prepare_content($inner_content)
    {
        $inner_content = shortcode_unautop($inner_content);
        $inner_content = trim($inner_content, "\x00..\x1F");
        return $inner_content;
    }

    protected function is_displayable($value)
    {
        return inc_is_device_type_of($value);
    }

    function get_attribute($attr_name, $attr_value, $attr_default_value = '')
    {
        if (!isset($attr_value) || $attr_value == '') {
            $attr_value = $attr_default_value;
        }
        $attr_value = htmlentities($attr_value);
        return ($attr_value == '') ? '' : " $attr_name=\"$attr_value\"";
    }

    protected function get_merged_attribute($attr_name, $attr_value, $attr_default_value)
    {
        if (is_array($attr_default_value)) {
            $attr_default_value = implode(' ', $attr_default_value);
        }
        if (!empty($attr_default_value)) {
            if (!empty($attr_value)) {
                $attr_value .= ' ' . $attr_default_value;
            } else {
                $attr_value = $attr_default_value;
            }
        }
        return $this->get_attribute($attr_name, $attr_value);
    }

    function get_core_attributes($attr, $default_values = array())
    {
        $content = '';
        $content .= $this->get_attribute('id', array_key_exists('id', $attr) ? $attr['id'] : '', array_key_exists('id', $default_values) ? $default_values['id'] : '');
        $content .= $this->get_merged_attribute('class', array_key_exists('class', $attr) ? $attr['class'] : '', array_key_exists('class', $default_values) ? $default_values['class'] : '');
        return $content;
    }

    protected function get_error($error_msg)
    {
        $sc_names = $this->get_names();
        if (is_array($sc_names)) {
            $sc_names = $sc_names[0];
        }
        return "<p style=\"color:red\">SHORTCODE '.$sc_names.' ERROR: $error_msg</p>";
    }
}
