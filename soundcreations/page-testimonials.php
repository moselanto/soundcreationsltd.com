<?php
/**
 * Testimonials page (slug: testimonials).
 *
 * The single canonical home for client quotes. Every legacy testimonials-v-N
 * URL 301s here (see sound-creations-core/includes/post-types.php), so there is
 * exactly one testimonials surface to keep current.
 *
 * Hero copy comes from Sound Creations -> Settings -> Testimonials page; the
 * quotes come from the Testimonials menu in wp-admin. With no published quotes
 * the grid is simply not rendered -- no sample or placeholder quotes -- and
 * Core marks the page noindex until the first real one is published.
 *
 * @package SoundCreations
 */

if ( defined( 'ABSPATH' ) === false ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();
	$sc_lead = (string) sc_setting( 'testimonials_lead', '' );
	?>
	<article class="sc-page sc-testimonials-page">
		<div class="sc-container">
			<?php echo sc_breadcrumb( array( array( __( 'Home', 'soundcreations' ), home_url( '/' ) ), array( get_the_title(), '' ) ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- first-party trusted markup. ?>
			<header class="sc-pagehero">
				<p class="sc-eyebrow"><?php echo esc_html( sc_setting( 'testimonials_eyebrow', __( 'Testimonials', 'soundcreations' ) ) ); ?></p>
				<h1 class="sc-pagehero__title"><?php echo esc_html( sc_setting( 'testimonials_title', get_the_title() ) ); ?></h1>
				<?php if ( '' !== trim( $sc_lead ) ) : ?>
					<p class="sc-lead sc-pagehero__lead"><?php echo sc_rich_e( $sc_lead ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- wp_kses_post inside helper. ?></p>
				<?php endif; ?>
			</header>

			<?php if ( '' !== trim( (string) get_the_content() ) ) : ?>
				<div class="sc-prose sc-page__body"><?php the_content(); ?></div>
			<?php endif; ?>

			<?php echo sc_testimonials_grid(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped in helper. ?>

			<p class="sc-testimonials__cta">
				<a class="sc-btn sc-btn--primary" href="<?php echo esc_url( home_url( '/request-a-consultation/' ) ); ?>"><?php esc_html_e( 'Request a Consultation', 'soundcreations' ); ?></a>
			</p>
		</div>
	</article>
	<?php
endwhile;

get_footer();
