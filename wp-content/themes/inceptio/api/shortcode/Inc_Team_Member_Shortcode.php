<?php


class Inc_Team_Member_Shortcode extends Abstract_Inc_Shortcode implements Inc_Shortcode_Designer
{
    static $NAME_ATTR = "name";
    static $JOB_ATTR = "job";
    static $PHOTO_ATTR = "photo";
    static $URL_ATTR = "url";
    static $TARGET_ATTR = "target";

    function render($attr, $inner_content = null, $code = "")
    {
        $inner_content = do_shortcode($this->prepare_content($inner_content));
        extract(shortcode_atts(array(
            Inc_Team_Member_Shortcode::$URL_ATTR => '',
            Inc_Team_Member_Shortcode::$TARGET_ATTR => '',
            Inc_Team_Member_Shortcode::$NAME_ATTR => '',
            Inc_Team_Member_Shortcode::$JOB_ATTR => '',
            Inc_Team_Member_Shortcode::$PHOTO_ATTR => ''), $attr));

        $photo_src = Media_Util::get_image_src($photo);
        $social_sc = new Inc_Social_Icons_Shortcode();

        $classes = array('team-member');
        $core_attributes = $this->get_core_attributes($attr, array('class' => $classes));

        $content = "<div" . $core_attributes . ">";
        if (!empty($url)) {
            $target_attr = $this->get_attribute('target', $target);
            $href_attr = $this->get_attribute('href', $url);
            $content .= "<a $href_attr $target_attr>";
        }
        $content .= "<img class=\"photo\" src=\"$photo_src\" alt=\"$name\">";
        if (!empty($url)) {
            $content .= "</a>";
        }
        $content .= "<div class=\"content\">";
        $content .= "<h3 class=\"name\">$name</h3>";
        if (!empty($job)) {
            $content .= "<span class=\"job-title\">$job</span>";
        }
        $content .= $social_sc->render($attr, null, "");
        if (!inc_start_with(strtolower($inner_content), '<p') &&
            !inc_start_with(strtolower($inner_content), '<span') &&
            !inc_start_with(strtolower($inner_content), '<div') &&
            !inc_start_with(strtolower($inner_content), '<h')
        ) {
            $content .= "<p>$inner_content</p>";
        } else {
            $content .= $inner_content . "";
        }
        $content .= "</div>";
        $content .= "</div>";
        return $content;
    }

    function get_names()
    {
        return array('team_member', 'tm');
    }

