<?php
/**
 * The template for displaying archive pages.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Stratum
 * @since 1.0.0
 */

if ( is_home() && ! is_front_page() ) :?>

	<header<?php stratum_attr( 'page-header', array( 'class' => 'screen-reader-text' ) ); ?>>
		<h1<?php stratum_attr( 'page-title' ); ?>><?php single_post_title(); ?></h1>
	</header><!-- .page-header -->

<?php
elseif ( is_archive() && ! is_post_type_archive( 'jetpack-portfolio' ) ) :

	if ( is_tax() && in_array( get_queried_object()->taxonomy, array( 'jetpack-portfolio-type', 'jetpack-portfolio-tag' ), true ) ) {
		return;
	}
	?>

	<header<?php stratum_attr( 'page-header' ); ?>>
		<?php
		the_archive_title( sprintf( '<h1%1$s>', stratum_get_attr( 'page-title' ) ), '</h1>' );
		the_archive_description( sprintf( '<div%1$s>', stratum_get_attr( 'taxonomy-description' ) ), '</div>' );
		?>
	</header><!-- .page-header -->

<?php
elseif ( is_search() ) :
?>

	<header<?php stratum_attr( 'page-header' ); ?>>
		<h1<?php stratum_attr( 'page-title' ); ?>>
			<?php
			/* translators: %s: search query */
			printf( esc_html__( 'Search Results for: %s', 'stratum' ), '<span>' . get_search_query() . '</span>' );
			?>
		</h1>
	</header><!-- .page-header -->

<?php
endif;
