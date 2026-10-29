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
	return array(
		'SC_EW_Services',
		'SC_EW_Solutions',
		'SC_EW_Partners',
		'SC_EW_Work',
		'SC_EW_Stats',
		'SC_EW_Testimonials',
		'SC_EW_Cta',
		'SC_EW_Event',
		'SC_EW_Enquiry_Form',
		'SC_EW_Logo',
		'SC_EW_Menu',
		'SC_EW_Contact',
		'SC_EW_Social',
		'SC_EW_Consult_Button',
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
		$fields = sc_el_section_fields();
		$fields = isset( $fields[ $this->sc_section ] ) ? $fields[ $this->sc_section ] : array();
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
		$fields    = sc_el_section_fields();
		$fields    = isset( $fields[ $this->sc_section ] ) ? $fields[ $this->sc_section ] : array();
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

final class SC_EW_Services extends SC_EW_Section {
	protected $sc_section = 'services';
}
final class SC_EW_Solutions extends SC_EW_Section {
	protected $sc_section = 'solutions';
}
final class SC_EW_Partners extends SC_EW_Section {
	protected $sc_section = 'partners';
}
final class SC_EW_Work extends SC_EW_Section {
	protected $sc_section = 'work';
}
final class SC_EW_Stats extends SC_EW_Section {
	protected $sc_section = 'stats';
}
final class SC_EW_Testimonials extends SC_EW_Section {
	protected $sc_section = 'testimonials';
}
final class SC_EW_Cta extends SC_EW_Section {
	protected $sc_section = 'cta';
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
			. '<img class="sc-logo__img sc-logo__img--dark" src="' . esc_url( SC_THEME_URI . '/assets/img/logo-white.webp' ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" width="309" height="115">'
			. '<img class="sc-logo__img sc-logo__img--light" src="' . esc_url( SC_THEME_URI . '/assets/img/logo-color.webp' ) . '" alt="' . esc_attr( get_bloginfo( 'name' ) ) . '" width="309" height="115">'
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
