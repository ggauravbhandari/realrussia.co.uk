<?php

/**
 * Groups KB CORE code
 *
 * @copyright   Copyright (C) 2018, Echo Plugins
 *
 */
class EMKB_KB_Core {

	const DEFAULT_KB_ID = 1;

	const EMKB_KB_DEBUG = 'epkb_debug';
	const EMKB_KB_KNOWLEDGE_BASE = 'Echo_Knowledge_Base';
	const EMKB_KB_POST_TYPE_PREFIX = 'epkb_post_type_';  // changing this requires db update

	// plugin pages
	const EMKB_KB_CONFIGURATION_PAGE = 'epkb-kb-configuration';
	const EMKB_KB_CONFIGURATION_URL = 'edit.php?post_type=epkb_post_type_1&page=epkb-kb-configuration';
	const EMKB_KB_LICENSES_URL = 'edit.php?post_type=epkb_post_type_1&page=epkb-add-ons&epkb-tab=licenses';
	const EMKB_KB_ADD_ONS_PAGE = 'epkb-add-ons';
	const EMKB_KB_LICENSE_FIELD = 'epkb_license_fields';

	// FILTERS
	const EMKB_KB_ADD_ON_LICENSE_MSG = 'epkb_add_on_license_message';

    // actions
    const EMKB_LOAD_ADMIN_PLUGIN_PAGES_RESOURCES = 'epkb_load_admin_plugin_pages_resources';
	const EMKB_KB_FLUSH_REWRITE_RULES = 'epkb_flush_rewrite_rules';

	// KB states
	const PUBLISHED = 'published';
	const ARCHIVED = 'archived';

	// name of KB shortcode
	const KB_MAIN_PAGE_SHORTCODE_NAME = 'epkb-knowledge-base'; // changing this requires db update


	/**********************************************************************************************************
	 *
	 *   EPKB_KB_Handler
	 *
	 **********************************************************************************************************/

	/**
	 * @param $new_kb_id
	 * @param $new_kb_main_page_title
	 * @param $new_kb_main_page_slug
	 * @return array|WP_Error the new KB configuration or WP_Error
	 */
	public static function add_new_knowledge_base( $new_kb_id, $new_kb_main_page_title, $new_kb_main_page_slug ) {
		return self::get_param_result( 'EPKB_KB_Handler', 'add_new_knowledge_base', array($new_kb_id, $new_kb_main_page_title, $new_kb_main_page_slug), new WP_Error("Internal Error (xy)") );
	}


	/**********************************************************************************************************
	 *
	 *   EPKB_KB_Config_DB
	 *
	 **********************************************************************************************************/

	/**
	 * @return mixed array containing all existing KB IDs
	 */
	public static function get_kb_ids() {
		return self::get_result( 'EPKB_KB_Config_DB', 'get_kb_ids', array(self::DEFAULT_KB_ID) );
	}

	/**
	 * @param $kb_id
	 * @return array|WP_Error return current KB configuration; if not found return defaults
	 */
	public static function get_kb_config( $kb_id ) {
		return self::get_param_result( 'EPKB_KB_Config_DB', 'get_kb_config', array($kb_id), new WP_Error("Internal Error (xy)") );
	}

	/**
	 * @param $kb_id
	 * @param array $config
	 * @return array|WP_Error configuration that was updated
	 */
	public static function update_kb_configuration( $kb_id, array $config ) {
		return self::get_param_result( 'EPKB_KB_Config_DB', 'update_kb_configuration', array($kb_id, $config), new WP_Error("Internal Error (x3)") );
	}


	/**********************************************************************************************************
	 *
	 *                                       CORE CALLING FUNCTIONS
	 *
	 **********************************************************************************************************/

	/**
	 * Safely invoke function.
	 *
	 * @param $class_name
	 * @param $method
	 * @param $default
	 * @return mixed
	 */
	private static function get_result( $class_name, $method, $default ) {

		// instantiate certain classes
		$class = $class_name;
		if ( in_array($class_name, array('EPKB_KB_Config_Elements', 'EPKB_HTML_Elements', 'EPKB_KB_Config_DB', 'EPKB_Input_Filter')) ) {
			$class = new $class_name();
		}

		if ( ! is_callable( array($class, $method) ) ) {
			EMKB_Logging::add_log("Cannot invoke class $class with method $method.");
			return $default;
		}

		return call_user_func( array( $class, $method ) );
	}

	/**
	 * Safely invoke function with parameters.
	 *
	 * @param $class_name
	 * @param $method
	 * @param $params
	 * @param $default
	 * @return mixed
	 */
	private static function get_param_result( $class_name, $method, $params, $default ) {

		// instantiate certain classes
		$class = $class_name;
		if ( in_array($class_name, array('EPKB_KB_Config_Elements', 'EPKB_HTML_Elements', 'EPKB_KB_Config_DB', 'EPKB_Input_Filter')) ) {
			$class = new $class_name();
		}

		if ( ! is_callable( array($class, $method ) ) ) {
			EMKB_Logging::add_log("Cannot invoke class $class with method $method.");
			return $default;
		}

		return call_user_func_array( array( $class, $method ), $params );
	}
}
