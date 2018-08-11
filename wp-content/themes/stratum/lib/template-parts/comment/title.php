<?php
/**
 * The template part for displaying post comment title
 *
 * @package Stratum
 * @since 1.0.0
 */

?>

<h2<?php stratum_attr( 'comments-title' ); ?>>
	<?php
	printf(
		/* translators: 1: number of comments, 2: post title */
		_nx(
			'%1$s reply to %2$s',
			'%1$s replies to %2$s',
			get_comments_number(),
			'comments title',
			'stratum'
		),
		number_format_i18n( get_comments_number() ),
		'<span class="post-title">' . get_the_title() . '</span>'
	);
	?>
</h2>
