<?php
/**
 * About page. Auto-applies to the page with slug "about".
 *
 * Simplified layout: a single About + history block with a photo,
 * followed by What We Do, Our Brands, and downloadable Company Profiles.
 * All copy and the photo are editable in Sound Creations -> Settings.
 *
 * @package SoundCreations
 */

if ( defined( 'ABSPATH' ) === false ) {
	exit;
}
get_header();

// Built with Elementor? Show that layout. Otherwise the built-in sections.
if ( ! sc_el_page_content() ) {
	// Sections live in inc/sections-pages.php (Elementor rebuild, phase 2).
	echo sc_render_page_sections( 'about' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped inside each section.
}

get_footer();
