<?php
/**
 * Enable static frontpage widgets.
 *
 * @package Stratum
 * @since 1.0.0
 */

/**
 * Class for displaying static frontpage widgets.
 *
 * @since  1.0.0
 */
class Stratum_Frontpage_Widgets {

	/**
	 * Holds the instance of this class.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    object
	 */
	protected static $instance = null;

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 */
	public function __construct() {

	}

	/**
	 * Register hooked functions.
	 *
	 * @since 1.0.0
	 */
	public static function init() {
		add_action( 'wp_enqueue_scripts', array( Stratum_Frontpage_Widgets::get_instance(), 'frontpage_scripts' ) );
		add_filter( 'body_class', array( Stratum_Frontpage_Widgets::get_instance(), 'add_body_classes' ) );
		add_filter( 'stratum_register_sidebar', array( Stratum_Frontpage_Widgets::get_instance(), 'get_widgets' ), 0 );
		add_filter( 'stratum_theme_sections', array( Stratum_Frontpage_Widgets::get_instance(), 'get_theme_sections' ) );
		add_filter( 'stratum_theme_controls', array( Stratum_Frontpage_Widgets::get_instance(), 'get_theme_controls' ) );
		add_action( 'stratum_hook_after_header', array( Stratum_Frontpage_Widgets::get_instance(), 'frontpage_widgets' ) );
	}

	/**
	 * Enqueue frontpage scripts and styles.
	 *
	 * @since 1.0.0
	 */
	public function frontpage_scripts() {
		if ( is_front_page() && ! is_home() ) {
			wp_enqueue_style(
				'stratum_frontpage_style',
				get_template_directory_uri() . '/addon/frontpage/assets/frontpage.css'
			);
			wp_style_add_data( 'stratum_frontpage_style', 'rtl', 'replace' );
		}
	}

	/**
	 * Adds custom classes to the array of body class.
	 *
	 * @since 1.0.0
	 *
	 * @param array $classes Classes for the body element.
	 * @return array
	 */
	public function add_body_classes( $classes ) {

		// Adds a class for static frontpage.
		if ( is_front_page() && ! is_home() ) {
			$classes[] = 'frontpage';
			if ( is_active_sidebar( 'frontpage-1' ) && 1 === get_theme_mod( 'stratum_front_page_widget_extend', stratum_get_theme_defaults( 'stratum_front_page_widget_extend' ) ) ) {
				$classes[] = 'cta';
			} else {
				$classes[] = 'no-cta';
			}

			if ( get_theme_mod( 'stratum_front_page_content', '' ) ) {
				$classes[] = 'no-site-content';
			}
		}
		return $classes;
	}

	/**
	 * Theme widget areas.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $widgets Widget area args.
	 * @return array Returns  Args for widgets to be registered.
	 */
	public function get_widgets( $widgets = array() ) {
		$widgets = array_merge( $widgets,
			array(
				array(
					'name'        => esc_html__( 'Primary Sidebar', 'stratum' ),
					'id'          => 'sidebar-1',
					'description' => esc_html__( 'Add widgets here to appear in your primary sidebar.', 'stratum' ),
				),
				array(
					'name'        => esc_html__( 'Front Page 1', 'stratum' ),
					'id'          => 'frontpage-1',
					'description' => esc_html__( 'Display widgets only on static front page.', 'stratum' ),
				),
				array(
					'name'        => esc_html__( 'Front Page 2', 'stratum' ),
					'id'          => 'frontpage-2',
					'description' => esc_html__( 'Display widgets only on static front page.', 'stratum' ),
				),
				array(
					'name'        => esc_html__( 'Front Page 3', 'stratum' ),
					'id'          => 'frontpage-3',
					'description' => esc_html__( 'Display widgets only on static front page.', 'stratum' ),
				),
				array(
					'name'        => esc_html__( 'Front Page 4', 'stratum' ),
					'id'          => 'frontpage-4',
					'description' => esc_html__( 'Display widgets only on static front page.', 'stratum' ),
				),
				array(
					'name'        => esc_html__( 'Front Page 5', 'stratum' ),
					'id'          => 'frontpage-5',
					'description' => esc_html__( 'Display widgets only on static front page.', 'stratum' ),
				),
				array(
					'name'        => esc_html__( 'Front Page 6', 'stratum' ),
					'id'          => 'frontpage-6',
					'description' => esc_html__( 'Display widgets only on static front page.', 'stratum' ),
				),
				array(
					'name'        => esc_html__( 'Footer Widget 1', 'stratum' ),
					'id'          => 'footer-1',
					'description' => '',
				),
				array(
					'name'        => esc_html__( 'Footer Widget 2', 'stratum' ),
					'id'          => 'footer-2',
					'description' => '',
				),
				array(
					'name'        => esc_html__( 'Footer Widget 3', 'stratum' ),
					'id'          => 'footer-3',
					'description' => '',
				),
				array(
					'name'        => esc_html__( 'Footer Widget 4', 'stratum' ),
					'id'          => 'footer-4',
					'description' => '',
				),
				array(
					'name'        => esc_html__( 'Footer Widget 5', 'stratum' ),
					'id'          => 'footer-5',
					'description' => '',
				),
			)
		);

		return $widgets;
	}

