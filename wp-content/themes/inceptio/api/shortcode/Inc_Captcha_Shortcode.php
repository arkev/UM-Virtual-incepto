<?php

class Inc_Captcha_Shortcode extends Abstract_Inc_Shortcode
{
    function render($attr, $inner_content = null, $code = '')
    {
        $use_ssl = is_ssl();
        if (inc_is_captcha_plugin_activated()) {
            global $recaptcha;
            return $recaptcha->get_recaptcha_html(null, $use_ssl);
        } else {
            return $this->get_error('The ReCaptcha plugin is not activated.');
        }
    }

    function get_names()
    {
        return array('captcha');
    }

}
