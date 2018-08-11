<?php
/**
 * Filters to modify default contents
 *
 * @package Stratum
 * @since 1.0.0
 */

/**
 * Filters to add or change theme contents.
 *
 * @since 1.0.0
 */
class Stratum_Filters {

	/**
	 * Constructor method intentionally left blank.
	 *
	 * @since 1.0.0
	 */
	private function __construct() {}

	/**
	 * Initiate.
	 *
	 * @since 1.0.0
	 */
	public static function initiate() {
		add_filter( 'body_class', array( __CLASS__, 'add_body_classes' ) );
		add_filter( 'post_class', array( __CLASS__, 'add_post_classes' ) );
		add_filter( 'stratum_get_attr_content-sidebar-wrap', array( __CLASS__, 'add_csw_classes' ) );
		add_filter( 'stratum_get_attr_header-items', array( __CLASS__, 'add_header_item_classes' ) );
		add_filter( 'stratum_get_attr_site-footer', array( __CLASS__, 'add_site_footer_classes' ) );
		add_filter( 'stratum_nav_menus', array( __CLASS__, 'get_nav_menus' ) );
		add_filter( 'stratum_register_sidebar', array( __CLASS__, 'get_widgets' ) );
		add_filter( 'stratum_localize_script_data', array( __CLASS__, 'localize_script_data' ) );
		add_filter( 'excerpt_length', array( __CLASS__, 'change_excerpt_length' ) );
		add_filter( 'wp_nav_menu_args', array( __CLASS__, 'primary_nav_search' ) );
		add_filter( 'the_content_more_link', array( __CLASS__, 'modify_excerpt_teaser' ) );
		add_filter( 'excerpt_more', array( __CLASS__, 'modify_excerpt_teaser' ) );
		add_filter( 'wp_get_attachment_image_attributes', array( __CLASS__, 'custom_logo_attr' ), 10, 2 );
	}

	/**
	 * Adds custom classes to the array of body class.
	 *
	 * @since 1.0.0
	 *
	 * @param array $classes Classes for the body element.
	 * @return array
	 */
	public static function add_body_classes( $classes ) {

		// Adds a class of group-blog to blogs with more than 1 published author.
		if ( is_multi_author() ) {
			$classes[] = 'group-blog';
		}

		// Adds a class of hfeed to non-singular pages.
		if ( ! is_singular() ) {
			$classes[] = 'hfeed';
		}

		// Adds a class for overall site layout.
		if ( 'boxed' === get_theme_mod( 'stratum_site_layout', stratum_get_theme_defaults( 'stratum_site_layout' ) ) ) {
			$classes[] = 'boxed';
		} else {
			$classes[] = 'full-width';
		}

		// Adds a class for fixed main navigation.
		if ( get_theme_mod( 'stratum_sticky_main_menu', stratum_get_theme_defaults( 'stratum_sticky_main_menu' ) ) ) {
			$classes[] = 'fixed-elem';
		}

		return $classes;
	}

	/**
	 * Adds custom classes to the array of post class.
	 *
	 * @since 1.0.0
	 *
	 * @param array $classes Classes for the post element.
	 * @return array
	 */
	public static function add_post_classes( $classes ) {
		if ( is_home() || is_search() || is_archive() ) {

			// Adds a class to identify excerpt or full content on home, search or archive pages.
			if ( 'excerpt' === get_theme_mod( 'stratum_excerpt_option', stratum_get_theme_defaults( 'stratum_excerpt_option' ) ) ) {
				$classes[] = 'excerpt';
			} else {
				$classes[] = 'full-content';
			}
		}

		// Adds a class to style thumbnails.
		if ( 'large_above' === get_theme_mod( 'stratum_thumbnails_display', stratum_get_theme_defaults( 'stratum_thumbnails_display' ) ) ) {
			$classes[] = 'thumb-above-title';
		} elseif ( 'large_below' === get_theme_mod( 'stratum_thumbnails_display', stratum_get_theme_defaults( 'stratum_thumbnails_display' ) ) ) {
			$classes[] = 'thumb-below-title';
		} else {
			$classes[] = 'no-thumb';
		}

		return $classes;
	}

