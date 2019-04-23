<?php
/**
 * Signature class
 *
 * @package notification/signature
 */

namespace BracketSpace\Notification\Signature\Core;

use BracketSpace\Notification\Utils\Files;

/**
 * Signature class
 */
class Signature {

	/**
	 * Adds the signature to email message
	 *
	 * @filter notification/carrier/email/message/pre
	 *
	 * @param  string $message Email message.
	 * @return string          Message with signature applied
	 */
	public function add( $message ) {

		if ( ! notification_get_setting( 'notifications/email/signature_enable' ) ) {
			return $message;
		}

		$signature = notification_get_setting( 'notifications/email/signature' );

		if ( empty( $signature ) ) {
			return $message;
		}

		return $message . '<br><br>' . $signature;

	}

}
