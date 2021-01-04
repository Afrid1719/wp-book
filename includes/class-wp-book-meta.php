<?php
/**
 * WP Book Meta class with its methods
 */
class WP_Book_Meta {
	/**
	 * Meta table installation
	 *
	 * @return void
	 */
	public static function wp_bookmeta_install() {
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		global $wpdb;

		$table_name = $wpdb->prefix . 'bookmeta';

		$charset_collate = $wpdb->get_charset_collate();

		$max_index_length = 191;

		$sql = "CREATE TABLE $table_name (
		meta_id bigint(20) unsigned NOT NULL auto_increment,
		book_id bigint(20) unsigned NOT NULL default '0',
		meta_key varchar(255) default NULL,
		meta_value longtext,
		PRIMARY KEY  (meta_id),
		KEY book (book_id),
		KEY meta_key (meta_key($max_index_length))
	) $charset_collate;";

		dbDelta( $sql );
	}

	/**
	 * Integration with global wpdb
	 *
	 * @return void
	 */
	public function wp_bookmeta_integrate() {
		global $wpdb;

		$wpdb->bookmeta = $wpdb->prefix . 'bookmeta';
		$wpdb->tables[] = 'bookmeta';

		return;
	}

	/**
	 * Add meta data for the given book post
	 *
	 * @param int     $book_id Book post ID.
	 * @param string  $meta_key Meta Key for the post.
	 * @param mixed   $meta_value Meta value for the post.
	 * @param boolean $unique Whether to retrieve single or multiple value.
	 * @return mixed
	 */
	public function add_book_meta( $book_id, $meta_key, $meta_value, $unique = false ) {
		return add_metadata( 'book', $book_id, $meta_key, $meta_value, $unique );
	}

	/**
	 * Update meta data for the given book post
	 *
	 * @param int    $book_id Book post ID.
	 * @param string $meta_key Meta Key for the post.
	 * @param mixed  $meta_value Meta value for the post.
	 * @param string $prev_value Previous value.
	 * @return mixed
	 */
	public function update_book_meta( $book_id, $meta_key, $meta_value, $prev_value = '' ) {
		return update_metadata( 'book', $book_id, $meta_key, $meta_value, $prev_value );
	}

	/**
	 * Delete meta data for the given book post
	 *
	 * @param int    $book_id Book post ID.
	 * @param string $meta_key Meta key for the post.
	 * @param mixed  $meta_value Meta value for the post.
	 * @return boolean
	 */
	public function delete_book_meta( $book_id, $meta_key, $meta_value = '' ) {
		return delete_metadata( 'book', $book_id, $meta_key, $meta_value );
	}

	/**
	 * Undocumented function
	 *
	 * @param int     $book_id Book post ID.
	 * @param string  $key Meta key to retrive.
	 * @param boolean $single Whether to get single or multiple value.
	 * @return mixed
	 */
	public function get_book_meta( $book_id, $key = '', $single = false ) {
		return get_metadata( 'book', $book_id, $key, $single );
	}

}
