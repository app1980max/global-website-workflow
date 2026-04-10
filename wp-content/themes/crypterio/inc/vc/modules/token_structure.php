<?php

add_action('init', 'crypterio_moduleVC_token_structure');

function crypterio_moduleVC_token_structure()
{
	vc_map(array(
		'name'        => esc_html__('Token structure', 'crypterio'),
		'base'        => 'stm_token_structure',
		'icon'        => 'stm_token_structure',
		'category'    => array(
			esc_html__('Content', 'crypterio'),
		),
		'params'      => array(
			array(
				'type'       => 'param_group',
				'heading'    => esc_html__('Token Structure', 'crypterio'),
				'param_name' => 'tokens',
				'value'      => urlencode(json_encode(array(
					array(
						'label' => esc_html__('Value', 'crypterio'),
					),
					array(
						'label' => esc_html__('Label', 'crypterio'),
					),
					array(
						'label' => esc_html__('Color', 'crypterio'),
					),
				))),
				'params'     => array(
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__('Value', 'crypterio'),
						'param_name' => 'value'
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__('Label', 'crypterio'),
						'param_name' => 'label'
					),
					array(
						'type'       => 'colorpicker',
						'heading'    => esc_html__('Color', 'crypterio'),
						'param_name' => 'color'
					),
				)
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
	class WPBakeryShortCode_Stm_Token_Structure extends WPBakeryShortCode
	{
	}
}