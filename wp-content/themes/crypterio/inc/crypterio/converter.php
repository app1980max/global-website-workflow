<?php

if ( function_exists( 'vc_map' ) ) {
	vc_map(
		array(
			'name'     => esc_html__( 'Cryptocurrency converter', 'crypterio' ),
			'base'     => 'stm_crypto_converter',
			'category' => esc_html__('STM' , 'crypterio' ),
			'params'   => array(
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__('Title', 'crypterio'),
					'param_name' => 'title',
					'admin_label' => true
				),
				array(
					"type" => "colorpicker",
					"class" => "",
					"heading" => esc_html__( "Bacgkround color", "crypterio" ),
					"param_name" => "background_color",
					"value" => '#282a36', 
					"description" => esc_html__( "Widget background color", "crypterio" )
				)
			)
		)
		
	);

	class WPBakeryShortCode_Stm_Crypto_Converter extends WPBakeryShortCode {
	}
}