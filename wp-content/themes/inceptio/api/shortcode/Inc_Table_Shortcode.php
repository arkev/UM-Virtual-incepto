<?php


class Inc_Table_Shortcode extends Abstract_Inc_Shortcode implements Inc_Shortcode_Designer
{
    static $CAPTION_ATTR = "caption";
    static $FOOTER_ATTR = "footer";
    static $COLUMNS_SEPARATOR_ATTR = "col_sep";

    private $table_header;
    private $table_rows = array();

    private function reset()
    {
        unset($this->table_header);
        $this->table_rows = array();
    }

    function render($attr, $inner_content = null, $code = "")
    {
        $content = '';
        switch ($code) {
            case "table":
                do_shortcode($this->prepare_content($inner_content));
                $content .= $this->render_table($attr);
                $this->reset();
                break;
            case "th":
                $inner_content = do_shortcode($this->prepare_content($inner_content));
                $this->process_table_header($attr, $inner_content);
                break;
            case "tr":
                $inner_content = do_shortcode($this->prepare_content($inner_content));
                $this->process_table_row($attr, $inner_content);
                break;
        }
        return $content;
    }

    private function render_table($attr)
    {
        extract(shortcode_atts(array(
            Inc_Table_Shortcode::$CAPTION_ATTR => '',
            Inc_Table_Shortcode::$FOOTER_ATTR => '',
            Inc_Table_Shortcode::$COLUMNS_SEPARATOR_ATTR => '|',), $attr));

        $classes = array('gen-table');
        $core_attributes = $this->get_core_attributes($attr, array('class' => $classes));

        $content = '<table' . $core_attributes . '>' . "";

        //table caption
        if (strlen($caption) > 0) {
            $content .= '<caption>' . $caption . '</caption>' . "";
        }

        //table header
        if (isset($this->table_header)) {
            $content .= $this->table_header->render($col_sep);
        }

        //table footer
        $columns_count = $this->table_rows[0]->get_columns_count($col_sep);
        if (strlen($footer) > 0) {
            $content .= '<tfoot>';
            $content .= '<tr>';
            $content .= '<td colspan="' . $columns_count . '">' . $footer . '</td>';
            $content .= '</tr>';
            $content .= '</tfoot>';
        }

        //table body
        $content .= '<tbody>';
        $rows_total = count($this->table_rows);
        foreach ($this->table_rows as $row_count => $row) {
            if (($row_count + 1) == $rows_total) {
                $row_class = 'row-last' . ($row_count % 2 != 0) ? ' odd' : '';
            } else {
                $row_class = ($row_count % 2 != 0) ? 'odd' : '';
            }
            $content .= $row->render($col_sep, $row_class);
        }
        $content .= '</tbody>';

        $content .= '</table>';
        return $content;
    }

    private function process_table_header($attr, $inner_content)
    {
        if (!isset($this->table_header)) {
            $this->table_header = new Inc_Table_Header($inner_content);
        }
    }

    private function process_table_row($attr, $inner_content)
    {
        array_push($this->table_rows, new Inc_Table_Row($inner_content));
    }

    function get_names()
    {
        return array('table', 'tr', 'th');
    }

    function get_visual_editor_form()
    {
        $content = '<form id="sc-table-form" class="generic-form" method="post" action="#">';
        $content .= '<fieldset>';
        $content .= '<div>';
        $content .= '<label for="sc-table-caption">' . __('Caption', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-table-caption" name="sc-table-caption" type="text" data-attr-name="' . Inc_Table_Shortcode::$CAPTION_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-table-footer">' . __('Footer Text', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-table-footer" name="sc-table-footer" type="text" data-attr-name="' . Inc_Table_Shortcode::$FOOTER_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-table-separator">' . __('Column Separator', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-table-separator" name="sc-table-separator" type="text" class="required" value="|" data-attr-name="' . Inc_Table_Shortcode::$COLUMNS_SEPARATOR_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-table-columns">' . __('No. of Columns', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-table-columns" name="sc-table-columns" type="text" class="required number">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-table-rows">' . __('No. of Rows', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-table-rows" name="sc-table-rows" type="text" class="required number">';
        $content .= '</div>';
        $content .= '<div >';
        $content .= '<input id="sc-table-form-submit" type="submit" value="' . __('Insert Table', INCEPTIO_THEME_NAME) . '" class="button-primary">';
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
        return __('Table', INCEPTIO_THEME_NAME);
    }
}

class Inc_Table_Header
{

    private $content;

    function __construct($content)
    {
        $this->content = $content;
    }

    function render($col_sep)
    {
        $content = '<thead>';
        $content .= '<tr>';
        $columns = explode($col_sep, $this->content);
        foreach ($columns as $column) {
            $content .= '<th>' . $column . '</th>';
        }
        $content .= '</tr>';
        $content .= '</thead>';
        return $content;
    }

}

class Inc_Table_Row
{
    private $content;

    function __construct($content)
    {
        $this->content = $content;
    }

    function get_columns_count($col_sep)
    {
        return count(explode($col_sep, $this->content));
    }

    function render($col_sep, $row_class)
    {
        $row_class = empty($row_class) ? '' : ' class="' . $row_class . '"';
        $content = '<tr' . $row_class . '>';
        $columns = explode($col_sep, $this->content);
        foreach ($columns as $column) {
            $content .= '<td>' . $column . '</td>';
        }
        $content .= '</tr>';
        return $content;
    }

}