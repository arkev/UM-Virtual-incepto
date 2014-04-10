<?php


class Inc_Newsletter_Subscription_Widget extends Abstract_Inc_Widget
{
    function __construct()
    {
        $widget_ops = array('classname' => 'Inc_Newsletter_Subscription_Widget', 'description' => __('MailChimp Newsletter Subscription', INCEPTIO_THEME_NAME));
        $this->WP_Widget(Abstract_Inc_Widget::$NEWSLETTER_SUBSCRIPTION, '[Inceptio] ' . __('Newsletter Subscription', INCEPTIO_THEME_NAME), $widget_ops);
    }

    function widget($args, $instance)
    {
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);
        $intro = apply_filters('widget_text', $instance['intro']);
        $list_id = $instance['list_id'];

        echo str_replace('widget', 'widget newsletter', $before_widget);
        if ($title) {
            echo $before_title . $title . $after_title;
        }

        if (!empty($intro)) {
            echo '<p>' . $intro . '</p>';
        }

        $submit_button_id = uniqid('subscribe-');
        $success_box_id = uniqid('subscribe-success-');
        $error_box_id = uniqid('subscribe-error-');
        echo do_shortcode('[notif type="success" display="false" id="' . $success_box_id . '"]' . __('You have successfully subscribed to our newsletter. Look for the confirmation email.', INCEPTIO_THEME_NAME) . '[/notif]');
        echo do_shortcode('[notif type="error" display="false" id="' . $error_box_id . '"][/notif]');
        echo '<form id="newsletter-form" class="content-form" action="'.site_url('wp-admin/admin-ajax.php').'" method="post">';
        echo '<input type="hidden" name="list-id" value="' . $list_id . '">';
        echo '<input id="newsletter" type="email" name="email" placeholder="' . __('Enter your email address', INCEPTIO_THEME_NAME) . ' &hellip;" class="required">';
        echo '<input id="' . $submit_button_id . '" class="button" type="submit" name="subscribe" value="' . __('Subscribe', INCEPTIO_THEME_NAME) . '">';
        echo '</form>';

        echo $after_widget; //defined by themes

        echo "<script type=\"text/javascript\">
                if(!document['formsSettings']){
                    document['formsSettings'] = [];
                }
                document['formsSettings'].push({
                    action: 'process_newsletter_subscription',
                    submitButtonId: '" . $submit_button_id . "',
                    successBoxId: '" . $success_box_id . "',
                    errorBoxId: '" . $error_box_id . "'
                });
            </script>\n";
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        $instance['intro'] = $new_instance['intro'];
        $instance['list_id'] = $new_instance['list_id'];
        return $instance;
    }

    function form($instance)
    {
        $defaults = array(
            'title' => __('Newsletter', INCEPTIO_THEME_NAME),
            'intro' => '',
            'list_id' => '',
        );
        $instance = wp_parse_args((array)$instance, $defaults);

        $this->print_text_field($instance, 'title', __('Title', INCEPTIO_THEME_NAME));
        $this->print_text_field($instance, 'intro', __('Intro Text', INCEPTIO_THEME_NAME));
        $this->print_text_field($instance, 'list_id', __('List ID', INCEPTIO_THEME_NAME));
    }
}