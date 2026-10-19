<?php
/**
 * Unlisted entries: live at their own URL, hidden everywhere else.
 *
 * WHY: on 19 Oct 2026 the owner asked for the PCEA Chuka case study to stay
 * reachable only through old backlinks and the legacy redirect from the 2020
 * post, and not to appear anywhere on the site. WordPress has no "unlisted"
 * status (private would 404 the redirect target), so editors list slugs in
 * Sound Creations -> Settings -> "Unlisted projects" and this file:
 *  - removes them from every listing query (projects archive, homepage
 *    Our Work grid, related-project blocks, search) while the page itself
 *    still loads;
 *  - keeps them out of the sitemap and marks them noindex,follow, because a
 *    page the company does not want shown should not be pushed to Google
 *    either. Links on the page still pass value (follow).
 *
 * @package SoundCreationsCore
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Post IDs of unlisted projects, from the comma-separated slug setting.
 *
 * @return int[]
 */
function sc_core_unlisted_ids() {
	static $ids = null;
	if ( null !== $ids ) {
		return $ids;
	}
	$ids   = array();
	$raw   = function_exists( 'sc_core_get' ) ? (string) sc_core_get( 'unlisted_projects', '' ) : '';
	$slugs = array_filter( array_map( 'sanitize_title', array_map( 'trim', explode( ',', $raw ) ) ) );
	foreach ( $slugs as $slug ) {
		$post = get_page_by_path( $slug, OBJECT, 'sc_project' );
		if ( $post instanceof WP_Post ) {
			$ids[] = (int) $post->ID;
		}
	}
	$ids = (array) apply_filters( 'sc_core_unlisted_ids', $ids );
	return $ids;
}

/**
 * True when the current request is the unlisted entry's own page.
 *
 * @return bool
 */
function sc_core_is_unlisted_view() {
	return is_singular( 'sc_project' ) && in_array( (int) get_queried_object_id(), sc_core_unlisted_ids(), true );
}

add_action(
	'pre_get_posts',
	function ( $q ) {
		if ( is_admin() || ! ( $q instanceof WP_Query ) ) {
			return;
		}
		// Never touch the query that loads the unlisted page itself.
		if ( $q->is_singular() ) {
			return;
		}
		$pt = $q->get( 'post_type' );
		$pt = is_array( $pt ) ? $pt : array( $pt );
		// Listings of projects, or untyped queries such as search.
		if ( ! in_array( 'sc_project', $pt, true ) && ! in_array( 'any', $pt, true ) && ! ( $q->is_search() && array( '' ) === $pt ) ) {
			return;
		}
		$ids = sc_core_unlisted_ids();
		if ( count( $ids ) === 0 ) {
			return;
		}
		$not = (array) $q->get( 'post__not_in' );
		$q->set( 'post__not_in', array_values( array_unique( array_merge( $not, $ids ) ) ) );
	},
	20
);

// Keep unlisted entries out of the WordPress core sitemap.
add_filter(
	'wp_sitemaps_posts_query_args',
	function ( $args, $post_type ) {
		if ( 'sc_project' !== $post_type ) {
			return $args;
		}
		$ids = sc_core_unlisted_ids();
		if ( count( $ids ) > 0 ) {
			$not                  = isset( $args['post__not_in'] ) ? (array) $args['post__not_in'] : array();
			$args['post__not_in'] = array_values( array_unique( array_merge( $not, $ids ) ) );
		}
		return $args;
	},
	10,
	2
);

// noindex,follow on the unlisted page itself (WordPress robots API).
add_filter(
	'wp_robots',
	function ( $robots ) {
		if ( sc_core_is_unlisted_view() ) {
			unset( $robots['index'] );
			$robots['noindex'] = true;
			$robots['follow']  = true;
		}
		return $robots;
	},
	20
);

// Same rule when Rank Math prints the robots tag.
add_filter(
	'rank_math/frontend/robots',
	function ( $robots ) {
		if ( sc_core_is_unlisted_view() ) {
			$robots['index']  = 'noindex';
			$robots['follow'] = 'follow';
		}
		return $robots;
	},
	20
);
