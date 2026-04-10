<?php
/*
Plugin Name: WPStar - White Label WordPress Admin Theme
Plugin URI: http://codecanyon.net/user/themepassion/portfolio
Description: Advanced Admin Theme with White Label Branding for WordPress.
Author: themepassion
Version: 1.3
Text Domain: wpstr-framework
Author URI: http://codecanyon.net/user/themepassion/portfolio
*/

/* --------------- Load Redux Vendor Support ---------------- */
require_once( trailingslashit(dirname( __FILE__ )) . 'redux-vendor-support.php' );

/* --------------- Load Custom functions ---------------- */
require_once( trailingslashit(dirname( __FILE__ )) . 'lib/wpstr-functions.php' );

/* --------------- Wpstr CSS based on WP Version ---------------- */
require_once( trailingslashit(dirname( __FILE__ )) . 'lib/wpstr-css-version.php' );

/* --------------- Custom colors ---------------- */
require_once( trailingslashit(dirname( __FILE__ )) . 'lib/wpstr-custom-colors.php' );

/* --------------- Color Library ---------------- */
require_once( trailingslashit(dirname( __FILE__ )) . 'lib/wpstr-color-lib.php' );

/* --------------- Wpstr Fonts ---------------- */
require_once( trailingslashit(dirname( __FILE__ )) . 'lib/wpstr-fonts.php' );

/* --------------- CSS Library ---------------- */
require_once( trailingslashit(dirname( __FILE__ )) . 'lib/wpstr-css-lib.php' );

/* --------------- Logo and Favicon Settings ---------------- */
require_once( trailingslashit(dirname( __FILE__ )) . 'lib/wpstr-logo.php' );

/* --------------- Login  ---------------- */
require_once( trailingslashit(dirname( __FILE__ )) . 'lib/wpstr-login.php' );

/* --------------- Top Bar ---------------- */
require_once( trailingslashit(dirname( __FILE__ )) . 'lib/wpstr-topbar.php' );

/* --------------- Page Loader ---------------- */
require_once( trailingslashit(dirname( __FILE__ )) . 'lib/wpstr-pageloader.php' );

/* --------------- Admin Settings ---------------- */
require_once( trailingslashit(dirname( __FILE__ )) . 'lib/wpstr-settings.php' );

/* --------------- Visitor Stats ---------------- */
// Disabled - In case of ajax call disable visitor script
//if (defined('DOING_AJAX') && DOING_AJAX) { //} else {
require_once( trailingslashit(dirname( __FILE__ )) . 'visitor-stats/index.php' );
//}
/* --------------- Site Stats ---------------- */
require_once( trailingslashit(dirname( __FILE__ )) . 'site-stats/index.php' );

/* --------------- Menu User Info ---------------- */
require_once( trailingslashit(dirname( __FILE__ )) . 'menu-userinfo/index.php' );

/* --------------- Floating Menu ---------------- */
require_once( trailingslashit(dirname( __FILE__ )) . 'floating-menu/index.php' );

/* --------------- Load  framework ---------------- */

function wpstr_load_framework(){
    

	if ( !class_exists( 'RedukFramework' ) && file_exists( dirname( __FILE__ ) . '/framework/core/framework.php' ) ) {
	    require_once( dirname( __FILE__ ) . '/framework/core/framework.php' );
	}
	if (!isset( $wpstr_demo ) && file_exists( dirname( __FILE__ ) . '/framework/options/wpstr-config.php')) {
	    require_once( dirname( __FILE__ ) . '/framework/options/wpstr-config.php' );
	}
}

add_action('plugins_loaded', 'wpstr_load_framework', 11);
//wpstr_load_framework();


/* ---------------- Dynamic CSS - after plugins loaded ------------------ */
add_action('plugins_loaded', 'wpstr_core', 12);
add_action('admin_menu', 'wpstr_panel_settings', 12);


/* ---------------- On Options saved hook ------------------ */
add_action ('reduk/options/wpstr_demo/saved', 'wpstr_framework_settings_saved');

/* ------------------------------------------------
Regenerate All Color Files again - 
------------------------------------------------- */
$wpstr_regenerate_css = false;
if($wpstr_regenerate_css){
  add_action('plugins_loaded', 'wpstr_regenerate_all_dynamic_css_file', 12);
}


/* ------------------------------------------------
Load Settings Panel only if demo_settings is present.
------------------------------------------------- */

$wpstr_demo_settings = false;
if($wpstr_demo_settings){
  add_action('admin_footer', 'wpstr_admin_footer_function');
}

/* ------------------------------------------------
Regenerate All Inbuilt Theme import Files - 
------------------------------------------------- */

$wpstr_generate_import = false;
if($wpstr_generate_import){
  add_action('plugins_loaded', 'wpstr_generate_inbuilt_theme_import_file', 12);
}

/* --------------- Registration Hook Library---------------- */
require_once( trailingslashit(dirname(__FILE__)) . 'lib/wpstr-register-hook.php' );
register_activation_hook(__FILE__, 'wpstr_admin_activation');
register_deactivation_hook(__FILE__, 'wpstr_admin_deactivation');



?>