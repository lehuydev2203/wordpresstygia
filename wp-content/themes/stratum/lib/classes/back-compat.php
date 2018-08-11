<?php
/**
 * Stratum Theme back compat functionality
 *
 * Prevents stratum from running on WordPress versions prior to 4.5,
 * since this theme is not meant to be backward compatible beyond that and
 * relies on many newer functions and markup changes introduced in 4.5.
 *
 * This file incorporates code from Twenty Fifteen WordPress Theme,
 * Copyright 2014-2016 WordPress.org & Automattic.com Twenty Fifteen is
 * distributed under the terms of the GNU GPL.
 *
 * @package Stratum
 * @since 1.0.0
 */

/**
 * Stratum Theme back compat functionality.
 *
 * @since 1.0.0
 */
class Stratum_Back_Compat {

	/**
	 * Constructor method intentionally left blank.
	 */
	private function __construct() {}

	/**
	 * Compatibility functions.
	 *
	 * @since 1.0.0
	 */
	public static function initiate() {
		add_action( 'after_switch_theme', array( __CLASS__, 'switch_theme' ) );
		add_action( 'load-customize.php', array( __CLASS__, 'customize' ) );
		add_action( 'template_redirect', array( __CLASS__, 'preview' ) );
	}

	/**
	 * Prevent switching to stratum on old versions of WordPress.
	 *
	 * Switches to the default theme.
	 *
	 * @since 1.0.0
	 */
	public static function switch_theme() {
		switch_theme( WP_DEFAULT_THEME, WP_DEFAULT_THEME );

		unset( $_GET['activated'] );

		add_action( 'admin_notices', array( __CLASS__, 'upgrade_notice' ) );
	}

	/**
	 * Adds a message for unsuccessful theme switch.
	 *
	 * Prints an update nag after an unsuccessful attempt to switch to
	 * stratum on WordPress versions prior to 4.5.
	 *
	 * @since 1.0.0
	 *
	 * @global string $wp_version WordPress version.
	 */
	public static function upgrade_notice() {
		/* translators: %s: WordPress currently installed version */
		$message = sprintf( esc_html__( 'stratum requires at least WordPress version 4.5. You are running version %s. Please upgrade and try again.', 'stratum' ), $GLOBALS['wp_version'] );
		printf( '<div class="error"><p>%s</p></div>', $message ); // WPCS : XSS OK.
	}

	/**
	 * Prevents the Customizer from being loaded on WordPress versions prior to 4.5.
	 *
	 * @since 1.0.0
	 *
	 * @global string $wp_version WordPress version.
	 */
	public static function customize() {
		wp_die(
			/* translators: %s: WordPress currently installed version */
			sprintf( esc_html__( 'stratum requires at least WordPress version 4.5. You are running version %s. Please upgrade and try again.', 'stratum' ), $GLOBALS['wp_version'] ), '', array(
				'back_link' => true,
			)
		);
	}

	/**
	 * Prevents the Theme Preview from being loaded on WordPress versions prior to 4.5.
	 *
	 * @since 1.0.0
	 *
	 * @global string $wp_version WordPress version.
	 */
	public static function preview() {
		if ( isset( $_GET['preview'] ) ) {
			wp_die(
				/* translators: %s: WordPress currently installed version */
				sprintf( esc_html__( 'stratum requires at least WordPress version 4.5. You are running version %s. Please upgrade and try again.', 'stratum' ), $GLOBALS['wp_version'] )
			);
		}
	}
}

Stratum_Back_Compat::initiate();
