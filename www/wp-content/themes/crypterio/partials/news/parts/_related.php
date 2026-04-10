<?php
$id = get_the_ID();
$terms = crypterio_get_terms_array($id, 'category', 'term_id');

$args = array(
	'post_type' => 'post',
	'post_status' => 'publish',
	'posts_per_page' => get_option('posts_per_page'),
	'tax_query' => array(
		array(
			'taxonomy' => 'category',
			'field' => 'term_id',
			'terms' => $terms
		)
	),
	'post__not_in' => array($id),
);

$query = new WP_Query($args);

if($query->have_posts()): ?>
	<div class="stm_news_widget">
		<h3 class="title"><?php esc_html_e('Related posts', 'crypterio'); ?></h3>
		<div class="stm_news_grid">
			<?php while($query->have_posts()): $query->the_post(); ?>
				<?php get_template_part('partials/news/news-related'); ?>
			<?php endwhile; ?>
		</div>
	</div>
	<?php wp_reset_postdata(); ?>
<?php endif; ?>
