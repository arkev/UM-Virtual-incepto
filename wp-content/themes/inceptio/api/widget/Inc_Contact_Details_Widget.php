<?php


class Inc_Contact_Details_Widget extends Abstract_Inc_Widget
{
    function __construct()
    {
        $widget_ops = array('classname' => 'Inc_Contact_Details_Widget', 'description' => __('A simple widget which allows you to edit your contact details.', INCEPTIO_THEME_NAME));
        $this->WP_Widget(Abstract_Inc_Widget::$CONTACT_DETAILS_WIDGET, '[Inceptio] ' . __('Contact Info', INCEPTIO_THEME_NAME), $widget_ops);
    }

    function widget($args, $instance)
    {
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);
        $sync = (array_key_exists('sync', $instance)) ? $instance['sync'] : 'on';
        if ($sync == 'on') {
            $address = inc_get_contact_details(OPTION_CONTACT_ADDRESS);
            $phone = inc_get_contact_details(OPTION_CONTACT_PHONE);
            $mobile = inc_get_contact_details(OPTION_CONTACT_MOBILE);
            $fax = inc_get_contact_details(OPTION_CONTACT_FAX);
            $email = inc_get_contact_details(OPTION_CONTACT_EMAIL);
        } else {
            $address = $instance['address'];
            $phone = $instance['phone'];
            $mobile = $instance['mobile'];
            $fax = isset($instance['fax']) ? $instance['fax'] : '';
            $email = $instance['email'];
        }
        $timetable = $instance['timetable'];

        echo str_replace('widget', 'widget contact-info', $before_widget);
        if ($title) {
            echo $before_title . $title . $after_title;
        }
        echo "<div>\n";
        echo '<p class="address"><strong>' . __('Address', INCEPTIO_THEME_NAME) . ':</strong> ' . $address . '</p>' . "\n";
        if (isset($phone) && !empty($phone)) {
            echo '<p class="phone"><strong>' . __('Phone', INCEPTIO_THEME_NAME) . ':</strong> ' . $phone . '</p>' . "\n";
        }
        if (isset($mobile) && !empty($mobile)) {
            echo '<p class="mobile"><strong>' . __('Mobile', INCEPTIO_THEME_NAME) . ':</strong> ' . $mobile . '</p>' . "\n";
        }
        if (isset($fax) && !empty($fax)) {
            echo '<p class="fax"><strong>' . __('Fax', INCEPTIO_THEME_NAME) . ':</strong> ' . $fax . '</p>' . "\n";
        }
        if (isset($email) && !empty($email)) {
            echo '<p class="email"><strong>' . __('Email', INCEPTIO_THEME_NAME) . ':</strong> <a href="mailto:' . $email . '">' . $email . '</a></p>' . "\n";
        }
        if (isset($timetable) && !empty($timetable)) {
            echo '<p class="business-hours"><strong>' . __('Business Hours', INCEPTIO_THEME_NAME) . ':</strong>' . ' <br>' . "\n";
            echo str_replace(array("\r\n", "\r", "\n", "\\r", "\\n", "\\r\\n"), "<br/>", $timetable) . "\n";
            echo '</p>' . "\n";
        }
        echo "</div>\n";
        echo $after_widget; //defined by themes
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['sync'] = $new_instance['sync'];
        $instance['title'] = $new_instance['title'];
        $instance['address'] = $new_instance['address'];
        $instance['phone'] = $new_instance['phone'];
        $instance['mobile'] = $new_instance['mobile'];
        $instance['fax'] = $new_instance['fax'];
        $instance['email'] = $new_instance['email'];
        $instance['timetable'] = $new_instance['timetable'];
        return $instance;
    }

    function form($instance)
    {
        $defaults = array(
            'title' => __('Contact Info', INCEPTIO_THEME_NAME),
            'sync' => 'on',
            'address' => inc_get_contact_details(OPTION_CONTACT_ADDRESS),
            'phone' => inc_get_contact_details(OPTION_CONTACT_PHONE),
            'mobile' => inc_get_contact_details(OPTION_CONTACT_MOBILE),
            'email' => inc_get_contact_details(OPTION_CONTACT_EMAIL),
            'fax' => inc_get_contact_details(OPTION_CONTACT_FAX),
            'timetable' => '',
        );
        $instance = wp_parse_args((array)$instance, $defaults);

        $this->print_checkbox_field($instance, 'sync', __('Use the contacts details in Theme Options', INCEPTIO_THEME_NAME));
        $this->print_text_field($instance, 'title', __('Title', INCEPTIO_THEME_NAME));
        $this->print_text_field($instance, 'address', __('Address', INCEPTIO_THEME_NAME));
        $this->print_text_field($instance, 'phone', __('Phone Number', INCEPTIO_THEME_NAME));
        $this->print_text_field($instance, 'mobile', __('Mobile Number', INCEPTIO_THEME_NAME));
        $this->print_text_field($instance, 'fax', __('Fax Number', INCEPTIO_THEME_NAME));
        $this->print_text_field($instance, 'email', __('Email Address', INCEPTIO_THEME_NAME));
        $this->print_textarea_field($instance, 'timetable', __('Timetable', INCEPTIO_THEME_NAME));
    }
}