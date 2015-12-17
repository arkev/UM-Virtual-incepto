<?php
if (is_user_logged_in()) {
    add_action('wp_ajax_inc-twitter-proxy', 'inc_process_twitter_request');
} else {
    add_action('wp_ajax_nopriv_inc-twitter-proxy', 'inc_process_twitter_request');
}

if (!function_exists('inc_twitter_build_base_string')) {
    function inc_twitter_build_base_string($baseURI, $method, $params)
    {
        $args = array();
        ksort($params);
        foreach ($params as $key => $value) {
            $args[] = $key . '=' . rawurlencode($value);
        }
        return $method . "&" . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $args));
    }
}

if (!function_exists('inc_twitter_build_authorization_header')) {
    function inc_twitter_build_authorization_header($oauth)
    {
        $values = array();
        foreach ($oauth as $key => $value) {
            $values[] = "$key=\"" . rawurlencode($value) . "\"";
        }
        return 'OAuth ' . implode(', ', $values);
    }
}

if (!function_exists('inc_process_twitter_request')) {
    function inc_process_twitter_request()
    {
        $twitter_config = inc_get_twitter_config();
        $twitter_uername = inc_get_social_network_url(OPTION_SN_TWITTER_USERNAME);

        $white_list = array(
            'statuses/user_timeline.json?screen_name=' . $twitter_uername,
            'favorites.json?screen_name=' . $twitter_uername,
            $twitter_uername . '/lists/'
        );

        if (!isset($_GET['url'])) {
            die('No URL set');
        }
        $white_list = apply_filters('inc_twitter_white_list', $white_list);
        $url = $_GET['url'];

        if (count($white_list) > 0) {
            $valid_url = false;
            foreach ($white_list as $val) {
                if (inc_start_with($url, $val)) {
                    $valid_url = true;
                }
            }
            if (!$valid_url) {
                die('URL is not authorised');
            }
        }

        $url_parts = parse_url($url);
        parse_str($url_parts['query'], $url_arguments);

        $full_url = $twitter_config['api_url'] . $url; // Url with the query on it.
        $base_url = $twitter_config['api_url'] . $url_parts['path']; // Url without the query.

        $oauth_config = array(
            'oauth_consumer_key' => $twitter_config['consumer_key'],
            'oauth_nonce' => time(),
            'oauth_signature_method' => 'HMAC-SHA1',
            'oauth_token' => $twitter_config['access_token'],
            'oauth_timestamp' => time(),
            'oauth_version' => '1.0'
        );
        $base_info = inc_twitter_build_base_string($base_url, 'GET', array_merge($oauth_config, $url_arguments));
        $composite_key = rawurlencode($twitter_config['consumer_secret']) . '&' . rawurlencode($twitter_config['access_token_secret']);
        $oauth_signature = base64_encode(hash_hmac('sha1', $base_info, $composite_key, true));
        $oauth_config['oauth_signature'] = $oauth_signature;

        $oauth_header = array(
            'Authorization' => inc_twitter_build_authorization_header($oauth_config),
            'Expect' => ''
        );
        $response = wp_remote_get($full_url, array('headers' => $oauth_header, 'sslverify' => false));
        $resp_headers = $response['headers'];
        $resp_body = $response['body'];

        header('Content-Type: ' . $resp_headers['content-type']);
        header('Content-Length: ' . strlen($resp_body));
        echo $resp_body;
        die();
    }
}