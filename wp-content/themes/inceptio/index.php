<?php get_header(); ?>

<?php
add_filter('the_title', 'inc_posts_title');
if (!function_exists('inc_posts_title')) {
    function inc_posts_title()
    {
        return __('Blog', INCEPTIO_THEME_NAME);
    }
}

add_filter('inc_flex_slider_settings', 'inc_posts_overview_flex_slider_settings');
if (!function_exists('inc_posts_overview_flex_slider_settings')) {
    function inc_posts_overview_flex_slider_settings($slider_settings){
        return array_merge($slider_settings, array(
            'img_size' => 'inc-blog-post-sidebar',
            'link' => 'inherited'));
    }
}

add_filter('inc_page_image_settings', 'inc_posts_overview_image_settings');
if (!function_exists('inc_posts_overview_image_settings')) {
    function inc_posts_overview_image_settings($img_settings){
        return array_merge($img_settings, array(
            'img_size' => 'inc-blog-post-sidebar',
            'img_link' => 'inherited'));
    }
}
?>
<?php get_template_part('page-header'); ?>
<?php remove_filter('the_title', 'inc_posts_title'); ?>

    <!-- begin content -->
    <section id="content">
        <div class="container clearfix">
            <!-- begin main content -->
            <section id="main" class="blog-entry-list three-fourths">
            <?php if ( have_posts() ) { ?>
                <?php
                if (get_query_var('paged')) {
                    $paged = get_query_var('paged');
                } elseif (get_query_var('page')) {
                    $paged = get_query_var('page');
                } else {
                    $paged = 1;
                }
                $query_args = apply_filters('inc_post_overview_query_args', array('post_type' => 'post', 'paged' => $paged ));
                query_posts($query_args); ?>

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