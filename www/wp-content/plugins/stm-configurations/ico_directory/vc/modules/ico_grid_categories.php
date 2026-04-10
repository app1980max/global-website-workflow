<?php

add_action('init', 'crypterio_moduleVC_ico_grid_categories');

function crypterio_moduleVC_ico_grid_categories()
{
	vc_map(array(
		'name'        => esc_html__('ICO Grid Categories', 'crypterio'),
		'base'        => 'stm_ico_grid_categories',
		'icon'        => 'stm_ico_grid_categories',
		'description' => esc_html__('ICO Grid Categories', 'crypterio'),
		'category'    => array(
			esc_html__('Content', 'crypterio'),
		),
		'html_template' => STM_CONFIGURATIONS_PATH . '/ico_directory/vc_templates/stm_ico_grid_categories.php',
		'params'      => array(
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
	class WPBakeryShortCode_Stm_Ico_Grid_Categories extends WPBakeryShortCode
	{
	}
}