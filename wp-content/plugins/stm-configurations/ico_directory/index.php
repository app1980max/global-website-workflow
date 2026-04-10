<?php

require_once STM_CONFIGURATIONS_PATH . '/ico_directory/helpers.php';
require_once STM_CONFIGURATIONS_PATH . '/ico_directory/ico_directory.class.php';
require_once STM_CONFIGURATIONS_PATH . '/ico_directory/vc/vc_map.php';

if(is_admin()) {
	require_once STM_CONFIGURATIONS_PATH . '/ico_directory/admin/butterbean_metaboxes.php';
}