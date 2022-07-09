<?php
namespace Creative_Addons;

use Creative_Addons\includes\admin\Settings_DB;
use Creative_Addons\Includes\System\Upgrades;
use Creative_Addons\Includes\Utilities;
use Creative_Addons\Includes\Controls_Manager;
use Creative_Addons\Includes\Widgets_Manager;
use Creative_Addons\Includes\Assets_Manager;
use Creative_Addons\Includes\Cache_Manager;
use Creative_Addons\includes\admin\Admin_Menus;
use Creative_Addons\Includes\Kb\KB_Search_Cntrl;
use Creative_Addons\Includes\Admin\Admin_Handlers;
use Creative_Addons\Includes\System\Deactivate_Feedback;

if ( ! defined( 'ABSPATH' ) ) exit;


/**
 * Main class to load the plugin.
 * Singleton
 */
final class Creative_Addons_for_Elementor {

	/* @var Creative_Addons_for_Elementor */
	private static $instance;

	/* @var Settings_DB */
	public $settings_obj;

	private function __construct() {
		spl_autoload_register( [ $this, 'autoload' ] );
	}

	/**
	 * Create a new instance
	 * @static
	 * @return Creative_Addons_for_Elementor
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
			self::$instance->setup_plugin();
			// add_action( 'init', array( self::$instance, 'stop_heartbeat' ), 1 );
		}

		return self::$instance;
	}

	/**
	 * Setup plugin before it runs. Include functions and instantiate classes based on user action
	 */
	private function setup_plugin() {

		// add_action( 'elementor/init', [ $this, 'on_elementor_init' ] );
		// add_action( 'elementor_pro/init', [ $this, 'on_elementor_pro_init' ]  );

		require_once CREATIVE_ADDONS_DIR_PATH . 'includes/system/plugin-links.php';

		self::$instance->settings_obj = new Settings_DB();

		Controls_Manager::init();
		Widgets_Manager::init();
		Assets_Manager::init();
		Cache_Manager::init();

		new Upgrades();

		$action = Utilities::post( 'action' );

		// process action request if any
		if ( ! empty( $action ) ) {
			$this->handle_action_request( $action );
		}

		// handle AJAX front & back-end requests (no admin, no admin bar)
		if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
			$this->handle_ajax_requests( $action );
			return;
		}

		// ADMIN or CLI
		if ( is_admin() || ( defined( 'WP_CLI' ) && WP_CLI ) ) {    // || ( defined( 'REST_REQUEST' ) && REST_REQUEST )
			$this->setup_backend_classes();
			return;
		}

		// FRONT-END (no ajax, possibly admin bar)
	}

	/**
	 * Handle plugin actions here such as saving settings
	 * @param $action
	 */
	private function handle_action_request( $action ) {

		if ( empty( $action ) ) {
			return;
		}

		if ( $action == 'crel_download_debug_info' ) {
			new Admin_Handlers();
			return;
		}
	}

	/**
	 * Handle AJAX requests coming from front-end and back-end
	 * @param $action
	 */
	private function handle_ajax_requests( $action ) {

		if ( empty( $action ) ) {
			return;
		}

		// KB Search widget - user searches
		if ( $action == 'crel-search-kb' ) {
            new KB_Search_Cntrl();
			return;
		}

		// user saves widgets/presets ON/OFF option || Toggle Debug Info
		if ( in_array( $action, ['crel-save-widgets', 'crel_toggle_debug', 'crel-save-presets', 'crel-switch-to-globals'] ) ) {
			new Admin_Handlers();
			return;
		}

		if ( $action == 'crel_deactivate_feedback' ) {
			new Deactivate_Feedback();
			return;
		}
	}

	/**
	 * Setup up classes when on ADMIN pages
	 */
	private function setup_backend_classes() {
		global $pagenow;
		
		Admin_Menus::init();
		if ( ! empty($pagenow) && in_array( $pagenow, [ 'plugins.php', 'plugins-network.php' ] ) ) {
			new Deactivate_Feedback();
		}
	}

	// Don't allow this singleton to be cloned.
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, 'Invalid (#1)', '4.0' );
	}

	// Don't allow un-serializing of the class except when testing
	public function __wakeup() {
		if ( strpos($GLOBALS['argv'][0], 'phpunit') === false ) {
			_doing_it_wrong( __FUNCTION__, 'Invalid (#1)', '4.0' );
		}
	}

	/** When developing and debugging we don't need heartbeat */
	public function stop_heartbeat() {
		if ( defined( 'RUNTIME_ENVIRONMENT' ) && RUNTIME_ENVIRONMENT == 'ECHODEV' ) {
			wp_deregister_script( 'heartbeat' );
		}
	}

	// auto-load classes (taken from Elementor)
	public function autoload( $class ) {
		if ( 0 !== strpos( $class, __NAMESPACE__ ) ) {
			return;
		}

		$class_to_load = $class;
		if ( ! class_exists( $class_to_load ) ) {
			$filename = strtolower(
				preg_replace(
					[ '/^' . __NAMESPACE__ . '\\\/', '/([a-z])([A-Z])/', '/_/', '/\\\/' ],
					[ '', '$1-$2', '-', DIRECTORY_SEPARATOR ],
					$class_to_load
				)
			);
			$filename = str_replace('-', '_', $filename);
			$filename = CREATIVE_ADDONS_DIR_PATH . $filename . '.php';

			if ( is_readable( $filename ) ) {
				include( $filename );
			}
		}
	}
}

/**
 * Returns the single instance of this class
 * @return Creative_Addons_for_Elementor - this class instance
 */
function crel_get_instance() {
	return Creative_Addons_for_Elementor::instance();
}

Creative_Addons_for_Elementor::instance();
