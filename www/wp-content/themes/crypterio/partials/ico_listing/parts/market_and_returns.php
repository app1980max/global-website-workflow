<?php
$returns = array(
	'return_usd' => array('USD'),
	'return_eth' => array('ETH'),
	'return_btc' => array('BTC')
);

foreach ($returns as $return_key => $return_value) {
	if (!empty($metas[$return_key])) $returns[$return_key][1] = $metas[$return_key];
}

if (!empty($metas['token_price']) or count($returns, COUNT_RECURSIVE) > 6): ?>

    <div class="stm_single_ico_part stm_single_ico__market">

        <i class="stm-id_rate stm_single_ico_part__icon stc"></i>
        <div class="stm_single_ico_part__title h4">
			<?php esc_html_e('Market & Returns', 'crypterio'); ?>
        </div>

        <div class="stm_single_ico_part__double clearfix">
            <div class="stm_single_ico_part__double_left">
				<?php if (!empty($metas['token_price']) and !empty($metas['token_price'])):
					$eth_price = floatval($metas['token_price']);
					$usd = crypterio_get_rates();
					$eth = crypterio_get_rates('ETH');

					$usd_price = ($eth_price / $eth) * $usd;
					$btc_price = $eth_price / $eth;

					?>
                    <div class="stm_single_ico__market_price">

                        <div class="stm_single_ico_part__content">
                            <h5><?php printf(esc_html__('%s token price', 'crypterio'), get_the_title()); ?></h5>
                        </div>

                        <div class="stm_single_ico__market_price_prices">
                            <span><?php echo crypterio_price_view($usd_price, '$', 'left', ',', '.', 7); ?></span>
                            <span><?php echo crypterio_price_view($eth_price, ' ETH', 'right', ',', '.', 7); ?></span>
                            <span><?php echo crypterio_price_view($btc_price, ' BTC', 'right', ',', '.', 7); ?></span>
                        </div>
                    </div>
				<?php endif; ?>
            </div>

			<?php if (count($returns, COUNT_RECURSIVE) > 6): ?>
                <div class="stm_single_ico_part__double_right">
                    <div class="stm_single_ico_part__content">
                        <h5><?php esc_html_e('Returns since ICO', 'crypterio'); ?></h5>
                        <div class="stm_single_ico__returns">
							<?php foreach ($returns as $return_key => $return): ?>
								<?php if (!empty($return[1])): ?>
                                    <div class="stm_single_ico__return">
                                        <span><?php echo esc_attr($return['1']) ?></span>
                                        <label><?php echo esc_attr($return['0']) ?></label>
                                    </div>
								<?php endif; ?>
							<?php endforeach; ?>
                        </div>
						<?php if (!empty($metas['return_text'])): ?>
                            <div class="stm_single_ico_part__return_description">
								<?php echo esc_attr($metas['return_text']); ?>
                            </div>
						<?php endif; ?>
                    </div>
                </div>
			<?php endif; ?>

        </div>


    </div>
<?php endif;