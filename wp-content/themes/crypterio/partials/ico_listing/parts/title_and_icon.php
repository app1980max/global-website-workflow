<div class="stm_single_ico__top">
	<?php if(!empty($metas['icon'])): ?>
        <div class="stm_single_ico__top_icon">
			<?php echo crypterio_get_image_vc($metas['icon'], '75x75'); ?>
        </div>
	<?php elseif(!empty($metas['image_url'])): ?>
        <div class="stm_single_ico__top_icon">
            <img src="<?php echo esc_url($metas['image_url']); ?>" />
        </div>
	<?php endif; ?>
	<div class="stm_single_ico__right clearfix">
        <div class="stm_single_ico__right_info clearfix">
            <div class="stm_single_ico__share">
				<?php get_template_part('partials/news/parts/_share'); ?>
            </div>
            <div class="stm_single_ico__title">
                <h1 itemprop="name"><?php the_title(); ?></h1>
                <span class="sbc_a"><?php echo implode(', ', crypterio_get_terms_array(get_the_ID(), 'stm_ico_listing_category', 'name')); ?></span>
            </div>
        </div>

        <div class="stm_single_ico__excerpt"><?php echo get_the_excerpt(); ?></div>
	</div>
</div>