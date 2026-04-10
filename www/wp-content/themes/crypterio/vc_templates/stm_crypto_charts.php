<?php
if( class_exists( 'VCW_Data' ) ) {
    $atts = vc_map_get_attributes( $this->getShortcode(), $atts );
    extract( $atts );
    $css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );

    $assets_path = get_template_directory_uri() . '/assets';
    wp_enqueue_script( 'stm_moment', $assets_path . '/js/moment.js' );

    wp_enqueue_script( 'chartjs', $assets_path . '/js/chartjs.js' );
    wp_enqueue_script( 'stm_crypto_chart', $assets_path . '/js/vc/crypto_chart.js', array( 'jquery' ), CRYPTERIO_THEME_VERSION );
    wp_enqueue_style( 'stm_crypro_chart', $assets_path . '/css/shared/vc/stm_crypro_chart.css', array(), CRYPTERIO_THEME_VERSION );

    $classes = array(
        'stm_crypto_chart'
    );
    $all_currencies = crypterio_get_cmc_data();
    $selected_currencies = array();
    $cur_names = explode( ', ', $cur_names );
    foreach( $cur_names as $cur_name ) {
        if( isset( $all_currencies[ $cur_name ] ) && !empty( $all_currencies[ $cur_name ] ) ) {
            $selected_currencies[] = $all_currencies[ $cur_name ][ 'name' ];
        }

    }
    $colors = array(
        'btc' => array(
            'fill' => !empty( $btc_fill_color ) ? $btc_fill_color : 'rgba(0,0,0,0)',
            'border' => $btc_border_color
        ),
        'usd' => array(
            'fill' => !empty( $usd_fill_color ) ? $usd_fill_color : 'rgba(0,0,0,0)',
            'border' => $usd_border_color
        )
    );
    $decimals = array(
        'btc' => $btc_decimals,
        'usd' => $usd_decimals
    );
    $inverted = !empty( $inverse );
    if( $inverted ) {
        $classes[] = 'contrast';
    }

    $period = '1 year';

    $periods = array(
        '1 day' => array(
            'class' => 'day',
            'text' => esc_html__( 'day', 'crypterio' )
        ),
        '1 week' => array(
            'class' => 'week',
            'text' => esc_html__( 'week', 'crypterio' )
        ),
        '1 month' => array(
            'class' => 'month',
            'text' => esc_html__( 'month', 'crypterio' )
        ),
        '1 year' => array(
            'class' => 'year',
            'text' => esc_html__( 'year', 'crypterio' )
        ),
        'all' => array(
            'class' => 'all',
            'text' => esc_html__( 'all', 'crypterio' )
        ),
    );
    ?>


    <div class="<?php echo implode( ' ', $classes ); ?>"
         data-colors="<?php echo esc_attr( json_encode( $colors ) ); ?>"
         data-cache-expiration="<?php echo esc_attr( $transient ); ?>"
         data-decimals="<?php echo esc_attr( json_encode( $decimals ) ); ?>"
         data-period="<?php echo esc_attr( $period ); ?>"
         data-contrast="<?php echo esc_attr( json_encode( $inverted ) ); ?>"
         data-currencies="<?php echo esc_attr( json_encode( array_values( $selected_currencies ) ) ); ?>">

        <?php if( count( $cur_names ) > 1 ) : ?>

            <div class="stm_crypto_chart__toolbar">
                <select class="stm_crypto_chart__currency">
                    <?php foreach( $selected_currencies as $selected_currencie ) : ?>
                        <option value="<?php echo wp_kses_post( $selected_currencie ); ?>">
                            <?php echo wp_kses_post( $selected_currencie ); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        <?php endif; ?>

        <div class="stm_crypto_chart__error">
            <span><?php echo esc_html__( 'Request failed', 'crypterio' ); ?></span>
            <button><?php echo esc_html__( 'Retry', 'crypterio' ); ?></button>
        </div>
        <div class="stm_crypto_chart__preloader">
            <div class="loader">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>

        <canvas width="<?php echo intval( $width ); ?>" height="<?php echo intval( $height ); ?>"></canvas>
        <div class="stm_crypto_chart__periods <?php echo empty( $show_periods ) ? 'hidden' : '' ?>">
            <?php
            foreach( $periods as $period_key => $period_val ) {
                $period_classes = array( $period_val[ 'class' ] );
                if( $period_key === $period ) {
                    $period_classes[] = 'active';
                }
                ?>
                <span class="<?php echo esc_attr( implode( ' ', $period_classes ) ); ?>"
                      data-period="<?php echo esc_attr( $period_key ); ?>"
                >
                    <?php echo wp_kses_post( $period_val[ 'text' ] ); ?>
                </span>
                <?php
            }
            ?>
        </div>
    </div>
<?php }