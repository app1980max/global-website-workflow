<?php

add_action('init', 'crypterio_moduleVC_ico_grid');

function crypterio_moduleVC_ico_grid()
{
	vc_map(array(
		'name'        => esc_html__('ICO Grid', 'crypterio'),
		'base'        => 'stm_ico_grid',
		'icon'        => 'stm_ico_grid',
		'description' => esc_html__('ICO Grid view', 'crypterio'),
		'category'    => array(
			esc_html__('Content', 'crypterio'),
		),
		'html_template' => STM_CONFIGURATIONS_PATH . '/ico_directory/vc_templates/stm_ico_grid.php',
		'params'      => array(
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__('Title', 'crypterio'),
				'param_name'  => 'title',
				'holder'  => 'div',
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__('Number of ICO to show', 'crypterio'),
				'param_name'  => 'number',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__('Show Only:', 'crypterio'),
				'param_name' => 'style',
				'value'      => array(
					__('Active', 'crypterio')   => 'live',
					__('Upcoming', 'crypterio') => 'upcoming',
					__('Ended', 'crypterio')    => 'finished',
				),
				'std'        => 'live',
			),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__('Show Date or Logo:', 'crypterio'),
				'param_name' => 'date_or_logo',
				'value'      => array(
					__('Date', 'crypterio')   => 'date',
					__('Logo', 'crypterio') => 'logo',
				),
				'std'        => 'date',
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
	class WPBakeryShortCode_Stm_Ico_Grid extends WPBakeryShortCode
	{
	}
}