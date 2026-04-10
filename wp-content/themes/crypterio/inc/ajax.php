<?php
add_action('wp_ajax_crypterio_load_stm_news_list', 'crypterio_load_stm_news_list');
add_action('wp_ajax_nopriv_crypterio_load_stm_news_list', 'crypterio_load_stm_news_list');

function crypterio_load_stm_news_list() {
    check_ajax_referer('crypterio_load_stm_news_list', 'security');
	$r = array();
	ob_start();
	get_template_part('vc_templates/stm_news_list');
	$r['content'] = ob_get_clean();
	wp_send_json($r);
}