<?php

class Inc_Carousel_Settings
{

    private $selector, $attr, $default;
    static $CS_VERTICAL_ATTR = "cs_vertical";
    static $CS_RTL_ATTR = "cs_rtl";
    static $CS_START_ATTR = "cs_start";
    static $CS_OFFSET_ATTR = "cs_offset";
    static $CS_SIZE_ATTR = "cs_size";
    static $CS_SCROLL_ATTR = "cs_scroll";
    static $CS_VISIBLE_ATTR = "cs_visible";
    static $CS_ANIMATION_ATTR = "cs_animation";
    static $CS_EASING_ATTR = "cs_easing";
    static $CS_AUTO_ATTR = "cs_auto";
    static $CS_WRAP_ATTR = "cs_wrap";

    function __construct($selector, $attr, $default = array())
    {
        $this->attr = $attr;
        $this->selector = $selector;
        $this->default = $default;
    }

    function get_carousel_settings()
    {
        extract(shortcode_atts(array(
            Inc_Carousel_Settings::$CS_VERTICAL_ATTR => '',
            Inc_Carousel_Settings::$CS_RTL_ATTR => '',
            Inc_Carousel_Settings::$CS_START_ATTR => '',
            Inc_Carousel_Settings::$CS_OFFSET_ATTR => '',
            Inc_Carousel_Settings::$CS_SIZE_ATTR => '',
            Inc_Carousel_Settings::$CS_SCROLL_ATTR => '',
            Inc_Carousel_Settings::$CS_VISIBLE_ATTR => '',
            Inc_Carousel_Settings::$CS_ANIMATION_ATTR => '',
            Inc_Carousel_Settings::$CS_EASING_ATTR => '',
            Inc_Carousel_Settings::$CS_AUTO_ATTR => '',
            Inc_Carousel_Settings::$CS_WRAP_ATTR => ''), array_merge($this->default, $this->attr)));

        $customSettings = 'inceptio:""';
        if (!empty($cs_vertical)) {
            $customSettings .= ',vertical:' . $cs_vertical;
        }
        if (!empty($cs_rtl)) {
            $customSettings .= ',rtl:' . $cs_rtl;
        }
        if (!empty($cs_start)) {
            $customSettings .= ',start:' . $cs_start;
        }
        if (!empty($cs_offset)) {
            $customSettings .= ',offset:' . $cs_offset;
        }
        if (!empty($cs_size)) {
            $customSettings .= ',size:' . $cs_size;
        }
        if (!empty($cs_scroll)) {
            $customSettings .= ',scroll:' . $cs_scroll;
        }
        if (!empty($cs_visible)) {
            $customSettings .= ',visible:' . $cs_visible;
        }
        if (!empty($cs_animation)) {
            if (is_numeric($cs_animation)) {
                $customSettings .= ',animation: ' . $cs_animation . '';
            } else {
                $customSettings .= ',animation:"' . $cs_animation . '"';
            }
        }
        if (!empty($cs_easing)) {
            $customSettings .= ',easing:"' . $cs_easing . '"';
        }
        if (!empty($cs_auto)) {
            $customSettings .= ',auto:' . $cs_auto;
        }
        if (!empty($cs_wrap)) {
            $customSettings .= ',wrap:"' . $cs_wrap . '"';
        }

        $content = "<script type=\"text/javascript\">
                    if(!document['carouselSettings']){
                        document['carouselSettings'] = [];
                    }
                    document['carouselSettings'].push({
                        selector: '" . $this->selector . "',
                        customSettings: {" . $customSettings . "}
                    });
                </script>";
        return $content;
    }
}