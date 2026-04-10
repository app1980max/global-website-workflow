<?php
if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly
}

require_once STM_CONFIGURATIONS_PATH . '/ico_directory/admin/butterbean_helpers.php';

add_action('butterbean_register', 'stm_listings_register_manager', 10, 2);

function stm_listings_register_manager($butterbean, $post_type)
{

	$listings = stm_ico_directory_get_post_type();

	// Register managers, sections, controls, and settings here.
	if ($post_type !== $listings) {
		return;
	}

	$butterbean->register_manager(
		'stm_ico_manager',
		array(
			'label'     => esc_html__('ICO manager', 'stm_vehicles_listing'),
			'post_type' => $listings,
			'context'   => 'normal',
			'priority'  => 'high'
		)
	);

	$manager = $butterbean->get_manager('stm_ico_manager');

	$sections = array(
		'stm_options' => array(
			'label' => esc_html__('Details', 'stm_vehicles_listing'),
			'icon'  => 'fa fa-list-ul'
		),
		'stm_trending' => array(
			'label' => esc_html__('Features', 'stm_vehicles_listing'),
			'icon'  => 'fa fa-bolt'
		),
		'stm_goals' => array(
			'label' => esc_html__('Goals', 'stm_vehicles_listing'),
			'icon'  => 'fa fa-money'
		),
		'stm_socials' => array(
			'label' => esc_html__('Socials', 'stm_vehicles_listing'),
			'icon'  => 'fa fa-facebook'
		),
		'stm_market' => array(
			'label' => esc_html__('Market', 'stm_vehicles_listing'),
			'icon'  => 'fa fa-dollar'
		),
		'stm_rate' => array(
			'label' => esc_html__('Rates', 'stm_vehicles_listing'),
			'icon'  => 'fa fa-star'
		),
		'stm_info' => array(
			'label' => esc_html__('Token Info', 'stm_vehicles_listing'),
			'icon'  => 'fa fa-info'
		),
		'stm_reviews' => array(
			'label' => esc_html__('Short Review', 'stm_vehicles_listing'),
			'icon'  => 'fa fa-bookmark'
		),
		'stm_links' => array(
			'label' => esc_html__('Additional links', 'stm_vehicles_listing'),
			'icon'  => 'fa fa-external-link'
		),
		'stm_gallery' => array(
			'label' => esc_html__('Gallery', 'stm_vehicles_listing'),
			'icon'  => 'fa fa-camera-retro'
		),
		'stm_user' => array(
			'label' => esc_html__('User Info (Frontend Submission)', 'stm_vehicles_listing'),
			'icon'  => 'fa fa-user'
		),
	);

	/*Register sections*/
	foreach($sections as $section_name => $section) {
		$manager->register_section(
			$section_name,
			$section
		);
	}

	/*Options*/
	$stm_options = array(
		'start_date' => array(
			'options' => array(
				'section' => 'stm_options',
				'type' => 'datepicker',
				'label' => esc_html__('ICO start date', 'stm_domain'),
			),
			'sanitize' => 'stm_ico_validate_date'
		),
		'end_date' => array(
			'options' => array(
				'section' => 'stm_options',
				'type' => 'datepicker',
				'label' => esc_html__('ICO end date', 'stm_domain'),
			),
			'sanitize' => 'stm_ico_validate_date'
		),
		'website' => array(
			'options' => array(
				'section' => 'stm_options',
				'type' => 'text',
				'label' => esc_html__('Website', 'stm_domain'),
				'attr' => array(
					'class' => 'widefat',
				)
			),
			'sanitize' => 'stm_listings_no_validate'
		),
		'whitepaper' => array(
			'options' => array(
				'section' => 'stm_options',
				'type' => 'text',
				'label' => esc_html__('WhitePaper', 'stm_domain'),
				'attr' => array(
					'class' => 'widefat',
				)
			),
			'sanitize' => 'stm_listings_no_validate'
		),
		'image_url' => array(
			'options' => array(
				'section' => 'stm_options',
				'type' => 'text',
				'label' => esc_html__('Image URL', 'stm_domain'),
				'attr' => array(
					'class' => 'widefat',
				)
			),
			'sanitize' => 'stm_listings_no_validate'
		),
		'icon' => array(
			'options' => array(
				'section' => 'stm_options',
				'type' => 'image',
				'label' => esc_html__('ICO Icon', 'stm_domain'),
			),
			'sanitize' => 'stm_listings_no_validate'
		),
	);

	/*Info Fields*/
	$info_fields = array(
		'ticker' => esc_html__('Ticker', 'stm-configurations'),
		'token_type' => esc_html__('Token type', 'stm-configurations'),
		'ico_token_price' => esc_html__('ICO Token Price', 'stm-configurations'),
		'fundraising_goal' => esc_html__('Fundraising Goal', 'stm-configurations'),
		'sold_on_pre_sale' => esc_html__('Sold on pre-sale', 'stm-configurations'),
		'total_tokens' => esc_html__('Total Tokens', 'stm-configurations'),
		'available_for_token_sale' => esc_html__('Available for Token Sale', 'stm-configurations'),
		'whitelist' => esc_html__('Whitelist', 'stm-configurations'),
		'know_your_customer' => esc_html__('Know Your Customer', 'stm-configurations'),
		'cant_participate' => esc_html__('Сant participate', 'stm-configurations'),
		'min_max_personal_cap' => esc_html__('Min/Max Personal Cap', 'stm-configurations'),
		'token_issue' => esc_html__('Token Issue', 'stm-configurations'),
		'accepts' => esc_html__('Accepts', 'stm-configurations'),
	);
	$stm_info = array();
	foreach($info_fields as $info_name => $info) {
		$stm_info[$info_name] = array(
			'options' => array(
				'type'        => 'text',
				'section'     => 'stm_info',
				'label'       => $info,
				'attr'        => array('class' => 'widefat')
			),
			'sanitize' => 'stm_listings_no_validate'
		);
	}

	/*Info Fields*/
	$review_fields = array(
		'number_of_team_members' => esc_html__('Number of team Members', 'stm-configurations'),
		'prototype' => esc_html__('Prototype', 'stm-configurations'),
		'team_from' => esc_html__('Team From', 'stm-configurations'),
	);
	$stm_review = array();
	foreach($review_fields as $review_name => $review) {
		$stm_review[$review_name] = array(
			'options' => array(
				'type'        => 'text',
				'section'     => 'stm_reviews',
				'label'       => $review,
				'attr'        => array('class' => 'widefat')
			),
			'sanitize' => 'stm_listings_no_validate'
		);
	}

	/*Features*/
	$stm_trending = array(
		'trending' => array(
			'options' => array(
				'type'        => 'checkbox',
				'section'     => 'stm_trending',
				'value'       => 'on',
				'label'       => esc_html__('Trending', 'stm_vehicles_listing'),
				'attr'        => array('class' => 'widefat')
			),
			'sanitize' => 'stm_listings_validate_checkbox'
		),
		'sponsored' => array(
			'options' => array(
				'type'        => 'checkbox',
				'section'     => 'stm_trending',
				'value'       => 'on',
				'label'       => esc_html__('Sponsored', 'stm_vehicles_listing'),
				'attr'        => array('class' => 'widefat')
			),
			'sanitize' => 'stm_listings_validate_checkbox'
		),
	);

	/*Goals*/
	$stm_goals = array(
		'raised' => array(
			'options' => array(
				'type'        => 'text',
				'section'     => 'stm_goals',
				'value'       => 'on',
				'label'       => esc_html__('Raised', 'stm_vehicles_listing'),
				'attr'        => array('class' => 'widefat')
			),
			'sanitize' => 'stm_listings_no_validate'
		),
		'softcap' => array(
			'options' => array(
				'type'        => 'text',
				'section'     => 'stm_goals',
				'value'       => 'on',
				'label'       => esc_html__('Softcap', 'stm_vehicles_listing'),
				'attr'        => array('class' => 'widefat')
			),
			'sanitize' => 'stm_listings_no_validate'
		),
		'hardcap' => array(
			'options' => array(
				'type'        => 'text',
				'section'     => 'stm_goals',
				'value'       => 'on',
				'label'       => esc_html__('Hardcap', 'stm_vehicles_listing'),
				'attr'        => array('class' => 'widefat')
			),
			'sanitize' => 'stm_listings_no_validate'
		),
	);

	/*Market and Returns*/
	$stm_market = array(
		'token_price' => array(
			'options' => array(
				'type'        => 'text',
				'section'     => 'stm_market',
				'label'       => esc_html__('Token Price (ETH)', 'stm_vehicles_listing'),
				'attr'        => array('class' => 'widefat')
			),
			'sanitize' => 'stm_listings_no_validate'
		),
		'return_usd' => array(
			'options' => array(
				'type'        => 'text',
				'section'     => 'stm_market',
				'label'       => esc_html__('Projected Returns after listing(USD)', 'stm_vehicles_listing'),
				'attr'        => array('class' => 'widefat')
			),
			'sanitize' => 'stm_listings_no_validate'
		),
		'return_eth' => array(
			'options' => array(
				'type'        => 'text',
				'section'     => 'stm_market',
				'label'       => esc_html__('Projected Returns after listing(ETH)', 'stm_vehicles_listing'),
				'attr'        => array('class' => 'widefat')
			),
			'sanitize' => 'stm_listings_no_validate'
		),
		'return_btc' => array(
			'options' => array(
				'type'        => 'text',
				'section'     => 'stm_market',
				'label'       => esc_html__('Projected Returns after listing(BTC)', 'stm_vehicles_listing'),
				'attr'        => array('class' => 'widefat')
			),
			'sanitize' => 'stm_listings_no_validate'
		),
		'return_text' => array(
			'options' => array(
				'type'        => 'text',
				'section'     => 'stm_market',
				'label'       => esc_html__('Return description', 'stm_vehicles_listing'),
				'attr'        => array('class' => 'widefat')
			),
			'sanitize' => 'stm_listings_no_validate'
		),
	);

	/*Rates*/
	$rates = array(
		'hype_rate' => array(
			'label' => esc_html__('Hype Rate', 'stm_domain'),
		),
		'risk_rate' => array(
			'label' => esc_html__('Risk Rate', 'stm_domain'),
		),
		'roi_rate' => array(
			'label' => esc_html__('ROI Rate', 'stm_domain'),
		),
		'crypterio_rate' => array(
			'label' => esc_html__('Your Rate', 'stm_domain'),
		),
	);
	$stm_rates = array();
	foreach($rates as $rate_name => $rate) {
		$stm_rates[$rate_name] = array(
			'options' => array(
				'type' => 'select',
				'section' => 'stm_rate',
				'label' => $rate['label'],
				'choices' => array(
					'neutral' => esc_html__('Neutral', 'stm_domain'),
					'high' => esc_html__('High', 'stm_domain'),
					'medium' => esc_html__('Medium', 'stm_domain'),
					'low' => esc_html__('Low', 'stm_domain'),
				),
			),
			'sanitize' => 'stm_listings_no_validate'
		);
	}

	/*Socials*/
	$socials = crypterio_socials_list();
	$stm_socials = array();
	foreach($socials as $key => $value) {
		$stm_socials[$key] = array(
			'options' => array(
				'type'        => 'text',
				'section'     => 'stm_socials',
				'label'       => $value,
				'attr'        => array('class' => 'widefat')
			),
			'sanitize' => 'stm_listings_no_validate'
		);
	}

	/*Additional links*/
	$stm_links = array();
	$i = 1;
	while($i <= 4) {
		$stm_links['url_' . $i] = array(
			'options' => array(
				'type'        => 'text',
				'section'     => 'stm_links',
				'label'       => esc_html__('URL', 'stm-configurations') . ' ' . $i,
				'attr'        => array('class' => 'widefat')
			),
			'sanitize' => 'stm_listings_no_validate'
		);
		$stm_links['url_label_' . $i] = array(
			'options' => array(
				'type'        => 'text',
				'section'     => 'stm_links',
				'label'       => esc_html__('Label', 'stm-configurations') . ' ' . $i,
				'attr'        => array('class' => 'widefat')
			),
			'sanitize' => 'stm_listings_no_validate'
		);

		$i++;
	}

	/*Gallery*/
	$stm_gallery = array(
		'video' => array(
			'options' => array(
				'type'        => 'text',
				'section'     => 'stm_gallery',
				'label'       => esc_html__('Video URL', 'stm_vehicles_listing'),
				'attr'        => array('class' => 'widefat')
			),
			'sanitize' => 'stm_listings_no_validate'
		),
		'gallery' => array(
			'options' => array(
				'type'        => 'gallery',
				'section'     => 'stm_gallery',
				'label'       => esc_html__('Gallery', 'stm_vehicles_listing'),
				'attr'        => array('class' => 'widefat')
			),
			'sanitize' => 'stm_listings_validate_gallery'
		),
	);

	/*Market and Returns*/
	$stm_user = array(
		'name' => array(
			'options' => array(
				'type'        => 'text',
				'section'     => 'stm_user',
				'label'       => esc_html__('User Name', 'stm_vehicles_listing'),
				'attr'        => array('class' => 'widefat')
			),
			'sanitize' => 'stm_listings_no_validate'
		),
		'email' => array(
			'options' => array(
				'type'        => 'text',
				'section'     => 'stm_user',
				'label'       => esc_html__('User Email', 'stm_vehicles_listing'),
				'attr'        => array('class' => 'widefat')
			),
			'sanitize' => 'stm_listings_no_validate'
		),
		'affiliated' => array(
			'options' => array(
				'type'        => 'text',
				'section'     => 'stm_user',
				'label'       => esc_html__('User Affiliated?', 'stm_vehicles_listing'),
				'attr'        => array('class' => 'widefat')
			),
			'sanitize' => 'stm_listings_no_validate'
		),
	);


	$controls = array_merge(
		$stm_options,
		$stm_info,
		$stm_trending,
		$stm_goals,
		$stm_socials,
		$stm_market,
		$stm_rates,
		$stm_review,
		$stm_links,
		$stm_gallery,
		$stm_user
	);

	foreach($controls as $control => $control_data) {
		/*Registering controls*/
		$manager->register_control(
			$control,
			$control_data['options']
		);

		/*Register setting*/
		$manager->register_setting(
			$control,
			array('sanitize_callback' => $control_data['sanitize'])
		);
	}

}