<?php if (inc_is_internationalization_enabled()) {
    $languages = array();
    $languages = apply_filters('inc_languages', $languages);
    if (count($languages) > 0) {
        $default_lang_flag = '';
        $default_lang_name = '';
        foreach ($languages as $lang) {
            if (empty($default_lang_flag)) {
                $default_lang_flag = Media_Util::get_external_image_src($lang['flag']);
                $default_lang_name = $lang['name'];
            }
            if ($lang['default'] == true) {
                $default_lang_flag = Media_Util::get_external_image_src($lang['flag']);
                $default_lang_name = $lang['name'];
            }
        }
        ?>
        <!-- begin language switcher -->
        <div id="inc-language-switcher" class="language-switcher" style="display: none; left: -195px;">
            <h4><?php _e('Change Language', INCEPTIO_THEME_NAME); ?> <a id="inc-language-switcher-thumb" href="#"><img src="<?php echo $default_lang_flag; ?>" alt="<?php echo $default_lang_name; ?>"></a></h4>

            <div class="language-options">
                <ul>
                    <?php
                    foreach ($languages as $lang) {
                        if ($lang['default'] != true) {
                            $lang_flag = Media_Util::get_external_image_src($lang['flag']);
                            $lang_name = $lang['name'];
                            $lang_url = $lang['url'];
                            echo '<li><a href="' . $lang_url . '"><img src="' . $lang_flag . '" alt="' . $lang_name . '">' . $lang_name . '</a></li>';
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
        <!-- end language switcher -->
<?php } } ?>