	/**
	 * Adds custom classes to Content sidebar wrap.
	 *
	 * @since 1.0.0
	 *
	 * @param array $attr attribute values array.
	 * @return array
	 */
	public static function add_csw_classes( $attr ) {

		$classes = explode( ' ', $attr['class'] );

		// Adds a class for displayed sidebars.
		$no_col = array( 'only-content', 'only-content-full' );
		if ( count( array_intersect( $classes, $no_col ) ) === 0 ) {
			$classes[] = 'one-sidebar';
		} else {
			$classes[] = 'no-sidebar';
		}

		$attr['class'] = implode( ' ', $classes );

		return $attr;
	}

	/**
	 * Adds custom classes to header items.
	 *
	 * @since 1.0.0
	 *
	 * @param array $attr attribute values array.
	 * @return array
	 */
	public static function add_header_item_classes( $attr ) {

		// Adds a class for header items alignment.
		if ( 'left' === get_theme_mod( 'stratum_header_alignment', stratum_get_theme_defaults( 'stratum_header_alignment' ) ) ) {
			$attr['class'] .= ' aligned left';
		} elseif ( 'right' === get_theme_mod( 'stratum_header_alignment', stratum_get_theme_defaults( 'stratum_header_alignment' ) ) ) {
			$attr['class'] .= ' aligned right';
		}

		return $attr;
	}

	/**
	 * Adds custom classes to site footer.
	 *
	 * @since 1.0.0
	 *
	 * @param array $attr attribute values array.
	 * @return array
	 */
	public static function add_site_footer_classes( $attr ) {

		// Adds a class for site footer alignment.
		if ( 'left' === get_theme_mod( 'stratum_footer_alignment', stratum_get_theme_defaults( 'stratum_footer_alignment' ) ) ) {
			$attr['class'] .= ' aligned left';
		} elseif ( 'right' === get_theme_mod( 'stratum_footer_alignment', stratum_get_theme_defaults( 'stratum_footer_alignment' ) ) ) {
			$attr['class'] .= ' aligned right';
		}

		return $attr;
	}

	/**
	 * Navigation menu locations.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $locations Associative array of menu location identifiers (like a slug) and descriptive text.
	 * @return array Returns    Menu locations.
	 */
	public static function get_nav_menus( $locations = array() ) {
		$locations = array_merge( $locations,
			array(
				'header' => esc_html__( 'Header', 'stratum' ),
				'footer' => esc_html__( 'Footer', 'stratum' ),
			)
		);

		return $locations;
	}

	/**
	 * Theme widget areas.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $widgets Widget area args.
	 * @return array Returns  Args for widgets to be registered.
	 */
	public static function get_widgets( $widgets = array() ) {
		$widgets = array_merge( $widgets,
			array(
				array(
					'name'        => esc_html__( 'Primary Sidebar', 'stratum' ),
					'id'          => 'sidebar-1',
					'description' => esc_html__( 'Add widgets here to appear in your primary sidebar.', 'stratum' ),
				),
				array(
					'name'        => esc_html__( 'Footer 1', 'stratum' ),
					'id'          => 'footer-1',
					'description' => '',
				),
				array(
					'name'        => esc_html__( 'Footer 2', 'stratum' ),
					'id'          => 'footer-2',
					'description' => '',
				),
				array(
					'name'        => esc_html__( 'Footer 3', 'stratum' ),
					'id'          => 'footer-3',
					'description' => '',
				),
				array(
					'name'        => esc_html__( 'Footer 4', 'stratum' ),
					'id'          => 'footer-4',
					'description' => '',
				),
				array(
					'name'        => esc_html__( 'Footer 5', 'stratum' ),
					'id'          => 'footer-5',
					'description' => '',
				),
			)
		);

		return $widgets;
	}

