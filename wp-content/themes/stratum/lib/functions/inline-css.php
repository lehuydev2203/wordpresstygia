<?php
/**
 * Adds inline css to site head
 *
 * @package Stratum
 * @since 1.0.0
 */

/**
 * Generate inline css.
 *
 * Collect portions of inline css from different functions and methods,
 * and enque them to site head.
 *
 * @since 1.0.0
 */
function stratum_inline_css() {

	// Return if style.css file does not exists.
	if ( ! wp_style_is( 'stratum-style', 'enqueued' ) ) {
		return;
	}

	/**
	 * Filter inline css.
	 *
	 * @since 1.0.0
	 */
	$output = apply_filters( 'stratum_get_inline_style', '' );

	if ( '' !== $output ) :

		// Strip tags and remove breaks.
		$output = wp_strip_all_tags( $output, true );

		// A bit of css minification.
		$to_be_replaced = array( ': ', '; ', ' {', ', ', ';}', ' + ' );
		$replace_with   = array( ':', ';', '{', ',', '}', '+' );
		$output         = str_replace( $to_be_replaced, $replace_with, $output );

		// Enqueue inline css.
		wp_add_inline_style( 'stratum-style', $output );
	endif;
}
add_action( 'wp_enqueue_scripts', 'stratum_inline_css', 50 );
