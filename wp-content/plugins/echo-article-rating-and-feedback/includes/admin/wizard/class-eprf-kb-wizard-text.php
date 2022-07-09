<?php  if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Store Wizard theme data
 *
 * @copyright   Copyright (C) 2018, Echo Plugins
 * @license http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */
class EPRF_KB_Wizard_Text {

	public static function register_text_wizard_hooks() {

		// TEXT WIZARD hooks
		add_action( EPRF_KB_Core::EPRF_TEXT_WIZARD_ARTICLE_PAGE_TEXTS, array('EPRF_KB_Wizard_Text', 'add_article_page_texts') );
	}
	
	/**
	 * Add color pickers to Wizard Article Page
	 * @param $kb_id
	 */
	public static function add_article_page_texts ( $kb_id ) {
		$form = new EPRF_KB_Config_Elements();
		
		$eprf_specs = EPRF_KB_Config_Specs::get_fields_specification();
		$eprf_config = eprf_get_instance()->kb_config_obj->get_kb_config( $kb_id );
		
		
		$form->option_group_wizard( $eprf_specs, array(
			'option-heading'    => 'Rating: General',
			'class'             => 'eckb-wizard-texts eckb-wizard-accordion__body',
			'inputs'            => array(
				'0' => $form->text( $eprf_specs['rating_text_value'] + array(
						'value'             => $eprf_config['rating_text_value'],
						'input_group_class' => 'eckb-wizard-single-text',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eprf-stars-module__text, .eprf-like-dislike-module__text',
							'text' => '1'
						)
					) ),
				'1' => $form->text( $eprf_specs['rating_confirmation_positive'] + array(
						'value'             => $eprf_config['rating_confirmation_positive'],
						'input_group_class' => 'eckb-wizard-single-text',
						'data' => array(
							'wizard_input' => '1',
						)
					) ),
				'2' => $form->text( $eprf_specs['rating_confirmation_negative'] + array(
						'value'             => $eprf_config['rating_confirmation_negative'],
						'input_group_class' => 'eckb-wizard-single-text',
						'data' => array(
							'wizard_input' => '1',
						)
					) )
			)
		));
		
		$form->option_group_wizard( $eprf_specs, array(
			'option-heading'    => 'Rating: Stars Mode',
			'class'             => 'eckb-wizard-texts eckb-wizard-accordion__body',
			'depends'         => array(
				'show_when' => array(
					'rating_mode' => 'eprf-rating-mode-five-stars'
				)
			),
			'inputs'            => array(
				'0' => $form->text( $eprf_specs['rating_stars_text_1'] + array(
						'value'             => $eprf_config['rating_stars_text_1'],
						'input_group_class' => 'eckb-wizard-single-text',
					) ),
				'1' => $form->text( $eprf_specs['rating_stars_text_2'] + array(
						'value'             => $eprf_config['rating_stars_text_2'],
						'input_group_class' => 'eckb-wizard-single-text',
					) ),
				'2' => $form->text( $eprf_specs['rating_stars_text_3'] + array(
						'value'             => $eprf_config['rating_stars_text_3'],
						'input_group_class' => 'eckb-wizard-single-text',
					) ),
				'3' => $form->text( $eprf_specs['rating_stars_text_4'] + array(
						'value'             => $eprf_config['rating_stars_text_4'],
						'input_group_class' => 'eckb-wizard-single-text',
					) ),
				'4' => $form->text( $eprf_specs['rating_stars_text_5'] + array(
						'value'             => $eprf_config['rating_stars_text_5'],
						'input_group_class' => 'eckb-wizard-single-text',
					) ),
			)
		));
		
		$form->option_group_wizard( $eprf_specs, array(
			'option-heading'    => 'Rating: Like Mode',
			'class'             => 'eckb-wizard-texts eckb-wizard-accordion__body',
			'depends'         => array(
							'show_when' => array(
								'rating_mode' => 'eprf-rating-mode-like-dislike',
								'rating_like_style' => 'rating_like_style_4'
							)
						),
			'inputs'            => array(
				'0' => $form->text( $eprf_specs['rating_like_style_yes_button'] + array(
						'value'             => $eprf_config['rating_like_style_yes_button'],
						'input_group_class' => 'eckb-wizard-single-text',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eprf-rate-like .epkbfa',
						)
					) ),
				'1' => $form->text( $eprf_specs['rating_like_style_no_button'] + array(
						'value'             => $eprf_config['rating_like_style_no_button'],
						'input_group_class' => 'eckb-wizard-single-text',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eprf-rate-dislike .epkbfa',
						)
					) )
			)
		));
		
		$form->option_group_wizard( $eprf_specs, array(
			'option-heading'    => 'Rating: Feedback',
			'class'             => 'eckb-wizard-texts eckb-wizard-accordion__body',
			'inputs'            => array(
				'0' => $form->text( $eprf_specs['rating_feedback_title'] + array(
						'value'             => $eprf_config['rating_feedback_title'],
						'input_group_class' => 'eckb-wizard-single-text',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eprf-article-feedback__title h5',
							'text' => '1',
						)
					) ),
				'1' => $form->text( $eprf_specs['rating_feedback_description'] + array(
						'value'             => $eprf_config['rating_feedback_description'],
						'input_group_class' => 'eckb-wizard-single-text',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '#eprf-form-text',
							'target_attr' => 'placeholder',
						)
					) ),
				'2' => $form->text( $eprf_specs['rating_feedback_support_link_text'] + array(
						'value'             => $eprf_config['rating_feedback_support_link_text'],
						'input_group_class' => 'eckb-wizard-single-text',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eprf-article-feedback__support-link a',
							'text' => '1',
						)
					) ),
				'3' => $form->text( $eprf_specs['rating_feedback_support_link_url'] + array(
						'value'             => $eprf_config['rating_feedback_support_link_url'],
						'input_group_class' => 'eckb-wizard-single-text',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eprf-article-feedback__support-link a',
							'target_attr' => 'href',
						)
					) ),
				'4' => $form->text( $eprf_specs['rating_feedback_button_text'] + array(
						'value'             => $eprf_config['rating_feedback_button_text'],
						'input_group_class' => 'eckb-wizard-single-text',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eprf-article-feedback__submit button',
							'text' => '1',
							'target_attr' => 'data-submit_text',
						)
					) ),
			)
		));
		$form->option_group_wizard( $eprf_specs, array(
			'option-heading'    => 'Rating: Other',
			'class'             => 'eckb-wizard-texts eckb-wizard-accordion__body',
			'inputs'            => array(
				'0' => $form->text( $eprf_specs['rating_stars_text'] + array(
						'value'             => $eprf_config['rating_stars_text'],
						'input_group_class' => 'eckb-wizard-single-text',
						'data' => array()
					) ),
				'1' => $form->text( $eprf_specs['rating_out_of_stars_text'] + array(
						'value'             => $eprf_config['rating_out_of_stars_text'],
						'input_group_class' => 'eckb-wizard-single-text',
						'data' => array()
					) ),
			)
		));
	}
}