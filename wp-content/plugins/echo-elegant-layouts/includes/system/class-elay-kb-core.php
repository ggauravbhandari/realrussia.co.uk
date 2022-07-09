<?php

/**
 * Groups KB CORE code
 *
 * @copyright   Copyright (C) 2018, Echo Plugins
 *
 */
class ELAY_KB_Core {

	const DEFAULT_KB_ID = 1;
	const ELAY_KB_CONFIG_PREFIX =  'epkb_config_';
	const ELAY_KB_DEBUG = 'epkb_debug';
	const ELAY_KB_KNOWLEDGE_BASE = 'Echo_Knowledge_Base';
	const ELAY_KB_POST_TYPE_PREFIX = 'epkb_post_type_';  // changing this requires db update
	const ELAY_ARTICLES_SEQUENCE = 'epkb_articles_sequence';
	const ELAY_CATEGORIES_SEQUENCE = 'epkb_categories_sequence';
	const ELAY_CATEGORIES_ICONS = 'epkb_categories_icons_images';

	// plugin pages links
	const ELAY_KB_CONFIGURATION_PAGE = 'epkb-kb-configuration';
	const ELAY_KB_CONFIGURATION_URL = 'edit.php?post_type=epkb_post_type_1&page=epkb-kb-configuration';
	const ELAY_KB_ADD_ONS_PAGE = 'epkb-add-ons';
	const ELAY_KB_LICENSE_FIELD = 'epkb_license_fields';
	const ELAY_KB_DEBUG_PAGE = 'epkb-add-ons';

	// FILTERS
	const ELAY_KB_ARTICLE_PAGE_LAYOUT_OUTPUT = 'epkb_article_page_layout_output';
	const ELAY_KB_SIDEBAR_LAYOUT_OUTPUT = 'epkb_sidebar_layout_output';
	const ELAY_KB_GRID_LAYOUT_OUTPUT = 'epkb_grid_layout_output';
	const ELAY_KB_LAYOUT_NAMES = 'epkb_layout_names';
	const ELAY_KB_ARTICLE_PAGE_LAYOUT_NAMES = 'epkb_article_page_layout_names';
	const ELAY_KB_LAYOUT_MAPPING = 'epkb_layout_mapping';
	const ELAY_KB_MAX_LAYOUT_LEVEL = 'epkb_max_layout_level';
	const ELAY_KB_LAYOUT_INFO_MESSAGE = 'epkb_layout_info_message';
	const ELAY_KB_ADD_ON_LICENSE_MSG = 'epkb_add_on_license_message';
	const ELAY_ALL_WIZARDS_CONFIGURATION_DEFAULTS = 'epkb_all_wizards_configuration_defaults';
	const ELAY_ALL_WIZARDS_GET_CURRENT_CONFIG = 'epkb_all_wizards_get_current_config';
	const ELAY_THEME_WIZARD_GET_COLOR_PRESETS = 'epkb_theme_wizard_get_color_presets';

	// ACTIONS
	const ELAY_KB_CONFIG_GET_ADD_ON_INPUT = 'epkb_kb_config_get_add_on_input';
	const ELAY_KB_CONFIG_SAVE_INPUT = 'epkb_kb_config_save_input_v2';
	const ELAY_THEME_WIZARD_MAIN_PAGE_COLORS = 'epkb_theme_wizard_before_main_page_colors';
	const ELAY_THEME_WIZARD_ARTICLE_PAGE_COLORS = 'epkb_theme_wizard_before_article_page_colors';
	const ELAY_TEXT_WIZARD_MAIN_PAGE_TEXTS = 'epkb_text_wizard_before_main_page_texts';
	const ELAY_TEXT_WIZARD_ARTICLE_PAGE_TEXTS = 'epkb_text_wizard_before_article_page_texts';
	const ELAY_FEATURES_WIZARD_MAIN_PAGE_FEATURES = 'epkb_features_wizard_after_main_page_features';
	const ELAY_FEATURES_WIZARD_ARTICLE_PAGE_FEATURES = 'epkb_features_wizard_after_article_page_features';

	// AJAX action events
	const ELAY_CHANGE_MAIN_PAGE_CONFIG_AJAX = 'epkb_change_main_page_config_ajax';
	const ELAY_CHANGE_ARTICLE_PAGE_CONFIG_AJAX = 'epkb_change_article_page_config_ajax';
	const ELAY_CHANGE_ONE_PARAM_AJAX = 'epkb_change_one_config_param_ajax';
	const ELAY_CHANGE_ARTICLE_CATEGORY_SEQUENCE = 'epkb_change_article_category_sequence';
	const ELAY_KB_ADD_ON_CONFIG_SPECS = 'epkb_add_on_config_specs';
	const ELAY_SAVE_KB_CONFIG_CHANGES = 'epkb_save_kb_config_changes';
	const ELAY_APPLY_WIZARD_CHANGES = 'epkb_apply_wizard_changes';
	const ELAY_UPDATE_KB_WIZARD_ARTICLE_COLOR_VIEW = 'epkb_wizard_update_color_article_view';
	const ELAY_UPDATE_KB_WIZARD_ORDER_VIEW = 'epkb_wizard_update_order_view';
	const ELAY_UPDATE_KB_WIZARD_PREVIEW = 'epkb_update_wizard_preview';
	
