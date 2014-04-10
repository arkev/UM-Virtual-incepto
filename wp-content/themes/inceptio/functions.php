<?php

define('INCEPTIO_THEME_NAME', 'inceptio');
define('INCEPTIO_THEME_VERSION', '1.13');
define('IS_STYLE_SWITCHER_ENABLED', false);
define('IS_BROWSER_COMPATIBILITY_CHECK_ENABLED', true);
define('INCEPTIO_ROOT_PATH', dirname(__FILE__));
define('INCEPTIO_SIDEBAR_FOOTER', 'Footer Sidebar');
define('INCEPTIO_SIDEBAR_DEFAULT', 'Default Sidebar');
define('INCEPTIO_SIDEBAR_NONE', 'No Sidebar');
define('INCEPTIO_SIDEBAR_PORTFOLIO_CATEGORY', 'Portfolio Category Sidebar');
define('HTTP_PROTOCOL', is_ssl() ? 'https' : 'http');


//Page
define('OPTION_CUSTOM_SEO_ENABLED', 'inceptio_custom_seo_enabled');
define('OPTION_HEAD_META_KEYWORDS', 'inceptio_head_meta_keywords');
define('OPTION_HEAD_META_DESCRIPTION', 'inceptio_head_meta_description');
define('OPTION_HEAD_META_APPNAME', 'inceptio_head_meta_appname');
define('OPTION_HEAD_META_GENERATOR', 'inceptio_head_meta_generator');
define('OPTION_HEAD_META_AUTHOR', 'inceptio_head_meta_author');
//Header settings
define('OPTION_HEADER_LOGO', 'inceptio_header_logo');
define('OPTION_HEADER_LOGO_ALT', 'inceptio_header_logo_alt');
define('OPTION_HEADER_FAV_ICON', 'inceptio_header_favicon');
define('OPTION_HEADER_SEARCH_VISIBLE', 'inceptio_header_search_visible');
//Footer settings
define('OPTION_FOOTER_COPYRIGHT', 'inceptio_footer_copyright');
define('OPTION_FOOTER_TRACKING_CODE', 'inceptio_footer_tracking_code');
define('OPTION_FOOTER_FEATURED_ENABLED', 'inceptio_footer_featured_enabled');
define('OPTION_FOOTER_FEATURED_TITLE', 'inceptio_footer_featured_title');
define('OPTION_FOOTER_FEATURED_BODY', 'inceptio_footer_featured_body');
define('OPTION_FOOTER_FEATURED_URL', 'inceptio_footer_featured_url');
define('OPTION_FOOTER_FEATURED_ICON', 'inceptio_footer_featured_icon');
define('OPTION_FOOTER_FEATURED_CONTENT', 'inceptio_footer_featured_content');
//Content
define('OPTION_CONTENT_FEATURED', 'inceptio_content_featured');
//Breadcrumb and Page Titlebar settings
define('OPTION_BREADCRUMB_ENABLED', 'inceptio_breadcrumb_enabled');
define('OPTION_TITLE_BAR_ENABLED', 'inceptio_title_bar_enabled');
//Contact settings
define('OPTION_CONTACT_ADDRESS', 'inceptio_contact_address');
define('OPTION_CONTACT_EMAIL', 'inceptio_contact_email');
define('OPTION_CONTACT_PHONE', 'inceptio_contact_phone');
define('OPTION_CONTACT_MOBILE', 'inceptio_contact_mobile');
define('OPTION_CONTACT_FAX', 'inceptio_contact_fax');
//Captcha settings
define('OPTION_CAPTCHA_ENABLED', 'inceptio_captcha_enabled');
//RSS settings
define('OPTION_RSS_ENABLED', 'inceptio_rss_enabled');
define('OPTION_RSS_TYPE', 'inceptio_rss_type');
//Responsiveness settings
define('OPTION_RESPONSIVE_ENABLED', 'inceptio_responsive_enabled');
define('OPTION_INTERNATIONALIZATION_ENABLED', 'inceptio_internationalization_enabled');
//Excerpt Length
define('OPTION_POST_EXCERPT_LENGTH', 'inceptio_post_excerpt_length');
define('OPTION_NEWS_SC_EXCERPT_LENGTH', 'inceptio_news_sc_excerpt_length');
define('OPTION_POST_GALLERY_SC_EXCERPT_LENGTH', 'inceptio_posts_gallery_sc_excerpt_length');
define('OPTION_SEARCH_RESULTS_EXCERPT_LENGTH', 'inceptio_search_results_excerpt_length');
//Hellip Type
define('OPTION_POST_HELLIP_TYPE', 'inceptio_post_hellip_type');
define('OPTION_NEWS_SC_HELLIP_TYPE', 'inceptio_news_sc_hellip_type');
define('OPTION_POSTS_GALLERY_SC_HELLIP_TYPE', 'inceptio_posts_gallery_sc_hellip_type');
define('OPTION_SEARCH_RESULTS_HELLIP_TYPE', 'inceptio_search_results_hellip_type');

//Blog Overview, Blog & Portfolio
define('OPTION_BLOG_OVERVIEW_DISPLAY_DATE', 'inceptio_blog_overview_display_date');
define('OPTION_BLOG_OVERVIEW_DISPLAY_AUTHOR', 'inceptio_blog_overview_display_author');
define('OPTION_BLOG_OVERVIEW_DISPLAY_CATEGORIES', 'inceptio_blog_overview_display_categories');
define('OPTION_BLOG_OVERVIEW_DISPLAY_COMMENTS', 'inceptio_blog_overview_display_comments');
define('OPTION_BLOG_DISPLAY_POST_NAVIGATION', 'inceptio_blog_display_post_navigation');
define('OPTION_BLOG_DISPLAY_POST_TAGS', 'inceptio_blog_display_post_tags');
define('OPTION_BLOG_DISPLAY_RELATED_POSTS', 'inceptio_blog_display_related_posts');
define('OPTION_BLOG_DISPLAY_POST_SHARING', 'inceptio_blog_display_post_sharing');
define('OPTION_BLOG_DISPLAY_POST_ABOUT_AUTHOR', 'inceptio_blog_display_post_about_author');
define('OPTION_BLOG_DISPLAY_DATE', 'inceptio_blog_display_date');
define('OPTION_BLOG_DISPLAY_AUTHOR', 'inceptio_blog_display_author');
define('OPTION_BLOG_DISPLAY_CATEGORIES', 'inceptio_blog_display_categories');
define('OPTION_BLOG_DISPLAY_COMMENTS', 'inceptio_blog_display_comments');
define('OPTION_PORTFOLIO_DISPLAY_POST_NAVIGATION', 'inceptio_portfolio_display_post_navigation');
define('OPTION_PORTFOLIO_DISPLAY_RELATED_POSTS', 'inceptio_portfolio_display_related_posts');

