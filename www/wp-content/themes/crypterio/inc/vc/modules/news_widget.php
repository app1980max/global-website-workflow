<?php

add_action('init', 'crypterio_moduleVC_news_widget');

function crypterio_moduleVC_news_widget()
{
	vc_map(array(
		'name'        => esc_html__('Crypterio News Widget', 'crypterio'),
		'base'        => 'stm_news_widget',
		'icon'        => 'stm_news_widget',
		'description' => esc_html__('News Widget', 'crypterio'),
		'category'    => array(
			esc_html__('Content', 'crypterio'),
		),
		'params'      => array(
			array(
				'type'       => 'loop',
				'heading'    => esc_html__('Query', 'crypterio'),
				'param_name' => 'loop',
				'value'      => 'size:3|post_type:post',
				'settings'   => array(
					'size' => array('hidden' => false, 'value' => 4)
				),
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__('Query offset', 'crypterio'),
				'param_name' => 'offset',
				'value'      => '',
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__('Title', 'crypterio'),
				'param_name' => 'title',
				'value'      => '',
				'holder'     => 'div'
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__('Sort by:', 'crypterio'),
				'param_name' => 'popular',
				'value'      => array(
					__('Date', 'crypterio')    => '',
					__('Popular', 'crypterio') => 'popular',
				),
				'std'        => '',
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
	class WPBakeryShortCode_Stm_News_Widget extends WPBakeryShortCode
	{
	}
}