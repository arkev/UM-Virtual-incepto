<?php get_header(); ?>

    <?php get_template_part('page-header'); ?>

    <!-- begin content -->
    <section id="content">
        <div class="container clearfix">
            <!-- begin main content -->
            <h2 class="error-404"><?php _e('The page requested was not found.', INCEPTIO_THEME_NAME) ?></h2>
            <p><?php _e('It seems that the page you were looking for doesn\'t exist.', INCEPTIO_THEME_NAME) ?></p>
            <p><?php _e('Perhaps one of the links below can help.', INCEPTIO_THEME_NAME) ?></p>
            <?php global $simple_menu_walker;
            wp_nav_menu( array(
                'theme_location' => 'primary',
                'container' => '',
                'items_wrap' => '<ul class="square">%3$s</ul>',
                'depth' => '1',
                'walker' => $simple_menu_walker));
            ?>
        </div>
    </section>
    <!-- end content -->

<?php get_footer(); ?>