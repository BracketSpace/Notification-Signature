<?php
/**
 * Plugin Name: Notification : Signature
 * Description: Add your own Signature to Notification Emails
 * Plugin URI: https://bracketspace.com
 * Author: BracketSpace
 * Author URI: https://bracketspace.com
 * Version: 2.1.0
 * License: GPL3
 * Text Domain: notification-signature
 * Domain Path: /languages
 *
 * @package notification/signature
 */

/**
 * Load Composer dependencies.
 */
require_once 'vendor/autoload.php';

/**
 * Gets plugin runtime object.
 *
 * @since  2.1.0
 * @return BracketSpace\Notification\Signature\Runtime
 */
function notification_signature_runtime() {

	global $notification_signature_runtime;

	if ( empty( $notification_signature_runtime ) ) {
		$notification_signature_runtime = new BracketSpace\Notification\Signature\Runtime( __FILE__ );
	}

	return $notification_signature_runtime;

}

/**
 * Boot up the plugin
 */
add_action( 'notification/boot/initial', function() {

	/**
	 * Requirements check
	 */
	$requirements = new BracketSpace\Notification\Signature\Utils\Requirements( __( 'Notification : Signature', 'notification-signature' ), [
		'php'          => '5.6',
		'wp'           => '4.9',
		'notification' => '6.0.0',
	] );

	$requirements->add_check( 'notification', require 'src/inc/requirements/notification.php' );

	if ( ! $requirements->satisfied() ) {
		add_action( 'admin_notices', [ $requirements, 'notice' ] );
		return;
	}

	$runtime = notification_signature_runtime();
	$runtime->boot();

} );
