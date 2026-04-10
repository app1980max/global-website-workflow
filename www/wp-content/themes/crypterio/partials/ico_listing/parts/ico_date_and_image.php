<?php $socials = crypterio_socials_list(); ?>

<div class="stm_single_ico__date_image">

    <div class="stm_single_ico__date heading_font">
		<?php if (!empty($metas['start_date']) or !empty($metas['end_date'])):
			$status = crypterio_check_ico_status($metas['start_date'], $metas['end_date']);
			$now = time(); ?>
            <!--Check if upcoming, live or finished-->
            <!--Upcoming-->
            <div class="stm_single_ico__date_date">
				<?php if ($status === 'upcoming'): ?>

					<?php printf(
						__('Token sale <strong>will start %s</strong>', 'crypterio'),
						date_i18n('d F', $metas['start_date'])
					); ?>

                    <!--Live-->
				<?php elseif ($status === 'live'): ?>

					<?php printf(
						__('Token sale <strong>is active until %s</strong>', 'crypterio'),
						date_i18n('d F', $metas['end_date'])
					); ?>

                    <!--Finished-->
				<?php else: ?>
					<?php printf(
						__('Token sale <strong>completed on %s</strong>', 'crypterio'),
						date_i18n('d F', $metas['end_date'])
					); ?>
				<?php endif; ?>
            </div>
		<?php endif; ?>

        <div class="stm_single_ico__date_goals heading_font">
			<?php crypterio_ico_progress($metas, esc_html__('of', 'crypterio')); ?>
        </div>

		<?php if (!empty($metas['website'])): ?>
            <a href="<?php echo esc_url($metas['website']); ?>" class="stm_single_ico__button">
				<?php esc_html_e('Website', 'crypterio'); ?>
                <i class="stm-stm14_right_arrow"></i>
            </a>
		<?php endif; ?>

		<?php if (!empty($metas['whitepaper'])): ?>
            <a href="<?php echo esc_url($metas['whitepaper']); ?>"
               class="stm_single_ico__button stm_single_ico__button_whitepaper">
				<?php esc_html_e('Whitepaper', 'crypterio'); ?>
                <i class="stm-stm14_right_arrow"></i>
            </a>
		<?php endif; ?>

        <div class="stm_single_ico__socials">
			<?php foreach ($socials as $social_key => $social_value): ?>
				<?php if (!empty($metas[$social_key])): ?>
                    <div class="stm_single_ico__social">
                        <a href="<?php echo esc_url($metas[$social_key]); ?>">
                            <i class="fab fa-<?php echo esc_attr($social_key); ?>"></i>
                        </a>
                    </div>
				<?php endif; ?>
			<?php endforeach; ?>
        </div>

    </div>


	<?php if (!empty($metas['_thumbnail_id'])): ?>
        <div class="stm_single_ico__image">
			<?php if (!empty($metas['video'])): ?>
                <div data-fancybox class="stm_iframe_btn" href="<?php echo esc_url($metas['video']); ?>"></div>
			<?php endif; ?>
			<?php echo crypterio_get_image_vc($metas['_thumbnail_id'], '760x422'); ?>
        </div>
	<?php endif; ?>

</div>