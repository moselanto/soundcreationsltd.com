<?php
/**
 * WhatsApp chat card.
 *
 * Replaces the plain floating "Chat with us" link with a small branded chat
 * card: company avatar, online/offline status from the Nairobi opening hours,
 * a welcome message, quick enquiry topics and a message box that opens
 * WhatsApp with the visitor's message ready to send. No third-party scripts.
 * Pattern adapted from the Smile Community Centre theme.
 *
 * Phones (v0.11.0): a round WhatsApp button floats on the right above the
 * bottom navigation and the card opens as a bottom sheet with a dimmed
 * backdrop, matching the Smile Community Centre site.
 *
 * Without JavaScript the floating button is still a working wa.me link.
 *
 * @package SoundCreations
 */

if ( defined( 'ABSPATH' ) === false ) {
	exit;
}

/**
 * Opening hours as minutes from midnight per weekday, for the online status.
 * Read from the same Central Settings strings the site and the structured
 * data already use, via the Core plugin's parser when it is active.
 *
 * @return array<string, array{0:int,1:int}> e.g. array( 'Mon' => array( 540, 1050 ) ).
 */
function sc_theme_wa_hours() {
	$sc_days = array(
		'Monday'    => 'Mon',
		'Tuesday'   => 'Tue',
		'Wednesday' => 'Wed',
		'Thursday'  => 'Thu',
		'Friday'    => 'Fri',
		'Saturday'  => 'Sat',
		'Sunday'    => 'Sun',
	);
	$sc_out  = array();
	if ( function_exists( 'sc_seo_hours_spec' ) ) {
		foreach ( (array) sc_seo_hours_spec() as $sc_spec ) {
			if ( isset( $sc_spec['opens'], $sc_spec['closes'], $sc_spec['dayOfWeek'] ) === false ) {
				continue;
			}
			$sc_o = explode( ':', (string) $sc_spec['opens'] );
			$sc_c = explode( ':', (string) $sc_spec['closes'] );
			$sc_om = (int) $sc_o[0] * 60 + ( isset( $sc_o[1] ) ? (int) $sc_o[1] : 0 );
			$sc_cm = (int) $sc_c[0] * 60 + ( isset( $sc_c[1] ) ? (int) $sc_c[1] : 0 );
			foreach ( (array) $sc_spec['dayOfWeek'] as $sc_day ) {
				if ( isset( $sc_days[ $sc_day ] ) ) {
					$sc_out[ $sc_days[ $sc_day ] ] = array( $sc_om, $sc_cm );
				}
			}
		}
	}
	if ( count( $sc_out ) === 0 ) {
		// Fallback: Mon-Fri 9:00-17:30, Sat 9:00-13:30 (confirmed business hours).
		foreach ( array( 'Mon', 'Tue', 'Wed', 'Thu', 'Fri' ) as $sc_d ) {
			$sc_out[ $sc_d ] = array( 540, 1050 );
		}
		$sc_out['Sat'] = array( 540, 810 );
	}
	return $sc_out;
}

/**
 * Print the chat widget in the footer.
 */
