<?php
/**
 * Starter Elementor layouts, applied with one click
 * (Appearance > Starter layouts).
 *
 * Each layout is the page's current design rebuilt from the Sound Creations
 * widgets, so applying one changes nothing visually; it only makes the page
 * editable in Elementor. Rules that keep this safe:
 *  - never overwrites a page that is already built with Elementor;
 *  - copies the page's old editor text to _sc_about_body / _sc_pre_elementor
 *    before switching, so nothing typed into a page is lost;
 *  - Solutions, Projects and Videos are listings, not pages: their layout goes
 *    on a new PRIVATE page that is linked in Theme Options > Archive layouts;
 *  - "Undo" switches a page back to its built-in template (Elementor data is
 *    kept, just not used).
 *
 * @package SoundCreations
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Layout definitions: id => array( label, target, widget list ).
 * target: 'front' (the static front page), 'slug:<path>', or 'archive:<name>'.
 *
 * @return array
 */
function sc_starter_layouts() {
	$w = function ( $page ) {
		$out = array();
		foreach ( sc_section_keys( $page ) as $k ) {
			$out[] = array( 'sc_section_' . $k, array() );
		}
		return $out;
	};
	return array(
		'home'        => array( __( 'Home (sections below the hero)', 'soundcreations' ), 'front', $w( 'home' ) ),
		'about'       => array( __( 'About', 'soundcreations' ), 'slug:about', $w( 'about' ) ),
		'fane'        => array( __( 'FANE Africa', 'soundcreations' ), 'slug:fane', $w( 'fane' ) ),
		'contact'     => array( __( 'Contact', 'soundcreations' ), 'slug:contact', $w( 'contact' ) ),
		'masterclass' => array( __( 'Masterclass', 'soundcreations' ), 'slug:masterclass', array( array( 'sc_event', array( 'sc_h' => 'h1' ) ) ) ),
		'solutions'   => array( __( 'Solutions (listing)', 'soundcreations' ), 'archive:solutions', $w( 'solpage' ) ),
		'projects'    => array( __( 'Projects (listing)', 'soundcreations' ), 'archive:projects', $w( 'projpage' ) ),
		'videos'      => array( __( 'Videos (listing)', 'soundcreations' ), 'archive:videos', $w( 'videos' ) ),
	);
}

/**
 * Elementor data for a list of widgets: one full-width section per widget.
 *
 * @param array $widgets array( array( widgetType, settings ) ).
 * @return array
 */
