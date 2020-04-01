<?php
/**
 * General functions
 *
 * @package notification/signature
 */

/**
 * Gets one of the plugin filesystems
 *
 * @since  2.2.0
 * @param  string $name Filesystem name.
 * @return Filesystem|null
 */
function notification_signature_filesystem( $name ) {
	return \NotificationSignature::runtime()->get_filesystem( $name );
}
