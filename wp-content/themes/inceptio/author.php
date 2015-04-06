<?php get_header(); ?>
<?php
add_filter('the_title', 'inc_posts_author_title');
if (!function_exists('inc_posts_author_title')) {
    function inc_posts_author_title()
    {
        return sprintf(__('Author Archives: %s', INCEPTIO_THEME_NAME), get_the_author() );
    }
}
?>

<?php get_template_part('page-title'); ?>
<?php remove_filter('the_title', 'inc_posts_author_title'); ?>

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
                <?php }else { ?>
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