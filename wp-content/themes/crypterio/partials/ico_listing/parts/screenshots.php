<?php if (!empty($metas['gallery'])):
    $gallery = unserialize($metas['gallery']);
    ?>

    <div class="stm_single_ico_part stm_single_ico__screenshots">

        <i class="stm-id_screenshots stm_single_ico_part__icon stc"></i>
        <div class="stm_single_ico_part__title h4">
			<?php esc_html_e('Screenshots', 'crypterio'); ?>
        </div>

        <div class="stm_single_ico__gallery">

            <?php foreach($gallery as $value): ?>
                <?php if(!empty(intval($value))): ?>
                    <div class="stm_single_ico__gallery_item">
                        <a data-fancybox href="<?php echo esc_url(crypterio_get_image_url($value)); ?>"
                           rel="fancybox_gallery"
                           class="stm_fancy_btn">
                            <?php echo crypterio_get_image_vc($value, '230x130'); ?>
                        </a>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>

        </div>

    </div>

<?php endif; ?>