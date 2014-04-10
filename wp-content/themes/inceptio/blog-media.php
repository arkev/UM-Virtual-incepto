<?php

add_filter('inc_flex_slider_settings', 'inc_blog_flex_slider_settings');
if (!function_exists('inc_blog_flex_slider_settings')) {
    function inc_blog_flex_slider_settings($slider_settings){
        $page_sidebar = inc_get_page_sidebar();
        $img_size = ($page_sidebar == INCEPTIO_SIDEBAR_NONE)? 'inc-portfolio-full' : 'inc-blog-post-sidebar';
        return array_merge($slider_settings, array('img_size' => $img_size));
    }
}

add_filter('inc_page_image_settings', 'inc_blog_image_settings');
if (!function_exists('inc_blog_image_settings')) {
    function inc_blog_image_settings($img_settings){
        $page_sidebar = inc_get_page_sidebar();
        $img_size = ($page_sidebar == INCEPTIO_SIDEBAR_NONE)? 'inc-portfolio-full' : 'inc-blog-post-sidebar';
        return array_merge($img_settings, array('img_size' => $img_size));
    }
}
?>

<?php $post_format = get_post_format(); ?>
<?php if ($post_format == 'gallery'){ ?>
<?php if (inc_has_page_slider()) { ?>
    <!-- begin entry slider -->
    <div class="entry-slider">
        <?php echo Page_Media_Manager::render_page_slider(); ?>
    </div>
    <!-- end entry slider -->
    <?php } ?>
<?php }elseif ($post_format == 'video'){ ?>
<?php if (inc_has_page_video()) { ?>
    <div class="entry-video">
        <?php echo Page_Media_Manager::render_page_video(); ?>
    </div>
    <?php } ?>
<?php } else { ?>
<?php if (has_post_thumbnail()) { ?>
    <?php $thumbnail_id = get_post_thumbnail_id();
        echo Page_Media_Manager::render_page_image($thumbnail_id); ?>
    <?php } ?>
<?php } ?>