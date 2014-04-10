<?php
/**
 * Template Name: Portfolio Overview - Right Sidebar
 */
get_header(); ?>

<?php get_template_part('page-title'); ?>

    <!-- begin content -->
    <section id="content">
        <div class="container clearfix">
            <section id="main" class="three-fourths">
                <?php
                $settings = inc_get_posts_overview_settings();
                $settings = apply_filters("inc_portfolio_overview_settings", $settings);
                $thumb_click_action = array_key_exists('thumb_click_action', $settings) ? $settings['thumb_click_action'] : 'lightbox';
                $items_count = array_key_exists('items_count', $settings) ? $settings['items_count'] : '-1';
                $display_meta = array_key_exists('display_meta', $settings) ? $settings['display_meta'] : 'true';
                $order_by = array_key_exists('orderby', $settings) ? $settings['orderby'] : 'date';
                $order = array_key_exists('order', $settings) ? $settings['order'] : 'desc';
                $terms_order = array_key_exists('terms_order', $settings) ? $settings['terms_order'] : ''; ?>
                <?php echo do_shortcode('[post_gallery type="portfolio" terms="' . $settings['terms'] . '" terms_order="' . $terms_order . '" count="'.$items_count.'" tca="'.$thumb_click_action.'" display_filters="true" display_filters_all_btn="' . $settings['display_filter_all'] . '" columns="' . $settings['columns'] . '" display_meta="'.$display_meta.'" orderby="'.$order_by.'" order="'.$order.'"][/post_gallery]'); ?>
            </section>

            <?php get_sidebar(); ?>
        </div>
    </section>
    <!-- end content -->

<?php get_footer(); ?>