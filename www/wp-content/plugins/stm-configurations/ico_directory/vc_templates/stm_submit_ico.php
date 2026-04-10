<?php
$atts = vc_map_get_attributes($this->getShortcode(), $atts);
extract($atts);

stm_ico_directory_module_styles('stm_submit_ico');
stm_ico_directory_module_script('vc/stm_submit_ico');

wp_enqueue_script('stm_grecaptcha');

$fields = stm_submit_ico_fields($atts);

$recaptcha_enabled = get_theme_mod('enable_recaptcha', 0);
$recaptcha_public_key = get_theme_mod('recaptcha_public_key');
$recaptcha_secret_key = get_theme_mod('recaptcha_secret_key');
?>

<div class="stm_submit_ico">
    <form type="POST" enctype="multipart/form-data">

        <div class="stm_submit_ico__inner inner">
			<?php if (!empty($title)): ?>
                <h2 class="stm_submit_ico__title sbc_a"><?php echo sanitize_text_field($title); ?></h2>
			<?php endif; ?>

            <div class="stm_submit_ico__fields">
				<?php foreach ($fields as $field_name => $field):
					$type = (empty($field['type'])) ? 'text' : $field['type'];
					$placeholder = (!empty($field['placeholder'])) ? $field['placeholder'] : '';
					$required = (!empty($field['required']) and $field['required']) ? 'required1' : '';
					?>
                    <div class="stm_submit_ico__field <?php echo esc_attr('field_' . $field_name); ?>">
                        <div class="stm_submit_ico__field_label">
							<?php echo sanitize_text_field($field['label']); ?><?php echo (!empty($required)) ? '*' : ''; ?>
                        </div>
                        <div class="stm_submit_ico__field_value">
							<?php switch ($type) {
								case 'select' : ?>
                                    <select name="<?php echo esc_attr($field_name); ?>">
										<?php foreach ($field['choices'] as $key => $value): ?>
                                            <option value="<?php echo esc_attr($key); ?>"><?php echo esc_attr($value); ?></option>
										<?php endforeach; ?>
                                    </select>
									<?php break;
								case 'radio' : ?>
                                    <input type="hidden" name="<?php echo esc_attr($field_name); ?>"
                                           value="<?php esc_html_e('Yes', 'crypterio'); ?>"/>
                                    <div class="stm_submit_ico__field_radio stm_submit_ico__field_radio_yes active"
                                         data-value="<?php esc_html_e('Yes', 'crypterio'); ?>"></div>
                                    <div class="stm_submit_ico__field_radio  stm_submit_ico__field_radio_no"
                                         data-value="<?php esc_html_e('No', 'crypterio'); ?>"></div>
									<?php break;
								case 'image' : ?>
                                    <div class="stm_ico_submit__file">
                                        <span class="form-control">
                                            <?php echo esc_attr($placeholder) ?>
                                        </span>
                                        <i class="fa fa-paperclip"></i>
                                        <input type="file" name="<?php echo esc_attr($field_name); ?>" data-placeholder="<?php echo esc_attr($placeholder) ?>" />
                                    </div>
									<?php break;
								case 'date' : ?>
                                    <input type="date"
                                           placeholder="<?php echo esc_attr($placeholder); ?>"
                                           class="form-control"
										<?php echo esc_attr($required); ?>
                                           name="<?php echo esc_attr($field_name); ?>"/>
									<?php break;
								default: ?>
                                    <input type="text"
                                           placeholder="<?php echo esc_attr($placeholder); ?>"
                                           class="form-control"
										    <?php echo esc_attr($required); ?>
                                           name="<?php echo esc_attr($field_name); ?>"/>
								<?php } ?>
                        </div>
                    </div>
				<?php endforeach; ?>

            </div>


            <div class="text-center">
                <div class="stm_submit_ico__submit">
					<?php if (!empty($recaptcha_enabled) and $recaptcha_enabled and !empty($recaptcha_public_key) and !empty($recaptcha_secret_key)) : ?>
                        <div class="input-group">
                            <div class="g-recaptcha"
                                 data-sitekey="<?php echo esc_attr($recaptcha_public_key); ?>"
                                 data-size="normal"></div>
                        </div>
					<?php endif; ?>
                    <div class="stm_submit_ico__submit_btn">
                        <button type="submit">
                            <span><?php esc_html_e('Submit', 'crypterio'); ?></span>
                            <i class="stm-stm14_right_arrow"></i>
                        </button>
                    </div>
                </div>
            </div>

        </div>

        <div class="text-center">
            <div class="submit_ico_validation"></div>
        </div>

    </form>
</div>