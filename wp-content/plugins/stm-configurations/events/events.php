<?php
function stm_display_event_calendar()
{
	$stm_event_date_start = get_post_meta(get_the_ID(), 'stm_event_date_start', true);
	$stm_event_date_end = get_post_meta(get_the_ID(), 'stm_event_date_end', true);

	// Date Format
	if (!empty($stm_event_date_start) and !empty($stm_event_date_end)) {
		$event_month_start = date_i18n('n', $stm_event_date_start);
		$event_month_end = date_i18n('n', $stm_event_date_end);
		$event_day_start = date_i18n('j', $stm_event_date_start);
		$event_day_end = date_i18n('j', $stm_event_date_end);
		$event_year_start = date_i18n('Y', $stm_event_date_end);
		$event_year_end = date_i18n('Y', $stm_event_date_end);
	}

	// Time - Number
	$stm_event_time_end = get_post_meta(get_the_ID(), 'stm_event_time_end', true);
	$stm_event_time_start = get_post_meta(get_the_ID(), 'stm_event_time_start', true);

	// Venue
	$stm_event_venue = get_post_meta(get_the_ID(), 'stm_event_venue', true);

    ?>
    <script type="text/javascript">(function () {
            if (window.addtocalendar) if (typeof window.addtocalendar.start == "function") return;
            if (window.ifaddtocalendar == undefined) {
                window.ifaddtocalendar = 1;
                var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
                s.type = 'text/javascript';
                s.charset = 'UTF-8';
                s.async = true;
                s.src = ('https:' == window.location.protocol ? 'https' : 'http') + '://addtocalendar.com/atc/1.5/atc.min.js';
                var h = d[g]('body')[0];
                h.appendChild(s);
            }
        })();
        (function ($) {
            "use strict";
            $(document).ready(function () {
                $(".addtocalendar .vc_general").click(function (event) {
                    event.stopPropagation();
                    $(".atcb-list").slideDown();
                    $(".vc_general").addClass("vc_general-active");
                });
                $(window).click(function () {
                    $(".atcb-list").slideUp();
                    $(".vc_general").removeClass("vc_general-active");
                });
                $(window).scroll(function () {
                    $(".atcb-list").slideUp();
                    $(".vc_general").removeClass("vc_general-active");
                });

            });

        })(jQuery);
    </script>
    <!-- Event data -->
	<?php if (!empty($stm_event_date_start) and !empty($stm_event_date_end)) : ?>
    <div class="addtocalendar">
        <var class="atc_event">
            <var class="atc_date_start"><?php echo $event_year_start ?>-<?php echo $event_month_start ?>
                -<?php echo $event_day_start ?> <?php echo esc_html($stm_event_time_start); ?></var>
            <var class="atc_date_end"><?php echo $event_year_end ?>-<?php echo $event_month_end ?>
                -<?php echo $event_day_end ?> <?php echo esc_html($stm_event_time_end); ?></var>
            <var class="atc_timezone"><?php if (get_option('timezone_string')) : ?><?php echo get_option('timezone_string'); ?><?php else : ?><?php esc_html_e('Europe/London', 'stm-configurations'); ?><?php endif; ?></var>
            <var class="atc_title"><?php the_title(); ?></var>
            <var class="atc_description"><?php echo esc_html(get_the_excerpt()); ?></var>
            <var class="atc_location"><?php if (!empty($stm_event_venue)) : ?><?php echo esc_html($stm_event_venue); ?><?php else : ?><?php esc_html_e('Not indicated', 'stm-configurations'); ?><?php endif; ?></var>
        </var>
        <div class="vc_general vc_btn3 vc_btn3-size-md vc_btn3-shape-square vc_btn3-style-outline vc_btn3-color-theme_style_4"><?php esc_html_e('save event to calendar', 'stm-configurations'); ?></div>
    </div>
<?php endif;
}


