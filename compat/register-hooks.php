<?php
/**
 * Hooks compatibilty file.
 *
 * Automatically generated with `wp notification dump-hooks`.
 *
 * @package notification/signature
 */

/** @var \BracketSpace\Notification\Signature\Runtime $this */

// phpcs:disable
add_filter( 'notification/carrier/email/message/pre', [ $this->component( 'core/signature' ), 'add' ], 10, 1 );
