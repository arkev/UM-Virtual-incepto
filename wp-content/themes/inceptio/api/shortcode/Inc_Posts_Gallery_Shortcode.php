<?php

class Inc_Posts_Gallery_Shortcode extends Abstract_Inc_Shortcode implements Inc_Shortcode_Designer
{

    static $IDS_ATTR = "ids";
    static $TYPE_ATTR = "type";
    static $COUNT_ATTR = "count";
    static $TERMS_ATTR = "terms";
    static $TERMS_ORDER_ATTR = "terms_order";
    static $COLUMNS_ATTR = "columns";
    static $ORDER_BY_ATTR = "orderby";
    static $ORDER_ATTR = "order";
    static $DISPLAY_MODE_ATTR = "display_mode";
    static $DISPLAY_FILTERS_ATTR = "display_filters";
    static $DISPLAY_FILTERS_ALL_BTN_ATTR = "display_filters_all_btn";
    static $DISPLAY_META_ATTR = "display_meta";
    static $RELATED_CURRENT_POST_ATTR = "related";
    static $CLASS_ATTR = "class";
    static $THUMB_CLICK_ACTION_ATTR = "tca";
    static $PAGINATION_ATTR = "pagination";
    static $NO_IMAGE_ATTR = "no_image";
    static $NO_IMAGE_SRC_ATTR = "no_image_src";

    private $order_array = array('ASC', 'DESC');
    private $display_mode_array = array('gallery', 'carousel', 'thumbs');

