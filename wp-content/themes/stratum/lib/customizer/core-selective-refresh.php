<?php
/**
 * Theme customizer selective refresh render callback functions.
 *
 * @package	 Stratum
 * @since 1.1
 */

/**
 * Render the site title for the selective refresh partial.
 *
 * @since 1.1
 *
 * @return void
 */
function stratum_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @since 1.1
 *
 * @return void
 */
function stratum_customize_partial_blogdescription() {
	bloginfo( 'description' );
}
