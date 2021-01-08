<?php
/**
 * Custom Book Category Widget
 *
 * Defines the class for custom widget.
 *
 * @package    WP_Book
 * @subpackage WP_Book/public
 * @author     Afrid <aliatif908@gmail.com>
 */
class WP_Book_Category_Widget extends WP_Widget {

	/**
	 * Widget setup
	 */
	public function __construct() {

		$widget_options = array(
			'classname'   => 'wp-book-category-widget',
			'description' => __( 'Custom widget to display the books of selected category.', 'wp_book' ),
		);
		parent::__construct( 'wp_book_category', __( 'WP Books', 'wp_book' ), $widget_options );

	}

	/**
	 *  Outputs the content of the widget
	 *
	 * @param array $args
	 * @param array $instance
	 * @return void
	 */
	public function widget( $args, $instance ) {
		extract( $args );

		$title    = apply_filters( 'widget_title', $instance['title'] );
		$category = isset( $instance['category'] ) ? $instance['category'] : '';

		if ( 'Select a category' === $category || '' === $category ) {
			/**
			 * Without "field" key the query would return all the
			 * terms when provided with an arbitary value.
			 *
			 * This fetches all the posts associated with the given
			 * taxonomy regardless of any term
			 */
			$args = array(
				array(
					'taxonomy' => 'book-category',
					'terms'    => 'abc',
				),
			);
		} else {
			$args = array(
				array(
					'taxonomy' => 'book-category',
					'field'    => 'slug',
					'terms'    => $category,
				),
			);
		}

		$posts = new WP_Query(
			array(
				'post_type' => 'cpt_wp_book',
				'tax_query' => $args,
			)
		);

		$posts = $posts->get_posts();
		?>
			<?php echo $before_widget; ?>
			<?php
			if ( $title ) :
					echo $before_title . __( $title, 'wp-book' ) . $after_title;
				endif;
			?>
			<ol>
			<?php
			foreach ( $posts as $post ) :
				?>
				 
				<li><a href="<?php echo get_permalink( $post ); ?>" title="<?php sprintf( __( 'View all posts in %s' ), $post->post_title ); ?>"><?php echo $post->post_title; ?></a></li>
			<?php endforeach; ?>
			</ol>
			<?php $after_widget; ?>
		<?php
	}

	/**
	 * Outputs the options form on admin
	 *
	 * @param array $instance The widget options
	 */
	public function form( $instance ) {
		$title    = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : esc_attr( 'Book Categories' );
		$category = isset( $instance['category'] ) ? esc_attr( $instance['category'] ) : '';

		?>
		<p>
		  <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'wp_book' ); ?></label>
		  <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Choose the category to display' ); ?></label>
			<select name="<?php echo $this->get_field_name( 'category' ); ?>" id="<?php echo $this->get_field_id( 'category' ); ?>" class="widefat"/>
				<option>Select a category</option>
				<?php
				$terms = get_terms(
					array(
						'taxonomy' => 'book-category',
					)
				);

				foreach ( $terms as $option ) {
					echo '<option id="' . $option->name . '" value="' . $option->slug . '"', $category === $option->slug ? ' selected="selected"' : '', '>', $option->name, '</option>';
				}
				?>
			</select>
		</p>
		<?php
	}

	/**
	 * Processing widget options on save
	 *
	 * @param array $new_instance The new options
	 * @param array $old_instance The previous options
	 *
	 * @return array
	 */
	public function update( $new_instance, $old_instance ) {
		$instance             = $old_instance;
		$instance['title']    = strip_tags( $new_instance['title'] );
		$instance['category'] = $new_instance['category'];
		return $instance;
	}
}
