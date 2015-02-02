<?php
/**
 * The template for displaying content in the single.php template
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'hnews item' ); ?> itemscope itemtype="http://schema.org/Article">

	<?php do_action('largo_before_post_header'); ?>

	<header>

		<h5 class="top-tag"><?php largo_top_term(); ?></h5>

 		<h1 class="entry-title" itemprop="headline"><?php the_title(); ?></h1>
 		<h5 class="byline"><?php largo_byline(); ?></h5>

 		<?php
 			if ( !of_get_option( 'single_social_icons' ) == false ) {
 				largo_post_social_links();
 			}
 		?>

 		<?php largo_post_metadata( $post->ID ); ?>

	</header><!-- / entry header -->

	<?php
		do_action('largo_after_post_header');

		get_template_part( 'partials/single', 'hero' );

		do_action('largo_after_hero');

		get_template_part( 'partials/author', 'block-byline' );
	?>

	<div class="entry-content clearfix" itemprop="articleBody">
		<?php largo_entry_content( $post ); ?>
	</div><!-- .entry-content -->

	<?php do_action('largo_after_post_content'); ?>

	<footer class="post-meta bottom-meta">

    <?php if ( of_get_option( 'clean_read' ) === 'footer' ) : ?>
    	<div class="clean-read-container clearfix">
 			<a href="#" class="clean-read"><?php _e("View as 'Clean Read'", 'largo') ?></a>
 		</div>
 	<?php endif; ?>

	</footer><!-- /.post-meta -->

	<?php do_action('largo_after_post_footer'); ?>

</article><!-- #post-<?php the_ID(); ?> -->
