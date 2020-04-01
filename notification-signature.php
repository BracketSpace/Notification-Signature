<?php
/**
 * Legacy file for updating from previous version
 *
 * @package notification/signature
 */

/**
 * Activates plugin with new file, deactivates the old file.
 */
add_action( 'admin_init', function() {

	$new_file = dirname( __FILE__ ) . '/signature-notification.php';

	deactivate_plugins( __FILE__ );
	activate_plugin( $new_file, $_SERVER['REQUEST_URI'] ); //phpcs:ignore

	// Remove this file after new plugin activtion.
	unlink( __FILE__ );
} );
