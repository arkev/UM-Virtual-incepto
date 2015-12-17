<?php

class Inc_Notification_Box_Shortcode extends Abstract_Inc_Shortcode implements Inc_Shortcode_Designer
{
    static $ID_ATTR = "id";
    static $CLOSEABLE_ATTR = "closeable";
    static $TYPE_ATTR = "type";
    static $DISPLAY_ATTR = "display";

    function render($attr, $inner_content = null, $code = "")
    {
        $uuid = uniqid();
        extract(shortcode_atts(array(
            Inc_Notification_Box_Shortcode::$ID_ATTR => $uuid,
            Inc_Notification_Box_Shortcode::$CLOSEABLE_ATTR => 'true',
            Inc_Notification_Box_Shortcode::$TYPE_ATTR => 'info',
            Inc_Notification_Box_Shortcode::$DISPLAY_ATTR => 'true'
        ), $attr));
        switch ($type) {
            case 'info':
            case 'success':
            case 'warning':
            case 'error':
                return $this->generate_notification_box($id, $inner_content, $type, $closeable === 'true', $display === 'true');
            default:
                return $this->generate_notification_box($id, $inner_content, 'info', $closeable === 'true', $display === 'true');
        }
    }

    private function generate_notification_box($id, $text, $type, $closeable, $display)
    {
        $display_style = $display ? '' : 'style="display: none;"';
        $content = "<div id=\"" . $id . "\" class=\"notification-box notification-box-$type\" $display_style>";
        $content .= "<p id=\"" . $id . "-p\">$text</p>";
        if ($closeable) {
            $content .= "<a href=\"#\" class=\"notification-close notification-close-$type\">x</a>";
        }
        $content .= "</div>";
        return $content;
    }

    function get_names()
    {
        return array('notification', 'notif');
    }

    function get_visual_editor_form()
    {
        $content = '<form id="sc-notifbox-form" class="generic-form" method="post" action="#" data-sc="notif">';
        $content .= '<fieldset>';
        $content .= '<div>';
        $content .= '<label for="sc-notifbox-id">' . __('ID', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-notifbox-id" name="sc-notifbox-id" type="text" data-attr-name="'.Inc_Notification_Box_Shortcode::$ID_ATTR.'" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-notifbox-content">' . __('Content', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<textarea id="sc-notifbox-content" name="sc-notifbox-content" class="required" data-attr-type="content"></textarea>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-notifbox-type">' . __('Type', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="sc-notifbox-type" name="sc-notifbox-type" data-attr-name="'.Inc_Notification_Box_Shortcode::$TYPE_ATTR.'" data-attr-type="attr">';
        $content .= '<option value="info">' . __('Info', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="success">' . __('Success', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="warning">' . __('Warning', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="error">' . __('Error', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<input id="sc-notifbox-closeable" name="sc-notifbox-closeable" type="checkbox" checked data-attr-name="'.Inc_Notification_Box_Shortcode::$CLOSEABLE_ATTR.'" data-attr-type="attr">';
        $content .= '<label for="sc-notifbox-closeable">' . __('Display the close button', INCEPTIO_THEME_NAME) . '</label>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<input id="sc-notifbox-display" name="sc-notifbox-display" type="checkbox" checked data-attr-name="'.Inc_Notification_Box_Shortcode::$DISPLAY_ATTR.'" data-attr-type="attr">';
        $content .= '<label for="sc-notifbox-display">' . __('Display after the page is loaded', INCEPTIO_THEME_NAME) . '</label>';
        $content .= '</div>';
        $content .= '<div >';
        $content .= '<input id="sc-notifbox-form-submit" type="submit" name="submit" value="' . __('Insert Notification Box', INCEPTIO_THEME_NAME) . '" class="button-primary">';
        $content .= '</div>';
        $content .= '</fieldset>';
        $content .= '</form>';

        return $content;
    }

    function get_group_title()
    {
        return __('Dynamic Elements', INCEPTIO_THEME_NAME);
    }

    function get_title()
    {
        return __('Notification Box', INCEPTIO_THEME_NAME);
    }
}
