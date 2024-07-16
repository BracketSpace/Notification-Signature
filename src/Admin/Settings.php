<?php
/**
 * Settings
 *
 * @package notification/signature
 */

declare(strict_types=1);

namespace BracketSpace\Notification\Signature\Admin;

use BracketSpace\Notification\Utils\Settings\CoreFields;

/**
 * Settings class
 */
class Settings
{
	/**
	 * Registers carrier settings
	 *
	 * @action notification/settings/register 30
	 *
	 * @since  2.2.0
	 * @param  \BracketSpace\Notification\Utils\Settings $settings Settings API object.
	 * @return void
	 */
	public function registerCarrierSettings($settings)
	{
		$carriers = $settings->addSection(__('Carriers', 'notification-signature'), 'carriers');

		$carriers->addGroup(__('Email', 'notification'), 'email')
			->addField(
				[
				'name' => __('Enable signature', 'notification-signature'),
				'slug' => 'signature_enable',
				'default' => 'false',
				'addons' => [
					'label' => __('Add signature to every email', 'notification-signature'),
				],
				'render' => [ new CoreFields\Checkbox(), 'input' ],
				'sanitize' => [ new CoreFields\Checkbox(), 'sanitize' ],
				]
			)
			->addField(
				[
				'name' => __('Signature', 'notification-signature'),
				'slug' => 'signature',
				'addons' => [
					'wpautop' => true,
					'media_buttons' => false,
					'tiny' => true,
				],
				'description' => __('Please remember that images may not be rendered', 'notification-signature'),
				'render' => [ new CoreFields\Editor(), 'input' ],
				'sanitize' => [ new CoreFields\Editor(), 'sanitize' ],
				]
			);
	}
}
