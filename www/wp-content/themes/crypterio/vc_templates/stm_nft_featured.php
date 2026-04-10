<?php
/**
 * @var $atts
 * @var $css
 * @var $css_animation
 * @var $image
 * @var $title
 * @var $position
 * @var $css_class
 * @var $crypto_price
 * @var $crypto_price_icon
 * @var $price
 * @var $badge
 * @var $button_link
 * @var $button_text
 */

$assets_path = get_template_directory_uri() . '/assets';

wp_enqueue_style( 'stm_nft_featured', get_template_directory_uri() . '/assets/css/shared/vc/stm_nft_featured.css', array(), CRYPTERIO_THEME_VERSION );
wp_enqueue_script( 'countdown' );

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$classes    = array( 'stm_nft_featured mbc tbdc' );
$classes[]  = $this->getCSSAnimation( $css_animation );
$classes[]  = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
$classes[]  = 'stm_' . $position;
$image_size = '495x495';
$image      = wpb_getImageBySize(
	array(
		'attach_id'  => $image,
		'thumb_size' => $image_size,
	)
);

$count = wp_rand( 0, 999999 );
?>

<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
	<?php if ( ! empty( $image['thumbnail'] ) ) : ?>
		<div class="stm_nft_featured_image">
			<?php echo wp_kses_post( crypterio_sanitize_text_field( $image['thumbnail'] ) ); ?>
		</div>
	<?php endif; ?>
	<div class="stm_nft_featured_info">
		<div class="stm_nft_featured_header">
			<?php if ( ! empty( $title ) ) : ?>
				<span class="stm_nft_featured_title"><?php echo esc_html( $title ); ?></span>
			<?php endif; ?>
			<?php if ( ! empty( $countdown ) ) : ?>
				<div class="countdown_box">
					<div class="stm_countdown" id="countdown_<?php echo esc_attr( $count ); ?>"></div>
				</div>
			<?php endif; ?>
		</div>
		<div class="stm_nft_featured_bottom">
			<div class="stm_nft_featured_price">
				<span class="stm_nft_featured_price_label"><?php echo esc_html__( 'Starter bid:', 'crypterio' ); ?></span>
				<?php if ( ! empty( $crypto_price ) ) : ?>
					<span class="stm_nft_featured_crypto_value stc">
						<?php if ( ! empty( $crypto_price_icon ) ) : ?>
							<i class="<?php echo esc_attr( $crypto_price_icon ); ?>"></i>
						<?php endif; ?>
						<?php echo esc_html( $crypto_price ); ?>
					</span>
				<?php endif; ?>
				<?php if ( ! empty( $price ) ) : ?>
					<span class="stm_nft_featured_value">
						<?php echo esc_html( $price ); ?>
					</span>
				<?php endif; ?>
			</div>
			<?php if ( ! empty( $button_text ) || ! empty( $button_link ) ) : ?>
				<a href="<?php echo esc_attr( $button_link ); ?>" class="stm_nft_featured_btn mtc_h">
					<?php echo esc_html( $button_text ); ?>
				</a>
			<?php endif; ?>
		</div>
	</div>
	<?php if ( 'yes' === $badge ) : ?>
		<div class="stm_nft_featured_live_auction">
			<img src="<?php echo esc_url( $assets_path . '/images/live_auction.png' ); ?>" alt="Live Auction"/>
		</div>
	<?php endif; ?>
</div>

<script type="text/javascript">
	jQuery(function ($) {
		var flash = true;
		var ts = <?php echo esc_html( strtotime( $countdown ) * 1000 ); ?>;
		if ((new Date()) < ts) {
			$('#countdown_<?php echo esc_attr( $count ); ?>').countdown({
				timestamp: ts,
				callback: function (days, hours, minutes, seconds) {
					var summaryTime = days + hours + minutes + seconds;
					if (summaryTime == 0) {
						$('#countdown_<?php echo esc_attr( $count ); ?>').html('<div class="countdown_ended h2"><?php esc_html__( 'Time is up, sorry!', 'crypterio' ); ?></div>');
					}
				}
			});
		} else {
			$('#countdown_<?php echo esc_attr( $count ); ?>').html('<div class="countdown_ended h2"><?php esc_html__( 'Time is up, sorry!', 'crypterio' ); ?></div>');
		}
	});
</script>
