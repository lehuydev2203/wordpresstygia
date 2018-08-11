<?php
/**
 * Customizer data
 *
 * Theme Customizer's sections and control field data.
 *
 * @package Stratum
 * @since 1.0.0
 */

/**
 * Theme option's active callback conditional functions library
 *
 * @since 1.0.0
 */
class Stratum_Customizer_Data {

	/**
	 * Constructor intentionally left blank.
	 *
	 * @since 1.0.0
	 */
	private function __construct() {}

	/**
	 * Initiate display functions.
	 *
	 * @since 1.0.0
	 */
	public static function init() {
		// Customization admin filters.
		add_filter( 'stratum_theme_panels'  , array( __CLASS__, 'get_theme_panels'    ) );
		add_filter( 'stratum_theme_sections', array( __CLASS__, 'get_theme_sections'  ) );
		add_filter( 'stratum_theme_controls', array( __CLASS__, 'get_theme_controls'  ) );
	}

	/**
	 * Set theme customizer panels.
	 *
	 * @since 1.0.1
	 *
	 * @return array Returns array of default theme customizer panels.
	 */
	public static function get_theme_panels( $panels = array() ) {
		$panels = array_merge( $panels,
			array(
				'stratum_theme_panel' => array(
					'title'       => esc_html__( 'Theme Options', 'stratum' ),
					'priority'    => 6,
					'description' => esc_html__( 'Options to customize site header structure and elements', 'stratum' ),
				)
			)
		);

		return $panels;
	}

