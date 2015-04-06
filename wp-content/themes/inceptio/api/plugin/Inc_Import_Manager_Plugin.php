<?php

class Inc_Import_Manager_Plugin extends Abstract_Plugin
{

    function register_actions()
    {
        add_action('wp_ajax_inc-import-demo', array($this, 'import_demo'));
    }

    protected function activate()
    {
    }

    function render()
    {
        echo '<div class="wrap">';
        echo '<div class="icon32" id="icon-themes"></div>';
        echo '<h2>Inceptio - ' . __('Import Demo', INCEPTIO_THEME_NAME) . '</h2>';

        echo '<div id="wait-message" class="updated below-h2" style="display: none"><p><strong>The demo import has started and will take a few moments. Please wait &hellip;</strong></p></div>';
        echo '<div id="success-message" class="updated below-h2" style="display: none"><p><strong>The data import has been successfully performed.</strong></p></div>';
        echo '<div id="error-message" class="error" style="display: none"><p><strong>Failed to import the demo. To see what were the problems activate the WordPress debug level.</strong></p></div>';
        echo '<div class="error"><p><strong>IMPORTANT!!!</strong></p>';
        echo '<p>This plugin allows you to import the demo of the Inceptio theme entirely (with all its settings).</p>';
        echo '<p>This import procedure will <strong>ERASE ALL DATA (pages, posts, comments, settings, users, etc.)</strong> from the database and insert new data.</p>';
        echo '<p>We strongly recommend you to <strong>RUN THIS IMPORT ON A NEW DATABASE WHICH HAS THE DEFAULT USER (Admin) CREATED BY WordPress</strong>.</p>';
        echo '<p>This plugin has been tested several times on our local environment (WordPress 3.8) and it works OK. We cannot guarantee that the import will work without problems in your case. This depends on your environment (database, WordPress version) settings.</p>';
        echo '<p><strong>DON\'T LAUNCH THIS IMPORT IF YOU ARE RUNNING AN WordPress VERSION OLDER THAN 3.8</strong></p>';
        echo '<p><strong>PLEASE NOTE THAT WE ARE NOT RESPONSIBLE FOR ANY DATA LOSS</strong>.</p>';
        echo '</div>';
        echo '<div>';
        echo '<form id="newsletter-send-form" method="post" action="admin-ajax.php">';
        echo wp_referer_field(false);
        echo $this->get_form();
        echo '<p class="submit"><input id="import-demo-submit" type="submit" value="' . __('Import Demo', INCEPTIO_THEME_NAME) . '" class="button-primary"></p>';
        echo '</form>';
        echo '</div>';
        echo '</div>';
    }

    private function get_form()
    {
        $content = '<table class="form-table"><tbody>';
        $content .= '<tr class="form-field form-required">';
        $content .= '<th scope="row"><label for="website-url"> ' . __('Site Address (URL)', INCEPTIO_THEME_NAME) . ' <span class="description">(required)</span></label></th>';
        $content .= '<td><input id="website-url" type="text" aria-required="true" value="' . get_home_url() . '" name="website-url" style="width: 25em"></td>';
        $content .= '</tr>';
        $content .= '<tr class="form-field form-required">';
        $content .= '<th scope="row"><label for="website-url"> ' . __('E-mail Address', INCEPTIO_THEME_NAME) . ' <span class="description">(required)</span></label></th>';
        $content .= '<td><input id="email-address" type="text" aria-required="true" value="" name="email-address" style="width: 25em"></td>';
        $content .= '</tr>';

        $content .= '</tbody></table>';

        $content .= '<input type="hidden" id="import-demo-action" name="action" value="inc-import-demo" >';
        $content .= '<input type="hidden" id="import-demo-nonce" name="nonce" value="' . wp_create_nonce('inc-import-demo') . '" />';
        return $content;
    }

    function get_title()
    {
        return __('Import Demo', INCEPTIO_THEME_NAME);
    }

    function get_slug()
    {
        return 'inc-import-demo-manager';
    }

    function import_demo()
    {
        $website_url = trim($_REQUEST['website-url']);
        $email_address = trim($_REQUEST['email-address']);
        $this->import_demo_data($website_url, $email_address);
    }

    function import_demo_data($website_url, $email_address)
    {
        try {
            global $wpdb;
            $table_prefix = $wpdb->prefix;

            if (empty($website_url)) {
                throw new Exception('The Website URL must not empty');
            }
            if (empty($email_address)) {
                throw new Exception('The Email Address must not empty');
            }
            $props = array(
                'table_prefix' => $table_prefix,
                'website_url' => $website_url,
                'email_address' => $email_address,
            );
            $this->start_import_demo($props);
            die();
        } catch (Exception $e) {
            header($_SERVER['SERVER_PROTOCOL'] . " 500 Internal Server Error");
            echo $e->getMessage();
            die();
        }
    }

