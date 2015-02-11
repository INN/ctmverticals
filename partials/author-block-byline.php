<?php
/**
* Partial: Author block byline
* 
* Print all authors in a block for display, similar to a pull quote. Supports both WP User authors and Co-Author Plus authors.
*/

if ( function_exists( 'get_coauthors' ) && !isset( $values['largo_byline_text'] ) ) { ?>
	<div class="byline-block">
		<?php
		$postmeta = get_post_custom( $post_id );

		// Use largo_byline_text if present
		if ( isset( $postmeta['largo_byline_text'][0] ) && !empty($postmeta['largo_byline_text'][0]) ) {
			// Build photo
			if ( isset( $postmeta['ctmirror_byline_image'][0] ) && !empty($postmeta['ctmirror_byline_image'][0]) ) {
				$photo = sprintf(
					'<figure class="photo"><img alt="%s" src="%s" width="96" height="96" class="avatar avatar-96 photo" /></figure>',
					esc_attr($postmeta['largo_byline_text'][0]),
					$postmeta['ctmirror_byline_image'][0]
				);
			} else {
				$photo = '';
			}

			// Build byline
			$byline = sprintf(
				'<h1 class="byline">%s</h1>',
				largo_author_link( false )
			);

			// Build organization markup
			$org = $postmeta['ctmirror_byline_org'][0];
			if ( $org ) {
				$org_markup = sprintf (
					'<h2 class="byline-org">%s</h2>',
					$org
				);
			} else {
				$org_markup = '';
			}

			// Build title markup
			$title = $postmeta['ctmirror_byline_title'][0];
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
		}
		// Use Co-Authors Plus methods if present
		elseif ( function_exists( 'get_coauthors' ) ) {
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
				} else {
					$photo = '';
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
			}
		} ?>
	</div>
<?php } ?>