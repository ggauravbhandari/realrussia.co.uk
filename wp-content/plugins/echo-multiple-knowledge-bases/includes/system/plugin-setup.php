<?php

/**
 * Activate the plugin
 *
 * @copyright   Copyright (C) 2018, Echo Plugins
*/

/**
 * Activate this plugin i.e. setup tables, data etc.
 * NOT invoked on plugin updates
 *
 * @param bool $network_wide - If the plugin is being network-activated
 */
function emkb_activate_plugin( $network_wide=false ) {
	global $wpdb;

	if ( is_multisite() && $network_wide ) {
		foreach ( $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs LIMIT 100" ) as $blog_id ) {
			switch_to_blog( $blog_id );
			emkb_activate_plugin_do();
			restore_current_blog();
		}
	} else {
		emkb_activate_plugin_do();
	}
}

function emkb_activate_plugin_do() {

	require_once 'class-emkb-autoloader.php';

	// true if the plugin was activated for the first time since installation
	$plugin_version = get_option( 'emkb_version' );
	if ( empty($plugin_version) ) {

		set_transient( '_emkb_plugin_installed', true, 3600 );
		EMKB_Utilities::save_wp_option( 'emkb_version', Echo_Multiple_Knowledge_Bases::$version, true );
	}

	set_transient( '_emkb_plugin_activated', true, 3600 );

	// TODO remove in the future
	EMKB_Utilities::save_wp_option( 'ep'.'kb_version_first', '5.2.0', true );

	// Clear permalinks
	flush_rewrite_rules( false );
}
register_activation_hook( Echo_Multiple_Knowledge_Bases::$plugin_file, 'emkb_activate_plugin' );

/**
 * User deactivates this plugin so refresh the permalinks
 */
function emkb_deactivation() {

	// Clear the permalinks to remove our post type's rules
	flush_rewrite_rules( false );

}
register_deactivation_hook( Echo_Multiple_Knowledge_Bases::$plugin_file, 'emkb_deactivation' );
