<?php
/**
 * Featured event promotion (first use: Advancing Audio Masterclass 2027).
 *
 * Three surfaces, all driven by the "Featured event" block in
 * Sound Creations -> Settings, so nothing about the event is hardcoded:
 *  - sc_event_bar():     slim announcement strip above the utility band, every page;
 *  - sc_event_feature(): full feature section (poster, details, mentors, CTA),
 *                        rendered on the homepage under the hero;
 *  - [sc_event]:         the same feature section for any page or post.
 *
 * Why the event switches itself off: a promotion that outlives its event is
 * worse than none -- it tells visitors the site is not maintained. So the
 * block hides automatically the day after "Event end date", with no admin
 * action needed. Typing "no" in "Show featured event" hides it at once.
 *
 * Registration is an external, third-party checkout (Pesapal). Links open in
 * a new tab with rel="noopener noreferrer" so the payment page can never
 * script this window, and they are plain links: no form, no PII, nothing
 * touches the enquiry pipeline.
 *
 * @package SoundCreations
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Whether the featured event should be shown right now.
 *
 * Needs a title and a registration URL (no half-empty promotion), must not be
 * switched off, and must not have ended (judged in the site's own timezone).
 *
 * @return bool
 */
function sc_event_is_live() {
	$sc_on = strtolower( trim( (string) sc_setting( 'event_enabled', '' ) ) );
	if ( in_array( $sc_on, array( 'no', 'off', '0', 'hide' ), true ) ) {
		return false;
	}
	if ( '' === trim( (string) sc_setting( 'event_title', '' ) ) || '' === trim( (string) sc_setting( 'event_url', '' ) ) ) {
		return false;
	}
	$sc_end = trim( (string) sc_setting( 'event_end_date', '' ) );
	if ( preg_match( '/^\d{4}-\d{2}-\d{2}$/', $sc_end ) === 1 ) {
		$sc_end_dt = date_create_immutable( $sc_end . ' 23:59:59', wp_timezone() );
		if ( false !== $sc_end_dt && $sc_end_dt->getTimestamp() < time() ) {
			return false;
		}
	}
	return true;
}

/**
 * Parse the mentors textarea: one per line, "Name | Role | Credits".
 *
 * @return array<int, array{name:string, role:string, credits:string}>
 */
function sc_event_mentors() {
	$sc_out   = array();
	$sc_lines = preg_split( '/\r\n|\r|\n/', (string) sc_setting( 'event_mentors', '' ) );
	foreach ( $sc_lines as $sc_line ) {
		$sc_parts = array_map( 'trim', explode( '|', $sc_line ) );
		if ( '' === $sc_parts[0] ) {
			continue;
		}
		$sc_out[] = array(
			'name'    => $sc_parts[0],
			'role'    => isset( $sc_parts[1] ) ? $sc_parts[1] : '',
			'credits' => isset( $sc_parts[2] ) ? $sc_parts[2] : '',
		);
	}
	return $sc_out;
}

/**
 * Attributes shared by every outbound registration link.
 *
 * @param string $where Where the link sits, sent to GA4 as link_location.
 * @return string Escaped attribute string.
 */
function sc_event_link_attrs( $where ) {
	return 'href="' . esc_url( sc_setting( 'event_url', '' ) ) . '" target="_blank" rel="noopener noreferrer" data-sc-event-cta="' . esc_attr( $where ) . '"';
}

/**
 * Slim announcement strip above the utility band. Called from header.php.
 */
