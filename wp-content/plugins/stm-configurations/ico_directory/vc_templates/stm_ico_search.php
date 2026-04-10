<?php
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);


stm_ico_directory_module_styles('stm_ico_search');

stm_ico_directory_module_script('vue.min');
stm_ico_directory_module_script('vue-resource');
stm_ico_directory_module_script('vc/stm_ico_search');


crypterio_load_vc_element('ico_search', $atts, 'style_1');
?>
