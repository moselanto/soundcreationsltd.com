<?php
/**
 * Responsive card images.
 *
 * PageSpeed Insights (14 Oct 2026) found the homepage downloading 1024x768
 * images for cards displayed at about 266x200, wasting roughly 1.4 MB on
 * desktop. This helper looks up the Media Library attachment behind a card
 * image URL and outputs a srcset/sizes pair so the browser picks a size close
 * to the displayed one. Images that are not in the Media Library (theme
 * assets) are output unchanged.
 *
 * @package SoundCreations
 */

if ( defined( 'ABSPATH' ) === false ) {
	exit;
}

/**
 * Find the attachment ID for an uploads URL, including resized variants
 * such as image-1024x768.webp.
 *
 * @param string $url Image URL.
 * @return int
 */
function sc_theme_attachment_id_from_url( $url ) {
	static $sc_cache = array();
	$url = (string) $url;
	if ( isset( $sc_cache[ $url ] ) ) {
		return $sc_cache[ $url ];
	}
	$sc_id = 0;
	if ( is_int( strpos( $url, '/wp-content/uploads/' ) ) ) {
		$sc_id = (int) attachment_url_to_postid( $url );
		if ( 0 === $sc_id ) {
			$sc_full = preg_replace( '/-\d+x\d+(\.[A-Za-z0-9]+)$/', '$1', $url );
			if ( is_string( $sc_full ) ) {
				$sc_id = (int) attachment_url_to_postid( $sc_full );
			}
		}
	}
	$sc_cache[ $url ] = $sc_id;
	return $sc_id;
}

/**
 * Card <img> tag with srcset/sizes when the image is a Media Library item.
 *
 * @param string $url   Image URL.
 * @param string $alt   Alt text.
 * @param int    $w     Intrinsic width attribute (keeps layout stable).
 * @param int    $h     Intrinsic height attribute.
 * @param string $sizes Value for the sizes attribute.
 * @return string Escaped HTML.
 */
function sc_theme_card_img( $url, $alt, $w, $h, $sizes ) {
	$sc_attrs = ' alt="' . esc_attr( (string) $alt ) . '" loading="lazy" decoding="async" width="' . (int) $w . '" height="' . (int) $h . '"';
	$sc_id    = sc_theme_attachment_id_from_url( $url );
	if ( $sc_id > 0 ) {
		$sc_src = wp_get_attachment_image_url( $sc_id, 'medium_large' );
		$sc_set = wp_get_attachment_image_srcset( $sc_id, 'medium_large' );
		if ( is_string( $sc_src ) && strlen( $sc_src ) > 0 ) {
			$sc_srcset = '';
			if ( is_string( $sc_set ) && strlen( $sc_set ) > 0 ) {
				$sc_srcset = ' srcset="' . esc_attr( $sc_set ) . '" sizes="' . esc_attr( (string) $sizes ) . '"';
			}
			return '<img src="' . esc_url( $sc_src ) . '"' . $sc_srcset . $sc_attrs . '>';
		}
	}
	return '<img src="' . esc_url( (string) $url ) . '"' . $sc_attrs . '>';
}
