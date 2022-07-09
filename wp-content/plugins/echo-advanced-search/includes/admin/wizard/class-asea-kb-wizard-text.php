<?php  if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Store Wizard text data
 *
 * @copyright   Copyright (C) 2018, Echo Plugins
 * @license http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */
class ASEA_KB_Wizard_Text {

	public static function register_text_wizard_hooks() {
		add_action( ASEA_KB_Core::ASEA_TEXT_WIZARD_MAIN_PAGE_TEXTS, array('ASEA_KB_Wizard_Text', 'add_main_page_texts') );
		add_action( ASEA_KB_Core::ASEA_TEXT_WIZARD_ARTICLE_PAGE_TEXTS, array('ASEA_KB_Wizard_Text', 'add_article_page_texts') );
	}

	/**
	 * Add text inputs to Wizard Text Main Page
	 * @param $kb_id
	 */
	public static function add_main_page_texts ( $kb_id ) {
		$form = new ASEA_KB_Config_Elements();
		$asea_specs = ASEA_KB_Config_Specs::get_fields_specification();
		$asea_config = asea_get_instance()->kb_config_obj->get_kb_config( $kb_id );

		$form->option_group_wizard( $asea_specs, array(
			'option-heading'    => __( 'Advanced Search Box', 'echo-advanced-search' ),
			'class'             => 'eckb-wizard-texts eckb-wizard-accordion__body',
			'inputs'            => array (
				'0' => $form->text( $asea_specs['advanced_search_mp_title'] + array(
						'value'             => $asea_config['advanced_search_mp_title'],
						'input_group_class'       => 'eckb-wizard-single-text',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-1 #asea-search-title',
							'html' => '1'
						)
					) ),
				'1' => $form->text( $asea_specs['advanced_search_mp_description_below_title'] + array(
						'value'             => $asea_config['advanced_search_mp_description_below_title'],
						'input_group_class'       => 'eckb-wizard-single-text',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-1 #asea-search-description-1',
							'html' => '1'
						)
					) ),
				'2' => $form->text( $asea_specs['advanced_search_mp_description_below_input'] + array(
						'value'             => $asea_config['advanced_search_mp_description_below_input'],
						'input_group_class'       => 'eckb-wizard-single-text',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-1 #asea-search-description-2',
							'html' => '1'
						)
					) ),
				'3' => $form->text( $asea_specs['advanced_search_mp_box_hint'] + array(
						'value'             => $asea_config['advanced_search_mp_box_hint'],
						'input_group_class'       => 'eckb-wizard-single-text',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-1 #asea_advanced_search_terms',
							'target_attr' => 'placeholder'
						)
					) ),
				'4' => $form->text( $asea_specs['advanced_search_mp_results_msg'] + array(
						'value'             => $asea_config['advanced_search_mp_results_msg'],
						'input_group_class'       => 'eckb-wizard-single-text',
					) ),
				'5' => $form->text( $asea_specs['advanced_search_mp_no_results_found'] + array(
						'value'             => $asea_config['advanced_search_mp_no_results_found'],
						'input_group_class'       => 'eckb-wizard-single-text',
					) ),
				'6' => $form->text( $asea_specs['advanced_search_mp_more_results_found'] + array(
						'value'             => $asea_config['advanced_search_mp_more_results_found'],
						'input_group_class'       => 'eckb-wizard-single-text',
					) ),
				'7' => $form->text( $asea_specs['advanced_search_mp_filter_indicator_text'] + array(
						'value'             => $asea_config['advanced_search_mp_filter_indicator_text'],
						'input_group_class'       => 'eckb-wizard-single-text',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-1 .asea-search-filter-text',
							'html' => '1'
						)
					) ),
				'8' => $form->text( $asea_specs['advanced_search_mp_title_by_filter'] + array(
						'value'             => $asea_config['advanced_search_mp_title_by_filter'],
						'input_group_class'       => 'eckb-wizard-single-text',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '',
							'html' => '1'
						)
					) ),
				'9' => $form->text( $asea_specs['advanced_search_mp_title_clear_results'] + array(
						'value'             => $asea_config['advanced_search_mp_title_clear_results'],
						'input_group_class'       => 'eckb-wizard-single-text',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '',
							'html' => '1'
						)
					) ),
			)
		));
	}
	
	/**
	 * Add text inputs to Wizard Text Article Page
	 * @param $kb_id
	 */
	public static function add_article_page_texts ( $kb_id ) {
		$form = new ASEA_KB_Config_Elements();
		
		$asea_specs = ASEA_KB_Config_Specs::get_fields_specification();
		$asea_config = asea_get_instance()->kb_config_obj->get_kb_config( $kb_id );
		$kb_config =  ASEA_KB_Core::get_kb_config( $kb_id );
		
		$show_options = true;
		
		if ( $kb_config['kb_main_page_layout'] == 'Categories'  ) $show_options = false;
		if ( in_array( $kb_config['kb_main_page_layout'], array( 'Basic', 'Tabs' ) ) &&  ! defined( 'EL'.'AY_PLUGIN_NAME' ) ) $show_options = false;
		if ( $asea_config['advanced_search_ap_box_visibility'] == 'asea-visibility-search-form-2' ) $show_options = false;
		
		if ( $show_options ) {
			$form->option_group_wizard( $asea_specs, array(
				'option-heading'    => __( 'Advanced Search Box', 'echo-advanced-search' ),
				'class'             => 'eckb-wizard-texts eckb-wizard-accordion__body',
				'inputs'            => array (
					'0' => $form->text( $asea_specs['advanced_search_ap_title'] + array(
							'value'             => $asea_config['advanced_search_ap_title'],
							'input_group_class'       => 'eckb-wizard-single-text',
							'data' => array(
								'wizard_input' => '1',
								'target_selector' => '.eckb-wizard-step-2 #asea-search-title',
								'html' => '1'
							)
						) ),
					'1' => $form->text( $asea_specs['advanced_search_ap_description_below_title'] + array(
							'value'             => $asea_config['advanced_search_ap_description_below_title'],
							'input_group_class'       => 'eckb-wizard-single-text',
							'data' => array(
								'wizard_input' => '1',
								'target_selector' => '.eckb-wizard-step-2 #asea-search-description-1',
								'html' => '1'
							)
						) ),
					'2' => $form->text( $asea_specs['advanced_search_ap_description_below_input'] + array(
							'value'             => $asea_config['advanced_search_ap_description_below_input'],
							'input_group_class'       => 'eckb-wizard-single-text',
							'data' => array(
								'wizard_input' => '1',
								'target_selector' => '.eckb-wizard-step-2 #asea-search-description-2',
								'html' => '1'
							)
						) ),
					'3' => $form->text( $asea_specs['advanced_search_ap_box_hint'] + array(
							'value'             => $asea_config['advanced_search_ap_box_hint'],
							'input_group_class'       => 'eckb-wizard-single-text',
							'data' => array(
								'wizard_input' => '1',
								'target_selector' => '.eckb-wizard-step-2 #asea_advanced_search_terms',
								'target_attr' => 'placeholder'
							)
						) ),
					'4' => $form->text( $asea_specs['advanced_search_ap_results_msg'] + array(
							'value'             => $asea_config['advanced_search_ap_results_msg'],
							'input_group_class'       => 'eckb-wizard-single-text',
						) ),
					'5' => $form->text( $asea_specs['advanced_search_ap_no_results_found'] + array(
							'value'             => $asea_config['advanced_search_ap_no_results_found'],
							'input_group_class'       => 'eckb-wizard-single-text',
						) ),
					'6' => $form->text( $asea_specs['advanced_search_ap_more_results_found'] + array(
							'value'             => $asea_config['advanced_search_ap_more_results_found'],
							'input_group_class'       => 'eckb-wizard-single-text',
						) ),
					'7' => $form->text( $asea_specs['advanced_search_ap_filter_indicator_text'] + array(
							'value'             => $asea_config['advanced_search_ap_filter_indicator_text'],
							'input_group_class'       => 'eckb-wizard-single-text',
						) ),
					'8' => $form->text( $asea_specs['advanced_search_ap_title_by_filter'] + array(
							'value'             => $asea_config['advanced_search_ap_title_by_filter'],
							'input_group_class'       => 'eckb-wizard-single-text',
							'data' => array(
								'wizard_input' => '1',
								'target_selector' => '',
								'html' => '1'
							)
						) ),
					'9' => $form->text( $asea_specs['advanced_search_ap_title_clear_results'] + array(
							'value'             => $asea_config['advanced_search_ap_title_clear_results'],
							'input_group_class'       => 'eckb-wizard-single-text',
							'data' => array(
								'wizard_input' => '1',
								'target_selector' => '',
								'html' => '1'
							)
						) ),
				)
			));
		}
	}
}