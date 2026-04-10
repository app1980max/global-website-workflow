<?php
function stm_whitelist_data()
{
    check_ajax_referer('stm_whitelist_data', 'security');
	$r = array(
		'has_error' => false,
		'errors'    => [],
		'data'      => [],
		'success'   => ''
	);
	$user_data = crypterio_white_list_data();

	/*Check Recapthca*/
	$recaptcha_pass = crypterio_check_recaptcha();
	if (!$recaptcha_pass) {
		$r['has_error'] = true;
		$r['error_message'] = esc_html__('CAPTCHA verification failed.', 'crypterio');
	}


	foreach ($user_data as $name => $data) {
		$error = '';

		switch ($data['type']) {
			case 'number':
				if (empty($_POST[$name])) {
					$error = esc_html__('Field is required', 'crypterio');
				} elseif (!is_numeric($_POST[$name])) {
					$error = esc_html__('Only numbers', 'crypterio');
				}

				if (empty($error)) {
					$r['data'][$name] = floatval($_POST[$name]);
				}
				break;
			case 'email':
				if (empty($_POST[$name])) {
					$error = esc_html__('Field is required', 'crypterio');
				} elseif (!filter_var($_POST[$name], FILTER_VALIDATE_EMAIL)) {
					$error = esc_html__('Invalid email format', 'crypterio');
				}

				if (empty($error)) {
					$r['data'][$name] = sanitize_text_field($_POST[$name]);
				}
				break;
			case 'file':
				if (empty($_FILES[$name])) {
					$error = esc_html__('Field is required', 'crypterio');
				} else {
					$maximum_size = 2048000;
					if ($_FILES[$name]['size'] > $maximum_size) {
						$error = esc_html__("File size limit is 2 mB", 'crypterio');
					} else {
						$info = getimagesize($_FILES[$name]['tmp_name']);
						if (($info[2] !== IMAGETYPE_GIF) && ($info[2] !== IMAGETYPE_JPEG) && ($info[2] !== IMAGETYPE_PNG)) {
							$error = esc_html__("Please use a jpg/png/gif image", 'crypterio');
						}
					}

					if (!$error) {
						$r['data'][$name] = $_FILES[$name];
					}

				}
				break;
			default:
				if (empty($_POST[$name])) {
					$error = esc_html__('Field is required', 'crypterio');
				}

				if (empty($error)) {
					$r['data'][$name] = sanitize_text_field($_POST[$name]);
				}
		}

		if ($error) {
			$r['has_error'] = true;
			$r['errors'][$name] = $error;
		}
	}

	$r = apply_filters('stm_crypto_contract_errors', $r);

	/*If no errors*/
	if (!$r['has_error']) {
		/*Create Post*/

		if (!empty($r['demo'])) {
			$r['success'] = esc_html__('Thank you, your data has been submitted. Email will be sent after approval.', 'crypterio');
			wp_send_json($r);
			die;
		}

		$data = $r['data'];

		$proposal = array(
			'post_title'  => $data['first_name'] . ' ' . $data['last_name'],
			'post_status' => 'pending',
			'post_type'   => 'stm_white_list'
		);

		$post_id = wp_insert_post($proposal);

		foreach ($data as $name => $value) {
			if ($user_data[$name]['type'] === 'file') {
				$value = crypterio_upload_photo($value, $post_id);
			}

			update_post_meta($post_id, $name, $value);
		}

		$r['success'] = esc_html__('Thank you, your data has been submitted. Email will be sent after approval.', 'crypterio');

		$to = get_bloginfo('admin_email');
		$subject = esc_html__('New ICO Participant', 'crypterio');
		$body = esc_html__('Please check new ICO Participant.', 'crypterio');

		wp_mail($to, $subject, $body);

		$to = $data['email'];
		$subject = esc_html__('Application submitted', 'crypterio');
		$body = sprintf(
			__('Dear, %s Your Application has been successfully submitted. <br/> We will contact you once Main ICO has been started.', 'crypterio'),
			$data['first_name'] . ' ' . $data['last_name']
		);

		wp_mail($to, $subject, $body);

	}

	wp_send_json($r);
}

add_action('wp_ajax_stm_whitelist_data', 'stm_whitelist_data');
add_action('wp_ajax_nopriv_stm_whitelist_data', 'stm_whitelist_data');


