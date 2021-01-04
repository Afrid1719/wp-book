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
		parent::__construct( 'wp_book_category', __( 'Book Category', 'wp_book' ), $widget_options );

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
		$taxonomy = $instance['taxonomy'];

		$args = array(
			'taxonomy' => $taxonomy,
		);

		$categories = get_categories( $args );
		?>
			<?php echo $before_widget; ?>
			<?php
			if ( $title ) :
					echo $before_title . __( $title, 'wp-book' ) . $after_title;
				endif;
			?>
			<ol>
			<?php
			foreach ( $categories as $category ) :
				?>
				 
				<li><a href="<?php echo get_term_link( $category->slug, $taxonomy ); ?>" title="<?php sprintf( __( 'View all posts in %s' ), $category->name ); ?>"><?php echo $category->name; ?></a></li>
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
		$taxonomy = isset( $intance['taxonomy'] ) ? esc_attr( $instance['taxonomy'] ) : esc_attr( 'book-category' );

		?>
		<p>
		  <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'wp_book' ); ?></label>
		  <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'taxonomy' ); ?>"><?php _e( 'Choose the category to display' ); ?></label>
			<select name="<?php echo $this->get_field_name( 'taxonomy' ); ?>" id="<?php echo $this->get_field_id( 'taxonomy' ); ?>" class="widefat"/>
				<?php
				$taxonomies = get_taxonomies( array( 'name' => 'book-category' ), 'names' );
				foreach ( $taxonomies as $option ) {
					echo '<option id="' . $option . '"', $taxonomy == $option ? ' selected="selected"' : '', '>', $option, '</option>';
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
		$instance['taxonomy'] = $new_instance['taxonomy'];
		return $instance;
	}
}
