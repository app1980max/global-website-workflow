<?php
/**
 * @var $atts
 * @var $css
 * @var $css_animation
 * @var $align
 */
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );
wp_enqueue_style( 'stm_icon_links', get_template_directory_uri() . '/assets/css/shared/vc/stm_icon_links.css', array(), CRYPTERIO_THEME_VERSION );

$classes   = array( 'stm_icon_links' );
$classes[] = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );
$classes[] = $this->getCSSAnimation( $css_animation );

$classes[] = 'text-' . $align;

if ( isset( $atts['icons'] ) && strlen( $atts['icons'] ) > 0 ) {
	$atts['icons'] = vc_param_group_parse_atts( $atts['icons'] );
}

if ( ! empty( $atts['icons'] ) && is_array( $atts['icons'] ) ) :
	$icons = $atts['icons']; ?>

	<div class="<?php echo esc_attr( implode( ' ', $classes ) ); ?>">
		<?php
		foreach ( $icons as $icon_num => $icon ) :
			if ( empty( array_filter( $icon ) ) ) {
				continue;
			}

			$url = ( empty( $icon['url'] ) ) ? '#' : $icon['url'];
			?>
			<a href="<?php echo esc_url( $url ); ?>" target="_blank" class="sbc_h sbdc_h mtc_h">
				<i class="<?php echo esc_attr( $icon['icon'] ); ?>"></i>
			</a>
		<?php endforeach; ?>
	</div>
	<?php
endif;
