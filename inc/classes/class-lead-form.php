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

        $data = sprintf("nonce: %s, phone_or_email: %s", $nonce, $phone_or_email);
        $this->put_program_logs( $data );

        global $wpdb;
        $table_name = $wpdb->prefix . 'sync_leads';

        // prepare sql statement
        $sql = $wpdb->prepare(
            "INSERT INTO $table_name (nonce, phone_or_email) VALUES (%s, %s)",
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

}