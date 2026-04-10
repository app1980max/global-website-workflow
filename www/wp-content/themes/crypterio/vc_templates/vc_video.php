<?php
global $wp_embed;

$output = $title = $link = $size = $height_size = $el_class = $image = $img_size = $button_text = '';
extract(shortcode_atts(array(
	'title'       => '',
	'subtitle'    => '',
	'link'        => 'https://www.youtube.com/embed/igpxx-lrpQc',
	'size'        => 400,
	'height_size' => 400,
	'el_class'    => '',
	'image'       => '',
	'style'       => 'style_1',
	'button_text' => '',
	'img_size'    => 'thumb-540x320',
	'css'         => '',
    'bg_image' => ''

), $atts));

if ($link == '') {
	return null;
}

$thumbnail = wpb_getImageBySize(array('attach_id' => $image, 'thumb_size' => $img_size));

$el_class = $this->getExtraClass($el_class);
$video_w = $size;
$video_h = $height_size;
$embed = '';
if (is_object($wp_embed)) {
	$embed = '<iframe src="' . $link . '" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
}
/** @var WP_Embed $wp_embed */
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_video_widget wpb_content_element' . $el_class . $el_class . vc_shortcode_custom_css_class($css, ' '), $this->settings['base'], $atts);

if (empty($thumbnail['thumbnail'])) {
	$css_class .= ' has_no_poster';
}

if ($style == 'style_1') {
	$output .= "\n\t" . '<div class="' . esc_attr($css_class) . '">';
	$output .= "\n\t\t" . '<div class="wpb_wrapper">';
	$output .= wpb_widget_title(array('title' => $title, 'extraclass' => 'wpb_video_heading'));
	$output .= '<div class="wpb_video_wrapper">';
	if (!empty($thumbnail['thumbnail'])) {
        $output .= $thumbnail['thumbnail'] . '<a href="#" class="play_video"></a>';
		$output .= '<div class="video" style="display: none; width: ' . esc_attr($video_w) . 'px; height: ' . esc_attr($video_h) . 'px;">' . $embed . '</div>';
	} else {
		$output .= '<div class="video" style="width: ' . esc_attr($video_w) . 'px; height: ' . esc_attr($video_h) . 'px;">' . $embed . '</div>';
	}

	$output .= '</div>';
	$output .= "\n\t\t" . '</div> ' . $this->endBlockComment('.wpb_wrapper');
	$output .= "\n\t" . '</div> ' . $this->endBlockComment('.wpb_video_widget');

	echo crypterio_sanitize_text_field($output);
} elseif ($style == 'style_2') {
	wp_enqueue_script('fancybox');
	wp_enqueue_style('fancybox');
	$lightbox = (!empty($atts['lightbox']) and $atts['lightbox'] == 'enable') ? 'data-fancybox' : '';
    ?>
	<div class="stm_ico_video <?php echo esc_attr($style); ?>">
		<a <?php echo esc_attr($lightbox); ?> href="<?php echo esc_url($link); ?>" target="_blank">
            <h4><?php echo sanitize_text_field($title); ?></h4>
            <span><?php echo sanitize_text_field($subtitle); ?></span>
        </a>
	</div>
<?php }
    elseif ($style == 'style_3') {
    wp_enqueue_script('fancybox');
    wp_enqueue_style('fancybox');
    $lightbox = (!empty($atts['lightbox']) and $atts['lightbox'] == 'enable') ? 'data-fancybox' : '';
    ?>
        <div class="stm_ico_video <?php echo esc_attr($style); ?>">
			<?php echo wp_get_attachment_image( $bg_image, 'full'); ?>
            <a <?php echo esc_attr($lightbox); ?> href="<?php echo esc_url($link); ?>" target="_blank"></a>
        </div>
<?php }