    function get_visual_editor_form()
    {
        $content = '<form id="sc-tm-form" class="generic-form" method="post" action="#" data-sc="tm">';
        $content .= '<fieldset>';
        $content .= '<div class="image-tab-content">';

        $content .= '<div class="image-tab-content-left">';
        $content .= '<div>';
        $content .= '<label for="sc-tm-src">' . __('Photo', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="sc-tm-src" name="sc-tm-src" class="required image-selector" data-attr-name="' . Inc_Team_Member_Shortcode::$PHOTO_ATTR . '" data-attr-type="attr">';
        $content .= '<option value="">' . __('Select Image ...', INCEPTIO_THEME_NAME) . '</option>';
        $images = Media_Util::get_all_uploaded_images();
        foreach ($images as $img) {
            $images = wp_get_attachment_image_src($img->ID);
            $content .= '<option value="' . $img->post_title . '" data-src="' . $images[0] . '">' . $img->post_title . '</option>';
        }
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-tm-name">' . __('Name', INCEPTIO_THEME_NAME) . '</label>';
        $content .= '<input id="sc-tm-name" name="sc-tm-name" type="text" class="required" data-attr-name="' . Inc_Team_Member_Shortcode::$NAME_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-tm-job">' . __('Job Title', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-tm-job" name="sc-tm-job" type="text" data-attr-name="' . Inc_Team_Member_Shortcode::$JOB_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-tm-descr">' . __('Description', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<textarea id="sc-tm-descr" name="sc-tm-descr" data-attr-type="content"></textarea>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-tm-url">' . __('URL', INCEPTIO_THEME_NAME) . '</label>';
        $content .= '<input id="sc-tm-url" name="sc-tm-url" type="text" data-attr-name="' . Inc_Team_Member_Shortcode::$URL_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-tm-target">' . __('Target Window', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="sc-tm-target" name="sc-tm-target" data-attr-name="' . Inc_Team_Member_Shortcode::$TARGET_ATTR . '" data-attr-type="attr">';
        $content .= '<option value="">' . __('Same Window', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="_blank">' . __('New Window', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="_parent">' . __('Parent Window', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="_top">' . __('Full Body of the Window', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-tm-mail">' . __('Mail Address', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-tm-mail" name="sc-tm-mail" type="text" data-attr-name="' . Inc_Social_Icons_Shortcode::$MAIL_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-tm-twitter">' . __('Twitter URL', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-tm-twitter" name="sc-tm-twitter" type="text" data-attr-name="' . Inc_Social_Icons_Shortcode::$TWITTER_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-tm-facebook">' . __('Facebook URL', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-tm-facebook" name="sc-tm-facebook" type="text" data-attr-name="' . Inc_Social_Icons_Shortcode::$FACEBOOK_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-tm-gplus">' . __('Google+ URL', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-tm-gplus" name="sc-tm-gplus" type="text" data-attr-name="' . Inc_Social_Icons_Shortcode::$GPLUS_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-tm-linkedin">' . __('LinkedIn URL', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-tm-linkedin" name="sc-tm-linkedin" type="text" data-attr-name="' . Inc_Social_Icons_Shortcode::$LINKEDIN_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-tm-vimeo">' . __('Vimeo URL', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-tm-vimeo" name="sc-tm-vimeo" type="text" data-attr-name="' . Inc_Social_Icons_Shortcode::$VIMEO_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-tm-youtube">' . __('YouTube URL', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-tm-youtube" name="sc-tm-youtube" type="text" data-attr-name="' . Inc_Social_Icons_Shortcode::$YOUTUBE_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-tm-skype">' . __('Skype URL', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-tm-skype" name="sc-tm-skype" type="text" data-attr-name="' . Inc_Social_Icons_Shortcode::$SKYPE_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-tm-digg">' . __('Digg URL', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-tm-digg" name="sc-tm-digg" type="text" data-attr-name="' . Inc_Social_Icons_Shortcode::$DIGG_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-tm-delicious">' . __('Delicious URL', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-tm-delicious" name="sc-tm-delicious" type="text" data-attr-name="' . Inc_Social_Icons_Shortcode::$DELICIOUS_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-tm-tumbler">' . __('Tumbler URL', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-tm-tumbler" name="sc-tm-tumbler" type="text" data-attr-name="' . Inc_Social_Icons_Shortcode::$TUMBLR_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-tm-dribbble">' . __('Dribbble URL', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-tm-dribbble" name="sc-tm-dribbble" type="text" data-attr-name="' . Inc_Social_Icons_Shortcode::$DRIBBBLE_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-tm-stumbleupon">' . __('StumbleUpon URL', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-tm-stumbleupon" name="sc-tm-stumbleupon" type="text" data-attr-name="' . Inc_Social_Icons_Shortcode::$STUMBLEUPON_ATTR . '" data-attr-type="attr">';
        $content .= '</div>';
        $content .= '<div >';
        $content .= '<input id="sc-tm-form-submit" type="submit" name="submit" value="' . __('Insert Team Member', INCEPTIO_THEME_NAME) . '" class="button-primary">';
        $content .= '</div>';
        $content .= '</div>';

        $content .= '<div class="image-tab-content-right">';
        $content .= '<img id="sc-tm-src-preview" src="#" alt="">';
        $content .= '</div>';

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
        return __('Team Member', INCEPTIO_THEME_NAME);
    }
}