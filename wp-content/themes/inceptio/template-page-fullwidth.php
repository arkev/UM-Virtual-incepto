<?php
/**
 * Template Name: Full Width
 */
get_header(); ?>

<?php if ( have_posts() ) while ( have_posts() ) { the_post(); ?>

<?php get_template_part('page-header'); ?>

<!-- begin content -->
<section id="content">
    <?php get_template_part('content-featured'); ?>

    <div class="container clearfix">
        <?php the_content(); ?>

        <?php comments_template('', true); ?>
    </div>
</section>
<!-- end content -->
<?php }?>

<?php get_footer(); ?>