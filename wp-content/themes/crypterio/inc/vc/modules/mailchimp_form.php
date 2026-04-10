<?php

add_action('init', 'crypterio_moduleVC_mailchimp_form');

function crypterio_moduleVC_mailchimp_form()
{
    vc_map(array(
        'name'        => esc_html__('Mailchimp form', 'crypterio'),
        'base'        => 'mailchimp_form',
        'icon'        => 'mailchimp_form',
        'category'    => array(
            esc_html__('Content', 'crypterio'),
        ),
        'params'   => array(
            array(
                'type'        => 'textfield',
                'heading'     => esc_html__('Title', 'crypterio'),
                'param_name'  => 'form_title'
            ),
            array(
                'type'        => 'textfield',
                'heading'     => esc_html__('Subtitle', 'crypterio'),
                'param_name'  => 'form_subtitle'
            ),
            array(
                'type'       => 'iconpicker',
                'heading'    => esc_html__('Icon', 'crypterio'),
                'param_name' => 'icon',
                'value'      => '',
                'weight'     => 1
            ),
        )
    ));
}

if (class_exists('WPBakeryShortCode')) {
    class WPBakeryShortCode_Mailchimp_Form extends WPBakeryShortCode
    {
    }
}