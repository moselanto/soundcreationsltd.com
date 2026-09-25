<?php
/**
 * Central business + content settings (Sound Creations -> Settings).
 * Writes to option 'soundcreations_settings', read by the theme via sc_setting().
 * Single source of truth for contact details AND homepage / About page copy.
 *
 * @package SoundCreationsCore
 */

if ( defined( 'ABSPATH' ) === false ) {
	exit;
}

function sc_core_settings_fields() {
	// key => array( 'Label', 'type' ). type: text | textarea | image | heading.
	return array(
		'__sec_business'       => array( 'Business details', 'heading' ),
		'company_name'         => array( 'Company name', 'text' ),
			'slogan'               => array( 'Slogan (footer)', 'text' ),
		'tagline'              => array( 'Tagline', 'text' ),
		'phone'                => array( 'Phone (display)', 'text' ),
		'phone_link'           => array( 'Phone (tel: digits, e.g. +254715754758)', 'text' ),
		'email'                => array( 'Email', 'text' ),
		'address'              => array( 'Address', 'text' ),
		'hours_week'           => array( 'Hours - weekdays', 'text' ),
		'hours_sat'            => array( 'Hours - Saturday', 'text' ),
		'hours_sun'            => array( 'Hours - Sunday', 'text' ),
		'regions'              => array( 'Regional presence line', 'text' ),
		'whatsapp'             => array( 'WhatsApp number (digits only, country code, no +)', 'text' ),
		'whatsapp_prefill'     => array( 'WhatsApp button: pre-filled greeting message', 'text' ),
		'facebook'             => array( 'Facebook URL', 'text' ),
		'x'                    => array( 'X (Twitter) URL', 'text' ),
		'linkedin'             => array( 'LinkedIn URL', 'text' ),
		'youtube'              => array( 'YouTube URL', 'text' ),
			'instagram'            => array( 'Instagram URL', 'text' ),
		'hero_video'           => array( 'Hero background video URL (MP4)', 'image' ),

		'__sec_footer'         => array( 'Footer', 'heading' ),
		'footer_about'         => array( 'About column: text', 'wysiwyg' ),
		'footer_explore'       => array( 'Explore column links (one per line: Label | URL or /path)', 'textarea' ),
		'footer_solutions'     => array( 'Solutions column links (one per line: Label | URL or /path)', 'textarea' ),
		'footer_address'       => array( 'Contact: address (one line per row)', 'textarea' ),
		'footer_hours_label'   => array( 'Contact: open-hours heading', 'text' ),
		'footer_hours'         => array( 'Contact: open hours (one line per row)', 'textarea' ),

		'__sec_home'           => array( 'Homepage content', 'heading' ),
		'home_hero_eyebrow'    => array( 'Hero: eyebrow line', 'text' ),
		'home_hero_title'      => array( 'Hero: headline', 'text' ),
		'home_hero_lead'       => array( 'Hero: intro paragraph', 'wysiwyg' ),
		'home_whatwedo_title'  => array( 'What we do: heading', 'text' ),
		'home_whatwedo_lead'   => array( 'What we do: intro', 'textarea' ),
		'home_solutions_title' => array( 'Solutions: heading', 'text' ),
		'home_projects_title'  => array( 'Featured projects: heading', 'text' ),
		'home_stat1_num'       => array( 'Proof stat 1: number', 'text' ),
		'home_stat1_label'     => array( 'Proof stat 1: label', 'text' ),
		'home_stat2_num'       => array( 'Proof stat 2: number', 'text' ),
		'home_stat2_label'     => array( 'Proof stat 2: label', 'text' ),
		'home_stat2_note'      => array( 'Proof stat 2: sub-note', 'text' ),
		'home_stat3_num'       => array( 'Proof stat 3: number', 'text' ),
		'home_stat3_label'     => array( 'Proof stat 3: label', 'text' ),
		'home_stat4_num'       => array( 'Proof stat 4: number', 'text' ),
		'home_stat4_label'     => array( 'Proof stat 4: label', 'text' ),
		'home_cta_title'       => array( 'CTA: heading', 'text' ),
		'home_cta_text'        => array( 'CTA: text', 'wysiwyg' ),

			'home_hero_cta1_label' => array( 'Hero: primary button label', 'text' ),
			'home_hero_cta1_url'   => array( 'Hero: primary button link (path or URL)', 'text' ),
			'home_hero_cta2_label' => array( 'Hero: secondary button label', 'text' ),
			'home_hero_cta2_url'   => array( 'Hero: secondary button link (path or URL)', 'text' ),
			'home_whatwedo_eyebrow'=> array( 'What we do: eyebrow', 'text' ),
			'home_steps'           => array( 'Process steps (one per line: Title | Description)', 'textarea' ),
			'home_solutions_eyebrow'=> array( 'Solutions: eyebrow', 'text' ),
			'home_partners_label'  => array( 'Partners strip: label', 'text' ),
			'home_projects_eyebrow'=> array( 'Featured projects: eyebrow', 'text' ),
		'__sec_home_images'    => array( 'Homepage images', 'heading' ),
		'home_hero_poster'     => array( 'Hero: poster image (shown before video loads)', 'image' ),
		'home_svc1_img'        => array( 'What we do - Consultancy: photo', 'image' ),
		'home_svc2_img'        => array( 'What we do - Distribution & Dealership: photo', 'image' ),
		'home_svc3_img'        => array( 'What we do - Integration: photo', 'image' ),
		'home_svc4_img'        => array( 'What we do - After-Sale Services: photo', 'image' ),
		'home_sol1_img'        => array( 'Solutions - Professional Audio: photo', 'image' ),
		'home_sol2_img'        => array( 'Solutions - Acoustics: photo', 'image' ),
		'home_sol3_img'        => array( 'Solutions - Sound & Acoustic Integration: photo', 'image' ),
		'home_cta_image'       => array( 'Closing CTA band: background photo', 'image' ),

		'__sec_about'          => array( 'About page content', 'heading' ),
		'about_hero_eyebrow'   => array( 'About hero: eyebrow', 'text' ),
		'about_hero_title'     => array( 'About hero: headline', 'text' ),
		'about_hero_lead'      => array( 'About hero: intro', 'textarea' ),
		'about_stat1_num'      => array( 'About stat 1: number', 'text' ),
		'about_stat1_label'    => array( 'About stat 1: label', 'text' ),
		'about_stat2_num'      => array( 'About stat 2: number', 'text' ),
		'about_stat2_label'    => array( 'About stat 2: label', 'text' ),
		'about_stat3_head'     => array( 'About stat 3: heading', 'text' ),
		'about_stat3_sub'      => array( 'About stat 3: sub', 'text' ),
		'about_stat4_head'     => array( 'About stat 4: heading', 'text' ),
		'about_stat4_sub'      => array( 'About stat 4: sub', 'text' ),
		'about_journey_eyebrow'=> array( 'Journey: eyebrow', 'text' ),
		'about_journey_title'  => array( 'Journey: heading', 'text' ),
		'about_journey_p1'     => array( 'Journey: paragraph 1', 'wysiwyg' ),
		'about_journey_p2'     => array( 'Journey: paragraph 2', 'wysiwyg' ),
		'about_story_label'    => array( 'Story card: label', 'text' ),
			'about_hero_image'     => array( 'About hero: photo (upload to Media, paste URL)', 'image' ),
		'about_story_video'    => array( 'Story card: YouTube video URL (paste full link)', 'image' ),
		'about_exp_eyebrow'    => array( 'Expertise: eyebrow', 'text' ),
		'about_exp_title'      => array( 'Expertise: heading', 'text' ),
		'about_exp_intro'      => array( 'Expertise: intro', 'wysiwyg' ),
		'about_exp_items'      => array( 'Expertise cards (one per line: Title | Description)', 'textarea' ),
		// Our Work Process, the four-step row that replaced the "What We Do" grid on
		// the About page. Deliberately NOT reusing about_exp_eyebrow: that key has a
		// default in sc_default_settings() and was written into the saved option by
		// the one-shot prefill pass, and sc_setting() prefers a stored value, so new
		// copy on it would have been silently overridden by the stored "What We Do".
		'about_process_eyebrow' => array( 'Work process: eyebrow', 'text' ),
		'about_process_items'  => array( 'Work process steps (one per line: Title | Description | Link path, e.g. /service/consultancy/)', 'textarea' ),
		'about_operate_eyebrow'=> array( 'Where we operate: eyebrow', 'text' ),
		'about_operate_title'  => array( 'Where we operate: heading', 'text' ),
		'about_operate_body'   => array( 'Where we operate: body', 'textarea' ),
		'about_partners_eyebrow'=> array( 'Partners: eyebrow', 'text' ),
		'about_partners_title' => array( 'Partners: heading', 'text' ),
		'about_cta_title'      => array( 'About CTA: heading', 'text' ),
		'about_cta_text'       => array( 'About CTA: text', 'textarea' ),

			'__sec_downloads'      => array( 'Company profiles (downloads)', 'heading' ),
			'profiles_eyebrow'     => array( 'Profiles: eyebrow', 'text' ),
			'profiles_title'       => array( 'Profiles: heading', 'text' ),
			'profiles_intro'       => array( 'Profiles: intro', 'wysiwyg' ),
			'company_profile_url'  => array( 'Company Profile: PDF URL (upload to Media, paste link)', 'image' ),
			'company_profile_desc' => array( 'Company Profile: description', 'wysiwyg' ),

			'__sec_solutions'      => array( 'Solutions page content', 'heading' ),
			'sol_hero_title'       => array( 'Solutions hero: headline', 'text' ),
			'sol_hero_lead'        => array( 'Solutions hero: intro', 'wysiwyg' ),
			'sol_solutions_title'  => array( 'Solutions: section heading', 'text' ),
			'sol_process_title'    => array( 'Process: heading', 'text' ),
			'sol_sectors_title'    => array( 'Who we work with: heading', 'text' ),
			'sol_sectors'          => array( 'Who we work with: sectors (one per line)', 'textarea' ),
			'sol_support_title'    => array( 'End-to-end support: heading', 'text' ),
			'sol_support_text'     => array( 'End-to-end support: text', 'textarea' ),
			'sol_support_points'   => array( 'End-to-end support: checklist (one per line)', 'textarea' ),
			'sol_support_cta'      => array( 'End-to-end support: button label', 'text' ),
			'sol_about_title'      => array( 'About Sound Creations: heading', 'text' ),
			'sol_about_items'      => array( 'About Sound Creations cards (one per line: Title | Description)', 'textarea' ),
			'sol_cta_title'        => array( 'Solutions CTA: heading', 'text' ),
			'sol_cta_text'         => array( 'Solutions CTA: text', 'wysiwyg' ),

			'__sec_contact'        => array( 'Contact / About page content', 'heading' ),
			'contact_eyebrow'      => array( 'Contact hero: eyebrow', 'text' ),
			'contact_title'        => array( 'Contact hero: headline', 'text' ),
			'contact_lead'         => array( 'Contact hero: intro', 'wysiwyg' ),
			'contact_offices_title'=> array( 'Offices: heading', 'text' ),
			'contact_cta_title'    => array( 'Contact CTA: heading', 'text' ),
			'contact_cta_text'     => array( 'Contact CTA: text', 'textarea' ),
			'__sec_projectspage'   => array( 'Projects page', 'heading' ),
			'projects_eyebrow'     => array( 'Projects hero: eyebrow', 'text' ),
			'projects_title'       => array( 'Projects hero: headline', 'text' ),
			'projects_lead'        => array( 'Projects hero: intro', 'wysiwyg' ),
			'proj_stats'           => array( 'Projects stats (one per line: Number | Label | Sub-note)', 'textarea' ),
			'projects_cta_title'   => array( 'Projects CTA: heading', 'text' ),
			'projects_cta_text'    => array( 'Projects CTA: text', 'wysiwyg' ),

			'__sec_fane_content'   => array( 'FANE page - content', 'heading' ),
			'fane_eyebrow'         => array( 'FANE hero: eyebrow line', 'text' ),
			'fane_title'           => array( 'FANE hero: headline', 'text' ),
			'fane_lead'            => array( 'FANE hero: intro paragraph', 'wysiwyg' ),
			'fane_hero_image'      => array( 'FANE hero: photo (upload to Media, paste URL)', 'image' ),
			'fane_diff_title'      => array( 'FANE "difference" section: heading', 'text' ),
			'fane_diff_body'       => array( 'FANE "difference" section: text', 'wysiwyg' ),
			'fane_heritage_title'  => array( 'FANE heritage section: heading', 'text' ),
			'fane_products_title'  => array( 'FANE product-range section: heading', 'text' ),
			'fane_products_url'    => array( 'FANE product-range button: link (path or URL)', 'text' ),
			'fane_apps_url'        => array( 'FANE applications button: link (path or URL)', 'text' ),
			'fane_cta_title'       => array( 'FANE bottom banner: heading', 'text' ),
			'fane_cta_text'        => array( 'FANE bottom banner: text', 'wysiwyg' ),
			'fane_catalogue_url'   => array( 'FANE catalogue PDF - the Download Catalogue button shows only when this is set (Select file to upload, or paste a link)', 'image' ),

			'fane_info'            => array( 'FANE information block: rich content shown on the FANE page below the hero. Use headings, bold, lists and links.', 'wysiwyg' ),
				'__sec_fane'           => array( 'FANE page - social links', 'heading' ),
			'fane_social_title'    => array( 'FANE social bar: heading', 'text' ),
			'fane_social_text'     => array( 'FANE social bar: sub-text', 'textarea' ),
			'fane_facebook'        => array( 'FANE Facebook URL (blank = company Facebook)', 'text' ),
			'fane_instagram'       => array( 'FANE Instagram URL (blank = company Instagram)', 'text' ),
			'fane_youtube'         => array( 'FANE YouTube URL (blank = company YouTube)', 'text' ),
			'fane_tiktok'          => array( 'FANE TikTok URL', 'text' ),
			'fane_x'               => array( 'FANE X (Twitter) URL (blank = company X)', 'text' ),
			'fane_linkedin'        => array( 'FANE LinkedIn URL (blank = company LinkedIn)', 'text' ),
			'fane_whatsapp'        => array( 'FANE WhatsApp number, digits only (blank = company WhatsApp)', 'text' ),

			'__sec_resources'         => array( 'Resources / Videos page', 'heading' ),
			'resources_eyebrow'       => array( 'Resources hero: eyebrow', 'text' ),
			'resources_title'         => array( 'Resources hero: headline', 'text' ),
			'resources_lead'          => array( 'Resources hero: intro', 'wysiwyg' ),
			'resources_videos_title'  => array( 'Videos section: heading', 'text' ),
			'resources_grid_title'    => array( 'Downloads section: heading', 'text' ),
			'resources_cta_title'     => array( 'Resources CTA: heading', 'text' ),
			'resources_cta_text'      => array( 'Resources CTA: text', 'wysiwyg' ),
	);
}

