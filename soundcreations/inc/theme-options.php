<?php
/**
 * Sound Creations Theme Options (Redux Framework, with a built-in fallback).
 *
 * Same pattern as smilecommunitycentre.org: one options screen for the look
 * of the whole theme. Business details and page copy stay in Core
 * (Sound Creations -> Settings); this screen holds presentation only:
 * Elementor header/footer, archive layout pages, brand colours, logos and
 * custom CSS.
 *
 *  - With the free Redux Framework plugin active, the options appear under
 *    Appearance > Theme Options with Redux's full interface.
 *  - Without Redux, a simple built-in screen at the same place edits the same
 *    values, so the site never depends on Redux to display correctly.
 *
 * Every value lives in one option, `sc_theme_options`. Empty values mean
 * "theme default", so a blank screen changes nothing on the live site.
 *
 * @package SoundCreations
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'SC_THEME_OPT', 'sc_theme_options' );

/**
 * Brand colours that can be changed, mapped to the CSS variables in tokens.css.
 *
 * @return array id => array( css variable, default, label )
 */
function sc_theme_opt_colours() {
	return array(
		'color_purple' => array( '--sc-purple', '#624489', __( 'Brand purple (structure, eyebrows, utility band)', 'soundcreations' ) ),
		'color_red'    => array( '--sc-red', '#BA0B0B', __( 'Brand red (buttons and calls to action)', 'soundcreations' ) ),
	);
}

/**
 * Read one theme option. Understands Redux's media arrays.
 *
 * @param string $key     Option key.
 * @param mixed  $default Fallback.
 * @return mixed
 */
function sc_theme_opt( $key, $default = '' ) {
	static $sc_o = null;
	if ( null === $sc_o ) {
		$sc_o = get_option( SC_THEME_OPT, array() );
		if ( ! is_array( $sc_o ) ) {
			$sc_o = array();
		}
	}
	if ( ! isset( $sc_o[ $key ] ) ) {
		return $default;
	}
	$sc_v = $sc_o[ $key ];
	if ( is_array( $sc_v ) ) {
		$sc_v = isset( $sc_v['url'] ) ? $sc_v['url'] : '';
	}
	return ( '' === $sc_v || null === $sc_v ) ? $default : $sc_v;
}

/**
 * Logo URL for the dark or light theme: Theme Options upload, else bundled file.
 *
 * @param string $which dark|light.
 * @return string
 */
function sc_logo_url( $which = 'dark' ) {
	if ( 'light' === $which ) {
		return (string) sc_theme_opt( 'logo_light', SC_THEME_URI . '/assets/img/logo-color.webp' );
	}
	return (string) sc_theme_opt( 'logo_dark', SC_THEME_URI . '/assets/img/logo-white.webp' );
}

/**
 * Pages offered as archive layouts (any page, including private ones).
 *
 * @return array id => title
 */
function sc_theme_opt_page_choices() {
	$sc_out = array( '' => __( 'None (built-in layout)', 'soundcreations' ) );
	foreach ( get_pages( array( 'post_status' => array( 'publish', 'private' ), 'sort_column' => 'post_title' ) ) as $sc_p ) {
		$sc_out[ (string) $sc_p->ID ] = $sc_p->post_title . ( 'private' === $sc_p->post_status ? ' (' . __( 'private', 'soundcreations' ) . ')' : '' );
	}
	return $sc_out;
}

/**
 * Header/footer template choices for the options screens.
 *
 * @return array
 */
function sc_theme_opt_template_choices() {
	$sc_out = array( '' => __( 'Built-in (theme)', 'soundcreations' ) );
	if ( function_exists( 'sc_builder_template_choices' ) ) {
		$sc_out += sc_builder_template_choices();
	}
	return $sc_out;
}

/* -------------------------------------------------------------------------
 * Front end: colours and custom CSS
 * ---------------------------------------------------------------------- */