    function render($attr, $inner_content = null, $code = "")
    {
        $default_attr = array(
            Inc_Posts_Gallery_Shortcode::$PAGINATION_ATTR => 'false',
            Inc_Posts_Gallery_Shortcode::$THUMB_CLICK_ACTION_ATTR => 'lightbox',
            Inc_Posts_Gallery_Shortcode::$IDS_ATTR => '',
            Inc_Posts_Gallery_Shortcode::$TYPE_ATTR => '',
            Inc_Posts_Gallery_Shortcode::$COUNT_ATTR => '',
            Inc_Posts_Gallery_Shortcode::$TERMS_ATTR => '',
            Inc_Posts_Gallery_Shortcode::$TERMS_ORDER_ATTR => '',
            Inc_Posts_Gallery_Shortcode::$COLUMNS_ATTR => '',
            Inc_Posts_Gallery_Shortcode::$ORDER_BY_ATTR => 'date',
            Inc_Posts_Gallery_Shortcode::$ORDER_ATTR => 'desc',
            Inc_Posts_Gallery_Shortcode::$DISPLAY_MODE_ATTR => 'gallery',
            Inc_Posts_Gallery_Shortcode::$DISPLAY_FILTERS_ATTR => 'false',
            Inc_Posts_Gallery_Shortcode::$DISPLAY_FILTERS_ALL_BTN_ATTR => 'true',
            Inc_Posts_Gallery_Shortcode::$RELATED_CURRENT_POST_ATTR => 'false',
            Inc_Posts_Gallery_Shortcode::$CLASS_ATTR => '',
            Inc_Posts_Gallery_Shortcode::$DISPLAY_META_ATTR => 'true',
            Inc_Posts_Gallery_Shortcode::$NO_IMAGE_ATTR => 'true',
            Inc_Posts_Gallery_Shortcode::$NO_IMAGE_SRC_ATTR => '/images/no-image.png',
            Inc_Carousel_Settings::$CS_SCROLL_ATTR => '4',
            Inc_Carousel_Settings::$CS_VISIBLE_ATTR => 'null',
        );
        $content = '';
        $filter_content = '';
        $combined_attr = shortcode_atts($default_attr, $attr);
        extract($combined_attr);

        if ($related == 'false' && empty($type)) {
            return $this->get_error('The value of the ' . Inc_Posts_Gallery_Shortcode::$TYPE_ATTR . ' attribute must be empty.');
        }
        if (empty($display_mode) || !in_array($display_mode, $this->display_mode_array)) {
            return $this->get_error('The value of the ' . Inc_Posts_Gallery_Shortcode::$DISPLAY_MODE_ATTR . ' attribute must be: ' . implode(',', $this->display_mode_array));
        }
        if (($display_mode == 'gallery') && (empty($columns) || !is_numeric($columns) || intval($columns) < 2 || intval($columns) > 4)) {
            return $this->get_error('The value of the ' . Inc_Posts_Gallery_Shortcode::$COLUMNS_ATTR . ' attribute must be a number between 2 and 4.');
        }
        $order = strtoupper($order);
        if (!in_array($order, $this->order_array)) {
            return $this->get_error('The value of the ' . Inc_Posts_Gallery_Shortcode::$ORDER_ATTR . ' attribute must be: ' . implode(',', $this->order_array));
        }

        if ($display_mode == 'gallery') {
            $class = empty($class) ? "project-list clearfix" : "$class project-list clearfix";
        } elseif ($display_mode == 'carousel') {
            $class = empty($class) ? "project-list project-carousel" : "$class project-list project-carousel";
        } elseif ($display_mode == 'thumbs') {
            $class = empty($class) ? "thumbs clearfix" : "$class thumbs clearfix";
        }
        $orderby = $this->get_orderby_as_array($orderby);
        $orderby = implode(' ', $orderby);
        if (empty($ids)) {

            $count = empty($count) ? -1 : intval($count);
            if ($pagination == 'true') {
                if (get_query_var('paged')) {
                    $paged = get_query_var('paged');
                } elseif (get_query_var('page')) {
                    $paged = get_query_var('page');
                } else {
                    $paged = 1;
                }
                if ($count == -1) {
                    $count = get_option('posts_per_page');
                }
            }
            $query_args = array(
                'orderby' => $orderby,
                'order' => $order,
                'posts_per_page' => $count,
            );

            if (isset($paged)) {
                $query_args['paged'] = $paged;
            }
            if ($related == 'true') {
                global $post;
                $type = get_post_type();
                $current_post_id = get_the_ID();
                $taxonomy = $this->get_post_taxonomy($type);
                $query_args['post__not_in'] = array($current_post_id);
                $post_terms = get_the_terms($post, $taxonomy);
                if ($post_terms && is_array($post_terms)) {
                    $terms = array();
                    foreach ($post_terms as $post_term) {
                        $terms[] = $post_term->slug;
                    }
                }
            } else {
                $taxonomy = $this->get_post_taxonomy($type);
            }

            $query_args['post_type'] = $type;
            if (!empty($terms)) {
                $terms = $this->get_terms_as_array($terms);
                $query_args['tax_query'] = array(
                    array(
                        'taxonomy' => $taxonomy,
                        'field' => 'slug',
                        'terms' => $terms,
                        'operator' => 'IN'
                    )
                );
            }
        } else {
            $taxonomy = $this->get_post_taxonomy($type);
            $ids = $this->get_ids_as_array($ids);
            $query_args = array(
                'post_type' => $type,
                'post__in' => $ids,
                'orderby' => $orderby,
                'order' => $order,
                'posts_per_page' => -1,
            );
        }

        $posts_terms = array();
        $query = new WP_Query($query_args);
        if ($pagination == 'true') {
            $GLOBALS['wp_query'] = $query;
        }
        if ($query->have_posts()) {
            $gallery_id = uniqid('posts-gallery-');
            if ($display_mode == 'gallery') {
                $class = str_replace('portfolio-grid', '', $class);
                $class = empty($class) ? 'portfolio-grid' : 'portfolio-grid ' . $class;
            }
            $content = "<ul id=\"$gallery_id\" class=\"$class\">";
            while ($query->have_posts()) {
                $query->the_post();
                $content .= $this->get_post_gallery_item($combined_attr);
                global $post;
                $post_terms = get_the_terms($post, $taxonomy);
                if ($post_terms) {
                    foreach ($post_terms as $term) {
                        $posts_terms[$term->name] = $term->slug;
                    }
                }
            }
            $content .= '</ul>';
            wp_reset_postdata();

            if ($display_mode == 'carousel') {
                $carousel_setting = new Inc_Carousel_Settings('#' . $gallery_id, $attr, $default_attr);
                $content .= $carousel_setting->get_carousel_settings();
            }

            if ($display_mode != 'thumbs' && $display_filters == 'true') {
                $terms_order = array_filter(explode(',', trim($terms_order)));
                ksort($posts_terms);
                if (!empty($terms_order)) {
                    $new_posts_terms = array();
                    foreach ($terms_order as $term_slug) {
                        foreach ($posts_terms as $key => $val) {
                            if ($val == $term_slug) {
                                $new_posts_terms[$key] = $val;
                            }
                        }
                    }
                    $posts_terms = array_merge($new_posts_terms, $posts_terms);
                }

                $selected_filter = '';
                $filter_id = uniqid('filter-');
                $filter_content = '<div id="' . $filter_id . '" class="filter">';
                $filter_content .= '<span>' . __('Filter', INCEPTIO_THEME_NAME) . ':</span>';
                $filter_content .= '<ul>';
                if ($display_filters_all_btn == 'true') {
                    $filter_content .= '<li><a class="selected" href="#" data-filter="*">' . __('All', INCEPTIO_THEME_NAME) . '</a></li>';
                } else {
                    reset($posts_terms);
                    $selected_filter = count($posts_terms) > 0 ? $posts_terms[key($posts_terms)] : '';
                }

                foreach ($posts_terms as $key => $val) {
                    $filter_content .= '<li><a href="#" data-filter=".' . $val . '">' . __inc($key) . '</a></li>';
                }
                $filter_content .= '</ul></div>';

                $content .= "<script type=\"text/javascript\">
                    if(!document['postsGallerySettings']){
                        document['postsGallerySettings'] = [];
                    }
                    document['postsGallerySettings'].push({
                        containerSelector: '#" . $gallery_id . "',
                        filterSelector: '#" . $filter_id . "',
                        selectedFilter: '" . $selected_filter . "'
                    });
                </script>";
            }
        }

        return $filter_content . $content;
    }

