<?php
/**
 * The default template for displaying content
 */
$tags       = of_get_option( 'tag_display' );
$hero_class = largo_hero_class( $post->ID, FALSE );
$values     = get_post_custom( $post->ID );
$featured   = has_term_or_child( 'homepage-featured', 'prominence' );

if ( has_term_or_child( 'homepage-big', 'prominence' ) ) {
	$archive_size = 'big';
	$img_size     = 'ctm-big';
	$excerpt_len  = 7;
} elseif ( has_term_or_child( 'homepage-medium', 'prominence' ) ) {
	$archive_size = 'medium';
	$img_size     = 'ctm-medium';
	$excerpt_len  = 4;
} elseif ( has_term_or_child( 'homepage-small', 'prominence' ) ) {
	$archive_size = 'small';
	$img_size     = 'ctm-small';
	$excerpt_len  = 2;
} elseif ( has_post_thumbnail() ) {
	// Stories without explicit Homepage post prominence
	// WITH featured image
	// Default to Medium Post Prominence
	$archive_size = 'medium';
	$img_size     = 'ctm-medium';
	$excerpt_len  = 4;
	// Set $featured to TRUE to display featured image
	$featured     = TRUE;
} else {
	// Stories without explicit Homepage post prominence
	// WITHOUT featured image
	// Default to Small Post Prominence
	$archive_size = 'small';
	$img_size     = 'ctm-small';
	$excerpt_len  = 2;
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(array('clearfix', 'homepage-'.$archive_size)); ?>>
	<?php
		if ( $featured && ( has_post_thumbnail() || $values['youtube_url'] ) ) {
	?>
		<header>
		<?php echo '<a href="' . get_permalink() . '">'; ?>
			<div class="hero span12 <?php echo $hero_class; ?>">
			<?php
				if ( $youtube_url = $values['youtube_url'][0] ) {
					echo '<div class="embed-container">';
					largo_youtube_iframe_from_url( $youtube_url );
					echo '</div>';
				} elseif( has_post_thumbnail() ){
					the_post_thumbnail( $img_size );
				}
			?>
			</div>
			<?php echo '</a>'; ?>
		</header>
	<?php
		}
		$entry_classes = 'entry-content';
		if ( $featured ) $entry_classes .= ' span10 with-hero';
		echo '<div class="' . $entry_classes . '">';

		if ( largo_has_categories_or_tags() && $tags === 'top' ) {
			echo '<h5 class="top-tag">' . largo_top_term( $args = array( 'echo' => FALSE ) ) . '</h5>';
		}

		if ( !$featured ) {
			echo '<a href="' . get_permalink() . '">' . get_the_post_thumbnail() . '</a>';
		}
	?>

		<h2 class="entry-title">
			<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute( array( 'before' => __( 'Permalink to', 'largo' ) . ' ' ) )?>" rel="bookmark"><?php the_title(); ?></a>
		</h2>

		<h5 class="byline"><?php largo_byline(); ?></h5>

		<?php largo_excerpt( $post, $excerpt_len, false, NULL, true, true ); ?>

		<?php if ( !is_home() && largo_has_categories_or_tags() && $tags === 'btm' ) { ?>
			<h5 class="tag-list"><strong><?php _e('More about:', 'largo'); ?></strong> <?php largo_categories_and_tags( 8 ); ?></h5>
		<?php } ?>

		</div><!-- .entry-content -->

</article><!-- #post-<?php the_ID(); ?> -->
