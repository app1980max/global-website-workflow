<?php

add_action('init', 'crypterio_moduleVC_services_grid');

function crypterio_moduleVC_services_grid()
{
	vc_map(array(
		'name'   => esc_html__('Services Grid', 'crypterio'),
		'base'   => 'stm_services_grid',
		'icon'   => 'stm_services_grid',
		'description' => esc_html__('Services Grid', 'crypterio'),
		'category' =>array(
			esc_html__('Content', 'crypterio'),
		),
		'params' => array(
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__('Number of posts', 'crypterio'),
				'param_name' => 'number',
			),
			vc_map_add_css_animation(),
			array(
				'type'       => 'css_editor',
				'heading'    => esc_html__('Css', 'crypterio'),
				'param_name' => 'css',
				'group'      => esc_html__('Design options', 'crypterio')
			)
		)
	));
}

if (class_exists('WPBakeryShortCode')) {
	class WPBakeryShortCode_Stm_Services_Grid extends WPBakeryShortCode
	{
	}
}