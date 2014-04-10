<?php get_header(); ?>

<?php get_template_part('page-title'); ?>

<?php while ( have_posts() ) { the_post(); $page_sidebar = inc_get_page_sidebar();?>
<!-- begin content -->
<section id="content">
    <div class="container clearfix">
    <!-- begin main content -->
    <section id="main" class="blog-entry-list<?php if($page_sidebar !== INCEPTIO_SIDEBAR_NONE){ ?> three-fourths<?php } ?>">
    <?php get_template_part('posts-navigation'); ?>

    <?php $blog_page_content = apply_filters('inc_blog_page_content', 'content-single'); ?>
    <?php get_template_part($blog_page_content); ?>

    <?php if(inc_is_display_blog_related_posts_enabled()){ ?>
    <?php $query_args = inc_get_related_taxonomies_query_args();
        if($query_args){
            $query = new wp_query($query_args);
            if ($query->have_posts()) { ?>
    <!-- begin related posts -->
    <section class="related-posts-wrap">
        <h3><?php _e('Related Posts', INCEPTIO_THEME_NAME); ?></h3>
        <ul class="square">
            <?php while ( $query->have_posts() ) { $query->the_post(); ?>
            <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
            <?php } ?>
        </ul>
    </section>
    <!-- end related posts -->
    <?php } wp_reset_query(); ?>
    <?php } ?>
    <?php } ?>

    <!-- begin comments -->
    <?php comments_template('', true); ?>
    <!-- end comments -->
    </section>
    <!-- end main content -->

    <?php if($page_sidebar !== INCEPTIO_SIDEBAR_NONE){ ?>
    <!-- begin sidebar -->
    <?php get_sidebar(); ?>
    <!-- end sidebar -->
    <?php } ?>
    </div>
</section>
<!-- end content -->
<?php } ?>

<?php get_footer(); ?>