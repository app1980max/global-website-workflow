<?php

add_action('init', 'crypterio_moduleVC_cryptoticker');

function crypterio_moduleVC_cryptoticker()
{
	vc_map(array(
		'name'   => esc_html__('Crypterio Ticker', 'crypterio'),
		'base'   => 'stm_cryptoticker',
		'icon'   => 'stm_cryptoticker',
		'description' => esc_html__('Crypto Ticker', 'crypterio'),
		'category' =>array(
			esc_html__('Content', 'crypterio'),
		),
		'params' => array(
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
	class WPBakeryShortCode_Stm_Cryptoticker extends WPBakeryShortCode
	{
	}
}