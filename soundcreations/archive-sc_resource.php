<?php
/**
 * Resource archive - owns the /resources/ URL (sc_resource CPT).
 *
 * Video-first: any resource with a YouTube URL renders as a click-to-play
 * video card; remaining resources (a download file, or just a permalink)
 * render below as download cards. Everything is data-driven from published
 * sc_resource posts (ordered by menu_order, then newest) and editable in
 * wp-admin. To add a video: Resources > Add New > paste a YouTube link in
 * the "YouTube video URL" field > Publish.
 *
 * @package SoundCreations
 */

if ( defined( 'ABSPATH' ) === false ) {
	exit;
}
get_header();

// An Elementor layout page chosen in Theme Options replaces the built-in
// sections below; without one (or with Elementor off) nothing changes.
if ( ! sc_el_render_layout_page( 'videos' ) ) {
	// Sections live in inc/sections-pages.php (Elementor rebuild, phase 2).
	echo sc_render_page_sections( 'videos' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped inside each section.
}

get_footer();
