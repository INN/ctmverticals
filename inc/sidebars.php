<?php

/**
 * Register our sidebars and other widget areas
 *
 * @since 1.0
 */
function ctmirror_register_sidebars() {
	$sidebars = array ();

	// Force generation of Footer 4 widget area, depending on selected footer layout
	if ( of_get_option('footer_layout') != '4col' ) {
		$sidebars[] = array(
			'name' 	=> __( 'Footer 4', 'largo' ),
			'desc' 	=> __( 'The fourth footer widget area.', 'largo' ),
			'id' 	=> 'footer-4'
		);
	}

	// the CT Mirror widget areas
	$sidebars[] = array (
		'name' 	=> __( 'Footer 5', 'ctmirror' ),
		'desc' 	=> __( 'The fifth footer widget area.', 'ctmirror' ),
		'id' 	=> 'footer-5'
	);
	$sidebars[] = array (
		'name' 	=> __( 'Footer 6', 'ctmirror' ),
		'desc' 	=> __( 'The third footer widget area.', 'ctmirror' ),
		'id' 	=> 'footer-6'
	);

	// register the active widget areas
	foreach ( $sidebars as $sidebar ) {
		register_sidebar( array(
			'name' 			=> $sidebar['name'],
			'description' 	=> $sidebar['desc'],
			'id' 			=> $sidebar['id'],
			'before_widget' => '<aside id="%1$s" class="%2$s clearfix">',
			'after_widget' 	=> "</aside>",
			'before_title' 	=> '<h3 class="widgettitle">',
			'after_title' 	=> '</h3>',
		) );
	}
}
// Largo hooks action at default priority. We want to run after that.
add_action( 'widgets_init', 'ctmirror_register_sidebars', 11 );