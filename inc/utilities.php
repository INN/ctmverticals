<?php

/**
* Check if the current post has any of given terms or their children.
*
* The given terms are checked against the post's terms' term_ids, names and slugs.
* Terms given as integers will only be checked against the post's terms' term_ids.
* If no terms are given, determines if post has any terms.
*
* @since 1.0
*
* @param string|int|array $term Optional. The term name/term_id/slug or array of them to check for.
* @param string $taxonomy Taxonomy name
* @param int|object $post Optional. Post to check instead of the current post.
* @return bool True if the current post has any of the given tags (or any tag, if no tag specified).
*/
function has_term_or_child( $term = '', $taxonomy = '', $post = null ) {

	$has_term_or_child = FALSE;

	if ( has_term($term, $taxonomy, $post) ) {

		$has_term_or_child = TRUE;

	} else {

		$term_parent_ids = array();

		if ( is_array($term) ) {
			foreach ($term as $parent_term) {
				if ( is_int($parent_term) ) {
					$term_parent_ids[] = $parent_term;
				} else {
					$maybe_parent_id = term_slug_or_name_to_id($parent_term, $taxonomy);
					if ( FALSE !== $maybe_parent_id ) {
						$term_parent_ids[] = $maybe_parent_id;
					}
				}
			}
		} elseif ( is_int($term) ) {
			$term_parent_ids[] = $term;
		} else {
			$maybe_parent_id = term_slug_or_name_to_id($term, $taxonomy);
			if ( FALSE !== $maybe_parent_id ) {
				$term_parent_ids[] = $maybe_parent_id;
			}
		}

		$term_child_ids = array();

		foreach ($term_parent_ids as $term_parent_id) {
			$maybe_child_ids = get_term_children( $term_parent_id, $taxonomy );
			if ( is_array($maybe_child_ids) ) {
				$term_child_ids = array_merge( $term_child_ids, $maybe_child_ids );
			}
		}

		$has_term_or_child = count($term_child_ids) && has_term($term_child_ids, $taxonomy);
	}

	return $has_term_or_child;
}

/**
* Get the a term's ID based on a string that may be the name or slug.
* Preferentially returns matches to slug.
*
* @param string $needle The search term. May be either a term slug or name.
* @param string $taxonomy The search haystack, the taxonomy.
* @return int|bool The integer term_id if found. FALSE if no match found.
*/
function term_slug_or_name_to_id ( $needle, $taxonomy ) {
	$term_id = FALSE;
	// First, try finding as a slug
	$term = get_term_by( 'slug', $needle, $taxonomy );
	if ( FALSE !== $term ) {
		// Match found!
		$term_id = $term->term_id;
	} else {
		// No match found. Try finding as a name.
		$term = get_term_by( 'name', $needle, $taxonomy );
		if ( FALSE !== $term ) {
			// Match found!
			$term_id = $term->term_id;
		}
	}
	return $term_id;
}


/**
 * var_dump() a variable to a file
 *
 * @param string $file Full path to file. Recommend: preg_replace('/\.php$/', '', __FILE__) . '-' . __FUNCTION__ . '.log'
 * @param string $var PHP content to var_dump
 * @param boolean $append TRUE to append to the file, false otherwise
 */
function fvar_dump($file,$var,$append=TRUE) {
	// Get var_dump output
	ob_start();
	var_dump($var);
	$str_var_dump = ob_get_clean();

	// Set file_put_contents flags
	$flags = 0;
	if ( $append ) {
		$flags = $flags | FILE_APPEND;
	}

	file_put_contents($file, $str_var_dump, $flags);
}
