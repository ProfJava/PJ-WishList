<?php
if (!defined('ABSPATH')) {
    die;
}

/* WisList Settings Page */
add_action('admin_post_pjwl_settings_process','pjwl_settings');
function pjwl_settings() {
    if(isset($_POST['wp_nonce_check'])){
        if ( ! wp_verify_nonce( $_POST['wp_nonce_check'], 'pjwl_settings' ) ) {
            return;
        }

        update_option('pjwl-icon',sanitize_text_field($_POST['pjwl-icon']));    // Button Icon
        update_option('pjwl-text',sanitize_text_field($_POST['pjwl-text']));    // Button Text
        update_option('pjwl-pp',sanitize_text_field($_POST['pjwl-pp']));        // Show or Hide Product Page
        update_option('pjwl-cp',sanitize_text_field($_POST['pjwl-cp']));        // Show or Hide Card Product
        update_option('pjwl-popup',sanitize_text_field($_POST['pjwl-popup']));  // Show or Hide Popup
        update_option('pjwl-pst',sanitize_text_field($_POST['pjwl-pst']));      // Popup Success Title
        update_option('pjwl-psm',sanitize_text_field($_POST['pjwl-psm']));      // Popup Success Message
        update_option('pjwl-pet',sanitize_text_field($_POST['pjwl-pet']));      // Popup Error Title
        update_option('pjwl-pem',sanitize_text_field($_POST['pjwl-pem']));      // Popup Error Message

        wp_safe_redirect( admin_url( '/admin.php?page=pj_wish_list' ) );
        exit;

    }
}