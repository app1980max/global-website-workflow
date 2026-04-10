<?php
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

$stm_css = 'stm_ico_grid_categories';

stm_ico_directory_module_styles($stm_css);
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class($css, ' ')); ?>

<div class="heading_font <?php echo $stm_css . ' ' . $css_class ?>">

    <?php get_template_part('partials/ico_listing/categories'); ?>

</div>
