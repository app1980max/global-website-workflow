<div class="stm_news_grid__single">
	<div class="stm_news_grid__single_inner">
		<div class="stm_news_grid__image">
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
				<?php echo html_entity_decode(crypterio_get_image_vc(get_post_thumbnail_id(get_the_ID()), '75x75')); ?>
			</a>
		</div>
		<div class="stm_news_grid__content">
			<h4>
				<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" class="wtc stc_h">
					<?php echo crypterio_minimize_word(get_the_title(), '53', ' . . .'); ?>
				</a>
			</h4>
			<div class="stm_news_grid__bottom">
				<?php $cats = crypterio_get_terms_array(get_the_ID(), 'category', '', true, array('class' => 'wtc mtc_h sbc_h sbdc_h'), 1); ?>
				<?php if (!empty($cats)): ?>
					<div class="stm_news_grid__category">
						<?php echo implode(' ', $cats); ?>
					</div>
				<?php endif; ?>
				<div class="views">
					<i class="fas fa-eye"></i>
					<?php stm_display_views(get_the_ID()); ?>
				</div>
			</div>
		</div>
	</div>
</div>