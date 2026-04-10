<?php
$rates = array(
	'hype_rate'      => array(esc_html__('Hype rate', 'crypterio')),
	'risk_rate'      => array(esc_html__('Risk rate', 'crypterio')),
	'roi_rate'       => array(esc_html__('ROI rate', 'crypterio')),
	'crypterio_rate' => array(esc_html__('Site Score', 'crypterio')),
);

foreach ($rates as $rate_key => $rate) {
	if (!empty($metas[$rate_key])) $rates[$rate_key][1] = $metas[$rate_key];
}

$rates_score = crypterio_rates_score();

$average_rate = 0;
$rates_mark = crypterio_rates_mark();
$rates_mark_reversed = crypterio_rates_mark_reversed();

foreach($rates as $rate => $labels) {
    $rates_mark_current = ($rate == 'risk_rate') ? $rates_mark_reversed : $rates_mark;
    $mark = !empty($metas[$rate]) ? $rates_mark_current[$metas[$rate]] : 3.5;

    $average_rate += $mark;
}

$average_rate = round($average_rate / 4, 2);
$average_rate_percent = ($average_rate * 100) / 5;

if (count($rates, COUNT_RECURSIVE) > 8): ?>

    <div class="stm_single_ico_part stm_single_ico__market">

        <i class="stm-id_rating stm_single_ico_part__icon stc"></i>
        <div class="stm_single_ico_part__title h4">
            <label><?php esc_html_e('Our Rating', 'crypterio'); ?></label>
            <div class="stm_single_ico__starrate"
                 itemprop="aggregateRating"
                 itemscope
                 itemtype="http://schema.org/AggregateRating">
                <div class="bar">
                    <div class="bar-filled" style="width: <?php echo esc_attr($average_rate_percent); ?>%;"></div>
                </div>
                <span class="hidden" itemprop="ratingCount">4</span>
                <span itemprop="ratingValue"><?php echo esc_attr($average_rate); ?></span>/5
            </div>
        </div>

        <div class="stm_single_ico__rates">
			<?php foreach ($rates as $rate_key => $rate): ?>
				<?php if (!empty($rate[1])): ?>
                    <div class="stm_single_ico__rate <?php echo esc_attr($rate_key); ?>">
                        <span><?php echo esc_attr($rate[0]); ?></span>
                        <label><?php echo esc_attr($rates_score[$rate[1]]); ?></label>
                    </div>
				<?php endif; ?>
			<?php endforeach; ?>
        </div>


    </div>
<?php endif;