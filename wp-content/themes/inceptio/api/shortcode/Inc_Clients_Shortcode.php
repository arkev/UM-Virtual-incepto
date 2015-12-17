<?php


class Inc_Clients_Shortcode extends Abstract_Inc_Shortcode implements Inc_Shortcode_Designer
{

    static $CAROUSEL_ATTR = "carousel";
    static $LOGO_ATTR = "logo";
    static $NAME_ATTR = "name";
    static $HREF_ATTR = "href";
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
            case "clients":
                $inner_content = do_shortcode($this->prepare_content($inner_content));
                $content .= $this->render_clients($attr, $inner_content);
                $this->reset();
                break;
            case "client":
                $inner_content = do_shortcode($this->prepare_content($inner_content));
                $this->process_client_item($attr, $inner_content);
                break;
        }
        return $content;
    }

    private function render_clients($attr, $inner_content)
    {
        extract(shortcode_atts(array(Inc_Clients_Shortcode::$CAROUSEL_ATTR => 'false'), $attr));
        $id = uniqid('clients-');
        $attr['id'] = $id;
        $classes = array('clients', 'clearfix');
        $core_attributes = $this->get_core_attributes($attr, array('class' => $classes));

        $content = "<ul" . $core_attributes . ">";
        for ($i = 0; $i < count($this->items); $i++) {
            $item = $this->items[$i];
            $content .= $item->get_client();
        }
        $content .= "</ul>";

        if ($carousel == 'true') {
            $default_carousel_attr = array(
                Inc_Carousel_Settings::$CS_VISIBLE_ATTR => '4',
                Inc_Carousel_Settings::$CS_SCROLL_ATTR => '1',);
            $carousel_setting = new Inc_Carousel_Settings('#' . $id, $attr, $default_carousel_attr);
            $content .= $carousel_setting->get_carousel_settings();
        }
        return $content;
    }

    private function process_client_item($attr, $inner_content)
    {
        array_push($this->items, new Inc_Client_Item($attr, $inner_content));
    }

    function get_names()
    {
        return array('clients', 'client');
    }

    function get_visual_editor_form()
    {
        $example = '[client ' . Inc_Clients_Shortcode::$NAME_ATTR . '="CLIENT1_NAME" ' . Inc_Clients_Shortcode::$LOGO_ATTR . '="CLIENT1_LOGO_IMG" ' . Inc_Clients_Shortcode::$HREF_ATTR . '="CLIENT1_LINK"][/client]';
        $example .= '[client ' . Inc_Clients_Shortcode::$NAME_ATTR . '="CLIENT2_NAME" ' . Inc_Clients_Shortcode::$LOGO_ATTR . '="CLIENT2_LOGO_IMG" ' . Inc_Clients_Shortcode::$HREF_ATTR . '="CLIENT2_LINK"][/client]';
        $example .= '[client ' . Inc_Clients_Shortcode::$NAME_ATTR . '="CLIENT3_NAME" ' . Inc_Clients_Shortcode::$LOGO_ATTR . '="CLIENT3_LOGO_IMG" ' . Inc_Clients_Shortcode::$HREF_ATTR . '="CLIENT3_LINK"][/client]';
        $example .= '[client ' . Inc_Clients_Shortcode::$NAME_ATTR . '="CLIENT4_NAME" ' . Inc_Clients_Shortcode::$LOGO_ATTR . '="CLIENT4_LOGO_IMG" ' . Inc_Clients_Shortcode::$HREF_ATTR . '="CLIENT4_LINK"][/client]';
        $example = str_replace(array('[', ']'), array('&#91;', '&#93;'), $example);
        $content = '<form id="sc-clients-form" class="generic-form" method="post" action="#" data-sc="clients">';
        $content .= '<fieldset>';
        $content .= '<div>';
        $content .= '<label for="sc-clients-content">' . __('Template', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<textarea id="sc-clients-content" name="sc-clients-content" class="required" data-attr-type="content">' . $example . '</textarea>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<input id="sc-clients-carousel" name="sc-clients-carousel" type="checkbox">';
        $content .= '<label for="sc-clients-carousel">' . __('Include in carousel', INCEPTIO_THEME_NAME) . '</label>';
        $content .= '</div>';
        $content .= '<div >';
        $content .= '<input id="sc-clients-form-submit" type="submit" name="submit" value="' . __('Insert Clients', INCEPTIO_THEME_NAME) . '" class="button-primary">';
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
        return __('Clients', INCEPTIO_THEME_NAME);
    }
}

class Inc_Client_Item
{
    private $attr;
    private $inner_content;

    function __construct($attr, $inner_content)
    {
        $this->attr = $attr;
        $this->inner_content = $inner_content;
    }

    function get_client()
    {
        extract(shortcode_atts(array(
            Inc_Clients_Shortcode::$LOGO_ATTR => '',
            Inc_Clients_Shortcode::$NAME_ATTR => '',
            Inc_Clients_Shortcode::$HREF_ATTR => '',
            Inc_Clients_Shortcode::$TARGET_ATTR => ''), $this->attr));
        $logo_src = Media_Util::get_image_src($logo);
        $target_attr = $this->get_attribute('target', $target);
        return "<li><a $target_attr href=\"$href\"><img src=\"$logo_src\" alt=\"$name\" title=\"$name\"></a></li>";
    }

    private function get_attribute($attr_name, $attr_value, $attr_default_value = '')
    {
        if (empty($attr_value)) {
            $attr_value = $attr_default_value;
        }
        return empty($attr_value) ? '' : " $attr_name=\"$attr_value\"";
    }

}