add_action(
	'wp_head',
	function () {
		$sc_css = '';
		foreach ( sc_theme_opt_colours() as $sc_id => $sc_def ) {
			$sc_hex = sanitize_hex_color( (string) sc_theme_opt( $sc_id, '' ) );
			if ( $sc_hex && strtolower( $sc_hex ) !== strtolower( $sc_def[1] ) ) {
				$sc_css .= $sc_def[0] . ':' . $sc_hex . ';';
			}
		}
		if ( '' !== $sc_css ) {
			$sc_css = ':root{' . $sc_css . '}';
		}
		// Custom CSS is staff-entered (manage_options only). Tags are stripped so
		// it can never close the <style> element.
		$sc_css .= wp_strip_all_tags( (string) sc_theme_opt( 'custom_css', '' ) );
		if ( '' !== trim( $sc_css ) ) {
			echo '<style id="sc-theme-options">' . $sc_css . '</style>' . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- sanitised hex values and tag-stripped admin CSS.
		}
	},
	99
);

/* -------------------------------------------------------------------------
 * Redux (when installed)
 * ---------------------------------------------------------------------- */

add_action(
	'after_setup_theme',
	function () {
		if ( ! class_exists( 'Redux' ) ) {
			return;
		}
		Redux::set_args(
			SC_THEME_OPT,
			array(
				'opt_name'        => SC_THEME_OPT,
				'display_name'    => __( 'Sound Creations Theme Options', 'soundcreations' ),
				'menu_type'       => 'submenu',
				'page_parent'     => 'themes.php',
				'menu_title'      => __( 'Theme Options', 'soundcreations' ),
				'page_slug'       => 'sc-theme-options',
				'page_permissions' => 'manage_options',
				'admin_bar'       => false,
				'dev_mode'        => false,
				'show_import_export' => true,
				'database'        => '',
			)
		);
		Redux::set_section(
			SC_THEME_OPT,
			array(
				'title'  => __( 'Header & footer', 'soundcreations' ),
				'id'     => 'sc-hf',
				'icon'   => 'el el-website',
				'fields' => array(
					array( 'id' => 'header_template', 'type' => 'select', 'title' => __( 'Site-wide header', 'soundcreations' ), 'subtitle' => __( 'An Elementor template (Templates > Saved Templates). Pages can override it.', 'soundcreations' ), 'options' => sc_theme_opt_template_choices(), 'default' => '' ),
					array( 'id' => 'footer_template', 'type' => 'select', 'title' => __( 'Site-wide footer', 'soundcreations' ), 'options' => sc_theme_opt_template_choices(), 'default' => '' ),
				),
			)
		);
		Redux::set_section(
			SC_THEME_OPT,
			array(
				'title'  => __( 'Archive layouts', 'soundcreations' ),
				'id'     => 'sc-layouts',
				'icon'   => 'el el-th-large',
				'desc'   => __( 'Solutions, Projects and Videos are listing pages that Elementor cannot edit directly. Pick a page built in Elementor to use as each one\'s layout. None = the built-in layout.', 'soundcreations' ),
				'fields' => array(
					array( 'id' => 'layout_solutions', 'type' => 'select', 'title' => __( 'Solutions page layout', 'soundcreations' ), 'options' => sc_theme_opt_page_choices(), 'default' => '' ),
					array( 'id' => 'layout_projects', 'type' => 'select', 'title' => __( 'Projects page layout', 'soundcreations' ), 'options' => sc_theme_opt_page_choices(), 'default' => '' ),
					array( 'id' => 'layout_videos', 'type' => 'select', 'title' => __( 'Videos page layout', 'soundcreations' ), 'options' => sc_theme_opt_page_choices(), 'default' => '' ),
				),
			)
		);
		$sc_colour_fields = array();
		foreach ( sc_theme_opt_colours() as $sc_id => $sc_def ) {
			$sc_colour_fields[] = array( 'id' => $sc_id, 'type' => 'color', 'title' => $sc_def[2], 'default' => $sc_def[1], 'transparent' => false, 'validate' => 'color' );
		}
		Redux::set_section( SC_THEME_OPT, array( 'title' => __( 'Colours', 'soundcreations' ), 'id' => 'sc-colours', 'icon' => 'el el-tint', 'fields' => $sc_colour_fields ) );
		Redux::set_section(
			SC_THEME_OPT,
			array(
				'title'  => __( 'Logos', 'soundcreations' ),
				'id'     => 'sc-logos',
				'icon'   => 'el el-picture',
				'fields' => array(
					array( 'id' => 'logo_dark', 'type' => 'media', 'url' => true, 'title' => __( 'Logo for the dark theme (white logo)', 'soundcreations' ) ),
					array( 'id' => 'logo_light', 'type' => 'media', 'url' => true, 'title' => __( 'Logo for the light theme (colour logo)', 'soundcreations' ) ),
				),
			)
		);
		Redux::set_section(
			SC_THEME_OPT,
			array(
				'title'  => __( 'Custom CSS', 'soundcreations' ),
				'id'     => 'sc-css',
				'icon'   => 'el el-css',
				'fields' => array(
					array( 'id' => 'custom_css', 'type' => 'ace_editor', 'mode' => 'css', 'theme' => 'monokai', 'title' => __( 'Extra CSS', 'soundcreations' ) ),
				),
			)
		);
	},
	20
);

