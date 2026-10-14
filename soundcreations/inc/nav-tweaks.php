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
 * Trim the primary menu to what clients should see:
 *  - Products (/brands/) and About Us (/about/) are single links, no dropdown;
 *  - the Conferencing solution is never listed (the page itself stays in
 *    wp-admin and is hidden from the public separately).
 *
 * @param array    $items Menu item objects.
 * @param stdClass $args  wp_nav_menu() arguments.
 * @return array
 */
function sc_theme_nav_trim( $items, $args ) {
	if ( empty( $args->theme_location ) || 'primary' !== $args->theme_location ) {
		return $items;
	}
	$sc_flat         = array( '/brands/', '/about/' );
	$sc_flat_parents = array();
	foreach ( $items as $item ) {
		if ( 0 === (int) $item->menu_item_parent ) {
			$sc_path = trailingslashit( (string) wp_parse_url( (string) $item->url, PHP_URL_PATH ) );
			if ( in_array( $sc_path, $sc_flat, true ) ) {
				$sc_flat_parents[] = (int) $item->ID;
			}
		}
	}
	$sc_keep = array();
	foreach ( $items as $item ) {
		$sc_path = trailingslashit( (string) wp_parse_url( (string) $item->url, PHP_URL_PATH ) );
		if ( '/solutions/conferencing/' === $sc_path ) {
			continue;
		}
		if ( in_array( (int) $item->menu_item_parent, $sc_flat_parents, true ) ) {
			continue;
		}
		if ( in_array( (int) $item->ID, $sc_flat_parents, true ) && is_array( $item->classes ) ) {
			$item->classes = array_values( array_diff( $item->classes, array( 'menu-item-has-children' ) ) );
		}
		$sc_keep[] = $item;
	}
	return $sc_keep;
}
add_filter( 'wp_nav_menu_objects', 'sc_theme_nav_trim', 11, 2 );

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
