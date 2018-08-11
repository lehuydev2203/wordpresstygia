<?php
/**
 * The template part for displaying entry content for current post
 *
 * @package Stratum
 * @since 1.0.0
 */

the_content( sprintf(
	/* translators: %s: post title */
	esc_html__( 'Continue reading %s', 'stratum' ),
	the_title( '<span class="screen-reader-text">', '</span>', false )
) );

/*
 * Displays page-links for paginated posts (i.e. if the <!--nextpage-->
 * Quicktag has been used for one or more times in a single post).
 */
wp_link_pages( array(
	'before' => '<div' . stratum_get_attr( 'page-links' ) . '>' . esc_html__( 'Pages:', 'stratum' ),
	'after'  => '</div>',
) );
