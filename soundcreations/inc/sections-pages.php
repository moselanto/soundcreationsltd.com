<?php
/**
 * Page sections for About, Solutions, Projects, FANE, Videos and Contact.
 *
 * GENERATED from the hand-built templates (Elementor rebuild, phase 2) by moving
 * each top-level <section> verbatim into its own function, exactly as phase 1
 * did for the homepage (inc/sections.php). The templates now call these, so
 * the pages render identical markup, and every section is also an Elementor
 * widget and a [sc_section name="..."] shortcode.
 *
 * Each page's shared setup (the code that ran before its first section:
 * queries, parsed settings, icons) lives in sc_pv_{page}(), runs once per
 * request and hands its variables to every section of that page.
 *
 * Editing a section: change its function here, not the template.
 *
 * @package SoundCreations
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Shared setup for the about sections (from page-about.php).
 *
 * @return array
 */
function sc_pv_about() {
	static $sc_v = null;
	if ( null === $sc_v ) {
		$sc_v = ( static function () {

// About hero photo: the CITAM auditorium install (2026-09-22 owner request),
// replacing about-photo.jpg. This is the FALLBACK only -- a URL saved in
// Settings ("About hero: photo") wins, because sc_setting() prefers a stored
// value. about_hero_image has no entry in sc_default_settings() and the image
// pickers were deliberately left unprefilled, so this fallback is what renders
// unless someone has pasted a URL into that field.
// The matching LCP preload hint in inc/enqueue.php points at the same file and
// must be kept in step with it.
$sc_about_photo = sc_setting( 'about_hero_image', SC_THEME_URI . '/assets/img/about-citam.webp' );

/*
 * Our Work Process (2026-09-22, owner request).
 *
 * Replaces the eight-card "What We Do" grid with the four-step work process
 * carried on the original site's homepage (soundcreationsltd.com). Titles and
 * copy are lifted verbatim from there; the only edit is a stray space before
 * the full stop in the Distribution line ("warranties ." -> "warranties.").
 *
 * NEW SETTING KEYS ON PURPOSE. The old section read 'about_exp_eyebrow', which
 * IS present in sc_default_settings() and was therefore written into the
 * soundcreations_settings option by the one-shot
 * sc_core_prefill_settings_from_defaults() pass. sc_setting() prefers a stored
 * value over any default, so re-pointing that key at new copy would have been
 * silently overridden by the stored "What We Do" and the change would not have
 * appeared on the live site. 'about_process_eyebrow' and 'about_process_items'
 * have no stored value, so these defaults resolve immediately -- and both keys
 * are registered in the core plugin so the owner can still edit them.
 */
$sc_proc_default = "Consultation & Design | We listen, we visualize with our new client, we propose, we reach agreements & we represent the solution. | /service/consultancy/\nDistribution | From the most affordable to the substantial investments, we keep the quality 100% and the warranties. | /distribution-dealership/\nIntegration | Our promise is professional installations, system trainings, seamless handovers and guaranteed. | /service/integration/\nSupport & Training | Comprehensive after-sales support, including a 1-year warranty service after installation. | /service/after-sale-services/";
$sc_proc_raw   = sc_setting( 'about_process_items', $sc_proc_default );
$sc_proc_items = array();
foreach ( preg_split( "/\r\n|\r|\n/", $sc_proc_raw ) as $sc_line ) {
	$sc_line = trim( $sc_line );
	if ( $sc_line === '' ) {
		continue;
	}
	// Third field is an optional link target (2026-09-22 owner request). The
	// limit is 3 so a description containing a pipe still parses, and a step
	// written with only "Title | Description" keeps working -- it simply renders
	// as a plain card rather than a link.
	$sc_parts = array_map( 'trim', explode( '|', $sc_line, 3 ) );
	$sc_url   = isset( $sc_parts[2] ) ? $sc_parts[2] : '';
	// Relative paths MUST go through home_url() so they stay correct wherever
	// WordPress is installed. The site now runs at the domain root; it was
	// previously served from the /newwebsite/ subdirectory, where a bare
	// "/service/consultancy/" resolved against the domain root and 404'd.
	// Absolute URLs pass through unchanged.
	if ( '' !== $sc_url && 0 !== strpos( $sc_url, 'http' ) ) {
		$sc_url = home_url( $sc_url );
	}
	$sc_proc_items[] = array(
		'title' => $sc_parts[0],
		'desc'  => isset( $sc_parts[1] ) ? $sc_parts[1] : '',
		'url'   => $sc_url,
	);
}
// Icons follow the original site's set: consultation (speech + group),
// distribution (globe), integration (operator at a console), support (gear).
// Indexed modulo the array so an owner adding a fifth step still renders.
$sc_proc_icons = array(
	'<path d="M2.5 5A1.5 1.5 0 0 1 4 3.5h7A1.5 1.5 0 0 1 12.5 5v3.5A1.5 1.5 0 0 1 11 10H6l-3.5 2.5V10z"/><path d="M15 6.5h5A1.5 1.5 0 0 1 21.5 8v3.5a1.5 1.5 0 0 1-1.5 1.5v2l-2.5-2h-2"/><circle cx="6" cy="17" r="1.5"/><circle cx="12" cy="17" r="1.5"/><circle cx="18" cy="17" r="1.5"/><path d="M3 22a3 3 0 0 1 6 0"/><path d="M9 22a3 3 0 0 1 6 0"/><path d="M15 22a3 3 0 0 1 6 0"/>',
	'<circle cx="12" cy="12" r="9"/><path d="M3 12h18"/><path d="M12 3c2.6 2.5 4 5.6 4 9s-1.4 6.5-4 9c-2.6-2.5-4-5.6-4-9s1.4-6.5 4-9z"/>',
	'<circle cx="12" cy="6.4" r="2.6"/><path d="M8.5 13.4a3.5 3.5 0 0 1 7 0"/><path d="M5 17h14l1.6 3.6H3.4z"/>',
	'<circle cx="12" cy="12" r="3.2"/><path d="M19.2 14.9a1.7 1.7 0 0 0 .34 1.87l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.7 1.7 0 0 0-2.9 1.22V21a2 2 0 1 1-4 0v-.11a1.7 1.7 0 0 0-2.9-1.22l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.7 1.7 0 0 0-1.22-2.9H3a2 2 0 1 1 0-4h.11a1.7 1.7 0 0 0 1.22-2.9l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.7 1.7 0 0 0 2.9-1.22V3a2 2 0 1 1 4 0v.11a1.7 1.7 0 0 0 2.9 1.22l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.7 1.7 0 0 0 1.22 2.9H21a2 2 0 1 1 0 4h-.11a1.7 1.7 0 0 0-1.56 1.03z"/>',
);
			return get_defined_vars();
		} )();
	}
	return $sc_v;
}

/**
 * About: intro hero.
 */
