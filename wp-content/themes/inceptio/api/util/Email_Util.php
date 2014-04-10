<?php

class Email_Util
{
    static function send_email_to_me($from_email, $from_name, $subject, $message)
    {
        $to = get_bloginfo('admin_email');
        Email_Util::send_email_to($to, $from_email, $from_name, $subject, $message);
    }

    static function send_email_to($to, $from_email, $from_name, $subject, $message)
    {
        if (!isset($subject) || empty($subject)) {
            $subject = __('New email from', INCEPTIO_THEME_NAME) . ' ' . get_home_url();
        }
        Email_Util::validate_email_address($to);
        Email_Util::validate_required_field($message);

        $headers = "Content-type: text/html; charset=UTF-8\r\n";
        $headers .= "From: $from_name <$from_email>\r\n";
        $headers .= "Reply-To: $from_email\r\n";
        if (!wp_mail($to, $subject, $message, $headers)) {
            throw new Exception(__('Error sending the email. Please check the server log for more details.', INCEPTIO_THEME_NAME));
        }
    }

    private static function validate_required_field($field_value)
    {
        if (!isset($field_value) || strlen(trim($field_value)) == 0) {
            throw new Exception(__('The field', INCEPTIO_THEME_NAME) . ' ' . $field_value . ' ' . __('is empty.', INCEPTIO_THEME_NAME));
        }
    }

    private static function validate_email_address($email)
    {
        if (!is_email($email)) {
            throw new Exception(__('Invalid email address', INCEPTIO_THEME_NAME));
        }
    }

}
