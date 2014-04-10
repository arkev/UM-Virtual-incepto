<?php $post_format = get_post_format(); ?>
<?php if ($post_format == 'gallery'){ ?>
<?php if (inc_has_page_slider()) { ?>
    <!-- begin entry slider -->
    <div class="entry-slider">
        <?php echo Page_Media_Manager::render_page_slider(); ?>
    </div>
    <!-- end entry slider -->
    <?php } ?>
<?php } elseif ($post_format == 'video'){ ?>
<?php if (inc_has_page_video()) { ?>
    <div class="entry-video">
        <?php echo Page_Media_Manager::render_page_video(); ?>
    </div>
    <?php } ?>
<?php } else { ?>
<?php if (has_post_thumbnail()){ ?>
    <?php $thumbnail_id = get_post_thumbnail_id();
        echo Page_Media_Manager::render_page_image($thumbnail_id); ?>
    <?php }; ?>
<?php }; ?>