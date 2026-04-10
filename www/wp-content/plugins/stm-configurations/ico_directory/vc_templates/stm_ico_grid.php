<?php
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$stm_css = 'stm_ico_grid';

if(function_exists('crypterio_config')) {
    $config = crypterio_config();
    if($config['layout'] == 'ico_listing') $stm_css = 'stm_ico_listing_grid';
}
stm_ico_directory_module_styles($stm_css);
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );
?>

<div class="<?php echo $css_class ?>">
    <?php crypterio_load_vc_element('ico_grid', $atts, $style); ?>
</div>