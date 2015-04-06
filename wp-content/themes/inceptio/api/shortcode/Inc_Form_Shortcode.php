<?php


class Inc_Form_Shortcode extends Abstract_Inc_Shortcode implements Inc_Shortcode_Designer
{

    static $ID_ATTR = "id";
    static $ACTION_ATTR = "action";
    static $RECIPIENTS_ATTR = "recipients";
    static $SUCCESS_MSG_ATTR = "success";
    static $ERROR_MSG_ATTR = "error";
    static $SUBMIT_LABEL_ATTR = "submit_label";
    static $DISPLAY_LEGEND_ATTR = "display_legend";
    static $INPUT_ID_ATTR = 'id';
    static $INPUT_NAME_ATTR = 'name';
    static $INPUT_TYPE_ATTR = 'type';
    static $INPUT_REQUIRED_ATTR = 'required';
    static $CLASSES_ATTR = 'classes';
    static $INPUT_LABEL_ATTR = 'label';
    static $INPUT_VALUE_ATTR = 'value';

    function render($attr, $inner_content = null, $code = "")
    {
        $content = '';
        switch ($code) {
            case "form":
                $inner_content = do_shortcode($this->prepare_content($inner_content));
                $content .= $this->render_form($attr, $inner_content);
                break;
            case "input":
                $inner_content = do_shortcode($this->prepare_content($inner_content));
                $content .= $this->render_form_input($attr, $inner_content);
                break;
        }
        return $content;
    }

    private function render_form($attr, $inner_content)
    {
        extract(shortcode_atts(array(
            Inc_Form_Shortcode::$ID_ATTR => '',
            Inc_Form_Shortcode::$RECIPIENTS_ATTR => '',
            Inc_Form_Shortcode::$ACTION_ATTR => '#',
            Inc_Form_Shortcode::$SUBMIT_LABEL_ATTR => '',
            Inc_Form_Shortcode::$DISPLAY_LEGEND_ATTR => 'true',
            Inc_Form_Shortcode::$SUCCESS_MSG_ATTR => '',
            Inc_Form_Shortcode::$ERROR_MSG_ATTR => ''), $attr));

        $submitButtonId = uniqid('submit-');
        $successBoxId = uniqid('success-');
        $errorBoxId = uniqid('error-');
        $submit_label = !empty($submit_label) ? $submit_label : __('Submit', INCEPTIO_THEME_NAME);
        $success = !empty($success) ? $success : __('The form has been successfully submitted', INCEPTIO_THEME_NAME);
        $error = !empty($error) ? $error : __('The form couldn\'t be submitted because a server error occurred. Please try again later.', INCEPTIO_THEME_NAME);
        $form_action = site_url('wp-admin/admin-ajax.php');

        $content = do_shortcode('[notif id="' . $successBoxId . '" type="success" display="false"]' . $success . '[/notif]');
        $content .= do_shortcode('[notif id="' . $errorBoxId . '" type="error" display="false"]' . $error . '[/notif]');

        $classes = array('content-form');
        $core_attributes = $this->get_core_attributes($attr, array('class' => $classes));

        $content .= "<form" . $core_attributes . " method=\"post\" action=\"$form_action\">";
        $content .= $inner_content;
        if(!empty($recipients)){
            $content .= "<input type=\"hidden\" name=\"recipients\" value=\"$recipients\">";
        }
        if (inc_is_captcha_form_enabled()) {
            $content .= "<p>";
            $content .= do_shortcode('[captcha][/captcha]');
            $content .= "</p>";
        }
        $content .= "<p>";
        $content .= "<input id=\"$submitButtonId\" class=\"button\" type=\"submit\" name=\"submit\" value=\"$submit_label\">";
        $content .= "</p>";

        $content .= "</form>";

        if ($display_legend == 'true') {
            $content .= "<p><span class=\"asterisk note\">*</span> " . __('Required fields', INCEPTIO_THEME_NAME) . "</p>";
        }
        $content .= "<script type=\"text/javascript\">
            if(!document['formsSettings']){
                document['formsSettings'] = [];
            }
            document['formsSettings'].push({
                action: '" . $action . "',
                submitButtonId: '" . $submitButtonId . "',
                successBoxId: '" . $successBoxId . "',
                errorBoxId: '" . $errorBoxId . "'
            });
		</script>";
        return $content;
    }

