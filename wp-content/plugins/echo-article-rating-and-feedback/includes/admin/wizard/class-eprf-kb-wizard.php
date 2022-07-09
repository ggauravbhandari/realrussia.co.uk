<?php  if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Store Wizard theme data
 *
 * @copyright   Copyright (C) 2018, Echo Plugins
 * @license http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */
class EPRF_KB_Wizard {

	public static function register_all_wizard_hooks() {

		// global hooks
		add_filter( EPRF_KB_Core::EPRF_ALL_WIZARDS_CONFIGURATION_DEFAULTS, array('EPRF_KB_Wizard', 'get_configuration_defaults') );
		add_filter( EPRF_KB_Core::EPRF_ALL_WIZARDS_GET_CURRENT_CONFIG, array('EPRF_KB_Wizard', 'get_current_config' ), 10, 2 );

		// THEME WIZARD hooks
		add_action( EPRF_KB_Core::EPRF_THEME_WIZARD_ARTICLE_PAGE_COLORS, array('EPRF_KB_Wizard', 'add_article_page_colors') );

		// TEXT WIZARD hooks
		EPRF_KB_Wizard_Text::register_text_wizard_hooks();
		
		// FEATURES WIZARD hooks
		EPRF_KB_Wizard_Features::register_features_wizard_hooks();
	}

	/**
	 * Returnt to Wizard the current KB configuration
	 *
	 * @param $kb_config
	 * @param $kb_id
	 * @return array
	 */
	public static function get_current_config( $kb_config, $kb_id ) {
		$eprf_config = eprf_get_instance()->kb_config_obj->get_kb_config( $kb_id );
		return array_merge( $kb_config, $eprf_config );
	}
	
	/**
	 * Return add-on configuration defaults.
	 *
	 * @param $template_defaults
	 * @return array
	 */
	public static function get_configuration_defaults( $template_defaults ) {
		$kb_eprf_defaults = EPRF_KB_Config_Specs::get_default_kb_config();
		return array_merge($template_defaults, $kb_eprf_defaults);
	}

	/**
	 * Add color pickers to Wizard Article Page
	 * @param $kb_id
	 */
	public static function add_article_page_colors ( $kb_id ) {
		$form = new EPRF_KB_Config_Elements();
		
		$eprf_specs = EPRF_KB_Config_Specs::get_fields_specification();
		$eprf_config = eprf_get_instance()->kb_config_obj->get_kb_config( $kb_id );
		
		$form->option_group_wizard( $eprf_specs, array(
			'option-heading'    => 'Rating And Feedback: General',
			'class'             => 'eckb-wizard-colors eckb-wizard-accordion__body',
			'inputs'            => array(
				'0' => $form->text( $eprf_specs['rating_feedback_button_color'] + array(
						'value'             => $eprf_config['rating_feedback_button_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-4 .eprf-article-feedback__submit button',
							'style_name' => 'background-color',
						)
					) ),
				'2' => $form->text( $eprf_specs['rating_text_color'] + array(
						'value'             => $eprf_config['rating_text_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-4 #eprf-current-rating, .eckb-wizard-step-4 #eprf-article-feedback-container, .eckb-wizard-step-4 .eprf-stars-module__text, .eckb-wizard-step-4 .eprf-like-dislike-module__text',  
							'style_name' => 'color',
						)
					) )
			)
		));
		
		
		$form->option_group_wizard( $eprf_specs, array(
			'option-heading'    => 'Rating And Feedback: 5 stars mode',
			'class'             => 'eckb-wizard-colors eckb-wizard-accordion__body',
			'depends'         => array(
				'show_when' => array(
					'rating_mode' => 'eprf-rating-mode-five-stars'
				)
			),
			'inputs'            => array(
				'0' => $form->text( $eprf_specs['rating_element_color'] + array(
						'value'             => $eprf_config['rating_element_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color epkb-rating-stars',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-4 .eprf-stars-container, .eckb-wizard-step-4 .eprf-article-meta__star-rating',
							'style_name' => 'color'
						)
					) ),
				
				'1' => $form->text( $eprf_specs['rating_dropdown_color'] + array(
						'value'             => $eprf_config['rating_dropdown_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-4 .eprf-article-meta__statistics-toggle, .eckb-wizard-step-4 .eprf-show-statistics-toggle',
							'style_name' => 'color',
						)
					) ),
			)
		));
		
		$form->option_group_wizard( $eprf_specs, array(
			'option-heading'    => 'Rating And Feedback: Like mode',
			'class'             => 'eckb-wizard-colors eckb-wizard-accordion__body',
			'depends'         => array(
							'show_when' => array(
								'rating_mode' => 'eprf-rating-mode-like-dislike'
							)
						),
			'inputs'            => array(
				'0' => $form->text( $eprf_specs['rating_like_color'] + array(
						'value'             => $eprf_config['rating_like_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color epkb-rating-like',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-4 .eprf-rate-like .epkbfa',
							'style_name' => 'color'
						)
					) ),
				'1' => $form->text( $eprf_specs['rating_dislike_color'] + array(
						'value'             => $eprf_config['rating_dislike_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color epkb-rating-like',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-4 .eprf-rate-dislike .epkbfa',
							'style_name' => 'color'
						)
					) )
			)
		));
		
		
			
		
	}
}