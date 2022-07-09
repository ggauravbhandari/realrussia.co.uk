<?php

/**
 * Groups KB CORE code
 *
 * @copyright   Copyright (C) 2018, Echo Plugins
 *
 */
class ASEA_KB_Core {

	const DEFAULT_KB_ID = 1;
	const ASEA_KB_CONFIG_PREFIX =  'epkb_config_';
	const ASEA_KB_DEBUG = 'epkb_debug';
	const ASEA_KB_POST_TYPE_PREFIX = 'epkb_post_type_';  // changing this requires db update
	const ASEA_ARTICLES_SEQUENCE = 'epkb_articles_sequence';
	const ASEA_DEBUG = '_epkb_advanced_search_debug_activated';

	// plugin pages links
	const ASEA_KB_CONFIGURATION_PAGE = 'epkb-kb-configuration';
	const ASEA_KB_CONFIGURATION_URL = 'edit.php?post_type=epkb_post_type_1&page=epkb-kb-configuration';
	const ASEA_KB_ADD_ONS_PAGE = 'epkb-add-ons';
	const ASEA_KB_ANALYTICS_PAGE = 'epkb-plugin-analytics';
	const ASEA_KB_LICENSE_FIELD = 'epkb_license_fields';
	const ASEA_KB_DEBUG_PAGE = 'epkb-add-ons';

	// FILTERS
	const ASEA_KB_ADD_ON_LICENSE_MSG = 'epkb_add_on_license_message';
	const ASEA_ADVANCED_SEARCH_BOX_STYLE_NAMES = 'epkb_advanced_search_box_style_names';
	const ASEA_ADVANCED_SEARCH_STYLE_SET = 'epkb_kb_advanced_search_style_set';
	const ASEA_ALL_WIZARDS_CONFIGURATION_DEFAULTS = 'epkb_all_wizards_configuration_defaults';
	const ASEA_ALL_WIZARDS_GET_CURRENT_CONFIG = 'epkb_all_wizards_get_current_config';

	// ACTIONS
	const ASEA_THEME_WIZARD_MAIN_PAGE_COLORS = 'epkb_theme_wizard_before_main_page_colors';
	const ASEA_THEME_WIZARD_ARTICLE_PAGE_COLORS = 'epkb_theme_wizard_before_article_page_colors';
	const ASEA_THEME_WIZARD_GET_COLOR_PRESETS = 'epkb_theme_wizard_get_color_presets';
	const ASEA_TEXT_WIZARD_MAIN_PAGE_TEXTS = 'epkb_text_wizard_before_main_page_texts';
	const ASEA_TEXT_WIZARD_ARTICLE_PAGE_TEXTS = 'epkb_text_wizard_before_article_page_texts';
	const ASEA_UPDATE_KB_WIZARD_ARTICLE_COLOR_VIEW = 'epkb_wizard_update_color_article_view';
	const ASEA_UPDATE_KB_WIZARD_ORDER_VIEW = 'epkb_wizard_update_order_view';
	const ASEA_UPDATE_KB_WIZARD_PREVIEW = 'epkb_update_wizard_preview';

	// AJAX - changing KB Configuration
    const ASEA_CHANGE_MAIN_PAGE_CONFIG_AJAX = 'epkb_change_main_page_config_ajax';
	const ASEA_CHANGE_ARTICLE_PAGE_CONFIG_AJAX = 'epkb_change_article_page_config_ajax';
	const ASEA_CHANGE_ONE_PARAM_AJAX = 'epkb_change_one_config_param_ajax';

	// AJAX - saving KB Configuration
	const ASEA_KB_CONFIG_GET_ADD_ON_INPUT           = 'epkb_kb_config_get_add_on_input';
	const ASEA_KB_CONFIG_SAVE_INPUT                 = 'epkb_kb_config_save_input_v2';
	const ASEA_KB_ADD_ON_CONFIG_SPECS               = 'epkb_add_on_config_specs';
	const ASEA_APPLY_SETUP_WIZARD_CHANGES           = 'epkb_apply_setup_wizard_changes';
	const ASEA_SAVE_KB_CONFIG_CHANGES               = 'epkb_save_kb_config_changes';
	const ASEA_CHANGE_ARTICLE_CATEGORY_SEQUENCE     = 'epkb_change_article_category_sequence';
	const ASEA_APPLY_WIZARD_CHANGES                 = 'epkb_apply_wizard_changes';
	const ASEA_KB_TEXT_FIELDS_LIST                  = 'epkb_kb_text_fields_list';
	const ASEA_KB_THEME_FIELDS_LIST                 = 'epkb_kb_theme_fields_list';
	
	/**
	 * Get value from KB Configuration
	 *
	 * @param string $kb_id
	 * @param $setting_name
	 * @param string $default
	 *
	 * @return array|string with value or $default value if this settings not found
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


	public static function apply_article_language_filter( $value ) {
		return self::get_param_result( 'EPKB_WPML', 'apply_article_language_filter', array( $value ), '' );
	}

	/**
	 * Get Elegant Layouts Configuration
	 *
	 * @param string $kb_id
	 * @return array|WP_Error with value or $default value if this settings not found
	 *
	 */
	public static function get_el_ay_config( $kb_id ) {
		if ( ! defined( 'EL'.'AY_PLUGIN_NAME' ) ) {
			return array();
		}

		if ( function_exists ('elay_get_instance' ) && isset(elay_get_instance()->kb_config_obj) ) {
			return elay_get_instance()->kb_config_obj->get_kb_config( $kb_id );
		}
		return new WP_Error('DB200', 'Failed to retrieve Elegant Layout Configuration');
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
	 * Remove KB Articles that the current user does not have access to.
	 * @param $value
	 * @return mixed
	 */
	public static function foundPosts( $value ) {
		return self::get_param_result( 'AMGR_Access_Articles_Front', 'foundPosts', array( $value ), false );
	}

	/**
	 * Get categories that the current user has access to.
	 * @param $terms
	 * @return mixed
	 */
	public static function filter_user_categories( $terms ) {
		return self::get_param_result( 'AMGR_Access_Utilities', 'filter_user_categories', array( $terms ), array() );
	}

	/**
	 * Get KB Configuration
	 *
	 * @param string $theme
	 * @return string
	 *
	 */
	public static function get_theme_data( $theme ) {
		return self::get_param_result( 'EPKB_KB_Wizard_Themes', 'get_theme_data', array( $theme ), '' );
	}

	public static function get_font_data() {
		
		if ( class_exists( 'Echo_Knowledge_Base' )
				&& version_compare(Echo_Knowledge_Base::$version, '7.7.0', '<=' )
				&& class_exists( 'EPKB_Editor_Utilities' )
				&& method_exists( 'EPKB_Editor_Utilities', 'get_google_fonts_data' ) ) {
			/** @noinspection PhpUndefinedMethodInspection */
			return EPKB_Editor_Utilities::get_google_fonts_data();
		}
		
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
			ASEA_Logging::add_log("Cannot invoke class $class with method $method.");
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
			ASEA_Logging::add_log("Cannot invoke class $class with method $method.");
			return $default;
		}

		return call_user_func_array( array( $class, $method ), $params );
	}
}
