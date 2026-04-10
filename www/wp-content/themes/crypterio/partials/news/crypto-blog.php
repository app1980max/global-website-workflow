<div class="stm_post_view">

	<h1 class="stm_post_view__title"><?php the_title(); ?></h1>

    <?php $terms = crypterio_get_terms_array(get_the_ID(), 'category', '', true, array('class' => 'sbc mtc wtc_h mbc_h no_deco')); ?>

    <?php if(!empty($terms)): ?>
        <div class="stm_post_view__categories">
            <?php echo implode(' ', $terms); ?>
        </div>
    <?php endif; ?>

    <div class="stm_post_view__info">
        <div class="date">
            <i class="stm-clock6"></i>
			<?php
			printf(__('%s by <strong>%s</strong>', 'crypterio'), get_the_time(crypterio_get_date_format()), get_the_author_meta('display_name'));
			?>
        </div>
        <div class="views">
            <i class="stm-cb_eye"></i>
			<?php stm_display_views(get_the_ID()); ?>
        </div>
        <div class="comments">
            <a href="<?php echo esc_url(get_comments_link()); ?>" class="stc_h">
                <i class="stm-cb_comments"></i>
                <?php comments_number(); ?>
            </a>
        </div>
    </div>

    <?php get_template_part('partials/news/parts/_share'); ?>

    <div class="stm_post_view__excerpt">
        <?php echo wp_kses_post(get_the_excerpt(get_the_ID())); ?>
    </div>

    <div class="stm_post_view__image" style="position: relative;">
        <?php echo crypterio_get_image_vc(get_post_thumbnail_id(), '770x415'); ?>
		<?php get_template_part('partials/news/parts/_video'); ?>
    </div>

    <div class="stm_post_view__content">
        <?php the_content(); ?>
    </div>

    <div class="stm_post_view__share_bot">
	    <?php get_template_part('partials/news/parts/_share'); ?>
    </div>

    <div class="stm_post_view__related">
	    <?php get_template_part('partials/news/parts/_related'); ?>
    </div>

	<?php if($blog_ad = get_theme_mod('post_ad_html', '')): ?>
        <div class="stm_blog_ad">
			<?php echo wp_kses_post($blog_ad); ?>
        </div>
	<?php endif; ?>

	<?php if ( comments_open() || get_comments_number() ) : ?>
        <div class="stm_post_comments">
			<?php comments_template(); ?>
        </div>
	<?php endif; ?>

</div>