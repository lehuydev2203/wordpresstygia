<?php
/**
 * Customizer sanitization
 *
 * Handles santization of theme customizer options.
 *
 * @package Stratum
 * @since 1.0.0
 */

/**
 * Sanitization callback functions library for theme customizer.
 *
 * @since 1.0.0
 */
abstract class Stratum_Sanitization {
	/**
	 * Abstract sanitization function.
	 *
	 * Keep abstract function public as it will be called by 'sanitize_callback'
	 * WordPress filter from outside of the class.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param  Mixed                $option  Selected customizer option.
	 * @param  WP_Customize_Setting $setting Setting instance.
	 */
	abstract public function sanitization( $option, $setting );

	/**
	 * Returns sanitized customizer options.
	 *
	 * @since 1.0.0
	 * @access protected
	 *
	 * @param  Mixed                $option  Selected customizer option.
	 * @param  WP_Customize_Setting $setting Setting instance.
	 * @return Mixed Returns sanitized value.
	 */
	protected function get_sanitized_value( $option, $setting ) {
		$type = $setting->manager->get_control( $setting->id )->type;
		switch ( $type ) {
			case 'select':
				$sanitized_value = $this->sanitize_select( $option, $setting );
				break;

			case 'checkbox':
				$sanitized_value = $this->sanitize_checkbox( $option );
				break;

			case 'number':
				$sanitized_value = $this->sanitize_number( $option, $setting );
				break;

			case 'range':
				$sanitized_value = $this->sanitize_number( $option, $setting );
				break;

			case 'range-slider':
				$sanitized_value = $this->sanitize_number( $option, $setting );
				break;

			case 'text':
				$sanitized_value = $this->sanitize_text( $option );
				break;

			case 'textarea':
				$sanitized_value = $this->sanitize_textarea( $option );
				break;

			case 'url':
				$sanitized_value = $this->sanitize_url( $option );
				break;

			case 'image':
				$sanitized_value = $this->sanitize_url( $option );
				break;

			case 'color':
				$sanitized_value = $this->sanitize_color( $option );
				break;

			default:
				$sanitized_value = $setting->default;
				break;
		} // End switch().
		return $sanitized_value;
	}

	/**
	 * Sanitize select choices.
	 *
	 * @since 1.0.0
	 * @access private
	 *
	 * @param str                  $option  Customizer Option selected.
	 * @param WP_Customize_Setting $setting Setting instance.
	 * @return string
	 */
	private function sanitize_select( $option, $setting ) {
		$choices = $setting->manager->get_control( $setting->id )->choices;
		if ( array_key_exists( $option, $choices ) ) :
			return $option;
		elseif ( in_array( $option, $choices, true ) ) :
			return $option;
		else :
			return $setting->default;
		endif;
	}

	/**
	 * Sanitize text.
	 *
	 * @since 1.0.0
	 * @access private
	 *
	 * @param str $option text.
	 * @return string
	 */
	private function sanitize_text( $option ) {
		return sanitize_text_field( $option );
	}

	/**
	 * Sanitize textarea.
	 *
	 * @since 1.0.0
	 * @access private
	 *
	 * @param str $option textarea.
	 * @return string
	 */
	private function sanitize_textarea( $option ) {
		return wp_kses_post( $option );
	}

	/**
	 * Sanitize url.
	 *
	 * @since 1.0.0
	 * @access private
	 *
	 * @param str $option url.
	 * @return string
	 */
	private function sanitize_url( $option ) {
		return esc_url_raw( $option );
	}

	/**
	 * Sanitize and Validate number
	 *
	 * @since 1.0.0
	 * @access private
	 *
	 * @param int                  $option  excerpt length.
	 * @param WP_Customize_Setting $setting Setting instance.
	 * @return integer
	 */
	private function sanitize_number( $option, $setting ) {
		if ( '' === $option && '' === $setting->default ) {
			return $setting->default;
		}

		$attr   = $setting->manager->get_control( $setting->id )->input_attrs;
		$option = abs( $option );

		if ( isset( $attr['max'] ) ) {
			$option = $option > $attr['max'] ? $attr['max'] : $option;
		}

		if ( isset( $attr['min'] ) ) {
			$option = $option < $attr['min'] ? $attr['min'] : $option;
		}

		if ( isset( $attr['step'] ) && is_float( $attr['step'] ) ) {
			$option = abs( floatval( $option ) );
		} else {
			$option = absint( $option );
		}

		if ( $option ) {
			return $option;
		}

		return $setting->default;
	}

	/**
	 * Validate checkbox value to be '1'
	 *
	 * @since  1.0.0
	 * @access private
	 *
	 * @param  bool $option checkbox value.
	 * @return bool
	 */
	private function sanitize_checkbox( $option ) {
		if ( 1 == $option ) :
			return 1;
		else :
			return '';
		endif;
	}

	/**
	 * Sanitizes a hex color.
	 *
	 * @since 1.0.1
	 * @access private
	 *
	 * @param str $option color.
	 * @return string|void
	 */
	private function sanitize_color( $option ) {
		return sanitize_hex_color( $option );
	}
}
