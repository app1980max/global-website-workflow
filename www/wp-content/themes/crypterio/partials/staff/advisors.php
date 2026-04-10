<?php

$id = get_the_ID();

$socials_list = array(
	'facebook',
	'twitter',
	'google_plus',
	'linkedin'
);

$socials = [];

foreach ($socials_list as $social) {
	$social_url = get_post_meta($id, $social, true);
	if(!empty($social_url)) $socials[$social] = $social_url;
}

?>

<li class="stm_animation stm_viewport" data-animate="fadeInUp"
    data-animation-delay="0"
    data-animation-duration="1"
    data-viewport_position="90">
    <div class="inner_box">
        <div class="staff_image">
            <?php
            $post_thumbnail = wpb_getImageBySize( array(
                'attach_id' => get_post_thumbnail_id($id),
                'thumb_size' => '115x115',
            ) );

            $thumbnail = $post_thumbnail['thumbnail'];
            ?>

            <?php echo crypterio_sanitize_text_field($thumbnail); ?>
            <?php if(!empty($socials['linkedin'])): ?>
                <a href="<?php echo esc_attr($socials['linkedin']); ?>" class="advisor-linkedin" style="display: none;">
                    <i class="fab fa-linkedin"></i>
                </a>
            <?php endif; ?>
        </div>

        <div class="inner">
            <h4 class="no_stripe">
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h4>
            <div class="stm_invis">
                <div class="stm_excerpt">
                    <?php if ($excerpt = get_the_excerpt(get_the_id())): ?>
                        <?php
                        if(strlen($excerpt) > 45){
                            $excerpt = substr ( $excerpt , 0, 45 ) . '...';
                        }
                        ?>
                        <p><?php echo esc_html($excerpt); ?></p>
                    <?php endif; ?>
                </div>
                <a href="<?php the_permalink(); ?>" class="read-more-link"><?php esc_html_e('More', 'crypterio'); ?></a>
            </div>

            <div class="staff_list__socials">
				<?php foreach ($socials as $social => $url): ?>
                    <a href="<?php echo esc_html($url); ?>" class="staff_<?php echo esc_attr($social); ?>" target="_blank">
                        <i class="fas fa-<?php echo esc_attr(str_replace('_', '-', $social)); ?>"></i>
                    </a>
				<?php endforeach; ?>
            </div>

            <div class="stm_staff__hover">
                <a class="title" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                <div class="stm_excerpt">
					<?php if ($excerpt = crypterio_substr_text(get_the_excerpt(), '100')): ?>
                        <p><?php echo esc_html($excerpt); ?></p>
					<?php endif; ?>
                </div>
                <div class="staff_list__socials">
					<?php foreach ($socials as $social => $url): ?>
                        <a href="<?php echo esc_html($url); ?>" class="staff_<?php echo esc_attr($social); ?>"  target="_blank">
                            <i class="fas fa-<?php echo esc_attr(str_replace('_', '-', $social)); ?>"></i>
                        </a>
					<?php endforeach; ?>
                </div>
            </div>
        </div>

    </div>
</li>