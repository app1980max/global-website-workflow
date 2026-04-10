<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );


if($calc_style == 'theme_style')
    wp_enqueue_style('stm-crypto-calculator', get_template_directory_uri() . '/assets/css/shared/vc/crypto-calculator.css', null, CRYPTERIO_THEME_VERSION, 'all');

echo do_shortcode('[stm-calc id="' . $calc_id . '"]');