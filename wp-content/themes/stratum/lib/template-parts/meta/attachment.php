<?php
/**
 * The template part for displaying image attachment meta information
 *
 * @package Stratum
 * @since 1.0.0
 */

if ( ! is_attachment() || ! wp_attachment_is_image() ) {
	return;
}

// Retrieve attachment metadata.
$stratum_metadata = wp_get_attachment_metadata();
?>

<span class="full-size-link">
	<span class="screen-reader-text"><?php esc_html_e( 'Full size attachment link', 'stratum' ); ?></span>
	<a href="<?php esc_url( wp_get_attachment_url() ); ?>">
		<?php $stratum_metadata['width']; ?> &times; <?php $stratum_metadata['height']; ?>
	</a>
</span><!-- .full-size-link -->
