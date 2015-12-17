<?php

class Inceptio_Main_Menu_Walker extends Walker_Nav_Menu
{
    var $is_footer_menu;
    var $is_header_menu;
    var $is_simple_menu;
    var $footer_top_level_menu_count;
    var $footer_current_top_level_menu_index;

    function __construct($type = 'simple')
    {
        $this->is_footer_menu = $type == 'footer';
        $this->is_header_menu = $type == 'header';
        $this->is_simple_menu = $type == 'simple';
        if ($this->is_footer_menu) {
            $this->footer_top_level_menu_count = $this->get_footer_top_level_menu_count();
        }
    }

    function start_lvl(&$output, $depth, $args = array())
    {
        if ($depth == 0 && $this->is_header_menu) {
            $ul_id = $args->rel;
            $output .= '<ul id="' . $ul_id . '" class="ddsubmenustyle">';
        } else {
            $output .= '<ul>';
        }
    }

    function display_element($element, &$children_elements, $max_depth, $depth = 0, $args, &$output)
    {
        if ($element) {
            if (is_array($args) && count($args) > 0 && is_object($args[0])) {
                $id_field = $this->db_fields['id'];
                $id = $element->$id_field;

                $args[0]->rel = '';
                $args[0]->selected = false;
                $args[0]->has_children = false;
                if (is_array($children_elements) && array_key_exists($id, $children_elements)) {
                    $args[0]->has_children = !empty($children_elements[$id]);
                }
                if ($depth == 0) {
                    if ($this->is_header_menu && $args[0]->has_children) {
                        $args[0]->rel = uniqid();
                    }
                    if (array_key_exists($id, $children_elements)) {
                        $args[0]->selected = $this->is_menu_selected($element, $children_elements[$id]);
                    } else {
                        $args[0]->selected = $this->is_menu_selected($element);
                    }
                }
            }

            parent::display_element($element, $children_elements, $max_depth, $depth, $args, $output);
        }
    }

    function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        if (isset($args)) {
            if (is_object($args)) {
                $is_selected = property_exists($args, 'selected') ? $args->selected : false;
                $a_rel = ($depth == 0 && property_exists($args, 'rel')) ? $args->rel : '';
                $before = property_exists($args, 'before') ? $args->before : '';
                $after = property_exists($args, 'after') ? $args->after : '';
                $link_before = property_exists($args, 'link_before') ? $args->link_before : '';
                $link_after = property_exists($args, 'link_after') ? $args->link_after : '';
            } else if (is_array($args)) {
                $is_selected = array_key_exists('selected', $args) ? $args['selected'] : false;
                $a_rel = ($depth == 0 && array_key_exists('rel', $args)) ? $args['rel'] : '';
                $before = array_key_exists('before', $args) ? $args['before'] : '';
                $after = array_key_exists('after', $args) ? $args['after'] : '';
                $link_before = array_key_exists('link_before', $args) ? $args['link_before'] : '';
                $link_after = array_key_exists('link_after', $args) ? $args['link_after'] : '';
            } else {
                $is_selected = false;
                $a_rel = '';
                $before = '';
                $after = '';
                $link_before = '';
                $link_after = '';
            }
        } else {
            $is_selected = false;
            $a_rel = '';
            $before = '';
            $after = '';
            $link_before = '';
            $link_after = '';
        }

        $classes = empty($item->classes) ? array() : (array)$item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_attr = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $li_class = ($is_selected && $depth == 0) ? ($class_names ? ' class="current ' . esc_attr($class_names) . '"' : ' class="current"') : $class_attr;
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        $output .= $indent . '<li' . $li_class . '>';

        $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= !empty($a_rel) ? ' data-rel="' . $a_rel . '"' : '';
        $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';

        $item_output = $before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $link_before . apply_filters('the_title', property_exists($item, 'title') ? $item->title : '', $item->ID) . $link_after;
        $item_output .= '</a>';
        if ($this->is_footer_menu) {
            $this->footer_current_top_level_menu_index++;
            if ($this->footer_current_top_level_menu_index < $this->footer_top_level_menu_count) {
                $item_output .= ' &middot;';
            }
        }
        $item_output .= $after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    private function is_menu_selected($element, $children_elements = null)
    {
        global $post;
        $current_post_id = is_object($post) ? $post->ID : -1;
        $current_post_title = is_object($post) ? $post->post_title : '';
        $menu_id = $element->object_id;
        $menu_title = $element->title;
        $menu_object = $element->object;

        if (($current_post_id == $menu_id) ||
            ($current_post_title == $menu_title) ||
            ($menu_object == 'category' && is_category($menu_id))
        ) {
            return true;
        }
        if (isset($children_elements) && is_array($children_elements)) {
            foreach ($children_elements as $child) {
                if (($current_post_id == $child->object_id) ||
                    ($current_post_title == $child->title) ||
                    ($child->object == 'category' && is_category($child->object_id)) ||
                    (is_404() && inc_contains_string($child->title, '404'))
                ) {
                    return true;
                }
            }
        }
        if(is_home() && !is_front_page()){
            $posts_page_id = get_option('page_for_posts');
            if($element->object_id == $posts_page_id){
                return true;
            }
        }

        return false;
    }

    private function get_footer_top_level_menu_count()
    {
        global $wpdb;
        $locations = get_nav_menu_locations();
        if (is_array($locations) && array_key_exists('footer', $locations) && isset($locations['footer'])) {
            $main_menu = wp_get_nav_menu_object($locations['footer']);
            if (isset($main_menu->term_taxonomy_id)) {
                $term_taxonomy_id = $main_menu->term_taxonomy_id;
                return $wpdb->get_var($wpdb->prepare("select count(*) as c from $wpdb->posts p, $wpdb->postmeta pm where p.post_type='nav_menu_item' and pm.meta_key='_menu_item_menu_item_parent' and pm.meta_value='0' and p.id in (select object_id from $wpdb->term_relationships where term_taxonomy_id=%d) and p.ID=pm.post_id", $term_taxonomy_id));
            }
        }
        return 0;
    }
}