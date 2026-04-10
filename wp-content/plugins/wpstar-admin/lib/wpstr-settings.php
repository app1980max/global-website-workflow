<?php


/* --------------- Admin Settings ---------------- */
require_once(trailingslashit(dirname(__FILE__)) . 'wpstr-menu-settings.php');


function wpstr_panel_settings()
{
	global $wpstradmin;
	//print_r($wpstradmin);

	wpstr_add_option("wpstradmin_plugin_access", "manage_options");
	wpstr_add_option("wpstradmin_plugin_page", "show");
	wpstr_add_option("wpstradmin_plugin_userid", "");
	wpstr_add_option("wpstradmin_menumng_page", "enable");
	wpstr_add_option("wpstradmin_admin_menumng_page", "enable");
	wpstr_add_option("wpstradmin_admintheme_page", "enable");
	wpstr_add_option("wpstradmin_logintheme_page", "enable");
	wpstr_add_option("wpstradmin_master_theme", "0");

	$get_menumng_page = wpstr_get_option("wpstradmin_menumng_page", "enable");
	$get_admin_menumng_page = wpstr_get_option("wpstradmin_admin_menumng_page", "enable");
	$get_admintheme_page = wpstr_get_option("wpstradmin_admintheme_page", "enable");
	$get_logintheme_page = wpstr_get_option("wpstradmin_logintheme_page", "enable");
	$get_mastertheme_page = wpstr_get_option("wpstradmin_master_theme", "0");


	// manageoptions and super admin

	$wpstradmin_permissions = 'manage_options';

	// $wpstradmin_permissions = wpstr_get_option( "wpstradmin_plugin_access","manage_options");
	// if($wpstradmin_permissions == "super_admin" && is_super_admin()){
	//     $wpstradmin_permissions = 'manage_options';
	// }

	// // specific user
	// $wpstradmin_userid = wpstr_get_option( "wpstradmin_plugin_userid","");
	// if($wpstradmin_permissions == "specific_user" && $wpstradmin_userid == get_current_user_id()){
	//     $wpstradmin_permissions = 'read';
	// }

	$showtabs = true;
	if (is_multisite() && wpstr_network_active()) {
		if (!is_main_site()) {
			$showtabs = false;
		}
	}

	if ($showtabs) {
		add_menu_page('WPStar Admin Addon', __('WPStar Admin Addon', 'wpstr_framework'), $wpstradmin_permissions, 'wpstr_permission_settings', 'wpstr_permission_settings_page');
		add_submenu_page('wpstr_permission_settings', 'Plugin Settings', __('Plugin Settings', 'wpstr_framework'), $wpstradmin_permissions, 'wpstr_permission_settings', 'wpstr_permission_settings_page');
		if ($get_menumng_page != "disable") {
			add_submenu_page('wpstr_permission_settings', 'Menu Management', __('Menu Management', 'wpstr_framework'), $wpstradmin_permissions, 'wpstr_menumng_settings', 'wpstr_menumng_settings_page');
		}
	}
}



