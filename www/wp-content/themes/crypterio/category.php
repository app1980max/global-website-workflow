<?php crypterio_get_header(); ?>
<?php
$sidebar_type = get_theme_mod('blog_sidebar_type', 'wp');
if ($sidebar_type == 'wp') {
	$sidebar_id = get_theme_mod('blog_wp_sidebar', 'crypterio-right-sidebar');
} else {
	$sidebar_id = get_theme_mod('blog_vc_sidebar');
}
if (!empty($_GET['sidebar_id'])) {
	$sidebar_id = sanitize_text_field($_GET['sidebar_id']);
}

$config = crypterio_config();

$load_more = array(
    'crypto_blog'
);

$tax = get_queried_object();
$tax_name = (!empty($tax->name)) ? $tax->name : '';

$structure = crypterio_get_structure($sidebar_id, $sidebar_type, get_theme_mod('blog_sidebar_position', 'right'), get_theme_mod('blog_layout')); ?>

<?php echo crypterio_sanitize_text_field($structure['content_before']); ?>
    <div class="<?php echo esc_attr($structure['class']); ?>">

        <div class="stm_category_name" data-title="<?php echo esc_attr($tax_name); ?>"></div>

        <?php if($blog_ad = get_theme_mod('post_ad_html', '')): ?>
            <div class="stm_blog_ad">
                <?php echo wp_kses_post($blog_ad); ?>
            </div>
        <?php endif; ?>

		<?php
		$posts_class = '';
		$paginate_links_data = paginate_links(array('type' => 'array'));

		if (empty($paginate_links_data)) {
			$posts_class .= ' no-paginate';
		}
		?>

        <?php if(in_array($config['layout'], $load_more)): ?>
            <div class="stm_news_grid">
				<?php
				if (have_posts()) :
					while (have_posts()) : the_post();

						if (crypterio_blog_layout() == 'grid') {
							get_template_part('partials/news/news', 'grid');
						} else {
							get_template_part('partials/content', 'loop_list');
						}

					endwhile;
				else:
					get_template_part('partials/content', 'none');
				endif;
				?>
            </div>
        <?php else: ?>
            <ul class="post_list_ul<?php echo crypterio_sanitize_text_field($posts_class); ?>">
                <?php
                if (have_posts()) :
                    while (have_posts()) : the_post();

                        if (crypterio_blog_layout() == 'grid') {
                            get_template_part('partials/content', 'loop_grid');
                        } else {
                            get_template_part('partials/content', 'loop_list');
                        }

                    endwhile;
                else:
                    get_template_part('partials/content', 'none');
                endif;
                ?>
            </ul>
        <?php endif; ?>

    </div>
<?php
echo paginate_links(array(
	'type'      => 'list',
	'prev_text' => '<i class="fas fa-chevron-left"></i>',
	'next_text' => '<i class="fas fa-chevron-right"></i>',
));
?>
<?php echo crypterio_sanitize_text_field($structure['content_after']); ?>
<?php echo crypterio_sanitize_text_field($structure['sidebar_before']); ?>
<?php
if ($sidebar_id) {
	if ($sidebar_type == 'wp') {
		$sidebar = true;
	} else {
		$sidebar = get_post($sidebar_id);
	}
}
if (isset($sidebar)) {
	if ($sidebar_type == 'vc') { ?>
        <div class="sidebar-area stm_sidebar">
            <style type="text/css" scoped>
                <?php echo get_post_meta( $sidebar_id, '_wpb_shortcodes_custom_css', true ); ?>
            </style>
			<?php echo apply_filters('the_content', $sidebar->post_content); ?>
        </div>
	<?php } else { ?>
        <div class="sidebar-area default_widgets">
			<?php dynamic_sidebar($sidebar_id); ?>
        </div>
	<?php }
}
?>
<?php echo crypterio_sanitize_text_field($structure['sidebar_after']); ?>

<?php get_footer(); ?>