<?php

add_action('init', 'crypterio_moduleVC_ico_list');

function crypterio_moduleVC_ico_list()
{
	vc_map(array(
		'name'        => esc_html__('ICO List', 'crypterio'),
		'base'        => 'stm_ico_list',
		'icon'        => 'stm_ico_list',
		'description' => esc_html__('ICO List view', 'crypterio'),
		'category'    => array(
			esc_html__('Content', 'crypterio'),
		),
		'html_template' => STM_CONFIGURATIONS_PATH . '/ico_directory/vc_templates/stm_ico_list.php',
		'params'      => array(
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__('Number of ICO to show', 'crypterio'),
				'param_name'  => 'number',
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
	class WPBakeryShortCode_Stm_Ico_List extends WPBakeryShortCode
	{
	}
}