<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @package Stratum
 * @since 1.0.0
 */

?>

<section<?php stratum_attr( 'no-results' ); ?>>
	<header<?php stratum_attr( 'page-header' ); ?>>
		<h1<?php stratum_attr( 'page-title' ); ?>><?php esc_html_e( 'Nothing Found', 'stratum' ); ?></h1>
	</header><!-- .page-header -->

	<div<?php stratum_attr( 'page-content' ); ?>>

		<?php

		/*
		 * Message to be shown if there are no posts on home page (Nothing has been
		 * published so far) and current user can publish a new post.
		 */
		?>
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
			<p><?php printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'stratum' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>
		<?php
		elseif ( is_search() ) :
			// Message to be shown if no results found for a search query.
			?>
			<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'stratum' ); ?></p>
			<?php get_search_form(); ?>
		<?php
		else :
			/*
			 * Message to be shown for any other situation (where posts cannot be
			 * found) then the two mentioned above.
			 */
			?>
			<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'stratum' ); ?></p>
			<?php get_search_form(); ?>
		<?php endif; ?>
	</div><!-- .page-content -->
</section><!-- .no-results -->
