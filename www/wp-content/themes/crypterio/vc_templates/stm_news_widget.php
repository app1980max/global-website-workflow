<?php
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

list($args) = vc_build_loop_query($loop, get_the_ID());

wp_enqueue_style('stm_news_grid', get_template_directory_uri() . '/assets/css/shared/vc/stm_news_grid.css', array(), CRYPTERIO_THEME_VERSION);
wp_enqueue_style('stm_news_widget', get_template_directory_uri() . '/assets/css/shared/vc/stm_news_widget.css', array(), CRYPTERIO_THEME_VERSION);

if (!empty($args)):
	if (!empty($offset)) $args['offset'] = $offset;

	if (!empty($popular) and $popular == 'popular') {
		$args['meta_value_num'] = 'DESC';
		$args['meta_key'] = 'stm_post_views';
	}

	$query = new WP_Query($args);
	if ($query->have_posts()): ?>
        <div class="stm_news_widget">
            <div class="stm_news_widget__top">
                <?php if (!empty($title)): ?>
                    <div class="stm_news_carousel__title">
                        <h4 class="wtc"><?php echo esc_attr($title); ?></h4>
                    </div>
                <?php endif; ?>
            </div>
            <div class="stm_news_grid">
                <?php while ($query->have_posts()): $query->the_post(); ?>
                    <?php get_template_part('partials/news/news-widget'); ?>
                <?php endwhile; ?>
            </div>
        </div>
		<?php wp_reset_postdata(); ?>

	<?php endif; ?>

<?php endif;