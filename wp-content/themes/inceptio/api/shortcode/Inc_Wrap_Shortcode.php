<?php


class Inc_Wrap_Shortcode extends Abstract_Inc_Shortcode
{
    static $TAG_ATTR = "tag";
    static $BASE64_ATTR = "base64";

    function render($attr, $inner_content = null, $code = "")
    {
        $content = '';
        if (strlen($inner_content) > 0) {
            $inner_content = do_shortcode($this->prepare_content($inner_content));
            if ($code == 'p') {
                $content = "<p>$inner_content</p>";
            } else {
                extract(shortcode_atts(array(Inc_Wrap_Shortcode::$TAG_ATTR => 'p',
                    Inc_Wrap_Shortcode::$BASE64_ATTR=>'false'), $attr));
                if($base64 == 'true'){
                    $inner_content = base64_decode($inner_content);
                }
                if (strlen(trim($tag)) > 0) {
                    $content = "<$tag>$inner_content</$tag>";
                } else {
                    $content = $inner_content;
                }
            }
        }
        return $content;
    }

    function get_names()
    {
        return array('wrap', 'p');
    }

}