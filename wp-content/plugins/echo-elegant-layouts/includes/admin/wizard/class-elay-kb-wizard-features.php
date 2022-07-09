<?php  if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Store Wizard feature data
 *
 * @copyright   Copyright (C) 2018, Echo Plugins
 * @license http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */
class ELAY_KB_Wizard_Features {

	public static function register_features_wizard_hooks() {
		add_action( ELAY_KB_Core::ELAY_FEATURES_WIZARD_MAIN_PAGE_FEATURES, array('ELAY_KB_Wizard_Features', 'add_main_page_features') );
		add_action( ELAY_KB_Core::ELAY_FEATURES_WIZARD_ARTICLE_PAGE_FEATURES, array('ELAY_KB_Wizard_Features', 'add_article_page_features'), 10, 2 );
	}

	/**
	 * Add text inputs to Wizard Text Main Page
	 * @param $kb_id
	 */
	public static function add_main_page_features ( $kb_id ) {
		$form = new ELAY_KB_Config_Elements();
		$elay_specs = ELAY_KB_Config_Specs::get_fields_specification();
		$elay_config = elay_get_instance()->kb_config_obj->get_kb_config( $kb_id );
		
		// GRID SETUP
		$form->option_group_wizard( $elay_specs, array(
			'option-heading' => __( 'Grid Setup', 'echo-elegant-layouts'),
			'class'        => 'eckb-wizard-features eckb-wizard-accordion__body',
			'depends'         => array(
				'show_when' => array(
					'kb_main_page_layout' => 'Grid',
				)
			),
			'inputs' => array(
				'1' => $form->radio_buttons_horizontal( $elay_specs['grid_nof_columns'] + array(
						'id'        => 'front-end-columns',
						'value'     => $elay_config['grid_nof_columns'],
						'current'   => $elay_config['grid_nof_columns'],
						'input_group_class' => 'eckb-wizard-single-radio',
						'main_label_class'  => 'config-col-5',
						'input_class'       => 'config-col-6',
						'radio_class'       => 'config-col-3',
						'data' => array(
							'preview' => 1
						)
					) ),
			)
		));

		// GRID CATEGORIES
		//Arg1 / Arg2  for text_and_select_fields_horizontal
		$arg1 = $elay_specs['grid_section_body_height'] +    array(
				'value' => $elay_config['grid_section_body_height'],
				'current' => $elay_config['grid_section_body_height'],
				'input_group_class' => 'config-col-6',
				'input_class'       => 'config-col-12',
				'data' => array(
					'preview' => 1
				)
			);
		$arg2 = $elay_specs['grid_section_box_height_mode'] +    array(
				'value'    => $elay_config['grid_section_box_height_mode'],
				'current'  => $elay_config['grid_section_box_height_mode'],
				'input_group_class' => 'config-col-6',
				'input_class' => 'config-col-12',
				'data' => array(
					'preview' => 1
				)
			);
		$form->option_group_wizard( $elay_specs, array(
			'option-heading' => __( 'Grid Categories', 'echo-elegant-layouts'),
			'class'        => 'eckb-wizard-features eckb-wizard-accordion__body',
			'depends'         => array(
				'show_when' => array(
					'kb_main_page_layout' => 'Grid',
				)
			),
			'inputs' => array(
				'1' => $form->checkbox( $elay_specs['grid_section_desc_text_on'] + array(
						'value'             => $elay_config['grid_section_desc_text_on'],
						'input_group_class' => 'eckb-wizard-single-checkbox',
						'label_class'       => 'config-col-5',
						'input_class' => 'config-col-2',
						'data' => array(
							'preview' => 1
						)
					) ),
				'2' => $form->checkbox( $elay_specs['grid_section_article_count'] + array(
						'value'             => $elay_config['grid_section_article_count'],
						'input_group_class' => 'eckb-wizard-single-checkbox',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-2',
						'data' => array(
							'preview' => 1
						)
					) ),
				'3' => $form->dropdown( $elay_specs['grid_category_icon_location'] + array(
						'value' => $elay_config['grid_category_icon_location'],
						'current' => $elay_config['grid_category_icon_location'],
						'input_group_class' => 'eckb-wizard-single-dropdown',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-6',
						'data' => array(
							'preview' => 1
						)
					)),
				'4' => $form->text( $elay_specs['grid_section_icon_size'] + array(
						'value'             => $elay_config['grid_section_icon_size'],
						'input_group_class' => 'eckb-wizard-single-text',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-2',
						'data' => array(
							'target_selector' => '#epkb-wsb-step-1-panel .elay-icon-elem',
							'style_name' => 'font-size',
							'postfix' => 'px'
						)
					) ),
				'5' => $form->dropdown( $elay_specs['grid_category_icon_thickness'] + array(
						'value'             => $elay_config['grid_category_icon_thickness'],
						'current' => $elay_config['grid_category_icon_thickness'],
						'input_group_class' => 'eckb-wizard-single-dropdown',
						'label_class'       => 'config-col-3',
						'input_class'       => 'config-col-7',
						'data' => array(
							'preview' => 1
						)
					) ),
				
				'6' => $form->dropdown( $elay_specs['grid_section_head_alignment'] + array(
						'value' => $elay_config['grid_section_head_alignment'],
						'current' => $elay_config['grid_section_head_alignment'],
						'input_group_class' => 'eckb-wizard-single-dropdown',
						'label_class'       => 'config-col-3',
						'input_class'       => 'config-col-7',
						'data' => array(
							'preview' => 1
						)
					) ),
				'7' => $form->dropdown( $elay_specs['grid_section_body_alignment'] + array(
						'value' => $elay_config['grid_section_body_alignment'],
						'current' => $elay_config['grid_section_body_alignment'],
						'input_group_class' => 'eckb-wizard-single-dropdown',
						'label_class'       => 'config-col-3',
						'input_class'       => 'config-col-7',
						'data' => array(
							'preview' => 1
						)
						) ),
				'8' => $form->text_and_select_fields_horizontal( array(
					'id'                => 'box_height',
					'input_group_class' => 'eckb-wizard-miltiple-select-text',
					'main_label_class'  => 'config-col-5',
					'label'             => __( 'Category Box Height', 'echo-elegant-layouts'),
					'input_class'       => 'config-col-6',
				), $arg1, $arg2 ),
			)
		));

	}

