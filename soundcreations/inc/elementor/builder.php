<?php
/**
 * Elementor header and footer builder (free Elementor, no Pro needed).
 *
 * Same approach as smilecommunitycentre.org: a header or footer is an ordinary
 * Elementor template (Templates > Saved Templates, type "Section" or
 * "Container"). Appearance -> Theme Options picks the site-wide header and footer; any page can pick its own, use the
 * built-in one, or hide it, in the "Header & footer" box on the edit screen.
 *
 * Safe fallback, always: when nothing is chosen, Elementor is off, or the
 * chosen template is missing, unpublished or renders empty, the theme's
 * hand-built header and footer print exactly as before. A broken template can
 * never leave the site without navigation.
 *
 * @package SoundCreations
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Is Elementor loaded and able to render templates?
 *
 * @return bool
 */
function sc_builder_ready() {
	return did_action( 'elementor/loaded' ) && class_exists( '\Elementor\Plugin' ) && isset( \Elementor\Plugin::$instance->frontend );
}

/**
 * Published Elementor templates usable as a header or footer.
 *
 * @return array id => title
 */
function sc_builder_template_choices() {
	static $cache = null;
	if ( null !== $cache ) {
		return $cache;
	}
	$cache = array();
	if ( ! post_type_exists( 'elementor_library' ) ) {
		return $cache;
	}
	$posts = get_posts(
		array(
			'post_type'        => 'elementor_library',
			'post_status'      => 'publish',
			'posts_per_page'   => 200,
			'orderby'          => 'title',
			'order'            => 'ASC',
			'no_found_rows'    => true,
			'suppress_filters' => true,
			// phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query -- admin screens only, small table.
			'meta_query'       => array(
				array(
					'key'     => '_elementor_template_type',
					'value'   => array( 'section', 'container', 'page', 'header', 'footer' ),
					'compare' => 'IN',
				),
			),
		)
	);
	foreach ( $posts as $p ) {
		$cache[ (string) $p->ID ] = '' !== $p->post_title ? $p->post_title : sprintf( '#%d', $p->ID );
	}
	return $cache;
}

/**
 * Which template (if any) applies to this request.
 *
 * @param string $where header|footer.
 * @return string '' / 'theme' = built-in, 'none' = hide, or a template ID.
 */
function sc_builder_choice( $where ) {
	$where = ( 'footer' === $where ) ? 'footer' : 'header';
	if ( is_singular() ) {
		$own = (string) get_post_meta( get_queried_object_id(), '_sc_el_' . $where, true );
		if ( '' !== $own ) {
			return $own;
		}
	}
	// Site-wide choice: Theme Options (Appearance > Theme Options).
	$site = function_exists( 'sc_theme_opt' ) ? (string) sc_theme_opt( $where . '_template', '' ) : '';
	return $site;
}

/**
 * Print the Elementor header/footer when one applies.
 *
 * @param string $where header|footer.
 * @return bool True when the slot was handled (template printed or hidden),
 *              false when the caller must print the built-in markup.
 */
function sc_builder_render( $where ) {
	$choice = sc_builder_choice( $where );
	if ( 'none' === $choice ) {
		return true;
	}
	if ( '' === $choice || 'theme' === $choice || ! ctype_digit( $choice ) || ! sc_builder_ready() ) {
		return false;
	}
	$id = (int) $choice;
	if ( 'publish' !== get_post_status( $id ) || 'elementor_library' !== get_post_type( $id ) ) {
		return false;
	}
	$html = (string) \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $id, true );
	if ( '' === trim( $html ) ) {
		return false;
	}
	$tag = ( 'footer' === $where ) ? 'footer' : 'header';
	echo '<' . $tag . ' class="sc-el-' . esc_attr( $where ) . '">' . $html . '</' . $tag . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Elementor's own rendered template output.
	return true;
}

/* -------------------------------------------------------------------------
 * Per-page "Header & footer" box (pages and posts).
 * ---------------------------------------------------------------------- */

add_action(
	'add_meta_boxes',
	function () {
		foreach ( array( 'page', 'post', 'sc_solution', 'sc_project', 'sc_service', 'sc_brand' ) as $pt ) {
			add_meta_box( 'sc-el-hf', __( 'Header & footer', 'soundcreations' ), 'sc_builder_meta_box', $pt, 'side', 'low' );
		}
	}
);

/**
 * Meta box markup.
 *
 * @param WP_Post $post Post.
 */
function sc_builder_meta_box( $post ) {
	wp_nonce_field( 'sc_el_hf', 'sc_el_hf_nonce' );
	$choices = array(
		''      => __( 'Use the site setting', 'soundcreations' ),
		'theme' => __( 'Built-in (theme)', 'soundcreations' ),
		'none'  => __( 'Hide on this page', 'soundcreations' ),
	) + sc_builder_template_choices();
	foreach ( array( 'header' => __( 'Header', 'soundcreations' ), 'footer' => __( 'Footer', 'soundcreations' ) ) as $k => $label ) {
		$cur = (string) get_post_meta( $post->ID, '_sc_el_' . $k, true );
		echo '<p><label for="sc_el_' . esc_attr( $k ) . '"><strong>' . esc_html( $label ) . '</strong></label><br>';
		echo '<select id="sc_el_' . esc_attr( $k ) . '" name="sc_el_' . esc_attr( $k ) . '" style="width:100%">';
		foreach ( $choices as $v => $t ) {
			echo '<option value="' . esc_attr( (string) $v ) . '"' . selected( $cur, (string) $v, false ) . '>' . esc_html( $t ) . '</option>';
		}
		echo '</select></p>';
	}
}

add_action(
	'save_post',
	function ( $post_id ) {
		if ( ! isset( $_POST['sc_el_hf_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['sc_el_hf_nonce'] ) ), 'sc_el_hf' ) ) {
			return;
		}
		if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
		foreach ( array( 'header', 'footer' ) as $k ) {
			$v = isset( $_POST[ 'sc_el_' . $k ] ) ? sanitize_key( wp_unslash( $_POST[ 'sc_el_' . $k ] ) ) : '';
			// Only the three keywords or a numeric template ID are accepted.
			if ( '' === $v || ! ( in_array( $v, array( 'theme', 'none' ), true ) || ctype_digit( $v ) ) ) {
				delete_post_meta( $post_id, '_sc_el_' . $k );
			} else {
				update_post_meta( $post_id, '_sc_el_' . $k, $v );
			}
		}
	}
);
