<?php
/**
 * Teplate tags for stratum theme
 *
 * @package Stratum
 * @since 1.0.0
 */

/**
 * Render footer credit information.
 *
 * @since 1.0.0
 *
 * @return str copyright information markup.
 */
function stratum_render_copyright_info() {
	$copyright_info = get_theme_mod( 'stratum_copyright', stratum_get_theme_defaults( 'stratum_copyright' ) );
	if ( '' === $copyright_info ) {
		$copyright_info = stratum_get_theme_defaults( 'stratum_copyright' );
	}

	$copyright_info = implode( '<br/>', array_map( 'esc_textarea', explode( "\n", $copyright_info ) ) );

	$output = str_replace( '[current_year]', date_i18n( __( 'Y', 'stratum' ) ), $copyright_info );
	$output = str_replace( '[site_title]', get_bloginfo( 'name' ), $output );
	$output = str_replace( '[copy_symbol]', '&copy;', $output );

	$output = sprintf( '%s', $output );
	return $output;
}

/**
 * Get navigation menu markup.
 *
 * Create navigation menu markup based on arguments provided.
 *
 * @since 1.0.0
 *
 * @param string $nav_id    Menu container ID.
 * @param string $menu_id   Menu ID.
 * @param string $label     Menu label.
 * @param string $location  Menu theme location.
 * @param bool   $is_toggle Is toggle button required.
 * @param int    $args      Additional wp_nav_menu args.
 */
function stratum_menu( $nav_id, $menu_id, $label, $location, $is_toggle = false, $args = array() ) {
	$menu = sprintf( '<h2 class="screen-reader-text">%s</h2>', $label );

	if ( $is_toggle ) {
		$menu .= sprintf(
			'<button aria-controls="%1$s" aria-expanded="false" %2$s>%3$s%4$s%5$s</button>',
			$menu_id,
			stratum_get_attr( 'menu-toggle' ),
			stratum_get_icon( array( 'icon' => 'bars' ) ),
			stratum_get_icon( array( 'icon' => 'close' ) ),
			esc_html__( 'Menu', 'stratum' )
		);
	}

	$menu .= wp_nav_menu(
		array_merge( $args, array(
			'theme_location' => $location,
			'menu_id'        => $menu_id,
			'menu_class'     => 'nav-menu nav-menu--' . $location,
			'echo'           => false,
		) )
	);

	$menu_markup = printf( '<nav id="%1$s"%2$s aria-label="%3$s">%4$s</nav>', $nav_id, stratum_get_attr( $nav_id ), $label, $menu );
}

/**
 * Display widgets area.
 *
 * Create widget area markup based on arguments provided.
 *
 * @since 1.0.0
 *
 * @param string $id        widget area ID.
 * @param string $class     widget area Class.
 * @param string $label     widget area label.
 * @param string $widgets   widgets to be displayed.
 * @param bool   $before_widgets markup before widget area.
 * @param int    $after_widgets markup after widget area..
 */
function stratum_widgets( $id, $class, $label, $widgets = array(), $before_widgets = '', $after_widgets = '' ) {
	printf( '<aside id="%1$s"%2$s area-label="%3$s">', esc_attr( $id ), stratum_get_attr( $class ), esc_attr( $label ) );
	printf( '<h2 class="screen-reader-text">%s</h2>', esc_attr( $label ) );
	echo apply_filters( 'stratum_before_widgets', $before_widgets, $id );
	foreach ( $widgets as $widget ) {
		if ( is_active_sidebar( $widget ) ) {
			printf( '<div%s>', stratum_get_attr( 'widget-wrapper' ) );
			dynamic_sidebar( $widget );
			printf( '</div>' );
		}
	}
	echo apply_filters( 'stratum_after_widgets', $after_widgets, $id );
	printf( '</aside>' );
}

/**
 * Display post content with limited characters and teaser text.
 *
 * @since 1.0.0
 *
 * @param int    $excerpt_length The maximum number of characters to return.
 * @param string $excerpt_more Optional. Text of the more link. Default none.
 */
function stratum_limited_content( $excerpt_length, $excerpt_more = '' ) {
	$content = get_the_content();

	// Strip tags and shortcodes so the content truncation count is done correctly.
	$content = strip_tags( strip_shortcodes( $content ), '<script>,<style>' );

	// Remove inline styles / scripts.
	$content = trim( preg_replace( '#<(s(cript|tyle)).*?</\1>#si', '', $content ) );

	// More link?
	if ( $excerpt_more ) {
		$url   = esc_url( get_permalink() );
		$text  = $excerpt_more;
		$title = get_the_title();

		if ( 0 === strlen( $title ) ) {
			$screen_reader = '';
		} else {
			$screen_reader = sprintf( '<span class="screen-reader-text">%s</span>', $title );
		}

		$excerpt_more = sprintf( '<p class="link-more"><a class="more-link" href="%1$s">%2$s %3$s</a></p>', $url, $text, $screen_reader );
	}

	$content = wp_trim_words( $content, $excerpt_length, $excerpt_more );
	$content = apply_filters( 'stratum_limited_content', $content );

	/** This filter is documented in wp-includes/post-template.php */
	echo apply_filters( 'the_excerpt', $content );
}

/**
 * Get all registered image sizes.
 *
 * @since 1.0.0
 *
 * @return array Registered image sizes.
 */
function stratum_get_image_sizes() {
	global $_wp_additional_image_sizes;
	$sizes = array();

	foreach ( get_intermediate_image_sizes() as $_size ) {
		if ( in_array( $_size, array( 'thumbnail', 'medium', 'large' ) ) ) {
			$sizes[ $_size ]['width']  = get_option( "{$_size}_size_w" );
			$sizes[ $_size ]['height'] = get_option( "{$_size}_size_h" );
			$sizes[ $_size ]['crop']   = (bool) get_option( "{$_size}_crop" );
		} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
			$sizes[ $_size ] = array(
				'width'  => $_wp_additional_image_sizes[ $_size ]['width'],
				'height' => $_wp_additional_image_sizes[ $_size ]['height'],
				'crop'   => $_wp_additional_image_sizes[ $_size ]['crop'],
			);
		}
	}

	return $sizes;
}
