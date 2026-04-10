<?php
$atts = vc_map_get_attributes($this->getShortcode(), $atts);

extract($atts);

$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' '));

$atts['css_class'] = (!empty($css_class)) ? $css_class : '';

$style = $by_contract;
$atts['content'] = (!empty($content)) ? $content : '';
if($atts['style'] == 'style_2'){
    crypterio_load_vc_element('ico_countdown_style_2', $atts, $style);
}
else if($atts['style'] == 'style_3'){
    crypterio_load_vc_element('ico_countdown_style_3', $atts, $style);
}
else {
    crypterio_load_vc_element('ico_countdown', $atts, $style);
}
