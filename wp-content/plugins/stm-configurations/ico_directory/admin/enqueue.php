<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function stm_listings_admin_enqueue($hook)
{
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker');

    wp_enqueue_style('stm-listings-datetimepicker', STM_LISTINGS_URL . '/assets/css/jquery.stmdatetimepicker.css', null, null, 'all');
    wp_enqueue_script('stm-listings-datetimepicker', STM_LISTINGS_URL . '/assets/js/jquery.stmdatetimepicker.js', array('jquery'), null, true);

    wp_enqueue_media();

    wp_enqueue_style('stm_listings_listing_css', STM_LISTINGS_URL . '/assets/css/style.css');
}

add_action('admin_enqueue_scripts', 'stm_listings_admin_enqueue');