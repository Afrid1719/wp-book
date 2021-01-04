<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://afrid.com
 * @since      1.0.0
 *
 * @package    WP_Book
 * @subpackage WP_Book/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    WP_Book
 * @subpackage WP_Book/public
 * @author     Afrid <aliatif908@gmail.com>
 */
class WP_Book_Public {

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
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $wp_book       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $wp_book, $version ) {

		$this->wp_book = $wp_book;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->wp_book, plugin_dir_url( __FILE__ ) . 'css/wp-book-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->wp_book, plugin_dir_url( __FILE__ ) . 'js/wp-book-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register [wpbook] shortcode
	 *
	 * @return void
	 */
	public function wp_book_register_shortcode() {
		add_shortcode( 'wpbook', array( $this, 'wp_book_shortcode_handler' ) );
	}

	/**
	 * Shortcode callback
	 *
	 * This is shortcode accepts anyone of the attributes mentioned -
	 * id, author, year, publisher
	 *
	 * @param   mixed $atts Holds the attributes of the shortcode.
	 * @return  mixed
	 */
	public function wp_book_shortcode_handler( $atts ) {
		require_once dirname( dirname( __FILE__ ) ) . '/includes/class-wp-book-meta.php';

		$book_meta    = new WP_Book_Meta();
		$default_atts = array(
			'id'        => '',
			'author'    => '',
			'year'      => '',
			'category'  => '',
			'tag'       => '',
			'publisher' => '',
		);

		$atts = shortcode_atts( $default_atts, $atts );
		$args = array_filter( $atts );

		if ( ! count( $args ) ) {
			return esc_html__( 'No results found!!', 'wp_book' );
		}

		if ( isset( $args['id'] ) ) {
			$post = get_post( $args['id'] );

			if ( is_null( $post ) ) {
				return esc_html__( 'No results found!!', 'wp_book' );
			}

			$post_title = $post->post_title;
			$post_price = $book_meta->get_book_meta( $post->ID, 'price', true );

			$html = <<<HTML
				<h4>{$post_title}</h4>
				Price : <em>{$post_price}</em>
			HTML;

			return $html;
		}

		$args_key = array_keys( $args );

		global $wpdb;
		$dbquery = $wpdb->prepare(
			"SELECT $wpdb->posts.ID, $wpdb->posts.post_title, $wpdb->bookmeta.meta_key, $wpdb->bookmeta.meta_value
			FROM $wpdb->posts, $wpdb->bookmeta
			WHERE $wpdb->posts.ID = $wpdb->bookmeta.book_id
			AND $wpdb->bookmeta.meta_key = %s",
			$args_key[0]
		);

		$res  = $wpdb->get_results( $dbquery, OBJECT );
		$html = '';

		foreach ( $res as $post ) {
			if ( $post->meta_value === $args[ $args_key[0] ] ) {

				$post_title = $post->post_title;
				$post_price = $book_meta->get_book_meta( $post->ID, 'price', true );

				$html .= <<<HTML
					<h4>{$post_title}</h4>
					Price : <em>{$post_price}</em>
				HTML;
			}
		}

		if ( empty( $html ) ) {
			return esc_html__( 'No results found!!', 'wp_book' );
		}

		return $html;
	}

	/**
	 * Register Custom Book Category Widget
	 *
	 * @return void
	 */
	public function wp_book_register_custom_widget() {
		require_once dirname( __FILE__ ) . '/class-wp-book-category-widget.php';

		register_widget( 'WP_Book_Category_Widget' );
	}
}

