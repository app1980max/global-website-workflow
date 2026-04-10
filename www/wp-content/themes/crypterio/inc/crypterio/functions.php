<?php
require_once CRYPTERIO_INC_PATH.'/crypterio/graph.php';
require_once CRYPTERIO_INC_PATH.'/crypterio/converter.php';

function crypterio_get_cmc_data( $data = 'cryptocurrencies' )
{
    if(!class_exists('VCW_Data') || !method_exists('VCW_Data', 'rates')) return array();
    $datas = VCW_Data::rates();

//	if (!empty($datas)) $datas = unserialize($datas);

//	$datas = (!empty($datas['data'])) ? $datas['data'] : '';

//	if (!empty($datas)) {
//		if (!empty($datas[$data])) {
//			$datas = $datas[$data];
//		}
//	}

	if ($data == 'cryptocurrencies') {
		$cmc = array();
		if (!empty($datas)) {
			foreach ($datas as $data) {
                if(!empty($data) && !empty($data['unit'])){
                    $key = $data['unit'];
                    if($key){
                        $cmc[$key] = $data;
                        $cmc[$key]['price_usd'] = 0;
                        $cmc[$key]['market_cap_usd'] = 0;
                        $cmc[$key]['change_24h'] = 0;
                        $cmc[$key]['change_1h'] = 0;
                        $cmc[$key]['change_7d'] = 0;
                    }
                }
			}
		}
		$datas = $cmc;
	}

    return $datas;
}

function crypterio_get_rates( $crypto = 'USD' )
{
    if(!class_exists('VCW_Data') || !method_exists('VCW_Data', 'rates')) return array();
    $datas = VCW_Data::rates();

    $datas = ( !empty( $datas ) ) ? $datas : '';

    return ( !empty( $datas[ $crypto ][ 'value' ] ) ) ? $datas[ $crypto ][ 'value' ] : '';
}

function crypterio_get_crypto_rate( $crypto = 'ETH' )
{
    $usd = crypterio_get_rates();

    $crypto = crypterio_get_rates( $crypto );

    return $usd / $crypto;
}

function crypterio_get_crypto_data( $name )
{
    $cryptos = crypterio_get_cmc_data();
    if( !empty( $cryptos ) and !empty( $cryptos[ $name ] ) ) {
        return $cryptos[ $name ];
    }

    return array();
}
function crypterio_get_user_crypto($format = 'code')
{
    $currencies = array();
    $currencies_code = array();
    $crypto = get_theme_mod( 'crypto' );
    if( !empty( $crypto ) ) {
        $currencies = array_filter( explode( ', ', $crypto ) );
    }
    if($format == 'code'){
        $all_currencies = crypterio_get_cmc_data();
        foreach( $all_currencies as $currency ) {
            if(in_array($currency['name'], $currencies) ){
                $index = array_search($currency['name'], $currencies);
                if($index){
                    $currencies[$index] = $currency['unit'];
                }
            }
        }
    }

    return apply_filters( 'crypterio_get_user_crypto', $currencies );
}

function crypterio_get_coin_id($name = ''){
    if(!class_exists('VCW_Data') || !method_exists('VCW_Data', 'coinList')) return '';
    $list = VCW_Data::coinList();
    $id = '';
    foreach($list as $item){
        if($name == $item['name']) return $item['id'];
    }
    return $id;
}
function crypterio_price_view( $price, $symbol = '', $position = 'left', $th_sep = ',', $float_sep = '.', $float = 2 )
{
    if( empty( $symbol ) ) $symbol = '$';
    $price = number_format( $price, $float, $float_sep, $th_sep );
    $price = ( $position == 'left' ) ? $symbol.$price : $price.$symbol;
    return sanitize_text_field( $price );
}

function crypterio_get_format()
{
    return 'price_usd';
}

function crypterio_get_btc_format()
{
    return 'price_btc';
}

function crypterio_get_cmc_data_currency()
{
    $transient = 'crypterio_get_cmc_data_currency';
    $json = get_transient( $transient );
    if( false === $json ) {
        $path = get_template_directory().'/assets/ids.json';
        $json = apply_filters( 'crypterio_get_content', $path );

        set_transient( $transient, $json );
    }

    return $json;
}

