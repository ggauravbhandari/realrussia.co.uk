<?php  if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Store Wizard theme data
 *
 * @copyright   Copyright (C) 2018, Echo Plugins
 * @license http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */
class EPRF_KB_Wizard_Features {

	public static function register_features_wizard_hooks() {

		// Features WIZARD hooks
		add_action( EPRF_KB_Core::EPRF_FEATURES_WIZARD_ARTICLE_PAGE_FEATURES, array('EPRF_KB_Wizard_Features', 'add_article_page_features'), 10, 2 );
	}

	/**
	 * Add color pickers to Wizard Article Page
	 *
	 * @param $kb_id
	 * @param $kb_config
	 *
	 * @noinspection PhpUnusedParameterInspection*/
	public static function add_article_page_features ( $kb_id, $kb_config ) {
		$form = new EPRF_KB_Config_Elements();

		$eprf_specs = EPRF_KB_Config_Specs::get_fields_specification();
		$eprf_config = eprf_get_instance()->kb_config_obj->get_kb_config( $kb_id );
		
		
		$form->option_group_wizard( $eprf_specs, array(
			'option-heading'    => 'Rating: General',
			'class'             => 'eckb-wizard-features eckb-wizard-accordion__body',
			'inputs'            => array(
				'0' => $form->checkbox( $eprf_specs['rating_switch_off'] + array(
						'value'             => $eprf_config['rating_switch_off'],
						'input_group_class' => 'eckb-wizard-single-checkbox',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-5',
						'data' => array(
							'preview' => 1,
						)
					) ),
				'1' => $form->dropdown( $eprf_specs['rating_mode'] + array(
						'value' => $eprf_config['rating_mode'],
						'current' => $eprf_config['rating_mode'],
						'input_group_class' => 'eckb-wizard-single-dropdown',
						'label_class' => 'config-col-5',
						'input_class' => 'config-col-4',
						'data' => array(
							'preview' => 1
						)
					) ),
				'2' => $form->radio_buttons_vertical( $eprf_specs['rating_layout'] + array(
						'value'     => $eprf_config['rating_layout'],
						'current'   => $eprf_config['rating_layout'],
						'input_group_class' => 'eckb-wizard-radio-btn-vertical',
						'main_label_class'  => 'config-col-5',
						'input_class'       => 'config-col-7',
						'radio_class'       => 'config-col-12',
						'data' => array(
							'preview' => 1
						)
					) ),
				'5' => $form->checkbox( $eprf_specs['rating_feedback_name_prompt'] + array(
						'value'             => $eprf_config['rating_feedback_name_prompt'],
						'input_group_class' => 'eckb-wizard-single-checkbox',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-5',
						'data' => array(
							'preview' => 1,
						)
					) ),
				'6' => $form->checkbox( $eprf_specs['rating_feedback_email_prompt'] + array(
						'value'             => $eprf_config['rating_feedback_email_prompt'],
						'input_group_class' => 'eckb-wizard-single-checkbox',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-5',
						'data' => array(
							'preview' => 1,
						)
					) ),
			)
		));
		
		$form->option_group_wizard( $eprf_specs, array(
			'option-heading'    => 'Rating: Stars Mode',
			'class'             => 'eckb-wizard-features eckb-wizard-accordion__body',
			'depends'         => array(
				'show_when' => array(
					'rating_mode' => 'eprf-rating-mode-five-stars'
				)
			),
			'inputs'            => array(
				'0' => $form->dropdown( $eprf_specs['rating_feedback_trigger_stars'] + array(
						'value' => $eprf_config['rating_feedback_trigger_stars'],
						'current' => $eprf_config['rating_feedback_trigger_stars'],
						'input_group_class' => 'eckb-wizard-single-dropdown',
						'label_class' => 'config-col-5',
						'input_class' => 'config-col-4',
						'data' => array(
							'preview' => 1
						)
					) ),
			)
		));
		
		$form->option_group_wizard( $eprf_specs, array(
			'option-heading'    => 'Rating: Like Mode',
			'class'             => 'eckb-wizard-features eckb-wizard-accordion__body',
			'depends'         => array(
				'show_when' => array(
					'rating_mode' => 'eprf-rating-mode-like-dislike'
				)
			),
			'inputs'            => array(
				'0' => $form->radio_buttons_vertical( $eprf_specs['rating_like_style'] + array(
						'value'     => $eprf_config['rating_like_style'],
						'current'   => $eprf_config['rating_like_style'],
						'input_group_class' => 'eckb-wizard-radio-btn-vertical',
						'main_label_class'  => 'config-col-5',
						'input_class'       => 'config-col-7',
						'radio_class'       => 'config-col-12',
						'data' => array(
							'preview' => 1
						)
					) ),
				'1' => $form->dropdown( $eprf_specs['rating_feedback_trigger_like'] + array(
						'value' => $eprf_config['rating_feedback_trigger_like'],
						'current' => $eprf_config['rating_feedback_trigger_like'],
						'input_group_class' => 'eckb-wizard-single-dropdown',
						'label_class' => 'config-col-5',
						'input_class' => 'config-col-4',
						'data' => array(
							'preview' => 1
						)
					) ),
			)
		));
		
	}
}