function stm_display_events_form()
{
	$id = get_the_id();
	$stm_event_count = get_post_meta($id, 'stm_event_count', true);
	$event_attended = get_post_meta($id, 'event_attended', true);
	$stm_event_date_end = get_post_meta($id, 'stm_event_date_end', true);
	$today = date("Ymd");

	if ($event_attended < $stm_event_count || $stm_event_count == '' and date_i18n('Ymd', $stm_event_date_end) > $today) : ?>
        <div id="event-form-box" class="event-members-box-wrap">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <h4><?php esc_html_e("register", 'stm-configurations'); ?></h4>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 required-info">
					<?php esc_html_e("* All fields are required", 'stm-configurations'); ?>
                </div>
            </div>
            <form id="event-members-form" action="<?php echo esc_url(home_url('/')); ?>" method="post">
                <div class="event-members-box">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="input-group">
                                <input name="name" type="text"
                                       placeholder="<?php esc_html_e('Name *', 'stm-configurations'); ?>"
                                       class="wpcf7-form-control"/>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="input-group">
                                <input name="email" type="email"
                                       placeholder="<?php esc_html_e('Email *', 'stm-configurations'); ?>"
                                       class="wpcf7-form-control"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="input-group">
                                <input name="phone" type="tel"
                                       placeholder="<?php esc_html_e('Phone *', 'stm-configurations'); ?>"
                                       class="wpcf7-form-control"/>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="input-group">
                                <input name="company" type="text"
                                       placeholder="<?php esc_html_e('Company Name *', 'stm-configurations'); ?>"
                                       class="wpcf7-form-control"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
						<?php
						$recaptcha_enabled = get_theme_mod('enable_recaptcha', 0);
						$recaptcha_public_key = get_theme_mod('recaptcha_public_key');
						$recaptcha_secret_key = get_theme_mod('recaptcha_secret_key');
						?>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
							<?php if ($event_terms_conditions = get_theme_mod('event_terms_conditions', wp_kses(__("I agree with the all additional <a href='http://stylemixthemes.com/' target='_blank'>Terms and Conditions</a>", 'stm-configurations'), array('a' => array('href' => array(), 'target' => array()))))): ?>
                                <div class="event_terms_conditions">
                                    <input type="checkbox" id="event_terms_conditions"/>
                                    <label
                                            for="event_terms_conditions"><?php printf(esc_html__('%s', 'stm-configurations'), $event_terms_conditions); ?></label>
                                </div>
							<?php endif; ?>
							<?php if (!empty($recaptcha_enabled) and $recaptcha_enabled and !empty($recaptcha_public_key) and !empty($recaptcha_secret_key)) : ?>
                                <div class="input-group">
                                    <div class="g-recaptcha"
                                         data-sitekey="<?php echo esc_attr($recaptcha_public_key); ?>"
                                         data-size="normal"></div>
                                </div>
							<?php endif; ?>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                            <div class="input-group">
                        <span class="stm-ajax-loader">
                            <i class="fa fa-refresh" aria-hidden="true"></i>
                        </span>
                                <button type="submit" class="button size-lg icon_left disabled" disabled><i
                                            class="fa fa-chevron-right"></i> <?php esc_html_e("join", 'stm-configurations'); ?>
                                </button>
                            </div>
                        </div>
                    </div>
                    <input name="event_member_id" type="hidden" value="<?php echo esc_attr(get_the_id()); ?>"/>
                    <input name="url" type="hidden" value='<?php the_permalink(); ?>'/>
                    <input name="title" type="hidden" value='<?php the_title(); ?>'/>
                    <div class="form__notice_information form__notice_success alert-modal alert alert-danger text-left">
						<?php esc_html_e("You already joined the event.", 'stm-configurations'); ?>
                    </div>
                </div>
            </form>
        </div>
	<?php endif;
}