//Social Networks
define('OPTION_SN_ICONS_TYPE', 'inceptio_sn_icons_type');
define('OPTION_SN_FOOTER_ICONS_TYPE', 'inceptio_sn_footer_icons_type');
define('OPTION_SN_FOOTER_DISPLAY', 'inceptio_sn_footer_display');
define('OPTION_SN_TWITTER_API_URL', 'inceptio_sn_twitter_api_url');
define('OPTION_SN_TWITTER_CONSUMER_KEY', 'inceptio_sn_twitter_consumer_key');
define('OPTION_SN_TWITTER_CONSUMER_SECRET', 'inceptio_sn_twitter_consumer_secret');
define('OPTION_SN_TWITTER_ACCESS_TOKEN', 'inceptio_sn_twitter_access_token');
define('OPTION_SN_TWITTER_ACCESS_TOKEN_SECRET', 'inceptio_sn_twitter_access_token_secret');
define('OPTION_SN_TWITTER_USERNAME', 'inceptio_sn_twitter_username');
define('OPTION_SN_FACEBOOK_URL', 'inceptio_sn_facebook_url');
define('OPTION_SN_GPLUS_URL', 'inceptio_sn_gplus_url');
define('OPTION_SN_LINKEDIN_URL', 'inceptio_sn_linkedin_url');
define('OPTION_SN_FLICKR_ID', 'inceptio_sn_flickr_id');
define('OPTION_SN_VIMEO_URL', 'inceptio_sn_vimeo_url');
define('OPTION_SN_YOUTUBE_URL', 'inceptio_sn_youtube_url');
define('OPTION_SN_SKYPE_URL', 'inceptio_sn_skype_url');
define('OPTION_SN_DIGG_URL', 'inceptio_sn_digg_url');
define('OPTION_SN_DELICIOUS_URL', 'inceptio_sn_delicious_url');
define('OPTION_SN_TUMBLR_URL', 'inceptio_sn_tumblr_url');
define('OPTION_SN_DRIBBBLE_URL', 'inceptio_sn_dribbble_url');
define('OPTION_SN_STUMBLEUPON_URL', 'inceptio_sn_stumbleupon_url');

//Layout
define('OPTION_LAYOUT_TYPE', 'inceptio_layout_type');

//Style
define('OPTION_COLOR_SCHEME', 'inceptio_color_scheme');
define('OPTION_CUSTOM_COLOR_SCHEME', 'inceptio_custom_color_scheme');


define('SETTINGS_THEME_SIDEBARS', 'inceptio_theme_sidebars');
define('SETTINGS_PAGE_SIDEBAR_NAME', 'inceptio_page_sidebar_name');
define('SETTINGS_PAGE_CONTENT_ALIGN', 'inceptio_page_content_align');
define('SETTINGS_PAGE_TITLE_BAR_VISIBLE', 'inceptio_page_title_bar_visible');

//Slider
define('SETTINGS_PAGE_MEDIA_SETTINGS', 'inceptio_page_media_settings');
//Portfolio
define('SETTINGS_PORTFOLIO_CUSTOMER', 'inceptio_portfolio_customer');
define('SETTINGS_PORTFOLIO_YEAR', 'inceptio_portfolio_year');
define('SETTINGS_PORTFOLIO_TECHNOLOGIES', 'inceptio_portfolio_technologies');
define('SETTINGS_PORTFOLIO_URL', 'inceptio_portfolio_url');
define('SETTINGS_PORTFOLIO_TEMPLATE', 'inceptio_portfolio_template');
define('SETTINGS_PORTFOLIO_OVERVIEW_SETTINGS', 'inceptio_portfolio_overview_settings');


define('SETTINGS_SLIDERS', 'inceptio_sliders');
define('SETTINGS_FLEX_SLIDER_TYPE', 'flex');
define('SETTINGS_REV_SLIDER_TYPE', 'rev');

include_once (get_template_directory() . '/custom.php');

if (!isset($content_width)) {
    $content_width = 900;
}

if (!function_exists('__inc')) {
    function __inc($value)
    {
        return apply_filters('widget_text', $value);
    }
}

//---------------------------------------------- BROWSER DETECTION -----------------------------------------------------
if (IS_BROWSER_COMPATIBILITY_CHECK_ENABLED) {
    add_filter('init', 'browser_compatibility_check_filter');
    function browser_compatibility_check_filter()
    {
        if (isset($_REQUEST['unsupported']) && $_REQUEST['unsupported'] == 'true') {
            include INCEPTIO_ROOT_PATH . '/update-browser.php';
            exit;
        }
    }
}