/* -------------------------------------------------------------------------
 * Built-in fallback screen (when Redux is not installed)
 * ---------------------------------------------------------------------- */

add_action(
	'admin_menu',
	function () {
		if ( class_exists( 'Redux' ) || class_exists( 'ReduxFramework' ) ) {
			return;
		}
		add_theme_page( __( 'Theme Options', 'soundcreations' ), __( 'Theme Options', 'soundcreations' ), 'manage_options', 'sc-theme-options', 'sc_theme_opt_render_fallback' );
	}
);

add_action(
	'admin_init',
	function () {
		register_setting(
			'sc_theme_opt_group',
			SC_THEME_OPT,
			array(
				'type'              => 'array',
				'sanitize_callback' => 'sc_theme_opt_sanitize',
				'default'           => array(),
			)
		);
	}
);

/**
 * Sanitise the fallback screen's input. Keeps any keys it does not know
 * (for example Redux's own bookkeeping) untouched.
 *
 * @param mixed $in Input.
 * @return array
 */
function sc_theme_opt_sanitize( $in ) {
	$sc_old = get_option( SC_THEME_OPT, array() );
	$sc_old = is_array( $sc_old ) ? $sc_old : array();
	$in     = is_array( $in ) ? $in : array();
	foreach ( array( 'header_template', 'footer_template', 'layout_solutions', 'layout_projects', 'layout_videos' ) as $sc_k ) {
		if ( isset( $in[ $sc_k ] ) ) {
			$sc_old[ $sc_k ] = ctype_digit( (string) $in[ $sc_k ] ) ? (string) $in[ $sc_k ] : '';
		}
	}
	foreach ( array_keys( sc_theme_opt_colours() ) as $sc_k ) {
		if ( isset( $in[ $sc_k ] ) ) {
			$sc_old[ $sc_k ] = (string) sanitize_hex_color( (string) $in[ $sc_k ] );
		}
	}
	foreach ( array( 'logo_dark', 'logo_light' ) as $sc_k ) {
		if ( isset( $in[ $sc_k ] ) ) {
			$sc_old[ $sc_k ] = esc_url_raw( (string) $in[ $sc_k ] );
		}
	}
	if ( isset( $in['custom_css'] ) ) {
		$sc_old['custom_css'] = wp_strip_all_tags( (string) $in['custom_css'] );
	}
	return $sc_old;
}

/**
 * Fallback screen markup.
 */
