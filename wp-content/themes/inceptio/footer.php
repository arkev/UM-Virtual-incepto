<!-- begin footer -->
<footer id="footer">

    <?php if ( inc_has_footer_featured() ) {?>
    <?php get_footer('featured'); ?>
    <?php } ?>

    <!-- begin footer top -->
    <?php if ( function_exists('dynamic_sidebar') && is_active_sidebar(INCEPTIO_SIDEBAR_FOOTER) ) {?>
    <div id="footer-top">
        <div class="container clearfix">
            <?php if ( dynamic_sidebar(INCEPTIO_SIDEBAR_FOOTER) ) {?>
            <?php } ?>
        </div>
    </div>
    <?php } ?>
    <!-- end footer top -->

    <?php get_footer('bottom'); ?>
</footer>
<!-- end footer -->
</div>
<!-- end container -->

<?php
    $twitter_js_keys = array('msg1' => __('about {p1} days ago', INCEPTIO_THEME_NAME),
        'msg2' => __('about a day ago', INCEPTIO_THEME_NAME),
        'msg3' => __('about {p1} hours ago', INCEPTIO_THEME_NAME),
        'msg4' => __('about an hour ago', INCEPTIO_THEME_NAME),
        'msg5' => __('about {p1} minutes ago', INCEPTIO_THEME_NAME),
        'msg6' => __('about {p1} seconds ago', INCEPTIO_THEME_NAME),
        'msg7' => __('just now', INCEPTIO_THEME_NAME),
    );

    $shortcodes_settings = apply_filters('inc_shortcodes_settings', array(
        'iconbox_same_height' => 'false',
        'portfolio_items_same_height' => 'false'
    ));

    echo '<script type="text/javascript">';

    echo "document.incTweetJSKeys = {";
    foreach($twitter_js_keys as $key => $val){
        $val = str_replace('\'', '\\\'', $val);
        echo "'$key': '$val',\n";
    }
    echo "'msg100': ''\n};";

    echo "\ndocument.incShortcodesSettings = {
            'sameIconBoxHeight': ".$shortcodes_settings['iconbox_same_height'].",
            'samePortfolioItemsHeight': ".$shortcodes_settings['portfolio_items_same_height']."
          };";

    echo '</script>';
?>
<?php echo inc_get_footer_tracking_code(); ?>
<?php wp_footer(); ?>
<script src="/bower_components/iframe-resizer/js/iframeResizer.min.js"></script>

<!-- Google Code para etiquetas de remarketing -->
<script type="text/javascript">
/* <![CDATA[ */
var google_conversion_id = 957296960;
var google_custom_params = window.google_tag_params;
var google_remarketing_only = true;
/* ]]> */
</script>
<script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/957296960/?value=0&amp;guid=ON&amp;script=0"/>
</div>
</noscript>

</body>
</html>