//------------------------------------------------- THEME SETUP --------------------------------------------------------
add_action('after_setup_theme', 'inceptio_setup');
if (!function_exists('inceptio_setup')) {
    function inceptio_setup()
    {

        //---------------------------------------- LOAD INTERNATIONALIZATION -------------------------------------------
        load_theme_textdomain(INCEPTIO_THEME_NAME, get_template_directory() . '/lang');

        //---------------------------------------- LOAD STYLES & SCRIPTS -----------------------------------------------
        add_action('wp_enqueue_scripts', 'inc_scripts_styles');
        add_action('admin_enqueue_scripts', 'inc_admin_scripts');

        //---------------------------------------- THEME CONFIGURATION -------------------------------------------------
        add_theme_support('automatic-feed-links');
        add_theme_support('post-formats', array('image', 'gallery', 'audio', 'video', 'aside', 'quote', 'link'));
        add_theme_support('post-thumbnails');
        add_filter('excerpt_length', 'inc_excerpt_length');
        register_custom_image_sizes();

        //---------------------------------------- MENU CONFIGURATION --------------------------------------------------
        register_nav_menus(array(
            'primary' => 'Main Menu',
            'footer' => 'Footer Menu',
        ));

        $has_at_least_one_menu_item_defined = inc_has_menu_at_least_one_item_defined();
        $GLOBALS['simple_menu_walker'] = $has_at_least_one_menu_item_defined ? new Inceptio_Main_Menu_Walker() : '';
        $GLOBALS['header_menu_walker'] = $has_at_least_one_menu_item_defined ? new Inceptio_Main_Menu_Walker('header') : '';
        $GLOBALS['footer_menu_walker'] = $has_at_least_one_menu_item_defined ? new Inceptio_Main_Menu_Walker('footer') : '';

        //------------------------------------------- SIDEBAR SECTION --------------------------------------------------
        inc_register_sidebars();
        add_filter('dynamic_sidebar_params', 'inc_configure_footer_sidebar_params');

        //------------------------------------------- WIDGETS SECTION --------------------------------------------------
        add_action('widgets_init', 'inc_register_widgets');

        //------------------------------------------ PORTFOLIO SECTION -------------------------------------------------
        $portfolio_args = array(
            'label' => __('Portfolio', INCEPTIO_THEME_NAME),
            'singular_label' => __('Portfolio', INCEPTIO_THEME_NAME),
            'public' => true,
            'rewrite' => true,
            'show_ui' => true,
            'capability_type' => 'post',
            'hierarchical' => false,
            'show_in_nav_menus' => true,
            'supports' => array('title', 'editor', 'post-formats', 'thumbnail', 'comments', 'custom-fields', 'excerpt')
        );
        register_post_type('portfolio', $portfolio_args);
        add_action('init', 'inc_register_portfolio_taxonomy');
        add_action("template_redirect", 'inc_portfolio_template_redirect');

        $shortcode_manager = new Inc_Shortcode_Manager();
        $GLOBALS['shortcode_manager'] = $shortcode_manager;
        //Elements
        $shortcode_manager->add_shortcode(new Inc_Button_Shortcode());
        $shortcode_manager->add_shortcode(new Inc_Iconbox_Shortcode());
        $shortcode_manager->add_shortcode(new Inc_Intro_Shortcode());
        $shortcode_manager->add_shortcode(new Inc_Infobox_Shortcode());
        $shortcode_manager->add_shortcode(new Inc_Posts_Gallery_Shortcode());
        $shortcode_manager->add_shortcode(new Inc_Blockquote_Shortcode());
        $shortcode_manager->add_shortcode(new Inc_Social_Icons_Shortcode());
        $shortcode_manager->add_shortcode(new Inc_Team_Member_Shortcode());
        $shortcode_manager->add_shortcode(new Inc_Clients_Shortcode());
        $shortcode_manager->add_shortcode(new Inc_Process_Shortcode());
        //Dynamic Elements
        $shortcode_manager->add_shortcode(new Inc_Tabs_Shortcode());
        $shortcode_manager->add_shortcode(new Inc_Toggles_Shortcode());
        $shortcode_manager->add_shortcode(new Inc_Notification_Box_Shortcode());
        $shortcode_manager->add_shortcode(new Inc_Testimonials_Carousel());
        $shortcode_manager->add_shortcode(new Inc_News_Shortcode());
        //Media
        $shortcode_manager->add_shortcode(new Inc_Image_Shortcode());
        $shortcode_manager->add_shortcode(new Inc_Image_Gallery_Shortcode());
        $shortcode_manager->add_shortcode(new Inc_Slider_Shortcode());
        $shortcode_manager->add_shortcode(new Inc_Audio_Shortcode());
        $shortcode_manager->add_shortcode(new Inc_Video_Shortcode());
        //Typography
        $shortcode_manager->add_shortcode(new Inc_Dropcap_Shortcode());
        $shortcode_manager->add_shortcode(new Inc_Highlight_Shortcode());
        $shortcode_manager->add_shortcode(new Inc_Computer_Code_Shortcode());
        $shortcode_manager->add_shortcode(new Inc_List_Shortcode());
        $shortcode_manager->add_shortcode(new Inc_Divider_Shortcode());
        $shortcode_manager->add_shortcode(new Inc_Horizontal_Space_Shortocode());
        //Layout
        $shortcode_manager->add_shortcode(new Inc_Container_Shortcode());
        $shortcode_manager->add_shortcode(new Inc_Grid_Columns_Shortcode());
        //Table
        $shortcode_manager->add_shortcode(new Inc_Table_Shortcode());
        $shortcode_manager->add_shortcode(new Inc_Pricing_Table_Shortcodes());
        //Others
        $shortcode_manager->add_shortcode(new Inc_Site_Map_Shortcode());
        $shortcode_manager->add_shortcode(new Inc_Form_Shortcode());
        $shortcode_manager->add_shortcode(new Inc_Tooltip_Shortcode());
        $shortcode_manager->add_shortcode(new Inc_GMap_Shortcode());
        $shortcode_manager->add_shortcode(new Inc_Contact_Shortcode());

        $shortcode_manager->add_shortcode(new Inc_Wrap_Shortcode());
        $shortcode_manager->add_shortcode(new Inc_Clear_Shortcode());
        $shortcode_manager->add_shortcode(new Inc_Captcha_Shortcode());
        $shortcode_manager->add_shortcode(new Inc_Display_Shortcode());

        $shortcode_manager->register_shortcodes();

        $page_media_manager = new Page_Media_Manager();
        $GLOBALS['page_media_manager'] = $page_media_manager;
        $page_contact_manager = new Page_Contact_Manager();
        $GLOBALS['page_contact_manager'] = $page_contact_manager;
        $posts_overview_manager = new Posts_Overview_Manager();
        $GLOBALS['posts_overview_manager'] = $posts_overview_manager;
        $blog_overview_manager = new Blog_Overview_Manager();
        $GLOBALS['blog_overview_manager'] = $blog_overview_manager;

        $mobile_detect = new Mobile_Detect();
        $GLOBALS['inc_mobile_detect'] = $mobile_detect;
        $GLOBALS['inc_device_type'] = ($mobile_detect->isMobile() ? ($mobile_detect->isTablet() ? 'tablet' : 'phone') : 'computer');
        do_action('inc_after_setup');
    }
}

