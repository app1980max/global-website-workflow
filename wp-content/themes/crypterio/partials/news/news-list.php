<div class="stm_news_list__single">
	<div class="stm_news_list__single_inner">

		<div class="stm_news_list__image">
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
				<?php echo html_entity_decode(crypterio_get_image_vc(get_post_thumbnail_id(get_the_ID()), '270x200')); ?>
			</a>
			<?php get_template_part('partials/news/parts/_video'); ?>
		</div>

        <div class="stm_news_list__content">

            <h4>
                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="mtc stc_h">
                    <?php the_title(); ?>
                </a>
            </h4>

            <div class="stm_news_list__bottom">
                <?php $cats = crypterio_get_terms_array(get_the_ID(), 'category', '', true, array('class' => 'mtc wtc_h sbc_h sbdc_h')); ?>
                <?php if(!empty($cats)): ?>
                    <div class="stm_news_list__category">
                        <?php echo implode(' ', $cats); ?>
                    </div>
                <?php endif; ?>
                <div class="date">
                    <i class="stm-clock6"></i>
                    <?php echo get_the_time(crypterio_get_date_format()); ?>
                </div>
                <div class="views">
                    <i class="fas fa-eye"></i>
                    <?php stm_display_views(get_the_ID()); ?>
                </div>
            </div>

            <div class="stm_news_list__excerpt">
				<?php echo crypterio_minimize_word(get_the_excerpt(), 310); ?>
            </div>
        </div>

	</div>
</div>