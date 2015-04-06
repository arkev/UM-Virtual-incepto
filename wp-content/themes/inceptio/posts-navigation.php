<?php $current_post_type = get_post_type();
$post_navigation = inc_is_display_blog_navigation_enabled();
$portfolio_navigation = inc_is_display_portfolio_navigation_enabled();

if(($current_post_type == 'post' && $post_navigation) || ($current_post_type == 'portfolio' && $portfolio_navigation)){
$next_post_link = get_adjacent_post_rel_link('%title', false, '', false);
$prev_post_link = get_adjacent_post_rel_link('%title', false, '', true); ?>
<?php if(!empty($next_post_link) || !empty($prev_post_link)){ ?>
<!-- begin pagination -->
<nav class="page-nav prev-next">
    <ul>
        <li><?php previous_post_link('%link', __('&lsaquo; Previous', INCEPTIO_THEME_NAME)); ?></li>
        <li><?php next_post_link('%link', __('Next &rsaquo;', INCEPTIO_THEME_NAME)); ?></li>
    </ul>
</nav>
<!-- end pagination -->
<?php } ?>
<?php } ?>