function crypterio_display_currency_image( $currency )
{
    $cmc = crypterio_get_cmc_data_currency();

    if( !empty( $cmc ) and !empty( $cmc[ $currency ] ) ) {
        //echo '<img src="https://files.coinmarketcap.com/static/img/coins/32x32/' . $cmc[$currency] . '.png" />';
        echo '<img src="https://s2.coinmarketcap.com/static/img/coins/32x32/'.$cmc[ $currency ].'.png"/>';
    }
}

function crypterio_white_list_data( $descriptions = array(
    'wallet' => '',
    'front_photo' => '',
    'amount' => '',
) )
{
    $user_data = array(
        'first_name' => array(
            'label' => esc_html__( 'First name', 'crypterio' ),
            'type' => 'text',
            'value' => '',
        ),
        'email' => array(
            'label' => esc_html__( 'Email', 'crypterio' ),
            'type' => 'email',
            'value' => '',
        ),
        'last_name' => array(
            'label' => esc_html__( 'Last name', 'crypterio' ),
            'type' => 'text',
            'value' => '',
        ),
        'amount' => array(
            'label' => esc_html__( 'Expected ETH ICO Participation Amount', 'crypterio' ),
            'type' => 'number',
            'value' => '',
            'description' => $descriptions[ 'amount' ]
        ),
        'wallet' => array(
            'label' => esc_html__( 'ERC-20 Wallet Address', 'crypterio' ),
            'type' => 'text',
            'value' => '',
            'description' => $descriptions[ 'wallet' ]
        ),
        'front_photo' => array(
            'label' => esc_html__( 'Government-Issued ID Card or Passport', 'crypterio' ),
            'type' => 'file',
            'option_type' => 'image_preview',
            'value' => '',
            'description' => $descriptions[ 'front_photo' ]
        ),
        'country' => array(
            'label' => esc_html__( 'Country', 'crypterio' ),
            'show' => 'hide',
            'type' => 'text',
            'value' => ''
        ),
    );

    return apply_filters( 'crypterio_white_list_data', $user_data );
}

function crypterio_get_countries()
{

    $transient_name = 'stm_countries';
    if( false === ( $json_file = get_transient( $transient_name ) ) ) {
        global $wp_filesystem;

        if( empty( $wp_filesystem ) ) {
            require_once ABSPATH.'/wp-admin/includes/file.php';
            WP_Filesystem();
        }

        $json_file = get_template_directory().'/assets/js/countries.json';
        $json_file = json_decode( $wp_filesystem->get_contents( $json_file ), true );

        set_transient( $transient_name, $json_file );
    }

    return apply_filters( 'crypterio_get_countries', $json_file );
}

function crypterio_check_recaptcha( $recaptcha_name = 'recaptcha' )
{

    $r = true;

    $recaptcha_enabled = get_theme_mod( 'enable_recaptcha', 0 );
    $recaptcha_public_key = get_theme_mod( 'recaptcha_public_key' );
    $recaptcha_secret_key = get_theme_mod( 'recaptcha_secret_key' );

    if( !empty( $recaptcha_enabled ) and $recaptcha_enabled and !empty( $recaptcha_public_key ) and !empty( $recaptcha_secret_key ) ) {
        $crypterio_recaptcha_name = '';
        if(!empty($_POST[ $recaptcha_name ])){
            $crypterio_recaptcha_name = sanitize_text_field($_POST[ $recaptcha_name ]);
        }
        $post_data = http_build_query(
            array(
                'secret' => $recaptcha_secret_key,
                'response' => $crypterio_recaptcha_name,
                'remoteip' => apply_filters( 'crypterio_recaptcha_remote_address', $remote_ad = '' )
            )
        );
        $opts = array( 'http' =>
            array(
                'method' => 'POST',
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'content' => $post_data
            )
        );
        $context = stream_context_create( $opts );
        $response = apply_filters( 'crypterio_recaptcha_get_content', $context );
        $result = json_decode( $response );

        if( !$result->success ) {
            $r = false;
        }
    }
    return $r;


}


