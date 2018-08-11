<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the
 * current comments and the comment form.
 *
 * @link https://codex.wordpress.org/Comments_in_WordPress
 *
 * @package Stratum
 * @since 1.0.0
 */

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<?php
/**
 * Fires immediately before opening comments-area.
 *
 * @since 1.0.0
 */
do_action( 'stratum_hook_before_comments' );
?>

<div id="comments"<?php stratum_attr( 'comments-area' ); ?>>

	<?php if ( have_comments() ) : ?>
		<div <?php stratum_attr( 'entry-comments' ); ?>>

			<?php
			/**
			 * Fires immediately before comment list.
			 *
			 * @since 1.0.0
			 */
			do_action( 'stratum_hook_on_top_of_comments' );
			?>

			<ol<?php stratum_attr( 'comment-list' ); ?>>

				<?php

				/*
				 * Loop through and list the comments. Tell wp_list_comments()
				 * to use Stratum_Display::comments() to format the comments which is
				 * located in lib/classes/display.php.
				 */
				wp_list_comments( array(
					'callback' => array( 'Stratum_Display', 'comments' ),
				) );
				?>

			</ol><!-- .comment-list -->

			<?php
			/**
			 * Fires immediately after comment list.
			 *
			 * @since 1.0.0
			 */
			do_action( 'stratum_hook_bottom_of_comments' );
			?>

		</div><!-- .entry-comments -->
	<?php
	endif; // Check for have_comments().

	// If comments are closed and there are comments, let's leave a little note.
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p<?php stratum_attr( 'no-comments' ); ?>><?php esc_html_e( 'Comments are closed.', 'stratum' ); ?></p>
	<?php endif; ?>

	<?php if ( have_comments() ) : ?>
		<?php
		comment_form( array(
			'title_reply_before' => '<h3 id="reply-title"' . stratum_get_attr( 'comment-reply-title' ) . '>',
		) );
		?>
	<?php else : ?>
		<?php
		comment_form( array(

			/*
			 * Reply title modified to address following accessibility issue,
			 * On single post view & Pages, 'Leave a Reply' skips a heading
			 * level by jumping from H1 > H3 if there are no comments.
			 */
			'title_reply_before' => '<h2 id="reply-title"' . stratum_get_attr( 'comment-reply-title' ) . '>',
			'title_reply_after'  => '</h2>',
		) );
		?>
	<?php endif; ?>

</div><!-- #comments -->

<?php
/**
 * Fires immediately after closing comments-area.
 *
 * @since 1.0.0
 */
do_action( 'stratum_hook_after_comments' );
