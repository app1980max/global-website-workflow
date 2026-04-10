<?php if (!empty($metas['url_1']) and !empty($metas['url_label_1'])): ?>

    <div class="stm_single_ico_part stm_single_ico__market">

        <i class="stm-id_additional_links stm_single_ico_part__icon stc"></i>
        <div class="stm_single_ico_part__title h4">
			<?php esc_html_e('Additional links', 'crypterio'); ?>
        </div>

        <div class="stm_single_ico__token_sales stm_single_ico__links">
			<?php $i = 1;
			while ($i <= 4): ?>
				<?php if (!empty($metas['url_' . $i]) and !empty($metas['url_label_' . $i])): ?>
                    <div class="stm_single_ico__token_sale">
                        <a href="<?php echo esc_url($metas['url_' . $i]); ?>" target="_blank">
							<?php echo esc_attr($metas['url_label_' . $i]); ?> <i class="fas fa-external-link"></i>
                        </a>
                    </div>
				<?php endif;
				$i++; ?>
			<?php endwhile; ?>
        </div>


    </div>

<?php endif;