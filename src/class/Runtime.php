<?php
/**
 * Runtime
 *
 * @package notification/signature
 */

namespace BracketSpace\Notification\Signature;

use BracketSpace\Notification\Utils;

/**
 * Runtime class
 */
class Runtime extends Utils\DocHooks {

	/**
	 * Plugin file path
	 *
	 * @var string
	 */
	protected $plugin_file;

	/**
	 * Class constructor
	 *
	 * @since 2.1.0
	 * @param string $plugin_file Plugin main file full path.
	 */
	public function __construct( $plugin_file ) {
		$this->plugin_file = $plugin_file;
		$this->add_hooks();
	}

	/**
	 * Loads needed files
	 *
	 * @since  2.1.0
	 * @return void
	 */
	public function boot() {

		$this->instances();
		$this->load_functions();

	}

	/**
	 * Creates needed class instances
	 *
	 * @since  2.1.0
	 * @return void
	 */
	public function instances() {

		$this->files = new Utils\Files( $this->plugin_file );

		$this->add_hooks( new Utils\Internationalization( $this->files, 'notification-signature' ) );
		$this->add_hooks( new Core\Signature() );

		$settings = $this->add_hooks( new Core\Settings() );

		notification_register_settings( [ $settings, 'register_settings' ], 1000 );

	}

	/**
	 * Creates instances when Notification plugin is fully loaded
	 * Useful when you are depending on registered Carriers or Triggers
	 *
	 * @action notification/boot
	 *
	 * @since  2.1.0
	 * @return void
	 */
	public function late_instances() {

	}

	/**
	 * Returns new View object
	 *
	 * @since  2.1.0
	 * @return View view object
	 */
	public function view() {
		return new Utils\View( $this->files );
	}

	/**
	 * Loads functions from src/inc/functions directory
	 * All .php files are loaded automatically
	 *
	 * @since  2.1.0
	 * @return void
	 */
	public function load_functions() {

		$function_files = glob( $this->files->dir_path( 'src/inc/functions/' ) . '*.php' );

		if ( empty( $function_files ) ) {
			return;
		}

		foreach ( $function_files as $file ) {
			require_once $file;
		}

	}

}
