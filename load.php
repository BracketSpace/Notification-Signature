<?php
/**
 * Load file
 *
 * @package notification/signature
 */

declare(strict_types=1);

/**
 * Load the main plugin file.
 */
require_once __DIR__ . '/notification-signature.php';

/**
 * Initialize early.
 */
add_action(
	'notification/init',
	static function () {
		NotificationSignature::init(__FILE__)->init();
	},
	1
);
