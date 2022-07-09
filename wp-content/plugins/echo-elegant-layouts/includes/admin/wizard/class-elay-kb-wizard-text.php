<?php  if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Store Wizard text data
 *
 * @copyright   Copyright (C) 2018, Echo Plugins
 * @license http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */
class ELAY_KB_Wizard_Text {

	public static function register_text_wizard_hooks() {
		add_action( ELAY_KB_Core::ELAY_TEXT_WIZARD_MAIN_PAGE_TEXTS, array('ELAY_KB_Wizard_Text', 'add_main_page_texts') );
		add_action( ELAY_KB_Core::ELAY_TEXT_WIZARD_ARTICLE_PAGE_TEXTS, array('ELAY_KB_Wizard_Text', 'add_article_page_texts') );
	}

	/**
	 * Add text inputs to Wizard Text Main Page
	 * @param $kb_id
	 */
	public static function add_main_page_texts ( $kb_id ) {
		$form = new ELAY_KB_Config_Elements();
		$elay_specs = ELAY_KB_Config_Specs::get_fields_specification();
		$elay_config = elay_get_instance()->kb_config_obj->get_kb_config( $kb_id );

		// GRID layout 
		$form->option_group_wizard( $elay_specs, array(
			'option-heading'    => __( 'Grid Texts', 'echo-elegant-layouts' ),
			'class'             => 'eckb-wizard-texts eckb-wizard-accordion__body',
			'depends'          => array(
				'show_when' => array(
					'kb_main_page_layout' => 'Grid'
				)
			),
			'inputs'            => array(
				'0' => $form->text( $elay_specs['grid_category_empty_msg'] + array(
						'value'             => $elay_config['grid_category_empty_msg'],
						'input_group_class'       => 'eckb-wizard-single-text',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.elay_grid_empty_msg',
							'text' => '1'
						)
					) ),
				'1' => $form->text( $elay_specs['grid_article_count_text'] + array(
						'value'             => $elay_config['grid_article_count_text'],
						'input_group_class'       => 'eckb-wizard-single-text',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.elay_grid_count_text--single',
							'text' => '1'
						)
					) ),
				'2' => $form->text( $elay_specs['grid_article_count_plural_text'] + array(
						'value'             => $elay_config['grid_article_count_plural_text'],
						'input_group_class'       => 'eckb-wizard-single-text',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.elay_grid_count_text--plural',
							'text' => '1'
						)
					) ),
				'3' => $form->text( $elay_specs['grid_category_link_text'] + array(
						'value'             => $elay_config['grid_category_link_text'],
						'input_group_class'       => 'eckb-wizard-single-text',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.elay_grid_link_text',
							'text' => '1'
						)
					) ),
			)
		));
		
		// GRID SEARCH
		$form->option_group_wizard( $elay_specs, array(
			'option-heading'    => __( 'Grid Search', 'echo-elegant-layouts'),
			'class'             => 'eckb-wizard-texts eckb-wizard-accordion__body',
			'depends'        => array(
				'show_when' => array(
					'kb_main_page_layout' => 'Grid'
				),
				'hide_when' => array(
					'advanced_search_mp_show_top_category' => 'on|off',  // true if Advanced Search is enabled
				)
			),
			'inputs' => array(
				'0' => $form->text( $elay_specs['grid_search_title'] + array( 
						'value' => $elay_config['grid_search_title'], 
						'current' => $elay_config['grid_search_title'],
						'input_group_class'       => 'eckb-wizard-single-text',  
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '#elay-grid-layout-page-container .elay-doc-search-title',
							'text' => '1'
						)
				) ),
				'1' => $form->text( $elay_specs['grid_search_box_hint'] + array( 
						'value' => $elay_config['grid_search_box_hint'], 
						'current' => $elay_config['grid_search_box_hint'],
						'input_group_class'       => 'eckb-wizard-single-text',   
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '#elay-grid-layout-page-container #elay_search_terms',
							'target_attr' => 'placeholder|aria-label' // use this input value like one of the attributes, divided by | 
						)
					) ),
				'2' => $form->text( $elay_specs['grid_search_button_name'] + array( 
						'value' => $elay_config['grid_search_button_name'], 
						'current' => $elay_config['grid_search_button_name'],
						'input_group_class'       => 'eckb-wizard-single-text',   
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '#grid-elay-search-kb',
							'target_attr' => 'value',
							'text' => '1',
						)    
					) ),
				'3' => $form->text( $elay_specs['grid_search_results_msg'] + array( 
						'value' => $elay_config['grid_search_results_msg'], 
						'current' => $elay_config['grid_search_results_msg'],
						'input_group_class'       => 'eckb-wizard-single-text',      
					) ), 
				'4' => $form->text( $elay_specs['grid_no_results_found'] + array( 
						'value' => $elay_config['grid_no_results_found'], 
						'current' => $elay_config['grid_no_results_found'],
						'input_group_class'       => 'eckb-wizard-single-text',
					) ),
				'5' => $form->text( $elay_specs['grid_min_search_word_size_msg'] + array( 
						'value' => $elay_config['grid_min_search_word_size_msg'], 
						'current' => $elay_config['grid_min_search_word_size_msg'],
				        'input_group_class'       => 'eckb-wizard-single-text',  
					) )
			)
		));

		// SIDEBAR layout
		$form->option_group_wizard( $elay_specs, array(
			'option-heading'    => __( 'Sidebar Text', 'echo-elegant-layouts' ),
			'class'             => 'eckb-wizard-texts eckb-wizard-accordion__body',
			'depends'          => array(
				'show_when' => array(
					'kb_main_page_layout' => 'Sidebar'
				)
			),
			'inputs'            => array(
				'0' => $form->text( $elay_specs['sidebar_category_empty_msg'] + array(
						'value'             => $elay_config['sidebar_category_empty_msg'],
						'input_group_class'       => 'eckb-wizard-single-text',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.elay-articles-coming-soon',
							'text' => '1'
						)
					) ),
				'1' => $form->text( $elay_specs['sidebar_collapse_articles_msg'] + array(
						'value'             => $elay_config['sidebar_collapse_articles_msg'],
						'input_group_class'       => 'eckb-wizard-single-text',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.elay-show-all-articles .elay-hide-text',
							'text' => '1'
						)
					) ),
				'2' => $form->text( $elay_specs['sidebar_show_all_articles_msg'] + array(
						'value'             => $elay_config['sidebar_show_all_articles_msg'],
						'input_group_class'       => 'eckb-wizard-single-text',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.elay-show-all-articles .elay-show-text span',
							'text' => '1'
						)
					) ),
				'3' => $form->wp_editor( $elay_specs['sidebar_main_page_intro_text'] + array(
						'id'                => 'sidebar_main_page_intro_text',
						'value'             => $elay_config['sidebar_main_page_intro_text'],
						'input_group_class'       => 'eckb-wizard-single-text eckb-wizard-wp-editor',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '#ep'.'kb-wsb-step-1-panel #eckb-article-content',
							'html' => '1'
						)
					), true )
			)
		));
		
		ELAY_KB_Config_Layouts::get_wp_editor( $elay_config );
	}

	/**
	 * Add text inputs to Wizard Text Article Page
	 * @param $kb_id
	 */
	public static function add_article_page_texts ( $kb_id ) {
		$form = new ELAY_KB_Config_Elements();
		$elay_specs = ELAY_KB_Config_Specs::get_fields_specification();
		$elay_config = elay_get_instance()->kb_config_obj->get_kb_config( $kb_id );
		
		// SIDEBAR SEARCH
		$form->option_group_wizard( $elay_specs, array(
			'option-heading'    => __( 'Sidebar Search', 'echo-elegant-layouts' ),
			'class'             => 'eckb-wizard-texts eckb-wizard-accordion__body',
			'depends'        => array(
				'hide_when' => array(
					'advanced_search_mp_show_top_category' => 'on|off',  // true if Advanced Search is enabled
					'sidebar_search_layout' => 'elay-search-form-0'
				)
			),
			'inputs' => array(
				'0' => $form->text( $elay_specs['sidebar_search_title'] + array( 
						'value' => $elay_config['sidebar_search_title'], 
						'current' => $elay_config['sidebar_search_title'],
				        'input_group_class'       => 'eckb-wizard-single-text',    
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.elay-sidebar-template .elay-doc-search-title, #epkb-wsb-step-2-panel .elay-doc-search-title',
							'text' => '1'
						)
					) ),
				'1' => $form->text( $elay_specs['sidebar_search_box_hint'] + array( 
						'value' => $elay_config['sidebar_search_box_hint'], 
						'current' => $elay_config['sidebar_search_box_hint'],
				        'input_group_class'       => 'eckb-wizard-single-text',  
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.elay-sidebar-template #elay_search_terms, #epkb-wsb-step-2-panel #elay_search_terms',
							'target_attr' => 'placeholder|aria-label' // use this input value like one of the attributes, divided by | 
						)
					) ),
				'2' => $form->text( $elay_specs['sidebar_search_button_name'] + array( 
						'value' => $elay_config['sidebar_search_button_name'], 
						'current' => $elay_config['sidebar_search_button_name'],
				        'input_group_class'       => 'eckb-wizard-single-text',  
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.elay-sidebar-template #sidebar-elay-search-kb, #epkb-wsb-step-2-panel #sidebar-elay-search-kb',
							'target_attr' => 'value',
							'text' => '1',
						)         
					) ),
				'3' => $form->text( $elay_specs['sidebar_search_results_msg'] +
				                    array( 'value' => $elay_config['sidebar_search_results_msg'], 'current' => $elay_config['sidebar_search_results_msg'],
				                           'input_group_class'       => 'eckb-wizard-single-text',       ) ),
				'4' => $form->text( $elay_specs['sidebar_no_results_found'] +
				                    array( 'value' => $elay_config['sidebar_no_results_found'], 'current' => $elay_config['sidebar_no_results_found'],
				                           'input_group_class'       => 'eckb-wizard-single-text',   ) ),
				'5' => $form->text( $elay_specs['sidebar_min_search_word_size_msg'] +
				                    array( 'value' => $elay_config['sidebar_min_search_word_size_msg'], 'current' => $elay_config['sidebar_min_search_word_size_msg'],
				                           'input_group_class'       => 'eckb-wizard-single-text',   ) )
			)
		));
	}
}