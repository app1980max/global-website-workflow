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

/* 
 * Function to select the CSS theme file based on option panel settings
 * Also it can regenerate custom CSS file and enqueue 
 *  
 */


function wpstr_core()
{

    global $wpstr_css_ver;
    global $wpstradmin;

    $wpstradmin = wpstradmin_network($wpstradmin);

    $globalmsg = "";


    /*----------- Check Permissions - Start ---------------*/

    $get_admintheme_page = wpstr_get_option("wpstradmin_admintheme_page", "enable");
    $get_logintheme_page = wpstr_get_option("wpstradmin_logintheme_page", "enable");

    $adminside = true;
    if (isset($get_admintheme_page) && $get_admintheme_page == "disable") {
        $adminside = false;
    }

    $loginside = true;
    if (isset($get_logintheme_page) && $get_logintheme_page == "disable") {
        $loginside = false;
    }

    //echo $adminside; echo $loginside;

    /*----------- Check Permissions - End---------------*/


    if ($wpstr_css_ver != "") {

        /* Add Options*/
        wpstr_add_option("wpstradmin_menuorder", "");
        wpstr_add_option("wpstradmin_submenuorder", "");
        wpstr_add_option("wpstradmin_menurename", "");
        wpstr_add_option("wpstradmin_submenurename", "");
        wpstr_add_option("wpstradmin_menudisable", "");
        wpstr_add_option("wpstradmin_submenudisable", "");

        add_action('admin_enqueue_scripts', 'wpstr_disable_menu', 1);
        if ($adminside) {
            add_action('admin_enqueue_scripts', 'wpstr_scripts', 1);
        }

        add_action('admin_enqueue_scripts', 'wpstr_logo', 99);
        add_action('admin_enqueue_scripts', 'wpstr_logo_url', 99);

        add_action('admin_enqueue_scripts', 'wpstr_admintopbar', 1);
        add_action('admin_enqueue_scripts', 'wpstr_admintopbar_links', 1);
        add_action('wp_enqueue_scripts', 'wpstr_admintopbar_links', 1);
        add_action('wp_enqueue_scripts', 'wpstr_wptopbar', 1);
        add_action('wp_before_admin_bar_render', 'wpstr_topbar_logout_link');
        add_action('wp_before_admin_bar_render', 'wpstr_topbar_menuids');
        add_action('admin_bar_menu', 'wpstr_topbar_account_menu', 11);

        if ($adminside) {
            add_action('admin_enqueue_scripts', 'wpstr_userinfo_menu_settings', 1);
        }

        global $pagenow;
        if ($pagenow == "index.php") {
            add_action("admin_enqueue_scripts", "wpstrwid_init_scripts");
        }
        add_action("wp_enqueue_scripts", "wpstrwid_init_scripts_frontend");

        add_action('admin_footer', 'wpstr_floating_menu_settings', 1);
        add_action('admin_init', 'wpstr_load_dashboard_widgets', 1);
        add_filter('admin_body_class', 'wpstr_hover3d_body_class');

        if ($adminside) {
            add_action('admin_enqueue_scripts', 'wpstr_page_loader', 1);
            add_action('admin_enqueue_scripts', 'wpstr_fonts', 99);
            add_action('admin_enqueue_scripts', 'wpstr_admin_css', 99);
            add_action('admin_enqueue_scripts', 'wpstr_adminmenu_style', 99);
        }

        add_action('admin_enqueue_scripts', 'wpstr_favicon', 99);
        add_action('admin_enqueue_scripts', 'wpstr_custom_css', 99);

        add_action('admin_enqueue_scripts', 'wpstr_extra_css', 99);



        /*add_action('admin_enqueue_scripts', 'wpstradmin_access', 99);*/
        add_filter('admin_footer_text', 'wpstr_footer_admin');
        add_action('init', 'wpstr_email_settings');

        if ($adminside) {
            remove_action("admin_color_scheme_picker", "admin_color_scheme_picker");
        }

        if ($loginside) {
            add_action('login_enqueue_scripts', 'wpstr_custom_login', 99);
            add_filter('login_headerurl', 'wpstr_custom_loginlogo_url');
            add_action('login_enqueue_scripts', 'wpstr_login_options', 99);
            add_action('login_enqueue_scripts', 'wpstr_login_custom_css', 99);
        }

        if ($adminside) {
            wpstr_dynamic_css_settings();
        }

        if ($adminside) {
            add_action('admin_menu', 'wpstr_screen_tabs');
        }

        $get_menumng_page = wpstr_get_option("wpstradmin_menumng_page", "enable");
        if ($get_menumng_page != "disable") {
            add_filter('admin_body_class', 'wpstr_menumng_body_classes');
        }
    } else {
        echo "<script type='text/javascript'>console.log('Wpstr WP Admin: WordPress Version Not Supported Yet!');</script>";
    }
}

function wpstr_menumng_body_classes($classes)
{
    return $classes . " tp-menumng";
}


function wpstradmin_network($default)
{

    if (is_multisite() && wpstr_network_active()) {
        global $blog_id;
        $current_blog_id = $blog_id;
        switch_to_blog(1);
        $site_specific_wpstradmin = get_option("wpstr_demo");
        $wpstradmin = $site_specific_wpstradmin;
        switch_to_blog($current_blog_id);
    } else {
        $wpstradmin = $default;
    }

    return $wpstradmin;
}

