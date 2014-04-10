<?php

if (!function_exists('get_theme_option')) {
    function get_theme_option($option_name)
    {
        global $theme_options;
        $all_options = wp_load_alloptions();
        if (!array_key_exists($option_name, $all_options)) {
            $return_value = $theme_options->get_option_value($option_name);
        } else {
            $return_value = $all_options[$option_name];
        }
        return maybe_unserialize($return_value);
    }
}

$GLOBALS['available_font_families'] = array(
    "'Open Sans'" => "Open Sans",
    "'Nunito'" => "Nunito",
);
foreach ($font_manager->get_all_fonts_name() as $font_name) {
    $GLOBALS['available_font_families']["'" . $font_name . "'"] = $font_name;
}

$GLOBALS['available_font_weights'] = array(
    "normal" => "Normal",
    "bold" => "Bold",
    "bolder" => "Bolder",
    "lighter" => "Lighter",
    "100" => "100",
    "200" => "200",
    "300" => "300",
    "400" => "400",
    "500" => "500",
    "600" => "600",
    "700" => "700",
    "800" => "800",
    "900" => "900",
    "inherit" => "Inherit",
);

$GLOBALS['theme_options'] = new Inceptio_Theme_Options();

class Inceptio_Theme_Options
{

    var $sections = array();
    var $all_options;

    function __construct()
    {
        $xml = simplexml_load_file(INCEPTIO_ROOT_PATH . "/api/theme-options.xml");
        foreach ($xml->section as $section) {
            array_push($this->sections, new Inceptio_Section($section));
        }

        add_action('admin_menu', array($this, 'register_theme_options_menu'));
        add_action('admin_init', array($this, 'register_options'));
        $this->all_options = wp_load_alloptions();
    }

    function register_theme_options_menu()
    {
        $theme_options_title = __('Theme Options', INCEPTIO_THEME_NAME);
        add_theme_page($theme_options_title, $theme_options_title, 'manage_options',
            'inc-theme-options', array($this, 'render'));
    }

    function get_option_value($option_name)
    {
        $return_value = null;
        if (array_key_exists($option_name, $this->all_options)) {
            $return_value = $this->all_options[$option_name];
        } else {
            foreach ($this->sections as $section) {
                foreach ($section->categories as $category) {
                    foreach ($category->options as $option) {
                        if ($option_name == $option->name) {
                            $return_value = $option->default_value;
                        }
                    }
                }
            }
        }
        return maybe_unserialize($return_value);
    }

    function get_default_value($option_name)
    {
        foreach ($this->sections as $section) {
            foreach ($section->categories as $category) {
                foreach ($category->options as $option) {
                    if ($option_name == $option->name) {
                        return $option->default_value;
                    }
                }
            }
        }
        return null;
    }

    function is_option_changed($option_name)
    {
        if (array_key_exists($option_name, $this->all_options)) {
            $custom_value = $this->get_option_value($option_name);
            $default_value = $this->get_default_value($option_name);
            if (is_array($default_value) && is_array($custom_value)) {
                return (trim($default_value[0]) != trim($custom_value[0])) ||
                (trim($default_value[1]) != trim($custom_value[1]));
            } else {
                return $default_value != $custom_value;
            }
        } else {
            return false;
        }
    }

    function register_options()
    {
        if (strpos($_SERVER["REQUEST_URI"], 'media-upload.php')) {
            return;
        }
        foreach ($this->sections as $section) {
            foreach ($section->categories as $category) {
                foreach ($category->options as $option) {
                    register_setting('inceptio-options', $option->name);
                }
            }
        }
    }

    function render()
    {
        echo "<div class=\"wrap\">\n";
        echo "<div class=\"icon32\" id=\"icon-themes\"></div>\n";
        echo "<h2>Inceptio - Theme Options</h2>\n";
        if (!isset($_REQUEST['tab']) || strlen($_REQUEST['tab']) == 0) {
            $selected_tab = $this->sections[0]->id;
        } else {
            $selected_tab = $_REQUEST['tab'];
        }
        echo "<h2 class=\"nav-tab-wrapper\">";
        foreach ($this->sections as $i => $section) {
            $section->render_title($section->id == $selected_tab);
        }
        echo "</h2>";

        echo "<div style=\"padding-top: 10px;\">\n";
        echo "<form id=\"theme-settings-form\" method=\"post\" action=\"options.php\">\n";
        settings_fields('inceptio-options');

        echo "<div>\n";
//        echo "<ul class=\"outer-border\">\n";
        foreach ($this->sections as $i => $section) {
            $section->render_content($section->id != $selected_tab);
        }
//        echo "</ul>\n";
        echo "</div>\n";

        echo "<p>";
        echo '<input type="submit" class="button-primary" value="' . __('Save Changes', INCEPTIO_THEME_NAME) . '"/>';
        echo '<input id="restore-theme-settings" type="submit" class="button-secondary" value="' . __('Restore Defaults', INCEPTIO_THEME_NAME) . '"/>';
        echo "</p>";

        echo "</form>\n";
        echo "</div>\n";
        echo "</div>\n";
    }
}

