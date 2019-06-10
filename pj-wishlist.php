<?php
/*
    Plugin Name: PJ WishList
    Plugin URI: https://github.com/ProfJava/pj-wish-list
    Description: WishList Plugin.
    Version: 0.1
    Author: Prof
    Author URI: https://github.com/ProfJava
    License: GPL2 or later
    Text Domain: pjwl
*/

if( ! defined('ABSPATH')) {
    die;
}

//Plugin Version
if ( ! defined( 'PJWL_VERSION' ) ) {
    define( 'PJWL_VERSION', 0.1 );
}

/* Include Files */
include plugin_dir_path( __FILE__ ) . 'assets.php';
include plugin_dir_path( __FILE__ ) . 'hooks.php';
include plugin_dir_path( __FILE__ ) . 'admin.php';


/* Add Settings Link */
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'pjwl_add_settings_links' );
function pjwl_add_settings_links ( $links ) {
    $pjwl_links = array(
        '<a href="admin.php?page=pj_wish_list">Settings</a>',
    );
    return array_merge( $links, $pjwl_links );
}

/* Settings Page */
add_action( 'admin_menu', 'pjwl_add_admin_pages' );
function pjwl_add_admin_pages() {
    add_menu_page( 'PJ WishList','PJ WishList','manage_options','pj_wish_list', 'pjwl_settings_page' , 'dashicons-store', 110 );
}

function pjwl_settings_page() {
    // Require Template
    require_once plugin_dir_path(__FILE__) . 'template/pjwl-settings.php';
}