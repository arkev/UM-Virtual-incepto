<?php

//updated
if (!function_exists('inc_get_admin_custom_css')) {
    function inc_get_admin_custom_css()
    {
        global $font_manager;
        $output = '';
        $fonts = $font_manager->get_all_fonts();
        foreach ($fonts as $font) {
            $font_url = $font->font_url;
            $output .= "@import url(" . $font_url . ");\n";
        }
        foreach ($fonts as $font) {
            $font_name = $font->font_name;
            $output .= "." . str_replace(' ', '-', $font->font_name) . "-normal-400{
            font-family: '$font_name' !important;
            font-style: normal;
            font-weight: 400;
            font-size: 24px;
        }\n";
        }
        if (!empty($output)) {
            return "\n<style type=\"text/css\">\n" . $output . "</style>\n";
        } else {
            return '';
        }
    }
}

if (!function_exists('inc_get_custom_css')) {
    function inc_get_custom_css()
    {
        $output = inc_get_generic_color_styling();
        $output .= inc_get_menu_navigation_styles();
        $output .= inc_get_revslider_caption_styles();
        $output .= inc_get_flexslider_caption_styles();
        $output .= inc_get_page_title_breadcrumbs_styles();
        $output .= inc_get_tables_styles();
        $output .= inc_get_featured_content_styles();
        $output .= inc_get_arrow_boxes_styles();
        $output .= inc_get_left_aligned_iconbox_styles();
        $output .= inc_get_footer_styles();
        $output .= inc_get_footer_featured_styles();
        $output .= inc_get_body_styles();
        $output .= inc_get_h1_styles();
        $output .= inc_get_h2_styles();
        $output .= inc_get_h3_styles();
        $output .= inc_get_h4_styles();
        $output .= inc_get_h5_styles();
        $output .= inc_get_h6_styles();

        if (!empty($output)) {
            global $font_manager;
            $font_import = '';
            $fonts = $font_manager->get_all_fonts();
            foreach ($fonts as $font) {
                $font_url = $font->font_url;
                if (inc_start_with($font_url, 'http://fonts.googleapis.com') || inc_start_with($font_url, 'https://fonts.googleapis.com')) {
                    $font_import .= "@import url(" . $font_url . ");\n";
                }
            }
            return "\n<style type=\"text/css\">\n" . $font_import . $output . "</style>\n";
        } else {
            return '';
        }

    }
}

if (!function_exists('inc_get_generic_color_styling')) {
    function inc_get_generic_color_styling()
    {
        global $theme_options;
        $template_uri = get_template_directory_uri();
        $output = '';

        if (inc_get_layout_type() == 'wide') {
            if ($theme_options->is_option_changed('inceptio_wide_bg_pattern') ||
                $theme_options->is_option_changed('inceptio_wide_bg_repeat') ||
                $theme_options->is_option_changed('inceptio_wide_bg_position') ||
                $theme_options->is_option_changed('inceptio_wide_bg_color')
            ) {
                $inceptio_wide_bg_color = $theme_options->get_option_value('inceptio_wide_bg_color');
                $inceptio_wide_bg_pattern = $theme_options->get_option_value('inceptio_wide_bg_pattern');
                $inceptio_wide_bg_repeat = $theme_options->get_option_value('inceptio_wide_bg_repeat');
                $inceptio_wide_bg_position = $theme_options->get_option_value('inceptio_wide_bg_position');
                if ($inceptio_wide_bg_pattern != 'none') {
                    $inceptio_wide_bg_pattern = str_replace('..', $template_uri, $inceptio_wide_bg_pattern);
                    $inceptio_wide_bg_pattern = 'url(' . $inceptio_wide_bg_pattern . ')';
                }
                $output .= "body.wide {
	background-color: $inceptio_wide_bg_color;
	background-image: $inceptio_wide_bg_pattern;
	background-repeat: $inceptio_wide_bg_repeat;
	background-position: $inceptio_wide_bg_position;
}\n";
            }
        } else {
            if ($theme_options->is_option_changed('inceptio_boxed_bg_pattern') ||
                $theme_options->is_option_changed('inceptio_boxed_bg_repeat') ||
                $theme_options->is_option_changed('inceptio_boxed_bg_position') ||
                $theme_options->is_option_changed('inceptio_boxed_bg_color')
            ) {
                $inceptio_boxed_bg_color = $theme_options->get_option_value('inceptio_boxed_bg_color');
                $inceptio_boxed_bg_pattern = $theme_options->get_option_value('inceptio_boxed_bg_pattern');
                $inceptio_boxed_bg_repeat = $theme_options->get_option_value('inceptio_boxed_bg_repeat');
                $inceptio_boxed_bg_position = $theme_options->get_option_value('inceptio_boxed_bg_position');
                if ($inceptio_boxed_bg_pattern != 'none') {
                    $inceptio_boxed_bg_pattern = str_replace('..', $template_uri, $inceptio_boxed_bg_pattern);
                    $inceptio_boxed_bg_pattern = 'url(' . $inceptio_boxed_bg_pattern . ')';
                }
                $output .= "body.boxed {
	background-color: $inceptio_boxed_bg_color;
	background-image: $inceptio_boxed_bg_pattern;
	background-repeat: $inceptio_boxed_bg_repeat;
	background-position: $inceptio_boxed_bg_position;
}\n";
            }
        }

        if ($theme_options->is_option_changed('inceptio_generic_color_styling_link')) {
            $link_color = $theme_options->get_option_value('inceptio_generic_color_styling_link');
            $output .= "a, a > *,
.intro strong,
.introbox strong,
.iconbox > a:hover .iconbox-title,
.entry-title a:hover,
.project-list li:hover .entry-title,
ul#search-results h2 a:hover,
ul#search-results h2 a:hover strong,
.widget ul.menu li > a:hover, .widget ul.menu li.current-menu-item > a,
.ui-tabs .ui-tabs-nav li a:hover, .ui-tabs .ui-tabs-nav li.ui-state-active a,
.ui-accordion .ui-accordion-header:hover, .ui-accordion .ui-accordion-header.ui-state-active,
ol.comment-list .comment-author a:hover,
.post-carousel .entry-meta a:hover,
.iconbox .call-to-action,
.content-featured a:hover,
#breadcrumbs a:hover,
.language-options ul li a:hover {
	color: $link_color;
}\n";
        }
        if ($theme_options->is_option_changed('inceptio_generic_color_styling_bg')) {
            $bg_color = $theme_options->get_option_value('inceptio_generic_color_styling_bg');
            $output .= "ul#navlist li.current a,
.ddsubmenustyle li a,
.flex-direction-nav a:hover, .flex-direction-nav a:active,
.tp-leftarrow.default:hover, .tp-rightarrow.default:hover,
.ie8 .flex-direction-nav a:hover, .ie8 .flex-direction-nav a:active,
.ie8 .rev_slider_wrapper .tp-leftarrow.default:hover, .ie8 .rev_slider_wrapper .tp-rightarrow.default:hover,
.iconbox.icon-left > a:hover .iconbox-icon,
.jcarousel-prev:hover, .jcarousel-prev:focus,
.jcarousel-next:hover, .jcarousel-next:focus,
#toTop:hover,
.page-nav li.current,
.page-nav a:hover,
.pricing-box.featured .price,
.pricing-box.featured .title,
.filter a:hover, .filter a.selected,
.tags a:hover,
.rev_slider_wrapper .colored,
.tp-bullets .bullet:hover, .tp-bullets .bullet.selected,
#newsletter-form input.button:hover,
.button, .content-form input.button, #comment-form #submit, wpcf7-submit,
.button.black:hover,
.arrow-box-hover,
#footer-featured {
	background-color: $bg_color;
}

