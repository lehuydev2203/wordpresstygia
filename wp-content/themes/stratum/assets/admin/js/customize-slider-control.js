/**
 * customizer-control.js
 */
jQuery( window ).load( function () {
	/**
	 * Range Slider
	 */
	jQuery( '.customize-control-range-slider' ).each( function ( index, el ) {
		var range_Control = jQuery( el ),
			range_Input = range_Control.find( '.slider-input' ),
			range_Slider = range_Control.find( '.slider' ),
			range_Default = range_Control.find( '.stratum-slider-default-value' ),
			range_Min = parseFloat( range_Slider.attr( 'data-min' ) ) || 0,
			range_Max = parseFloat( range_Slider.attr( 'data-max' ) ) || 9999,
			range_Step = parseFloat( range_Slider.attr( 'data-step' ) ) || 1;
		/**
		 * Slider initialize
		 */
		range_Slider.slider( {
			value: range_Input.val(),
			min: range_Min,
			max: range_Max,
			step: range_Step,
			slide: function ( event, ui ) {
				range_Input.val( ui.value ).change();
				range_Input.val( ui.value );
			}
		} );
		/**
		 * Slider input change
		 */
		range_Input.change( function () {
			var current_value = this.value || '';
			if ( '' !== current_value ) {
				current_value = parseFloat( current_value );
			}
			range_Slider.slider( 'value', current_value );
		} );
		/**
		 * Slider reset default value
		 */
		range_Default.on( 'click', function ( e ) {
			e.preventDefault();
			var default_value = jQuery( this ).data( 'default-value' ) || '';
			if ( '' !== default_value ) {
				default_value = parseFloat( default_value );
			}
			range_Input.attr( 'value', default_value ).trigger( 'change' );
		} );
	} );
} );
/**
 * Control Constructor
 */
( function ( $, api ) {
	api.controlConstructor[ 'range-slider' ] = api.Control.extend( {
		ready: function () {
			var control = this;
			$( '.slider-input', control.container ).on( 'change keyup', function () {
				control.setting.set( $( this ).val() );
			} );
		}
	} );
} )( jQuery, wp.customize );
