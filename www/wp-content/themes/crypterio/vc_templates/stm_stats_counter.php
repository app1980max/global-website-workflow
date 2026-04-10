<?php
/**
 * @var $atts
 * @var $css
 * @var $alignment
 * @var $stat_counter_style
 * @var $counter_value_pre
 * @var $counter_value
 * @var $counter_value_suf
 * @var $title
 * @var $description
 * @var $duration
 * @var $is_on_screen
 */

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

wp_enqueue_script( 'countUp' );

$css_class  = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );
$counter_id = uniqid( 'counter_' );

if ( empty( $stats_style ) ) {
	$stats_style = '';
}

if ( empty( $color ) ) {
	$color = '';
} else {
	$color = 'style="color:' . $color . '"';
}

?>

<div class="stats_counter-<?php echo esc_attr( crypterio_sanitize_text_field( $alignment ) ); ?>">
	<div class="stats_counter <?php echo esc_attr( crypterio_sanitize_text_field( $stat_counter_style ) ); ?> <?php echo esc_attr( crypterio_sanitize_text_field( $alignment ) ); ?> <?php
	echo esc_attr( $stats_style );
	echo esc_attr( $css_class );
	?>
	" <?php echo esc_attr( crypterio_sanitize_text_field( $color ) ); ?>>
		<div class="inner">
			<?php if ( wp_is_mobile() ) { ?>
				<h3 class="no_stripe"
					id="<?php echo esc_attr( $counter_id ); ?>" <?php echo esc_attr( crypterio_sanitize_text_field( $color ) ); ?>>
					<?php echo esc_attr( $counter_value_pre ); ?>
					<?php echo esc_attr( $counter_value ); ?>
					<?php echo esc_attr( $counter_value_suf ); ?>
				</h3>
			<?php } else { ?>
				<h3 class="no_stripe"
					id="<?php echo esc_attr( $counter_id ); ?>" <?php echo esc_attr( crypterio_sanitize_text_field( $color ) ); ?>>0</h3>
			<?php } ?>
			<?php if ( $title ) { ?>
				<div class="counter_title" <?php echo esc_attr( crypterio_sanitize_text_field( $color ) ); ?>><?php echo esc_html( $title ); ?></div>
			<?php } ?>
			<?php if ( $description ) { ?>
				<div class="counter_description">
					<p><?php echo wp_kses( $description, array( 'br' => array() ) ); ?></p>
				</div>
			<?php } ?>
			<?php if ( ! wp_is_mobile() ) { ?>
				<script type="text/javascript">
					jQuery(document).ready(function ($) {
						var <?php echo esc_attr( $counter_id ); ?> =
						new countUp("<?php echo esc_attr( $counter_id ); ?>", 0, <?php echo esc_attr( $counter_value ); ?>, 0, <?php echo esc_attr( $duration ); ?>, {
							useEasing: true,
							useGrouping: false,
							prefix: '<?php echo esc_js( $counter_value_pre ); ?>',
							suffix: '<?php echo esc_js( $counter_value_suf ); ?>'
						});
						<?php if ( $is_on_screen ) : ?>
							$(document).ready(function () {
								if ($("#<?php echo esc_attr( $counter_id ); ?>").is_on_screen()) {
									<?php echo esc_attr( $counter_id ); ?>.
									start();
								}
							});
						<?php endif; ?>
						$(window).scroll(function () {
							if ($("#<?php echo esc_attr( $counter_id ); ?>").is_on_screen()) {
								<?php echo esc_attr( $counter_id ); ?>.
								start();
							}
						});
					});
				</script>
			<?php } ?>
		</div>
	</div>
</div>
