<?php

class Inc_Sidebar_Manager_Plugin extends Abstract_Plugin
{

    public function __construct()
    {
        parent::__construct();
    }

    function register_actions()
    {
        add_action('wp_ajax_sbm-add-form', array($this, 'render_add_sidebar_form'));
        add_action('wp_ajax_sbm-add', array($this, 'process_add_sidebar'));
        add_action('wp_ajax_sbm-remove', array($this, 'process_remove_sidebar'));
    }

    protected function activate()
    {
    }

    function render()
    {
        echo '<div class="wrap">';
        echo '<div class="icon32" id="icon-themes"></div>';
        echo '<h2>Inceptio - Sidebar Manager <a class="thickbox add-new-h2" href="admin-ajax.php?action=sbm-add-form" title="Add New Sidebar">Add New</a></h2>';
        echo '<div class="plugin-content">';
        echo '<div id="sidebar-list">';
        echo $this->get_sidebar_list();
        echo '</div>';
        echo '</div>';
        echo '</div>';
    }

    function get_title()
    {
        return __('Sidebars', INCEPTIO_THEME_NAME);
    }

    function get_slug()
    {
        return 'inc-sidebar-manager';
    }

    function render_add_sidebar_form()
    {
        $content = '<form id="sbm-add-form" class="generic-form" method="post" action="admin-ajax.php">';
        $content .= '<fieldset>';
        $content .= '<div>';
        $content .= '<label for="sidebar-name">' . __('Name', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<input type="text" id="name-id" name="name" class="required">';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<label for="description-id">' . __('Description', INCEPTIO_THEME_NAME) . ':</label>';
        $content .= '<textarea id="description-id" name="description" class="required"></textarea>';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<input type="hidden" name="action" value="sbm-add" >';
        $content .= '<input type="hidden" name="nonce" value="' . wp_create_nonce('sbm-add') . '" />';
        $content .= '</div>';
        $content .= '<div>';
        $content .= '<input type="submit" id="sbm-add-form-submit" value="' . __('Add Sidebar', INCEPTIO_THEME_NAME) . '" class="button-primary button-secondary">';
        $content .= '</div>';
        $content .= '</fieldset>';
        $content .= '</form>';
        echo $content;
        die();
    }

    function process_add_sidebar()
    {
        try {
            if (!isset($_POST['name']) || empty($_POST['name'])) {
                throw new Exception(__('The sidebar name not be empty!', INCEPTIO_THEME_NAME));
            }
            if (!isset($_POST['description']) || empty($_POST['description'])) {
                throw new Exception(__('The sidebar description not be empty!', INCEPTIO_THEME_NAME));
            }
            $sidebar_name = $_POST['name'];
            $sidebar_description = $_POST['description'];
            $sidebars = $this->get_all_sidebars();
            foreach ($sidebars as $sidebar) {
                if ($sidebar['name'] == $sidebar_name) {
                    throw new Exception(__('A sidebar with the same name already exists.', INCEPTIO_THEME_NAME));
                }
            }
            $sidebars[] = array(
                'id' => sanitize_title($sidebar_name),
                'name' => $sidebar_name,
                'description' => $sidebar_description);
            $this->save_sidebars($sidebars);
            echo $this->get_sidebar_list();
        } catch (Exception $e) {
            header($_SERVER['SERVER_PROTOCOL']." 500 Internal Server Error");
            echo $e->getMessage();
        }
        die();
    }

    function process_remove_sidebar()
    {
        try {
            if (!isset($_POST['name']) || empty($_POST['name'])) {
                throw new Exception("The sidebar name not be empty!");
            }
            $sidebar_name = $_POST['name'];
            $sidebars = $this->get_all_sidebars();
            foreach ($sidebars as $i => $sidebar) {
                if ($sidebar['name'] == $sidebar_name) {
                    unset($sidebars[$i]);
                }
            }
            $this->save_sidebars($sidebars);
            echo $this->get_sidebar_list();
        } catch (Exception $e) {
            header($_SERVER['SERVER_PROTOCOL']." 500 Internal Server Error");
            echo $e->getMessage();
        }
        die();
    }

    private function get_sidebar_list()
    {
        $content = '<table cellspacing="0" class="wp-list-table widefat fixed media">';
        $content .= '<thead>';
        $content .= '<tr>';
        $content .= '<th style="" class="manage-column column-response" scope="col"><span>ID</span></a></th>';
        $content .= '<th style="" class="manage-column column-response" scope="col"><span>Name</span></a></th>';
        $content .= '<th style="" class="manage-column column-title" scope="col"><span>Description</span></a></th>';
        $content .= '</tr>';
        $content .= '</thead>';

        $content .= '<tfoot>';
        $content .= '<tr>';
        $content .= '<th style="" class="manage-column column-response" scope="col"><span>ID</span></a></th>';
        $content .= '<th style="" class="manage-column column-response" scope="col"><span>Name</span></a></th>';
        $content .= '<th style="" class="manage-column column-title" scope="col"><span>Description</span></a></th>';
        $content .= '</tr>';
        $content .= '</tfoot>';
        $content .= '<tbody id="the-list">';
        $sidebars = $this->get_all_sidebars();
        foreach ($sidebars as $i => $sidebar) {
            $delete_url = 'action=sbm-remove&amp;name=' . $sidebar['name'];
            $alternate_class = ($i % 2 == 0) ? 'alternate' : '';
            $content .= "<tr valign=\"top\" class=\"$alternate_class author-self status-inherit\">";
            $content .= '<td class="title column-title"><strong>' . $sidebar['id'] . '</strong>';
            $content .= '<div class="row-actions"><span class="delete"><a class="sbm-delete" href="' . $delete_url . '">Delete</a></span></div>';
            $content .= '</td>';
            $content .= '<td class="title column-title"><strong>' . $sidebar['name'] . '</strong></td>';
            $content .= '<td class="title column-title"><strong>' . $sidebar['description'] . '</strong></td>';
        }
        $content .= '</tbody>';
        $content .= '</table>';
        return $content;
    }

    function get_all_sidebars(){
        $dynamic_sidebars = get_option(SETTINGS_THEME_SIDEBARS);
        if (!$dynamic_sidebars) {
            return array();
        } else {
            return $dynamic_sidebars;
        }
    }

    function save_sidebars($sidebars){
        update_option(SETTINGS_THEME_SIDEBARS, $sidebars);       
    }
}