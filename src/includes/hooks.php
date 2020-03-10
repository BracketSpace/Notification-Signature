<?php
/**
 * Hooks compatibilty file.
 *
 * Automatically generated with bin/dump-hooks.php file.
 *
 * @package notification/signature
 */

// phpcs:disable
add_filter( 'notification/carrier/email/message/pre', [ $this->component( 'core_signature' ), 'add' ], 10, 1 );
