<?php
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

wp_enqueue_style('stm_cryptowidget', get_template_directory_uri() . '/assets/css/shared/vc/stm_cryptowidget.css', array(), CRYPTERIO_THEME_VERSION);

$currencies = crypterio_get_user_crypto('name');

if(count($currencies) > 5) $currencies = array_slice($currencies, 0, 5);

$currency_format = 'price';

if (!empty($currencies) && class_exists('VCW_Data') && method_exists('VCW_Data', 'coin')): ?>
    <div class="stm_currencies_simple_widget">
		<?php foreach ($currencies as $currency_name): ?>
        <?php
            if($currency_name == 'Ripple') $currency_name = 'XRP';
            $currency_id = crypterio_get_coin_id($currency_name);
            if(empty($currency_id)) continue;
            $currency_info = VCW_Data::coin($currency_id);
            if(empty($currency_info['id'])) continue;
            ?>
			<?php if (!empty($currency_info)): ?>
                <div class="scsl__single">
                    <div class="inner">
						<?php
                        $change_1h = ($currency_info['change_1h'] < 0) ? 'minus' : 'plus';
                        $change_24h = ($currency_info['change_24h'] < 0) ? 'minus' : 'plus';
						?>

                        <div class="scsl__name">
                            <div class="scsl__image">
								<?php crypterio_display_currency_image($currency_name); ?>
                            </div>
							<?php echo sanitize_text_field($currency_info['name']); ?>
                        </div>

                        <div class="scsl__price">
							<?php echo crypterio_price_view($currency_info[$currency_format]['usd']); ?>
                        </div>

                        <div class="scsl__change_<?php echo esc_attr($change_24h); ?>">
                            <?php echo sanitize_text_field($currency_info['change_24h']); ?>%
                        </div>

                    </div>
                </div>
			<?php endif; ?>
		<?php endforeach; ?>
    </div>
<?php endif;