    private function get_post_gallery_item($combined_attr)
    {
        global $post;
        $display_mode = $combined_attr[Inc_Posts_Gallery_Shortcode::$DISPLAY_MODE_ATTR];
        $display_meta = $combined_attr[Inc_Posts_Gallery_Shortcode::$DISPLAY_META_ATTR];
        $type = $combined_attr[Inc_Posts_Gallery_Shortcode::$TYPE_ATTR];
        $columns = $combined_attr[Inc_Posts_Gallery_Shortcode::$COLUMNS_ATTR];
        $tca = $combined_attr[Inc_Posts_Gallery_Shortcode::$THUMB_CLICK_ACTION_ATTR];
        $no_image = $combined_attr[Inc_Posts_Gallery_Shortcode::$NO_IMAGE_ATTR];
        $no_image_src = $combined_attr[Inc_Posts_Gallery_Shortcode::$NO_IMAGE_SRC_ATTR];


        $post_title = get_the_title();
        $post_url = get_permalink();
        $posts_gallery_excerpt_length = apply_filters('posts_gallery_excerpt_length', 27);
        if($posts_gallery_excerpt_length == 27){
            $posts_gallery_excerpt_length = inc_get_posts_gallery_sc_excerpt_length();
        }
        $post_excerpt = Post_Util::get_post_excerpt($posts_gallery_excerpt_length, '');

        if (inc_start_with($post_excerpt, 'url:')) {
            $post_url = Post_Util::get_post_excerpt(500, '');
            $post_url = str_replace('url:', '', $post_url);
            $post_excerpt = '';
        }

        $assoc_media = Post_Util::get_associated_media($post->ID);
        if (empty($assoc_media) && $no_image == 'true') {
            $assoc_media[] = array('type' => 'img', 'id' => $no_image_src);
        }
        if ($display_mode == 'thumbs') {
            $img_src = '';
            foreach ($assoc_media as $media) {
                if (empty($img_src)) {
                    if ($media['type'] == 'img') {
                        $img_post = Media_Util::get_original_post($media['id']);
                        if ($img_post) {
                            $img_src = Media_Util::get_image_src($media['id'], 'thumbnail');
                        }
                    } elseif ($media['type'] == 'video') {
                        $video_meta = $media['meta'];
                        if ($video_meta) {
                            $attach_id = $video_meta['attach_id'];
                            if ($attach_id) {
                                $large_img_src = Media_Util::get_image_src($attach_id, 'thumbnail');
                                if ($large_img_src != $attach_id) {
                                    $img_src = $large_img_src;
                                }
                            }
                            if (empty($img_src)) {
                                $large_img_src = Media_Util::get_image_src($attach_id, 'thumbnail');
                                if ($large_img_src != $attach_id) {
                                    $img_src = $large_img_src;
                                }
                            }
                            if (empty($img_src)) {
                                $img_src = $video_meta['thumb'];
                            }
                        }
                    }
                }
            }
            $content = '<li><a href="' . $post_url . '" title="' . $post_title . '"><img src="' . $img_src . '" alt="' . $post_title . '"></a></li>';
            return $content;
        } else {
            $li_class = "entry";
            if ($display_mode == 'gallery') {
                if ($columns == 2) {
                    $li_class .= " one-half";
                } elseif ($columns == 3) {
                    $li_class .= " one-third";
                } else {
                    $li_class .= " one-fourth";
                }
                $terms_slug = $this->get_post_terms_slug($type);
                if (count($terms_slug) > 0) {
                    $li_class .= ' ' . implode(' ', $terms_slug);
                }
            }
            $gallery_id = uniqid();

            $content = "<li class=\"$li_class\">";
            if ($tca == 'link') {
                foreach ($assoc_media as $media) {
                    $a_class = 'entry-image';
                    if ($media['type'] == 'img') {
                        if (is_numeric($media['id'])) {
                            $img_post = Media_Util::get_original_post($media['id']);
                            if ($img_post) {
                                $img_title = $post_title;
                                $thumb_src = Media_Util::get_image_src($media['id'], 'inc-post-gallery-thumb');
                                $content .= "<a class=\"$a_class\" href=\"$post_url\" title=\"$img_title\"><span class=\"overlay\"></span><img src=\"$thumb_src\" alt=\"$img_title\"></a>";
                            }
                        } else {
                            $thumb_src = Media_Util::get_image_src($media['id']);
                            $content .= "<a class=\"entry-image\" href=\"$post_url\" title=\"$post_title\"><span class=\"overlay\"></span><img src=\"$thumb_src\" alt=\"$post_title\"></a>";

                        }
                    } elseif ($media['type'] == 'video') {
                        $video_meta = $media['meta'];
                        if ($video_meta) {
                            $video_title = $video_meta['title'];
                            $video_thumb = '';
                            $attach_id = $video_meta['attach_id'];
                            if ($attach_id) {
                                $large_img_src = Media_Util::get_image_src($attach_id, 'inc-post-gallery-thumb');
                                if ($large_img_src != $attach_id) {
                                    $video_thumb = $large_img_src;
                                }
                            }
                            if (empty($video_thumb)) {
                                $large_img_src = Media_Util::get_image_src($attach_id, 'inc-post-gallery-thumb');
                                if ($large_img_src != $attach_id) {
                                    $video_thumb = $large_img_src;
                                }
                            }
                            if (empty($video_thumb)) {
                                $video_thumb = $video_meta['thumb'];
                            }
                            $content .= "<a class=\"$a_class\" href=\"$post_url\" title=\"$video_title\"><span class=\"overlay\"></span><img src=\"$video_thumb\" alt=\"$video_title\"></a>";
                        }
                    }
                    break;
                }
            } else {
                $i = 0;
                foreach ($assoc_media as $media) {
                    $a_class = ($media['type'] == 'img') ? 'entry-image lightbox' : 'entry-image lightbox-video';
                    if ($i > 0) {
                        $a_class .= " invisible";
                    }
                    if ($media['type'] == 'img') {
                        if (is_numeric($media['id'])) {
                            $img_post = Media_Util::get_original_post($media['id']);
                            if ($img_post) {
                                $img_title = $post_title;
                                $thumb_src = Media_Util::get_image_src($media['id'], 'inc-post-gallery-thumb');
                                $full_src = Media_Util::get_image_src($media['id'], 'full');
                                $content .= "<a class=\"$a_class\" data-fancybox-group=\"$gallery_id\" href=\"$full_src\" title=\"$img_title\"><span class=\"overlay zoom\"></span><img src=\"$thumb_src\" alt=\"$img_title\"></a>";
                            }
                        } else {
                            $thumb_src = Media_Util::get_image_src($media['id']);
                            $content .= "<a class=\"entry-image\" href=\"$post_url\" title=\"$post_title\"><span class=\"overlay\"></span><img src=\"$thumb_src\" alt=\"$post_title\"></a>";
                        }
                    } elseif ($media['type'] == 'video') {
                        $video_meta = $media['meta'];
                        if ($video_meta) {
                            $video_title = $video_meta['title'];
                            $video_type = $video_meta['type'];
                            $video_id = $video_meta['id'];
                            $video_thumb = '';
                            $attach_id = $video_meta['attach_id'];
                            if ($attach_id) {
                                $large_img_src = Media_Util::get_image_src($attach_id, 'inc-post-gallery-thumb');
                                if ($large_img_src != $attach_id) {
                                    $video_thumb = $large_img_src;
                                }
                            }
                            if (empty($video_thumb)) {
                                $large_img_src = Media_Util::get_image_src($attach_id, 'inc-post-gallery-thumb');
                                if ($large_img_src != $attach_id) {
                                    $video_thumb = $large_img_src;
                                }
                            }
                            if (empty($video_thumb)) {
                                $video_thumb = $video_meta['thumb'];
                            }

                            if ($video_type == 'vimeo') {
                                $video_url = 'http://player.vimeo.com/video/' . $video_id . '?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff';
                            } elseif ($video_type == 'youtube') {
                                $video_url = 'http://www.youtube.com/embed/' . $video_id . '?rel=0';
                            }
                            $content .= "<a class=\"$a_class\" href=\"$video_url\" title=\"$video_title\"><span class=\"overlay zoom\"></span><img src=\"$video_thumb\" alt=\"$video_title\"></a>";
                        }
                    }
                    $i++;
                }
            }

            if ($display_meta == 'true') {
                if (empty($post_excerpt)) {
                    $post_excerpt = '&nbsp;';
                }
                $content .= "<a class=\"entry-meta\" href=\"$post_url\">";
                $content .= "<h4 class=\"entry-title\">$post_title</h4>";
                $content .= "<div class=\"entry-content\">";
                $content .= "<p>$post_excerpt</p>";
                $content .= "</div>";
                $content .= "<div class=\"arrow-box-hover\"></div>";
                $content .= "</a>";
            }
            $content .= "</li>";
            return $content;
        }

    }

