<?php

add_action( 'wp_enqueue_scripts', 'stm_deregister_theme_scripts_and_styles' );

function stm_deregister_theme_scripts_and_styles() {
	wp_deregister_style( 'font-awesome' );
	wp_deregister_style( 'select2' );
	wp_deregister_style( 'slick' );
	wp_deregister_style( 'owl.carousel' );
	wp_deregister_script( 'select2' );
}

if ( function_exists( 'vc_add_shortcode_param' ) ) {
	vc_add_shortcode_param( 'stm_animator', 'crypterio_animator_param' );

	vc_add_shortcode_param( 'stm_datepicker_vc', 'stm_datepicker_vc_st', get_template_directory_uri().'/assets/js/jquery.stmdatetimepicker.js' );

	vc_add_shortcode_param( 'stm_timepicker_vc', 'stm_timepicker_vc_st' );

	vc_add_shortcode_param( 'stm_countdown_vc', 'stm_countdown_vc_st', get_template_directory_uri().'/assets/js/jquery.stmdatetimepicker.js' );
}

if( ! function_exists( 'crypterio_animator_param' ) ){
	function crypterio_animator_param( $settings, $value ) {
		global $wp_filesystem;

		if ( empty( $wp_filesystem ) ) {
			require_once ABSPATH . '/wp-admin/includes/file.php';
			WP_Filesystem();
		}
		$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
		$type       = isset( $settings['type'] ) ? $settings['type'] : '';
		$class      = isset( $settings['class'] ) ? $settings['class'] : '';
		$animations = json_decode( $wp_filesystem->get_contents( get_template_directory() . '/assets/js/animate-config.json' ), true );
		if ( $animations ) {
			$output = '<select name="' . esc_attr( $param_name ) . '" class="wpb_vc_param_value ' . esc_attr( $param_name . ' ' . $type . ' ' . $class ) . '">';
			foreach ( $animations as $key => $val ) {
				if ( is_array( $val ) ) {
					$labels = str_replace( '_', ' ', $key );
					$output .= '<optgroup label="' . ucwords( esc_attr( $labels ) ) . '">';
					foreach ( $val as $label => $style ) {
						$label = str_replace( '_', ' ', $label );
						if ( $label == $value ) {
							$output .= '<option selected value="' . esc_attr( $label ) . '">' . esc_html( $label ) . '</option>';
						} else {
							$output .= '<option value="' . esc_attr( $label ) . '">' . esc_html( $label ) . '</option>';
						}
					}
				} else {
					if ( $key == $value ) {
						$output .= "<option selected value=" . esc_attr( $key ) . ">" . esc_html( $key ) . "</option>";
					} else {
						$output .= "<option value=" . esc_attr( $key ) . ">" . esc_html( $key ) . "</option>";
					}
				}
			}

			$output .= '</select>';
		}

		return $output;
	}
}

function stm_datepicker_vc_st( $settings, $value ) {
	return '<div class="stm_datepicker_vc_field">'
		.'<input type="text" name="' . esc_attr( $settings['param_name'] ) . '" class="stm_datepicker_vc wpb_vc_param_value wpb-textinput ' .
		esc_attr( $settings['param_name'] ) . ' ' .
		esc_attr( $settings['type'] ) . '_field" type="text" value="' . esc_attr( $value ) . '" />' .
		'</div>';
}

function stm_timepicker_vc_st( $settings, $value ) {
	return '<div class="stm_timepicker_vc_field">'
		.'<input type="text" name="' . esc_attr( $settings['param_name'] ) . '" class="stm_timepicker_vc wpb_vc_param_value wpb-textinput ' .
		esc_attr( $settings['param_name'] ) . ' ' .
		esc_attr( $settings['type'] ) . '_field" type="text" value="' . esc_attr( $value ) . '" />' .
		'</div>';
}

function stm_countdown_vc_st( $settings, $value ) {
	return '<div class="stm_countdown_vc_field">'
		.'<input type="text" name="' . esc_attr( $settings['param_name'] ) . '" class="stm_countdown_vc wpb_vc_param_value wpb-textinput ' .
		esc_attr( $settings['param_name'] ) . ' ' .
		esc_attr( $settings['type'] ) . '_field" type="text" value="' . esc_attr( $value ) . '" />' .
		'</div>';
}

