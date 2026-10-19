<?php
/**
 * Custom post types.
 *
 * @package SoundCreationsCore
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function sc_core_register_post_types() {
	$types = array(
		'sc_project'       => array( 'Project', 'Projects', 'projects', 'dashicons-portfolio' ),
		'sc_product'       => array( 'Product', 'Products', 'products', 'dashicons-products' ),
		'sc_brand'         => array( 'Brand', 'Brands', 'brands', 'dashicons-awards' ),
		'sc_solution'      => array( 'Solution', 'Solutions', 'solutions', 'dashicons-analytics' ),
		'sc_case_study'    => array( 'Case Study', 'Case Studies', 'case-studies', 'dashicons-media-document' ),
		'sc_resource'      => array( 'Video', 'Videos', 'videos', 'dashicons-format-video' ),
		'sc_fane_resource' => array( 'FANE Resource', 'FANE Resources', 'fane-resources', 'dashicons-format-audio' ),
	);

	foreach ( $types as $slug => $data ) {
		list( $single, $plural, $rewrite, $icon ) = $data;
		register_post_type(
			$slug,
			array(
				'labels'       => array(
					'name'          => $plural,
					'singular_name' => $single,
					'add_new_item'  => 'Add New ' . $single,
					'edit_item'     => 'Edit ' . $single,
					'menu_name'     => $plural,
				),
				'public'       => true,
				'has_archive'  => true,
				'menu_icon'    => $icon,
				'rewrite'      => array( 'slug' => $rewrite, 'with_front' => false ),
				'show_in_rest' => true,
				'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes' ),
			)
		);
	}

	// Services: content pages for the homepage "What we do" section. Single URLs at
	// /service/{slug}/ (Consultancy, Distribution & Dealership, Integration, After-Sale Services).
	register_post_type(
		'sc_service',
		array(
			'labels'       => array(
				'name'          => 'Services',
				'singular_name' => 'Service',
				'add_new_item'  => 'Add New Service',
				'edit_item'     => 'Edit Service',
				'menu_name'     => 'Services',
			),
			'public'       => true,
			'has_archive'  => false,
			'menu_icon'    => 'dashicons-superhero',
			'rewrite'      => array( 'slug' => 'service', 'with_front' => false ),
			'show_in_rest' => true,
			'supports'     => array( 'title', 'editor', 'thumbnail', 'excerpt', 'custom-fields', 'page-attributes' ),
		)
	);

	// Testimonials: client quotes for the single canonical /testimonials/ page.
	// Deliberately NOT public. A quote has no reason to exist as its own URL --
	// the old site's testimonials-v-1..v-9 pages showed what happens when every
	// variant gets an address: duplicates that compete in search and then rot
	// into 404s. Editors manage quotes here; the theme renders them only on the
	// Testimonials page, and an empty list renders nothing at all (no sample
	// quotes, ever -- an invented testimonial is a trust and legal liability).
	register_post_type(
		'sc_testimonial',
		array(
			'labels'              => array(
				'name'          => 'Testimonials',
				'singular_name' => 'Testimonial',
				'add_new_item'  => 'Add New Testimonial',
				'edit_item'     => 'Edit Testimonial',
				'menu_name'     => 'Testimonials',
				'title_placeholder' => 'Name of the person quoted',
			),
			'public'              => false,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'show_ui'             => true,
			'show_in_rest'        => true,
			'has_archive'         => false,
			'rewrite'             => false,
			'query_var'           => false,
			'menu_icon'           => 'dashicons-format-quote',
			'supports'            => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
		)
	);

	// Enquiries: private storage so no lead is ever lost.
	register_post_type(
		'sc_enquiry',
		array(
			'labels'          => array( 'name' => 'Enquiries', 'singular_name' => 'Enquiry', 'menu_name' => 'Enquiries' ),
			'public'          => false,
			'show_ui'         => true,
			'menu_icon'       => 'dashicons-email-alt',
			'capability_type' => 'post',
			'supports'        => array( 'title', 'custom-fields' ),
		)
	);
}
add_action( 'init', 'sc_core_register_post_types' );

/**
 * The standalone Products archive was retired. The represented-products list now
 * lives on the Brands archive (relabeled "Products"). Redirect the old /products/
 * archive to /brands/ so existing menu links and bookmarks keep working.
 */
function sc_core_redirect_product_archive() {
	if ( is_post_type_archive( 'sc_product' ) ) {
		$dest = get_post_type_archive_link( 'sc_brand' );
		if ( empty( $dest ) ) {
			$dest = home_url( '/brands/' );
		}
		wp_safe_redirect( $dest, 301 );
		exit;
	}
}
add_action( 'template_redirect', 'sc_core_redirect_product_archive' );

/**
 * The Resources archive was rebranded to "Videos" and now lives at /videos/.
 * 301-redirect the old /resources/ archive and single URLs to the matching
 * /videos/ path so existing links and bookmarks keep working.
 */
function sc_core_redirect_resources_to_videos() {
	if ( is_admin() ) {
		return;
	}
	$uri = isset( $_SERVER['REQUEST_URI'] ) ? (string) wp_unslash( $_SERVER['REQUEST_URI'] ) : '';
	if ( '' === $uri ) {
		return;
	}
	if ( preg_match( '#/resources(/|$)#', $uri ) === 1 ) {
		$new = preg_replace( '#/resources(/|$)#', '/videos$1', $uri, 1 );
		if ( is_string( $new ) ) {
			$host = isset( $_SERVER['HTTP_HOST'] ) ? $_SERVER['HTTP_HOST'] : '';
			$dest = ( is_ssl() ? 'https://' : 'http://' ) . $host . $new;
			wp_safe_redirect( $dest, 301 );
			exit;
		}
	}
}
add_action( 'template_redirect', 'sc_core_redirect_resources_to_videos' );

