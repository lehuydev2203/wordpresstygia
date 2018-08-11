<?php
/**
 * Implement Stratum Theme Customizer modifications to front end.
 *
 * @link https://codex.wordpress.org/Theme_Customization_API
 *
 * @package Stratum
 * @since 1.0
 */

/**
 * Implement Stratum Theme Customizer options to front end.
 *
 * @since 1.0
 */
class Stratum_Customizer_Front_Base {

	/**
	 * Hold theme mod values.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    array
	 */
	public $mods;

	/**
	 * Hold defaults values for theme customization options.
	 *
	 * @since  1.0
	 * @access public
	 * @var    array
	 */
	public $defaults;

	/**
	 * Hold names of all google sans fonts listed in theme customizer.
	 *
	 * @since  1.0
	 * @access public
	 * @var    array
	 */
	public $google_sans;

	/**
	 * Hold names of all google serif fonts listed in theme customizer.
	 *
	 * @since  1.0
	 * @access public
	 * @var    array
	 */
	public $google_serif;

	/**
	 * Constructor method.
	 *
	 * @since 1.0
	 */
	public function __construct() {
		$this->mods         = get_theme_mods();
		$this->defaults     = stratum_get_theme_defaults( 'all' );
		$this->google_sans  = Stratum_Customizer_Data::get_google_sans_fonts_list();
		$this->google_serif = Stratum_Customizer_Data::get_google_serif_fonts_list();
	}

	/**
	 * Check if given font is a google font or not.
	 *
	 * @since 1.0
	 * @access public
	 *
	 * @param string $font Font name.
	 * @return bool
	 */
	public function is_google_font( $font ) {
		$google_fonts = array_merge( $this->google_sans, $this->google_serif );
		return in_array( $font, $google_fonts, true );
	}

	/**
	 * Check if given font is a google sans font or not.
	 *
	 * @since 1.0
	 * @access public
	 *
	 * @param string $font Font name.
	 * @return bool
	 */
	public function is_google_sans_font( $font ) {
		return in_array( $font, $this->google_sans, true );
	}

	/**
	 * Check if given font is a google serif font or not.
	 *
	 * @since 1.0
	 * @access public
	 *
	 * @param string $font Font name.
	 * @return bool
	 */
	public function is_google_serif_font( $font ) {
		return in_array( $font, $this->google_serif, true );
	}

	/**
	 * Retrieve theme modification value for the current theme.
	 *
	 * @since 1.0
	 *
	 * @param string $name Theme modification name.
	 * @param string $type Type of mod value.
	 * @return mixed escaped theme modification value.
	 */
	public function get_mod( $name, $type = 'html' ) {
		$default = false;

		if ( isset( $this->mods[ $name ] ) ) {

			/** This filter is documented in wp-includes/theme.php */
			return apply_filters( "theme_mod_{$name}", $this->escape( $this->mods[ $name ], $type ) );
		}

		if ( isset( $this->defaults[ $name ] ) ) {
			$default = $this->defaults[ $name ];
			$default = sprintf( $default, get_template_directory_uri(), get_stylesheet_directory_uri() );
		}

		/** This filter is documented in wp-includes/theme.php */
		return apply_filters( "theme_mod_{$name}", $this->escape( $default, $type ) );
	}

	/**
	 * Return escaped theme modification value.
	 *
	 * @since 1.0
	 * @access public
	 *
	 * @param mixed  $mod  Theme modification value.
	 * @param string $type Type of theme modification.
	 * @return mixed
	 */
	public function escape( $mod, $type ) {
		switch ( $type ) {
			case 'none':
				$escaped_mod = $mod;
				break;

			case 'html':
				$escaped_mod = esc_html( $mod );
				break;

			case 'integer':
				$escaped_mod = absint( $mod );
				break;

			case 'float':
				$escaped_mod = abs( floatval( $mod ) );
				break;

			case 'url':
				$escaped_mod = esc_url( $mod );
				break;

			case 'color':
				$escaped_mod = ( $mod && preg_match( '|^#([A-Fa-f0-9]{3}){1,2}$|', $mod ) ) ? $mod : false;
				break;

			default:
				$escaped_mod = false;
				break;
		}

		return $escaped_mod;
	}
}
