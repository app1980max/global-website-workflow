<?php
if(isset($element['data']['style'])) {
    $stm_cv_style = $element['data']['style'];
} else {
    $stm_cv_style = 'grid';
}
get_template_part('partials/crypterio/simple', $stm_cv_style);