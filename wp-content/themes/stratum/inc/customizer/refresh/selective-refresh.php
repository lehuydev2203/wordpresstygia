<?php
/**
 * Theme customizer selective refresh render callback functions.
 *
 * @package	 Stratum
 * @since 1.0.0
 */

/**
 * Render the content sidebar wrap for the selective refresh partial.
 *
 * @since 1.0.0
 *
 * @return void
 */
function stratum_customize_partial_cs_wrap() {?>
	<div<?php stratum_attr( 'content-sidebar-wrap' ); ?>>

		<div id="primary"<?php stratum_attr( 'content-area' ); ?>>

			<?php do_action( 'stratum_hook_before_main_content' ); ?>

			<main id="main" role="main"<?php stratum_attr( 'site-main' ); ?>>

				<?php
				if ( have_posts() ) :
					do_action( 'stratum_hook_for_main_loop' );
				else :
					get_template_part( 'lib/template-parts/content/none' );
				endif;
				?>

			</main><!-- #main -->

			<?php do_action( 'stratum_hook_after_main_content' ); ?>

		</div><!-- #primary -->

		<?php get_sidebar(); ?>

	</div><!-- .content-sidebar-wrap -->
<?php
}

/**
 * Render the site main content for the selective refresh partial.
 *
 * @since 1.0.0
 *
 * @return void
 */
function stratum_customize_partial_main_content() {
	if ( have_posts() ) :
		do_action( 'stratum_hook_for_main_loop' );
	else :
		get_template_part( 'lib/template-parts/content/none' );
	endif;
}

/**
 * Render the copyright text for the selective refresh partial.
 *
 * @since 1.0.0
 *
 * @return void
 */
function stratum_customize_partial_copyright() {
	?>
	<span<?php stratum_attr( 'copyright-text' ); ?>>
		<?php echo stratum_render_copyright_info(); ?>
	</span><!-- .copyright-text -->
	<?php
}

/**
 * Hide Customizer Shortcut Controls for main content
 *
 * @since 1.0.0
 *
 * @param  string $css Stratum inline css.
 */
function stratum_disable_main_customizer_shortcuts( $css ) {
	if ( is_customize_preview() ) {
		$css .= '#main .customize-partial-edit-shortcut{display: none!important;}';
	}

	return $css;
}
add_action( 'stratum_get_inline_style', 'stratum_disable_main_customizer_shortcuts' );
