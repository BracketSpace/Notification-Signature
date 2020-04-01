<?php
/**
 * Plugin Name: Notification : Signature
 * Description: Add your own Signature to Notification Emails
 * Plugin URI: https://bracketspace.com
 * Author: BracketSpace
 * Author URI: https://bracketspace.com
 * Version: 2.2.0
 * License: GPL3
 * Text Domain: notification-signature
 * Domain Path: /languages
 *
 * @package notification/signature
 */

if ( ! class_exists( 'NotificationSignature' ) ) :

	/**
	 * NotificationSignature class
	 */
	class NotificationSignature {

		/**
		 * Runtime object
		 *
		 * @var BracketSpace\Notification\Signature\Runtime
		 */
		protected static $runtime;

		/**
		 * Initializes the plugin runtime
		 *
		 * @since  2.2.0
		 * @param  string $plugin_file Main plugin file.
		 * @return BracketSpace\Notification\Signature\Runtime
		 */
		public static function init( $plugin_file ) {
			if ( ! isset( self::$runtime ) ) {
				// Autoloading.
				require_once dirname( $plugin_file ) . '/vendor/autoload.php';
				self::$runtime = new BracketSpace\Notification\Signature\Runtime( $plugin_file );
			}

			return self::$runtime;
		}

		/**
		 * Gets runtime component
		 *
		 * @since  2.2.0
		 * @return array
		 */
		public static function components() {
			return isset( self::$runtime ) ? self::$runtime->components() : [];
		}

		/**
		 * Gets runtime component
		 *
		 * @since  2.2.0
		 * @param  string $component_name Component name.
		 * @return mixed
		 */
		public static function component( $component_name ) {
			return isset( self::$runtime ) ? self::$runtime->component( $component_name ) : null;
		}

		/**
		 * Gets runtime object
		 *
		 * @since  2.2.0
		 * @return BracketSpace\Notification\Runtime
		 */
		public static function runtime() {
			return self::$runtime;
		}

	}

endif;

add_action( 'notification/init', function() {
	NotificationSignature::init( __FILE__ )->init();
}, 2 );
