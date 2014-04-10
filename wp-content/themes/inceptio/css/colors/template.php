<?php header('Content-type: text/css');  global $inc_color; ?>
@charset "utf-8";
/* CSS Document */


/* ---------------------------------------------------------------------- */
/* Theme Information
/* ----------------------------------------------------------------------
Name: Inceptio
Description: Responsive Multi-Purpose Theme
Author: Ixtendo
Author URI: http://www.ixtendo.com
------------------------------------------------------------------------- */


/* ---------------------------------------------------------------------- */
/* Inceptio Color Styles
/* ----------------------------------------------------------------------
TABLE OF CONTENTS

-Text
-Background Colors
-Borders
------------------------------------------------------------------------- */


/* ---------------------------------------------------------------------- */
/* Text
/* ---------------------------------------------------------------------- */
a, a > *,
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
color: <?php echo $inc_color; ?>;
}

/* ---------------------------------------------------------------------- */
/* Background Colors
/* ---------------------------------------------------------------------- */
ul#navlist li.current a,
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
.button, .content-form input.button, #comment-form #submit, .wpcf7-submit,
.button.black:hover,
.arrow-box-hover,
#footer-featured {
	background-color: <?php echo $inc_color; ?>;
}

/* rewrite WooCommerce style */
.single_add_to_cart_button.button {
background-color: <?php echo $inc_color; ?> !important;
}

/* HTML5 Reset CSS Rewriting */

/* Custom text-selection colors (remove any text shadows: twitter.com/miketaylr/status/12228805301) */
::-moz-selection {background: <?php echo $inc_color; ?>;}
::selection {background: <?php echo $inc_color; ?>;}

ins, mark {background-color: <?php echo $inc_color; ?>;}

/* ---------------------------------------------------------------------- */
/* Borders
/* ---------------------------------------------------------------------- */
#wrap,
#footer-top,
.infobox,
.ui-tabs .ui-tabs-nav li.ui-state-active a,
.pricing-box.featured .price,
.pricing-box.featured .title,
.project-list .entry:hover .entry-meta,
.iconbox > a:hover {
border-color: <?php echo $inc_color; ?>;
}

/* ---------------------------------------------------------------------- */
/* Media Player
/* ---------------------------------------------------------------------- */
.mejs-controls .mejs-time-rail .mejs-time-loaded {
background: <?php echo $inc_color; ?> !important;
background: rgba(<?php echo $inc_color_rgb; ?>,0.8) !important;
background: -webkit-gradient(linear, 0% 0%, 0% 100%, from(rgba(<?php echo $inc_color_rgb; ?>,0.8)), to(rgba(<?php echo $inc_color_rgb; ?>,0.6))) !important;
background: -webkit-linear-gradient(top, rgba(<?php echo $inc_color_rgb; ?>,0.8), rgba(<?php echo $inc_color_rgb; ?>,0.6)) !important;
background: -moz-linear-gradient(top, rgba(<?php echo $inc_color_rgb; ?>,0.8), rgba(<?php echo $inc_color_rgb; ?>,0.6)) !important;
background: -o-linear-gradient(top, rgba(<?php echo $inc_color_rgb; ?>,0.8), rgba(<?php echo $inc_color_rgb; ?>,0.6)) !important;
background: -ms-linear-gradient(top, rgba(<?php echo $inc_color_rgb; ?>,0.8), rgba(<?php echo $inc_color_rgb; ?>,0.6)) !important;
background: linear-gradient(rgba(<?php echo $inc_color_rgb; ?>,0.8), rgba(<?php echo $inc_color_rgb; ?>,0.6)) !important;
}

.mejs-controls .mejs-button button:focus {
outline-color: <?php echo $inc_color; ?> !important;
}