<?php
/**
 * Elementor widget classes. Loaded only from the elementor/widgets/register
 * hook (inc/elementor/widgets.php), so \Elementor\Widget_Base always exists.
 *
 * @package SoundCreations
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

/**
 * All widget classes to register.
 *
 * @return string[]
 */
function sc_el_widget_class_names() {
	$sc_names = array();
	// One widget per section (homepage and every other page), generated below.
	foreach ( array_keys( sc_sections() ) as $sc_k ) {
		$sc_names[] = 'SC_EW_S_' . $sc_k;
	}
	return array_merge(
		$sc_names,
		array(
			'SC_EW_Page_Banner',
			'SC_EW_Event',
			'SC_EW_Enquiry_Form',
			'SC_EW_Logo',
			'SC_EW_Menu',
			'SC_EW_Contact',
			'SC_EW_Social',
			'SC_EW_Consult_Button',
		)
	);
}

/**
 * Shared base: category, keywords.
 */
abstract class SC_EW_Base extends Widget_Base {
	/** @return string[] */
	public function get_categories() {
		return array( 'soundcreations' );
	}
	/** @return string[] */
	public function get_keywords() {
		return array( 'sound creations', 'section' );
	}
}

/**
 * A homepage section as a widget. Subclasses set $sc_section only.
 */
abstract class SC_EW_Section extends SC_EW_Base {
	/** @var string Section slug from sc_sections(). */
	protected $sc_section = '';

	public function get_name() {
		return 'sc_section_' . $this->sc_section;
	}

	public function get_title() {
		$all = sc_sections();
		return isset( $all[ $this->sc_section ] ) ? $all[ $this->sc_section ][0] : $this->sc_section;
	}

	public function get_icon() {
		return 'eicon-section';
	}

