<!-- begin footer featured -->
<?php $footerFeaturedContent = inc_get_footer_featured_content(); ?>
<?php if ($footerFeaturedContent) { ?>
    <?php echo $footerFeaturedContent; ?>
<?php } else { ?>
<?php $footerFeaturedTitle = inc_get_footer_featured_title(); $footerFeaturedBody = inc_get_footer_featured_body();?>
<div id="footer-featured">
    <div class="container clearfix">
        <div class="three-fourths">
            <?php if ($footerFeaturedTitle) { ?>
                <h1><?php echo do_shortcode($footerFeaturedTitle); ?></h1>
            <?php } ?>
            <?php if ($footerFeaturedBody) { ?>
                <p><?php echo do_shortcode($footerFeaturedBody); ?></p>
            <?php } ?>
        </div>
        <div class="one-fourth column-last">
            <a class="entry-image" href="<?php echo inc_get_footer_featured_url(); ?>" title=""><img src="<?php echo inc_get_footer_featured_icon(); ?>" alt="Mail"></a>
        </div>
    </div>
</div>
<?php } ?>
<!-- end footer featured -->