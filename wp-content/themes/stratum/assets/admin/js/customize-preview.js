/**
 * customizer.js
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */
( function ( $ ) {
	var displayToggler = function ( value, selector, trueValue ) {
		if ( trueValue == value ) {
			$( selector ).css( {
				'position': 'absolute',
				'clip': 'rect(1px, 1px, 1px, 1px)'
			} );
		}
		else {
			$( selector ).css( {
				'position': 'relative',
				'clip': 'auto'
			} );
		}
	}
	var addInlineCss = function ( id, css ) {
		if ( $( 'style#' + id ).length ) {
			$( 'style#' + id ).html( css );
		}
		else {
			$( 'head' ).append( '<style id="' + id + '">' + css + '</style>' );
			setTimeout( function () {
				$( 'style#' + id ).not( ':last' ).remove();
			}, 100 );
		}
	}
	var enqueGoogleFonts = function ( id, fontVal ) {
		var gfontUrl = [ '//fonts.googleapis.com/css?family=' ];
		var fonts = fontVal.split( ' ' ).join( '+' );
		gfontUrl.push( fonts );
		if ( 0 === $( 'link#' + id ).length ) {
			$gfontlink = $( '<link>', {
				id: id,
				href: gfontUrl.join( '' ),
				rel: 'stylesheet',
				type: 'text/css'
			} );
			$( 'link:last' ).after( $gfontlink );
		}
		else {
			$( 'link#' + id ).attr( 'href', gfontUrl.join( '' ) );
		}
	}
	wp.customize( 'stratum_display_site_title', function ( value ) {
		value.bind( function ( to ) {
			displayToggler( to, '.site-title', '' );
		} );
	} );
	wp.customize( 'stratum_display_site_desc', function ( value ) {
		value.bind( function ( to ) {
			displayToggler( to, '.site-description', '' );
		} );
	} );
	// Excerpt teaser text.
	wp.customize( 'stratum_excerpt_teaser', function ( value ) {
		value.bind( function ( to ) {
			$( '.more-link' ).text( to );
		} );
	} );
	// Display footer credit information.
	wp.customize( 'stratum_site_credit', function ( value ) {
		value.bind( function ( to ) {
			displayToggler( to, '.site-credit', 1 );
		} );
	} );
	// Mobile/ tablet base font size.
	wp.customize( 'stratum_small_base_font_size', function ( value ) {
		value.bind( function ( to ) {
			var css = '@media only screen and (max-width: 640px){html{font-size:' + to + 'px }}';
			addInlineCss( 'stratum_small_base_font_size', css );
		} );
	} );
	// Desktop base font size.
	wp.customize( 'stratum_large_base_font_size', function ( value ) {
		value.bind( function ( to ) {
			var css = '@media only screen and (min-width: 640px){html{font-size:' + to + 'px }}';
			addInlineCss( 'stratum_large_base_font_size', css );
		} );
	} );
	// Line height.
	wp.customize( 'stratum_base_line_height', function ( value ) {
		value.bind( function ( to ) {
			var css = 'body{line-height:' + to +'}.widget{line-height:' + (to / 0.9) + '}';
			addInlineCss( 'stratum_base_line_height', css );
		} );
	} );
	// Boxed Layout.
	wp.customize( 'stratum_site_layout', function ( value ) {
		value.bind( function ( to ) {
			$( 'body' ).removeClass( 'boxed full-width' );
			if ( 'boxed' === to ) {
				$( 'body' ).addClass( 'boxed' );
			}
			else {
				$( 'body' ).addClass( 'full-width' );
			}
		} );
	} );
	// Header items alignment.
	wp.customize( 'stratum_header_alignment', function ( value ) {
		value.bind( function ( to ) {
			$( '.header-items' ).removeClass( 'aligned left right' );
			if ( 'left' === to ) {
				$( '.header-items' ).addClass( 'aligned left' );
			}
			else if ( 'right' === to ) {
				$( '.header-items' ).addClass( 'aligned right' );
			}

			var height = $( '#masthead' ).outerHeight();
			if ( $( 'body' ).hasClass( 'boxed' ) ) {
				var contentPadding = height + 60;
				var css = '@media only screen and (min-width: 1024px){.boxed .site-header + .site-content{padding:' + contentPadding + 'px 0 0 }.boxed .wp-custom-header{margin:' + height + 'px auto 0}}';
				addInlineCss( 'stratum_top_padding_custom', css );
			} else {
				var contentPadding = height + 40;
				var css = '@media only screen and (min-width: 1024px){.site-header + .site-content{padding:' + contentPadding + 'px 0 0 }.wp-custom-header{margin:' + height + 'px auto 0}}';
				addInlineCss( 'stratum_top_padding_custom', css );
			}
		} );
	} );
	// Main menu alignment.
	wp.customize( 'stratum_main_menu_alignment', function ( value ) {
		value.bind( function ( to ) {
			$( '#main-navigation' ).removeClass( 'aligned left right' );
			if ( 'left' === to ) {
				$( '#main-navigation' ).addClass( 'aligned left' );
			}
			else if ( 'right' === to ) {
				$( '#main-navigation' ).addClass( 'aligned right' );
			}
		} );
	} );
	// Footer alignment.
	wp.customize( 'stratum_footer_alignment', function ( value ) {
		value.bind( function ( to ) {
			$( '#colophon' ).removeClass( 'aligned left right' );
			if ( 'left' === to ) {
				$( '#colophon' ).addClass( 'aligned left' );
			}
			else if ( 'right' === to ) {
				$( '#colophon' ).addClass( 'aligned right' );
			}
		} );
	} );
	// Sticky main menu.
	wp.customize( 'stratum_sticky_main_menu', function ( value ) {
		value.bind( function ( to ) {
			$( 'body' ).removeClass( 'fixed-elem' );
			if ( to ) {
				$( 'body' ).addClass( 'fixed-elem' );
			}
		} );
	} );
	// Overall link color
	wp.customize( 'stratum_link_color', function ( value ) {
		value.bind( function ( to ) {
			var css = 'a{color:' + to + '}';
			addInlineCss( 'stratum_link_color', css );
		} );
	} );
	// Overall link hover color
	wp.customize( 'stratum_link_hover_color', function ( value ) {
		value.bind( function ( to ) {
			var css = 'a:hover,a:focus,.nav-menu a:hover,.nav-menu a:focus,.nav-links a:hover,.nav-links a:focus,.nav-menu .sub-menu a:hover,.nav-menu .sub-menu a:focus,#header-menu .search-toggle:hover,#header-menu .search-toggle:focus,.entry-meta a:hover,.entry-meta a:focus,.menu-toggle:hover,.menu-toggle:focus,.sub-menu-toggle:hover,.sub-menu-toggle:focus,#header-menu .nav-menu .menu-item:hover > a, #header-menu .nav-menu .menu-item.focus > a{color:' + to + '}';
			css += 'input:focus,textarea:focus{border-color:' + to + '}';
			css += 'input[type="button"]:hover,input[type="button"]:focus,input[type="reset"]:hover,input[type="reset"]:focus,input[type="submit"]:hover,input[type="submit"]:focus{background-color:' + to + '}';
			addInlineCss( 'stratum_link_hover_color', css );
		} );
	} );
	// Body text color
	wp.customize( 'stratum_content_text_color', function ( value ) {
		value.bind( function ( to ) {
			var css = 'body,.nav-menu a,.nav-links a{color:' + to + '}';
			addInlineCss( 'stratum_content_text_color', css );
		} );
	} );
	// Post Title color
	wp.customize( 'stratum_post_title_color', function ( value ) {
		value.bind( function ( to ) {
			var css = '#main .entry-title,.entry-title a{color:' + to + '}';
			addInlineCss( 'stratum_post_title_color', css );
		} );
	} );
	// Post Title hover color
	wp.customize( 'stratum_post_title_hover_color', function ( value ) {
		value.bind( function ( to ) {
			var css = '.entry-title a:hover,.entry-title a:focus{color:' + to + '}';
			addInlineCss( 'stratum_post_title_hover_color', css );
		} );
	} );
	// Body font family
	wp.customize( 'stratum_body_font_family', function ( value ) {
		value.bind( function ( to ) {
			enqueGoogleFonts( 'stratum_body_font_family', to );
			var css = 'body{font-family:' + to + '}';
			addInlineCss( 'stratum_body_font_family', css );
		} );
	} );
	// Heading font family
	wp.customize( 'stratum_heading_font_family', function ( value ) {
		value.bind( function ( to ) {
			enqueGoogleFonts( 'stratum_heading_font_family', to );
			var css = 'h1,h2,h3,h4,h5,h6,h1.site-title,p.site-title,.nav-menu a,.site-description{font-family:' + to + '}';
			addInlineCss( 'stratum_heading_font_family', css );
		} );
	} );
	// Primary sidebar width.
	wp.customize( 'stratum_primary_sidebar_width', function ( value ) {
		value.bind( function ( to ) {
			if ( '' !== to ) {
				var css = '@media only screen and (min-width: 1024px){#secondary{width:' + to + 'px}}';
				addInlineCss( 'stratum_primary_sidebar_width', css );
			}
			else {
				var css = '@media only screen and (min-width: 1024px){#secondary{width: 300px}}';
				css += '@media only screen and (min-width: 1200px){#secondary{width: 380px}.both-sidebar #secondary{width: 300px}}';
				css += '@media only screen and (min-width: 1340px){.both-sidebar #secondary{width: 380px}}';
				addInlineCss( 'stratum_primary_sidebar_width', css );
			}
		} );
	} );
	// Overall site width.
	wp.customize( 'stratum_overall_site_width', function ( value ) {
		value.bind( function ( to ) {
			if ( '' === to ) {
				to = 1280;
			}
			var screen = +to + 40;
			var outer = +to + 120;
			var css = '@media only screen and (min-width:' + screen + 'px){#main-navigation .wrap,#header-nav,.header-items,#colophon > .wrap,.site-content,.footer-widgets .wrap,.widget-container{max-width:' + to + 'px}}';
			css += '@media only screen and (min-width:1680px){.wp-custom-header{max-width:' + to + 'px}}';
			css += '@media only screen and (min-width:' + outer + 'px){.boxed .wrap,.boxed .header-items,.boxed .footer-widgets > .wrap,.boxed .content-sidebar-wrap,.boxed #colophon > .wrap{max-width:' + outer + 'px}}';
			addInlineCss( 'stratum_overall_site_width', css );
		} );
	} );
} )( jQuery );