function wpstr_dynamic_css_settings()
{

    global $wpstr_css_ver;

    global $wpstradmin;
    //echo "<pre>"; print_r($wpstradmin); echo "</pre>"; 

    $csstype = wpstr_dynamic_css_type();

    if (isset($csstype) && $csstype != "custom") {
        // enqueue default/ inbuilt CSS styles
        add_action('admin_enqueue_scripts', 'wpstr_default_css_colors', 99);
    } else {

        // load custom CSS style generated dynamically

        $css_dir = trailingslashit(plugin_dir_path(__FILE__) . '../' . $wpstr_css_ver);

        // if Not multisite
        if (!is_multisite()) {
            if (is_writable($css_dir)) {
                //write the file if isn't there
                if (!file_exists($css_dir . '/wpstr-colors.css')) {
                    wpstr_regenerate_dynamic_css_file();
                }
                add_action('admin_enqueue_scripts', 'wpstr_dynamic_enqueue_style', 99);
            } else {
                add_action('admin_head', 'wpstr_wp_head_css');
            }
        } else if (is_multisite() && wpstr_network_active()) {
            // multisite and network active
            if (is_writable($css_dir)) {

                global $wpdb;
                global $blog_id;
                $current_blog_id = $blog_id;

                $current_site = 1;
                switch_to_blog(1);

                //write the file if isn't there
                if (!file_exists($css_dir . '/wpstr-colors-site-' . $current_site . '.css')) {

                    $site_specific_wpstradmin = get_option("wpstr_demo");
                    $filename = 'site-' . $current_site;
                    //print_r($site_specific_wpstradmin);
                    wpstr_regenerate_dynamic_css_file($site_specific_wpstradmin, $filename);
                }
                add_action('admin_enqueue_scripts', 'wpstr_dynamic_enqueue_style', 99);

                switch_to_blog($current_blog_id);
            } else {
                add_action('admin_head', 'wpstr_wp_head_css');
            }
        } else {
            // multisite and not network active

            // regenerate css file for the individual site only and enqueue it.
            if (is_writable($css_dir)) {

                global $wpdb;
                $current_site = $wpdb->blogid;

                //write the file if isn't there
                if (!file_exists($css_dir . '/wpstr-colors-site-' . $current_site . '.css')) {

                    $site_specific_wpstradmin = get_option("wpstr_demo");
                    $filename = 'site-' . $current_site;
                    //print_r($site_specific_wpstradmin);
                    wpstr_regenerate_dynamic_css_file($site_specific_wpstradmin, $filename);
                }
                add_action('admin_enqueue_scripts', 'wpstr_dynamic_enqueue_style', 99);
            } else {
                add_action('admin_head', 'wpstr_wp_head_css');
            }
        }
    }
}

function wpstr_framework_settings_saved()
{
    //die();
    global $wpstr_css_ver;
    global $wpstradmin;

    $css_dir = trailingslashit(plugin_dir_path(__FILE__) . '../' . $wpstr_css_ver);

    // if Not multisite
    if (!is_multisite()) {

        if (is_writable($css_dir)) {
            wpstr_regenerate_dynamic_css_file();
        }
    } else if (is_multisite() && wpstr_network_active()) {
        global $wpdb;
        $current_blog_id = $wpdb->blogid;
        $current_site = 1;
        switch_to_blog(1);

        $site_specific_wpstradmin = get_option("wpstr_demo");
        $filename = 'site-' . $current_site;
        //print_r($site_specific_wpstradmin);
        wpstr_regenerate_dynamic_css_file($site_specific_wpstradmin, $filename);
        switch_to_blog($current_blog_id);
    } else {

        // multisite
        // regenerate css file for the individual site only

        if (is_writable($css_dir)) {

            global $wpdb;
            $current_site = $wpdb->blogid;

            $site_specific_wpstradmin = get_option("wpstr_demo");
            $filename = 'site-' . $current_site;
            //print_r($site_specific_wpstradmin);
            wpstr_regenerate_dynamic_css_file($site_specific_wpstradmin, $filename);
        }
    }
}



function wpstr_scripts()
{
    global $wpstradmin;

    $url = plugins_url('/', __FILE__) . '../js/wpstr-scripts.js';
    wp_deregister_script('wpstr-scripts-js');
    wp_register_script('wpstr-scripts-js', $url);
    wp_enqueue_script('wpstr-scripts-js', 'jquery');

    // $element = 'enable-smoothscroll';
    // if (isset($wpstradmin['enable-smoothscroll']) && $wpstradmin['enable-smoothscroll'] == "1" && $wpstradmin['enable-smoothscroll'] != "0" && $wpstradmin['enable-smoothscroll']) {
    //     $url = plugins_url('/', __FILE__) . '../js/wpstr-smoothscroll.min.js';
    //     wp_deregister_script('wpstr-smoothscroll-js');
    //     wp_register_script('wpstr-smoothscroll-js', $url);
    //     wp_enqueue_script('wpstr-smoothscroll-js', 'jquery');
    // }

    $url = plugins_url('/', __FILE__) . '../js/wpstr-plugins.min.js';
    wp_deregister_script('wpstr-waves-js');
    wp_register_script('wpstr-waves-js', $url);
    wp_enqueue_script('wpstr-waves-js', 'jquery');


    global $wp_version;
    $plug = trim(get_current_screen()->id);

    if (isset($plug) && $plug == "dashboard") {
        $url = plugins_url('/', __FILE__) . '../js/echarts-all.js';
        wp_deregister_script('wpstr-echarts-js');
        wp_register_script('wpstr-echarts-js', $url);
        wp_enqueue_script('wpstr-echarts-js', 'jquery');
    }

    wp_localize_script(
        'wpstr-scripts-js',
        'wpstr_vars',
        array(
            'wpstr_nonce' => wp_create_nonce('wpstr-nonce')
        )
    );




    if (file_exists(plugin_dir_path(__FILE__) . '../demo-settings/wpstr-settings-panel-css.css')) {
        wp_deregister_style('wpstr-settings-panel-css');
        wp_register_style('wpstr-settings-panel-css', plugins_url('/', __FILE__) . "../demo-settings/wpstr-settings-panel-css.css");
        wp_enqueue_style('wpstr-settings-panel-css');
    }

    if (file_exists(plugin_dir_path(__FILE__) . '../demo-settings/wpstr-settings-panel-js.js')) {
        wp_deregister_script('wpstr-settings-panel-js');
        wp_register_script('wpstr-settings-panel-js', plugins_url('/', __FILE__) . "../demo-settings/wpstr-settings-panel-js.js");
        wp_enqueue_script('wpstr-settings-panel-js');
    }
}

