<?php
$token_sale = array(
	'number_of_team_members' => array(esc_html__('Number of team Members', 'crypterio')),
	'prototype'              => array(esc_html__('Prototype', 'crypterio')),
	'team_from'              => array(esc_html__('Team From', 'crypterio')),
);

foreach ($token_sale as $token_sale_key => $token_sale_value) {
	if (!empty($metas[$token_sale_key])) $token_sale[$token_sale_key][1] = $metas[$token_sale_key];
}

if (count($token_sale, COUNT_RECURSIVE) > 6): ?>

    <div class="stm_single_ico_part stm_single_ico__market">

        <i class="stm-short_review stm_single_ico_part__icon stc"></i>
        <div class="stm_single_ico_part__title h4">
			<?php esc_html_e('Short review', 'crypterio'); ?>
        </div>

        <div class="stm_single_ico__token_sales">
			<?php foreach ($token_sale as $token_sale_key => $token_sale_value): ?>
				<?php if (!empty($token_sale_value[1])): ?>
                    <div class="stm_single_ico__token_sale">
                        <span><?php echo esc_attr($token_sale_value[0]); ?></span>
                        <label><?php echo esc_attr($token_sale_value[1]); ?></label>
                    </div>
				<?php endif; ?>
			<?php endforeach; ?>
        </div>

    </div>

<?php endif;