function stm_submit_ico()
{
    check_ajax_referer('stm_submit_ico', 'security');
	$r = array(
		'errors'    => array(),
		'has_error' => false,
		'message'   => '',
	);

	$fields = stm_submit_ico_fields();


	$recaptcha = crypterio_check_recaptcha('g-recaptcha-response');
	if (!$recaptcha) {
		$r['errors'][] = 'recaptcha';
		$r['has_error'] = true;
		$r['message'] = esc_html__('CAPTCHA verification failed.', 'crypterio');
	}

	foreach ($fields as $field_key => $field) {
		$type = (empty($field['type'])) ? 'text' : $field['type'];
		$required = (!empty($field['required']) and $field['required']) ? true : false;

		switch ($type) {
			case 'select' :
				$value = (!empty($_POST[$field_key])) ? sanitize_text_field($_POST[$field_key]) : '';
				if (!empty($value) and !empty($field['choices'][$value])) {
					$fields[$field_key]['value'] = $value;
				}
				break;
			case 'date' :
				if (empty($_POST[$field_key]) and $required) {
					$r['errors'][] = $field_key;
					$r['has_error'] = true;
				} else {
					$fields[$field_key]['value'] = strtotime(sanitize_text_field($_POST[$field_key]));
				}
				break;
			case 'image':
				if (!empty($_FILES[$field_key])) {
					$maximum_size = 2048000;
					if ($_FILES[$field_key]['size'] > $maximum_size) {
						$r['message'] = esc_html__("File size limit is 2 mB", 'crypterio');
						$r['has_error'] = true;
					} else {
						$info = getimagesize($_FILES[$field_key]['tmp_name']);
						if (($info[2] !== IMAGETYPE_GIF) && ($info[2] !== IMAGETYPE_JPEG) && ($info[2] !== IMAGETYPE_PNG)) {
							$r['message'] = esc_html__("Please use a jpg/png/gif image", 'crypterio');
							$r['has_error'] = true;
						}
					}

					if (!$r['has_error']) {
						$fields[$field_key]['value'] = $_FILES[$field_key];
					}

				}
				break;
			default:
				if (empty($_POST[$field_key]) and $required) {
					$r['errors'][] = $field_key;
					$r['has_error'] = true;
				} else {
					$fields[$field_key]['value'] = sanitize_text_field($_POST[$field_key]);
				}
		}
	}

	$r = apply_filters('stm_submit_ico_errors', $r);

	if (!$r['has_error']) {


		if (!empty($r['demo'])) {
			$r['message'] = esc_html__('Thank you, your ICO has been submitted. Email will be sent after approval.', 'crypterio');
			wp_send_json($r);
			die;
		}

		$excerpt = (!empty($_POST['excerpt'])) ? wp_kses_post($_POST['excerpt']) : '';

		$proposal = array(
			'post_title'   => $fields['ico_name']['value'],
			'post_status'  => 'pending',
			'post_type'    => 'stm_ico_listing',
			'post_content' => $excerpt,
		);

		$post_id = wp_insert_post($proposal);

		foreach ($fields as $name => $field) {
			$type = (!empty($field['type'])) ? $field['type'] : 'text';
			if ($type === 'image') {
				$value = crypterio_upload_photo($field['value'], $post_id);
			}
			update_post_meta($post_id, $name, $field['value']);

			do_action('stm_icolisting_field_saved', array($post_id, $name, $field['value']));

		}

		if (!empty($fields['ico_category']['value'])) {
			wp_set_object_terms($post_id, array(intval($fields['ico_category']['value'])), 'stm_ico_listing_category');
		}

		//wp_delete_post($post_id, true);

		$r['message'] = esc_html__('Thank you, your ICO has been submitted.', 'crypterio');

		$to = get_bloginfo('admin_email');
		$subject = esc_html__('New ICO', 'crypterio');
		$body = esc_html__('Please check new ICO.', 'crypterio');

		wp_mail($to, $subject, $body);

	} else {
		$r['message'] = (empty($r['message'])) ? esc_html__('Please, fill all required fields.', 'crypterio') : $r['message'];
	}


	wp_send_json($r);
}

add_action('wp_ajax_stm_submit_ico', 'stm_submit_ico');
add_action('wp_ajax_nopriv_stm_submit_ico', 'stm_submit_ico');

add_filter('crypterio_get_content', function($path){
	return json_decode(file_get_contents($path), true);
}, 9);

add_filter('crypterio_recaptcha_get_content', function ($context){
	return file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, $context);
}, 9);

add_filter('crypterio_recaptcha_remote_address', function($remote_ad){
	return $_SERVER['REMOTE_ADDR'];
});