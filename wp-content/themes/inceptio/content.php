<article id="post-<?php the_ID(); ?>" <?php post_class('entry clearfix') ?>>
    <?php $post_format = get_post_format(); ?>
    <?php if ($post_format == 'gallery') { ?>
        <?php if (inc_has_page_slider()) { ?>
            <!-- begin entry slider -->
            <div class="entry-slider">
                <?php echo Page_Media_Manager::render_page_slider(); ?>
            </div>
            <!-- end entry slider -->
        <?php } ?>
    <?php } elseif ($post_format == 'video') { ?>
        <?php if (inc_has_page_video()) { ?>
            <div class="entry-video">
                <?php echo Page_Media_Manager::render_page_video(); ?>
            </div>
        <?php } ?>
    <?php } else { ?>
        <?php if (has_post_thumbnail()){ ?>
            <?php $thumbnail_id = get_post_thumbnail_id();
            echo Page_Media_Manager::render_page_image($thumbnail_id); ?>
        <?php } ?>
    <?php } ?>

    <?php  $blog_overview_settings = apply_filters('inc_blog_overview_settings', array(
        'display_date' => true,
        'display_author' => true,
        'display_comments' => true,
        'display_categories' => true));
    $display_date = $blog_overview_settings['display_date'] && inc_is_display_blog_overview_date_enabled();
    $display_author = $blog_overview_settings['display_author'] && inc_is_display_blog_overview_author_enabled();
    $display_categories = $blog_overview_settings['display_categories'] && inc_is_display_blog_overview_categories_enabled();
    $display_comments = $blog_overview_settings['display_comments'] && comments_open() && inc_is_display_blog_overview_comments_enabled();
    $display_entry_meta = $display_author || $display_categories || $display_comments;
    ?>
    <?php if($display_date) { ?>
    <div class="entry-date">
        <div class="entry-day"><?php the_time('d'); ?></div>
        <div class="entry-month"><?php the_time('M'); ?></div>
    </div>
    <?php } ?>
    <div class="entry-body">
        <h2 class="entry-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
        <?php if($display_entry_meta) { ?>
        <div class="entry-meta">
            <?php if($display_author) { ?>
            <span class="author"><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php the_author(); ?></a></span>
            <?php } ?>
            <?php if($display_categories) { ?>
            <span class="category"><?php printf('%s', get_the_category_list(', ')); ?></span>
            <?php } ?>
            <?php if($display_comments) { ?>
            <span class="comments"><?php comments_popup_link(__('No Comments', INCEPTIO_THEME_NAME), __('1 Comment', INCEPTIO_THEME_NAME), __('% Comments', INCEPTIO_THEME_NAME)); ?></span>
            <?php } ?>
        </div>
        <?php } ?>
        <div class="entry-content">
            <?php $hellip = inc_get_posts_overview_hellip();
                global $post;
                if (has_excerpt()) {
                    echo do_shortcode(get_the_excerpt()).' '.$hellip;
                }elseif(preg_match('/<!--more(.*?)?-->/', $post->post_content, $matches)){
                    the_content(__('read more', INCEPTIO_THEME_NAME));
                }else{
                    $excerpt = Post_Util::get_post_excerpt(inc_get_post_excerpt_length(), $hellip);
                    if(inc_start_with($hellip, '<a')){
                        $excerpt = str_replace('<a', '</p> <a', $excerpt);
                        $excerpt = '<p>'.$excerpt;
                    }
                    echo $excerpt;
                }
            ?>
        </div>
    </div>
</article>