add_action(
	'admin_menu',
	function () {
		add_menu_page( 'Sound Creations', 'Sound Creations', 'manage_options', 'sc-settings', 'sc_core_render_settings_page', 'dashicons-format-audio', 58 );
		add_submenu_page( 'sc-settings', 'Settings', 'Settings', 'manage_options', 'sc-settings', 'sc_core_render_settings_page' );
	}
);

add_action(
	'admin_init',
	function () {
		register_setting(
			'sc_settings_group',
			'soundcreations_settings',
			array(
				'type'              => 'array',
				'sanitize_callback' => 'sc_core_sanitize_settings',
				'default'           => array(),
			)
		);
	}
);

function sc_core_sanitize_settings( $input ) {
	$clean = array();
	foreach ( sc_core_settings_fields() as $key => $def ) {
		$type = isset( $def[1] ) ? $def[1] : 'text';
		if ( 'heading' === $type ) {
			continue;
		}
		if ( isset( $input[ $key ] ) === false ) {
			continue;
		}
		$val = trim( (string) $input[ $key ] );
		if ( in_array( $key, array( 'facebook', 'x', 'linkedin', 'youtube', 'instagram', 'fane_facebook', 'fane_x', 'fane_linkedin', 'fane_youtube', 'fane_instagram', 'fane_tiktok' ), true ) || 'image' === $type ) {
			$clean[ $key ] = esc_url_raw( $val );
		} elseif ( 'email' === $key ) {
			$clean[ $key ] = sanitize_email( $val );
		} elseif ( 'wysiwyg' === $type ) {
				$clean[ $key ] = wp_kses_post( $val );
			} elseif ( 'textarea' === $type ) {
			$clean[ $key ] = sanitize_textarea_field( $val );
		} else {
			$clean[ $key ] = sanitize_text_field( $val );
		}
	}
	return $clean;
}