	/**
	 * Set theme customizer sections.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $sections array of theme customizer sections.
	 * @return array Returns array of default theme customizer sections.
	 */
	public function get_theme_sections( $sections = array() ) {
		$sections = array_merge( $sections,
			array(
				'stratum_front_page'         => array(
					'title' => esc_html__( 'Front Page', 'stratum' ),
					'panel' => 'stratum_theme_panel',
				),
				'stratum_front_page_general' => array(
					'title'   => esc_html__( 'General', 'stratum' ),
					'section' => 'stratum_front_page',
					'panel'   => 'stratum_theme_panel',
				),
				'stratum_front_widget_1'     => array(
					'title'   => esc_html__( 'Front Page 1', 'stratum' ),
					'section' => 'stratum_front_page',
					'panel'   => 'stratum_theme_panel',
				),
				'stratum_front_widget_2'     => array(
					'title'   => esc_html__( 'Front Page 2', 'stratum' ),
					'section' => 'stratum_front_page',
					'panel'   => 'stratum_theme_panel',
				),
				'stratum_front_widget_3'     => array(
					'title'   => esc_html__( 'Front Page 3', 'stratum' ),
					'section' => 'stratum_front_page',
					'panel'   => 'stratum_theme_panel',
				),
				'stratum_front_widget_4'     => array(
					'title'   => esc_html__( 'Front Page 4', 'stratum' ),
					'section' => 'stratum_front_page',
					'panel'   => 'stratum_theme_panel',
				),
				'stratum_front_widget_5'     => array(
					'title'   => esc_html__( 'Front Page 5', 'stratum' ),
					'section' => 'stratum_front_page',
					'panel'   => 'stratum_theme_panel',
				),
				'stratum_front_widget_6'     => array(
					'title'   => esc_html__( 'Front Page 6', 'stratum' ),
					'section' => 'stratum_front_page',
					'panel'   => 'stratum_theme_panel',
				),
			)
		);

		return $sections;
	}