//-------------------------------------- LOADING SCRIPTS & STYLES METHODS-----------------------------------------------
if (!function_exists('inc_scripts_styles')) {
    function inc_scripts_styles()
    {
        global $wp_styles;
        global $wp_scripts;
        $template_uri = get_template_directory_uri();

        wp_enqueue_style('inceptio-style', get_stylesheet_uri());
        wp_enqueue_style('inceptio-ie', get_template_directory_uri() . '/css/ie.css', array('inceptio-style'), INCEPTIO_THEME_VERSION);
        $wp_styles->add_data('inceptio-ie', 'conditional', 'IE');
        wp_enqueue_style('inceptio-mediaelementplayer', $template_uri . '/css/mediaelementplayer.css', array('inceptio-style', 'inceptio-ie'), INCEPTIO_THEME_VERSION);

        if (inc_is_responsive_enabled()) {
            wp_enqueue_style('responsive-style', $template_uri . '/css/responsive.css', array('inceptio-style'), INCEPTIO_THEME_VERSION);
        }

        $default_colors_scheme = array('green', 'retro-green', 'teal', 'orange', 'yellow', 'indigo', 'blue', 'red', 'purple', 'pink');
        $site_color_scheme = inc_get_site_color_scheme();
        if (in_array($site_color_scheme, $default_colors_scheme)) {
            wp_enqueue_style('color-style', $template_uri . '/css/colors/' . $site_color_scheme . '.css', array('inceptio-style', 'inceptio-ie'), INCEPTIO_THEME_VERSION);
        } else {
            wp_enqueue_style('color-style', site_url('wp-admin/admin-ajax.php') . '?action=inc-color-style', array('inceptio-style', 'inceptio-ie'), INCEPTIO_THEME_VERSION);
        }
        wp_enqueue_style('custom-style', $template_uri . '/custom.css', array('inceptio-style', 'inceptio-ie', 'color-style'), INCEPTIO_THEME_VERSION);

        wp_enqueue_script('modernizr', $template_uri . '/js/modernizr.custom.js');
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-browser', $template_uri . '/js/jquery.browser-min.js', array('jquery'), INCEPTIO_THEME_VERSION, true);
        wp_enqueue_script('froogaloop', $template_uri . '/js/froogaloop.min.js', array('jquery'), INCEPTIO_THEME_VERSION, true);
        if (IS_BROWSER_COMPATIBILITY_CHECK_ENABLED) {
            wp_enqueue_script('browser-check', $template_uri . '/js/ie.js', array('jquery', 'jquery-browser'), INCEPTIO_THEME_VERSION, true);
        }
        wp_enqueue_script('jquery-easing', $template_uri . '/js/jquery.easing.1.3.js', array('jquery'), INCEPTIO_THEME_VERSION, true);
        if (inc_is_ie_version(8)) {
            wp_enqueue_script('respond', $template_uri . '/js/respond.min.js', array('jquery', 'jquery-easing', 'modernizr'), INCEPTIO_THEME_VERSION, true);
            wp_enqueue_script('selectivizr', $template_uri . '/js/selectivizr-min.js', array('jquery', 'jquery-easing', 'modernizr', 'respond'), INCEPTIO_THEME_VERSION, true);
        }
        wp_enqueue_script('ddlevelsmenu', $template_uri . '/js/ddlevelsmenu.js', array('jquery', 'jquery-easing', 'modernizr'), INCEPTIO_THEME_VERSION, true);
        wp_enqueue_script('ddlevelsmenu-invoker', $template_uri . '/js/ddlevelsmenu-invoker.js', array('jquery', 'jquery-easing', 'modernizr', 'ddlevelsmenu'), INCEPTIO_THEME_VERSION, true);
        wp_enqueue_script('tinynav', $template_uri . '/js/tinynav.min.js', array('jquery', 'ddlevelsmenu', 'ddlevelsmenu-invoker'), INCEPTIO_THEME_VERSION, true);
        wp_enqueue_script('jquery-validate', $template_uri . '/js/jquery.validate.min.js', array('jquery', 'ddlevelsmenu', 'ddlevelsmenu-invoker'), INCEPTIO_THEME_VERSION, true);
        wp_enqueue_script('jquery-isotope', $template_uri . '/js/jquery.isotope.min.js', array('jquery', 'ddlevelsmenu', 'ddlevelsmenu-invoker'), INCEPTIO_THEME_VERSION, true);
        wp_enqueue_script('jquery-ui', $template_uri . '/js/jquery-ui-1.10.1.custom.min.js', array('jquery', 'ddlevelsmenu', 'ddlevelsmenu-invoker'), INCEPTIO_THEME_VERSION, true);
        wp_enqueue_script('jquery-flexslider', $template_uri . '/js/jquery.flexslider-min.js', array('jquery', 'ddlevelsmenu', 'ddlevelsmenu-invoker'), INCEPTIO_THEME_VERSION, true);
        wp_enqueue_script('jquery-jcarousel', $template_uri . '/js/jquery.jcarousel.min.js', array('jquery', 'ddlevelsmenu', 'ddlevelsmenu-invoker'), INCEPTIO_THEME_VERSION, true);
        wp_enqueue_script('jquery-totop', $template_uri . '/js/jquery.ui.totop.min.js', array('jquery', 'ddlevelsmenu', 'ddlevelsmenu-invoker'), INCEPTIO_THEME_VERSION, true);
        wp_enqueue_script('jquery-fitvids', $template_uri . '/js/jquery.fitvids.js', array('jquery', 'ddlevelsmenu', 'ddlevelsmenu-invoker'), INCEPTIO_THEME_VERSION, true);
        wp_enqueue_script('jquery-tweet', $template_uri . '/js/jquery.tweet.js', array('jquery', 'ddlevelsmenu', 'ddlevelsmenu-invoker'), INCEPTIO_THEME_VERSION, true);
        wp_enqueue_script('jquery-jflickrfeed', $template_uri . '/js/jflickrfeed.min.js', array('jquery', 'ddlevelsmenu', 'ddlevelsmenu-invoker'), INCEPTIO_THEME_VERSION, true);
        wp_enqueue_script('googleapis', HTTP_PROTOCOL . '://maps.googleapis.com/maps/api/js?sensor=false', array(), INCEPTIO_THEME_VERSION, true);
        wp_enqueue_script('jquery-gmap', $template_uri . '/js/jquery.gmap.min.js', array('jquery', 'googleapis'), INCEPTIO_THEME_VERSION, true);
        wp_enqueue_script('jquery-tipsy', $template_uri . '/js/jquery.tipsy.js', array('jquery', 'ddlevelsmenu', 'ddlevelsmenu-invoker'), INCEPTIO_THEME_VERSION, true);
//        wp_enqueue_script('jquery-revslider-plugins', $template_uri . '/js/jquery.themepunch.plugins.min.js', array('jquery', 'ddlevelsmenu', 'ddlevelsmenu-invoker'), INCEPTIO_THEME_VERSION, true);
//        wp_enqueue_script('jquery-revslider', $template_uri . '/js/jquery.themepunch.revolution.min.js', array('jquery', 'ddlevelsmenu', 'ddlevelsmenu-invoker'), INCEPTIO_THEME_VERSION, true);
        wp_enqueue_script('jquery-fancybox-pack', $template_uri . '/js/jquery.fancybox.pack.js', array('jquery', 'ddlevelsmenu', 'ddlevelsmenu-invoker'), INCEPTIO_THEME_VERSION, true);
        wp_enqueue_script('jquery-fancybox-media', $template_uri . '/js/jquery.fancybox-media.js', array('jquery', 'ddlevelsmenu', 'ddlevelsmenu-invoker'), INCEPTIO_THEME_VERSION, true);
        if (IS_STYLE_SWITCHER_ENABLED) {
            wp_enqueue_style('style-switcher-style', $template_uri . '/style-switcher/style-switcher.css');
            wp_enqueue_script('style-switcher', $template_uri . '/style-switcher/style-switcher.js', array('jquery'), INCEPTIO_THEME_VERSION, true);
        }
        wp_enqueue_script('form-processor', $template_uri . '/js/form-processor.js', array('jquery'), INCEPTIO_THEME_VERSION, true);
        if (is_singular() && get_option('thread_comments') && get_option('thread_comments')) {
            wp_enqueue_script('comment-reply', false, array(), INCEPTIO_THEME_VERSION, true);
        }
        wp_enqueue_script('custom', $template_uri . '/js/custom.js', array('jquery', 'ddlevelsmenu', 'ddlevelsmenu-invoker', 'form-processor'), INCEPTIO_THEME_VERSION, true);
        do_action('inc_after_enqueue_all');
    }
}