function crypterio_ico_progress( $metas, $divider = '/' )
{
    if( empty( $metas[ 'raised' ] ) and empty( $metas[ 'hardcap' ] ) and empty( $metas[ 'softcap' ] ) ): ?>
        <div class="stm_ico_goal">
            <span><?php esc_html_e( 'Goal:', 'crypterio' ); ?></span>
            <?php esc_html_e( 'Not set', 'crypterio' ); ?>
        </div>
    <?php elseif( empty( $metas[ 'raised' ] ) and ( !empty( $metas[ 'hardcap' ] ) or !empty( $metas[ 'softcap' ] ) ) ):
        $goal = ( !empty( $metas[ 'softcap' ] ) ) ? $metas[ 'softcap' ] : $metas[ 'hardcap' ];
        ?>
        <div class="stm_ico_goal">
            <span><?php esc_html_e( 'Goal:', 'crypterio' ); ?></span>
            <?php echo esc_attr( $goal ); ?>
        </div>
    <?php else:
        $goal = ( !empty( $metas[ 'softcap' ] ) ) ? $metas[ 'softcap' ] : $metas[ 'hardcap' ];
        $raised = crypterio_remove_but_numbers( $metas[ 'raised' ] );

        if( !empty( $metas[ 'hardcap' ] )
            and !empty( $metas[ 'softcap' ] ) ) {
            $softcap = crypterio_remove_but_numbers( $metas[ 'softcap' ] );
            if( $raised > $softcap ) {
                $goal = $metas[ 'hardcap' ];
            }
        }

        $percent = intval( ( $raised / crypterio_remove_but_numbers( $goal ) ) * 100 );

        ?>
        <div class="stm_ico_goal in_progress">
            <span><?php echo esc_attr( $metas[ 'raised' ] ); ?></span>
            <label><?php echo crypterio_sanitize_text_field( $divider ); ?></label>
            <bdo><?php echo esc_attr( $goal ); ?></bdo></i>
            <span class="percent"><?php echo esc_attr( $percent ) ?>%</span>
        </div>
    <?php endif;
}

function crypterio_rates_score()
{
    return apply_filters( 'crypterio_rates_score', array(
        'neutral' => esc_html__( 'Neutral', 'crypterio' ),
        'high' => esc_html__( 'High', 'crypterio' ),
        'medium' => esc_html__( 'Medium', 'crypterio' ),
        'low' => esc_html__( 'Low', 'crypterio' ),
    ) );
}

function crypterio_rates_mark()
{
    return apply_filters( 'crypterio_rates_mark', array(
        'neutral' => 3.5,
        'high' => 5,
        'medium' => 4,
        'low' => 2,
    ) );
}

function crypterio_rates_mark_reversed()
{
    return apply_filters( 'crypterio_rates_mark_reversed', array(
        'neutral' => 2.5,
        'high' => 2,
        'medium' => 3,
        'low' => 5,
    ) );
}

function crypterio_status_score()
{
    return array(
        'live' => esc_html__( 'Active', 'crypterio' ),
        'upcoming' => esc_html__( 'Upcoming', 'crypterio' ),
        'finished' => esc_html__( 'Ended', 'crypterio' ),
    );
}

function crypterio_ico_rate( $metas )
{
    if( !empty( $metas[ 'sponsored' ] ) and $metas[ 'sponsored' ] == 'on' ): ?>
        <div class="stm_ico_rate stm_ico_rate__sponsored">
            <?php esc_html_e( 'Sponsored', 'crypterio' ); ?>
        </div>
    <?php elseif( !empty( $metas[ 'crypterio_rate' ] ) ):
        $rates = crypterio_rates_score();
        ?>
        <div class="stm_ico_rate stm_ico_rate__<?php echo esc_attr( $metas[ 'crypterio_rate' ] ); ?>">
            <?php echo esc_attr( $rates[ $metas[ 'crypterio_rate' ] ] ); ?>
        </div>
    <?php else: ?>
        <div class="stm_ico_rate stm_ico_rate__unrated">
            <?php esc_html_e( 'Not rated', 'crypterio' ); ?>
        </div>
    <?php endif;
}

function crypterio_remove_but_numbers( $value )
{
    return preg_replace( '/[^0-9]/', '', $value );
}

