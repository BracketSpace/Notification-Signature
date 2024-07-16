<?php
/**
 * Signature class
 *
 * @package notification/signature
 */

declare(strict_types=1);

namespace BracketSpace\Notification\Signature\Core;

/**
 * Signature class
 */
class Signature
{
	/**
	 * Adds the signature to email message
	 *
	 * @filter notification/carrier/email/message/pre
	 *
	 * @param  string $message Email message.
	 * @return string          Message with signature applied
	 */
	public function add($message)
	{
		if (! \Notification::settings()->getSetting('carriers/email/signature_enable')) {
			return $message;
		}

		$signature = \Notification::settings()->getSetting('carriers/email/signature');

		if (empty($signature)) {
			return $message;
		}

		return $message . '<br><br>' . $signature;
	}
}