	/**
	 * Add text inputs to Wizard Features Article Page
	 *
	 * @param $kb_id
	 * @param $kb_config
	 *
	 * @noinspection PhpUnusedParameterInspection*/
	public static function add_article_page_features ( $kb_id, $kb_config ) {
		$form = new ELAY_KB_Config_Elements();
		$elay_specs = ELAY_KB_Config_Specs::get_fields_specification();
		$elay_config = elay_get_instance()->kb_config_obj->get_kb_config( $kb_id );

		// SIDEBAR layout

		// SIDEBAR CONTENT - Style
		$sidebar_height_arg1 = $elay_specs['sidebar_side_bar_height'] +  array( 'value' => $elay_config['sidebar_side_bar_height'], 'current' => $elay_config['sidebar_side_bar_height'], 'input_group_class' => 'config-col-6', 'input_class' => 'config-col-12',
						'data' => array(
							'preview' => 1
						) );
		$sidebar_height_arg2 = $elay_specs['sidebar_side_bar_height_mode'] + array( 'value'    => $elay_config['sidebar_side_bar_height_mode'], 'current'  => $elay_config['sidebar_side_bar_height_mode'], 'input_group_class' => 'config-col-6', 'input_class' => 'config-col-12',
						'data' => array(
							'preview' => 1
						) );
		//Arg1 / Arg2  for text_and_select_fields_horizontal
		$arg10 = $elay_specs['sidebar_section_body_height'] + array( 'value' => $elay_config['sidebar_section_body_height'], 'current' => $elay_config['sidebar_section_body_height'], 'input_group_class' => 'config-col-6', 'input_class' => 'config-col-12',
						'data' => array(
							'preview' => 1
						) );
		$arg20 = $elay_specs['sidebar_section_box_height_mode'] + array( 'value' => $elay_config['sidebar_section_box_height_mode'], 'current'  => $elay_config['sidebar_section_box_height_mode'], 'input_group_class' => 'config-col-6', 'input_class' => 'config-col-12',
						'data' => array(
							'preview' => 1
						) );
		
		
		$sidebar_side_bar_width = '';
		
		if ( ! ELAY_KB_Core::is_article_structure_v2( $kb_config ) ) {
			$sidebar_side_bar_width = $form->text( $elay_specs['sidebar_side_bar_width'] + array(
						'value' => $elay_config['sidebar_side_bar_width'],
						'current' => $elay_config['sidebar_side_bar_width'],
						'input_group_class' => 'eckb-wizard-single-text',
						'main_label_class'  => 'config-col-3',
						'label_class' => 'config-col-5',
						'input_class' => 'config-col-4',
						'data' => array(
							'preview' => 1
						)
					) );
		}
		
		$form->option_group_wizard( $elay_specs, array(
			'option-heading' => __( 'Elegant Layout - Sidebar', 'echo-elegant-layouts'),
			'class'        => 'eckb-wizard-features eckb-wizard-accordion__body',
			'depends'         => array(
				'show_when' => array(
					'kb_article_page_layout' => 'Sidebar',
				)
			),
			'inputs' => array(
				'0' => $sidebar_side_bar_width,
				'1' => $form->text_and_select_fields_horizontal( array(
						'id'                => 'sidebar_height',
						'input_group_class' => 'eckb-wizard-miltiple-select-text',
						'main_label_class'  => 'config-col-5',
						'label'             => __( 'Overall Sidebar Height', 'echo-elegant-layouts'),
						'input_class'       => 'config-col-8',
					)
					, $sidebar_height_arg1, $sidebar_height_arg2 ),
				'2' => $form->dropdown( $elay_specs['sidebar_scroll_bar'] + array(
						'value' => $elay_config['sidebar_scroll_bar'],
						'current' => $elay_config['sidebar_scroll_bar'],
						'input_group_class' => 'eckb-wizard-single-dropdown',
						'label_class' => 'config-col-5',
						'input_class' => 'config-col-4',
						'data' => array(
							'preview' => 1
						)
					) ),
				'4' => $form->text( $elay_specs['sidebar_nof_articles_displayed'] + array(
						'value' => $elay_config['sidebar_nof_articles_displayed'],
						'input_group_class' => 'eckb-wizard-single-text',
						'label_class' => 'config-col-5',
						'input_class' => 'config-col-2',
						'data' => array(
							'preview' => 1
						)
					) ),
				'6' => $form->dropdown( $elay_specs['sidebar_expand_articles_icon'] + array(
						'value' => $elay_config['sidebar_expand_articles_icon'],
						'current' => $elay_config['sidebar_expand_articles_icon'],
						'input_group_class' => 'eckb-wizard-single-dropdown',
						'label_class' => 'config-col-5',
						'input_class' => 'config-col-4',
						'data' => array(
							'preview' => 1
						)
					) ),
				'7' => $form->text_and_select_fields_horizontal( array(
					'id'                => 'list_height',
					'input_group_class' => 'eckb-wizard-miltiple-select-text',
					'main_label_class'  => 'config-col-5',
					'label'             => __( 'List Height of Articles', 'echo-elegant-layouts'),
					'input_class'       => 'config-col-6',
				), $arg10, $arg20 )
			)));

		// CATEGORIES - Style
		$form->option_group_wizard( $elay_specs, array(
			'option-heading' => __( 'Elegant Layout - Sidebar Categories', 'echo-elegant-layouts'),
			'class'        => 'eckb-wizard-features eckb-wizard-accordion__body',
			'depends'         => array(
				'show_when' => array(
					'kb_article_page_layout' => 'Sidebar',
				)
			),
			'inputs' => array(
				'0' => $form->checkbox( $elay_specs['sidebar_top_categories_collapsed'] + array(
						'value'             => $elay_config['sidebar_top_categories_collapsed'],
						'input_group_class' => 'eckb-wizard-single-checkbox',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-2',
						'data' => array(
							'preview' => 1
						)
					) ),
				'1' => $form->checkbox( $elay_specs['sidebar_section_desc_text_on'] + array(
						'value'             => $elay_config['sidebar_section_desc_text_on'],
						'input_group_class' => 'eckb-wizard-single-checkbox',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-2',
						'data' => array(
							'preview' => 1
						)
					) ),
				'2' => $form->dropdown( $elay_specs['sidebar_section_head_alignment'] + array(
						'value' => $elay_config['sidebar_section_head_alignment'],
						'current' => $elay_config['sidebar_section_head_alignment'],
						'input_group_class' => 'eckb-wizard-single-dropdown',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-3',
						'data' => array(
							'preview' => 1
						)
					) ),
				'3' => $form->checkbox( $elay_specs['sidebar_section_divider'] + array(
						'value'             => $elay_config['sidebar_section_divider'],
						'input_group_class' => 'eckb-wizard-single-checkbox',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-2',
						'data' => array(
							'preview' => 1
						)
					) ),
				'4' => $form->text( $elay_specs['sidebar_section_divider_thickness'] + array(
						'value'             => $elay_config['sidebar_section_divider_thickness'],
						'input_group_class' => 'eckb-wizard-single-text',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-2',
						'data' => array(
							'target_selector' => '#epkb-wsb-step-2-panel .elay_section_heading',
							'style_name' => 'border-width',
							'postfix' => 'px'
						)
					) ),
			)
		));

	}
}