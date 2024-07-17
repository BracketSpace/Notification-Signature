<?php
/**
 * Hooks compatibilty file.
 *
 * Automatically generated with `wp notification-signature dump-hooks`.
 *
 * @package notification/signature
 */

/** @var \BracketSpace\Notification\Signature\Runtime $this */

// phpcs:disable
add_action('notification/settings/register', [$this->component('BracketSpace\Notification\Signature\Admin\Settings'), 'registerCarrierSettings'], 30, 1);
add_filter('notification/carrier/email/message/pre', [$this->component('BracketSpace\Notification\Signature\Core\Signature'), 'add'], 10, 1);
