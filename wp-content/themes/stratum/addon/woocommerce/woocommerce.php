<?php
/**
 * Enable support for woo commerece plugin.
 *
 * @package Stratum
 * @since 1.0.0
 */

/**
 * Class for extending woo commerece support.
 *
 * @since  1.0.0
 */
class Stratum_Woo_Commerece {

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
		add_action( 'wp_enqueue_scripts', array( Stratum_Woo_Commerece::get_instance(), 'woo_scripts' ) );
		add_action( 'after_setup_theme', array( Stratum_Woo_Commerece::get_instance(), 'woo_support' ) );
		add_filter( 'wp_nav_menu_items', array( Stratum_Woo_Commerece::get_instance(), 'add_cart_menu_item' ), 10, 2 );
		add_filter( 'wp_nav_menu', array( Stratum_Woo_Commerece::get_instance(), 'add_cart_button' ), 10, 2 );
		add_filter( 'stratum_register_sidebar', array( Stratum_Woo_Commerece::get_instance(), 'get_widgets' ) );
		add_action( 'stratum_hook_for_woo_sidebar', array( Stratum_Woo_Commerece::get_instance(), 'woo_sidebar' ) );
		add_filter( 'stratum_layout_css_classes', array( Stratum_Woo_Commerece::get_instance(), 'layout_class' ) );
		remove_action( 'woocommerce_after_shop_loop', 'woocommerce_pagination', 10 );
	}

	/**
	 * Enqueue WooCommerce scripts and styles.
	 *
	 * @since 1.0.0
	 */
	public function woo_scripts() {

		if ( ! class_exists( 'woocommerce' ) ) {
			return;
		}

		wp_enqueue_script(
			'stratum_woo_js',
			get_template_directory_uri() . '/addon/woocommerce/assets/woocommerce.js',
			array( 'jquery' ),
			'1.0.0',
			true
		);

		wp_enqueue_style(
			'stratum_woo_style',
			get_template_directory_uri() . '/addon/woocommerce/assets/woocommerce.css'
		);
		wp_style_add_data( 'stratum_woo_style', 'rtl', 'replace' );
	}

	/**
	 * WooCommerce featured support.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function woo_support() {
		if ( ! class_exists( 'woocommerce' ) ) {
			return;
		}

		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
	}

	/**
	 * WooCommerce register sidebar.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $widgets Array of widgets to be registered.
	 * @return array Array of woocommerce widgets to be registered.
	 */
	public function get_widgets( $widgets = array() ) {
		if ( ! class_exists( 'woocommerce' ) ) {
			return $widgets;
		}

		$widgets = array_merge( $widgets,
			array(
				array(
					'name'        => esc_html__( 'WooCommerce Shop Archive', 'stratum' ),
					'id'          => 'woo-sidebar-shop',
					'description' => esc_html__( 'Widgets added here will appear on the sidebar of WooCommerce shop page.', 'stratum' ),
				),
				array(
					'name'        => esc_html__( 'WooCommerce Single Product', 'stratum' ),
					'id'          => 'woo-sidebar-product',
					'description' => esc_html__( 'Widgets added here will appear on the sidebar of WooCommerce single product pages.', 'stratum' ),
				),
			)
		);

		return $widgets;
	}

	/**
	 * WooCommerce layout class.
	 *
	 * @since 1.0.0
	 *
	 * @param  Null|string $value Layout class or null.
	 * @return Null|string Layout class.
	 */
	public function layout_class( $value ) {
		if ( ! class_exists( 'woocommerce' ) ) {
			return $value;
		}

		if ( is_cart() || is_checkout() ) {
			return 'only-content-full';
		}

		if ( ! function_exists( 'is_woocommerce' ) ) {
			return $value;
		}

		if ( ! is_woocommerce() ) {
			return $value;
		}

		if ( is_product() && ! is_active_sidebar( 'woo-sidebar-product' ) ) {
			return 'only-content-full';
		}

		if ( ( is_shop() || is_product_taxonomy() ) && ! is_active_sidebar( 'woo-sidebar-shop' ) ) {
			return 'only-content-full';
		}

		return $value;
	}

	/**
	 * WooCommerce sidebar support.
	 *
	 * @since 1.0.0
	 *
	 * @return void
	 */
	public function woo_sidebar() {
		if ( ! class_exists( 'woocommerce' ) ) {
			return;
		}

		if ( ! is_woocommerce() ) {
			return;
		}

		$layout_classes = Stratum_Layouts::get_instance()->stratum_layout_css_classes( array( 'class' => 'content-sidebar-wrap' ) );
		$no_col         = array( 'only-content', 'only-content-full', 'two-col-grid', 'three-col-grid' );
		$classes        = explode( ' ', $layout_classes['class'] );

		// Conditionally display primary sidebar.
		if ( count( array_intersect( $classes, $no_col ) ) !== 0 ) {
			return;
		}

		if ( is_product() ) {
			$sidebar = 'woo-sidebar-product';
		} else {
			$sidebar = 'woo-sidebar-shop';
		}

		if ( is_active_sidebar( $sidebar ) ) {
			stratum_widgets(
				'secondary',
				'primary-sidebar',
				esc_html( 'Primary Sidebar', 'stratum' ),
				array( $sidebar )
			);
		}
	}

	/**
	 * Add WooCommerce cart icon in primary menu.
	 *
	 * @since 1.0.0
	 *
	 * @param string   $menu The HTML content for the navigation menu.
	 * @param stdClass $args     An object containing wp_nav_menu() arguments.
	 * @return array
	 */
	public function add_cart_menu_item( $menu, $args ) {
		if ( has_nav_menu( 'primary' ) ) {
			if ( 'primary' !== $args->theme_location ) {
				return $menu;
			}
		} else {
			if ( 'header' !== $args->theme_location ) {
				return $menu;
			}
		}

		$menu_item = $this->get_cart_icon_link( '<li class="menu-item cart-menu-link">', '</li>' );
		if ( $menu_item ) {
			return $menu . $menu_item;
		}

		return $menu;
	}

	/**
	 * Add WooCommerce cart icon after primary menu for smaller screens.
	 *
	 * @since 1.0.0
	 *
	 * @param string   $menu The HTML content for the navigation menu.
	 * @param stdClass $args     An object containing wp_nav_menu() arguments.
	 * @return array
	 */
	public function add_cart_button( $menu, $args ) {
		if ( has_nav_menu( 'primary' ) ) {
			if ( 'primary' !== $args->theme_location ) {
				return $menu;
			}
		} else {
			if ( 'header' !== $args->theme_location ) {
				return $menu;
			}
		}

		$menu_item = $this->get_cart_icon_link( '<div class="woo-cart-sml">', '</div>' );
		if ( $menu_item ) {
			return $menu_item . $menu;
		}

		return $menu;
	}

	/**
	 * Get WooCommerce cart icon link.
	 *
	 * @since 1.0.0
	 *
	 * @param string $before HTML string to be added before cart icon link.
	 * @param string $after  HTML string to be added after cart icon link.
	 * @return string WooCommerce cart link with bucket icon.
	 */
	public function get_cart_icon_link( $before, $after ) {
		if ( ! class_exists( 'woocommerce' ) ) {
			return false;
		}

		$viewing_cart   = esc_html__( 'View your shopping cart', 'stratum' );
		$start_shopping = esc_html__( 'Start shopping', 'stratum' );
		if ( version_compare( WOOCOMMERCE_VERSION, '2.5.2', '>=' ) ) {
			$cart_url = wc_get_cart_url();
		} else {
			$cart_url = WC()->cart->get_cart_url();
		}

		if ( version_compare( WOOCOMMERCE_VERSION, '2.5.2', '>=' ) ) {
			$shop_page_url = wc_get_page_permalink( 'shop' );
		} else {
			$shop_page_url = get_permalink( wc_get_page_id( 'shop' ) );
		}
		$cart_contents_count = WC()->cart->cart_contents_count;
		$cart_contents       = sprintf(
			/* translators: %s: Number of items in cart */
			_n( '%d item', '%d items', $cart_contents_count, 'stratum' ), $cart_contents_count
		);
		$cart_total = WC()->cart->get_cart_total();

		if ( 0 === $cart_contents_count ) {
			$cart_link = '<a class="wcmenucart-contents" href="' . $shop_page_url . '" title="' . $start_shopping . '">';
		} else {
			$cart_link = '<a class="wcmenucart-contents" href="' . $cart_url . '" title="' . $viewing_cart . '">';
		}

		$cart_link .= stratum_get_icon( array( 'icon' => 'cart' ) );
		$cart_link .= ' ' . $cart_contents . '<span class="cart-total"> - ' . $cart_total . '</span>';
		$cart_link .= '</a>';
		$cart_link  = $before . $cart_link . $after;

		return $cart_link;
	}


	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 *
	 * @return object Instance of this class.
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}

Stratum_Woo_Commerece::init();