    private function get_ids_as_array($ids)
    {
        if (is_string($ids)) {
            $ids = explode(",", $ids);
        }
        $selected_posts_id = array();
        foreach ($ids as $id) {
            $id = trim($id);
            if (strlen($id) > 0 && is_numeric($id)) {
                array_push($selected_posts_id, intval($id));
            }
        }
        return $selected_posts_id;
    }

    private function get_terms_as_array($terms)
    {
        if (is_array($terms)) {
            return $terms;
        } else {
            $terms_array = explode(',', $terms);
            $query_terms = array();
            foreach ($terms_array as $term) {
                array_push($query_terms, trim($term));
            }
            return $query_terms;
        }
    }

    private function get_orderby_as_array($orderby)
    {
        $orderby_array = explode(',', $orderby);
        $query_orderby = array();
        foreach ($orderby_array as $item) {
            array_push($query_orderby, trim($item));
        }
        return $query_orderby;
    }

    private function get_post_terms_slug($type)
    {
        global $post;
        $taxonomy = $this->get_post_taxonomy($type);
        $terms = get_the_terms($post, $taxonomy);
        $terms_slug = array();
        if ($terms) {
            foreach ($terms as $term) {
                array_push($terms_slug, $term->slug);
            }
        }
        return $terms_slug;
    }