	protected function register_controls() {
		$fields = sc_el_fields_for( $this->sc_section );
		$this->start_controls_section(
			'sc_content',
			array(
				'label' => __( 'Content', 'soundcreations' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			)
		);
		$this->add_control(
			'sc_note',
			array(
				'type'            => Controls_Manager::RAW_HTML,
				'raw'             => esc_html__( 'Leave a box empty to use the wording from Sound Creations > Settings. Text typed here changes this placement only.', 'soundcreations' ),
				'content_classes' => 'elementor-descriptor',
			)
		);
		foreach ( $fields as $key => $def ) {
			if ( 'image' === $def[1] ) {
				$this->add_control( $key, array( 'label' => $def[0], 'type' => Controls_Manager::MEDIA ) );
			} else {
				$this->add_control(
					$key,
					array(
						'label'       => $def[0],
						'type'        => 'textarea' === $def[1] ? Controls_Manager::TEXTAREA : Controls_Manager::TEXT,
						'placeholder' => wp_strip_all_tags( (string) sc_setting( $key, '' ) ),
						'label_block' => true,
					)
				);
			}
		}
		$this->end_controls_section();
	}

	protected function render() {
		$fields    = sc_el_fields_for( $this->sc_section );
		$settings  = $this->get_settings_for_display();
		$overrides = array();
		foreach ( $fields as $key => $def ) {
			if ( ! isset( $settings[ $key ] ) ) {
				continue;
			}
			if ( 'image' === $def[1] ) {
				$url = is_array( $settings[ $key ] ) && ! empty( $settings[ $key ]['url'] ) ? (string) $settings[ $key ]['url'] : '';
				// Elementor's MEDIA default is its placeholder image; never let that through.
				if ( '' !== $url && false === strpos( $url, 'placeholder' ) ) {
					$overrides[ $key ] = esc_url_raw( $url );
				}
			} elseif ( '' !== trim( (string) $settings[ $key ] ) ) {
				$overrides[ $key ] = 'textarea' === $def[1] ? wp_kses_post( (string) $settings[ $key ] ) : sanitize_text_field( (string) $settings[ $key ] );
			}
		}
		echo sc_render_section( $this->sc_section, $overrides ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped inside the section.
	}
}

// Generated: one widget class per section key in sc_sections().
final class SC_EW_S_services extends SC_EW_Section {
	protected $sc_section = 'services';
}
final class SC_EW_S_solutions extends SC_EW_Section {
	protected $sc_section = 'solutions';
}
final class SC_EW_S_partners extends SC_EW_Section {
	protected $sc_section = 'partners';
}
final class SC_EW_S_work extends SC_EW_Section {
	protected $sc_section = 'work';
}
final class SC_EW_S_stats extends SC_EW_Section {
	protected $sc_section = 'stats';
}
final class SC_EW_S_testimonials extends SC_EW_Section {
	protected $sc_section = 'testimonials';
}
final class SC_EW_S_cta extends SC_EW_Section {
	protected $sc_section = 'cta';
}
final class SC_EW_S_about_hero extends SC_EW_Section {
	protected $sc_section = 'about_hero';
}
final class SC_EW_S_about_process extends SC_EW_Section {
	protected $sc_section = 'about_process';
}
final class SC_EW_S_about_brands extends SC_EW_Section {
	protected $sc_section = 'about_brands';
}
final class SC_EW_S_about_company extends SC_EW_Section {
	protected $sc_section = 'about_company';
}
final class SC_EW_S_about_profiles extends SC_EW_Section {
	protected $sc_section = 'about_profiles';
}
final class SC_EW_S_solpage_hero extends SC_EW_Section {
	protected $sc_section = 'solpage_hero';
}
final class SC_EW_S_solpage_grid extends SC_EW_Section {
	protected $sc_section = 'solpage_grid';
}
final class SC_EW_S_solpage_sectors extends SC_EW_Section {
	protected $sc_section = 'solpage_sectors';
}
final class SC_EW_S_solpage_projects extends SC_EW_Section {
	protected $sc_section = 'solpage_projects';
}
final class SC_EW_S_solpage_cta extends SC_EW_Section {
	protected $sc_section = 'solpage_cta';
}
final class SC_EW_S_projpage_hero extends SC_EW_Section {
	protected $sc_section = 'projpage_hero';
}
final class SC_EW_S_projpage_grid extends SC_EW_Section {
	protected $sc_section = 'projpage_grid';
}
final class SC_EW_S_projpage_stats extends SC_EW_Section {
	protected $sc_section = 'projpage_stats';
}
final class SC_EW_S_projpage_cta extends SC_EW_Section {
	protected $sc_section = 'projpage_cta';
}
final class SC_EW_S_fane_hero extends SC_EW_Section {
	protected $sc_section = 'fane_hero';
}
final class SC_EW_S_fane_catalogue extends SC_EW_Section {
	protected $sc_section = 'fane_catalogue';
}
final class SC_EW_S_fane_heritage extends SC_EW_Section {
	protected $sc_section = 'fane_heritage';
}
final class SC_EW_S_fane_difference extends SC_EW_Section {
	protected $sc_section = 'fane_difference';
}
final class SC_EW_S_fane_social extends SC_EW_Section {
	protected $sc_section = 'fane_social';
}
final class SC_EW_S_videos_hero extends SC_EW_Section {
	protected $sc_section = 'videos_hero';
}
final class SC_EW_S_videos_videos extends SC_EW_Section {
	protected $sc_section = 'videos_videos';
}
final class SC_EW_S_videos_downloads extends SC_EW_Section {
	protected $sc_section = 'videos_downloads';
}
final class SC_EW_S_videos_empty extends SC_EW_Section {
	protected $sc_section = 'videos_empty';
}
final class SC_EW_S_videos_cta extends SC_EW_Section {
	protected $sc_section = 'videos_cta';
}
final class SC_EW_S_contact_hero extends SC_EW_Section {
	protected $sc_section = 'contact_hero';
}
final class SC_EW_S_contact_main extends SC_EW_Section {
	protected $sc_section = 'contact_main';
}

/**
 * Page banner: the same hero band the Solutions and Videos pages use
 * (.sc-support-hero), for any Elementor page. Title defaults to the page title.
 */
final class SC_EW_Page_Banner extends SC_EW_Base {
	public function get_name() {
		return 'sc_page_banner';
	}
	public function get_title() {
		return __( 'Page banner', 'soundcreations' );
	}
	public function get_icon() {
		return 'eicon-header';
	}
	protected function register_controls() {
		$this->start_controls_section( 'sc_content', array( 'label' => __( 'Banner', 'soundcreations' ) ) );
		$this->add_control( 'eyebrow', array( 'label' => __( 'Eyebrow', 'soundcreations' ), 'type' => Controls_Manager::TEXT, 'label_block' => true ) );
		$this->add_control( 'title', array( 'label' => __( 'Heading (empty = page title)', 'soundcreations' ), 'type' => Controls_Manager::TEXT, 'label_block' => true ) );
		$this->add_control( 'lead', array( 'label' => __( 'Intro', 'soundcreations' ), 'type' => Controls_Manager::TEXTAREA ) );
		$this->add_control( 'image', array( 'label' => __( 'Background photo', 'soundcreations' ), 'type' => Controls_Manager::MEDIA ) );
		$this->add_control(
			'tag',
			array(
				'label'   => __( 'Heading level', 'soundcreations' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h1',
				'options' => array(
					'h1' => 'H1',
					'h2' => 'H2',
				),
			)
		);
		$this->add_control(
			'crumb',
			array(
				'label'        => __( 'Show breadcrumb', 'soundcreations' ),
				'type'         => Controls_Manager::SWITCHER,
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);
		$this->add_control( 'btn_label', array( 'label' => __( 'Button label (optional)', 'soundcreations' ), 'type' => Controls_Manager::TEXT ) );
		$this->add_control( 'btn_link', array( 'label' => __( 'Button link', 'soundcreations' ), 'type' => Controls_Manager::URL ) );
		$this->end_controls_section();
	}
	protected function render() {
		$s     = $this->get_settings_for_display();
		$title = trim( (string) ( isset( $s['title'] ) ? $s['title'] : '' ) );
		if ( '' === $title ) {
			$title = (string) get_the_title( get_queried_object_id() );
		}
		$img = '';
		if ( ! empty( $s['image']['url'] ) && false === strpos( (string) $s['image']['url'], 'placeholder' ) ) {
			$img = (string) $s['image']['url'];
		}
		$tag = ( isset( $s['tag'] ) && 'h2' === $s['tag'] ) ? 'h2' : 'h1';
		echo '<section class="sc-support-hero sc-el-banner"' . ( '' !== $img ? ' style="background-image:url(\'' . esc_url( $img ) . '\');"' : '' ) . '>';
		echo '<span class="sc-support-hero__scrim" aria-hidden="true"></span><div class="sc-container sc-support-hero__inner">';
		if ( isset( $s['crumb'] ) && 'yes' === $s['crumb'] ) {
			echo '<nav class="sc-crumb" aria-label="' . esc_attr__( 'Breadcrumb', 'soundcreations' ) . '"><a href="' . esc_url( home_url( '/' ) ) . '">' . esc_html__( 'Home', 'soundcreations' ) . '</a> <span aria-hidden="true">&rsaquo;</span> <span class="sc-crumb__cur">' . esc_html( $title ) . '</span></nav>';
		}
		if ( ! empty( $s['eyebrow'] ) ) {
			echo '<p class="sc-eyebrow">' . esc_html( (string) $s['eyebrow'] ) . '</p>';
		}
		echo '<' . $tag . ' class="sc-support-hero__title">' . esc_html( $title ) . '</' . $tag . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- $tag is h1 or h2 only.
		if ( ! empty( $s['lead'] ) ) {
			echo '<p class="sc-lead sc-support-hero__lead">' . esc_html( (string) $s['lead'] ) . '</p>';
		}
		if ( ! empty( $s['btn_label'] ) && ! empty( $s['btn_link']['url'] ) ) {
			$ext = ! empty( $s['btn_link']['is_external'] );
			echo '<p><a class="sc-btn sc-btn--primary" href="' . esc_url( (string) $s['btn_link']['url'] ) . '"' . ( $ext ? ' target="_blank" rel="noopener noreferrer"' : '' ) . '>' . esc_html( (string) $s['btn_label'] ) . '</a></p>';
		}
		echo '</div></section>';
	}
}

/**
 * Featured event (Settings -> Featured event). Renders nothing once it ends.
 */
final class SC_EW_Event extends SC_EW_Base {
	public function get_name() {
		return 'sc_event';
	}
	public function get_title() {
		return __( 'Featured event', 'soundcreations' );
	}
	public function get_icon() {
		return 'eicon-calendar';
	}
	protected function register_controls() {
		$this->start_controls_section( 'sc_content', array( 'label' => __( 'Event', 'soundcreations' ) ) );
		$this->add_control(
			'sc_h',
			array(
				'label'   => __( 'Event name heading', 'soundcreations' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'h2',
				'options' => array(
					'h1' => 'H1 (event page)',
					'h2' => 'H2',
				),
			)
		);
		$this->add_control(
			'sc_note',
			array(
				'type' => Controls_Manager::RAW_HTML,
				'raw'  => esc_html__( 'Details come from Sound Creations > Settings > Featured event.', 'soundcreations' ),
			)
		);
		$this->end_controls_section();
	}
	protected function render() {
		if ( ! function_exists( 'sc_event_feature_html' ) ) {
			return;
		}
		$s = $this->get_settings_for_display();
		echo sc_event_feature_html( 'elementor', isset( $s['sc_h'] ) ? $s['sc_h'] : 'h2' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escaped while building.
	}
}

/**
 * Embeds a hand-coded enquiry form. Never rebuilds it: the form, anti-spam,
 * routing and storage all stay in sound-creations-enquiries.
 */
final class SC_EW_Enquiry_Form extends SC_EW_Base {
	public function get_name() {
		return 'sc_enquiry_form';
	}
	public function get_title() {
		return __( 'Enquiry form', 'soundcreations' );
	}
	public function get_icon() {
		return 'eicon-form-horizontal';
	}
	protected function register_controls() {
		$types = array();
		if ( function_exists( 'sc_enq_forms' ) ) {
			foreach ( sc_enq_forms() as $k => $f ) {
				$types[ $k ] = isset( $f['title'] ) ? (string) $f['title'] : ucfirst( (string) $k );
			}
		}
		if ( ! $types ) {
			$types = array( 'consultation' => 'Consultation' );
		}
		$this->start_controls_section( 'sc_content', array( 'label' => __( 'Form', 'soundcreations' ) ) );
		$this->add_control(
			'type',
			array(
				'label'   => __( 'Form', 'soundcreations' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'consultation',
				'options' => $types,
			)
		);
		$this->add_control(
			'title',
			array(
				'label'       => __( 'Heading (optional)', 'soundcreations' ),
				'type'        => Controls_Manager::TEXT,
				'label_block' => true,
			)
		);
		$this->end_controls_section();
	}
	protected function render() {
		$s = $this->get_settings_for_display();
		if ( ! shortcode_exists( 'sc_enquiry_form' ) ) {
			return;
		}
		echo do_shortcode( '[sc_enquiry_form type="' . esc_attr( sanitize_key( (string) $s['type'] ) ) . '" title="' . esc_attr( sanitize_text_field( (string) $s['title'] ) ) . '"]' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- form plugin escapes its own markup.
	}
}

/* -------------------------------------------------------------------------
 * Header / footer building blocks
 * ---------------------------------------------------------------------- */

abstract class SC_EW_Block extends SC_EW_Base {
	public function get_keywords() {
		return array( 'sound creations', 'header', 'footer' );
	}
}

final class SC_EW_Logo extends SC_EW_Block {
	public function get_name() {
		return 'sc_logo';
	}
	public function get_title() {
		return __( 'Site logo', 'soundcreations' );
	}
	public function get_icon() {
		return 'eicon-site-logo';
	}
	protected function render() {
		// Same two-logo markup as header.php: CSS shows the right one per theme.
		echo '<a href="' . esc_url( home_url( '/' ) ) . '" class="sc-logo" rel="home">'
			. '<img class="sc-logo__img sc-logo__img--dark" src="' . esc_url( sc_logo_url( 'dark' ) ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" width="309" height="115">'
			. '<img class="sc-logo__img sc-logo__img--light" src="' . esc_url( sc_logo_url( 'light' ) ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" width="309" height="115">'
			. '</a>';
	}
}

/**
 * Primary menu with the theme's own drawer markup and toggle, so theme.js
 * (data-sc-menu-toggle / data-sc-menu-close) drives it exactly as in the
 * built-in header. Use once per page.
 */
final class SC_EW_Menu extends SC_EW_Block {
	public function get_name() {
		return 'sc_menu';
	}
	public function get_title() {
		return __( 'Primary menu', 'soundcreations' );
	}
	public function get_icon() {
		return 'eicon-nav-menu';
	}
	protected function render() {
		echo '<nav class="sc-nav" id="sc-primary-nav" aria-label="' . esc_attr__( 'Primary', 'soundcreations' ) . '">';
		echo '<div class="sc-nav__head"><span class="sc-nav__title">' . esc_html__( 'Menu', 'soundcreations' ) . '</span><button class="sc-nav__close" type="button" data-sc-menu-close aria-label="' . esc_attr__( 'Close menu', 'soundcreations' ) . '">&times;</button></div>';
		if ( has_nav_menu( 'primary' ) ) {
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'container'      => false,
					'menu_class'     => 'sc-nav__list',
					'depth'          => 2,
				)
			);
		} elseif ( function_exists( 'sc_primary_menu_fallback' ) ) {
			sc_primary_menu_fallback();
		}
		echo '</nav>';
		echo '<button class="sc-menu-toggle" type="button" data-sc-menu-toggle aria-expanded="false" aria-controls="sc-primary-nav" aria-label="' . esc_attr__( 'Menu', 'soundcreations' ) . '">&#9776;</button>';
		echo '<div class="sc-nav-scrim" data-sc-menu-close aria-hidden="true"></div>';
	}
}

final class SC_EW_Contact extends SC_EW_Block {
	public function get_name() {
		return 'sc_contact';
	}
	public function get_title() {
		return __( 'Phone & email', 'soundcreations' );
	}
	public function get_icon() {
		return 'eicon-headphones';
	}
	protected function render() {
		echo '<div class="sc-el-contact"><a href="tel:' . esc_attr( sc_setting( 'phone_link' ) ) . '">' . esc_html( sc_setting( 'phone' ) ) . '</a> <span aria-hidden="true">&middot;</span> <a href="mailto:' . esc_attr( sc_setting( 'email' ) ) . '">' . esc_html( sc_setting( 'email' ) ) . '</a></div>';
	}
}

final class SC_EW_Social extends SC_EW_Block {
	public function get_name() {
		return 'sc_social';
	}
	public function get_title() {
		return __( 'Social icons', 'soundcreations' );
	}
	public function get_icon() {
		return 'eicon-social-icons';
	}
	protected function render() {
		echo '<div class="sc-el-social">';
		if ( function_exists( 'sc_all_social' ) ) {
			sc_all_social();
		}
		echo '</div>';
	}
}

final class SC_EW_Consult_Button extends SC_EW_Block {
	public function get_name() {
		return 'sc_consult_button';
	}
	public function get_title() {
		return __( 'Consultation button', 'soundcreations' );
	}
	public function get_icon() {
		return 'eicon-button';
	}
	protected function register_controls() {
		$this->start_controls_section( 'sc_content', array( 'label' => __( 'Button', 'soundcreations' ) ) );
		$this->add_control(
			'label',
			array(
				'label'   => __( 'Label', 'soundcreations' ),
				'type'    => Controls_Manager::TEXT,
				'default' => __( 'Request a Consultation', 'soundcreations' ),
			)
		);
		$this->end_controls_section();
	}
	protected function render() {
		$s = $this->get_settings_for_display();
		echo '<a class="sc-btn sc-btn--primary" href="' . esc_url( home_url( '/request-a-consultation/' ) ) . '">' . esc_html( (string) $s['label'] ) . '</a>';
	}
}
