<?php
/**
 * Legacy URL map from the pre-redesign WordPress site.
 *
 * The previous soundcreationsltd.com was a stock WordPress/WooCommerce theme
 * with a blog, a shop and a portfolio. Google indexed those URLs and they were
 * never redirected when the site was rebuilt, so dozens of indexed addresses
 * now answer 404 -- or worse, WordPress guesses a "similar" post and serves the
 * wrong page (/service/ served a video, /sitenew/ a duplicate homepage).
 * docs/seo/LEGACY-REDIRECTS.md is the researched inventory; this file
 * implements its machine-readable map. Owner decision (19 Oct 2026): every old
 * page Google crawled is 301'd to its best new equivalent.
 *
 * Order of play on template_redirect:
 *   0   security.php author-enumeration guard (410)
 *   1   sc_core_legacy_redirects()            <- this file
 *   9   sc_core_redirect_legacy_paths()       (/sitenew/*, /newwebsite/*, testimonials-v-N, 404 only)
 *   10  redirect_canonical()                  (its 404 slug-guess is disabled for mapped paths below)
 *
 * Rules:
 *   - Exact map rows fire even when WordPress resolved something, because the
 *     wrong-content cases above are exactly "WordPress resolved something".
 *   - Pattern rules (catch-alls for paths the doc could not enumerate) fire
 *     only on a 404, so they can never hijack a real page.
 *   - A path that is itself a current destination, or that resolves to a live
 *     Core post or taxonomy term at its own canonical address, is never touched.
 *   - Targets are single hops: none of them redirects again, and /products/
 *     (which 301s to /brands/) is never used as a target.
 *
 * @package SoundCreationsCore
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Value used in the map for "respond 410 Gone" instead of a redirect.
 */
if ( ! defined( 'SC_CORE_LEGACY_GONE' ) ) {
	define( 'SC_CORE_LEGACY_GONE', '410' );
}

/**
 * Exact old => new map, transcribed from LEGACY-REDIRECTS.md section 5.
 *
 * Keys are lowercase paths relative to the install root with no leading or
 * trailing slash (so /our-services and /our-services/ both match). Values are
 * site-relative paths passed to home_url(), or SC_CORE_LEGACY_GONE.
 *
 * Deviation from the doc: /author/moses/ and /author/moses/page/2/ answer 410,
 * not a redirect to /about/. security.php already answers every author archive
 * whose user exists with 410 (username enumeration guard). Redirecting only the
 * author paths whose user does NOT exist would make the response itself reveal
 * which usernames are real, so all author paths get the same 410.
 *
 * Filterable via sc_core_legacy_redirect_map so a row can be corrected (for
 * example, when /projects/pcea-chuka/ is published) without editing this file.
 *
 * @return array<string,string>
 */
