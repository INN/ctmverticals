<?php
global $tags, $shown_ids;

$topstory = largo_get_featured_posts(array(
	'tax_query' => array(
		array(
			'taxonomy' => 'prominence',
			'field' => 'slug',
			'terms' => 'homepage-top'
		)
	),
	'showposts' => 1
));

if (!empty($topstory)) { ?>
	<div class="homepage-topstory">
		<?php if ($topstory->have_posts()) {
				while ($topstory->have_posts()) {
					$topstory->the_post();
					$shown_ids[] = get_the_ID();

					get_template_part('partials/content', 'home');
				}
		} ?>
	</div>
<?php }
