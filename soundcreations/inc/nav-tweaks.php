<?php
/**
 * Primary menu adjustments.
 *
 * Applied in code so they hold whether the header renders an assigned
 * WordPress menu (Appearance > Menus) or the built-in fallback menu:
 *  - a "Home" link is always the first item, before Solutions;
 *  - the Rwanda link points to the Rwanda site at soundcreationsltd.rw.
 *
 * @package SoundCreations
 */

if ( defined( 'ABSPATH' ) === false ) {
	exit;
}

/**
 * Canonical address of the Rwanda website.
 *
 * @return string
 */
function sc_theme_rwanda_url() {
	return 'https://soundcreationsltd.rw/';
}

/**
 * Point any old Rwanda menu link at soundcreationsltd.rw.
 *
 * @param array    $items Menu item objects.
 * @param stdClass $args  wp_nav_menu() arguments.
 * @return array
 */
function sc_theme_nav_fix_rwanda( $items, $args ) {
	if ( empty( $args->theme_location ) || 'primary' !== $args->theme_location ) {
		return $items;
	}
	foreach ( $items as $item ) {
		if ( is_int( strpos( (string) $item->url, 'rwanda.soundcreationsltd.com' ) ) ) {
			$item->url = sc_theme_rwanda_url();
		}
	}
	return $items;
}
add_filter( 'wp_nav_menu_objects', 'sc_theme_nav_fix_rwanda', 10, 2 );

/**
 * Put a Home link first in the primary menu unless the menu already has one.
 *
 * @param string   $items Menu items HTML.
 * @param stdClass $args  wp_nav_menu() arguments.
 * @return string
 */
function sc_theme_nav_prepend_home( $items, $args ) {
	if ( empty( $args->theme_location ) || 'primary' !== $args->theme_location ) {
		return $items;
	}
	if ( is_int( strpos( $items, 'menu-item-home' ) ) ) {
		return $items;
	}
	$sc_home = home_url( '/' );
	if ( is_int( strpos( $items, 'href="' . esc_url( $sc_home ) . '"' ) ) ) {
		return $items;
	}
	$sc_cur  = is_front_page() ? ' current-menu-item' : '';
	$sc_aria = is_front_page() ? ' aria-current="page"' : '';
	$sc_li   = '<li class="menu-item menu-item-home' . $sc_cur . '"><a href="' . esc_url( $sc_home ) . '"' . $sc_aria . '>' . esc_html__( 'Home', 'soundcreations' ) . '</a></li>';
	return $sc_li . $items;
}
add_filter( 'wp_nav_menu_items', 'sc_theme_nav_prepend_home', 10, 2 );