function wpstr_adminmenu_style()
{
    // global $wpstradmin;
    // $wpstradmin = wpstradmin_network($wpstradmin);

    // if (isset($wpstradmin['menu-style']) && $wpstradmin['menu-style'] == "style2") {
        // add_filter('admin_body_class', 'wpstr_admin_body_class');
    // }
}

// function wpstr_admin_body_class($classes)
// {
//     return $classes . ' menustyle2';
// }


function wpstr_admin_css()
{
    global $wpstr_css_ver;

    $url = plugins_url('/', __FILE__) . '../' . $wpstr_css_ver . '/wpstr-admin.min.css';
    wp_deregister_style('wpstr-admin', $url);
    wp_register_style('wpstr-admin', $url);
    wp_enqueue_style('wpstr-admin');
}


function wpstr_dynamic_css_type()
{

    //global $wpdb;
    //echo $wpdb->blogid;

    global $wpstr_css_ver;
    global $wpstradmin;


    $csstype = "custom";

    if (is_multisite()) {

        global $blog_id;
        $current_blog_id = $blog_id;
        $network_active = wpstr_network_active();

        //echo "<br><br>id:".$current_blog_id;

        if ($network_active) {
            //if network activate, switch to main blog
            switch_to_blog(1);
        }

        //echo $blog_id;

        // get current site framework options and thus gets it csstype value
        $current_site = get_option("wpstr_demo");
        if (isset($current_site['dynamic-css-type'])) {
            $csstype = $current_site['dynamic-css-type'];
        }
        //print_r($current_site);
        //echo $csstype;
        if ($network_active) {
            // switch back to current blog again if network active
            switch_to_blog($current_blog_id);
        }
        //echo $blog_id;

    } else {


        if (!isset($wpstradmin) || (isset($wpstradmin) && is_array($wpstradmin) && sizeof($wpstradmin) == 0)) {
            $wpstradmin = get_option("wpstr_demo");
        }
        if (isset($wpstradmin['dynamic-css-type'])) {
            $csstype = $wpstradmin['dynamic-css-type'];
        }
    }

    /* --------------- Wpstr Settings Panel - for demo purposes ---------------- */
    if (!has_action('plugins_loaded', 'wpstr_regenerate_all_dynamic_css_file') && has_action('admin_footer', 'wpstr_admin_footer_function')) {
        if (file_exists(plugin_dir_path(__FILE__) . '../demo-settings/wpstr-settings-panel-session.php')) {
            include(trailingslashit(dirname(__FILE__)) . '../demo-settings/wpstr-settings-panel-session.php');
        }
    }
    return $csstype;
}


function wpstr_default_css_colors()
{
    global $wpstr_css_ver;
    global $wpstradmin;
    $csstype = wpstr_dynamic_css_type();
    //echo "default:".$csstype;
    $css_path = trailingslashit(plugins_url('/', __FILE__) . '../' . $wpstr_css_ver . '/colors');
    $css_dir = trailingslashit(plugin_dir_path(__FILE__) . '../' . $wpstr_css_ver . '/colors');

    if (isset($csstype) && $csstype != "custom" && trim($csstype) != "") {

        $style_color = trim($csstype);

        if (file_exists($css_dir . 'wpstr-colors-' . $style_color . '.css')) {

            wp_deregister_style('wpstr-colors');
            wp_register_style('wpstr-colors', $css_path . 'wpstr-colors-' . $style_color . '.css');
            wp_enqueue_style('wpstr-colors');
        } else {
            // enqueue the default wpstr-colors.css file   
            wpstr_dynamic_enqueue_style();
        }
    }
}


function wpstr_dynamic_enqueue_style()
{
    global $wpstr_css_ver;

    if (!is_multisite()) {
        $url = plugins_url('/', __FILE__) . '../' . $wpstr_css_ver . '/wpstr-colors.css';
    } else if (is_multisite() && wpstr_network_active()) {
        // IF NETWORK ACTIVE
        global $wpdb;
        $current_site = 1;
        $url = plugins_url('/', __FILE__) . '../' . $wpstr_css_ver . '/wpstr-colors-site-' . $current_site . '.css';
    } else {
        // IF NOT NETWORK ACTIVE - FOR INDIVIDUAL SITES ONLY
        global $wpdb;
        $current_site = $wpdb->blogid;
        $url = plugins_url('/', __FILE__) . '../' . $wpstr_css_ver . '/wpstr-colors-site-' . $current_site . '.css';
    }
    wp_deregister_style('wpstr-colors');
    wp_register_style('wpstr-colors', $url);
    wp_enqueue_style('wpstr-colors');

    $style_type = 'custom';
}


function wpstr_wp_head_css()
{

    global $wpstr_css_ver;
    global $wpstradmin;

    global $wpdb;
    $current_blog_id = $wpdb->blogid;

    if (is_multisite() && wpstr_network_active()) {
        switch_to_blog(1);
        $site_specific_wpstradmin = get_option("wpstr_demo");
        $wpstradmin = $site_specific_wpstradmin;
        switch_to_blog($current_blog_id);
    }
    //print_r($wpstradmin);

    echo '<style type="text/css">';

    $dynamic_css_file = trailingslashit(plugin_dir_path(__FILE__) . '../' . $wpstr_css_ver) . 'dynamic_css.php';

    // buffer css 
    ob_start();
    require($dynamic_css_file); // Generate CSS
    $dynamic_css = ob_get_contents();
    ob_get_clean();

    // compress css
    $dynamic_css = wpstr_compress_css($dynamic_css);

    echo $dynamic_css;
    echo '</style>';

    $style_type = 'custom';
}


