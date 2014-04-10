<?php get_template_part('page-title'); ?>

<?php if(!inc_is_blog_set_as_home_page() && !is_404() && !is_search()) { ?>
    <?php
    add_filter('inc_flex_slider_settings', 'inc_page_flex_slider_settings');
    function inc_page_flex_slider_settings($slider_settings){
        $container_class = $slider_settings['container_class'];
        if(inc_contains_string($container_class, 'container')){
            $img_size = 'inc-home-slider';
        }else{
            $img_size = apply_filters('inc_flex_slider_wide_layout_img_size', 'full');
        }
        return array_merge($slider_settings, array('img_size' => $img_size));
    } ?>
<?php $real_post_id = get_real_post_ID(); if (inc_has_page_slider()) { ?>
<!-- begin slider -->
<section id="slider-home">
    <?php echo Page_Media_Manager::render_page_slider(); ?>
</section>
<!-- end slider -->
<?php } elseif(isset($real_post_id) && has_post_thumbnail($real_post_id)) { ?>
<section class="container clearfix">
    <div class="entry-image">
        <?php the_post_thumbnail($real_post_id); ?>
    </div>
</section>
<?php } ?>
<?php } ?>
