<!-- begin article -->
<article class="entry clearfix">

    <?php get_template_part('blog-media'); ?>

    <?php  $blog_overview_settings = apply_filters('inc_blog_settings', array(
        'display_date' => true,
        'display_author' => true,
        'display_comments' => true,
        'display_categories' => true));
        $display_date = $blog_overview_settings['display_date'] && inc_is_display_blog_date_enabled();
        $display_author = $blog_overview_settings['display_author'] && inc_is_display_blog_author_enabled();
        $display_categories = $blog_overview_settings['display_categories'] && inc_is_display_blog_categories_enabled();
        $display_comments = $blog_overview_settings['display_comments'] && comments_open() && inc_is_display_blog_comments_enabled();
        $display_entry_meta = $display_author || $display_categories || $display_comments;
    ?>
    <?php if($display_date) { ?>
    <!-- begin entry date -->
    <div class="entry-date">
        <div class="entry-day"><?php the_time('d'); ?></div>
        <div class="entry-month"><?php the_time('M'); ?></div>
    </div>
    <!-- end entry date -->
    <?php } ?>
    <!-- begin entry body -->
    <div class="entry-body">
        <!-- begin entry title -->
        <h2 class="entry-title"><?php the_title(); ?></h2>
        <!-- end entry title -->

        <?php if($display_entry_meta) { ?>
        <!-- begin entry meta -->
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
        <!-- end entry meta -->
        <?php } ?>

        <!-- begin entry content -->
        <div class="entry-content">
            <?php $post = get_post(); if(empty($post->post_content)) {echo '<p>&nbsp;</p>';} else {the_content();} ?>
        </div>
        <!-- end entry content -->

        <?php if(inc_is_display_blog_tags_enabled()){ $post_tags = get_the_tags(); ?>
        <?php if($post_tags && is_array($post_tags) && !empty($post_tags)){ ?>
        <!-- begin tags -->
        <div class="tags-wrap">
            <h4><?php _e('Tags', INCEPTIO_THEME_NAME); ?></h4>
            <ul class="tags clearfix">
                <?php foreach ($post_tags as $tag)
                {
                    $tag_link = get_tag_link($tag->term_id);
                    if(empty($tag_link)){
                        $tag_link = '#';
                    }
                    echo "<li><a href=\"$tag_link\">".$tag->name."</a></li>\n";
                }?>
            </ul>
        </div>
        <!-- end tags -->
        <?php } ?>
        <?php } ?>

        <!-- begin wp_link_pages -->
        <?php $wp_link_pages = wp_link_pages(array(
            'echo' => '0',
            'before' => '<nav class="page-nav"><ul>',
            'after' => '</ul></nav>',
            'link_before' => '++',
            'link_after' => '--',
        ));
        if(strlen($wp_link_pages) > 0){
            $wp_link_pages = str_replace('<a', '<li><a', $wp_link_pages);
            $wp_link_pages = str_replace('>++', '>', $wp_link_pages);
            $wp_link_pages = str_replace('--</a>', '</a></li>', $wp_link_pages);

            $wp_link_pages = str_replace('++', '<li class="current">', $wp_link_pages);
            $wp_link_pages = str_replace('--', '</li>', $wp_link_pages);
            echo $wp_link_pages;
        }
        ?>
        <!-- end wp_link_pages -->

        <?php if(inc_is_display_blog_sharing_post_enabled()){ ?>
        <!-- begin share -->
        <?php $post_sharing_content = apply_filters('inc_post_sharing_content', 'post-sharing'); ?>
        <?php get_template_part($post_sharing_content); ?>
        <!-- end share -->
        <?php } ?>

        <?php if(inc_is_display_about_author_post_enabled() && get_the_author_meta('description')) { ?>
        <?php $user_url = get_the_author_meta('user_url');
            if(empty($user_url)){
                $user_url = "#";
            }?>
        <!-- begin author info -->
        <div class="author-info">
            <div class="author-image">
                <a href="<?php echo $user_url; ?>" target="_blank">
                <?php echo get_avatar(get_the_author_meta('user_email'), apply_filters('inc_author_avatar_size', 70)); ?>
                </a>
            </div>

            <div class="author-bio">
                <h4><?php _e('About the Author', INCEPTIO_THEME_NAME); ?></h4>
                <?php the_author_meta('description'); ?>
            </div>
        </div>
        <!-- end author info -->
        <?php } ?>

    </div>
    <!-- end entry body -->
</article>
<!-- end article -->