<?php

add_action('init', 'crypterio_moduleVC_panel_box');

function crypterio_moduleVC_panel_box()
{
	vc_map(array(
		'name'        => esc_html__('Panel Box', 'crypterio'),
		'base'        => 'stm_panel_box',
		'icon'        => 'stm_panel_box',
		'description' => esc_html__('Panel Box', 'crypterio'),
		'category'    => array(
			esc_html__('Content', 'crypterio'),
		),
		'params'      => array(
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__('Panel Title', 'crypterio'),
				'param_name' => 'title',
				'value'      => '',
				'holder'     => 'div'
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__('Panel Subtitle', 'crypterio'),
				'param_name' => 'subtitle',
				'value'      => '',
				'holder'     => 'div'
			),
			array(
				'type'       => 'textarea_html',
				'heading'    => esc_html__('Panel Subtitle', 'crypterio'),
				'param_name' => 'content',
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__('Start Color', 'crypterio'),
				'param_name' => 'start_color',
			),
			array(
				'type'       => 'colorpicker',
				'heading'    => esc_html__('End Color', 'crypterio'),
				'param_name' => 'end_color',
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
	class WPBakeryShortCode_Stm_Panel_Box extends WPBakeryShortCode
	{
	}
}