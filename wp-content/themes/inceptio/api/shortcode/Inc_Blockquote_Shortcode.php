<?php


class Inc_Blockquote_Shortcode extends Abstract_Inc_Shortcode implements Inc_Shortcode_Designer
{

    static $ID_ATTR = "id";
    static $TYPE_ATTR = "type";
    static $AUTHOR_ATTR = "author";
    static $AUTHOR_GENDER_ATTR = "author_gender";
    static $PROFESSION_ATTR = "profession";
    static $COMPANY_ATTR = "company";

    function render($attr, $inner_content = null, $code = "")
    {
        $content = '';
        if (isset($inner_content) && strlen($inner_content) > 0) {
            extract(shortcode_atts(array(
                Inc_Blockquote_Shortcode::$ID_ATTR => '',
                Inc_Blockquote_Shortcode::$TYPE_ATTR => 'simple',
                Inc_Blockquote_Shortcode::$AUTHOR_ATTR => '',
                Inc_Blockquote_Shortcode::$AUTHOR_GENDER_ATTR => '',
                Inc_Blockquote_Shortcode::$PROFESSION_ATTR => '',
                Inc_Blockquote_Shortcode::$COMPANY_ATTR => '',
            ), $attr));

            $inner_content = do_shortcode($this->prepare_content($inner_content));
            if (!inc_start_with(strtolower($inner_content), '<p') &&
                !inc_start_with(strtolower($inner_content), '<span') &&
                !inc_start_with(strtolower($inner_content), '<div') &&
                !inc_start_with(strtolower($inner_content), '<h')
            ) {
                $inner_content = "<p>$inner_content</p>";
            }

            $has_author = !empty($author) || !empty($profession) || !empty($company);

            if ($type == 'speech') {
                $author_class = '';
                if (isset($author_gender) && !empty($author_gender)) {
                    if (strtolower($author_gender) == 'm') {
                        $author_class = ' author-male';
                    } elseif (strtolower($author_gender) == 'f') {
                        $author_class = ' author-female';
                    }
                }

                $classes = array('speech-bubble');
                $core_attributes = $this->get_core_attributes($attr, array('class' => $classes));

                $content .= "<blockquote" . $core_attributes . ">";
                $content .= "<div class=\"quote-content\">";
                $content .= "$inner_content";
                if ($has_author) {
                    $content .= "<span class=\"quote-arrow\"></span>";
                }
                $content .= "</div>";
                if ($has_author) {
                    $content .= "<div class=\"quote-meta" . $author_class . "\">";
                    if (!empty($author)) {
                        $content .= "<strong>" . $author . "</strong>";
                    }
                    if (!empty($profession)) {
                        $content .= ", $profession";
                    }
                    $content .= "<br>";
                    if (!empty($company)) {
                        $content .= "<span>" . $company . "</span>";
                    }
                    $content .= "</div>";
                }
                $content .= "</blockquote>";
            } else {
                $classes = array('simple');
                $core_attributes = $this->get_core_attributes($attr, array('class' => $classes));

                $content .= "<blockquote" . $core_attributes . ">";
                $content .= "<div class=\"quote-content\">";
                $content .= "$inner_content";
                $content .= "</div>";
                if ($has_author) {
                    $content .= "<div class=\"quote-meta\">&mdash;";
                    if (!empty($author)) {
                        $content .= " $author";
                    }
                    if (!empty($profession)) {
                        $content .= ", $profession";
                    }
                    if (!empty($company)) {
                        $content .= ", $company";
                    }
                    $content .= "</div>";
                }
                $content .= "</blockquote>";
            }
        }
        return $content;
    }

    function get_names()
    {
        return array('bq');
    }

    function get_visual_editor_form()
    {
        $content = '<form id="sc-bq-form" class="generic-form" method="post" action="#" data-sc="bq">';
        $content .= '<fieldset>';
        $content .= '<div>';
        $content .= '<label for="sc-bq-id">' . __('ID', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-bq-id" name="sc-bq-id" type="text" data-attr-name="' . Inc_Blockquote_Shortcode::$ID_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-bq-type">' . __('Type', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="sc-bq-type" name="sc-bq-type" data-attr-name="' . Inc_Blockquote_Shortcode::$TYPE_ATTR . '" data-attr-type="attr">';
        $content .= '<option value="simple">' . __('Simple', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="speech">' . __('Speech Bubble', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-bq-author">' . __('Author Name', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-bq-author" name="sc-bq-author" type="text" data-attr-name="' . Inc_Blockquote_Shortcode::$AUTHOR_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-bq-ag">' . __('Author Gender', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="sc-bq-ag" name="sc-bq-ag" data-attr-name="' . Inc_Blockquote_Shortcode::$AUTHOR_GENDER_ATTR . '" data-attr-type="attr">';
        $content .= '<option value="">' . __('Unknown', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="m">' . __('Male', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="f">' . __('Female', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-bq-profession">' . __('Author Profession', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-bq-profession" name="sc-bq-profession" type="text" data-attr-name="' . Inc_Blockquote_Shortcode::$PROFESSION_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-bq-company">' . __('Company', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-bq-company" name="sc-bq-company" type="text" data-attr-name="' . Inc_Blockquote_Shortcode::$COMPANY_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-bq-content">' . __('Content', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<textarea id="sc-bq-content" name="sc-bq-content" class="required" data-attr-type="content"></textarea>';
        $content .= '</div>';
        $content .= '<div >';
        $content .= '<input id="sc-bq-form-submit" type="submit" name="submit" value="' . __('Insert Blockquote', INCEPTIO_THEME_NAME) . '" class="button-primary">';
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
        return __('Blockquote (Testimonial)', INCEPTIO_THEME_NAME);
    }

}