if (!function_exists('inc_admin_scripts')) {
    function inc_admin_scripts($hook)
    {
        global $wp_version;
        $accepted_hooks = array('post-new.php', 'post.php', 'index.php');
        $current_screen = get_current_screen();
        $pos = strpos($hook, 'inc-');
        if ($current_screen->id != 'media-upload' && ($pos !== false || in_array($hook, $accepted_hooks))) {
            $template_url = get_template_directory_uri();
            wp_enqueue_script('thickbox');
            wp_enqueue_script('jquery');
            wp_enqueue_script('jquery-ui-core', 'jquery');
            wp_enqueue_script('jquery-ui-tabs', 'jquery');
            wp_enqueue_script('jquery-ui-dialog', 'jquery');
            wp_enqueue_script('jquery-ui-accordion', 'jquery');
            wp_enqueue_script('jquery-ui-draggable', 'jquery');
            wp_enqueue_script('jquery-ui-droppable', 'jquery');
            wp_enqueue_script('jquery-ui-sortable', 'jquery');
            wp_enqueue_script('jquery-ui-position', 'jquery');
            wp_enqueue_script('media-upload');
            wp_enqueue_script('jquery-validate', $template_url . '/admin/js/jquery.validate.min.js', array('jquery'));
            wp_enqueue_script('color-picker', $template_url . '/admin/js/colorpicker.js', array('jquery'));
            wp_enqueue_script('js-base64', $template_url . '/admin/js/base64.js', array('jquery'));
            wp_enqueue_script('inc-admin-script', $template_url . '/admin/js/admin.js', array('jquery', 'jquery-validate',
                    'jquery-ui-core', 'jquery-ui-tabs', 'jquery-ui-accordion', 'jquery-ui-draggable', 'jquery-ui-droppable',
                    'jquery-ui-sortable', 'jquery-ui-position', 'media-upload', 'thickbox', 'color-picker', 'js-base64',
                    'jquery-ui-dialog'),
                INCEPTIO_THEME_VERSION);
            wp_enqueue_script('inc-shortcode-editor', $template_url . '/admin/js/shortcode-editor.js', array('jquery',
                    'jquery-validate', 'jquery-ui-core', 'jquery-ui-tabs', 'jquery-ui-accordion', 'jquery-ui-draggable',
                    'jquery-ui-droppable', 'jquery-ui-sortable', 'jquery-ui-position', 'media-upload', 'thickbox',
                    'color-picker', 'inc-admin-script', 'js-base64', 'jquery-ui-dialog'),
                INCEPTIO_THEME_VERSION);
            wp_enqueue_script('inc-media-editor', $template_url . '/admin/js/media-editor.js', array('jquery',
                    'jquery-validate', 'jquery-ui-core', 'jquery-ui-tabs', 'jquery-ui-accordion', 'jquery-ui-draggable',
                    'jquery-ui-droppable', 'jquery-ui-sortable', 'jquery-ui-position', 'media-upload', 'thickbox',
                    'color-picker', 'inc-admin-script', 'js-base64', 'jquery-ui-dialog'),
                INCEPTIO_THEME_VERSION);

            wp_enqueue_style('thickbox');
            if (version_compare($wp_version, '3.6', '<')) {
                wp_enqueue_style('dialog-style', $template_url . '/admin/css/jquery.ui.dialog.css');
            }else{
                wp_enqueue_style('wp-jquery-ui-dialog');
            }
            wp_enqueue_style('colorpicker-style', $template_url . '/admin/css/colorpicker.css');
            wp_enqueue_style('custom-admin-style', $template_url . '/admin/css/admin-style.css');
            do_action('inc_after_admin_enqueue_script');
        }
    }
}

//--------------------------------------------- THEME CONFIGURATION ----------------------------------------------------

if (!function_exists('inc_excerpt_length')) {
    function inc_excerpt_length($length)
    {
        return 999999;
    }
}

if (!function_exists('register_custom_image_sizes')) {
    function register_custom_image_sizes()
    {
        $image_sizes = array();
        $image_sizes[] = array('name' => 'inc-small', 'width' => 220, 'height' => 140, 'crop' => true);
        $image_sizes[] = array('name' => 'inc-home-slider', 'width' => 940, 'height' => 400, 'crop' => true);
        $image_sizes[] = array('name' => 'inc-post-gallery-thumb', 'width' => 460, 'height' => 292, 'crop' => true);
        $image_sizes[] = array('name' => 'inc-portfolio-full', 'width' => 940, 'height' => 598, 'crop' => true);
        $image_sizes[] = array('name' => 'inc-portfolio-sidebar', 'width' => 700, 'height' => 445, 'crop' => true);
        $image_sizes[] = array('name' => 'inc-blog-post-sidebar', 'width' => 700, 'height' => 300, 'crop' => true);

        $image_sizes = apply_filters('inc_image_size', $image_sizes);
        foreach ($image_sizes as $image_size) {
            add_image_size($image_size['name'], $image_size['width'], $image_size['height'], $image_size['crop']);
        }
    }
}

//--------------------------------------------- STYLE CONFIGURATION ----------------------------------------------------

add_action('admin_head', 'inc_custom_admin_head_page');
if (!function_exists('inc_custom_admin_head_page')) {
    function inc_custom_admin_head_page()
    {
        echo inc_get_admin_custom_css();
    }
}

add_action('wp_head', 'inc_custom_head_page');
if (!function_exists('inc_custom_head_page')) {
    function inc_custom_head_page()
    {
        echo inc_get_custom_css();
    }
}

