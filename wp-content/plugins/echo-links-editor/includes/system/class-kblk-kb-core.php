<?php

/**
 * Groups KB CORE code
 *
 * @copyright   Copyright (C) 2018, Echo Plugins
 *
 */
class KBLK_KB_Core {

	const DEFAULT_KB_ID = 1;
	const KBLK_KB_CONFIG_PREFIX =  'epkb_config_';
	const KBLK_KB_DEBUG = 'epkb_debug';
	const KBLK_KB_KNOWLEDGE_BASE = 'Echo_Knowledge_Base';
	const KBLK_KB_POST_TYPE_PREFIX = 'epkb_post_type_';  // changing this requires db update
	const KBLK_ARTICLES_SEQUENCE = 'epkb_articles_sequence';

	// plugin pages links
	const KBLK_KB_CONFIGURATION_PAGE = 'epkb-kb-configuration';
	const KBLK_KB_CONFIGURATION_URL = 'edit.php?post_type=epkb_post_type_1&page=epkb-kb-configuration';
	const KBLK_KB_LICENSES_URL = 'edit.php?post_type=epkb_post_type_1&page=epkb-add-ons&epkb-tab=licenses';
	const KBLK_KB_ADD_ONS_PAGE = 'epkb-add-ons';
	const KBLK_KB_LICENSE_FIELD = 'epkb_license_fields';

	// FILTERS
	const KBLK_KB_REGISTER_KB_CONFIG_HOOKS = 'epkb_register_kb_config_hooks';
	const KBLK_KB_ADD_ON_LICENSE_MSG = 'epkb_add_on_license_message';
	const KBLK_KB_ARTICLE_PAGE_ADD_ON_LINKS = 'epkb_kb_article_page_add_on_links';
	const KBLK_KB_DEBUG_PAGE = 'epkb-add-ons';

	// ACTIONS
    const KBLK_KB_CONFIG_GET_ADD_ON_INPUT           = 'epkb_kb_config_get_add_on_input';
    const KBLK_KB_CONFIG_SAVE_INPUT                 = 'epkb_kb_config_save_input_v2';
    const KBLK_KB_ARTICLE_PAGE_ADD_ON_MENU_CONTENT  = 'epkb_kb_article_page_add_on_menu_content';
    const KBLK_KB_ARTICLE_CONFIG_SIDEBAR_CONTENT    = 'eckb_article_page_sidebar_additional_output';


	// AJAX action events
    const KBLK_CHANGE_MAIN_PAGE_CONFIG_AJAX = 'epkb_change_main_page_config_ajax';
    const KBLK_SAVE_KB_CONFIG_CHANGES = 'epkb_save_kb_config_changes';


	/**
	 * Get value from KB Configuration
	 *
	 * @param string $kb_id
	 * @param $setting_name
	 * @param string $default
	 *
	 * @return array|string with value or $default value if this settings not found
	 */
	public static function get_value( $kb_id, $setting_name, $default = '' ) {
		if ( function_exists ('epkb_get_instance' ) && isset(epkb_get_instance()->kb_config_obj) ) {
			return epkb_get_instance()->kb_config_obj->get_value( $setting_name, $kb_id, $default ); // TODO switch arguments
		}
		return $default;
	}

	/**
	 * Get KB Configuration
	 *
	 * @param string $kb_id
	 * @return array|WP_Error with value or $default value if this settings not found
	 *
	 */
	public static function get_kb_config( $kb_id ) {
		if ( function_exists ('epkb_get_instance' ) && isset(epkb_get_instance()->kb_config_obj) ) {
			return epkb_get_instance()->kb_config_obj->get_kb_config( $kb_id );
		}
		return new WP_Error('DB200', 'Failed to retrieve KB Configuration');
	}

	/**
	 * Get all KB Configuration
	 *
	 * @param boolean $skip_check
	 * @return array|string with value or $default value if this settings not found
	 *
	 */
	public static function get_kb_configs( $skip_check=false ) {
		if ( function_exists ('epkb_get_instance' ) && isset(epkb_get_instance()->kb_config_obj) ) {
			return epkb_get_instance()->kb_config_obj->get_kb_configs( $skip_check );
		}
		return new WP_Error('DB200', 'Failed to retrieve KB Configuration');
	}

	public static function apply_article_language_filter( $value ) {
		return self::get_param_result( 'EPKB_WPML', 'apply_article_language_filter', array( $value ), '' );
	}

	/**
	 * Remove KB Articles that the current user does not have access to.
	 * @param $value
	 * @return mixed
	 */
	public static function foundPosts( $value ) {
		return self::get_param_result( 'AMGR_Access_Articles_Front', 'foundPosts', array( $value ), false );
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
			KBLK_Logging::add_log("Cannot invoke class $class with method $method.");
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
			KBLK_Logging::add_log("Cannot invoke class $class with method $method.");
			return $default;
		}

		return call_user_func_array( array( $class, $method ), $params );
	}
}
