<?php
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

list($args) = vc_build_loop_query($loop, get_the_ID());

wp_enqueue_style('stm_news_grid', get_template_directory_uri() . '/assets/css/shared/vc/stm_news_grid.css', array(), CRYPTERIO_THEME_VERSION);
wp_enqueue_script('fancybox');
wp_enqueue_style('fancybox');

if (!empty($args)):
	if (!empty($offset)) $args['offset'] = $offset;
	$query = new WP_Query($args);
	if ($query->have_posts()): ?>
        <div class="stm_news_grid">
			<?php while ($query->have_posts()): $query->the_post(); ?>
				<?php get_template_part('partials/news/news', 'grid'); ?>
			<?php endwhile; ?>
        </div>
		<?php wp_reset_postdata(); ?>
	<?php endif; ?>

<?php endif;