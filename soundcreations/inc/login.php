<?php
/**
 * Branded staff sign-in screen (wp-login.php).
 *
 * Split layout: a dark photo panel on the left (logo, headline, what the team
 * can do, help line) and a clean sign-in card on the right. Uses the brand
 * palette from tokens.css (purple for structure, red for the one action) and
 * the self-hosted Inter font, so no external requests. Every wording is
 * translatable. Turn the whole design off with:
 *   add_filter( 'sc_login_design', '__return_false' );
 * Pattern adapted from the Smile Community Centre theme.
 *
 * @package SoundCreations
 */

if ( defined( 'ABSPATH' ) === false ) {
	exit;
}

/**
 * Whether the branded sign-in design is on.
 *
 * @return bool
 */
function sc_login_enabled() {
	return (bool) apply_filters( 'sc_login_design', true );
}

/**
 * Setting with a safe fallback when the Core plugin is not active.
 *
 * @param string $key      Setting key.
 * @param string $fallback Fallback value.
 * @return string
 */
function sc_login_setting( $key, $fallback = '' ) {
	if ( function_exists( 'sc_setting' ) ) {
		$val = (string) sc_setting( $key, $fallback );
		return '' === $val ? $fallback : $val;
	}
	return $fallback;
}

/**
 * Styles, fonts and brand images for the sign-in screen.
 */
function sc_login_assets() {
	if ( sc_login_enabled() === false ) {
		return;
	}
	wp_enqueue_style( 'sc-login-fonts', SC_THEME_URI . '/assets/css/fonts.css', array(), SC_THEME_VERSION );
	wp_enqueue_style( 'sc-login', SC_THEME_URI . '/assets/css/login.css', array( 'login', 'sc-login-fonts' ), SC_THEME_VERSION );
	$photo = SC_THEME_URI . '/assets/img/solutions/install-theatre.jpg';
	$small = SC_THEME_URI . '/assets/img/hero-poster.webp';
	$logo  = SC_THEME_URI . '/assets/img/logo-white.webp';
	wp_add_inline_style(
		'sc-login',
		'body.sc-login{--sc-login-photo:url(' . esc_url( $photo ) . ');--sc-login-logo:url(' . esc_url( $logo ) . ')}'
		. '@media (max-width:959px){body.sc-login{--sc-login-photo:url(' . esc_url( $small ) . ')}}'
	);
}
add_action( 'login_enqueue_scripts', 'sc_login_assets', 20 );

/**
 * Preload the Inter font so the card renders in the brand typeface at once.
 */
function sc_login_preload_font() {
	if ( sc_login_enabled() ) {
		echo '<link rel="preload" href="' . esc_url( SC_THEME_URI . '/assets/fonts/inter-600.woff2' ) . '" as="font" type="font/woff2" crossorigin>' . "\n";
	}
}
add_action( 'login_head', 'sc_login_preload_font', 1 );

/**
 * Body class so every rule is scoped to the branded design.
 *
 * @param array $classes Body classes.
 * @return array
 */
function sc_login_body_class( $classes ) {
	if ( sc_login_enabled() ) {
		$classes[] = 'sc-login';
	}
	return $classes;
}
add_filter( 'login_body_class', 'sc_login_body_class' );

/* Logo in the card links to the site, not wordpress.org. */
add_filter(
	'login_headerurl',
	function ( $url ) {
		return sc_login_enabled() ? home_url( '/' ) : $url;
	}
);
add_filter(
	'login_headertext',
	function ( $text ) {
		return sc_login_enabled() ? get_bloginfo( 'name' ) : $text;
	}
);

/**
 * English-only site: hide the language drop-down under the card.
 *
 * @param bool $show Whether to show it.
 * @return bool
 */
function sc_login_language_dropdown( $show ) {
	return sc_login_enabled() ? false : $show;
}
add_filter( 'login_display_language_dropdown', 'sc_login_language_dropdown' );

/**
 * Small check-mark icon.
 *
 * @return string
 */
function sc_login_tick() {
	return '<svg aria-hidden="true" focusable="false" width="20" height="20" viewBox="0 0 24 24"><circle cx="12" cy="12" r="11" fill="currentColor" opacity=".2"/><path d="M7 12.5l3.2 3.2L17 9" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>';
}

/**
 * Left brand panel, printed before the sign-in box.
 */
