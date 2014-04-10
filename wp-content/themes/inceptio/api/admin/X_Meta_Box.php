<?php

class X_Meta_Box
{
    var $config;

    public function __construct($config)
    {
        if (is_user_logged_in()) {
            $this->config = $config;
            add_action('add_meta_boxes', array(&$this, 'add_meta_box'));
            add_action('save_post', array(&$this, 'save_post'));
        }
    }

    public function add_meta_box()
    {
        foreach ($this->config['location'] as $location) {
            add_meta_box(
                $this->config['id'],
                $this->config['title'],
                array(&$this, 'render_meta_box_content'),
                $location,
                $this->config['context'],
                $this->config['priority']
            );
        }
    }

    public function render_meta_box_content()
    {
        global $post;
        $page_type = $post->post_type;
        $slider_type_key = $page_type . '_slider_type';
        if (array_key_exists($slider_type_key, $this->config) && strlen($this->config[$slider_type_key]) > 0) {
            echo '<input type="hidden" id="slider-type" name="slider-type" value="' . $this->config[$slider_type_key] . '">';
            echo '<input type="hidden" id="page-type" name="page-type" value="' . $page_type . '">';
        }
        $callback_key = $page_type . '_callback';
        if (array_key_exists($callback_key, $this->config)) {
            call_user_func(($this->config[$callback_key]));
        } else {
            echo '<table cellspacing="1" cellpadding="2" style="width: 100%;" class="form-table">';
            echo '<tbody>';
            foreach ($this->config['fields'] as $field) {
                echo '<tr class="form-field">';
                echo '<th valign="top" scope="row"><label for="' . $field['id'] . '">' . $field['name'] . '</label></th>';
                echo '<td>';
                if ($field['type'] == 'text') {
                    $this->print_text_field($field);
                } elseif ($field['type'] == 'textarea') {
                    $this->print_textarea_field($field);
                } elseif ($field['type'] == 'select') {
                    $this->print_select_field($field);
                } elseif ($field['type'] == 'checkbox') {
                    $this->print_checkbox_field($field);
                } elseif ($field['type'] == 'callback') {
                    call_user_func(($field['callback']));
                }
                if (isset($field['desc']) && $field['desc'] != '') {
                    echo '<p style="font-style: italic;">' . $field['desc'] . '</p>';
                }
                echo '</td></tr>';
            }
            echo '</tbody></table>';
        }
    }

    private function print_text_field($field)
    {
        echo '<input type="text" style="width: 95%" value="' . htmlspecialchars($this->get_field_value($field)) . '" id="' . $field['id'] . '" class="code" name="' . $field['id'] . '">';
    }

    private function print_textarea_field($field)
    {
        echo '<textarea style="width: 95%" rows="3" cols="20" id="' . $field['id'] . '" name="' . $field['id'] . '">' . htmlspecialchars($this->get_field_value($field)) . '</textarea>';
    }

    private function print_checkbox_field($field)
    {
        $on = (strtolower($this->get_field_value($field)) == 'on') ? 'checked' : '';
        echo '<input type="checkbox" ' . $on . ' style="width:auto" id="' . $field['id'] . '" name="' . $field['id'] . '">';
    }

    private function print_select_field($field)
    {
        $field_value = $this->get_field_value($field);
        echo '<select size="1" id="' . $field['id'] . '" name="' . $field['id'] . '">';
        foreach ($field['values'] as $key => $value) {
            $selected = (strtolower($field_value) == strtolower($key)) ? 'selected' : '';
            echo "<option value=\"$key\" $selected>$value</option>";
        }
        echo '</select>';
    }

    public function save_post($post_id)
    {
        // verify if this is an auto save routine.
        // If it is our form has not been submitted, so we dont want to do anything
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if ((!isset($_POST['post_ID']) || $post_id != $_POST['post_ID'])) {
            return;
        }
        // verify this came from the our screen and with proper authorization,
        // because save_post can be triggered at other times
        //        if (!wp_verify_nonce($_POST['myplugin_noncename'], plugin_basename(__FILE__))) {
        //            return;
        //        }

        $post_type = array_key_exists('post_type', $_POST)? $_POST['post_type']: '';
        // Check permissions
        if ('page' == $post_type) {
            if (!current_user_can('edit_page', $post_id)) {
                return;
            }
        } else {
            if (!current_user_can('edit_post', $post_id)) {
                return;
            }
        }

        if (isset($this->config['fields']) && is_array($this->config['fields'])) {
            // OK, we're authenticated: we need to find and save the data
            foreach ($this->config['fields'] as $field) {
                if (isset($_POST[$field['id']])) {
                    $field_value = stripslashes($_POST[$field['id']]);
                    $old_field_value = get_post_meta($post_id, $field['id'], true);
                    update_post_meta($post_id, $field['id'], $field_value, $old_field_value);
                }
            }
        }
    }

    private function get_field_value($field)
    {
        global $post;
        $post_values = get_post_custom($post->ID);
        if (isset($post_values[$field['id']])) {
            $old_field_value = $post_values[$field['id']];
            if (is_array($old_field_value)) {
                return $old_field_value[0];
            } else {
                return $old_field_value;
            }
        } else {
            return ''; //$field['default_value'];
        }
    }
}