//------------------------------------------- PLUGINS INITIALIZATION ---------------------------------------------------
require_once (get_template_directory() . '/api/plugin/Abstract_Plugin.php');
require_once (get_template_directory() . '/api/plugin/Inc_Plugin_Manager.php');
require_once (get_template_directory() . '/api/plugin/Inc_Font_Manager_Plugin.php');
require_once (get_template_directory() . '/api/plugin/Inc_Sidebar_Manager_Plugin.php');
require_once (get_template_directory() . '/api/plugin/Inc_Import_Manager_Plugin.php');
require_once (get_template_directory() . '/api/plugin/Inc_Help_Manager_Plugin.php');
require_once (get_template_directory() . '/api/plugin/Inc_Abstract_Slider_Manager_Plugin.php');
require_once (get_template_directory() . '/api/plugin/Inc_Flex_Slider_Manager_Plugin.php');

$sidebar_manager = new Inc_Sidebar_Manager_Plugin();
$font_manager = new Inc_Font_Manager_Plugin();
$flex_slider_manager = new Inc_Flex_Slider_Manager_Plugin();
$demo_import_manager = new Inc_Import_Manager_Plugin();
$online_doc_manager = new Inc_Help_Manager_Plugin();

$plugin_manager = new Inc_Plugin_Manager();
$plugin_manager->register_plugin($sidebar_manager);
$plugin_manager->register_plugin($font_manager);
$plugin_manager->register_plugin($flex_slider_manager);
$plugin_manager->register_plugin($demo_import_manager);
$plugin_manager->register_plugin($online_doc_manager);
$plugin_manager->load_plugins();

//----------------------------------------------- CLASS LOADING --------------------------------------------------------
require_once (get_template_directory() . '/api/menu/Inceptio_Main_Menu_Walker.php');
require_once (get_template_directory() . '/api/util.php');
require_once (get_template_directory() . '/api/theme-options.php');
require_once (get_template_directory() . '/api/header-util.php');
require_once (get_template_directory() . '/api/comments-util.php');
require_once (get_template_directory() . '/api/form-processor.php');
require_once (get_template_directory() . '/api/twitter-util.php');
require_once (get_template_directory() . '/api/util/Mobile_Detect.php');
require_once (get_template_directory() . '/api/util/Email_Util.php');
require_once (get_template_directory() . '/api/util/Media_Util.php');
require_once (get_template_directory() . '/api/util/Post_Util.php');
require_once (get_template_directory() . '/api/util/Page_Media_Manager.php');
require_once (get_template_directory() . '/api/util/Page_Contact_Manager.php');
require_once (get_template_directory() . '/api/util/Posts_Overview_Manager.php');
require_once (get_template_directory() . '/api/util/Blog_Overview_Manager.php');
//widgets
require_once (get_template_directory() . '/api/widget/Abstract_Inc_Widget.php');
require_once (get_template_directory() . '/api/widget/Inc_Text_Widget.php');
require_once (get_template_directory() . '/api/widget/Inc_Latest_Tweets_Widget.php');
require_once (get_template_directory() . '/api/widget/Inc_Flickr_Widget.php');
require_once (get_template_directory() . '/api/widget/Inc_Contact_Details_Widget.php');
require_once (get_template_directory() . '/api/widget/Inc_Archives_Widget.php');
require_once (get_template_directory() . '/api/widget/Inc_Categories_Widget.php');
require_once (get_template_directory() . '/api/widget/Inc_Recent_Posts_Widget.php');
require_once (get_template_directory() . '/api/widget/Inc_Recent_Comments_Widget.php');
require_once (get_template_directory() . '/api/widget/Inc_Meta_Widget.php');
require_once (get_template_directory() . '/api/widget/Inc_Pages_Widget.php');
require_once (get_template_directory() . '/api/widget/Inc_Most_Used_Tags_Widget.php');
require_once (get_template_directory() . '/api/widget/Inc_Tag_Cloud_Widget.php');
require_once (get_template_directory() . '/api/widget/Inc_Newsletter_Subscription_Widget.php');
require_once (get_template_directory() . '/api/widget/Inc_Shortcode_Eval_Widget.php');
//shortcodes
require_once (get_template_directory() . '/api/shortcode/Inc_Carousel_Settings.php');
require_once (get_template_directory() . '/api/shortcode/Abstract_Inc_Shortcode.php');
require_once (get_template_directory() . '/api/shortcode/Inc_Shortcode_Designer.php');
require_once (get_template_directory() . '/api/shortcode/Inc_Shortcode_Manager.php');
require_once (get_template_directory() . '/api/shortcode/Inc_Button_Shortcode.php');
require_once (get_template_directory() . '/api/shortcode/Inc_Tabs_Shortcode.php');
require_once (get_template_directory() . '/api/shortcode/Inc_Toggles_Shortcode.php');
require_once (get_template_directory() . '/api/shortcode/Inc_Notification_Box_Shortcode.php');
require_once (get_template_directory() . '/api/shortcode/Inc_Testimonials_Carousel.php');
require_once (get_template_directory() . '/api/shortcode/Inc_Iconbox_Shortcode.php');
require_once (get_template_directory() . '/api/shortcode/Inc_Intro_Shortcode.php');
require_once (get_template_directory() . '/api/shortcode/Inc_Infobox_Shortcode.php');
require_once (get_template_directory() . '/api/shortcode/Inc_Dropcap_Shortcode.php');
require_once (get_template_directory() . '/api/shortcode/Inc_Highlight_Shortcode.php');
require_once (get_template_directory() . '/api/shortcode/Inc_Computer_Code_Shortcode.php');
require_once (get_template_directory() . '/api/shortcode/Inc_Blockquote_Shortcode.php');
require_once (get_template_directory() . '/api/shortcode/Inc_List_Shortcode.php');
require_once (get_template_directory() . '/api/shortcode/Inc_Divider_Shortcode.php');
require_once (get_template_directory() . '/api/shortcode/Inc_Horizontal_Space_Shortocode.php');
require_once (get_template_directory() . '/api/shortcode/Inc_Table_Shortcode.php');
require_once (get_template_directory() . '/api/shortcode/Inc_Pricing_Table_Shortcodes.php');
require_once (get_template_directory() . '/api/shortcode/Inc_Process_Shortcode.php');
require_once (get_template_directory() . '/api/shortcode/Inc_Container_Shortcode.php');
require_once (get_template_directory() . '/api/shortcode/Inc_Wrap_Shortcode.php');
require_once (get_template_directory() . '/api/shortcode/Inc_Clear_Shortcode.php');
require_once (get_template_directory() . '/api/shortcode/Inc_Grid_Columns_Shortcode.php');
require_once (get_template_directory() . '/api/shortcode/Inc_Image_Shortcode.php');
require_once (get_template_directory() . '/api/shortcode/Inc_Image_Gallery_Shortcode.php');
require_once (get_template_directory() . '/api/shortcode/Inc_Posts_Gallery_Shortcode.php');
require_once (get_template_directory() . '/api/shortcode/Inc_News_Shortcode.php');
require_once (get_template_directory() . '/api/shortcode/Inc_Slider_Shortcode.php');
require_once (get_template_directory() . '/api/shortcode/Inc_Audio_Shortcode.php');
require_once (get_template_directory() . '/api/shortcode/Inc_Video_Shortcode.php');
require_once (get_template_directory() . '/api/shortcode/Inc_Social_Icons_Shortcode.php');
require_once (get_template_directory() . '/api/shortcode/Inc_Team_Member_Shortcode.php');
require_once (get_template_directory() . '/api/shortcode/Inc_Clients_Shortcode.php');
require_once (get_template_directory() . '/api/shortcode/Inc_Captcha_Shortcode.php');
require_once (get_template_directory() . '/api/shortcode/Inc_Site_Map_Shortcode.php');
require_once (get_template_directory() . '/api/shortcode/Inc_Form_Shortcode.php');
require_once (get_template_directory() . '/api/shortcode/Inc_GMap_Shortcode.php');
require_once (get_template_directory() . '/api/shortcode/Inc_Tooltip_Shortcode.php');
require_once (get_template_directory() . '/api/shortcode/Inc_Contact_Shortcode.php');
require_once (get_template_directory() . '/api/shortcode/Inc_Display_Shortcode.php');

