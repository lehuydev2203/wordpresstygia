<?php
/**
 * Theme layouts
 *
 * @package Stratum
 * @since 1.0.0
 */

/**
 * Class for displaying various theme layout.
 *
 * @since  1.0.0
 */
class Stratum_Layouts {

	/**
	 * Holds the instance of this class.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var    object
	 */
	protected static $instance = null;

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 */
	public function __construct() {}

	/**
	 * Register hooked functions.
	 *
	 * @since 1.0.0
	 */
	public static function init() {
		add_filter( 'stratum_theme_controls', array( Stratum_Layouts::get_instance(), 'customizer_layout_options' ) );
		add_filter( 'stratum_theme_defaults', array( Stratum_Layouts::get_instance(), 'layout_defaults' ) );
		add_action( 'add_meta_boxes', array( Stratum_Layouts::get_instance(), 'add_layout_metabox' ) );
		add_action( 'save_post', array( Stratum_Layouts::get_instance(), 'save_layout_metabox' ) );
		add_filter( 'stratum_get_attr_content-sidebar-wrap', array( Stratum_Layouts::get_instance(), 'stratum_layout_css_classes' ), 9 );
	}

	/**
	 * Register layout customizer options.
	 *
	 * @since 1.0.0
	 *
	 * @param arr $controls Customizer control array.
	 * @return array $controls Customizer control array.
	 */
	public function customizer_layout_options( $controls ) {
		$controls[] = array(
			'label'    => esc_html__( 'Default Content Layout', 'stratum' ),
			'section'  => 'stratum_layout_section',
			'settings' => 'stratum_global_layout',
			'type'     => 'select',
			'choices'  => $this->layout_choices(),
		);

		$controls[] = array(
			'label'           => esc_html__( 'Posts Content Layout', 'stratum' ),
			'section'         => 'stratum_layout_section',
			'settings'        => 'stratum_post_layout',
			'type'            => 'select',
			'choices'         => $this->layout_choices(),
			'active_callback' => array( 'Stratum_Active_Callback', 'is_different_layout' ),
		);

		$controls[] = array(
			'label'           => esc_html__( 'Pages Content Layout', 'stratum' ),
			'section'         => 'stratum_layout_section',
			'settings'        => 'stratum_page_layout',
			'type'            => 'select',
			'choices'         => $this->layout_choices(),
			'active_callback' => array( 'Stratum_Active_Callback', 'is_different_layout' ),
		);

		if ( current_theme_supports( 'stratum_jetpack' ) && defined( 'JETPACK__VERSION' ) ) {
			$controls[] = array(
				'label'           => esc_html__( 'Jetpack Project Content Layout', 'stratum' ),
				'section'         => 'stratum_layout_section',
				'settings'        => 'stratum_project_layout',
				'type'            => 'select',
				'choices'         => $this->layout_choices(),
				'active_callback' => array( 'Stratum_Active_Callback', 'is_different_layout' ),
			);
		}

		if ( current_theme_supports( 'stratum_woocommerce' ) && class_exists( 'WooCommerce' ) ) {
			$controls[] = array(
				'label'           => esc_html__( 'WooCommerce Product Archive Layout', 'stratum' ),
				'section'         => 'stratum_layout_section',
				'settings'        => 'stratum_product_archive_layout',
				'type'            => 'select',
				'choices'         => $this->layout_choices( 'woo-shop' ),
				'active_callback' => array( 'Stratum_Active_Callback', 'is_different_layout' ),
			);
			$controls[] = array(
				'label'           => esc_html__( 'WooCommerce Single Product Layout', 'stratum' ),
				'section'         => 'stratum_layout_section',
				'settings'        => 'stratum_product_layout',
				'type'            => 'select',
				'choices'         => $this->layout_choices( 'woo-product' ),
				'active_callback' => array( 'Stratum_Active_Callback', 'is_different_layout' ),
			);
		}

		$controls[] = array(
			'label'    => esc_html__( 'Enable custom layout options for posts/pages', 'stratum' ),
			'section'  => 'stratum_layout_section',
			'settings' => 'stratum_enforce_global',
			'type'     => 'checkbox',
		);

		return $controls;
	}

