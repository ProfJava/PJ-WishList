<?php
if (!defined('ABSPATH')) {
    die;
}

// Plugin Assets Url
define( 'PJWL_ASSETS', plugin_dir_url( __FILE__ ) . 'assets/front-end/' );
define( 'PJWL_ADMIN_ASSETS', plugin_dir_url( __FILE__ ) . 'assets/admin/' );
//define( 'PJWL_CORE_DIR', plugin_dir_path( __FILE__ ) . 'template' . DIRECTORY_SEPARATOR );


add_action( 'wp_enqueue_scripts', 'pjwl_frontend_scripts' );
function pjwl_frontend_scripts() {
    //Load css files
    wp_enqueue_style( 'pjwl-frontend-style', PJWL_ASSETS . 'css/style.css', false, PJWL_VERSION );
    wp_enqueue_style( 'pjwl-icons-style', PJWL_ASSETS . 'css/pjwl.css', false, PJWL_VERSION );

    //Load JS Files
    wp_enqueue_script( 'pjwl-frontend-script', PJWL_ASSETS . 'js/main.js', array( 'jquery' ), PJWL_VERSION, true );

    wp_enqueue_style( 'toast_style', '//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css' );
    wp_enqueue_script( 'toast_message', '//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js', array( 'jquery' ), false, false );

    wp_localize_script( 'pjwl-frontend-script', 'pjwl_ajax_object', [
            'ajax_url'    => admin_url( 'admin-ajax.php' ),
            'ajax_nonce'  => wp_create_nonce( 'pjwl_ajax_requests' ),
            'login_state' => is_user_logged_in() ? true : false,
        ]
    );
}

add_action('admin_enqueue_scripts','pjwl_admin_scripts');
function pjwl_admin_scripts() {
    // Style Css
    wp_enqueue_style( 'pjwl-admin-style', PJWL_ADMIN_ASSETS . 'css/style.css', false, PJWL_VERSION );
    wp_enqueue_style( 'pjwl-icons-style', PJWL_ASSETS . 'css/pjwl.css', false, PJWL_VERSION );
    // Main JS
    wp_enqueue_script( 'pjwl-admin-script', PJWL_ADMIN_ASSETS . 'js/main.js', array( 'jquery' ), PJWL_VERSION, true );
}