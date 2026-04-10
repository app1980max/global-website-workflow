<?php

add_action('init', 'crypterio_moduleVC_news_grid');

function crypterio_moduleVC_news_grid()
{
	vc_map(array(
		'name'   => esc_html__('Crypterio News Grid', 'crypterio'),
		'base'   => 'stm_news_grid',
		'icon'   => 'stm_news_grid',
		'description' => esc_html__('News Grid', 'crypterio'),
		'category' =>array(
			esc_html__('Content', 'crypterio'),
		),
		'params' => array(
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
	class WPBakeryShortCode_Stm_News_Grid extends WPBakeryShortCode
	{
	}
}