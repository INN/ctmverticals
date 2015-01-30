<div id="supplementary" class="ctmirror-footer row-fluid">
	<?php
	/**
	 * The Footer widget areas.
	 * CT Mirror verticals use 6 equal footer columns
	 */
	 $layout_spans = array( 'span2', 'span2', 'span2', 'span2', 'span2', 'span2' );
	?>

	<!-- Footer column 1 -->
	<div id='footer-column-1' class="<?php echo $layout_spans[0]; ?> widget-area footer-col-1" role="complementary">
		<?php if ( ! dynamic_sidebar( 'footer-1' ) )
			largo_nav_menu( array( 'theme_location' => 'footer', 'container' => false, 'depth' => 1  ) );
		?>
	</div>

	<!-- Footer column 2 -->
	<div class="<?php echo $layout_spans[1]; ?> widget-area footer-col-2" role="complementary">
		<?php if (!dynamic_sidebar('footer-2')) { ?>
			<p><?php _e('Please add widgets to the Footer 2 area in WordPress Admin, under appearance > widgets.', 'ctmirror'); ?></p>
		<?php } ?>
	</div>

	<!-- Footer column 3 -->
	<div class="<?php echo $layout_spans[2]; ?> widget-area footer-col-3" role="complementary">
		<?php if (!dynamic_sidebar('footer-3')) { ?>
			<p><?php _e('Please add widgets to the Footer 3 area in WordPress Admin, under appearance > widgets.', 'ctmirror'); ?></p>
		<?php } ?>
	</div>

	<!-- Footer column 4 -->
	<div class="<?php echo $layout_spans[3]; ?> widget-area footer-col-4" role="complementary">
		<?php if (!dynamic_sidebar('footer-4')) { ?>
			<p><?php _e('Please add widgets to the Footer 4 area in WordPress Admin, under appearance > widgets.', 'ctmirror'); ?></p>
		<?php } ?>
	</div>

	<!-- Footer column 5 -->
	<div class="<?php echo $layout_spans[4]; ?> widget-area footer-col-5" role="complementary">
		<?php if (!dynamic_sidebar('footer-5')) { ?>
			<p><?php _e('Please add widgets to the Footer 5 area in WordPress Admin, under appearance > widgets.', 'ctmirror'); ?></p>
		<?php } ?>
	</div>

	<!-- Footer column 6 -->
	<div class="<?php echo $layout_spans[5]; ?> widget-area footer-col-6" role="complementary">
		<?php if (!dynamic_sidebar('footer-6')) { ?>
			<p><?php _e('Please add widgets to the Footer 6 area in WordPress Admin, under appearance > widgets.', 'ctmirror'); ?></p>
		<?php } ?>
		<ul id="ft-social" class="social-icons">
			<?php largo_social_links(); ?>
		</ul>
	</div>
</div>
