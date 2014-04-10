<?php

class Inc_Infobox_Shortcode extends Abstract_Inc_Shortcode implements Inc_Shortcode_Designer
{

    static $ID_ATTR = "id";
    static $TITLE_ATTR = "title";
    static $HREF_ATTR = "href";
    static $TARGET_ATTR = "target";
    static $BUTTON_TEXT_ATTR = "button_text";
    static $BUTTON_SIZE_ATTR = "button_size";

    function render($attr, $inner_content = null, $code = "")
    {
        $inner_content = do_shortcode($this->prepare_content($inner_content));
        extract(shortcode_atts(array(
            Inc_Infobox_Shortcode::$ID_ATTR => '',
            Inc_Infobox_Shortcode::$TITLE_ATTR => '',
            Inc_Infobox_Shortcode::$HREF_ATTR => '',
            Inc_Infobox_Shortcode::$TARGET_ATTR => '',
            Inc_Infobox_Shortcode::$BUTTON_SIZE_ATTR => 'large',
            Inc_Infobox_Shortcode::$BUTTON_TEXT_ATTR => ''), $attr));

        if (empty($href) && !empty($button_text)) {
            $content = $this->get_error('Please provide the URL for the button link using the ' . Inc_Infobox_Shortcode::$HREF_ATTR . ' attribute.');
        } elseif (!empty($href) && empty($button_text)) {
            $content = $this->get_error('Please provide the text for the button link using the ' . Inc_Infobox_Shortcode::$BUTTON_TEXT_ATTR . ' attribute.');
        } else {
            $classes = array('infobox');
            $core_attributes = $this->get_core_attributes($attr, array('class' => $classes));

            $content = "<div" . $core_attributes . ">";
            $content .= "<div class=\"infobox-inner\">";
            if (!empty($href) && !empty($button_text)) {
                $content .= do_shortcode('[btn size="' . $button_size . '" target="' . $target . '" href="' . $href . '"]' . $button_text . '[/btn]');
            }
            $content .= "<div class=\"with-button\">";
            if (!empty($title)) {
                $content .= "<h2>$title</h2>";
            }
            if (!inc_start_with(strtolower($inner_content), '<p') &&
                !inc_start_with(strtolower($inner_content), '<span') &&
                !inc_start_with(strtolower($inner_content), '<div') &&
                !inc_start_with(strtolower($inner_content), '<h')
            ) {
                $content .= "<p>$inner_content</p>";
            } else {
                $content .= $inner_content . "";
            }
            $content .= "</div>";
            if (!empty($href) && !empty($button_text)) {
                $content .= do_shortcode('[btn size="' . $button_size . '" class="mobile-button" target="' . $target . '" href="' . $href . '"]' . $button_text . '[/btn]');
            }
            $content .= "</div>";
            $content .= "</div>";
        }
        return $content;
    }

    function get_names()
    {
        return 'infobox';
    }

    function get_visual_editor_form()
    {
        $content = '<form id="sc-infobox-form" class="generic-form" method="post" action="#" data-sc="infobox">';
        $content .= '<fieldset>';
        $content .= '<div>';
        $content .= '<label for="sc-infobox-id">' . __('ID', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-infobox-id" name="sc-infobox-id" type="text" data-attr-name="' . Inc_Infobox_Shortcode::$ID_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-infobox-title">' . __('Title', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-infobox-title" name="sc-infobox-title" type="text" data-attr-name="' . Inc_Infobox_Shortcode::$TITLE_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-infobox-btnurl">' . __('Button URL', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-infobox-btnurl" name="sc-infobox-btnurl" type="text" data-attr-name="' . Inc_Infobox_Shortcode::$HREF_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-infobox-btntext">' . __('Button Text', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-infobox-btntext" name="sc-infobox-btntext" type="text" data-attr-name="' . Inc_Infobox_Shortcode::$BUTTON_TEXT_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-infobox-btnsize">' . __('Button Size', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="sc-infobox-btnsize" name="sc-infobox-btnsize" data-attr-name="' . Inc_Infobox_Shortcode::$BUTTON_SIZE_ATTR . '" data-attr-type="attr">';
        $content .= '<option value="large">' . __('Large Button', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="">' . __('Normal Button', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-infobox-content">' . __('Content', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<textarea id="sc-infobox-content" name="sc-infobox-content" class="required" data-attr-type="content"></textarea>';
        $content .= '</div>';
        $content .= '<div >';
        $content .= '<input id="sc-infobox-form-submit" type="submit" name="submit" value="' . __('Insert Info Box', INCEPTIO_THEME_NAME) . '" class="button-primary">';
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
        return __('Info Box', INCEPTIO_THEME_NAME);
    }
}