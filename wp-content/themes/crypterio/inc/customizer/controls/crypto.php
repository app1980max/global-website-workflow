<?php
if ( ! class_exists( 'WP_Customizer_Crypto_Control' ) ) {

	class WP_Customizer_Crypto_Control extends WP_Customize_Control {

		public $type = 'stm-text';
		public $placeholder = '';

		public function render_content() {

			$input_args = array(
				'type'        => 'text',
				'label'       => $this->label,
				'name'        => '',
				'id'          => $this->id,
				'value'       => $this->value(),
				'placeholder' => $this->placeholder,
				'link'        => $this->get_link(),
				'options'     => $this->choices
			);

			$crypto_data = crypterio_get_cmc_data();
			?>

			<?php $currencies =  wp_list_pluck($crypto_data, 'name'); ?>

			<div id="stm-customize-control-<?php echo esc_attr( $this->id ); ?>" class="stm-customize-control stm-customize-control-<?php echo esc_attr( str_replace( 'stm-', '', $this->type ) ); ?>">

				<span class="customize-control-title">
					<?php echo esc_html( $this->label ); ?>
				</span>

				<div class="stm-form-item">
					<div class="stm-text-wrapper stm-form-item">
						<?php stm_input( $input_args ); ?>
					</div>
				</div>

				<?php if ( '' != $this->description ) : ?>
					<div class="description customize-control-description">
						<?php echo esc_html( $this->description ); ?>
					</div>
				<?php endif; ?>

			</div>

            <script type="text/javascript">
                var stm_crypto_currencies = <?php echo json_encode($currencies) ?>;
                var stm_crypto = {};
                if(stm_crypto_currencies !== null) {
                   stm_crypto = Object.values(stm_crypto_currencies);
                }
            </script>

			<?php
		}
	}
}