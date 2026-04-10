<?php

add_action( 'init', 'crypterio_moduleVC_nft_featured' );

function crypterio_moduleVC_nft_featured() {
	vc_map(
		array(
			'name'     => esc_html__( 'NFT Featured Card', 'crypterio' ),
			'base'     => 'stm_nft_featured',
			'icon'     => 'stm_post_slider',
			'category' => array(
				esc_html__( 'STM', 'crypterio' ),
			),
			'params'   => array(
				array(
					'type'       => 'attach_image',
					'heading'    => esc_html__( 'Image', 'crypterio' ),
					'param_name' => 'image',
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Title', 'crypterio' ),
					'param_name' => 'title',
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Price', 'crypterio' ),
					'param_name' => 'price',
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Crypto Price', 'crypterio' ),
					'param_name' => 'crypto_price',
				),
				array(
					'type'       => 'iconpicker',
					'heading'    => esc_html__( 'Crypto Price Icon', 'crypterio' ),
					'param_name' => 'crypto_price_icon',
					'value'      => '',
					'weight'     => 1,
				),
				array(
					'type'       => 'stm_countdown_vc',
					'heading'    => esc_html__( 'Countdown', 'crypterio' ),
					'param_name' => 'countdown',
					'holder'     => 'div',
				),
				array(
					'type'       => 'dropdown',
					'heading'    => esc_html__( 'Position inside column', 'crypterio' ),
					'param_name' => 'position',
					'value'      => array(
						esc_html__( 'Left', 'crypterio' )  => 'nft_featured_position_left',
						esc_html__( 'Center', 'crypterio' ) => 'nft_featured_position_center',
						esc_html__( 'Right', 'crypterio' ) => 'nft_featured_position_right',
					),
				),
				array(
					'type'        => 'checkbox',
					'heading'     => esc_html__( 'Show live auction badge?', 'crypterio' ),
					'param_name'  => 'badge',
					'description' => esc_html__( 'If checked, live auction badge will be shown.', 'crypterio' ),
					'value'       => array( esc_html__( 'Yes', 'crypterio' ) => 'yes' ),
					'std'         => 'yes',
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Button link', 'crypterio' ),
					'param_name' => 'button_link',
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Button text', 'crypterio' ),
					'param_name' => 'button_text',
				),
				vc_map_add_css_animation(),
				array(
					'type'       => 'css_editor',
					'heading'    => esc_html__( 'Css', 'crypterio' ),
					'param_name' => 'css',
					'group'      => esc_html__( 'Design options', 'crypterio' ),
				),
			),
		)
	);
}

if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_Stm_Nft_Featured extends WPBakeryShortCode {
	}
}
