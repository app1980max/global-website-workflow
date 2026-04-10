<?php
add_action( 'vc_after_init', 'crypterio_moduleVC_icon_links' );

function crypterio_moduleVC_icon_links() {
	vc_map(
		array(
			'name'        => esc_html__( 'Icon links', 'crypterio' ),
			'base'        => 'stm_icon_links',
			'icon'        => 'stmicon-users',
			'category'    => array(
				esc_html__( 'STM', 'crypterio' ),
			),
			'description' => esc_html__( 'Icon with link', 'crypterio' ),
			'params'      => array(
				array(
					'type'       => 'param_group',
					'heading'    => esc_html__( 'Icons', 'crypterio' ),
					'param_name' => 'icons',
					'value'      => rawurlencode(
						wp_json_encode(
							array(
								array(
									'label'       => esc_html__( 'Icon', 'crypterio' ),
									'admin_label' => false,
								),
								array(
									'label'       => esc_html__( 'Icon Link', 'crypterio' ),
									'admin_label' => true,
								),
							)
						)
					),
					'params'     => array(
						array(
							'type'        => 'iconpicker',
							'heading'     => esc_html__( 'Icon', 'crypterio' ),
							'param_name'  => 'icon',
							'admin_label' => false,
						),
						array(
							'type'        => 'textfield',
							'heading'     => esc_html__( 'Link', 'crypterio' ),
							'param_name'  => 'url',
							'admin_label' => true,
						),
					),
				),
				array(
					'type'       => 'dropdown',
					'heading'    => esc_html__( 'Align', 'crypterio' ),
					'param_name' => 'align',
					'value'      => array(
						esc_html__( 'Left', 'crypterio' )  => 'left',
						esc_html__( 'Center', 'crypterio' ) => 'center',
						esc_html__( 'Right', 'crypterio' ) => 'right',
					),
					'std'        => 'left',
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
	class WPBakeryShortCode_Stm_Icon_Links extends WPBakeryShortCode {
	}
}
