<?php
/**
 * Contact page. Auto-applies to the page with slug "contact". Uses its own Contact Us layout.
 *
 * @package SoundCreations
 */

if ( defined( 'ABSPATH' ) === false ) {
	exit;
}
get_header();
// Built with Elementor? Show that layout. Otherwise the built-in Contact page.
if ( ! sc_el_page_content() ) {
	get_template_part( 'template-parts/contact-page' );
}
get_footer();
