<?php
/**
 * The template part for displaying header text
 *
 * Display site title and site description.
 *
 * @package Stratum
 * @since 1.0.0
 */

?>

<div<?php stratum_attr( 'title-area' ); ?>>

	<?php if ( is_front_page() && is_home() ) : ?>
		<h1<?php stratum_attr( 'site-title' ); ?>>
			<a href= "<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
		</h1>
	<?php else : ?>
		<p<?php stratum_attr( 'site-title' ); ?>>
			<a href= "<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
		</p>
	<?php
	endif;

	$description = get_bloginfo( 'description', 'display' );
	?>

	<?php if ( $description || is_customize_preview() ) : ?>
		<p<?php stratum_attr( 'site-description' ); ?>>
			<?php echo $description; ?>
		</p>
	<?php endif; ?>

</div><!-- .title-area -->
