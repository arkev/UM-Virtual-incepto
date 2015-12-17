<?php
/**
 * Template Name: Left Sidebar
 */
get_header(); ?>

<?php if ( have_posts() ) while ( have_posts() ) { the_post(); ?>

<?php get_template_part('page-header'); ?>

<!-- begin content -->
<section id="content">
    <?php get_template_part('content-featured'); ?>

    <div class="container clearfix">
        <!-- begin sidebar -->
        <?php get_sidebar('left'); ?>
        <!-- end sidebar -->

        <!-- begin main content -->
        <section id="main" class="three-fourths column-last">
            <?php the_content(); ?>

            <!-- begin comments -->
            <?php comments_template('', true); ?>
            <!-- end comments -->
        </section>
        <!-- end main content -->
    </div>
</section>
<!-- end content -->
<?php }?>

<?php get_footer(); ?>