//Registration
function stm_custom_register()
{
    check_ajax_referer('stm_custom_register', 'security');
	$response = array();
	$errors = array();

	if (!is_email($_POST['stm_user_mail'])) {
		$errors['stm_user_mail'] = true;
	} else {
		$user_mail = $_POST['stm_user_mail'];
	}

	if (empty($_POST['stm_nickname'])) {
		$errors['stm_nickname'] = true;
	} else {
		$user_login = $_POST['stm_nickname'];
	}

	if (empty($_POST['stm_user_password'])) {
		$errors['stm_user_password'] = true;
	} else {
		$user_pass = $_POST['stm_user_password'];
	}

	if (empty($_POST['stm_user_link'])) {
		$errors['stm_user_link'] = true;
	} else {
		$user_link = $_POST['stm_user_link'];
	}

	if (empty($_POST['stm_site_address'])) {
		$errors['stm_site_address'] = true;
	} else {
		$site_address = $_POST['stm_site_address'];
	}


	if (empty($errors)) {

		$user_login = explode('@', $user_mail);
		$user_login = $user_login[0];
		$user_data = array(
			'user_login' => $user_login,
			'user_pass'  => $user_pass
		);

		$user_has_mail = array(
			'user_email' => $user_mail
		);

		$user_id = wp_insert_user($user_data);
		$user_has_mail_id = wp_insert_user($user_has_mail);

		if (!is_wp_error($user_id)) {
			$response['message'] = esc_html__('Please, check yor email', 'stm-configurations');

			$to = $user_mail;
			$subject = esc_html__('Registration completed successfully', 'stm-configurations');
			$body = esc_html__('Your login: ', 'stm-configurations') . $user_login . "<br>" . esc_html__('Your password: ', 'stm-configurations') . $user_pass . "<br>" . esc_html__('Website: ', 'stm-configurations') . $site_address;
			$headers = array('Content-Type: text/html; charset=UTF-8');

			wp_mail($to, $subject, $body, $headers);

			$to = $user_mail;
			$subject = esc_html__('Your download is available', 'stm-configurations');
			$body = esc_html__('Download link: ', 'stm-configurations') . $user_link;
			$headers = array('Content-Type: text/html; charset=UTF-8');

			wp_mail($to, $subject, $body, $headers);

		} elseif ($user_has_mail_id) {
			$response['message'] = esc_html__('Please, check yor email', 'stm-configurations');

			$to = $user_mail;
			$subject = esc_html__('Your download is available', 'stm-configurations');
			$body = esc_html__('Download link: ', 'stm-configurations') . $user_link;
			$headers = array('Content-Type: text/html; charset=UTF-8');

			wp_mail($to, $subject, $body, $headers);
		} else {
			$response['message'] = $user_id->get_error_message();
			$response['user'] = $user_id;
		}
	}

	$response['errors'] = $errors;
	$response = json_encode($response);
	echo $response;
	exit;
}

add_action('wp_ajax_stm_custom_register', 'stm_custom_register');
add_action('wp_ajax_nopriv_stm_custom_register', 'stm_custom_register');


/*Events fields*/
if (class_exists('STM_PostType')) {
	$speakers = get_posts(array(
		'posts_per_page' => -1,
		'post_type'      => 'stm_staff'
	));

	$speakers_data = array(
		'' => esc_html__('None', 'stm-configurations')
	);

	if (!empty($speakers)) {
		foreach ($speakers as $speaker) {
			$speakers_data[$speaker->ID] = $speaker->post_title;
		}
	}

	STM_PostType::addMetaBox('events_information', esc_html__('Information', 'stm-configurations'), array('stm_event'), '', '', '', array(
		'fields' => array(
			'stm_event_speakers'   => array(
				'label'   => esc_html__('Speaker', 'stm-configurations'),
				'type'    => 'multi-select',
				'options' => $speakers_data
			),
			'stm_event_count'      => array(
				'label' => esc_html__('Max Participants:', 'stm-configurations'),
				'type'  => 'text'
			),
			'stm_event_date_start' => array(
				'label' => esc_html__('Date - Start:', 'stm-configurations'),
				'type'  => 'event_datepicker'
			),
			'stm_event_date_end'   => array(
				'label' => esc_html__('Date - End:', 'stm-configurations'),
				'type'  => 'event_datepicker'
			),
			'stm_event_time_text'  => array(
				'label' => esc_html__('Time - Text:', 'stm-configurations'),
				'type'  => 'text'
			),
			'stm_event_time_start' => array(
				'label' => esc_html__('Time - Start:', 'stm-configurations'),
				'type'  => 'event_timepicker'
			),
			'stm_event_time_end'   => array(
				'label' => esc_html__('Time - End:', 'stm-configurations'),
				'type'  => 'event_timepicker'
			),
			'stm_event_venue'      => array(
				'label' => esc_html__('Venue:', 'stm-configurations'),
				'type'  => 'textarea'
			),
			'stm_event_map_lat'    => array(
				'label' => esc_html__('Latitude:', 'stm-configurations'),
				'type'  => 'text'
			),
			'stm_event_map_lng'    => array(
				'label' => esc_html__('Longitude:', 'stm-configurations'),
				'type'  => 'text'
			),
			'stm_event_tel'        => array(
				'label' => esc_html__('Telephone:', 'stm-configurations'),
				'type'  => 'text'
			)
		)
	));
}