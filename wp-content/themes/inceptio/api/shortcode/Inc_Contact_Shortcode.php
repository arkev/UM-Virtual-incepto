<?php

class Inc_Contact_Shortcode extends Abstract_Inc_Shortcode implements Inc_Shortcode_Designer
{

    static $TITLE_ATTR = "title";
    static $PHONE_ATTR = "phone";
    static $MOBILE_ATTR = "mobile";
    static $FAX_ATTR = "fax";
    static $EMAIL_ATTR = "email";
    static $TIMETABLE_ATTR = "timetable";
    static $TIMETABLE_SEP_ATTR = "timetable_sep";

    function render($attr, $inner_content = null, $code = "")
    {
        extract(shortcode_atts(array(
            Inc_Contact_Shortcode::$TITLE_ATTR => '',
            Inc_Contact_Shortcode::$PHONE_ATTR => '',
            Inc_Contact_Shortcode::$MOBILE_ATTR => '',
            Inc_Contact_Shortcode::$FAX_ATTR => '',
            Inc_Contact_Shortcode::$EMAIL_ATTR => '',
            Inc_Contact_Shortcode::$TIMETABLE_SEP_ATTR => '|',
            Inc_Contact_Shortcode::$TIMETABLE_ATTR => ''), $attr));
        $inner_content = do_shortcode($this->prepare_content($inner_content));

        $classes = array('contact-info');
        $core_attributes = $this->get_core_attributes($attr, array('class' => $classes));

        $content = '';
        $content .= '<div' . $core_attributes . '>';
        if (!empty($title)) {
            $content .= '<h2>' . $title . '</h2>';
        }

        $content .= '<div>';
        if (!empty($inner_content)) {
            $content .= '<p class="address"><strong>' . __('Address', INCEPTIO_THEME_NAME) . ':</strong> ' . $inner_content . '</p>';
        }
        if (!empty($phone)) {
            $content .= '<p class="phone"><strong>' . __('Phone', INCEPTIO_THEME_NAME) . ':</strong> ' . $phone . '</p>';
        }
        if (!empty($mobile)) {
            $content .= '<p class="mobile"><strong>' . __('Mobile', INCEPTIO_THEME_NAME) . ':</strong> ' . $mobile . '</p>';
        }
        if (!empty($fax)) {
            $content .= '<p class="fax"><strong>' . __('Fax', INCEPTIO_THEME_NAME) . ':</strong> ' . $fax . '</p>';
        }
        if (!empty($email)) {
            $content .= '<p class="email"><strong>' . __('Email', INCEPTIO_THEME_NAME) . ':</strong> <a href="mailto:' . $email . '">' . $email . '</a></p>';
        }
        if (!empty($timetable)) {
            $content .= '<p class="business-hours"><strong>' . __('Business Hours', INCEPTIO_THEME_NAME) . ':</strong>' . ' <br>';
            $content .= str_replace($timetable_sep, "<br/>", $timetable);
            $content .= '</p>';
        }
        $content .= '</div>';
        $content .= '</div>';

        return $content;
    }

    function get_names()
    {
        return array('contact');
    }

    function get_visual_editor_form()
    {
        $content = '<form id="sc-contact-form" class="generic-form" method="post" action="#" data-sc="contact">';
        $content .= '<fieldset>';
        $content .= '<div>';
        $content .= '<label for="sc-contact-title">' . __('Title', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-contact-title" name="sc-contact-title" type="text">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-contact-phone">' . __('Phone', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-contact-phone" name="sc-contact-phone" type="text">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-contact-mobile">' . __('Mobile', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-contact-mobile" name="sc-contact-mobile" type="text">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-contact-fax">' . __('Fax', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-contact-fax" name="sc-contact-fax" type="text">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-contact-email">' . __('Email', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-contact-email" name="sc-contact-email" type="text">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-contact-tts">' . __('Timetable Separator', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-contact-tts" name="sc-contact-tts" type="text" value="|" class="required">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-contact-tt">' . __('Timetable (one per line)', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<textarea id="sc-contact-tt" name="sc-contact-tt"></textarea>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-contact-addr">' . __('Address', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<textarea id="sc-contact-addr" name="sc-contact-addr"></textarea>';
        $content .= '</div>';

        $content .= '<div >';
        $content .= '<input id="sc-contact-form-submit" type="submit" name="submit" value="' . __('Insert Contact', INCEPTIO_THEME_NAME) . '" class="button-primary">';
        $content .= '</div>';
        $content .= '</fieldset>';
        $content .= '</form>';
        return $content;
    }

    function get_group_title()
    {
        return __('Others', INCEPTIO_THEME_NAME);
    }

    function get_title()
    {
        return __('Contact', INCEPTIO_THEME_NAME);
    }
}