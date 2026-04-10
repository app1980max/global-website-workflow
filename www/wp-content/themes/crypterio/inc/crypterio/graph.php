<?php

if (function_exists('vc_map')) {
    $currencies = crypterio_get_cmc_data();
    $list = array();
    foreach ($currencies as $currency_key => $currency_val) {
        $list[] = array(
            'value' => $currency_key,
            'label' => $currency_val['name']
        );
    }

    vc_map(
        array(
            'name' => esc_html__('Cryptocurrency charts', 'crypterio'),
            'base' => 'stm_crypto_charts',
            'category' => esc_html__('STM', 'crypterio'),
            'params' => array(
                array(
                    'type' => 'autocomplete',
                    'heading' => esc_html__('Select currency', 'crypterio'),
                    'param_name' => 'cur_names',
                    'settings' => array(
						'multiple' => true,
                        'sortable' => true,
                        'min_length' => 1,
                        'no_hide' => false,
                        'unique_values' => true,
                        'display_inline' => true,
                        'values' => $list
                    )
                ),
                array(
                    'type' => 'dropdown',
                    'heading' => esc_html__('Default period', 'crypterio'),
                    'param_name' => 'period',
                    'value' => array(
                        esc_html__('1 day', 'crypterio') => '1 day',
                        esc_html__('1 week', 'crypterio') => '1 week',
                        esc_html__('1 month', 'crypterio') => '1 month',
                        esc_html__('1 year', 'crypterio') => '1 year',
                        esc_html__('All', 'crypterio') => 'all',
                    ),
					'std' => '1 day'
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('Height', 'crypterio'),
                    'param_name' => 'height',
                    'std' => 400
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('Width', 'crypterio'),
                    'param_name' => 'width',
                    'std' => 1200
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('USD price decimals number', 'crypterio'),
                    'param_name' => 'usd_decimals',
                    'std' => 3,
                    'value' => 3
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('BTC price decimals number', 'crypterio'),
                    'param_name' => 'btc_decimals',
                    'std' => 8,
                    'value' => 8
                ),
                array(
                    'type' => 'colorpicker',
                    'heading' => esc_html__('USD chart fill color', 'crypterio'),
                    'param_name' => 'usd_fill_color',
                    'std' => 'rgba(0,0,0,0)'
                ),
                array(
                    'type' => 'colorpicker',
                    'heading' => esc_html__('USD chart border color', 'crypterio'),
                    'param_name' => 'usd_border_color',
                    'std' => '#333333'
                ),
                array(
                    'type' => 'colorpicker',
                    'heading' => esc_html__('BTC chart fill color', 'crypterio'),
                    'param_name' => 'btc_fill_color',
                    'std' => 'rgba(0,0,0,0)'
                ),
                array(
                    'type' => 'colorpicker',
                    'heading' => esc_html__('BTC chart border color', 'crypterio'),
                    'param_name' => 'btc_border_color',
                    'std' => '#333333'
                ),
                array(
                    'type' => 'checkbox',
                    'heading' => esc_html__('Inverse grid colors', 'crypterio'),
                    'param_name' => 'inverse',
                    'std' => ''
                ),
                array(
                    'type' => 'checkbox',
                    'heading' => esc_html__('Show periods', 'crypterio'),
                    'param_name' => 'show_periods',
                    'std' => ''
                ),
                array(
                    'type' => 'css_editor',
                    'heading' => esc_html__('Css', 'crypterio'),
                    'param_name' => 'css',
                    'group' => esc_html__('Design options', 'crypterio')
                ),
                array(
                    'type' => 'textfield',
                    'heading' => esc_html__('Cache expiration in ms', 'crypterio'),
                    'param_name' => 'transient',
                    'std' => 3600
                ),
            )
        )
    );

    class WPBakeryShortCode_Stm_Crypto_Charts extends WPBakeryShortCode
    {
    }
}


add_action('wp_ajax_nopriv_crypterio_get_currency_data', 'crypterio_get_currency_data');
add_action('wp_ajax_crypterio_get_currency_data', 'crypterio_get_currency_data');

function crypterio_get_currency_data()
{
    check_ajax_referer('crypterio_get_currency_data', 'security');
    $currency = '';
    if(!empty($_GET['currency'])){
        $currency = sanitize_text_field($_GET['currency']);
    }
    $currency = strtolower($currency);
    $currency = sanitize_title($currency, 'bitcoin');
    if($currency == 'XRP') $currency = 'ripple';

    $period_timestamp = !empty($_GET['periodTimestamp']) ? sanitize_text_field($_GET['periodTimestamp']) : '';
    $period = !empty($_GET['period']) ? sanitize_text_field($_GET['period']) : '';
    $transient_name = 'stm_crypto_charts_' . $currency . '_' . $period;
    $transient_expiration = !empty($_GET['transient_exp']) ? sanitize_text_field($_GET['transient_exp']) : 3600;
    $data = get_transient($transient_name);
    if (false === $data) {
        $url = 'https://graphs2.coinmarketcap.com/currencies/' . $currency . '/' . $period_timestamp;
        $data = wp_remote_get($url);
        if (!is_wp_error($data)) {
            if ($data['response']['code'] === 200) {
                $data = (array)json_decode($data['body']);
                $data['responseCode'] = 200;
                set_transient($transient_name, $data, $transient_expiration);
            } else {
                $data['responseCode'] = 500;
            }
        }
    }

    wp_send_json($data);
}