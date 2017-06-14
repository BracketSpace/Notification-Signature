<?php
/**
 * Processor class
 */

namespace underDEV\Notification\Signature;
use underDEV\Notification\Settings;

class Processor {

	public function __construct() {

		if ( Settings::get()->get_setting( 'signature/general/enable' ) ) {
			add_filter( 'notification/notify/message', array( $this, 'add_signature' ) );
		}

	}

	public function add_signature( $message ) {

		return $message . wpautop( Settings::get()->get_setting( 'signature/general/signature' ) );

	}

}