/* ------------ Generate / Update dynamic CSS file on saving / changing plugin settings ----------*/
function wpstr_regenerate_dynamic_css_file($newwpstradmin = array(), $filename = "", $basedir = "")
{

    global $wpstr_css_ver;
    global $wpstradmin;
    if (sizeof($wpstradmin) == 0) {
        $wpstradmin = get_option("wpstr_demo");
    }
    if (is_array($newwpstradmin) && sizeof($newwpstradmin) > 0) {
        $wpstradmin = $newwpstradmin;
    }

    //echo $filename; print_r($wpstradmin); echo "<hr>";

    global $wpstr_color;

    $newfilename = "wpstr-colors";
    if (trim($filename) != "") {
        $newfilename = "wpstr-colors-" . $filename;
    }

    $dynamic_css = trailingslashit(plugin_dir_path(__FILE__) . '../' . $wpstr_css_ver) . 'dynamic_css.php';
    ob_start(); // Capture all output (output buffering)
    require($dynamic_css); // Generate CSS
    $css = ob_get_clean(); // Get generated CSS (output buffering)
    $pluginurl = plugins_url('/', __FILE__);
    $pluginurl = str_replace("/lib/", "", $pluginurl);
    $css = str_replace("PLUGINURL", $pluginurl, $css);
    $css = wpstr_compress_css($css);

    $css_dir = trailingslashit(plugin_dir_path(__FILE__) . '../' . $wpstr_css_ver);

    if (isset($basedir) && $basedir != "") {
        $css_dir = $basedir;
    }

    require_once(ABSPATH . 'wp-admin/includes/file.php');
    WP_Filesystem();
    global $wp_filesystem;
    if (!$wp_filesystem->put_contents($css_dir . '/' . $newfilename . '.css', $css, 0644)) {
        return true;
    }
}


/*******************
 * wpstr_regenerate_all_dynamic_css_file();
 * Generate all Colors CSS files Function
 * Function called in main plugin file
 *********************/

function wpstr_regenerate_all_dynamic_css_file()
{

    global $wpstr_css_ver;
    global $wpstradmin;

    if (sizeof($wpstradmin) == 0) {
        //switch_to_blog(1);
        $get_wpstradmin = get_option("wpstr_demo");
        $wpstradmin = $get_wpstradmin;
    }

    $wpstradmin_backup = $wpstradmin;
    //echo "hi";
    //print_r($wpstradmin_backup);
    //die();

    global $wpstr_color;

    $basedir = trailingslashit(plugin_dir_path(__FILE__) . '../' . $wpstr_css_ver . '/colors');
    // loop through each color
    foreach ($wpstr_color as $filename => $dyn_data) {
        $wpstradmin = wpstr_newdata($dyn_data);
        //echo $filename."<pre>"; print_r($wpstradmin); echo "</pre>";

        //regenerate new css file
        wpstr_regenerate_dynamic_css_file($wpstradmin, $filename, $basedir);
        $wpstradmin = $wpstradmin_backup;
    }

    // V. Imp to restore the original $data in variable back.
    $wpstradmin = $wpstradmin_backup;
    //die;
}



function wpstr_newdata($dyn_data)
{

    global $wpstr_css_ver;
    global $wpstradmin;
    //print_r($wpstradmin);
    //die();
    //print_r($dyn_data);
    // loop through dynamic values
    foreach ($dyn_data as $type => $val) {
        // string type options
        if (!is_array($val) && trim($val) != "") {
            $wpstradmin[$type] = $val;
        }

        // array type options
        if (is_array($val) && sizeof($val) > 0) {
            foreach ($val as $type2 => $val2) {
                if (!is_array($val2) && trim($val2) != "") {
                    $wpstradmin[$type][$type2] = $val2;
                }
            }
        }
    }

    return $wpstradmin;
}



function wpstr_compress_css($css)
{
    //return $css;
    /* remove comments */
    $css = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $css);

    /* remove tabs, spaces, newlines, etc. */
    $css = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $css);
    return $css;
}



function wpstradmin_access()
{

    global $wpstradmin;
    $str = "";

    $element = 'enable-allusers-wpstradmin';
    if (isset($wpstradmin[$element]) && $wpstradmin[$element] != "1" && $wpstradmin[$element] == "0" && !$wpstradmin[$element]) {
        if (!is_admin()) {
            $str .= ".toplevel_page__wpstroptions{display:none;}";
            $str .= "#wp-admin-bar-_wpstroptions{display:none;}";
        }
    }

    echo "<style type='text/css'>" . $str . "</style>";
}




function wpstr_custom_css()
{

    global $wpstradmin;
    $wpstradmin = wpstradmin_network($wpstradmin);

    $str = "";

    $element = 'custom-css';
    if (isset($wpstradmin[$element]) && trim($wpstradmin[$element]) != "") {
        $str .= $wpstradmin[$element];
    }

    echo "<style type='text/css' id='wpstr-custom-css'>" . $str . "</style>";
}


function wpstr_login_custom_css()
{

    global $wpstradmin;
    $wpstradmin = wpstradmin_network($wpstradmin);

    $str = "";

    $element = 'custom-login-css';
    if (isset($wpstradmin[$element]) && trim($wpstradmin[$element]) != "") {
        $str .= $wpstradmin[$element];
    }

    echo "<style type='text/css' id='wpstr-custom-login-css'>" . $str . "</style>";
}


function wpstr_extra_css()
{

    global $wpstradmin;
    $wpstradmin = wpstradmin_network($wpstradmin);

    //print_r($wpstradmin);

    $transform = "uppercase";
    $style = "";
    $upgrade = "inline";


    /*-----------------*/
    /* Check admin side theme permission */
    $get_admintheme_page = wpstr_get_option("wpstradmin_admintheme_page", "enable");

    $adminside = true;
    if (isset($get_admintheme_page) && $get_admintheme_page == "disable") {
        $adminside = false;
    }
    //echo $adminside;

    if ($adminside) {
        $element = 'menu-transform-text';
        if (isset($wpstradmin[$element]) && trim($wpstradmin[$element]) != "") {
            $transform = $wpstradmin[$element];
        }
        $style .= " #adminmenu .wp-submenu-head, #adminmenu a.menu-top,#adminmenu li.menu-top .wp-submenu>li>a { text-transform:" . $transform . " !important; } ";
    }

    /*-----------------*/


    $element = 'footer_version';
    if (isset($wpstradmin[$element]) && trim($wpstradmin[$element]) != "") {
        if ($wpstradmin[$element] == "0") {
            $upgrade = "none";
        }
    }
    $style .= " #wpfooter #footer-upgrade { display:" . $upgrade . " !important; } ";

    echo "<style type='text/css' id='wpstr-extra-css'>" . $style . "</style>";
}


