<?php
/**
 * Stratum Theme Customizer.
 *
 * @link https://codex.wordpress.org/Theme_Customization_API
 *
 * @package Stratum
 * @since 1.0.0
 */

/**
 * Add theme modification options to Theme Customizer
 *
 * @since 1.0.0
 */
class Stratum_Customizer extends Stratum_Sanitization {

	/**
	 * Holds the instance of this class.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    object
	 */
	protected static $instance = null;

	/**
	 * Hold defaults values for theme customization options.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    array
	 */
	public $defaults;

	/**
	 * Hold defaults theme settings and controls.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    array
	 */
	public $customizer_controls;

	/**
	 * Hold theme customizer sections details.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    array
	 */
	public $customizer_sections;

	/**
	 * Hold theme customizer panels details.
	 *
	 * @since  1.0.1
	 * @access public
	 * @var    array
	 */
	public $customizer_panels;

	/**
	 * Constructor method.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		$this->defaults            = stratum_get_theme_defaults( 'all' );
		$this->customizer_panels   = apply_filters( 'stratum_theme_panels', array() );
		$this->customizer_sections = apply_filters( 'stratum_theme_sections', array() );
		$this->customizer_controls = apply_filters( 'stratum_theme_controls', array() );
	}

	/**
	 * Add theme modification options and postMessage support to Theme Customizer.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
	 */
	public function customize_register( $wp_customize ) {
		$wp_customize->register_section_type( 'Stratum_WP_Customize_Section' );
		$wp_customize->get_setting( 'blogname' )->transport               = 'postMessage';
		$wp_customize->get_setting( 'blogdescription' )->transport        = 'postMessage';
		$wp_customize->get_control( 'blogdescription' )->priority         = 20;
		$wp_customize->get_section( 'background_image' )->active_callback = array( 'Stratum_Active_Callback', 'is_full_width_layout' );
		$wp_customize->get_section( 'colors' )->panel                     = 'stratum_theme_panel';

		if ( isset( $wp_customize->selective_refresh ) ) {
			$wp_customize->selective_refresh->add_partial( 'blogname', array(
				'selector'            => '.site-title a',
				'container_inclusive' => false,
				'render_callback'     => 'stratum_customize_partial_blogname',
			) );
			$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
				'selector'            => '.site-description',
				'container_inclusive' => false,
				'render_callback'     => 'stratum_customize_partial_blogdescription',
			) );
		}

		foreach ( $this->customizer_panels as $id => $args ) {
			$wp_customize->add_panel( $id, $args );
		}

		foreach ( $this->customizer_sections as $id => $args ) {
			if ( isset( $args['section'] ) ) {
				$subsection = new Stratum_WP_Customize_Section( $wp_customize, $id, array(
					'title'   => $args['title'],
					'section' => $args['section'],
					'panel'   => $args['panel'],
				) );

				$wp_customize->add_section( $subsection );
			} else {
				$wp_customize->add_section( $id, $args );
			}
		}

		foreach ( $this->customizer_controls as $customizer_control ) {
			$wp_customize->add_setting( $customizer_control['settings'], array(
				'default'           => isset( $this->defaults[ $customizer_control['settings'] ] ) ? $this->defaults[ $customizer_control['settings'] ] : '',
				'sanitize_callback' => array( $this, 'sanitization' ),
				'transport'         => ( isset( $customizer_control['transport'] ) && 'postMessage' === $customizer_control['transport'] ) ? 'postMessage' : 'refresh',
			) );

			// Check if custom control class is available.
			if ( isset( $customizer_control['control_class'] ) ) {
				$class = $customizer_control['control_class'];

				// Include required custom control class.
				if ( isset( $customizer_control['control_path'] ) ) {
					$stratum_dir = trailingslashit( get_template_directory() );
					$path        = "{$stratum_dir}lib/customizer/controls/{$customizer_control['control_path']}.php";
					$path = apply_filters( 'stratum_custom_control_class_path', $path, $class );
					if ( ! class_exists( $class ) && file_exists( $path ) ) {
						require_once $path;
					}
				}

				// Are we using underscores js template for control rendering?
				if ( isset( $customizer_control['js_template'] ) ) {
					$wp_customize->register_control_type( $class );
				}

				if ( class_exists( $class ) ) {
					$wp_customize->add_control( new $class( $wp_customize, $customizer_control['settings'], $customizer_control ) );
				} else {
					$wp_customize->add_control( $customizer_control['settings'], $customizer_control );
				}
			} else {

				$wp_customize->add_control( $customizer_control['settings'], $customizer_control );
			}

			if ( isset( $customizer_control['select_refresh'] ) && isset( $wp_customize->selective_refresh ) ) {
				$wp_customize->selective_refresh->add_partial( $customizer_control['settings'], $customizer_control['select_refresh'] );
			}
		} // End foreach().
	}

	/**
	 * Wrapper function for sanitization class.
	 *
	 * @since 1.0.0
	 *
	 * @param  Mixed                $option  Selected customizer option.
	 * @param  WP_Customize_Setting $setting Setting instance.
	 * @return Mixed Returns sanitized value.
	 */
	public function sanitization( $option, $setting ) {
		return $this->get_sanitized_value( $option, $setting );
	}

	/**
	 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
	 *
	 * @since 1.0.0
	 */
	public function customize_preview_js() {
		wp_enqueue_script(
			'stratum_customizer',
			get_template_directory_uri() . '/assets/admin/js/customize-preview.js',
			array( 'customize-preview' ),
			'1.0.0',
			true
		);
	}

	/**
	 * Enqueue customizer control JS file.
	 *
	 * @since 1.0.0
	 */
	public function customize_control_js() {
		wp_enqueue_script(
			'stratum_customizer_control',
			get_template_directory_uri() . '/assets/admin/js/customize-control.js',
			array( 'customize-controls', 'jquery', 'jquery-ui-core', 'jquery-ui-slider' ),
			'1.0.0',
			true
		);
	}

	/**
	 * Enqueue customizer control CSS file.
	 *
	 * @since 1.0.0
	 */
	public function customize_control_css() {
		wp_enqueue_style(
			'stratum_customizer_control_style',
			get_template_directory_uri() . '/assets/admin/css/customize-control.css'
		);
	}

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 *
	 * @return object Customizer instance.
	 */
	public static function getInstance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}

add_action( 'customize_register', array( Stratum_Customizer::getInstance(), 'customize_register' ) );
add_action( 'customize_preview_init', array( Stratum_Customizer::getInstance(), 'customize_preview_js' ) );
add_action( 'customize_controls_enqueue_scripts', array( Stratum_Customizer::getInstance(), 'customize_control_js' ) );
add_action( 'customize_controls_print_styles', array( Stratum_Customizer::getInstance(), 'customize_control_css' ) );