class Inceptio_Section
{
    var $id;
    var $title;
    var $categories = array();

    function __construct($element)
    {
        $this->id = (string)$element['id'];
        $this->title = (string)$element['title'];
        if (isset($element->category)) {
            $cnt = count($element->category);
            for ($i = 0; $i < $cnt; $i++) {
                array_push($this->categories, new Inceptio_Category($element->category[$i]));
            }
        }
    }

    function render_title($is_selected)
    {
        $selected_tab_class = $is_selected ? ' nav-tab-active' : '';
        echo '<a class="nav-tab' . $selected_tab_class . '" href="themes.php?page=inc-theme-options&tab=' . $this->id . '">' . $this->title . '</a>';
    }

    function render_content($as_hidden)
    {
        foreach ($this->categories as $i => $category) {
            $category->render($i, $as_hidden);
        }
    }
}

class Inceptio_Category
{

    var $id;
    var $title;
    var $is_expanded = false;
    var $options = array();

    function __construct($element)
    {
        $this->title = (string)$element['title'];
        $this->id = strtolower(str_replace(' ', '-', $this->title));
        if (isset($element->expanded)) {
            $this->is_expanded = (strtolower((string)$element->expanded) == 'true');
        }
        if (isset($element->option)) {
            $cnt = count($element->option);
            for ($i = 0; $i < $cnt; $i++) {
                array_push($this->options, new Inceptio_Option($element->option[$i]));
            }
        }
    }

    function render($index, $as_hidden = false)
    {
        if ($as_hidden) {
            foreach ($this->options as $i => $option) {
                $option->render(true);
            }
        } else {
            if (isset($_REQUEST['expand'])) {
                $expanded_section = $_REQUEST['expand'];
                $expanded_section = strtolower(trim($expanded_section));
                $this->is_expanded = $expanded_section == $this->id;
            }
            $category_status = $this->is_expanded ? '' : ' closed';
            $category_style = $this->is_expanded ? ' display: block;' : ' display: none;';

            echo '<div style="margin: 10px 0 0;" class="widgets-holder-wrap' . $category_status . '">';
            echo '<div style="margin-bottom: 0; min-height: 0; padding: 0 8px; position: relative;">';
            echo '<div class="sidebar-name category-title">';
            echo '<div class="sidebar-name-arrow" style="right: 0; top: 4px;"><br></div>';
            echo '<h3 style="padding: 15px 7px;">' . $this->title . '<span class="spinner"></span></h3>';
            echo '</div>';
            echo '<div class="category-body" style="clear: both; margin: 20px; 40px; 40px; 20px;' . $category_style . '">';
            foreach ($this->options as $i => $option) {
                $option->render();
            }
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    }
}

class Inceptio_Option
{

    var $name;
    var $type;
    var $description = '';
    var $prefix = '';
    var $suffix = '';
    var $default_value = '';
    var $possible_values = array();

    function __construct($element)
    {
        $this->name = (string)$element['name'];
        $this->type = (string)$element['type'];
        if (isset($element->description)) {
            $site_url = site_url();
            $this->description = (string)$element->description;
            $this->description = str_replace('${get_home_url}', $site_url, $this->description);
        }
        if (isset($element->prefix)) {
            $this->prefix = (string)$element->prefix . ' ';
        }
        if (isset($element->suffix)) {
            $this->suffix = ' ' . (string)$element->suffix;
        }
        if (isset($element->default_value)) {
            if ($this->type == 'gradient') {
                $default_value = preg_replace('/\\s+/', '', (string)$element->default_value);
                $this->default_value = explode(",", $default_value);
            } elseif ($this->type == 'font') {
                $default_value = (string)$element->default_value;
                $this->default_value = explode(",", $default_value, 2);
                if (count($this->default_value) == 1) {
                    array_push($this->default_value, '');
                }
            } else {
                $this->default_value = esc_textarea((string)$element->default_value);
            }
        }
        if (isset($element->possible_values)) {
            $possible_values_el = $element->possible_values;
            if (isset($possible_values_el['ref'])) {
                foreach ($GLOBALS[(string)$possible_values_el['ref']] as $key => $value) {
                    $this->possible_values[$key] = $value;
                }
            } else {
                $cnt = count($possible_values_el->value);
                for ($i = 0; $i < $cnt; $i++) {
                    $this->possible_values[(string)$possible_values_el->value[$i]['key']] = (string)$possible_values_el->value[$i];
                }
            }
        }
    }

