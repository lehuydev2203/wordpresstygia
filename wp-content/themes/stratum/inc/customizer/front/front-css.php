<?php
/**
 * Create front end css based on Theme Customizer options.
 *
 * @link https://codex.wordpress.org/Theme_Customization_API
 *
 * @package Stratum
 * @since 1.0.0
 */

/**
 * Create front end css based on Theme Customizer options.
 *
 * @since 1.0.0
 */
class Stratum_Customizer_Front_Css extends Stratum_Customizer_Front_Base {

	/**
	 * Hold theme customized CSS.
	 *
	 * @since  1.0.0
	 * @access public
	 * @var    string
	 */
	public $css;

	/**
	 * Returns theme customized CSS.
	 *
	 * @since 1.0.0
	 *
	 * @param  string $output Stratum inline css.
	 * @return string Stratum modified inline css.
	 */
	public function customized_css( $output ) {

		$this->css = $output;
		$this->title_tagline();
		$this->color_css();
		$this->header_image();
		$this->frontpage_widget();
		$this->typography_css();
		$this->dimension_css();

		return $this->css;
	}

	/**
	 * Hide/Display title tagline customized CSS.
	 *
	 * @since 1.0.0
	 */
	public function title_tagline() {

		if ( ! $this->get_mod( 'stratum_display_site_title', 'none' ) ) {
			$this->css .= sprintf( '.site-title{position:absolute;clip: rect(1px, 1px, 1px, 1px)}' );
		}

		if ( ! $this->get_mod( 'stratum_display_site_desc', 'none' ) ) {
			$this->css .= sprintf( '.site-description{position:absolute;clip: rect(1px, 1px, 1px, 1px)}' );
		}
	}

