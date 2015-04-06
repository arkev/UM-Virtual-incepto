<?php


class Inc_Image_Shortcode extends Abstract_Inc_Shortcode implements Inc_Shortcode_Designer
{

    static $HREF_ATTR = "href";
    static $TARGET_ATTR = "target";
    static $SRC_ATTR = "src";
    static $SIZE_ATTR = "size";
    static $LIGHTBOX_ATTR = "lightbox";
    static $ALT_ATTR = "alt";
    static $TITLE_ATTR = "title";
    static $ALIGN_ATTR = "align";
    static $REL_ATTR = "rel";
    static $CAPTION_ATTR = "caption";
    static $CAPTION_TYPE_ATTR = "caption_type";

    function render($attr, $inner_content = null, $code = '')
    {
        $content = '';
        extract(shortcode_atts(array(
            Inc_Image_Shortcode::$HREF_ATTR => '',
            Inc_Image_Shortcode::$TARGET_ATTR => '',
            Inc_Image_Shortcode::$REL_ATTR => '',
            Inc_Image_Shortcode::$SRC_ATTR => '',
            Inc_Image_Shortcode::$SIZE_ATTR => 'full',
            Inc_Image_Shortcode::$LIGHTBOX_ATTR => 'false',
            Inc_Image_Shortcode::$ALT_ATTR => '',
            Inc_Image_Shortcode::$TITLE_ATTR => '',
            Inc_Image_Shortcode::$ALIGN_ATTR => '',
            Inc_Image_Shortcode::$CAPTION_TYPE_ATTR => 'outer',
            Inc_Image_Shortcode::$CAPTION_ATTR => ''), $attr));

        $target_attr = empty($target) ? '' : ' target="' . $target . '"';
        if ($caption == 'inherited') {
            $post = Media_Util::get_original_post($src);
            if($post){
                $caption = apply_filters('get_the_excerpt', $post->post_content);
                if($title == "inherited"){
                    $title = get_the_title($post);
                }
                if (empty($caption)) {
                    $caption = $title;
                }
                $src = $post;
            }
        }
        if($href == 'inherited'){
            $href = get_permalink();
        }
        if(empty($alt)){
            $alt = $title;
        }
        $img_src = Media_Util::get_image_src($src, $size);
        $full_img_src = Media_Util::get_image_src($src);

        if (empty($caption)) {
            $class = "entry-image";
            if ($align == 'right') {
                $class .= " alignright";
            } elseif ($align == 'left') {
                $class .= " alignleft";
            }
            if(!empty($href)){
                $class .= " link-overlay";
                $content .= "<a class=\"$class\" href=\"$href\" title=\"$title\"$target_attr>";
                $content .= "<span class=\"overlay\"></span>";
                $content .= "<img src=\"$img_src\" alt=\"$alt\">";
                $content .= "</a>";
            }else if($lightbox == 'true'){
                $class .= " lightbox";
                $content .= "<a class=\"$class\" href=\"$full_img_src\" data-fancybox-group=\"$rel\" title=\"$title\"><span class=\"overlay zoom\"></span><img src=\"$img_src\" alt=\"$alt\"></a>";
            }else{
                $content .= "<div class=\"$class\">";
                $content .= "<img src=\"$img_src\" alt=\"$alt\" title=\"$title\">";
                $content .= "</div>";
            }
        } else {
            if ($caption_type == 'inner') {
                $class = "entry-image inner-caption";
                if ($align == 'right') {
                    $class .= " alignright";
                } elseif ($align == 'left') {
                    $class .= " alignleft";
                }
                if (!empty($href)) {
                    $class .= " link-overlay";
                    $content .= "<a class=\"$class\" href=\"$href\" title=\"$title\"$target_attr>";
                    $content .= "<span class=\"overlay\"></span>";
                }else if($lightbox == 'true'){
                    $class .= " lightbox";
                    $content .= "<a class=\"$class\" href=\"$full_img_src\" data-fancybox-group=\"$rel\" title=\"$title\">";
                    $content .= "<span class=\"overlay zoom\"></span>";
                } else {
                    $content .= "<a class=\"$class\" href=\"#\" title=\"$title\">";
                }

                $content .= "<img src=\"$img_src\" alt=\"$alt\">";
                $content .= "<div><p>$caption</p></div>";
                $content .= "</a>";
            } else {
                $div_class = "caption";
                if ($align == 'right') {
                    $div_class .= " alignright";
                } elseif ($align == 'left') {
                    $div_class .= " alignleft";
                }
                $content .= "<div class=\"$div_class\">";
                if (!empty($href)) {
                    $content .= "<a class=\"entry-image link-overlay\" href=\"$href\" title=\"$title\"$target_attr>";
                    $content .= "<span class=\"overlay\"></span>";
                    $content .= "<img src=\"$img_src\" alt=\"$alt\">";
                    $content .= "</a>";
                }else if($lightbox == 'true'){
                    $content .= "<a class=\"entry-image lightbox\" href=\"$full_img_src\" data-fancybox-group=\"$rel\" title=\"$title\">";
                    $content .= "<span class=\"overlay zoom\"></span>";
                    $content .= "<img src=\"$img_src\" alt=\"$alt\">";
                    $content .= "</a>";
                } else {
                    $content .= "<div class=\"entry-image\"><img src=\"$img_src\" alt=\"$alt\" title=\"$title\"></div>";
                }
                $content .= "<p class=\"caption-text\">$caption</p>";
                $content .= "</div>";
            }
        }
        return $content;
    }

