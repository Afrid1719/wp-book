<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://afrid.com
 * @since      1.0.0
 *
 * @package    WP_Book
 * @subpackage WP_Book/admin/partials
 */

?>

<!-- This renders the form in the WP Book Admin Menu -->
<h1>WP Book Settings</h1>
<?php settings_errors(); ?>
<form action="options.php" method="POST">
	<?php settings_fields( 'wp-book-admin-settings-group' ); ?>
	<?php do_settings_sections( 'wp-book-admin-settings' ); ?>
	<?php submit_button(); ?>
</form>
