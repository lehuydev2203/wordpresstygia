<?php
/**
 * The template part for displaying footer meta information for current post
 *
 * @package Stratum
 * @since 1.0.0
 */

if ( get_theme_mod( 'stratum_jetpack_project_type', '' ) ) {
	$project_type = get_the_term_list( get_the_ID(), 'jetpack-portfolio-type', '', ' ,', '' );
	if ( $project_type ) :
	?>
		<div<?php stratum_attr( 'project-type-meta' ); ?>>
			<?php
			echo esc_html( $project_type );
			?>
		</div>
	<?php
	endif;
}

if ( get_theme_mod( 'stratum_jetpack_project_archive', '' ) ) {
	the_excerpt();
}
