<?php

// Exit if accessed directly
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) exit;


/**
 * Uninstall this plugin
 *
 */

/** Delete plugin options */
delete_option( 'crel_version' );
delete_option( 'crel_version_first' );
delete_option( 'crel_error_log' );
delete_option( 'crel_long_notices' );
delete_option( 'crel_one_time_notices' );
delete_option( 'crel_show_upgrade_message' );
delete_transient( '_crel_plugin_activated' );