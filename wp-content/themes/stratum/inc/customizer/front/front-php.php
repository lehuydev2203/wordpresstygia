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
class Stratum_Customizer_Front_End extends Stratum_Customizer_Front_Base {

	/**
	 * Holds the instance of this class.
	 *
	 * @since  1.0
	 * @access protected
	 * @var    object
	 */
	protected static $instance = null;

	/**
	 * Wrapper function for front end CSS class.
	 *
	 * @since 1.0
	 * @access public
	 *
	 * @param  string $output  Stratum inline css.
	 * @return string $output  Stratum modified inline css.
	 */
	public function css( $output ) {
		$css = new Stratum_Customizer_Front_Css();
		return $css->customized_css( $output );
	}

	/**
	 * Adds google fonts in font enqueue function.
	 *
	 * Add google fonts based on font selected in theme customizer options.
	 *
	 * @since 1.0
	 * @access public
	 *
	 * @param array $fonts Google fonts array.
	 * @return string $output Google fonts to be enqueued.
	 */
	public function google_fonts( $fonts = array() ) {
		$google_fonts = array();
		$body_font    = $this->get_mod( 'stratum_body_font_family' );
		$heading_font = $this->get_mod( 'stratum_heading_font_family' );

		if ( $this->is_google_font( $body_font ) ) {
			$google_fonts[] = "{$body_font}:400,600,400italic,600italic";
		} elseif ( stratum_get_theme_defaults( 'stratum_body_font_family' ) === $body_font ) {
			$google_fonts[] = $fonts[0];
		}

		if ( $body_font !== $heading_font && $this->is_google_font( $heading_font ) ) {
			$google_fonts[] = "{$heading_font}:400,600,400italic,600italic";
		} elseif ( stratum_get_theme_defaults( 'stratum_heading_font_family' ) === $heading_font ) {
			$google_fonts[] = $fonts[1];
		}

		return $google_fonts;
	}

	/**
	 * Returns the instance.
	 *
	 * @since  1.0
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

add_filter( 'stratum_fonts', array( Stratum_Customizer_Front_End::getInstance(), 'google_fonts' ) );
add_filter( 'stratum_get_inline_style', array( Stratum_Customizer_Front_End::getInstance(), 'css' ) );
