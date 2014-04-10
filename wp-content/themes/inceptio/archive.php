<?php get_header(); ?>
<?php
add_filter('the_title', 'inc_posts_archive_title');
if (!function_exists('inc_posts_archive_title')) {
    function inc_posts_archive_title()
    {
        if (is_day()) {
            return sprintf (__('Daily Archives: %s', INCEPTIO_THEME_NAME), get_the_time());
        } elseif (is_month()) {
            return sprintf (__('Monthly Archives: %s', INCEPTIO_THEME_NAME), get_the_time(_x('F Y', 'monthly archives date format', INCEPTIO_THEME_NAME)));
        } elseif (is_year()) {
            return sprintf (__('Yearly Archives: %s', INCEPTIO_THEME_NAME), get_the_time(_x('Y', 'yearly archives date format', INCEPTIO_THEME_NAME)));
        } else {
            return __('Blog Archives', INCEPTIO_THEME_NAME);
        }
    }
}

?>
<?php get_template_part('page-title'); ?>
<?php remove_filter('the_title', 'inc_posts_archive_title'); ?>

    <!-- begin content -->
    <section id="content">
        <div class="container clearfix">
            <!-- begin main content -->
            <section id="main" class="blog-entry-list three-fourths">
                <?php if ( have_posts() ) { ?>

                    <?php $blog_content = apply_filters('inc_blog_content', 'content'); ?>

                    <?php while ( have_posts() ) { the_post(); ?>
                        <?php get_template_part($blog_content); ?>
                    <?php } ?>

                    <!-- begin pagination -->
                    <?php inc_pagination($wp_query->max_num_pages); wp_reset_query(); ?>
                    <!-- end pagination -->
                <?php } else { ?>
                    <h1><?php _e('No posts found', INCEPTIO_THEME_NAME); ?></h1>
                <?php } ?>
            </section>
            <!-- end main content -->

            <!-- begin sidebar -->
            <?php get_sidebar(); ?>
            <!-- end sidebar -->
        </div>
    </section>
    <!-- end content -->

<?php get_footer(); ?>