function wpstr_permission_settings_page()
{

	if (isset($_POST['action']) && $_POST['action'] == 'wpstr_save_settings') {
		wpstr_save_permission_settings();
	}

	$currentUser = wp_get_current_user();
	$isMultisite = is_multisite();
	$isSuperAdmin = is_super_admin();

	$get_plugin_access = wpstr_get_option("wpstradmin_plugin_access", "manage_options");
	$get_plugin_page = wpstr_get_option("wpstradmin_plugin_page", "show");

	$get_menumng_page = wpstr_get_option("wpstradmin_menumng_page", "enable");
	$get_admin_menumng_page = wpstr_get_option("wpstradmin_admin_menumng_page", "enable");

	$get_admintheme_page = wpstr_get_option("wpstradmin_admintheme_page", "enable");
	$get_logintheme_page = wpstr_get_option("wpstradmin_logintheme_page", "enable");
	$get_mastertheme_page = wpstr_get_option("wpstradmin_master_theme", "0");


	global $wpstradmin;
	//echo $wpstradmin['dynamic-css-type'];
	//echo "jhi";
	global $wpdb;
	global $blog_id;

	//echo "<pre>"; print_r($wpstradmin); echo "</pre>";
?>

	<div class="wrap">

		<h1>WPStar Settings</h1>

		<?php

		$wpstr_plugin_settings = true;
		if (wpstr_network_active() && $blog_id != 1) {
			$wpstr_plugin_settings = false;
		}
		?>
		<?php if ($wpstr_plugin_settings) {


			// global $menu;
			// echo "<pre>"; print_r($menu); echo "</pre>";

		?>
			<form method="post" action="<?php echo esc_url(add_query_arg(array())); ?>" id="wpstradmin_settings_form">
				<table class="form-table">
					<tbody>

						<tr>
							<th scope="row">
								<?php _e('Disable Menu Management Addon', 'wpstr_framework'); ?>
							</th>
							<td>
								<p>
									<label>
										<input type="checkbox" name="wpstr_disable_menumng" value="1" <?php checked($get_menumng_page == "disable"); ?> <?php disabled($isMultisite && !is_super_admin()); ?>>
										<?php _e('DISABLE WPStar Admin MENU MANAGEMENT Addon.', 'wpstr_framework'); ?>
										<br><span class="description">
											<?php _e('Generally disabled when managed by some other plugins', 'wpstr_framework'); ?>
										</span>
									</label>
								</p>
							</td>
						</tr>

						<tr>
							<th scope="row">
								<?php _e('User Role based Menu Management', 'wpstr_framework'); ?>
							</th>
							<td>
								<p>
									<label>
										<input type="checkbox" name="wpstr_disable_admin_menumng" value="1" <?php checked($get_admin_menumng_page == "disable"); ?> <?php disabled($isMultisite && !is_super_admin()); ?>>
										<?php _e('Check to show Original Admin menu to administrator', 'wpstr_framework'); ?>
										<br><span class="description">
											<?php _e('Means the edited menu will be shown to all users except administrator', 'wpstr_framework'); ?>
										</span>
									</label>
								</p>
							</td>
						</tr>

						<tr>
							<th scope="row">
								<?php _e('Disable WPStar Theme on Admin Pages', 'wpstr_framework'); ?>
							</th>
							<td>
								<p>
									<label>
										<input type="checkbox" name="wpstr_disable_admintheme" value="1" <?php checked($get_admintheme_page == "disable"); ?> <?php disabled($isMultisite && !is_super_admin()); ?>>
										<?php _e('Check to DISABLE WPStar Admin Theme.', 'wpstr_framework'); ?>
									</label>
								</p>
							</td>
						</tr>


						<tr>
							<th scope="row">
								<?php _e('Disable WPStar Theme on Login Page', 'wpstr_framework'); ?>
							</th>
							<td>
								<p>
									<label>
										<input type="checkbox" name="wpstr_disable_logintheme" value="1" <?php checked($get_logintheme_page == "disable"); ?> <?php disabled($isMultisite && !is_super_admin()); ?>>
										<?php _e('Check to DISABLE WPStar Admin Theme on LOGIN PAGE.', 'wpstr_framework'); ?>
									</label>
								</p>
							</td>
						</tr>

					</tbody>
				</table>
				<input type="hidden" name="plugin_userid" value="<?php echo get_current_user_id(); ?>">
				<input type="hidden" name="action" value="wpstr_save_settings">
				<?php
				wp_nonce_field('save_settings');
				submit_button();
				?>
			</form>
		<?php } ?>

	</div>


<?php



}



