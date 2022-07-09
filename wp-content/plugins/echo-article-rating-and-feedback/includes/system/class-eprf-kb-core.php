<?php

/**
 * Groups KB CORE code
 *
 * @copyright   Copyright (C) 2018, Echo Plugins
 *
 */
class EPRF_KB_Core {

	const DEFAULT_KB_ID = 1;
	const EPRF_KB_CONFIG_PREFIX =  'epkb_config_';
	const EPRF_KB_DEBUG = 'epkb_debug';
	const EPRF_KB_KNOWLEDGE_BASE = 'Echo_Knowledge_Base';
	const EPRF_KB_POST_TYPE_PREFIX = 'epkb_post_type_';  // changing this requires db update

	// plugin pages links
	const EPRF_KB_CONFIGURATION_PAGE = 'epkb-kb-configuration';
	const EPRF_KB_CONFIGURATION_URL = 'edit.php?post_type=epkb_post_type_1&page=epkb-kb-configuration';
	const EPRF_KB_ADD_ONS_PAGE = 'epkb-add-ons';
	const EPRF_KB_LICENSE_FIELD = 'epkb_license_fields';

	// FILTERS
	const EPRF_KB_ADD_ON_LICENSE_MSG = 'epkb_add_on_license_message';
	const EPRF_KB_ANALYTICS_PAGE = 'epkb-plugin-analytics';

	// ACTIONS
	const EPRF_KB_ARTICLE_PAGE_ADD_ON_LINKS = 'epkb_kb_article_page_add_on_links';
	const EPRF_KB_ARTICLE_PAGE_ADD_ON_MENU_CONTENT  = 'epkb_kb_article_page_add_on_menu_content';
	const EPRF_KB_ARTICLE_CONFIG_SIDEBAR_CONTENT    = 'eckb_article_page_sidebar_additional_output';
	const EPRF_KB_CONFIG_GET_ADD_ON_INPUT = 'epkb_kb_config_get_add_on_input';
	const EPRF_KB_CONFIG_SAVE_INPUT = 'epkb_kb_config_save_input_v2';
	const EPRF_ALL_WIZARDS_CONFIGURATION_DEFAULTS = 'epkb_all_wizards_configuration_defaults';
	const EPRF_ALL_WIZARDS_GET_CURRENT_CONFIG = 'epkb_all_wizards_get_current_config';
	const EPRF_THEME_WIZARD_ARTICLE_PAGE_COLORS = 'epkb_theme_wizard_after_article_page_colors';
	const EPRF_TEXT_WIZARD_ARTICLE_PAGE_TEXTS = 'epkb_text_wizard_after_article_page_texts';
	const EPRF_FEATURES_WIZARD_ARTICLE_PAGE_FEATURES = 'epkb_features_wizard_after_article_page_features';

	// AJAX action events
	const EPRF_CHANGE_MAIN_PAGE_CONFIG_AJAX = 'epkb_change_main_page_config_ajax';
	const EPRF_CHANGE_ARTICLE_PAGE_CONFIG_AJAX = 'epkb_change_article_page_config_ajax';
	const EPRF_CHANGE_ONE_PARAM_AJAX = 'epkb_change_one_config_param_ajax';
	const EPRF_CHANGE_ARTICLE_CATEGORY_SEQUENCE = 'epkb_change_article_category_sequence';
	const EPRF_KB_ADD_ON_CONFIG_SPECS = 'epkb_add_on_config_specs';
	const EPRF_SAVE_KB_CONFIG_CHANGES = 'epkb_save_kb_config_changes';
	const EPRF_APPLY_WIZARD_CHANGES                = 'epkb_apply_wizard_changes';
	const EPRF_UPDATE_KB_WIZARD_ARTICLE_COLOR_VIEW = 'epkb_wizard_update_color_article_view';
	const EPRF_UPDATE_KB_WIZARD_ORDER_VIEW = 'epkb_wizard_update_order_view';
	const EPRF_UPDATE_KB_WIZARD_PREVIEW = 'epkb_update_wizard_preview';
	const EPRF_APPLY_SETUP_WIZARD_CHANGES = 'epkb_apply_setup_wizard_changes';


	// AJAX Editor
	const EPRF_UPDATE_KB_EDITOR = 'eckb_apply_editor_changes';

	/**
	 * Get value from KB Configuration
	 *
	 * @param string $kb_id
	 * @param $setting_name
	 * @param string $default
	 *
	 * @return string|array with value or $default value if this settings not found
	 */
	public static function get_value( $kb_id, $setting_name, $default='' ) {
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
		if ( function_exists( 'epkb_get_instance' ) && isset(epkb_get_instance()->kb_config_obj) ) {
			return epkb_get_instance()->kb_config_obj->get_kb_config( $kb_id );
		}
		return new WP_Error('DB200', 'Failed to retrieve KB Configuration');
	}

	/**
	 * Get KB Configuration
	 *
	 * @return array|WP_Error with value or $default value if this settings not found
	 *
	 */
	public static function get_kb_ids() {
		if ( function_exists('epkb_get_instance' ) && isset(epkb_get_instance()->kb_config_obj) ) {
			return epkb_get_instance()->kb_config_obj->get_kb_ids();
		}
		return new WP_Error('DB200', 'Failed to retrieve KB Configuration');
	}

	/**
	 * Get KB Configuration or default
	 *
	 * @param string $kb_id
	 * @return array|WP_Error with value or $default value if this settings not found
	 *
	 */
	public static function get_kb_config_or_default( $kb_id ) {
		if ( function_exists('epkb_get_instance' ) && isset(epkb_get_instance()->kb_config_obj) ) {
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
		if ( function_exists('epkb_get_instance') && isset(epkb_get_instance()->kb_config_obj) ) {
			return epkb_get_instance()->kb_config_obj->get_kb_configs( $skip_check );
		}
		return new WP_Error('DB200', 'Failed to retrieve KB Configuration');
	}

	public static function get_current_kb_id() {
		return self::get_result( 'EPKB_KB_Handler', 'get_current_kb_id', EPRF_KB_Config_DB::DEFAULT_KB_ID );
	}

	public static function get_font_data() {
		return class_exists('EPKB_Typography') ? EPKB_Typography::$font_data : [];
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
			EPRF_Logging::add_log("Cannot invoke class $class with method $method.");
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
		if ( in_array($class_name, array('EPKB_KB_Config_Elements', 'EPKB_HTML_Elements', 'EPKB_KB_Config_DB', 'EPKB_Input_Filter', 'AMGR_Access_Articles_Front')) ) {
			$class = new $class_name();
		}

		if ( ! is_callable( array($class, $method ) ) ) {
			EPRF_Logging::add_log("Cannot invoke class $class with method $method.");
			return $default;
		}

		return call_user_func_array( array( $class, $method ), $params );
	}
}
