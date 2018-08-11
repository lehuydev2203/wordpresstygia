<?php
/**
 * The template part for displaying entry title for current post
 *
 * @package Stratum
 * @since 1.0.0
 */

if ( is_singular() && ! is_page_template( 'page-template/page-portfolio.php' ) ) :
	the_title( sprintf( '<h1%1$s>', stratum_get_attr( 'entry-title' ) ), '</h1>' );
else :
	the_title( sprintf( '<h2%1$s><a href="%2$s" rel="bookmark">', stratum_get_attr( 'entry-title' ), esc_url( get_permalink() ) ), '</a></h2>' );
endif;
