<?php
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract( $atts );

wp_enqueue_style('mailchimp_form', get_template_directory_uri() . '/assets/css/shared/vc/mailchimp_form.css', array(), CRYPTERIO_THEME_VERSION);

?>
<div class="stm_mailchimp_form">
    <div class="mailchimp_text">
        <?php if(!empty($icon)): ?>
            <i class="<?php echo esc_attr($icon); ?>"></i>
        <?php endif; ?>
        <?php if(!empty($form_title)): ?>
        <h3><?php echo esc_html($form_title); ?></h3>
        <?php endif; ?>
        <?php if(!empty($form_subtitle)): ?>
            <div class="form_subtitle">
                <?php echo esc_html($form_subtitle); ?>
            </div>
        <?php endif; ?>
    </div>
    <div class="mailchimp_content">
        <?php echo do_shortcode('[mc4wp_form]'); ?>
    </div>
</div>
