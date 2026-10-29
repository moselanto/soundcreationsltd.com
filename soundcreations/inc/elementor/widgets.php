<?php
/**
 * Sound Creations widgets for Elementor (free Elementor, no Pro needed).
 *
 * Every homepage section below the hero, the featured event, the enquiry
 * forms and the header/footer building blocks are widgets in a
 * "Sound Creations" panel. Section widgets render the SAME markup as the
 * hand-built templates (inc/sections.php), so the design never forks; their
 * text boxes override the site-wide copy for that one placement only, and an
 * empty box keeps the wording from Sound Creations -> Settings.
 *
 * Deliberately NOT widgets (owner decision 29 Oct 2026):
 *  - the homepage hero (LCP element, preloaded by enqueue.php);
 *  - the enquiry forms themselves. The "Enquiry form" widget only embeds the
 *    hand-coded form from sound-creations-enquiries, with its anti-spam,
 *    routing and PII handling intact.
 *
 * Nothing here touches Elementor until Elementor has loaded, so the site works
 * the same with Elementor switched off.
 *
 * @package SoundCreations
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Editable copy per section widget: section => array( setting key => array( label, type ) ).
 * type: text | textarea | image. Keys are the real Settings keys the section reads.
 *
 * @return array
 */
function sc_el_section_fields() {
	return array(
		'services'     => array(
			'home_whatwedo_eyebrow' => array( __( 'Eyebrow', 'soundcreations' ), 'text' ),
			'home_whatwedo_title'   => array( __( 'Heading', 'soundcreations' ), 'text' ),
			'home_whatwedo_lead'    => array( __( 'Intro', 'soundcreations' ), 'textarea' ),
		),
		'solutions'    => array(
			'home_solutions_eyebrow' => array( __( 'Eyebrow', 'soundcreations' ), 'text' ),
			'home_solutions_title'   => array( __( 'Heading', 'soundcreations' ), 'text' ),
		),
		'partners'     => array(
			'home_partners_label' => array( __( 'Label', 'soundcreations' ), 'text' ),
		),
		'work'         => array(
			'home_projects_eyebrow'    => array( __( 'Eyebrow', 'soundcreations' ), 'text' ),
			'home_projects_title'      => array( __( 'Heading', 'soundcreations' ), 'text' ),
			'home_projects_link_label' => array( __( '"View all" link label', 'soundcreations' ), 'text' ),
		),
		'stats'        => array(
			'home_stat1_num'   => array( __( 'Stat 1: number', 'soundcreations' ), 'text' ),
			'home_stat1_label' => array( __( 'Stat 1: label', 'soundcreations' ), 'text' ),
			'home_stat2_num'   => array( __( 'Stat 2: number', 'soundcreations' ), 'text' ),
			'home_stat2_label' => array( __( 'Stat 2: label', 'soundcreations' ), 'text' ),
			'home_stat2_note'  => array( __( 'Stat 2: sub-note', 'soundcreations' ), 'text' ),
			'home_stat3_num'   => array( __( 'Stat 3: number', 'soundcreations' ), 'text' ),
			'home_stat3_label' => array( __( 'Stat 3: label', 'soundcreations' ), 'text' ),
			'home_stat4_num'   => array( __( 'Stat 4: number', 'soundcreations' ), 'text' ),
			'home_stat4_label' => array( __( 'Stat 4: label', 'soundcreations' ), 'text' ),
		),
		'testimonials' => array(
			'home_testimonials_eyebrow'    => array( __( 'Eyebrow', 'soundcreations' ), 'text' ),
			'home_testimonials_title'      => array( __( 'Heading', 'soundcreations' ), 'text' ),
			'home_testimonials_link_label' => array( __( '"Read all" link label', 'soundcreations' ), 'text' ),
		),
		'cta'          => array(
			'home_cta_title' => array( __( 'Heading', 'soundcreations' ), 'text' ),
			'home_cta_text'  => array( __( 'Text', 'soundcreations' ), 'textarea' ),
			'home_cta_image' => array( __( 'Background photo', 'soundcreations' ), 'image' ),
		),
	);
}

add_action(
	'elementor/elements/categories_registered',
	function ( $elements_manager ) {
		$elements_manager->add_category(
			'soundcreations',
			array(
				'title' => __( 'Sound Creations', 'soundcreations' ),
				'icon'  => 'eicon-headphones',
			)
		);
	}
);

add_action(
	'elementor/widgets/register',
	function ( $widgets_manager ) {
		require_once SC_THEME_DIR . '/inc/elementor/widget-classes.php';
		foreach ( sc_el_widget_class_names() as $class ) {
			if ( class_exists( $class ) ) {
				$widgets_manager->register( new $class() );
			}
		}
	}
);

// Elementor renders section widgets' own CSS classes; nothing extra to load.
// The theme stylesheet already styles .sc-section, .sc-svcards and friends.
