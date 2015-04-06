<?php $portfolio_customer = inc_get_portfolio_param(SETTINGS_PORTFOLIO_CUSTOMER);
$portfolio_year = inc_get_portfolio_param(SETTINGS_PORTFOLIO_YEAR);
$portfolio_technologies = inc_get_portfolio_param(SETTINGS_PORTFOLIO_TECHNOLOGIES);
$portfolio_url = inc_get_portfolio_param(SETTINGS_PORTFOLIO_URL);?>

<?php if($portfolio_customer || $portfolio_year || $portfolio_technologies || $portfolio_url) { ?>
<div class="project-details">
    <h2><?php _e('Project Details', INCEPTIO_THEME_NAME); ?></h2>

    <?php if($portfolio_customer){ ?>
        <h4><?php _e('Customer', INCEPTIO_THEME_NAME); ?></h4>
        <?php if(inc_start_with($portfolio_customer, 'http')){ ?>
            <div class="entry-image">
                <img src="<?php echo $portfolio_customer; ?>" alt="" title="">
            </div>
        <?php }else{ ?>
            <p>&mdash; <?php echo $portfolio_customer; ?></p>
        <?php } ?>
    <?php } ?>

    <?php if ($portfolio_year){ ?>
        <h4><?php _e('Year', INCEPTIO_THEME_NAME); ?></h4>
        <p>&mdash; <?php echo $portfolio_year; ?></p>
    <?php } ?>

    <?php if($portfolio_technologies){ ?>
        <h4><?php _e('Technology', INCEPTIO_THEME_NAME); ?></h4>
        <ul class="check">
            <?php foreach (explode("\n", $portfolio_technologies) as $technology) { ?>
                <?php if(!empty($technology)){ ?>
                    <li><?php echo __inc($technology); ?></li>
                <?php } ?>
            <?php } ?>
        </ul>
    <?php } ?>

    <?php if($portfolio_url){ ?>
    <?php $portfolio_urls = explode("|", $portfolio_url, 2);
        $portfolio_url = $portfolio_urls[0];
        $target_attr = (count($portfolio_urls) == 2)? ' target="'.$portfolio_urls[1].'"':''; ?>
        <a href="<?php echo $portfolio_url; ?>" class="button"<?php echo $target_attr; ?>><?php _e('Visit Website', INCEPTIO_THEME_NAME); ?></a>
    <?php } ?>
</div>
<?php } ?>