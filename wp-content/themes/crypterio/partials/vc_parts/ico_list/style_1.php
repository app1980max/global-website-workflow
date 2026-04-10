<?php
$number = (!empty($number)) ? $number : 3;
$args = array(
	'post_type' => 'stm_ico_listing',
	'posts_per_page' => $number
);
$q = new WP_Query($args);

if($q->have_posts()): $i=0; ?>
	<div class="stm_ico_list">
		<?php while($q->have_posts()):
			$q->the_post();
			$post_id = get_the_ID();
			$raised = get_post_meta($post_id, 'raised', true);
			?>
			<div class="stm_ico_list__single stm_animation stm_viewport"
                 data-animate="fadeInUp"
                 data-animation-delay="0.<?php echo esc_attr($i); ?>"
                 data-animation-duration="1"
                 data-viewport_position="90">
				<a href="<?php the_permalink(); ?>" class="stm_ico_list__single_image">
					<?php echo crypterio_get_image_vc(get_post_thumbnail_id(), '350x195'); ?>
				</a>
				<a href="<?php the_permalink(); ?>" class="stm_ico_list__single_title h4">
					<?php the_title(); ?>
				</a>
				<div class="stm_ico_list__single_excerpt">
					<?php echo get_the_excerpt(); ?>
				</div>
				<?php if(!empty($raised)): ?>
					<div class="stm_ico_list__meta heading_font">
						<span><?php esc_html_e('Collected:', 'crypterio'); ?></span>
						<label class="stc"><?php echo esc_attr($raised); ?></label>
					</div>
				<?php endif; ?>
			</div>
		<?php $i++; endwhile; ?>
	</div>

	<?php wp_reset_postdata(); ?>
<?php endif;