/* HTML5 Reset CSS Rewriting */

/* Custom text-selection colors (remove any text shadows: twitter.com/miketaylr/status/12228805301) */
::-moz-selection {background: $bg_color;}
::selection {background: $bg_color;}

ins, mark {background-color: $bg_color;}\n";
        }
        if ($theme_options->is_option_changed('inceptio_generic_color_styling_border')) {
            $border_color = $theme_options->get_option_value('inceptio_generic_color_styling_border');
            $output .= "#wrap,
#footer-top,
.infobox,
.ui-tabs .ui-tabs-nav li.ui-state-active a,
.pricing-box.featured .price,
.pricing-box.featured .title,
.project-list .entry:hover .entry-meta,
.iconbox > a:hover {
	border-color: $border_color;
}\n";
        }
        return $output;
    }
}

if (!function_exists('inc_get_menu_navigation_styles')) {
    function inc_get_menu_navigation_styles()
    {
        global $theme_options;
        $output = '';

        if ($theme_options->is_option_changed('inceptio_navigation_hlink_font_family') ||
            $theme_options->is_option_changed('inceptio_navigation_hlink_font_size') ||
            $theme_options->is_option_changed('inceptio_navigation_hlink_font_weight') ||
            $theme_options->is_option_changed('inceptio_navigation_hlink_color')
        ) {
            $inceptio_navigation_hlink_font_family = $theme_options->get_option_value('inceptio_navigation_hlink_font_family');
            $inceptio_navigation_hlink_font_family1 = trim($inceptio_navigation_hlink_font_family[0]);
            $inceptio_navigation_hlink_font_family2 = trim($inceptio_navigation_hlink_font_family[1]) == '' ? '' : ', ' . trim($inceptio_navigation_hlink_font_family[1]);
            $inceptio_navigation_hlink_font_size = $theme_options->get_option_value('inceptio_navigation_hlink_font_size');
            $inceptio_navigation_hlink_font_weight = $theme_options->get_option_value('inceptio_navigation_hlink_font_weight');
            $inceptio_navigation_hlink_color = $theme_options->get_option_value('inceptio_navigation_hlink_color');
            $output .= "ul#navlist li a {
	font-family: $inceptio_navigation_hlink_font_family1$inceptio_navigation_hlink_font_family2;
	font-size: $inceptio_navigation_hlink_font_size; /* 14px */
	font-weight: $inceptio_navigation_hlink_font_weight;
	color: $inceptio_navigation_hlink_color;
}\n";
        }

        if ($theme_options->is_option_changed('inceptio_navigation_hlink_left_padding')) {
            $inceptio_navigation_hlink_left_padding = $theme_options->get_option_value('inceptio_navigation_hlink_left_padding');
            $output .= "#search-form, ul#navlist li a {
               padding-left: $inceptio_navigation_hlink_left_padding;
}\n";
        }
        if ($theme_options->is_option_changed('inceptio_navigation_hlink_right_padding')) {
            $inceptio_navigation_hlink_right_padding = $theme_options->get_option_value('inceptio_navigation_hlink_right_padding');
            $output .= "ul#navlist li a {
               padding-right: $inceptio_navigation_hlink_right_padding;
}\n";
        }


        if ($theme_options->is_option_changed('inceptio_navigation_hlink_selected_color')) {
            $inceptio_navigation_hlink_selected_color = $theme_options->get_option_value('inceptio_navigation_hlink_selected_color');
            $output .= "ul#navlist li.current a,
ul#navlist li a:hover,
ul#navlist li a.selected {
	color: $inceptio_navigation_hlink_selected_color;
}\n";
        }
        if ($theme_options->is_option_changed('inceptio_navigation_hlink_selected_bg_color')) {
            $inceptio_navigation_hlink_selected_bg_color = $theme_options->get_option_value('inceptio_navigation_hlink_selected_bg_color');
            $output .= "ul#navlist li a:hover,
ul#navlist li a.selected {
	background-color: $inceptio_navigation_hlink_selected_bg_color;
}\n";
        }
        if ($theme_options->is_option_changed('inceptio_navigation_ddlink_font_family') ||
            $theme_options->is_option_changed('inceptio_navigation_ddlink_color')
        ) {
            $inceptio_navigation_ddlink_font_family = $theme_options->get_option_value('inceptio_navigation_ddlink_font_family');
            $inceptio_navigation_ddlink_font_family1 = trim($inceptio_navigation_ddlink_font_family[0]);
            $inceptio_navigation_ddlink_font_family2 = trim($inceptio_navigation_ddlink_font_family[1]) == '' ? '' : ', ' . trim($inceptio_navigation_ddlink_font_family[1]);
            $inceptio_navigation_ddlink_color = $theme_options->get_option_value('inceptio_navigation_ddlink_color');
            $output .= ".ddsubmenustyle li a {
	font-family: $inceptio_navigation_ddlink_font_family1$inceptio_navigation_ddlink_font_family2;
	color: $inceptio_navigation_ddlink_color;
}\n";
        }
        if ($theme_options->is_option_changed('inceptio_navigation_ddlink_hover_bg_color') ||
            $theme_options->is_option_changed('inceptio_navigation_ddlink_hover_border_color')
        ) {
            $inceptio_navigation_ddlink_hover_bg_color = $theme_options->get_option_value('inceptio_navigation_ddlink_hover_bg_color');
            $inceptio_navigation_ddlink_hover_border_color = $theme_options->get_option_value('inceptio_navigation_ddlink_hover_border_color');
            $output .= ".ddsubmenustyle li a:hover {
	background-color: $inceptio_navigation_ddlink_hover_bg_color;
	border-color: $inceptio_navigation_ddlink_hover_border_color;
}\n";
        }

        return $output;
    }

    if (!function_exists('inc_get_revslider_caption_styles')) {
        function inc_get_revslider_caption_styles()
        {
            global $theme_options;
            $output = '';

            if ($theme_options->is_option_changed('inceptio_revslider_caption_big_font_family') ||
                $theme_options->is_option_changed('inceptio_revslider_caption_big_font_size') ||
                $theme_options->is_option_changed('inceptio_revslider_caption_big_font_weight') ||
                $theme_options->is_option_changed('inceptio_revslider_caption_big_line_height') ||
                $theme_options->is_option_changed('inceptio_revslider_caption_big_letter_spacing')
            ) {
                $inceptio_revslider_caption_big_font_family = $theme_options->get_option_value('inceptio_revslider_caption_big_font_family');
                $inceptio_revslider_caption_big_font_family1 = trim($inceptio_revslider_caption_big_font_family[0]);
                $inceptio_revslider_caption_big_font_family2 = trim($inceptio_revslider_caption_big_font_family[1]) == '' ? '' : ', ' . trim($inceptio_revslider_caption_big_font_family[1]);
                $inceptio_revslider_caption_big_font_size = $theme_options->get_option_value('inceptio_revslider_caption_big_font_size');
                $inceptio_revslider_caption_big_font_weight = $theme_options->get_option_value('inceptio_revslider_caption_big_font_weight');
                $inceptio_revslider_caption_big_line_height = $theme_options->get_option_value('inceptio_revslider_caption_big_line_height');
                $inceptio_revslider_caption_big_letter_spacing = $theme_options->get_option_value('inceptio_revslider_caption_big_letter_spacing');

                $output .= ".tp-caption.big {
	font-family: $inceptio_revslider_caption_big_font_family1$inceptio_revslider_caption_big_font_family2;
	font-size: $inceptio_revslider_caption_big_font_size; /* 30px */
	font-weight: $inceptio_revslider_caption_big_font_weight;
	line-height: $inceptio_revslider_caption_big_line_height; /* 38px/30px */
	letter-spacing: $inceptio_revslider_caption_big_letter_spacing;
}\n";
            }
            if ($theme_options->is_option_changed('inceptio_revslider_caption_small_font_family') ||
                $theme_options->is_option_changed('inceptio_revslider_caption_small_font_size') ||
                $theme_options->is_option_changed('inceptio_revslider_caption_small_font_weight') ||
                $theme_options->is_option_changed('inceptio_revslider_caption_small_line_height')
            ) {
                $inceptio_revslider_caption_small_font_family = $theme_options->get_option_value('inceptio_revslider_caption_small_font_family');
                $inceptio_revslider_caption_small_font_family1 = trim($inceptio_revslider_caption_small_font_family[0]);
                $inceptio_revslider_caption_small_font_family2 = trim($inceptio_revslider_caption_small_font_family[1]) == '' ? '' : ', ' . trim($inceptio_revslider_caption_small_font_family[1]);
                $inceptio_revslider_caption_small_font_size = $theme_options->get_option_value('inceptio_revslider_caption_small_font_size');
                $inceptio_revslider_caption_small_font_weight = $theme_options->get_option_value('inceptio_revslider_caption_small_font_weight');
                $inceptio_revslider_caption_small_line_height = $theme_options->get_option_value('inceptio_revslider_caption_small_line_height');

                $output .= ".tp-caption.small {
	font-family: $inceptio_revslider_caption_small_font_family1$inceptio_revslider_caption_small_font_family2;
	font-size: $inceptio_revslider_caption_small_font_size; /* 16px */
	font-weight: $inceptio_revslider_caption_small_font_weight;
	line-height: $inceptio_revslider_caption_small_line_height; /* 22px/16px */
}\n";
            }
            if ($theme_options->is_option_changed('inceptio_revslider_caption_black_font_family') ||
                $theme_options->is_option_changed('inceptio_revslider_caption_black_font_weight')
            ) {
                $inceptio_revslider_caption_black_font_family = $theme_options->get_option_value('inceptio_revslider_caption_black_font_family');
                $inceptio_revslider_caption_black_font_family1 = trim($inceptio_revslider_caption_black_font_family[0]);
                $inceptio_revslider_caption_black_font_family2 = trim($inceptio_revslider_caption_black_font_family[1]) == '' ? '' : ', ' . trim($inceptio_revslider_caption_black_font_family[1]);
                $inceptio_revslider_caption_black_font_weight = $theme_options->get_option_value('inceptio_revslider_caption_black_font_weight');

                $output .= ".tp-caption.black {
	font-family: $inceptio_revslider_caption_black_font_family1$inceptio_revslider_caption_black_font_family2;
	font-weight: $inceptio_revslider_caption_black_font_weight;
}\n";
            }
            if ($theme_options->is_option_changed('inceptio_revslider_caption_button_font_family') ||
                $theme_options->is_option_changed('inceptio_revslider_caption_button_font_size') ||
                $theme_options->is_option_changed('inceptio_revslider_caption_button_font_weight')
            ) {
                $inceptio_revslider_caption_button_font_family = $theme_options->get_option_value('inceptio_revslider_caption_button_font_family');
                $inceptio_revslider_caption_button_font_family1 = trim($inceptio_revslider_caption_button_font_family[0]);
                $inceptio_revslider_caption_button_font_family2 = trim($inceptio_revslider_caption_button_font_family[1]) == '' ? '' : ', ' . trim($inceptio_revslider_caption_button_font_family[1]);
                $inceptio_revslider_caption_button_font_size = $theme_options->get_option_value('inceptio_revslider_caption_button_font_size');
                $inceptio_revslider_caption_button_font_weight = $theme_options->get_option_value('inceptio_revslider_caption_button_font_weight');

                $output .= ".tp-caption .button {
	font-family: $inceptio_revslider_caption_button_font_family1$inceptio_revslider_caption_button_font_family2;
	font-size: $inceptio_revslider_caption_button_font_size; /* 16px */
	font-weight: $inceptio_revslider_caption_button_font_weight;
}\n";
            }

            return $output;
        }
    }
}

