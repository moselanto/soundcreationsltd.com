<?php
/**
 * Header & footer choice inside Elementor's own Page Settings panel
 * (cog icon > Settings > "Header & footer").
 *
 * The value is stored in the same post meta the WordPress-editor box uses
 * (_sc_el_header / _sc_el_footer, see builder.php), so both screens always
 * show and change the same choice.
 *
 * @package SoundCreations
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'elementor/documents/register_controls',
	function ( $document ) {
		if ( ! class_exists( '\Elementor\Controls_Manager' ) || ! method_exists( $document, 'get_main_id' ) ) {
			return;
		}
		// Pages and posts only; skip templates (a header template choosing a header makes no sense).
		$post_type = get_post_type( $document->get_main_id() );
		if ( 'elementor_library' === $post_type ) {
			return;
		}
		$choices = array(
			''      => __( 'Use the site setting', 'soundcreations' ),
			'theme' => __( 'Built-in (theme)', 'soundcreations' ),
			'none'  => __( 'Hide on this page', 'soundcreations' ),
		) + ( function_exists( 'sc_builder_template_choices' ) ? sc_builder_template_choices() : array() );
		$document->start_controls_section(
			'sc_hf_section',
			array(
				'label' => __( 'Header & footer', 'soundcreations' ),
				'tab'   => \Elementor\Controls_Manager::TAB_SETTINGS,
			)
		);
		foreach ( array( 'header' => __( 'Header', 'soundcreations' ), 'footer' => __( 'Footer', 'soundcreations' ) ) as $k => $label ) {
			$document->add_control(
				'sc_el_' . $k,
				array(
					'label'   => $label,
					'type'    => \Elementor\Controls_Manager::SELECT,
					'options' => $choices,
					'default' => (string) get_post_meta( $document->get_main_id(), '_sc_el_' . $k, true ),
				)
			);
		}
		$document->end_controls_section();
	}
);

// Copy the Elementor page-settings choice into the shared meta on save.
add_action(
	'elementor/document/after_save',
	function ( $document ) {
		if ( ! method_exists( $document, 'get_main_id' ) || ! method_exists( $document, 'get_settings' ) ) {
			return;
		}
		$post_id = (int) $document->get_main_id();
		if ( $post_id <= 0 || ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
		foreach ( array( 'header', 'footer' ) as $k ) {
			$v = sanitize_key( (string) $document->get_settings( 'sc_el_' . $k ) );
			if ( '' === $v || ! ( in_array( $v, array( 'theme', 'none' ), true ) || ctype_digit( $v ) ) ) {
				delete_post_meta( $post_id, '_sc_el_' . $k );
			} else {
				update_post_meta( $post_id, '_sc_el_' . $k, $v );
			}
		}
	}
);
