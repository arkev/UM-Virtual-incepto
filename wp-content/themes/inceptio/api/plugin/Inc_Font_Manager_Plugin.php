<?php

class Inc_Font_Manager_Plugin extends Abstract_Plugin
{

    public function __construct()
    {
        parent::__construct();
    }

    function register_actions()
    {
        add_action('wp_ajax_font-manager-form', array($this, 'render_add_form'));
        add_action('wp_ajax_font-manager-add', array($this, 'process_add_font'));
        add_action('wp_ajax_font-manager-remove', array($this, 'process_remove_font'));
    }

    function render_add_form()
    {
        $content = '<form id="font-manager-form" class="generic-form" method="post" action="admin-ajax.php">';
        $content .= '<fieldset>';
        $content .= '<div>';
        $content .= '<label for="font-url-id">' . __('Google Font URL or the Font-Family name', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input type="text" id="font-url-id" name="font-url" class="required">';
        $content .= '</div>';
        $content .= '<p> ' . __('An example of URL font is', INCEPTIO_THEME_NAME) . ': <em>http://fonts.googleapis.com/css?family=Dosis:400,200,300,500,600,700,800</em>';
        $content .= '<br> ' . __('The google fonts can be selected from here', INCEPTIO_THEME_NAME) . ': <a href="http://www.google.com/webfonts" target="_blank">http://www.google.com/webfonts</a> </p>';
        $content .= '<p> ' . __('An example of Font-Family can be: "Times New Roman" or "Georgia"', INCEPTIO_THEME_NAME) . '</p>';
        $content .= '<div>';
        $content .= '<input type="hidden" name="action" value="font-manager-add" />';
        $content .= '<input type="hidden" name="nonce" value="' . wp_create_nonce('font-manager-add') . '" />';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<input id="font-manager-form-submit" type="submit" value="' . __('Add Font', INCEPTIO_THEME_NAME) . '" class="button-primary button-secondary">';
        $content .= '</div>';
        $content .= '</fieldset>';
        $content .= '</form>';
        echo $content;
        die();
    }

    function process_add_font()
    {
        try {
            if (!isset($_POST['font-url']) || empty($_POST['font-url'])) {
                throw new Exception(__('The font URL must not be empty!', INCEPTIO_THEME_NAME));
            }
            $font_url = trim($_POST['font-url']);
            $font_name = $this->get_font_name($font_url);
            if ($font_name == 'Open Sans' || $font_name == 'Nunito') {
                throw new Exception(__('This font already exists as a default one.', INCEPTIO_THEME_NAME));
            }
            $existing_font_url = $this->get_font_url_by_name($font_name);
            if (isset($existing_font_url) && strlen($existing_font_url) > 0) {
                throw new Exception(__('This font already exists.', INCEPTIO_THEME_NAME));
            }
            $table_name = $this->get_table_name();
            global $wpdb;
            $wpdb->query($wpdb->prepare("insert into $table_name (font_name, font_url) values(%s, %s)", array($font_name, $font_url)));
            echo $this->get_font_list();
        } catch (Exception $e) {
            header($_SERVER['SERVER_PROTOCOL'] . " 500 Internal Server Error");
            echo $e->getMessage();
        }
        die();
    }

    function process_remove_font()
    {
        try {
            if (!isset($_POST['id']) || empty($_POST['id'])) {
                throw new Exception(__('The font id must not be empty!', INCEPTIO_THEME_NAME));
            }
            global $wpdb;
            $font_id = $_POST['id'];
            $table_name = $this->get_table_name();
            $wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE id = %d", $font_id));
            echo $this->get_font_list();
        } catch (Exception $e) {
            header($_SERVER['SERVER_PROTOCOL'] . " 500 Internal Server Error");
            echo $e->getMessage();
        }
        die();
    }

    private function get_table_name()
    {
        global $wpdb;
        return $table_name = $wpdb->base_prefix . "inceptio_fonts";
    }

    protected function activate()
    {
        global $wpdb;
        $table_name = $this->get_table_name();
        $wpdb->query("CREATE TABLE if not exists $table_name (
          id int(6) NOT NULL PRIMARY KEY AUTO_INCREMENT,
          font_name varchar(128) NOT NULL,
          font_url TEXT NOT NULL,
          UNIQUE (font_name)
        ) DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;");
    }

    function render()
    {
        echo '<div class="wrap">';
        echo '<div class="icon32" id="icon-themes"></div>';
        echo '<h2>Inceptio - ' . __('Font Manager', INCEPTIO_THEME_NAME) . ' <a class="thickbox add-new-h2" href="admin-ajax.php?action=font-manager-form" title="' . __('Add New Font', INCEPTIO_THEME_NAME) . '">' . __('Add New', INCEPTIO_THEME_NAME) . '</a></h2>';
        echo '<div class="plugin-content">';
        echo '<div id="font-list">';
        echo $this->get_font_list();
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }

    private function get_font_list()
    {
        $content = '';
        $content .= '<table cellspacing="0" class="wp-list-table widefat fixed media">';
        $content .= '<thead>';
        $content .= '<tr>';
        $content .= '<th style="" class="manage-column column-date" scope="col"><span>' . __('ID', INCEPTIO_THEME_NAME) . '</span></a></th>';
        $content .= '<th style="" class="manage-column column-date" scope="col"><span>' . __('Font Name', INCEPTIO_THEME_NAME) . '</span></a></th>';
        $content .= '<th style="" class="manage-column column-comment" scope="col"><span>' . __('Font URL', INCEPTIO_THEME_NAME) . '</span></a></th>';
        $content .= '<th style="" class="manage-column column-comment" scope="col"><span>' . __('Preview', INCEPTIO_THEME_NAME) . '</span></a></th>';
        $content .= '</tr>';
        $content .= '</thead>';

        $content .= '<tfoot>';
        $content .= '<tr>';
        $content .= '<th style="" class="manage-column column-date" scope="col"><span>' . __('ID', INCEPTIO_THEME_NAME) . '</span></a></th>';
        $content .= '<th style="" class="manage-column column-date" scope="col"><span>' . __('Font Name', INCEPTIO_THEME_NAME) . '</span></a></th>';
        $content .= '<th style="" class="manage-column column-comment" scope="col"><span>' . __('Font URL', INCEPTIO_THEME_NAME) . '</span></a></th>';
        $content .= '<th style="" class="manage-column column-comment" scope="col"><span>' . __('Preview', INCEPTIO_THEME_NAME) . '</span></a></th>';
        $content .= '</tr>';
        $content .= '</tfoot>';
        $content .= '<tbody id="the-list">';

        $fonts = $this->get_all_fonts();
        foreach ($fonts as $i => $font) {
            $delete_url = 'action=font-manager-remove&amp;id=' . $font->id;
            $alternate_class = ($i % 2 == 0) ? 'alternate' : '';
            $content .= "<tr valign=\"top\" class=\"$alternate_class author-self status-inherit\">";
            $content .= '<td class="title column-title"><strong>' . $font->id . '</strong>';
            $content .= '<div class="row-actions"><span class="delete">';
            $content .= '<a class="font-manager-delete" href="' . $delete_url . '">Delete</a>';
            $content .= '</span></div>';
            $content .= '</td>';
            $content .= '<td class="title column-title"><strong>' . $font->font_name . '</strong></td>';
            $content .= '<td class="title column-title"><strong>' . $font->font_url . '</strong></td>';
            $content .= '<td class="title column-title"><span class="' . str_replace(' ', '-', $font->font_name) . '-normal-400" >' . $font->font_name . '</strong></td>';
        }

        $content .= '</tbody>';
        $content .= '</table>';
        return $content;
    }

    function get_title()
    {
        return __('Theme Fonts', INCEPTIO_THEME_NAME);
    }

    function get_slug()
    {
        return 'inc-font-manager';
    }

    function get_all_fonts()
    {
        global $wpdb;
        $table_name = $this->get_table_name();
        return $wpdb->get_results("SELECT * FROM $table_name");
    }

    function get_all_fonts_name()
    {
        global $wpdb;
        $table_name = $this->get_table_name();
        $rows = $wpdb->get_results("SELECT font_name FROM $table_name");
        $fonts_name = array();
        foreach ($rows as $row) {
            array_push($fonts_name, $row->font_name);
        }
        return $fonts_name;
    }

    function get_font_url_by_name($font_name)
    {
        global $wpdb;
        $table_name = $this->get_table_name();
        return $wpdb->get_var($wpdb->prepare("select font_url from $table_name where upper(font_name)=upper(%s)", $font_name));
    }

    function get_font_name($font_url)
    {
        if (inc_start_with($font_url, 'http://fonts.googleapis.com/css?family=') ||
            inc_start_with($font_url, 'https://fonts.googleapis.com/css?family=')) {
            $pos1 = stripos($font_url, '=');
            $font_name = substr($font_url, $pos1 + 1);
            $pos2 = stripos($font_name, ':');
            if ($pos2 === false) {
                $pos2 = stripos($font_name, '&');
            }
            if ($pos2 !== false) {
                $font_name = substr($font_name, 0, $pos2);
            }
            $font_name = str_replace('+', ' ', $font_name);

            return $font_name;
        } else {
            return $font_url;
        }
    }

}