function wpstr_disable_menu()
{

    $str = "";
    $menudisable = get_option("wpstradmin_menudisable", "");
    $exp = array_unique(array_filter(explode("|", $menudisable)));
    foreach ($exp as $menuid) {
        $str .= "#" . $menuid . ", ";
    }

    $str = substr($str, 0, -2);
}


function wpstrprint($name, $arr)
{

    echo "<div style='max-height:500px;overflow:auto;width:500px;margin-left:300px;z-index:99999;position:relative;background:white;padding:20px;'>";
    echo $name;
    echo "<pre>";
    print_r($arr);
    echo "</pre></div>";
}

//change admin footer text
function wpstr_footer_admin()
{

    global $wpstradmin;

    $wpstradmin = wpstradmin_network($wpstradmin);

    $str = 'Thank you for creating with <a href="https://wordpress.org/">WordPress</a> and <a target="_blank" href="http://codecanyon.net/user/themepassion/portfolio">WPStar - White Label WordPress Admin Theme Theme</a>';

    //print_r($wpstradmin);

    $element = 'footer_text';
    if (isset($wpstradmin[$element]) && trim($wpstradmin[$element]) != "") {
        $str = $wpstradmin[$element];
    }

    echo $str;

    $get_menumng_page = wpstr_get_option("wpstradmin_menumng_page", "enable");
    if ($get_menumng_page != "disable") {
        wpstr_menu_management_counts();
    }
}


function wpstr_menu_management_counts()
{

    //echo "<div style='float:right;position:fixed;background:#fff;top:80px;right:10px;'><pre>";

    $counts = wp_get_update_data();
    $str = "<script type='text/javascript'> ";
    foreach ($counts as $key => $value) {
        if ($key == "counts" && is_array($value) && sizeof($value) > 0) {
            //print_r($value);
            foreach ($value as $ele => $no) {
                if ($ele == "plugins") {
                    $str .= "jQuery('#menu-plugins .wp-menu-name').append('<div class=\'tpcount count-" . $no . " \'>" . $no . "</div>');
                    ";
                }
                if ($ele == "total") {
                    $str .= "jQuery('#menu-dashboard a[href=\'update-core.php\']').append('<div class=\'tpcount count-" . $no . " \'>" . $no . "</div>');
                    ";
                }
                //menu-dashboard
            }
        }
        //echo $key;
    }

    $comment = wp_count_comments();
    foreach ($comment as $key => $value) {
        if ($key == "moderated") {
            $str .= "jQuery('#menu-comments .wp-menu-name').append('<div class=\'tpcount awaiting-mod count-" . $value . "\'>" . $value . "</div>');
                    ";
        }
        //echo $key.$value." | ";
    }


    echo $str;
    echo "</script>";
    //echo "</pre></div>";
    //die();

}



function wpstr_multisite_allsites()
{

    $arr = array();
    //echo "<pre>";
    // get all blogs
    $blogs = get_sites();
    // print_r($blogs);
    //echo "</pre>";
    //die();

    if (0 < count($blogs)) :
        foreach ($blogs as $blog) :
            $getblogid = $blog->blog_id;
            // echo "id:". $getblogid;
            //die();
            switch_to_blog($getblogid);

            if (get_theme_mod('show_in_home', 'on') !== 'on') {
                continue;
            }

            $blog_details = get_blog_details($getblogid);
            //print_r($blog_details);

            //echo "<div style='height:200px; overflow:auto;width:100%;'>"; print_r(get_blog_option( $getblogid, 'wpstr_demo' )); echo "</div>";

            $id = $getblogid;
            $name = $blog_details->blogname;
            $arr[$id] = $name;

        endforeach;
    endif;

    return $arr;
}


function wpstr_network_active()
{

    if (!function_exists('is_plugin_active_for_network')) {
        require_once(ABSPATH . '/wp-admin/includes/plugin.php');
    }

    // Makes sure the plugin is defined before trying to use it
    if (is_plugin_active_for_network('wpstar-admin/wpstr-core.php')) {
        return true;
    }

    return false;
}


function wpstr_add_option($variable, $default)
{
    if (wpstr_network_active()) {
        add_site_option($variable, $default);
    } else {
        add_option($variable, $default);
    }
}

function wpstr_get_option($variable, $default)
{
    if (wpstr_network_active()) {
        return get_site_option($variable, $default);
    } else {
        return get_option($variable, $default);
    }
}

function wpstr_update_option($variable, $default)
{
    if (wpstr_network_active()) {
        update_site_option($variable, $default);
    } else {
        update_option($variable, $default);
    }
}



function wpstr_get_user_type()
{
    $get_admin_menumng_page = wpstr_get_option("wpstradmin_admin_menumng_page", "enable");

    $enablemenumng = true;
    if ((is_super_admin() || current_user_can('manage_options')) && $get_admin_menumng_page == "disable") {
        $enablemenumng = false;
    }
    return $enablemenumng;
}

