<?php
/**
 * Contact Us page body. Included by page-contact.php.
 *
 * A general "get in touch" page: quick contact methods, a short message form,
 * business hours and the regional offices map. This is intentionally distinct
 * from template-parts/consult-page.php (the detailed project-brief page).
 * Renders its own enquiry form via shortcode, so it never calls the_content()
 * (which would auto-append a second form on the mapped slug).
 *
 * @package SoundCreations
 */

if ( defined( 'ABSPATH' ) === false ) {
	exit;
}

// Sections live in inc/sections-pages.php (Elementor rebuild, phase 2).
echo sc_render_page_sections( 'contact' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped inside each section.
