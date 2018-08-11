<?php
/**
 * Display post content
 *
 * Template part file that contains the default Post content,
 * including Post header, Post entry, and Post footer.
 *
 * @package Stratum
 * @since 1.0.0
 */

/**
 * Fires immediately before post content.
 *
 * @since 1.0.0
 */
do_action( 'stratum_hook_before_entry' ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?><?php stratum_attr( 'post' ); ?>>

	<?php
	/**
	 * Fires immediately after opening of post content.
	 *
	 * @since 1.0.0
	 */
	do_action( 'stratum_hook_on_top_of_entry' );
	?>

	<header<?php stratum_attr( 'entry-header' ); ?>>

		<?php
		/**
		 * Fires immediately before closing of entry header.
		 *
		 * @since 1.0.0
		 */
		do_action( 'stratum_hook_for_entry_header' );
		?>

	</header><!-- .entry-header -->

	<?php
	/**
	 * Fires immediately before entry content.
	 *
	 * @since 1.0.0
	 */
	do_action( 'stratum_hook_before_entry_content' );
	?>

	<div<?php stratum_attr( 'entry-content' ); ?>>

		<?php
		/**
		 * Fires immediately before closing of post content.
		 *
		 * @since 1.0.0
		 */
		do_action( 'stratum_hook_for_entry_content' );
		?>

	</div><!-- .entry-content -->

	<?php
	/**
	 * Fires immediately after entry content.
	 *
	 * @since 1.0.0
	 */
	do_action( 'stratum_hook_after_entry_content' );

	/**
	 * Fires immediately before closing of post content.
	 *
	 * @since 1.0.0
	 */
	do_action( 'stratum_hook_bottom_of_entry' );
	?>

</article><!-- #post-<?php the_ID(); ?> -->

<?php
/**
 * Fires immediately after post content.
 *
 * @since 1.0.0
 */
do_action( 'stratum_hook_after_entry' );
