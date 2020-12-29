<?php

/**
 * Fired during plugin activation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    WP_Book
 * @subpackage WP_Book/includes
 * @author     Afrid <aliatif908@gmail.com>
 */
class WP_Book_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		require_once dirname( plugin_dir_path( __FILE__ ) ) . '/admin/class-wp-book-admin.php';
		$wp_book = new WP_Book_Admin( 'wp-book', WP_BOOK_VERSION );
		$wp_book->register_book_post_type();

		flush_rewrite_rules();
	}

}
