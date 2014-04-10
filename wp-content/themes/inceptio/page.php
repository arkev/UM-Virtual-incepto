<?php get_header(); ?>

<?php if ( have_posts() ) while ( have_posts() ) { the_post(); ?>

<?php get_template_part('page-header'); ?>

<!-- begin content -->
<section id="content">
    <?php get_template_part('content-featured'); ?>

    <div class="container clearfix">
        <!-- begin main content -->
        <section id="main" class="three-fourths">
            <?php $post = get_post(); if(empty($post->post_content)) {echo '<p>&nbsp;</p>';} else {the_content();} ?>

            <!-- begin comments -->
            <?php comments_template('', true); ?>
            <!-- end comments -->
        </section>
        <!-- end main content -->

        <!-- begin sidebar -->
        <?php get_sidebar(); ?>
        <!-- end sidebar -->
    </div>
</section>
<!-- end content -->
<?php }?>

<?php get_footer(); ?>