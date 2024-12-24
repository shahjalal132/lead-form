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
    }

    public function lead_form_shortcode() {
        ob_start();

        // include lead form template
        include_once PLUGIN_BASE_PATH . '/templates/template-lead-form.php';

        return ob_get_clean();
    }

}