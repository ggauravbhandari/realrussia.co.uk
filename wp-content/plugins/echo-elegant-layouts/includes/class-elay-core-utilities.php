<?php

/**
 * Utility functions specific to this plugin
 */
class ELAY_Core_Utilities {

	/**
	 * Return value for given search configuration and whether we are on Main Page or Article Page
	 * @param $kb_config
	 * @param $config_name
	 *
	 * @return string
	 */
	public static function get_search_kb_config( $kb_config, $config_name ) {

		$config_name = str_replace('*', self::get_search_index( $kb_config ), $config_name);

		if ( isset($kb_config[$config_name]) ) {
			return $kb_config[$config_name];
		}

		$default_specs = ELAY_KB_Config_Specs::get_default_kb_config();

		return isset($default_specs[$config_name]) ? $default_specs[$config_name] : '';
	}

	public static function get_search_index( $kb_config=array() ) {
		global $eckb_is_kb_main_page;
		global $elay_use_main_page_settings;

		$ix = ( isset( $eckb_is_kb_main_page ) && $eckb_is_kb_main_page ) || ELAY_Utilities::post( 'is_kb_main_page' ) == 1 || ! empty( $elay_use_main_page_settings ) ? 'mp' : 'ap';

		$ix = empty($kb_config['kb_main_page_layout']) || $kb_config['kb_main_page_layout'] != 'Sidebar' ? $ix : 'mp';

		return $ix;
	}

	/**
	 * if the Editor is active then use its configuration changes to update the current configuration
	 * @param $config
	 * @return mixed
	 */
	public static function update_from_editor_config( $config ) {

		// do not make any changes to the configuration unless Editor is active
		if ( empty( $_REQUEST['epkb-editor-page-loaded'] ) || empty( $_REQUEST['epkb-editor-settings'] ) ) {
			return $config;
		}

		$new_config = json_decode(stripcslashes($_REQUEST['epkb-editor-settings'] ), true);
		if ( empty( $new_config ) || ! is_array($new_config) ) {
			return $config;
		}

		// use Editor configuration to update current configuration
		foreach ( $new_config as $zone_name => $zone ) {
			foreach ( $zone['settings'] as $field_name => $field ) {
				if ( ! isset( $config[$field_name] ) ) {
					continue;
				}

				$config[$field_name] = $field['value'];
			}
		}

		return $config;
	}

	/**
	 * Retrieve a KB article with security checks
	 *
	 * @param $post_id
	 * @return null|WP_Post - return null if this is NOT KB post
	 */
	public static function get_kb_post_secure( $post_id ) {

		if ( empty($post_id) ) {
			return null;
		}

		// ensure post_id is valid
		$post_id = ELAY_Utilities::sanitize_int( $post_id );
		if ( empty($post_id) ) {
			return null;
		}

		// retrieve the post and ensure it is one
		$post = get_post( $post_id );
		if ( empty($post) || ! is_object($post) || ! $post instanceof WP_Post ) {
			return null;
		}

		// verify it is a KB article
		if ( ! ELAY_KB_Handler::is_kb_post_type( $post->post_type ) ) {
			return null;
		}

		return $post;
	}

	/**
	 * Is WPML enabled? Only for KB CORE. ADD-ONs to call this function in core
	 *
	 * @param $kb_id
	 *
	 * @return bool
	 */
	public static function is_wpml_enabled_addon( $kb_id ) {

		if ( ELAY_Utilities::is_positive_int( $kb_id ) ) {
			$kb_config = ELAY_KB_Core::get_kb_config( $kb_id );
			if ( is_wp_error( $kb_config ) ) {
				return false;
			}
		} else {
			return false;
		}

		return ELAY_Utilities::is_wpml_enabled( $kb_config );
	}
}
