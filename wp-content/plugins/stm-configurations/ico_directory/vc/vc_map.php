<?php
if (class_exists('WPBakeryShortCodesContainer')) {
	$modules = array(
		'stm_ico_search',
		'ico_grid',
		'ico_list',
		'ico_grid_categories',
		'submit_ico',
	);

	foreach ($modules as $module) {
		require_once STM_CONFIGURATIONS_PATH . '/ico_directory/vc/modules/' . $module . '.php';
	}
}