function crypterio_create_wave_road( $road )
{ ?>
    <div class="stm_wave_roadmap__road_content">
        <?php if( !empty( $road[ 'date' ] ) ): ?>
            <div class="stm_wave_roadmap__road_date">
                <div class="stm_wave_roadmap__road_anchor"></div>
                <?php echo esc_attr( $road[ 'date' ] ); ?>
            </div>
        <?php endif; ?>
        <?php if( !empty( $road[ 'description' ] ) ): ?>
            <div class="stm_wave_roadmap__road_description">
                <?php echo esc_attr( $road[ 'description' ] ); ?>
            </div>
        <?php endif; ?>
    </div>
<?php }

function crypterio_check_ico_status( $start_date, $end_date )
{
    $now = time();

    if( !empty( $start_date ) and $start_date > $now ) {
        $status = 'upcoming';
    } elseif( !empty( $start_date )
        and $start_date < $now
        and !empty( $end_date )
        and ( $end_date > $now )
    ) {
        $status = 'live';
    } else {
        $status = 'finished';
    }

    return apply_filters( 'crypterio_check_ico_status', $status );
}

/*Submit ICO Logic*/
function stm_submit_ico_fields( $enabled = array() )
{
    $terms = get_terms( 'stm_ico_listing_category', array(
        'hide_empty' => false,
    ) );

    $terms = wp_list_pluck( $terms, 'name', 'term_id' );

    $fields = array(
        'name' => array(
            'label' => esc_html__( 'Your name', 'crypterio' ),
            'placeholder' => esc_html__( 'Enter your full name', 'crypterio' ),
            'required' => true,
        ),
        'ico_category' => array(
            'label' => esc_html__( 'ICO Category', 'crypterio' ),
            'type' => 'select',
            'choices' => $terms,
            'placeholder' => esc_html__( 'Select ICO category', 'crypterio' ),
            'required' => true,
        ),
        'email' => array(
            'label' => esc_html__( 'Your E-mail', 'crypterio' ),
            'placeholder' => esc_html__( 'Enter Your E-mail', 'crypterio' ),
            'required' => true,
        ),
        'ico_name' => array(
            'label' => esc_html__( 'ICO name', 'crypterio' ),
            'placeholder' => esc_html__( 'Enter ICO name', 'crypterio' ),
            'required' => true,
        ),
        'softcap' => array(
            'label' => esc_html__( 'Fundraising Soft Cap Goal', 'crypterio' ),
            'placeholder' => esc_html__( 'Soft Cap value (ETH)', 'crypterio' ),
            'required' => true,
        ),
        'hardcap' => array(
            'label' => esc_html__( 'Fundraising Hard Cap Goal', 'crypterio' ),
            'placeholder' => esc_html__( 'Hard Cap value (ETH)', 'crypterio' ),
            'required' => true,
        ),
        'token_price' => array(
            'label' => esc_html__( 'Token Price', 'crypterio' ),
            'placeholder' => esc_html__( 'Enter Token Price (ETH)', 'crypterio' ),
            'required' => true,
        ),
        'total_tokens' => array(
            'label' => esc_html__( 'Total Tokens', 'crypterio' ),
            'placeholder' => esc_html__( 'Enter Total Tokens', 'crypterio' ),
            'required' => true,
        ),
        'token_type' => array(
            'label' => esc_html__( 'Token Type', 'crypterio' ),
            'placeholder' => esc_html__( 'Enter Token type', 'crypterio' ),
            'required' => true,
        ),
        'website' => array(
            'label' => esc_html__( 'ICO Website', 'crypterio' ),
            'placeholder' => esc_html__( 'Enter ICO Website Url', 'crypterio' ),
            'required' => true,
        ),
        'start_date' => array(
            'label' => esc_html__( 'Token sale start date', 'crypterio' ),
            'type' => 'date',
            'placeholder' => esc_html__( 'Select start date', 'crypterio' ),
            'required' => true,
        ),
        'paper-plane' => array(
            'label' => esc_html__( 'Telegram group', 'crypterio' ),
            'placeholder' => esc_html__( 'Enter Telegram group URL', 'crypterio' ),
        ),
        'end_date' => array(
            'label' => esc_html__( 'Token sale end date', 'crypterio' ),
            'type' => 'date',
            'placeholder' => esc_html__( 'Select end date', 'crypterio' ),
            'required' => true,
        ),
        'facebook' => array(
            'label' => esc_html__( 'Facebook account', 'crypterio' ),
            'placeholder' => esc_html__( 'Enter Facebook account', 'crypterio' ),
        ),
        'twitter' => array(
            'label' => esc_html__( 'Twitter account', 'crypterio' ),
            'placeholder' => esc_html__( 'Enter Twitter account', 'crypterio' ),
        ),
        'whitelist' => array(
            'label' => esc_html__( 'Is ICO use Whitelist?', 'crypterio' ),
            'type' => 'radio',
            'required' => true,
        ),
        'github' => array(
            'label' => esc_html__( 'Github account', 'crypterio' ),
            'placeholder' => esc_html__( 'Enter Github account', 'crypterio' ),
        ),
        'affiliated' => array(
            'label' => esc_html__( 'Are you affiliated with the ICO?', 'crypterio' ),
            'type' => 'radio',
            'required' => true,
        ),
        'ticker' => array(
            'label' => esc_html__( 'Ticker', 'crypterio' ),
            'placeholder' => esc_html__( 'Enter Ticker', 'crypterio' ),
        ),
        'available_for_token_sale' => array(
            'label' => esc_html__( 'Available for token sale', 'crypterio' ),
            'placeholder' => esc_html__( 'Percent of tokens for sale', 'crypterio' ),
        ),
        'know_your_customer' => array(
            'label' => esc_html__( 'Know your customer?', 'crypterio' ),
            'type' => 'radio',
        ),
        'min_max_personal_cap' => array(
            'label' => esc_html__( 'Min/Max Personal Cap', 'crypterio' ),
            'placeholder' => esc_html__( 'Enter Min/Max Personal Cap', 'crypterio' ),
        ),
        'image_url' => array(
            'label' => esc_html__( 'Image Url', 'crypterio' ),
            'placeholder' => esc_html__( 'Enter URL for ICO icon', 'crypterio' ),
        ),
        'accepts' => array(
            'label' => esc_html__( 'Accepts', 'crypterio' ),
            'placeholder' => esc_html__( 'Ex. ETH, BTC, USD', 'crypterio' ),
        ),
        'token_issue' => array(
            'label' => esc_html__( 'Token Issue', 'crypterio' ),
            'placeholder' => esc_html__( 'Enter token issue', 'crypterio' ),
        ),
        'cant_participate' => array(
            'label' => esc_html__( 'Сant participate', 'crypterio' ),
            'placeholder' => esc_html__( 'Who cant participate', 'crypterio' ),
        ),
        'number_of_team_members' => array(
            'label' => esc_html__( 'Number of team Members', 'crypterio' ),
            'placeholder' => esc_html__( 'Enter Number of team Members', 'crypterio' ),
        ),
        'prototype' => array(
            'label' => esc_html__( 'Prototype', 'crypterio' ),
            'placeholder' => esc_html__( 'Enter Prototype name', 'crypterio' ),
        ),
        'excerpt' => array(
            'label' => esc_html__( 'Description', 'crypterio' ),
            'placeholder' => esc_html__( 'Enter ICO description', 'crypterio' ),
        ),
        'whitepaper' => array(
            'label' => esc_html__( 'Whitepaper', 'crypterio' ),
            'placeholder' => esc_html__( 'Enter Whitepaper link', 'crypterio' ),
        ),
        'team_from' => array(
            'label' => esc_html__( 'Team From', 'crypterio' ),
            'placeholder' => esc_html__( 'Team From', 'crypterio' ),
        ),
        'image' => array(
            'label' => esc_html__( 'Image', 'crypterio' ),
            'type' => 'image',
            'placeholder' => esc_html__( 'Attach Image (Min 760x422px)', 'crypterio' ),
        ),
    );

    foreach( $fields as $field_key => $field ) {
        if( !empty( $enabled[ $field_key ] ) and $enabled[ $field_key ] ) {
            unset( $fields[ $field_key ] );
        }
    }

    return apply_filters( 'stm_submit_ico_fields', $fields );
}


