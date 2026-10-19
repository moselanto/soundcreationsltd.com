<?php
/**
 * Media: generate WebP sub-sizes for new JPEG and PNG uploads.
 *
 * PageSpeed flagged "serve images in next-gen formats" on every page whose
 * images come from the Media Library. WebP is typically 25-35% smaller than
 * the equivalent JPEG at the same visual quality, which matters most on the
 * mobile connections most visitors here use.
 *
 * This lives in Core, not the theme, because it changes what WordPress
 * writes to disk at upload time -- a re-theme must not silently switch it off.
 *
 * What it does and does not do:
 *   - Uses the core image_editor_output_format filter (WordPress 5.8+): the
 *     ORIGINAL file is kept exactly as uploaded; only the generated sub-sizes
 *     (thumbnail, medium, medium_large, large, ...) are written as WebP.
 *     WordPress then serves those sub-sizes through srcset automatically.
 *   - Affects NEW uploads only. Existing images keep their JPEG/PNG sub-sizes
 *     until thumbnails are regenerated (WP-CLI "wp media regenerate", or a
 *     regenerate-thumbnails tool run once and removed).
 *
 * Server requirement: the active image editor (Imagick or GD) must be able to
 * encode WebP. When it cannot, wp_image_editor_supports() returns false and
 * this filter changes nothing, so uploads keep working exactly as before --
 * it can never break an upload on a host without WebP support. Check under
 * Tools -> Site Health -> Info -> Media Handling ("ImageMagick supported file
 * formats" or "GD supported file formats" should list WEBP).
 *
 * Opt out without a code change elsewhere: add_filter( 'sc_core_webp_uploads', '__return_false' ).
 *
 * @package SoundCreationsCore
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Map JPEG and PNG sub-size output to WebP when the server can encode it.
 *
 * @param array $formats Map of source mime type => output mime type.
 * @return array
 */
function sc_core_webp_output_format( $formats ) {
	if ( ! apply_filters( 'sc_core_webp_uploads', true ) ) {
		return $formats;
	}
	static $supported = null;
	if ( null === $supported ) {
		$supported = function_exists( 'wp_image_editor_supports' ) && wp_image_editor_supports( array( 'mime_type' => 'image/webp' ) );
	}
	if ( ! $supported ) {
		return $formats;
	}
	$formats = is_array( $formats ) ? $formats : array();
	$formats['image/jpeg'] = 'image/webp';
	$formats['image/png']  = 'image/webp';
	return $formats;
}
add_filter( 'image_editor_output_format', 'sc_core_webp_output_format' );
