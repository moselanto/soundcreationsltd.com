<?php
/**
 * Event structured data for the featured event (Settings -> Featured event).
 *
 * Emitted on the homepage only, and only while the theme says the event is
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
		'url'                 => home_url( '/#sc-event' ),
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
		if ( ! is_front_page() ) {
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
