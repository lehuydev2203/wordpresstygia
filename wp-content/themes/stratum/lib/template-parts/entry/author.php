<?php
/**
 * The template part for displaying an author biography
 *
 * This file incorporates code from Twenty Fifteen WordPress Theme,
 * Copyright 2014-2016 WordPress.org & Automattic.com Twenty Fifteen is
 * distributed under the terms of the GNU GPL.
 *
 * @package Stratum
 * @since 1.0.0
 */

?>

<div<?php stratum_attr( 'author-info' ); ?>>

	<?php
	/**
	 * Filter author bio avatar size.
	 *
	 * @since 1.0.0
	 */
	$stratum_author_avatar_size = apply_filters( 'stratum_author_bio_avatar_size', 120 );
	echo get_avatar( get_the_author_meta( 'user_email' ), $stratum_author_avatar_size );
	?>

	<div<?php stratum_attr( 'author-description' ); ?>>
		<h2<?php stratum_attr( 'author-title' ); ?>><span class="screen-reader-text"><?php esc_html_e( 'Author', 'stratum' ); ?></span><?php the_author(); ?></h2>

		<p<?php stratum_attr( 'author-bio' ); ?>>
			<?php the_author_meta( 'description' ); ?>
			<p><a<?php stratum_attr( 'author-link' ); ?> href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
				<?php
				/* translators: %s: post author */
				printf( esc_html__( 'View all posts by %s', 'stratum' ), get_the_author() );
				?>
			</a></p>
		</p><!-- .author-bio -->
	</div><!-- .author-description -->
</div><!-- .author-info -->