function wpstr_generate_inbuilt_theme_import_file()
{
    global $wpstr_color;
    foreach ($wpstr_color as $key => $value) {
        $str = "";

        $str .= '{"dynamic-css-type":"custom",';

        if (isset($value['primary-color'])) {
            $str .= '{"primary-color":"' . $value['primary-color'] . '",';
        }
        if (isset($value['menu-icon-color'])) {
            $str .= '"menu-icon-color":"' . $value['menu-icon-color'] . '",';
        }
        if (isset($value['menu-icon-hover-color'])) {
            $str .= '"menu-icon-hover-color":"' . $value['menu-icon-hover-color'] . '",';
        }
        if (isset($value['floatingmenu-bg']['background-color'])) {
            $str .= '"floatingmenu-bg":{"background-color":"' . $value['floatingmenu-bg']['background-color'] . '"},';
        }
        if (isset($value['pace-color'])) {
            $str .= '"pace-color":"' . $value['pace-color'] . '",';
        }

        //        $str .= '"page-bg":{"background-color":"'.$value['page-bg']['background-color'].'"},';
        if (isset($value['heading-color'])) {
            $str .= '"heading-color":"' . $value['heading-color'] . '",';
        }
        //        $str .= '"body-text-color":"'.$value['body-text-color'].'",';

        if (isset($value['link-color']['regular'])) {
            $str .= '"link-color":{"regular":"' . $value['link-color']['regular'] . '","hover":"' . $value['link-color']['hover'] . '"},';
        }

        if (isset($value['menu-bg']['background-color'])) {
            $str .= '"menu-bg":{"background-color":"' . $value['menu-bg']['background-color'] . '"},';
        }
        if (isset($value['menu-color'])) {
            $str .= '"menu-color":"' . $value['menu-color'] . '",';
        }
        if (isset($value['menu-hover-color'])) {
            $str .= '"menu-hover-color":"' . $value['menu-hover-color'] . '",';
        }
        if (isset($value['submenu-color'])) {
            $str .= '"submenu-color":"' . $value['submenu-color'] . '",';
        }
        if (isset($value['menu-primary-bg'])) {
            $str .= '"menu-primary-bg":"' . $value['menu-primary-bg'] . '",';
        }
        if (isset($value['menu-secondary-bg'])) {
            $str .= '"menu-secondary-bg":"' . $value['menu-secondary-bg'] . '",';
        }

        //        $str .= '"logo-bg":"'.$value['logo-bg'].'",';
        //        $str .= '"box-bg":{"background-color":"'.$value['box-bg']['background-color'].'"},';

        if (isset($value['box-head-bg']['background-color'])) {
            $str .= '"box-head-bg":{"background-color":"' . $value['box-head-bg']['background-color'] . '"},';
        }
        if (isset($value['box-head-color'])) {
            $str .= '"box-head-color":"' . $value['box-head-color'] . '",';
        }
        if (isset($value['button-primary-bg'])) {
            $str .= '"button-primary-bg":"' . $value['button-primary-bg'] . '",';
        }
        if (isset($value['button-primary-hover-bg'])) {
            $str .= '"button-primary-hover-bg":"' . $value['button-primary-hover-bg'] . '",';
        }

        if (isset($value['page-heading-bg'])) {
            $str .= '"page-heading-bg":{"background-color":"' . $value['page-heading-bg']['background-color'] . '", "background-repeat":"' . $value['page-heading-bg']['background-repeat'] . '", "background-size":"' . $value['page-heading-bg']['background-size'] . '", "background-position":"' . $value['page-heading-bg']['background-position'] . '", "background-image":"' . $value['page-heading-bg']['background-image'] . '"},';
        }

        if (isset($value['topbar-menu-color'])) {
            $str .= '"topbar-menu-color":"' . $value['topbar-menu-color'] . '",';
        }

        if (isset($value['topbar-menu-bg']['background-color'])) {
            $str .= '"topbar-menu-bg":{"background-color":"' . $value['topbar-menu-bg']['background-color'] . '"},';
        }

        if (isset($value['topbar-submenu-color'])) {
            $str .= '"topbar-submenu-color":"' . $value['topbar-submenu-color'] . '",';
        }
        if (isset($value['topbar-submenu-bg'])) {
            $str .= '"topbar-submenu-bg":"' . $value['topbar-submenu-bg'] . '",';
        }
        if (isset($value['topbar-submenu-hover-bg'])) {
            $str .= '"topbar-submenu-hover-bg":"' . $value['topbar-submenu-hover-bg'] . '","reduk_import_export":"","reduk-backup":1}';
        }
        if (isset($value['topbar-submenu-hover-color'])) {
            $str .= '"topbar-submenu-hover-color":"' . $value['topbar-submenu-hover-color'] . '","reduk_import_export":"","reduk-backup":1}';
        }

        $str .= '"reduk_import_export":"","reduk-backup":1}';

        $pluginurl = plugins_url('/', __FILE__);
        $pluginurl = str_replace("/lib/", "", $pluginurl);
        $str = str_replace("PLUGINURL", $pluginurl, $str);

        wpstr_inbuilttheme_file_create($key, $str);
    }
}


function wpstr_inbuilttheme_file_create($filename, $str)
{

    if (trim($filename) != "" && trim($str) != "") {
        $css_dir = trailingslashit(plugin_dir_path(__FILE__) . '../plugin-essentials/inbuilt_themes_import');

        require_once(ABSPATH . 'wp-admin/includes/file.php');
        WP_Filesystem();
        global $wp_filesystem;
        if (!$wp_filesystem->put_contents($css_dir . '/' . $filename . '.txt', $str, 0644)) {
            return true;
        }
    }
}



function wpstr_admin_footer_function()
{
    /* --------------- Settings Panel ----------------- */
    if (!has_action('plugins_loaded', 'wpstr_regenerate_all_dynamic_css_file')) {
        if (file_exists(plugin_dir_path(__FILE__) . '../demo-settings/wpstr-settings-panel.php')) {
            require_once(trailingslashit(dirname(__FILE__)) . '../demo-settings/wpstr-settings-panel.php');
        }
    }
}


function wpstr_hover3d_body_class()
{
    //global $wpstr_css_ver;
    global $wpstradmin;
    //print_r($wpstradmin);
    $ret = "";

    $wpstradmin = wpstradmin_network($wpstradmin);

    $element = 'hover3d_shadow';
    if (isset($wpstradmin[$element]) && trim($wpstradmin[$element]) != "") {
        if ($wpstradmin[$element] == "0") {
            $ret .= " h3dnos ";
        }
    }

    $element = 'hover3d_translate';
    if (isset($wpstradmin[$element]) && trim($wpstradmin[$element]) != "") {
        if ($wpstradmin[$element] == "0") {
            $ret .= " h3dnot ";
        }
    }

    return $ret;
}

