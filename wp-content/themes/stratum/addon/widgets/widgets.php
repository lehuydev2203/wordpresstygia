<?php
/**
 * Widget API: Stratum_Widget_Master_Posts class
 *
 * @package Stratum
 * @since 1.0.0
 */

/**
 * Class used to display Posts widget.
 *
 * @since 1.0.0
 *
 * @see WP_Widget
 */
class Stratum_Widget_Master_Posts extends WP_Widget {

	/**
	 * Holds widget settings defaults, populated in constructor.
	 *
	 * @since  1.0.0
	 * @access protected
	 * @var array
	 */
	protected $defaults = array();

	/**
	 * Sets up a new Master Posts widget instance.
	 *
	 * @since 1.2.1
	 * @access public
	 */
	public function __construct() {
		$this->defaults = array(
			'title'         => esc_html__( 'Featured Posts', 'stratum' ),
			'number'        => 5,
			'orderby'       => '',
			'order'         => '',
			'posts_cat'     => '',
			'posts_layout'  => 'list_l',
			'content_limit' => 0,
			'more_text'     => esc_html__( '(more...)', 'stratum' ),
			'image_size'    => 'thumbnail',
			'show_title'    => false,
			'show_date'     => false,
			'show_author'   => false,
			'show_thumb'    => false,
		);

		$widget_ops = array(
			'classname'                   => 'stratum_widget_master_entries',
			'description'                 => esc_html__( 'Your site&#8217;s selected Posts.', 'stratum' ),
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'stratum-master-posts', esc_html__( 'Stratum  - Featured Posts', 'stratum' ), $widget_ops );
		$this->alt_option_name = 'stratum_widget_master_entries';
	}

	/**
	 * Outputs the content for the current Master Posts widget instance.
	 *
	 * @since 1.2.1
	 * @access public
	 *
	 * @param array $args     Display arguments including 'before_title', 'after_title',
	 *                        'before_widget', and 'after_widget'.
	 * @param array $instance Settings for the current Master Posts widget instance.
	 */
	public function widget( $args, $instance ) {
		if ( ! isset( $args['widget_id'] ) ) {
			$args['widget_id'] = $this->id;
		}

		// Merge with defaults.
		$instance = wp_parse_args( (array) $instance, $this->defaults );

		$title = apply_filters( 'stratum_widget_title', $instance['title'], $instance, $this->id_base );

		$r = new WP_Query( apply_filters( 'stratum_widget_posts_args', array(
			'post_type'           => 'post',
			'cat'                 => $instance['posts_cat'],
			'posts_per_page'      => $instance['number'],
			'orderby'             => $instance['orderby'],
			'order'               => $instance['order'],
			'no_found_rows'       => true,
			'post_status'         => 'publish',
			'ignore_sticky_posts' => true,
		) ) );

		if ( $r->have_posts() ) {
			echo $args['before_widget'];

			if ( $title ) {
				echo $args['before_title'] . $title . $args['after_title'];
			}
			?>
			<div class="widget-post-wrapper <?php echo esc_html( $instance['posts_layout'] ); ?>">
			<?php
			while ( $r->have_posts() ) :
				$r->the_post();
			?>
				<div class="widget-post-entry">
				<?php if ( $instance['show_thumb'] && has_post_thumbnail( $r->post->ID ) ) : ?>
					<a href="<?php the_permalink(); ?>" class="widget-post-thumbnail" aria-hidden="true">
						<?php the_post_thumbnail( $instance['image_size'], array( 'alt' => the_title_attribute( 'echo=0' ) ) ); ?>
					</a>
				<?php endif; ?>
					<div class="widget-post-content">
					<?php if ( $instance['show_title'] ) : ?>
						<div class="widget-post-title">
							<a class="master-post-title" href="<?php the_permalink(); ?>">
								<?php get_the_title() ? the_title() : the_ID(); ?>
							</a>
						</div>
					<?php endif; ?>
					<?php if ( $instance['show_date'] || $instance['show_author'] ) : ?>
						<div class="widget-post-meta">
						<?php if ( $instance['show_date'] ) : ?>
							<span class="widget-post-date"><?php echo get_the_date(); ?></span>
						<?php endif; ?>
						<?php if ( $instance['show_author'] ) : ?>
							<span class="widget-post-author">
								<?php esc_html_e( 'by', 'stratum' ); ?>
								<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"<?php stratum_attr( 'url' ); ?>>
									<span<?php stratum_attr( 'name' ); ?>> <?php the_author(); ?></span>
								</a>
							</span>
						<?php endif; ?>
						</div>
					<?php endif; ?>
					<?php if ( 0 < $instance['content_limit'] ) : ?>
						<div class="widget-post-excerpt">
							<?php stratum_limited_content( $instance['content_limit'], $instance['more_text'] ); ?>
						</div>
					<?php endif; ?>
					</div>
				</div>
			<?php endwhile; ?>
			</div>
			<?php echo $args['after_widget']; ?>
			<?php
			// Reset the global $the_post as this query will have stomped on it.
			wp_reset_postdata();
		}
	}