if (!function_exists('inc_get_flexslider_caption_styles')) {
    function inc_get_flexslider_caption_styles()
    {
        global $theme_options;
        $output = '';

        if ($theme_options->is_option_changed('inceptio_flexslider_caption_width') ||
            $theme_options->is_option_changed('inceptio_flexslider_caption_min_width') ||
            $theme_options->is_option_changed('inceptio_flexslider_caption_max_width') ||
            $theme_options->is_option_changed('inceptio_flexslider_caption_left') ||
            $theme_options->is_option_changed('inceptio_flexslider_caption_bottom') ||
            $theme_options->is_option_changed('inceptio_flexslider_caption_color') ||
            $theme_options->is_option_changed('inceptio_flexslider_caption_text_shadow')
        ) {
            $inceptio_flexslider_caption_width = $theme_options->get_option_value('inceptio_flexslider_caption_width');
            $inceptio_flexslider_caption_min_width = $theme_options->get_option_value('inceptio_flexslider_caption_min_width');
            $inceptio_flexslider_caption_max_width = $theme_options->get_option_value('inceptio_flexslider_caption_max_width');
            $inceptio_flexslider_caption_left = $theme_options->get_option_value('inceptio_flexslider_caption_left');
            $inceptio_flexslider_caption_bottom = $theme_options->get_option_value('inceptio_flexslider_caption_bottom');
            $inceptio_flexslider_caption_color = $theme_options->get_option_value('inceptio_flexslider_caption_color');
            $inceptio_flexslider_caption_text_shadow = $theme_options->get_option_value('inceptio_flexslider_caption_text_shadow');

            $output .= ".flex-caption {
	width: $inceptio_flexslider_caption_width;
	min-width: $inceptio_flexslider_caption_min_width;
	max-width: $inceptio_flexslider_caption_max_width;
	left: $inceptio_flexslider_caption_left;
	bottom: $inceptio_flexslider_caption_bottom;
	color: $inceptio_flexslider_caption_color;
	text-shadow: $inceptio_flexslider_caption_text_shadow;
}\n";
        }
        if ($theme_options->is_option_changed('inceptio_flexslider_caption_bg')) {
            $inceptio_flexslider_caption_bg = $theme_options->get_option_value('inceptio_flexslider_caption_bg');
            $inceptio_flexslider_caption_text_ie8_bg = $theme_options->get_option_value('inceptio_flexslider_caption_text_ie8_bg');
            $inceptio_flexslider_caption_text_ie8_bg = str_replace('\\"', "\"", $inceptio_flexslider_caption_text_ie8_bg);
            $output .= ".flex-caption h1, .flex-caption > div {
	background: $inceptio_flexslider_caption_bg;
}
.ie8 .flex-caption h1, .ie8 .flex-caption > div {
	$inceptio_flexslider_caption_text_ie8_bg
}\n";
        }
        if ($theme_options->is_option_changed('inceptio_flexslider_caption_text_font_size') ||
            $theme_options->is_option_changed('inceptio_flexslider_caption_text_line_height')
        ) {
            $inceptio_flexslider_caption_text_font_size = $theme_options->get_option_value('inceptio_flexslider_caption_text_font_size');
            $inceptio_flexslider_caption_text_line_height = $theme_options->get_option_value('inceptio_flexslider_caption_text_line_height');
            $output .= ".flex-caption p {
	font-size: $inceptio_flexslider_caption_text_font_size;
	line-height: $inceptio_flexslider_caption_text_line_height;
}\n";
        }
        if ($theme_options->is_option_changed('inceptio_flexslider_caption_button_font_size')) {
            $inceptio_flexslider_caption_button_font_size = $theme_options->get_option_value('inceptio_flexslider_caption_button_font_size');
            $output .= ".flex-caption .button {
	font-size: $inceptio_flexslider_caption_button_font_size;
}\n";
        }

        return $output;
    }
}

