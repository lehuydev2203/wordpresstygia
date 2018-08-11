/* global stratumScreenReaderText */
/**
 * Adds toggle icon for mobile navigation and dropdown animations for widescreen navigation
 */
( function ( $ ) {

	var scrnRdrSpn = $('<span />', {'class': 'screen-reader-text', text: stratumScreenReaderText.expand}),
		dropdownToggle = $('<button />', {'class': 'sub-menu-toggle', 'aria-expanded': false}).append(stratumScreenReaderText.icon).append(scrnRdrSpn),
		headerMenu = $( '#' + stratumScreenReaderText.secondary );
		stickyElem = $( '#masthead' );

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

	$.fn.navSearch = function() {

		var $this = $(this),
			menuToggle   = $this.find( '.menu-toggle' ),
			searchForm   = $this.find( '.search-form' );

			if( !menuToggle || !searchForm ) {
				return;
			}

			$this.find('.search-toggle').click( function( event ) {
				event.stopPropagation();
				$(this).toggleClass('nav-search-active');
				$(this).attr('aria-expanded', $(this).hasClass('toggled-on'));
				searchForm.toggleClass('nav-search-active');
			});
	}

	$.fn.responsiveMenu = function() {

		var touchStartFn, i,
			$this = $(this),
			parentLink = $this.find('.menu-item-has-children > a, .page_item_has_children > a'),
			menuToggle = $this.find('.menu-toggle');

		if ( !menuToggle.length ) {
			return;
		}

		menuToggle.on('click.stratum', function () {
			$this.toggleClass('toggled-on');
			$(this).attr('aria-expanded', $this.hasClass('toggled-on'));
		} );

		parentLink.after(dropdownToggle);
		$this.find('.sub-menu-toggle').click( function (e) {
			var screenReaderSpan = $(this).find('.screen-reader-text');
			e.preventDefault();
			$(this).toggleClass('toggled-on');
			$(this).next('.children, .sub-menu').toggleClass('toggled-on');
			$(this).attr('aria-expanded', $(this).hasClass('toggled-on'));
			screenReaderSpan.text( $(this).hasClass('toggled-on') ? stratumScreenReaderText.collapse : stratumScreenReaderText.expand );
		} );

		if ('ontouchstart' in window) {
			$(window).on('resize.stratum', toggleFocusClassTouchScreen);
			toggleFocusClassTouchScreen();
		}

		$this.find('a').on('focus.stratum blur.stratum', function () {
			$(this).parents('.menu-item, .page_item').toggleClass('focus');
		} );

		function toggleFocusClassTouchScreen() {
			if ('none' === menuToggle.css('display')) {
				$(document.body).on( 'touchstart.stratum', function (e) {
					if (!$(e.target).closest('.nav-menu li').length) {
						$('.nav-menu li').removeClass('focus');
					}
				} );
				parentLink.on('touchstart.stratum', function (e) {
					var el = $(this).parent( 'li' );
					if (!el.hasClass('focus')) {
						e.preventDefault();
						el.toggleClass('focus');
						el.siblings('.focus').removeClass('focus');
					}
				} );
			}
			else {
				parentLink.unbind('touchstart.stratum');
			}
		}
	}

	$.fn.stickyOnScroll = function() {

		var $this = $(this),
			elemHeight = $this.outerHeight();
			scrollPos = 0,
			scrollTimer = null,
			$menuToggle = $this.find('.menu-toggle');

		$(window).scroll(function () {
			if ( 'none' !== $menuToggle.css('display') ) {
				return;
			}
			scrollPos = $(window).scrollTop();
			if ( $( 'body' ).hasClass("fixed-elem") ) {
				if ($this.hasClass("sticky-elem")) {
					if (scrollPos <= 0) {
						$this.removeClass("sticky-elem");
					}
				} else {
					if (scrollPos > 0 ) {
						$this.addClass("sticky-elem");
					}
				}
			} else {
				if ( $this.hasClass("no-sticky") ) {
					if ( scrollPos <= elemHeight ) {
						$this.removeClass("no-sticky");
						$this.fadeIn();
					}
				} else {
					if ( scrollPos > elemHeight ) {
						$this.addClass("no-sticky");
						$this.fadeOut();
					}
				}
			}
		} );
	}

	if ( headerMenu.length ) {
		headerMenu.responsiveMenu();
		headerMenu.navSearch();
	}

	/*
	 * Test if inline SVGs are supported.
	 * @link https://github.com/Modernizr/Modernizr/
	 */
	function supportsInlineSVG() {
		var div = document.createElement( 'div' );
		div.innerHTML = '<svg/>';
		return 'http://www.w3.org/2000/svg' === ( 'undefined' !== typeof SVGRect && div.firstChild && div.firstChild.namespaceURI );
	}
	// Change HTML class based on SVG support.
	$( document ).ready( function () {
		if ( true === supportsInlineSVG() ) {
			document.documentElement.className = document.documentElement.className.replace( /(\s*)no-svg(\s*)/, '$1svg$2' );
		}
	} );

	$(document).ready(function () {
		if ( stickyElem.length ) {
			stickyElem.stickyOnScroll();
		}
	} );

	function contentTopHeight() {
		var height = $( '#masthead' ).outerHeight();
		if ( $( 'body' ).hasClass( 'boxed' ) ) {
			contentPadding = height + 60;
			var css = '@media only screen and (min-width: 1024px){.boxed .site-header + .site-content{padding:' + contentPadding + 'px 0 0 }.boxed .wp-custom-header{margin:' + height + 'px auto 0}}';
			addInlineCss( 'stratum_top_padding', css );
		} else {
			contentPadding = height + 40;
			var css = '@media only screen and (min-width: 1024px){.site-header + .site-content{padding:' + contentPadding + 'px 0 0 }.wp-custom-header{margin:' + height + 'px auto 0}}';
			addInlineCss( 'stratum_top_padding', css );
		}
	}

	$(window).on('resize.stratum', contentTopHeight);
	contentTopHeight();

} )( jQuery );
