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

function wpstr_custom_login() {
    global $wpstradmin;
       $wpstradmin = wpstradmin_network($wpstradmin);       

    global $wpstr_css_ver;

    $url = plugins_url('/', __FILE__).'../'.$wpstr_css_ver.'/wpstr-login.min.css';
    wp_deregister_style('wpstr-login');
    wp_register_style('wpstr-login', $url);
    wp_enqueue_style('wpstr-login');



    $url = plugins_url('/', __FILE__).'../js/wpstr-login.js';
    // wp_deregister_script('wpstr-login-scripts-js');
    // wp_register_script('wpstr-login-scripts-js', $url);
    // wp_enqueue_script('wpstr-login-scripts-js','jquery');

    wp_enqueue_script( 'wpstr-login-scripts-js', $url, array( 'jquery' ), '1.0.0', true );
    

    $show_bg_effect = true;
    $element = 'login_bg_effect';
    
    if(isset($wpstradmin[$element]) && trim($wpstradmin[$element]) != ""){
         if($wpstradmin[$element] == "0"){
            $show_bg_effect = false;
    }}

    if($show_bg_effect){
        $url = plugins_url('/', __FILE__).'../effect/css/style.css';
        wp_deregister_style('wpstr-login-effect');
        wp_register_style('wpstr-login-effect', $url);
        wp_enqueue_style('wpstr-login-effect');
        $url = plugins_url('/', __FILE__).'../effect/js/particles.js';
        wp_enqueue_script( 'wpstr-login-effect-scripts-js', $url, array( 'jquery' ), '1.0.0', true );
        $url = plugins_url('/', __FILE__).'../effect/js/app.js';
        wp_enqueue_script( 'wpstr-login-effect-app-scripts-js', $url, array( 'jquery' ), '1.0.0', true );
    }

    echo "\n<style type='text/css'>";

    /*text, backgrounds, link color*/
    echo wpstr_css_background("body, #wp-auth-check-wrap #wp-auth-check", "login-background","","","imp") . "\n";
    // echo "@media screen and ( max-width: 992px ){";
        // echo wpstr_css_background(".login form", "login-form-background",($wpstradmin['login-form-bg-opacity']) == "" ? "0.9" : $wpstradmin['login-form-bg-opacity'],"","imp") . "\n";
        echo wpstr_css_background(".login h1", "login-logo-background","","","imp") . "\n";
    // echo "}";
    // echo "@media screen and ( max-width: 768px ){";
        // echo wpstr_css_background("#login", "login-form-background",($wpstradmin['login-form-bg-opacity']) == "" ? "0.7" : $wpstradmin['login-form-bg-opacity'],"","imp") . "\n";
    // echo "}";

    echo wpstr_link_color("body.login #backtoblog a, body.login #nav a, body.login a", "login-link-color") . "\n";
    echo wpstr_css_color(".login, .login form label, .login form, .login .message", "login-text-color") . "\n";

    /*login button*/
    echo wpstr_css_bgcolor(".login.wp-core-ui .button-primary", "login-button-bg") . "\n";
    echo wpstr_css_bgcolor(".login.wp-core-ui .button-primary:hover, .login.wp-core-ui .button-primary:focus", "login-button-hover-bg") . "\n";
    echo wpstr_css_color(".login.wp-core-ui .button-primary", "login-button-text-color") . "\n";


    /*form input fields - text and checkbox*/
    echo wpstr_css_bgcolor(".login form .input, .login form input[type=checkbox], .login input[type=text]", "login-input-bg-color", ($wpstradmin['login-input-bg-opacity']) == "" ? "0.5" : $wpstradmin['login-input-bg-opacity'],"","imp") . "\n";
    echo wpstr_css_bgcolor(".login form .input:hover, .login form input[type=checkbox]:hover, .login input[type=text]:hover, .login form .input:focus, .login form input[type=checkbox]:focus, .login input[type=text]:focus", "login-input-bg-color", ($wpstradmin['login-input-bg-hover-opacity']) == "" ? "0.8" : $wpstradmin['login-input-bg-hover-opacity'],"","imp") . "\n";
    echo wpstr_css_color(".login form .input, .login form input[type=checkbox], .login input[type=text]", "login-input-text-color") . "\n";
    echo wpstr_css_color(".login.wp-core-ui input[type=checkbox]:checked:before", "login-input-text-color") . "\n";

    // echo wpstr_css_border_color(".login form .input, .login input[type=text]", "login-input-border-color", "1.0", "bottom") . "\n";
    // echo wpstr_css_border_color(".login form .input:hover, .login input[type=text]:hover,.login input[type=checkbox]:hover, .login input[type=password]:hover ,.login form .input:focus, .login input[type=text]:focus,.login input[type=checkbox]:focus, .login input[type=password]:focus", "login-button-bg", "1.0", "all") . "\n";
    // echo wpstr_css_border_color(".login form input[type=checkbox]", "login-input-border-color", "1.0", "all") . "\n";

    /* input fields icons */
    // echo wpstr_css_color(".login label[for='user_login']:before, .login label[for='user_pass']:before, .login label[for='user_email']:before", "login-input-border-color") . "\n";

    /*form input fields - other fields - for future use*/
    echo wpstr_css_bgcolor("input[type=checkbox], input[type=color], input[type=date], input[type=datetime-local], input[type=datetime], input[type=email], input[type=month], input[type=number], input[type=password], input[type=radio], input[type=search], input[type=tel], input[type=text], input[type=time], input[type=url], input[type=week], select, textarea", "login-input-bg-color", ($wpstradmin['login-input-bg-opacity']) == "" ? "0.5" : $wpstradmin['login-input-bg-opacity']) . "\n";
    echo wpstr_css_color("input[type=checkbox], input[type=color], input[type=date], input[type=datetime-local], input[type=datetime], input[type=email], input[type=month], input[type=number], input[type=password], input[type=radio], input[type=search], input[type=tel], input[type=text], input[type=time], input[type=url], input[type=week], select, textarea", "login-input-text-color") . "\n";


    /*login error message*/
    echo wpstr_css_bgcolor(".login #login_error, .login .message", "login-input-bg-color", ($wpstradmin['login-input-bg-opacity']) == "" ? "0.5" : $wpstradmin['login-input-bg-opacity'],"","imp") . "\n";
    echo wpstr_css_color(" .login .message,  .login .message a, .login #login_error, .login #login_error a", "login-input-text-color") . "\n";


    /*login logo*/
	$logo_url = "";
    if (isset($wpstradmin['login-logo']['url']) && $wpstradmin['login-logo']['url'] != "") {
        $logo_url = $wpstradmin['login-logo']['url'];
    } else {
        $logo_url = $wpstradmin['logo']['url'];
    }

    echo '.login h1 a { background-image: url("' . $logo_url . '") !important;}';


echo "</style>\n"; 




}


