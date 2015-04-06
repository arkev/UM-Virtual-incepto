<?php require_once 'api/util.php'; ?>
<!DOCTYPE HTML>
<!--[if IE 8]> <html class="ie8 no-js" <?php language_attributes(); ?>> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head>
    <!-- begin meta -->
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=8, IE=9, IE=10">
    <meta http-equiv="content-type" content="text/html; charset=<?php bloginfo( 'charset' ); ?>">
    <?php if (inc_is_responsive_enabled()) { ?>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <?php } ?>
    <?php if(inc_is_custom_seo_enabled()) { ?>
    <?php if(inc_has_meta_description()) { ?>
    <meta name="description" content="<?php echo inc_get_meta_description();?>">
    <?php } ?>
    <?php if(inc_has_meta_keywords()) { ?>
    <meta name="keywords" content="<?php echo inc_get_meta_keywords();?>">
    <?php }; ?>
    <?php if(inc_has_meta_author()) { ?>
    <meta name="author" content="<?php echo inc_get_meta_author();?>">
    <?php } ?>
    <?php if(inc_has_meta_appname()) { ?>
    <meta name="application-name" content="<?php echo inc_get_meta_appname();?>">
    <?php } ?>
    <?php if(inc_has_meta_generator()) { ?>
    <meta name="generator" content="<?php echo inc_get_meta_generator();?>">
    <?php } ?>
    <?php } ?>
    <!-- end meta -->

    <title><?php bloginfo( 'name' ); wp_title('-', true, 'left');
        $site_description = get_bloginfo('description', 'display');
        if ($site_description && (is_home() || is_front_page()) )
            echo " - $site_description";?></title>
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <link href="<?php echo inc_get_fav_icon(); ?>" type="image/x-icon" rel="shortcut icon">

    <!-- begin JS & CSS -->
    <?php wp_head(); ?>
    <!-- end JS & CSS -->
</head>

<body <?php body_class(inc_get_layout_type()); ?>>
<?php get_template_part('language-switcher'); ?>
<!-- begin container -->
<div id="wrap">
    <!-- begin header -->
    <header id="header">
        <div class="container clearfix">
            <!-- begin logo -->
            <h1 id="logo"><a href="<?php echo get_home_url(); ?>"><?php if (inc_get_header_logo()) { ?><img src="<?php echo inc_get_header_logo(); ?>" alt="<?php echo inc_get_header_logo_alt(); ?>"><?php } else { bloginfo( 'name' ); } ?></a></h1>
            <!-- end logo -->

            <!-- begin navigation wrapper -->
            <div class="nav-wrap clearfix">

                <?php if (inc_is_header_search_visible()) { ?>
                <!-- begin search form -->
                <form id="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
                    <input id="ix-s" type="text" name="s" placeholder="<?php _e('Search', INCEPTIO_THEME_NAME) ?> &hellip;" style="display: none;">
                    <input id="search-submit" type="submit" name="search-submit" value="<?php _e('Search', INCEPTIO_THEME_NAME) ?>">
                </form>
                <!-- end search form -->
                <?php } ?>

                <!-- begin navigation -->
                <?php global $header_menu_walker;
                    wp_nav_menu( array(
                        'theme_location' => 'primary',
                        'container' => 'nav',
                        'container_id' => 'nav',
                        'container_class' => ' ',
                        'items_wrap' => '<ul id="navlist" class="clearfix">%3$s</ul>',
                        'walker' => $header_menu_walker ) );
                ?>
                <!-- end navigation -->
            </div>
            <!-- end navigation wrapper -->
        </div>
    </header>
    <!-- end header -->