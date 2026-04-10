<?php

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

$theme = crypterio_get_theme_info();
$theme_name = $theme['name'];
?>
<div class="wrap about-wrap stm-admin-wrap  stm-admin-support-screen">
	<?php crypterio_get_admin_tabs('wpml'); ?>

		<div class="wrap otgsi_downloads_form">
			<?php
				$config['template'] = 'default'; //required
				WP_Installer_Show_Products($config);
			?>
		</div>

</div>