<?php


class Inc_Image_Gallery_Shortcode extends Abstract_Inc_Shortcode implements Inc_Shortcode_Designer
{

    static $POST_ID_ATTR = "post_id";
    static $IDS_ATTR = "ids";
    static $COLUMNS_ATTR = "columns";
    static $SIZE_ATTR = "size";
    static $LIGHTBOX_ATTR = "lightbox";
    static $ALIGN_ATTR = "align";
    static $SRC_ATTR = "src";
    static $DISPLAY_CAPTION_ATTR = "display_caption";
    static $CAPTION_ATTR = "caption";
    static $CAPTION_TYPE_ATTR = "caption_type";
    static $LINK_ATTR = "link";
    static $HREF_ATTR = "href";
    static $NAME_ATTR = "name";
    static $TITLE_ATTR = "title";
    static $TARGET_ATTR = "target";

    var $items = array();

    private function reset()
    {
        unset($this->items);
        $this->items = array();
    }

    function render($attr, $inner_content = null, $code = "")
    {
        $content = '';
        switch ($code) {
            case "ixgallery":
            case "gallery":
                do_shortcode($this->prepare_content($inner_content));
                $content .= $this->render_gallery($attr);
                $this->reset();
                break;
            case "gallery_item":
                $this->process_gallery_item($attr);
                break;
        }
        return $content;
    }

    private function render_gallery($attr)
    {
        $content = '';
        extract(shortcode_atts(array(Inc_Image_Gallery_Shortcode::$IDS_ATTR => '',
            Inc_Image_Gallery_Shortcode::$POST_ID_ATTR => '',
            Inc_Image_Gallery_Shortcode::$COLUMNS_ATTR => '1',
            Inc_Image_Gallery_Shortcode::$SIZE_ATTR => 'full',
            Inc_Image_Gallery_Shortcode::$LIGHTBOX_ATTR => 'false',
            Inc_Image_Gallery_Shortcode::$LINK_ATTR => '',
            Inc_Image_Gallery_Shortcode::$HREF_ATTR => '',
            Inc_Image_Gallery_Shortcode::$TARGET_ATTR => '',
            Inc_Image_Gallery_Shortcode::$NAME_ATTR => '',
            Inc_Image_Gallery_Shortcode::$DISPLAY_CAPTION_ATTR => 'true',
            Inc_Image_Gallery_Shortcode::$CAPTION_TYPE_ATTR => 'outer',
            Inc_Image_Gallery_Shortcode::$ALIGN_ATTR => ''), $attr));

        if (empty($columns) || !is_numeric($columns) || intval($columns) < 0 || intval($columns) > 4) {
            return $this->get_error('The value of the ' . Inc_Image_Gallery_Shortcode::$COLUMNS_ATTR . ' attribute must be a number between 1 and 4.');
        }
        if (empty($href)) {
            $href = $link;
        }
        $columns = intval($columns);
        $gallery_name = strlen($name) == 0 ? uniqid('gallery-') : $name;

        if (empty($ids) && empty($post_id) && count($this->items) == 0) {
            $post_id = get_the_ID();
        }

        if (!empty($post_id)) {
            $post_id = intval($post_id);
            $attachments_id = Post_Util::get_post_attachments_id($post_id);
            if (!empty($attachments_id)) {
                $ids = $attachments_id;
            }
        }
        if (!empty($ids)) {
            $img_ids = is_array($ids) ? $ids : explode(',', $ids);
            if ($columns == 1) {
                if ($align == 'right') {
                    $div_class = "class=\"alignright\"";
                } elseif ($align == 'left') {
                    $div_class = "class=\"alignleft\"";
                } else {
                    $div_class = "";
                }
                $content .= "<div $div_class>";
                for ($i = 0; $i < count($img_ids); $i++) {
                    $img_id = $img_ids[$i];
                    $post = Media_Util::get_original_post($img_id);
                    if ($post) {
                        $title = apply_filters('get_the_excerpt', $post->post_content);
                        if (empty($title)) {
                            $title = get_the_title($post);
                        }
                        $thumb_src = Media_Util::get_image_src($img_id, $size);
                        $full_src = Media_Util::get_image_src($img_id);
                        $li_class = "entry-image lightbox";
                        if ($i > 0) {
                            $li_class .= " invisible";
                        }
                        $content .= "<a class=\"$li_class\" data-fancybox-group=\"$gallery_name\" href=\"$full_src\" title=\"$title\"><span class=\"overlay zoom\"></span><img src=\"$thumb_src\" alt=\"$title\"></a>";
                    }
                }
                $content .= "</div>";
            } else {
                $row = 0;
                $col = 0;
                for ($i = 0; $i < count($img_ids); $i++) {
                    $img_id = $img_ids[$i];
                    if ($i > 0 && $i % $columns == 0) {
                        $col = 0;
                        $row++;
                    }
                    if ($col == 0) {
                        if ($row > 0) {
                            $content .= '[/gc]';
                        }
                        $content .= '[gc layout="' . $columns . '"]';
                    } else {
                        $content .= "|";
                    }
                    if ($display_caption == 'true') {
                        $caption_attr = "caption=\"inherited\"";
                    } else {
                        $caption_attr = "";
                    }
                    $content .= "[img src=\"$img_id\" title=\"inherited\" size=\"$size\" lightbox=\"$lightbox\" rel=\"$gallery_name\" caption_type=\"$caption_type\" $caption_attr target=\"$target\" href=\"$href\"][/img]";
                    $col++;
                }
                for ($i = $col; $i < $columns; $i++) {
                    $content .= "|&nbsp;";
                }
                $content .= '[/gc]';
                $content = do_shortcode($content);
            }
        } else {
            if ($columns == 1) {
                if ($align == 'right') {
                    $div_class = "class=\"alignright\"";
                } elseif ($align == 'left') {
                    $div_class = "class=\"alignleft\"";
                } else {
                    $div_class = "";
                }
                $content .= "<div $div_class>";
                for ($i = 0; $i < count($this->items); $i++) {
                    $item = $this->items[$i];
                    $content .= $item->get_img($columns, $i, $gallery_name, $size, $lightbox, $display_caption, $caption_type);
                    $content .= "";
                }
                $content .= "</div>";
            } else {
                $row = 0;
                $col = 0;
                for ($i = 0; $i < count($this->items); $i++) {
                    $item = $this->items[$i];
                    if ($i > 0 && $i % $columns == 0) {
                        $col = 0;
                        $row++;
                    }
                    if ($col == 0) {
                        if ($row > 0) {
                            $content .= '[/gc]';
                        }
                        $content .= '[gc layout="' . $columns . '"]';
                    } else {
                        $content .= "|";
                    }
                    $content .= $item->get_img($columns, $i, $gallery_name, $size, $lightbox, $display_caption, $caption_type);
                    $content .= "";
                    $col++;
                }
                for ($i = $col; $i < $columns; $i++) {
                    $content .= "|&nbsp;";
                }
                $content .= '[/gc]';
                $content = do_shortcode($content);
            }
        }
        return $content;
    }