/**
 * Classify a site-relative path as a legacy URL left over from the redesign.
 *
 * Three legacy spaces are still being requested (verified live 19 Oct 2026,
 * all returning a bare 404):
 *   - /sitenew/*     the staging copy used while the redesign was built
 *   - /newwebsite/*  the subdirectory the new site ran from before moving to
 *                    the domain root (see AGENTS.md rule 3)
 *   - /testimonials-v-1/ .. /testimonials-v-N/  versioned drafts of one page
 * The first two strip the prefix and land on the same path at the root, so
 * deep links survive. Every testimonials variant collapses to the single
 * canonical Testimonials page.
 *
 * Shared by the redirect below and the sitemap exclusion in seo.php so the
 * two can never disagree about what counts as legacy.
 *
 * @param string $rel Path relative to the install root, without leading slash.
 * @return string Absolute destination URL, or '' when the path is not legacy.
 */
function sc_core_legacy_destination( $rel ) {
	$rel = ltrim( (string) $rel, '/' );
	if ( 1 === preg_match( '#^(?:sitenew|newwebsite)(?:/(.*))?$#i', $rel, $m ) ) {
		$rest = isset( $m[1] ) ? ltrim( $m[1], '/' ) : '';
		return home_url( '/' . $rest );
	}
	if ( 1 === preg_match( '#^testimonials?-v-?\d+/?$#i', $rel ) ) {
		return sc_core_testimonials_url();
	}
	return '';
}

/**
 * 301 legacy URLs to their modern equivalents.
 *
 * Same template_redirect mechanism as the /products/ and /resources/
 * redirects above. Two deliberate differences:
 *   - It only fires on a 404. If a real page ever exists at one of these
 *     paths, the content wins and nothing is hijacked.
 *   - It runs at priority 9, ahead of redirect_canonical() at 10, whose
 *     "guess the permalink" heuristic would otherwise send /sitenew/about/
 *     to whatever post happens to have a similar slug.
 * The path is computed relative to home_url() so the logic holds wherever
 * WordPress is installed, and wp_safe_redirect() keeps it on-site.
 */
function sc_core_redirect_legacy_paths() {
	if ( is_admin() || ! is_404() ) {
		return;
	}
	$uri  = isset( $_SERVER['REQUEST_URI'] ) ? (string) wp_unslash( $_SERVER['REQUEST_URI'] ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- only pattern-matched; never echoed or stored.
	$path = (string) wp_parse_url( $uri, PHP_URL_PATH );
	$base = trailingslashit( (string) wp_parse_url( home_url( '/' ), PHP_URL_PATH ) );
	if ( '' === $path || 0 !== strpos( $path, $base ) ) {
		return;
	}
	$dest = sc_core_legacy_destination( substr( $path, strlen( $base ) ) );
	if ( '' === $dest ) {
		return;
	}
	$query = (string) wp_parse_url( $uri, PHP_URL_QUERY );
	if ( '' !== $query ) {
		$dest .= ( false === strpos( $dest, '?' ) ? '?' : '&' ) . $query;
	}
	wp_safe_redirect( $dest, 301 );
	exit;
}
add_action( 'template_redirect', 'sc_core_redirect_legacy_paths', 9 );

/**
 * The Brands archive is presented as the "Products" page, so its document <title>
 * should read "Products" rather than the "Brands" post-type label.
 */
function sc_core_products_archive_title( $parts ) {
	if ( is_post_type_archive( 'sc_brand' ) ) {
		$parts['title'] = 'Products';
	}
	return $parts;
}
add_filter( 'document_title_parts', 'sc_core_products_archive_title' );

/**
 * Published testimonials, in the editor's chosen order.
 *
 * Query logic lives here rather than in the template so a re-theme keeps the
 * same ordering rules. Order is the post "Order" field first (so the team can
 * pin the strongest quote to the top), then newest first.
 *
 * @param int $limit Maximum number to return; -1 for all.
 * @return WP_Post[]
 */
function sc_core_testimonials( $limit = -1 ) {
	$posts = get_posts(
		array(
			'post_type'        => 'sc_testimonial',
			'post_status'      => 'publish',
			'posts_per_page'   => (int) $limit,
			'orderby'          => array(
				'menu_order' => 'ASC',
				'date'       => 'DESC',
			),
			'no_found_rows'    => true,
			'suppress_filters' => false,
		)
	);
	return is_array( $posts ) ? $posts : array();
}

/**
 * URL of the one canonical testimonials page.
 *
 * Every legacy testimonials variant redirects here, so it resolves the real
 * page permalink (survives a slug edit or a subdirectory move) and only falls
 * back to the conventional path when the page has not been created yet.
 *
 * @return string
 */
function sc_core_testimonials_url() {
	$page = get_page_by_path( 'testimonials', OBJECT, 'page' );
	if ( $page instanceof WP_Post && 'publish' === $page->post_status ) {
		return (string) get_permalink( $page );
	}
	return home_url( '/testimonials/' );
}
