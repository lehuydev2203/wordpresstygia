<?php
/**
 * Custom Customize API: Stratum_Sub_Sections class
 *
 * @package Stratum
 * @since 1.0.0
 */

/**
 * Customize Custom sub section label.
 *
 * @since 1.0.0
 */
class Stratum_Sub_Sections extends WP_Customize_Control {

	/**
	 * Type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'sub-section';

	/**
	 * Content template to render slider control.
	 *
	 * @since 1.0.0
	 */
	public function render_content() {
		?>
		<label class="customizer-text">
			<?php if ( $this->label ) { ?>
				<span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
			<?php } ?>
			<?php if ( $this->description ) { ?>
				<span class="description customize-control-description"><?php echo esc_html( $this->description ); ?></span>
			<?php } ?>
		</label>
		<?php
	}
}
