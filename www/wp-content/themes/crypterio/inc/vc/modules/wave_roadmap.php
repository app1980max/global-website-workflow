<?php

add_action('init', 'crypterio_moduleVC_wave_roadmap');

function crypterio_moduleVC_wave_roadmap()
{
	vc_map(array(
		'name'        => esc_html__('Wave Roadmap', 'crypterio'),
		'base'        => 'stm_wave_roadmap',
		'icon'        => 'stm_wave_roadmap',
		'category'    => array(
			esc_html__('Content', 'crypterio'),
		),
		'params'      => array(
            array(
                'type'       => 'colorpicker',
                'heading'    => esc_html__('Text color', 'crypterio'),
                'param_name' => 'text_color'
            ),
            array(
                'type'       => 'colorpicker',
                'heading'    => esc_html__('Wave color start', 'crypterio'),
                'param_name' => 'wave_color_start'
            ),
            array(
                'type'       => 'colorpicker',
                'heading'    => esc_html__('Wave color end', 'crypterio'),
                'param_name' => 'wave_color_end'
            ),
            array(
                'type'       => 'checkbox',
                'heading'    => esc_html__('Add shadow to the wave', 'crypterio'),
                'param_name' => 'stm_wave'
            ),
			array(
				'type'       => 'param_group',
				'heading'    => esc_html__('Token Structure', 'crypterio'),
				'param_name' => 'roadmap',
				'value'      => urlencode(json_encode(array(
					array(
						'label' => esc_html__('Date', 'crypterio'),
						'admin_label' => 'true'
					),
					array(
						'label' => esc_html__('Description', 'crypterio'),
					),
					array(
						'label' => esc_html__('Is done', 'crypterio'),
					),
				))),
				'params'     => array(
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__('Date', 'crypterio'),
						'param_name' => 'date'
					),
					array(
						'type'       => 'textfield',
						'heading'    => esc_html__('Description', 'crypterio'),
						'param_name' => 'description'
					),
					array(
						'type'       => 'dropdown',
						'heading'    => esc_html__('Is done', 'crypterio'),
						'param_name' => 'done',
						'value'      => array(
							__('Not yet', 'crypterio')    => 'not',
							__('Yes', 'crypterio') => 'yes',
						),
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
	class WPBakeryShortCode_Stm_Wave_Roadmap extends WPBakeryShortCode
	{
	}
}