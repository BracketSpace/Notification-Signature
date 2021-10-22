<?php
/**
 * Settings
 *
 * @package notification/signature
 */

namespace BracketSpace\Notification\Signature\Admin;

use BracketSpace\Notification\Utils\Settings\CoreFields;

/**
 * Settings class
 */
class Settings {

	/**
	 * Registers carrier settings
	 *
	 * @since  2.2.0
	 * @param  object $settings Settings API object.
	 * @return void
	 */
	public function register_carrier_settings( $settings ) {
		$carriers = $settings->add_section( __( 'Carriers', 'notification-signature' ), 'carriers' );

		$carriers->add_group( __( 'Email', 'notification' ), 'email' )
			->add_field( [
				'name'     => __( 'Enable signature', 'notification-signature' ),
				'slug'     => 'signature_enable',
				'default'  => 'false',
				'addons'   => [
					'label' => __( 'Add signature to every email', 'notification-signature' ),
				],
				'render'   => [ new CoreFields\Checkbox(), 'input' ],
				'sanitize' => [ new CoreFields\Checkbox(), 'sanitize' ],
			] )
			->add_field( [
				'name'        => __( 'Signature', 'notification-signature' ),
				'slug'        => 'signature',
				'addons'      => [
					'wpautop'       => true,
					'media_buttons' => false,
					'tiny'          => true,
				],
				'description' => __( 'Please remember that images may not be rendered', 'notification-signature' ),
				'render'      => [ new CoreFields\Editor(), 'input' ],
				'sanitize'    => [ new CoreFields\Editor(), 'sanitize' ],
			] );
	}

}