function crypterio_display_posttimeline( $key, $post, $counter )
{
    extract( $post );
    /**
     * @var $id
     * @var $title
     * @var $image
     * @var $year
     * @var $excerpt
     * @var $url
     */
    $post_classes = array(
        'stm_posttimeline__post',
        'stm_posttimeline__post_'.$id,
    );
    $post_classes[] = ( has_post_thumbnail( $id ) ) ? 'has_thumb' : 'no_thumb';
    $post_classes[] = ( $key === 0 ) ? 'main_year' : 'has_year';
    $post_classes[] = get_post_format( $id );
    ?>
<div class="<?php echo esc_attr( implode( ' ', $post_classes ) ); ?>" data-related="<?php echo intval( $year ); ?>"
     data-key="<?php echo intval( $counter ); ?>">
    <?php if( !empty( $post[ 'url' ] ) ): ?>
    <a href="<?php echo esc_url( $url ); ?>"
<?php else: ?>
    <div
<?php endif; ?>
    class="stm_posttimeline__post_inner no_deco ttc">
    <?php if( in_array( 'main_year', $post_classes ) ): ?>
    <div class="stm_posttimeline__year heading_font" data-year="<?php echo intval( $year ); ?>">
        <span><?php echo intval( $year ) ?></span>
    </div>
<?php endif; ?>
    <?php if( !empty( $image ) ): ?>
    <div class="stm_posttimeline__post_image mbc_b">
        <?php echo html_entity_decode( $image ); ?>
    </div>
<?php endif; ?>

    <div class="stm_posttimeline__post_info heading_font">
        <div
                class="stm_posttimeline__post_info-date mtc"><?php echo sanitize_text_field( get_the_date( 'j F', $id ) ); ?></div>
        <div class="stm_posttimeline__post_info-author"
             data-content="<?php esc_html_e( 'By', 'crypterio' ); ?>"><?php the_author(); ?>
            <span><?php echo get_avatar( get_the_author_meta( 'email' ), 174 ); ?></span></div>
    </div>

    <div class="stm_posttimeline__post_title">
        <h5><?php echo sanitize_text_field( $title ); ?></h5>
    </div>
    <div class="stm_posttimeline__post_excerpt"><?php echo sanitize_text_field( $excerpt ); ?></div>
    <?php if( !empty( $post[ 'url' ] ) ): ?>
    </div>
<?php else: ?>
    </div>
<?php endif; ?>
    </div>
<?php }

