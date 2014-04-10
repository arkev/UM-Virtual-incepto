<?php


class Inc_Latest_Tweets_Widget extends Abstract_Inc_Widget
{

    function Inc_Latest_Tweets_Widget()
    {
        $widget_ops = array('classname' => 'Inc_Latest_Tweets_Widget', 'description' => __('A simple widget which displays your latest tweets.', INCEPTIO_THEME_NAME));
        $this->WP_Widget(Abstract_Inc_Widget::$LATEST_TWEETS_WIDGET, '[Inceptio] ' . __('Display Latest Tweets', INCEPTIO_THEME_NAME), $widget_ops);
    }

    function widget($args, $instance)
    {
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);
        $username = inc_get_social_network_url(OPTION_SN_TWITTER_USERNAME);
        $tweets_count = min(intval($instance['tweets_count']), 20);

        echo str_replace('widget', 'widget twitter-widget', $before_widget);
        if ($title) {
            echo $before_title . $title . $after_title;
        }
        if(!empty($username)){
            $proxy_url = site_url('wp-admin/admin-ajax.php?action=inc-twitter-proxy');
            echo '<div class="tweet" data-username="'.esc_textarea($username).'" data-count="'.$tweets_count.'" data-proxy="'.esc_textarea($proxy_url).'"></div>';
        }
        echo $after_widget; //defined by themes
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        $instance['username'] = $new_instance['username'];
        $instance['tweets_count'] = $new_instance['tweets_count'];
        return $instance;
    }

    function form($instance)
    {
        /* Default widget values. */
        $defaults = array(
            'title' => __('Latest Tweets', INCEPTIO_THEME_NAME),
            'tweets_count' => '2',
        );
        $instance = wp_parse_args((array)$instance, $defaults);
        $username_label = __('Username', INCEPTIO_THEME_NAME);
        $change_label = __('Change', INCEPTIO_THEME_NAME);
        $id_label = $username_label . ' (<a href="' . site_url() . '/wp-admin/themes.php?page=inc-theme-options&amp;tab=social-settings&amp;expand=configuration" target="_blank">' . $change_label . '</a>)';
        $this->print_info_field($id_label, inc_get_social_network_url(OPTION_SN_TWITTER_USERNAME));
        $this->print_text_field($instance, 'title', __('Title', INCEPTIO_THEME_NAME));
        $this->print_text_field($instance, 'tweets_count', __('Number of tweets(max 20)', INCEPTIO_THEME_NAME));
    }

}