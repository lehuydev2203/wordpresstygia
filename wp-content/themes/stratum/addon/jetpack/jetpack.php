<?php
/**
 * Enable support for Jetpack Portfolio.
 *
 * @package Stratum
 * @since 1.0.0
 */

/**
 * Class for enabling support for Jetpack Portfolio.
 *
 * @since  1.0.0
 */
class Stratum_Jetpack {

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
	public function __construct() {}

	/**
	 * Register hooked functions.
	 *
	 * @since 1.0.0
	 */
	public static function init() {
		add_action( 'wp_enqueue_scripts', array( Stratum_Jetpack::get_instance(), 'portfolio_scripts' ) );
		add_filter( 'body_class', array( Stratum_Jetpack::get_instance(), 'add_site_main_class' ) );
		add_filter( 'stratum_layout_css_classes', array( Stratum_Jetpack::get_instance(), 'modify_layout_class' ) );
		add_action( 'stratum_hook_bottom_of_entry', array( Stratum_Jetpack::get_instance(), 'project_meta' ), 9 );
		add_filter( 'stratum_get_inline_style', array( Stratum_Jetpack::get_instance(), 'portfolio_css' ) );
		add_action( 'stratum_hook_for_main_loop', array( Stratum_Jetpack::get_instance(), 'project_type_filter' ) );
		add_action( 'stratum_hook_for_main_loop', array( Stratum_Jetpack::get_instance(), 'content_wrap_open' ), 12 );
		add_action( 'stratum_hook_for_main_loop', array( Stratum_Jetpack::get_instance(), 'content_wrap_close' ), 20 );
		add_filter( 'stratum_theme_controls', array( Stratum_Jetpack::get_instance(), 'customizer_jetpack_options' ) );
		add_action( 'stratum_hook_bottom_of_entry', array( Stratum_Jetpack::get_instance(), 'entry_footer_wrapper' ), 9 );
		add_action( 'stratum_hook_for_entry_content', array( Stratum_Jetpack::get_instance(), 'entry_content' ), 9 );
	}

	/**
	 * Enqueue masonry scripts and styles.
	 *
	 * @since 1.0.0
	 */
	public function portfolio_scripts() {

		if ( ! $this->is_portfolio_grid() ) {
			return;
		}

		wp_enqueue_script(
			'stratum_jetpack_grid_js',
			get_template_directory_uri() . '/addon/jetpack/assets/jetpack-grid.js',
			array( 'jquery' ),
			'1.0.0',
			true
		);

		wp_enqueue_style(
			'stratum_jetpack_grid_style',
			get_template_directory_uri() . '/addon/jetpack/assets/jetpack-grid.css'
		);
		wp_style_add_data( 'stratum_jetpack_grid_style', 'rtl', 'replace' );
	}

	/**
	 * Adds custom classes to the array of site-main class.
	 *
	 * @since 1.0.0
	 *
	 * @param array $classes Classes for the body element.
	 * @return array
	 */
	public function add_site_main_class( $classes ) {
		if ( ! defined( 'JETPACK__VERSION' ) ) {
			return $classes;
		}

		if ( ! $this->is_portfolio_grid() ) {
			return $classes;
		}

		$classes[] = 'threecol-grid';
		return $classes;
	}

	/**
	 * Modify content sidebar layout class.
	 *
	 * Modify content sidebar layout classes to remove primary and secondary
	 * sidebars from home ot archive pages (if sidebar needs to be hidden).
	 *
	 * @since 1.0.0
	 *
	 * @param null $value replacing 'null' with string value will short circuit layout class function.
	 * @return null|string.
	 */
	public function modify_layout_class( $value ) {
		if ( ! defined( 'JETPACK__VERSION' ) ) {
			return $value;
		}

		if ( ! $this->is_portfolio_grid() ) {
			return $value;
		}

		return 'only-content-full';
	}

	/**
	 * Adds project type footer meta.
	 *
	 * @since 1.0.0
	 */
	public function project_meta() {
		if ( is_singular( 'jetpack-portfolio' ) ) {
			get_template_part( 'addon/jetpack/project-meta' );
		}
	}

	/**
	 * Display entry content on singular page.
	 *
	 * @since 1.0.0
	 */
	public function entry_content() {
		if ( $this->is_portfolio_grid() ) {
			remove_action( 'stratum_hook_for_entry_content', array( 'Stratum_Display', 'entry_content' ) );
			get_template_part( 'addon/jetpack/content' );
		}
	}

