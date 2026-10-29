<?php
/**
 * Homepage template. Cinematic dark hero + narrative sections.
 * All copy is editable in wp-admin: Sound Creations -> Settings (Homepage section).
 * Solution cards and Featured Projects are pulled live from the Solutions and
 * Projects you manage in wp-admin (with a safe fallback if none exist yet).
 *
 * @package SoundCreations
 */

if ( defined( 'ABSPATH' ) === false ) {
	exit;
}
get_header();

$sc_hero_video  = sc_setting( 'hero_video' );
$sc_hero_poster = sc_setting( 'home_hero_poster', SC_THEME_URI . '/assets/img/hero-poster.webp' );
?>

<section class="sc-hero sc-hero--video" style="background-image:url('<?php echo esc_url( $sc_hero_poster ); ?>');">
	<?php if ( $sc_hero_video ) : ?>
		<?php
		// Deferred on purpose. An autoplaying <video> with a src in the markup is
		// fetched immediately and in full, so this ~23MB file was competing with the
		// stylesheet, fonts and the LCP image for bandwidth on every first visit.
		// No autoplay, no src, preload="none": assets/js/theme.js attaches the source
		// after the load event. The poster is already painted as this section's CSS
		// background, so the hero looks identical while the video is still absent.
		?>
		<video class="sc-hero__video" muted loop playsinline preload="none"
			data-sc-hero-video="<?php echo esc_url( $sc_hero_video ); ?>"
			poster="<?php echo esc_url( $sc_hero_poster ); ?>"></video>
	<?php endif; ?>
	<span class="sc-hero__scrim" aria-hidden="true"></span>
	<div class="sc-container sc-hero__inner">
		<?php
		// Hero headline removed at the owner's request (2026-09-15). The setting is kept
		// so a headline can be restored from Sound Creations -> Settings at any time; the
		// h1 is emitted only when it actually holds text, so an empty value leaves no
		// stray empty heading in the markup.
		$sc_hero_title = trim( (string) sc_setting( 'home_hero_title', '' ) );
		if ( strlen( $sc_hero_title ) > 0 ) :
			?>
			<h1 class="sc-hero__title"><?php echo esc_html( $sc_hero_title ); ?></h1>
		<?php else : ?>
			<?php
			// The visible headline was removed at the owner's request, but a page with
			// no h1 at all is an SEO and screen-reader defect -- the homepage was the
			// only page on the site missing one. This keeps the design exactly as the
			// owner wants it while giving the document a single top-level heading.
			// Visually hidden inline (not display:none, which hides it from assistive
			// tech too, defeating the point).
			?>
			<h1 style="position:absolute;width:1px;height:1px;margin:-1px;padding:0;overflow:hidden;clip:rect(0 0 0 0);clip-path:inset(50%);white-space:nowrap;border:0;"><?php echo esc_html( sc_setting( 'tagline', get_bloginfo( 'name' ) ) ); ?></h1>
		<?php endif; ?>
	</div>
</section>

<?php
// Every section below the hero lives in inc/sections.php so Elementor widgets
// and the [sc_section] shortcode render the identical markup. The hero above
// stays hand-coded on purpose (owner decision 29 Oct 2026): it is the LCP
// element and enqueue.php preloads its poster for this template.
//
// When the Home page is built with Elementor, its Elementor layout replaces
// the built-in sections (the hero above still prints). Otherwise, or with
// Elementor off, the built-in sections print exactly as before.
if ( ! sc_el_page_content() ) {
	echo sc_render_page_sections( 'home' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped inside each section.
}

get_footer();
