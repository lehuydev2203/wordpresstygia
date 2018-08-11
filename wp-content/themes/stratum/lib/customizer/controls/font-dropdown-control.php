<?php
/**
 * Custom Customize API: Stratum_Font_Dropdown_Control class
 *
 * @package Stratum
 * @since 1.0.0
 */

/**
 * Customize Custom fonts dropdown control class.
 *
 * @since 1.0.0
 */
class Stratum_Font_Dropdown_Control extends WP_Customize_Control {

	/**
	 * Type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'select';

	/**
	 * Render the content of the category dropdown
	 *
	 * @since 1.0.0
	 */
	public function render_content() {
		?>
		<label>
			<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<select <?php $this->link(); ?> class="fonts">
				<?php
				$fonts = Stratum_Customizer_Data::get_google_sans_fonts_list();
				if ( ! empty( $fonts ) ) {
					printf( '<optgroup label="%s" class="google_label">', sprintf( __( 'Sans Serif web fonts', 'stratum' ) ) ); // WPCS : xss ok.
					foreach ( $fonts as $font ) {
						printf( '<option value="%s" %s>%s</option>', esc_attr( $font ), selected( $this->value(), $font, false ), esc_html( $font ) );
					}
					printf( '</optgroup>' );
				}
				$fonts = Stratum_Customizer_Data::get_google_serif_fonts_list();
				if ( ! empty( $fonts ) ) {
					printf( '<optgroup label="%s" class="google_label">', sprintf( __( 'Serif web fonts', 'stratum' ) ) ); // WPCS : xss ok.
					foreach ( $fonts as $font ) {
						printf( '<option value="%s" %s>%s</option>', esc_attr( $font ), selected( $this->value(), $font, false ), esc_html( $font ) );
					}
					printf( '</optgroup>' );
				}
				?>
			</select>
		</label>
		<?php
	}
}