function wpstr_screen_tabs()
{


    global $wpstr_css_ver;
    global $wpstradmin;

    $wpstradmin = wpstradmin_network($wpstradmin);

    /*Remove Screen Option & Help Tabs*/

    $screenoption = true;
    $element = 'screen_option_tab';

    //echo $wpstradmin[$element];

    if (isset($wpstradmin[$element]) && trim($wpstradmin[$element]) != "") {
        if ($wpstradmin[$element] == "0") {
            $screenoption = false;
        }
    }

    $screenhelp = true;
    $element = 'screen_help_tab';
    if (isset($wpstradmin[$element]) && trim($wpstradmin[$element]) != "") {
        if ($wpstradmin[$element] == "0") {
            $screenhelp = false;
        }
    }

    if (!$screenoption) {
        add_filter('screen_options_show_screen', '__return_false');
    }

    if (!$screenhelp) {
        add_action('admin_head', 'wpstr_remove_help_tabs');
    }
}

function wpstr_remove_help_tabs()
{
    $screen = get_current_screen();
    $screen->remove_help_tabs();
}


function wpstr_load_dashboard_widgets()
{
    global $wpstradmin;
    $wpstradmin = wpstradmin_network($wpstradmin);
    $element = "dashboard-widgets";
    //print_r($wpstradmin);

    $widgetid = "wpstr_visitors_type";
    if (isset($wpstradmin[$element][$widgetid]) && $wpstradmin[$element][$widgetid] == "1") {
        add_action('wp_dashboard_setup', $widgetid);
    }

    $widgetid = "wpstr_today_visitors";
    if (isset($wpstradmin[$element][$widgetid]) && $wpstradmin[$element][$widgetid] == "1") {
        add_action('wp_dashboard_setup', $widgetid);
    }

    $widgetid = "wpstr_user_type";
    if (isset($wpstradmin[$element][$widgetid]) && $wpstradmin[$element][$widgetid] == "1") {
        add_action('wp_dashboard_setup', $widgetid);
    }

    $widgetid = "wpstr_browser_type";
    if (isset($wpstradmin[$element][$widgetid]) && $wpstradmin[$element][$widgetid] == "1") {
        add_action('wp_dashboard_setup', $widgetid);
    }

    $widgetid = "wpstr_platform_type";
    if (isset($wpstradmin[$element][$widgetid]) && $wpstradmin[$element][$widgetid] == "1") {
        add_action('wp_dashboard_setup', $widgetid);
    }

    $widgetid = "wpstr_country_type";
    if (isset($wpstradmin[$element][$widgetid]) && $wpstradmin[$element][$widgetid] == "1") {
        add_action('wp_dashboard_setup', $widgetid);
    }


    $widgetid = "wpstr_userstats_add_dashboard";
    if (isset($wpstradmin[$element][$widgetid]) && $wpstradmin[$element][$widgetid] == "1") {
        add_action('wp_dashboard_setup', $widgetid);
    }

    $widgetid = "wpstr_catstats_add_dashboard";
    if (isset($wpstradmin[$element][$widgetid]) && $wpstradmin[$element][$widgetid] == "1") {
        add_action('wp_dashboard_setup', $widgetid);
    }

    $widgetid = "wpstr_commentstats_add_dashboard";
    if (isset($wpstradmin[$element][$widgetid]) && $wpstradmin[$element][$widgetid] == "1") {
        add_action('wp_dashboard_setup', $widgetid);
    }

    $widgetid = "wpstr_poststats_add_dashboard";
    if (isset($wpstradmin[$element][$widgetid]) && $wpstradmin[$element][$widgetid] == "1") {
        add_action('wp_dashboard_setup', $widgetid);
    }

    $widgetid = "wpstr_pagestats_add_dashboard";
    if (isset($wpstradmin[$element][$widgetid]) && $wpstradmin[$element][$widgetid] == "1") {
        add_action('wp_dashboard_setup', $widgetid);
    }


    $element = "dashboard-default-widgets";

    $widgetid = "welcome_panel";
    if (isset($wpstradmin[$element][$widgetid]) && $wpstradmin[$element][$widgetid] != "1") {
        remove_action('welcome_panel', 'wp_welcome_panel');
    }

    $widgetid = "dashboard_primary";
    if (isset($wpstradmin[$element][$widgetid]) && $wpstradmin[$element][$widgetid] != "1") {
        remove_meta_box('dashboard_primary', 'dashboard', 'side');
    }

    $widgetid = "dashboard_quick_press";
    if (isset($wpstradmin[$element][$widgetid]) && $wpstradmin[$element][$widgetid] != "1") {
        remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
    }

    $widgetid = "dashboard_recent_drafts";
    if (isset($wpstradmin[$element][$widgetid]) && $wpstradmin[$element][$widgetid] != "1") {
        remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');
    }

    $widgetid = "dashboard_recent_comments";
    if (isset($wpstradmin[$element][$widgetid]) && $wpstradmin[$element][$widgetid] != "1") {
        remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
    }

    $widgetid = "dashboard_right_now";
    if (isset($wpstradmin[$element][$widgetid]) && $wpstradmin[$element][$widgetid] != "1") {
        remove_meta_box('dashboard_right_now', 'dashboard', 'normal');
    }

    $widgetid = "dashboard_activity";
    if (isset($wpstradmin[$element][$widgetid]) && $wpstradmin[$element][$widgetid] != "1") {
        remove_meta_box('dashboard_activity', 'dashboard', 'normal'); //since 3.8
    }

    $widgetid = "dashboard_incoming_links";
    if (isset($wpstradmin[$element][$widgetid]) && $wpstradmin[$element][$widgetid] != "1") {
        remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
    }

    $widgetid = "dashboard_plugins";
    if (isset($wpstradmin[$element][$widgetid]) && $wpstradmin[$element][$widgetid] != "1") {
        remove_meta_box('dashboard_plugins', 'dashboard', 'normal');
    }

    $widgetid = "dashboard_secondary";
    if (isset($wpstradmin[$element][$widgetid]) && $wpstradmin[$element][$widgetid] != "1") {
        remove_meta_box('dashboard_secondary', 'dashboard', 'normal');
    }
}



