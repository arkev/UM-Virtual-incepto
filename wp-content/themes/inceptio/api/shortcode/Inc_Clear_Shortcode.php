<?php


class Inc_Clear_Shortcode extends Abstract_Inc_Shortcode
{

    function render($attr, $inner_content = null, $code = "")
    {
        return '<div class="clear"></div>';
    }

    function get_names()
    {
        return array('clear');
    }

}