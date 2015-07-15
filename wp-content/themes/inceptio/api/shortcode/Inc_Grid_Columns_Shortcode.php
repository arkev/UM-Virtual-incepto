<?php


class Inc_Grid_Columns_Shortcode extends Abstract_Inc_Shortcode implements Inc_Shortcode_Designer
{
    static $SEPARATOR_ATTR = "separator";
    static $LAYOUT_ATTR = "layout";
    static $TAG_ATTR = "tag";
    static $layouts = array("2", "3", "4", "1/3", "2/3", "1/4", "3/4");

    function render($attr, $inner_content = null, $code = "")
    {
        $inner_content = do_shortcode($this->prepare_content($inner_content));
        extract(shortcode_atts(array(
            Inc_Grid_Columns_Shortcode::$SEPARATOR_ATTR => '|',
            Inc_Grid_Columns_Shortcode::$TAG_ATTR => 'div',
            Inc_Grid_Columns_Shortcode::$LAYOUT_ATTR => '2'), $attr));
        if(empty($layout)){
            return $this->get_error('The value of the ' . Inc_Grid_Columns_Shortcode::$LAYOUT_ATTR . ' attribute must be: 2, 3, 4, 1/3, 2/3, 1/4 or 3/4.');
        }
        if(empty($tag)){
            return $this->get_error('The value of the ' . Inc_Grid_Columns_Shortcode::$TAG_ATTR . ' attribute must be: div or section.');
        }
        if(empty($separator)){
            return $this->get_error('The value of the ' . Inc_Grid_Columns_Shortcode::$SEPARATOR_ATTR . ' attribute must not be empty.');
        }

        $columns = $this->get_columns_no($layout);
        $lines = explode($separator, $inner_content, $columns);
        $content = '';
        for ($i = 0; $i < count($lines); $i++) {
            $content .= '<'.$tag.' class="' . $this->get_class($layout, $i) . '">'.$lines[$i].'</'.$tag.'>';
        }
        $content .= "<div class=\"clear\"></div>";
        return $content;
    }

    private function get_columns_no($layout)
    {
        switch ($layout) {
            case "3":
                return 3;
            case "4":
                return 4;
            default:
                return 2;
        }
    }

    private function get_class($layout, $index)
    {
        switch ($layout) {
            case "2":
                $class = ($index == 1) ? 'one-half column-last' : 'one-half';
                break;
            case "3":
                $class = ($index == 2) ? 'one-third column-last' : 'one-third';
                break;
            case "4":
                $class = ($index == 3) ? 'one-fourth column-last' : 'one-fourth';
                break;
            case "1/3":
                $class = ($index == 1) ? 'two-thirds column-last' : 'one-third';
                break;
            case "2/3":
                $class = ($index == 1) ? 'one-third column-last' : 'two-thirds';
                break;
            case "1/4":
                $class = ($index == 1) ? 'three-fourths column-last' : 'one-fourth';
                break;
            case "3/4":
                $class = ($index == 1) ? 'one-fourth column-last' : 'three-fourths';
                break;
            default:
                $class = '';
        }
        return $class;
    }

    function get_names()
    {
        return array('gc', 'gc2', 'gc3');
    }

    function get_visual_editor_form()
    {
        $content = '<form id="sc-gc-form" class="generic-form" method="post" action="#" data-sc="gc">';
        $content .= '<fieldset>';
        $content .= '<div>';
        $content .= '<label for="sc-gc-layout">' . __('Layout', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="sc-gc-layout" name="sc-gc-layout" data-attr-name="' . Inc_Grid_Columns_Shortcode::$LAYOUT_ATTR . '" data-attr-type="attr">';
        $content .= '<option value="2">' . __('Two Columns', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="3">' . __('Tree Columns', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="4">' . __('Four Columns', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="1/3">' . __('One Third - Two Thirds', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="2/3">' . __('Two Thirds - One Third', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="1/4">' . __('One Fourth - Three Fourths', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="3/4">' . __('Three Fourths - One Fourth', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-gc-tag">' . __('HTML Tag', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="sc-gc-tag" name="sc-gc-tag" data-attr-name="' . Inc_Grid_Columns_Shortcode::$TAG_ATTR . '" data-attr-type="attr">';
        $content .= '<option value="div">Div</option>';
        $content .= '<option value="section">Section</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-gc-separator">' . __('Column Separator', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-gc-separator" name="sc-gc-separator" type="text" class="required" value="|" data-attr-name="' . Inc_Grid_Columns_Shortcode::$SEPARATOR_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div >';
        $content .= '<input id="sc-gc-form-submit" type="submit" name="submit" value="' . __('Insert Grid Columns', INCEPTIO_THEME_NAME) . '" class="button-primary">';
        $content .= '</div>';
        $content .= '</fieldset>';
        $content .= '</form>';
        return $content;
    }

    function get_group_title()
    {
        return __('Layout', INCEPTIO_THEME_NAME);
    }

    function get_title()
    {
        return __('Grid Columns', INCEPTIO_THEME_NAME);
    }
}