<?php
/**
 * Plugin Name: Notification : Signature
 * Description: Add your own Signature to Notification Emails
 * Plugin URI: https://bracketspace.com
 * Author: BracketSpace
 * Author URI: https://bracketspace.com
 * Version: 4.0.0
 * License: GPL3
 * Text Domain: notification-signature
 * Domain Path: /languages
 * Requires Plugins: notification
 *
 * @package notification/signature
 *
 * phpcs:disable PSR1.Files.SideEffects.FoundWithSymbols
 * phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace
 * phpcs:disable Squiz.Classes.ClassFileName.NoMatch
 */

declare(strict_types=1);

if (! class_exists('NotificationSignature')) :

	/**
	 * NotificationSignature class
	 */
	class NotificationSignature
	{
		/**
		 * Runtime object
		 *
		 * @var ?BracketSpace\Notification\Signature\Runtime
		 */
		protected static $runtime;

		/**
		 * Initializes the plugin runtime
		 *
		 * @since  2.2.0
		 * @param  string $pluginFile Main plugin file.
		 * @return BracketSpace\Notification\Signature\Runtime
		 */
		public static function init($pluginFile)
		{
			if (self::$runtime === null) {
				// Autoloading.
				require_once dirname($pluginFile) . '/vendor/autoload.php';
				self::$runtime = new BracketSpace\Notification\Signature\Runtime($pluginFile);
			}

			return self::$runtime;
		}

		/**
		 * Gets runtime component
		 *
		 * @since  2.2.0
		 * @return array<class-string,mixed>
		 */
		public static function components()
		{
			return self::$runtime !== null ? self::$runtime->components() : [];
		}

		/**
		 * Gets runtime component
		 *
		 * @since  2.2.0
		 * @param  string $componentName Component name.
		 * @return mixed
		 */
		public static function component($componentName)
		{
			return self::$runtime !== null ? self::$runtime->component($componentName) : null;
		}

		/**
		 * Gets runtime object
		 *
		 * @since  2.2.0
		 * @return ?BracketSpace\Notification\Signature\Runtime
		 */
		public static function runtime()
		{
			return self::$runtime;
		}

		/**
		 * Gets plugin filesystem
		 *
		 * @since  4.0.0
		 * @throws \Exception When runtime wasn't invoked yet.
		 * @return \BracketSpace\Notification\Signature\Dependencies\Micropackage\Filesystem\Filesystem
		 */
		public static function fs()
		{
			if (self::$runtime === null) {
				throw new \Exception('Runtime has not been invoked yet.');
			}

			return self::$runtime->getFilesystem();
		}
	}

endif;

add_action(
	'notification/init',
	static function () {
		NotificationSignature::init(__FILE__)->init();
	},
	2
);
