<?php
/**
 * Template Name: Blog Overview
 */

add_filter('inc_post_overview_query_args', 'inc_post_overview_query_args');
function inc_post_overview_query_args($query_args)
{
    $settings = inc_get_blog_overview_settings();
    if (!empty($settings)) {
        $terms_type = $settings['terms_type'];
        $terms = $settings['terms'];
        $terms_order_by = $settings['terms_order_by'];
        $terms_order = $settings['terms_order'];
        $terms_array = inc_parse_as_int_array($terms);

        if (empty($terms_array)) {
            $new_query_args = array();
        } else {
            if ($terms_type == 'category') {
                $new_query_args = array('category__in' => $terms_array);
            } else {
                $new_query_args = array('tag__in' => $terms_array);
            }
        }
        $new_query_args['orderby'] = $terms_order_by;
        $new_query_args['order'] = $terms_order;
        $query_args = array_merge($query_args, $new_query_args);
    }
    return $query_args;
}

add_filter('getarchives_join', 'inc_getarchives_join', 10, 2);
function inc_getarchives_join($join, $r)
{
    $settings = inc_get_blog_overview_settings();
    if (!empty($settings)) {
        $terms = $settings['terms'];
        $terms_array = inc_parse_as_int_array($terms);
        if (!empty($terms_array)) {
            global $wpdb;
            $join .= ", $wpdb->term_relationships tr, $wpdb->term_taxonomy tt";
        }
    }
    return $join;
}

add_filter('getarchives_where', 'inc_getarchives_where', 10, 2);
function inc_getarchives_where($where, $r)
{
    $settings = inc_get_blog_overview_settings();
    if (!empty($settings)) {
        $terms_type = $settings['terms_type'];
        $terms = $settings['terms'];
        $terms_array = inc_parse_as_int_array($terms);
        if (!empty($terms_array)) {
            global $wpdb;
            $where .= " AND $wpdb->posts.ID=tr.object_id AND tr.term_taxonomy_id=tt.term_taxonomy_id AND upper(tt.taxonomy)=upper('$terms_type') AND tt.term_id IN (" . implode(',', $terms_array) . ")";
        }
    }
    return $where;
}

add_filter('widget_categories_dropdown_args', 'inc_widget_categories_args');
add_filter('widget_categories_args', 'inc_widget_categories_args');
function inc_widget_categories_args($args)
{
    $settings = inc_get_blog_overview_settings();
    if (!empty($settings)) {
        $terms = $settings['terms'];
        $terms_array = inc_parse_as_int_array($terms);
        if (!empty($terms_array)) {
            return array_merge($args, array('include' => $terms_array));
        }
    }
    return $args;
}


get_template_part('index');