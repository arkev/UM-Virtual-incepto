<?php

class Inc_Iconbox_Shortcode extends Abstract_Inc_Shortcode implements Inc_Shortcode_Designer
{

    static $ID_ATTR = "id";
    static $TITLE_ATTR = "title";
    static $HREF_ATTR = "href";
    static $TARGET_ATTR = "target";
    static $ICON_ATTR = "icon";
    static $ICON_POSITION_ATTR = "icon_position";
    static $HIGHLIGHTED_TEXT_ATTR = "hl_text";
    static $DISPLAY_LEARN_MORE_ATTR = "display_learn_more";
    static $LEARN_MORE_TEXT_ATTR = "learn_more_text";
    static $ICON_SIZE = "icon_size";

    function render($attr, $inner_content = null, $code = "")
    {
        $inner_content = do_shortcode($this->prepare_content($inner_content));
        extract(shortcode_atts(array(
            Inc_Iconbox_Shortcode::$ID_ATTR => '',
            Inc_Iconbox_Shortcode::$TITLE_ATTR => '',
            Inc_Iconbox_Shortcode::$HREF_ATTR => '',
            Inc_Iconbox_Shortcode::$TARGET_ATTR => '',
            Inc_Iconbox_Shortcode::$ICON_ATTR => '',
            Inc_Iconbox_Shortcode::$ICON_POSITION_ATTR => 'left',
            Inc_Iconbox_Shortcode::$HIGHLIGHTED_TEXT_ATTR => '',
            Inc_Iconbox_Shortcode::$DISPLAY_LEARN_MORE_ATTR => 'true',
            Inc_Iconbox_Shortcode::$LEARN_MORE_TEXT_ATTR => '',
            Inc_Iconbox_Shortcode::$ICON_SIZE => 'full'), $attr));

        $img_alt = $title;
        $id = empty($id) ? sanitize_title($title) : $id;
        $target = empty($target) ? "" : "target=\"$target\"";
        $href = empty($href) ? "" : "href=\"$href\"";
        $icon_position = empty($icon_position) ? "left" : $icon_position;
        $icon_size = empty($icon_size) ? "full" : $icon_size;
        $hl_text = empty($hl_text) ? "" : "<p class=\"call-to-action\"><strong>$hl_text</strong></p>";
        $learn_more = "";
        if ($display_learn_more == 'true') {
            $learn_more_text = empty($learn_more_text) ? __('Learn More', INCEPTIO_THEME_NAME) : $learn_more_text;
            $learn_more = "<span class=\"button\">$learn_more_text</span>";
        }
        if (!inc_start_with(strtolower($inner_content), '<p') &&
            !inc_start_with(strtolower($inner_content), '<span') &&
            !inc_start_with(strtolower($inner_content), '<div') &&
            !inc_start_with(strtolower($inner_content), '<h')
        ) {
            $inner_content = "<p>$inner_content</p>";
        }

        if ($icon_position == 'top') {
            $img_src = $this->get_icon_src($icon, $icon_size);

            $classes = array('iconbox', 'icon-top');
            $core_attributes = $this->get_core_attributes($attr, array('class' => $classes, 'id' => $id));

            $content = "<div" . $core_attributes . ">";
            if (!empty($href)) {
                $content .= "<a $href $target>";
            }
            if (!empty($img_src)) {
                $content .= "<div class=\"iconbox-icon\"><img src=\"$img_src\" alt=\"$img_alt\"></div>";
            }
            $content .= empty($title) ? '' : "<h2 class=\"iconbox-title\">$title</h2>";
            $content .= $inner_content;
            $content .= $hl_text;
            if (!empty($href)) {
                $content .= $learn_more;
                $content .= "<div class=\"arrow-box-hover\"></div>";
                $content .= "</a>";
            }
            $content .= "</div>";
        } else if ($icon_position == 'left') {
            $img_src = $this->get_icon_src($icon, $icon_size);

            $classes = array('iconbox', 'icon-left');
            $core_attributes = $this->get_core_attributes($attr, array('class' => $classes, 'id' => $id));

            $content = "<div" . $core_attributes . ">";
            if (!empty($href)) {
                $content .= "<a $href $target>";
            }
            $content .= "<h2 class=\"iconbox-title\">";
            if (!empty($img_src)) {
                $content .= "<span class=\"iconbox-icon\"><img src=\"$img_src\" alt=\"$img_alt\"></span>";
            }
            $content .= $title . "</h2>";
            $content .= "$inner_content";
            $content .= $hl_text;
            if (!empty($href)) {
                $content .= $learn_more;
                $content .= "<div class=\"arrow-box-hover\"></div>";
                $content .= "</a>";
            }
            $content .= "</div>";
        } else {
            $content = $this->get_error('Wrong icon position value. The value of the ' . Inc_Iconbox_Shortcode::$ICON_POSITION_ATTR . ' attribute must be: top or left.');
        }

        return $content;
    }

