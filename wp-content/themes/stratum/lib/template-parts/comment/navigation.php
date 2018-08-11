<?php
/**
 * The template part for displaying post comment navigation
 *
 * @package Stratum
 * @since 1.0.0
 */

$stratum_prev_link = get_previous_comments_link();
$stratum_next_link = get_next_comments_link();
?>

<nav id="comment-nav" <?php stratum_attr( 'comment-navigation' ); ?>>
	<h2 class="screen-reader-text"><?php printf( esc_html__( 'Comment navigation', 'stratum' ) ); ?></h2>

	<div<?php stratum_attr( 'nav-links' ); ?>>
		<?php if ( $stratum_prev_link ) : ?>
			<div<?php stratum_attr( 'nav-previous' ); ?>>
				<?php echo $stratum_prev_link; ?>
			</div>
		<?php endif; ?>

		<?php if ( $stratum_next_link ) : ?>
			<div<?php stratum_attr( 'nav-next' ); ?>>
				<?php echo $stratum_next_link; ?>
			</div>
		<?php endif; ?>
	</div>
</nav>