//Ajax request event member
function stm_ajax_add_event_member() {
    check_ajax_referer('stm_ajax_add_event_member', 'security');
	$response['errors'] = array();

	if ( empty( $_POST['name'] ) ) {
		$response['errors']['name'] = true;
	}
	if ( ! is_email( $_POST['email'] ) ) {
		$response['errors']['email'] = true;
	}
	if ( ! is_numeric( $_POST['phone'] ) ) {
		$response['errors']['phone'] = true;
	}
	if ( empty( $_POST['company'] ) ) {
		$response['errors']['company'] = false;
	}

	$id = $_POST['event_member_id'];
	$name = $_POST['name'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$company = $_POST['company'];
	$url = $_POST['url'];
	$title = $_POST['title'];

	$recaptcha = true;

	$recaptcha_enabled = get_theme_mod('enable_recaptcha',0);
	$recaptcha_public_key = get_theme_mod('recaptcha_public_key');
	$recaptcha_secret_key = get_theme_mod('recaptcha_secret_key');
	if(!empty($recaptcha_enabled) and $recaptcha_enabled and !empty($recaptcha_public_key) and !empty($recaptcha_secret_key)){
		$recaptcha = false;
		if(!empty($_POST['g-recaptcha-response'])) {
			$recaptcha = true;
		}
	}

	if ( $recaptcha ) {
		if ( empty( $response['errors'] ) and ! empty( $id ) ) {
			$data['post_title']  = esc_html__( 'New request for event - ', 'crypterio' ) . ' ' . get_the_title( $id );
			$data['post_type']   = 'event_member';
			$data['post_status'] = 'publish';
			$data_id             = wp_insert_post( $data );
			update_post_meta( $data_id, 'name', $name );
			update_post_meta( $data_id, 'email', $email );
			update_post_meta( $data_id, 'phone', $phone );
			update_post_meta( $data_id, 'company', $company );
			update_post_meta( $data_id, 'memberId', $id );

			update_post_meta( $data_id, 'event_member_eventID', $id );
			$event_attended = get_post_meta($id, 'event_attended', true );
			update_post_meta( $id, 'event_attended', $event_attended + 1 );

			$response['response'] = esc_html__( 'Your request was sent', 'crypterio' );
			$response['status']   = 'success';

		} else {
			$response['response'] = esc_html__( 'Please fill all fields', 'crypterio' );
			$response['status']   = 'danger';
		}

		$response['recaptcha'] = true;
	} else {
		$response['recaptcha'] = false;
		$response['status']    = 'danger';
		$response['response']  = esc_html__( 'Please prove you\'re not a robot', 'crypterio' );
	}

	//Sending Mail to admin
	if ( empty( $response['errors'] ) and ! empty( $id ) ) {
		add_filter( 'wp_mail_content_type', 'stm_set_html_content_type' );

		$to      = get_bloginfo( 'admin_email' );
		$subject = esc_html__( 'New Event Member', 'crypterio' );
		$body    = esc_html__( 'Event: ', 'crypterio' ) . '<a href="'. $url .'">' . $title . '</a><br/>';
		$body .= esc_html__( 'Name: ', 'crypterio' ) . $name . '<br/>';
		$body .= esc_html__( 'Email: ', 'crypterio' ) . $email . '<br/>';
		$body .= esc_html__( 'Phone: ', 'crypterio' ) . $phone . '<br/>';
		$body .= esc_html__( 'Company: ', 'crypterio' ) . $company . '<br/>';

		wp_mail( $to, $subject, $body );
		wp_mail( $email, $subject, 'You have been joined to the event - ' . '<a href="'. $url .'">' . $title . '</a>' );

		remove_filter( 'wp_mail_content_type', 'stm_set_html_content_type' );
	}

	$response = json_encode( $response );

	echo crypterio_sanitize_text_field($response);
	exit;
}

add_action( 'wp_ajax_stm_ajax_add_event_member', 'stm_ajax_add_event_member' );
add_action( 'wp_ajax_nopriv_stm_ajax_add_event_member', 'stm_ajax_add_event_member' );