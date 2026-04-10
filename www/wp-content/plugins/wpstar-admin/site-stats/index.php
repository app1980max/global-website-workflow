<?php
// Security: Considered blocking direct access to PHP files by adding the following line. 
defined('ABSPATH') or die("Silence is golden :)");

/*Dashboard Widget Page Stats*/

function wpstr_pagestats_add_dashboard() {
  wp_add_dashboard_widget( 'pagestats_wp_dashboard',  __('Pages Count & Type', 'wpstr_framework'), 'wpstr_pagestats_dashboard_output' );
}

function wpstr_pagestats_dashboard_output() {
  include('includes/pagestats-ajaxcall.php');
}

function wpstrwid_pagestats(){  
  include('includes/wpstr-stats-pages.php');
  wp_show_stats_pages();
  die();
}

add_action('wp_ajax_wpstrwid_pagestats', 'wpstrwid_pagestats');
add_action('wp_ajax_nopriv_wpstrwid_pagestats', 'wpstrwid_pagestats');


/*Dashboard Widget Post Stats*/

function wpstr_poststats_add_dashboard() {
  wp_add_dashboard_widget( 'poststats_wp_dashboard', __('Posts Statistics', 'wpstr_framework') , 'wpstr_poststats_dashboard_output' );
}

function wpstr_poststats_dashboard_output() {
  include('includes/poststats-ajaxcall.php');
}

function wpstrwid_poststats(){  
  include('includes/wpstr-stats-posts.php');
  wp_show_stats_posts();
  die();
}

add_action('wp_ajax_wpstrwid_poststats', 'wpstrwid_poststats');
add_action('wp_ajax_nopriv_wpstrwid_poststats', 'wpstrwid_poststats');


/*Dashboard Widget Comment Stats*/

function wpstr_commentstats_add_dashboard() {
  wp_add_dashboard_widget( 'commentstats_wp_dashboard', __('User Comments', 'wpstr_framework') , 'wpstr_commentstats_dashboard_output' );
}

function wpstr_commentstats_dashboard_output() {
  include('includes/commentstats-ajaxcall.php');
}

function wpstrwid_commentstats(){  
  include('includes/wpstr-stats-comments.php');
  wp_show_stats_comments();
  die();
}

add_action('wp_ajax_wpstrwid_commentstats', 'wpstrwid_commentstats');
add_action('wp_ajax_nopriv_wpstrwid_commentstats', 'wpstrwid_commentstats');






/*Dashboard Widget Category Stats*/

function wpstr_catstats_add_dashboard() {
  wp_add_dashboard_widget( 'catstats_wp_dashboard', __('Category Statistics', 'wpstr_framework') , 'wpstr_catstats_dashboard_output' );
}

function wpstr_catstats_dashboard_output() {
  include('includes/catstats-ajaxcall.php');
}

function wpstrwid_catstats(){
  include('includes/wpstr-stats-categories.php');
  wp_show_stats_categories();
  die();
}

add_action('wp_ajax_wpstrwid_catstats', 'wpstrwid_catstats');
add_action('wp_ajax_nopriv_wpstrwid_catstats', 'wpstrwid_catstats');



/*Dashboard Widget User Stats*/

function wpstr_userstats_add_dashboard() {
  wp_add_dashboard_widget( 'userstats_wp_dashboard', __('User Statistics', 'wpstr_framework') , 'wpstr_userstats_dashboard_output' );
}


function wpstr_userstats_dashboard_output() {
  include('includes/userstats-ajaxcall.php');
}

function wpstrwid_userstats(){  
  include('includes/wpstr-stats-users.php');
  wp_show_stats_users();
  die();
}

add_action('wp_ajax_wpstrwid_userstats', 'wpstrwid_userstats');
add_action('wp_ajax_nopriv_wpstrwid_userstats', 'wpstrwid_userstats');


?>
