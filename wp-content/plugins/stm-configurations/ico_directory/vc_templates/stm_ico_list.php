<?php
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$stm_css = 'stm_ico_list';

stm_ico_directory_module_styles($stm_css);
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );
?>

<div class="<?php echo $css_class ?>">
    <?php crypterio_load_vc_element('ico_list', $atts, 'style_1'); ?>
</div>