<?php
/**
 * FANE brand hub. Auto-applies to the page with slug "fane".
 * Copy is editable in Sound Creations -> Settings where wired via sc_setting().
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
	echo sc_render_page_sections( 'fane' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped inside each section.
}

get_footer();