	// AJAX Editor 
	const ELAY_UPDATE_KB_EDITOR = 'eckb_apply_editor_changes';

	const ELAY_APPLY_SETUP_WIZARD_CHANGES = 'epkb_apply_setup_wizard_changes';

	const ELAY_CONFIG_SIDEBAR_INTRO_SETTINGS = 'epkb_config_page_sidebar_intro_settings';
	const ELAY_SAVE_SIDEBAR_INTRO_TEXT = 'elay_save_sidebar_intro_text';
	
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
		if ( function_exists('epkb_get_instance' ) && isset(epkb_get_instance()->kb_config_obj) ) {
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
		if ( function_exists ('epkb_get_instance' ) && isset(epkb_get_instance()->kb_config_obj) ) {
			return epkb_get_instance()->kb_config_obj->get_kb_configs( $skip_check );
		}
		return new WP_Error('DB200', 'Failed to retrieve KB Configuration');
	}
	
	public static function get_epkbfa_all_icons() {
		return self::get_result( 'EPKB_Icons', 'get_epkbfa_all_icons', array() );
	}

	public static function get_demo_category_icons( $kb_config, $theme_name ) {
		return self::get_param_result( 'EPKB_Icons', 'get_demo_category_icons', array( $kb_config, $theme_name ), '' );
	}

	public static function format_font_awesome_icon_name( $value ) {
		return self::get_param_result( 'EPKB_Icons', 'format_font_awesome_icon_name', array( $value ), '' );
	}

	public static function apply_category_language_filter( $category_seq_data ) {
		return self::get_param_result( 'EPKB_WPML', 'apply_category_language_filter', array( $category_seq_data ), '' );
	}

	public static function apply_article_language_filter( $value ) {
		return self::get_param_result( 'EPKB_WPML', 'apply_article_language_filter', array( $value ), '' );
	}

	public static function get_category_demo_data( $layout, $kb_config ) {
		return self::get_param_result( 'EPKB_KB_Demo_Data', 'get_category_demo_data',
				array( $layout, $kb_config ), array( 'category_seq' => array(), 'article_seq' => array(), 'category_icons' => array() ) );
	}

	public static function get_category_icon( $box_category_id, $categories_icons ) {
		return self::get_param_result( 'EPKB_KB_Config_Category', 'get_category_icon', array( $box_category_id, $categories_icons ), array() );
	}

	public static function is_article_structure_v2( $kb_config ) {
		$result = self::get_param_result( 'EPKB_Articles_Setup', 'is_article_structure_v2', array($kb_config), true );
		return ! empty($result) && ( true == $result );
	}

	public static function get_search_form( $kb_config ) {
		self::get_param_result( 'EPKB_KB_Search', 'get_search_form', array($kb_config), '' );
	}

	/**
	 * @param $kb_id
	 * @param array $config
	 * @return array|WP_Error configuration that was updated
	 */
	public static function update_kb_configuration( $kb_id, array $config ) {
		return self::get_param_result( 'EPKB_KB_Config_DB', 'update_kb_configuration', array($kb_id, $config), new WP_Error("Internal Error (x3)") );
	}

	public static function submit_button( $params ) {
		ELAY_KB_Core::get_param_result( 'EPKB_HTML_Elements', 'submit_button', $params, '' );
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
			ELAY_Logging::add_log("Cannot invoke class $class with method $method.");
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
	public static function get_param_result( $class_name, $method, $params, $default ) {

		// instantiate certain classes
		$class = $class_name;
		if ( in_array($class_name, array('EPKB_KB_Config_Elements', 'EPKB_HTML_Elements', 'EPKB_KB_Config_DB', 'EPKB_Input_Filter', 'AMGR_Access_Articles_Front')) ) {
			$class = new $class_name();
		}

		if ( ! is_callable( array($class, $method ) ) ) {
			ELAY_Logging::add_log("Cannot invoke class $class with method $method.");
			return $default;
		}

		return call_user_func_array( array( $class, $method ), $params );
	}

	public static function get_font_data() {
		return class_exists('EPKB_Typography') ? EPKB_Typography::$font_data : [];
	}

}
