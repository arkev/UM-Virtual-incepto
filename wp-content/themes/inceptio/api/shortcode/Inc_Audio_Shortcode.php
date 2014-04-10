<?php

class Inc_Audio_Shortcode extends Abstract_Inc_Shortcode implements Inc_Shortcode_Designer
{
    static $SRC_ATTR = "src";
    static $MP3_ATTR = "mp3";
    static $M4A_ATTR = "m4a";
    static $WAV_ATTR = "wav";
    static $OGG_ATTR = "ogg";
    static $WMA_ATTR = "wma";
    static $LOOP_ATTR = "loop";
    static $AUTOPLAY_ATTR = "autoplay";
    static $PRELOAD_ATTR = "preload";

    function render($attr, $inner_content = null, $code = "")
    {
        $classes = array('entry-audio');
        $core_attributes = $this->get_core_attributes($attr, array('class' => $classes));
        return '<div' . $core_attributes . '>' . wp_audio_shortcode($attr) . '</div>';
    }

    function get_names()
    {
        return array('audio');
    }

    function get_visual_editor_form()
    {
        $content = '<form id="sc-audio-form" class="generic-form" method="post" action="#" data-sc="video">';
        $content .= '<fieldset>';
        $content .= '<div>';
        $content .= '<label for="sc-audio-align">' . __('Align', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="sc-audio-align" name="sc-audio-align">';
        $content .= '<option value="">' . __('None', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="left">' . __('Left', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="right">' . __('Right', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-audio-type">' . __('Source Type', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<select id="sc-audio-type" name="sc-audio-type">';
        $content .= '<option value="ss">' . __('Single Source', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="sf">' . __('Source with Fallbacks', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';

        $content .= '<div class="sc-audio-ss">';
        $content .= '<label for="sc-audio-src">' . __('Source URL', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-audio-src" name="sc-audio-src" type="text">';
        $content .= '</div>';

        $content .= '<div class="sc-audio-sf" style="display: none">';
        $content .= '<label for="sc-audio-mp3">' . __('MP3 URL', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-audio-mp3" name="sc-audio-mp3" type="text">';
        $content .= '</div>';
        $content .= '<div class="sc-audio-sf" style="display: none">';
        $content .= '<label for="sc-audio-mp4a">' . __('MP4A URL', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-audio-mp4a" name="sc-audio-mp4a" type="text">';
        $content .= '</div>';
        $content .= '<div class="sc-audio-sf" style="display: none">';
        $content .= '<label for="sc-audio-ogg">' . __('OGG URL', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-audio-ogg" name="sc-audio-ogg" type="text">';
        $content .= '</div>';
        $content .= '<div class="sc-audio-sf" style="display: none">';
        $content .= '<label for="sc-audio-wav">' . __('WAV URL', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-audio-wav" name="sc-audio-wav" type="text">';
        $content .= '</div>';
        $content .= '<div class="sc-audio-sf" style="display: none">';
        $content .= '<label for="sc-audio-wma">' . __('WMA URL', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input id="sc-audio-wma" name="sc-audio-wma" type="text">';
        $content .= '</div>';

        $content .= '<div>';
        $content .= '<input id="sc-audio-loop" name="sc-audio-loop" type="checkbox">';
        $content .= '<label for="sc-audio-loop">' . __('Loop', INCEPTIO_THEME_NAME) . '</label>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<input id="sc-audio-autop" name="sc-audio-autop" type="checkbox">';
        $content .= '<label for="sc-audio-autop">' . __('Auto-Play', INCEPTIO_THEME_NAME) . '</label>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="sc-audio-preload">' . __('Preload', INCEPTIO_THEME_NAME) . '</label>';
        $content .= '<select id="sc-audio-preload" name="sc-audio-preload">';
        $content .= '<option value="none">' . __('None', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="metadata">' . __('Metadata', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '<option value="auto">' . __('Auto', INCEPTIO_THEME_NAME) . '</option>';
        $content .= '</select>';
        $content .= '</div>';
        $content .= '<div >';
        $content .= '<input id="sc-audio-form-submit" type="submit" name="submit" value="' . __('Insert Audio', INCEPTIO_THEME_NAME) . '" class="button-primary">';
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
        return __('Audio', INCEPTIO_THEME_NAME);
    }
}