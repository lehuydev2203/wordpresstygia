<?php
/**
 * The template part for displaying post thumbnails
 *
 * @package Stratum
 * @since 1.0.0
 */

?>
<div <?php stratum_attr( 'single-thumb' ); ?>>

	<?php
	the_post_thumbnail( 'large', array(
		'alt'   => the_title_attribute( 'echo=0' ),
		'class' => 'aligncenter',
	) );
	?>

</div>
