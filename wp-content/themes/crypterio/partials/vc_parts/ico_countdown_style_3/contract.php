<?php
$theme_info = CRYPTERIO_THEME_VERSION;
$assets = get_template_directory_uri().'/inc/admin/announcement/assets/';
wp_enqueue_script( 'vue.js', $assets.'vue.min.js', null, $theme_info, true );
wp_enqueue_script( 'vue-resource.js', $assets.'vue-resource.js', array( 'vue.js' ), $theme_info, true );
wp_enqueue_script( 'vue-select.js', get_template_directory_uri().'/assets/js/vue-select.js', array( 'vue.js' ), $theme_info, true );
wp_enqueue_script( 'web3.js', get_template_directory_uri().'/assets/js/web3.min.js', null, $theme_info, true );
wp_enqueue_script( 'stm_web3.js', get_template_directory_uri().'/assets/js/vc/contract.js', null, $theme_info, true );

wp_enqueue_script( 'kinetic' );
wp_enqueue_script( 'final_countdown' );

wp_enqueue_style( 'stm_contract', get_template_directory_uri().'/assets/css/shared/vc/stm_contract.css', null, $theme_info );
if( class_exists( 'VCW_Data' ) && method_exists('VCW_Data', 'coin')) {
    $attributes = '';
    if( !empty( $ico_bg_image ) ) {
        $ico_bg_image = crypterio_get_image_url( $ico_bg_image );
        $attributes = "style='background-image: url(\"{$ico_bg_image}\")'";
    }

    $link = vc_build_link( $link );
    if( empty( $link[ 'target' ] ) ) {
        $link[ 'target' ] = '_self';
    }

    if( !empty( $custom_links ) ) {
        $custom_links = vc_value_from_safe( $custom_links );
        $custom_links = explode( ',', $custom_links );
    }

    if( !empty( $payments ) ) $payments = explode( ',', $payments );

    $descriptions = array(
        'amount' => $popup_amount_desc,
        'wallet' => $popup_wallet_desc,
        'front_photo' => $popup_passport_desc,
        'agreement_1' => $popup_agreement_desc_1,
        'agreement_2' => $popup_agreement_desc_2,
    );

    $user_data = crypterio_white_list_data( $descriptions );
    $countries_data = crypterio_get_countries();
    $countries = array();
    foreach( $countries_data as $country ) {
        $countries[] = $country[ 'name' ];
    }
    $currencies_info = crypterio_get_cmc_data();

    $eth_id = crypterio_get_coin_id( 'Ethereum' );
    $cur_name_id = crypterio_get_coin_id( $cur_name );
    $cur_name2_id = crypterio_get_coin_id( $cur_name_2 );

    $eth = VCW_Data::coin( $eth_id );
    $currencie_1 = VCW_Data::coin( $cur_name_id );
    $currencie_2 = VCW_Data::coin( $cur_name2_id );
    $currencie_1_rate = $currencie_1[ 'price' ][ 'usd' ];
    $currencie_2_rate = $currencie_2[ 'price' ][ 'usd' ];
    $eth_sum = $eth[ 'price' ][ 'usd' ];
    if( empty( $round ) ) {
        $round = 2;
    }
    ?>

    <script type="text/javascript">
        var stm_contract_data = {
            'contract': '<?php echo esc_js( $contract ) ?>',
            'softcap': '<?php echo esc_js( $softcap ); ?>',
            'softcap_label': '<?php echo esc_js( $softcap_label ); ?>',
            'softcap_label_2': '<?php echo esc_js( $softcap_label_2 ); ?>',
            'hardcap': '<?php echo esc_js( $hardcap ); ?>',
            'hardcap_label': '<?php echo esc_js( $hardcap_label ); ?>',
            'hardcap_label_2': '<?php echo esc_js( $hardcap_label_2 ); ?>',
            'eth_rate': '<?php echo esc_js( crypterio_get_crypto_rate() ); ?>',
            'user_data': <?php echo json_encode( $user_data ); ?>,
            'countries': <?php echo json_encode( $countries ); ?>,
            'currencie_1_rate': '<?php echo esc_js( $currencie_1_rate ) ?>',
            'currencie_2_rate': '<?php echo esc_js( $currencie_2_rate ) ?>',
            'round': '<?php echo esc_js( $round ) ?>',
            'i18n': {
                'upload': '<?php esc_html_e( 'Upload', 'crypterio' ); ?>',
                'remove': '<?php esc_html_e( 'Remove', 'crypterio' ); ?>',
            }
        };

    </script>

    <div class="stm_ico_countdown stm_ico_countdown__contract <?php echo esc_attr( $css_class ); ?> <?php echo esc_attr( $style ); ?>"
         id="buy_tokens">
        <div class="stm_ico_countdown__bg" <?php echo sanitize_text_field( $attributes ); ?>></div>
        <div class="stm_countdown_wrap" id="crypterio-contract">
            <div class="stm_left_countdown">
                <?php if( !empty( $title ) ): ?>
                    <div class="stm_ico_countdown__title_wrap">
                        <h4 class="stm_ico_countdown__title">
                            <?php echo wp_kses_post( $title ); ?>
                        </h4>
                    </div>
                <?php endif; ?>

                <?php if( !empty( $countdown ) ):
                    $count = rand( 0, 999999 );
                    ?>
                    <div class="countdown_box">

                        <?php
                        $seconds_left = intval( strtotime( $countdown ) - strtotime( current_time( 'mysql' ) ) );
                        $max_time = 8553600;
                        if( $seconds_left > $max_time ) $seconds_left = $max_time;
                        ?>
                        <div id="countdown<?php echo esc_attr( $count ); ?>" class="container countdown-wrap">
                            <div class="clock row">
                                <div class="clock-item clock-days countdown-time-value col-xs-3">
                                    <div class="wrap">
                                        <div class="inner">
                                            <div id="canvas-days" class="clock-canvas"></div>

                                            <div class="text">
                                                <p class="val">0</p>
                                                <p class="type-days type-time"><?php echo esc_html( 'days', 'crypterio' ); ?></p>
                                            </div><!-- /.text -->
                                        </div><!-- /.inner -->
                                    </div><!-- /.wrap -->
                                </div><!-- /.clock-item -->

                                <div class="clock-item clock-hours countdown-time-value col-xs-3">
                                    <div class="wrap">
                                        <div class="inner">
                                            <div id="canvas-hours" class="clock-canvas"></div>

                                            <div class="text">
                                                <p class="val">0</p>
                                                <p class="type-hours type-time"><?php echo esc_html( 'hours', 'crypterio' ); ?></p>
                                            </div><!-- /.text -->
                                        </div><!-- /.inner -->
                                    </div><!-- /.wrap -->
                                </div><!-- /.clock-item -->

                                <div class="clock-item clock-minutes countdown-time-value col-xs-3">
                                    <div class="wrap">
                                        <div class="inner">
                                            <div id="canvas-minutes" class="clock-canvas"></div>

                                            <div class="text">
                                                <p class="val">0</p>
                                                <p class="type-minutes type-time"><?php echo esc_html( 'minutes', 'crypterio' ); ?></p>
                                            </div><!-- /.text -->
                                        </div><!-- /.inner -->
                                    </div><!-- /.wrap -->
                                </div><!-- /.clock-item -->

                                <div class="clock-item clock-seconds countdown-time-value col-xs-3">
                                    <div class="wrap">
                                        <div class="inner">
                                            <div id="canvas-seconds" class="clock-canvas"></div>

                                            <div class="text">
                                                <p class="val">0</p>
                                                <p class="type-seconds type-time"><?php echo esc_html( 'seconds', 'crypterio' ); ?></p>
                                            </div><!-- /.text -->
                                        </div><!-- /.inner -->
                                    </div><!-- /.wrap -->
                                </div><!-- /.clock-item -->
                            </div><!-- /.clock -->
                        </div><!-- /.countdown-wrapper -->

                        <script type="text/javascript">
                            var clock;

                            jQuery(document).ready(function () {
                                var $ = jQuery;
                                var flash = false;
                                var ts = <?php echo strtotime( $countdown ) * 1000; ?>;
                                var currentTime = <?php echo strtotime( current_time( 'mysql' ) ); ?>;
                                if ((new Date()) < ts) {
                                    setTimeout(function () {
                                        $('#countdown<?php echo esc_js( $count ); ?>').final_countdown({
                                            'start': (ts / 1000) - 8553600,
                                            'end': ts / 1000,
                                            'now': currentTime,
                                            seconds: {
                                                borderColor: '#34bbff',
                                                borderWidth: '3'
                                            },
                                            minutes: {
                                                borderColor: '#34bbff',
                                                borderWidth: '3'
                                            },
                                            hours: {
                                                borderColor: '#34bbff',
                                                borderWidth: '3'
                                            },
                                            days: {
                                                borderColor: '#34bbff',
                                                borderWidth: '3'
                                            }
                                        });
                                    }, 300)
                                } else {
                                    $('#countdown_<?php echo esc_attr( $count ); ?>').html('<div class="countdown_ended h2"><?php esc_html__( "Time is up, sorry!", "crypterio" ); ?></div>');
                                }
                            });
                        </script>
                    </div>
                <?php else: ?>
                    <?php esc_html_e( 'Time is up, sorry!', 'crypterio' ); ?>
                <?php endif; ?>
                <div class="stm_ico_countdown__progress">
                    <div class="inner">

                        <div class="stm_ico_countdown__softcap">
                            <div class="stm_ico_countdown__softcap_label">
                                <?php if( !empty( $price_label_1 ) ): ?>
                                    <?php echo esc_html( $price_label_1 ); ?>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="stm_ico_countdown__progress_bar">
                            <div class="stm_ico_countdown__progress_completed"
                                 v-bind:style="{ width: contract_data.completed + '%' }"></div>
                        </div>

                        <div class="stm_ico_countdown__hardcap">
                            <div class="stm_ico_countdown__hardcap_label">
                                {{contract_data.hardcap_label}}
                            </div>
                            <div class="stm_ico_countdown__progress_holder"></div>
                            <div class="stm_ico_countdown__hardcap_label_2">
                                {{contract_data.hardcap_label_2}}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="stm_right_countdown">
                <div>

                    <div class="stm_ico_countdown__links">
                        <div class="stm_countdown_top_part">
                            <div class="stm_raised_currencies">
                                <?php crypterio_display_currency_image( 'Ethereum' ); ?>
                                <div class="stm_raised_val">{{balance.toFixed(contract_data.round)}}</div>
                                <div class="stm_raised_text"><?php echo esc_html( 'ETH raised', 'crypterio' ); ?></div>
                            </div>
                            <div class="stm_raised_currencies">
                                <?php crypterio_display_currency_image( $cur_name ); ?>
                                <div class="stm_raised_val">{{raised_currency_1}}</div>
                                <div class="stm_raised_text"><?php echo esc_html( $currencie_1[ 'symbol' ] ).' '.esc_html__( 'raised', 'crypterio' ); ?></div>
                            </div>
                            <div class="stm_raised_currencies">
                                <?php crypterio_display_currency_image( $cur_name_2 ); ?>
                                <div class="stm_raised_val">{{raised_currency_2}}</div>
                                <div class="stm_raised_text"><?php echo esc_html( $currencie_2[ 'symbol' ] ).' '.esc_html__( 'raised', 'crypterio' ); ?></div>
                            </div>
                        </div>
                        <div class="stm_countdown_bot_part">
                            <?php if( !empty( $price_description ) ): ?>
                                <div class="price_description"><span
                                            style="font-weight: 400;"><?php esc_html_e( 'Raised:', 'crypterio' ); ?></span>
                                    {{contract_data.balance_usd}}
                                </div>
                            <?php endif; ?>
                            <?php if( !empty( $link[ 'title' ] ) ): ?>
                                <a href="#"
                                   target="<?php echo esc_attr( $link[ 'target' ] ) ?>"
                                   v-on:click="openPopup($event)"
                                   class="stm_ico_countdown__button stm_ico_countdown__button__popup"
                                   title="<?php echo esc_attr( $link[ 'title' ] ) ?>">
                                    <?php echo esc_attr( $link[ 'title' ] ) ?>
                                    <i class="stm-stm-right-long-arrow"></i>
                                </a>
                            <?php endif; ?>
                        </div>

                    </div>

                    <div class="stm_ico_countdown__popup_overlay" v-on:click="openPopup($event)"
                         v-bind:class="{'active' : popup}"></div>
                    <div class="stm_ico_countdown__popup" v-bind:class="{'active' : popup}">
                        <div class="container">
                            <div class="stm_ico_countdown__popup_inner" v-bind:class="{'completed' : completed}">
                                <div class="stm_ico_countdown__popup_inner_content"
                                     v-bind:class="{'completed' : completed}">
                                    <div class="stm_ico_countdown__popup_close" v-on:click="openPopup($event)"></div>
                                    <?php if( !empty( $popup_title_contract ) ): ?>
                                        <div class="stm_ico_countdown__popup_title h3">
                                            <?php echo sanitize_text_field( $popup_title_contract ); ?>
                                        </div>
                                    <?php endif; ?>

                                    <?php if( !empty( $popup_subtitle ) ): ?>
                                        <div class="stm_ico_countdown__popup_subtitle">
                                            <?php echo sanitize_text_field( $popup_subtitle ); ?>
                                        </div>
                                    <?php endif; ?>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group"
                                                 v-for="(info, name, index) in contract_data.user_data">
                                                <div v-if="index%2 == 0">
                                                    <?php get_template_part( 'partials/vc_parts/ico_countdown/contract_vue/inputs' ); ?>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label><?php esc_html_e( 'Country of Citizenship', 'crypterio' ); ?></label>
                                                <v-select v-model="contract_data.user_data['country'].value"
                                                          label="countryName"
                                                          :options="contract_data.countries"></v-select>
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group"
                                                 v-for="(info, name, index) in contract_data.user_data">
                                                <div v-if="Math.abs(index % 2) == 1">
                                                    <?php get_template_part( 'partials/vc_parts/ico_countdown/contract_vue/inputs' ); ?>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <hr/>
                                    <div class="row agreements">
                                        <div class="col-md-6">
                                            <label>
                                                <input type="checkbox" v-model="agreement_1"/>
                                                <p><?php echo wp_kses_post( $descriptions[ 'agreement_1' ] ); ?></p>
                                            </label>
                                        </div>
                                        <div class="col-md-6">
                                            <label>
                                                <input type="checkbox" v-model="agreement_2"/>
                                                <p><?php echo wp_kses_post( $descriptions[ 'agreement_2' ] ); ?></p>
                                            </label>

                                            <?php
                                            $recaptcha_enabled = get_theme_mod( 'enable_recaptcha', 0 );
                                            $recaptcha_public_key = get_theme_mod( 'recaptcha_public_key' );
                                            $recaptcha_secret_key = get_theme_mod( 'recaptcha_secret_key' );
                                            ?>

                                            <?php if( !empty( $recaptcha_enabled ) and $recaptcha_enabled and !empty( $recaptcha_public_key ) and !empty( $recaptcha_secret_key ) ) : ?>
                                                <?php
                                                wp_enqueue_script( 'stm_grecaptcha' );
                                                wp_enqueue_script( 'vue-recaptcha', get_template_directory_uri().'/assets/js/vc/vue-recaptcha.js', array( 'stm_grecaptcha' ), CRYPTERIO_THEME_VERSION );
                                                ?>
                                                <div class="input-group">
                                                    <vue-recaptcha
                                                            @verify="onCaptchaVerified"
                                                            @expired="onCaptchaExpired"
                                                            sitekey="<?php echo esc_attr( $recaptcha_public_key ); ?>">
                                                    </vue-recaptcha>
                                                </div>

                                                <p class="stm_input_alert" v-html="captcha_error"
                                                   v-if="captcha_error"></p>
                                            <?php endif; ?>

                                            <button type="submit"
                                                    v-on:click="submitData()"
                                                    v-bind:class="{'active' : agreement_1 && agreement_2}"
                                                    class="vc_general vc_btn3 vc_btn3-size-md vc_btn3-shape-round vc_btn3-style-custom">
                                                <span><?php esc_html_e( 'Submit', 'crypterio' ); ?></span>
                                                <i class="fas fa-refresh fa-spin" v-if="submitting"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="popup-message" v-bind:class="{'completed' : completed}"
                                     v-html="completed"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <?php if( !empty( $payments ) and !empty( $custom_links ) ): ?>
            <div class="stm_ico_countdown__payments">
                <?php foreach( $payments as $key => $payment ):
                    $post_thumbnail = wpb_getImageBySize( array(
                        'attach_id' => $payment,
                        'thumb_size' => '58x33',
                    ) );
                    $post_thumbnail = $post_thumbnail[ 'thumbnail' ];
                    $href = ( !empty( $custom_links[ $key ] ) ) ? $custom_links[ $key ] : '#';
                    ?>
                    <a href="<?php echo esc_url( $href ); ?>" target="_blank" class="stm_ico_countdown__payment">
                        <?php echo html_entity_decode( $post_thumbnail ); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

    </div>
<?php }