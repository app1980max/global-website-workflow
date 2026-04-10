<?php

class STM_White_List
{
	function __construct()
	{
		add_action('admin_menu', array($this, 'crypterio_register_white_list_page'));
		add_action('admin_enqueue_scripts', array($this, 'crypterio_register_white_list_ss'));
		add_action('wp_ajax_stm_wl', array($this, 'stm_wl'));
		add_action('wp_ajax_stm_wl_sorted', array($this, 'stm_wl_sorted'));
		add_action('wp_ajax_stm_wl_change_status', array($this, 'stm_wl_change_status'));
		add_action('transition_post_status', array($this, 'admin_status_changed'), 10, 3);
		add_action('wp_ajax_stm_wl_change_status', array($this, 'stm_wl_change_status'));
		add_filter('wp_mail_content_type', array($this, 'mail_content_type'));

		if (!empty($_GET['stm_export_wl'])) {
			add_action('admin_init', array($this, 'stm_wl_export'));
		}
	}

	function mail_content_type()
	{
		return "text/html";
	}

	function admin_status_changed($new_status, $old_status, $post)
	{
		if ($new_status === 'publish') {
			$this->notify_user($post);
		}
	}

	function notify_user($post)
	{
		$meta = $this->user_meta_data($post->ID);
		$to = $meta['email'];
		$subject = esc_html__('ICO Participation', 'crypterio');
		$body = sprintf(
			__('Hi! <br/> %s, your request to buy %s tokens has been approved. Please use your %s wallet for the purchase. <br/> We will send the contract address close to the token sale date.', 'crypterio'),
			$meta['first_name'] . ' ' . $meta['last_name'],
			$meta['amount'],
			$meta['wallet']
		);

		wp_mail($to, $subject, $body);
	}

	function stm_wl_export()
	{
		$data = $this->generate_wl(array('posts_per_page' => -1, 'post_status' => 'publish'));
		$this->download_send_headers("data_export_" . date("Y-m-d") . ".csv");
		echo crypterio_sanitize_text_field($this->array2csv($data['posts']));
		die();
	}

	function crypterio_register_white_list_page()
	{
		add_submenu_page(
			'edit.php?post_type=stm_white_list',
			__('White list requests', 'crypterio'),
			__('White list requests', 'crypterio'),
			'manage_options',
			'crypterio-white-list',
			array($this, 'crypterio_white_list_page')
		);
	}

	function crypterio_white_list_page()
	{
		require_once STM_CONFIGURATIONS_PATH . '/white_list/templates/list.php';
		require_once STM_CONFIGURATIONS_PATH . '/white_list/templates/i18n.php';

		get_template_part('inc/admin/white_list/templates/list');
		get_template_part('inc/admin/white_list/templates/i18n');

		$this->user_meta_data();
	}

	function crypterio_register_white_list_ss()
	{
		$theme_info = STM_CONFIGURATIONS_THEME_VERSION;
		$assets = STM_CONFIGURATIONS_URL . 'announcement/assets/';
		$assets_wl = STM_CONFIGURATIONS_URL . 'white_list/assets/';
		wp_enqueue_style('milligram.css', $assets_wl . 'milligram.min.css', null, $theme_info, 'all');
		wp_enqueue_style('stm_white_list', $assets_wl . 'style.css', null, $theme_info, 'all');
		wp_enqueue_script('vue.js', $assets . 'vue.min.js', null, $theme_info, true);
		wp_enqueue_script('vue-resource.js', $assets . 'vue-resource.js', array('vue.js'), $theme_info, true);
		wp_enqueue_script('wl-vue.js', $assets_wl . 'wl_vue.js', array('vue.js'), $theme_info, true);
	}

	function user_meta_data($post_id = 0)
	{
		$data = crypterio_white_list_data();
		$user_data = [];
		foreach ($data as $key => $value) {

			$data_value = get_post_meta($post_id, $key, true);

			if ($value['type'] == 'file') {
				$data_value = wp_get_attachment_image_url($data_value, 'full');
			}
			$user_data[$key] = $data_value;
		}

		return $user_data;
	}

	function post_status($post_id)
	{
		$status = get_post_status($post_id);
		switch ($status) {
			case 'trash':
				$post_status = esc_html__('Declined', 'crypterio');
				break;
			case 'publish':
				$post_status = esc_html__('Approved', 'crypterio');
				break;
			default :
				$post_status = esc_html__('Pending', 'crypterio');
		}

		return $post_status;
	}

	function generate_wl($args = array())
	{

		$per_page = 30;

		$r = array(
			'posts' => [],
			'total' => 0
		);

		$default = array(
			'post_type'      => 'stm_white_list',
			'post_status'    => array('publish', 'pending', 'trash'),
			'posts_per_page' => $per_page,
		);

		if (empty($args)) {
			$args = $this->stm_wl_sorted($per_page);
		}

		$args = wp_parse_args($args, $default);
		$posts = array();

		$q = new WP_Query($args);
		if ($q->have_posts()) {
			while ($q->have_posts()) {
				$q->the_post();
				$post_id = get_the_ID();

				$data = array(
					'ID'     => $post_id,
					'title'  => get_the_title(),
					'edit_url'  => admin_url("post.php?post={$post_id}&action=edit"),
					'status' => $this->post_status($post_id)
				);

				$posts[] = array_merge($data, $this->user_meta_data($post_id));
			}
		}

		$r['posts'] = $posts;
		$r['total'] = $q->found_posts;
		$r['per_page'] = $per_page;

		wp_reset_postdata();

		return $r;
	}

	function stm_wl()
	{
	    check_ajax_referer('stm_wl', 'security');
		wp_send_json($this->generate_wl());
	}

	function stm_wl_sorted($per_page)
	{
		$args = array();

		if (!empty($_GET['status'])) {
			$args['post_status'] = sanitize_text_field($_GET['status']);
		}

		if (!empty($_GET['page'])) {
			$args['offset'] = ($per_page * intval($_GET['page'])) - $per_page;
		}

		return $args;
	}

	function stm_wl_change_status()
	{
		$post = array(
			'ID'          => intval($_GET['post_id']),
			'post_status' => sanitize_text_field($_GET['status'])
		);

		$post['r'] = wp_update_post($post);
		$post['status'] = $this->post_status($post['ID']);

		wp_send_json($post);
	}

	function array2csv(array &$array)
	{
		if (count($array) == 0) {
			return null;
		}
		ob_start();
		$df = fopen("php://output", 'w');
		fputcsv($df, array_keys(reset($array)));
		foreach ($array as $row) {
			fputcsv($df, $row);
		}
		fclose($df);
		return ob_get_clean();
	}

	function download_send_headers($filename)
	{
		// disable caching
		$now = gmdate("D, d M Y H:i:s");
		header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
		header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
		header("Last-Modified: {$now} GMT");

		// force download
		header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");

		// disposition / encoding on response body
		header("Content-Disposition: attachment;filename={$filename}");
		header("Content-Transfer-Encoding: binary");
	}

}

new STM_White_List();