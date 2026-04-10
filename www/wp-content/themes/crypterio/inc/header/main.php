<?php
add_filter('stm_hb_elements', 'crypterio_hb_elements', 100);

function crypterio_hb_elements($elements) {

	if(!empty($elements[13]) and $elements[13]['type'] == 'icontext') {
		$elements[13]['settings_template'] = 'hb_templates/modals/icontext';
	}

	$elements[] = array(
		'label' => 'Cryptodata',
		'type' => 'text',
		'icon' => 'crypto',
		'view_template' => 'crypto',
		'settings_template' => 'hb_templates/modals/crypto'
	);

	return $elements;
}