if (!function_exists('inc_get_page_title_breadcrumbs_styles')) {
    function inc_get_page_title_breadcrumbs_styles()
    {
        global $theme_options;
        $output = '';

        if ($theme_options->is_option_changed('inceptio_page_title_bg') ||
            $theme_options->is_option_changed('inceptio_page_title_box_shadow') ||
            $theme_options->is_option_changed('inceptio_page_title_color')
        ) {
            $inceptio_page_title_bg = $theme_options->get_option_value('inceptio_page_title_bg');
            $inceptio_page_title_box_shadow = $theme_options->get_option_value('inceptio_page_title_box_shadow');
            $inceptio_page_title_color = $theme_options->get_option_value('inceptio_page_title_color');

            $output .= "#page-title {
	background-color: $inceptio_page_title_bg;
	box-shadow: $inceptio_page_title_box_shadow;
	color: $inceptio_page_title_color;
}\n";
        }
        if ($theme_options->is_option_changed('inceptio_page_title_h1_color')) {
            $inceptio_page_title_h1_color = $theme_options->get_option_value('inceptio_page_title_h1_color');

            $output .= "#page-title h1 {
	color: $inceptio_page_title_h1_color;
}\n";
        }
        if ($theme_options->is_option_changed('inceptio_page_breadcrumb_color')) {
            $inceptio_page_breadcrumb_color = $theme_options->get_option_value('inceptio_page_breadcrumb_color');

            $output .= "#breadcrumbs a {
	color: $inceptio_page_breadcrumb_color;
}\n";
        }
        return $output;
    }
}

if (!function_exists('inc_get_tables_styles')) {
    function inc_get_tables_styles()
    {
        global $theme_options;
        $output = '';

        if ($theme_options->is_option_changed('inceptio_generic_table_hover_bg')) {
            $inceptio_generic_table_hover_bg = $theme_options->get_option_value('inceptio_generic_table_hover_bg');

            $output .= ".gen-table tbody tr:hover th, .gen-table tbody tr:hover td {
	background-color: $inceptio_generic_table_hover_bg;
}\n";
        }
        if ($theme_options->is_option_changed('inceptio_pricing_table_price_color')) {
            $inceptio_pricing_table_price_color = $theme_options->get_option_value('inceptio_pricing_table_price_color');

            $output .= ".pricing-box .price span {
	color: $inceptio_pricing_table_price_color;
}\n";
        }

        return $output;
    }
}

