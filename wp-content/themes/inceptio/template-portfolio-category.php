<?php get_header(); ?>
<?php
add_filter('the_title', 'inc_portfolio_category_title');
if (!function_exists('inc_portfolio_category_title')) {
    function inc_portfolio_category_title()
    {
        return sprintf(__('Portfolio Category: %s', INCEPTIO_THEME_NAME), single_term_title( '', false ) );
    }
}
?>

<?php get_template_part('page-title'); ?>
<?php remove_filter('the_title', 'inc_portfolio_category_title'); ?>

    <!-- begin content -->
    <section id="content">
        <div class="container clearfix">
            <!-- begin main content -->
            <section id="main" class="blog-entry-list three-fourths">
                <?php if ( have_posts() ) { ?>

                    <?php $blog_content = apply_filters('inc_portfolio_content', 'content'); ?>

                    <?php while ( have_posts() ) { the_post(); ?>
                        <?php get_template_part($blog_content); ?>
                    <?php } ?>

                    <!-- begin pagination -->
                    <?php inc_pagination($wp_query->max_num_pages); wp_reset_query(); ?>
                    <!-- end pagination -->
                <?php } else { ?>
                    <h1><?php _e('No portfolios found', INCEPTIO_THEME_NAME); ?></h1>
                <?php } ?>
            </section>
            <!-- end main content -->

            <!-- begin sidebar -->
            <?php get_sidebar('portfolio-category'); ?>
            <!-- end sidebar -->
        </div>
    </section>
    <!-- end content -->

<?php get_footer(); ?>