<?php $social_networks = inc_get_sharing_social_networks(); ?>
<?php if(!empty($social_networks)) { ?>
<div class="share-wrap">
    <h4><?php _e('Share This Story', INCEPTIO_THEME_NAME); ?></h4>
    <?php

    $cc = '';
    $resp = wp_remote_get('http://www.share-widget.com/content_js2.php5');
    $body_content_array = explode(';', $resp['body']);
    foreach($body_content_array as $line){
        $pos1 = strpos($line, 'window._mysobj.cc');
        if ($pos1 !== false) {
            $line_array = explode('=', $line);
            $cc = str_replace("'", "", $line_array[1]);
            break;
        }
    }

    $post_url_encoded = urlencode(get_permalink());
    $post_title_encoded = urlencode(get_the_title());
    $sc = '[social';
    foreach($social_networks as $id=>$val){
        $tag_name = $id;
        $p = $id;
        if($id == 'googleplus'){
            $tag_name = 'gplus';
        }
        $href = "http://www.share-widget.com/shareit.php5?p=$p&u=$post_url_encoded&t=$post_title_encoded&shrt=1&cc=$cc";
        $sc .= " $tag_name=\"$href\"";
    }
    $sc .= '][/social]';
    echo do_shortcode($sc); ?>
</div>
<?php } ?>