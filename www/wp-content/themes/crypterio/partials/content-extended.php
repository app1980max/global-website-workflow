<?php $vc_status = get_post_meta(get_the_ID(), '_wpb_vc_js_status', true); ?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="entry-content">
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
		$structure = crypterio_get_structure($sidebar_id, $sidebar_type, get_theme_mod('blog_sidebar_position', 'right'), get_theme_mod('blog_layout')); ?>
		<?php echo crypterio_sanitize_text_field($structure['content_before']); ?>
            <?php get_template_part('partials/news/crypto', 'blog'); ?>
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
                <style type="text/css" scoped>
                    <?php echo get_post_meta( $sidebar_id, '_wpb_shortcodes_custom_css', true ); ?>
                </style>
                <div class="sidebar-area stm_sidebar">
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
    </div>
</article> <!-- #post-## -->