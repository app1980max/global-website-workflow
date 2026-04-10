<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$timeline = vc_param_group_parse_atts( $atts['timeline'] );
wp_enqueue_style('stm_timeline_white', get_template_directory_uri() . '/assets/css/shared/vc/stm_timeline_white.css', array(), CRYPTERIO_THEME_VERSION);

if(!empty($timeline)): ?>
    <div class="stm_timeline-wrap wpb_animate_when_almost_visible wpb_fadeInUp fadeInUp" style="animation-duration: 1s !important;">
        <?php foreach ($timeline as $timeline_item): ?>
            <div class="timeline-item">
                <div class="timeline-date <?php echo esc_attr($timeline_item['time']); ?>">
                    <span class="timeline_month"><?php echo esc_html($timeline_item['month'], 'crypterio'); ?></span>
                    <span class="timeline_year"><?php echo esc_html($timeline_item['year'], 'crypterio'); ?></span>
                </div>
                <div class="timeline_content"><?php echo esc_html($timeline_item['timeline_content'], 'crypterio'); ?></div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>