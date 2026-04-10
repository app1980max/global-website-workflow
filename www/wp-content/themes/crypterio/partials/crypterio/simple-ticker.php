<?php
$currencies = crypterio_get_user_crypto('name');
//$currencies_info = crypterio_get_cmc_data();

$currency_format = 'price';

$stm_ct_id = time();

if (!empty($currencies) && class_exists('VCW_Data') && method_exists('VCW_Data', 'coin')): ?>
    <div id="stm_currencies_ticker_<?php echo esc_attr($stm_ct_id); ?>" class="stm_currencies_simple_ticker">
		<?php foreach ($currencies as $currency_name): ?>
        <?php
            if($currency_name == 'Ripple') $currency_name = 'XRP';
            $currency_id = crypterio_get_coin_id($currency_name);
            if( empty( $currency_id ) ) continue;
            $currency_info = VCW_Data::coin($currency_id);
            if(empty($currency_info['id'])) continue;
            ?>
			<?php if (!empty($currency_info)): ?>
                <div class="scsl__single">
                    <div class="inner">
						<?php
                        $change_1h = ($currency_info['change_1h'] < 0) ? 'minus' : 'plus';
                        $change_24h = ($currency_info['change_24h'] < 0) ? 'minus' : 'plus';
                        $change_7d = ($currency_info['change_7d'] < 0) ? 'minus' : 'plus';
                        $income = ( $currency_info[$currency_format]['usd'] * $currency_info['change_24h'] ) / 100;
						?>

                        <div class="scsl__name">
                            <span class="scsl__image">
                                <?php crypterio_display_currency_image($currency_name); ?>
                            </span>
							<?php echo sanitize_text_field($currency_info['name']); ?>
                            <span class="scsl__income scsl__change_<?php echo esc_attr($change_24h); ?>"><?php echo crypterio_price_view($income, ' '); ?></span>
                            <div class="scsl__price">
								<?php echo crypterio_price_view($currency_info[$currency_format]['usd']); ?>
                                <span class="scsl__change_<?php echo esc_attr($change_24h); ?>"><?php echo sanitize_text_field($currency_info['change_24h']); ?>%</span>
                            </div>
                        </div>
                    </div>
                </div>
			<?php endif; ?>
		<?php endforeach; ?>
    </div>

    <script type="text/javascript">
        jQuery(document).ready(function(){
            var $ = jQuery;

            $('#stm_currencies_ticker_<?php echo esc_attr($stm_ct_id); ?>').simplemarquee({
                speed: 40,
                space: 0,
                handleHover: true,
	            delayBetweenCycles: 1,
                handleResize: true
            });
        });
    </script>
<?php endif;