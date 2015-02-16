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
 * Include CT Mirror theme's and CSSS
 *
 * @see "js/ctmirror.js"
 * @see "sass/*"
 */
function enqueue_custom_script() {
	$version = '0.1.0';
	// JavaScript
	wp_enqueue_script(
		'ctmirror-js',
		get_stylesheet_directory_uri() . '/js/ctmirror.js',
		array('jquery'),
		$version,
		true
	);
	// CSS
	if ( rand(0,1) ) {
		// Enqueue styles for Trend CT data vertical
		$css = 'core-trend.css';
	} else {
		// Enqueue styles for CT Viewpoints opinion vertical
		$css = 'core-viewpoints.css';
	}
	wp_enqueue_style(
		'ctmirror-stylesheet',
		get_stylesheet_directory_uri() . '/css/' . $css
	);
	

}
// Add action with a low priority, to have CSS load later
add_action('wp_enqueue_scripts', 'enqueue_custom_script', 50);

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
 * Display comment header on the page if comments are enabled
 */
function ctmirror_largo_before_comments() {
	// Only display header if comments are enabled
	if ( comments_open() ) {
		echo '<h2 class="commentHeader">What do you think?</h2>';
	}
}
add_action( 'largo_before_comments', 'ctmirror_largo_before_comments', 11 );

/**
 * Add arbitrary HTML custom field after hero
 * When used in conjunction with Largo's "Override display of featured image for this post?",
 *    effectively replaces with hero image with arbitrary markup. (E.g. iframe)
 */
function ctmirror_largo_after_hero() {
	$hero_html = get_post_meta( get_the_ID(), 'hero_html', true );
	// check if the custom field has a value
	if( ! empty( $hero_html ) ) {
		echo '<div class="after-hero">' . $hero_html . '</div>';
	}
}
add_action( 'largo_after_hero', 'ctmirror_largo_after_hero', 11 );

/**
 * Modify CT Mirror opinion vertical submission form
 */
function ctmirror_gform_after_submission( $entry, $form ) {
	if ( 'Submit an Opinion Piece' == $form['title'] ) {
		// Get headshot image URL
		$headshot_url = $entry[ '9' ];
		// Only resize if a headshot image was submitted
		if ( $headshot_url ) {
			// Determine full path to image file
			$form_id = $entry[ 'form_id' ];
			$upload_path = GFFormsModel::get_upload_path( $form_id );
			$upload_url = GFFormsModel::get_upload_url( $form_id );
			$headshot_path = str_replace( $upload_url, $upload_path, $headshot_url );
			// Instantiate WP image editor
			$headshot_editor = wp_get_image_editor( $headshot_path );
			if ( ! is_wp_error( $headshot_editor )) {
				// WP image editor multi_resize handles image resizing, filename changing, and saving
				$headshot_meta = $headshot_editor->multi_resize( array(array(
					'width'  => 96,
					'height' => 96,
					'crop'   => TRUE,
				)) );
				// Only update the postmeta if the resize was successful & new filename returned
				if ( is_array($headshot_meta) && isset($headshot_meta[0]['file']) && $headshot_meta[0]['file'] ) {
					// Build thumbnail URL
					$headshot_thumb_url = dirname($headshot_url) . '/' . $headshot_meta[0]['file'];

					// Update ctmirror_byline_image entry & postmeta
					$entry[ '17' ] = $headshot_thumb_url;
					$post_id = $entry['post_id'];
					update_post_meta($post_id, 'ctmirror_byline_image', $headshot_thumb_url );
				}
			}
		}
	}
}
add_action( 'gform_after_submission_1', 'ctmirror_gform_after_submission', 10, 2 );


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
