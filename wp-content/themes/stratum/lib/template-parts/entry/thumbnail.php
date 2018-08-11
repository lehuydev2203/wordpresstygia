<?php
/**
 * The template part for displaying post thumbnails
 *
 * @package Stratum
 * @since 1.0.0
 */

/*
 * Even though post thumbnal link is a focusable element and screen-reader will
 * announce as 'blank' if we have 'area-hidden= "true"' in it. But, here
 * area-hidden is use as a non-verbose option to minimize repetition of data.
 * https://core.trac.wordpress.org/ticket/30076#comment:13
 */
?>

<a href="<?php the_permalink(); ?>" <?php stratum_attr( 'post-thumbnail' ); ?> aria-hidden="true">

	<?php
	the_post_thumbnail( 'post-thumbnail', array(
		'alt'   => the_title_attribute( 'echo=0' ),
		'class' => 'thumbnails aligncenter',
	) );
	?>

</a>
<?php