function wpstr_save_permission_settings()
{

	if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'save_settings')) {
		die('Save Permissions check failed.');
	}

	global $wpdb;

	$plugin_access = "manage_options";
	//echo "<br><br><br><br><pre>"; print_r($_POST); echo "</pre>";
	//die();
	if ($_POST['action'] == 'wpstr_save_settings') {

		// plugin access
		$plugin_access = $_POST['plugin_access'];
		wpstr_update_option("wpstradmin_plugin_access", $plugin_access);

		// show on plugin page
		$plugin_page = "show";
		if (isset($_POST['hide_plugin_from_others'])) {
			$plugin_page = "hide";
		}
		wpstr_update_option("wpstradmin_plugin_page", $plugin_page);

		// user specific
		$onlyuser = "";
		if ($plugin_access == "specific_user") {
			$onlyuser = $_POST['plugin_userid'];
		}
		wpstr_update_option("wpstradmin_plugin_userid", $onlyuser);


		// show on menu mngmnt page
		$menumng_page = "enable";
		if (isset($_POST['wpstr_disable_menumng'])) {
			$menumng_page = "disable";
		}
		wpstr_update_option("wpstradmin_menumng_page", $menumng_page);

		// show on menu mngmnt page for admin users
		$admin_menumng_page = "enable";
		if (isset($_POST['wpstr_disable_admin_menumng'])) {
			$admin_menumng_page = "disable";
		}
		wpstr_update_option("wpstradmin_admin_menumng_page", $admin_menumng_page);

		// show on admin theme
		$admintheme_page = "enable";
		if (isset($_POST['wpstr_disable_admintheme'])) {
			$admintheme_page = "disable";
		}
		wpstr_update_option("wpstradmin_admintheme_page", $admintheme_page);


		// show on login theme
		$logintheme_page = "enable";
		if (isset($_POST['wpstr_disable_logintheme'])) {
			$logintheme_page = "disable";
		}
		wpstr_update_option("wpstradmin_logintheme_page", $logintheme_page);


		//wpstr_multisite_allsites();
		//die();

		/*Update multisite in one click settings*/
		$master_theme = 0;
		$master_options = "";
		if (isset($_POST['wpstr_multisite_options']) && $_POST['wpstr_multisite_options'] != "0" && is_numeric($_POST['wpstr_multisite_options'])) {
			$master_theme = $_POST['wpstr_multisite_options'];
			update_option("wpstradmin_master_theme", $master_theme);

			if ($master_theme != "0") {
				$master_options = get_blog_option($master_theme, 'wpstr_demo');

				$blogarr = wpstr_multisite_allsites();
				foreach ($blogarr as $blogid => $blogname) {
					update_blog_option($blogid, 'wpstr_demo', $master_options);
				}
			}
		}
	}
}



add_filter('all_plugins', 'wpstr_filter_plugin_list');

function wpstr_filter_plugin_list()
{

	if (!function_exists('get_plugins')) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}

	$plugins = get_plugins();

	//print_r($plugins);

	$currentUser = wp_get_current_user();
	$uaccess = wpstr_get_option("wpstradmin_plugin_access", "manage_options");
	$upage = wpstr_get_option("wpstradmin_plugin_page", "show");
	$uid = wpstr_get_option("wpstradmin_plugin_userid", "");

	if ($upage == "hide") {

		if ($uaccess == "super_admin" && !is_super_admin()) {
			unset($plugins['wpstar-admin/wpstr-core.php']);
		}

		if ($uaccess == "specific_user" && $uid != get_current_user_id()) {
			unset($plugins['wpstar-admin/wpstr-core.php']);
		}

		if ($uaccess == "manage_options" && !current_user_can('manage_options')) {
			unset($plugins['wpstar-admin/wpstr-core.php']);
		}
	}


	return $plugins;

	/*


		if($get_plugin_access == "specific_user" && $get_plugin_page == "hide"){

		}

		$get_plugin_userid == get_current_user_id()
		$allowed_user_id = $this->wp_menu_editor->get_plugin_option('plugins_page_allowed_user_id');
		if ( get_current_user_id() != $allowed_user_id ) {
			unset($plugins[$this->wp_menu_editor->plugin_basename]);
		}
		return $plugins;*/
}


?>