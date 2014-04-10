<?php

class Inc_Recent_Posts_Widget extends WP_Widget_Recent_Posts
{
    function __construct() {
        parent::__construct();
    }

    function widget($args, $instance)
    {
        $cache = wp_cache_get('widget_recent_posts', 'widget');

        if ( !is_array($cache) )
            $cache = array();

        if ( ! isset( $args['widget_id'] ) )
            $args['widget_id'] = $this->id;

        if ( isset( $cache[ $args['widget_id'] ] ) ) {
            echo $cache[ $args['widget_id'] ];
            return;
        }

        ob_start();
        extract($args);

        $title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Posts', INCEPTIO_THEME_NAME) : $instance['title'], $instance, $this->id_base);
        if ( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
            $number = 10;
        $show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

        $r = new WP_Query( apply_filters( 'widget_posts_args', array( 'posts_per_page' => $number, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true ) ) );
        if ($r->have_posts()) :
            ?>
        <?php echo $before_widget; ?>
        <?php if ( $title ) echo $before_title . $title . $after_title; ?>
        <ul class="menu">
            <?php while ( $r->have_posts() ) : $r->the_post(); ?>
            <li>
                <a href="<?php the_permalink() ?>" title="<?php echo esc_attr( get_the_title() ? get_the_title() : get_the_ID() ); ?>"><?php if ( get_the_title() ) the_title(); else the_ID(); ?></a>
                <?php if ( $show_date ) : ?>
                <span class="post-date"><?php echo get_the_time(get_option('date_format')); ?></span>
                <?php endif; ?>
            </li>
            <?php endwhile; ?>
        </ul>
        <?php echo $after_widget; ?>
        <?php
            // Reset the global $the_post as this query will have stomped on it
            wp_reset_postdata();

        endif;

        $cache[$args['widget_id']] = ob_get_flush();
        wp_cache_set('widget_recent_posts', $cache, 'widget');
    }
}
