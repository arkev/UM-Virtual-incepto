<?php

class Inc_Shortcode_Eval_Widget extends Abstract_Inc_Widget
{
    function __construct()
    {
        $widget_ops = array('classname' => 'Inc_Shortcode_Eval_Widget', 'description' => __('Shortcode Evaluator Widget', INCEPTIO_THEME_NAME));
        $this->WP_Widget(Abstract_Inc_Widget::$SHORTCODE_EVALUATOR, '[Inceptio] ' . __('Shortcode Evaluator', INCEPTIO_THEME_NAME), $widget_ops);
    }

    function widget($args, $instance)
    {
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);
        $sc = $instance['sc'];

        echo $before_widget;
        if ($title) {
            echo $before_title . $title . $after_title;
        }

        if (!empty($intro)) {
            echo '<p>' . $intro . '</p>';
        }

        echo do_shortcode($sc);
        echo $after_widget; //defined by themes
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        $instance['sc'] = $new_instance['sc'];
        return $instance;
    }

    function form($instance)
    {
        $defaults = array(
            'title' => '',
            'sc' => ''
        );
        $instance = wp_parse_args((array)$instance, $defaults);

        $this->print_text_field($instance, 'title', __('Title', INCEPTIO_THEME_NAME));
        $this->print_textarea_field($instance, 'sc', __('Shortcode', INCEPTIO_THEME_NAME));
    }
}