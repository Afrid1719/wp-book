<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://afrid.com
 * @since      1.0.0
 *
 * @package    WP_Book
 * @subpackage WP_Book/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    WP_Book
 * @subpackage WP_Book/admin
 * @author     Afrid <aliatif908@gmail.com>
 * Text Domain:       wp-book
 * Domain Path:       /languages
 */
class WP_Book_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $wp_book    The ID of this plugin.
	 */
	private $wp_book;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Reference to Book Meta object
	 *
	 * @access   private
	 * @var      object    $bookmeta    The reference to wp_book_meta object
	 */
	private $bookmeta;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $wp_book       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $wp_book, $version ) {

		$this->wp_book = $wp_book;
		$this->version = $version;

		require_once dirname( dirname( __FILE__ ) ) . '/includes/class-wp-book-meta.php';
		$this->bookmeta = new WP_Book_Meta();

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->wp_book, plugin_dir_url( __FILE__ ) . 'css/wp-book-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->wp_book, plugin_dir_url( __FILE__ ) . 'js/wp-book-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Registers a custom post type - WP Book
	 *
	 * @return   void
	 * @since    1.0.0
	 */
	public function register_book_post_type() {
		$labels = array(
			'name'               => __( 'WP Books', 'wp-book' ),
			'singular_name'      => __( 'WP Book', 'wp-book' ),
			'add_new'            => _x( 'Add New', 'wp_book', 'wp_book' ),
			'add_new_item'       => __( 'Add New WP Book', 'wp_book' ),
			'edit_item'          => __( 'Edit WP Book', 'wp_book' ),
			'new_item'           => __( 'New WP Book', 'wp_book' ),
			'view_item'          => __( 'View WP Book', 'wp_book' ),
			'view_items'         => __( 'View WP Books', 'wp_book' ),
			'search_items'       => __( 'Search WP Books', 'wp_book' ),
			'not_found'          => __( 'No WP Books found', 'wp_book' ),
			'not_found_in_trash' => __( 'No WP Books found in trash', 'wp_book' ),
			'all_items'          => __( 'All WP Books', 'wp_book' ),
			'archives'           => __( 'WP Books Archives', 'wp_book' ),
			'attributes'         => __( 'WP Books Attributes', 'wp_book' ),
		);

		$args = array(
			'labels'              => $labels,
			'public'              => true,
			'description'         => __( 'This is a custom WP Book post type', 'wp_book' ),
			'hierarchical'        => false,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => false,
			'capability_type'     => 'post',
			'has_archive'         => __( 'cpt-wp-books', 'wp_book' ),
			'taxonomies'          => array( 'book-category', 'book-tag' ),
			'rewrite'             => array( 'slug' => 'cpt-wp-book' ),
			'query_var'           => 'cpt_wp_book',
		);

		register_post_type( 'cpt_wp_book', $args );
	}

	/**
	 * Registers Book Category Taxonomy
	 *
	 * @return   void
	 * @since    1.0.0
	 */
	public function register_book_category_taxonomy() {
		$labels = array(
			'name'              => _x( 'Book Categories', 'taxonomy general name', 'wp_book' ),
			'singular_name'     => _x( 'Book Category', 'taxonomy singular name', 'wp_book' ),
			'search_items'      => __( 'Search Book Categories', 'wp_book' ),
			'all_items'         => __( 'All Book Categories', 'wp_book' ),
			'parent_item'       => __( 'Parent Book Category', 'wp_book' ),
			'parent_item_colon' => __( 'Parent Book Category:', 'wp_book' ),
			'edit_item'         => __( 'Edit Book Category', 'wp_book' ),
			'view_item'         => __( 'View Book Category', 'wp_book' ),
			'update_item'       => __( 'Update Book Category', 'wp_book' ),
			'add_new_item'      => __( 'Add New Book Category', 'wp_book' ),
			'new_item_name'     => __( 'New Book Category', 'wp_book' ),
			'menu_name'         => __( 'Book Categories', 'wp_book' ),
			'not_found'         => __( 'No book categories found', 'wp_book' ),
			'no_terms'          => __( 'No book categories', 'wp_book' ),
		);
		$args   = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'book-category' ),
		);
		register_taxonomy( 'book-category', array( 'cpt_wp_book' ), $args );
	}

	/**
	 * Registers Book Tag taxonomy
	 *
	 * @return   void
	 * @since    1.0.0
	 */
	public function register_book_tag_taxonomy() {
		$labels = array(
			'name'                       => _x( 'Book Tags', 'taxonomy general name', 'wp_book' ),
			'singular_name'              => _x( 'Book Tag', 'taxonomy singular name', 'wp_book' ),
			'search_items'               => __( 'Search Book Tags', 'wp_book' ),
			'popular_items'              => __( 'Book Tags', 'wp_book' ),
			'all_items'                  => __( 'All Book Tags', 'wp_book' ),
			'edit_item'                  => __( 'Edit Book Tag', 'wp_book' ),
			'view_item'                  => __( 'View Book Tag', 'wp_book' ),
			'update_item'                => __( 'Update Book Tag', 'wp_book' ),
			'add_new_item'               => __( 'Add New Book Tag', 'wp_book' ),
			'new_item_name'              => __( 'New Book Tag', 'wp_book' ),
			'separate_items_with_commas' => __( 'Separate book tags with commas', 'wp_book' ),
			'menu_name'                  => __( 'Book Tags', 'wp_book' ),
			'not_found'                  => __( 'No book tags found', 'wp_book' ),
			'no_terms'                   => __( 'No book tags', 'wp_book' ),
		);
		$args   = array(
			'hierarchical'      => false,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array( 'slug' => 'book-tag' ),
		);
		register_taxonomy( 'book-tag', array( 'cpt_wp_book' ), $args );
	}

	/**
	 * To add a hook to create custom meta box
	 *
	 * @return void
	 */
	public function show_off_meta_box() {
		add_action( 'add_meta_boxes', array( $this, 'add_custom_meta_box' ) );
	}

	/**
	 * Creates a custom meta box
	 *
	 * @return void
	 */
	public function add_custom_meta_box() {
		add_meta_box(
			'wb_post_meta_box',
			'WP Books Meta',
			array( $this, 'wb_meta_box_renderer' ),
			'cpt_wp_book',
			'side',
			'default'
		);
	}

	/**
	 * HTML renderer of the custom meta box
	 *
	 * @param    [post_type] $post
	 * @return   void
	 */
	public function wb_meta_box_renderer( $post ) {
		$elems = array(
			'Author'    => 'text',
			'Price'     => 'number',
			'Publisher' => 'text',
			'Year'      => 'number',
			'Edition'   => 'text',
			'URL'       => 'url',
		);

		$values = array();
		foreach ( array_keys( $elems ) as $key ) {
			$value = $this->bookmeta->get_book_meta( $post->ID, strtolower( $key ), true );

			if ( ! empty( $value ) ) {
				$values[ $key ] = $value;
			}
		}

		?>

		<?php wp_nonce_field( basename( __FILE__ ), 'wp_bookmeta_nonce' ); ?>

		<?php
		foreach ( $elems as $key => $value ) :
			if ( 'Year' === $key ) :
				?>

					<label
						for="<?php esc_attr_e( 'wp_book_year', 'wp_book' ); ?>"
					>
						<?php printf( __( '%s', 'wp_book' ), $key ); ?>
					</label>
					<br/>
					<input
						type="<?php printf( esc_attr( '%s', 'wp_book' ), $value ); ?>"
						id="<?php printf( esc_attr( '%s', 'wp_book' ), $key ); ?>"
						name="<?php printf( esc_attr( '%s', 'wp_book' ), $key ); ?>"
						placeholder="<?php esc_attr_e( 'YYYY', 'wp_book' ); ?>"
						min="1900"
						max="2020"
						value="<?php echo $values[ $key ] ?? ''; ?>"
					/>

				<?php
			else :
				?>
				<p>
					<label
						for="<?php printf( esc_attr( '%s', 'wp_book' ), $key ); ?>"
					>
						<?php printf( __( '%s', 'wp_book' ), $key ); ?>
					</label>
					<br/>
					<input
						type="<?php printf( esc_attr( '%s', 'wp_book' ), $value ); ?>"
						id="<?php printf( esc_attr( '%s', 'wp_book' ), $key ); ?>"
						name="<?php printf( esc_attr( '%s', 'wp_book' ), $key ); ?>"
						value="<?php echo $values[ $key ] ?? ''; ?>"
					/>
				</p>
				<?php
			endif;
		endforeach;
	}

	/**
	 * Saves Book Meta Information
	 *
	 * @param  [int] $post_id
	 * @return mixed
	 */
	public function save_book_meta( $post_id ) {
		if ( ! isset( $_POST['wp_bookmeta_nonce'] ) || ! wp_verify_nonce( $_POST['wp_bookmeta_nonce'], basename( __FILE__ ) ) ) {
			return $post_id;
		}

		if ( 'cpt-wp-book' !== get_post( $post_id )->post_slug ) {
			return;
		}

			$inputs = array(
				'Author',
				'Price',
				'Publisher',
				'Year',
				'Edition',
				'URL',
			);

			/**
			 * Stores input array length
			 *
			 * @var   int $input_arr_length
			 */
			$input_arr_length = count( $inputs );
			for ( $i = 0; $i < $input_arr_length; $i++ ) {
				if ( ! empty( $_POST[ $inputs[ $i ] ] ) ) {
					$this->bookmeta->update_book_meta( $post_id, sanitize_key( "$inputs[$i]" ), sanitize_text_field( $_POST[ $inputs[ $i ] ] ) );
				} else {
					$this->bookmeta->delete_book_meta( $post_id, sanitize_key( "$inputs[$i]" ) );
				}
			}

	}
}
