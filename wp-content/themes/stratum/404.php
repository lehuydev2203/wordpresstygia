<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Stratum
 * @since 1.0.0
 */

get_header(); ?>

	<div<?php stratum_attr( 'content-sidebar-wrap' ); ?>>
		<div id="primary"<?php stratum_attr( 'content-area' ); ?>>
			<main id="main" role="main"<?php stratum_attr( 'site-main' ); ?>>

				<section<?php stratum_attr( 'error-404' ); ?>>
					<header<?php stratum_attr( 'page-header' ); ?>>
						<h1<?php stratum_attr( 'page-title' ); ?>>
							<?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'stratum' ); ?>
						</h1>
					</header><!-- .page-header -->

					<div<?php stratum_attr( 'page-content' ); ?>>
						<h2><?php esc_html_e( 'We tried to find it, but it\'s just not to be found.', 'stratum' ); ?></h2>
						<p><?php esc_html_e( 'You might ensure the URL is spelled correctly, or if you followed a link here please let us know. Please try a search to reach your desired destination.', 'stratum' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .page-content -->
				</section><!-- .error-404 -->

			</main><!-- #main -->
		</div><!-- #primary -->
		<?php get_sidebar(); ?>
	</div><!-- .content-sidebar-wrap -->

<?php
get_footer();