function sc_core_render_settings_page() {
	if ( current_user_can( 'manage_options' ) === false ) {
		return;
	}
	$opts     = get_option( 'soundcreations_settings', array() );
	$defaults = function_exists( 'sc_default_settings' ) ? sc_default_settings() : array();
	?>
	<div class="wrap">
		<h1>Sound Creations - Central Settings</h1>
		<p>Everything here feeds the live site: header, footer, contact details, and the homepage and About page copy. Update once and every template follows. Leave a field blank to use the built-in default (shown as grey placeholder text).</p>
		<form method="post" action="options.php">
			<?php settings_fields( 'sc_settings_group' ); ?>
			<table class="form-table" role="presentation"><tbody>
			<?php
			foreach ( sc_core_settings_fields() as $key => $def ) {
				$label = isset( $def[0] ) ? $def[0] : $key;
				$type  = isset( $def[1] ) ? $def[1] : 'text';
				if ( 'heading' === $type ) {
					printf( '<tr><th colspan="2" style="padding:26px 0 0;"><h2 style="margin:0;border-bottom:1px solid #dcdcde;padding-bottom:6px;">%s</h2></th></tr>', esc_html( $label ) );
					continue;
				}
				$value       = isset( $opts[ $key ] ) ? $opts[ $key ] : '';
				$placeholder = isset( $defaults[ $key ] ) ? $defaults[ $key ] : '';
				if ( 'textarea' === $type ) {
					printf(
						'<tr><th scope="row"><label for="sc_%1$s">%2$s</label></th><td><textarea id="sc_%1$s" name="soundcreations_settings[%1$s]" rows="3" class="large-text" placeholder="%4$s">%3$s</textarea></td></tr>',
						esc_attr( $key ),
						esc_html( $label ),
						esc_textarea( $value ),
						esc_attr( $placeholder )
					);
				} elseif ( 'wysiwyg' === $type ) {
						echo '<tr><th scope="row"><label for="sc_' . esc_attr( $key ) . '">' . esc_html( $label ) . '</label></th><td>';
						if ( strlen( (string) $value ) === 0 && strlen( (string) $placeholder ) > 0 ) {
							echo '<p class="description" style="margin:0 0 6px;color:#646970;">Shown on the live page if left blank: ' . esc_html( wp_strip_all_tags( (string) $placeholder ) ) . '</p>';
						}
						wp_editor(
							(string) $value,
							'sc_' . $key,
							array(
								'textarea_name' => 'soundcreations_settings[' . $key . ']',
								'media_buttons' => false,
								'textarea_rows' => 6,
								'teeny'         => true,
								'quicktags'     => true,
							)
						);
						echo '</td></tr>';
					} elseif ( 'image' === $type ) {
					$sc_is_img = ( substr( $key, -4 ) === '_img' ) || in_array( $key, array( 'home_hero_poster', 'home_cta_image', 'about_hero_image', 'fane_hero_image' ), true );
					$sc_mtype  = $sc_is_img ? 'image' : '';
					$sc_btn    = $sc_is_img ? 'Select image' : 'Select file';
					$sc_prev   = '';
					if ( strlen( (string) $value ) > 0 ) {
						if ( preg_match( '/[.](jpe?g|png|webp|gif|svg|avif)([?].*)?$/i', $value ) === 1 ) {
							$sc_prev = '<img src="' . esc_url( $value ) . '" alt="" style="max-width:190px;height:auto;border-radius:8px;margin-top:8px;display:block;border:1px solid #dcdcde;">';
						} else {
							$sc_prev = '<code style="display:inline-block;margin-top:8px;word-break:break-all;">' . esc_html( $value ) . '</code>';
						}
					}
					printf(
						'<tr><th scope="row"><label for="sc_%1$s">%2$s</label></th><td><div class="sc-media-field" data-sc-media-type="%5$s"><input type="text" id="sc_%1$s" name="soundcreations_settings[%1$s]" value="%3$s" placeholder="%4$s" class="regular-text sc-media-url" style="width:26rem;max-width:100%%;"> <button type="button" class="button sc-media-pick">%6$s</button> <button type="button" class="button sc-media-clear">Remove</button><div class="sc-media-prev">%7$s</div></div></td></tr>',
						esc_attr( $key ),
						esc_html( $label ),
						esc_attr( $value ),
						esc_attr( $placeholder ),
						esc_attr( $sc_mtype ),
						esc_html( $sc_btn ),
						$sc_prev
					);
				} else {
					printf(
						'<tr><th scope="row"><label for="sc_%1$s">%2$s</label></th><td><input type="text" id="sc_%1$s" name="soundcreations_settings[%1$s]" value="%3$s" placeholder="%4$s" class="regular-text" style="width:34rem;max-width:100%%;"></td></tr>',
						esc_attr( $key ),
						esc_html( $label ),
						esc_attr( $value ),
						esc_attr( $placeholder )
					);
				}
			}
			?>
			</tbody></table>
			<?php submit_button( 'Save settings' ); ?>
		</form>
	</div>
	<?php
}


