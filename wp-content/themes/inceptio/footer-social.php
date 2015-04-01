<?php if(inc_is_display_sn_icons_in_footer_enabled()) {?>
<a href="http://www.um.edu.mx"><img src="/wp-content/themes/inceptio/images/um.png" alt="um" id="UM-Logo"></a>
<ul class="social-links">
    <?php if(inc_get_sn_data(OPTION_SN_TWITTER_USERNAME)) {?>
    <li class="<?php echo inc_get_footer_sn_class('twitter'); ?>"><a href="https://twitter.com/#!/<?php echo inc_get_sn_data(OPTION_SN_TWITTER_USERNAME); ?>" title="<?php _e('Twitter', INCEPTIO_THEME_NAME) ?>" target="_blank"><?php _e('Twitter', INCEPTIO_THEME_NAME) ?></a></li>
    <?php } ?>
    <?php if(inc_get_sn_data(OPTION_SN_FACEBOOK_URL)) { ?>
    <li class="<?php echo inc_get_footer_sn_class('facebook'); ?>"><a href="<?php echo inc_get_sn_data(OPTION_SN_FACEBOOK_URL); ?>" title="<?php _e('Facebook', INCEPTIO_THEME_NAME) ?>" target="_blank"><?php _e('Facebook', INCEPTIO_THEME_NAME) ?></a></li>
    <?php } ?>
    <?php if(inc_get_sn_data(OPTION_SN_GPLUS_URL)) { ?>
    <li class="<?php echo inc_get_footer_sn_class('google-plus'); ?>"><a href="<?php echo inc_get_sn_data(OPTION_SN_GPLUS_URL); ?>" title="<?php _e('Google+', INCEPTIO_THEME_NAME) ?>" target="_blank"><?php _e('Google+', INCEPTIO_THEME_NAME) ?></a></li>
    <?php } ?>
    <?php if(inc_get_sn_data(OPTION_SN_LINKEDIN_URL)) { ?>
    <li class="<?php echo inc_get_footer_sn_class('linkedin'); ?>"><a href="<?php echo inc_get_sn_data(OPTION_SN_LINKEDIN_URL); ?>" title="<?php _e('LinkedIn', INCEPTIO_THEME_NAME) ?>" target="_blank"><?php _e('LinkedIn', INCEPTIO_THEME_NAME) ?></a></li>
    <?php } ?>
    <?php if(inc_get_sn_data(OPTION_SN_VIMEO_URL)) { ?>
    <li class="<?php echo inc_get_footer_sn_class('vimeo'); ?>"><a href="<?php echo inc_get_sn_data(OPTION_SN_VIMEO_URL); ?>" title="<?php _e('Vimeo', INCEPTIO_THEME_NAME) ?>" target="_blank"><?php _e('Vimeo', INCEPTIO_THEME_NAME) ?></a></li>
    <?php } ?>
    <?php if(inc_get_sn_data(OPTION_SN_YOUTUBE_URL)) { ?>
    <li class="<?php echo inc_get_footer_sn_class('youtube'); ?>"><a href="<?php echo inc_get_sn_data(OPTION_SN_YOUTUBE_URL); ?>" title="<?php _e('YouTube', INCEPTIO_THEME_NAME) ?>" target="_blank"><?php _e('YouTube', INCEPTIO_THEME_NAME) ?></a></li>
    <?php } ?>
    <?php if(inc_get_sn_data(OPTION_SN_SKYPE_URL)) { ?>
    <li class="<?php echo inc_get_footer_sn_class('skype'); ?>"><a href="<?php echo inc_get_sn_data(OPTION_SN_SKYPE_URL); ?>" title="<?php _e('Skype', INCEPTIO_THEME_NAME) ?>" target="_blank"><?php _e('Skype', INCEPTIO_THEME_NAME) ?></a></li>
    <?php } ?>
    <?php if(inc_get_sn_data(OPTION_SN_DIGG_URL)) { ?>
    <li class="<?php echo inc_get_footer_sn_class('digg'); ?>"><a href="<?php echo inc_get_sn_data(OPTION_SN_DIGG_URL); ?>" title="<?php _e('Digg', INCEPTIO_THEME_NAME) ?>" target="_blank"><?php _e('Digg', INCEPTIO_THEME_NAME) ?></a></li>
    <?php } ?>
    <?php if(inc_get_sn_data(OPTION_SN_DELICIOUS_URL)) { ?>
    <li class="<?php echo inc_get_footer_sn_class('delicious'); ?>"><a href="<?php echo inc_get_sn_data(OPTION_SN_DELICIOUS_URL); ?>" title="<?php _e('Delicious', INCEPTIO_THEME_NAME) ?>" target="_blank"><?php _e('Delicious', INCEPTIO_THEME_NAME) ?></a></li>
    <?php } ?>
    <?php if(inc_get_sn_data(OPTION_SN_TUMBLR_URL)) { ?>
    <li class="<?php echo inc_get_footer_sn_class('tumbler'); ?>"><a href="<?php echo inc_get_sn_data(OPTION_SN_TUMBLR_URL); ?>" title="<?php _e('Tumbler', INCEPTIO_THEME_NAME) ?>" target="_blank"><?php _e('Tumbler', INCEPTIO_THEME_NAME) ?></a></li>
    <?php } ?>
    <?php if(inc_get_sn_data(OPTION_SN_DRIBBBLE_URL)) { ?>
    <li class="<?php echo inc_get_footer_sn_class('dribbble'); ?>"><a href="<?php echo inc_get_sn_data(OPTION_SN_DRIBBBLE_URL); ?>" title="<?php _e('Dribbble', INCEPTIO_THEME_NAME) ?>" target="_blank"><?php _e('Dribbble', INCEPTIO_THEME_NAME) ?></a></li>
    <?php } ?>
    <?php if(inc_get_sn_data(OPTION_SN_STUMBLEUPON_URL)) { ?>
    <li class="<?php echo inc_get_footer_sn_class('stumbleupon'); ?>"><a href="<?php echo inc_get_sn_data(OPTION_SN_STUMBLEUPON_URL); ?>" title="<?php _e('StumbleUpon', INCEPTIO_THEME_NAME) ?>" target="_blank"><?php _e('StumbleUpon', INCEPTIO_THEME_NAME) ?></a></li>
    <?php } ?>
    <?php if(inc_is_rss_enabled()) { ?>
    <li class="<?php echo inc_get_footer_sn_class('rss'); ?>"><a href="<?php echo inc_get_rss_url(); ?>" title="<?php _e('RSS', INCEPTIO_THEME_NAME) ?>" target="_blank"><?php _e('RSS', INCEPTIO_THEME_NAME) ?></a></li>
    <?php } ?>
</ul>
<?php } ?>