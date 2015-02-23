<?php if(inc_is_display_portfolio_related_posts_enabled()){ ?>
<!-- begin related projects -->
<?php $related_posts_config = apply_filters('inc_portfolio_related_projects',
        array('count' => 8,
            'related' => 'true',
            'display_meta' => 'true',
            'tca' => 'link'));
    $related_posts = do_shortcode('[post_gallery count="'.$related_posts_config['count'].'" related="'.$related_posts_config['related'].'" display_mode="carousel" tca="'.$related_posts_config['tca'].'" display_meta="'.$related_posts_config['display_meta'].'" ][/post_gallery]'); ?>
<?php if(!empty($related_posts)){ ?>
<section>
    <h2><?php _e('Related Projects', INCEPTIO_THEME_NAME) ?></h2>
    <!-- begin project carousel -->
    <?php echo $related_posts; ?>
    <!-- end project carousel -->
</section>
<?php } ?>
<!-- end related projects -->
<?php } ?>