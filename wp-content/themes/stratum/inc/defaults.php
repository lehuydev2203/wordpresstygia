<?php
/**
 * Defaults values for customizer options
 *
 * @package Stratum
 * @since 1.0.0
 */

/**
 * Set default values for theme customization options.
 *
 * @since 1.0.0
 *
 * @param str $option name of the option.
 * @return mixed Returns integer, string or array option values.
 */
function stratum_get_theme_defaults( $option ) {

	/**
	 * Filter default values for customizer options.
	 *
	 * @since 1.0.0
	 */
	$stratum_defaults = apply_filters( 'stratum_theme_defaults', array(
		'stratum_post_title_color'       => '#333',
		'stratum_post_title_hover_color' => '#333',
		'stratum_site_title_color'       => '#333',
		'stratum_content_text_color'     => '#333',
		'stratum_link_color'             => '#0067ac',
		'stratum_link_hover_color'       => '#0067ac',
		'stratum_display_site_title'     => 1,
		'stratum_display_site_desc'      => 1,
		'stratum_body_font_family'       => 'Noto Sans',
		'stratum_heading_font_family'    => 'Source Sans Pro',
		'stratum_small_base_font_size'   => 16,
		'stratum_large_base_font_size'   => 18,
		'stratum_base_line_height'       => 1.75,
		'stratum_site_layout'            => 'boxed',
		'stratum_header_alignment'       => 'left',
		'stratum_main_menu_alignment'    => 'left',
		'stratum_nav_search'             => 1,
		'stratum_footer_alignment'       => 'center',
		'stratum_sticky_main_menu'       => 1,
		'stratum_custom_header_position' => 'above-main-nav',
		'stratum_excerpt_option'         => 'excerpt',
		'stratum_excerpt_length'         => 40,
		'stratum_excerpt_teaser'         => esc_html__( 'Read More', 'stratum' ),
		'stratum_thumbnails_display'     => 'large_above',
		'stratum_copyright'              => '[site_title] [copy_symbol] [current_year]',
		'stratum_show_date'              => 1,
		'stratum_show_author'            => 1,
		'stratum_show_comment_link'      => 1,
		'stratum_show_cat'               => 1,
		'stratum_show_tags'              => 1,
		'stratum_show_author_box'        => 1,
		'stratum_show_prevnext'          => 1,
	) );

	if ( 'all' === $option ) {
		return $stratum_defaults;
	} elseif ( isset( $stratum_defaults[ $option ] ) ) {
		return $stratum_defaults[ $option ];
	}

	return '';
}
