<?php
/**
 * The template part for displaying portfolio project type filter.
 *
 * @package Stratum
 * @since 1.0.0
 */

if ( is_post_type_archive( 'jetpack-portfolio' ) || is_page_template( 'page-template/page-portfolio.php' ) ) {
	$stratum_terms = get_terms( 'jetpack-portfolio-type' );
} elseif ( 'jetpack-portfolio-type' === get_queried_object()->taxonomy ) {
	$stratum_terms = get_terms( 'jetpack-portfolio-type' );
} elseif ( 'jetpack-portfolio-tag' === get_queried_object()->taxonomy ) {
	$stratum_terms = get_terms( 'jetpack-portfolio-tag' );
} else {
	$stratum_terms = '';
}

if ( empty( $stratum_terms ) ) {
	return;
}
?>

<ul class="project-type-filter">
	<li class="project-type">
		<a href="<?php echo esc_url( get_post_type_archive_link( 'jetpack-portfolio' ) ); ?>" rel="jetpack-portfolio-type">
			<?php esc_html_e( 'All', 'stratum' ); ?>
		</a>
	</li><!-- .project-type -->

	<?php
	foreach ( $stratum_terms as $term ) {
		$class       = 'project-type';
		$link        = get_term_link( $term, $term->taxonomy );
		$current_url = sprintf( '%1$s%2$s%3$s', is_ssl() ? 'https://' : 'http://', $_SERVER['HTTP_HOST'], $_SERVER['REQUEST_URI'] );
		if ( $link == $current_url ) {
			$class .= ' ' . 'current-project-type';
			?>
			<li class="<?php echo $class; ?>">
				<?php echo esc_html( $term->name ); ?>
			</li>
			<?php
		} else {
			?>
			<li class="<?php echo $class; ?>">
				<a href="<?php echo esc_url( $link ); ?>" rel="<?php echo esc_attr( $term->taxonomy ); ?>"><?php echo esc_html( $term->name ); ?></a>
			</li>
			<?php
		}
	}
	?>
</ul><!-- .project-type-filter -->