if (!function_exists('inc_get_featured_content_styles')) {
    function inc_get_featured_content_styles()
    {
        global $theme_options;
        $output = '';

        if ($theme_options->is_option_changed('inceptio_featured_content_bg') ||
            $theme_options->is_option_changed('inceptio_featured_content_color') ||
            $theme_options->is_option_changed('inceptio_featured_content_font_size') ||
            $theme_options->is_option_changed('inceptio_featured_content_line_height') ||
            $theme_options->is_option_changed('inceptio_featured_content_box_shadow')
        ) {
            $inceptio_featured_content_bg = $theme_options->get_option_value('inceptio_featured_content_bg');
            $inceptio_featured_content_color = $theme_options->get_option_value('inceptio_featured_content_color');
            $inceptio_featured_content_font_size = $theme_options->get_option_value('inceptio_featured_content_font_size');
            $inceptio_featured_content_line_height = $theme_options->get_option_value('inceptio_featured_content_line_height');
            $inceptio_featured_content_box_shadow = $theme_options->get_option_value('inceptio_featured_content_box_shadow');

            $output .= ".content-featured {
	background-color: $inceptio_featured_content_bg;
	color: $inceptio_featured_content_color;
	font-size: $inceptio_featured_content_font_size;
	line-height: $inceptio_featured_content_line_height;
	box-shadow: $inceptio_featured_content_box_shadow;
}\n";
        }
        if ($theme_options->is_option_changed('inceptio_featured_content_link_color')
        ) {
            $inceptio_featured_content_link_color = $theme_options->get_option_value('inceptio_featured_content_link_color');

            $output .= ".content-featured a {
	color: $inceptio_featured_content_link_color;
}\n";
        }

        return $output;
    }
}

if (!function_exists('inc_get_arrow_boxes_styles')) {
    function inc_get_arrow_boxes_styles()
    {
        global $theme_options;
        $output = '';

        if ($theme_options->is_option_changed('inceptio_arrowbox_title_bg') ||
            $theme_options->is_option_changed('inceptio_arrowbox_title_color')
        ) {
            $inceptio_arrowbox_title_bg = $theme_options->get_option_value('inceptio_arrowbox_title_bg');
            $inceptio_arrowbox_title_color = $theme_options->get_option_value('inceptio_arrowbox_title_color');

            $output .= ".arrowbox-title {
	background-color: $inceptio_arrowbox_title_bg;
	color: $inceptio_arrowbox_title_color;
}\n";
        }

        if ($theme_options->is_option_changed('inceptio_arrowbox_title_arrow_front_bg') ||
            $theme_options->is_option_changed('inceptio_arrowbox_title_arrow_front_bg_repeat') ||
            $theme_options->is_option_changed('inceptio_arrowbox_title_arrow_front_bg_pos')
        ) {
            $inceptio_arrowbox_title_arrow_front_bg = $theme_options->get_option_value('inceptio_arrowbox_title_arrow_front_bg');
            $inceptio_arrowbox_title_arrow_front_bg_repeat = $theme_options->get_option_value('inceptio_arrowbox_title_arrow_front_bg_repeat');
            $inceptio_arrowbox_title_arrow_front_bg_pos = $theme_options->get_option_value('inceptio_arrowbox_title_arrow_front_bg_pos');

            $output .= ".arrowbox-title-arrow-front {
	background-image: url($inceptio_arrowbox_title_arrow_front_bg);
	background-repeat: $inceptio_arrowbox_title_arrow_front_bg_repeat;
	background-position: $inceptio_arrowbox_title_arrow_front_bg_pos;
}\n";
        }

        if ($theme_options->is_option_changed('inceptio_arrowbox_title_arrow_back_bg') ||
            $theme_options->is_option_changed('inceptio_arrowbox_title_arrow_back_bg_repeat') ||
            $theme_options->is_option_changed('inceptio_arrowbox_title_arrow_back_bg_pos')
        ) {
            $inceptio_arrowbox_title_arrow_back_bg = $theme_options->get_option_value('inceptio_arrowbox_title_arrow_back_bg');
            $inceptio_arrowbox_title_arrow_back_bg_repeat = $theme_options->get_option_value('inceptio_arrowbox_title_arrow_back_bg_repeat');
            $inceptio_arrowbox_title_arrow_back_bg_pos = $theme_options->get_option_value('inceptio_arrowbox_title_arrow_back_bg_pos');

            $output .= ".arrowbox-title-arrow-back {
	background-image: url($inceptio_arrowbox_title_arrow_back_bg);
	background-repeat: $inceptio_arrowbox_title_arrow_back_bg_repeat;
	background-position: $inceptio_arrowbox_title_arrow_back_bg_pos;
}\n";
        }

        return $output;
    }
}

if (!function_exists('inc_get_left_aligned_iconbox_styles')) {
    function inc_get_left_aligned_iconbox_styles()
    {
        global $theme_options;
        $output = '';

        if ($theme_options->is_option_changed('inceptio_left_aligned_iconbox_width') ||
            $theme_options->is_option_changed('inceptio_left_aligned_iconbox_height') ||
            $theme_options->is_option_changed('inceptio_left_aligned_iconbox_color') ||
            $theme_options->is_option_changed('inceptio_left_aligned_iconbox_border_radius') ||
            $theme_options->is_option_changed('inceptio_left_aligned_iconbox_line_height')
        ) {
            $inceptio_left_aligned_iconbox_width = $theme_options->get_option_value('inceptio_left_aligned_iconbox_width');
            $inceptio_left_aligned_iconbox_height = $theme_options->get_option_value('inceptio_left_aligned_iconbox_height');
            $inceptio_left_aligned_iconbox_color = $theme_options->get_option_value('inceptio_left_aligned_iconbox_color');
            $inceptio_left_aligned_iconbox_border_radius = $theme_options->get_option_value('inceptio_left_aligned_iconbox_border_radius');
            $inceptio_left_aligned_iconbox_line_height = $theme_options->get_option_value('inceptio_left_aligned_iconbox_line_height');

            $output .= ".icon-left .iconbox-icon {
	width: $inceptio_left_aligned_iconbox_width;
	height: $inceptio_left_aligned_iconbox_height;
	background-color: $inceptio_left_aligned_iconbox_color;
	border-radius: $inceptio_left_aligned_iconbox_border_radius;
	line-height: $inceptio_left_aligned_iconbox_line_height;
}\n";
        }

        if ($theme_options->is_option_changed('inceptio_left_aligned_iconbox_img_max_width') ||
            $theme_options->is_option_changed('inceptio_left_aligned_iconbox_img_max_height')
        ) {
            $inceptio_left_aligned_iconbox_img_max_width = $theme_options->get_option_value('inceptio_left_aligned_iconbox_img_max_width');
            $inceptio_left_aligned_iconbox_img_max_height = $theme_options->get_option_value('inceptio_left_aligned_iconbox_img_max_height');

            $output .= ".icon-left .iconbox-icon img {
	max-width: $inceptio_left_aligned_iconbox_img_max_width;
	max-height: $inceptio_left_aligned_iconbox_img_max_height;
}\n";
        }

        return $output;
    }
}

