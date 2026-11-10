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

// FAQs from the page's FAQ box (10 Nov 2026, for the "who is Sound Creations"
// questions in docs/seo/AEO-QUESTIONS.md). Printed outside the Elementor
// check so they show with either layout; seo-faq.php lists this template as
// always showing FAQs, so FAQPage schema appears only with visible questions.
// No FAQs saved = nothing printed, so the page is unchanged until they are added.
if ( function_exists( 'sc_faq_render' ) ) {
	$sc_about_faq = sc_faq_render( get_queried_object_id() );
	if ( '' !== $sc_about_faq ) {
		echo '<section class="sc-section sc-section--tight"><div class="sc-container">' . $sc_about_faq . '</div></section>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped inside sc_faq_render().
	}
}

get_footer();
