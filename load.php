<?php
/**
 * Load file
 *
 * @package notification/signature
 */

/**
 * Load the main plugin file.
 */
require_once __DIR__ . '/notification-signature.php';

/**
 * Initialize early.
 */
add_action( 'notification/init', function() {
	NotificationSignature::init( __FILE__ )->init();
}, 1 );
