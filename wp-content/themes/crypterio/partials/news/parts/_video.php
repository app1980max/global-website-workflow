<?php
$video = get_post_meta(get_the_ID(), 'stm_post_video', true);
wp_enqueue_style('fancybox');
wp_enqueue_script('fancybox');
if (!empty($video)): ?>
	<a data-fancybox class="stm_post__video sbc_a tbc_a_h stm_iframe_btn" href="<?php echo esc_attr($video); ?>">
        <div class="pulse"></div>
    </a>
<?php endif; ?>