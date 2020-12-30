<?php


class WP_Book_Meta {
	public static function wp_bookmeta_install() {
		require_once ABSPATH . 'wp-admin/includes/upgrade.php';

		global $wpdb;

		$table_name = $wpdb->prefix . 'bookmeta';

		$charset_collate = $wpdb->get_charset_collate();

		$max_index_length = 191;

		$install_query = "CREATE TABLE $table_name (
		meta_id bigint(20) unsigned NOT NULL auto_increment,
		book_id bigint(20) unsigned NOT NULL default '0',
		meta_key varchar(255) default NULL,
		meta_value longtext,
		PRIMARY KEY  (meta_id),
		KEY badge (book_id),
		KEY meta_key (meta_key($max_index_length))
	) $charset_collate;";

	dbDelta( $install_query );
	}

	public function wp_bookmeta_integrate() {
		global $wpdb;

		$wpdb->bookmeta = $wpdb->prefix . 'bookmeta';
		$wpdb->tables[] = 'bookmeta';

		return;
	}

	public function add_book_meta($book_id, $meta_key, $meta_value,$unique = false) {
		return add_metadata('book', $book_id, $meta_key, $meta_value, $unique);
	}

	public function update_book_meta($book_id, $meta_key, $meta_value, $prev_value = '') {
		return update_metadata('book', $book_id, $meta_key, $meta_value, $prev_value);
	}

	public function delete_book_meta($book_id, $meta_key, $meta_value = '') {
		return delete_metadata('book', $book_id, $meta_key, $meta_value);
	}

	public function get_book_meta($book_id, $key = '', $single = false) {
		return get_metadata('book', $book_id, $key, $single);
	}

}