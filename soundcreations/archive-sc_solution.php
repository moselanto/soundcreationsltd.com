<?php
/**
 * Solutions landing page (renders at /solutions/, the sc_solution archive).
 * The Our Solutions and Featured Projects sections mirror the homepage:
 * the same solution cards (shared home_sol*_img settings) and the same
 * live sc_project carousel. The hero is the compact style used on /brands/;
 * hero and CTA band copy remain editable in
 * Sound Creations -> Settings (Solutions page content).
 *
 * @package SoundCreations
 */

if ( defined( 'ABSPATH' ) === false ) {
	exit;
}
get_header();

// An Elementor layout page chosen in Theme Options replaces the built-in
// sections below; without one (or with Elementor off) nothing changes.
if ( ! sc_el_render_layout_page( 'solutions' ) ) {
	// Sections live in inc/sections-pages.php (Elementor rebuild, phase 2).
	echo sc_render_page_sections( 'solpage' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped inside each section.
}

get_footer();