    private function start_import_demo($props)
    {
        global $wp_version;
        if (version_compare($wp_version, '3.6', '>=')) {
            wp_enqueue_style('dialog-style', $template_url . '/admin/css/jquery.ui.dialog.css');

            require_once (get_template_directory() . '/api/plugin/demo/demo_data.php');
            global $wpdb;
            $wp_tables = array(
                'wp_comments' => $wp_comments,
                'wp_inceptio_fonts' => $wp_inceptio_fonts,
                'wp_options' => $wp_options,
                'wp_postmeta' => $wp_postmeta,
                'wp_posts' => $wp_posts,
                'wp_revslider_sliders' => $wp_revslider_sliders,
                'wp_revslider_slides' => $wp_revslider_slides,
//            'wp_links' => $wp_links,
                'wp_terms' => $wp_terms,
                'wp_term_relationships' => $wp_term_relationships,
                'wp_term_taxonomy' => $wp_term_taxonomy,
                'wp_usermeta' => $wp_usermeta,
                'wp_users' => $wp_users,
            );
            $ok = true;
            $has_admin = $this->has_admin_user();
            foreach ($wp_tables as $table => $rows) {
                $initial_table = $table;
                $table = str_replace('wp_', $props['table_prefix'], $table);

                if ($this->exists_table($table)) {
                    $this->clear_table_data($table);

                    foreach ($rows as $row) {
                        $column_values = array();
                        $column_formats = array();

                        foreach ($row as $column => $data) {
                            $column_values[$column] = $this->get_column_value($data, $props);
                            array_push($column_formats, $this->get_column_type($data));
                        }

                        $execute_sql = true;
                        if (strtolower($initial_table) == 'wp_users' || strtolower($initial_table) == 'wp_usermeta') {
                            if ($has_admin) {
                                $execute_sql = false;
                            } elseif ($column_values['ID'] == 1 || $column_values['user_id'] == 1) {
                                $execute_sql = true;
                            }
                        }

                        if ($execute_sql) {
                            $result = $wpdb->insert($table, $column_values, $column_formats);
                            if ($result === false) {
                                $ok = false;
                            }
                        }
                    }
                }
            }

            if ($ok === false) {
                throw new Exception("The import of the demo database encountered some problems. To see what were the problems activate the WordPress debug level.");
            }
        }else{
            throw new Exception("You must have installed at least the version 3.6 of WordPress.");
        }
    }

    private function clear_table_data($table_name)
    {
        global $wpdb;
        if (inc_end_with($table_name, '_users') || inc_end_with($table_name, '_usermeta')) {
            return;
        } else {
            $wpdb->query("DELETE FROM $table_name");
        }
    }

    private function has_admin_user()
    {
        global $wpdb;
        $user_count = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->users where ID=1");
        return $user_count > 0;
    }

    private function get_column_type($data)
    {
        if (is_numeric($data)) {
            if (intval($data) == floatval($data)) {
                return '%d';
            }
            return '%f';
        } else {
            return '%s';
        }
    }

    private function get_column_value($data, $props)
    {
        if (is_numeric($data)) {
            if (intval($data) == floatval($data)) {
                return intval($data);
            }
            return floatval($data);
        } else {
            foreach ($props as $key => $value) {
                if ($key === 'email_address') {
                    $data = str_replace('info@somesite.com', $value, $data);
                } elseif ($key === 'website_url') {
                    $value = str_replace('http://', '', $value);
                    $data = str_replace('somesite.com/demo', $value, $data);
                } elseif ($key === 'table_prefix') {
                    $data = str_replace('wp_capabilities', $value . 'capabilities', $data);
                    $data = str_replace('wp_user_level', $value . 'user_level', $data);
                    $data = str_replace('wp_dashboard_quick_press_last_post_id', $value . 'dashboard_quick_press_last_post_id', $data);
                    $data = str_replace('wp_user-settings', $value . 'user-settings', $data);
                    $data = str_replace('wp_user-settings-time', $value . 'user-settings-time', $data);
                    $data = str_replace('wp_user_roles', $value . 'user_roles', $data);
                }
            }
            return $data;
        }
    }

    private function exists_table($table_name)
    {
        global $wpdb;
        if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
            return false;
        } else {
            return true;
        }
    }
}