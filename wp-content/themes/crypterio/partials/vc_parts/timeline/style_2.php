<?php
$posts = array();

$q_args = array(
	'posts_per_page' => '-1',
	'post_status'    => 'any',
	'order'          => 'ASC'
);

if (!empty($categories)) {
	$categories = explode(',', $categories);
	if (is_array($categories)) {
		$q_args['category__in'] = $categories;
	}
}



$q = new WP_Query($q_args);

if ($q->have_posts()) {
	while ($q->have_posts()) {
		$q->the_post();
		$year = get_the_date('Y');
		$title = (blockchain_check_string($show_title)) ? get_the_title() : '';
		$id = get_the_ID();
		$status = get_post_status($id);
		$url = ($status == 'future') ? '' : get_the_permalink($id);
		$url = (!empty($show_url) && blockchain_check_string($show_url)) ? $url : false;
		$excerpt = get_the_excerpt($id);

		$image_id = get_post_thumbnail_id($id);

		$image = wpb_getImageBySize( array(
			'attach_id'  => get_post_thumbnail_id($id),
			'thumb_size' => $image_size,
		) );
		$image = !empty($image) ? $image['thumbnail'] : '';

		if (empty($posts[$year])) $posts[$year] = array();

		$posts[$year][] = array(
			'id'      => $id,
			'title'   => $title,
			'image'   => $image,
			'year'    => (blockchain_check_string($show_year)) ? $year : '',
			'excerpt' => $excerpt,
			'url'     => $url,
		);
	}

	wp_reset_postdata();
}

if (!empty($posts)): $current_odd = $current_even = $counter = 0; ?>
	<div class="<?php echo esc_attr(implode(' ', $classes)); ?>">
		<div class="stm_posttimeline__year_posts">
			<!--LEFT COLUMN ALL ODD POSTS-->
			<div class="stm_posttimeline__year_posts_left">
				<?php foreach ($posts as $year => $year_posts) {
					foreach ($year_posts as $key => $post) {
						$current_odd++;
						if ($current_odd % 2 == 0) continue;
						crypterio_display_posttimeline($key, $post, $counter);
						$counter++;
					};
				} ?>
			</div>

			<!--Right COLUMN ALL EVEN POSTS-->
			<div class="stm_posttimeline__year_posts_right">
				<?php $counter = 0; foreach ($posts as $year => $year_posts) {
					foreach ($year_posts as $key => $post) {
						$current_even++;
						if ($current_even % 2 != 0) continue;
						crypterio_display_posttimeline($key, $post, $counter);
						$counter++;
					};
				} ?>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		(function($){
			$(document).ready(function(){
				$('.stm_posttimeline__post')
					.mouseenter(function(){
						var year = $(this).attr('data-related');
						$('[data-year="'+ year +'"]').addClass('active');
					})
					.mouseleave(function(){
						var year = $(this).attr('data-related');
						$('[data-year="'+ year +'"]').removeClass('active');
					});

				$('[data-year]').mouseenter(function(){
					var year = $(this).attr('data-year');
					$('[data-related="'+ year +'"]').addClass('active');
				})
					.mouseleave(function(){
						var year = $(this).attr('data-year');
						$('[data-related="'+ year +'"]').removeClass('active');
					});

				mix_posts();
			});


			function mix_posts() {
				if(window.innerWidth < 600) {
					$('.stm_posttimeline__year_posts_right .stm_posttimeline__post').each(function(){
						var $post = $(this);
						var index = $post.attr('data-key');
						var $insertAfter = $('.stm_posttimeline__year_posts_left .stm_posttimeline__post[data-key="'+index+'"]');
						$insertAfter.after($post);
					});
					$('.stm_posttimeline__year_posts_right').remove();
				}
			}

		})(jQuery);
	</script>
<?php endif;