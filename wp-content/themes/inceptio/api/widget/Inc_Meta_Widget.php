<?php

class Inc_Meta_Widget extends WP_Widget_Meta
{
    function __construct() {
        parent::__construct();
    }

    function widget($args, $instance)
    {
        extract($args);
        $title = apply_filters('widget_title', empty($instance['title']) ? __('Meta', INCEPTIO_THEME_NAME) : $instance['title'], $instance, $this->id_base);

        echo $before_widget;
        if ( $title )
            echo $before_title . $title . $after_title;
        ?>
    <ul class="menu">
        <?php wp_register(); ?>
        <li><?php wp_loginout(); ?></li>
        <li><a href="<?php bloginfo('rss2_url'); ?>" title="<?php echo esc_attr(__('Syndicate this site using RSS 2.0', INCEPTIO_THEME_NAME)); ?>"><?php _e('Entries <abbr title="Really Simple Syndication">RSS</abbr>', INCEPTIO_THEME_NAME); ?></a></li>
        <li><a href="<?php bloginfo('comments_rss2_url'); ?>" title="<?php echo esc_attr(__('The latest comments to all posts in RSS', INCEPTIO_THEME_NAME)); ?>"><?php _e('Comments <abbr title="Really Simple Syndication">RSS</abbr>', INCEPTIO_THEME_NAME); ?></a></li>
        <li><a href="<?php esc_attr_e( 'http://wordpress.org/' ); ?>" title="<?php echo esc_attr(__('Powered by WordPress, state-of-the-art semantic personal publishing platform.', INCEPTIO_THEME_NAME)); ?>"><?php echo 'WordPress.org'; ?></a></li>
        <?php wp_meta(); ?>
    </ul>
    <?php
        echo $after_widget;
    }
}
