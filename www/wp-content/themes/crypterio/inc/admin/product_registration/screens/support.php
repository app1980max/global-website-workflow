<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

$theme = crypterio_get_theme_info();
$theme_name = $theme['name'];
?>
<div class="wrap about-wrap stm-admin-wrap  stm-admin-support-screen">
	<?php crypterio_get_admin_tabs('support'); ?>
	<div class="stm-admin-important-notice">

		<p class="about-description"><?php printf(wp_kses_post(__( '%s comes with 6 months of free support for every license you purchase. Support can be extended through subscriptions via ThemeForest.', 'crypterio' )), $theme_name); ?></p>
		<p><a href="<?php echo esc_url(crypterio_theme_support_url()); ?>" class="button button-large button-primary stm-admin-button stm-admin-large-button" target="_blank" rel="noopener noreferrer"><?php esc_attr_e( 'Create A Support Account', 'crypterio' ); ?></a></p>
	</div>

	<div class="stm-admin-row">
		<div class="stm-admin-two-third">

			<div class="stm-admin-row">

				<div class="stm-admin-one-half">
					<div class="stm-admin-one-half-inner">
						<h3>
							<span>
								<img src="<?php echo crypterio_get_admin_images_url('ticket.svg'); ?>" />
							</span>
							<?php esc_html_e( 'Ticket System', 'crypterio' ); ?>
						</h3>
						<p>
							<?php esc_html_e( 'We offer excellent support through our advanced ticket system. Make sure to register your purchase first to access our support services and other resources.', 'crypterio' ); ?>
						</p>
						<a href="<?php echo esc_url(crypterio_theme_support_url()); ?>" target="_blank">
							<?php esc_html_e( 'Submit a ticket', 'crypterio' ); ?>
						</a>
					</div>
				</div>

				<div class="stm-admin-one-half">
					<div class="stm-admin-one-half-inner">
						<h3>
							<span>
								<img src="<?php echo crypterio_get_admin_images_url('docs.svg'); ?>" />
							</span>
							<?php esc_html_e( 'Documentation', 'crypterio' ); ?>
						</h3>
						<p>
							<?php printf(wp_kses_post(__( 'Our online documentation is a useful resource for learning the every aspect and features of %s.', 'crypterio' )), $theme_name); ?>
						</p>
						<a href="<?php echo esc_url(crypterio_theme_docs_url() . 'crypterio-theme-documentation/'); ?>" target="_blank">
							<?php esc_html_e( 'Learn more', 'crypterio' ); ?>
						</a>
					</div>
				</div>
			</div>

			<div class="stm-admin-row">

				<div class="stm-admin-one-half">
					<div class="stm-admin-one-half-inner">
						<h3>
							<span>
								<img src="<?php echo crypterio_get_admin_images_url('tutorials.svg'); ?>" />
							</span>
							<?php esc_html_e( 'Video Tutorials', 'crypterio' ); ?>
						</h3>
						<p>
							<?php printf(wp_kses_post(__( 'We recommend you to watch video tutorials before you start the theme customization. Our video tutorials can teach you the different aspects of using %s.', 'crypterio' )), $theme_name); ?>
						</p>
						<a href="https://www.youtube.com/watch?v=sZkW6nbUsKI&feature=youtu.be" target="_blank">
							<?php esc_html_e( 'Watch Videos', 'crypterio' ); ?>
						</a>
					</div>
				</div>

			</div>

		</div>
	</div>

</div>