	/**
	 * Set theme customizer sections.
	 *
	 * @since 1.0.1
	 *
	 * @return array Returns array of default theme customizer sections.
	 */
	public static function get_theme_sections( $sections = array() ) {
		$sections = array_merge( $sections,
			array(
				'stratum_typography_section' => array(
					'title'              => esc_html__( 'Typography', 'stratum' ),
					'panel'              => 'stratum_theme_panel',
					'description'        => esc_html__( 'Options to theme typography', 'stratum' ),
					'description_hidden' => true,
				),
				'stratum_layout_section'  => array(
					'title'              => esc_html__( 'Layout', 'stratum' ),
					'panel'              => 'stratum_theme_panel',
					'description'        => esc_html__( 'Options to change various layouts', 'stratum' ),
					'description_hidden' => true,
				),
				'stratum_dimension_section'  => array(
					'title'              => esc_html__( 'Dimensions', 'stratum' ),
					'panel'              => 'stratum_theme_panel',
					'description'        => esc_html__( 'Options to change various site deimensions', 'stratum' ),
					'description_hidden' => true,
				),
				'stratum_content_section' => array(
					'title'              => esc_html__( 'Blog', 'stratum' ),
					'panel'              => 'stratum_theme_panel',
					'description'        => esc_html__( 'Options to change content display', 'stratum' ),
					'description_hidden' => true,
				),
				'stratum_footer_section' => array(
					'title'              => esc_html__( 'Footer', 'stratum' ),
					'panel'              => 'stratum_theme_panel',
					'description'        => esc_html__( 'Options to change site footer content', 'stratum' ),
					'description_hidden' => true,
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
	 * @return array Returns array of default theme controls and settings.
	 */
	public static function get_theme_controls( $controls = array() ) {
		$controls = array_merge( $controls,
			array(
				array(
					'label'         => esc_html__( 'Display Site Title', 'stratum' ),
					'section'       => 'title_tagline',
					'settings'      => 'stratum_display_site_title',
					'transport'     => 'postMessage',
					'type'          => 'checkbox',
				),
				array(
					'label'         => esc_html__( 'Display Tagline', 'stratum' ),
					'section'       => 'title_tagline',
					'settings'      => 'stratum_display_site_desc',
					'transport'     => 'postMessage',
					'type'          => 'checkbox',
					'priority'      => 20,
				),
				array(
					'label'         => esc_html__( 'Body Text Color', 'stratum' ),
					'section'       => 'colors',
					'settings'      => 'stratum_content_text_color',
					'transport'     => 'postMessage',
					'control_class' => 'WP_Customize_Color_Control',
				),
				array(
					'label'         => esc_html__( 'Link Color', 'stratum' ),
					'section'       => 'colors',
					'settings'      => 'stratum_link_color',
					'transport'     => 'postMessage',
					'control_class' => 'WP_Customize_Color_Control',
				),
				array(
					'label'         => esc_html__( 'Link Hover Color', 'stratum' ),
					'section'       => 'colors',
					'settings'      => 'stratum_link_hover_color',
					'transport'     => 'postMessage',
					'control_class' => 'WP_Customize_Color_Control',
				),
				array(
					'label'         => esc_html__( 'Post Title Color', 'stratum' ),
					'section'       => 'colors',
					'settings'      => 'stratum_post_title_color',
					'transport'     => 'postMessage',
					'control_class' => 'WP_Customize_Color_Control',
				),
				array(
					'label'         => esc_html__( 'Post Title Hover Color', 'stratum' ),
					'section'       => 'colors',
					'settings'      => 'stratum_post_title_hover_color',
					'transport'     => 'postMessage',
					'control_class' => 'WP_Customize_Color_Control',
				),
				array(
					'label'         => esc_html__( 'Body Font Family', 'stratum' ),
					'section'       => 'stratum_typography_section',
					'settings'      => 'stratum_body_font_family',
					'transport'     => 'postMessage',
					'control_class' => 'Stratum_Font_Dropdown_Control',
					'control_path'  => 'font-dropdown-control',
					'choices'       => self::get_all_web_fonts_list(),
				),
				array(
					'label'         => esc_html__( 'Heading Font Family', 'stratum' ),
					'section'       => 'stratum_typography_section',
					'settings'      => 'stratum_heading_font_family',
					'transport'     => 'postMessage',
					'control_class' => 'Stratum_Font_Dropdown_Control',
					'control_path'  => 'font-dropdown-control',
					'choices'       => self::get_all_web_fonts_list(),
				),
				array(
					'label'         => esc_html__( 'Mobile Base Font Size', 'stratum' ),
					'section'       => 'stratum_typography_section',
					'settings'      => 'stratum_small_base_font_size',
					'transport'     => 'postMessage',
					'control_class' => 'Stratum_Slider_Control',
					'control_path'  => 'slider-control',
					'js_template'   => true,
					'input_attrs'   => array( 'min' => 8, 'max' => 40, 'step' => 1 ),
					'unit'          => 'px',
					'default_value' => stratum_get_theme_defaults('stratum_small_base_font_size'),
				),
				array(
					'label'         => esc_html__( 'Desktop Base Font Size', 'stratum' ),
					'section'       => 'stratum_typography_section',
					'settings'      => 'stratum_large_base_font_size',
					'transport'     => 'postMessage',
					'control_class' => 'Stratum_Slider_Control',
					'control_path'  => 'slider-control',
					'js_template'   => true,
					'input_attrs'   => array( 'min' => 8, 'max' => 40, 'step' => 1 ),
					'unit'          => 'px',
					'default_value' => stratum_get_theme_defaults('stratum_large_base_font_size'),
				),
				array(
					'label'         => esc_html__( 'Base Line Height', 'stratum' ),
					'section'       => 'stratum_typography_section',
					'settings'      => 'stratum_base_line_height',
					'transport'     => 'postMessage',
					'control_class' => 'Stratum_Slider_Control',
					'control_path'  => 'slider-control',
					'js_template'   => true,
					'input_attrs'   => array( 'min' => 1, 'max' => 3, 'step' => 0.01 ),
					'unit'          => 'na',
					'default_value' => stratum_get_theme_defaults('stratum_base_line_height'),
				),
				array(
					'label'         => esc_html__( 'Overall Site Layout', 'stratum' ),
					'section'       => 'stratum_layout_section',
					'settings'      => 'stratum_site_layout',
					'type'          => 'select',
					'choices'       => array(
						'boxed'      => esc_html__( 'Full Width Minimal', 'stratum' ),
						'full_width' => esc_html__( 'Full Width + Background', 'stratum' ),
					),
				),
				array(
					'label'         => esc_html__( 'Header Items Alignment', 'stratum' ),
					'section'       => 'stratum_layout_section',
					'settings'      => 'stratum_header_alignment',
					'type'          => 'select',
					'transport'     => 'postMessage',
					'choices'       => array(
						'left'    => esc_html__( 'Left aligned', 'stratum' ),
						'right'   => esc_html__( 'Right aligned', 'stratum' ),
						'center'  => esc_html__( 'Center aligned', 'stratum' ),
					),
				),
				array(
					'label'         => esc_html__( 'Display search bar in main menu', 'stratum' ),
					'section'       => 'stratum_layout_section',
					'settings'      => 'stratum_nav_search',
					'type'          => 'checkbox',
				),
				array(
					'label'         => esc_html__( 'Footer Items Alignment', 'stratum' ),
					'section'       => 'stratum_layout_section',
					'settings'      => 'stratum_footer_alignment',
					'type'          => 'select',
					'transport'     => 'postMessage',
					'choices'       => array(
						'left'    => esc_html__( 'Left aligned', 'stratum' ),
						'right'   => esc_html__( 'Right aligned', 'stratum' ),
						'center'  => esc_html__( 'Center aligned', 'stratum' ),
					),
				),
				array(
					'label'         => esc_html__( 'Make main menu sticky on scroll', 'stratum' ),
					'section'       => 'stratum_layout_section',
					'settings'      => 'stratum_sticky_main_menu',
					'type'          => 'checkbox',
				),
				array(
					'label'         => esc_html__( 'Display Header Image', 'stratum' ),
					'section'       => 'header_image',
					'settings'      => 'stratum_custom_header_position',
					'type'          => 'select',
					'priority'      => 5,
					'choices'       => array(
						'above-main-nav' => esc_html__( 'Above primary navigation menu', 'stratum' ),
						'below-main-nav' => esc_html__( 'Below primary navigation menu', 'stratum' ),
					),
					'active_callback' => array( 'Stratum_Active_Callback', 'is_place_header_image' ),
				),
				array(
					'label'         => esc_html__( 'Thumbnail Display Options', 'stratum' ),
					'section'       => 'stratum_layout_section',
					'settings'      => 'stratum_thumbnails_display',
					'type'          => 'select',
					'choices'       => array(
						'large_above' => esc_html__( 'Large thumbnail above post title', 'stratum' ),
						'large_below' => esc_html__( 'Large thumbnail below post title', 'stratum' ),
						'none'        => esc_html__( 'Do not display thumbnails', 'stratum' ),
					),
					'select_refresh' => array(
						'selector'            => '.site-main',
						'container_inclusive' => false,
						'render_callback'     => 'stratum_customize_partial_main_content',
						'fallback_refresh'    => false,
					),
					'transport'      => 'postMessage',
					'active_callback' => array( 'Stratum_Active_Callback', 'is_display_excerpt' ),
				),
				array(
					'label'         => esc_html__( 'Overall Site Width', 'stratum' ),
					'section'       => 'stratum_dimension_section',
					'settings'      => 'stratum_overall_site_width',
					'description'   => esc_html__( 'Change overall site width for laptops and desktops. Minimum allowed site width is 960px. Enter a number i.e., 1280', 'stratum' ),
					'control_class' => 'Stratum_Slider_Control',
					'control_path'  => 'slider-control',
					'js_template'   => true,
					'input_attrs'   => array( 'step' => 2, 'min' => 960, 'max' => 2000 ),
					'unit'          => 'px',
					'default_value' => '',
				),
				array(
					'label'         => esc_html__( 'Primary Sidebar Width', 'stratum' ),
					'section'       => 'stratum_dimension_section',
					'settings'      => 'stratum_primary_sidebar_width',
					'description'   => esc_html__( 'Change primary sidebar width for laptops and desktops. Minimum allowed sidebar width is 300px. Enter a number i.e., 340 ', 'stratum' ),
					'control_class' => 'Stratum_Slider_Control',
					'control_path'  => 'slider-control',
					'js_template'   => true,
					'input_attrs'   => array( 'step' => 2, 'min' => 180, 'max' => 1000 ),
					'unit'          => 'px',
					'default_value' => '',
				),
				array(
					'label'          => esc_html__( 'Excerpt Or Full Content', 'stratum' ),
					'section'        => 'stratum_content_section',
					'settings'       => 'stratum_excerpt_option',
					'type'           => 'select',
					'transport'      => 'postMessage',
					'select_refresh' => array(
						'selector'            => '.site-main',
						'container_inclusive' => false,
						'render_callback'     => 'stratum_customize_partial_main_content',
						'fallback_refresh'    => false,
					),
					'choices'        => array(
						'excerpt' => esc_html__( 'Excerpt', 'stratum' ),
						'content' => esc_html__( 'Full content', 'stratum' ),
					),
				),
				array(
					'label'         => esc_html__( 'Excerpt Length (from 1 to 500 words)', 'stratum' ),
					'section'       => 'stratum_content_section',
					'settings'      => 'stratum_excerpt_length',
					'type'          => 'number',
					'transport'      => 'postMessage',
					'select_refresh' => array(
						'selector'            => '.site-main',
						'container_inclusive' => false,
						'render_callback'     => 'stratum_customize_partial_main_content',
						'fallback_refresh'    => false,
					),
					'active_callback' => array( 'Stratum_Active_Callback', 'is_display_excerpt' ),
				),
				array(
					'label'         => esc_html__( 'Change Excerpt Read More Text', 'stratum' ),
					'section'       => 'stratum_content_section',
					'settings'      => 'stratum_excerpt_teaser',
					'type'          => 'text',
					'transport'     => 'postMessage',
					'active_callback' => array( 'Stratum_Active_Callback', 'is_display_excerpt' ),
				),
				array(
					'label'         => esc_html__( 'Display thumbnail image on single posts', 'stratum' ),
					'section'       => 'stratum_content_section',
					'settings'      => 'stratum_thumbnails_on_single',
					'type'          => 'checkbox',
					'transport'      => 'postMessage',
					'select_refresh' => array(
						'selector'            => '.site-main',
						'container_inclusive' => false,
						'render_callback'     => 'stratum_customize_partial_main_content',
						'fallback_refresh'    => false,
					),
				),
				array(
					'label'         => esc_html__( 'Copyright Text', 'stratum' ),
					'section'       => 'stratum_footer_section',
					'settings'      => 'stratum_copyright',
					'description'   => esc_html__( 'Type to change default copyright text', 'stratum' ),
					'transport'     => 'postMessage',
					'type'          => 'textarea',
					'select_refresh' => array(
						'selector'            => '.copyright-text',
						'container_inclusive' => true,
						'render_callback'     => 'stratum_customize_partial_copyright',
						'fallback_refresh'    => false,
					),
				),
			)
		);
		return $controls;
	}

	/**
	 * Get Sans serif Google fonts.
	 *
	 * @since  1.0.0
	 * @return array  Returns array of required google fonts.
	 */
	public static function get_google_sans_fonts_list() {
		return apply_filters( 'stratum_sans_serif_web_fonts_list', array() );
	}

	/**
	 * Get Serif Google fonts attributes.
	 *
	 * @since  1.0.0
	 * @return array  Returns array of required google fonts.
	 */
	public static function get_google_serif_fonts_list() {
		return apply_filters( 'stratum_serif_web_fonts_list', array() );
	}

	/**
	 * Get list of all available web fonts.
	 *
	 * @return  array Returns list of all web fonts.
	 * @since   1.1
	 */
	public static function get_all_web_fonts_list() {
		$google_sans_fonts  = self::get_google_sans_fonts_list();
		$google_serif_fonts = self::get_google_serif_fonts_list();

		return array_merge( $google_sans_fonts, $google_serif_fonts );
	}
}
Stratum_Customizer_Data::init();
