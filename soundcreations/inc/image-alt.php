<?php
/**
 * Fallback alt text for images whose Media Library alt field is empty.
 *
 * An SEO crawl found 45 images without alt text, all on brand and project
 * pages (brand logos, project hero images and gallery photos). Their alt
 * fields are blank in the Media Library. This fills a descriptive alt from the
 * page being viewed, only when the stored alt is empty, so any alt text the
 * team adds in the Media Library always wins.
 *
 * @package SoundCreations
 */

if ( defined( 'ABSPATH' ) === false ) {
	exit;
}

/**
 * @param array        $attr       Image attributes.
 * @param WP_Post|null $attachment Attachment post.
 * @return array
 */
function sc_theme_fallback_image_alt( $attr, $attachment ) {
	static $sc_alt_n = 0;
	if ( is_admin() || is_singular() === false ) {
		return $attr;
	}
	if ( isset( $attr['alt'] ) && '' !== trim( (string) $attr['alt'] ) ) {
		return $attr;
	}
	$sc_title = trim( html_entity_decode( wp_strip_all_tags( (string) get_the_title( get_queried_object_id() ) ), ENT_QUOTES, 'UTF-8' ) );
	if ( '' === $sc_title ) {
		return $attr;
	}
	if ( is_singular( 'sc_brand' ) ) {
		$attr['alt'] = $sc_title . ' logo';
		return $attr;
	}
	++$sc_alt_n;
	if ( is_singular( 'sc_project' ) ) {
		$attr['alt'] = ( 1 === $sc_alt_n ) ? $sc_title . ' project by Sound Creations' : $sc_title . ' installation photo ' . $sc_alt_n;
		return $attr;
	}
	$attr['alt'] = ( 1 === $sc_alt_n ) ? $sc_title : $sc_title . ' image ' . $sc_alt_n;
	return $attr;
}
add_filter( 'wp_get_attachment_image_attributes', 'sc_theme_fallback_image_alt', 20, 2 );
