<?php
/**
 * Event structured data for the featured event (Settings -> Featured event).
 *
 * Emitted on the event's own page only (/masterclass/), and only while the theme says the event is
 * live (sc_event_is_live(): switched on, has a registration link, not yet
 * ended). That keeps the JSON-LD and the visible section in lock-step --
 * Google penalises markup describing content the page does not show.
 *
 * A separate ld+json block rather than a node in seo-graph.php on purpose:
 * the event is temporary, and removing it must never risk the permanent
 * Organization / WebSite graph. No organizer is claimed: the poster does not
 * name one, and we do not invent facts.
 *
 * @package SoundCreationsCore
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Build the Event node, or null when there is nothing valid to describe.
 *
 * @return array|null
 */
function sc_core_event_schema() {
	if ( ! function_exists( 'sc_event_is_live' ) || ! sc_event_is_live() ) {
		return null;
	}
	$start = trim( (string) sc_core_get( 'event_start_date', '' ) );
	$end   = trim( (string) sc_core_get( 'event_end_date', '' ) );
	// startDate is required by Google; without a valid one, emit nothing.
	if ( preg_match( '/^\d{4}-\d{2}-\d{2}$/', $start ) !== 1 ) {
		return null;
	}
	$node = array(
		'@context'            => 'https://schema.org',
		'@type'               => 'EducationEvent',
		'name'                => wp_strip_all_tags( (string) sc_core_get( 'event_title', '' ) ),
		'startDate'           => $start,
		'eventStatus'         => 'https://schema.org/EventScheduled',
		'eventAttendanceMode' => 'https://schema.org/OfflineEventAttendanceMode',
		'url'                 => function_exists( 'sc_event_page_url' ) ? sc_event_page_url() : home_url( '/masterclass/' ),
	);
	if ( preg_match( '/^\d{4}-\d{2}-\d{2}$/', $end ) === 1 ) {
		$node['endDate'] = $end;
	}
	$lead = trim( wp_strip_all_tags( (string) sc_core_get( 'event_lead', '' ) ) );
	if ( '' !== $lead ) {
		$node['description'] = $lead;
	}
	$img = trim( (string) sc_core_get( 'event_poster_img', '' ) );
	if ( '' !== $img ) {
		$node['image'] = array( esc_url_raw( $img ) );
	}
	$venue = trim( (string) sc_core_get( 'event_venue', '' ) );
	$city  = trim( (string) sc_core_get( 'event_city', '' ) );
	if ( '' !== $venue ) {
		$node['location'] = array(
			'@type'   => 'Place',
			'name'    => $venue,
			'address' => array(
				'@type'           => 'PostalAddress',
				'addressLocality' => trim( (string) strtok( $city, ',' ) ),
				'addressCountry'  => 'KE',
			),
		);
	}
	$amount   = trim( (string) sc_core_get( 'event_fee_amount', '' ) );
	$currency = strtoupper( trim( (string) sc_core_get( 'event_fee_currency', '' ) ) );
	$reg_url  = trim( (string) sc_core_get( 'event_url', '' ) );
	if ( is_numeric( $amount ) && preg_match( '/^[A-Z]{3}$/', $currency ) === 1 ) {
		$node['offers'] = array(
			'@type'         => 'Offer',
			'price'         => $amount,
			'priceCurrency' => $currency,
			'availability'  => 'https://schema.org/InStock',
			'url'           => esc_url_raw( $reg_url ),
		);
	}
	if ( function_exists( 'sc_event_mentors' ) ) {
		$people = array();
		foreach ( sc_event_mentors() as $m ) {
			$people[] = array(
				'@type'    => 'Person',
				'name'     => $m['name'],
				'jobTitle' => $m['role'],
			);
		}
		if ( count( $people ) > 0 ) {
			$node['performer'] = $people;
		}
	}
	return $node;
}

add_action(
	'wp_head',
	function () {
		if ( ! sc_core_is_event_page() ) {
			return;
		}
		$node = sc_core_event_schema();
		if ( null === $node ) {
			return;
		}
		echo '<script type="application/ld+json">' . wp_json_encode( $node, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG ) . '</script>' . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- JSON encoded with JSON_HEX_TAG, cannot break out of the script element.
	},
	30
);

/**
 * Whether the current request is the featured event's own page.
 *
 * @return bool
 */
function sc_core_is_event_page() {
	if ( ! is_page() ) {
		return false;
	}
	$path = trim( (string) sc_core_get( 'event_page_path', '/masterclass/' ), '/' );
	if ( '' === $path ) {
		$path = 'masterclass';
	}
	$page = get_queried_object();
	return ( $page instanceof WP_Post ) && get_page_uri( $page ) === $path;
}

/**
 * Create the /masterclass/ page once, so the announcement strip never links
 * to a 404 and nobody has to add the page by hand. Runs on the first admin
 * load after upload. Never overwrites: if a page already sits at that path
 * (published, draft or trashed) it is left exactly as it is. Body is left
 * empty on purpose -- the template renders the event from Settings, and any
 * text typed into the page later appears under it.
 */
add_action(
	'admin_init',
	function () {
		if ( '1' === get_option( 'sc_core_event_page_v1' ) || ! current_user_can( 'manage_options' ) ) {
			return;
		}
		if ( null === get_page_by_path( 'masterclass', OBJECT, 'page' ) ) {
			wp_insert_post(
				array(
					'post_title'   => 'Advancing Audio Masterclass 2027',
					'post_name'    => 'masterclass',
					'post_content' => '',
					'post_status'  => 'publish',
					'post_type'    => 'page',
				)
			);
		}
		update_option( 'sc_core_event_page_v1', '1', false );
	},
	15
);
