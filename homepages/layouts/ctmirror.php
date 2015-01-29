<?php

include_once get_template_directory() . '/homepages/homepage-class.php';

class CTMirror extends Homepage {
	function __construct($options=array()) {
		$defaults = array(
			'name' => __('CT Mirror Homepage Layout', 'largo'),
			'description' => __('CT Mirror Homepage Layout', 'ctmirror'),
			'template' => get_stylesheet_directory() . '/homepages/templates/ctmirror.php',
			'assets' => array(
				array(
					'ctmirror_javascript',
					get_stylesheet_directory_uri() . '/homepages/assets/css/ctmirror.css',
					array()
				),
				array(
					'ctmirror_css',
					get_stylesheet_directory_uri() . '/homepages/assets/js/ctmirror.js',
					array('jquery')
				)
			),
		);
		$options = array_merge($defaults, $options);
		parent::__construct($options);
	}

	function content() {
		return "CT Mirror homepage stub";
	}
}
