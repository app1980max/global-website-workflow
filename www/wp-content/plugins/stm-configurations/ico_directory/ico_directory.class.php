<?php

class STM_Ico_Listing
{

	public $save_option = 'stm_icos';

	function __construct()
	{
		add_action('wp_ajax_stm_ico_search', array($this, 'stm_ico_search'));
		add_action('wp_ajax_nopriv_stm_ico_search', array($this, 'stm_ico_search'));
	}

	function ico_listing_args($args = array())
	{
		$per_page = 1;

		$default = array(
			'post_type'      => stm_ico_directory_get_post_type(),
			'post_status'    => array('publish', 'pending', 'trash'),
			'posts_per_page' => $per_page,
		);

		$args = wp_parse_args($args, $default);

		return $args;
	}

	function stm_ico_search()
	{
	    check_ajax_referer('stm_ico_search', 'security');
		$posts = [];

		$s = (!empty($_GET['search_ico'])) ? sanitize_text_field($_GET['search_ico']) : '';
		$args = $this->ico_listing_args(
			array(
				's' => $s
			)
		);

		$q = new WP_Query($args);
		if($q->have_posts()) {
			while($q->have_posts()) { $q->the_post();

				$posts[] = array(
					'url' => get_the_permalink(),
					'title' => get_the_title()
				);

			}
		}

		wp_send_json($posts);
	}
}

new STM_Ico_Listing();