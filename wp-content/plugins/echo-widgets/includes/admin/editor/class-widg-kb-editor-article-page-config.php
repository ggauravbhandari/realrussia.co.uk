<?php

/**
 * Configuration for the front end editor
 */

class WIDG_KB_Editor_Article_Page_Config {

	// Frontend Editor Tabs
	const EDITOR_TAB_CONTENT = 'content';
	const EDITOR_TAB_STYLE = 'style';
	const EDITOR_TAB_FEATURES = 'features';
	const EDITOR_TAB_ADVANCED = 'advanced';
	const EDITOR_TAB_GLOBAL = 'global';
	const EDITOR_TAB_DISABLED = 'hidden';

	const EDITOR_GROUP_DIMENSIONS = 'dimensions';

	/**
	 * Widgets Zone
	 * @return array[]
	 */
	private static function widgets_zone() {

		$settings = [

			// Features
			'widgets_sidebar_location' => [
				'editor_tab' => self::EDITOR_TAB_FEATURES,
				'preview' => 1,
			],
			'widg_search_results_limit' => [
				'editor_tab' => self::EDITOR_TAB_FEATURES,
			],

			// Style
			'widg_search_preset_styles' => [
				'editor_tab' => self::EDITOR_TAB_STYLE,
				'preview' => 1,
			],

			// Advanced
			'widg_widget_css_reset' => [
				'editor_tab' => self::EDITOR_TAB_ADVANCED,
			],
			'widg_widget_css_defaults' => [
				'editor_tab' => self::EDITOR_TAB_ADVANCED,
			],
			'widg_shortcode_css_reset' => [
				'editor_tab' => self::EDITOR_TAB_ADVANCED,
			],
			'widg_shortcode_css_defaults' => [
				'editor_tab' => self::EDITOR_TAB_ADVANCED,
			],

		];

		return [
			'widgets_zone' => [
				'title'     =>  __( 'Widgets Zone', 'echo-widgets' ),
				'classes'   => '',
				'settings'  => $settings
			]];
	}


	/**
	 * Retrieve Editor configuration
	 * @param $kb_config
	 * @return array
	 */
	public static function get_config( $kb_config ) {

		$editor_config = [];

		$editor_config += self::widgets_zone();

		return $editor_config;
	}
}