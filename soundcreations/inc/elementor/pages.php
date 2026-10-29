<?php
/**
 * Elementor-built pages and archive layout pages.
 *
 * Every page template asks sc_el_page_content() first: if the page is built
 * with Elementor (or is open in the Elementor editor) its Elementor layout is
 * shown full width; otherwise the template prints its built-in sections
 * exactly as before. With Elementor off, nothing changes anywhere.
 *
 * Post type archives (Solutions, Projects, Videos) cannot be edited in free
 * Elementor, so each can borrow a private "layout page" chosen in Theme
 * Options (the starter-layout tool creates and links them). No layout page,
 * or Elementor off, means the built-in archive renders.
 *
 * @package SoundCreations
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Is this post built with Elementor, with Elementor active?
 *
 * @param int $post_id Post ID.
 * @return bool
 */
function sc_el_is_built( $post_id ) {
	$post_id = (int) $post_id;
	if ( $post_id <= 0 || ! function_exists( 'sc_builder_ready' ) || ! sc_builder_ready() ) {
		return false;
	}
	return 'builder' === get_post_meta( $post_id, '_elementor_edit_mode', true );
}

/**
 * Is the Elementor editor previewing the current request?
 *
 * @return bool
 */
function sc_el_is_preview() {
	if ( ! function_exists( 'sc_builder_ready' ) || ! sc_builder_ready() ) {
		return false;
	}
	$el = \Elementor\Plugin::$instance;
	return isset( $el->preview ) && method_exists( $el->preview, 'is_preview_mode' ) && $el->preview->is_preview_mode();
}

/**
 * Print the current page's Elementor layout when it has one.
 *
 * Uses the_content() inside the loop on purpose: the Elementor editor needs
 * it to find the editable area, and Elementor enqueues the page's CSS itself.
 *
 * @return bool True when the Elementor layout was printed.
 */
function sc_el_page_content() {
	if ( ! is_singular() ) {
		return false;
	}
	$sc_id = get_queried_object_id();
	if ( ! sc_el_is_built( $sc_id ) && ! sc_el_is_preview() ) {
		return false;
	}
	while ( have_posts() ) {
		the_post();
		echo '<div class="sc-el-page">';
		the_content();
		echo '</div>';
	}
	rewind_posts();
	return true;
}

/**
 * Archive layout pages: archive => page ID, from Theme Options.
 *
 * @param string $archive solutions|projects|videos.
 * @return int 0 when none.
 */
function sc_el_layout_page_id( $archive ) {
	$sc_id = (int) sc_theme_opt( 'layout_' . sanitize_key( $archive ), 0 );
	if ( $sc_id <= 0 || ! in_array( get_post_status( $sc_id ), array( 'publish', 'private' ), true ) ) {
		return 0;
	}
	return $sc_id;
}

/**
 * Print an archive's Elementor layout page in place of its built-in sections.
 *
 * @param string $archive solutions|projects|videos.
 * @return bool True when printed; false means "render the built-in archive".
 */
function sc_el_render_layout_page( $archive ) {
	$sc_id = sc_el_layout_page_id( $archive );
	if ( 0 === $sc_id || ! sc_el_is_built( $sc_id ) ) {
		return false;
	}
	$sc_html = (string) \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $sc_id, true );
	if ( '' === trim( $sc_html ) ) {
		return false;
	}
	echo '<div class="sc-el-page">' . $sc_html . '</div>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor's own rendered output.
	return true;
}

/**
 * Archive layout pages are private on purpose (staff-only, edited in
 * Elementor). Keep them out of search engines even for logged-in previews.
 */
add_filter(
	'wp_robots',
	function ( $robots ) {
		if ( is_page() ) {
			$sc_id = get_queried_object_id();
			foreach ( array( 'solutions', 'projects', 'videos' ) as $sc_a ) {
				if ( $sc_id && sc_el_layout_page_id( $sc_a ) === $sc_id ) {
					$robots['noindex'] = true;
					$robots['nofollow'] = true;
				}
			}
		}
		return $robots;
	}
);
