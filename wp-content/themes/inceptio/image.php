<?php get_header(); ?>

<?php get_template_part('page-title'); ?>

<?php while (have_posts()) { the_post(); ?>
    <!-- begin content -->
    <section id="content">
        <div class="container clearfix">
            <!-- begin main content -->
            <section id="main" class="blog-entry-list">
                <?php $next_attachment_url = wp_get_attachment_url();
                $post = get_post();
                $attachment_ids = get_posts(array(
                    'post_parent' => $post->post_parent,
                    'fields' => 'ids',
                    'numberposts' => -1,
                    'post_status' => 'inherit',
                    'post_type' => 'attachment',
                    'post_mime_type' => 'image',
                    'order' => 'ASC',
                    'orderby' => 'menu_order ID'
                ));

                if (count($attachment_ids) > 1) {
                    $next_attachment_url = '';
                    $prev_attachment_url = '';
                    $current_index = 0;
                    foreach ($attachment_ids as $index => $attachment_id) {
                        if ($attachment_id == $post->ID) {
                            $current_index = $index;
                            break;
                        }
                    }
                    if ($current_index - 1 >= 0) {
                        $prev_attachment_url = get_attachment_link($attachment_ids[$current_index - 1]);
                    }
                    if ($current_index + 1 < count($attachment_ids)) {
                        $next_attachment_url = get_attachment_link($attachment_ids[$current_index + 1]);
                    }

                    echo '<nav class="page-nav prev-next"><ul>';
                    if (!empty($prev_attachment_url)) {
                        echo '<li><a href="' . $prev_attachment_url . '">' . __('&lsaquo; Previous Image', INCEPTIO_THEME_NAME) . '</a></li>';
                    }
                    if (!empty($next_attachment_url)) {
                        echo '<li><a href="' . $next_attachment_url . '">' . __('Next Image &rsaquo;', INCEPTIO_THEME_NAME) . '</a></li>';
                    }
                    echo '</ul></nav>';
                } ?>

                <!-- begin article -->
                <article class="entry clearfix">

                    <!-- begin entry date -->
                    <div class="entry-date">
                        <div class="entry-day"><?php the_time('d'); ?></div>
                        <div class="entry-month"><?php the_time('M'); ?></div>
                    </div>
                    <!-- end entry date -->

                    <!-- begin entry body -->
                    <div class="entry-body">
                        <!-- begin entry title -->
                        <h2 class="entry-title"><?php the_title(); ?></h2>
                        <!-- end entry title -->

                        <!-- begin entry meta -->
                        <div class="entry-meta">
                            <?php $category_list = get_the_category_list(', '); ?>
                            <span class="author"><a
                                    href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php the_author(); ?></a></span>
                            <?php if(!empty($category_list)) { ?>
                            <span class="category"><?php printf('%s', get_the_category_list(', ')); ?></span>
                            <?php } ?>
                        </div>
                        <!-- end entry meta -->

                        <!-- begin entry content -->
                        <div class="entry-content">
                            <?php if (has_excerpt()) { ?>
                                <div class="caption">
                                    <div class="entry-image"><a target="_blank" href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image($post->ID, 'full'); ?></a></div>
                                    <p class="caption-text"><?php the_excerpt(); ?></p>
                                </div>
                            <?php } else { ?>
                                <div class="entry-image"><a target="_blank" href="<?php echo wp_get_attachment_url($post->ID); ?>"><?php echo wp_get_attachment_image($post->ID, 'full'); ?></a></div>
                            <?php } ?>
                            <?php if (!empty($post->post_content)) { ?>
                                <div class="entry-description">
                                    <?php the_content(); ?>
                                </div>
                            <?php } ?>
                        </div>
                        <!-- end entry content -->

                        <!-- begin share -->
                        <?php $post_sharing_content = apply_filters('inc_attachment_sharing_content', 'post-sharing'); ?>
                        <?php get_template_part($post_sharing_content); ?>
                        <!-- end share -->

                    </div>
                    <!-- end entry body -->
                </article>
                <!-- end article -->


            </section>
            <!-- end main content -->
        </div>
    </section>
    <!-- end content -->
<?php } ?>

<?php get_footer(); ?>