	/**
	 * Display header image as background image of site header.
	 *
	 * @since 1.0.0
	 */
	public function header_image() {

		if ( is_front_page() && ! is_home() ) {

			// Inline css for header text and link color.
			$text_color  = $this->get_mod( 'stratum_frontpage_header_text_color', 'color' );
			$hover_color = $this->get_mod( 'stratum_link_hover_color', 'color' );
			if ( $text_color ) {
				$this->css .= sprintf( '
				@media only screen and (min-width: 1024px) {
				.title-area,
				.site-title a,
				#header-menu .nav-menu a,
				#header-menu .search-toggle {
					color: %1$s;
				}
				#header-menu .search-toggle .icon-close,
				.fixed-elem .sticky-elem .title-area,
				.fixed-elem .sticky-elem .site-title a,
				.fixed-elem .sticky-elem #header-menu .nav-menu a,
				.fixed-elem .sticky-elem #header-menu .search-toggle {
					color: #333;
				}
				#header-menu .nav-menu .sub-menu a,
				.fixed-elem .sticky-elem #header-menu .nav-menu .sub-menu a {
					color: #fff;
				}
				#header-menu .nav-menu .menu-item:hover > a,
				#header-menu .nav-menu .menu-item.focus > a {
					color: %2$s;
				}
				.fixed-elem .sticky-elem #header-menu .nav-menu .menu-item:hover > a,
				.fixed-elem .sticky-elem #header-menu .nav-menu .menu-item.focus > a,
				#header-menu .search-toggle:hover .icon-close,
				#header-menu .search-toggle:focus .icon-close,
				#header-menu .sub-menu .menu-item:hover > a,
				#header-menu .sub-menu .menu-item.focus > a {
					color: %2$s;
					box-shadow: none;
				}
				}', $text_color, $hover_color );
			}
		}
	}

	/**
	 * Typography customized CSS.
	 *
	 * @since 1.1
	 */
	public function typography_css() {
		$typography = array(
			'stratum_body_font_family'    => 'body{font-family:%s}',
			'stratum_heading_font_family' => 'h1,h2,h3,h4,h5,h6,h1.site-title,p.site-title,.nav-menu a,.site-description{font-family:%s}',
		);

		foreach ( $typography as $id => $css ) {
			$ff = $this->get_mod( $id );
			if ( $ff && stratum_get_theme_defaults( $id ) !== $ff ) {
				if ( $this->is_google_sans_font( $ff ) ) {
					$ff = $ff . ',sans-serif';
				} elseif ( $this->is_google_serif_font( $ff ) ) {
					$ff = $ff . ',serif';
				} elseif ( $this->is_web_safe_font( $ff ) ) {
					$ff = Stratum_Customizer_Data::get_web_safe_fonts_stack( $ff );
				}

				$this->css .= sprintf( $css, $ff );
			}
		}

		$small_font  = $this->get_mod( 'stratum_small_base_font_size', 'integer' );
		$large_font  = $this->get_mod( 'stratum_large_base_font_size', 'integer' );
		$line_height = $this->get_mod( 'stratum_base_line_height', 'float' );

		if ( $small_font && 16 !== $small_font ) {
			$this->css .= sprintf( '@media only screen and (max-width: 640px){html{font-size: %spx}}', $small_font );
		}

		if ( $large_font && 18 !== $large_font ) {
			$this->css .= sprintf( '@media only screen and (min-width: 640px){html{font-size: %spx}}', $large_font );
		}

		if ( $line_height && 1.75 !== $line_height ) {
			$this->css .= sprintf( 'body{line-height: %1$s}.widget{line-height: %2$s}', $line_height, $line_height / 0.9 );
		}
	}

	/**
	 * Colors customized CSS.
	 *
	 * @since 1.0.0
	 */
	public function color_css() {
		$colors = array(
			'stratum_link_color'             => 'a{color: %1$s}',
			'stratum_post_title_color'       => '#main .entry-title,.entry-title a{color:%s}',
			'stratum_post_title_hover_color' => '.entry-title a:hover,.entry-title a:focus{color:%s}',
			'stratum_content_text_color'     => 'body,.nav-menu a,.nav-links a{color:%s}',
			'stratum_link_hover_color'       => 'a:hover,a:focus, .nav-menu a:hover,.nav-menu a:focus,.nav-menu .sub-menu a:hover,.nav-menu .sub-menu a:focus,#header-menu .search-toggle:hover,#header-menu .search-toggle:focus,.entry-meta a:hover,.entry-meta a:focus,.nav-links a:hover,.nav-links a:focus,.menu-toggle:hover,.menu-toggle:focus,.sub-menu-toggle:hover,.sub-menu-toggle:focus{color: %1$s}input:focus,textarea:focus{border-color: %1$s}input[type="button"]:hover,input[type="button"]:focus,input[type="reset"]:hover,input[type="reset"]:focus,input[type="submit"]:hover,input[type="submit"]:focus{background-color: %1$s}',
		);

		foreach ( $colors as $id => $css ) {
			$color = $this->get_mod( $id, 'color' );
			if ( $color && stratum_get_theme_defaults( $id ) !== $color ) {
				$this->css .= sprintf( $css, $color );
			}
		}
	}

	/**
	 * Inline styles for front page widget.
	 *
	 * @since 1.0.0
	 */
	public function frontpage_widget() {

		if ( ! is_front_page() || is_home() ) {
			return;
		}

		if ( get_theme_mod( 'stratum_front_page_content', '' ) ) {
			$this->css .= sprintf('
				.frontpage .content-sidebar-wrap {
					display: none;
				}'
			);
		}

		for ( $i = 1; $i <= 6; $i++ ) {
			// Inline css for background image.
			$image = $this->get_mod( 'stratum_front_widget_' . $i . '_bg_image', 'url' );
			if ( $image ) {
				$this->css .= sprintf( '
				.front-widget.frontpage-%1$s{
					background-repeat: no-repeat;
					background-position: center center;
					background-size: cover;
					background-image: url(%2$s);
				}', $i, $image );
			}

			// Inline css for background color.
			$color = $this->get_mod( 'stratum_front_widget_' . $i . '_bg_color', 'color' );
			if ( $color ) {
				$this->css .= sprintf( '
				.front-widget.frontpage-%1$s{
					background-color: %2$s;
				}', $i, $color );
			}

			// Inline css for fixed background image.
			$fixed_bg = $this->get_mod( 'stratum_front_widget_' . $i . '_fixed_bg_image', 'none' );
			if ( $fixed_bg ) {
				$this->css .= sprintf( '
				.frontpage-%s{
					background-attachment: fixed;
				}', $i );
			}

			// Inline css to dim background image.
			$dim_bg = $this->get_mod( 'stratum_front_widget_' . $i . '_dim_image', 'none' );
			if ( $dim_bg ) {
				$this->css .= sprintf( '
				.frontpage-%1$s,
				.frontpage-%1$s .wrap .widget{
					position: relative;
				}

				.frontpage-%1$s .wrap .widget{
					z-index: 1;
				}

				.frontpage-%1$s::before{
					content: "";
					position: absolute;
					top: 0;
					left: 0;
					bottom: 0;
					right: 0;
					background: rgba(0,0,0,0.5);
				}', $i );
			}

			// Frontpage widgets area layout.
			$layout = $this->get_mod( 'stratum_front_widget_' . $i . '_widget_layout', 'none' );
			if ( 'aligned_1' === $layout ) {
				$this->css .= sprintf( '
				.frontpage-%1$s .wrap{
					display: flex;
					flex-direction: column;
				}
				.frontpage-%1$s .wrap .widget{
					padding-top: 20px;
					padding-bottom: 20px;
				}', $i );
			} elseif ( 'aligned_2' === $layout ) {
				$this->css .= sprintf( '
				@media only screen and (min-width: 1024px) {
				.frontpage-%1$s .wrap .widget{
					flex-grow: 1;
					flex-shrink: 0;
					flex-basis: calc( 50%% - 20px );
					min-width: calc( 50%% - 20px );
					margin-right: 40px;
					padding-top: 20px;
					padding-bottom: 20px;
				}
				.frontpage-%1$s .wrap .widget:nth-of-type(2n){
					margin-right: 0;
				}
				.frontpage-%1$s .wrap .widget:last-child{
					margin-right: 0;
				}
				.frontpage-%2$s .widget-wrapper{
					display: flex;
					flex-direction: row;
					flex-wrap: wrap;
				}}', $i, $i );
			} elseif ( 'aligned_3' === $layout ) {
				$this->css .= sprintf( '
				@media only screen and (min-width: 1024px) {
				.frontpage-%1$s .wrap .widget{
					flex-grow: 1;
					flex-shrink: 0;
					flex-basis: calc( 33%% - 27px );
					min-width: calc( 33%% - 27px );
					margin-right: 40px;
					padding-top: 20px;
					padding-bottom: 20px;
				}
				.frontpage-%1$s .wrap .widget:nth-of-type(3n),
				.frontpage-%1$s .wrap .widget:last-child{
					margin-right: 0;
				}
				.frontpage-%2$s .widget-wrapper{
					display: flex;
					flex-direction: row;
					flex-wrap: wrap;
				}}', $i, $i );
			} elseif ( 'aligned_4' === $layout ) {
				$this->css .= sprintf( '
				@media only screen and (min-width: 1024px) {
				.frontpage-%1$s .wrap .widget{
					flex-grow: 1;
					flex-shrink: 0;
					flex-basis: calc( 25%% - 23px );
					min-width: calc( 25%% - 23px );
					margin-right: 30px;
					padding-top: 20px;
					padding-bottom: 20px;
				}
				.frontpage-%1$s .wrap .widget:nth-of-type(4n),
				.frontpage-%1$s .wrap .widget:last-child{
					margin-right: 0;
				}
				.frontpage-%2$s .widget-wrapper{
					display: flex;
					flex-direction: row;
					flex-wrap: wrap;
				}}', $i, $i );
			}

			// Inline css for text color.
			$text_color = $this->get_mod( 'stratum_front_widget_' . $i . '_text_color', 'color' );
			if ( $text_color ) {
				$this->css .= sprintf( '
				.frontpage-%1$s,
				.frontpage-%1$s a{
					color: %2$s;
				}', $i, $text_color );
			}

			// Inline css for text shadow.
			$text_shadow = $this->get_mod( 'stratum_front_widget_' . $i . '_text_shadow', 'none' );
			if ( $text_shadow ) {
				$this->css .= sprintf( '
				.frontpage-%1$s,
				.frontpage-%1$s a{
					text-shadow: 0 -1px 0 rgba(0,0,0,.65);
				}', $i );
			}

			// Inline css for text alignment.
			$text_align = $this->get_mod( 'stratum_front_widget_' . $i . '_alignment', 'none' );
			if ( 'left' === $text_align ) {
				$this->css .= sprintf( '
				@media only screen and (min-width: 860px) {
				.frontpage-%1$s{
					text-align: left;
				}}', $i );
			} elseif ( 'right' === $text_align ) {
				$this->css .= sprintf( '
				@media only screen and (min-width: 860px) {
				.frontpage-%1$s{
					text-align: right;
				}}', $i );
			} elseif ( 'center' === $text_align ) {
				$this->css .= sprintf( '
				@media only screen and (min-width: 860px) {
				.frontpage-%1$s{
					text-align: center;
				}}', $i );
			}

			// Content width control.
			$width = $this->get_mod( 'stratum_front_widget_' . $i . '_width', 'integer' );
			if ( $width ) {
				$min_width = $width + 80;
				if ( 860 > $min_width ) {
					$min_width = 860;
				}
				$this->css .= sprintf( '
				@media only screen and (min-width: %1$spx){
				.front-widget.frontpage-%2$s .widget-wrapper{
					width: %3$spx;
					max-width: 100%;
				}}', $min_width, $i, $width );
			}

			// Inline css for content horizontal alignment.
			$content_align = $this->get_mod( 'stratum_front_widget_' . $i . '_content_alignment', 'none' );
			if ( 'left' === $content_align ) {
				$this->css .= sprintf( '
				.frontpage-%1$s .wrap:after {
					display: table;
					clear: both;
					content: "";
				}
				.frontpage-%1$s .widget-wrapper{
					float: left;
				}', $i );
			} elseif ( 'right' === $content_align ) {
				$this->css .= sprintf( '
				.frontpage-%1$s .wrap:after {
					display: table;
					clear: both;
					content: "";
				}
				.frontpage-%1$s .widget-wrapper{
					float: right;
				}', $i );
			} else {
				$this->css .= sprintf( '
				.frontpage-%1$s .widget-wrapper{
					float: none;
					margin: 0 auto;
				}', $i );
			}

			// Inline css for content vertical alignment.
			$vertical_align = $this->get_mod( 'stratum_front_widget_' . $i . '_vertical_alignment', 'none' );
			if ( 'mid' === $vertical_align ) {
				$this->css .= sprintf( '
				@media only screen and (min-width: 1024px) {
				.frontpage-%1$s .widget-wrapper{
					align-items: center;
				}}', $i );
			} elseif ( 'bottom' === $vertical_align ) {
				$this->css .= sprintf( '
				@media only screen and (min-width: 1024px) {
				.frontpage-%1$s .widget-wrapper{
					align-items: flex-end;
				}}', $i );
			} else {
				$this->css .= sprintf( '
				@media only screen and (min-width: 1024px) {
				.frontpage-%1$s .widget-wrapper{
					align-items: inherit;
				}}', $i );
			}

			// Content Padding control.
			$padding = $this->get_mod( 'stratum_front_widget_' . $i . '_padding', 'integer' );
			if ( $padding ) {
				$min_width  = 860;
				$this->css .= sprintf( '
				@media only screen and (min-width: %1$spx){
				.front-widget.frontpage-%2$s .widget-container{
					padding: %3$spx 0;
				}}', $min_width, $i, $padding );
			}

			// Full screen height front page widget.
			$widget_height = $this->get_mod( 'stratum_front_widget_' . $i . '_full_screen', 'none' );
			if ( $widget_height ) {
				if ( 1 === $i ) {
					$this->css .= sprintf( '
					@media only screen and (min-width: 1024px) {
						.cta .frontpage-%1$s {
							height: 100vh;
						}
						.cta.admin-bar .frontpage-%1$s {
							height: calc( 100vh - 29px);
						}
						.no-cta .frontpage-%1$s {
							min-height: calc( 100vh - 80px );
						}
						.no-cta.admin-bar .frontpage-%1$s {
							min-height: calc( 100vh - 109px );
						}
					}', $i );
				} else {
					$this->css .= sprintf( '
					@media only screen and (min-width: 1024px) {
						.frontpage-%1$s {
							min-height: 100vh;
						}
						admin-bar .frontpage-%1$s {
							min-height: calc( 100vh - 29px);
						}
						.fixed-elem .frontpage-%1$s {
							min-height: calc( 100vh - 80px);
						}
						.fixed-elem.admin-bar .frontpage-%1$s {
							min-height: calc( 100vh - 109px);
						}
					}', $i );
				}
			}
		}

	}

	/**
	 * Site dimension customized CSS.
	 *
	 * @since 1.0.0
	 */
	public function dimension_css() {

		$min_width       = 1024;
		$site_width      = $this->get_mod( 'stratum_overall_site_width', 'integer' );
		$secondary_width = $this->get_mod( 'stratum_primary_sidebar_width', 'integer' );

		if ( is_active_sidebar( 'sidebar-1' ) ) {
			if ( $secondary_width ) {
				$this->css .= sprintf( '@media only screen and (min-width: %1$spx){#secondary{width: %2$spx}}', $min_width, $secondary_width );
			}
		}

		if ( $site_width ) {

			// Applicable screen size for full width layout to keep at least 40px space on either side.
			$screen_width = $site_width + 80;
			if ( $screen_width < $min_width ) {
				$screen_width = $min_width;
			}

			// Maintain 60px padding on both sides for boxed layout.
			$outer_width = $site_width + 120;

			$this->css .= sprintf( '@media only screen and (min-width: %1$spx){#main-navigation .wrap,#header-nav,.header-items,#colophon > .wrap,.site-content,.footer-widgets .wrap,.widget-container{max-width: %2$spx}}', $screen_width, $site_width );
			$this->css .= sprintf( '@media only screen and (min-width: %1$spx){.boxed .wrap,.boxed .header-items,.boxed .footer-widgets > .wrap,.boxed .content-sidebar-wrap,.boxed #colophon > .wrap{max-width: %2$spx}}', $outer_width, $outer_width );
			$this->css .= sprintf( '@media only screen and (min-width: 1680px){.wp-custom-header{max-width: %1$spx}}', $site_width );
		}
	}
}
