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

function wpstr_page_loader()
{
    global $wpstr_css_ver;

    global $wpstradmin;
       $wpstradmin = wpstradmin_network($wpstradmin);       


    //print_r($wpstradmin);


    if(isset($wpstradmin['enable-pageloader']) && $wpstradmin['enable-pageloader'] == "1" && $wpstradmin['enable-pageloader'] != "0" && $wpstradmin['enable-pageloader']){

        $url = plugins_url('/', __FILE__).'../js/wpstr-pace.min.js';
        wp_deregister_script('wpstr-pace-js');
        wp_register_script('wpstr-pace-js', $url);
        wp_enqueue_script('wpstr-pace-js');


        $url = plugins_url('/', __FILE__).'../css/wpstr-pace.min.css';
        wp_deregister_style('wpstr-pace-css', $url);
        wp_register_style('wpstr-pace-css', $url);
        wp_enqueue_style('wpstr-pace-css');
    }

}

?>