function wpstr_custom_loginlogo_url() {

    global $wpstradmin;
       $wpstradmin = wpstradmin_network($wpstradmin);       

    $logourl = "https://wordpress.org/";

    if(isset($wpstradmin['logo-url']) && trim($wpstradmin['logo-url']) != ""){
        $logourl = $wpstradmin['logo-url'];
    }
    return $logourl;
}




function wpstr_login_options(){

       global $wpstradmin;
       $wpstradmin = wpstradmin_network($wpstradmin);       

       // back to blog
       $backtoblog = "block";
       $element = 'backtosite_login_link';
       
       if(isset($wpstradmin[$element]) && trim($wpstradmin[$element]) != ""){
            if($wpstradmin[$element] == "0"){
                $backtoblog = "none";
       }}
         
       $style = "";
       $style .= " #backtoblog { display:".$backtoblog." !important; } ";


       // forgot password

       $forgot = "block";
       $element = 'forgot_login_link';
       
       if(isset($wpstradmin[$element]) && trim($wpstradmin[$element]) != ""){
            if($wpstradmin[$element] == "0"){
                $forgot = "none";
       }}
       
       $style .= " #nav { display:".$forgot." !important; } ";

       echo "<style type='text/css' id='wpstr-login-extra-css'>".$style."</style>";

}


// change title
function wpstr_loginlogo_title() {
    global $wpstradmin;
       $wpstradmin = wpstradmin_network($wpstradmin);       

    $logourl = "";

    if(isset($wpstradmin['login-logo-title']) && trim($wpstradmin['login-logo-title']) != ""){
        $logourl = $wpstradmin['login-logo-title'];
    }
    return $logourl;
}
add_filter( 'login_headertext', 'wpstr_loginlogo_title' );


function wpstr_login_effect(){

    global $wpstradmin;
    $wpstradmin = wpstradmin_network($wpstradmin);       

    $show = true;
    $element = 'login_bg_effect';
    
    if(isset($wpstradmin[$element]) && trim($wpstradmin[$element]) != ""){
         if($wpstradmin[$element] == "0"){
            $show = false;
    }}

    if($show){
        echo '<div id="particles-js"></div>';
    }
}
add_filter( 'login_message', 'wpstr_login_effect' );


?>