    function render($as_hidden = false)
    {
        if ($as_hidden) {
            $this->print_hidden_field();
        } else {
            $description_array = explode('|', $this->description);
            foreach ($description_array as $desc) {
                echo "<p class=\"description\">$desc</p>";
            }
            echo '<div class="option">' . $this->prefix;
            switch ($this->type) {
                case 'text':
                    $this->print_text_field();
                    break;
                case 'password':
                    $this->print_password_field();
                    break;
                case 'font':
                    $this->print_font_selection_field();
                    break;
                case 'textarea':
                    $this->print_textarea_field();
                    break;
                case 'select':
                    $this->print_select_field();
                    break;
                case 'checkbox':
                    $this->print_checkbox_field();
                    break;
                case 'upload-image':
                    $this->print_upload_image_field();
                    break;
                case 'color':
                    $this->print_color_field();
                    break;
                case 'gradient':
                    $this->print_gradient_field();
                    break;
                case 'predefined-colors':
                    $this->print_predefined_colors_field();
                    break;
                case 'predefined-patterns':
                    $this->print_predefined_patterns_field();
                    break;
            }

            echo $this->suffix . '</div>';
        }
    }

    private
    function print_text_field($class_name = 'regular-text code') //small-text
    {
        $field_name = $this->name;
        $default_value = esc_textarea($this->default_value);
        $field_value = esc_textarea(get_theme_option($field_name));
        if (is_numeric($field_value)) {
            $class_name = 'small-text';
        }
        echo "<input data-default-value=\"$default_value\" type=\"text\" id=\"$field_name\" name=\"$field_name\" value=\"$field_value\" class=\"$class_name\" />";
    }

    private
    function print_password_field($class_name = 'regular-text code') //small-text
    {
        $field_name = $this->name;
        $default_value = esc_textarea($this->default_value);
        $field_value = esc_textarea(get_theme_option($field_name));
        echo "<input data-default-value=\"$default_value\" type=\"password\" id=\"$field_name\" name=\"$field_name\" value=\"$field_value\" class=\"$class_name\" />";
    }

    private
    function print_font_selection_field($class_name = 'regular-text code') //small-text
    {
        global $available_font_families;
        $field_name = $this->name;
        $default_values = $this->default_value;
        $default_value1 = trim($default_values[0]);
        $default_value2 = trim($default_values[1]);

        $field_values = get_theme_option($field_name);
        $field_value1 = trim($field_values[0]);
        $field_value2 = trim($field_values[1]);
        echo '<select data-default-value="' . $default_value1 . '" name="' . $field_name . '[]" >';
        foreach ($available_font_families as $value => $key) {
            if ($value == $field_value1) {
                echo '<option value="' . $value . '" selected="selected">' . $key . '</option>';
            } else {
                echo '<option value="' . $value . '">' . $key . '</option>';
            }
        }
        echo '</select>';
        echo ' <strong>,</strong> <input data-default-value="' . $default_value2 . '" type="text" name="' . $field_name . '[]" value="' . $field_value2 . '" class="' . $class_name . '" /> (fallback font family separated by comma)';
    }

    private
    function print_textarea_field()
    {
        $field_name = $this->name;
        $default_value = esc_textarea($this->default_value);
        $field_value = esc_textarea(get_theme_option($field_name));
        echo "<textarea data-default-value=\"$default_value\" rows=\"8\" cols=\"80\" id=\"$field_name\" name=\"$field_name\" >$field_value</textarea>";
    }

    private
    function print_select_field()
    {
        $field_name = $this->name;
        $default_value = $this->default_value;
        $possible_values = $this->possible_values;
        $field_value = get_theme_option($field_name);
        echo '<select data-default-value="' . $default_value . '" id="' . $field_name . '" name="' . $field_name . '" >';
        foreach ($possible_values as $value => $key) {
            if ($value == $field_value) {
                echo '<option value="' . $value . '" selected="selected">' . $key . '</option>';
            } else {
                echo '<option value="' . $value . '">' . $key . '</option>';
            }
        }
        echo '</select>';
    }

