<?php
/**
 * @Package: WordPress Plugin
 * @Subpackage: WPStar - White Label WordPress Admin Theme Theme
 * @Since: Wpstr 1.0
 * @WordPress Version: 4.0 or above
 * This file is part of WPStar - White Label WordPress Admin Theme Theme Plugin.
 */
?>
<?php

function wpstr_admintopbar(){
    global $wpstradmin;
       $wpstradmin = wpstradmin_network($wpstradmin);       

    if(isset($wpstradmin['enable-topbar']) && $wpstradmin['enable-topbar'] != "1" && $wpstradmin['enable-topbar'] == "0" && !$wpstradmin['enable-topbar']){
        echo "<style type='text/css'>#wpadminbar{display: none !important;} html.wp-toolbar{padding-top:0px !important;} #wpcontent{padding-top: 0px !important;}  #wpcontent:before{height: 70px !important;position:absolute !important;}</style>";
    }
}



function wpstr_wptopbar(){
    global $wpstradmin;
       $wpstradmin = wpstradmin_network($wpstradmin);       

    if(isset($wpstradmin['enable-topbar-wp']) && $wpstradmin['enable-topbar-wp'] != "1" && $wpstradmin['enable-topbar-wp'] == "0" && !$wpstradmin['enable-topbar-wp']){
        remove_action('wp_footer', 'wp_admin_bar_render', 9);
        add_filter('show_admin_bar', '__return_false');
    }

}



function wpstr_admintopbar_links(){
        global $wpstradmin;
       $wpstradmin = wpstradmin_network($wpstradmin);       

        //print_r($wpstradmin);
          
        $str = "";

        $element = 'enable-topbar-links-wp';
        if(isset($wpstradmin[$element]) && $wpstradmin[$element] != "1" && $wpstradmin[$element] == "0" && !$wpstradmin[$element]){
            $str .= "#wp-admin-bar-wp-logo{display:none;}";
        }
        
        $element = 'enable-topbar-links-site';
        if(isset($wpstradmin[$element]) && $wpstradmin[$element] != "1" && $wpstradmin[$element] == "0" && !$wpstradmin[$element]){
            $str .= "#wp-admin-bar-site-name{display:none;}";
        }

        $element = 'enable-topbar-links-comments';
        if(isset($wpstradmin[$element]) && $wpstradmin[$element] != "1" && $wpstradmin[$element] == "0" && !$wpstradmin[$element]){
            $str .= "#wp-admin-bar-comments{display:none;}";
        }

        $element = 'enable-topbar-links-new';
        if(isset($wpstradmin[$element]) && $wpstradmin[$element] != "1" && $wpstradmin[$element] == "0" && !$wpstradmin[$element]){
            $str .= "#wp-admin-bar-new-content{display:none;}";
        }

        $element = 'enable-topbar-links-wpstradmin';
        if(isset($wpstradmin[$element]) && $wpstradmin[$element] != "1" && $wpstradmin[$element] == "0" && !$wpstradmin[$element]){
            $str .= "#wp-admin-bar-_wpstroptions{display:none;}";
        }


        $element = 'enable-topbar-links-updates';
        if(isset($wpstradmin[$element]) && $wpstradmin[$element] != "1" && $wpstradmin[$element] == "0" && !$wpstradmin[$element]){
            $str .= "#wp-admin-bar-updates{display:none;}";
        }

       echo "<style type='text/css'>".$str."</style>";
}





function wpstr_topbar_logout_link() {
       global $wpstradmin;
       $wpstradmin = wpstradmin_network($wpstradmin);       

       $element = 'user-profile-style';
       
       if(isset($wpstradmin[$element]) && trim($wpstradmin[$element]) == "style3"){
   
                global $wp_admin_bar;
                $wp_admin_bar->add_menu( array(
                    'id'    => 'wp-custom-logout',
                    'title' => 'Logout',
                    'parent'=> 'top-secondary',
                    'href'  => wp_logout_url()
                ) );
   }

}



function wpstr_topbar_menuids(){

    global $wp_admin_bar;
    global $wpstradmin;
       $wpstradmin = wpstradmin_network($wpstradmin);       

        $element = 'enable-topbar-links-wp';
        if(isset($wpstradmin[$element]) && $wpstradmin[$element] != "1" && $wpstradmin[$element] == "0" && !$wpstradmin[$element]){
            $wp_admin_bar->remove_menu('wp-logo');
        }

        $element = 'enable-topbar-links-site';
        if(isset($wpstradmin[$element]) && $wpstradmin[$element] != "1" && $wpstradmin[$element] == "0" && !$wpstradmin[$element]){
            $wp_admin_bar->remove_menu('site-name');            
        }

        $element = 'enable-topbar-links-comments';
        if(isset($wpstradmin[$element]) && $wpstradmin[$element] != "1" && $wpstradmin[$element] == "0" && !$wpstradmin[$element]){
            $wp_admin_bar->remove_menu('comments');
        }

        $element = 'enable-topbar-links-updates';
        if(isset($wpstradmin[$element]) && $wpstradmin[$element] != "1" && $wpstradmin[$element] == "0" && !$wpstradmin[$element]){
            $wp_admin_bar->remove_menu('updates');
        }

        $element = 'enable-topbar-links-new';
        if(isset($wpstradmin[$element]) && $wpstradmin[$element] != "1" && $wpstradmin[$element] == "0" && !$wpstradmin[$element]){
            $wp_admin_bar->remove_menu('new-content');
        }

        $element = 'enable-topbar-links-wpstradmin';
        if(isset($wpstradmin[$element]) && $wpstradmin[$element] != "1" && $wpstradmin[$element] == "0" && !$wpstradmin[$element]){
            $wp_admin_bar->remove_menu('_wpstroptions');
        }

        $element = 'user-profile-style';
        if(isset($wpstradmin[$element]) && ($wpstradmin[$element] != "style1" && $wpstradmin[$element] != "style2") ){
            $wp_admin_bar->remove_menu('my-account');
        }


        $element = 'topbar-removeids';
        if(isset($wpstradmin[$element]) && trim($wpstradmin[$element]) != ""){
            $exp = explode(",",$wpstradmin[$element]);
            $exp = array_unique(array_filter($exp));

            foreach($exp as $nodeid){
                if(trim($nodeid) != ""){
                    $wp_admin_bar->remove_menu($nodeid);
                }
            }
        }


}





function wpstr_topbar_account_menu( $wp_admin_bar ) {

    global $wpstradmin;
       $wpstradmin = wpstradmin_network($wpstradmin);       
        $greet = 'Howdy';

        $element = 'myaccount_greet';
        if(isset($wpstradmin[$element]) && trim($wpstradmin[$element]) != "Howdy"){

            $greet = $wpstradmin[$element];
            if($greet != ""){ $greet .= ', '; }

            $user_id = get_current_user_id();
            $current_user = wp_get_current_user();
            $profile_url = get_edit_profile_url( $user_id );

            if ( 0 != $user_id ) {
            
                /* Add the "My Account" menu */
                $avatar = get_avatar( $user_id, 28 );
                $howdy = $greet.''.sprintf( __('%1$s','wpstr_framework'), $current_user->display_name );
                $class = empty( $avatar ) ? '' : 'with-avatar';

                $wp_admin_bar->add_menu( array(
                'id' => 'my-account',
                'parent' => 'top-secondary',
                'title' => $howdy . $avatar,
                'href' => $profile_url,
                'meta' => array(
                'class' => $class,
                ),
                ) );

            }
        }
}





?>