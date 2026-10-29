<?php
/**
 * Featured event page (/masterclass/). WordPress picks this template by slug.
 *
 * Content comes from Sound Creations -> Settings -> Featured event, the same
 * source as the site-wide announcement strip, so the two can never disagree.
 * Anything typed in the page editor renders under the event section (extra
 * notes, schedule, FAQs). The page itself is created by Core
 * (includes/event-schema.php) so nobody has to add it by hand.
 *
 * After the event ends the section hides itself; the page then says so and
 * points visitors to the rest of the site instead of showing a dead CTA.
 *
 * @package SoundCreations
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
get_header();

// Built with Elementor? Show that layout instead (the Featured event widget
// renders the same section).
if ( sc_el_page_content() ) {
	get_footer();
	return;
}

$sc_live = function_exists( 'sc_event_is_live' ) && sc_event_is_live();

if ( $sc_live ) {
	sc_event_feature( 'event_page', 'h1' );
} else {
	?>
	<section class="sc-section sc-event sc-event--ended">
		<div class="sc-container">
			<h1 class="sc-event__title"><?php the_title(); ?></h1>
			<p class="sc-lead"><?php esc_html_e( 'Registration for this event has closed. Follow us for news of upcoming training and events, or talk to our team about your project.', 'soundcreations' ); ?></p>
			<a class="sc-btn sc-btn--primary" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><?php esc_html_e( 'Contact us', 'soundcreations' ); ?></a>
		</div>
	</section>
	<?php
}

while ( have_posts() ) :
	the_post();
	if ( '' !== trim( (string) get_the_content() ) ) :
		?>
		<section class="sc-section">
			<div class="sc-container sc-content">
				<?php the_content(); ?>
			</div>
		</section>
		<?php
	endif;
endwhile;

get_footer();