function sc_event_bar() {
	if ( ! sc_event_is_live() ) {
		return;
	}
	$sc_text = trim( (string) sc_setting( 'event_bar_text', '' ) );
	if ( '' === $sc_text ) {
		$sc_text = (string) sc_setting( 'event_title', '' );
	}
	// On the homepage the strip jumps to the feature section; elsewhere it
	// goes to the homepage section so visitors see the details before paying.
	$sc_more = is_front_page() ? '#sc-event' : home_url( '/#sc-event' );
	?>
	<div class="sc-eventbar" role="region" aria-label="<?php esc_attr_e( 'Featured event', 'soundcreations' ); ?>">
		<div class="sc-container sc-eventbar__inner">
			<span class="sc-eventbar__tag"><?php echo esc_html( sc_setting( 'event_bar_tag', 'Upcoming' ) ); ?></span>
			<a class="sc-eventbar__text" href="<?php echo esc_url( $sc_more ); ?>"><?php echo esc_html( $sc_text ); ?></a>
			<a class="sc-eventbar__cta" <?php echo sc_event_link_attrs( 'event_bar' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>><?php echo esc_html( sc_setting( 'event_cta_label', 'Register now' ) ); ?> <span aria-hidden="true">&rarr;</span><span class="screen-reader-text"> <?php esc_html_e( '(opens in a new tab)', 'soundcreations' ); ?></span></a>
		</div>
	</div>
	<?php
}

/**
 * Full feature section. Returns markup so it can serve the shortcode too.
 *
 * @param string $where GA4 link_location for the CTA (homepage / shortcode).
 * @return string
 */
function sc_event_feature_html( $where = 'home_feature' ) {
	if ( ! sc_event_is_live() ) {
		return '';
	}
	$sc_poster  = trim( (string) sc_setting( 'event_poster_img', '' ) );
	$sc_title   = (string) sc_setting( 'event_title', '' );
	$sc_social  = trim( (string) sc_setting( 'event_social_url', '' ) );
	$sc_mentors = sc_event_mentors();
	$sc_facts   = array(
		array( __( 'Dates', 'soundcreations' ), sc_setting( 'event_dates_label', '' ) ),
		array( __( 'Venue', 'soundcreations' ), trim( sc_setting( 'event_venue', '' ) . ', ' . sc_setting( 'event_city', '' ), ', ' ) ),
		array( __( 'Access fee', 'soundcreations' ), sc_setting( 'event_fee_label', '' ) ),
	);
	ob_start();
	?>
	<section class="sc-section sc-event" id="sc-event" aria-labelledby="sc-event-title">
		<div class="sc-container sc-event__grid">
			<?php if ( '' !== $sc_poster ) : ?>
				<a class="sc-event__poster" <?php echo sc_event_link_attrs( $where . '_poster' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>>
					<img src="<?php echo esc_url( $sc_poster ); ?>" alt="<?php echo esc_attr( sprintf( /* translators: %s: event name */ __( '%s poster: mentors, dates, venue and registration details', 'soundcreations' ), $sc_title ) ); ?>" width="900" height="1165" loading="lazy" decoding="async">
				</a>
			<?php endif; ?>
			<div class="sc-event__body">
				<p class="sc-eyebrow sc-eyebrow--home"><?php echo esc_html( sc_setting( 'event_eyebrow', 'Upcoming event' ) ); ?></p>
				<h2 id="sc-event-title" class="sc-event__title"><?php echo esc_html( $sc_title ); ?></h2>
				<?php $sc_lead = trim( (string) sc_setting( 'event_lead', '' ) ); if ( '' !== $sc_lead ) : ?>
					<p class="sc-lead sc-event__lead"><?php echo sc_rich_e( $sc_lead ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- wp_kses_post in helper. ?></p>
				<?php endif; ?>

				<dl class="sc-event__facts">
					<?php foreach ( $sc_facts as $sc_f ) : ?>
						<?php if ( '' === trim( (string) $sc_f[1] ) ) { continue; } ?>
						<div class="sc-event__fact"><dt><?php echo esc_html( $sc_f[0] ); ?></dt><dd><?php echo esc_html( $sc_f[1] ); ?></dd></div>
					<?php endforeach; ?>
				</dl>

				<?php if ( count( $sc_mentors ) > 0 ) : ?>
					<h3 class="sc-event__subhead"><?php echo esc_html( sc_setting( 'event_mentors_title', 'Your mentors' ) ); ?></h3>
					<ul class="sc-event__mentors">
						<?php foreach ( $sc_mentors as $sc_m ) : ?>
							<li class="sc-event__mentor">
								<span class="sc-event__mentor-name"><?php echo esc_html( $sc_m['name'] ); ?></span>
								<?php if ( '' !== $sc_m['role'] ) : ?><span class="sc-event__mentor-role"><?php echo esc_html( $sc_m['role'] ); ?></span><?php endif; ?>
								<?php if ( '' !== $sc_m['credits'] ) : ?><span class="sc-event__mentor-credits"><?php echo esc_html( $sc_m['credits'] ); ?></span><?php endif; ?>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>

				<div class="sc-event__actions">
					<a class="sc-btn sc-btn--primary" <?php echo sc_event_link_attrs( $where ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>><?php echo esc_html( sc_setting( 'event_cta_label', 'Register now' ) ); ?> <span aria-hidden="true">&rarr;</span><span class="screen-reader-text"> <?php esc_html_e( '(opens in a new tab)', 'soundcreations' ); ?></span></a>
					<?php if ( '' !== $sc_social ) : ?>
						<a class="sc-btn sc-btn--ghost" href="<?php echo esc_url( $sc_social ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( sc_setting( 'event_social_label', 'View on Instagram' ) ); ?><span class="screen-reader-text"> <?php esc_html_e( '(opens in a new tab)', 'soundcreations' ); ?></span></a>
					<?php endif; ?>
				</div>
				<?php $sc_note = trim( (string) sc_setting( 'event_note', '' ) ); if ( '' !== $sc_note ) : ?>
					<p class="sc-event__note"><?php echo esc_html( $sc_note ); ?></p>
				<?php endif; ?>
			</div>
		</div>
	</section>
	<?php
	return (string) ob_get_clean();
}

/**
 * Echo the feature section (homepage).
 */
function sc_event_feature() {
	echo sc_event_feature_html( 'home_feature' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped while building.
}

// [sc_event] -- drop the same section into any page (e.g. a dedicated
// /masterclass/ page). Renders nothing once the event has ended.
add_shortcode(
	'sc_event',
	function () {
		return sc_event_feature_html( 'shortcode' );
	}
);
