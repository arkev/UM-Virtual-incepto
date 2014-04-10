<?php

$pages_customizer = array();
array_push($pages_customizer, new Post_Page_Customizer());
array_push($pages_customizer, new Basic_Page_Customizer());
array_push($pages_customizer, new Portfolio_Page_Customizer());

$meta_boxes = array();

$meta_boxes[] = array(
    'id' => 'portfolio_project_details',
    'title' => __('Project Details', INCEPTIO_THEME_NAME),
    'location' => array(),
    'context' => 'advanced',
    'priority' => 'default',

    'fields' => array(
        array(
            'name' => __('Customer', INCEPTIO_THEME_NAME),
            'id' => SETTINGS_PORTFOLIO_CUSTOMER,
            'type' => 'text',
            'desc' => __('The customer details', INCEPTIO_THEME_NAME)
        ),
        array(
            'name' => __('Year', INCEPTIO_THEME_NAME),
            'id' => SETTINGS_PORTFOLIO_YEAR,
            'type' => 'text',
            'desc' => __('The year of the project creation', INCEPTIO_THEME_NAME)
        ),
        array(
            'name' => __('Technologies Used', INCEPTIO_THEME_NAME),
            'id' => SETTINGS_PORTFOLIO_TECHNOLOGIES,
            'type' => 'textarea',
            'desc' => __('The technologies used in this project (one per line)', INCEPTIO_THEME_NAME)
        ),
        array(
            'name' => __('Project URL', INCEPTIO_THEME_NAME),
            'id' => SETTINGS_PORTFOLIO_URL,
            'type' => 'text',
            'desc' => __('The project page URL. Optional, after the url you can add the target link separated by |. Example: <strong>http://www.ixtendo.com|blank</strong>', INCEPTIO_THEME_NAME)
        )
    )
);

$meta_boxes[] = array(
    'id' => 'portfolio_page_attributes',
    'title' => __('Page Attributes', INCEPTIO_THEME_NAME),
    'location' => array(),
    'context' => 'side',
    'priority' => 'high',
    'fields' => array(
        array(
            'id' => SETTINGS_PORTFOLIO_TEMPLATE
        )
    ),
);

$meta_boxes[] = array(
    'id' => 'page_content_featured',
    'title' => __('Content Featured Settings', INCEPTIO_THEME_NAME),
    'location' => array(),
    'context' => 'advanced',
    'priority' => 'default',

    'fields' => array(
        array(
            'name' => __('Content Featured', INCEPTIO_THEME_NAME),
            'id' => OPTION_CONTENT_FEATURED,
            'type' => 'textarea',
            'desc' => 'Enter the HTML code which will placed below to the slider or title'
        ),
    )
);

$meta_boxes[] = array(
    'id' => 'page_footer_featured',
    'title' => __('Footer Featured Settings', INCEPTIO_THEME_NAME),
    'location' => array(),
    'context' => 'advanced',
    'priority' => 'default',

    'fields' => array(
        array(
            'name' => __('Title', INCEPTIO_THEME_NAME),
            'id' => OPTION_FOOTER_FEATURED_TITLE,
            'type' => 'text'
        ),
        array(
            'name' => __('Body', INCEPTIO_THEME_NAME),
            'id' => OPTION_FOOTER_FEATURED_BODY,
            'type' => 'textarea'
        ),
        array(
            'name' => __('URL', INCEPTIO_THEME_NAME),
            'id' => OPTION_FOOTER_FEATURED_URL,
            'type' => 'text'
        ),
        array(
            'name' => __('Icon Source', INCEPTIO_THEME_NAME),
            'id' => OPTION_FOOTER_FEATURED_ICON,
            'type' => 'text'
        ),
        array(
            'name' => __('Override Entire Content', INCEPTIO_THEME_NAME),
            'id' => OPTION_FOOTER_FEATURED_CONTENT,
            'type' => 'textarea',
            'desc' => 'Enter the HTML code which will replace the default Footer Featured design'
        ),
    )
);

$meta_boxes[] = array(
    'id' => 'page_seo_settings',
    'title' => __('SEO Settings', INCEPTIO_THEME_NAME),
    'location' => array(),
    'context' => 'advanced',
    'priority' => 'default',

    'fields' => array(
        array(
            'name' => __('Meta description', INCEPTIO_THEME_NAME),
            'id' => OPTION_HEAD_META_DESCRIPTION,
            'type' => 'textarea'
        ),
        array(
            'name' => __('Meta keywords', INCEPTIO_THEME_NAME),
            'id' => OPTION_HEAD_META_KEYWORDS,
            'type' => 'text'
        ),
        array(
            'name' => __('Meta application-name', INCEPTIO_THEME_NAME),
            'id' => OPTION_HEAD_META_APPNAME,
            'type' => 'text'
        ),
        array(
            'name' => __('Meta generator', INCEPTIO_THEME_NAME),
            'id' => OPTION_HEAD_META_GENERATOR,
            'type' => 'text'
        )
    )
);

$meta_boxes[] = array(
    'id' => 'page_sidebar_settings',
    'title' => __('Sidebar &amp; Header Attributes', INCEPTIO_THEME_NAME),
    'location' => array(),
    'context' => 'side',
    'priority' => 'high',
    'fields' => array(
        array(
            'id' => SETTINGS_PAGE_SIDEBAR_NAME
        ),
        array(
            'id' => SETTINGS_PAGE_TITLE_BAR_VISIBLE
        )
    ),
);

add_action('admin_init', 'inc_customize_pages');
if (!function_exists('inc_customize_pages')) {
    function inc_customize_pages()
    {
        global $meta_boxes;
        global $pages_customizer;
        foreach ($meta_boxes as $meta_box) {
            foreach ($pages_customizer as $page_customizer) {
                $page_customizer->visit($meta_box);
            }
            new X_Meta_Box($meta_box);
        }
    }
}

add_action('load-post.php', 'inc_set_page_post_formats');
add_action('load-post-new.php', 'inc_set_page_post_formats');
if (!function_exists('inc_set_page_post_formats')) {
    function inc_set_page_post_formats()
    {
        if (isset($_GET['post'])) {
            $post = get_post($_GET['post']);
            if ($post) {
                $post_type = $post->post_type;
            } else {
                return;
            }
        } else {
            $post_type = isset($_GET['post_type']) ? $_GET['post_type'] : 'post';
        }

        if ('portfolio' == $post_type) {
            add_theme_support('post-formats', array('video', 'gallery'));
        } elseif ('post' == $post_type) {
            add_theme_support('post-formats', array('image', 'gallery', 'audio', 'video', 'aside', 'quote', 'link'));
        }
    }
}
