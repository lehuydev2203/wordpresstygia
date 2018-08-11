<?php
/**
 * Active callback functions
 *
 * Library of active callback functions for theme customizer.
 *
 * @link https://codex.wordpress.org/Theme_Customization_API
 *
 * @package Stratum
 * @since 1.0.0
 */

/**
 * Theme option's active callback conditional functions library
 *
 * @since 1.0.0
 */
class Stratum_Active_Callback {

	/**
	 * Constructor method intentionally left blank.
	 *
	 * @since 1.0.0
	 */
	private function __construct() {}

	/**
	 * Check if display excerpt option selected.
	 *
	 * @since 1.0.0
	 *
	 * @param object $control whole wp_customize_control object.
	 * @return bool
	 */
	public static function is_display_excerpt( $control ) {
		return 'excerpt' === $control->manager->get_setting( 'stratum_excerpt_option' )->value();
	}

	/**
	 * Check if single post or page will have different content layout.
	 *
	 * @since 1.0.0
	 *
	 * @param object $control whole wp_customize_control object.
	 * @return bool
	 */
	public static function is_different_layout( $control ) {
		return '' !== $control->manager->get_setting( 'stratum_enforce_global' )->value();
	}

	/**
	 * Check if header image placement options to be displayed.
	 *
	 * @since 1.0.0
	 *
	 * @param object $control whole wp_customize_control object.
	 * @return bool
	 */
	public static function is_full_width_layout( $control ) {
		return ( 'full_width' === get_theme_mod( 'stratum_site_layout', '' ) );
	}
}
