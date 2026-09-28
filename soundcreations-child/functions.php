<?php
/**
 * Sound Creations Child theme functions.
 *
 * @package SoundCreationsChild
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'wp_enqueue_scripts',
	function () {
		// Parent stylesheets (sc-tokens, sc-main) are already enqueued by the parent theme.
		wp_enqueue_style(
			'soundcreations-child',
			get_stylesheet_directory_uri() . '/style.css',
			array( 'sc-main' ),
			wp_get_theme()->get( 'Version' )
		);
	},
	30
);

/* ============================================================
   zlib output compression / output buffer collision.

   Symptom: "Failed to send buffer of zlib output compression (1) in
   wp-includes/functions.php on line 5581", rendered at the top of wp-login
   and wp-admin.

   Cause: PHP is running with zlib.output_compression = On, so PHP owns a
   compression buffer. WordPress separately flushes every open output buffer
   from wp_ob_end_flush_all() on the 'shutdown' hook, and the two collide.
   It is a warning, not a fatal error -- the page still renders.

   THE REAL FIX IS A SERVER SETTING, NOT THIS CODE. Set

       zlib.output_compression = Off

   in the host's PHP configuration (cPanel: MultiPHP INI Editor, or a
   .user.ini in the web root) and serve gzip from Apache mod_deflate instead.
   Once that is done this block becomes a no-op and can be deleted.

   Until then: replace WordPress's unconditional flush with one that
   suppresses the warning, and only when zlib compression is actually on, so
   this does nothing on a correctly configured server.
   ============================================================ */
add_action(
	'init',
	function () {
		if ( ! ini_get( 'zlib.output_compression' ) ) {
			return;
		}

		remove_action( 'shutdown', 'wp_ob_end_flush_all', 1 );

		add_action(
			'shutdown',
			function () {
				while ( ob_get_level() > 0 ) {
					@ob_end_flush();
				}
			},
			1
		);
	}
);
