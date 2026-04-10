<?php

add_action('init', 'crypterio_moduleVC_timeline_white');

function crypterio_moduleVC_timeline_white()
{
    vc_map(array(
        'name'        => esc_html__('Timeline White', 'crypterio'),
        'base'        => 'stm_timeline_white',
        'icon'        => 'stm_timeline_white',
        'category'    => array(
            esc_html__('Content', 'crypterio'),
        ),
        'params'      => array(
            array(
                'type'       => 'param_group',
                'heading'    => esc_html__('Timeline', 'crypterio'),
                'param_name' => 'timeline',
                'value'      => urlencode(json_encode(array(
                    array(
                        'label' => esc_html__('Month', 'crypterio'),
                    ),
                    array(
                        'label' => esc_html__('Year', 'crypterio'),
                    ),
                    array(
                        'label' => esc_html__('Content', 'crypterio'),
                    ),
                    array(
                        'label' => esc_html__('Select time', 'crypterio'),
                    ),
                ))),
                'params'     => array(
                    array(
                        'type'       => 'textfield',
                        'heading'    => esc_html__('Month', 'crypterio'),
                        'param_name' => 'month'
                    ),
                    array(
                        'type'       => 'textfield',
                        'heading'    => esc_html__('Year', 'crypterio'),
                        'param_name' => 'year'
                    ),
                    array(
                        'type'       => 'textarea',
                        'heading'    => esc_html__('Content', 'crypterio'),
                        'param_name' => 'timeline_content'
                    ),
                    array(
                        'type'       => 'dropdown',
                        'heading'    => esc_html__('Select time', 'crypterio'),
                        'param_name' => 'time',
                        'value' => array(
	                        esc_html__('Past', 'crypterio') => 'past',
	                        esc_html__('Present', 'crypterio')  => 'present',
	                        esc_html__('Upcoming', 'crypterio')  => 'upcoming',
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
    class WPBakeryShortCode_Stm_Timeline_White extends WPBakeryShortCode
    {
    }
}