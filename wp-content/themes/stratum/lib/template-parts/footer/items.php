<?php
/**
 * Template part for displaying footer items
 *
 * @package Stratum
 * @since 1.0.0
 */

?>

<div<?php stratum_attr( 'footer-items' ); ?>>

	<div<?php stratum_attr( 'wrap' ); ?>>

		<?php // Display Copyright text. ?>
		<div<?php stratum_attr( 'footer-text' ); ?>>
			<span class="copyright-text">
				<?php echo stratum_render_copyright_info(); ?>
			</span>
			<span class="sep"> &middot; </span>
			<?php
			printf(
				/* translators: %s: Theme author */
				esc_html__( 'Theme by %1$s', 'stratum' ),
				// Note: URI is escaped via `WP_Theme::markup_header()`.
				'<a href="' . wp_get_theme( get_template() )->display( 'AuthorURI' ) . '" rel="designer">PremiumWP</a>'
			);
			?>
			<span class="sep"> &middot; </span>
			<?php
			printf(
				/* translators: %s: WordPress */
				esc_html__( 'Powered by %1$s', 'stratum' ),
				'<a href="' . esc_url( __( 'https://wordpress.org/', 'stratum' ) ) . '">WordPress</a>'
			);
			?>
		</div><!-- .copyright-text -->

	</div><!-- .wrap -->

</div><!-- .footer-items -->
