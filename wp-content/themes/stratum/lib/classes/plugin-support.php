<?php
/**
 * Stratum Theme plugin support
 *
 * @package Stratum
 * @since 1.0.0
 */

/**
 * Prvides support for various popular plugins.
 *
 * @since 1.0.0
 */
class Stratum_Plugin_Support {

	/**
	 * Constructor method intentionally left blank.
	 */
	private function __construct() {}

	/**
	 * Support functions.
	 *
	 * @since 1.0.0
	 */
	public static function initiate() {
		add_action( 'after_setup_theme', array( __CLASS__, 'jetpack_setup' ) );
		add_action( 'after_setup_theme', array( __CLASS__, 'woocommerce' ), 13 );
	}

	/**
	 * Jetpack setup function.
	 *
	 * @since 1.0.0
	 *
	 * @link https://jetpack.com/support/infinite-scroll/
	 * @link https://jetpack.com/support/responsive-videos/
	 */
	public static function jetpack_setup() {
		// Add theme support for Infinite Scroll.
		add_theme_support( 'infinite-scroll', array(
			'container' => 'main',
			'render'    => array( __CLASS__, 'infinite_scroll_render' ),
			'footer'    => 'page',
		) );

		// Add theme support for Responsive Videos.
		add_theme_support( 'jetpack-responsive-videos' );
	}

	/**
	 * Custom render function for Jetpack Infinite Scroll.
	 *
	 * @since 1.0.0
	 */
	public static function infinite_scroll_render() {
		while ( have_posts() ) {
			the_post();
			if ( is_search() ) :
				get_template_part( 'lib/template-parts/content/search' );
			else :
				get_template_part( 'lib/template-parts/content/content' );
			endif;
		}
	}

	/**
	 * Add support for wooCommerce.
	 *
	 * @since 1.0.0
	 */
	public static function woocommerce() {
		add_theme_support( 'woocommerce' );
		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper' );
		remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end' );
		remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar' );
		add_action( 'woocommerce_before_main_content', array( __CLASS__, 'woocommerce_start' ) );
		add_action( 'woocommerce_after_main_content', array( __CLASS__, 'woocommerce_end' ) );
	}

	/**
	 * Add support for wooCommerce start wrapper.
	 *
	 * @since 1.0.0
	 */
	public static function woocommerce_start() {
		?>
		<div<?php stratum_attr( 'content-sidebar-wrap' ); ?>>
			<div id="primary"<?php stratum_attr( 'content-area' ); ?>>
				<?php
				/** This action is documented in /index.php */
				do_action( 'stratum_hook_before_main_content' );
				?>
				<main id="main" role="main"<?php stratum_attr( 'site-main', array( 'class' => 'woo-content' ) ); ?>>
		<?php
	}

	/**
	 * Add support for wooCommerce end wrapper.
	 *
	 * @since 1.0.0
	 */
	public static function woocommerce_end() {
		?>
				</main><!-- #main -->

				<?php
				/** This action is documented in /index.php */
				do_action( 'stratum_hook_after_main_content' );
				?>

			</div><!-- #primary -->
			<?php
			do_action( 'stratum_hook_for_woo_sidebar' );
			?>
		</div><!-- .content-sidebar-wrap -->
		<?php
	}
}

Stratum_Plugin_Support::initiate();
