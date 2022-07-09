<?php
namespace Creative_Addons\Includes\System;

use Creative_Addons\Includes\Utilities;
use Creative_Addons\Includes\System\Logging;

defined( 'ABSPATH' ) || exit();

/**
 * Check if plugin upgrade to a new version requires any actions like database upgrade
 *
 * @copyright   Copyright (C) 2020, Echo Plugins
 */
class Upgrades {

	public function __construct() {
        // will run after plugin is updated but not always like front-end rendering
		add_action( 'admin_init', array( 'Creative_Addons\Includes\System\Upgrades', 'update_plugin_version' ) );
	}

    /**
     * If necessary run plugin database updates
     */
    public static function update_plugin_version() {

        $last_version = Utilities::get_wp_option( 'crel_version', null );
        if ( empty($last_version) ) {
	        // TODO update_option( 'crel_version', CREATIVE_ADDONS_VERSION, true );
	        return;
        }

        // if the plugin is up-to-date then return
        if ( version_compare( $last_version, CREATIVE_ADDONS_VERSION, '>=' ) ) {
            return;
        }

		// since we need to upgrade this plugin, on the Overview Page show an upgrade message
	    Utilities::save_wp_option( 'crel_show_upgrade_message', true, true );

        // upgrade the plugin
        // self::invoke_upgrades( $last_version );

        // update the plugin version
        $result = Utilities::save_wp_option( 'crel_version', CREATIVE_ADDONS_VERSION, true );
        if ( is_wp_error( $result ) ) {
	        Logging::add_log( 'Could not update plugin version', $result );
            return;
        }
    }

    /**
     * Invoke each database update as necessary.
     *
     * @param $last_version
     */
    private static function invoke_upgrades( $last_version ) {
    }
}
