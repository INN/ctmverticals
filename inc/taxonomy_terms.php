<?php

/**
 * Add CT Mirror vertical post promince terms
 */
function ctmirror_prominence_terms($termsDefinitions) {
	$termsDefinitions[] = array(
		'name' => __('Footer Tease 1', 'ctmirror'),
		'description' => __('Add this label to a post for it to appear in the FIRST footer teaser widget.', 'ctmirror'),
		'slug' => 'footer-tease-1'
	);
	$termsDefinitions[] = array(
		'name' => __('Footer Tease 2', 'ctmirror'),
		'description' => __('Add this label to a post for it to appear in the SECOND footer teaser widget.', 'ctmirror'),
		'slug' => 'footer-tease-2'
	);

	return $termsDefinitions;
}
add_filter('largo_prominence_terms', 'ctmirror_prominence_terms', 1);