function sc_login_aside() {
	if ( sc_login_enabled() === false ) {
		return;
	}
	$phone   = sc_login_setting( 'phone', '+254 715 754 758' );
	$phone_l = sc_login_setting( 'phone_link', preg_replace( '/[^0-9+]/', '', $phone ) );
	$email   = sc_login_setting( 'email', 'info@soundcreationsltd.com' );
	$items   = array(
		__( 'Update pages, solutions, projects and brands', 'soundcreations' ),
		__( 'Reply to enquiries and consultation requests', 'soundcreations' ),
		__( 'Keep products, photos and contact details current', 'soundcreations' ),
	);
	$stats   = array(
		array( __( 'Audio', 'soundcreations' ), __( 'Professional sound', 'soundcreations' ) ),
		array( __( 'Acoustics', 'soundcreations' ), __( 'Design and treatment', 'soundcreations' ) ),
		array( __( 'Integration', 'soundcreations' ), __( 'AV, LED and lighting', 'soundcreations' ) ),
	);
	?>
	<aside class="sc-login-aside" aria-label="<?php esc_attr_e( 'About this website', 'soundcreations' ); ?>">
		<div class="sc-login-aside__wave" aria-hidden="true">
			<?php for ( $i = 0; $i < 28; $i++ ) : ?><span style="--i:<?php echo (int) $i; ?>"></span><?php endfor; ?>
		</div>
		<div class="sc-login-aside__inner">
			<a class="sc-login-aside__brand" href="<?php echo esc_url( home_url( '/' ) ); ?>">
				<img src="<?php echo esc_url( SC_THEME_URI . '/assets/img/logo-white.webp' ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" width="172" height="64">
			</a>
			<div class="sc-login-aside__body">
				<p class="sc-login-aside__eyebrow"><?php esc_html_e( 'Team sign-in', 'soundcreations' ); ?></p>
				<h2 class="sc-login-aside__title"><?php esc_html_e( 'Every great sound starts behind the scenes.', 'soundcreations' ); ?></h2>
				<p class="sc-login-aside__lead"><?php esc_html_e( 'Sign in to manage the Sound Creations website: pro audio, acoustics and system integration across East Africa.', 'soundcreations' ); ?></p>
				<ul class="sc-login-aside__list">
					<?php foreach ( $items as $item ) : ?>
						<li><?php echo sc_login_tick(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- fixed SVG. ?><span><?php echo esc_html( $item ); ?></span></li>
					<?php endforeach; ?>
				</ul>
				<dl class="sc-login-aside__stats">
					<?php foreach ( $stats as $stat ) : ?>
						<div><dt><?php echo esc_html( $stat[0] ); ?></dt><dd><?php echo esc_html( $stat[1] ); ?></dd></div>
					<?php endforeach; ?>
				</dl>
			</div>
			<p class="sc-login-aside__foot">
				<span><?php esc_html_e( 'Need access or locked out?', 'soundcreations' ); ?></span>
				<a href="<?php echo esc_url( 'tel:' . $phone_l ); ?>"><?php echo esc_html( $phone ); ?></a>
				<?php if ( '' !== $email ) : ?>
					<span aria-hidden="true">&middot;</span>
					<a href="<?php echo esc_url( 'mailto:' . $email ); ?>"><?php echo esc_html( $email ); ?></a>
				<?php endif; ?>
			</p>
		</div>
	</aside>
	<main class="sc-login-main" id="sc-login-main">
		<a class="sc-login-back" href="<?php echo esc_url( home_url( '/' ) ); ?>"><span aria-hidden="true">&larr;</span> <?php esc_html_e( 'Back to website', 'soundcreations' ); ?></a>
	<?php
}
add_action( 'login_header', 'sc_login_aside' );

/**
 * Heading above the form, inside the card, per screen.
 *
 * @param string $message Existing login message.
 * @return string
 */
function sc_login_intro( $message ) {
	if ( sc_login_enabled() === false ) {
		return $message;
	}
	$action = isset( $_REQUEST['action'] ) ? sanitize_key( wp_unslash( $_REQUEST['action'] ) ) : 'login'; // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- display only.
	if ( 'lostpassword' === $action || 'retrievepassword' === $action ) {
		$title = __( 'Reset your password', 'soundcreations' );
		$sub   = __( 'Enter your username or email and we will send you a reset link.', 'soundcreations' );
	} elseif ( 'rp' === $action || 'resetpass' === $action ) {
		$title = __( 'Choose a new password', 'soundcreations' );
		$sub   = __( 'Use at least 12 characters. A short sentence is easy to remember.', 'soundcreations' );
	} elseif ( in_array( $action, array( 'validate_2fa', 'backup_2fa', 'revalidate_2fa' ), true ) ) {
		$title = __( 'Two-step verification', 'soundcreations' );
		$sub   = __( 'Type the 6-digit code from your authenticator app. Lost your phone? Use a recovery code.', 'soundcreations' );
	} elseif ( 'login' === $action ) {
		$title = __( 'Welcome back', 'soundcreations' );
		$sub   = __( 'Sign in to manage the Sound Creations website.', 'soundcreations' );
	} else {
		return $message;
	}
	$logo  = '<a class="sc-login-intro__logo" href="' . esc_url( home_url( '/' ) ) . '"><img src="' . esc_url( SC_THEME_URI . '/assets/img/logo-white.webp' ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" width="150" height="56"></a>';
	$badge = '<span class="sc-login-intro__badge" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12h3l2-6 4 12 3-9 2 3h4"/></svg></span>';
	return '<div class="sc-login-intro">' . $logo . $badge . '<h2>' . esc_html( $title ) . '</h2><p>' . esc_html( $sub ) . '</p></div>' . $message;
}
add_filter( 'login_message', 'sc_login_intro', 5 );

/**
 * Trust line and footer, printed after the sign-in box.
 */
function sc_login_footer() {
	if ( sc_login_enabled() === false ) {
		return;
	}
	?>
	<p class="sc-login-trust">
		<svg aria-hidden="true" focusable="false" width="14" height="14" viewBox="0 0 24 24"><rect x="5" y="10" width="14" height="10" rx="2" fill="none" stroke="currentColor" stroke-width="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3" fill="none" stroke="currentColor" stroke-width="2"/></svg>
		<?php esc_html_e( 'Secure connection. Five failed attempts pause sign-in for 15 minutes.', 'soundcreations' ); ?>
	</p>
	<?php
	$help_phone = sc_login_setting( 'phone', '+254 715 754 758' );
	$help_link  = sc_login_setting( 'phone_link', preg_replace( '/[^0-9+]/', '', $help_phone ) );
	?>
	<p class="sc-login-help"><?php esc_html_e( 'Locked out?', 'soundcreations' ); ?> <a href="<?php echo esc_url( 'tel:' . $help_link ); ?>"><?php echo esc_html( $help_phone ); ?></a></p>
	<p class="sc-login-copy">
		&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( sc_login_setting( 'company_name', 'Sound Creations Ltd' ) ); ?>, <?php esc_html_e( 'Nairobi', 'soundcreations' ); ?>
	</p>
	</main>
	<script>
	(function () {
		var pass = document.getElementById( 'user_pass' ) || document.getElementById( 'pass1' );
		var form = document.getElementById( 'loginform' );
		// Caps Lock warning: the most common reason staff get "wrong password".
		if ( pass ) {
			var warn = document.createElement( 'p' );
			warn.className = 'sc-login-caps';
			warn.setAttribute( 'role', 'status' );
			warn.textContent = <?php echo wp_json_encode( __( 'Caps Lock is on', 'soundcreations' ) ); ?>;
			var wrap = pass.closest( '.wp-pwd' ) || pass;
			wrap.parentNode.insertBefore( warn, wrap.nextSibling );
			var check = function ( e ) { if ( e.getModifierState ) { warn.classList.toggle( 'is-on', e.getModifierState( 'CapsLock' ) ); } };
			pass.addEventListener( 'keydown', check );
			pass.addEventListener( 'keyup', check );
			pass.addEventListener( 'blur', function () { warn.classList.remove( 'is-on' ); } );
		}
		// Busy state so the button is not pressed twice.
		if ( form ) {
			var user = document.getElementById( 'user_login' );
			if ( user && ! user.getAttribute( 'placeholder' ) ) { user.setAttribute( 'placeholder', <?php echo wp_json_encode( __( 'Username or email', 'soundcreations' ) ); ?> ); }
			if ( pass && ! pass.getAttribute( 'placeholder' ) ) { pass.setAttribute( 'placeholder', <?php echo wp_json_encode( __( 'Your password', 'soundcreations' ) ); ?> ); }
			form.addEventListener( 'submit', function () {
				var btn = document.getElementById( 'wp-submit' );
				if ( btn ) { btn.classList.add( 'is-busy' ); btn.value = <?php echo wp_json_encode( __( 'Signing in...', 'soundcreations' ) ); ?>; }
			} );
		}
	}() );
	</script>
	<?php
}
add_action( 'login_footer', 'sc_login_footer', 5 );

/**
 * "Log In" reads "Sign in" on the button (front end only, no core change).
 *
 * @param string $translation Translated text.
 * @param string $text        Original text.
 * @param string $domain      Text domain.
 * @return string
 */
function sc_login_gettext( $translation, $text, $domain ) {
	if ( 'default' !== $domain || sc_login_enabled() === false ) {
		return $translation;
	}
	if ( 'Log In' === $text ) {
		return __( 'Sign in', 'soundcreations' );
	}
	if ( 'Remember Me' === $text ) {
		return __( 'Keep me signed in on this device', 'soundcreations' );
	}
	if ( 'Lost your password?' === $text ) {
		return __( 'Forgot your password?', 'soundcreations' );
	}
	return $translation;
}
add_action(
	'login_init',
	function () {
		add_filter( 'gettext', 'sc_login_gettext', 10, 3 );
	}
);
