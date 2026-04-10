<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$short_code = '[crypto-converter-widget ';
$short_code .= 'crypto="bitcoin" ';
$short_code .= 'fiat="united-states-dollar" ';
$short_code .= 'background-color="'.$background_color.'" ';
$short_code .= 'amount="1" ';
$short_code .= 'decimal-places="2" ';
$short_code .= 'font-family="inherit" ';
$short_code .= 'border-radius="0.30rem" ';
$short_code .= 'shadow="true" ';
$short_code .= 'symbol="true" ';
$short_code .= 'live="true" ';
$short_code .= 'signature="true" ';
$short_code .= ']';
?>

<div class="stm_crypto_converter">
	<?php if(!empty($title)): ?>
		<h3><?php echo sanitize_text_field($title); ?></h3>
	<?php endif; ?>
	<?php echo do_shortcode($short_code); ?>
</div>