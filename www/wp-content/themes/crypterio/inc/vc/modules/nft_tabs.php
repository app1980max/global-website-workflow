<?php

add_action( 'init', 'crypterio_moduleVC_nft_tabs' );

function crypterio_moduleVC_nft_tabs() {
	vc_map(
		array(
			'name'     => esc_html__( 'NFT Cards with Tabs', 'crypterio' ),
			'base'     => 'stm_nft_tabs',
			'category' => array(
				esc_html__( 'STM', 'crypterio' ),
			),
			'params'   => array(
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Title', 'crypterio' ),
					'param_name' => 'title',
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Number of posts', 'crypterio' ),
					'param_name' => 'number',
				),
				array(
					'type'       => 'checkbox',
					'heading'    => esc_html__( 'Hide tab All', 'crypterio' ),
					'param_name' => 'hide_all',
					'value'      => array( esc_html__( 'Yes', 'crypterio' ) => 'yes' ),
					'std'        => 'no',
				),
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
	class WPBakeryShortCode_Stm_NFT_Tabs extends WPBakeryShortCode {
	}
}
