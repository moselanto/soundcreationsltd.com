<?php
/**
 * Product directory facets: filter products by Brand, Application and
 * Product Type.
 *
 * WHERE THE DIRECTORY LIVES. The sc_product archive (/products/) is 301'd to
 * /brands/ by sc_core_redirect_product_archive() -- a documented decision in
 * AGENTS.md section 5, not to be "fixed". The represented-products list is
 * presented on the Brands archive, so that is where the filterable product
 * directory renders. Because the Brands archive's main query is sc_brand, the
 * product list is necessarily a secondary query; its arguments are built
 * here so the query rules survive a re-theme. pre_get_posts is also hooked
 * below, so if the product archive is ever reinstated (or a product taxonomy
 * archive is reached) the same facets apply to that main query unchanged.
 *
 * DESIGN.
 *   - Plain GET parameters, so filtering works with JavaScript off and every
 *     filtered view is a shareable link.
 *   - Parameter names are f_-prefixed on purpose: "sc_brand" is the brand
 *     post type's own query var and the taxonomy names are query vars too,
 *     so reusing them would make WordPress try to resolve a single brand or
 *     a taxonomy archive instead of filtering.
 *   - Every value is sanitize_title()'d and then must match a real term slug
 *     in the expected taxonomy; anything else is silently dropped, so a
 *     crafted URL can only ever produce the unfiltered list.
 *   - Only terms that are actually attached to a published product are
 *     offered, so no filter option leads to an empty page.
 *   - Filtered permutations are noindex,follow (see seo.php) and the
 *     canonical stays the unfiltered archive: every combination is a thin
 *     duplicate of the directory and must not compete in search.
 *
 * @package SoundCreationsCore
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Facet definitions: GET parameter => array( taxonomy, label ).
 *
 * @return array<string, array{0:string,1:string}>
 */
function sc_core_product_facets() {
	return array(
		'f_brand'       => array( 'sc_brand_tax', __( 'Brand', 'sc-core' ) ),
		'f_application' => array( 'sc_application', __( 'Application', 'sc-core' ) ),
		'f_type'        => array( 'sc_product_category', __( 'Product type', 'sc-core' ) ),
	);
}

/**
 * The validated facet selections for this request.
 *
 * @return array<string, string> GET parameter => term slug, only valid ones.
 */
function sc_core_product_filter_values() {
	static $values = null;
	if ( null !== $values ) {
		return $values;
	}
	$values = array();
	foreach ( sc_core_product_facets() as $param => $def ) {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- read-only GET filter, no state change.
		if ( ! isset( $_GET[ $param ] ) || ! is_string( $_GET[ $param ] ) ) {
			continue;
		}
		$slug = sanitize_title( wp_unslash( $_GET[ $param ] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( '' === $slug ) {
			continue;
		}
		$term = get_term_by( 'slug', $slug, $def[0] );
		if ( $term instanceof WP_Term ) {
			$values[ $param ] = $term->slug;
		}
	}
	return $values;
}

/**
 * Whether any valid product facet is applied to this request.
 *
 * @return bool
 */
function sc_core_product_filters_active() {
	return count( sc_core_product_filter_values() ) > 0;
}

/**
 * The tax_query for the current selections (AND across facets).
 *
 * @param array<string, string>|null $values Selections; defaults to the request.
 * @return array
 */
function sc_core_product_filter_tax_query( $values = null ) {
	$values = ( null === $values ) ? sc_core_product_filter_values() : $values;
	$facets = sc_core_product_facets();
	$query  = array();
	foreach ( $values as $param => $slug ) {
		if ( ! isset( $facets[ $param ] ) ) {
			continue;
		}
		$query[] = array(
			'taxonomy'         => $facets[ $param ][0],
			'field'            => 'slug',
			'terms'            => array( $slug ),
			'include_children' => true,
		);
	}
	if ( count( $query ) > 1 ) {
		$query['relation'] = 'AND';
	}
	return $query;
}

/**
 * IDs of every published product (small catalogue; cached per request).
 *
 * @return int[]
 */
function sc_core_published_product_ids() {
	static $ids = null;
	if ( null === $ids ) {
		$ids = array_map(
			'intval',
			(array) get_posts(
				array(
					'post_type'      => 'sc_product',
					'post_status'    => 'publish',
					'posts_per_page' => -1,
					'fields'         => 'ids',
					'no_found_rows'  => true,
				)
			)
		);
	}
	return $ids;
}

/**
 * Terms of a facet taxonomy that are attached to at least one published
 * product. hide_empty alone is not enough: sc_brand_tax is shared with
 * Projects, so its count includes projects and would offer brands that
 * have no product to show.
 *
 * @param string $taxonomy Taxonomy name.
 * @return WP_Term[]
 */
function sc_core_product_filter_terms( $taxonomy ) {
	$ids = sc_core_published_product_ids();
	if ( count( $ids ) === 0 ) {
		return array();
	}
	$terms = get_terms(
		array(
			'taxonomy'   => $taxonomy,
			'object_ids' => $ids,
			'hide_empty' => true,
			'orderby'    => 'name',
			'order'      => 'ASC',
		)
	);
	if ( is_wp_error( $terms ) || ! is_array( $terms ) ) {
		return array();
	}
	// object_ids can return one row per object; de-duplicate by term id.
	$unique = array();
	foreach ( $terms as $t ) {
		if ( $t instanceof WP_Term ) {
			$unique[ $t->term_id ] = $t;
		}
	}
	return array_values( $unique );
}

/**
 * Query arguments for the product directory on the Brands archive.
 *
 * @param int $limit Maximum products to list.
 * @return array
 */
function sc_core_product_directory_query_args( $limit = 48 ) {
	$args = array(
		'post_type'      => 'sc_product',
		'post_status'    => 'publish',
		'posts_per_page' => (int) $limit,
		'orderby'        => array(
			'menu_order' => 'ASC',
			'title'      => 'ASC',
		),
	);
	$tax = sc_core_product_filter_tax_query();
	if ( count( $tax ) > 0 ) {
		$args['tax_query'] = $tax; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query -- small catalogue, user-driven filter.
	}
	return $args;
}

/**
 * Apply the facets to any front-end MAIN query for products, so the rules are
 * identical wherever products are listed by WordPress itself.
 *
 * @param WP_Query $q Query.
 */
function sc_core_product_filters_pre_get_posts( $q ) {
	if ( is_admin() || ! $q->is_main_query() || ! sc_core_product_filters_active() ) {
		return;
	}
	if ( ! $q->is_post_type_archive( 'sc_product' ) && ! $q->is_tax( array( 'sc_application', 'sc_product_category' ) ) ) {
		return;
	}
	$existing = $q->get( 'tax_query' );
	$tax      = sc_core_product_filter_tax_query();
	if ( is_array( $existing ) && count( $existing ) > 0 ) {
		$tax = array_merge( array( 'relation' => 'AND' ), array( $existing ), array_filter( $tax, 'is_array' ) );
	}
	$q->set( 'tax_query', $tax );
}
add_action( 'pre_get_posts', 'sc_core_product_filters_pre_get_posts' );
