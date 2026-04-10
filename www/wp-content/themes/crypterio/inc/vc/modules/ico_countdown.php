<?php

add_action('init', 'crypterio_moduleVC_ico_countdown');

function crypterio_moduleVC_ico_countdown()
{
    $currencies = crypterio_get_cmc_data();
    $list = array();
    foreach ($currencies as $currency_key => $currency_val) {
        $list[] = array(
            'label' => $currency_val['name'],
            'value' => $currency_val['name']
        ) ;
    }

	vc_map(array(
		'name'     => esc_html__('ICO Countdown', 'crypterio'),
		'base'     => 'stm_ico_countdown',
		'category' => esc_html__('STM', 'crypterio'),
		'params'   => array(
            array(
                'type'       => 'dropdown',
                'heading'    => esc_html__('Style', 'crypterio'),
                'param_name' => 'style',
                'value'      => array(
                    esc_html__('Style 1', 'crypterio') => 'style_1',
                    esc_html__('Style 2', 'crypterio') => 'style_2',
                    esc_html__('Style 3', 'crypterio') => 'style_3'
                ),
                'std' => 'style_1'
            ),
			array(
				'type'       => 'textarea_html',
				'heading'    => esc_html__('Title', 'crypterio'),
				'param_name' => 'content',
                'dependency' => array(
                    'element' => 'style',
                    'value'   => 'style_2',
                ),
			),
            array(
                'type'       => 'textfield',
                'heading'    => esc_html__('Title', 'crypterio'),
                'param_name' => 'title',
                'dependency' => array(
                    'element' => 'style',
                    'value'   => array('style_1', 'style_3'),
                ),
            ),
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__('Get ICO data automatically from Contract', 'crypterio'),
				'param_name' => 'by_contract',
				'value'      => array(
					esc_html__('Custom', 'crypterio') => 'custom',
					esc_html__('Contract', 'crypterio') => 'contract'
				),
				'std' => 'custom'
			),
            array(
                'type'       => 'textfield',
                'heading'    => esc_html__('ICO Contract address', 'crypterio'),
                'param_name' => 'contract',
                'dependency' => array(
                    'element' => 'by_contract',
                    'value'   => 'contract',
                ),
            ),
            array(
                'type'       => 'textfield',
                'heading'    => esc_html__('Rounding of a number', 'crypterio'),
                'param_name' => 'round',
                'dependency' => array(
                    'element' => 'by_contract',
                    'value'   => 'contract',
                ),
            ),
			array(
				'type'       => 'stm_countdown_vc',
				'heading'    => esc_html__('Count to date', 'crypterio'),
				'param_name' => 'countdown',
				'holder'     => 'div',
			),
			array(
				'type'       => 'stm_countdown_vc',
				'heading'    => esc_html__('Softcap end date', 'crypterio'),
				'param_name' => 'softcap_countdown',
				'holder'     => 'div',
				'dependency' => array(
					'element' => 'by_contract',
					'value'   => 'custom',
				),
			),
			array(
				'type'       => 'attach_image',
				'heading'    => esc_html__('Background Image', 'crypterio'),
				'param_name' => 'ico_bg_image',
                'dependency' => array(
                    'element' => 'style',
                    'value'   => 'style_1',
                ),
			),
            array(
                'type'       => 'textfield',
                'heading'    => esc_html__('Sale price description', 'crypterio'),
                'param_name' => 'price_description',
            ),
			array(
				'type'       => 'vc_link',
				'heading'    => esc_html__('Token Buy Button', 'crypterio'),
				'param_name' => 'link',
			),
			array(
				'type'       => 'vc_link',
				'heading'    => esc_html__('Whitepaper link', 'crypterio'),
				'param_name' => 'wp_link',
				'dependency' => array(
					'element' => 'by_contract',
					'value'   => 'custom',
				),
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__('Sale tokens price (number format)', 'crypterio'),
				'param_name' => 'price_num',
				'dependency' => array(
					'element' => 'by_contract',
					'value'   => 'custom',
				),
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__('Sale tokens price 1', 'crypterio'),
				'param_name' => 'price_1',
				'dependency' => array(
					'element' => 'by_contract',
					'value'   => 'custom',
				),
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__('Sale tokens price label 1', 'crypterio'),
				'param_name' => 'price_label_1',
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__('Sale tokens price 2', 'crypterio'),
				'param_name' => 'price_2',
				'dependency' => array(
					'element' => 'by_contract',
					'value'   => 'custom',
				),
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__('Sale tokens price label 2', 'crypterio'),
				'param_name' => 'price_label_2',
				'dependency' => array(
					'element' => 'by_contract',
					'value'   => 'custom',
				),
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__('Softcap price (number format)', 'crypterio'),
				'param_name' => 'softcap',
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__('Softcap label', 'crypterio'),
				'param_name' => 'softcap_label',
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__('Softcap label 2', 'crypterio'),
				'param_name' => 'softcap_label_2',
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__('Hardcap price (number format)', 'crypterio'),
				'param_name' => 'hardcap',
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__('Hardcap label', 'crypterio'),
				'param_name' => 'hardcap_label',
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__('Hardcap label 2', 'crypterio'),
				'param_name' => 'hardcap_label_2',
			),
			array(
				'type'       => 'attach_images',
				'heading'    => esc_html__('Payments', 'crypterio'),
				'param_name' => 'payments',
                'dependency' => array(
                    'element' => 'style',
                    'value'   => 'style_1',
                ),
			),
            array(
                'type' => 'autocomplete',
                'heading'    => esc_html__( 'Select currency 1', 'crypterio' ),
                'param_name' => 'cur_name',
                'settings' => array(
                    'sortable' => true,
                    'min_length' => 1,
                    'no_hide' => false,
                    'unique_values' => true,
                    'display_inline' => true,
                    'values' => $list
                ),
                'dependency' => array(
                    'element' => 'style',
                    'value'   => 'style_3',
                ),

            ),
            array(
                'type' => 'autocomplete',
                'heading'    => esc_html__( 'Select currency 2', 'crypterio' ),
                'param_name' => 'cur_name_2',
                'settings' => array(
                    'sortable' => true,
                    'min_length' => 1,
                    'no_hide' => false,
                    'unique_values' => true,
                    'display_inline' => true,
                    'values' => $list
                ),
                'dependency' => array(
                    'element' => 'style',
                    'value'   => 'style_3',
                ),
            ),
			array(
				'type'        => 'exploded_textarea_safe',
				'heading'     => esc_html__('Custom links', 'crypterio'),
				'param_name'  => 'custom_links',
				'description' => esc_html__('Enter links for each payment (Note: divide links with linebreaks (Enter)).', 'crypterio'),
				'dependency'  => array(
					'element' => 'onclick',
					'value'   => array('payments'),
				),
			),
			/*Custom Popup*/
			array(
				'type'       => 'dropdown',
				'heading'    => esc_html__('Show popup', 'crypterio'),
				'param_name' => 'show_popup',
				'value'      => array(
					esc_html__('Hide', 'crypterio') => 'hide',
					esc_html__('Show', 'crypterio') => 'show',
				),
				'group'      => esc_html__('Popup', 'crypterio'),
				'std'        => 'hide',
				'dependency' => array(
					'element' => 'by_contract',
					'value'   => 'custom',
				),
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__('Popup Title', 'crypterio'),
				'param_name' => 'popup_title',
				'group'      => esc_html__('Popup', 'crypterio'),
				'dependency' => array(
					'element' => 'show_popup',
					'value'   => array('show'),
				),
			),
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__('Contract address', 'crypterio'),
				'param_name' => 'popup_address',
				'group'      => esc_html__('Popup', 'crypterio'),
				'dependency' => array(
					'element' => 'show_popup',
					'value'   => array('show'),
				),
			),
			array(
				'type'       => 'textarea',
				'heading'    => esc_html__('Popup description', 'crypterio'),
				'param_name' => 'popup_desc',
				'group'      => esc_html__('Popup', 'crypterio'),
				'dependency' => array(
					'element' => 'show_popup',
					'value'   => array('show'),
				),
			),
			array(
				'type'       => 'vc_link',
				'heading'    => esc_html__('Popup link', 'crypterio'),
				'param_name' => 'popup_link',
				'group'      => esc_html__('Popup', 'crypterio'),
				'dependency' => array(
					'element' => 'show_popup',
					'value'   => array('show'),
				),
			),
			/*Whitepaper Popup*/
			array(
				'type'       => 'textfield',
				'heading'    => esc_html__('Popup Title', 'crypterio'),
				'param_name' => 'popup_title_contract',
				'group'      => esc_html__('Popup', 'crypterio'),
				'dependency' => array(
					'element' => 'by_contract',
					'value'   => 'contract',
				),
			),
			array(
				'type'       => 'textarea',
				'heading'    => esc_html__('Popup Subtitle', 'crypterio'),
				'param_name' => 'popup_subtitle',
				'group'      => esc_html__('Popup', 'crypterio'),
				'dependency' => array(
					'element' => 'by_contract',
					'value'   => 'contract',
				),
			),
			array(
				'type'       => 'textarea',
				'heading'    => esc_html__('Expected ETH ICO Participation Amount Description', 'crypterio'),
				'param_name' => 'popup_amount_desc',
				'group'      => esc_html__('Popup', 'crypterio'),
				'dependency' => array(
					'element' => 'by_contract',
					'value'   => 'contract',
				),
			),
			array(
				'type'       => 'textarea',
				'heading'    => esc_html__('Wallet description', 'crypterio'),
				'param_name' => 'popup_wallet_desc',
				'group'      => esc_html__('Popup', 'crypterio'),
				'dependency' => array(
					'element' => 'by_contract',
					'value'   => 'contract',
				),
			),
			array(
				'type'       => 'textarea',
				'heading'    => esc_html__('Passport Photo description', 'crypterio'),
				'param_name' => 'popup_passport_desc',
				'group'      => esc_html__('Popup', 'crypterio'),
				'dependency' => array(
					'element' => 'by_contract',
					'value'   => 'contract',
				),
			),
			array(
				'type'       => 'textarea',
				'heading'    => esc_html__('Agreement text 1', 'crypterio'),
				'param_name' => 'popup_agreement_desc_1',
				'group'      => esc_html__('Popup', 'crypterio'),
				'dependency' => array(
					'element' => 'by_contract',
					'value'   => 'contract',
				),
			),
			array(
				'type'       => 'textarea',
				'heading'    => esc_html__('Agreement text 2', 'crypterio'),
				'param_name' => 'popup_agreement_desc_2',
				'group'      => esc_html__('Popup', 'crypterio'),
				'dependency' => array(
					'element' => 'by_contract',
					'value'   => 'contract',
				),
			),




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
	class WPBakeryShortCode_Stm_Ico_Countdown extends WPBakeryShortCode
	{
	}
}