    private function process_gallery_item($attr)
    {
        array_push($this->items, new Inc_Gallery_Item($attr));
    }

    function get_names()
    {
        return array('gallery', 'ixgallery', 'gallery_item');
    }

    function get_visual_editor_form()
    {
        $content = '<form id="sc-imgg-form" class="generic-form" method="post" action="#">';
        $content .= '<fieldset>';
        $content .= '<div>';
        $content .= '<label for="sc-imgg-name">' . __('Gallery Name', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-imgg-name" name="sc-imgg-name" type="text">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-imgg-size">' . __('Image Size', INCEPTIO_THEME_NAME) . '</label>';
        $content .= '<select id="sc-imgg-size" name="sc-imgg-size">';
        $content .= '<option value="full">' . __('Original Size', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="thumbnail">' . __('Thumbnail Size (150 x 150)', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="inc-small">' . __('Small Size (220 x 140)', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="medium">' . __('Medium Size (300 x 300)', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="large">' . __('Large Size (640 x 640)', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-imgg-cols">' . __('No. of Columns', INCEPTIO_THEME_NAME) . '</label>';
        $content .= '<select id="sc-imgg-cols" name="sc-imgg-cols">';
        $content .= '<option value="1">1</option>';
        $content .= '<option value="2">2</option>';
        $content .= '<option value="3">3</option>';
        $content .= '<option value="4">4</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<input id="sc-imgg-lightbox" name="sc-imgg-lightbox" type="checkbox">';
        $content .= '<label for="sc-imgg-lightbox">' . __('Enable Lightbox', INCEPTIO_THEME_NAME) . '</label>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<input id="sc-imgg-captionenable" name="sc-imgg-captionenable" type="checkbox" checked>';
        $content .= '<label for="sc-imgg-captionenable">' . __('Enable Caption', INCEPTIO_THEME_NAME) . '</label>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-imgg-captiontype">' . __('Caption Type', INCEPTIO_THEME_NAME) . '</label>';
        $content .= '<select id="sc-imgg-captiontype" name="sc-imgg-captiontype">';
        $content .= '<option value="outer">' . __('Outer', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="inner">' . __('Inner', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-imgg-align">' . __('Align', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="sc-imgg-align" name="sc-imgg-align">';
        $content .= '<option value="" >' . __('None', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="left">' . __('Left', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="right">' . __('Right', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<ul id="sc-imgg-slides" class="slides sortable-slides"></ul>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<input id="sc-imgg-form-submit" type="submit" name="submit" value="' . __('Insert Image Gallery', INCEPTIO_THEME_NAME) . '" class="button-primary">';
        $content .= '<input id="sc-imgg-form-add" type="submit" name="submit" value="' . __('Add New Image', INCEPTIO_THEME_NAME) . '" class="button-secondary">';
        $content .= '</div>';
        $content .= '</fieldset>';
        $content .= '</form>';

        $content .= '<div id="sc-imgg-slide-dialog" title="' . __('Add New Image', INCEPTIO_THEME_NAME) . '" style="display: none">';
        $content .= '<form id="sc-imgg-slide-form" class="generic-form" method="post" action="#">';
        $content .= '<fieldset>';
        $content .= '<div class="image-tab-content">';
        $content .= '<div class="image-tab-content-left">';
        $content .= '<div>';
        $content .= '<label for="sc-imgg-slide-src">' . __('Image Source', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="sc-imgg-slide-src" name="sc-imgg-slide-src" class="required image-selector">';
        $content .= '<option value="">' . __('Select Image ...', INCEPTIO_THEME_NAME) . '</option>';
        $images = Media_Util::get_all_uploaded_images();
        foreach ($images as $img) {
            $images = wp_get_attachment_image_src($img->ID);
            $content .= '<option value="' . $img->post_title . '" data-src="' . $images[0] . '">' . $img->post_title . '</option>';
        }
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-imgg-slide-caption">' . __('Caption', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-imgg-slide-caption" name="sc-imgg-slide-caption" type="text">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-imgg-slide-title">' . __('Title', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-imgg-slide-title" name="sc-imgg-slide-title" type="text">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-imgg-slide-url">' . __('Image Link', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-imgg-slide-url" name="sc-imgg-slide-url" type="text">';
        $content .= '</div>';
        $content .= '<div >';
        $content .= '<input id="sc-imgg-slide-form-submit" type="submit" name="submit" value="' . __('Add Image to Gallery', INCEPTIO_THEME_NAME) . '" class="button-primary">';
        $content .= '<input id="sc-imgg-slide-form-cancel" type="submit" name="submit" value="' . __('Cancel', INCEPTIO_THEME_NAME) . '" class="button-secondary">';
        $content .= '</div>';
        $content .= '</div>';

        $content .= '<div class="image-tab-content-right">';
        $content .= '<img id="sc-imgg-slide-src-preview" src="#" alt="">';
        $content .= '</div>';

        $content .= '</div>';
        $content .= '</fieldset>';
        $content .= '</form>';
        $content .= '</div>';

        return $content;
    }

    function get_group_title()
    {
        return __('Media', INCEPTIO_THEME_NAME);
    }

    function get_title()
    {
        return __('Image Gallery', INCEPTIO_THEME_NAME);
    }
}

class Inc_Gallery_Item
{
    private $attr;

    function __construct($attr)
    {
        $this->attr = $attr;
    }

    function get_img($columns, $col_no, $gallery_name, $size, $lightbox, $display_caption, $caption_type)
    {
        extract(shortcode_atts(array(
            Inc_Image_Gallery_Shortcode::$SRC_ATTR => '',
            Inc_Image_Gallery_Shortcode::$CAPTION_ATTR => '',
            Inc_Image_Gallery_Shortcode::$HREF_ATTR => '',
            Inc_Image_Gallery_Shortcode::$TITLE_ATTR => '',
            Inc_Image_Gallery_Shortcode::$TARGET_ATTR => ''), $this->attr));

        if ($columns == 1) {
            $thumb_src = Media_Util::get_image_src($src, $size);
            $full_src = Media_Util::get_image_src($src);
            $a_class = "entry-image lightbox";
            if ($col_no > 0) {
                $a_class .= " invisible";
            }
            return "<a class=\"$a_class\" data-fancybox-group=\"$gallery_name\" href=\"$full_src\" title=\"$title\"><span class=\"overlay zoom\"></span><img src=\"$thumb_src\" alt=\"$title\"></a>";
        } else {
            if ($display_caption == 'true') {
                $caption_attr = "caption_type=\"$caption_type\" caption=\"$caption\"";
            } else {
                $caption_attr = "";
            }
            return "[img src=\"$src\" title=\"$title\" size=\"$size\" lightbox=\"$lightbox\" target=\"$target\" href=\"$href\" rel=\"$gallery_name\" $caption_attr][/img]";
        }
    }

}