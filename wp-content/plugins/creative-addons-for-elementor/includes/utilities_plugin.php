<?php
namespace Creative_Addons\Includes;

use Creative_Addons\Includes\System\Logging;
use Elementor\Plugin;

defined( 'ABSPATH' ) || exit();

/**
 * Various utility functions
 */
class Utilities_Plugin {

    /**
     * Get elementor instance
     * @return Plugin
     */
    public static function elementor() {
        return Plugin::instance();
    }

    public static function is_built_with_elementor( $post_id ) {
        return Plugin::instance()->db->is_built_with_elementor( $post_id );
    }

    /**
     * Get type of the widget
     * @param $element
     * @return mixed|string
     */
    public static function get_widget_type( $element ) {
        $type = empty($element['widgetType']) ? $element['elType'] : $element['widgetType'];
        if ( $type === 'global' && ! empty( $element['templateID'] ) ) {
            $type = self::get_global_widget_type( $element['templateID'] );
        }
        return $type;
    }

    /**
     * Elementor PRO has Global Widget so we will get the type of that widget.
     * @param $template_id
     * @return mixed|string
     */
    public static function get_global_widget_type( $template_id ) {

        // get global widget data
        $template_data = Utilities_Plugin::elementor()->templates_manager->get_template_data( [
            'source' => 'local',
            'template_id' => $template_id,
        ] );

        if ( is_wp_error( $template_data ) ) {
            // throw new \Exception( $template_data->get_error_message() );
            return '';
        }

        if ( empty( $template_data['content'] ) ) {
            // throw new \Exception( 'Template content not found.' );
            return '';
        }

        $original_widget_type = Utilities_Plugin::elementor()->widgets_manager->get_widget_types( $template_data['content'][0]['widgetType'] );
        /* if ( ! $original_widget_type ) {
            throw new \Exception( 'Original Widget Type not found.' );
        } */

        return $original_widget_type ? $template_data['content'][0]['widgetType'] : '';
    }
	
	/**
	 * Get users settings for presets 
	 */
	public static function get_users_inactive_presets() {
		return get_option( 'crel_preset_settings', [] );
	}
	
	public static function set_users_inactive_presets( $inactive_presets = [] ) {
		update_option( 'crel_preset_settings', $inactive_presets );
		return true;
	}

	/**
	 * Old versions of Widgets do not use Global fonts/colors so we need to set defaults for them
	 * @return mixed
	 */
	public static function use_old_widgets_without_globals() {

		// make sure we have plugin initial and current version recorded
		$plugin_first_version = Utilities::get_wp_option( 'crel_version_first', '' );
		if ( empty($plugin_first_version) ) {
			update_option( 'crel_version', CREATIVE_ADDONS_VERSION, true );
			update_option( 'crel_version_first', '1.1.0', true );
			$plugin_first_version = '1.1.0';
		}
		
		// global fonts/colors used by default from version 1.2.0 up
		return version_compare( $plugin_first_version, '1.2.0' , '<' );
	}
}
