<?php
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

wp_enqueue_style('stm_panel_box', get_template_directory_uri() . '/assets/css/shared/vc/stm_panel_box.css', array(), CRYPTERIO_THEME_VERSION);

$start_color = (!empty($start_color)) ? $start_color : '#5b45bf';
$end_color = (!empty($end_color)) ? $end_color : '#1c7bf7';

$uniq_id = uniqid('stm_panel_box');

$inline_styles = "#{$uniq_id} .stm_panel_box__gradient {
    background: linear-gradient(to right, {$start_color}, {$end_color});
}
#{$uniq_id} .stm_panel_box__content ul li::before {
	background: linear-gradient(to right, {$start_color}, {$end_color});
	background: -webkit-linear-gradient(to right, {$start_color}, {$end_color});
}";

wp_add_inline_style('stm_panel_box', $inline_styles);

?>

<div class="stm_panel_box" id="<?php echo esc_attr($uniq_id); ?>">

    <div class="stm_panel_box__gradient"></div>

    <div class="stm_panel_box__inner">
        <div class="stm_panel_box__top">

            <?php if(!empty($title)): ?>
                <div class="stm_panel_box__title"><?php echo esc_attr($title); ?></div>
            <?php endif; ?>

            <?php if(!empty($subtitle)): ?>
                <div class="stm_panel_box__subtitle"><?php echo esc_attr($subtitle); ?></div>
            <?php endif; ?>

        </div>

        <?php if(!empty($content)): ?>
            <div class="stm_panel_box__content">
                <?php echo wpb_js_remove_wpautop( $content ); ?>
            </div>
        <?php endif; ?>
    </div>

</div>