function wpstr_dashboard_widget_color()
{

    global $wpstradmin;
    $wpstradmin = wpstradmin_network($wpstradmin);
    $csstype = wpstr_dynamic_css_type();

    $blue_colors = array();
    $blue_colors[0] = "#988ee0";
    $blue_colors[1] = "#8ed4e0";
    $blue_colors[2] = "#e0a98e";
    $blue_colors[3] = "#8ee0d2";
    $blue_colors[4] = "#8ee0b3";
    $blue_colors[5] = "#e0d28e";

    $red_colors = array();
    $red_colors[0] = "#E57373";
    $red_colors[1] = "#FFD54F";
    $red_colors[2] = "#F06292"; //A1887F
    $red_colors[3] = "#FFB74D";
    $red_colors[4] = "#FF8A65";
    $red_colors[5] = "#FFF176";

    $green_colors = array();
    $green_colors[0] = "#81C784";
    $green_colors[1] = "#DCE775";
    $green_colors[2] = "#AED581";
    $green_colors[3] = "#9CCC65";
    $green_colors[4] = "#00E676";
    $green_colors[5] = "#C0CA33";


    $bluethemes = array(
        'color1', 'color3', 'color4', 'color5', 'color6', 'color7', 'color8',
        'color10', 'color11', 'color12', 'color13', 'color16', 'color17', 'color18', 'color20',
        'color21', 'color25', 'color28', 'color29', 'color30', 'color32', 'color33', 'color37',
        'color39', 'color40', 'color41', 'color42', 'color43', 'color44', 'color46', 'color47', 'color48',
        'color49', 'color51', 'color52', 'color53', 'color54', 'color56', 'color57', 'color58', 'color59',
        'color60', 'color61', 'color62', 'color63', 'color64', 'color66', 'color67', 'color68',
        'color70', 'color71', 'color72', 'color78', 'color81', 'color85', 'color87',
        'color90', 'color93', 'color97', 'color99'
    );

    $redthemes = array(
        'color2', 'color14', 'color15', 'color22', 'color23', 'color24', 'color26', 'color27', 'color34',
        'color35', 'color36', 'color38', 'color50', 'color65', 'color69', 'color74', 'color75', 'color76', 'color77',
        'color79', 'color80', 'color82', 'color83', 'color84', 'color86', 'color88', 'color89',
        'color91', 'color92', 'color94', 'color95', 'color96', 'color98', 'color100'
    );

    $greenthemes = array('color9', 'color19', 'color31', 'color45', 'color55', 'color73');

    $getcolor = array();
    if ($csstype == "custom" && isset($wpstradmin['dashboard-widget-colors']) && $wpstradmin['dashboard-widget-colors'] != "") {
        //$getcolor = $wpstradmin['dashboard-widget-colors'];

        $getcolorexp = explode(",", $wpstradmin['dashboard-widget-colors']);

        if (sizeof($getcolorexp) >= 5) {
            $getcolor = $getcolorexp;
        }

        // print_r($getcolor);

    } else {
        if (in_array($csstype, $bluethemes)) {
            $getcolor = $blue_colors;
        } else if (in_array($csstype, $redthemes)) {
            $getcolor = $red_colors;
        } else if (in_array($csstype, $greenthemes)) {
            $getcolor = $green_colors;
        } else {
            $getcolor = $blue_colors;
        }
    }

    return $getcolor;
}

/** remove reduk menu under the tools **/
add_action('admin_menu', 'wpstr_remove_reduk_menu', 12);
function wpstr_remove_reduk_menu()
{
    remove_submenu_page('tools.php', 'reduk-about');
}

function wpstr_removeDemoModeLink()
{ // Be sure to rename this function to something more unique
    if (class_exists('RedukFrameworkPlugin')) {
        remove_filter('plugin_row_meta', array(RedukFrameworkPlugin::get_instance(), 'plugin_metalinks'), null, 2);
    }
    if (class_exists('RedukFrameworkPlugin')) {
        remove_action('admin_notices', array(RedukFrameworkPlugin::get_instance(), 'admin_notices'));
    }
}
add_action('init', 'wpstr_removeDemoModeLink');




add_filter('admin_title', 'wpstr_admin_title', 10, 2);

function wpstr_admin_title($admin_title, $title)
{
    return get_bloginfo('name') . ' &bull; ' . $title;
}


function wpstr_email_settings()
{
    global $wpstradmin;
    $wpstradmin = wpstradmin_network($wpstradmin);

    if (isset($wpstradmin['from-mail-email']) && trim($wpstradmin['from-mail-email']) != "") {
        // wp_mail_from
        add_filter('wp_mail_from', 'wpstr_from_mail');
    }

    if (isset($wpstradmin['from-mail-name']) && trim($wpstradmin['from-mail-name']) != "") {
        // wp_mail_from_name
        add_filter('wp_mail_from_name', 'wpstr_from_mail_name');
    }
}

function wpstr_from_mail($original_email_address)
{

    global $wpstradmin;
    $wpstradmin = wpstradmin_network($wpstradmin);
    $ret = $wpstradmin['from-mail-email'];
    // $ret = "info@domain.com";
    return $ret;
}

function wpstr_from_mail_name($original_email_address_name)
{
    global $wpstradmin;
    $wpstradmin = wpstradmin_network($wpstradmin);
    $ret = $wpstradmin['from-mail-name'];
    //  $ret = "info";
    return $ret;
}


// add_action('admin_footer', 'wpstr_custom_dashboard_widget');
function wpstr_custom_dashboard_widget()
{

    // Bail if not viewing the main dashboard page
    if (get_current_screen()->base !== 'dashboard') {
        return;
    }

    $id = "custom_full_widget";

    echo "<div id='custom-id'>"; ?>
    
    <div id="<?php echo $id; ?>" class="postbox ">
        <div class="postbox-header">
            <h2 class="hndle ui-sortable-handle">Full Widget</h2>
        </div>
        <div class="inside">
            hi
        </div>
    </div>
    
    <?php    
    echo "</div>
    <script>
    jQuery(document).ready(function($) {
        $('#welcome-panel').after($('#custom-id').show());
    });
    </script>";
}



?>