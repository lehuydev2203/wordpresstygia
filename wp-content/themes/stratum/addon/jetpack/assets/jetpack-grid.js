/**
 * Grid layout.
 */

( function ( $ ) {
	var scrollTimer = null;

	$.fn.matchHeight = function() {

		var $this = $(this),
			len;

		if ( $( 'body' ).hasClass( 'twocol-grid' ) || ( $( 'body' ).hasClass( 'threecol-grid' ) && $( window ).width() < 1200 ) ) {
			for (var i = 0, len = $this.length; i < len-1; i++) {
				maxHeight = 0;
				for ( var j = 0; j < 2; j++ ) {
					if ( $this.eq( [i+j] ).outerHeight(false) > maxHeight ) {
						maxHeight = $this.eq( [i+j] ).outerHeight(false);
					}
				}

				for ( var j = 0; j < 2; j++ ) {
					$this.eq( [i+j] ).css( 'height', maxHeight );
				}
				i=i+1;
			}
		} else if ( $( 'body' ).hasClass( 'threecol-grid' ) ) {
			for (var i = 0, len = $this.length; i < len-2; i++) {
				maxHeight = 0;
				for ( var j = 0; j < 3; j++ ) {
					if ( $this.eq( [i+j] ).outerHeight(false) > maxHeight ) {
						maxHeight = $this.eq( [i+j] ).outerHeight(false);
					}
				}

				for ( var j = 0; j < 3; j++ ) {
					$this.eq( [i+j] ).css( 'height', maxHeight );
				}
				i=i+2;
			}
		}
	}

	function gridLayout() {
		$('#main .post-wrapper').css( 'height', 'auto' );
		$('#main .hentry').css( 'height', 'auto' );
		if ( 860 <= $( window ).width() ) {
			if ( $( '.hentry' ).hasClass( 'thumb-above-title' ) || $( '.hentry' ).hasClass( 'thumb-below-title' ) ) {
				$('#main .post-wrapper').matchHeight();
			} else {
				$('#main .hentry').matchHeight();
			}
		}
	}

	gridLayout();

	$(window).resize(function () {
		clearTimeout(scrollTimer);
		scrollTimer = setTimeout(gridLayout, 100);
	});

} )( jQuery );