if (!function_exists('inc_get_footer_styles')) {
    function inc_get_footer_styles()
    {
        global $theme_options;
        $output = '';

        if ($theme_options->is_option_changed('inceptio_footer_link_hover_color')
        ) {
            $inceptio_footer_link_hover_color = $theme_options->get_option_value('inceptio_footer_link_hover_color');

            $output .= "#footer a:hover {
	color: $inceptio_footer_link_hover_color;
}\n";
        }

        if ($theme_options->is_option_changed('inceptio_footer_h3_color') ||
            $theme_options->is_option_changed('inceptio_footer_h3_border_bottom')
        ) {
            $inceptio_footer_h3_color = $theme_options->get_option_value('inceptio_footer_h3_color');
            $inceptio_footer_h3_border_bottom = $theme_options->get_option_value('inceptio_footer_h3_border_bottom');

            $output .= "#footer h3 {
	color: $inceptio_footer_h3_color;
	border-bottom: $inceptio_footer_h3_border_bottom;
}\n";
        }

        if ($theme_options->is_option_changed('inceptio_footer_top_color') ||
            $theme_options->is_option_changed('inceptio_footer_top_bg')
        ) {
            $inceptio_footer_top_color = $theme_options->get_option_value('inceptio_footer_top_color');
            $inceptio_footer_top_bg = $theme_options->get_option_value('inceptio_footer_top_bg');

            $output .= "#footer-top {
	color: $inceptio_footer_top_color;
	background-color: $inceptio_footer_top_bg;
}\n";
        }

        if ($theme_options->is_option_changed('inceptio_footer_bottom_color') ||
            $theme_options->is_option_changed('inceptio_footer_bottom_bg') ||
            $theme_options->is_option_changed('inceptio_footer_bottom_font_size') ||
            $theme_options->is_option_changed('inceptio_footer_bottom_border_top') ||
            $theme_options->is_option_changed('inceptio_footer_bottom_box_shadow')
        ) {
            $inceptio_footer_bottom_color = $theme_options->get_option_value('inceptio_footer_bottom_color');
            $inceptio_footer_bottom_bg = $theme_options->get_option_value('inceptio_footer_bottom_bg');
            $inceptio_footer_bottom_font_size = $theme_options->get_option_value('inceptio_footer_bottom_font_size');
            $inceptio_footer_bottom_border_top = $theme_options->get_option_value('inceptio_footer_bottom_border_top');
            $inceptio_footer_bottom_box_shadow = $theme_options->get_option_value('inceptio_footer_bottom_box_shadow');

            $output .= "#footer-bottom {
	color: $inceptio_footer_bottom_color;
	background-color: $inceptio_footer_bottom_bg;
	font-size: $inceptio_footer_bottom_font_size;
	border-top: $inceptio_footer_bottom_border_top;
	box-shadow: $inceptio_footer_bottom_box_shadow;
}\n";
        }

        if ($theme_options->is_option_changed('inceptio_footer_bottom_link_color')
        ) {
            $inceptio_footer_bottom_link_color = $theme_options->get_option_value('inceptio_footer_bottom_link_color');

            $output .= "#footer-bottom a {
	color: $inceptio_footer_bottom_link_color;
}\n";
        }

        return $output;
    }
}
if (!function_exists('inc_get_footer_featured_styles')) {
    function inc_get_footer_featured_styles()
    {
        global $theme_options;
        $output = '';

        if ($theme_options->is_option_changed('inceptio_footer_featured_color')
        ) {
            $inceptio_footer_featured_color = $theme_options->get_option_value('inceptio_footer_featured_color');

            $output .= "#footer-featured {
	color: $inceptio_footer_featured_color;
}\n";
        }

        if ($theme_options->is_option_changed('inceptio_footer_featured_font_size') ||
            $theme_options->is_option_changed('inceptio_footer_featured_line_height')
        ) {
            $inceptio_footer_featured_font_size = $theme_options->get_option_value('inceptio_footer_featured_font_size');
            $inceptio_footer_featured_line_height = $theme_options->get_option_value('inceptio_footer_featured_line_height');

            $output .= "#footer-featured p {
	font-size: $inceptio_footer_featured_font_size;
	line-height: $inceptio_footer_featured_line_height;
}\n";
        }

        if ($theme_options->is_option_changed('inceptio_footer_featured_link_color')
        ) {
            $inceptio_footer_featured_link_color = $theme_options->get_option_value('inceptio_footer_featured_link_color');

            $output .= "#footer-featured a,
#footer-featured a strong {
	color: $inceptio_footer_featured_link_color;
}\n";
        }

        if ($theme_options->is_option_changed('inceptio_footer_featured_link_hover_color')
        ) {
            $inceptio_footer_featured_link_hover_color = $theme_options->get_option_value('inceptio_footer_featured_link_hover_color');

            $output .= "#footer-featured a:hover, #footer-featured a:hover strong {
	color: $inceptio_footer_featured_link_hover_color;
}
#footer-featured ::-moz-selection {background: $inceptio_footer_featured_link_hover_color;}
#footer-featured ::selection {background: $inceptio_footer_featured_link_hover_color;}\n";
        }

        if ($theme_options->is_option_changed('inceptio_footer_featured_padding_top') ||
            $theme_options->is_option_changed('inceptio_footer_featured_padding_bottom')
        ) {
            $inceptio_footer_featured_padding_top = $theme_options->get_option_value('inceptio_footer_featured_padding_top');
            $inceptio_footer_featured_padding_bottom = $theme_options->get_option_value('inceptio_footer_featured_padding_bottom');

            $output .= "#footer-featured {
               padding-top: $inceptio_footer_featured_padding_top;
               padding-bottom: $inceptio_footer_featured_padding_bottom;
}\n";
        }

        if ($theme_options->is_option_changed('inceptio_footer_featured_h1_margin_top') ||
            $theme_options->is_option_changed('inceptio_footer_featured_h1_margin_bottom')
        ) {
            $inceptio_footer_featured_h1_margin_top = $theme_options->get_option_value('inceptio_footer_featured_h1_margin_top');
            $inceptio_footer_featured_h1_margin_bottom = $theme_options->get_option_value('inceptio_footer_featured_h1_margin_bottom');

            $output .= "#footer-featured h1 {
               margin-top: $inceptio_footer_featured_h1_margin_top;
margin-bottom: $inceptio_footer_featured_h1_margin_bottom;
}\n";
        }

        if ($theme_options->is_option_changed('inceptio_footer_featured_p_margin_bottom')
        ) {
            $inceptio_footer_featured_p_margin_bottom = $theme_options->get_option_value('inceptio_footer_featured_p_margin_bottom');

            $output .= "#footer-featured p {
               margin-bottom: $inceptio_footer_featured_p_margin_bottom;
}\n";
        }

        return $output;
    }
}

