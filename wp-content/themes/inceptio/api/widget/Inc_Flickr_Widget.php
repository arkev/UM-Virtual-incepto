<?php


class Inc_Flickr_Widget extends Abstract_Inc_Widget
{
    function __construct()
    {
        $widget_ops = array('classname' => 'Inc_Flickr_Widget', 'description' => __('Displays the latest pictures from a Flickr account.', INCEPTIO_THEME_NAME));
        $this->WP_Widget(Abstract_Inc_Widget::$FLICKR_WIDGET, '[Inceptio] ' . __('Flickr Photostream', INCEPTIO_THEME_NAME), $widget_ops);
    }

    function widget($args, $instance)
    {
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);
        $pictures_count = $instance['pictures_count'];
        $flickr_id = inc_get_sn_data(OPTION_SN_FLICKR_ID);

        echo str_replace('widget', 'widget flickr-widget', $before_widget);
        if ($title) {
            echo $before_title . $title . $after_title;
        }
        echo '<ul class="flickr-feed clearfix"></ul>';
        echo "<script type=\"text/javascript\">
            if(!document['flickrSettings']){
                document['flickrSettings'] = {id: '$flickr_id', limit: $pictures_count};
            }
		</script>";
        echo $after_widget; //defined by themes
    }

    function update($new_instance, $old_instance)
    {
        $instance = $old_instance;
        $instance['title'] = $new_instance['title'];
        $instance['pictures_count'] = intval($new_instance['pictures_count']);
        return $instance;
    }

    function form($instance)
    {
        $defaults = array(
            'title' => '',
            'pictures_count' => '6'
        );
        $instance = wp_parse_args((array)$instance, $defaults);
        $id_label = 'ID (<a href="' . site_url() . '/wp-admin/themes.php?page=inc-theme-options&amp;tab=social-settings&amp;expand=configuration" target="_blank">Change</a>)';
        $this->print_info_field($id_label, inc_get_sn_data(OPTION_SN_FLICKR_ID));
        $this->print_text_field($instance, 'title', __('Title', INCEPTIO_THEME_NAME));
        $this->print_text_field($instance, 'pictures_count', __('The number of pictures', INCEPTIO_THEME_NAME));
    }
}