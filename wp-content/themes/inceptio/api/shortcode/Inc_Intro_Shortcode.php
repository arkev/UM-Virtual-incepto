<?php

class Inc_Intro_Shortcode extends Abstract_Inc_Shortcode implements Inc_Shortcode_Designer
{

    static $ID_ATTR = "id";
    static $TYPE_ATTR = "type";
    static $ALT_IMG_ATTR = "alt_img";
    static $RIBBON_IMG_ATTR = "ribbon_img";
    private $body = '';
    private $footer = '';

    private function reset()
    {
        $this->body = '';
        $this->footer = '';
    }

    function render($attr, $inner_content = null, $code = "")
    {
        switch ($code) {
            case "intro":
                $inner_content = do_shortcode($this->prepare_content($inner_content));
                $content = $this->render_intro($attr, $inner_content);
                $this->reset();
                return $content;
            case "intro_body":
                $this->body = do_shortcode($this->prepare_content($inner_content));
                break;
            case "intro_footer":
                $this->footer = do_shortcode($this->prepare_content($inner_content));
                break;
        }

        return '';
    }

    private function render_intro($attr, $inner_content)
    {
        extract(shortcode_atts(array(
            Inc_Intro_Shortcode::$ID_ATTR => '',
            Inc_Intro_Shortcode::$TYPE_ATTR => '',
            Inc_Intro_Shortcode::$ALT_IMG_ATTR => '',
            Inc_Intro_Shortcode::$RIBBON_IMG_ATTR => '',
        ), $attr));

        if ($type == 'simple') {
            $classes = array('intro');
            $core_attributes = $this->get_core_attributes($attr, array('class' => $classes));

            $content = "<div" . $core_attributes . ">";
            $content .= empty($this->body) ? "" : $this->body . "";
            if (!empty($this->footer)) {
                $content .= "<div class=\"buttons-wrap\">";
                $content .= $this->footer . "";
                $content .= "</div>";
            }
            $content .= "</div>";
        } elseif ($type == 'box') {
            $classes = array('introbox');
            $core_attributes = $this->get_core_attributes($attr, array('class' => $classes));

            $content = "<div" . $core_attributes . ">";
            $content .= empty($this->body) ? "" : $this->body . "";
            if (!empty($this->footer)) {
                $content .= "<div class=\"buttons-wrap\">";
                $content .= $this->footer . "";
                $content .= "</div>";
            }
            if (!empty($ribbon_img)) {
                if (empty($alt_img)) {
                    $alt_img = __('New', INCEPTIO_THEME_NAME);
                }
                $ribbon_img_src = Media_Util::get_image_src($ribbon_img);
                $content .= "<img alt=\"$alt_img\" src=\"$ribbon_img_src\">";
            }
            $content .= "</div>";
        } else {
            $content = '<h1>Wrong type value. The value of the ' . Inc_Intro_Shortcode::$TYPE_ATTR . ' attribute must be: simple or box.</h1>';
        }
        return $content;
    }

    function get_names()
    {
        return array('intro', 'intro_body', 'intro_footer');
    }

    function get_visual_editor_form()
    {
        $content = '<form id="sc-intro-form" class="generic-form" method="post" action="#">';
        $content .= '<fieldset>';
        $content .= '<div>';
        $content .= '<label for="sc-intro-id">' . __('ID', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-intro-id" name="sc-intro-id" type="text">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="Button ">' . __('Type', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="sc-intro-type" name="sc-intro-type">';
        $content .= '<option value="simple">' . __('Simple', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="box">' . __('Box', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-intro-body">' . __('Body Content', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<textarea id="sc-intro-body" name="sc-intro-body" class="required"></textarea>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-intro-footer">' . __('Footer Content', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<textarea id="sc-intro-footer" name="sc-intro-footer"></textarea>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-intro-ribbon-img">' . __('Ribbon Image', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-intro-ribbon-img" name="sc-intro-ribbon-img" type="text">';
        $content .= '</div>';


        $content .= '<div >';
        $content .= '<input id="sc-intro-form-submit" type="submit" name="submit" value="' . __('Insert Intro Box', INCEPTIO_THEME_NAME) . '" class="button-primary">';
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
        return __('Intro Box', INCEPTIO_THEME_NAME);
    }

}