function sc_core_legacy_redirect_map() {
	static $map = null;
	if ( null !== $map ) {
		return $map;
	}
	$map = array(
		'our-services'                                                                => '/solutions/',
		'audio-solutions'                                                             => '/solutions/professional-audio/',
		'acoustic-solutions'                                                          => '/solutions/acoustics/',
		'design-and-consulting'                                                       => '/solutions/consultation-design/',
		'shure-microphones'                                                           => '/brands/shure/',
		'audio-products'                                                              => '/brands/',
		'service'                                                                     => '/solutions/',
		'service/intergration'                                                        => '/service/integration/',
		'service/trainings'                                                           => '/solutions/support-training/',
		'the-team'                                                                    => '/about/',
		'video'                                                                       => '/videos/',
		'multimedia'                                                                  => '/projects/',
		'dj'                                                                          => '/brands/',
		'blog-carousel'                                                               => '/projects/',
		'absen-display-products'                                                      => '/solutions/lighting-led-screens/',
		'sitenew'                                                                     => '/',
		'newwebsite'                                                                  => '/',
		'testimonials-v'                                                              => '/testimonials/',
		'acoustics-treatment-at-p-c-e-a-in-chuka-town'                                => '/solutions/church-worship-sound-systems/',
		'all-saints-cathedral-trinity-center-project'                                 => '/projects/all-saints-cathedral/',
		'yu-mwaminifu-concert-by-james-kahero'                                        => '/projects/sarit-expo-centre/',
		'allen-heath-empowers-a-larger-vision'                                        => '/brands/allen-heath/',
		'sound-creations-ltd-audio-visual-integration-at-citam-buruburu'              => '/projects/citam-buruburu/',
		'upgrading-a-church-audio-visual-system'                                      => '/solutions/church-worship-sound-systems/',
		'building-worship-center-for-quality-sound-acoustics'                         => '/solutions/church-worship-sound-systems/',
		'why-your-church-should-buy-a-led-screen-and-how-to-choose-the-right-one'     => '/solutions/lighting-led-screens/',
		'dbtechnologies-new-three-way-line-array'                                     => '/brands/db-technologies/',
		'the-it-professionals-guide-to-great-corporate-sound'                         => '/solutions/professional-audio/',
		'peripheral-vision-appointed-distributor-for-absen-in-sa-for-professional-av' => '/solutions/lighting-led-screens/',
		'parise-joins-chauvet-as-emea-bdm'                                            => '/solutions/lighting-led-screens/',
		'chauvetdj-gigbar-move'                                                       => '/solutions/lighting-led-screens/',
		'kigali-up-2018'                                                              => '/solutions/professional-audio/',
		'korg-will-provide-ikaossilator-for-ios'                                      => '/brands/',
		'dj-angelo-launches-reloop-dj-brand'                                          => '/brands/',
		'many-types-of-construction-equipment-are-designed'                           => SC_CORE_LEGACY_GONE,
		'reasons-to-explan-fast-business-builder'                                     => SC_CORE_LEGACY_GONE,
		'2020'                                                                        => '/projects/',
		'2021'                                                                        => '/projects/',
		'2022'                                                                        => '/projects/',
		'2022/01'                                                                     => '/projects/',
		'2022/03'                                                                     => '/projects/',
		'2022/06'                                                                     => '/projects/',
		'2022/09'                                                                     => '/projects/',
		'2025'                                                                        => '/projects/',
		'author/moses'                                                                => SC_CORE_LEGACY_GONE,
		'author/moses/page/2'                                                         => SC_CORE_LEGACY_GONE,
		'category/multimedia'                                                         => '/projects/',
		'category/projects'                                                           => '/projects/',
		'category/business-strategy'                                                  => '/solutions/',
		'category/video'                                                              => '/videos/',
		'tag/tower'                                                                   => '/projects/',
		'product-category/uncategorized'                                              => '/brands/behringer/',
		'product-category/audio'                                                      => '/brands/',
		'product-category/audio/page/2'                                               => '/brands/',
		'product-category/audio/page/3'                                               => '/brands/',
		'product-category/musical-instruments'                                        => '/brands/',
		'product-category/musical-instruments/page/2'                                 => '/brands/',
		'product-category/musical-instruments/page/3'                                 => '/brands/',
		'product-category/video'                                                      => '/brands/',
		'product-category/axes-picks'                                                 => SC_CORE_LEGACY_GONE,
		'product-category/spirit-levels'                                              => SC_CORE_LEGACY_GONE,
		'product-category/surgery'                                                    => SC_CORE_LEGACY_GONE,
		'product/behringer-u-phoria-umc202hd-usb-audio-interface'                     => '/brands/behringer/',
		'product/behringer-nekkst-k10s-10-inch-powered-studio-subwoofer'              => '/brands/behringer/',
		'product/leem-smp1020u-powered-mixing-console'                                => '/brands/',
		'product/focusrite-scarlett-2i2-3rd-gen-usb-audio-interface'                  => '/brands/',
		'product/m-audio-keystation-49-mk3'                                           => '/brands/',
		'product/ibanez-btb20th5-brl-standard-blue-reef-gradation'                    => '/brands/',
		'product/irig-stream-ultracompact-2x2-audio-interface-for-computers-smartphones-and-tablets' => '/brands/',
		'product/irig-hd-2-guitar-interface-for-ios-mac-and-pc'                       => '/brands/',
	);
	$map = (array) apply_filters( 'sc_core_legacy_redirect_map', $map );
	return $map;
}

