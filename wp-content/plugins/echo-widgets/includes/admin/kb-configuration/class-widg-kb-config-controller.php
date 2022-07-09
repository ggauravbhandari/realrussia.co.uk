<?php

/**
 * Handle saving specific plugin configuration.
 *
 * @copyright   Copyright (C) 2018, Echo Plugins
 */
class WIDG_KB_Config_Controller {

	public function __construct() {
		add_filter( WIDG_KB_Core::WIDG_KB_CONFIG_GET_ADD_ON_INPUT, array( $this, 'get_changed_input' ), 10, 3 );
		add_filter( WIDG_KB_Core::WIDG_KB_ADD_ON_CONFIG_SPECS, array( $this, 'get_add_on_config_specs' ), 10, 1 );
		add_filter( WIDG_KB_Core::WIDG_KB_CONFIG_SAVE_INPUT, array( $this, 'save_kb_config_changes_in_db' ), 10, 4 );
		add_filter( 'eckb_kb_config_save_input_v3', array( $this, 'save_new_kb_config_changes' ), 10, 4 );
	}

	/**
	 * Retrieve user input and fill up missing values with original values.
	 *
	 * @param $kb_id
	 * @param $all_add_on_configs
	 * @param $form_fields
	 * @return array|WP_Error
	 */
	public function get_changed_input( $all_add_on_configs, $kb_id, $form_fields ) {

		// retrieve new KB configuration
		$add_on_config = $this->get_new_kb_config( $form_fields, $kb_id );
		if ( is_wp_error( $add_on_config ) ) {
			return $add_on_config;
		}

		return array_merge($all_add_on_configs, $add_on_config);
	}

	/**
	 * Retrieve user input and fill up missing values with original values.
	 * @param $all_add_on_specs
	 * @return array|WP_Error
	 */
	public function get_add_on_config_specs( $all_add_on_specs ) {

		// retrieve new KB configuration
		$add_on_specs = WIDG_KB_Config_Specs::get_fields_specification();

		return array_merge($all_add_on_specs, $add_on_specs);
	}

	/**
	 * Save new KB configuration for this add-on based on user input.
	 *
	 * @param $status
	 * @param $kb_id
	 * @param $new_config
	 * @return String|WP_Error
	 */
	public function save_new_kb_config_changes( $status, $kb_id, $new_config ) {

		$result = widg_get_instance()->kb_config_obj->update_kb_configuration( $kb_id, $new_config );
		if ( is_wp_error( $result ) ) {
			return $result;
		}

		// do not overwrite error from other add-ons
		return empty($status) ? '' : $status;
	}

    /**
     * Save KB configuration for this add-on based on user input.
     *
     * @param $status
     * @param $kb_id
     * @param $form_fields
     * @param $main_page_layout
     * @return String|WP_Error
     */
	public function save_kb_config_changes_in_db( $status, $kb_id, $form_fields, $main_page_layout ) {

		// retrieve new KB configuration
		$add_on_config = $this->get_new_kb_config( $form_fields, $kb_id );
		if ( is_wp_error( $add_on_config ) ) {
			return $add_on_config;
		}

		// save WIDG configuration
		$result = widg_get_instance()->kb_config_obj->update_kb_configuration( $kb_id, $add_on_config );
		if ( is_wp_error( $result ) ) {
			return $result;
		}

        // do not overwrite error from other add-ons
        return empty($status) ? '' : $status;
	}

	private function get_new_kb_config( $form_fields_sanitized, $kb_id ) {

		// retrieve current KB configuration
		$orig_config = widg_get_instance()->kb_config_obj->get_kb_config( $kb_id );
		if ( is_wp_error( $orig_config ) ) {
			return $orig_config;
		}

		$field_specs = WIDG_KB_Config_Specs::get_fields_specification();
		$input_filter = new WIDG_Input_Filter();

		// retrieve new values
		$new_kb_config = $input_filter->retrieve_and_sanitize_form_fields( $form_fields_sanitized, $field_specs, $orig_config );

		return $new_kb_config;
	}
}