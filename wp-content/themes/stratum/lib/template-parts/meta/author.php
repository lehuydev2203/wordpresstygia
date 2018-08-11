<?php
/**
 * The template part for displaying current post author name
 *
 * @package Stratum
 * @since 1.0.0
 */

?>

<span<?php stratum_attr( 'byline' ); ?>>
	<span<?php stratum_attr( 'author' ); ?>>
		<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"<?php stratum_attr( 'url' ); ?>>
			<?php esc_html_e( 'By', 'stratum' ); ?>
			<span<?php stratum_attr( 'name' ); ?>> <?php the_author(); ?></span>
		</a>
	</span>
</span>
