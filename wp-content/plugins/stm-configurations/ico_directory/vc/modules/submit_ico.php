<?php

add_action('init', 'stm_ico_listing_stm_submit_ico');

function stm_ico_listing_stm_submit_ico()
{

	if (function_exists('stm_submit_ico_fields')){
		$submit = stm_submit_ico_fields();
		$params = array(
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__('Title', 'crypterio'),
				'param_name'  => 'title',
				'holder'  => 'div',
			),
			vc_map_add_css_animation(),
			array(
				'type'       => 'css_editor',
				'heading'    => esc_html__('Css', 'stm-configurations'),
				'param_name' => 'css',
				'group'      => esc_html__('Design options', 'stm-configurations')
			)
		);
	
		foreach($submit as $key => $value) {
			if(!empty($value['required']) and $value['required']) continue;
			$params[] = array(
				'type'        => 'checkbox',
				'heading'     => sprintf(esc_html__('Disable %s Field', 'crypterio'), $value['label']),
				'param_name'  => $key,
			);
		}
	
		vc_map(array(
			'name'   => esc_html__('Submit ICO Form', 'stm-configurations'),
			'base'   => 'stm_submit_ico',
			'icon'   => 'stm_submit_ico',
			'description' => esc_html__('Submit ICO Form with admin pre-moderation', 'stm-configurations'),
			'category' =>array(
				esc_html__('Content', 'stm-configurations'),
			),
			'html_template' => STM_CONFIGURATIONS_PATH . '/ico_directory/vc_templates/stm_submit_ico.php',
			'params' => $params
		));
	}
}

if (class_exists('WPBakeryShortCode')) {
	class WPBakeryShortCode_Stm_Submit_Ico extends WPBakeryShortCode
	{
	}
}