function sc_section_about_hero() {
	extract( sc_pv_about(), EXTR_SKIP ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract -- page setup variables, first-party.
	?>
<section class="sc-about-hero sc-section--tight" id="about-intro">
	<div class="sc-container sc-journey">
		<div class="sc-journey__text">
			<nav class="sc-breadcrumb" aria-label="Breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a><span class="sep">/</span><span aria-current="page">About</span></nav>
			<p class="sc-eyebrow"><?php echo esc_html( sc_setting( 'about_hero_eyebrow', 'Who We Are' ) ); ?></p>
			<h1 class="sc-about-hero__title"><?php echo esc_html( sc_setting( 'about_hero_title', 'If it sounds good, it’s Sound Creations' ) ); ?></h1>
			<p class="sc-journey__lead"><?php echo sc_rich_e( sc_setting( 'about_journey_p1', 'Founded in 2004, Sound Creations Ltd has grown into a leading provider of professional audio, visual, lighting and acoustic solutions across East Africa and beyond. What began as a specialist audio company is today a full-service integrator — designing, supplying, installing and supporting complete systems for the region’s most demanding spaces.' ) ); ?></p>
		</div>
		<div class="sc-about-hero__media" style="align-self:stretch;background-image:url('<?php echo esc_url( $sc_about_photo ); ?>');" role="img" aria-label="<?php esc_attr_e( 'Sound Creations at work', 'soundcreations' ); ?>"></div>
	</div>
</section>
	<?php
}

/**
 * About: work process.
 */
function sc_section_about_process() {
	extract( sc_pv_about(), EXTR_SKIP ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract -- page setup variables, first-party.
	?>
<section class="sc-section sc-section--tight" id="work-process">
	<div class="sc-container">
		<div class="sc-workproc__head">
			<p class="sc-eyebrow"><?php echo esc_html( sc_setting( 'about_process_eyebrow', 'Our Work Process' ) ); ?></p>
		</div>
		<div class="sc-workproc">
			<?php
			foreach ( $sc_proc_items as $sc_i => $sc_step ) :
				// Each step links to its Service page when a third field is present.
				// The whole card becomes the anchor so the icon, title and copy are
				// one target, rather than burying a small "read more" link. Steps
				// without a URL still render as a plain div.
				$sc_has_link = ( '' !== $sc_step['url'] );
				$sc_tag      = $sc_has_link ? 'a' : 'div';
				?>
				<<?php echo $sc_tag; ?> class="sc-workproc__item"<?php echo $sc_has_link ? ' href="' . esc_url( $sc_step['url'] ) . '"' : ''; ?>>
					<span class="sc-workproc__icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><?php echo $sc_proc_icons[ $sc_i % count( $sc_proc_icons ) ]; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static inline SVG. ?></svg></span>
					<h3 class="sc-workproc__title"><?php echo esc_html( $sc_step['title'] ); ?></h3>
					<?php if ( '' !== $sc_step['desc'] ) : ?>
						<p class="sc-workproc__desc"><?php echo esc_html( $sc_step['desc'] ); ?></p>
					<?php endif; ?>
				</<?php echo $sc_tag; ?>>
				<?php
			endforeach;
			?>
		</div>
	</div>
</section>
	<?php
}

/**
 * About: our brands.
 */
function sc_section_about_brands() {
	extract( sc_pv_about(), EXTR_SKIP ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract -- page setup variables, first-party.
	?>
<section class="sc-section sc-section--tight" id="our-brands">
	<div class="sc-container">
		<p class="sc-eyebrow"><?php echo esc_html( sc_setting( 'about_partners_eyebrow', 'Our Brands' ) ); ?></p>
		<h2 style="margin-bottom:1.5rem;"><?php echo esc_html( sc_setting( 'about_partners_title', 'World-class brands, supported locally' ) ); ?></h2>
		<?php echo do_shortcode( '[sc_partners]' ); ?>
	</div>
</section>
	<?php
}

/**
 * About: company summary.
 */
function sc_section_about_company() {
	extract( sc_pv_about(), EXTR_SKIP ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract -- page setup variables, first-party.
// Body text from the About page editor (for example the company summary),
// shown above the company profiles. Hidden when the editor is empty.
$sc_about_body = sc_about_body_source();
if ( '' !== trim( wp_strip_all_tags( $sc_about_body ) ) ) :
	?>
<section class="sc-section sc-section--tight" id="about-company">
	<div class="sc-container">
		<div class="sc-prose"><?php echo sc_about_body_html( $sc_about_body ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- same filters as the_content(). ?></div>
	</div>
</section>
<?php endif; ?>
	<?php
}

/**
 * About: company profiles.
 */
function sc_section_about_profiles() {
	extract( sc_pv_about(), EXTR_SKIP ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract -- page setup variables, first-party.
	?>
<section class="sc-section sc-section--tight" id="company-profiles">
	<div class="sc-container">
		<?php echo do_shortcode( '[sc_profiles]' ); ?>
	</div>
</section>
	<?php
}

/**
 * Shared setup for the solpage sections (from archive-sc_solution.php).
 *
 * @return array
 */
function sc_pv_solpage() {
	static $sc_v = null;
	if ( null === $sc_v ) {
		$sc_v = ( static function () {

$sc_sol_hero  = SC_THEME_URI . '/assets/img/solutions-hero.jpg';
$sc_cta_photo = SC_THEME_URI . '/assets/img/cta-building.webp';

			return get_defined_vars();
		} )();
	}
	return $sc_v;
}

/**
 * Solutions: hero.
 */
function sc_section_solpage_hero() {
	extract( sc_pv_solpage(), EXTR_SKIP ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract -- page setup variables, first-party.
	?>
<section class="sc-support-hero sc-solutions-hero" style="background-image:url('<?php echo esc_url( $sc_sol_hero ); ?>');">
	<span class="sc-support-hero__scrim" aria-hidden="true"></span>
	<div class="sc-container sc-support-hero__inner">
		<nav class="sc-crumb" aria-label="Breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a> <span aria-hidden="true">&rsaquo;</span> <span class="sc-crumb__cur"><?php esc_html_e( 'Solutions', 'soundcreations' ); ?></span></nav>
		<h1 class="sc-support-hero__title"><?php echo esc_html( sc_setting( 'sol_hero_title', 'Engineered solutions. Exceptional experiences.' ) ); ?></h1>
		<p class="sc-lead sc-support-hero__lead"><?php echo sc_rich_e( sc_setting( 'sol_hero_lead', 'We design, integrate and support professional audio, visual, lighting and acoustic solutions for every space, application and performance.' ) ); ?></p>
	</div>
</section>
	<?php
}

/**
 * Solutions: solution cards.
 */
function sc_section_solpage_grid() {
	extract( sc_pv_solpage(), EXTR_SKIP ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract -- page setup variables, first-party.
	?>
<section class="sc-section">
	<div class="sc-container">
		<div class="sc-sechead">
			<div>
				<p class="sc-eyebrow"><?php esc_html_e( 'Our Solutions', 'soundcreations' ); ?></p>
			</div>
		</div>
		<div class="sc-solgrid">
			<?php
			$sc_sols = array(
				array( 'solution-db3.webp', 'Professional Audio', 'Powerful, intelligible and reliable sound systems designed around your room and application.', '/solutions/professional-audio/', 'home_sol1_img' ),
				array( 'solution-acoustics.jpg', 'Acoustics', 'Acoustics treated as an engineering discipline: measure, analyze, design, treat and verify for clear, intelligible sound.', '/solutions/acoustics/', 'home_sol2_img' ),
				array( 'solution-av-integration.jpg', 'Sound & Acoustic Integration', 'Professional sound and acoustic systems, installed, commissioned and calibrated by our technical team.', '/solutions/installation/', 'home_sol3_img' ),
			);
			foreach ( $sc_sols as $sc_so ) :
				$sc_scimg = sc_setting( $sc_so[4], SC_THEME_URI . '/assets/img/home/' . $sc_so[0] );
				?>
				<a class="sc-solcard" href="<?php echo esc_url( home_url( $sc_so[3] ) ); ?>">
					<span class="sc-solcard__img"><img src="<?php echo esc_url( $sc_scimg ); ?>" alt="<?php echo esc_attr( $sc_so[1] ); ?>" loading="lazy" decoding="async" width="640" height="440"></span>
					<span class="sc-solcard__body">
						<h3><?php echo esc_html( $sc_so[1] ); ?></h3>
						<p><?php echo esc_html( $sc_so[2] ); ?></p>
						<span class="sc-solcard__more"><?php esc_html_e( 'Explore solution', 'soundcreations' ); ?> &rarr;</span>
					</span>
				</a>
				<?php
			endforeach;
			?>
		</div>
	</div>
</section>
	<?php
}

/**
 * Solutions: sectors.
 */
function sc_section_solpage_sectors() {
	extract( sc_pv_solpage(), EXTR_SKIP ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract -- page setup variables, first-party.
	?>
<section class="sc-section">
	<div class="sc-container">
		<div class="sc-sechead">
			<div>
				<p class="sc-eyebrow"><?php esc_html_e( 'Solutions by Sector', 'soundcreations' ); ?></p>
			</div>
		</div>
		<div class="sc-solgrid">
			<?php
			// Sector landing pages (Solutions entries created in wp-admin). A card is
			// shown only while its page is published, so a deleted or drafted page
			// never leaves a broken link here.
			$sc_sectors = array(
				array( 'audio-worship.jpg', 'Church and Worship Sound Systems', 'Church PA systems, mixers, microphones and acoustic treatment for clear speech and music in every seat.', 'church-worship-sound-systems' ),
				array( 'install-theatre.jpg', 'School and Auditorium Sound Systems', 'Acoustics, sound and lighting for school halls, chapels and auditoriums, designed together.', 'education-auditorium-sound-systems' ),
				array( 'audio-live.jpg', 'Hospitality and Venue Sound Systems', 'Multi-zone background music, club sound and venue acoustics for hotels, restaurants, clubs and event venues.', 'hospitality-commercial-audio' ),
			);
			foreach ( $sc_sectors as $sc_se ) :
				$sc_se_post = get_page_by_path( $sc_se[3], OBJECT, 'sc_solution' );
				if ( ! $sc_se_post || 'publish' !== $sc_se_post->post_status ) {
					continue;
				}
				$sc_se_img = has_post_thumbnail( $sc_se_post ) ? get_the_post_thumbnail_url( $sc_se_post, 'large' ) : SC_THEME_URI . '/assets/img/solutions/' . $sc_se[0];
				?>
				<a class="sc-solcard" href="<?php echo esc_url( get_permalink( $sc_se_post ) ); ?>">
					<span class="sc-solcard__img"><img src="<?php echo esc_url( $sc_se_img ); ?>" alt="<?php echo esc_attr( $sc_se[1] ); ?>" loading="lazy" decoding="async" width="640" height="440"></span>
					<span class="sc-solcard__body">
						<h3><?php echo esc_html( $sc_se[1] ); ?></h3>
						<p><?php echo esc_html( $sc_se[2] ); ?></p>
						<span class="sc-solcard__more"><?php esc_html_e( 'Explore solution', 'soundcreations' ); ?> &rarr;</span>
					</span>
				</a>
				<?php
			endforeach;
			?>
		</div>
	</div>
</section>
	<?php
}

/**
 * Solutions: featured projects.
 */
function sc_section_solpage_projects() {
	extract( sc_pv_solpage(), EXTR_SKIP ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract -- page setup variables, first-party.
	?>
<section class="sc-section sc-section--surface">
	<div class="sc-container">
		<div class="sc-section__head">
			<div>
				<p class="sc-eyebrow"><?php esc_html_e( 'Featured Projects', 'soundcreations' ); ?></p>
				<h2 style="margin:.3rem 0 0;"><?php esc_html_e( 'Real spaces. Real results.', 'soundcreations' ); ?></h2>
			</div>
			<a class="sc-link-arrow" href="<?php echo esc_url( home_url( '/projects/' ) ); ?>"><?php esc_html_e( 'View All Projects', 'soundcreations' ); ?> &rarr;</a>
		</div>
		<div class="sc-carousel" data-sc-carousel>
			<button class="sc-carousel__btn sc-carousel__btn--prev" type="button" data-sc-prev aria-label="Previous">&lsaquo;</button>
			<div class="sc-carousel__track">
				<?php
				$sc_pq = new WP_Query(
					array(
						'post_type'      => 'sc_project',
						'post_status'    => 'publish',
						'posts_per_page' => 8,
						'orderby'        => array( 'menu_order' => 'ASC', 'title' => 'ASC' ),
						'no_found_rows'  => true,
					)
				);
				if ( $sc_pq->have_posts() ) :
					while ( $sc_pq->have_posts() ) :
						$sc_pq->the_post();
						$pid  = get_the_ID();
						$img = sc_project_card_image( $pid );
						$loc  = (string) get_post_meta( $pid, '_sc_location', true );
						?>
						<a class="sc-project" href="<?php the_permalink(); ?>"><span class="sc-project__media"><img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( get_the_title() ); ?>" loading="lazy" decoding="async" width="400" height="250"></span><h3 class="sc-project__title"><?php echo esc_html( get_the_title() ); ?></h3><?php if ( strlen( $loc ) > 0 ) : ?><p class="sc-project__loc"><?php echo esc_html( $loc ); ?></p><?php endif; ?></a>
						<?php
					endwhile;
					wp_reset_postdata();
				else :
					?>
					<a class="sc-project" href="<?php echo esc_url( home_url( '/projects/' ) ); ?>"><span class="sc-project__media"><img src="<?php echo esc_url( SC_THEME_URI . '/assets/img/projects/boardroom.jpg' ); ?>" alt="Corporate Boardroom" loading="lazy" decoding="async" width="400" height="250"></span><h3 class="sc-project__title">Corporate Boardroom</h3><p class="sc-project__loc">Nairobi, Kenya</p></a>
					<a class="sc-project" href="<?php echo esc_url( home_url( '/projects/' ) ); ?>"><span class="sc-project__media"><img src="<?php echo esc_url( SC_THEME_URI . '/assets/img/projects/worship.jpg' ); ?>" alt="House of Worship" loading="lazy" decoding="async" width="400" height="250"></span><h3 class="sc-project__title">House of Worship</h3><p class="sc-project__loc">Kigali, Rwanda</p></a>
					<a class="sc-project" href="<?php echo esc_url( home_url( '/projects/' ) ); ?>"><span class="sc-project__media"><img src="<?php echo esc_url( SC_THEME_URI . '/assets/img/projects/conference.jpg' ); ?>" alt="Conference Centre" loading="lazy" decoding="async" width="400" height="250"></span><h3 class="sc-project__title">Conference Centre</h3><p class="sc-project__loc">Dubai, UAE</p></a>
					<?php
				endif;
				?>
			</div>
			<button class="sc-carousel__btn sc-carousel__btn--next" type="button" data-sc-next aria-label="Next">&rsaquo;</button>
		</div>
		<script>
		(function(){
			var roots = document.querySelectorAll('[data-sc-carousel]');
			roots.forEach(function(root){
				var track = root.querySelector('.sc-carousel__track');
				if (track === null) { return; }
				function step(){
					var card = track.querySelector('.sc-project');
					if (card === null) { return 320; }
					return card.getBoundingClientRect().width + 20;
				}
				var prev = root.querySelector('[data-sc-prev]');
				var next = root.querySelector('[data-sc-next]');
				if (prev) { prev.addEventListener('click', function(){ track.scrollBy({ left: -step(), behavior: 'smooth' }); }); }
				if (next) { next.addEventListener('click', function(){ track.scrollBy({ left: step(), behavior: 'smooth' }); }); }
			});
		})();
		</script>
	</div>
</section>
	<?php
}

/**
 * Solutions: call to action.
 */
function sc_section_solpage_cta() {
	extract( sc_pv_solpage(), EXTR_SKIP ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract -- page setup variables, first-party.
	?>
<section class="sc-section">
	<div class="sc-container">
		<div class="sc-cta-band sc-cta-band--photo" style="background-image:url('<?php echo esc_url( $sc_cta_photo ); ?>');">
			<div class="sc-cta-band__inner">
				<h2><?php echo esc_html( sc_setting( 'sol_cta_title', 'Have a project in mind?' ) ); ?></h2>
				<p class="sc-lead" style="margin:0 0 1.5rem;"><?php echo sc_rich_e( sc_setting( 'sol_cta_text', 'Let’s design and deliver the right solution for your space and application.' ) ); ?></p>
				<a class="sc-btn sc-btn--primary" href="<?php echo esc_url( home_url( '/request-a-consultation/' ) ); ?>"><?php esc_html_e( 'Request a Consultation', 'soundcreations' ); ?></a>
			</div>
		</div>
	</div>
</section>
	<?php
}

/**
 * Shared setup for the projpage sections (from archive-sc_project.php).
 *
 * @return array
 */
function sc_pv_projpage() {
	static $sc_v = null;
	if ( null === $sc_v ) {
		$sc_v = ( static function () {

$sc_archive  = get_post_type_archive_link( 'sc_project' );
if ( empty( $sc_archive ) ) {
	$sc_archive = home_url( '/projects/' );
}
$sc_consult  = home_url( '/request-a-consultation/' );
$sc_hero_img = SC_THEME_URI . '/assets/img/projects-hero.jpg';
$sc_cta_img  = SC_THEME_URI . '/assets/img/projects-cta.webp';
$sc_arrow    = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>';
$sc_pinicon  = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>';

// Category pills (fixed set matching the design). Slug must match sanitize_title of each card's category.
$sc_cat_pills = array( 'Acoustic', 'Audio', 'Visual' );

// Collect projects (data-driven, ordered by menu_order).
$sc_q = new WP_Query(
	array(
		'post_type'      => 'sc_project',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => array( 'menu_order' => 'ASC', 'title' => 'ASC' ),
		'no_found_rows'  => true,
	)
);
$sc_items = array();
$sc_sols  = array();
$sc_locs  = array();
if ( $sc_q->have_posts() ) {
	while ( $sc_q->have_posts() ) {
		$sc_q->the_post();
		$pid   = get_the_ID();
		$cat   = (string) get_post_meta( $pid, '_sc_category', true );
		$badge = (string) get_post_meta( $pid, '_sc_badge', true );
		$loc   = (string) get_post_meta( $pid, '_sc_location', true );
		$sol   = (string) get_post_meta( $pid, '_sc_solution', true );
		$sum   = (string) get_post_meta( $pid, '_sc_summary', true );
		$img = sc_project_card_image( $pid );
		if ( '' !== $sol && ! in_array( $sol, $sc_sols, true ) ) {
			$sc_sols[] = $sol;
		}
		if ( '' !== $loc && ! in_array( $loc, $sc_locs, true ) ) {
			$sc_locs[] = $loc;
		}
		$division_meta = (string) get_post_meta( $pid, '_sc_division', true );
		if ( strlen( $division_meta ) > 0 ) {
			$divs = array_values( array_filter( array_map( 'trim', explode( ',', $division_meta ) ) ) );
		} else {
			$hay  = strtolower( $sol . ' ' . $cat . ' ' . $sum . ' ' . get_the_title() );
			$divs = array();
			if ( is_int( strpos( $hay, 'acoustic' ) ) || is_int( strpos( $hay, 'reverb' ) ) || is_int( strpos( $hay, 'stone-wool' ) ) || is_int( strpos( $hay, 'ceiling' ) ) || is_int( strpos( $hay, 'treatment' ) ) ) {
				$divs[] = 'Acoustic';
			}
			if ( is_int( strpos( $hay, 'audio' ) ) || is_int( strpos( $hay, 'sound' ) ) || is_int( strpos( $hay, 'pa system' ) ) || is_int( strpos( $hay, 'loudspeaker' ) ) || is_int( strpos( $hay, 'amplif' ) ) || is_int( strpos( $hay, 'monitor' ) ) || is_int( strpos( $hay, 'front-of-house' ) ) || is_int( strpos( $hay, 'subwoofer' ) ) || is_int( strpos( $hay, 'console' ) ) || is_int( strpos( $hay, 'reinforcement' ) ) || is_int( strpos( $hay, ' av ' ) ) ) {
				$divs[] = 'Audio';
			}
			if ( is_int( strpos( $hay, 'visual' ) ) || is_int( strpos( $hay, 'video' ) ) || is_int( strpos( $hay, 'lecture' ) ) || is_int( strpos( $hay, 'projection' ) ) || is_int( strpos( $hay, 'display' ) ) || is_int( strpos( $hay, 'screen' ) ) || is_int( strpos( $hay, ' av ' ) ) || is_int( strpos( $hay, 'integrat' ) ) ) {
				$divs[] = 'Visual';
			}
			if ( count( $divs ) === 0 ) {
				$divs[] = 'Audio';
			}
		}
		$division_slugs = array();
		foreach ( $divs as $d ) {
			$division_slugs[] = sanitize_title( $d );
		}
		$sc_items[] = array(
			'title' => get_the_title(),
			'href'  => get_permalink( $pid ),
			'cat'   => implode( ' ', $division_slugs ),
			'badge' => implode( ' / ', $divs ),
			'loc'   => $loc,
			'sol'   => $sol,
			'sum'   => $sum,
			'img'   => $img,
		);
	}
	wp_reset_postdata();
}
			return get_defined_vars();
		} )();
	}
	return $sc_v;
}

/**
 * Projects: hero.
 */
function sc_section_projpage_hero() {
	extract( sc_pv_projpage(), EXTR_SKIP ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract -- page setup variables, first-party.
	?>
<section class="sc-projhero">
	<div class="sc-container sc-projhero__grid">
		<div class="sc-projhero__text">
			<?php echo sc_breadcrumb( array( array( 'Home', home_url( '/' ) ), array( 'Projects', '' ) ) ); ?>
			<p class="sc-eyebrow"><?php echo esc_html( sc_setting( 'projects_eyebrow', 'Our Projects' ) ); ?></p>
			<h1 class="sc-projhero__title"><?php echo esc_html( sc_setting( 'projects_title', 'Real solutions. Real impact.' ) ); ?></h1>
			<p class="sc-lead sc-projhero__lead"><?php echo sc_rich_e( sc_setting( 'projects_lead', 'Explore a selection of our professional audio, acoustics and integration projects across Africa and the Middle East.' ) ); ?></p>
			<a class="sc-btn sc-btn--primary sc-projhero__btn" href="<?php echo esc_url( $sc_consult ); ?>"><?php esc_html_e( 'Start Your Project', 'soundcreations' ); ?> <?php echo $sc_arrow; ?></a>
		</div>
		<div class="sc-projhero__media">
			<img src="<?php echo esc_url( $sc_hero_img ); ?>" alt="<?php esc_attr_e( 'Concert hall and auditorium installation', 'soundcreations' ); ?>" loading="eager" decoding="async">
		</div>
	</div>
</section>
	<?php
}

/**
 * Projects: filter and grid.
 */
function sc_section_projpage_grid() {
	extract( sc_pv_projpage(), EXTR_SKIP ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract -- page setup variables, first-party.
	?>
<section class="sc-section sc-projfilter-sec">
	<div class="sc-container" data-sc-projfilter>
		<div class="sc-projfilters">
			<div class="sc-projfilters__row">
				<span class="sc-projfilters__label"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg> <?php esc_html_e( 'Filter by Category', 'soundcreations' ); ?></span>
				<div class="sc-projfilters__pills">
					<button type="button" class="sc-projpill is-active" data-proj-cat="all"><?php esc_html_e( 'All Projects', 'soundcreations' ); ?></button>
					<?php foreach ( $sc_cat_pills as $c ) : ?>
						<button type="button" class="sc-projpill" data-proj-cat="<?php echo esc_attr( sanitize_title( $c ) ); ?>"><?php echo esc_html( $c ); ?></button>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="sc-projfilters__row sc-projfilters__row--controls">
				<label class="sc-projctrl sc-projctrl--search">
					<span class="sc-projfilters__label"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg> <?php esc_html_e( 'Search Projects', 'soundcreations' ); ?></span>
					<input type="search" data-proj-search placeholder="<?php esc_attr_e( 'Search project, venue or solution...', 'soundcreations' ); ?>">
				</label>
			</div>
		</div>

		<div class="sc-projfeat-head">
			<h2><?php esc_html_e( 'Featured Projects', 'soundcreations' ); ?></h2>
			<a class="sc-linkbtn" href="<?php echo esc_url( $sc_archive ); ?>"><?php esc_html_e( 'View All Projects', 'soundcreations' ); ?> <span aria-hidden="true">&rarr;</span></a>
		</div>

		<?php if ( count( $sc_items ) > 0 ) : ?>
			<div class="sc-projgrid">
				<?php
				foreach ( $sc_items as $it ) :
					$text = strtolower( $it['title'] . ' ' . $it['loc'] . ' ' . $it['cat'] . ' ' . $it['sol'] . ' ' . $it['sum'] );
					?>
					<article class="sc-projcard" data-card data-category="<?php echo esc_attr( $it['cat'] ); ?>" data-location="<?php echo esc_attr( sanitize_title( $it['loc'] ) ); ?>" data-solution="<?php echo esc_attr( sanitize_title( $it['sol'] ) ); ?>" data-text="<?php echo esc_attr( $text ); ?>">
						<a class="sc-projcard__media" href="<?php echo esc_url( $it['href'] ); ?>" style="background-image:url('<?php echo esc_url( $it['img'] ); ?>');">
							<?php if ( '' !== $it['badge'] ) : ?>
								<span class="sc-projcard__badge"><?php echo esc_html( $it['badge'] ); ?></span>
							<?php endif; ?>
							<?php if ( '' !== $it['loc'] ) : ?>
								<span class="sc-projcard__loc"><?php echo $sc_pinicon; ?> <?php echo esc_html( $it['loc'] ); ?></span>
							<?php endif; ?>
						</a>
						<div class="sc-projcard__body">
							<h3 class="sc-projcard__title"><?php echo esc_html( $it['title'] ); ?></h3>
							<?php if ( '' !== $it['sum'] ) : ?>
								<p class="sc-projcard__desc"><?php echo esc_html( $it['sum'] ); ?></p>
							<?php endif; ?>
							<a class="sc-projcard__link" href="<?php echo esc_url( $it['href'] ); ?>"><?php esc_html_e( 'View Project', 'soundcreations' ); ?> <span aria-hidden="true">&rarr;</span></a>
						</div>
					</article>
				<?php endforeach; ?>
			</div>
			<p class="sc-projempty" data-proj-empty hidden><?php esc_html_e( 'No projects match your filters.', 'soundcreations' ); ?></p>
		<?php else : ?>
			<div class="sc-empty"><?php esc_html_e( 'No projects published yet. In wp-admin, open Sound Creations -> Sample Catalog to add starter items.', 'soundcreations' ); ?></div>
		<?php endif; ?>
	</div>
</section>
	<?php
}

/**
 * Projects: stats.
 */
function sc_section_projpage_stats() {
	extract( sc_pv_projpage(), EXTR_SKIP ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract -- page setup variables, first-party.
// Projects proof stats. These numbers were hardcoded here AND on the homepage,
// which is how the site ended up advertising two different project counts.
// They now render from the "Projects stats" field in Sound Creations ->
// Settings (proj_stats), one stat per line as: Number | Label | Sub-note.
$sc_pstat_icons = array(
	0 => '<span class="sc-stat__icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="9" r="6"/><path d="m12 6.4 1.13 2.29 2.53.37-1.83 1.78.43 2.52L12 12.06l-2.26 1.19.43-2.52-1.83-1.78 2.53-.37z"/><path d="M9 14.4 7.5 21l4.5-2.6L16.5 21 15 14.4"/></svg></span>',
	1 => '<span class="sc-stat__icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M3 12h18"/><path d="M12 3c2.6 2.5 4 5.6 4 9s-1.4 6.5-4 9c-2.6-2.5-4-5.6-4-9s1.4-6.5 4-9z"/></svg></span>',
	2 => '<span class="sc-stat__icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M9 4.5h6a1 1 0 0 1 1 1V6a1 1 0 0 1-1 1H9a1 1 0 0 1-1-1v-.5a1 1 0 0 1 1-1z"/><path d="M8 5.5H6a2 2 0 0 0-2 2V19a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5a2 2 0 0 0-2-2h-2"/><path d="m8.5 13.5 2.2 2.2 4.3-4.3"/></svg></span>',
	3 => '<span class="sc-stat__icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M16 19v-1.5a3.5 3.5 0 0 0-3.5-3.5h-5A3.5 3.5 0 0 0 4 17.5V19"/><circle cx="10" cy="8" r="3.2"/><path d="M20 19v-1.5a3.5 3.5 0 0 0-2.6-3.4"/><path d="M15.4 5a3.2 3.2 0 0 1 0 6"/></svg></span>',
);
$sc_pstat_raw = (string) sc_setting( 'proj_stats', '' );

/*
 * SINGLE SOURCE OF TRUTH FOR THE PROOF STATS  (30 Sep 2026)
 *
 * A previous pass moved these numbers out of the template and into the
 * proj_stats setting -- see the comment above -- but left a hardcoded
 * DEFAULT for proj_stats in inc/template-tags.php that still carried the
 * old figures. sc_setting() falls back to that default whenever the field
 * is empty, so the contradiction survived the refactor and the site went on
 * publishing two different numbers for the same facts:
 *
 *     homepage        22+ years      4 locations      850+ projects
 *     projects page   20+ years      4 offices        300+ projects
 *
 * A visitor comparing the two pages sees a company that cannot count its
 * own projects, and 850 versus 300 is not a rounding difference. Publishing
 * mutually contradictory claims is also precisely the pattern that gets a
 * business flagged for misrepresentation.
 *
 * Fix: the homepage stat fields are now the ONE place these facts live. When
 * proj_stats is empty this page derives its tiles from them, so editing the
 * numbers in Settings updates both pages together and they cannot drift
 * apart again. proj_stats is kept as a deliberate override for the rare case
 * where this page should show something different -- but it now starts empty,
 * so matching is the default behaviour rather than something to remember.
 */
if ( '' === trim( $sc_pstat_raw ) ) {
	$sc_derived = array();
	for ( $sc_si = 1; $sc_si <= 4; $sc_si++ ) {
		$sc_dnum  = trim( (string) sc_setting( 'home_stat' . $sc_si . '_num', '' ) );
		$sc_dlab  = trim( (string) sc_setting( 'home_stat' . $sc_si . '_label', '' ) );
		$sc_dnote = trim( (string) sc_setting( 'home_stat' . $sc_si . '_note', '' ) );
		if ( '' === $sc_dnum && '' === $sc_dlab ) {
			continue;
		}
		$sc_derived[] = $sc_dnum . ' | ' . $sc_dlab . ' | ' . $sc_dnote;
	}
	$sc_pstat_raw = implode( "\n", $sc_derived );
}
$sc_pstats    = array();
foreach ( preg_split( '/\r\n|\r|\n/', $sc_pstat_raw ) as $sc_line ) {
	$sc_line = trim( $sc_line );
	if ( '' === $sc_line ) {
		continue;
	}
	$sc_bits = array_map( 'trim', explode( '|', $sc_line ) );
	$sc_pstats[] = array(
		'num'   => isset( $sc_bits[0] ) ? $sc_bits[0] : '',
		'label' => isset( $sc_bits[1] ) ? $sc_bits[1] : '',
		'note'  => isset( $sc_bits[2] ) ? $sc_bits[2] : '',
	);
}
if ( count( $sc_pstats ) > 0 ) :
	?>
<section class="sc-stats sc-stats--proof">
	<div class="sc-container">
		<div class="sc-stats__grid">
			<?php foreach ( $sc_pstats as $sc_pi => $sc_ps ) : ?>
			<div class="sc-stat">
				<?php echo $sc_pstat_icons[ $sc_pi % count( $sc_pstat_icons ) ]; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- trusted inline SVG ?>
				<div class="sc-stat__body">
					<div class="sc-stat__head sc-stat__head--num"><?php echo esc_html( $sc_ps['num'] ); ?></div>
					<div class="sc-stat__sub"><?php echo esc_html( $sc_ps['label'] ); ?><?php if ( '' !== $sc_ps['note'] ) : ?><span class="sc-stat__note"><?php echo esc_html( $sc_ps['note'] ); ?></span><?php endif; ?></div>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>
	<?php
}

/**
 * Projects: call to action.
 */
function sc_section_projpage_cta() {
	extract( sc_pv_projpage(), EXTR_SKIP ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract -- page setup variables, first-party.
	?>
<section class="sc-section">
	<div class="sc-container">
		<div class="sc-cta-band sc-cta-band--photo" style="background-image:url('<?php echo esc_url( $sc_cta_img ); ?>');">
			<div class="sc-cta-band__inner">
				<h2><?php echo esc_html( sc_setting( 'projects_cta_title', 'Have a project in mind?' ) ); ?></h2>
				<p class="sc-lead" style="margin:0 0 1.5rem;"><?php echo sc_rich_e( sc_setting( 'projects_cta_text', 'Our team of experts is ready to help you design and deliver the right solution.' ) ); ?></p>
				<a class="sc-btn sc-btn--primary" href="<?php echo esc_url( $sc_consult ); ?>"><?php esc_html_e( 'Request a Consultation', 'soundcreations' ); ?> <?php echo $sc_arrow; ?></a>
			</div>
		</div>
	</div>
</section>
	<?php
}

/**
 * Shared setup for the fane sections (from page-fane.php).
 *
 * @return array
 */
function sc_pv_fane() {
	static $sc_v = null;
	if ( null === $sc_v ) {
		$sc_v = ( static function () {

$sc_img  = SC_THEME_URI . '/assets/img/fane';
$sc_sol  = SC_THEME_URI . '/assets/img/solutions';
$sc_proj = SC_THEME_URI . '/assets/img/projects';
$sc_spec = $sc_img . '/dist-network.jpg';

$sc_consult = home_url( '/request-a-consultation/' );
$sc_products_url = sc_setting( 'fane_products_url', home_url( '/products/' ) );
$sc_apps_url = sc_setting( 'fane_apps_url', home_url( '/projects/' ) );
$sc_catalogue = trim( (string) sc_setting( 'fane_catalogue_url' ) );

$sc_pills = array(
	array( '65+', 'Years of Engineering Heritage', '<circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/>' ),
	array( 'Precision', 'Engineered for performance', '<circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/>' ),
	array( 'Built to Last', 'Reliability in every environment', '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>' ),
	array( 'Global Standards', 'Designed & engineered in the UK', '<circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>' ),
);

$sc_diff = array(
	array( 'Core', 'Engineered for accuracy and clarity' ),
	array( 'Voice Coil', 'High-power handling and efficiency' ),
	array( 'Basket', 'Rigid, lightweight and durable' ),
	array( 'Magnet System', 'High flux, low distortion motor design' ),
	array( 'Complete Driver', 'Engineered as one precision system' ),
);

$sc_timeline = array(
	array( '1958', 'FANE is founded in the UK with a passion for loudspeaker innovation.' ),
	array( '1960s - 70s', 'Growth and expansion of professional audio component technology.' ),
	array( '1980s - 90s', 'FANE becomes a trusted name in professional loudspeaker components.' ),
	array( '2000s', 'Continued innovation and investment in engineering excellence.' ),
	array( 'Today', 'FANE components power systems in the world’s most demanding venues.' ),
);

$sc_apps = array(
	array( 'Live Sound', $sc_proj . '/performance.jpg' ),
	array( 'Installed Audio', $sc_sol . '/audio.jpg' ),
	array( 'Worship', $sc_proj . '/worship.jpg' ),
	array( 'Touring', $sc_img . '/app-touring.jpg' ),
	array( 'Studio & Recording', $sc_sol . '/broadcast.jpg' ),
	array( 'Hospitality', $sc_img . '/app-hospitality.jpg' ),
	array( 'Custom Design', $sc_img . '/app-custom.jpg' ),
);


$sc_why = array(
	array( 'Heritage', 'Decades of loudspeaker engineering experience.', '<circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/>' ),
	array( 'Engineering', 'Precision components designed for demanding applications.', '<path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>' ),
	array( 'Performance', 'Reliable, consistent performance worldwide.', '<polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>' ),
	array( 'Flexibility', 'Solutions from individual drivers to complete loudspeaker systems.', '<path d="M12 2 2 7l10 5 10-5-10-5z"/><path d="m2 17 10 5 10-5"/><path d="m2 12 10 5 10-5"/>' ),
);

$sc_dist = array(
	array( 'Authorised Distribution', '<path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="m9 12 2 2 4-4"/>' ),
	array( 'Technical Expertise', '<path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/>' ),
	array( 'System Integration', '<rect x="4" y="4" width="16" height="16" rx="2"/><rect x="9" y="9" width="6" height="6"/><line x1="9" y1="1" x2="9" y2="4"/><line x1="15" y1="1" x2="15" y2="4"/><line x1="9" y1="20" x2="9" y2="23"/><line x1="15" y1="20" x2="15" y2="23"/><line x1="20" y1="9" x2="23" y2="9"/><line x1="20" y1="14" x2="23" y2="14"/><line x1="1" y1="9" x2="4" y2="9"/><line x1="1" y1="14" x2="4" y2="14"/>' ),
	array( 'After-Sales Support', '<path d="M3 18v-6a9 9 0 0 1 18 0v6"/><path d="M21 19a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2v-3a2 2 0 0 1 2-2h3z"/><path d="M3 19a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-3a2 2 0 0 0-2-2H3z"/>' ),
);

$sc_arrow = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>';
			return get_defined_vars();
		} )();
	}
	return $sc_v;
}

/**
 * FANE: hero.
 */
function sc_section_fane_hero() {
	extract( sc_pv_fane(), EXTR_SKIP ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract -- page setup variables, first-party.
	?>
<section class="sc-fane-hero">
	<div class="sc-container sc-fane-hero__grid">
		<div class="sc-fane-hero__left">
			<div class="sc-fane-mark"><span class="sc-fane-mark__bar" aria-hidden="true"></span>Fane Africa</div>
			<h1 class="sc-fane-hero__title"><?php echo esc_html( sc_setting( 'fane_title', 'Engineering sound since 1958.' ) ); ?></h1>
			<p class="sc-lead sc-fane-hero__lead"><?php echo sc_rich_e( sc_setting( 'fane_lead', 'Precision-engineered loudspeaker components built for demanding professional applications, trusted by sound professionals around the world.' ) ); ?></p>
			<div class="sc-fane-hero__cta">
				<a class="sc-btn sc-btn--primary" href="<?php echo esc_url( $sc_products_url ); ?>"><?php esc_html_e( 'Explore FANE Products', 'soundcreations' ); ?> <?php echo $sc_arrow; ?></a>
			</div>
		</div>
		<div class="sc-fane-hero__media">
			<img src="<?php echo esc_url( sc_setting( 'fane_hero_image', $sc_img . '/fane-hero-sov15.webp' ) ); ?>" alt="<?php esc_attr_e( 'FANE Sovereign 15-400LF professional loudspeaker driver', 'soundcreations' ); ?>">
		</div>
	</div>
</section>
	<?php
}

/**
 * FANE: dealer and catalogue.
 */
function sc_section_fane_catalogue() {
	extract( sc_pv_fane(), EXTR_SKIP ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract -- page setup variables, first-party.
	?>
<section class="sc-section sc-fane-dealer" id="fane-catalogue">
	<div class="sc-container">
		<div class="sc-cta-band sc-cta-band--photo" style="background-image:url('<?php echo esc_url( $sc_img . '/fane-hero.jpg' ); ?>');">
			<div class="sc-cta-band__inner">
				<h2><?php echo esc_html( sc_setting( 'fane_cta_title', 'Become a FANE Dealer.' ) ); ?></h2>
				<p class="sc-lead" style="margin:0 0 1.5rem;"><?php echo sc_rich_e( sc_setting( 'fane_cta_text', 'We’re building the FANE dealer network across Kenya, Uganda, Tanzania, Rwanda, Burundi, Ethiopia, South Sudan and the Democratic Republic of Congo. Sound Creations focuses on large, project-based installations, so we partner with dealers who can stock and sell FANE components at the local level, supported by product knowledge, technical support, marketing resources and local availability through Sound Creations.' ) ); ?></p>
				<div class="sc-fane-cta__btns">
					<a class="sc-btn sc-btn--primary" href="<?php echo esc_url( home_url( '/become-a-dealer/' ) ); ?>"><?php esc_html_e( 'Become a FANE Dealer', 'soundcreations' ); ?> <?php echo $sc_arrow; ?></a>
					<?php if ( strlen( $sc_catalogue ) > 0 ) : ?>
					<a class="sc-btn sc-btn--ghost" href="<?php echo esc_url( $sc_catalogue ); ?>" target="_blank" rel="noopener"><?php esc_html_e( 'Download Catalogue', 'soundcreations' ); ?> <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg></a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>
	<?php
}

/**
 * FANE: heritage.
 */
function sc_section_fane_heritage() {
	extract( sc_pv_fane(), EXTR_SKIP ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract -- page setup variables, first-party.
	?>
<section class="sc-section sc-fane-alt" id="fane-heritage">
	<div class="sc-container">
		<p class="sc-eyebrow"><?php esc_html_e( 'Our heritage', 'soundcreations' ); ?></p>
		<h2 class="sc-fane-heritage__title"><?php echo esc_html( sc_setting( 'fane_heritage_title', '65+ years of loudspeaker engineering.' ) ); ?></h2>
		<div class="sc-fane-heritage">
			<div class="sc-timeline">
				<?php foreach ( $sc_timeline as $t ) : ?>
					<div class="sc-tl-item">
						<span class="sc-tl-item__dot" aria-hidden="true"></span>
						<span class="sc-tl-item__year"><?php echo esc_html( $t[0] ); ?></span>
						<span class="sc-tl-item__text"><?php echo esc_html( $t[1] ); ?></span>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="sc-fane-heritage__img">
				<img src="<?php echo esc_url( $sc_img . '/fane-headquarters.webp' ); ?>" alt="<?php esc_attr_e( 'FANE headquarters and manufacturing facility', 'soundcreations' ); ?>" loading="lazy" width="1180" height="266">
			</div>
		</div>
	</div>
</section>
	<?php
}

/**
 * FANE: the difference.
 */
function sc_section_fane_difference() {
	extract( sc_pv_fane(), EXTR_SKIP ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract -- page setup variables, first-party.
	?>
<section class="sc-section" id="fane-difference">
	<div class="sc-container sc-fane-diff">
		<div class="sc-fane-diff__intro">
			<p class="sc-eyebrow"><?php esc_html_e( 'The FANE difference', 'soundcreations' ); ?></p>
			<h2><?php echo esc_html( sc_setting( 'fane_diff_title', 'Built from the inside out.' ) ); ?></h2>
			<p class="sc-support-sub"><?php echo sc_rich_e( sc_setting( 'fane_diff_body', 'Every FANE component is designed and engineered to work in perfect harmony - delivering the performance, reliability and consistency professionals depend on.' ) ); ?></p>
			<a class="sc-btn sc-btn--ghost" href="https://www.fane-international.com/" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'Discover Our Technology', 'soundcreations' ); ?> <?php echo $sc_arrow; ?></a>
		</div>
		<div class="sc-fane-diff__media">
			<img src="<?php echo esc_url( $sc_img . '/fane-exploded.jpg' ); ?>" alt="<?php esc_attr_e( 'Exploded view of a FANE loudspeaker driver', 'soundcreations' ); ?>" loading="lazy">
			<div class="sc-fane-diff__labels">
				<?php foreach ( $sc_diff as $d ) : ?>
					<div class="sc-fane-diff__label"><span class="sc-fane-diff__dot" aria-hidden="true"></span><div><strong><?php echo esc_html( $d[0] ); ?></strong><span><?php echo esc_html( $d[1] ); ?></span></div></div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
	<?php
}

/**
 * FANE: social links.
 */
function sc_section_fane_social() {
	extract( sc_pv_fane(), EXTR_SKIP ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract -- page setup variables, first-party.
/*
 * Social channels Sound Creations uses to promote FANE. Every link below is
 * editable in Sound Creations -> Settings (FANE page - social links). Only the
 * FANE fields you fill in are shown - a blank FANE field is hidden, with no
 * company-wide fallback, and the whole bar disappears when none are set.
 */
$sc_fane_soc = array(
	array( 'Facebook',  sc_setting( 'fane_facebook' ),  'facebook',  '<svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor" aria-hidden="true"><path d="M14 9h3V6h-3c-1.7 0-3 1.3-3 3v2H8v3h3v7h3v-7h3l1-3h-4V9c0-.6.4-1 1-1z"/></svg>' ),
	array( 'Instagram', sc_setting( 'fane_instagram' ), 'instagram', '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/></svg>' ),
	array( 'YouTube',   sc_setting( 'fane_youtube' ),   'youtube',   '<svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor" aria-hidden="true"><path d="M23 12s0-3.2-.4-4.7a2.5 2.5 0 0 0-1.8-1.8C19.2 5 12 5 12 5s-7.2 0-8.8.5A2.5 2.5 0 0 0 1.4 7.3C1 8.8 1 12 1 12s0 3.2.4 4.7a2.5 2.5 0 0 0 1.8 1.8C4.8 19 12 19 12 19s7.2 0 8.8-.5a2.5 2.5 0 0 0 1.8-1.8C23 15.2 23 12 23 12zM9.8 15.3V8.7l5.7 3.3z"/></svg>' ),
	array( 'TikTok',    sc_setting( 'fane_tiktok' ),                                'tiktok',    '<svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor" aria-hidden="true"><path d="M16 3c.3 2 1.6 3.6 3.5 4v2.4c-1.3 0-2.5-.3-3.5-.9v5.6a5.6 5.6 0 1 1-5.6-5.6c.3 0 .6 0 .9.1v2.5a3.1 3.1 0 1 0 2.2 3V3H16z"/></svg>' ),
	array( 'X',         sc_setting( 'fane_x' ),         'x',         '<svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor" aria-hidden="true"><path d="M18.9 2H22l-7.6 8.7L23 22h-6.9l-5-6.6L4.3 22H1.2l8.2-9.4L1 2h7.1l4.5 6 6.3-6zm-2.4 18h1.9L7.6 4H5.6z"/></svg>' ),
	array( 'LinkedIn',  sc_setting( 'fane_linkedin' ),  'linkedin',  '<svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor" aria-hidden="true"><path d="M6.94 5a2 2 0 1 1-4 0 2 2 0 0 1 4 0zM3 8.5h3.9V21H3zM9.5 8.5h3.7v1.7h.1c.5-.9 1.8-1.9 3.6-1.9 3.9 0 4.6 2.5 4.6 5.8V21h-3.9v-5.4c0-1.3 0-3-1.8-3s-2.1 1.4-2.1 2.9V21H9.5z"/></svg>' ),
);
$sc_fane_wa = trim( (string) sc_setting( 'fane_whatsapp' ) );
$sc_fane_wa = preg_replace( '/[^0-9]/', '', $sc_fane_wa );
if ( strlen( $sc_fane_wa ) > 0 ) {
	$sc_fane_soc[] = array( 'WhatsApp', 'https://wa.me/' . $sc_fane_wa, 'whatsapp', '<svg viewBox="0 0 24 24" width="18" height="18" fill="currentColor" aria-hidden="true"><path d="M12 2a10 10 0 0 0-8.5 15.3L2 22l4.8-1.3A10 10 0 1 0 12 2zm0 18a8 8 0 0 1-4.1-1.1l-.3-.2-2.8.7.8-2.7-.2-.3A8 8 0 1 1 12 20zm4.4-6c-.2-.1-1.4-.7-1.6-.8s-.4-.1-.5.1-.6.8-.8 1-.3.2-.5.1a6.5 6.5 0 0 1-3.2-2.8c-.2-.4.2-.4.6-1.2.1-.2 0-.3 0-.5s-.5-1.3-.7-1.8-.4-.4-.5-.4h-.5a1 1 0 0 0-.7.3 3 3 0 0 0-.9 2.2c0 1.3 1 2.6 1.1 2.8s1.9 3 4.7 4.2c1.7.7 2.4.8 3.2.7.5-.1 1.4-.6 1.6-1.1s.2-1 .1-1.1z"/></svg>' );
}
$sc_fane_links = array();
foreach ( $sc_fane_soc as $sc_s ) {
	if ( strlen( trim( (string) $sc_s[1] ) ) > 0 ) {
		$sc_fane_links[] = $sc_s;
	}
}
?>
<?php if ( count( $sc_fane_links ) > 0 ) : ?>
<section class="sc-section sc-section--tight" id="fane-social">
	<div class="sc-container">
		<div class="sc-fane-social">
			<div class="sc-fane-social__intro">
				<p class="sc-eyebrow"><?php echo esc_html( sc_setting( 'fane_social_title', 'Follow FANE Africa\'s account' ) ); ?></p>
				<p class="sc-fane-social__lead"><?php echo esc_html( sc_setting( 'fane_social_text', 'See FANE loudspeakers, live demos and installations on the channels we use to bring the brand to East Africa and the Middle East.' ) ); ?></p>
			</div>
			<div class="sc-fane-social__links">
				<?php foreach ( $sc_fane_links as $sc_l ) : ?>
					<a class="sc-fane-social__btn sc-fane-social__btn--<?php echo esc_attr( $sc_l[2] ); ?>" href="<?php echo esc_url( $sc_l[1] ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( $sc_l[0] ); ?>">
						<span class="sc-fane-social__icon" aria-hidden="true"><?php echo $sc_l[3]; ?></span>
						<span class="sc-fane-social__name"><?php echo esc_html( $sc_l[0] ); ?></span>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
<?php endif; ?>
	<?php
}

/**
 * Shared setup for the videos sections (from archive-sc_resource.php).
 *
 * @return array
 */
function sc_pv_videos() {
	static $sc_v = null;
	if ( null === $sc_v ) {
		$sc_v = ( static function () {

$sc_hero_img = SC_THEME_URI . '/assets/img/support-hero.jpg';
$sc_cta_img  = SC_THEME_URI . '/assets/img/support-cta.jpg';
$sc_consult  = home_url( '/request-a-consultation/' );
$sc_arrow    = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>';
$sc_dl       = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>';
$sc_playicon = '<svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M8 5v14l11-7z"/></svg>';

$sc_q = new WP_Query(
	array(
		'post_type'      => 'sc_resource',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => array(
			'menu_order' => 'ASC',
			'date'       => 'DESC',
		),
		'no_found_rows'  => true,
	)
);
$sc_videos    = array();
$sc_downloads = array();
if ( $sc_q->have_posts() ) {
	while ( $sc_q->have_posts() ) {
		$sc_q->the_post();
		$rid  = get_the_ID();
		$vurl = (string) get_post_meta( $rid, '_sc_video_url', true );
		$vid  = function_exists( 'sc_youtube_id' ) ? sc_youtube_id( $vurl ) : '';
		$file = (string) get_post_meta( $rid, '_sc_file', true );
		$desc = has_excerpt( $rid ) ? get_the_excerpt() : wp_trim_words( wp_strip_all_tags( get_the_content() ), 22 );
		if ( strlen( $vid ) > 0 ) {
			$sc_videos[] = array( 'id' => $vid, 'title' => get_the_title(), 'desc' => $desc );
		} else {
			$sc_downloads[] = array(
				'title' => get_the_title(),
				'desc'  => $desc,
				'href'  => ( strlen( $file ) > 0 ) ? $file : get_permalink( $rid ),
				'ext'   => ( strlen( $file ) > 0 ),
			);
		}
	}
	wp_reset_postdata();
}
			return get_defined_vars();
		} )();
	}
	return $sc_v;
}

/**
 * Videos: hero.
 */
function sc_section_videos_hero() {
	extract( sc_pv_videos(), EXTR_SKIP ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract -- page setup variables, first-party.
	?>
<section class="sc-support-hero" style="background-image:url('<?php echo esc_url( $sc_hero_img ); ?>');">
	<span class="sc-support-hero__scrim" aria-hidden="true"></span>
	<div class="sc-container sc-support-hero__inner">
		<nav class="sc-crumb" aria-label="Breadcrumb"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a> <span aria-hidden="true">&rsaquo;</span> <span class="sc-crumb__cur"><?php esc_html_e( 'Videos', 'soundcreations' ); ?></span></nav>
		<p class="sc-eyebrow"><?php echo esc_html( sc_setting( 'resources_eyebrow', 'Videos' ) ); ?></p>
		<h1 class="sc-support-hero__title"><?php echo esc_html( sc_setting( 'resources_title', 'Videos & resources.' ) ); ?></h1>
		<p class="sc-lead sc-support-hero__lead"><?php echo sc_rich_e( sc_setting( 'resources_lead', 'Watch demos, installations and product highlights, plus manuals and datasheets for the systems and brands we supply and support.' ) ); ?></p>
	</div>
</section>
	<?php
}

/**
 * Videos: video grid.
 */
function sc_section_videos_videos() {
	extract( sc_pv_videos(), EXTR_SKIP ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract -- page setup variables, first-party.
 if ( count( $sc_videos ) > 0 ) : ?>
<section class="sc-section">
	<div class="sc-container">
		<div class="sc-res-head">
			<div>
				<p class="sc-eyebrow"><?php esc_html_e( 'Watch', 'soundcreations' ); ?></p>
				<h2 style="margin:.15rem 0 0;"><?php echo esc_html( sc_setting( 'resources_videos_title', 'Videos' ) ); ?></h2>
			</div>
		</div>
		<div class="sc-video-grid">
			<?php foreach ( $sc_videos as $v ) : ?>
				<article class="sc-video-card">
					<button type="button" class="sc-video-card__frame" data-sc-yt="<?php echo esc_attr( $v['id'] ); ?>" aria-label="<?php echo esc_attr( 'Play: ' . $v['title'] ); ?>">
						<img class="sc-video-card__thumb" src="https://img.youtube.com/vi/<?php echo esc_attr( $v['id'] ); ?>/hqdefault.jpg" loading="lazy" alt="<?php echo esc_attr( $v['title'] ); ?>" width="480" height="360">
						<span class="sc-video-card__play" aria-hidden="true"><?php echo $sc_playicon; ?></span>
					</button>
					<div class="sc-video-card__body">
						<h3 class="sc-video-card__title"><?php echo esc_html( $v['title'] ); ?></h3>
						<?php if ( strlen( (string) $v['desc'] ) > 0 ) : ?><p class="sc-video-card__desc"><?php echo esc_html( $v['desc'] ); ?></p><?php endif; ?>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>
<?php
// Click-to-load YouTube player script, printed once per page however many
// video grids are placed (two copies would fight over the same click).
static $sc_yt_js = false;
if ( ! $sc_yt_js && count( $sc_videos ) > 0 ) :
	$sc_yt_js = true;
	?>
<script>
( function () {
	function buildFrame( id, title ) {
		var f = document.createElement( 'iframe' );
		f.className = 'sc-video-card__iframe';
		f.src = 'https://www.youtube.com/embed/' + id + '?autoplay=1&rel=0';
		f.title = title || 'Video';
		f.setAttribute( 'frameborder', '0' );
		f.setAttribute( 'allow', 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share' );
		f.setAttribute( 'allowfullscreen', 'true' );
		return f;
	}
	document.addEventListener( 'click', function ( e ) {
		var btn = e.target.closest ? e.target.closest( '[data-sc-yt]' ) : null;
		if ( btn === null ) {
			return;
		}
		e.preventDefault();
		var id = btn.getAttribute( 'data-sc-yt' );
		if ( id && id.length > 0 ) {
			btn.parentNode.replaceChild( buildFrame( id, btn.getAttribute( 'aria-label' ) ), btn );
		}
	} );
} )();
</script>
<?php endif; ?>
	<?php
}

/**
 * Videos: downloads.
 */
function sc_section_videos_downloads() {
	extract( sc_pv_videos(), EXTR_SKIP ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract -- page setup variables, first-party.
 if ( count( $sc_downloads ) > 0 ) : ?>
<section class="sc-section">
	<div class="sc-container">
		<div class="sc-res-head">
			<div>
				<p class="sc-eyebrow"><?php esc_html_e( 'Downloads & documentation', 'soundcreations' ); ?></p>
				<h2 style="margin:.15rem 0 0;"><?php echo esc_html( sc_setting( 'resources_grid_title', 'Manuals, datasheets & guides.' ) ); ?></h2>
			</div>
		</div>
		<div class="sc-res-grid">
			<?php foreach ( $sc_downloads as $d ) : ?>
				<a class="sc-res-card" href="<?php echo esc_url( $d['href'] ); ?>"<?php echo $d['ext'] ? ' target="_blank" rel="noopener"' : ''; ?>>
					<span class="sc-res-card__icon" aria-hidden="true"><?php echo $sc_dl; ?></span>
					<span class="sc-res-card__text"><strong><?php echo esc_html( $d['title'] ); ?></strong><span><?php echo esc_html( $d['desc'] ); ?></span></span>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>
	<?php
}

/**
 * Videos: empty state.
 */
function sc_section_videos_empty() {
	extract( sc_pv_videos(), EXTR_SKIP ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract -- page setup variables, first-party.
 if ( count( $sc_videos ) === 0 && count( $sc_downloads ) === 0 ) : ?>
<section class="sc-section">
	<div class="sc-container">
		<p class="sc-empty"><?php esc_html_e( 'No videos yet. In wp-admin, go to Videos > Add New, paste a YouTube link in the YouTube video URL field, and publish.', 'soundcreations' ); ?></p>
	</div>
</section>
<?php endif; ?>
	<?php
}

/**
 * Videos: call to action.
 */
function sc_section_videos_cta() {
	extract( sc_pv_videos(), EXTR_SKIP ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract -- page setup variables, first-party.
	?>
<section class="sc-section">
	<div class="sc-container">
		<div class="sc-cta-band sc-cta-band--photo" style="background-image:url('<?php echo esc_url( $sc_cta_img ); ?>');">
			<div class="sc-cta-band__inner">
				<h2><?php echo esc_html( sc_setting( 'resources_cta_title', 'Looking for something specific?' ) ); ?></h2>
				<p class="sc-lead" style="margin:0 0 1.5rem;"><?php echo sc_rich_e( sc_setting( 'resources_cta_text', 'Our technical team can point you to the right video, manual or datasheet for your system.' ) ); ?></p>
				<a class="sc-btn sc-btn--primary" href="<?php echo esc_url( $sc_consult ); ?>"><?php esc_html_e( 'Contact Our Team', 'soundcreations' ); ?> <?php echo $sc_arrow; ?></a>
			</div>
		</div>
	</div>
</section>
	<?php
}

/**
 * Shared setup for the contact sections (from template-parts/contact-page.php).
 *
 * @return array
 */
function sc_pv_contact() {
	static $sc_v = null;
	if ( null === $sc_v ) {
		$sc_v = ( static function () {

$sc_map_img = SC_THEME_URI . '/assets/img/map-africa-me.jpg';

$sc_pin   = '<path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>';
$sc_i_call = '<path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.13.96.36 1.9.7 2.81a2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.9.34 1.85.57 2.81.7A2 2 0 0 1 22 16.92Z"/>';
$sc_i_mail = '<rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-10 6L2 7"/>';
$sc_i_chat = '<path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/>';
$sc_i_clock = '<circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>';

$sc_offices = array(
	array( 'id' => 'nairobi',  'name' => 'Nairobi, Kenya',     'addr' => 'Mpaka Plaza, Mpaka Road, Westlands, Nairobi', 'short' => 'Nairobi',  'x' => 62, 'y' => 61 ),
	array( 'id' => 'kigali',   'name' => 'Kigali, Rwanda',     'addr' => 'KN1 Rd Muhima, Kigali (near BTN)',            'short' => 'Kigali',   'x' => 56, 'y' => 63 ),
	array( 'id' => 'kinshasa', 'name' => 'Kinshasa, DR Congo', 'addr' => 'Kinshasa, Democratic Republic of Congo',       'short' => 'Kinshasa', 'x' => 46, 'y' => 64 ),
	array( 'id' => 'dubai',    'name' => 'Dubai, UAE',         'addr' => 'Dubai, United Arab Emirates',                  'short' => 'Dubai',    'x' => 79, 'y' => 33 ),
);

$sc_phone      = sc_setting( 'phone', '+254 715 754 758' );
$sc_phone_link = sc_setting( 'phone_link', '+254715754758' );
$sc_email      = sc_setting( 'email', 'info@soundcreationsltd.com' );
$sc_hours_week = sc_setting( 'hours_week', 'Mon - Fri: 9:00 AM - 5:30 PM' );
$sc_hours_sat  = sc_setting( 'hours_sat', 'Sat: 9:00 AM - 1:30 PM' );
$sc_addr       = sc_setting( 'address', 'Mpaka Plaza, Mpaka Road, Westlands, Nairobi' );
$sc_whatsapp   = trim( (string) sc_setting( 'whatsapp', '' ) );
$sc_wa_digits  = preg_replace( '/[^0-9]/', '', $sc_whatsapp );

// Per-office contact details. Kigali uses the Rwanda office line; every other
// office uses the Kenya head-office details. Hours lines are pipe-separated.
$sc_ke_contact = array(
	'phone'      => $sc_phone,
	'phone_link' => $sc_phone_link,
	'email'      => $sc_email,
	'hours'      => $sc_hours_week . ' | ' . $sc_hours_sat,
);
$sc_rw_contact = array(
	'phone'      => '+250 783 141 050 | 782 739 889',
	'phone_link' => '+250783141050',
	'email'      => 'fred@soundcreationsltd.com',
	'hours'      => 'Mon – Fri: 9:00am – 6:00pm',
);
$sc_contacts_map = array(
	'nairobi'  => $sc_ke_contact,
	'kigali'   => $sc_rw_contact,
	'kinshasa' => $sc_ke_contact,
	'dubai'    => $sc_ke_contact,
);
			return get_defined_vars();
		} )();
	}
	return $sc_v;
}

/**
 * Contact: hero.
 */
function sc_section_contact_hero() {
	extract( sc_pv_contact(), EXTR_SKIP ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract -- page setup variables, first-party.
	?>
<section class="sc-section sc-section--tight sc-section--compact sc-contactpage-hero">
	<div class="sc-container sc-contactpage-hero__inner">
		<span class="sc-eyebrow"><?php echo esc_html( sc_setting( 'contact_eyebrow', 'Get in touch' ) ); ?></span>
		<h1 class="sc-contactpage-hero__title"><?php echo esc_html( sc_setting( 'contact_title', 'Contact Us' ) ); ?></h1>
		<p class="sc-lead sc-contactpage-hero__lead"><?php echo sc_rich_e( sc_setting( 'contact_lead', 'Have a question, need a quote, or want to visit us? Reach our team through any of the channels below, or send us a message and we will get back to you quickly.' ) ); ?></p>
	</div>
</section>
	<?php
}

/**
 * Contact: form and details.
 */
function sc_section_contact_main() {
	extract( sc_pv_contact(), EXTR_SKIP ); // phpcs:ignore WordPress.PHP.DontExtract.extract_extract -- page setup variables, first-party.
	?>
<section class="sc-section sc-section--compact sc-contactpage-main">
	<div class="sc-container sc-contact-layout">
		<div class="sc-formcard sc-contact-formcard">
			<h2 class="sc-formcard__title"><?php echo esc_html( sc_setting( 'contact_form_title', 'Send us a message' ) ); ?></h2>
			<p class="sc-formcard__sub"><?php echo esc_html( sc_setting( 'contact_form_sub', 'Fill in the form below and our team will respond as soon as possible.' ) ); ?></p>
			<?php echo do_shortcode( '[sc_enquiry_form type="contact"]' ); ?>
		</div>

		<aside class="sc-teamcard sc-contact-info" id="sc-offices">
			<h2 class="sc-teamcard__title"><?php echo esc_html( sc_setting( 'contact_info_title', 'Reach us directly' ) ); ?></h2>
			<ul class="sc-getintouch__list sc-teamcard__contact">
				<li>
					<span class="sc-getintouch__icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><?php echo $sc_i_call; ?></svg></span>
					<div><span class="sc-getintouch__k"><?php esc_html_e( 'Phone', 'soundcreations' ); ?></span><a href="tel:<?php echo esc_attr( $sc_phone_link ); ?>" data-sc-phone><?php echo esc_html( $sc_phone ); ?></a></div>
				</li>
				<li>
					<span class="sc-getintouch__icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><?php echo $sc_i_mail; ?></svg></span>
					<div><span class="sc-getintouch__k"><?php esc_html_e( 'Email', 'soundcreations' ); ?></span><a href="mailto:<?php echo esc_attr( $sc_email ); ?>" data-sc-email><?php echo esc_html( $sc_email ); ?></a></div>
				</li>
				<li>
					<span class="sc-getintouch__icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><?php echo $sc_i_clock; ?></svg></span>
					<div><span class="sc-getintouch__k"><?php esc_html_e( 'Business Hours', 'soundcreations' ); ?></span><span class="sc-getintouch__v" data-sc-hours><?php echo esc_html( $sc_hours_week ); ?><br><?php echo esc_html( $sc_hours_sat ); ?></span></div>
				</li>
			</ul>
			<hr class="sc-teamcard__rule">
			<h3 class="sc-teamcard__offhead"><?php esc_html_e( 'Our Offices', 'soundcreations' ); ?></h3>
			<div class="sc-teamcard__geo" data-sc-locmap data-sc-contacts="<?php echo esc_attr( wp_json_encode( $sc_contacts_map ) ); ?>">
				<ul class="sc-teamcard__offices">
					<?php foreach ( $sc_offices as $i => $o ) : ?>
						<li class="sc-teamcard__office<?php echo 0 === $i ? ' is-active' : ''; ?>" data-loc="<?php echo esc_attr( $o['id'] ); ?>" tabindex="0" role="button" aria-label="<?php echo esc_attr( sprintf( 'Show %s on the map', $o['name'] ) ); ?>">
							<span class="sc-teamcard__pin" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><?php echo $sc_pin; ?></svg></span>
							<div><strong><?php echo esc_html( $o['name'] ); ?></strong><span><?php echo esc_html( $o['addr'] ); ?></span></div>
						</li>
					<?php endforeach; ?>
				</ul>
				<div class="sc-map__stage sc-teamcard__mapstage">
					<img class="sc-map__bg" src="<?php echo esc_url( $sc_map_img ); ?>" alt="<?php esc_attr_e( 'Map of Sound Creations regional offices', 'soundcreations' ); ?>" loading="lazy">
					<?php foreach ( $sc_offices as $i => $o ) : ?>
						<button type="button" class="sc-map__pin<?php echo 0 === $i ? ' is-active' : ''; ?>" data-loc="<?php echo esc_attr( $o['id'] ); ?>" style="left:<?php echo (int) $o['x']; ?>%;top:<?php echo (int) $o['y']; ?>%;" aria-label="<?php echo esc_attr( $o['name'] ); ?>">
							<span class="sc-map__dot"></span><span class="sc-map__flag"><?php echo esc_html( $o['short'] ); ?></span>
						</button>
					<?php endforeach; ?>
				</div>
			</div>
		</aside>
	</div>
</section>
	<?php
}

/**
 * The About page's own editor text, for the "About: company summary" section.
 *
 * Once the About page is built with Elementor, Elementor rewrites post_content
 * on every save, so the original text is kept in _sc_about_body (copied there
 * by the starter-layout tool before it switches the page to Elementor).
 *
 * @return string
 */
function sc_about_body_source() {
	$sc_page = get_page_by_path( 'about' );
	if ( ! $sc_page ) {
		return '';
	}
	if ( function_exists( 'sc_el_is_built' ) && sc_el_is_built( $sc_page->ID ) ) {
		return (string) get_post_meta( $sc_page->ID, '_sc_about_body', true );
	}
	return (string) $sc_page->post_content;
}

/**
 * Format the About text. Uses the_content filters only when the page is NOT an
 * Elementor page: on an Elementor page, the_content would render the page's
 * own Elementor layout again (which contains this section) and loop.
 *
 * @param string $body Raw text.
 * @return string
 */
function sc_about_body_html( $body ) {
	$sc_page = get_page_by_path( 'about' );
	if ( $sc_page && function_exists( 'sc_el_is_built' ) && sc_el_is_built( $sc_page->ID ) ) {
		return wpautop( do_shortcode( wp_kses_post( $body ) ) );
	}
	return str_replace( ']]>', ']]&gt;', apply_filters( 'the_content', $body ) );
}

/**
 * Page sections: key => array( label, function, page, setting keys ).
 *
 * @return array
 */
function sc_page_sections_registry() {
	return array(

		'about_hero' => array( __( 'About: intro hero', 'soundcreations' ), 'sc_section_about_hero', 'about', array( 'about_hero_eyebrow', 'about_hero_title', 'about_journey_p1' ) ),
		'about_process' => array( __( 'About: work process', 'soundcreations' ), 'sc_section_about_process', 'about', array( 'about_process_eyebrow' ) ),
		'about_brands' => array( __( 'About: our brands', 'soundcreations' ), 'sc_section_about_brands', 'about', array( 'about_partners_eyebrow', 'about_partners_title' ) ),
		'about_company' => array( __( 'About: company summary', 'soundcreations' ), 'sc_section_about_company', 'about', array(  ) ),
		'about_profiles' => array( __( 'About: company profiles', 'soundcreations' ), 'sc_section_about_profiles', 'about', array(  ) ),
		'solpage_hero' => array( __( 'Solutions: hero', 'soundcreations' ), 'sc_section_solpage_hero', 'solpage', array( 'sol_hero_title', 'sol_hero_lead' ) ),
		'solpage_grid' => array( __( 'Solutions: solution cards', 'soundcreations' ), 'sc_section_solpage_grid', 'solpage', array(  ) ),
		'solpage_sectors' => array( __( 'Solutions: sectors', 'soundcreations' ), 'sc_section_solpage_sectors', 'solpage', array(  ) ),
		'solpage_projects' => array( __( 'Solutions: featured projects', 'soundcreations' ), 'sc_section_solpage_projects', 'solpage', array(  ) ),
		'solpage_cta' => array( __( 'Solutions: call to action', 'soundcreations' ), 'sc_section_solpage_cta', 'solpage', array( 'sol_cta_title', 'sol_cta_text' ) ),
		'projpage_hero' => array( __( 'Projects: hero', 'soundcreations' ), 'sc_section_projpage_hero', 'projpage', array( 'projects_eyebrow', 'projects_title', 'projects_lead' ) ),
		'projpage_grid' => array( __( 'Projects: filter and grid', 'soundcreations' ), 'sc_section_projpage_grid', 'projpage', array(  ) ),
		'projpage_stats' => array( __( 'Projects: stats', 'soundcreations' ), 'sc_section_projpage_stats', 'projpage', array( 'proj_stats', 'home_stat' ) ),
		'projpage_cta' => array( __( 'Projects: call to action', 'soundcreations' ), 'sc_section_projpage_cta', 'projpage', array( 'projects_cta_title', 'projects_cta_text' ) ),
		'fane_hero' => array( __( 'FANE: hero', 'soundcreations' ), 'sc_section_fane_hero', 'fane', array( 'fane_title', 'fane_lead', 'fane_hero_image' ) ),
		'fane_catalogue' => array( __( 'FANE: dealer and catalogue', 'soundcreations' ), 'sc_section_fane_catalogue', 'fane', array( 'fane_cta_title', 'fane_cta_text' ) ),
		'fane_heritage' => array( __( 'FANE: heritage', 'soundcreations' ), 'sc_section_fane_heritage', 'fane', array( 'fane_heritage_title' ) ),
		'fane_difference' => array( __( 'FANE: the difference', 'soundcreations' ), 'sc_section_fane_difference', 'fane', array( 'fane_diff_title', 'fane_diff_body' ) ),
		'fane_social' => array( __( 'FANE: social links', 'soundcreations' ), 'sc_section_fane_social', 'fane', array( 'fane_facebook', 'fane_instagram', 'fane_youtube', 'fane_tiktok', 'fane_x', 'fane_linkedin', 'fane_whatsapp', 'fane_social_title', 'fane_social_text' ) ),
		'videos_hero' => array( __( 'Videos: hero', 'soundcreations' ), 'sc_section_videos_hero', 'videos', array( 'resources_eyebrow', 'resources_title', 'resources_lead' ) ),
		'videos_videos' => array( __( 'Videos: video grid', 'soundcreations' ), 'sc_section_videos_videos', 'videos', array( 'resources_videos_title' ) ),
		'videos_downloads' => array( __( 'Videos: downloads', 'soundcreations' ), 'sc_section_videos_downloads', 'videos', array( 'resources_grid_title' ) ),
		'videos_empty' => array( __( 'Videos: empty state', 'soundcreations' ), 'sc_section_videos_empty', 'videos', array(  ) ),
		'videos_cta' => array( __( 'Videos: call to action', 'soundcreations' ), 'sc_section_videos_cta', 'videos', array( 'resources_cta_title', 'resources_cta_text' ) ),
		'contact_hero' => array( __( 'Contact: hero', 'soundcreations' ), 'sc_section_contact_hero', 'contact', array( 'contact_eyebrow', 'contact_title', 'contact_lead' ) ),
		'contact_main' => array( __( 'Contact: form and details', 'soundcreations' ), 'sc_section_contact_main', 'contact', array( 'contact_form_title', 'contact_form_sub', 'contact_info_title' ) ),
	);
}
