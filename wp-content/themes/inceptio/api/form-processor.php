<?php
if (is_user_logged_in()) {
    add_action('wp_ajax_inc-process-form', 'inc_process_form');
} else {
    add_action('wp_ajax_nopriv_inc-process-form', 'inc_process_form');
}

if (!function_exists('inc_process_form')) {
    function inc_process_form()
    {
        $user_action = $_POST['ua'];
        $method_name = 'inc_' . $user_action;
        if (function_exists($method_name)) {
            call_user_func($method_name);
        } else {
            header($_SERVER['SERVER_PROTOCOL'] . " 500 Internal Server Error");
            echo "No callable function " . $method_name . " found";
            die();
        }
    }
}

if (!function_exists('inc_process_contact_form')) {
    function inc_process_contact_form()
    {
        try {
            if (inc_is_captcha_form_enabled() && !inc_is_captcha_code_valid()) {
                throw new Exception(__('The reCAPTCHA code wasn\'t entered correctly.', INCEPTIO_THEME_NAME));
            }
            $current_host = home_url();
            $params_ignored = array('submit', 'action', 'ua', 'recaptcha_challenge_field', 'recaptcha_response_field', 'recipients');
            $email = isset($_POST['email']) ? $_POST['email'] : get_bloginfo('admin_email');
            $name = isset($_POST['name']) ? $_POST['name'] : $email;
            $recipients = isset($_POST['recipients']) ? trim($_POST['recipients']) : '';
            $email_subject = "New email from $current_host";

            $email_body = "<html><head></head><body>";
            $email_body .= "<p>Hi,</p>";
            $email_body .= "<p>You have just received an email from the <a href=\"$current_host\" target=\"_blank\">$current_host</a> address.</p>";
            $email_body .= "<p>Please find below the data from the contact form:</p>";
            $email_body .= "<div>";
            foreach ($_POST as $key => $value) {
                if (!in_array($key, $params_ignored)) {
                    $email_body .= "<p>";
                    $email_body .= "<span><strong>" . htmlspecialchars($key) . "</strong></span><br>";
                    $email_body .= "<span>" . htmlspecialchars($value) . "</span>";
                    $email_body .= "</p>";
                }
            }
            $email_body .= "</div>";
            $email_body .= "</body></html>";

            if(empty($recipients)){
                Email_Util::send_email_to_me($email, $name, $email_subject, $email_body);
            }else{
                $recipients_array = array_filter(explode(',', $recipients));
                foreach($recipients_array as $recp){
                    Email_Util::send_email_to($recp, $email, $name, $email_subject, $email_body);
                }
            }
        } catch (Exception $e) {
            header($_SERVER['SERVER_PROTOCOL'] . " 500 Internal Server Error");
            echo $e->getMessage();
        }
        die();
    }
}

if (!function_exists('inc_process_newsletter_subscription')) {
    function inc_process_newsletter_subscription()
    {

        try {
            if(class_exists('wpMailChimpFramework')){
                $wpMailChimpFramework = wpMailChimpFramework::getInstance();
                $args = array(
                    'id'			=> $_POST['list-id'],
                    'email_address'	=> $_POST['email'],
                    'merge_vars'	=> array('EMAIL' => $_POST['email']),
                );
                $resp = $wpMailChimpFramework->listSubscribe($args);
                if (is_object($resp) && property_exists($resp, 'error')) {
                    $error_code = __('Your email address couldn\'t be subscribed because a server error occurred.', INCEPTIO_THEME_NAME);
                    $error_code .= 'Details: code=' . $resp->code . ', msg=' . $resp->error;
                    throw new Exception($error_code);
                }
            }else{
                throw new Exception(__('The MailChimp Plugin is not enabled.', INCEPTIO_THEME_NAME));
            }
        } catch (Exception $e) {
            header($_SERVER['SERVER_PROTOCOL'] . " 500 Internal Server Error");
            echo $e->getMessage();
        }
        die();
    }
}

