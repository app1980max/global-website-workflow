<?php
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

wp_enqueue_style('stm_token_structure', get_template_directory_uri() . '/assets/css/shared/vc/stm_token_structure.css', array(), CRYPTERIO_THEME_VERSION);

$tokens = vc_param_group_parse_atts( $atts['tokens'] );

if(!empty($tokens)):

	?>


<div class="stm_token_structure">
    <?php foreach($tokens as $token): ?>
    <?php
        $token_value = 6;
	    if($token['value'] > 6){
	    	$token_value = $token['value'];
	    }
	    ?>
        <div class="stm_token" style="width: <?php echo esc_attr($token_value); ?>% ">
            <div class="stm_token__bar" style="background-color:<?php echo esc_attr($token['color']); ?>">
                <?php echo esc_html($token['value']); ?>%
            </div>
            <div class="stm_token__label"><?php echo esc_html($token['label']); ?></div>
        </div>
    <?php endforeach; ?>
</div>

<?php endif; ?>