	/**
	 * Conditionally display entry footer.
	 *
	 * @since 1.0.0
	 */
	public function entry_footer_wrapper() {
		if ( $this->is_portfolio_grid() ) {
			remove_action( 'stratum_hook_bottom_of_entry', array( 'Stratum_Display', 'entry_footer_wrapper' ) );
			return;
		}

		if ( is_singular( 'jetpack-portfolio' ) ) {
			remove_action( 'stratum_hook_bottom_of_entry', array( 'Stratum_Display', 'entry_footer_wrapper' ) );
			return;
		}
	}

	/**
	 * Portfolio grid layout.
	 *
	 * @since 1.0.0
	 */
	public function is_portfolio_grid() {
		if ( is_page_template( 'page-template/page-portfolio.php' ) ) {
			return true;
		}

		if ( is_post_type_archive( 'jetpack-portfolio' ) ) {
			return true;
		}

		if ( ! is_tax() ) {
			return false;
		}

		if ( ! in_array( get_queried_object()->taxonomy, array( 'jetpack-portfolio', 'jetpack-portfolio-type', 'jetpack-portfolio-tag' ), true ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Register jetpack customizer options.
	 *
	 * @since 1.0.0
	 *
	 * @param arr $controls Customizer control array.
	 * @return array $controls Customizer control array.
	 */
	public function customizer_jetpack_options( $controls ) {
		if ( defined( 'JETPACK__VERSION' ) ) {
			$controls[] = array(
				'label'    => esc_html__( 'Display project-type on Jetpack portfolio archive page.', 'stratum' ),
				'section'  => 'stratum_content_section',
				'settings' => 'stratum_jetpack_project_type',
				'type'     => 'checkbox',
			);

			$controls[] = array(
				'label'    => esc_html__( 'Display excerpt on Jetpack portfolio archive page.', 'stratum' ),
				'section'  => 'stratum_content_section',
				'settings' => 'stratum_jetpack_project_archive',
				'type'     => 'checkbox',
			);

		}

		$i = 0;
		foreach ( $controls as $control ) {
			if ( 'stratum_thumbnails_display' === $control['settings'] ) {
				break;
			}
			$i++;
		}

		unset( $controls[ $i ]['select_refresh'] );
		unset( $controls[ $i ]['transport'] );

		return $controls;
	}

	/**
	 * Add inline css for portfolio taxonomy.
	 *
	 * @param string $css Inline css for portfolio taxonomy.
	 * @since 1.0.0
	 */
	public function portfolio_css( $css ) {
		if ( ! $this->is_portfolio_grid() ) {
			return $css;
		}

		$css .= '
		.entry-header {
			margin-bottom:0;
			text-align:center;
		}
		.thumb-below-title .entry-header {
			margin-bottom:1.75rem
		}
		.thumb-below-title .thumbnails {
			margin-bottom:0
		}
		.portfolio-page-content {
			padding: 40px;
			background-color: #fff;
			margin-bottom: 40px;
		}
		.boxed .portfolio-page-content {
			padding: 0
		}
		.portfolio-page-content .entry-header {
			margin-bottom:1.75rem;
			text-align:left;
		}
		.portfolio-navigation .nav-previous,
		.portfolio-navigation .nav-next {
			width: 49.5%;
			float: left;
			margin-right: 1%;
		}
		.boxed .portfolio-navigation .nav-previous,
		.boxed .portfolio-navigation .nav-next {
			border: 1px solid #e6e6e6;
		}
		.portfolio-navigation .nav-next {
			margin-right: 0;
			text-align: right;
		}
		.portfolio-navigation .nav-links:after {
			display: table;
			clear: both;
			content: "";
		}
		.boxed .navigation {
			margin-bottom: 40px;
			padding: 0;
		}
		';
		return $css;
	}

	/**
	 * Adds project type filter in page header.
	 *
	 * @since 1.0.0
	 */
	public function project_type_filter() {
		if ( $this->is_portfolio_grid() ) {
			get_template_part( 'addon/jetpack/project-type-filter' );
		}
	}

	/**
	 * Main Content Wrapper open.
	 *
	 * @since 1.0.0
	 */
	public function content_wrap_open() {
		if ( ! $this->is_portfolio_grid() ) {
			return;
		}

		printf( '<div id="grid-wrapper"%s>', stratum_get_attr( 'grid-wrapper' ) );
	}

	/**
	 * Main Content Wrapper close.
	 *
	 * @since 1.0.0
	 */
	public function content_wrap_close() {
		if ( ! $this->is_portfolio_grid() ) {
			return;
		}

		echo '</div>';
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

Stratum_Jetpack::init();