function sc_theme_opt_render_fallback() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$sc_select = function ( $key, $label, $choices ) {
		$cur = (string) sc_theme_opt( $key, '' );
		echo '<tr><th scope="row"><label for="sc_to_' . esc_attr( $key ) . '">' . esc_html( $label ) . '</label></th><td><select id="sc_to_' . esc_attr( $key ) . '" name="' . esc_attr( SC_THEME_OPT . '[' . $key . ']' ) . '">';
		foreach ( $choices as $v => $t ) {
			echo '<option value="' . esc_attr( (string) $v ) . '"' . selected( $cur, (string) $v, false ) . '>' . esc_html( $t ) . '</option>';
		}
		echo '</select></td></tr>';
	};
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Sound Creations Theme Options', 'soundcreations' ); ?></h1>
		<p><?php esc_html_e( 'Simple version of the options screen. Install the free Redux Framework plugin for the full interface; your values carry over. Business details and page wording stay under Sound Creations > Settings.', 'soundcreations' ); ?></p>
		<form method="post" action="options.php">
			<?php settings_fields( 'sc_theme_opt_group' ); ?>
			<h2><?php esc_html_e( 'Header & footer', 'soundcreations' ); ?></h2>
			<table class="form-table" role="presentation"><tbody>
				<?php
				$sc_select( 'header_template', __( 'Site-wide header', 'soundcreations' ), sc_theme_opt_template_choices() );
				$sc_select( 'footer_template', __( 'Site-wide footer', 'soundcreations' ), sc_theme_opt_template_choices() );
				?>
			</tbody></table>
			<h2><?php esc_html_e( 'Archive layouts', 'soundcreations' ); ?></h2>
			<table class="form-table" role="presentation"><tbody>
				<?php
				$sc_select( 'layout_solutions', __( 'Solutions page layout', 'soundcreations' ), sc_theme_opt_page_choices() );
				$sc_select( 'layout_projects', __( 'Projects page layout', 'soundcreations' ), sc_theme_opt_page_choices() );
				$sc_select( 'layout_videos', __( 'Videos page layout', 'soundcreations' ), sc_theme_opt_page_choices() );
				?>
			</tbody></table>
			<h2><?php esc_html_e( 'Colours and logos', 'soundcreations' ); ?></h2>
			<table class="form-table" role="presentation"><tbody>
				<?php foreach ( sc_theme_opt_colours() as $sc_id => $sc_def ) : ?>
					<tr><th scope="row"><label for="sc_to_<?php echo esc_attr( $sc_id ); ?>"><?php echo esc_html( $sc_def[2] ); ?></label></th><td><input type="text" id="sc_to_<?php echo esc_attr( $sc_id ); ?>" name="<?php echo esc_attr( SC_THEME_OPT . '[' . $sc_id . ']' ); ?>" value="<?php echo esc_attr( (string) sc_theme_opt( $sc_id, '' ) ); ?>" placeholder="<?php echo esc_attr( $sc_def[1] ); ?>" class="regular-text"></td></tr>
				<?php endforeach; ?>
				<?php foreach ( array( 'logo_dark' => __( 'Logo for the dark theme (URL)', 'soundcreations' ), 'logo_light' => __( 'Logo for the light theme (URL)', 'soundcreations' ) ) as $sc_k => $sc_l ) : ?>
					<tr><th scope="row"><label for="sc_to_<?php echo esc_attr( $sc_k ); ?>"><?php echo esc_html( $sc_l ); ?></label></th><td><input type="url" id="sc_to_<?php echo esc_attr( $sc_k ); ?>" name="<?php echo esc_attr( SC_THEME_OPT . '[' . $sc_k . ']' ); ?>" value="<?php echo esc_attr( (string) sc_theme_opt( $sc_k, '' ) ); ?>" class="large-text"></td></tr>
				<?php endforeach; ?>
			</tbody></table>
			<h2><?php esc_html_e( 'Custom CSS', 'soundcreations' ); ?></h2>
			<textarea name="<?php echo esc_attr( SC_THEME_OPT . '[custom_css]' ); ?>" rows="10" class="large-text code"><?php echo esc_textarea( (string) sc_theme_opt( 'custom_css', '' ) ); ?></textarea>
			<?php submit_button(); ?>
		</form>
	</div>
	<?php
}
