<?php
$title_bar_settings = inc_get_title_bar_settings();
if(($title_bar_settings == 'on') || ($title_bar_settings == 'on_home')){
    if(is_front_page() || inc_is_blog_set_as_home_page()){
        $display_page_title_bar = ($title_bar_settings == 'on_home');
    }elseif(is_search() || is_404()){
        $display_page_title_bar = true;
    }else{
        $display_page_title_bar = inc_is_page_title_bar_visible();
    }
}else{
    $display_page_title_bar = false;
}
if ($display_page_title_bar) { ?>
<!-- begin page title -->
<section id="page-title">
    <div class="container clearfix">
        <h1 <?php global $post; if ($post && inc_is_breadcrumb_enabled()) { ?>class="one-half"<?php } ?>>
            <?php if(is_404()) { ?>
                <?php _e('404 Error Page', INCEPTIO_THEME_NAME); ?>
            <?php } elseif(is_search()) { ?>
                <?php _e('Search Results', INCEPTIO_THEME_NAME); ?>
            <?php } else { ?>
                <?php $title = get_the_title(); $title = apply_filters('inc_page_title', $title); echo $title; ?>
            <?php } ?>
        </h1>
        <?php $breadcrumb_template = apply_filters('inc_breadcrumb_template', 'breadcrumb'); get_template_part($breadcrumb_template); ?>
    </div>
</section>
<!-- begin page title -->
<?php } ?>