if (is_user_logged_in()) {
    require_once (get_template_directory() . '/api/admin/X_Meta_Box.php');
    require_once (get_template_directory() . '/api/admin/page/Page_Customizer.php');
    require_once (get_template_directory() . '/api/admin/page/Basic_Page_Customizer.php');
    require_once (get_template_directory() . '/api/admin/page/Post_Page_Customizer.php');
    require_once (get_template_directory() . '/api/admin/page/Portfolio_Page_Customizer.php');
    require_once (get_template_directory() . '/api/admin/admin-page-config.php');
}

//---------------------------------------------- SIDEBARS SECTION ------------------------------------------------------
if (!function_exists('inc_register_sidebars')) {
    function inc_register_sidebars()
    {
        register_sidebar(array(
            'name' => __(INCEPTIO_SIDEBAR_DEFAULT, INCEPTIO_THEME_NAME),
            'id' => 'default-sidebar',
            'description' => __('The default sidebar', INCEPTIO_THEME_NAME),
            'before_widget' => '<div class="widget">',
            'before_title' => '<h3>',
            'after_title' => '</h3>',
            'after_widget' => '</div>'
        ));

        register_sidebar(array(
            'name' => __(INCEPTIO_SIDEBAR_FOOTER, INCEPTIO_THEME_NAME),
            'id' => 'footer-sidebar',
            'description' => __('The footer sidebar', INCEPTIO_THEME_NAME),
            'before_widget' => '<div class="widget">',
            'before_title' => '<h3>',
            'after_title' => '</h3>',
            'after_widget' => '</div>'
        ));

        register_sidebar(array(
            'name' => __(INCEPTIO_SIDEBAR_PORTFOLIO_CATEGORY, INCEPTIO_THEME_NAME),
            'id' => 'portfolio-category-sidebar',
            'description' => __('The portfolio category sidebar', INCEPTIO_THEME_NAME),
            'before_widget' => '<div class="widget">',
            'before_title' => '<h3>',
            'after_title' => '</h3>',
            'after_widget' => '</div>'
        ));

        $sidebars = inc_get_all_sidebars();
        foreach ($sidebars as $sidebar) {
            register_sidebar(array(
                'id' => $sidebar['id'],
                'name' => $sidebar['name'],
                'description' => $sidebar['description'],
                'before_widget' => '<div class="widget">',
                'before_title' => '<h3>',
                'after_title' => '</h3>',
                'after_widget' => '</div>'
            ));
        }
    }
}

if (!function_exists('inc_configure_footer_sidebar_params')) {
    function inc_configure_footer_sidebar_params($params)
    {
        if ($params[0]['name'] == INCEPTIO_SIDEBAR_FOOTER) {
            $sidebars = wp_get_sidebars_widgets();
            $widgets = $sidebars[$params[0]['id']];
            $widgets_count = count($widgets);
            $class_names = '';

            if ($widgets_count > 0) {
                if ($widgets_count == 2) {
                    $class_names = 'one-half';
                } else if ($widgets_count == 3) {
                    $class_names = 'one-third';
                } else if ($widgets_count == 4) {
                    $class_names = 'one-fourth';
                }
            }
            if (strlen($class_names) > 0) {
                $widget_position = -1;
                foreach ($widgets as $i => $widget) {
                    if ($widget == $params[0]['widget_id']) {
                        $widget_position = ($i + 1);
                    }
                }
                if ($widget_position == $widgets_count) {
                    $class_names .= ' column-last';
                }
                $class = ' class="' . $class_names . '"';
            } else {
                $class = '';
            }
            $params[0]['before_widget'] = '<div' . $class . '>' . $params[0]['before_widget'];
            $params[0]['after_widget'] .= '</div>';
        }
        return $params;
    }
}

//------------------------------------------------ WIDGETS SECTION -----------------------------------------------------
if (!function_exists('inc_register_widgets')) {
    function inc_register_widgets()
    {
        unregister_widget('WP_Widget_Text');
        register_widget(Abstract_Inc_Widget::$TEXT_WIDGET);
        unregister_widget('WP_Widget_Archives');
        register_widget(Abstract_Inc_Widget::$POST_ARCHIVES);
        unregister_widget('WP_Widget_Categories');
        register_widget(Abstract_Inc_Widget::$POST_CATEGORIES);
        unregister_widget('WP_Widget_Recent_Posts');
        register_widget(Abstract_Inc_Widget::$RECENT_POSTS);
        unregister_widget('WP_Widget_Recent_Comments');
        register_widget(Abstract_Inc_Widget::$RECENT_COMMENTS);
        unregister_widget('WP_Widget_Meta');
        register_widget(Abstract_Inc_Widget::$META);
        unregister_widget('WP_Widget_Tag_Cloud');
        register_widget(Abstract_Inc_Widget::$TAGS_CLOUD);
        unregister_widget('WP_Widget_Pages');
        register_widget(Abstract_Inc_Widget::$PAGES);

        register_widget(Abstract_Inc_Widget::$LATEST_TWEETS_WIDGET);
        register_widget(Abstract_Inc_Widget::$CONTACT_DETAILS_WIDGET);
        register_widget(Abstract_Inc_Widget::$FLICKR_WIDGET);
        register_widget(Abstract_Inc_Widget::$MOST_USED_TAGS);
        register_widget(Abstract_Inc_Widget::$NEWSLETTER_SUBSCRIPTION);
        register_widget(Abstract_Inc_Widget::$SHORTCODE_EVALUATOR);
    }
}