/**
 * Old non-pretty query-string links (LEGACY-REDIRECTS.md Appendix A).
 *
 * Only ?service= and ?portfolio= are implemented. ?p= and ?page_id= are left
 * to WordPress on purpose: it resolves those IDs to whatever current post owns
 * them, and second-guessing that could send a live page somewhere else.
 * ?paged=2 is left alone for the same reason.
 *
 * @return array<string,array<string,string>> Query parameter => value => target path.
 */
function sc_core_legacy_query_map() {
	return array(
		'service'   => array(
			'residential-design' => '/solutions/',
			'hospitally-design'  => '/solutions/hospitality-commercial-audio/',
			'office-design'      => '/solutions/system-integration/',
			'commercial-design'  => '/solutions/hospitality-commercial-audio/',
		),
		'portfolio' => array(
			'microphone'                 => '/brands/db-technologies/',
			'apartment-renovation'       => '/brands/shure/',
			'behringer-x32'              => '/brands/allen-heath/',
			'shure-headphones'           => '/brands/shure/',
			'behringer-klark'            => '/brands/',
			'tiange-sound-proof-acoustic' => '/solutions/acoustic-panels-ceilings/',
			'dlp-projector'              => '/solutions/lighting-led-screens/',
			'plm-series'                 => '/brands/',
			'nec-projector'              => '/solutions/lighting-led-screens/',
			'behringer-mixer'            => '/brands/behringer/',
			'mdas'                       => '/brands/midas/',
			'restaurant-in-texas'        => '/brands/db-technologies/',
			'avantis-mixer'              => '/brands/allen-heath/',
			'shure-microphones'          => '/brands/shure/',
			'tama-drumsets'              => '/brands/',
			'vimeo-video'                => '/videos/',
		),
	);
}

/**
 * Normalise a path for map lookups: decoded, lowercase, no outer slashes.
 *
 * @param string $path Path, with or without slashes.
 * @return string
 */
function sc_core_legacy_normalise_path( $path ) {
	return trim( strtolower( rawurldecode( (string) $path ) ), '/' );
}

/**
 * Turn an absolute URL path into a normalised path relative to the install.
 *
 * Computed against home_url() so the map holds wherever WordPress is
 * installed (AGENTS.md rule 3).
 *
 * @param string $path URL path, e.g. /our-services/.
 * @return string|null Relative path ('' for the homepage), or null when the
 *                     path is outside this install.
 */
function sc_core_legacy_relative_path( $path ) {
	$path = (string) $path;
	$base = trailingslashit( (string) wp_parse_url( home_url( '/' ), PHP_URL_PATH ) );
	if ( '' === $path || 0 !== strpos( trailingslashit( $path ), $base ) ) {
		return null;
	}
	return sc_core_legacy_normalise_path( substr( trailingslashit( $path ), strlen( $base ) ) );
}

/**
 * The current request's path relative to the install.
 *
 * @return string|null See sc_core_legacy_relative_path().
 */
