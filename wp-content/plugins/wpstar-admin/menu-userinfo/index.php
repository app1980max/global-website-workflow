<?php

function wpstr_userinfo_menu_settings()
{

	echo "<style type='text/css'>#wp-admin-bar-my-account{visibility:hidden;}</style>";

    global $wpstradmin;
    $wpstradmin = wpstradmin_network($wpstradmin);   
    $element = "user-profile-style";
        if(isset($wpstradmin[$element]) && trim($wpstradmin[$element]) == "style1"){
		wp_enqueue_script('wpstr-wp-stats-js', plugins_url( '/ajaxcall.js' , __FILE__ ) , array( 'jquery' ));
		wp_localize_script( 'wpstr-wp-stats-js', 'wpstr_wp_stats_ajax', array( 'wpstr_wp_stats_ajaxurl' => admin_url( 'admin-ajax.php')));

        } else {

	echo "<style type='text/css'>#wp-admin-bar-my-account{visibility:visible;}</style>";

        }

}

//add_action("init","wpstr_userinfo_menu_settings");

function wpstr_wp_stats_ajax_online_total(){
	global $wpstradmin;
	$current_user = wp_get_current_user();
	$args = array();
	$display_name = $current_user->data->display_name;
	$user_id = $current_user->data->ID;
	$avatar_url = get_avatar_url ($user_id,$args);
	//echo $avatar_url;
	$roles = "";

	if ( !empty( $current_user->roles ) && is_array( $current_user->roles ) ) {
		foreach ( $current_user->roles as $role )
			$roles .= $role.", ";
	}

       $roles = substr($roles,0,-2);

		$element = 'myaccount_greet';
		$greetwith = "Hi";
		if(isset($wpstradmin[$element]) && trim($wpstradmin[$element]) != ""){
			$greetwith = $wpstradmin[$element];
		}

		$str = "<div class='menu-userinfo'>";
		$str .= "<div class='dispavatar'><a href='".get_edit_user_link($user_id)."'><img src='".$avatar_url."'></a></div>";
		$str .= "<div class='dispname'><a href='javascript:;'>".$greetwith." ".$display_name."</a><a href='javascript:;' class='wpstr-menu-profile-links'><i class='open-links'></i><ul class='all-links'></ul></a></span></div>";
		$str .= "<div class='disproles'>".$role."</div>";

		$str .= "</div>";

		echo $str;

	die();
}
add_action('wp_ajax_wpstr_wp_stats_ajax_online_total', 'wpstr_wp_stats_ajax_online_total');
add_action('wp_ajax_nopriv_wpstr_wp_stats_ajax_online_total', 'wpstr_wp_stats_ajax_online_total');

function wpstr_display_userinfo_in_menu(){ }

?>