	/**
	 * Set theme customizer controls and settings.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $controls array of theme controls and settings.
	 * @return array Returns array of default theme controls and settings.
	 */
	public function get_theme_controls( $controls = array() ) {
		$controls = array_merge( $controls,
			array(
				array(
					'label'         => esc_html__( 'Front Page Controls', 'stratum' ),
					'section'       => 'stratum_front_page',
					'settings'      => 'stratum_front_page_sub_section',
					'control_class' => 'Stratum_Sub_Sections',
					'control_path'  => 'sub-section',
				),
				array(
					'label'       => esc_html__( 'Display Only Front Page Widgets', 'stratum' ),
					'section'     => 'stratum_front_page_general',
					'settings'    => 'stratum_front_page_content',
					'description' => esc_html__( 'Hide entry title, content, comments etc. from front page', 'stratum' ),
					'type'        => 'checkbox',
				),
				array(
					'label'    => esc_html__( 'Extend Front Page 1 Background Over Site Header', 'stratum' ),
					'section'  => 'stratum_front_page_general',
					'settings' => 'stratum_front_page_widget_extend',
					'type'     => 'checkbox',
				),
				array(
					'label'         => esc_html__( 'Site Title & Menu Text Color on Front Page', 'stratum' ),
					'section'       => 'stratum_front_page_general',
					'settings'      => 'stratum_frontpage_header_text_color',
					'control_class' => 'WP_Customize_Color_Control',
				),
			)
		);

		for ( $i = 1; $i <= 6; $i++ ) {
			$controls = array_merge( $controls,
				array(
					array(
						'label'         => esc_html__( 'Background Image', 'stratum' ),
						'section'       => 'stratum_front_widget_' . $i,
						'settings'      => 'stratum_front_widget_' . $i . '_bg_image',
						'control_class' => 'WP_Customize_Image_Control',
					),
					array(
						'label'         => esc_html__( 'Background Color', 'stratum' ),
						'section'       => 'stratum_front_widget_' . $i,
						'settings'      => 'stratum_front_widget_' . $i . '_bg_color',
						'control_class' => 'WP_Customize_Color_Control',
					),
					array(
						'label'    => esc_html__( 'Dim Background', 'stratum' ),
						'section'  => 'stratum_front_widget_' . $i,
						'settings' => 'stratum_front_widget_' . $i . '_dim_image',
						'type'     => 'checkbox',
					),
					array(
						'label'    => esc_html__( 'Fixed Background Image', 'stratum' ),
						'section'  => 'stratum_front_widget_' . $i,
						'settings' => 'stratum_front_widget_' . $i . '_fixed_bg_image',
						'type'     => 'checkbox',
					),
					array(
						'label'    => esc_html__( 'Full Screen Widget Height.', 'stratum' ),
						'section'  => 'stratum_front_widget_' . $i,
						'settings' => 'stratum_front_widget_' . $i . '_full_screen',
						'type'     => 'checkbox',
					),
					array(
						'label'    => esc_html__( 'Widget Layout', 'stratum' ),
						'section'  => 'stratum_front_widget_' . $i,
						'settings' => 'stratum_front_widget_' . $i . '_widget_layout',
						'type'     => 'select',
						'choices'  => array(
							'aligned_1' => esc_html__( '1 Widget in a row', 'stratum' ),
							'aligned_2' => esc_html__( '2 Widgets in a row', 'stratum' ),
							'aligned_3' => esc_html__( '3 Widgets in a row', 'stratum' ),
							'aligned_4' => esc_html__( '4 Widgets in a row', 'stratum' ),
						),
					),
					array(
						'label'         => esc_html__( 'Widget Text & Link Color', 'stratum' ),
						'section'       => 'stratum_front_widget_' . $i,
						'settings'      => 'stratum_front_widget_' . $i . '_text_color',
						'control_class' => 'WP_Customize_Color_Control',
					),
					array(
						'label'    => esc_html__( 'Create Widget Text Shadow', 'stratum' ),
						'section'  => 'stratum_front_widget_' . $i,
						'settings' => 'stratum_front_widget_' . $i . '_text_shadow',
						'type'     => 'checkbox',
					),
					array(
						'label'    => esc_html__( 'Widget Text Alignment', 'stratum' ),
						'section'  => 'stratum_front_widget_' . $i,
						'settings' => 'stratum_front_widget_' . $i . '_alignment',
						'type'     => 'select',
						'choices'  => array(
							'left'   => esc_html__( 'Left', 'stratum' ),
							'right'  => esc_html__( 'Right', 'stratum' ),
							'center' => esc_html__( 'Center', 'stratum' ),
						),
					),
					array(
						'label'         => esc_html__( 'Widget Area Content Width', 'stratum' ),
						'section'       => 'stratum_front_widget_' . $i,
						'settings'      => 'stratum_front_widget_' . $i . '_width',
						'control_class' => 'Stratum_Slider_Control',
						'control_path'  => 'slider-control',
						'js_template'   => true,
						'input_attrs'   => array(
							'step' => 2,
							'min'  => 400,
							'max'  => 1600,
						),
						'unit'          => 'px',
						'default_value' => '',
					),
					array(
						'label'    => esc_html__( 'Widgets Horizontal Alignment', 'stratum' ),
						'section'  => 'stratum_front_widget_' . $i,
						'settings' => 'stratum_front_widget_' . $i . '_content_alignment',
						'type'     => 'select',
						'choices'  => array(
							'left'   => esc_html__( 'Left', 'stratum' ),
							'right'  => esc_html__( 'Right', 'stratum' ),
							'center' => esc_html__( 'Center', 'stratum' ),
						),
					),
					array(
						'label'    => esc_html__( 'Widgets Vertical Alignment', 'stratum' ),
						'section'  => 'stratum_front_widget_' . $i,
						'settings' => 'stratum_front_widget_' . $i . '_vertical_alignment',
						'type'     => 'select',
						'choices'  => array(
							'top'    => esc_html__( 'Top', 'stratum' ),
							'bottom' => esc_html__( 'Bottom', 'stratum' ),
							'mid'    => esc_html__( 'Middle', 'stratum' ),
						),
					),
					array(
						'label'         => esc_html__( 'Widget Area Vertical Padding', 'stratum' ),
						'section'       => 'stratum_front_widget_' . $i,
						'settings'      => 'stratum_front_widget_' . $i . '_padding',
						'control_class' => 'Stratum_Slider_Control',
						'control_path'  => 'slider-control',
						'js_template'   => true,
						'input_attrs'   => array(
							'step' => 2,
							'min'  => 40,
							'max'  => 200,
						),
						'unit'          => 'px',
						'default_value' => '',
					),
				)
			);
		}

		return $controls;
	}

	/**
	 * Conditionally include front page widgets display template.
	 *
	 * @since  1.0.0
	 */
	public function frontpage_widgets() {
		$frontpage_widgets = array(
			'frontpage-1' => esc_html__( 'Frontpage Widget 1', 'stratum' ),
			'frontpage-2' => esc_html__( 'Frontpage Widget 2', 'stratum' ),
			'frontpage-3' => esc_html__( 'Frontpage Widget 3', 'stratum' ),
			'frontpage-4' => esc_html__( 'Frontpage Widget 4', 'stratum' ),
			'frontpage-5' => esc_html__( 'Frontpage Widget 5', 'stratum' ),
			'frontpage-6' => esc_html__( 'Frontpage Widget 6', 'stratum' ),
		);

		if ( is_front_page() && ! is_home() ) {
			foreach ( $frontpage_widgets as $widget => $description ) {
				if ( is_active_sidebar( $widget ) ) {
					stratum_widgets(
						$widget,
						'front-widget ' . $widget,
						$description,
						array( $widget ),
						'<div class="widget-container"><div class="wrap">',
						'</div></div>'
					);
				}
			}
		}
	}

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 *
	 * @return object Customizer instance.
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}

Stratum_Frontpage_Widgets::init();
