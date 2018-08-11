<?php
/**
 * Template Name: JetPack Portfolio Page Template
 *
 * @package Stratum
 * @since 1.0.0
 */

get_header(); ?>

	<div<?php stratum_attr( 'content-sidebar-wrap' ); ?>>

		<div id="primary"<?php stratum_attr( 'content-area' ); ?>>

			<main id="main" role="main"<?php stratum_attr( 'site-main' ); ?>>

				<?php
				while ( have_posts() ) :
					the_post();
					?>
					<article id="post-<?php the_ID(); ?>" class="portfolio-page-content">
						<?php
						the_title( '<header class="entry-header"><h1 class="page-title">', '</h1></header>' );
						?>
						<div<?php stratum_attr( 'entry-content' ); ?>>
							<?php
							the_content( sprintf(
								/* translators: %s: post title */
								esc_html__( 'Continue reading %s', 'stratum' ),
								the_title( '<span class="screen-reader-text">', '</span>', false )
							) );

							/*
							 * Displays page-links for paginated posts (i.e. if the <!--nextpage-->
							 * Quicktag has been used for one or more times in a single post).
							 */
							wp_link_pages( array(
								'before' => '<div' . stratum_get_attr( 'page-links' ) . '>' . esc_html__( 'Pages:', 'stratum' ),
								'after'  => '</div>',
							) );

							edit_post_link(
								sprintf(
									/* translators: %s: Name of current post */
									__( 'Edit<span class="screen-reader-text"> "%s"</span>', 'stratum' ),
									get_the_title()
								),
								'<span' . stratum_get_attr( 'edit-link' ) . '>',
								'</span>'
							);
							?>
						</div>
					</article><!-- #post-## -->
					<?php
					if ( ! defined( 'JETPACK__VERSION' ) ) {
						if ( comments_open() || get_comments_number() ) {
							// If comments are open or we have at least one comment, load up the comment template.
							comments_template();
						}
					}
					?>
				<?php
				endwhile;

				if ( defined( 'JETPACK__VERSION' ) ) {
					if ( get_query_var( 'paged' ) ) :
						$paged = get_query_var( 'paged' );
					elseif ( get_query_var( 'page' ) ) :
						$paged = get_query_var( 'page' );
					else :
						$paged = 1;
					endif;

					$posts_per_page = get_option( 'jetpack_portfolio_posts_per_page', '9' );

					$args = array(
						'post_type'      => 'jetpack-portfolio',
						'paged'          => $paged,
						'posts_per_page' => $posts_per_page,
					);

					$project_query = new WP_Query( $args );

					if ( $project_query->have_posts() ) :
					?>
						<div class="grid-wrapper">
							<?php
							get_template_part( 'addon/jetpack/project-type-filter' );
							while ( $project_query->have_posts() ) :
								$project_query->the_post();
								get_template_part( 'lib/template-parts/content/content' );
							endwhile;
							?>
						</div>

						<?php
						if ( $project_query->max_num_pages > 1 ) :
							$max_num_pages = $project_query->max_num_pages;
						?>
						<nav class="navigation portfolio-navigation">
							<h1 class="screen-reader-text"><?php esc_html_e( 'Posts navigation', 'stratum' ); ?></h1>
							<div class="nav-links">
								<?php if ( get_next_posts_link( '', $max_num_pages ) ) : ?>
								<div class="nav-next">
									<?php next_posts_link( stratum_get_icon( array( 'icon' => 'arrow-left' ) ) . __( '<span class="meta-nav">Next</span>', 'stratum' ), $max_num_pages ); ?>
								</div>
								<?php endif; ?>
								<?php if ( get_previous_posts_link( '', $max_num_pages ) ) : ?>
								<div class="nav-previous"><?php previous_posts_link( __( '<span class="meta-nav">Previous</span>', 'stratum' ) . stratum_get_icon( array( 'icon' => 'arrow-right' ) ), $max_num_pages ); ?></div>
								<?php endif; ?>
							</div><!-- .nav-links -->
						</nav><!-- .navigation -->
						<?php
						endif;
						wp_reset_postdata();
					endif;
				}
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
