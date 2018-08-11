<?php
/**
 * Custom Customize API: Stratum_Slider_Control class
 *
 * @package Stratum
 * @since 1.0.0
 */

/**
 * Customize Custom fonts dropdown control class.
 *
 * @since 1.0.0
 */
class Stratum_Slider_Control extends WP_Customize_Control {

	/**
	 * Type.
	 *
	 * @access public
	 * @var string
	 */
	public $type = 'range-slider';

	/**
	 * Default
	 *
	 * @access public
	 * @var string
	 */
	public $default_value = '';

	/**
	 * Unit
	 *
	 * @access public
	 * @var string
	 */
	public $unit = '';

	/**
	 * Convert option data in JSON.
	 *
	 * @since 1.0.0
	 */
	public function to_json() {
		parent::to_json();
		$this->json['id']          = $this->id;
		$this->json['min']         = $this->input_attrs['min'];
		$this->json['max']         = $this->input_attrs['max'];
		$this->json['step']        = $this->input_attrs['step'];
		$this->json['unit']        = $this->unit;
		$this->json['link']        = $this->get_link();
		$this->json['value']       = $this->value();
		$this->json['default']     = $this->default_value;
		$this->json['reset_title'] = esc_attr_x( 'Reset', 'Reset the slider customizer control value.', 'stratum' );
	}

	/**
	 * Content template to render slider control.
	 *
	 * @since 1.0.0
	 */
	public function content_template() {
		?>
		<label>
			<p>
				<span class="customize-control-title">{{ data.label }}</span>
				<span class="value">
					<input name="{{ data.id }}" type="number" {{{ data.link }}} value="{{{ data.value }}}" class="slider-input" min="{{data.min}}" max="{{data.max}}" step="{{data.step}}" />
					<span class="px">{{ data.unit }}</span>
				</span>
			</p>
		</label>
		<div class="slider stratum-flat-slider show-reset" data-min="<# if ( data.min ) { #>{{data.min}}<# } #>" data-max="<# if ( data.max ) { #>{{data.max}}<# } #>" data-step="<# if ( data.step ) { #>{{data.step}}<# } #>" ></div>
		<span title="{{ data.reset_title }}" class="stratum-slider-default-value" data-default-value="{{ data.default }}">
			<span class="dashicons dashicons-image-rotate" aria-hidden="true"></span>
			<span class="screen-reader-text">{{ data.reset_title }}</span>
		</span>
		<?php
	}

	/**
	 * Enqueue range slider scripts and styles.
	 *
	 * @since 1.0.0
	 */
	public function enqueue() {
		wp_enqueue_script(
			'stratum-slider-js',
			get_template_directory_uri() . '/assets/admin/js/customize-slider-control.js',
			array( 'jquery-ui-core', 'jquery-ui-slider', 'customize-controls' ),
			'1.0.0',
			true
		);
		wp_enqueue_style(
			'stratum-ui-slider',
			get_template_directory_uri() . '/assets/admin/css/jquery-ui.structure.css'
		);

		wp_enqueue_style(
			'stratum-flat-slider',
			get_template_directory_uri() . '/assets/admin/css/range-slider.css'
		);
	}
}
