<?php


class Inc_Video_Shortcode extends Abstract_Inc_Shortcode implements Inc_Shortcode_Designer
{
    static $ALIGN_ATTR = "align";
    static $SRC_ATTR = "src";
    static $MP4_ATTR = "mp4";
    static $M4V_ATTR = "m4v";
    static $WEBM_ATTR = "webm";
    static $OGV_ATTR = "ogv";
    static $WMV_ATTR = "wmv";
    static $FLV_ATTR = "flv";
    static $POSTER_ATTR = "poster";
    static $LOOP_ATTR = "loop";
    static $AUTOP_ATTR = "autoplay";
    static $PRELOAD_ATTR = "preload";
    static $HEIGHT_ATTR = "height";
    static $WIDTH_ATTR = "width";

    function render($attr, $inner_content = null, $code = "")
    {
        extract(shortcode_atts(array(Inc_Video_Shortcode::$ALIGN_ATTR => '',
            Inc_Video_Shortcode::$POSTER_ATTR => ''), $attr));
        $classes = array('entry-video');
        if ($align == 'right') {
            array_push($classes, 'alignright');
        } elseif ($align == 'left') {
            array_push($classes, 'alignleft');
        }
        if (isset($inner_content) && !empty($inner_content)) {
            $video_content = $inner_content;
        } else {
            if (!empty($poster)) {
                $poster = Media_Util::get_image_src($poster);
                $attr = array_merge($attr, array('poster' => $poster));
            }
            $video_content = wp_video_shortcode($attr);
        }

        $core_attributes = $this->get_core_attributes($attr, array('class' => $classes));

        return "<div" . $core_attributes . ">$video_content</div>";
    }

    function get_names()
    {
        return array('video');
    }

    function get_visual_editor_form()
    {
        $content = '<form id="sc-video-form" class="generic-form" method="post" action="#" data-sc="video">';
        $content .= '<fieldset>';
        $content .= '<div>';
        $content .= '<label for="sc-video-align">' . __('Align', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="sc-video-align" name="sc-video-align">';
        $content .= '<option value="">' . __('None', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="left">' . __('Left', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="right">' . __('Right', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';

        $content .= '<div>';
        $content .= '<label for="sc-video-type">' . __('Video Type', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="sc-video-type" name="sc-video-type">';
        $content .= '<option value="e">' . __('Embedded', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="ss">' . __('Single Source', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="sf">' . __('Source with Fallbacks', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';

        $content .= '<div class="sc-video-e">';
        $content .= '<label for="sc-video-content">' . __('Embedded Video', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<textarea id="sc-video-content" name="sc-video-content" class="required" data-attr-type="content"></textarea>';
        $content .= '</div>';

        $content .= '<div class="sc-video-ss" style="display: none">';
        $content .= '<label for="sc-video-src">' . __('Source URL', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-video-src" name="sc-video-src" type="text" class="required">';
        $content .= '</div>';

        $content .= '<div class="sc-video-sf" style="display: none">';
        $content .= '<label for="sc-video-mp4">' . __('MP4 URL', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-video-mp4" name="sc-video-mp4" type="text">';
        $content .= '</div>';
        $content .= '<div class="sc-video-sf" style="display: none">';
        $content .= '<label for="sc-video-m4v">' . __('M4V URL', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-video-m4v" name="sc-video-m4v" type="text">';
        $content .= '</div>';
        $content .= '<div class="sc-video-sf" style="display: none">';
        $content .= '<label for="sc-video-webm">' . __('WEBM URL', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-video-webm" name="sc-video-webm" type="text">';
        $content .= '</div>';
        $content .= '<div class="sc-video-sf" style="display: none">';
        $content .= '<label for="sc-video-ogv">' . __('OGV URL', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-video-ogv" name="sc-video-ogv" type="text">';
        $content .= '</div>';
        $content .= '<div class="sc-video-sf" style="display: none">';
        $content .= '<label for="sc-video-wmv">' . __('WMV URL', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-video-wmv" name="sc-video-wmv" type="text">';
        $content .= '</div>';
        $content .= '<div class="sc-video-sf" style="display: none">';
        $content .= '<label for="sc-video-flv">' . __('FLV URL', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-video-flv" name="sc-video-flv" type="text">';
        $content .= '</div>';

        $content .= '<div class="sc-video-sssf" style="display: none">';
        $content .= '<label for="sc-video-poster">' . __('Poster (image ID or image URL)', INCEPTIO_THEME_NAME) . '</label>';
        $content .= '<input id="sc-video-poster" name="sc-video-poster" type="text">';
        $content .= '</div>';
        $content .= '<div class="sc-video-sssf" style="display: none">';
        $content .= '<input id="sc-video-loop" name="sc-video-loop" type="checkbox">';
        $content .= '<label for="sc-video-loop">' . __('Loop', INCEPTIO_THEME_NAME) . '</label>';
        $content .= '</div>';
        $content .= '<div class="sc-video-sssf" style="display: none">';
        $content .= '<input id="sc-video-autop" name="sc-video-autop" type="checkbox">';
        $content .= '<label for="sc-video-autop">' . __('Auto-Play', INCEPTIO_THEME_NAME) . '</label>';
        $content .= '</div>';
        $content .= '<div class="sc-video-sssf" style="display: none">';
        $content .= '<label for="sc-video-preload">' . __('Preload', INCEPTIO_THEME_NAME) . '</label>';
        $content .= '<select id="sc-video-preload" name="sc-video-preload">';
        $content .= '<option value="none">' . __('None', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="metadata">' . __('Metadata', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="auto">' . __('Auto', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div class="sc-video-sssf" style="display: none">';
        $content .= '<label for="sc-video-width">' . __('Width', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-video-width" name="sc-video-width" type="text" value="640" class="required">';
        $content .= '</div>';
        $content .= '<div class="sc-video-sssf" style="display: none">';
        $content .= '<label for="sc-video-height">' . __('Height', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-video-height" name="sc-video-height" type="text" value="360" class="required">';
        $content .= '</div>';

        $content .= '<div >';
        $content .= '<input id="sc-video-form-submit" type="submit" name="submit" value="' . __('Insert Video', INCEPTIO_THEME_NAME) . '" class="button-primary">';
        $content .= '</div>';
        $content .= '</fieldset>';
        $content .= '</form>';
        return $content;
    }

    function get_group_title()
    {
        return __('Media', INCEPTIO_THEME_NAME);
    }

    function get_title()
    {
        return __('Video', INCEPTIO_THEME_NAME);
    }
}