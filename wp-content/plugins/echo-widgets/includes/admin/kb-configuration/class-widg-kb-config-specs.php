<?php

/**
 * Lists all KB configuration settings and adds filter to get configuration from add-ons.
 *
 * @copyright   Copyright (C) 2018, Echo Plugins
 */
class WIDG_KB_Config_Specs {
	
	private static $cached_specs = array();

	/**
	 * Defines how KB configuration fields will be displayed, initialized and validated/sanitized
	 *
	 * ALL FIELDS ARE MANDATORY by default ( otherwise use 'mandatory' => false )
	 *
	 * @return array with KB config specification
	 */
	public static function get_fields_specification() {

		// retrieve settings if already cached
		if ( ! empty(self::$cached_specs) && is_array(self::$cached_specs) ) {
			return self::$cached_specs;
		}

		// get all configuration
		$config_specification = array(
			// version 1 of article structure
            'widgets_sidebar_location' => array(
                'label'       => __( 'Article Sidebar Location', 'echo-widgets' ),
                'name'        => 'widgets_sidebar_location',
                'type'        => WIDG_Input_Filter::SELECTION,
                'options'     => array(
                    'left-sidebar'   => _x( 'Left Sidebar', 'echo-widgets' ),
                    'right-sidebar'  => _x( 'Right Sidebar', 'echo-widgets' ),
                    'no-sidebar'     => _x( 'No Sidebar', 'echo-widgets' ) ),
                'default'     => 'no-sidebar'
            ),
			'widg_widget_css_reset' => array(
				'label'       => __( 'Widget CSS Reset', 'echo-widgets' ),
				'name'        => 'widg_widget_css_reset',
				'type'        => WIDG_Input_Filter::CHECKBOX,
				'default'     => 'on'
			),
			'widg_widget_css_defaults' => array(
				'label'       => __( 'Widget CSS Defaults', 'echo-widgets' ),
				'name'        => 'widg_widget_css_defaults',
				'type'        => WIDG_Input_Filter::CHECKBOX,
				'default'     => 'on'
			),
			'widg_shortcode_css_reset' => array(
				'label'       => __( 'Shortcode CSS Reset', 'echo-widgets' ),
				'name'        => 'widg_shortcode_css_reset',
				'type'        => WIDG_Input_Filter::CHECKBOX,
				'default'     => 'on'
			),
			'widg_shortcode_css_defaults' => array(
				'label'       => __( 'Shortcode CSS Defaults', 'echo-widgets' ),
				'name'        => 'widg_shortcode_css_defaults',
				'type'        => WIDG_Input_Filter::CHECKBOX,
				'default'     => 'on'
			),
			'widg_search_preset_styles' => array(
				'label'       => __( 'Widget Search Preset Styles', 'echo-widgets' ),
				'name'        => 'widg_search_preset_styles',
				'type'        => WIDG_Input_Filter::SELECTION,
				'options'     => array(
					'widg-search-preset-style-1'  => _x( 'Style 1', 'echo-widgets' ),
					'widg-search-preset-style-2'  => _x( 'Style 2', 'echo-widgets' ),
					'widg-search-preset-style-3'  => _x( 'Style 3', 'echo-widgets' ),
					'widg-search-preset-style-4'  => _x( 'Style 4', 'echo-widgets' ),
					'widg-search-preset-style-5'  => _x( 'Style 5', 'echo-widgets' ),
					'widg-search-preset-style-6'  => _x( 'Style 6', 'echo-widgets' ),
					'widg-search-preset-style-7'  => _x( 'Style 7', 'echo-widgets' )

				),
				'default'     => 'widg-search-preset-style-1'
			),
			'widg_search_results_limit'                => array(
				'label'       => __( 'Search results limit', 'echo-widgets' ),
				'name'        => 'widg_search_results_limit',
				'max'         => '50',
				'min'         => '1',
				'type'        => WIDG_Input_Filter::NUMBER,
				'default'     => 8
			)
        );

		self::$cached_specs = $config_specification;

		return self::$cached_specs;
	}

	/**
	 * Get KB default configuration
	 *
	 * @return array contains default values for KB configuration
	 */
	public static function get_default_kb_config() {
		$config_specs = self::get_fields_specification();

		$configuration = array();
		foreach( $config_specs as $key => $spec ) {
			$default = isset($spec['default']) ? $spec['default'] : '';
			$configuration += array( $key => $default );
		}

		return $configuration;
	}

	/**
	 * Get names of all configuration items for KB configuration
	 * @return array
	 */
	public static function get_specs_item_names() {
		return array_keys( self::get_fields_specification() );
	}

	/**
	 * Return default values from given specification.
	 * @param $config_specs
	 * @return array
	 */
	public static function get_specs_defaults( $config_specs ) {
		$default_configuration = array();
		foreach( $config_specs as $key => $spec ) {
			$default = isset($spec['default']) ? $spec['default'] : '';
			$default_configuration += array( $key => $default );
		}
		return $default_configuration;
	}
}
