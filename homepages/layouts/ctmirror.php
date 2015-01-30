<?php

include_once get_template_directory() . '/homepages/homepage-class.php';

class CTMirror extends Homepage {
	function __construct($options=array()) {
		$defaults = array(
			'name' => __('CT Mirror Homepage Layout', 'largo'),
			'description' => __('Large Top Story at the top. Set the Homepage Size post prominence terms to determine featured image and excerpt size.', 'ctmirror'),
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
			'prominenceTerms' => array(
				array(
					'name' => __('Homepage Featured', 'ctmirror'),
					'description' => __('Add this label to a post for it to appear on the main section of the homepage.', 'ctmirror'),
					'slug' => 'homepage-featured'
				),
				array(
					'name' => __('Homepage Big', 'ctmirror'),
					'description' => __('Must be a child of the "Homepage Featured" term. Add this label to a post to make it it have a BIG image and LONG excerpt on the homepage.', 'ctmirror'),
					'slug' => 'homepage-big'
				),
				array(
					'name' => __('Homepage Medium', 'ctmirror'),
					'description' => __('Must be a child of the "Homepage Featured" term. Add this label to a post to make it it have a MEDIUM image and excerpt on the homepage.', 'ctmirror'),
					'slug' => 'homepage-medium'
				),
				array(
					'name' => __('Homepage Small', 'ctmirror'),
					'description' => __('Must be a child of the "Homepage Featured" term. Add this label to a post to make it it have a SMAL image and SHORT excerpt on the homepage.', 'ctmirror'),
					'slug' => 'homepage-small'
				),
				array(
					'name' => __('Homepage Top Story', 'ctmirror'),
					'description' => __('Must be a child of the "Homepage Big" term. If you are using a "Big story" homepage layout, add this label to a post to make it the top story on the homepage', 'ctmirror'),
					'slug' => 'homepage-top'
				),
			)
		);
		$options = array_merge($defaults, $options);
		parent::__construct($options);
	}

	function content() {
		return "CT Mirror homepage stub";
	}
}
