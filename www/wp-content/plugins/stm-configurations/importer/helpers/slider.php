<?php

function stm_theme_import_sliders($layout)
{
	$slider_names = array(
		'default' => array(
			'about_us_slider',
			'service_slider',
		),
        'advisor' => array(
            'about_us_slider',
            'service_slider',
            'main_slider'
        ),
		'corporate' => array(
			'about_us_slider',
			'service_slider',
			'main_slider'
		),
		'counselor' => array(
			'about_us_slider',
			'service_slider',
		),
	);

	if (!empty($slider_names[$layout])) {
		if (class_exists('RevSlider')) {
			$path = STM_CONFIGURATIONS_PATH . '/importer/demos/' . $layout . '/sliders/';
			foreach ($slider_names[$layout] as $slider_name) {
				$slider_path = $path . $slider_name . '.zip';
				if (file_exists($slider_path)) {
					$slider = new RevSlider();
					$slider->importSliderFromPost(true, true, $slider_path);
				}
			}
		}
	}
}