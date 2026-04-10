<?php
if(!empty($_GET['action']) && $_GET['action'] == 'crypterio_load_stm_news_list') {
    $loop = sanitize_text_field($_GET['loop']);
    $offset = intval($_GET['offset']);
} else {
	$atts = vc_map_get_attributes($this->getShortcode(), $atts);
	extract($atts);
}


list($args) = vc_build_loop_query($loop, get_the_ID());

wp_enqueue_style('stm_news_list', get_template_directory_uri() . '/assets/css/shared/vc/stm_news_list.css', array(), CRYPTERIO_THEME_VERSION);
wp_enqueue_script('stm_news_list', get_template_directory_uri() . '/assets/js/vc/stm_news_list.js', array('jquery'), CRYPTERIO_THEME_VERSION);
wp_enqueue_script('fancybox');
wp_enqueue_style('fancybox');

if (!empty($args)):
    $args['posts_per_page'] = (!empty($args['posts_per_page'])) ? $args['posts_per_page'] : 4;
	$args['offset'] = (!empty($offset)) ? $offset : 0;
	$query = new WP_Query($args);

	$total = $query->found_posts;
	$posts_per_page = $args['posts_per_page'];
	$offset = $args['offset'];

	if ($query->have_posts()): ?>
        <div class="stm_news_list">
			<?php while ($query->have_posts()): $query->the_post(); ?>
                <?php get_template_part('partials/news/news', 'list'); ?>
			<?php endwhile; ?>
        </div>
		<?php wp_reset_postdata(); ?>

        <?php if($total > $posts_per_page + $offset): ?>
            <a href="#"
               data-total="<?php echo intval($total); ?>"
               data-loop="<?php echo esc_js($loop); ?>"
               data-per_page="<?php echo intval($posts_per_page); ?>"
               data-offset="<?php echo intval($offset + $posts_per_page); ?>"
               class="stm_news_list__more mbdc mtc sbdc_h sbc_h wtc_h">
                <span><?php esc_html_e('Load more posts', 'crypterio'); ?></span>
            </a>
        <?php endif; ?>

	<?php endif; ?>

<?php endif;