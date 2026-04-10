<?php
function stm_ico_directory_get_post_type() {
	return apply_filters('stm_ico_directory_get_post_type', 'stm_ico_listing');
}

function stm_ico_directory_get_post_type_link() {
	return apply_filters(
		'stm_ico_directory_get_post_type_link',
		get_post_type_archive_link(stm_ico_directory_get_post_type())
	);
}

function stm_ico_directory_module_styles($style, $dependency = array()) {
	$style_url = STM_CONFIGURATIONS_URL . 'ico_directory/assets/css/' . $style . '.css';
	$v = (defined('WP_DEBUG') && true === WP_DEBUG) ? time() : '1.0';
	wp_enqueue_style($style, $style_url, $dependency, $v);
}

function stm_ico_directory_module_script($script, $dependency = array(), $footer = true) {
	$script_url = STM_CONFIGURATIONS_URL . 'ico_directory/assets/js/' . $script . '.js';
	$v = (defined('WP_DEBUG') && true === WP_DEBUG) ? time() : '1.0';
	wp_enqueue_script($script, $script_url, $dependency, $v, $footer);
}