function crypterio_parts_config()
{
    $parts = array(
        'default' => array(
            'date_or_logo' => 'date',
            'ico_grid' => 'stm_ico_grid',
            'categories' => false
        ),
        'ico_listing' => array(
            'date_or_logo' => 'logo',
            'ico_grid' => 'stm_ico_listing_grid',
            'categories' => true
        )
    );

    $config = crypterio_config();
    $layout = $config[ 'layout' ];


    return ( !empty( $parts[ $layout ] ) ) ? $parts[ $layout ] : $parts[ 'default' ];
}

function crypterio_get_request($url)
{
$request = wp_remote_get($url);

if(is_wp_error($request)) {
    return false;
}

return json_decode(wp_remote_retrieve_body($request), true);
}

function crypterio_get_coin_cap($id)
{
    $transient  = "crypterio_vcw_coingecko_$id";
    $coin       = get_transient($transient);
    if($coin === false) {
        $info = crypterio_get_request("https://api.coingecko.com/api/v3/coins/$id");
        if(is_array($info) && !empty($info['market_data']['market_cap']['usd'])) {
            $coin = $info['market_data']['market_cap']['usd'];
            set_transient($transient, $coin, 60);
            return $coin;
        }
        return null;
    }

    return $coin;
}

/* Updating Cost Calculator settings */
add_action('admin_init', 'cost_calc_imported_content_options');
function cost_calc_imported_content_options() {
    if(defined('CALC_VERSION') && is_admin()) {
        if(get_option('stm_ccb_form_settings_' . sanitize_text_field( '4345' )) == null) {
            $settings_data = cBuilder\Classes\CCBSettingsData::settings_data();
            $settings_data['general']['boxStyle'] = 'horizontal';
            update_option('stm_ccb_form_settings_' . sanitize_text_field( '4345' ), apply_filters('stm_ccb_sanitize_array', $settings_data));
        }
    }
}