function sc_theme_whatsapp_chat() {
	if ( is_admin() || function_exists( 'sc_whatsapp_url' ) === false ) {
		return;
	}
	$sc_base = (string) sc_whatsapp_url();
	$sc_num  = preg_replace( '/\D/', '', $sc_base );
	if ( '' === (string) $sc_num ) {
		return;
	}
	$sc_greet  = (string) sc_setting( 'whatsapp_prefill', 'Hello Sound Creations, I would like to enquire about your services.' );
	$sc_nojs   = 'https://wa.me/' . $sc_num . '?text=' . rawurlencode( $sc_greet );
	$sc_avatar = SC_THEME_URI . '/assets/img/logo-white.webp';
	$sc_topics = array(
		__( 'I would like a quote for equipment', 'soundcreations' ),
		__( 'Sound system design and installation', 'soundcreations' ),
		__( 'Acoustic treatment or soundproofing', 'soundcreations' ),
		__( 'LED screens and stage lighting', 'soundcreations' ),
		__( 'I would like to book a site visit', 'soundcreations' ),
		__( 'Support for an existing system', 'soundcreations' ),
	);
	$sc_icon = '<svg viewBox="0 0 32 32" aria-hidden="true" focusable="false"><path fill="currentColor" d="M16 3.2A12.8 12.8 0 0 0 5 22.5L3.2 28.8l6.5-1.7A12.8 12.8 0 1 0 16 3.2zm0 23.3c-2 0-3.9-.5-5.5-1.5l-.4-.2-3.9 1 1-3.8-.2-.4A10.5 10.5 0 1 1 16 26.5zm5.8-7.9c-.3-.2-1.9-.9-2.2-1-.3-.1-.5-.2-.7.2l-1 1.2c-.2.2-.4.2-.7.1-.3-.2-1.4-.5-2.6-1.6-1-.9-1.6-1.9-1.8-2.2-.2-.3 0-.5.1-.7l.5-.6.3-.5c.1-.2 0-.4 0-.6l-1-2.4c-.3-.6-.5-.5-.7-.5h-.6c-.2 0-.6.1-.9.4-.3.3-1.2 1.1-1.2 2.8s1.2 3.2 1.4 3.5c.2.2 2.4 3.6 5.7 5 .8.4 1.4.6 1.9.7.8.2 1.5.2 2.1.1.6-.1 1.9-.8 2.2-1.5.3-.7.3-1.4.2-1.5-.1-.2-.3-.3-.6-.4z"/></svg>';
	?>
	<div class="sc-wa" data-sc-wa data-number="<?php echo esc_attr( $sc_num ); ?>" data-hours="<?php echo esc_attr( wp_json_encode( sc_theme_wa_hours() ) ); ?>" data-open-text="<?php esc_attr_e( 'Online now, usually replies within minutes', 'soundcreations' ); ?>" data-closed-text="<?php esc_attr_e( 'Leave a message, we reply when the office opens', 'soundcreations' ); ?>">
		<div class="sc-wa__teaser" hidden>
			<button type="button" class="sc-wa__teaser-close" aria-label="<?php esc_attr_e( 'Dismiss', 'soundcreations' ); ?>">&times;</button>
			<p><strong><?php esc_html_e( 'Planning a project?', 'soundcreations' ); ?></strong> <?php esc_html_e( 'Chat with our team on WhatsApp for advice, availability and quotes.', 'soundcreations' ); ?></p>
		</div>
		<div class="sc-wa__scrim" hidden></div>
		<section class="sc-wa__panel" id="sc-wa-panel" role="dialog" aria-modal="false" aria-labelledby="sc-wa-title" hidden>
			<header class="sc-wa__head">
				<span class="sc-wa__avatar"><img src="<?php echo esc_url( $sc_avatar ); ?>" alt="" width="44" height="44" loading="lazy" decoding="async"><i class="sc-wa__presence" aria-hidden="true"></i></span>
				<span class="sc-wa__who">
					<strong id="sc-wa-title"><?php esc_html_e( 'Sound Creations Ltd', 'soundcreations' ); ?></strong>
					<span class="sc-wa__status"><?php esc_html_e( 'Usually replies during business hours', 'soundcreations' ); ?></span>
				</span>
				<button type="button" class="sc-wa__close" aria-label="<?php esc_attr_e( 'Close chat', 'soundcreations' ); ?>"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 6l12 12M18 6L6 18" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/></svg></button>
			</header>
			<div class="sc-wa__body">
				<div class="sc-wa__bubble">
					<p><?php esc_html_e( 'Hello and welcome to Sound Creations.', 'soundcreations' ); ?></p>
					<p><?php esc_html_e( 'Tell us about your space or the equipment you need, and our team will help.', 'soundcreations' ); ?></p>
					<span class="sc-wa__time" aria-hidden="true"></span>
				</div>
				<p class="sc-wa__label"><?php esc_html_e( 'Pick a topic or type your own message', 'soundcreations' ); ?></p>
				<div class="sc-wa__chips">
					<?php foreach ( $sc_topics as $sc_topic ) : ?>
						<button type="button" class="sc-wa__chip"><?php echo esc_html( $sc_topic ); ?></button>
					<?php endforeach; ?>
				</div>
			</div>
			<form class="sc-wa__form" action="<?php echo esc_url( 'https://wa.me/' . $sc_num ); ?>" method="get" target="_blank" rel="noopener noreferrer">
				<label class="screen-reader-text" for="sc-wa-text"><?php esc_html_e( 'Your message', 'soundcreations' ); ?></label>
				<textarea id="sc-wa-text" name="text" rows="1" maxlength="800" placeholder="<?php esc_attr_e( 'Type a message', 'soundcreations' ); ?>"></textarea>
				<button type="submit" class="sc-wa__send" aria-label="<?php esc_attr_e( 'Send on WhatsApp', 'soundcreations' ); ?>"><svg viewBox="0 0 24 24" aria-hidden="true"><path fill="currentColor" d="M3.4 20.4l17.5-7.5a1 1 0 000-1.8L3.4 3.6a.9.9 0 00-1.3 1l1.8 6.1 9 1.3-9 1.3-1.8 6.1a.9.9 0 001.3 1z"/></svg></button>
			</form>
			<p class="sc-wa__note"><?php esc_html_e( 'Opens WhatsApp with your message ready to send.', 'soundcreations' ); ?></p>
		</section>
		<a class="sc-wa__fab" href="<?php echo esc_url( $sc_nojs ); ?>" target="_blank" rel="noopener noreferrer nofollow" aria-controls="sc-wa-panel" aria-expanded="false" aria-label="<?php esc_attr_e( 'Chat with us on WhatsApp', 'soundcreations' ); ?>">
			<span class="sc-wa__fab-icon"><?php echo $sc_icon; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static SVG. ?></span>
			<span class="sc-wa__fab-label"><?php esc_html_e( 'Chat with us', 'soundcreations' ); ?></span>
		</a>
	</div>
	<?php
}
add_action( 'wp_footer', 'sc_theme_whatsapp_chat', 6 );
