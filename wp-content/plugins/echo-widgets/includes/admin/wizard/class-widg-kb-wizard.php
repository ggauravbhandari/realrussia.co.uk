<?php  if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Store Wizard theme data
 *
 * @copyright   Copyright (C) 2020, Echo Plugins
 * @license http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */
class WIDG_KB_Wizard {

	public static function register_all_wizard_hooks() {

		// global hooks
		add_filter( WIDG_KB_Core::WIDG_ALL_WIZARDS_CONFIGURATION_DEFAULTS, array('WIDG_KB_Wizard','get_configuration_defaults') );
		add_filter( WIDG_KB_Core::WIDG_ALL_WIZARDS_GET_CURRENT_CONFIG, array('WIDG_KB_Wizard', 'get_current_config' ), 10, 2 );

		// Features WIZARD hooks
		WIDG_KB_Wizard_Features::register_features_wizard_hooks();
	}

	/**
	 * Returnt to Wizard the current KB configuration
	 *
	 * @param $kb_config
	 * @param $kb_id
	 * @return array
	 */
	public static function get_current_config( $kb_config, $kb_id ) {
		$widg_config = widg_get_instance()->kb_config_obj->get_kb_config( $kb_id );
		return array_merge( $kb_config, $widg_config );
	}

	/**
	 * Return add-on configuration defaults.
	 *
	 * @param $template_defaults
	 * @return array
	 */
	public static function get_configuration_defaults( $template_defaults ) {
		$kb_widg_defaults = WIDG_KB_Config_Specs::get_default_kb_config();
		return array_merge($template_defaults, $kb_widg_defaults);
	}
	
}