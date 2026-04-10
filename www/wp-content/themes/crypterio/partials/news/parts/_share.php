<?php
$link = get_the_permalink();
$image = crypterio_get_image_url(get_post_thumbnail_id());

$socials = array(
    'facebook' => array(
        'url' => "https://www.facebook.com/sharer/sharer.php?u={$link}",
        'share' => esc_html__('Share', 'crypterio')
    ),
	'twitter' => array(
		'url' => "https://twitter.com/home?status={$link}",
		'share' => esc_html__('Tweet', 'crypterio')
	),
	'google-plus' => array(
		'url' => "https://plus.google.com/share?url={$link}",
		'share' => esc_html__('Share', 'crypterio')
	),
	'linkedin' => array(
		'url' => "https://www.linkedin.com/shareArticle?mini=true&url={$link}&title=&summary=&source=",
		'share' => esc_html__('Share', 'crypterio')
	),
	'pinterest' => array(
		'url' => "https://pinterest.com/pin/create/button/?url={$link}&media={$image}&description=",
		'share' => esc_html__('Pin it', 'crypterio')
	),
);

?>

<div class="stm_share stm_js__shareble">
	<?php foreach ($socials as $social => $social_info): ?>
		<a href="#"
		   class="__icon icon_12px stm_share_<?php echo esc_attr($social); ?>"
		   data-share="<?php echo esc_url($social_info['url']); ?>"
		   data-social="<?php echo esc_attr($social); ?>">
			<i class="fab fa-<?php echo esc_attr($social); ?>"></i>
            <span><?php echo esc_attr($social_info['share']); ?></span>
		</a>
	<?php endforeach; ?>
</div>