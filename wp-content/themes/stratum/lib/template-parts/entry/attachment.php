<?php
/**
 * The template part for displaying entry content for current post
 *
 * @package Stratum
 * @since 1.0.0
 */

?>

<div class="entry-attachment">

	<?php
	/**
	 * Filter the default Stratum image attachment size.
	 *
	 * @since 1.0
	 *
	 * @param string $image_size Image size. Default 'large'.
	 */
	$image_size = apply_filters( 'stratum_attachment_size', 'large' );

	echo wp_get_attachment_image( get_the_ID(), $image_size );
	?>

	<?php if ( has_excerpt() ) : ?>
		<div class="entry-caption">
			<?php the_excerpt(); ?>
		</div><!-- .entry-caption -->
	<?php endif; ?>

</div><!-- .entry-attachment -->
