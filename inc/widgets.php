<?php
/**
* Largo unregisters many default widgets, including RSS.
* Re-register it for CT Mirror's use.
*/
function ctmirror_widgets_init() {
	register_widget('WP_Widget_RSS');
}
add_action( 'widgets_init', 'ctmirror_widgets_init', 11 );