	/**
	 * Get all applicable global layout choices.
	 *
	 * @since 1.0.0
	 *
	 * @param  string $called_by Function called by.
	 * @return array Applicable content layout options.
	 */
	public function layout_choices( $called_by = '' ) {
		$basic_layouts = array(
			'only-content'      => esc_html__( 'Only Content (No sidebar)', 'stratum' ),
			'only-content-full' => esc_html__( 'Only Content full width', 'stratum' ),
		);

		$two_col_layouts   = array();
		$three_col_layouts = array();

		if ( ( is_active_sidebar( 'sidebar-1' ) ) ||
			( 'woo-shop' === $called_by && is_active_sidebar( 'woo-sidebar-shop' ) ) ||
			( 'woo-product' === $called_by && is_active_sidebar( 'woo-sidebar-product' ) )
			) {
			$two_col_layouts = array(
				'content-sidebar' => esc_html__( 'Content-Sidebar', 'stratum' ),
				'sidebar-content' => esc_html__( 'Sidebar-Content', 'stratum' ),
			);
		}

		if ( is_active_sidebar( 'sidebar-1' ) && is_active_sidebar( 'sidebar-2' ) ) {
			$three_col_layouts = array(
				'content-sidebar-sidebar' => esc_html__( 'Content-Sidebar-Sidebar', 'stratum' ),
				'sidebar-sidebar-content' => esc_html__( 'Sidebar-Sidebar-Content', 'stratum' ),
				'sidebar-content-sidebar' => esc_html__( 'Sidebar-Content-Sidebar', 'stratum' ),
			);
		}

		return array_merge( $basic_layouts, $two_col_layouts, $three_col_layouts );
	}

	/**
	 * Set theme layout default customizer options.
	 *
	 * @since 1.0.0
	 *
	 * @param arr $default Customizer control default options.
	 * @return array $default Customizer control default options.
	 */
	public function layout_defaults( $default ) {
		if ( is_active_sidebar( 'sidebar-1' ) && is_active_sidebar( 'sidebar-2' ) ) {
			$default_layout = 'sidebar-content-sidebar';
		} elseif ( is_active_sidebar( 'sidebar-1' ) ) {
			$default_layout = 'content-sidebar';
		} else {
			$default_layout = 'only-content';
		}

		$default['stratum_global_layout'] = $default_layout;
		$default['stratum_post_layout']   = $default_layout;
		$default['stratum_page_layout']   = $default_layout;
		if ( current_theme_supports( 'stratum_jetpack' ) ) {
			$default['stratum_project_layout'] = $default_layout;
		}
		if ( current_theme_supports( 'stratum_woocommerce' ) ) {
			$default['stratum_product_layout']         = 'only-content-full';
			$default['stratum_product_archive_layout'] = 'only-content-full';
			if ( is_active_sidebar( 'woo-sidebar-shop' ) ) {
				$default['stratum_product_archive_layout'] = 'content-sidebar';
			}
			if ( is_active_sidebar( 'woo-sidebar-product' ) ) {
				$default['stratum_product_layout'] = 'content-sidebar';
			}
		}
		$default['stratum_enforce_global'] = 1;

		return $default;
	}

	/**
	 * Add layout meta box to post/page edit screen.
	 *
	 * @since  1.0.0
	 */
	public function add_layout_metabox() {
		global $post;
		if ( '' === get_theme_mod( 'stratum_enforce_global', stratum_get_theme_defaults( 'stratum_enforce_global' ) ) ) {
			return;
		}

		// Do not display layout metabox on woocommerce shop page.
		if ( class_exists( 'WooCommerce' ) && get_option( 'woocommerce_shop_page_id' ) === $post->ID ) {
			return;
		}

		add_meta_box(
			'stratum_layout_meta',
			esc_html__( 'Post Layout', 'stratum' ),
			array( $this, 'render_layout_metabox' ),
			array( 'post', 'page', 'jetpack-portfolio', 'product' ),
			'side',
			'default'
		);
	}

	/**
	 * Render meta box to post/page edit screen.
	 *
	 * @since  1.0.0
	 *
	 * @param obj $post Current post object.
	 */
	public function render_layout_metabox( $post ) {

		// Add nonce for security and authentication.
		wp_nonce_field( basename( __FILE__ ), 'stratum_layout_nonce' );

		$layout_meta                           = get_post_meta( $post->ID );
		$layout_meta['stratum-layout-meta'][0] = ( isset( $layout_meta['stratum-layout-meta'][0] ) ) ? $layout_meta['stratum-layout-meta'][0] : '';
		$checked                               = ( isset( $layout_meta['stratum-layout-meta'][0] ) && '' === $layout_meta['stratum-layout-meta'][0] ) ? 'checked="checked"' : '';
		$layouts                               = $this->layout_choices();
		?>
		<p>
			<div class="stratum-layouts">
				<label for="meta-global-layout" style="display:block;margin-bottom:10px;">
					<input type="radio" name="stratum-layout-meta" id="layout-global" value="" <?php echo $checked; // WPCS : XSS OK. ?>/>
					<?php esc_html_e( 'Default Layout', 'stratum' ); ?>
				</label>
				<?php foreach ( $layouts as $layout => $layout_name ) { ?>
					<label for="meta-<?php echo esc_attr( $layout ); ?>" style="display:block;margin-bottom:10px;">
						<input type="radio" name="stratum-layout-meta" id="layout-<?php echo esc_attr( $layout ); ?>" value="<?php echo esc_attr( $layout ); ?>" <?php checked( $layout_meta['stratum-layout-meta'][0], $layout ); ?>/>
						<?php echo esc_html( $layout_name ); ?>
					</label>
				<?php } ?>
			</div>
		</p>
		<?php
	}