    private function render_form_input($attr, $inner_content = null)
    {
        $content = '';
        extract(shortcode_atts(array(
            Inc_Form_Shortcode::$INPUT_ID_ATTR => uniqid(),
            Inc_Form_Shortcode::$INPUT_NAME_ATTR => '',
            Inc_Form_Shortcode::$INPUT_TYPE_ATTR => 'text',
            Inc_Form_Shortcode::$INPUT_REQUIRED_ATTR => 'false',
            Inc_Form_Shortcode::$CLASSES_ATTR => '',
            Inc_Form_Shortcode::$INPUT_LABEL_ATTR => '',
            Inc_Form_Shortcode::$INPUT_VALUE_ATTR => ''
        ), $attr));
        $required_span = '';
        if ($required == 'true') {
            $required_span = "<span class=\"asterisk note\">*</span>";
            if (empty($classes)) {
                $classes = "required";
            } else {
                $classes = $classes . " required";
            }
        }

        if ($type != 'submit') {
            $content .= "<p>";
            if ($type == 'hidden') {
                $content .= "<input id=\"$id\" type=\"$type\" name=\"$name\" value=\"$value\">";
            } elseif ($type == 'custom') {
                $content .= "<label for=\"$id\">" . $label . ":$required_span</label>";
                $content .= $inner_content;
            } else {
                if ($type == 'textarea') {
                    $content .= "<label for=\"$id\">" . $label . ":$required_span</label>";
                    $content .= "<textarea id=\"$id\" cols=\"68\" rows=\"8\" name=\"$name\" class=\"$classes\">$value</textarea>";
                } elseif ($type == 'checkbox') {
                    $checked = ($value == 'on' || $value == 'checked') ? 'checked' : '';
                    $content .= "<input id=\"$id\" name=\"$name\" type=\"checkbox\" class=\"$classes\" $checked>";
                    $content .= " <label for=\"$id\">" . $label . "$required_span</label>";
                } elseif ($type == 'number') {
                    $content .= "<label for=\"$id\">" . $label . ":$required_span</label>";
                    $content .= "<input id=\"$id\" type=\"text\" name=\"$name\" value=\"$value\" class=\"number $classes\">";
                } elseif ($type == 'datepicker') {
                    $content .= "<label for=\"$id\">" . $label . ":$required_span</label>";
                    $content .= "<input id=\"$id\" type=\"text\" name=\"$name\" value=\"$value\" class=\"datepicker $classes\">";
                } else {
                    $content .= "<label for=\"$id\">" . $label . ":$required_span</label>";
                    $content .= "<input id=\"$id\" type=\"$type\" name=\"$name\" value=\"$value\" class=\"$classes\">";

                }
            }
            $content .= "</p>";
        }
        return $content;
    }

    function get_names()
    {
        return array('form', 'input');
    }

