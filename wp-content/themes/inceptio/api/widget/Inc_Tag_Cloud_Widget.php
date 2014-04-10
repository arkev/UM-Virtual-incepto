<?php

class Inc_Tag_Cloud_Widget extends WP_Widget_Tag_Cloud
{

    function __construct()
    {
        parent::__construct();
    }

    function widget($args, $instance)
    {
        extract($args);
        $current_taxonomy = $this->_get_current_taxonomy($instance);
        if (!empty($instance['title'])) {
            $title = $instance['title'];
        } else {
            if ('post_tag' == $current_taxonomy) {
                $title = __('Tags', INCEPTIO_THEME_NAME);
            } else {
                $tax = get_taxonomy($current_taxonomy);
                $title = $tax->labels->name;
            }
        }
        $title = apply_filters('widget_title', $title, $instance, $this->id_base);

        echo $before_widget;
        if ($title)
            echo $before_title . $title . $after_title;
        echo '<ul class="tags clearfix">';
        $this->wp_tag_cloud_item(apply_filters('widget_tag_cloud_args', array('taxonomy' => $current_taxonomy)));
        echo "</ul>\n";
        echo $after_widget;
    }

    private function wp_tag_cloud_item($args = '')
    {
        $return = '';
        $defaults = array(
            'smallest' => 8, 'largest' => 22, 'unit' => 'pt', 'number' => 45,
            'format' => 'flat', 'separator' => "\n", 'orderby' => 'name', 'order' => 'ASC',
            'exclude' => '', 'include' => '', 'link' => 'view', 'taxonomy' => 'post_tag', 'echo' => true
        );
        $args = wp_parse_args($args, $defaults);

        $tags = get_terms($args['taxonomy'], array_merge($args, array('orderby' => 'count', 'order' => 'DESC'))); // Always query top tags

        if (empty($tags) || is_wp_error($tags))
            return;

        foreach ($tags as $key => $tag) {
            if ('edit' == $args['link'])
                $link = get_edit_tag_link($tag->term_id, $tag->taxonomy);
            else
                $link = get_term_link(intval($tag->term_id), $tag->taxonomy);
            if (is_wp_error($link))
                return false;

            $tags[$key]->link = $link;
            $tags[$key]->id = $tag->term_id;
            $return .= '<li><a href="' . $tags[$key]->link . '">' . $tags[$key]->name . '</a></li>';
        }
        echo $return;
    }
}