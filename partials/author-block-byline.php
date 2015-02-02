<?php
/**
* Partial: Author block byline
* 
* Print all authors in a block for display, similar to a pull quote. Supports both WP User authors and Co-Author Plus authors.
*/

if ( function_exists( 'get_coauthors' ) && !isset( $values['largo_byline_text'] ) ) { ?>
	<div class="byline-block">
		<?php
		// Support multiple authors
		$coauthors = get_coauthors( $post_id );
		foreach( $coauthors as $author ) {

			// Get author details
			$byline_text = $author->display_name;
			$org = $author->organization;
			$title = $author->job_title;

			// Build photo
			if ( largo_has_avatar( $author->user_email ) ) {
				$photo = '<figure class="photo">' . get_avatar( $author->ID, 96, '', $author->display_name ) . '</figure>';
			} elseif ( $author->type == 'guest-author' && get_the_post_thumbnail( $author->ID ) ) {
				$photo = get_the_post_thumbnail( $author->ID, array( 96,96 ) );
				$photo = str_replace( 'attachment-96x96 wp-post-image', 'avatar avatar-96 photo', $photo );
				$photo = '<figure class="photo">' . $photo . '</figure>';
			}

			// Build byline
			$byline = sprintf(
				'<h1 class="byline"><a class="url fn n" href="%s" title="%s" rel="author">%s</a></h1>',
				get_author_posts_url( $author->ID, $author->user_nicename ),
				esc_attr( sprintf( __( 'Read All Posts By %s', 'largo' ), $author->display_name ) ),
				esc_html( $byline_text )
			);

			// Build organization markup
			if ( $org ) {
				$org_markup = sprintf (
					'<h2 class="byline-org">%s</h2>',
					$org
				);
			} else {
				$org_markup = '';
			}

			// Build title markup
			if ( $title ) {
				$title_markup = sprintf (
					'<h3 class="byline-title">%s</h3>',
					$title
				);
			} else {
				$title_markup = '';
			}

			// Output individual author block
			printf(
				'<div class="author">%s%s%s%s</div>',
				$photo,
				$byline,
				$org_markup,
				$title_markup
			);
		} ?>
	</div>
<?php } ?>