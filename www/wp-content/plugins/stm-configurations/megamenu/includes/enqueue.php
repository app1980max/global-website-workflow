<?php
function stm_megamenu_front_scripts_method() {
    $base_url = STM_CONFIGURATIONS_URL;
    $front_css = $base_url . 'megamenu/assets/css/';
    $front_js = $base_url . 'megamenu/assets/js/';
    wp_enqueue_style( 'stm_megamenu', $front_css . 'megamenu.css', array(), '1.4' );
    wp_enqueue_script( 'stm_megamenu', $front_js . 'megamenu.js', array( 'jquery' ), '1.4' );
}
add_action( 'wp_enqueue_scripts', 'stm_megamenu_front_scripts_method' );