	/**
	 * Localize script data for stratum javascripts.
	 *
	 * @since 1.0.0
	 *
	 * @param  array $script_data Localize script data.
	 * @return array
	 */
	public static function localize_script_data( $script_data = array() ) {
		$script_data = array_merge( $script_data,
			array(
				'expand'    => esc_html__( 'Expand child menu', 'stratum' ),
				'collapse'  => esc_html__( 'Collapse child menu', 'stratum' ),
				'icon'      => stratum_get_icon( array(
					'icon'     => 'angle-down',
					'fallback' => true,
				) ),
				'secondary' => 'header-menu',
			)
		);

		return $script_data;
	}

	/**
	 * Change excerpt length.
	 *
	 * Change excerpt length to be displayed on main, archive and search
	 * pages, default excerpt length is 55.
	 *
	 * @since 1.0.0
	 *
	 * @param int $length excert length.
	 * @return integer
	 */
	public static function change_excerpt_length( $length ) {
		$length = absint( get_theme_mod( 'stratum_excerpt_length', stratum_get_theme_defaults( 'stratum_excerpt_length' ) ) );
		return $length;
	}

	/**
	 * Add search form in primary menu.
	 *
	 * Conditionally add search form and search toggle in primary navigation menu.
	 *
	 * @since 1.0.0
	 *
	 * @param array $args Array of nav menu arguments.
	 * @return array
	 */
	public static function primary_nav_search( $args ) {
		if ( '' === get_theme_mod( 'stratum_nav_search', stratum_get_theme_defaults( 'stratum_nav_search' ) ) ) {
			return $args;
		}
		$search_toggle = sprintf( '<button aria-expanded="false"%1$s>%2$s%3$s</button>', stratum_get_attr( 'search-toggle' ), stratum_get_icon( array( 'icon' => 'search' ) ), stratum_get_icon( array( 'icon' => 'close' ) ) );
		$search_item   = sprintf( '<span%1$s>%2$s</span>', stratum_get_attr( 'search-item' ), $search_toggle );

		if ( has_nav_menu( 'header' ) && 'header' === $args['theme_location'] ) {
			$args['items_wrap'] = '<ul id="%1$s" class="%2$s">' . get_search_form( false ) . '%3$s' . $search_item . '</ul>';
		}
		return $args;
	}

	/**
	 * Change Read more text.
	 *
	 * Change excerpt read more link text based on custom text entered in
	 * theme customizer.
	 *
	 * @since 1.0.0
	 *
	 * @return string
	 */
	public static function modify_excerpt_teaser() {
		$url   = esc_url( get_permalink() );
		$text  = esc_html( get_theme_mod( 'stratum_excerpt_teaser', stratum_get_theme_defaults( 'stratum_excerpt_teaser' ) ) );
		$title = get_the_title();

		if ( 0 === strlen( $title ) ) {
			$screen_reader = '';
		} else {
			$screen_reader = sprintf( '<span class="screen-reader-text">%s</span>', $title );
		}

		$excerpt_teaser = sprintf( '<p class="link-more"><a class="more-link" href="%1$s">%2$s %3$s</a></p>', $url, $text, $screen_reader );
		return $excerpt_teaser;
	}

	/**
	 * Modify custom logo attributes.
	 *
	 * Modify 'itemprop="logo"' and 'alt' attributes to address google strucutral data
	 * and accessibility related errors.
	 *
	 * @since 1.0.0
	 *
	 * @param array   $attr       Attributes for the image markup.
	 * @param WP_Post $attachment Image attachment post.
	 * @return array
	 */
	public static function custom_logo_attr( $attr, $attachment ) {
		$custom_logo_id = get_theme_mod( 'custom_logo' );
		if ( $custom_logo_id === $attachment->ID ) {
			if ( isset( $attr['itemprop'] ) ) {
				unset( $attr['itemprop'] );
			}
			if ( ! get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ) ) {
				$attr['alt'] = get_bloginfo( 'name', 'display' );
			}
		}

		return $attr;
	}
}

Stratum_Filters::initiate();
