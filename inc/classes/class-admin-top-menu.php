<?php

namespace BOILERPLATE\Inc;

use BOILERPLATE\Inc\Traits\Program_Logs;
use BOILERPLATE\Inc\Traits\Singleton;

class Admin_Top_Menu {

    use Singleton;
    use Program_Logs;

    public function __construct() {
        $this->setup_hooks();
    }

    public function setup_hooks() {
        add_action( 'admin_menu', [ $this, 'register_admin_top_menu' ] );
        add_filter( 'plugin_action_links_' . PLUGIN_BASE_NAME, [ $this, 'add_plugin_action_links' ] );
    }

    function add_plugin_action_links( $links ) {
        $settings_link = '<a href="admin.php?page=leads">' . __( 'Settings', 'lead-form' ) . '</a>';
        array_unshift( $links, $settings_link );
        return $links;
    }

    public function register_admin_top_menu() {
        add_menu_page(
            'Leads',
            'Leads',
            'manage_options',
            'leads',
            [ $this, 'menu_callback_html' ],
            'dashicons-database-view',
            35
        );
    }

    public function menu_callback_html() {
        include_once PLUGIN_BASE_PATH . '/templates/template-admin-top-menu.php';
    }

}