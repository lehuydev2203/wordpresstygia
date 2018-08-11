<?php
/**
 * Customizer section
 *
 * @package Vodka
 * @since 1.0.0
 */

if ( class_exists( 'WP_Customize_Section' ) ) {
	/**
	 * Provision for creating sub section in customizer.
	 *
	 * @since 1.0.0
	 */
	class Stratum_WP_Customize_Section extends WP_Customize_Section {

		/**
		 * Sections.
		 *
		 * @since  1.0.0
		 * @access public
		 * @var    array
		 */
		public $section;

		/**
		 * Current control type.
		 *
		 * @since  1.0.0
		 * @access public
		 * @var    string
		 */
		public $type = 'stratum_section';

		/**
		 * Convert option data in JSON.
		 *
		 * @since  1.0.0
		 */
		public function json() {
			$array                   = wp_array_slice_assoc( (array) $this, array( 'id', 'description', 'priority', 'panel', 'type', 'description_hidden', 'section' ) );
			$array['title']          = html_entity_decode( $this->title, ENT_QUOTES, get_bloginfo( 'charset' ) );
			$array['content']        = $this->get_content();
			$array['active']         = $this->active();
			$array['instanceNumber'] = $this->instance_number;
			if ( $this->panel ) {
				$array['customizeAction'] = sprintf( 'Customizing &#9656; %s', esc_html( $this->manager->get_panel( $this->panel )->title ) );
			} else {
				$array['customizeAction'] = 'Customizing';
			}
			return $array;
		}
	}
}
