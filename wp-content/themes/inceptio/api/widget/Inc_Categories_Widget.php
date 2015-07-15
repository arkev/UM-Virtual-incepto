<?php


class Inc_Categories_Widget extends WP_Widget_Categories
{
    function __construct() {
        parent::__construct();
    }

    function widget($args, $instance)
    {
        extract($args);

        $title = apply_filters('widget_title', empty($instance['title']) ? __('Categories', INCEPTIO_THEME_NAME) : $instance['title'], $instance, $this->id_base);
        $taxonomy = $this->get_taxonomy($instance);
        $c = !empty($instance['count']) ? '1' : '0';
        $h = !empty($instance['hierarchical']) ? '1' : '0';
        $d = !empty($instance['dropdown']) ? '1' : '0';

        echo $before_widget;
        if ($title) {
            echo $before_title . $title . $after_title;
        }

        $cat_args = array('orderby' => 'name', 'show_count' => $c, 'hierarchical' => $h, 'taxonomy' => $taxonomy);
        if ($d) {
            $home_url = home_url();
            $cat_args['show_option_none'] = __('Select Category', INCEPTIO_THEME_NAME);
            wp_dropdown_categories(apply_filters('widget_categories_dropdown_args', $cat_args));
            echo "<script type=\"text/javascript\">
            var dropdown = document.getElementById(\"cat\");
            function onCatChange() {
                if ( dropdown.options[dropdown.selectedIndex].value > 0 ) {
                    location.href = \"$home_url/?cat=\"+dropdown.options[dropdown.selectedIndex].value;
                }
            }
            dropdown.onchange = onCatChange;
        </script>";

        } else {
            echo '<ul class="menu">' . "\n";
            $cat_args['title_li'] = '';
            wp_list_categories(apply_filters('widget_categories_args', $cat_args));
            echo '</ul>' . "\n";
        }
        echo $after_widget;
    }

    function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['taxonomy'] = strip_tags($new_instance['taxonomy']);
        $instance['count'] = !empty($new_instance['count']) ? 1 : 0;
        $instance['hierarchical'] = !empty($new_instance['hierarchical']) ? 1 : 0;
        $instance['dropdown'] = !empty($new_instance['dropdown']) ? 1 : 0;

        return $instance;
    }

    function form( $instance ) {
        //Defaults
        $instance = wp_parse_args( (array) $instance, array( 'title' => '') );
        $title = esc_attr( $instance['title'] );
        $taxonomy = esc_attr( $this->get_taxonomy($instance) );
        $count = isset($instance['count']) ? (bool) $instance['count'] :false;
        $hierarchical = isset( $instance['hierarchical'] ) ? (bool) $instance['hierarchical'] : false;
        $dropdown = isset( $instance['dropdown'] ) ? (bool) $instance['dropdown'] : false;
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></p>

        <p><label for="<?php echo $this->get_field_id('taxonomy'); ?>"><?php _e( 'Taxonomy:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('taxonomy'); ?>" name="<?php echo $this->get_field_name('taxonomy'); ?>" type="text" value="<?php echo $taxonomy; ?>" /></p>

        <p><input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('dropdown'); ?>" name="<?php echo $this->get_field_name('dropdown'); ?>"<?php checked( $dropdown ); ?> />
            <label for="<?php echo $this->get_field_id('dropdown'); ?>"><?php _e( 'Display as dropdown' ); ?></label><br />

            <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>"<?php checked( $count ); ?> />
            <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e( 'Show post counts' ); ?></label><br />

            <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('hierarchical'); ?>" name="<?php echo $this->get_field_name('hierarchical'); ?>"<?php checked( $hierarchical ); ?> />
            <label for="<?php echo $this->get_field_id('hierarchical'); ?>"><?php _e( 'Show hierarchy' ); ?></label></p>
    <?php
    }

    private function get_taxonomy($instance){
        $taxonomy = array_key_exists('taxonomy', $instance)? $instance['taxonomy']: 'category';
        if(empty($taxonomy)){
            $taxonomy = 'category';
        }
        return $taxonomy;
    }

}