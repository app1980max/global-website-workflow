<?php

add_action( 'init', 'crypterio_moduleVC_nft_packs_carousel' );

function crypterio_moduleVC_nft_packs_carousel() {
	vc_map(
		array(
			'name'     => esc_html__( 'NFT Packs Carousel', 'crypterio' ),
			'base'     => 'stm_nft_packs_carousel',
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
					'type'       => 'checkbox',
					'heading'    => esc_html__( 'Hide Carousel Arrows', 'crypterio' ),
					'param_name' => 'hide_arrows',
					'value'      => array( esc_html__( 'Yes', 'crypterio' ) => 'yes' ),
					'std'        => 'no',
				),
				array(
					'type'       => 'checkbox',
					'heading'    => esc_html__( 'Carousel autoplay', 'crypterio' ),
					'param_name' => 'autoplay',
					'value'      => array( esc_html__( 'Yes', 'crypterio' ) => 'true' ),
					'std'        => 'false',
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
	class WPBakeryShortCode_Stm_NFT_Packs_Carousel extends WPBakeryShortCode {
	}
}
