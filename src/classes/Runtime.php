<?php
/**
 * Runtime
 *
 * @package notification/signature
 */

namespace BracketSpace\Notification\Signature;

use BracketSpace\Notification\Signature\Vendor\Micropackage\Requirements\Requirements;
use BracketSpace\Notification\Signature\Vendor\Micropackage\DocHooks\HookTrait;
use BracketSpace\Notification\Signature\Vendor\Micropackage\DocHooks\Helper as DocHooksHelper;
use BracketSpace\Notification\Signature\Vendor\Micropackage\Filesystem\Filesystem;

/**
 * Runtime class
 */
class Runtime {

	use HookTrait;

	/**
	 * Main plugin file path
	 *
	 * @var string
	 */
	protected $plugin_file;

	/**
	 * Flag for unmet requirements
	 *
	 * @var bool
	 */
	protected $requirements_unmet;

	/**
	 * Components
	 *
	 * @var array
	 */
	protected $components = [];

	/**
	 * Class constructor
	 *
	 * @since 2.2.0
	 * @param string $plugin_file plugin main file full path.
	 */
	public function __construct( $plugin_file ) {
		$this->plugin_file = $plugin_file;
	}

	/**
	 * Loads needed files
	 *
	 * @since  2.2.0
	 * @return void
	 */
	public function init() {

		// Plugin has been already initialized.
		if ( did_action( 'notification/signature/init' ) || $this->requirements_unmet ) {
			return;
		}

		// Requirements check.
		$requirements = new Requirements( __( 'Notification : Signature', 'notification-signature' ), [
			'php'          => '7.0',
			'wp'           => '5.3',
			'notification' => '7.0.0',
		] );

		$requirements->register_checker( __NAMESPACE__ . '\\Requirements\\BasePlugin' );

		if ( ! $requirements->satisfied() ) {
			$requirements->print_notice();
			$this->requirements_unmet = true;
			return;
		}

		$this->filesystems();
		$this->singletons();
		$this->actions();

		do_action( 'notification/signature/init' );

	}

	/**
	 * Registers all the hooks with DocHooks
	 *
	 * @since  2.2.0
	 * @return void
	 */
	public function register_hooks() {

		$this->add_hooks( $this );

		foreach ( $this->components as $component ) {
			if ( is_object( $component ) ) {
				$this->add_hooks( $component );
			}
		}

	}

	/**
	 * Sets up the plugin filesystems
	 *
	 * @since  2.2.0
	 * @return void
	 */
	public function filesystems() {

		$root = new Filesystem( dirname( $this->plugin_file ) );

		$this->filesystems = [
			'root'     => $root,
			'includes' => new Filesystem( $root->path( 'src/includes' ) ),
		];

	}

	/**
	 * Gets filesystem
	 *
	 * @since  2.2.0
	 * @param  string $name Filesystem name.
	 * @return Filesystem|null
	 */
	public function get_filesystem( $name ) {
		return $this->filesystems[ $name ];
	}

	/**
	 * Adds runtime component
	 *
	 * @since  2.2.0
	 * @throws \Exception When component is already registered.
	 * @param  string $name      Component name.
	 * @param  mixed  $component Component.
	 * @return $this
	 */
	public function add_component( $name, $component ) {

		if ( isset( $this->components[ $name ] ) ) {
			throw new \Exception( sprintf( 'Component %s is already added.', $name ) );
		}

		$this->components[ $name ] = $component;

		return $this;

	}

	/**
	 * Gets runtime component
	 *
	 * @since  2.2.0
	 * @param  string $name Component name.
	 * @return mixed        Component or null
	 */
	public function component( $name ) {
		return isset( $this->components[ $name ] ) ? $this->components[ $name ] : null;
	}

	/**
	 * Gets runtime components
	 *
	 * @since  2.2.0
	 * @return array
	 */
	public function components() {
		return $this->components;
	}

	/**
	 * Creates needed classes
	 * Singletons are used for a sake of performance
	 *
	 * @since  2.2.0
	 * @return void
	 */
	public function singletons() {

		$this->add_component( 'admin_settings', new Admin\Settings() );

		$this->add_component( 'core_signature', new Core\Signature() );

	}

	/**
	 * All WordPress actions this plugin utilizes
	 *
	 * @since  2.2.0
	 * @return void
	 */
	public function actions() {

		$this->register_hooks();

		notification_register_settings( [ $this->component( 'admin_settings' ), 'register_carrier_settings' ], 30 );

		// DocHooks compatibility.
		if ( ! DocHooksHelper::is_enabled() && $this->get_filesystem( 'includes' )->exists( 'hooks.php' ) ) {
			include_once $this->get_filesystem( 'includes' )->path( 'hooks.php' );
		}

	}

}