function sc_starter_elementor_data( $widgets ) {
	$id   = function () {
		return substr( md5( wp_generate_uuid4() ), 0, 7 );
	};
	$data = array();
	foreach ( $widgets as $wd ) {
		$data[] = array(
			'id'       => $id(),
			'elType'   => 'section',
			'settings' => array(
				'layout' => 'full_width',
				'gap'    => 'no',
				'padding' => array( 'unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'isLinked' => true ),
			),
			'elements' => array(
				array(
					'id'       => $id(),
					'elType'   => 'column',
					'settings' => array(
						'_column_size' => 100,
						'padding'      => array( 'unit' => 'px', 'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'isLinked' => true ),
					),
					'elements' => array(
						array(
							'id'         => $id(),
							'elType'     => 'widget',
							'widgetType' => $wd[0],
							'settings'   => (object) $wd[1],
							'elements'   => array(),
						),
					),
				),
			),
		);
	}
	return $data;
}

/**
 * The page a layout applies to (0 when it does not exist yet).
 *
 * @param string $target Target string.
 * @return int
 */
function sc_starter_target_id( $target ) {
	if ( 'front' === $target ) {
		return 'page' === get_option( 'show_on_front' ) ? (int) get_option( 'page_on_front' ) : 0;
	}
	if ( 0 === strpos( $target, 'slug:' ) ) {
		$p = get_page_by_path( substr( $target, 5 ) );
		return $p ? (int) $p->ID : 0;
	}
	if ( 0 === strpos( $target, 'archive:' ) ) {
		return function_exists( 'sc_el_layout_page_id' ) ? sc_el_layout_page_id( substr( $target, 8 ) ) : 0;
	}
	return 0;
}

/**
 * Apply one layout.
 *
 * @param string $key Layout id.
 * @return string Result message.
 */
function sc_starter_apply( $key ) {
	$all = sc_starter_layouts();
	if ( ! isset( $all[ $key ] ) ) {
		return __( 'Unknown layout.', 'soundcreations' );
	}
	if ( ! function_exists( 'sc_builder_ready' ) || ! sc_builder_ready() ) {
		return __( 'Elementor is not active. Activate it first.', 'soundcreations' );
	}
	list( $label, $target, $widgets ) = $all[ $key ];
	$post_id = sc_starter_target_id( $target );

	if ( 0 === strpos( $target, 'archive:' ) && 0 === $post_id ) {
		$post_id = (int) wp_insert_post(
			array(
				/* translators: %s: listing name */
				'post_title'  => sprintf( __( '%s page layout', 'soundcreations' ), $label ),
				'post_name'   => 'layout-' . substr( $target, 8 ),
				'post_status' => 'private',
				'post_type'   => 'page',
			)
		);
		if ( $post_id > 0 ) {
			$opts = get_option( SC_THEME_OPT, array() );
			$opts = is_array( $opts ) ? $opts : array();
			$opts[ 'layout_' . substr( $target, 8 ) ] = (string) $post_id;
			update_option( SC_THEME_OPT, $opts );
		}
	}
	if ( $post_id <= 0 ) {
		return sprintf( /* translators: %s: layout */ __( '%s: the page does not exist yet (for Home, set a static front page under Settings > Reading).', 'soundcreations' ), $label );
	}
	if ( 'builder' === get_post_meta( $post_id, '_elementor_edit_mode', true ) && '' !== (string) get_post_meta( $post_id, '_elementor_data', true ) ) {
		return sprintf( /* translators: %s: layout */ __( '%s is already built with Elementor. Nothing was changed.', 'soundcreations' ), $label );
	}

	// Keep what was typed in the page editor before Elementor takes it over.
	$old = (string) get_post_field( 'post_content', $post_id );
	if ( '' !== trim( $old ) ) {
		update_post_meta( $post_id, '_sc_pre_elementor', wp_slash( $old ) );
		if ( 'slug:about' === $target ) {
			update_post_meta( $post_id, '_sc_about_body', wp_slash( $old ) );
		}
	}

	update_post_meta( $post_id, '_elementor_edit_mode', 'builder' );
	update_post_meta( $post_id, '_elementor_template_type', 'wp-page' );
	if ( defined( 'ELEMENTOR_VERSION' ) ) {
		update_post_meta( $post_id, '_elementor_version', ELEMENTOR_VERSION );
	}
	update_post_meta( $post_id, '_elementor_data', wp_slash( wp_json_encode( sc_starter_elementor_data( $widgets ) ) ) );
	if ( isset( \Elementor\Plugin::$instance->files_manager ) ) {
		\Elementor\Plugin::$instance->files_manager->clear_cache();
	}
	return sprintf( /* translators: %s: layout */ __( '%s: starter layout applied. Open the page and click "Edit with Elementor".', 'soundcreations' ), $label );
}

/**
 * Undo: back to the built-in template. Elementor data is kept, just unused.
 *
 * @param string $key Layout id.
 * @return string
 */
function sc_starter_undo( $key ) {
	$all = sc_starter_layouts();
	if ( ! isset( $all[ $key ] ) ) {
		return __( 'Unknown layout.', 'soundcreations' );
	}
	$post_id = sc_starter_target_id( $all[ $key ][1] );
	if ( $post_id <= 0 ) {
		return __( 'Nothing to undo.', 'soundcreations' );
	}
	delete_post_meta( $post_id, '_elementor_edit_mode' );
	$old = (string) get_post_meta( $post_id, '_sc_pre_elementor', true );
	if ( '' !== $old ) {
		wp_update_post( array( 'ID' => $post_id, 'post_content' => $old ) );
	}
	return sprintf( /* translators: %s: layout */ __( '%s now uses the built-in design again.', 'soundcreations' ), $all[ $key ][0] );
}

add_action(
	'admin_menu',
	function () {
		add_theme_page( __( 'Starter layouts', 'soundcreations' ), __( 'Starter layouts', 'soundcreations' ), 'manage_options', 'sc-starter-layouts', 'sc_starter_render_screen' );
	}
);

/**
 * Admin screen.
 */
function sc_starter_render_screen() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$msg = '';
	if ( isset( $_POST['sc_starter_key'], $_POST['sc_starter_nonce'] ) && wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['sc_starter_nonce'] ) ), 'sc_starter' ) ) {
		$key = sanitize_key( wp_unslash( $_POST['sc_starter_key'] ) );
		$msg = ( isset( $_POST['sc_starter_undo'] ) ) ? sc_starter_undo( $key ) : sc_starter_apply( $key );
	}
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Starter Elementor layouts', 'soundcreations' ); ?></h1>
		<p><?php esc_html_e( 'Each button rebuilds that page from the Sound Creations widgets so it looks the same but can be edited in Elementor. The homepage hero and the enquiry forms stay hand-coded. A page already built with Elementor is never overwritten.', 'soundcreations' ); ?></p>
		<?php if ( '' !== $msg ) : ?>
			<div class="notice notice-info"><p><?php echo esc_html( $msg ); ?></p></div>
		<?php endif; ?>
		<?php if ( ! function_exists( 'sc_builder_ready' ) || ! sc_builder_ready() ) : ?>
			<div class="notice notice-warning"><p><?php esc_html_e( 'Elementor is not active, so layouts cannot be applied yet.', 'soundcreations' ); ?></p></div>
		<?php endif; ?>
		<table class="widefat striped" style="max-width:820px"><thead><tr><th><?php esc_html_e( 'Page', 'soundcreations' ); ?></th><th><?php esc_html_e( 'Status', 'soundcreations' ); ?></th><th></th></tr></thead><tbody>
		<?php
		foreach ( sc_starter_layouts() as $key => $def ) :
			$pid   = sc_starter_target_id( $def[1] );
			$built = $pid > 0 && 'builder' === get_post_meta( $pid, '_elementor_edit_mode', true );
			?>
			<tr>
				<td><strong><?php echo esc_html( $def[0] ); ?></strong></td>
				<td><?php echo $built ? esc_html__( 'Built with Elementor', 'soundcreations' ) : ( $pid > 0 ? esc_html__( 'Built-in design', 'soundcreations' ) : esc_html__( 'No page yet', 'soundcreations' ) ); ?></td>
				<td>
					<form method="post" style="display:inline">
						<?php wp_nonce_field( 'sc_starter', 'sc_starter_nonce' ); ?>
						<input type="hidden" name="sc_starter_key" value="<?php echo esc_attr( $key ); ?>">
						<?php if ( $built ) : ?>
							<a class="button button-primary" href="<?php echo esc_url( admin_url( 'post.php?post=' . $pid . '&action=elementor' ) ); ?>"><?php esc_html_e( 'Edit with Elementor', 'soundcreations' ); ?></a>
							<button class="button" name="sc_starter_undo" value="1" onclick="return confirm('<?php echo esc_js( __( 'Switch this page back to the built-in design?', 'soundcreations' ) ); ?>');"><?php esc_html_e( 'Undo', 'soundcreations' ); ?></button>
						<?php else : ?>
							<button class="button button-primary"><?php esc_html_e( 'Apply starter layout', 'soundcreations' ); ?></button>
						<?php endif; ?>
					</form>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody></table>
	</div>
	<?php
}
