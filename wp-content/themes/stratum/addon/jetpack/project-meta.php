<?php
/**
 * The template part for displaying footer meta information for current post
 *
 * @package Stratum
 * @since 1.0.0
 */

?>
<footer<?php stratum_attr( 'entry-footer' ); ?>>
	<?php $project_type = get_the_term_list( get_the_ID(), 'jetpack-portfolio-type', '', ', ', '' ); ?>
	<?php if ( $project_type ) : ?>
		<span<?php stratum_attr( 'cat-links' ); ?>>
			<?php
			printf( esc_html__( 'Project: ', 'stratum' ) );
			echo $project_type;
			?>
		</span>
	<?php endif; ?>
	<?php $project_tags = get_the_term_list( get_the_ID(), 'jetpack-portfolio-tag', '', ', ', '' ); ?>
	<?php if ( $project_tags ) : ?>
		<span<?php stratum_attr( 'tag-links' ) ?>>
			<?php
			printf( esc_html__( 'Tags: ', 'stratum' ) );
			echo $project_tags;
			?>
		</span>
	<?php endif; ?>
</footer><!-- .entry-footer -->