	/**
	 * Handles updating the settings for the current Master Posts widget instance.
	 *
	 * @since 1.2.1
	 * @access public
	 *
	 * @param array $new_instance New settings for this instance as input by the user via
	 *                            WP_Widget::form().
	 * @param array $old_instance Old settings for this instance.
	 * @return array Updated settings to save.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance                  = $old_instance;
		$instance['title']         = sanitize_text_field( $new_instance['title'] );
		$instance['number']        = (int) $new_instance['number'];
		$instance['orderby']       = sanitize_text_field( $new_instance['orderby'] );
		$instance['order']         = sanitize_text_field( $new_instance['order'] );
		$instance['posts_cat']     = sanitize_text_field( $new_instance['posts_cat'] );
		$instance['posts_layout']  = sanitize_text_field( $new_instance['posts_layout'] );
		$instance['image_size']    = sanitize_text_field( $new_instance['image_size'] );
		$instance['content_limit'] = (int) $new_instance['content_limit'];
		$instance['more_text']     = sanitize_text_field( $new_instance['more_text'] );
		$instance['show_title']    = isset( $new_instance['show_title'] ) ? (bool) $new_instance['show_title'] : false;
		$instance['show_date']     = isset( $new_instance['show_date'] ) ? (bool) $new_instance['show_date'] : false;
		$instance['show_author']   = isset( $new_instance['show_author'] ) ? (bool) $new_instance['show_author'] : false;
		$instance['show_thumb']    = isset( $new_instance['show_thumb'] ) ? (bool) $new_instance['show_thumb'] : false;
		return $instance;
	}

	/**
	 * Outputs the settings form for the Master Posts widget.
	 *
	 * @since 2.8.0
	 * @access public
	 *
	 * @param array $instance Current settings.
	 */
	public function form( $instance ) {
		// Merge with defaults.
		$instance = wp_parse_args( (array) $instance, $this->defaults );
?>
		<p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php esc_html_e( 'Title:', 'stratum' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $instance['title']; ?>" /></p>

		<p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php esc_html_e( 'Number of posts to show:', 'stratum' ); ?></label>
		<input class="tiny-text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo $instance['number']; ?>" size="3" /></p>

		<p>
			<label for="<?php echo $this->get_field_id( 'posts_cat' ); ?>"><?php esc_html_e( 'Category', 'stratum' ); ?>:</label>
			<?php
			$categories_args = array(
				'name'            => $this->get_field_name( 'posts_cat' ),
				'id'              => $this->get_field_id( 'posts_cat' ),
				'selected'        => $instance['posts_cat'],
				'orderby'         => 'Name',
				'hierarchical'    => 1,
				'show_option_all' => __( 'All Categories', 'stratum' ),
				'hide_empty'      => '0',
			);
			wp_dropdown_categories( $categories_args );
			?>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>"><?php esc_html_e( 'Order By', 'stratum' ); ?>:</label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'orderby' ) ); ?>">
				<option value="date" <?php selected( 'date', $instance['orderby'] ); ?>><?php esc_html_e( 'Date', 'stratum' ); ?></option>
				<option value="comment_count" <?php selected( 'comment_count', $instance['orderby'] ); ?>><?php esc_html_e( 'Comment Count', 'stratum' ); ?></option>
				<option value="rand" <?php selected( 'rand', $instance['orderby'] ); ?>><?php esc_html_e( 'Random', 'stratum' ); ?></option>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>"><?php esc_html_e( 'Sort Order', 'stratum' ); ?>:</label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>">
				<option value="DESC" <?php selected( 'DESC', $instance['order'] ); ?>><?php esc_html_e( 'Descending', 'stratum' ); ?></option>
				<option value="ASC" <?php selected( 'ASC', $instance['order'] ); ?>><?php esc_html_e( 'Ascending', 'stratum' ); ?></option>
			</select>
		</p>

		<hr/>

		<p><input class="checkbox" type="checkbox"<?php checked( $instance['show_title'] ); ?> id="<?php echo $this->get_field_id( 'show_title' ); ?>" name="<?php echo $this->get_field_name( 'show_title' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_title' ); ?>"><?php esc_html_e( 'Display post title?', 'stratum' ); ?></label></p>

		<p><input class="checkbox" type="checkbox"<?php checked( $instance['show_date'] ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php esc_html_e( 'Display post date?', 'stratum' ); ?></label></p>

		<p><input class="checkbox" type="checkbox"<?php checked( $instance['show_author'] ); ?> id="<?php echo $this->get_field_id( 'show_author' ); ?>" name="<?php echo $this->get_field_name( 'show_author' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_author' ); ?>"><?php esc_html_e( 'Display post author?', 'stratum' ); ?></label></p>

		<p><input class="checkbox" type="checkbox"<?php checked( $instance['show_thumb'] ); ?> id="<?php echo $this->get_field_id( 'show_thumb' ); ?>" name="<?php echo $this->get_field_name( 'show_thumb' ); ?>" />
		<label for="<?php echo $this->get_field_id( 'show_thumb' ); ?>"><?php esc_html_e( 'Display post thumbnail?', 'stratum' ); ?></label></p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'content_limit' ) ); ?>"><?php esc_html_e( 'Limit post content to', 'stratum' ); ?>
				<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'content_limit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'content_limit' ) ); ?>" value="<?php echo esc_attr( (int) $instance['content_limit'] ); ?>" size="3" />
				<?php esc_html_e( 'words', 'stratum' ); ?>
			</label>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'more_text' ) ); ?>"><?php esc_html_e( 'More Text (if applicable)', 'stratum' ); ?>:</label>
			<input type="text" id="<?php echo esc_attr( $this->get_field_id( 'more_text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'more_text' ) ); ?>" value="<?php echo esc_attr( $instance['more_text'] ); ?>" />
		</p>

		<hr />

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'image_size' ) ); ?>"><?php esc_html_e( 'Thumbnail Size', 'stratum' ); ?>:</label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'image_size' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'image_size' ) ); ?>">
				<?php
				$sizes = stratum_get_image_sizes();
				foreach ( (array) $sizes as $name => $size ) {
					printf( '<option value="%s" %s>%s (%sx%s)</option>', esc_attr( $name ), selected( $name, $instance['image_size'], false ), esc_html( $name ), esc_html( $size['width'] ), esc_html( $size['height'] ) );
				}
				?>
			</select>
		</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'posts_layout' ) ); ?>"><?php esc_html_e( 'Posts display layout', 'stratum' ); ?>:</label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'posts_layout' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'posts_layout' ) ); ?>">
				<option value="list_l" <?php selected( 'list_l', $instance['posts_layout'] ); ?>><?php esc_html_e( 'List (Thumb Left)', 'stratum' ); ?></option>
				<option value="list_r" <?php selected( 'list_r', $instance['posts_layout'] ); ?>><?php esc_html_e( 'List (Thumb Right)', 'stratum' ); ?></option>
				<option value="grid_1" <?php selected( 'grid_1', $instance['posts_layout'] ); ?>><?php esc_html_e( 'Grid (1 Column))', 'stratum' ); ?></option>
				<option value="grid_2" <?php selected( 'grid_2', $instance['posts_layout'] ); ?>><?php esc_html_e( 'Grid (2 Column))', 'stratum' ); ?></option>
				<option value="grid_3" <?php selected( 'grid_3', $instance['posts_layout'] ); ?>><?php esc_html_e( 'Grid (3 Column))', 'stratum' ); ?></option>
				<option value="grid_4" <?php selected( 'grid_4', $instance['posts_layout'] ); ?>><?php esc_html_e( 'Grid (4 Column))', 'stratum' ); ?></option>
			</select>
		</p>
<?php
	}
}

/**
 * Register Widget.
 *
 * @since 1.0.0
 */
function stratum_register_master_posts_widget() {
	register_widget( 'Stratum_Widget_Master_Posts' );
}
add_action( 'widgets_init', 'stratum_register_master_posts_widget' );

/**
 * Enqueue masonry scripts and styles.
 *
 * @since 1.0.0
 */
function stratum_widgets_styles() {
	wp_enqueue_style(
		'stratum_widgets_style',
		get_template_directory_uri() . '/addon/widgets/assets/widgets.css'
	);
	wp_style_add_data( 'stratum_widgets_style', 'rtl', 'replace' );
}
add_action( 'wp_enqueue_scripts', 'stratum_widgets_styles' );
