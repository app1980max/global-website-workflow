<?php
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

wp_enqueue_style('stm_cryptoticker', get_template_directory_uri() . '/assets/css/shared/vc/stm_cryptoticker.css', array(), CRYPTERIO_THEME_VERSION);

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );
?>

<div class="stm_cryptoticker <?php echo esc_attr($css_class); ?>">
	<?php get_template_part('partials/crypterio/simple-inline'); ?>
</div>