    private
    function print_checkbox_field()
    {
        $field_name = $this->name;
        $default_value = $this->default_value;
        $field_value = get_theme_option($field_name);

        $checked = strtolower($field_value) == 'on' ? 'checked' : '';
        echo '<input data-default-value="' . $default_value . '" type="checkbox" ' . $checked . ' id="' . $field_name . '" name="' . $field_name . '" >';
    }

    private
    function print_upload_image_field($class_name = 'regular-text code') //small-text
    {
        $field_name = $this->name;
        $default_value = $this->default_value;
        $field_value = get_theme_option($field_name);

        echo "<input data-default-value=\"$default_value\" type=\"text\" id=\"$field_name\" name=\"$field_name\" value=\"$field_value\" class=\"$class_name\" />";
        echo "<input id=\"upload_$field_name\" type=\"button\" value=\"Upload\" class=\"upload-button button\" >";
        echo "<div class=\"theme-option-media-wrap\"><img id=\"img_$field_name\" src=\"$field_value\" alt=\"\" ></div>";
    }

    private
    function print_color_field()
    {
        $field_name = $this->name;
        $default_value = $this->default_value;
        $field_value = get_theme_option($field_name);

        echo '<div class="controls"><div class="color-selector"><div style="background-color:' . $field_value . '"></div></div><input data-default-value="' . $default_value . '" type="text" value="' . $field_value . '" name="' . $field_name . '" class="of-color"></div>';
    }

    private
    function print_predefined_colors_field()
    {
        $field_name = $this->name;
        $possible_values = $this->possible_values;
        $default_value = $this->default_value;
        $field_value = get_theme_option($field_name);

        $values = array_merge(array(), $possible_values);
        if (!array_key_exists($field_value, $values)) {
            $values[$field_value] = $field_value;
        }

        $content = '<div class="controls"><div class="predefined-colors-selector"><div style="background-color:' . $field_value . '"></div></div>';
        $content .= '<select data-default-value="' . $default_value . '" id="' . $field_name . '" name="' . $field_name . '" class="of-color-select">';
        foreach ($values as $value => $key) {
            $selected = ($value == $field_value) ? ' selected="selected"' : '';
            $content .= '<option value="' . $value . '"' . $selected . '>' . $key . '</option>';
        }
        $content .= '</select>';
        $content .= '</div>';

        echo $content;
    }

    private
    function print_predefined_patterns_field()
    {
        $field_name = $this->name;
        $possible_values = $this->possible_values;
        $default_value = $this->default_value;
        $field_value = get_theme_option($field_name);

        $values = array_merge(array(), $possible_values);
        if (!array_key_exists($field_value, $values)) {
            $values[$field_value] = $field_value;
        }

        $content = '<select id="' . $field_name . '" name="' . $field_name . '" data-default-value="' . $default_value . '" >';
        foreach ($values as $value => $key) {
            $selected = ($value == $field_value) ? ' selected="selected"' : '';
            $content .= '<option value="' . $value . '"' . $selected . '>' . $key . '</option>';
        }
        $content .= '</select>';
        $content .= '<input id="upload_' . $field_name . '" type="button" value="Upload" class="predefined-patterns-selector button" >';

        echo $content;
    }

    private
    function print_gradient_field()
    {
        $field_name = $this->name;
        $default_value = $this->default_value;
        $field_value = get_theme_option($field_name);

        echo '<div class="controls"><div class="color-selector"><div style="background-color:' . $field_value[0] . '"></div></div><input data-default-value="' . $default_value[0] . '" type="text" value="' . $field_value[0] . '" name="' . $field_name . '[]" class="of-color"></div>';
        echo '<div class="controls"><div class="color-selector"><div style="background-color:' . $field_value[1] . '"></div></div><input data-default-value="' . $default_value[1] . '" type="text" value="' . $field_value[1] . '" name="' . $field_name . '[]" class="of-color"></div>';
    }

    private
    function print_hidden_field()
    {
        $field_name = $this->name;
        $field_value = get_theme_option($field_name);
        if (is_array($field_value)) {
            foreach ($field_value as $i => $value) {
                echo '<input type="hidden" name="' . $field_name . '[]" value="' . $value . '" />';
            }
        } else {
            $field_value = esc_textarea($field_value);
            echo "<input type=\"hidden\" id=\"$field_name\" name=\"$field_name\" value=\"$field_value\" />";
        }
    }
}