if (!function_exists('inc_get_body_styles')) {
    function inc_get_body_styles()
    {
        global $theme_options;
        $output = '';

        if ($theme_options->is_option_changed('inceptio_body_font_family') ||
            $theme_options->is_option_changed('inceptio_body_font_size')
        ) {
            $inceptio_body_font_family = $theme_options->get_option_value('inceptio_body_font_family');
            $inceptio_body_font_family1 = trim($inceptio_body_font_family[0]);
            $inceptio_body_font_family2 = trim($inceptio_body_font_family[1]) == '' ? '' : ', ' . trim($inceptio_body_font_family[1]);
            $inceptio_body_font_size = $theme_options->get_option_value('inceptio_body_font_size');

            $output .= "body, .ui-tabs, .ui-accordion {
	font-family: $inceptio_body_font_family1$inceptio_body_font_family2;
	font-size: $inceptio_body_font_size;
}\n";
        }

        if ($theme_options->is_option_changed('inceptio_body_line_height')) {
            $inceptio_body_line_height = $theme_options->get_option_value('inceptio_body_line_height');

            $output .= "body, .ui-tabs, .ui-tabs .ui-helper-reset, .ui-accordion, .ui-accordion .ui-helper-reset, #reply-title small {
	line-height: $inceptio_body_line_height;
}\n";
        }

        if ($theme_options->is_option_changed('inceptio_body_text_color')) {
            $inceptio_body_text_color = $theme_options->get_option_value('inceptio_body_text_color');

            $output .= "body, a:hover, a > *, #logo a, #logo a > *, .iconbox > a > *, ul#search-results h2 a, ul#search-results h2 a strong, .page-nav a, #filter a, .entry-title a, .tags a, ol.comment-list .comment-author a, .project-list .entry-title, .widget ul.menu li > a, .widget ul.menu li > a > *, .ui-tabs .ui-widget-content, .ui-tabs .ui-tabs-nav li a, .ui-accordion .ui-widget-content, .ui-accordion .ui-accordion-header, .language-options ul li a {
	color: $inceptio_body_text_color;
}\n";
        }

        if ($theme_options->is_option_changed('inceptio_body_lg_text_color')) {
            $inceptio_body_lg_text_color = $theme_options->get_option_value('inceptio_body_lg_text_color');

            $output .= ".tip, caption, .caption, .grey-text, .searchform .screen-reader-text {
	color: $inceptio_body_lg_text_color;
}
::-webkit-input-placeholder { /* Chrome, Safari */
	color: $inceptio_body_lg_text_color;
}
:-moz-placeholder { /* Firefox */
   color: $inceptio_body_lg_text_color;
}\n";
        }

        if ($theme_options->is_option_changed('inceptio_body_dg_text_color')) {
            $inceptio_body_dg_text_color = $theme_options->get_option_value('inceptio_body_dg_text_color');

            $output .= ".project-list .entry-content, .quote-content, blockquote.speech-bubble span {
	color: $inceptio_body_dg_text_color;
}\n";
        }

        if ($theme_options->is_option_changed('inceptio_body_secondary_text_color')) {
            $inceptio_body_secondary_text_color = $theme_options->get_option_value('inceptio_body_secondary_text_color');

            $output .= ".team-member .job-title, .post-carousel .entry-meta a, ol.comment-list .comment-meta, pre, code, #recentcomments.menu li {
	color: $inceptio_body_secondary_text_color;
}\n";
        }

        return $output;
    }
}

if (!function_exists('inc_get_h1_styles')) {
    function inc_get_h1_styles()
    {
        global $theme_options;
        $output = '';

        if ($theme_options->is_option_changed('inceptio_h1_font_family') ||
            $theme_options->is_option_changed('inceptio_h1_font_size') ||
            $theme_options->is_option_changed('inceptio_h1_line_height') ||
            $theme_options->is_option_changed('inceptio_h1_font_weight') ||
            $theme_options->is_option_changed('inceptio_h1_letter_spacing') ||
            $theme_options->is_option_changed('inceptio_h1_color')
        ) {
            $inceptio_h1_font_family = $theme_options->get_option_value('inceptio_h1_font_family');
            $inceptio_h1_font_family1 = trim($inceptio_h1_font_family[0]);
            $inceptio_h1_font_family2 = trim($inceptio_h1_font_family[1]) == '' ? '' : ', ' . trim($inceptio_h1_font_family[1]);
            $inceptio_h1_font_size = $theme_options->get_option_value('inceptio_h1_font_size');
            $inceptio_h1_line_height = $theme_options->get_option_value('inceptio_h1_line_height');
            $inceptio_h1_font_weight = $theme_options->get_option_value('inceptio_h1_font_weight');
            $inceptio_h1_letter_spacing = $theme_options->get_option_value('inceptio_h1_letter_spacing');
            $inceptio_h1_color = $theme_options->get_option_value('inceptio_h1_color');

            $output .= "h1 {
    font-family: $inceptio_h1_font_family1$inceptio_h1_font_family2;
	font-size: $inceptio_h1_font_size;
	line-height: $inceptio_h1_line_height;
	font-weight: $inceptio_h1_font_weight;
	letter-spacing: $inceptio_h1_letter_spacing;
	color: $inceptio_h1_color;
}\n";
        }
        return $output;
    }
}

if (!function_exists('inc_get_h2_styles')) {
    function inc_get_h2_styles()
    {
        global $theme_options;
        $output = '';

        if ($theme_options->is_option_changed('inceptio_h2_font_family') ||
            $theme_options->is_option_changed('inceptio_h2_font_size') ||
            $theme_options->is_option_changed('inceptio_h2_line_height') ||
            $theme_options->is_option_changed('inceptio_h2_font_weight') ||
            $theme_options->is_option_changed('inceptio_h2_letter_spacing') ||
            $theme_options->is_option_changed('inceptio_h2_color')
        ) {
            $inceptio_h2_font_family = $theme_options->get_option_value('inceptio_h2_font_family');
            $inceptio_h2_font_family1 = trim($inceptio_h2_font_family[0]);
            $inceptio_h2_font_family2 = trim($inceptio_h2_font_family[1]) == '' ? '' : ', ' . trim($inceptio_h2_font_family[1]);
            $inceptio_h2_font_size = $theme_options->get_option_value('inceptio_h2_font_size');
            $inceptio_h2_line_height = $theme_options->get_option_value('inceptio_h2_line_height');
            $inceptio_h2_font_weight = $theme_options->get_option_value('inceptio_h2_font_weight');
            $inceptio_h2_letter_spacing = $theme_options->get_option_value('inceptio_h2_letter_spacing');
            $inceptio_h2_color = $theme_options->get_option_value('inceptio_h2_color');

            $output .= "h2 {
    font-family: $inceptio_h2_font_family1$inceptio_h2_font_family2;
	font-size: $inceptio_h2_font_size;
	line-height: $inceptio_h2_line_height;
	font-weight: $inceptio_h2_font_weight;
	letter-spacing: $inceptio_h2_letter_spacing;
	color: $inceptio_h2_color;
}\n";
        }
        return $output;
    }
}