function sc_core_legacy_request_path() {
	$uri = isset( $_SERVER['REQUEST_URI'] ) ? (string) wp_unslash( $_SERVER['REQUEST_URI'] ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- only pattern-matched; never echoed or stored.
	return sc_core_legacy_relative_path( (string) wp_parse_url( $uri, PHP_URL_PATH ) );
}

/**
 * Drop a trailing page/N segment: page 2 of an old list goes where page 1 goes.
 *
 * @param string $rel Normalised relative path.
 * @return string
 */
function sc_core_legacy_strip_paging( $rel ) {
	$stripped = preg_replace( '#(?:^|/)page/\d+$#', '', (string) $rel );
	return is_string( $stripped ) ? $stripped : (string) $rel;
}

/**
 * Exact-map destination for a path, trying it as-is and without /page/N/.
 *
 * @param string $rel Normalised relative path.
 * @return string Target path, SC_CORE_LEGACY_GONE, or '' when unmapped.
 */
function sc_core_legacy_exact_target( $rel ) {
	$map = sc_core_legacy_redirect_map();
	if ( isset( $map[ $rel ] ) ) {
		return (string) $map[ $rel ];
	}
	$stripped = sc_core_legacy_strip_paging( $rel );
	if ( $stripped !== $rel && isset( $map[ $stripped ] ) ) {
		return (string) $map[ $stripped ];
	}
	return '';
}

/**
 * Brand page for an old WooCommerce /product/<slug>/ URL.
 *
 * Old product slugs started with the brand name. Only brands that still have
 * a published Brand page get their own target; anything else goes to /brands/
 * so the redirect never lands on a 404. Never /products/: that archive 301s.
 *
 * @param string $slug Old product slug.
 * @return string Target path.
 */
function sc_core_legacy_brand_target( $slug ) {
	$prefixes = array(
		'behringer'       => 'behringer',
		'dbtechnologies'  => 'db-technologies',
		'db-'             => 'db-technologies',
		'shure'           => 'shure',
		'allen-and-heath' => 'allen-heath',
		'allen-heath'     => 'allen-heath',
		'midas'           => 'midas',
		'bose'            => 'bose-professional',
		'sommer'          => 'sommer-cable',
		'fane'            => 'fane',
		'rockfon'         => 'rockfon',
	);
	foreach ( $prefixes as $prefix => $brand ) {
		if ( 0 !== strpos( (string) $slug, $prefix ) ) {
			continue;
		}
		$post = get_page_by_path( $brand, OBJECT, 'sc_brand' );
		if ( $post instanceof WP_Post && 'publish' === $post->post_status ) {
			return '/brands/' . $brand . '/';
		}
		break;
	}
	return '/brands/';
}

/**
 * Pattern-rule destination (LEGACY-REDIRECTS.md "Pattern rules").
 *
 * Only consulted on a 404, so these catch-alls never shadow live content.
 *
 * @param string $rel Normalised relative path.
 * @return string Target path, SC_CORE_LEGACY_GONE, or '' when no rule applies.
 */
function sc_core_legacy_pattern_target( $rel ) {
	$rel = sc_core_legacy_strip_paging( $rel );
	if ( 1 === preg_match( '#^product/([a-z0-9-]+)$#', $rel, $m ) ) {
		return sc_core_legacy_brand_target( $m[1] );
	}
	// Old shop spaces. "product" never matches "products": the current
	// /products/ archive has its own redirect in post-types.php.
	if ( 1 === preg_match( '#^(?:product|product-category|shop|cart|checkout)(?:/|$)#', $rel ) ) {
		return '/brands/';
	}
	if ( 1 === preg_match( '#^\d{4}(?:/\d{2}(?:/\d{2})?)?$#', $rel ) ) {
		return '/projects/';
	}
	if ( 1 === preg_match( '#^(?:category|tag)/#', $rel ) ) {
		return '/projects/';
	}
	// 410, not /about/: see the author note on sc_core_legacy_redirect_map().
	if ( 1 === preg_match( '#^author(?:/|$)#', $rel ) ) {
		return SC_CORE_LEGACY_GONE;
	}
	if ( 1 === preg_match( '#^portfolio(?:/|$)#', $rel ) ) {
		return '/projects/';
	}
	return '';
}

/**
 * Every current destination in the map, as normalised paths.
 *
 * A request for one of these is a live page by definition and is never
 * redirected, whatever else the map says.
 *
 * @return array<string,bool>
 */
function sc_core_legacy_live_targets() {
	$out = array();
	foreach ( sc_core_legacy_redirect_map() as $target ) {
		if ( SC_CORE_LEGACY_GONE !== $target ) {
			$out[ sc_core_legacy_normalise_path( $target ) ] = true;
		}
	}
	return $out;
}

/**
 * Whether the request resolved to live Core content at its own address.
 *
 * Guards the exact map against hijacking a real page: a Core taxonomy term
 * (e.g. a /product-category/<term>/ that the new site actually uses) or a Core
 * post whose permalink is this very path. Old blog posts and pages (post types
 * "post" and "page", such as /sitenew/) are deliberately not protected: they
 * are the legacy content the map exists to retire.
 *
 * @param string $rel Normalised relative path of the request.
 * @return bool
 */
function sc_core_legacy_is_live_core_url( $rel ) {
	if ( is_404() ) {
		return false;
	}
	$obj = get_queried_object();
	if ( $obj instanceof WP_Term ) {
		return 0 === strpos( (string) $obj->taxonomy, 'sc_' );
	}
	if ( $obj instanceof WP_Post && 0 === strpos( (string) $obj->post_type, 'sc_' ) ) {
		$own = sc_core_legacy_relative_path( (string) wp_parse_url( (string) get_permalink( $obj ), PHP_URL_PATH ) );
		return null !== $own && sc_core_legacy_strip_paging( $own ) === sc_core_legacy_strip_paging( $rel );
	}
	return false;
}

/**
 * Answer 410 Gone and let WordPress render the theme's 404 template.
 *
 * set_404() makes the template loader pick 404.php and keeps any matching
 * leftover demo post from rendering; nothing later in the request resets the
 * status. The body is the normal "not found" page, so no PII is involved.
 */
function sc_core_legacy_send_gone() {
	global $wp_query;
	if ( $wp_query instanceof WP_Query ) {
		$wp_query->set_404();
	}
	status_header( 410 );
	nocache_headers();
}

/**
 * Redirect the old ?service= / ?portfolio= homepage links.
 *
 * Only when the request resolved to the front page (or nothing): neither
 * parameter is a query var on the current site, so WordPress ignores it and
 * serves a duplicate homepage. If a future post type claims the parameter,
 * the request resolves elsewhere and this steps aside. The legacy parameter is
 * dropped from the destination, because carrying it over would recreate the
 * old URL under a new path.
 */
function sc_core_legacy_query_redirect() {
	if ( ! ( is_404() || is_front_page() || is_home() ) ) {
		return;
	}
	foreach ( sc_core_legacy_query_map() as $param => $rows ) {
		if ( ! isset( $_GET[ $param ] ) || ! is_string( $_GET[ $param ] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- read-only lookup against a fixed list.
			continue;
		}
		$value = sanitize_title( wp_unslash( $_GET[ $param ] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- read-only lookup against a fixed list.
		if ( isset( $rows[ $value ] ) ) {
			wp_safe_redirect( home_url( $rows[ $value ] ), 301 );
			exit;
		}
	}
}

/**
 * Whether this request should be left alone entirely.
 *
 * template_redirect does not normally fire for these, but the redirect must
 * never touch admin, AJAX, cron, REST, previews or anything but a plain read.
 *
 * @return bool
 */
function sc_core_legacy_skip_request() {
	if ( is_admin() || wp_doing_ajax() || wp_doing_cron() || ( defined( 'REST_REQUEST' ) && REST_REQUEST ) ) {
		return true;
	}
	if ( is_preview() || is_customize_preview() ) {
		return true;
	}
	$method = isset( $_SERVER['REQUEST_METHOD'] ) ? strtoupper( sanitize_key( wp_unslash( $_SERVER['REQUEST_METHOD'] ) ) ) : 'GET';
	return 'GET' !== $method && 'HEAD' !== $method;
}

/**
 * 301 (or 410) legacy URLs. Runs at template_redirect priority 1.
 *
 * Priority 1 puts it ahead of redirect_canonical() at 10, whose 404 slug guess
 * is what served /service/ as a video, and ahead of the 404-only
 * sc_core_redirect_legacy_paths() at 9, which still handles deep
 * /sitenew/*, /newwebsite/* and testimonials-v-N paths. The incoming query
 * string is preserved (campaign tags survive) and wp_safe_redirect() keeps the
 * destination on this host.
 */
function sc_core_legacy_redirects() {
	if ( sc_core_legacy_skip_request() ) {
		return;
	}
	$rel = sc_core_legacy_request_path();
	if ( null === $rel ) {
		return;
	}
	if ( '' === $rel ) {
		sc_core_legacy_query_redirect();
		return;
	}
	$live = sc_core_legacy_live_targets();
	if ( isset( $live[ $rel ] ) || sc_core_legacy_is_live_core_url( $rel ) ) {
		return;
	}
	$target = sc_core_legacy_exact_target( $rel );
	if ( '' === $target && is_404() ) {
		$target = sc_core_legacy_pattern_target( $rel );
	}
	if ( '' === $target ) {
		return;
	}
	if ( SC_CORE_LEGACY_GONE === $target ) {
		sc_core_legacy_send_gone();
		return;
	}
	$dest  = home_url( $target );
	$uri   = isset( $_SERVER['REQUEST_URI'] ) ? (string) wp_unslash( $_SERVER['REQUEST_URI'] ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- query is passed through wp_safe_redirect(), which sanitises it.
	$query = (string) wp_parse_url( $uri, PHP_URL_QUERY );
	if ( '' !== $query ) {
		$dest .= '?' . $query;
	}
	wp_safe_redirect( $dest, 301 );
	exit;
}
add_action( 'template_redirect', 'sc_core_legacy_redirects', 1 );

/**
 * Stop WordPress guessing a "similar" post for any mapped legacy path.
 *
 * redirect_guess_404_permalink() is how /service/ ended up on a video. The
 * redirect above normally exits first; this covers the 410 rows (which fall
 * through to the template) and anything a filter on the map changes.
 *
 * @param bool $do Whether WordPress should guess.
 * @return bool
 */
function sc_core_legacy_disable_guess( $do ) {
	$rel = sc_core_legacy_request_path();
	if ( null === $rel || '' === $rel ) {
		return $do;
	}
	if ( '' !== sc_core_legacy_exact_target( $rel ) || '' !== sc_core_legacy_pattern_target( $rel ) ) {
		return false;
	}
	return $do;
}
add_filter( 'do_redirect_guess_404_permalink', 'sc_core_legacy_disable_guess' );

/**
 * IDs of published posts and pages whose own address is a mapped legacy path.
 *
 * Old blog posts and the /sitenew/ page may still exist in the database. A
 * sitemap that lists a URL which then 301s is a contradictory signal, so they
 * are dropped from whichever sitemap is live (same approach as
 * sc_seo_legacy_page_ids() in seo.php).
 *
 * @return int[]
 */
function sc_core_legacy_mapped_post_ids() {
	static $ids = null;
	if ( null !== $ids ) {
		return $ids;
	}
	$ids   = array();
	$posts = get_posts(
		array(
			'post_type'      => array( 'post', 'page' ),
			'post_status'    => 'publish',
			'posts_per_page' => -1,
			'fields'         => 'ids',
			'no_found_rows'  => true,
		)
	);
	foreach ( (array) $posts as $pid ) {
		$rel = sc_core_legacy_relative_path( (string) wp_parse_url( (string) get_permalink( $pid ), PHP_URL_PATH ) );
		if ( null !== $rel && '' !== $rel && '' !== sc_core_legacy_exact_target( $rel ) ) {
			$ids[] = (int) $pid;
		}
	}
	return $ids;
}

add_filter(
	'wp_sitemaps_posts_query_args',
	function ( $args, $post_type ) {
		if ( 'post' !== $post_type && 'page' !== $post_type ) {
			return $args;
		}
		$ids = sc_core_legacy_mapped_post_ids();
		if ( count( $ids ) > 0 ) {
			$existing             = isset( $args['post__not_in'] ) ? (array) $args['post__not_in'] : array();
			$args['post__not_in'] = array_values( array_unique( array_merge( $existing, $ids ) ) );
		}
		return $args;
	},
	10,
	2
);

add_filter(
	'rank_math/sitemap/entry',
	function ( $url, $type, $obj ) {
		if ( 'post' === $type && $obj instanceof WP_Post && in_array( (int) $obj->ID, sc_core_legacy_mapped_post_ids(), true ) ) {
			return false;
		}
		return $url;
	},
	10,
	3
);
