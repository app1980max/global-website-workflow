<?php

add_action('init', 'crypterio_moduleVC_cryptowidget');

function crypterio_moduleVC_cryptowidget()
{
	vc_map(array(
		'name'   => esc_html__('Crypterio Widget', 'crypterio'),
		'base'   => 'stm_cryptowidget',
		'icon'   => 'stm_cryptowidget',
		'description' => esc_html__('Crypto Widget', 'crypterio'),
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
	class WPBakeryShortCode_Stm_Cryptowidget extends WPBakeryShortCode
	{
	}
}