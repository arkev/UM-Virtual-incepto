<?php

class Inc_Display_Shortcode extends Abstract_Inc_Shortcode
{
    static $ON_ATTR = "on";

    function render($attr, $inner_content = null, $code = "")
    {
        $content = '';
        extract(shortcode_atts(array(Inc_Display_Shortcode::$ON_ATTR => 'all'), $attr));
        if ((strtolower($on) == 'all') || $this->is_displayable($on)) {
            $content = do_shortcode($this->prepare_content($inner_content));
        }
        return $content;
    }

    function get_names()
    {
        return array('display');
    }

}