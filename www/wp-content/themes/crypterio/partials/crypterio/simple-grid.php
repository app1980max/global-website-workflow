<?php
$currencies = crypterio_get_user_crypto( 'name' );

$currency_format = 'price';

if( !empty( $currencies ) && class_exists( 'VCW_Data' ) && method_exists( 'VCW_Data', 'coin' ) ): ?>
    <div class="stm_currencies_simple_grid">
        <?php foreach( $currencies as $currency_name ): ?>
            <?php
            if( $currency_name == 'Ripple' ) $currency_name = 'XRP';
            $currency_id = crypterio_get_coin_id( $currency_name );
            if( empty( $currency_id ) ) continue;
            $currency_info = VCW_Data::coin( $currency_id );
            if( empty( $currency_info[ 'id' ] ) ) continue;
            ?>
            <div class="scsl__single">
                <div class="inner">

                    <?php if( !empty( $currency_info ) ):
                        $change_1h = ( $currency_info[ 'change_1h' ] < 0 ) ? 'minus' : 'plus';
                        $change_24h = ( $currency_info[ 'change_24h' ] < 0 ) ? 'minus' : 'plus';
                        $change_7d = ( $currency_info[ 'change_7d' ] < 0 ) ? 'minus' : 'plus';
                        $income = ( $currency_info[ $currency_format ][ 'usd' ] * $currency_info[ 'change_24h' ] ) / 100;
                        ?>

                        <div class="scsl__name">
                            <?php echo sanitize_text_field( $currency_info[ 'name' ] ); ?>
                            <span class="scsl__income scsl__change_<?php echo esc_attr( $change_24h ); ?>"><?php echo crypterio_price_view( $income, ' ' ); ?></span>
                        </div>

                        <div class="scsl__price">
                            <?php echo crypterio_price_view( $currency_info[ $currency_format ][ 'usd' ] ); ?>
                            <span class="scsl__change_<?php echo esc_attr( $change_24h ); ?>"><?php echo sanitize_text_field( $currency_info[ 'change_24h' ] ); ?>
                                %</span>
                        </div>

                        <div class="scsl__time">
                            <?php echo crypterio_price_view( crypterio_get_coin_cap( $currency_id ) ); ?>
                        </div>


                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif;