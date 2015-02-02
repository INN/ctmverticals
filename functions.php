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
	include_once __DIR__ . '/homepages/layouts/ctmirror.php';
	register_homepage_layout('CTMirror');
}
// Largo homepage initialization uses priority 0.
// Child layout registration must be < 10 for post prominence tags to function
add_action( 'init', 'register_custom_homepage_layout', 4 );


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
		get_stylesheet_directory_uri() . '/js/ctmirror.js',
		array('jquery'),
		$version,
		true
	);
}
add_action('wp_enqueue_scripts', 'enqueue_custom_script');

/*
 * Renders markup for a page of posts and sends it back over the wire.
 */
if (!function_exists('largo_load_more_posts')) {
	function largo_load_more_posts() {
		$paged = $_POST['paged'];
		$context = (isset($_POST['query']))? $_POST['query'] : array();

		$args = array_merge(array(
			'paged' => $paged,
			'post_status' => 'publish',
			'posts_per_page' => 10,
			'ignore_sticky_posts' => true
		), $context);

		if ( of_get_option('num_posts_home') )
			// CT Mirror customization. Add 1 to the posts per page, to account for the Top Story.
			$args['posts_per_page'] = of_get_option('num_posts_home') + 1;
		if ( of_get_option('cats_home') )
			$args['cat'] = of_get_option('cats_home');
		$query = new WP_Query($args);

		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) : $query->the_post();
				get_template_part( 'partials/content', 'home' );
			endwhile;
		}
		wp_die();
	}
	add_action('wp_ajax_nopriv_load_more_posts', 'largo_load_more_posts');
	add_action('wp_ajax_load_more_posts', 'largo_load_more_posts');
}

/**
 * Post-Largo setup initialization
 */
function ctmirror_child_add_image_size() {
	// Large: 910px
	// Medium: 450px
	// Small: 190px
	add_image_size( 'ctm-big',    910, 9999 ); // unlimited height
	add_image_size( 'ctm-medium', 450, 9999 ); // unlimited height
	add_image_size( 'ctm-small',  190, 9999 ); // unlimited height
}
add_action( 'after_setup_theme', 'ctmirror_child_add_image_size', 11 );

/**
 * Post-Largo setup initialization
 */
function ctmirror_largo_before_comments() {
	echo '<h2 class="commentHeader">What do you think?</h2>';
}
add_action( 'largo_before_comments', 'ctmirror_largo_before_comments', 11 );

/**
 * Load up all of the other goodies from the /inc directory
 */
$includes = array();
$includes[] = '/inc/sidebars.php'; // Configures sidebars
$includes[] = '/inc/taxonomy_terms.php'; // Configures taxonomy terms
$includes[] = '/inc/utilities.php'; // Utility functions

// Perform load
foreach ( $includes as $include ) {
	require_once( get_stylesheet_directory() . $include );
}
