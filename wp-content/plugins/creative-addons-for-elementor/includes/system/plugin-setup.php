<?php
/**
 * Activate the plugin
*/

/**
 * Activate this plugin i.e. setup tables, data etc.
 * NOT invoked on plugin updates
 *
 * @param bool $network_wide - If the plugin is being network-activated
 */

function crel_activate_plugin( $network_wide=false ) {
	
	global $wpdb;

	if ( is_multisite() && $network_wide ) {
		foreach ( $wpdb->get_col( "SELECT blog_id FROM $wpdb->blogs LIMIT 100" ) as $blog_id ) {
			switch_to_blog( $blog_id );
			
			crel_activate_plugin_do();
			restore_current_blog();
		}
	} else {
		crel_activate_plugin_do();
	}
}
register_activation_hook( CREATIVE_ADDONS__FILE__, 'crel_activate_plugin' );

function crel_activate_plugin_do() {
	// true if the plugin was activated for the first time since installation
	$plugin_version = get_option( 'crel_version' );

	if ( empty($plugin_version) ) {
		set_transient( '_crel_plugin_installed', true, WEEK_IN_SECONDS );
		update_option( 'crel_version', CREATIVE_ADDONS_VERSION, true );
		update_option( 'crel_version_first', CREATIVE_ADDONS_VERSION, true );
	}

	set_transient( '_crel_plugin_activated', true, 3600 );
}

/**
 * User deactivates this plugin so refresh the permalinks
 */
function crel_deactivation() {
	
}
register_deactivation_hook( CREATIVE_ADDONS__FILE__, 'crel_deactivation' );