    function get_visual_editor_form()
    {
        $example1 = '[input ' . Inc_Form_Shortcode::$ID_ATTR . '="name-id" ' . Inc_Form_Shortcode::$INPUT_LABEL_ATTR . '="Name" ' . Inc_Form_Shortcode::$INPUT_TYPE_ATTR . '="text" ' . Inc_Form_Shortcode::$INPUT_NAME_ATTR . '="name" ' . Inc_Form_Shortcode::$INPUT_REQUIRED_ATTR . '="true"][/input]';
        $example1 .= '[input ' . Inc_Form_Shortcode::$ID_ATTR . '="email-id" ' . Inc_Form_Shortcode::$INPUT_LABEL_ATTR . '="Email" ' . Inc_Form_Shortcode::$INPUT_TYPE_ATTR . '="email" ' . Inc_Form_Shortcode::$INPUT_NAME_ATTR . '="email" ' . Inc_Form_Shortcode::$INPUT_REQUIRED_ATTR . '="true"][/input]';
        $example1 .= '[input ' . Inc_Form_Shortcode::$ID_ATTR . '="url-id" ' . Inc_Form_Shortcode::$INPUT_LABEL_ATTR . '="URL" ' . Inc_Form_Shortcode::$INPUT_TYPE_ATTR . '="url" ' . Inc_Form_Shortcode::$INPUT_NAME_ATTR . '="url" ' . Inc_Form_Shortcode::$INPUT_REQUIRED_ATTR . '="false"][/input]';
        $example1 .= '[input ' . Inc_Form_Shortcode::$ID_ATTR . '="subject-id" ' . Inc_Form_Shortcode::$INPUT_LABEL_ATTR . '="Subject" ' . Inc_Form_Shortcode::$INPUT_TYPE_ATTR . '="text" ' . Inc_Form_Shortcode::$INPUT_NAME_ATTR . '="subject" ' . Inc_Form_Shortcode::$INPUT_REQUIRED_ATTR . '="true"][/input]';
        $example1 .= '[input ' . Inc_Form_Shortcode::$ID_ATTR . '="message-id" ' . Inc_Form_Shortcode::$INPUT_LABEL_ATTR . '="Message" ' . Inc_Form_Shortcode::$INPUT_TYPE_ATTR . '="textarea" ' . Inc_Form_Shortcode::$INPUT_NAME_ATTR . '="message" ' . Inc_Form_Shortcode::$INPUT_REQUIRED_ATTR . '="true"][/input]';
        $example1 = htmlspecialchars($example1);
        $example1 = str_replace(array('[', ']'), array('&#91;', '&#93;'), $example1);

        $example2 = '[input ' . Inc_Form_Shortcode::$ID_ATTR . '="tf-id" ' . Inc_Form_Shortcode::$INPUT_LABEL_ATTR . '="Text Field" ' . Inc_Form_Shortcode::$INPUT_TYPE_ATTR . '="text" ' . Inc_Form_Shortcode::$INPUT_NAME_ATTR . '="name" ' . Inc_Form_Shortcode::$INPUT_REQUIRED_ATTR . '="true"][/input]';
        $example2 .= '[input ' . Inc_Form_Shortcode::$ID_ATTR . '="ef-id" ' . Inc_Form_Shortcode::$INPUT_LABEL_ATTR . '="Email Field" ' . Inc_Form_Shortcode::$INPUT_TYPE_ATTR . '="email" ' . Inc_Form_Shortcode::$INPUT_NAME_ATTR . '="email" ' . Inc_Form_Shortcode::$INPUT_REQUIRED_ATTR . '="true"][/input]';
        $example2 .= '[input ' . Inc_Form_Shortcode::$ID_ATTR . '="erlf-id" ' . Inc_Form_Shortcode::$INPUT_LABEL_ATTR . '="URL Field" ' . Inc_Form_Shortcode::$INPUT_TYPE_ATTR . '="url" ' . Inc_Form_Shortcode::$INPUT_NAME_ATTR . '="url" ' . Inc_Form_Shortcode::$INPUT_REQUIRED_ATTR . '="false"][/input]';
        $example2 .= '[input ' . Inc_Form_Shortcode::$ID_ATTR . '="cf-id" ' . Inc_Form_Shortcode::$INPUT_LABEL_ATTR . '="Checkbox Field" ' . Inc_Form_Shortcode::$INPUT_TYPE_ATTR . '="checkbox" ' . Inc_Form_Shortcode::$INPUT_NAME_ATTR . '="checkbox" ' . Inc_Form_Shortcode::$INPUT_REQUIRED_ATTR . '="true"][/input]';
        $example2 .= '[input ' . Inc_Form_Shortcode::$ID_ATTR . '="custf-id" ' . Inc_Form_Shortcode::$INPUT_LABEL_ATTR . '="Custom Field" ' . Inc_Form_Shortcode::$INPUT_TYPE_ATTR . '="custom" ' . Inc_Form_Shortcode::$INPUT_REQUIRED_ATTR . '="true"]<select id="custf-id" name="custom"><option value="op1">Option 1</option><option value="op2">Option 2</option></select>[/input]';
        $example2 .= '[input ' . Inc_Form_Shortcode::$ID_ATTR . '="taf-id" ' . Inc_Form_Shortcode::$INPUT_LABEL_ATTR . '="Textarea Field" ' . Inc_Form_Shortcode::$INPUT_TYPE_ATTR . '="textarea" ' . Inc_Form_Shortcode::$INPUT_NAME_ATTR . '="textarea" ' . Inc_Form_Shortcode::$INPUT_REQUIRED_ATTR . '="true"][/input]';
        $example2 = htmlspecialchars($example2);
        $example2 = str_replace(array('[', ']'), array('&#91;', '&#93;'), $example2);

        $content = '<form id="sc-form-form" class="generic-form" method="post" action="#" data-sc="form">';
        $content .= '<fieldset>';
        $content .= '<div>';
        $content .= '<label for="sc-form-ext">' . __('Example Type', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="sc-form-ext" name="sc-form-ext">';
        $content .= '<option value="contact">' . __('Contact Form Example', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="basic">' . __('Basic Form Example', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-form-id">' . __('ID', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-form-id" name="sc-form-action" type="text" data-attr-name="' . Inc_Form_Shortcode::$ID_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-form-action">' . __('Action', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-form-action" name="sc-form-action" type="text" data-attr-name="' . Inc_Form_Shortcode::$ACTION_ATTR . '" data-attr-type="attr" class="required" value="process_contact_form">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-form-sl">' . __('Submit Label', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-form-sl" name="sc-form-sl" type="text" data-attr-name="' . Inc_Form_Shortcode::$SUBMIT_LABEL_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-form-success">' . __('Success Message', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-form-success" name="sc-form-success" type="text" data-attr-name="' . Inc_Form_Shortcode::$SUCCESS_MSG_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-form-error">' . __('Error Message', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-form-error" name="sc-form-error" type="text" data-attr-name="' . Inc_Form_Shortcode::$ERROR_MSG_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<input id="sc-form-dl" name="sc-form-dl" type="checkbox" checked data-attr-name="' . Inc_Form_Shortcode::$DISPLAY_LEGEND_ATTR . '" data-attr-type="attr">';
        $content .= '<label for="sc-form-dl">' . __('Display Legend', INCEPTIO_THEME_NAME) . '</label>';
        $content .= '</div>';
        $content .= '<div >';
        $content .= '<input id="sc-form-ex-contact" type="hidden" value="' . $example1 . '">';
        $content .= '<input id="sc-form-ex-basic" type="hidden" value="' . $example2 . '">';
        $content .= '<input id="sc-form-form-submit" type="submit" name="submit" value="' . __('Insert Form', INCEPTIO_THEME_NAME) . '" class="button-primary">';
        $content .= '</div>';
        $content .= '</fieldset>';
        $content .= '</form>';

        return $content;
    }

    function get_group_title()
    {
        return __('Others', INCEPTIO_THEME_NAME);
    }

    function get_title()
    {
        return __('Form', INCEPTIO_THEME_NAME);
    }
}