<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Stratum
 * @since 1.0.0
 */

get_header(); ?>

	<div<?php stratum_attr( 'content-sidebar-wrap' ); ?>>

		<div id="primary"<?php stratum_attr( 'content-area' ); ?>>

			<?php
			/**
			 * Fires immediately after opening of primary content area.
			 *
			 * @since 1.0.0
			 */
			do_action( 'stratum_hook_before_main_content' );
			?>

			<main id="main" role="main"<?php stratum_attr( 'site-main' ); ?>>

				<?php
				if ( have_posts() ) :

					/**
					 * Fires immediately before executing main loop.
					 *
					 * @since 1.0.0
					 */
					do_action( 'stratum_hook_for_main_loop' );

				else :

					/**
					 * Include template if no content is available.
					 */
					get_template_part( 'lib/template-parts/content/none' );
				endif;
				?>

			</main><!-- #main -->

			<?php
			/**
			 * Fires immediately before closing primary content area.
			 *
			 * @since 1.0.0
			 */
			do_action( 'stratum_hook_after_main_content' );
			?>

		</div><!-- #primary -->

		<?php get_sidebar(); ?>

	</div><!-- .content-sidebar-wrap -->

<?php
get_footer();
