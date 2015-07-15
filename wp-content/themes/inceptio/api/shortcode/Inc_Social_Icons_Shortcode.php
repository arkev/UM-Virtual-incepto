<?php


class Inc_Social_Icons_Shortcode extends Abstract_Inc_Shortcode implements Inc_Shortcode_Designer
{
    static $CLASS = "class";
    static $MAIL_ATTR = "mail";
    static $TWITTER_ATTR = "twitter";
    static $FACEBOOK_ATTR = "facebook";
    static $GPLUS_ATTR = "gplus";
    static $LINKEDIN_ATTR = "linkedin";
    static $VIMEO_ATTR = "vimeo";
    static $YOUTUBE_ATTR = "youtube";
    static $SKYPE_ATTR = "skype";
    static $DIGG_ATTR = "digg";
    static $DELICIOUS_ATTR = "delicious";
    static $TUMBLR_ATTR = "tumblr";
    static $DRIBBBLE_ATTR = "dribbble";
    static $STUMBLEUPON_ATTR = "stumbleupon";
    static $RSS_ATTR = "rss";
    var $supported_sn;

    function __construct()
    {
        $this->supported_sn = array('twitter' => 'Twitter',
            'facebook' => 'Facebook',
            'gplus' => 'Google+',
            'linkedin' => 'LinkedIn',
            'vimeo' => 'Vimeo',
            'youtube' => 'YouTube',
            'skype' => 'Skype',
            'digg' => 'Digg',
            'delicious' => 'Delicious',
            'tumbler' => 'Tumbler',
            'dribbble' => 'Dribbble',
            'stumbleupon' => 'StumbleUpon');
    }

    function render($attr, $inner_content = null, $code = "")
    {
        extract(shortcode_atts(array(
            Inc_Social_Icons_Shortcode::$CLASS => '',
            Inc_Social_Icons_Shortcode::$MAIL_ATTR => '',
            Inc_Social_Icons_Shortcode::$RSS_ATTR => 'false'), $attr));
        $content = '';
        foreach ($attr as $key => $val) {
            if (!empty($val)) {
                if (array_key_exists($key, $this->supported_sn) || inc_start_with($key, 'sn_')) {
                    $sn_class = inc_get_sn_class(($key == 'gplus') ? 'google-plus' : $key);
                    $sn_name = $this->get_social_network_name($key);
                    $content .= "<li class=\"" . $sn_class . "\"><a href=\"$val\" title=\"$sn_name\" target=\"_blank\">$sn_name</a></li>";
                }
            }
        }
        if (!empty($mail)) {
            $mail_name = __("Mail", INCEPTIO_THEME_NAME);
            $content .= "<li class=\"" . inc_get_sn_class('mail') . "\"><a href=\"mailto:$mail\" title=\"$mail_name\" target=\"_blank\">$mail_name</a></li>";
        }
        if ($rss == 'true') {
            $rss_name = __('RSS', INCEPTIO_THEME_NAME);
            $rss_url = inc_get_rss_url();
            $content .= "<li class=\"" . inc_get_sn_class('rss') . "\"><a href=\"$rss_url\" title=\"$rss_name\" target=\"_blank\">$rss_name</a></li>";
        }

        if (!empty($content)) {
            $classes = array('social-links');
            $core_attributes = $this->get_core_attributes($attr, array('class' => $classes));

            $content = "<ul".$core_attributes.">" . $content . "</ul>";
        }

        return $content;
    }

    protected function get_social_network_name($sn)
    {
        if (array_key_exists($sn, $this->supported_sn)) {
            $sn_name = $this->supported_sn[$sn];
        } else {
            $sn_name = '';
        }
        return apply_filters('inc_sn_name', $sn_name, $sn);
    }

    function get_names()
    {
        return array('social');
    }

    function get_visual_editor_form()
    {
        $content = '<form id="sc-social-form" class="generic-form" method="post" action="#" data-sc="social">';
        $content .= '<fieldset>';
        $content .= '<div>';
        $content .= '<label for="sc-social-class">' . __('Class', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-social-class" name="sc-social-class" type="text" data-attr-name="' . Inc_Social_Icons_Shortcode::$CLASS . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-social-twitter">' . __('Twitter URL', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-social-twitter" name="sc-social-twitter" type="text" data-attr-name="' . Inc_Social_Icons_Shortcode::$TWITTER_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-social-facebook">' . __('Facebook URL', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-social-facebook" name="sc-social-facebook" type="text" data-attr-name="' . Inc_Social_Icons_Shortcode::$FACEBOOK_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-social-gplus">' . __('Google+ URL', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-social-gplus" name="sc-social-gplus" type="text" data-attr-name="' . Inc_Social_Icons_Shortcode::$GPLUS_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-social-linkedin">' . __('LinkedIn URL', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-social-linkedin" name="sc-social-linkedin" type="text" data-attr-name="' . Inc_Social_Icons_Shortcode::$LINKEDIN_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-social-vimeo">' . __('Vimeo URL', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-social-vimeo" name="sc-social-vimeo" type="text" data-attr-name="' . Inc_Social_Icons_Shortcode::$VIMEO_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-social-youtube">' . __('YouTube URL', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-social-youtube" name="sc-social-youtube" type="text" data-attr-name="' . Inc_Social_Icons_Shortcode::$YOUTUBE_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-social-skype">' . __('Skype URL', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-social-skype" name="sc-social-skype" type="text" data-attr-name="' . Inc_Social_Icons_Shortcode::$SKYPE_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-social-digg">' . __('Digg URL', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-social-digg" name="sc-social-digg" type="text" data-attr-name="' . Inc_Social_Icons_Shortcode::$DIGG_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-social-delicious">' . __('Delicious URL', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-social-delicious" name="sc-social-delicious" type="text" data-attr-name="' . Inc_Social_Icons_Shortcode::$DELICIOUS_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-social-tumbler">' . __('Tumbler URL', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-social-tumbler" name="sc-social-tumbler" type="text" data-attr-name="' . Inc_Social_Icons_Shortcode::$TUMBLR_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-social-dribbble">' . __('Dribbble URL', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-social-dribbble" name="sc-social-dribbble" type="text" data-attr-name="' . Inc_Social_Icons_Shortcode::$DRIBBBLE_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-social-stumbleupon">' . __('StumbleUpon URL', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-social-stumbleupon" name="sc-social-stumbleupon" type="text" data-attr-name="' . Inc_Social_Icons_Shortcode::$STUMBLEUPON_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-social-mail">' . __('Mail Address', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-social-mail" name="sc-social-mail" type="text" data-attr-name="' . Inc_Social_Icons_Shortcode::$MAIL_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div >';
        $content .= '<input id="sc-social-form-submit" type="submit" name="submit" value="' . __('Insert Social Icons', INCEPTIO_THEME_NAME) . '" class="button-primary">';
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
        return __('Social Icons', INCEPTIO_THEME_NAME);
    }
}