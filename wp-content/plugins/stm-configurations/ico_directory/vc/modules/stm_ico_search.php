<?php

add_action('init', 'stm_ico_listing_stm_ico_search');

function stm_ico_listing_stm_ico_search()
{
	vc_map(array(
		'name'   => esc_html__('ICO Listing Search', 'stm-configurations'),
		'base'   => 'stm_ico_search',
		'icon'   => 'stm_ico_search',
		'description' => esc_html__('ICO Listing Search Bar', 'stm-configurations'),
		'category' =>array(
			esc_html__('Content', 'stm-configurations'),
		),
		'html_template' => STM_CONFIGURATIONS_PATH . '/ico_directory/vc_templates/stm_ico_search.php',
		'params' => array(
			vc_map_add_css_animation(),
			array(
				'type'       => 'css_editor',
				'heading'    => esc_html__('Css', 'stm-configurations'),
				'param_name' => 'css',
				'group'      => esc_html__('Design options', 'stm-configurations')
			)
		)
	));
}

if (class_exists('WPBakeryShortCode')) {
	class WPBakeryShortCode_Stm_Ico_Search extends WPBakeryShortCode
	{
	}
}