<?php
	$status = (!empty($metas['start_date']) and !empty($metas['end_date'])) ? crypterio_check_ico_status($metas['start_date'], $metas['end_date']) : 'upcoming';
	$statuses = crypterio_status_score();
	$status_label = (!empty($statuses[$status])) ? $statuses[$status] : esc_html__('Upcoming', 'crypterio');
?>

<div class="stm_ico_listing__related">
	<h3 class="text-center sbc_a">
		<?php printf(esc_html__('Other %s ICOs', 'crypterio'), $status_label); ?>
	</h3>

	<?php

	$parts = crypterio_parts_config();
	$date_or_logo = $parts['date_or_logo'];
	$number = 3;
	$add_args = array(
        'orderby' => 'rand',
        'post__not_in' => array(get_the_ID()),
    );
	require_once(get_template_directory() . '/partials/vc_parts/ico_grid/' . $status . '.php');
	?>

</div>