    private function get_post_taxonomy($type)
    {
        return ($type == 'portfolio') ? 'filter' : 'category';
    }

    function get_names()
    {
        return array('post_gallery');
    }

    function get_visual_editor_form()
    {
        $content = '<form id="sc-posts-form" class="generic-form" method="post" action="#" data-sc="post_gallery">';
        $content .= '<fieldset>';
        $content .= '<div>';
        $content .= '<label for="sc-posts-pt">' . __('Post Type', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="sc-posts-pt" name="sc-posts-pt" data-attr-name="' . Inc_Posts_Gallery_Shortcode::$TYPE_ATTR . '" data-attr-type="attr">';
        $content .= '<option value="post">' . __('Post', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="portfolio">' . __('Portfolio', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="page">' . __('Page', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-posts-dm">' . __('Display Mode', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="sc-posts-dm" name="sc-posts-dm" data-attr-name="' . Inc_Posts_Gallery_Shortcode::$DISPLAY_MODE_ATTR . '" data-attr-type="attr">';
        $content .= '<option value="gallery">' . __('Gallery', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="carousel">' . __('Carousel', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-posts-df">' . __('Display Filter', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="sc-posts-df" name="sc-posts-df" data-attr-name="' . Inc_Posts_Gallery_Shortcode::$DISPLAY_FILTERS_ATTR . '" data-attr-type="attr">';
        $content .= '<option value="false">' . __('No', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="true">' . __('Yes', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-posts-dfa">' . __('Filter All Button', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="sc-posts-dfa" name="sc-posts-dfa" data-attr-name="' . Inc_Posts_Gallery_Shortcode::$DISPLAY_FILTERS_ALL_BTN_ATTR . '" data-attr-type="attr">';
        $content .= '<option value="true">' . __('Display', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="false">' . __('Hide', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-posts-dt">' . __('Display', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="sc-posts-dt" name="sc-posts-dt">';
        $content .= '<option value="latest">' . __('Latest Posts', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="specific">' . __('Specific Posts', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-posts-cols">' . __('Columns', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="sc-posts-cols" name="sc-posts-cols" data-attr-name="' . Inc_Posts_Gallery_Shortcode::$COLUMNS_ATTR . '" data-attr-type="attr">';
        $content .= '<option value="2">2</option>';
        $content .= '<option value="3">3</option>';
        $content .= '<option value="4">4</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-posts-ids">' . __('IDS', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-posts-ids" name="sc-posts-ids" type="text" data-attr-name="' . Inc_Posts_Gallery_Shortcode::$IDS_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-posts-cat">' . __('Categories (comma separated list)', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-posts-cat" name="sc-posts-cat" type="text" data-attr-name="' . Inc_Posts_Gallery_Shortcode::$TERMS_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-posts-count">' . __('Posts Count', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-posts-count" name="sc-posts-count" type="text" data-attr-name="' . Inc_Posts_Gallery_Shortcode::$COUNT_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-posts-ordby">' . __('Order By', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="sc-posts-ordby" name="sc-posts-ordby" multiple data-attr-name="' . Inc_Posts_Gallery_Shortcode::$ORDER_BY_ATTR . '" data-attr-type="attr">';
        $content .= '<option value="none">' . __('No order', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="ID">' . __('Order by post id', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="author">' . __('Order by author', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="title">' . __('Order by title', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="name">' . __('Order by post name', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="date" selected>' . __('Order by date', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="modified">' . __('Order by last modified date', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="parent">' . __('Order by post/page parent id', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="rand">' . __('Random order', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="comment_count">' . __('Order by number of comments', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="menu_order">' . __('Order by Page Order', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="meta_value">' . __('Order by meta value', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="meta_value_num">' . __('Order by numeric meta value', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="post__in">' . __('Preserve post ID', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-posts-ord">' . __('Order', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="sc-posts-ord" name="sc-posts-ord" data-attr-name="' . Inc_Posts_Gallery_Shortcode::$ORDER_ATTR . '" data-attr-type="attr">';
        $content .= '<option value="desc">' . __('Descendent', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="asc">' . __('Ascendent', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-posts-class">' . __('Container Classes', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-posts-class" name="sc-posts-class" type="text" data-attr-name="' . Inc_Posts_Gallery_Shortcode::$CLASS_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div >';
        $content .= '<input id="sc-posts-form-submit" type="submit" name="submit" value="' . __('Insert Posts Gallery', INCEPTIO_THEME_NAME) . '" class="button-primary">';
        $content .= '</div>';
        $content .= '</fieldset>';
        $content .= '</form>';

        return $content;
    }

    function get_group_title()
    {
        return __('Elements', INCEPTIO_THEME_NAME);
    }

    function get_title()
    {
        return __('Posts Gallery', INCEPTIO_THEME_NAME);
    }

}
