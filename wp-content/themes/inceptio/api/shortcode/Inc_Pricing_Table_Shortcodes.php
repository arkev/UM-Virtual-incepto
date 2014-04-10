<?php


class Inc_Pricing_Table_Shortcodes extends Abstract_Inc_Shortcode implements Inc_Shortcode_Designer
{

    static $COLUMNS_ATTR = "columns";
    static $DISPLAY_MODE_ATTR = "display_mode";
    static $HIGHLIGHTED_COLUMN_ATTR = "hl_column";
    static $COLUMN_TITLE_ATTR = "title";
    static $COLUMN_PRICE_ATTR = "price";
    static $COLUMNS_UNIT_ATTR = "unit";
    static $COLUMNS_ORDER_URL_ATTR = "order_url";
    static $COLUMNS_ORDER_COLOR_ATTR = "order_color";
    static $COLUMNS_ORDER_TEXT_ATTR = "order_text";
    static $ROW_SEPARATOR_ATTR = "separator";

    private $display_mode_array = array('table', 'box');
    private $boxes = array();

    private function reset()
    {
        $this->boxes = array();
    }

    function render($attr, $inner_content = null, $code = "")
    {
        $content = '';
        switch ($code) {
            case "pb":
                do_shortcode($this->prepare_content($inner_content));
                $content .= $this->render_table($attr);
                $this->reset();
                break;
            case "pb_column":
                $inner_content = do_shortcode($this->prepare_content($inner_content));
                $this->process_column($attr, $inner_content);
                break;
        }
        return $content;
    }

    private function render_table($attr)
    {
        extract(shortcode_atts(array(
            Inc_Pricing_Table_Shortcodes::$COLUMNS_ATTR => '4',
            Inc_Pricing_Table_Shortcodes::$DISPLAY_MODE_ATTR => 'table',
            Inc_Pricing_Table_Shortcodes::$HIGHLIGHTED_COLUMN_ATTR => '',
            Inc_Pricing_Table_Shortcodes::$ROW_SEPARATOR_ATTR => '|',), $attr));

        if (empty($columns) || !is_numeric($columns)) {
            return $this->get_error('The value of the ' . Inc_Pricing_Table_Shortcodes::$COLUMNS_ATTR . ' attribute must be a number between 2 and 4.');
        }
        if (empty($display_mode) || !in_array($display_mode, $this->display_mode_array)) {
            return $this->get_error('The value of the ' . Inc_Pricing_Table_Shortcodes::$DISPLAY_MODE_ATTR . ' attribute must be: ' . implode(',', $this->display_mode_array));
        }

        if ($columns == '2') {
            $base_layout_class = 'one-half';
        } elseif ($columns == '3') {
            $base_layout_class = 'one-third';
        } else {
            $base_layout_class = 'one-fourth';
        }

        if ($display_mode == 'table') {
            $base_layout_class .= ' pricing-table';
        }

        $content = '';
        foreach ($this->boxes as $i => $box) {
            $layout_class = $base_layout_class . ' pricing-box-' . ($i + 1);
            $is_highlighted = (isset($hl_column) && !empty($hl_column) && (($i + 1) == intval($hl_column)));
            $is_last = ($i + 1) == intval($columns);
            if ($is_highlighted) {
                $layout_class .= ' featured';
            }
            if ($is_last) {
                $layout_class .= ' column-last';
            }
            $content .= $box->render($separator, $layout_class, $is_highlighted);
        }
        $content .= '<div class="clear"></div>';
        return $content;
    }

    private function process_column($attr, $inner_content)
    {
        array_push($this->boxes, new Inc_Pricing_Table_Box($attr, $inner_content, $this));
    }

    function get_names()
    {
        return array('pb', 'pb_column');
    }

    function get_visual_editor_form()
    {
        $content = '<form id="sc-pb-form" class="generic-form" method="post" action="#">';
        $content .= '<fieldset>';
        $content .= '<div>';
        $content .= '<label for="sc-pb-dm">' . __('Display Mode', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="sc-pb-dm" name="sc-pb-dm">';
        $content .= '<option value="table">' . __('Table', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="box">' . __('Box', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-pb-columns">' . __('No. of Columns', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="sc-pb-columns" name="sc-pb-columns">';
        $content .= '<option value="2">' . __('Two', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="3">' . __('Three', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="4">' . __('Four', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-pb-hc">' . __('Highlighted Columns', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="sc-pb-hc" name="sc-pb-hc">';
        $content .= '<option value="">' . __('None', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="2">' . __('Two', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="3">' . __('Three', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="4">' . __('Four', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-pb-rows">' . __('No. of Rows', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-pb-rows" name="sc-pb-rows" type="text" class="required number">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-pb-separator">' . __('Rows Separator', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-pb-separator" name="sc-pb-separator" type="text" class="required small" value="|">';
        $content .= '</div>';
        $content .= '<div >';
        $content .= '<input id="sc-pb-form-submit" type="submit" value="' . __('Insert Pricing Boxes', INCEPTIO_THEME_NAME) . '" class="button-primary">';
        $content .= '</div>';
        $content .= '</fieldset>';
        $content .= '</form>';

        return $content;
    }

    function get_group_title()
    {
        return __('Tables', INCEPTIO_THEME_NAME);
    }

    function get_title()
    {
        return __('Pricing Boxes', INCEPTIO_THEME_NAME);
    }

}

class Inc_Pricing_Table_Box
{
    private $attr;
    private $content;
    private $sc;

    function __construct($attr, $content, $sc)
    {
        $this->attr = $attr;
        $this->content = $content;
        $this->sc = $sc;
    }

    function render($separator, $layout_class, $is_highlighted)
    {
        $sc_instance = $this->sc;
        extract($this->attr);

        $content = '<div class="pricing-box ' . $layout_class . '">';
        $content .= '<header class="header">' . "";
        $content .= '<div class="title">' . $title . '</div>' . "";
        $content .= '<div class="price">' . "";
        $content .= '<span>' . $price . '</span>' . "";
        $content .= '<sup>/' . $unit . '</sup>' . "";
        $content .= '</div>' . "";
        $content .= '</header>' . "";

        $content .= '<ul class="features">' . "";
        $columns = explode($separator, $this->content);
        foreach ($columns as $column) {
            $content .= '<li>' . $column . '</li>' . "";
        }
        $content .= '</ul>' . "";

        if (strlen($order_url) > 0 && strlen($order_text) > 0) {
            $content .= '<footer class="footer">' . "";
            $button_color = $is_highlighted ? '' : ' color="black"';
            $button_attr = '';
            foreach ($this->attr as $key => $val) {
                $key = strtolower($key);
                if (inc_start_with($key, 'order_') &&
                    $key != Inc_Pricing_Table_Shortcodes::$COLUMNS_ORDER_URL_ATTR &&
                    $key != Inc_Pricing_Table_Shortcodes::$COLUMNS_ORDER_TEXT_ATTR &&
                    $key != Inc_Pricing_Table_Shortcodes::$COLUMNS_ORDER_COLOR_ATTR
                ) {
                    $new_key = substr($key, 6);
                    $button_attr .= $sc_instance->get_attribute($new_key, $val);
                }
            }
            $content .= do_shortcode('[button href="' . $order_url . '"' . $button_color . $button_attr . ']' . $order_text . '[/button]') . "";
            $content .= '</footer>' . "";
        }
        $content .= '</div>' . "";
        return $content;
    }

}