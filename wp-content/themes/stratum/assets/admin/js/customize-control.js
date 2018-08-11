/**
 * customizer-control.js
 */
( function ( $, api ) {
	api.bind( 'ready', function () {
		var customize = this;
		var toggler = function ( setting, controls, trueValue ) {
			customize( setting, function ( value ) {
				$.each( controls, function ( index, id ) {
					customize.control( id, function ( control ) {
						var toggle = function ( to ) {
							if ( trueValue && 1 !== trueValue ) {
								control.toggle( trueValue === to );
							}
							else {
								control.toggle( to );
							}
						};
						toggle( value.get() );
						value.bind( toggle );
					} );
				} );
			} );
		};
		toggler( 'stratum_excerpt_option', [
				'stratum_excerpt_length',
				'stratum_excerpt_teaser',
				'stratum_thumbnails_display',
			], 'excerpt' );
		toggler( 'stratum_enforce_global', [
				'stratum_post_layout',
				'stratum_page_layout',
				'stratum_project_layout',
			], 1 );
		toggler( 'stratum_site_layout', [
				'background_color'
			], 'full_width' );
	} );

	// Fecilitate customizer sub-sections.
	api.bind( 'pane-contents-reflowed', function() {
		// Reflow sections
		var sections = [];

		api.section.each( function( section ) {

		  if ( 'stratum_section' !== section.params.type || 'undefined' === typeof section.params.section ) {
			return;
		  }

		  sections.push( section );

		});

		sections.sort( api.utils.prioritySort ).reverse();

		$.each( sections, function( i, section ) {

		  var parentContainer = $( '#sub-accordion-section-' + section.params.section );

		  parentContainer.children( '.customize-control-sub-section' ).after( section.headContainer );

		});
	} );

	// Extend Section
  var _sectionEmbed = wp.customize.Section.prototype.embed;
  var _sectionIsContextuallyActive = wp.customize.Section.prototype.isContextuallyActive;
  var _sectionAttachEvents = wp.customize.Section.prototype.attachEvents;

  wp.customize.Section = wp.customize.Section.extend({
    attachEvents: function() {

      if (
        'stratum_section' !== this.params.type ||
        'undefined' === typeof this.params.section
      ) {

        _sectionAttachEvents.call( this );

        return;

      }

      _sectionAttachEvents.call( this );

      var section = this;

      section.expanded.bind( function( expanded ) {

        var parent = api.section( section.params.section );

        if ( expanded ) {

          parent.contentContainer.addClass( 'current-section-parent' );

        } else {

          parent.contentContainer.removeClass( 'current-section-parent' );

        }

      });

      section.container.find( '.customize-section-back' )
        .off( 'click keydown' )
        .on( 'click keydown', function( event ) {

          if ( api.utils.isKeydownButNotEnterEvent( event ) ) {

            return;

          }

          event.preventDefault();

          if ( section.expanded() ) {

            api.section( section.params.section ).expand();

          }

        });

    },
    embed: function() {

      if (
        'stratum_section' !== this.params.type ||
        'undefined' === typeof this.params.section
      ) {

        _sectionEmbed.call( this );

        return;

      }

      _sectionEmbed.call( this );

      var section = this;
      var parentContainer = $( '#sub-accordion-section-' + this.params.section );

      parentContainer.append( section.headContainer );

    },
    isContextuallyActive: function() {

      if (
        'stratum_section' !== this.params.type
      ) {

        return _sectionIsContextuallyActive.call( this );

      }

      var section = this;
      var children = this._children( 'section', 'control' );

      api.section.each( function( child ) {

        if ( ! child.params.section ) {

          return;

        }

        if ( child.params.section !== section.id ) {

          return;

        }

        children.push( child );

      });

      children.sort( api.utils.prioritySort );

      var activeCount = 0;

      _( children ).each( function ( child ) {

        if ( 'undefined' !== typeof child.isContextuallyActive ) {

          if ( child.active() && child.isContextuallyActive() ) {

            activeCount += 1;

          }

        } else {

          if ( child.active() ) {

            activeCount += 1;

          }

        }

      });

      return ( activeCount !== 0 );

    }

  });

} )( jQuery, wp.customize );
