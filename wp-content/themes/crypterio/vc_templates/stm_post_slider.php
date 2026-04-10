<?php
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

list($args) = vc_build_loop_query($loop, get_the_ID());

wp_enqueue_style('stm_post_carousel', get_template_directory_uri() . '/assets/css/shared/vc/stm_post_carousel.css', array(), CRYPTERIO_THEME_VERSION);
wp_enqueue_script('stm_post_carousel', get_template_directory_uri() . '/assets/js/vc/stm_post_carousel.js', array('jquery'), CRYPTERIO_THEME_VERSION);


if (!empty($args)):
	if (!empty($offset)) $args['offset'] = $offset;
	$args['meta_query'] = array(array('key' => '_thumbnail_id'));
	$query = new WP_Query($args);
	if ($query->have_posts()): $counter = 0; ?>
        <div class="stm_posts_carousel">
			<?php while ($query->have_posts()): $query->the_post();
				$counter++;
				$image = wpb_getImageBySize(array('attach_id' => get_post_thumbnail_id(), 'thumb_size' => '1170x600'));
				$cats = crypterio_get_terms_array(get_the_ID(), 'category', '', true, array('class' => 'mtc mtc_h'));
				if (!empty($image['thumbnail'])): ?>
				<?php $is_active = ($counter == 1) ? 'active' : ''; ?>
                    <div class="stm_posts_carousel_single <?php echo esc_attr($is_active); ?>">
                        <div class="stm_posts_carousel_single__container">
                            <div class="stm_posts_carousel_single__image">
								<?php echo html_entity_decode($image['thumbnail']); ?>
                            </div>
                            <div class="stm_posts_carousel_single__body">
                                <div class="content">
									<?php if (!empty($cats)): ?>
                                        <div class="stm_posts_carousel_single__category sbc mbc_h">
											<?php echo implode(' | ', $cats); ?>
                                        </div>
									<?php endif; ?>
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="wtc">
                                        <h5><?php the_title(); ?></h5>
                                    </a>
                                    <div class="date">
                                        <i class="stm-clock6"></i>
										<?php
										printf(wp_kses_post(__('%s by <strong>%s</strong>', 'crypterio')), get_the_time(crypterio_get_date_format()), get_the_author_meta('display_name'));
										?>
                                    </div>
                                </div>
								<?php get_template_part('partials/news/parts/_video'); ?>
                            </div>
                        </div>
                    </div>
				<?php endif; ?>
			<?php endwhile; ?>

            <ol class="stm_posts_carousel_single__list">
				<?php $i = 0;
				while ($query->have_posts()): $query->the_post();
					$i++;
					$post_views = get_post_meta(get_the_ID(), 'stm_post_views', true);
					if (empty($post_views)) {
						$post_views = 0;
					}

					$cats = crypterio_get_terms_array(get_the_ID(), 'category', '', true, array('class' => 'mtc mtc_h'));

					$inc_count = ($i == 1) ? 'active' : '';
					?>

                    <li class="<?php echo esc_attr($inc_count); ?>">
						<?php if (!empty($cats)): ?>
                            <div class="stm_posts_carousel_single__category sbc mbc_h">
								<?php echo implode(' | ', $cats); ?>
                            </div>
						<?php endif; ?>
                        <h5><a class="wtc stc_h no_deco" href="<?php the_permalink(); ?>"><?php the_title() ?></a></h5>
                        <div class="stm_posts_carousel_single__info">
                            <div class="date">
                                <i class="stm-clock6"></i>
								<?php
								printf(wp_kses_post(__('%s by <strong>%s</strong>', 'crypterio')), get_the_time(crypterio_get_date_format()), get_the_author_meta('display_name'));
								?>
                            </div>
                        </div>
                    </li>

				<?php endwhile; ?>
            </ol>
        </div>
		<?php wp_reset_postdata(); ?>
	<?php endif; ?>

<?php endif;