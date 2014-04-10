<?php


class Inc_List_Shortcode implements Inc_Shortcode_Designer
{

    function get_visual_editor_form()
    {
        $content = '<form id="sc-list-form" class="generic-form" method="post" action="#">';
        $content .= '<fieldset>';
        $content .= '<div>';
        $content .= '<label for="sc-list-type">' . __('Type', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="sc-list-type" name="sc-list-type">';
        $content .= '<option value="ul">' . __('Unordered List', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="ol">' . __('Ordered List', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';

        $content .= '<div id="sc-list-style-div-ul">';
        $content .= '<label for="sc-list-style-ul">' . __('Style', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="sc-list-style-ul" name="sc-list-style-ul">';
        $content .= '<option value="arrow">' . __('Arrow', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="circle">' . __('Circle', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="square">' . __('Square', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="check">' . __('Check', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="green-arrow">' . __('Green Arrow', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="green-plus">' . __('Green Plus', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="green-check">' . __('Green Check', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';

        $content .= '<div id="sc-list-style-div-ol" style="display: none">';
        $content .= '<label for="sc-list-style-ol">' . __('Style', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="sc-list-style-ol" name="sc-list-style-ol">';
        $content .= '<option value="decimal">' . __('Decimal', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="upper-roman">' . __('Upper Roman', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="lower-alpha">' . __('Lower Alpha', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="upper-alpha">' . __('Upper Alpha', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';

        $content .= '<div>';
        $content .= '<label for="sc-list-items">' . __('Items (one item per line)', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<textarea id="sc-list-items" name="sc-list-items" class="required"></textarea>';
        $content .= '</div>';

        $content .= '<div >';
        $content .= '<input id="sc-list-form-submit" type="submit" name="submit" value="' . __('Insert List', INCEPTIO_THEME_NAME) . '" class="button-primary">';
        $content .= '</div>';
        $content .= '</fieldset>';
        $content .= '</form>';

        return $content;
    }

    function get_group_title()
    {
        return __('Typography', INCEPTIO_THEME_NAME);
    }

    function get_title()
    {
        return __('List', INCEPTIO_THEME_NAME);
    }

}