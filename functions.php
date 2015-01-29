<?php
/**
 * Child theme's custom functions go here
 */

/**
 * Register a custom homepage layout
 *
 * @see "homepages/layouts/your_homepage_layout.php"
 */
function register_custom_homepage_layout() {
	include_once __DIR__ . '/homepages/layouts/ctmirrorview.php';
	register_homepage_layout('CTMirrorView');
}
add_action('init', 'register_custom_homepage_layout', 0);


/**
 * Register a custom widget
 *
 * @see "inc/widgets/your_simple_widget.php"
 */
function register_custom_widget() {
	include_once __DIR__ . '/inc/widgets/your_simple_widget.php';
	register_widget('your_simple_widget');
}
// add_action('widgets_init', 'register_custom_widget', 1);

/**
 * Include CT Mirror theme's javascript
 *
 * @see "js/ctmirror.js"
 */
function enqueue_custom_script() {
	$version = '0.1.0';
	wp_enqueue_script(
		'your_theme',
		get_stylesheet_directory() . '/js/ctmirror.js',
		array('jquery'),
		$version,
		true
	);
}
add_action('wp_enqueue_scripts', 'enqueue_custom_script');
