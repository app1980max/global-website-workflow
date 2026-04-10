<?php
/**
 * @var $atts
 * @var $css
 * @var $hide_arrows
 * @var $autoplay
 */
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
$assets_path = get_template_directory_uri() . '/assets';

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );
wp_enqueue_style( 'stm_nft_packs_carousel', get_template_directory_uri() . '/assets/css/shared/vc/stm_nft_packs_carousel.css', array(), CRYPTERIO_THEME_VERSION );
wp_enqueue_script( 'owl.carousel' );
wp_enqueue_style( 'owl.carousel' );

$number = ( ! empty( $number ) ) ? intval( $number ) : 10;

$args = array(
	'post_type'      => 'stm_nft_packs',
	'posts_per_page' => -1,
);

$uniq = uniqid( 'stm_nft_packs' );

$q = new WP_Query( $args ); ?>
	<div class="stm_nft_packs_carousel <?php echo esc_attr( $uniq . ' ' . $css_class ); ?>">
		<div class="stm_nft_packs_carousel_header">
			<?php if ( ! empty( $title ) ) : ?>
				<h2 class="stm_nft_packs_carousel_title">
					<?php echo esc_html( $title ); ?>
				</h2>
			<?php endif; ?>
			<?php if ( 'yes' !== $hide_arrows ) : ?>
				<div class="stm_nft_packs_carousel_navigation">
					<div class="prev mbc tbc_h tbdc stc_h">
						<i class="stm-stm14_left_arrow"></i>
					</div>
					<div class="next mbc tbc_h tbdc stc_h">
						<i class="stm-stm14_right_arrow"></i>
					</div>
				</div>
			<?php endif; ?>
		</div>
		<?php if ( $q->have_posts() ) : ?>

		<div class="stm_nft_packs_carousel_slides owl-carousel owl-theme">
			<?php
			while ( $q->have_posts() ) :
				$q->the_post();
				$post_id      = get_the_ID();
				$description  = get_post_meta( $post_id, 'nft_pack_description', true );
				$price        = get_post_meta( $post_id, 'nft_pack_price', true );
				$crypto_price = get_post_meta( $post_id, 'nft_pack_crypto_price', true );
				$link         = get_post_meta( $post_id, 'nft_pack_button_link', true );
				$icon         = get_post_meta( $post_id, 'nft_pack_crypto_price_icon', true );
				?>

				<div class="stm_nft_packs_carousel_card mbc tbc_h tbdc">
					<div class="stm_nft_packs_carousel_card_overlay"></div>
					<div class="stm_nft_packs_carousel_card_image">
						<img src="<?php echo esc_url( $assets_path . '/images/cd_box.png' ); ?>" alt="CD Box"/>
						<div class="stm_nft_packs_carousel_card_mask">
							<?php echo wp_kses_post( crypterio_get_image_vc( get_post_thumbnail_id(), '238' ) ); ?>
						</div>
					</div>
					<h4 class="stm_nft_packs_carousel_card_title">
						<?php the_title(); ?>
					</h4>
					<?php if ( ! empty( $description ) ) : ?>
						<span class="stm_nft_packs_carousel_card_description"><?php echo esc_html( $description ); ?></span>
					<?php endif; ?>
					<div class="stm_nft_packs_carousel_card_bottom">
						<div class="stm_nft_packs_carousel_card_prices">
							<?php if ( ! empty( $crypto_price ) ) : ?>
								<div class="stm_nft_packs_carousel_card_crypto_price stc">
									<?php if ( ! empty( $icon ) ) : ?>
										<i class="<?php echo esc_attr( $icon ); ?>"></i>
									<?php endif; ?>
									<?php echo esc_html( $crypto_price ); ?>
								</div>
							<?php endif; ?>
							<?php if ( ! empty( $price ) ) : ?>
								<div class="stm_nft_packs_carousel_card_price"><?php echo esc_html( $price ); ?></div>
							<?php endif; ?>
						</div>
						<?php if ( ! empty( $link ) ) : ?>
							<a href="<?php echo esc_attr( $link ); ?>" class="stm_nft_packs_carousel_card_btn mtc_h">
								<?php echo esc_html__( 'View', 'crypterio' ); ?>
							</a>
						<?php endif; ?>
					</div>
				</div>
			<?php endwhile; ?>
		</div>
	</div>
	<script type="text/javascript">
		jQuery(document).ready(function () {
			jQuery('.<?php echo esc_attr( $uniq ); ?> .stm_nft_packs_carousel_slides').owlCarousel({
				items: 4,
				margin: 30,
				loop: true,
				autoplay:<?php echo esc_js( $autoplay ); ?>,
				autoplayTimeout:5000,
				autoplayHoverPause:true,
				responsive: {
					0: {
						items: 1
					},
					576: {
						items: 2
					},
					1280: {
						items: 3
					},
					1600: {
						items: 4
					}
				},
			});
			window.dispatchEvent(new Event('resize'));
			jQuery('.<?php echo esc_attr( $uniq ); ?> .stm_nft_packs_carousel_navigation .next').on('click', function(){
				jQuery('.<?php echo esc_attr( $uniq ); ?> .stm_nft_packs_carousel_slides').trigger('next.owl.carousel');
			});

			jQuery('.<?php echo esc_attr( $uniq ); ?> .stm_nft_packs_carousel_navigation .prev').on('click', function(){
				jQuery('.<?php echo esc_attr( $uniq ); ?> .stm_nft_packs_carousel_slides').trigger('prev.owl.carousel');
			});
		});
	</script>
			<?php
endif;
