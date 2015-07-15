<?php
/**
 * Template Name: Portfolio Overview - With Pagination
 */
get_header(); ?>

<?php get_template_part('page-title'); ?>

    <!-- begin content -->
    <section id="content">
        <div class="container clearfix">
            <?php $settings = inc_get_posts_overview_settings();
            $settings = apply_filters("inc_portfolio_overview_settings", $settings);
            $thumb_click_action = array_key_exists('thumb_click_action', $settings) ? $settings['thumb_click_action'] : 'lightbox';
            $items_count = array_key_exists('items_count', $settings) ? $settings['items_count'] : '-1';
            $display_meta = array_key_exists('display_meta', $settings) ? $settings['display_meta'] : 'true';
            $order_by = array_key_exists('orderby', $settings) ? $settings['orderby'] : 'date';
            $order = array_key_exists('order', $settings) ? $settings['order'] : 'desc'; ?>
            <?php echo do_shortcode('[post_gallery pagination="true" type="portfolio" terms="' . $settings['terms'] . '" count="'.$items_count.'" tca="'.$thumb_click_action.'" display_filters="false" columns="' . $settings['columns'] . '" display_meta="'.$display_meta.'" orderby="'.$order_by.'" order="'.$order.'"][/post_gallery]'); ?>

            <!-- begin pagination -->
            <?php inc_pagination($wp_query->max_num_pages); wp_reset_query(); ?>
            <!-- end pagination -->
        </div>
    </section>
    <!-- end content -->

<?php get_footer(); ?>