<?php
$show_logo = (!empty($date_or_logo) and $date_or_logo == 'logo') ? true : false;
$posts_per_page = (!empty($number) and intval($number)) ? $number : get_option( 'posts_per_page' );
$current = (!empty($offset) and intval($offset)) ? $offset : 1;
$offset = (!empty($offset) and intval($offset)) ? ( $offset * $posts_per_page ) - $posts_per_page : 0;

$args = array(
	'post_type'      => 'stm_ico_listing',
	'posts_per_page' => $posts_per_page,
	'offset' => $offset,
	'meta_key'       => 'end_date',
	'orderby'        => 'meta_value_num',
	'order'          => 'ASC',
	'meta_query'     => array(
		'relation' => 'AND',
		array(
			'key'     => 'end_date',
			'compare' => '<',
			'value'   => time(),
		),
		array(
			'key'     => 'end_date',
			'compare' => '!=',
			'value'   => '',
		),
	)
);

$args = (!empty($add_args)) ? wp_parse_args($add_args, $args) : $args;

$q = new WP_Query($args);

if ($q->have_posts()): ?>

	<?php if (!empty($title)): ?>
        <h4 class="text-center heading_font"><?php echo esc_attr($title); ?></h4>
	<?php endif; ?>

    <div class="stm_ico_grid">
		<?php while ($q->have_posts()): $q->the_post();
			$post_id = get_the_ID();
			$classes = [];
			$meta = get_post_meta($post_id);
			$metas = [];

			if (!empty($meta)) {
				foreach ($meta as $key => $value) {
					if (!empty($value[0])) {
						$metas[$key] = $value[0];
					}
				}
			}

			if (!empty($metas['start_date'])) {

				$days_left = date_i18n('d', $metas['start_date']);

				$classes[] = 'has_time';
			}

			if (!empty($metas['sponsored']) and $metas['sponsored'] == 'on') {
				$classes[] = 'sponsored_ico';
			}

			if (!empty($metas['trending']) and $metas['trending'] == 'on') {
				$classes[] = 'trending_ico';
			}

			$classes[] = ($show_logo) ? 's_logo' : 's_date';

			?>
            <div class="stm_ico_grid__single <?php echo implode(' ', $classes); ?>">
                <div class="stm_ico_grid__date">
					<?php if($show_logo and !empty($metas['icon'])): ?>
						<?php echo crypterio_get_image_vc($metas['icon'], '60x60'); ?>
					<?php elseif(!empty($metas['image_url'])): ?>
                        <img src="<?php echo esc_url($metas['image_url']); ?>" />
					<?php else: ?>
						<?php if (!empty($days_left)): ?>
                            <div class="stm_ico_grid__days heading_font">
								<?php echo intval($days_left); ?>
                            </div>
							<?php echo esc_attr(date_i18n('M', $metas['start_date'])); ?>
						<?php else: ?>
                            <div class="stm_ico_grid__days tba_days">
								<?php esc_html_e('TBA', 'crypterio'); ?>
                            </div>
						<?php endif; ?>
					<?php endif; ?>
                </div>
                <div class="stm_ico_grid__content">
                    <div class="clearfix">
                        <div class="pull-right">
							<?php crypterio_ico_rate($metas); ?>
                        </div>
                        <div class="stm_ico_grid__main_info">
                            <a href="<?php the_permalink(); ?>"
                               title="<?php the_title_attribute(); ?>"
                               class="stm_ico_grid__title no_deco">
								<?php the_title(); ?>
                            </a>
                        </div>
                    </div>
                    <div class="stm_ico_grid__category">
						<?php echo implode(' ', crypterio_get_terms_array(
								$post_id,
								'stm_ico_listing_category',
								'term_name',
								true
							)
						); ?>
                    </div>
                    <div class="stm_ico_grid__goals heading_font">
						<?php crypterio_ico_progress($metas); ?>
                    </div>

					<?php if($show_logo and !empty($metas['end_date'])): ?>
                        <div class="days_left">
							<?php printf(esc_html__('%s ended on', 'crypterio'), date_i18n('F j', $metas['end_date'])); ?>
                        </div>
					<?php endif; ?>

                </div>
            </div>
		<?php endwhile; ?>
    </div>

	<?php if (!empty($stm_pagination)): ?>

        <div class="stm_ico_pagination">
			<?php $big = 999999999; // need an unlikely integer
			echo paginate_links(array(
				'format'    => '?stm_page=%#%',
				'current'   => $current,
				'total'     => $q->max_num_pages,
				'next_text' => '<i class="stm-stm14_right_arrow"></i>',
				'prev_text' => '<i class="stm-stm14_left_arrow"></i>',
			)); ?>
        </div>
	<?php else:
        $cat = (!empty($stm_category)) ? '&stm_category=' . intval($stm_category) : '';
        ?>
        <a href="<?php echo get_post_type_archive_link(stm_ico_directory_get_post_type()) ?>?type=finished<?php echo esc_attr($cat); ?>"
           class="stm_ico_grid__all">
			<?php printf(esc_html__('View all %s ended ICO', 'crypterio'), intval($q->found_posts)); ?>
            <i class="fas fa-arrow-right"></i>
        </a>
	<?php endif; ?>

	<?php wp_reset_postdata(); ?>

<?php endif; ?>