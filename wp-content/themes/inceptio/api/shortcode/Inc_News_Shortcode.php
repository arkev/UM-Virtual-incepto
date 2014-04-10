<?php

class Inc_News_Shortcode extends Abstract_Inc_Shortcode implements Inc_Shortcode_Designer
{

    static $COUNT_ATTR = "count";
    static $PAGINATION_ATTR = "pagination";
    static $TERMS_ATTR = "terms";

    function render($attr, $inner_content = null, $code = "")
    {
        $content = '';
        extract(shortcode_atts(array(
            Inc_News_Shortcode::$COUNT_ATTR => '4',
            Inc_News_Shortcode::$PAGINATION_ATTR => '2',
            Inc_News_Shortcode::$TERMS_ATTR => ''), $attr));

        if (empty($pagination) || !is_numeric($pagination)) {
            return $this->get_error('The value of the ' . Inc_News_Shortcode::$PAGINATION_ATTR . ' attribute must be a number greater than 0.');
        }

        $count = empty($count) ? -1 : intval($count);
        $pagination = intval($pagination);
        $query_args = array(
            'posts_per_page' => $count,
            'post_type' => 'post',
        );

        if (!empty($terms)) {
            $terms = $this->get_terms_as_array($terms);
            $query_args['tax_query'] = array(
                array(
                    'taxonomy' => 'category',
                    'field' => 'slug',
                    'terms' => $terms,
                    'operator' => 'IN'
                )
            );
        }
        $sc_settings = apply_filters('inc_news_shortcode_settings', array('display_comments' => true));
        $query = new wp_query($query_args);
        if ($query->have_posts()) {
            $id = uniqid('posts-carousel-');
            $content = "<ul id=\"$id\" class=\"post-carousel\">";
            $page_content = '';
            $i = 0;
            while ($query->have_posts()) {
                $query->the_post();
                if ($i >= $pagination) {
                    $content .= "<li>$page_content</li>";
                    $i = 0;
                    $page_content = '';
                }
                $hellip = inc_get_news_sc_hellip();
                $excerpt = Post_Util::get_post_excerpt(inc_get_news_sc_excerpt_length(), $hellip);
                if (!inc_start_with($excerpt, "<p")) {
                    $excerpt = "<p>$excerpt</p>";
                }
                $page_content .= '<div class="entry">';

                $page_content .= '<div class="entry-date">';
                $page_content .= '<div class="entry-day">' . get_the_time('d') . '</div>';
                $page_content .= '<div class="entry-month">' . get_the_time('M') . '</div>';
                $page_content .= '</div>';

                $page_content .= '<div class="entry-body">';
                $page_content .= '<h4 class="entry-title"><a href="' . get_permalink() . '">' . get_the_title() . '</a></h4>';
                if($sc_settings['display_comments'] && comments_open()){
                    $page_content .= '<div class="entry-meta"><a href="' . get_comments_link() . '">' . $this->get_comments_number(__('No Comments', INCEPTIO_THEME_NAME), __('1 Comment', INCEPTIO_THEME_NAME), __('% Comments', INCEPTIO_THEME_NAME)) . '</a></div>';
                }
                $page_content .= '<div class="entry-content">';
                $page_content .= $excerpt;
                $page_content .= '<a href="' . get_permalink() . '">' . __('Learn More', INCEPTIO_THEME_NAME) . ' &rsaquo;</a>';
                $page_content .= '</div>';
                $page_content .= '</div>';

                $page_content .= '</div>';
                $i++;
            }
            if (!empty($page_content)) {
                $content .= "<li>$page_content</li>";
            }
            $content .= '</ul>';
            wp_reset_postdata();

            $carousel_setting = new Inc_Carousel_Settings('#' . $id, $attr);
            $content .= $carousel_setting->get_carousel_settings();
        }

        return $content;
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

    private function get_comments_number($zero = false, $one = false, $more = false)
    {
        $number = get_comments_number();

        if ($number > 1) {
            $output = str_replace('%', number_format_i18n($number), (false === $more) ? __('% Comments', INCEPTIO_THEME_NAME) : $more);
        } elseif ($number == 0) {
            $output = (false === $zero) ? __('No Comments', INCEPTIO_THEME_NAME) : $zero;
        } else {
            $output = (false === $one) ? __('1 Comment', INCEPTIO_THEME_NAME) : $one;
        }

        return apply_filters('comments_number', $output, $number);
    }

    function get_names()
    {
        return array('news');
    }

    function get_visual_editor_form()
    {
        $content = '<form id="sc-news-form" class="generic-form" method="post" action="#" data-sc="news">';
        $content .= '<fieldset>';
        $content .= '<div>';
        $content .= '<label for="sc-news-count">' . __('Posts Count', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-news-count" name="sc-news-count" type="text" value="4" data-attr-name="' . Inc_News_Shortcode::$COUNT_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-news-page">' . __('Items per Page', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-news-page" name="sc-news-page" type="text" value="2" data-attr-name="' . Inc_News_Shortcode::$PAGINATION_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-news-terms">' . __('Categories (comma separated list)', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-news-terms" name="sc-news-terms" type="text" data-attr-name="' . Inc_News_Shortcode::$TERMS_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div >';
        $content .= '<input id="sc-news-form-submit" type="submit" name="submit" value="' . __('Insert News', INCEPTIO_THEME_NAME) . '" class="button-primary">';
        $content .= '</div>';
        $content .= '</fieldset>';
        $content .= '</form>';

        return $content;
    }

    function get_group_title()
    {
        return __('Dynamic Elements', INCEPTIO_THEME_NAME);
    }

    function get_title()
    {
        return __('Recent Blog Posts Carousel (News)', INCEPTIO_THEME_NAME);
    }
}