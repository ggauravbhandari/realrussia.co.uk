<?php  if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Store Wizard search data
 *
 * @copyright   Copyright (C) 2020, Echo Plugins
 * @license http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */
class WIDG_KB_Wizard_Features {

	public static function register_features_wizard_hooks() {
		add_action( WIDG_KB_Core::WIDG_FEATURES_WIZARD_ARTICLE_PAGE_FEATURES, array('WIDG_KB_Wizard_Features', 'add_article_page_features'), 10, 2 );
	}

	/**
	 * Add text inputs to Wizard Text Article Page
	 *
	 * @param $kb_id
	 * @param $kb_config
	 */
	public static function add_article_page_features ( $kb_id, $kb_config=array() ) {

		// OLD KB Core hook does not send KB Config
		if ( empty($kb_config) ) {
			$kb_config = WIDG_KB_Core::get_kb_config_or_default( $kb_id );
		}
		
		$form = new WIDG_KB_Config_Elements();
		
		$widg_specs = WIDG_KB_Config_Specs::get_fields_specification();
		$widg_config = widg_get_instance()->kb_config_obj->get_kb_config( $kb_id );
		
		// old KB Sidebar is incompatible with v2 article structure
		if ( WIDG_KB_Core::is_article_structure_v2( $kb_config ) ) {
			return;
		}
		
		// Search Title ---------------------------------------------------/
		$form->option_group_wizard( $widg_specs, array(
			'option-heading' => __( 'Widgets Bar', 'echo-widgets' ),
			'class'             => 'eckb-wizard-features eckb-wizard-accordion__body',
			'depends'        => array(
				'hide_when' => array(
					'article-structure-version' => 'version-2',
					'kb_main_page_layout' => 'Categories'
				)
			),
			'inputs' => array(
				'0' => $form->radio_buttons_horizontal( $widg_specs['widgets_sidebar_location'] + array(
						'value' => $widg_config['widgets_sidebar_location'],
						'current' => $widg_config['widgets_sidebar_location'],
						'input_group_class' => 'eckb-wizard-single-radio',
						'main_label_class'  => 'config-col-5',
						'input_class'       => 'config-col-6',
						'radio_class'       => 'config-col-3',
						'data' => array(
							'preview' => 1
						)
					)),
				'1' => '<div class="config-input-group epkb-wizard-info-item"><a href="' . admin_url( 'widgets.php' ) . '" target="_blank">' . esc_html__( 'Configure KB Sidebar', 'echo-widgets' ) . '</a></div>'
			)
		));

	}
	
	/*
	 * Turn on artile page in all templates for the search wizard 
	 */
	public static function show_article_step_filter( $show ) {
		return true;
	}

}