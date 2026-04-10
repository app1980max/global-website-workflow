<?php

add_action('init', 'crypterio_moduleVC_ratings');

function crypterio_moduleVC_ratings()
{
	vc_map(array(
		'name'        => esc_html__('Ratings', 'crypterio'),
		'base'        => 'stm_ratings',
		'icon'        => 'stm_ratings',
		'description' => esc_html__('Text Rating', 'crypterio'),
		'category'    => array(
			esc_html__('Content', 'crypterio'),
		),
		'params'      => array(
            array(
                'type'       => 'dropdown',
                'heading'    => esc_html__('Style', 'crypterio'),
                'param_name' => 'style',
                'value'      => array(
                    esc_html__('Style 1', 'crypterio') => 'style_1',
                    esc_html__('Style 2', 'crypterio') => 'style_2'
                ),
                'std' => 'style_1'
            ),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__('Mark', 'crypterio'),
				'param_name' => 'mark',
				'value'      => '',
				'holder'     => 'div',
				'dependency' => array(
                    'element' => 'style',
                    'value'   => 'style_1',
                )
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__('Rating', 'crypterio'),
				'param_name' => 'rating',
				'value'      => '',
				'holder'     => 'div',
				'description' => esc_html__('Nubmer format, max 5 (example: 4.7)', 'crypterio'),
				'dependency' => array(
                    'element' => 'style',
                    'value'   => 'style_2',
                )
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__('Label', 'crypterio'),
				'param_name' => 'label',
				'value'      => '',
				'holder'     => 'div',
				'dependency' => array(
                    'element' => 'style',
                    'value'   => 'style_2',
                )
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__('Max', 'crypterio'),
				'param_name' => 'max',
				'value'      => '',
				'holder'     => 'div',
				'dependency' => array(
                    'element' => 'style',
                    'value'   => 'style_1',
                )
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__('Title', 'crypterio'),
				'param_name' => 'title',
				'value'      => '',
				'holder'     => 'div'
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
	class WPBakeryShortCode_Stm_Ratings extends WPBakeryShortCode
	{
	}
}