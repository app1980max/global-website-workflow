<?php
    $token_sale = array(
		'ticker' => array(esc_html__('Ticker', 'crypterio')),
		'token_type' => array(esc_html__('Token type', 'crypterio')),
		'ico_token_price' => array(esc_html__('ICO Token Price', 'crypterio')),
		'fundraising_goal' => array(esc_html__('Fundraising Goal', 'crypterio')),
		'sold_on_pre_sale' => array(esc_html__('Sold on pre-sale', 'crypterio')),
		'total_tokens' => array(esc_html__('Total Tokens', 'crypterio')),
		'available_for_token_sale' => array(esc_html__('Available for Token Sale', 'crypterio')),
		'whitelist' => array(esc_html__('Whitelist', 'crypterio')),
		'know_your_customer' => array(esc_html__('Know Your Customer', 'crypterio')),
		'cant_participate' => array(esc_html__('Сant participate', 'crypterio')),
		'min_max_personal_cap' => array(esc_html__('Min/Max Personal Cap', 'crypterio')),
		'token_issue' => array(esc_html__('Token Issue', 'crypterio')),
		'accepts' => array(esc_html__('Accepts', 'crypterio')),
	);

    foreach($token_sale as $token_sale_key => $token_sale_value) {
        if(!empty($metas[$token_sale_key])) $token_sale[$token_sale_key][1] = $metas[$token_sale_key];
    }

    $subtitle = '';
    if(!empty($metas['start_date']) and !empty($metas['end_date'])) {
        $subtitle = ': ' . date_i18n('d F', $metas['start_date']) . ' — ' . date_i18n('d F', $metas['end_date']);
    }
?>

<div class="stm_single_ico_part stm_single_ico__market">

    <i class="stm-id_calendar stm_single_ico_part__icon stc"></i>
    <div class="stm_single_ico_part__title h4">
		<?php esc_html_e('Token Sale', 'crypterio'); ?><strong><?php echo esc_attr($subtitle); ?></strong>
    </div>

    <div class="stm_single_ico__token_sales">
        <?php foreach($token_sale as $token_sale_key => $token_sale_value): ?>
            <?php if(!empty($token_sale_value[1])): ?>
                <div class="stm_single_ico__token_sale">
                    <span><?php echo esc_attr($token_sale_value[0]); ?></span>
                    <label><?php echo esc_attr($token_sale_value[1]); ?></label>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>


</div>