    function get_names()
    {
        return 'iconbox';
    }

    function get_visual_editor_form()
    {
        $content = '<form id="sc-iconbox-form" class="generic-form" method="post" action="#" data-sc="iconbox">';
        $content .= '<fieldset>';
        $content .= '<div>';
        $content .= '<label for="sc-iconbox-id">' . __('ID', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-iconbox-id" name="sc-iconbox-id" type="text" data-attr-name="' . Inc_Iconbox_Shortcode::$ID_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-iconbox-title">' . __('Title', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-iconbox-title" name="sc-iconbox-title" type="text" class="required" data-attr-name="' . Inc_Iconbox_Shortcode::$TITLE_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-iconbox-url">' . __('URL', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-iconbox-url" name="sc-iconbox-url" type="text" data-attr-name="' . Inc_Iconbox_Shortcode::$HREF_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-iconbox-icon">' . __('Icon Source', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-iconbox-icon" name="sc-iconbox-icon" type="text" class="required" data-attr-name="' . Inc_Iconbox_Shortcode::$ICON_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-iconbox-iconsz">' . __('Icon Size', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-iconbox-iconsz" name="sc-iconbox-iconsz" type="text" value="full" data-attr-name="' . Inc_Iconbox_Shortcode::$ICON_SIZE . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-iconbox-iconp">' . __('Icon Position', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="sc-iconbox-iconp" name="sc-iconbox-iconp" data-attr-name="' . Inc_Iconbox_Shortcode::$ICON_POSITION_ATTR . '" data-attr-type="attr">';
        $content .= '<option value="left">' . __('Left', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="top">' . __('Top', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-iconbox-hlt">' . __('Highlighted Text', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-iconbox-hlt" name="sc-iconbox-hlt" type="text" data-attr-name="' . Inc_Iconbox_Shortcode::$HIGHLIGHTED_TEXT_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-iconbox-dlm">' . __('Display Learn More Button', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="sc-iconbox-dlm" name="sc-iconbox-dlm" data-attr-name="' . Inc_Iconbox_Shortcode::$DISPLAY_LEARN_MORE_ATTR . '" data-attr-type="attr">';
        $content .= '<option value="true">' . __('Display', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="false">' . __('Hide', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-iconbox-lmt">' . __('Learn More Text', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-iconbox-lmt" name="sc-iconbox-lmt" type="text" data-attr-name="' . Inc_Iconbox_Shortcode::$LEARN_MORE_TEXT_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-iconbox-content">' . __('Content', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<textarea id="sc-iconbox-content" name="sc-iconbox-content" class="required" data-attr-type="content"></textarea>';
        $content .= '</div>';
        $content .= '<div >';
        $content .= '<input id="sc-iconbox-form-submit" type="submit" name="submit" value="' . __('Insert Icon Box', INCEPTIO_THEME_NAME) . '" class="button-primary">';
        $content .= '</div>';
        $content .= '</fieldset>';
        $content .= '</form>';

        return $content;
    }

    function get_group_title()
    {
        return __('Elements', INCEPTIO_THEME_NAME);
    }

    function get_title()
    {
        return __('Icon Box', INCEPTIO_THEME_NAME);
    }

    private function get_icon_src($icon, $icon_size)
    {
        $predefined_icons = array('laptop', 'iphone', 'cog', 'chemical', 'applications', 'globe', 'help', 'light-bulb', 'computer', 'mouse', 'suitcase', 'write');
        if (in_array($icon, $predefined_icons)) {
            $icon = "/images/icon-boxes/24x20/$icon.png";
        }
        return Media_Util::get_image_src($icon, $icon_size);
    }
}