	/**
	 * Saves the custom meta input
	 *
	 * @since  1.0.0
	 *
	 * @param int $post_id Post ID.
	 */
	public function save_layout_metabox( $post_id ) {

		if ( '' === get_theme_mod( 'stratum_enforce_global', stratum_get_theme_defaults( 'stratum_enforce_global' ) ) ) {
			return;
		}

		// Do not display layout metabox on woocommerce shop page.
		if ( class_exists( 'WooCommerce' ) && get_option( 'woocommerce_shop_page_id' ) === $post_id ) {
			return;
		}

		// Checks save status.
		$is_autosave    = wp_is_post_autosave( $post_id );
		$is_revision    = wp_is_post_revision( $post_id );
		$is_valid_nonce = ( isset( $_POST['stratum_layout_nonce'] ) && wp_verify_nonce( $_POST['stratum_layout_nonce'], basename( __FILE__ ) ) ) ? true : false;

		// Exits script depending on user capability.
		if ( isset( $_POST['post_type'] ) && 'page' === $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return;
			}
		} else {
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
		}

		// Exits script depending on save status.
		if ( $is_autosave || $is_revision || ! $is_valid_nonce ) {
			return;
		}

		// Checks for input and saves.
		if ( isset( $_POST['stratum-layout-meta'] ) ) {
			$layout_meta = array_key_exists( $_POST['stratum-layout-meta'], $this->layout_choices() ) ? $_POST['stratum-layout-meta'] : '';
			update_post_meta( $post_id, 'stratum-layout-meta', $layout_meta );
		}
	}

	/**
	 * Adds custom layout classes to the array of content sidebar wrapper class.
	 *
	 * @since 1.1
	 *
	 * @param array $attr attribute values array.
	 * @return array
	 */
	public function stratum_layout_css_classes( $attr = array() ) {
		$global_layout = $this->get_layout( 'global' );
		$force_global  = ( '' === get_theme_mod( 'stratum_enforce_global', stratum_get_theme_defaults( 'stratum_enforce_global' ) ) ) ? true : false;

		// Short circuit filter.
		$check = apply_filters( 'stratum_layout_css_classes', null, $attr );
		if ( null !== $check ) {
			$attr['class'] .= ' ' . esc_attr( $check );
			return $attr;
		}

		if ( $force_global ) {
			$attr['class'] .= ' ' . esc_attr( $global_layout );
			return $attr;
		}

		if ( is_home() || is_archive() || is_search() ) {
			if ( function_exists( 'is_product_category' ) && ( is_shop() || is_product_category() ) ) {
				$woo_archive_layout = $this->get_layout( 'product_archive' );
				$attr['class']     .= ' ' . esc_attr( $woo_archive_layout );
				return $attr;
			} else {
				$attr['class'] .= ' ' . esc_attr( $global_layout );
				return $attr;
			}
		}

		if ( is_singular() ) {
			global $post;

			if ( is_singular( 'post' ) ) {
				$type = 'post';
			} elseif ( is_singular( 'jetpack-portfolio' ) ) {
				$type = 'project';
			} elseif ( is_singular( 'product' ) ) {
				$type = 'product';
			} elseif ( is_singular( 'page' ) ) {
				$type = 'page';
			} else {
				$attr['class'] .= ' ' . esc_attr( $global_layout );
				return $attr;
			}

			$default_layout = $this->get_layout( $type );

			if ( isset( $post ) ) {
				$specific_layout = get_post_meta( $post->ID, 'stratum-layout-meta', true );
			} else {
				$specific_layout = '';
			}

			if ( ! $specific_layout ) {
				$attr['class'] .= ' ' . esc_attr( $default_layout );
				return $attr;
			}

			$layouts = $this->layout_choices();
			if ( array_key_exists( $specific_layout, $layouts ) ) {
				$attr['class'] .= ' ' . esc_attr( $specific_layout );
			} else {
				$attr['class'] .= ' ' . esc_attr( $default_layout );
			}

			return $attr;
		}

		return $attr;
	}

	/**
	 * Get global layout customizer option.
	 *
	 * @since  1.0.0
	 * @param str $type Type of singular post, i.e. Post or Page.
	 * @return str Content layout.
	 */
	public function get_layout( $type ) {
		$avl_layouts = $this->layout_choices();
		$layout      = get_theme_mod( "stratum_{$type}_layout", stratum_get_theme_defaults( "stratum_{$type}_layout" ) );

		if ( ! array_key_exists( $layout, $avl_layouts ) ) {
			$layout = stratum_get_theme_defaults( "stratum_{$type}_layout" );
		}

		return $layout;
	}

	/**
	 * Returns the instance.
	 *
	 * @since  1.0.0
	 *
	 * @return object Customizer instance.
	 */
	public static function get_instance() {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}

Stratum_Layouts::init();
