<?php
/**
 * Project archive. Owns the /projects/ URL (sc_project has_archive => projects).
 * Cards are data-driven from published sc_project posts, ordered by menu_order
 * (editable in wp-admin). Category / location / solution filtering and search are
 * client-side (see [data-sc-projfilter] wiring in assets/js/theme.js).
 *
 * @package SoundCreations
 */

if ( defined( 'ABSPATH' ) === false ) {
	exit;
}
get_header();

// An Elementor layout page chosen in Theme Options replaces the built-in
// sections below; without one (or with Elementor off) nothing changes.
if ( ! sc_el_render_layout_page( 'projects' ) ) {
	// Sections live in inc/sections-pages.php (Elementor rebuild, phase 2).
	echo sc_render_page_sections( 'projpage' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped inside each section.
}

get_footer();
