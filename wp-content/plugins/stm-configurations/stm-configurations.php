<?php
/*
Plugin Name: STM Configurations
Plugin URI: https://stylemixthemes.com/
Description: STM Configurations
Author: Stylemix Themes
Author URI: https://stylemixthemes.com/
Text Domain: stm-configurations
Version: 2.4.0
*/

$is_stm_theme = ! empty( get_option( 'stm_theme_version' ) );


define( 'STM_CONFIGURATIONS_PATH', dirname( __FILE__ ) );
define( 'STM_CONFIGURATIONS_URL', plugin_dir_url( __FILE__ ) );
define( 'STM_CONFIGURATIONS_THEME_VERSION', time() );

if ( ! is_textdomain_loaded( 'stm-configurations' ) ) {
	load_plugin_textdomain( 'stm-configurations', false, 'stm-configurations/languages' );
}

/*Custom icons*/
require_once STM_CONFIGURATIONS_PATH . '/iconloader/stm-custom-icons.php';

/*Post type*/
require_once STM_CONFIGURATIONS_PATH . '/post-type/stm-post-type.php';

/*Events*/
require_once STM_CONFIGURATIONS_PATH . '/events/events.php';

/*Helpers*/
require_once STM_CONFIGURATIONS_PATH . '/helpers/helpers.php';

/*Megamenu*/
require_once STM_CONFIGURATIONS_PATH . '/megamenu/main.php';

/*Megamenu*/
require_once STM_CONFIGURATIONS_PATH . '/ico_directory/index.php';

/*Theme functions*/
require_once STM_CONFIGURATIONS_PATH . '/crypterio/functions.php';

/* white list */
require_once STM_CONFIGURATIONS_PATH . '/white_list/white_list.php';
/* white list */
require_once STM_CONFIGURATIONS_PATH . '/announcement/main.php';

if ( is_admin() ) {

	/*Demo import*/
	require_once STM_CONFIGURATIONS_PATH . '/importer/importer.php';
}
add_shortcode(
	'copyright',
	function () {
		$copyright = get_theme_mod(
			'footer_copyright',
			wp_kses(
				__( "Copyright &copy; 2018 crypterio Theme by <a href='https://themeforest.net/item/crypterio-business-finance-wordpress-theme/14740561' target='_blank'>StylemixThemes</a>. All rights reserved", 'crypterio' ),
				array(
					'a' => array(
						'href'   => array(),
						'target' => array(),
					),
				)
			)
		);
		echo '<div class="stm-copyright">' . wp_kses_post( $copyright ) . '</div>';
	}
);
