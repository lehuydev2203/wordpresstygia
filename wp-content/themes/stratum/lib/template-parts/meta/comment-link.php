<?php
/**
 * The template part for displaying link to write comment in current post
 *
 * @package Stratum
 * @since 1.0.0
 */

?>

<?php if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) : ?>
	<span<?php stratum_attr( 'comments-link' ); ?>>
		<?php
		comments_popup_link(
			/* translators: %s: post title */
			sprintf( wp_kses( __( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'stratum' ), array( 'span' => array( 'class' => array() ) ) ), get_the_title() )
		);
		?>
	</span>
<?php endif; ?>
