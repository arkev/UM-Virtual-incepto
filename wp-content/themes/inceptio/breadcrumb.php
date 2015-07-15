<?php
    global $post;
    if ($post && !is_search() && !is_404() && inc_is_breadcrumb_enabled()) {
        $parent_page_ids = array();
        $parent_page_id = $post->post_parent;
        while ($parent_page_id) {
            array_push($parent_page_ids, $parent_page_id);
            $current_post = get_post($parent_page_id);
            $parent_page_id = $current_post->post_parent;
        }
        $parent_page_ids = array_reverse($parent_page_ids);
        $parent_page_ids = apply_filters('inc_breadcrumb', $parent_page_ids);

        echo '<nav id="breadcrumbs" class="one-half column-last">';
        echo '<ul>';
        echo '<li><a href="' . home_url() . '">' . __('Home', INCEPTIO_THEME_NAME) . '</a> &rsaquo;</li>' . "\n";
        foreach ($parent_page_ids as $page_id) {
            if(inc_start_with($page_id, 'filter:')){
                $page_id = str_replace('filter:', '', $page_id);
                $term = get_term_by('slug', $page_id, 'filter');
                if ($term) {
                    echo '<li><a href="' . get_term_link($term, 'filter') . '">' . __inc($term->name) . '</a> &rsaquo;</li>' . "\n";
                }
            }elseif(inc_start_with($page_id, 'category:')){
                $page_id = str_replace('category:', '', $page_id);
                $term = get_term_by('slug', $page_id, 'category');
                if ($term) {
                    echo '<li><a href="' . get_term_link($term, 'category') . '">' . __inc($term->name) . '</a> &rsaquo;</li>' . "\n";
                }
            }else{
                echo '<li><a href="' . get_page_link($page_id) . '">' . get_the_title($page_id) . '</a> &rsaquo;</li>' . "\n";
            }
        }
        echo '<li>' . get_the_title() . '</li>';
        echo '</ul>';
        echo '</nav>';
    }

