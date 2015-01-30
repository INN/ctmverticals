<div id="content-main" class="span8">
	<?php
	get_template_part('partials/home-topstories');

	get_template_part('partials/home-post-list');
	?>
</div>

<div id="rail" class="span4">
<?php if (!dynamic_sidebar('sidebar-main')) { ?>
	<p><?php _e('Please add widgets to the Main Sidebar area in WordPress Admin, under appearance > widgets.', 'ctmirror'); ?></p>
<?php } ?>
</div>