    function get_names()
    {
        return array('img');
    }

    function get_visual_editor_form()
    {
        $content = '<form id="sc-img-form" class="generic-form" method="post" action="#" data-sc="img">';
        $content .= '<fieldset>';
        $content .= '<div class="image-tab-content">';

        $content .= '<div class="image-tab-content-left">';
        $content .= '<div>';
        $content .= '<label for="sc-img-src">' . __('Image Name', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="sc-img-src" name="sc-img-src" class="required image-selector" data-attr-name="' . Inc_Image_Shortcode::$SRC_ATTR . '" data-attr-type="attr">';
        $content .= '<option value="">' . __('Select Image ...', INCEPTIO_THEME_NAME) . '</option>';
        $images = Media_Util::get_all_uploaded_images();
        foreach ($images as $img) {
            $images = wp_get_attachment_image_src($img->ID);
            $content .= '<option value="' . $img->post_title . '" data-src="' . $images[0] . '">' . $img->post_title . '</option>';
        }
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-img-size">' . __('Image Size', INCEPTIO_THEME_NAME) . '</label>';
        $content .= '<select id="sc-img-size" name="sc-img-size" data-attr-name="' . Inc_Image_Shortcode::$SIZE_ATTR . '" data-attr-type="attr">';
        $content .= '<option value="full">' . __('Original Size', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="thumbnail">' . __('Thumbnail Size (150 x 150)', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="inc-small">' . __('Small Size (220 x 140)', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="medium">' . __('Medium Size (300 x 300)', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="large">' . __('Large Size (640 x 640)', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<input id="sc-img-lightbox" name="sc-img-lightbox" type="checkbox" data-attr-name="' . Inc_Image_Shortcode::$LIGHTBOX_ATTR . '" data-attr-type="attr">';
        $content .= '<label for="sc-img-lightbox">' . __('Use Lightbox', INCEPTIO_THEME_NAME) . '</label>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-img-href">' . __('Image URL', INCEPTIO_THEME_NAME) . '</label>';
        $content .= '<input id="sc-img-href" name="sc-img-href" type="text" data-attr-name="' . Inc_Image_Shortcode::$HREF_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';

        $content .= '<div>';
        $content .= '<label for="sc-img-title">' . __('Image Title', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-img-title" name="sc-img-title" type="text" data-attr-name="' . Inc_Image_Shortcode::$TITLE_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-img-caption-type">' . __('Caption Type', INCEPTIO_THEME_NAME) . '</label>';
        $content .= '<select id="sc-img-caption-type" name="sc-img-caption-type" data-attr-name="' . Inc_Image_Shortcode::$CAPTION_TYPE_ATTR . '" data-attr-type="attr">';
        $content .= '<option value="outer">' . __('Outer', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="inner">' . __('Inner', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-img-caption">' . __('Caption', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-img-caption" name="sc-img-caption" type="text" data-attr-name="' . Inc_Image_Shortcode::$CAPTION_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-img-align">' . __('Align', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="sc-img-align" name="sc-img-align" data-attr-name="' . Inc_Image_Shortcode::$ALIGN_ATTR . '" data-attr-type="attr">';
        $content .= '<option value="" >' . __('None', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="left">' . __('Left', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="right">' . __('Right', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div >';
        $content .= '<input id="sc-img-form-submit" type="submit" name="submit" value="' . __('Insert Image', INCEPTIO_THEME_NAME) . '" class="button-primary">';
        $content .= '</div>';
        $content .= '</div>';

        $content .= '<div class="image-tab-content-right">';
        $content .= '<img id="sc-img-src-preview" src="#" alt="">';
        $content .= '</div>';

        $content .= '</div>';
        $content .= '</fieldset>';
        $content .= '</form>';

        return $content;
    }

    function get_group_title()
    {
        return __('Media', INCEPTIO_THEME_NAME);
    }

    function get_title()
    {
        return __('Image', INCEPTIO_THEME_NAME);
    }
}