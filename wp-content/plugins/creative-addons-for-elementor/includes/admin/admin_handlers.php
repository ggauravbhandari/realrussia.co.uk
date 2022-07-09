<?php
namespace Creative_Addons\Includes\Admin;

use Creative_Addons\Includes\Utilities;
use Creative_Addons\Includes\Utilities_Plugin;
use Creative_Addons\Includes\Widgets_Manager;

defined( 'ABSPATH' ) || exit();

/**
 * Handle ajax requests for Admin Settings
 */
class Admin_Handlers {

	const CREL_DEBUG = 'crel_debug';

	public function __construct() {
		add_action( 'wp_ajax_crel-save-widgets', array( $this, 'save_widgets' ) );
		add_action( 'wp_ajax_nopriv_crel-switch-to-globals', array( $this, 'user_not_logged_in' ) );
		add_action( 'wp_ajax_crel-switch-to-globals', array( $this, 'switch_to_globals' ) );
		add_action( 'wp_ajax_nopriv_crel-save-widgets', array( $this, 'user_not_logged_in' ) );
		add_action( 'wp_ajax_crel-save-presets', array( $this, 'save_presets' ) );
		add_action( 'wp_ajax_nopriv_crel-save-presets', array( $this, 'user_not_logged_in' ) );
		add_action( 'admin_init', array( $this, 'download_debug_info' ) );
		add_action( 'wp_ajax_crel_toggle_debug', array( $this, 'toggle_debug' ) );
		add_action( 'wp_ajax_nopriv_crel_toggle_debug', array( $this, 'user_not_logged_in' ) );
	}
	
	public function save_widgets() {
		
		// verify that request is authentic
		if ( empty( $_REQUEST['crel_settings_nonce'] ) || ! wp_verify_nonce( $_REQUEST['crel_settings_nonce'], 'crel_settings_nonce' ) ) {
			wp_die( json_encode( array( 'status' => 'error', 'message' => __( 'You do not have permission to edit these settings', 'creative-addons-for-elementor' ) ) ) );
		}
		
		$inactive_widgets = Utilities::post('inactive_widgets', [] );
		Widgets_Manager::set_inactive_widgets( $inactive_widgets );
		
		wp_die( json_encode( array( 'status' => 'success', 'message' => __( 'Widgets were saved', 'creative-addons-for-elementor' ) ) ) );
	}

	/**
	 * User with old widgets can switch to use Elementor global values for colors and fonts.
	 */
	public function switch_to_globals() {
		
		// verify that request is authentic
		if ( empty( $_REQUEST['crel_settings_nonce'] ) || ! wp_verify_nonce( $_REQUEST['crel_settings_nonce'], 'crel_settings_nonce' ) ) {
			wp_die( json_encode( array( 'status' => 'error', 'message' => __( 'You do not have permission to make a change', 'creative-addons-for-elementor' ) ) ) );
		}

		$switch_to_globals = Utilities::post( 'switch_to_globals' );
		if ( $switch_to_globals == '' ) {
			wp_die( json_encode( array( 'status' => 'error', 'message' => __( 'Please reload the page', 'creative-addons-for-elementor' ) ) ) );
		}

		// user wants to switch to globals or not
		if ( $switch_to_globals == 1 ) {
			update_option( 'crel_version_first', '1.2.0', true );
		} else {
			update_option( 'crel_version_first', '1.1.0', true );
		}

		wp_die( json_encode( array( 'status' => 'success', 'message' => __( 'Switch to globals completed. Please update your pages as required.', 'creative-addons-for-elementor' ) ) ) );
	}
	
	public function save_presets() {
		
		// verify that request is authentic
		if ( empty( $_REQUEST['crel_settings_nonce'] ) || ! wp_verify_nonce( $_REQUEST['crel_settings_nonce'], 'crel_settings_nonce' ) ) {
			wp_die( json_encode( array( 'status' => 'error', 'message' => __( 'You do not have permission to edit these settings', 'creative-addons-for-elementor' ) ) ) );
		}

		$inactive_presets = empty( $_POST['inactive_presets'] ) ? [] : $_POST['inactive_presets'];
		// TODO how can we santize this $inactive_presets = Utilities::post('inactive_presets', [] );
		Utilities_Plugin::set_users_inactive_presets( $inactive_presets );
		
		wp_die( json_encode( array( 'status' => 'success', 'message' => __( 'Presets were saved', 'creative-addons-for-elementor' ) ) ) );
	}

	/**
	 * Triggered when user clicks to toggle debug.
	 */
	public function toggle_debug() {

		// verify that request is authentic
		if ( ! isset( $_REQUEST['_wpnonce_crel_toggle_debug'] ) || !wp_verify_nonce( $_REQUEST['_wpnonce_crel_toggle_debug'], '_wpnonce_crel_toggle_debug' ) ) {
			Utilities::ajax_show_error_die( __( 'Refresh your page', 'creative-addons-for-elementor' ) );
		}

		// ensure user has correct permissions
		if ( ! current_user_can( 'manage_options' ) ) {
			Utilities::ajax_show_error_die( __( 'You do not have permission.', 'creative-addons-for-elementor' ) );
		}

		$is_debug_on = Utilities::get_wp_option( Admin_Handlers::CREL_DEBUG, false );

		$is_debug_on = empty($is_debug_on) ? 1 : 0;

		Utilities::save_wp_option( Admin_Handlers::CREL_DEBUG, $is_debug_on, true );

		// we are done here
		Utilities::ajax_show_info_die( __( 'Debug is now ' . ( $is_debug_on ? 'on' : 'off' ), 'creative-addons-for-elementor' ) );
	}

	/**
	 * Generates a System Info download file
	 */
	public function download_debug_info() {

		if ( Utilities::post('action') != 'crel_download_debug_info' ) {
			return;
		}

		// verify that the request is authentic
		if ( ! isset( $_REQUEST['_wpnonce_crel_download_debug_info'] ) || ! wp_verify_nonce( $_REQUEST['_wpnonce_crel_download_debug_info'], '_wpnonce_crel_download_debug_info' ) ) {
			Utilities::ajax_show_error_die(__( 'Debug not loaded. First refresh your page', 'creative-addons-for-elementor' ));
		}

		// ensure user has correct permissions - only admin can download info
		if ( ! current_user_can( 'manage_options' ) ) {
			Utilities::ajax_show_error_die(__( 'You do not have permission to access this page', 'creative-addons-for-elementor' ));
		}

		Utilities::save_wp_option( Admin_Handlers::CREL_DEBUG, false, true);

		nocache_headers();

		header( 'Content-Type: text/plain' );
		header( 'Content-Disposition: attachment; filename="echo-crel-debug-info.txt"' );

		$output = Admin_Pages::display_debug_data();
		echo wp_strip_all_tags( $output );

		die();
	}

	public function user_not_logged_in() {
		Utilities::ajax_show_error_die( '<p>' . __( 'You are not logged in. Refresh your page and log in.', 'creative-addons-for-elementor' ) . '</p>', __( 'Cannot save your changes', 'creative-addons-for-elementor' ) );
	}
}