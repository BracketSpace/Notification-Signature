<?php
/**
 * Plugin Name: Notification : Signature
 * Description: Add your own Signature to Notification Emails
 * Author: BracketSpace
 * Author URI: https://bracketspace.com
 * Version: 2.0.1
 * License: GPL3
 * Text Domain: notification-signature
 * Domain Path: /languages
 *
 * @package notification/signature
 */

/**
 * Plugin's autoload function
 *
 * @param  string $class class name.
 * @return mixed         false if not plugin's class or void
 */
function notification_signature_autoload( $class ) {

	$parts = explode( '\\', $class );

	if ( array_shift( $parts ) != 'BracketSpace' ) {
		return false;
	}

	if ( array_shift( $parts ) != 'Notification' ) {
		return false;
	}

	if ( array_shift( $parts ) != 'Signature' ) {
		return false;
	}

	$file = trailingslashit( dirname( __FILE__ ) ) . trailingslashit( 'class' ) . implode( '/', $parts ) . '.php';

	if ( file_exists( $file ) ) {
		require_once $file;
	}

}
spl_autoload_register( 'notification_signature_autoload' );

/**
 * Boot up the plugin in theme's action just in case the Notification
 * is used as a bundle.
 */
add_action( 'after_setup_theme', function() {

	/**
	 * Requirements check
	 */
	$requirements = new BracketSpace\Notification\Signature\Utils\Requirements( __( 'Notification : Signature', 'notification-signature' ), array(
		'php'          => '5.3',
		'wp'           => '4.6',
		'notification' => true,
	) );

	/**
	 * Tests if Notification plugin is active
	 * We have to do it like this in case the plugin
	 * is loaded as a bundle.
	 *
	 * @param string $comparsion value to test.
	 * @param object $r          requirements.
	 * @return void
	 */
	function notification_signature_check_base_plugin( $comparsion, $r ) {
		if ( $comparsion === true && ! function_exists( 'notification_runtime' ) ) {
			$r->add_error( __( 'Notification plugin active', 'notification-signature' ) );
		}
	}

	$requirements->add_check( 'notification', 'notification_signature_check_base_plugin' );

	if ( ! $requirements->satisfied() ) {
		add_action( 'admin_notices', array( $requirements, 'notice' ) );
		return;
	}

	/**
	 * Add Signature Settings to Email Notification
	 */
	notification_register_settings( function( $settings ) {

		$notifications = $settings->add_section( __( 'Notifications', 'notification' ), 'notifications' );

		$notifications->add_group( __( 'Email', 'notification' ), 'email' )
			->add_field( array(
				'name'     => __( 'Enable signature', 'notification-signature' ),
				'slug'     => 'signature_enable',
				'default'  => 'false',
				'addons'   => array(
					'label' => __( 'Add signature to every email', 'notification-signature' )
				),
				'render'   => array( new BracketSpace\Notification\Signature\Utils\Settings\CoreFields\Checkbox(), 'input' ),
				'sanitize' => array( new BracketSpace\Notification\Signature\Utils\Settings\CoreFields\Checkbox(), 'sanitize' ),
			) )
			->add_field( array(
				'name'        => __( 'Signature', 'notification-signature' ),
				'slug'        => 'signature',
				'addons'      => array(
					'wpautop'       => true,
					'media_buttons' => false,
					'tiny'          => true,
				),
				'description' => __( 'Please remember that images may not be rendered', 'notification-signature' ),
				'render'      => array( new BracketSpace\Notification\Signature\Utils\Settings\CoreFields\Editor(), 'input' ),
				'sanitize'    => array( new BracketSpace\Notification\Signature\Utils\Settings\CoreFields\Editor(), 'sanitize' ),
			) );

	}, 1000 );

	/**
	 * Add Signature to Email content
	 */
	add_filter( 'notification/email/message/pre', function( $message, $notification, $trigger ) {

		if ( ! notification_get_setting( 'notifications/email/signature_enable' ) ) {
			return $message;
		}

		$signature = notification_get_setting( 'notifications/email/signature' );

		if ( empty( $signature ) ) {
			return $message;
		}

		return $message . '<br><br>' . $signature;

	}, 10, 3 );


} );