//----------------------------------------------- PORTFOLIO SECTION ----------------------------------------------------
if (!function_exists('inc_register_portfolio_taxonomy')) {
    function inc_register_portfolio_taxonomy()
    {
        register_taxonomy('filter', 'portfolio',
            array('hierarchical' => true,
                'label' => __('Categories', INCEPTIO_THEME_NAME),
                'query_var' => true,
                'show_in_nav_menus' => false,
                'rewrite' => array('slug' => 'filter'))
        );
    }
}

if (!function_exists('inc_portfolio_template_redirect')) {
    function inc_portfolio_template_redirect()
    {
        global $wp_query;
        if ($wp_query->query_vars["post_type"] == "portfolio") {
            if (have_posts()) {
                $template = inc_get_portfolio_template();
                get_template_part('template-portfolio-' . $template);
                die();
            } else {
                $wp_query->is_404 = true;
            }
        } elseif (is_tax('filter')) {
            $template = apply_filters('inc_tax_template_redirect', 'template-portfolio-category');
            get_template_part($template);
            die();
        }
        wp_reset_postdata();
    }
}

if (inc_is_internationalization_enabled()) {

    add_filter('inc_languages', 'inc_get_languages');

    if (!function_exists('inc_get_languages')) {
        function inc_get_languages()
        {
            if (function_exists('icl_get_languages')) {
                return print_wpml_language_switcher();
            } elseif (function_exists('qtrans_getSortedLanguages')) {
                return get_qtranslate_languages();
            } elseif (isset($GLOBALS['my_transposh_plugin'])) {
                return print_transposh_language_switcher();
            } else {
                return array();
            }
        }
    }

    if (!function_exists('print_wpml_language_switcher')) {
        function print_wpml_language_switcher()
        {
            $languages = array();
            $wpml_languages = icl_get_languages('skip_missing=1');
            foreach ($wpml_languages as $lang) {
                $lang_link = apply_filters('inc_language_link', $lang['url']);
                $lang_flag = apply_filters('inc_language_flag', $lang['country_flag_url']);
                $languages[] = array(
                    'flag' => $lang_flag,
                    'name' => $lang['native_name'],
                    'url' => $lang_link,
                    'default' => $lang['active']);
            }
            return $languages;
        }
    }

    if (!function_exists('get_qtranslate_languages')) {
        function get_qtranslate_languages()
        {
            $languages = array();
            global $q_config;
            $supported_languages = qtrans_getSortedLanguages();
            foreach ($supported_languages as $language) {
                $lang_name = $q_config['language_name'][$language];
                $is_default = $language == $q_config['language'];
                $lang_id = strtolower($language);
                if ($lang_id == 'en') {
                    $lang_id = 'gb';
                }
                $lang_id = apply_filters('inc_language_id', $lang_id);
                $lang_flag = apply_filters('inc_language_flag', '/images/flags/' . $lang_id . '.png');
                $lang_link = get_permalink();
                if (inc_contains_string($lang_link, 'lang=')) {
                    $pos = strrpos($lang_link, 'lang=');
                    $lang_link = substr($lang_link, 0, $pos);
                    $lang_link = $lang_link . 'lang=' . $language;
                } elseif (inc_contains_string($lang_link, '?')) {
                    $lang_link = $lang_link . '&lang=' . $language;
                } else {
                    $lang_link = $lang_link . '?lang=' . $language;
                }
                $lang_link = apply_filters('inc_language_link', $lang_link);
                $languages[] = array(
                    'flag' => $lang_flag,
                    'name' => $lang_name,
                    'url' => $lang_link,
                    'default' => $is_default,
                );
            }
            return $languages;
        }
    }

    if (!function_exists('print_transposh_language_switcher')) {
        function print_transposh_language_switcher()
        {

            $languages = array();
            $transposh = $GLOBALS['my_transposh_plugin'];
            $clean_page_url = $transposh->get_clean_url();
            if (is_404()) {
                $clean_page_url = transposh_utils::cleanup_url($transposh->home_url, $transposh->home_url, true);
            }
            foreach ($transposh->options->get_sorted_langs() as $code => $langrecord) {
                if ($transposh->options->is_active_language($code) || ($transposh->options->is_default_language($code))) {
                    list ($langname, $language, $flag) = explode(',', $langrecord);
                    if ($transposh->options->enable_url_translate && !$transposh->options->is_default_language($code)) {
                        $page_url = transposh_utils::translate_url($clean_page_url, '', $code, array(&$transposh->database, 'fetch_translation'));
                    } else {
                        $page_url = $clean_page_url;
                    }

                    $page_url = transposh_utils::rewrite_url_lang_param($page_url, $transposh->home_url, $transposh->enable_permalinks_rewrite, $transposh->options->is_default_language($code) ? '' : $code, $transposh->edit_mode);
                    $page_url = apply_filters('inc_language_link', $page_url);
                    if ($flag == 'en' || $flag == 'us') {
                        $flag = 'gb';
                    }
                    $flag = apply_filters('inc_language_id', $flag);
                    $lang_flag = apply_filters('inc_language_flag', '/images/flags/' . $flag . '.png');
                    $languages[] = array(
                        'flag' => $lang_flag,
                        'name' => $language,
                        'url' => htmlentities($page_url),
                        'default' => ($transposh->target_language == $code));
                }
            }
            return $languages;
        }
    }
}

if (is_user_logged_in()) {
    add_action('wp_ajax_inc-color-style', 'inc_generate_site_color_scheme');
} else {
    add_action('wp_ajax_nopriv_inc-color-style', 'inc_generate_site_color_scheme');
}
if (!function_exists('inc_generate_site_color_scheme')) {
    function inc_generate_site_color_scheme()
    {
        $site_color_scheme = inc_get_site_color_scheme();
        if (!inc_start_with($site_color_scheme, '#')) {
            $site_color_scheme = '#' . $site_color_scheme;
        }
        $GLOBALS['inc_color'] = $site_color_scheme;
        $GLOBALS['inc_color_rgb'] = implode(',', inc_color_hex2rgb($site_color_scheme));
        $color_template_path = apply_filters('inc_color_style_template_path', get_template_directory() . '/css/colors/template.php');
        include ($color_template_path);
        die();
    }
}

if (function_exists('qtrans_convertURL')) {
    add_filter('post_type_link', 'qtrans_convertURL');
}

add_filter('the_content_more_link', 'inc_remove_more_link_scroll');
if (!function_exists('inc_remove_more_link_scroll')) {
    function inc_remove_more_link_scroll($link)
    {
        $link = preg_replace('|#more-[0-9]+|', '', $link);
        return $link;
    }
}
