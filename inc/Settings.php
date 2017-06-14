<?php
/**
 * Settings class
 */

namespace underDEV\Notification\Signature;
use underDEV\Utils\Settings\CoreFields;

class Settings {

	public function __construct() {

		add_action( 'notification/settings', array( $this, 'register_settings' ) );

	}

	public function register_settings( $settings_api ) {

		if ( ! class_exists( 'underDEV\Utils\Settings\CoreFields\Editor' ) ) {
			$signature_field = new CoreFields\Text();
			$signature_description = __( 'Please update Notification plugin to get Visual Editor here', 'notification-signature' );
		} else {
			$signature_field = new CoreFields\Editor();
			$signature_description = __( 'Please remember that images may not be rendered', 'notification-signature' );
		}

		$signature = $settings_api->add_section( __( 'Signature', 'notification-signature' ), 'signature' );

		$signature->add_group( __( 'Signature', 'notification-signature' ), 'general' )
			->add_field( array(
				'name'     => __( 'Enable', 'notification-signature' ),
				'slug'     => 'enable',
				'default'  => 'false',
				'addons'   => array(
					'label' => __( 'Add signature to every email', 'notification-signature' )
				),
				'render'   => array( new CoreFields\Checkbox(), 'input' ),
				'sanitize' => array( new CoreFields\Checkbox(), 'sanitize' ),
			) )
			->add_field( array(
				'name'     => __( 'Signature', 'notification-signature' ),
				'slug'     => 'signature',
				'addons'   => array(
					'wpautop'       => true,
					'media_buttons' => false,
					'tiny'          => true,
				),
				'description' => $signature_description,
				'render'   => array( $signature_field, 'input' ),
				'sanitize' => array( $signature_field, 'sanitize' ),
			) )
			->description( __( 'Signature settings for email.', 'notification' ) );

	}

}
