<?php
/**
 * Plugin Name: Giact Capture Utm
 * Plugin URI: https://giact.com/
 * Description: This is a Custom WordPress Plugin that captures UTM parameters from URL. It is a helper to the demo page, the download now page
 * Version: 1.0.0
 * Author: Andrew Tilbury
 * Author URI: https://giact.com/
 * License: GPL2
 */

if (!class_exists('CaptureUTM')) {
    class CaptureUTM {
        public function __construct() {
            add_action('init', array($this, 'start_session'), 1);
            add_action('init', array($this, 'capture_utm'));
        }

        public function start_session() {
            if(!session_id()) {
                session_start();
            }
        }

        public function capture_utm() {
            $utm_parameters = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_term', 'utm_content', 'referred_By', 'elqCampaignId'];
            foreach($utm_parameters as $utm) {
                if($utm_value = filter_input(INPUT_GET, $utm, FILTER_SANITIZE_STRING)) { // sanitize
                    $_SESSION[$utm] = $utm_value;
                }
            }
        }
    }
}

// initialize the class
if (class_exists('CaptureUTM')) {
    $CaptureUTM = new CaptureUTM();
}

