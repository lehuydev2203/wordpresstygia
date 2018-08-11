<?php
/**
 * The template part for displaying tags of current post
 *
 * @package Stratum
 * @since 1.0.0
 */

?>

<?php $tags_list = get_the_tag_list( '', _x( ', ', 'Used between list items, there is a space after the comma.', 'stratum' ) ); ?>
<?php if ( $tags_list ) : ?>
	<span<?php stratum_attr( 'tags-links' ); ?>>
		<?php
		printf( esc_html__( 'Tagged With : ', 'stratum' ) );
		echo $tags_list;
		?>
	</span>
<?php endif; ?>
