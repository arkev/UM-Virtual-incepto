<?php


class Inc_Process_Shortcode extends Abstract_Inc_Shortcode implements Inc_Shortcode_Designer
{
    static $COLS_ATTR = "cols";
    static $STEP_TITLE_ATTR = "title";
    private $steps = array();

    private function reset()
    {
        $this->steps = array();
    }

    function render($attr, $inner_content = null, $code = "")
    {
        $content = '';
        switch ($code) {
            case "process":
                do_shortcode($this->prepare_content($inner_content));
                $content .= $this->render_process($attr);
                $this->reset();
                break;
            case "step":
                $inner_content = do_shortcode($this->prepare_content($inner_content));
                $this->process_step($attr, $inner_content);
                break;
        }
        return $content;
    }

    private function render_process($attr)
    {
        extract(shortcode_atts(array(
            Inc_Process_Shortcode::$COLS_ATTR => ''), $attr));
        if (empty($cols) || !is_numeric($cols) || intval($cols) < 1 || intval($cols) > 4) {
            $content = $this->get_error('The value of the ' . Inc_Process_Shortcode::$COLS_ATTR . ' attribute must be a number between 1 and 4.');
        } else {
            $content = '';
            $cols = intval($cols);

            $row_count = 0;
            $i = 0;
            foreach ($this->steps as $index => $step) {
                $is_first = ($row_count == 0) && ($i == 0);
                if ($i % $cols == 0) {
                    $i = 0;
                    $row_count++;
                    $content .= "<div class=\"clear\"></div>";
                }

                $ps_class = $this->get_ps_class_name($cols, $i);
                $title = $step->title;
                $step_content = $step->content;

                $content .= "<div class=\"$ps_class inc-process-step-" . ($index + 1) . "\">";
                $content .= "<div class=\"arrowbox\">";
                $content .= "<h2 class=\"arrowbox-title\">$title";
                if (!$is_first) {
                    $content .= "<span class=\"arrowbox-title-arrow-back\"></span>";
                }
                $content .= "<span class=\"arrowbox-title-arrow-front\"></span>";
                $content .= "</h2>";
                $content .= $step_content . "";
                $content .= "</div>";
                $content .= "</div>";
                $i++;
            }

            for ($x = ($row_count * $cols) + $i; $x < ($row_count + 1) * $cols; $x++) {
                $ps_class = $this->get_ps_class_name($cols, $x);
                $content .= "<div class=\"$ps_class\">&nbsp;</div>";
            }
            $content .= "<div class=\"clear\"></div>";
        }

        return $content;
    }

    private function get_ps_class_name($steps_count, $current_step)
    {
        switch ($steps_count) {
            case 1:
                $class_name = '';
                break;
            case 2:
                $class_name = 'one-half';
                if ($steps_count == ($current_step + 1)) {
                    $class_name .= ' column-last';
                }
                break;
            case 3:
                $class_name = 'one-third';
                if ($steps_count == ($current_step + 1)) {
                    $class_name .= ' column-last';
                }
                break;
            default:
                $class_name = 'one-fourth';
                if ($steps_count == ($current_step + 1)) {
                    $class_name .= ' column-last';
                }
                break;
        }
        return $class_name;
    }

    private function process_step($attr, $inner_content)
    {
        extract(shortcode_atts(array(Inc_Process_Shortcode::$STEP_TITLE_ATTR => ''), $attr));
        array_push($this->steps, new Inc_Process_Step($title, $inner_content));
    }

    function get_names()
    {
        return array('process', 'step');
    }

    function get_visual_editor_form()
    {
        $content = '<form id="sc-ps-form" class="generic-form" method="post" action="#">';
        $content .= '<fieldset>';
        $content .= '<div>';
        $content .= '<label for="sc-ps-cols">' . __('No. of Columns', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="sc-ps-cols" name="sc-ps-cols" data-attr-name="' . Inc_Process_Shortcode::$COLS_ATTR . '" data-attr-type="attr">';
        $content .= '<option value="1">' . __('One Column', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="2">' . __('Two Columns', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="3">' . __('Three Columns', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="4">' . __('Four Columns', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-ps-steps">' . __('No. of Steps', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-ps-steps" name="sc-ps-steps" type="text" class="required number">';
        $content .= '</div>';
        $content .= '<div >';
        $content .= '<input id="sc-ps-form-submit" type="submit" value="' . __('Insert Process', INCEPTIO_THEME_NAME) . '" class="button-primary">';
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
        return __('Process (Outline of Steps)', INCEPTIO_THEME_NAME);
    }
}

class Inc_Process_Step
{

    var $title;
    var $content;

    function __construct($title, $content)
    {
        $this->title = $title;
        $this->content = $content;
    }

}