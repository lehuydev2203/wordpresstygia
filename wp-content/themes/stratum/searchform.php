<?php
/**
 * Display search form
 *
 * @link https://developer.wordpress.org/reference/functions/get_search_form
 *
 * @package Stratum
 * @since 1.0.0
 */

?>

<form role="search" method="get"<?php stratum_attr( 'search-form' ); ?> action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="label-search">
		<span class="screen-reader-text"><?php echo esc_html_x( 'Search for:', 'label', 'stratum' ); ?></span>
		<input type="search"<?php stratum_attr( 'search-field' ); ?> placeholder="<?php echo esc_attr_x( 'Search', 'placeholder', 'stratum' ); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'stratum' ); ?>" />
	</label>
	<span class="search-icon"><?php stratum_icon( array( 'icon' => 'search' ) ); ?><span class="screen-reader-text"><?php echo esc_html_x( 'Search', 'submit icon', 'stratum' ); ?></span></span>
	<?php

	/*
	Search submit button not required for this theme.
	<button type="submit" class="search-submit"><?php stratum_icon( array( 'icon' => 'search' ) ); ?><span class="screen-reader-text"><?php echo esc_html_x( 'Search', 'submit button', 'stratum' ); ?></span></button>
	*/
	?>
</form>
