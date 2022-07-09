<?php

/**
 * Groups KB CORE code
 *
 * @copyright   Copyright (C) 2018, Echo Plugins
 *
 */
class WIDG_KB_Core {

	const DEFAULT_KB_ID = 1;
	const WIDG_KB_CONFIG_PREFIX =  'epkb_config_';
	const WIDG_KB_DEBUG = 'epkb_debug';
	const WIDG_KB_KNOWLEDGE_BASE = 'Echo_Knowledge_Base';
	const WIDG_KB_POST_TYPE_PREFIX = 'epkb_post_type_';  // changing this requires db update

	// classes
	const WIDG_KB_MM_LINKS = 'epkb-mm-links';

	// plugin pages links
	const WIDG_KB_CONFIGURATION_PAGE = 'epkb-kb-configuration';
	const WIDG_KB_CONFIGURATION_URL = 'edit.php?post_type=epkb_post_type_1&page=epkb-kb-configuration';
	const WIDG_KB_ADD_ONS_PAGE = 'epkb-add-ons';
	const WIDG_KB_LICENSE_FIELD = 'epkb_license_fields';

	// FILTERS
	const WIDG_KB_ADD_ON_LICENSE_MSG = 'epkb_add_on_license_message';
	const WIDG_KB_ARTICLE_PAGE_ADD_ON_LINKS = 'epkb_kb_article_page_add_on_links';
	const WIDG_ALL_WIZARDS_CONFIGURATION_DEFAULTS = 'epkb_all_wizards_configuration_defaults';
	const WIDG_ALL_WIZARDS_GET_CURRENT_CONFIG = 'epkb_all_wizards_get_current_config';

	// ACTIONS
    const WIDG_KB_ARTICLE_PAGE_ADD_ON_MENU_CONTENT  = 'epkb_kb_article_page_add_on_menu_content';
    const WIDG_KB_ARTICLE_CONFIG_SIDEBAR_CONTENT    = 'eckb_article_page_sidebar_additional_output';
	const WIDG_UPDATE_KB_WIZARD_ARTICLE_COLOR_VIEW = 'epkb_wizard_update_color_article_view';
	const WIDG_UPDATE_KB_WIZARD_ORDER_VIEW = 'epkb_wizard_update_order_view';
	const WIDG_UPDATE_KB_WIZARD_PREVIEW = 'epkb_update_wizard_preview';
	const WIDG_FEATURES_WIZARD_ARTICLE_PAGE_FEATURES = 'epkb_features_wizard_after_article_page_features';

	// AJAX action events
    const WIDG_CHANGE_MAIN_PAGE_CONFIG_AJAX = 'epkb_change_main_page_config_ajax';
    const WIDG_CHANGE_ARTICLE_PAGE_CONFIG_AJAX = 'epkb_change_article_page_config_ajax';

	// AJAX - saving KB Configuration
    const WIDG_KB_CONFIG_GET_ADD_ON_INPUT           = 'epkb_kb_config_get_add_on_input';
    const WIDG_KB_CONFIG_SAVE_INPUT                 = 'epkb_kb_config_save_input_v2';
	const WIDG_KB_ADD_ON_CONFIG_SPECS               = 'epkb_add_on_config_specs';
    const WIDG_SAVE_KB_CONFIG_CHANGES = 'epkb_save_kb_config_changes';
	const WIDG_APPLY_WIZARD_CHANGES                 = 'epkb_apply_wizard_changes';
	const WIDG_APPLY_SETUP_WIZARD_CHANGES           = 'epkb_apply_setup_wizard_changes';


	// AJAX Editor
	const WIDG_UPDATE_KB_EDITOR = 'eckb_apply_editor_changes';

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
	 * Get KB Configuration or default
	 *
	 * @param string $kb_id
	 * @return array|WP_Error
	 *
	 */
	public static function get_kb_config_or_default( $kb_id ) {
		if ( function_exists ('epkb_get_instance' ) && isset(epkb_get_instance()->kb_config_obj) ) {
			return epkb_get_instance()->kb_config_obj->get_kb_config_or_default( $kb_id );
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

	/**
	 * Get KB Configuration
	 *
	 * @param string $label
	 * @return array|string with value or $default value if this settings not found
	 *
	 */
	public static function format_font_awesome_icon_name( $label ) {
		return self::get_result( 'EPKB_Icons', 'format_font_awesome_icon_name', array( $label ) );
	}

	/**
	 * Is article structure new v2 ?
	 * @param $kb_config
	 * @return bool
	 */
	public static function is_article_structure_v2( $kb_config ) {
		$result = self::get_param_result( 'EPKB_Articles_Setup', 'is_article_structure_v2', array($kb_config), true );
		return ! empty($result) && ( true == $result );
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
			WIDG_Logging::add_log("Cannot invoke class $class with method $method.");
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
		if ( in_array($class_name, array('EPKB_KB_Config_Elements', 'EPKB_HTML_Elements', 'EPKB_KB_Config_DB', 'EPKB_Input_Filter', 'AMGR_Access_Articles_Front', 'EPKB_Articles_DB')) ) {
			$class = new $class_name();
		}

		if ( ! is_callable( array($class, $method ) ) ) {
			WIDG_Logging::add_log("Cannot invoke class $class with method $method.");
			return $default;
		}

		return call_user_func_array( array( $class, $method ), $params );
	}
}
