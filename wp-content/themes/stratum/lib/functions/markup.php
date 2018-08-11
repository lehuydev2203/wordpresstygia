<?php
/**
 * Facilitate adding and filtering html elements or attributes to html elements
 *
 * This file incorporates code from Stargazer WordPress Theme,
 * Copyright (c) 2013 - 2016, Justin Tadlock http://themehybrid.com/themes/stargazer.
 * Stargazer WordPress Theme is distributed under the terms of the GNU GPL.
 *
 * @package Stratum
 * @since 1.0.1
 */

/**
 * Outputs an HTML element.
 *
 * @since  1.0.1
 *
 * @param string   $context       Markup context.
 * @param callable $callback      Callback function to echo content inside the wrapper.
 * @param mixed    $callback_args Callback function args.
 * @param string   $open          Markup wrapper opening div.
 * @param string   $close         Markup wrapper closing div.
 * @return void
 */
function stratum_markup( $context = '', $callback = '', $callback_args = '', $open = '<div%s>', $close = '</div>' ) {

	if ( ! $context ) {
		return;
	}

	// Short circuit filter.
	$check = apply_filters( "stratum_markup_{$context}", false, $context );
	if ( false !== $check ) {
		echo $check;
		return;
	}

	printf( $open, stratum_get_attr( $context ) );

	$hook = str_replace( '-', '_', $context );
	do_action( "stratum_hook_for_{$hook}" );

	if ( ! empty( $callback ) && is_callable( $callback ) ) {
		if ( ! empty( $callback_args ) ) {
			call_user_func( $callback, $callback_args );
		} else {
			call_user_func( $callback );
		}
	}

	echo $close;
}

/**
 * Outputs an HTML element's attributes.
 *
 * @since  1.0.0
 *
 * @param  str   $slug The slug/ID of the element (e.g., 'sidebar').
 * @param  array $attr Array of attributes to pass in (overwrites filters).
 */
function stratum_attr( $slug, $attr = array() ) {
	echo stratum_get_attr( $slug, $attr );
}

/**
 * Gets an HTML element's attributes.
 *
 * @since  1.0.0
 *
 * @param  str   $slug The slug/ID of the element (e.g., 'sidebar').
 * @param  array $attr Array of attributes to pass in (overwrites filters).
 * @return string
 */
function stratum_get_attr( $slug, $attr = array() ) {
	$out = '';

	if ( ! in_array( $slug, array( 'body', 'post', 'name', 'head' ), true ) ) {
		if ( isset( $attr['class'] ) ) {
			$attr['class'] .= ' ' . $slug;
		} else {
			$attr['class'] = $slug;
		}
	}

	/**
	 * Filter element's attributes.
	 *
	 * @since 1.0.0
	 */
	$attr = apply_filters( "stratum_get_attr_{$slug}", $attr, $slug );

	if ( ! empty( $attr ) ) {
		foreach ( $attr as $name => $value ) {
			$out .= sprintf( ' %s="%s"', esc_html( $name ), esc_attr( $value ) );
		}
	}

	return $out;
}

/**
 * Output a font icon.
 *
 * @since 1.0.1
 *
 * @param array $args Parameters needed to display a font icon.
 */
function stratum_icon( $args = array() ) {
	$icon_markup = stratum_get_icon( $args );
	if ( $icon_markup ) {
		echo $icon_markup;
	}
}

/**
 * Gets a font icon markup.
 *
 * @since 1.0.1
 *
 * @param array $args Parameters needed to display a font icon.
 * @return string Icon markup
 */
function stratum_get_icon( $args = array() ) {
	return apply_filters( 'stratum_get_icon', '', $args );
}
