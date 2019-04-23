<?php
/**
 * General functions
 *
 * @package notification/signature
 */

/**
 * Creates new View object.
 *
 * @since  2.1.0
 * @return View
 */
function notification_signature_create_view() {
	return notification_signature_runtime()->view();
}
