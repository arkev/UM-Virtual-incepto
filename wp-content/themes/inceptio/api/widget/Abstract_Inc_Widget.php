<?php


abstract class Abstract_Inc_Widget extends WP_Widget
{

    static $CONTACT_DETAILS_WIDGET = "Inc_Contact_Details_Widget";
    static $LATEST_TWEETS_WIDGET = "Inc_Latest_Tweets_Widget";
    static $FLICKR_WIDGET = "Inc_Flickr_Widget";
    static $POST_CATEGORIES = "Inc_Categories_Widget";
    static $RECENT_POSTS = "Inc_Recent_Posts_Widget";
    static $RECENT_COMMENTS = "Inc_Recent_Comments_Widget";
    static $META = "Inc_Meta_Widget";
    static $POST_ARCHIVES = "Inc_Archives_Widget";
    static $MOST_USED_TAGS = "Inc_Most_Used_Tags_Widget";
    static $TAGS_CLOUD = "Inc_Tag_Cloud_Widget";
    static $PAGES = "Inc_Pages_Widget";
    static $NEWSLETTER_SUBSCRIPTION = "Inc_Newsletter_Subscription_Widget";
    static $SHORTCODE_EVALUATOR = "Inc_Shortcode_Eval_Widget";

    static $TEXT_WIDGET = "Inc_Text_Widget";

    function print_info_field($label, $value)
    {
        $id = uniqid();
        echo '<p>';
        echo '<label for="' . $id . '">' . $label . '</label>';
        echo '<input id="' . $id . '" type="text" class="widefat" disabled="disabled" value="' . $value . '" />';
        echo '</p >';
    }

    function print_text_field($instance, $field, $text, $id = '', $display = true)
    {
        $field_id = strlen($id) == 0 ? $this->get_field_id($field) : $id;
        $field_name = $this->get_field_name($field);
        $field_value = esc_textarea(strip_tags($instance[$field]));
        $style = $display ? '' : ' style="display:none;"';
        echo '<p id="' . $field_id . '-p" ' . $style . '>';
        echo '<label for="' . $field_id . '" >' . $text . '</label>';
        echo '<input type="text" class="widefat" id="' . $field_id . '" name="' . $field_name . '" value="' . $field_value . '" />';
        echo '</p >';
    }

    function print_checkbox_field($instance, $field, $text, $id = '', $display = true)
    {
        $field_id = strlen($id) == 0 ? $this->get_field_id($field) : $id;
        $field_name = $this->get_field_name($field);
        $field_value = (strtolower($instance[$field]) === 'on') ? 'checked' : '';
        $style = $display ? '' : ' style="display:none;"';
        echo '<p id="' . $field_id . '-p" ' . $style . '>';
        echo '<input type="checkbox" id="' . $field_id . '" name="' . $field_name . '" ' . $field_value . ' />';
        echo '<label for="' . $field_id . '" > ' . $text . '</label>';
        echo '</p >';
    }

    function print_textarea_field($instance, $field, $text, $strip_tags = true, $id = '', $display = true)
    {
        $field_id = strlen($id) == 0 ? $this->get_field_id($field) : $id;
        $field_name = $this->get_field_name($field);
        $field_value = $strip_tags ? esc_textarea(strip_tags($instance[$field])) : $instance[$field];
        $style = $display ? '' : ' style="display:none;"';
        echo '<p id="' . $field_id . '-p" ' . $style . '>';
        echo '<label for="' . $field_id . '" >' . $text . '</label>';
        echo '<textarea class="widefat" rows="10" cols="10" id="' . $field_id . '" name="' . $field_name . '" >' . $field_value . '</textarea>';
        echo '</p >';
    }

    function print_select($instance, $field, $options, $text, $id = '', $display = true, $onchange_function = '')
    {
        $field_id = strlen($id) == 0 ? $this->get_field_id($field) : $id;
        $field_name = $this->get_field_name($field);
        $field_value = esc_textarea(strip_tags($instance[$field]));
        $style = $display ? '' : ' style="display:none;"';
        echo '<p id="' . $field_id . '-p" ' . $style . '>';
        echo '<label for="' . $field_id . '" >' . $text . '</label>';
        $onchange = strlen($onchange_function) > 0 ? ' onchange=' . $onchange_function . '(this);' : '';
        echo '<select ' . $onchange . ' class="widefat" id="' . $field_id . '" name="' . $field_name . '">';
        foreach ($options as $key => $value) {
            if ($field_value == $key) {
                $selected = ' selected="selected"';
            } else {
                $selected = '';
            }
            echo '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
        }
        echo '</select>';
        echo '</p >';
    }
}