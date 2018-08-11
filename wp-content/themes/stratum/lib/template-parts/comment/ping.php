<?php
/**
 * The template part for displaying post pingbacks and trackbacks
 *
 * @link https://themeshaper.com/2012/11/04/the-wordpress-theme-comments-template/
 *
 * @package Stratum
 * @since 1.0.0
 */

$stratum_url    = get_comment_author_url();
$stratum_author = get_comment_author();

?>

<li<?php stratum_attr( 'pingback' ); ?>>
	<p>
		<?php printf( esc_html__( 'Pingback:', 'stratum' ) ); ?>

		<?php if ( empty( $stratum_url ) ) : ?>
			<span<?php stratum_attr( 'name' ); ?>><?php echo esc_html( $stratum_author ); ?></span>
		<?php else : ?>
			<a href="<?php echo esc_url( $stratum_url ); ?>"<?php stratum_attr( 'url' ); ?>><span<?php stratum_attr( 'name' ); ?>><?php echo esc_html( $stratum_author ); ?></span></a>
		<?php endif; ?>

		<?php edit_comment_link( esc_html__( '(Edit)', 'stratum' ) ); ?>
	</p>

<?php
// No closing 'li' is needed.  WordPress will know where to add it.