add_action(
	'admin_enqueue_scripts',
	function ( $hook ) {
		if ( 'toplevel_page_sc-settings' === $hook ) {
			wp_enqueue_media();
			wp_enqueue_script(
				'sc-admin-media',
				plugins_url( 'assets/admin-media.js', dirname( __DIR__ ) . '/sound-creations-core.php' ),
				array( 'jquery' ),
				'1.0.0',
				true
			);
		}
	}
);

/**
 * One-time: promote the built-in defaults into the saved settings so every field
 * on the Central Settings screen shows real, editable content instead of an
 * empty box with grey placeholder text.
 *
 * Output-safe by construction. sc_setting() already falls back to exactly these
 * strings, so writing them into the option cannot change a single pixel on the
 * live site -- it only makes the values visible and editable in wp-admin, which
 * is the whole point. The screen's "leave blank to use the default" behaviour
 * still works for anything cleared afterwards.
 *
 * Three guards, in order:
 *  - the key must be a real editable field on the screen (headings skipped), so
 *    stray defaults never become phantom rows;
 *  - the default must be non-empty, so no field is filled with invented copy;
 *  - any value the team has already typed always wins and is never overwritten.
 *
 * @return int Number of fields filled.
 */
function sc_core_prefill_settings_from_defaults() {
	if ( function_exists( 'sc_default_settings' ) === false ) {
		return 0;
	}
	$sc_defaults = sc_default_settings();
	if ( is_array( $sc_defaults ) === false ) {
		return 0;
	}
	$sc_fields = sc_core_settings_fields();
	$sc_opts   = get_option( 'soundcreations_settings', array() );
	if ( is_array( $sc_opts ) === false ) {
		$sc_opts = array();
	}
	$sc_filled = 0;
	foreach ( $sc_defaults as $sc_key => $sc_val ) {
		if ( isset( $sc_fields[ $sc_key ] ) === false ) {
			continue;
		}
		$sc_type = isset( $sc_fields[ $sc_key ][1] ) ? $sc_fields[ $sc_key ][1] : 'text';
		if ( 'heading' === $sc_type ) {
			continue;
		}
		if ( strlen( trim( (string) $sc_val ) ) === 0 ) {
			continue;
		}
		$sc_cur = isset( $sc_opts[ $sc_key ] ) ? (string) $sc_opts[ $sc_key ] : '';
		if ( strlen( trim( $sc_cur ) ) > 0 ) {
			continue;
		}
		$sc_opts[ $sc_key ] = $sc_val;
		$sc_filled++;
	}
	if ( $sc_filled > 0 ) {
		update_option( 'soundcreations_settings', $sc_opts );
	}
	return $sc_filled;
}

// Runs once, on its own flag, at priority 12 so it lands after the theme has
// registered sc_default_settings() and after the catalog seeder.
add_action(
	'admin_init',
	function () {
		if ( '1' === get_option( 'sc_core_settings_prefilled' ) ) {
			return;
		}
		if ( current_user_can( 'manage_options' ) === false ) {
			return;
		}
		if ( function_exists( 'sc_default_settings' ) === false ) {
			return;
		}
		sc_core_prefill_settings_from_defaults();
		update_option( 'sc_core_settings_prefilled', '1', false );
	},
	12
);