if (!function_exists('inc_get_h3_styles')) {
    function inc_get_h3_styles()
    {
        global $theme_options;
        $output = '';

        if ($theme_options->is_option_changed('inceptio_h3_font_family') ||
            $theme_options->is_option_changed('inceptio_h3_font_size') ||
            $theme_options->is_option_changed('inceptio_h3_line_height') ||
            $theme_options->is_option_changed('inceptio_h3_font_weight') ||
            $theme_options->is_option_changed('inceptio_h3_color')
        ) {
            $inceptio_h3_font_family = $theme_options->get_option_value('inceptio_h3_font_family');
            $inceptio_h3_font_family1 = trim($inceptio_h3_font_family[0]);
            $inceptio_h3_font_family2 = trim($inceptio_h3_font_family[1]) == '' ? '' : ', ' . trim($inceptio_h3_font_family[1]);
            $inceptio_h3_font_size = $theme_options->get_option_value('inceptio_h3_font_size');
            $inceptio_h3_line_height = $theme_options->get_option_value('inceptio_h3_line_height');
            $inceptio_h3_font_weight = $theme_options->get_option_value('inceptio_h3_font_weight');
            $inceptio_h3_color = $theme_options->get_option_value('inceptio_h3_color');

            $output .= "h3, #wp-calendar caption {
    font-family: $inceptio_h3_font_family1$inceptio_h3_font_family2;
	font-size: $inceptio_h3_font_size;
	line-height: $inceptio_h3_line_height;
	font-weight: $inceptio_h3_font_weight;
	color: $inceptio_h3_color;
}\n";
        }
        return $output;
    }
}

if (!function_exists('inc_get_h4_styles')) {
    function inc_get_h4_styles()
    {
        global $theme_options;
        $output = '';

        if ($theme_options->is_option_changed('inceptio_h4_font_family') ||
            $theme_options->is_option_changed('inceptio_h4_font_size') ||
            $theme_options->is_option_changed('inceptio_h4_line_height') ||
            $theme_options->is_option_changed('inceptio_h4_font_weight') ||
            $theme_options->is_option_changed('inceptio_h4_color')
        ) {
            $inceptio_h4_font_family = $theme_options->get_option_value('inceptio_h4_font_family');
            $inceptio_h4_font_family1 = trim($inceptio_h4_font_family[0]);
            $inceptio_h4_font_family2 = trim($inceptio_h4_font_family[1]) == '' ? '' : ', ' . trim($inceptio_h4_font_family[1]);
            $inceptio_h4_font_size = $theme_options->get_option_value('inceptio_h4_font_size');
            $inceptio_h4_line_height = $theme_options->get_option_value('inceptio_h4_line_height');
            $inceptio_h4_font_weight = $theme_options->get_option_value('inceptio_h4_font_weight');
            $inceptio_h4_color = $theme_options->get_option_value('inceptio_h4_color');

            $output .= "h4 {
    font-family: $inceptio_h4_font_family1$inceptio_h4_font_family2;
	font-size: $inceptio_h4_font_size;
	line-height: $inceptio_h4_line_height;
	font-weight: $inceptio_h4_font_weight;
	color: $inceptio_h4_color;
}\n";
        }
        return $output;
    }
}

if (!function_exists('inc_get_h5_styles')) {
    function inc_get_h5_styles()
    {
        global $theme_options;
        $output = '';

        if ($theme_options->is_option_changed('inceptio_h5_font_family') ||
            $theme_options->is_option_changed('inceptio_h5_font_size') ||
            $theme_options->is_option_changed('inceptio_h5_line_height') ||
            $theme_options->is_option_changed('inceptio_h5_font_weight') ||
            $theme_options->is_option_changed('inceptio_h5_color')
        ) {
            $inceptio_h5_font_family = $theme_options->get_option_value('inceptio_h5_font_family');
            $inceptio_h5_font_family1 = trim($inceptio_h5_font_family[0]);
            $inceptio_h5_font_family2 = trim($inceptio_h5_font_family[1]) == '' ? '' : ', ' . trim($inceptio_h5_font_family[1]);
            $inceptio_h5_font_size = $theme_options->get_option_value('inceptio_h5_font_size');
            $inceptio_h5_line_height = $theme_options->get_option_value('inceptio_h5_line_height');
            $inceptio_h5_font_weight = $theme_options->get_option_value('inceptio_h5_font_weight');
            $inceptio_h5_color = $theme_options->get_option_value('inceptio_h5_color');

            $output .= "h5 {
    font-family: $inceptio_h5_font_family1$inceptio_h5_font_family2;
	font-size: $inceptio_h5_font_size;
	line-height: $inceptio_h5_line_height;
	font-weight: $inceptio_h5_font_weight;
	color: $inceptio_h5_color;
}\n";
        }
        return $output;
    }
}

if (!function_exists('inc_get_h6_styles')) {
    function inc_get_h6_styles()
    {
        global $theme_options;
        $output = '';

        if ($theme_options->is_option_changed('inceptio_h6_font_family') ||
            $theme_options->is_option_changed('inceptio_h6_font_size') ||
            $theme_options->is_option_changed('inceptio_h6_line_height') ||
            $theme_options->is_option_changed('inceptio_h6_font_weight') ||
            $theme_options->is_option_changed('inceptio_h6_color')
        ) {
            $inceptio_h6_font_family = $theme_options->get_option_value('inceptio_h6_font_family');
            $inceptio_h6_font_family1 = trim($inceptio_h6_font_family[0]);
            $inceptio_h6_font_family2 = trim($inceptio_h6_font_family[1]) == '' ? '' : ', ' . trim($inceptio_h6_font_family[1]);
            $inceptio_h6_font_size = $theme_options->get_option_value('inceptio_h6_font_size');
            $inceptio_h6_line_height = $theme_options->get_option_value('inceptio_h6_line_height');
            $inceptio_h6_font_weight = $theme_options->get_option_value('inceptio_h6_font_weight');
            $inceptio_h6_color = $theme_options->get_option_value('inceptio_h6_color');

            $output .= "h6 {
    font-family: $inceptio_h6_font_family1$inceptio_h6_font_family2;
	font-size: $inceptio_h6_font_size;
	line-height: $inceptio_h6_line_height;
	font-weight: $inceptio_h6_font_weight;
	color: $inceptio_h6_color;
}\n";
        }
        return $output;
    }
}