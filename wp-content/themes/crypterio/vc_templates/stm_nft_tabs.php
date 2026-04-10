<?php
/**
 * @var $atts
 * @var $css
 * @var $hide_all
 */
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );

wp_enqueue_style( 'stm_nft_tabs', get_template_directory_uri() . '/assets/css/shared/vc/stm_nft_tabs.css', array(), CRYPTERIO_THEME_VERSION );
wp_enqueue_script( 'isotope' );
wp_enqueue_script( 'imagesloaded' );

$number = ( ! empty( $number ) ) ? intval( $number ) : 8;

$args = array(
	'post_type'      => 'stm_nft',
	'posts_per_page' => - 1,
);

$categories_args = array(
	'orderby' => 'ID',
	'order'   => 'DESC',
);

$categories = get_terms( 'stm_nft_category', $categories_args );

$uniq = uniqid( 'stm_nft_tabs' );

$q = new WP_Query( $args ); ?>

<?php if ( $q->have_posts() ) : ?>
	<div class="stm_nft_tabs <?php echo esc_attr( $uniq . ' ' . $css_class ); ?>">
		<div class="stm_nft_tabs_header">
			<?php if ( ! empty( $title ) ) : ?>
				<h2 class="stm_nft_tabs_title">
					<?php echo esc_html( $title ); ?>
				</h2>
			<?php endif; ?>
			<?php if ( ! empty( $categories ) ) : ?>
				<div class="stm_nft_tabs_categories">
					<?php if ( 'yes' !== $hide_all ) : ?>
						<button class="stm_nft_tabs_category stc tbc" data-filter=".stm_nft_tabs_post_wrapper">
							<?php echo esc_html__( 'All', 'crypterio' ); ?>
						</button>
					<?php endif; ?>
					<?php foreach ( $categories as $category ) : ?>
						<button class="stm_nft_tabs_category stc_h"
								data-filter=".<?php echo esc_attr( $category->slug ); ?>">
							<?php echo esc_attr( $category->name ); ?>
						</button>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>

		<div class="stm_nft_tabs_posts">
			<?php
			while ( $q->have_posts() ) :
				$q->the_post();
				$post_id      = get_the_ID();
				$price        = get_post_meta( $post_id, 'nft_price', true );
				$crypto_price = get_post_meta( $post_id, 'nft_crypto_price', true );
				$icon         = get_post_meta( $post_id, 'nft_crypto_price_icon', true );
				$link         = get_post_meta( $post_id, 'nft_button_link', true );
				$badge        = get_post_meta( $post_id, 'nft_live_auction', true );
				?>
				<div class="stm_nft_tabs_post_wrapper <?php echo esc_attr( implode( ' ', crypterio_get_terms_array( $post_id, 'stm_nft_category', 'slug' ) ) ); ?>">
					<div class="stm_nft_tabs_post mbc tbdc tbc_h">
						<?php if ( 'on' === $badge ) : ?>
							<div class="stm_nft_tabs_post_badge sbc mtc">
								<?php echo esc_html__( 'Live Auction', 'crypterio' ); ?>
							</div>
						<?php endif; ?>
						<div class="stm_nft_tabs_post_image">
							<?php echo wp_kses_post( crypterio_get_image_vc( get_post_thumbnail_id(), '366' ) ); ?>
						</div>
						<div class="stm_nft_tabs_post_inner">
							<h4 class="stm_nft_tabs_post_title">
								<?php the_title(); ?>
							</h4>
							<div class="stm_nft_tabs_post_bottom">
								<div class="stm_nft_tabs_post_prices">
									<?php if ( ! empty( $crypto_price ) ) : ?>
										<div class="stm_nft_tabs_post_crypto_price stc">
											<?php if ( ! empty( $icon ) ) : ?>
												<i class="<?php echo esc_attr( $icon ); ?>"></i>
											<?php endif; ?>
											<?php echo esc_html( $crypto_price ); ?>
										</div>
									<?php endif; ?>
									<?php if ( ! empty( $price ) ) : ?>
										<div class="stm_nft_tabs_post_price"><?php echo esc_attr( $price ); ?></div>
									<?php endif; ?>
								</div>
								<?php if ( ! empty( $link ) ) : ?>
									<a href="<?php echo esc_attr( $link ); ?>" class="stm_nft_post_btn mtc_h">
										<?php echo esc_html__( 'View', 'crypterio' ); ?>
									</a>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			<?php endwhile; ?>
		</div>
		<button class="stm_nft_tabs_load_more_btn sbc mtc sbdc">
			<?php echo esc_html__( 'View more', 'crypterio' ); ?>
		</button>
	</div>

	<script type="text/javascript">
		jQuery(document).ready(function ($) {
			let $container = $('.<?php echo esc_attr( $uniq ); ?> .stm_nft_tabs_posts');
			let loadMoreItemsCount = 4;

			$container.isotope({
				itemSelector: '.stm_nft_tabs_post_wrapper',
				layoutMode: 'masonry',
			});

			$container.imagesLoaded().progress(function () {
				$container.isotope('layout');
			});

			$('.<?php echo esc_attr( $uniq ); ?> .stm_nft_tabs_category').on('click', function () {
				$container.isotope({
					filter: $(this).attr('data-filter')
				});
				$(this).siblings().removeClass('stc tbc');
				$(this).addClass('stc tbc');

				if ($($container.isotope('getFilteredItemElements')).length > <?php echo esc_js( $number ); ?>) {
					$('.stm_nft_tabs_load_more_btn').show();
				} else {
					$('.stm_nft_tabs_load_more_btn').hide();
				}

				let index = 0;

				if ($('.stm_nft_tabs_post_wrapper').hasClass('hidden')) {
					$('.stm_nft_tabs_post_wrapper').removeClass('hidden');
				}

				$($container.isotope('getFilteredItemElements')).each(function () {
					if (index >= <?php echo esc_js( $number ); ?>) {
						$(this).addClass('hidden');
					}
					index++;
				});

				$container.isotope('layout');
			});

			$('.stm_nft_tabs_load_more_btn').on('click', function (e) {
				e.preventDefault();
				let itemsMax = $('.hidden').length;
				let itemsCount = 0;

				$('.hidden').each(function () {
					if (itemsCount < loadMoreItemsCount) {
						$(this).removeClass('hidden');
						itemsCount++;
					}
				});

				if (itemsCount >= itemsMax) {
					$('.stm_nft_tabs_load_more_btn').hide();
				}

				$container.isotope('layout');
			});

			let itemsMax = $('.stm_nft_tabs_post_wrapper').length;
			let itemsCount = 0;

			$('.stm_nft_tabs_post_wrapper').each(function () {
				if (itemsCount >= <?php echo esc_js( $number ); ?>) {
					$(this).addClass('hidden');
				}
				itemsCount++;
			});

			if (itemsCount < itemsMax || <?php echo esc_js( $number ); ?> >= itemsMax) {
				$('.stm_nft_tabs_load_more_btn').hide();
			}

			$container.isotope('layout');
			$('.<?php echo esc_attr( $uniq ); ?> .stm_nft_tabs_category:first-child').trigger('click');
		});
	</script>
	<?php
endif;
