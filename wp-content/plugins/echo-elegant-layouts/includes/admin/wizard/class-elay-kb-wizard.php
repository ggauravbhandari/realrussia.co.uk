<?php  if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Store Wizard theme data
 * @copyright   Copyright (C) 2018, Echo Plugins
 * @license http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */
class ELAY_KB_Wizard {

	public static function register_all_wizard_hooks() {

		// global hooks
		add_filter( ELAY_KB_Core::ELAY_ALL_WIZARDS_CONFIGURATION_DEFAULTS, array('ELAY_KB_Wizard', 'get_configuration_defaults') );
		add_filter( ELAY_KB_Core::ELAY_ALL_WIZARDS_GET_CURRENT_CONFIG, array('ELAY_KB_Wizard', 'get_current_config' ), 10, 2 );

		// THEME WIZARD hooks
		add_action( ELAY_KB_Core::ELAY_THEME_WIZARD_MAIN_PAGE_COLORS, array('ELAY_KB_Wizard', 'get_main_page_colors' ) );
		add_action( ELAY_KB_Core::ELAY_THEME_WIZARD_ARTICLE_PAGE_COLORS, array('ELAY_KB_Wizard', 'get_article_page_colors' ) );
		add_filter( ELAY_KB_Core::ELAY_THEME_WIZARD_GET_COLOR_PRESETS, array('ELAY_KB_Wizard', 'get_color_presets' ), 10, 2 );

		// TEXT WIZARD hooks
		ELAY_KB_Wizard_Text::register_text_wizard_hooks();

		// FEATURES WIZARD hooks
		ELAY_KB_Wizard_Features::register_features_wizard_hooks();
	}

	/**
	 * Returnt to Wizard the current KB configuration
	 *
	 * @param $kb_config
	 * @param $kb_id
	 * @return array
	 */
	public static function get_current_config( $kb_config, $kb_id ) {
		$elay_config = elay_get_instance()->kb_config_obj->get_kb_config( $kb_id );
		return array_merge( $kb_config, $elay_config );
	}

	/**
	 * Return add-on configuration defaults.
	 *
	 * @param $template_defaults
	 * @return array
	 */
	public static function get_configuration_defaults( $template_defaults ) {
		$kb_elay_defaults = ELAY_KB_Config_Specs::get_default_kb_config();
		return array_merge($template_defaults, $kb_elay_defaults);
	}

	/**
	 * Add color pickers to Wizard Main Page
	 * @param $kb_id
	 */
	public static function get_main_page_colors ( $kb_id ) {
		$form = new ELAY_KB_Config_Elements();
		$elay_specs = ELAY_KB_Config_Specs::get_fields_specification();
		$elay_config = elay_get_instance()->kb_config_obj->get_kb_config( $kb_id );
		
		// GRID layout 
			
		// change input names
		$elay_specs['grid_section_head_font_color']['label'] = __( 'Category Name', 'echo-elegant-layouts' );
		$elay_specs['grid_section_body_text_color']['label'] = __( 'Article Counter', 'echo-elegant-layouts' );
		$elay_specs['grid_section_border_color']['label'] = __( 'Panel Border', 'echo-elegant-layouts' );
		$elay_specs['grid_section_head_background_color']['label'] = __( 'Panel Top Background', 'echo-elegant-layouts' );
		$elay_specs['grid_section_body_background_color']['label'] = __( 'Panel Bottom Background', 'echo-elegant-layouts' );
		
		// GRID SEARCH BOX
		$grid_arg1_input_text_field = $elay_specs['grid_search_text_input_background_color'] + array( 
			'value' => $elay_config['grid_search_text_input_background_color'], 
			'current' => $elay_config['grid_search_text_input_background_color'], 
			'class' => 'ekb-color-picker', 
			'text_class' => 'eckb-wizard-single-color',
			'data' => array(
				'wizard_input' => '1',
				'target_selector' => '.eckb-wizard-step-3 .elay-grid-template .elay-search-box input[type=text]',
				'style_name' => 'background'
			)
		);
			
		$grid_arg2_input_text_field = $elay_specs['grid_search_text_input_border_color']     + array( 
			'value' => $elay_config['grid_search_text_input_border_color'], 
			'current' => $elay_config['grid_search_text_input_border_color'], 
			'class' => 'ekb-color-picker', 
			'text_class' => 'eckb-wizard-single-color',
			'data' => array(
				'wizard_input' => '1',
				'target_selector' => '.eckb-wizard-step-3 .elay-grid-template .elay-search-box input[type=text]',
				'style_name' => 'border-color'
			)
		);

		$grid_arg1_button = $elay_specs['grid_search_btn_background_color']  + array( 
			'value' => $elay_config['grid_search_btn_background_color'],
			'current' => $elay_config['grid_search_btn_background_color'], 
			'class' => 'ekb-color-picker', 
			'text_class' => 'eckb-wizard-single-color',
			'data' => array(
				'wizard_input' => '1',
				'target_selector' => '.eckb-wizard-step-3 .elay-grid-template .elay-search-box button',
				'style_name' => 'background'
			)
		);
			
		$grid_arg2_button = $elay_specs['grid_search_btn_border_color'] + array( 
			'value' => $elay_config['grid_search_btn_border_color'],
			'current' => $elay_config['grid_search_btn_border_color'],
			'class' => 'ekb-color-picker', 
			'text_class' => 'eckb-wizard-single-color',
			'data' => array(
				'wizard_input' => '1',
				'target_selector' => '.eckb-wizard-step-3 .elay-grid-template .elay-search-box button',
				'style_name' => 'border-color'
			)
		);

		// GRID SEARCH BOX COLORS
		$form->option_group_wizard( $elay_specs, array(
			'option-heading'    => __('Grid Search Box', 'echo-elegant-layouts'),
			'class'             => 'eckb-wizard-colors eckb-wizard-accordion__body',
			'depends'        => array(
				'show_when' => array(
					'kb_main_page_layout' => 'Grid'
				),
				'hide_when' => array(
					'advanced_search_mp_show_top_category' => 'on|off',  // true if Advanced Search is enabled
				)
			),
			'inputs'            => array (
				'0' => $form->text( $elay_specs['grid_search_title_font_color'] + array(
						'value'             => $elay_config['grid_search_title_font_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .elay-grid-template .elay-doc-search-container>h2',
							'style_name' => 'color'
						)
					) ),
				'1' => $form->text( $elay_specs['grid_search_background_color'] + array(
						'value'             => $elay_config['grid_search_background_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .elay-grid-template .elay-doc-search-container',
							'style_name' => 'background-color'
						)
					) ),
				'2' => $form->text_fields_horizontal( array(
					'id'                => 'input_text_field',
					'input_class'       => 'ekb-color-picker',
					'label'             => __( 'Input Text Field', 'echo-elegant-layouts' ),
					'input_group_class' => 'ep'.'kb-wizard-dual-color',
				), $grid_arg1_input_text_field, $grid_arg2_input_text_field ),
				'3' => $form->text_fields_horizontal( array(
					'id'                => 'button',
					'input_class'       => 'ekb-color-picker',
					'label'             => __( 'Search Button', 'echo-elegant-layouts' ),
					'input_group_class' => 'ep'.'kb-wizard-dual-color',
				), $grid_arg1_button, $grid_arg2_button ),
			)
		));

		// GRID COLORS
		$form->option_group_wizard( $elay_specs, array(
			'option-heading'    => __( 'Grid Colors', 'echo-elegant-layouts' ),
			'class'             => 'eckb-wizard-colors eckb-wizard-accordion__body elay-grid',
			'depends'          => array(
				'show_when' => array(
					'kb_main_page_layout' => 'Grid'
				)
			),
			'inputs'            => array(
				'1' => $form->text( $elay_specs['grid_section_head_icon_color'] + array(
						'value'             => $elay_config['grid_section_head_icon_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color ',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .elay-grid-template  .elay-icon-elem',
							'style_name' => 'color'
						)
					) ),
				'2' => $form->text( $elay_specs['grid_section_head_font_color'] + array(
						'value'             => $elay_config['grid_section_head_font_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color ',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .elay-grid-template .elay-grid-category-name',
							'style_name' => 'color'
						)
					) ),
				'3' => $form->text( $elay_specs['grid_section_head_description_font_color'] + array(
						'value'             => $elay_config['grid_section_head_description_font_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color ',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .elay-grid-category-desc',
							'style_name' => 'color'
						)
					) ),
				'4' => $form->text( $elay_specs['grid_section_divider_color'] + array(
						'value'             => $elay_config['grid_section_divider_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color ',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .elay-grid-template .section-head',
							'style_name' => 'border-bottom-color'
						)
					) ),
				'5' => $form->text( $elay_specs['grid_section_body_text_color'] + array(
						'value'             => $elay_config['grid_section_body_text_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color ',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .elay-grid-template .elay-top-category-box',
							'style_name' => 'color'
						)
					) ),
				'6' => $form->text( $elay_specs['grid_section_border_color'] + array(
						'value'             => $elay_config['grid_section_border_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color ',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .elay-grid-template .elay-top-category-box',
							'style_name' => 'border-color'
						)
					) ),
				'7' => $form->text( $elay_specs['grid_section_head_background_color'] + array(
						'value'             => $elay_config['grid_section_head_background_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color ',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .elay-grid-template .section-head',
							'style_name' => 'background-color'
						)
					) ),
				'8' => $form->text( $elay_specs['grid_section_body_background_color'] + array(
						'value'             => $elay_config['grid_section_body_background_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color ',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .elay-grid-template .elay-top-category-box',
							'style_name' => 'background-color'
						)
					) ),
				'9' => $form->text( $elay_specs['grid_background_color'] + array(
						'value'             => $elay_config['grid_background_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color ',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .elay-grid-template #elay-content-container',
							'style_name' => 'background-color'
						)
					) ),
			)
		));
		
	}

	/**
	 * Add color pickers to Wizard Article Page
	 * @param $kb_id
	 */
	public static function get_article_page_colors ( $kb_id ) {
		$form = new ELAY_KB_Config_Elements();
		$elay_specs = ELAY_KB_Config_Specs::get_fields_specification();
		$elay_config = elay_get_instance()->kb_config_obj->get_kb_config( $kb_id );

		// SIDEBAR layout

		// rename default labels because we have no info button
		$elay_specs['sidebar_background_color']['label'] = __( 'Sidebar Background', 'echo-elegant-layouts' );
		$elay_specs['sidebar_section_head_font_color']['label'] = __( 'Category Text', 'echo-elegant-layouts' );
		$elay_specs['sidebar_section_head_background_color']['label'] = __( 'Category Background', 'echo-elegant-layouts' );
		$elay_specs['sidebar_section_category_icon_color']['label'] = __( 'Subcategory Icon', 'echo-elegant-layouts' );
		$elay_specs['sidebar_section_category_font_color']['label'] = __( 'Subcategory Title', 'echo-elegant-layouts' );
		$elay_specs['sidebar_article_icon_color']['label'] = __( 'Article Icon', 'echo-elegant-layouts' );
		$elay_specs['sidebar_article_font_color']['label'] = __( 'Article', 'echo-elegant-layouts' );
		$elay_specs['sidebar_article_active_font_color']['label'] = __( 'Active Article', 'echo-elegant-layouts' );
		$elay_specs['sidebar_article_active_background_color']['label'] = __( 'Active Article background', 'echo-elegant-layouts' );

		// SIDEBAR COLORS
		$form->option_group_wizard( $elay_specs, array(
			'option-heading'    => __( 'Sidebar Colors', 'echo-elegant-layouts' ),
			'class'             => 'eckb-wizard-colors eckb-wizard-accordion__body elay-sidebar',
			'depends'          => array(
				'hide_when' => array(
					'kb_main_page_layout' => 'Categories',
				)
			),
			'inputs'            => array(
				'0' => $form->text( $elay_specs['sidebar_background_color'] + array(
						'value'             => $elay_config['sidebar_background_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color ',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .elay-sidebar-template .elay-sidebar, .eckb-wizard-step-4 .elay-sidebar-template .elay-sidebar, .eckb-wizard-step-3 #elay-sidebar-container-v2, .eckb-wizard-step-4 #elay-sidebar-container-v2',
							'style_name' => 'background-color'
						)
					) ),
				'1' => $form->text( $elay_specs['sidebar_section_head_font_color'] + array(
						'value'             => $elay_config['sidebar_section_head_font_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color ',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .elay-sidebar-template .elay-category-level-1, 
							.eckb-wizard-step-4 .elay-sidebar-template .elay-category-level-1,
							.eckb-wizard-step-3 .elay-sidebar-template .elay-category-level-1 a, 
							.eckb-wizard-step-4 .elay-sidebar-template .elay-category-level-1 a, 
							.eckb-wizard-step-3  #elay-sidebar-container-v2 .elay-sidebar__heading__inner .elay-sidebar__heading__inner__name, 
							.eckb-wizard-step-3  #elay-sidebar-container-v2 .elay-sidebar__heading__inner .elay-sidebar__heading__inner__name>a,
							.eckb-wizard-step-4  #elay-sidebar-container-v2 .elay-sidebar__heading__inner .elay-sidebar__heading__inner__name, 
							.eckb-wizard-step-4  #elay-sidebar-container-v2 .elay-sidebar__heading__inner .elay-sidebar__heading__inner__name>a',
							'style_name' => 'color'
						)
					) ),
				'2' => $form->text( $elay_specs['sidebar_section_head_background_color'] + array(
						'value'             => $elay_config['sidebar_section_head_background_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color ',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .elay-sidebar-template .elay_section_heading,
							.eckb-wizard-step-4 .elay-sidebar-template .elay_section_heading, 
							.eckb-wizard-step-3 #elay-sidebar-container-v2 .elay-sidebar__cat__top-cat__heading-container,
							.eckb-wizard-step-4 #elay-sidebar-container-v2 .elay-sidebar__cat__top-cat__heading-container',
							'style_name' => 'background-color'
						)
					) ),
				'3' => $form->text( $elay_specs['sidebar_section_head_description_font_color'] + array(
						'value'             => $elay_config['sidebar_section_head_description_font_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color ',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .elay-sidebar-template .elay_section_heading p, .eckb-wizard-step-4 .elay-sidebar-template .elay_section_heading p, .eckb-wizard-step-3 #elay-sidebar-container-v2 .elay-sidebar__heading__inner .elay-sidebar__heading__inner__desc p, .eckb-wizard-step-4 #elay-sidebar-container-v2 .elay-sidebar__heading__inner .elay-sidebar__heading__inner__desc p',
							'style_name' => 'color',
						)
					) ),
				'4' => $form->text( $elay_specs['sidebar_section_category_icon_color'] + array(
						'value'             => $elay_config['sidebar_section_category_icon_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color ',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .elay-sidebar-template .elay-sub-category li .elay-category-level-2-3 i, .eckb-wizard-step-4 .elay-sidebar-template .elay-sub-category li .elay-category-level-2-3 i, .eckb-wizard-step-3 #elay-sidebar-container-v2 .elay_sidebar_expand_category_icon, .eckb-wizard-step-4 #elay-sidebar-container-v2 .elay_sidebar_expand_category_icon',
							'style_name' => 'color'
						)
					) ),
				'5' => $form->text( $elay_specs['sidebar_section_category_font_color'] + array(
						'value'             => $elay_config['sidebar_section_category_font_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color ',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .elay-sidebar-template .elay-sub-category li .elay-category-level-2-3 a, .eckb-wizard-step-4 .elay-sidebar-template .elay-sub-category li .elay-category-level-2-3 a, .eckb-wizard-step-3 #elay-sidebar-container-v2 .elay-category-level-2-3 a, .eckb-wizard-step-4 #elay-sidebar-container-v2 .elay-category-level-2-3 a',
							'style_name' => 'color'
						)
					) ),
				'6' => $form->text( $elay_specs['sidebar_section_divider_color'] + array(
						'value'             => $elay_config['sidebar_section_divider_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color ',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .elay-sidebar-template .elay_section_heading, .eckb-wizard-step-4 .elay-sidebar-template .elay_section_heading, .eckb-wizard-step-4 #elay-sidebar-container-v2 .elay-sidebar__cat__top-cat__heading-container,  .eckb-wizard-step-3 #elay-sidebar-container-v2 .elay-sidebar__cat__top-cat__heading-container',
							'style_name' => 'border-bottom-color'
						)
					) ),
				'7' => $form->text( $elay_specs['sidebar_article_icon_color'] + array(
						'value'             => $elay_config['sidebar_article_icon_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color ',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .elay-sidebar-template .elay-article-title i, .eckb-wizard-step-4 .elay-article-title i',
							'style_name' => 'color'
						)
					) ),
				'8' => $form->text( $elay_specs['sidebar_article_font_color'] + array(
						'value'             => $elay_config['sidebar_article_font_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color ',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .elay-sidebar-template .elay-article-title, .eckb-wizard-step-4 .elay-article-title',
							'style_name' => 'color'
						)
					) ),
				'9' => $form->text( $elay_specs['sidebar_article_active_font_color'] + array(
						'value'             => $elay_config['sidebar_article_active_font_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color ',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .elay-sidebar-template #elay-content-container .elay-articles .active span, body .eckb-wizard-step-4 .elay-sidebar-template #elay-content-container .elay-articles .active span',
							'style_name' => 'color',
						)
					) ),
				'10' => $form->text( $elay_specs['sidebar_article_active_background_color'] + array(
						'value'             => $elay_config['sidebar_article_active_background_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color ',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .elay-sidebar-template #elay-content-container .elay-articles .active, .eckb-wizard-step-4 .elay-sidebar-template #elay-content-container .elay-articles .active',
							'style_name' => 'background-color',
						)
					) ),
				'11' => $form->text( $elay_specs['sidebar_section_border_color'] + array(
						'value'             => $elay_config['sidebar_section_border_color'],
						'input_class'       => 'ekb-color-picker',
						'input_group_class' => 'eckb-wizard-single-color ',
						'data' => array(
							'wizard_input' => '1',
							'target_selector' => '.eckb-wizard-step-3 .elay-sidebar-template .elay-sidebar, .eckb-wizard-step-4 .elay-sidebar-template .elay-sidebar, .eckb-wizard-step-3 #elay-sidebar-container-v2, .eckb-wizard-step-4 #elay-sidebar-container-v2',
							'style_name' => 'border-color'
						)
					) ),
			)
		));
		
		
		// SIDEBAR layout 
		// SIDEBAR SEARCH BOX
		$sidebar_arg1_input_text_field = $elay_specs['sidebar_search_text_input_background_color'] + array( 
			'value' => $elay_config['sidebar_search_text_input_background_color'], 
			'current' => $elay_config['sidebar_search_text_input_background_color'], 
			'class' => 'ekb-color-picker', 
			'text_class' => 'eckb-wizard-single-color',
			'data' => array(
				'wizard_input' => '1',
				'target_selector' => '.eckb-wizard-step-3 .elay-sidebar-template .elay-search-box input[type=text], .eckb-wizard-step-4 .elay-sidebar-template .elay-search-box input[type=text], .eckb-wizard-step-3 #eckb-article-page-container-v2 #elay_search_terms, .eckb-wizard-step-4 #eckb-article-page-container-v2 #elay_search_terms',
				'style_name' => 'background'
			)
		);
			
		$sidebar_arg2_input_text_field = $elay_specs['sidebar_search_text_input_border_color']     + array( 
			'value' => $elay_config['sidebar_search_text_input_border_color'], 
			'current' => $elay_config['sidebar_search_text_input_border_color'], 
			'class' => 'ekb-color-picker', 
			'text_class' => 'eckb-wizard-single-color',
			'data' => array(
				'wizard_input' => '1',
				'target_selector' => '.eckb-wizard-step-3 .elay-sidebar-template .elay-search-box input[type=text], .eckb-wizard-step-4 .elay-sidebar-template .elay-search-box input[type=text], .eckb-wizard-step-3 #eckb-article-page-container-v2 #elay_search_terms, .eckb-wizard-step-4 #eckb-article-page-container-v2 #elay_search_terms',
				'style_name' => 'border-color'
			)
		);

		$sidebar_arg1_button = $elay_specs['sidebar_search_btn_background_color']  + array( 
			'value' => $elay_config['sidebar_search_btn_background_color'],
			'current' => $elay_config['sidebar_search_btn_background_color'], 
			'class' => 'ekb-color-picker', 
			'text_class' => 'eckb-wizard-single-color',
			'data' => array(
				'wizard_input' => '1',
				'target_selector' => '.eckb-wizard-step-3 .elay-sidebar-template .elay-search-box button, .eckb-wizard-step-4 .elay-sidebar-template .elay-search-box button, .eckb-wizard-step-3 #eckb-article-page-container-v2 #sidebar-elay-search-kb, .eckb-wizard-step-4 #eckb-article-page-container-v2 #sidebar-elay-search-kb',
				'style_name' => 'background'
			)
		);
			
		$sidebar_arg2_button = $elay_specs['sidebar_search_btn_border_color'] + array( 
			'value' => $elay_config['sidebar_search_btn_border_color'],
			'current' => $elay_config['sidebar_search_btn_border_color'],
			'class' => 'ekb-color-picker', 
			'text_class' => 'eckb-wizard-single-color',
			'data' => array(
				'wizard_input' => '1',
				'target_selector' => '.eckb-wizard-step-3 .elay-sidebar-template .elay-search-box button, .eckb-wizard-step-4 .elay-sidebar-template .elay-search-box button, .eckb-wizard-step-3 #eckb-article-page-container-v2 #sidebar-elay-search-kb, .eckb-wizard-step-4 #eckb-article-page-container-v2 #sidebar-elay-search-kb',
				'style_name' => 'border-color'
			)
		);


		// SIDEBAR SEARCH BOX
		$kb_config = ELAY_KB_Core::get_kb_config_or_default( $kb_id );
		if ( ( ELAY_KB_Core::is_article_structure_v2( $kb_config ) && $kb_config['kb_main_page_layout'] != 'Categories' ) ||
		     ( ! ELAY_KB_Core::is_article_structure_v2( $kb_config ) && $kb_config['kb_article_page_layout'] == 'Sidebar' )) {

			$form->option_group_wizard( $elay_specs, array(
				'option-heading' => __( 'Search Box', 'echo-elegant-layouts' ),
				'class'          => 'eckb-wizard-colors eckb-wizard-accordion__body',
				'depends'        => array(
					'hide_when' => array(
						'advanced_search_mp_show_top_category' => 'on|off',  // true if Advanced Search is enabled
						// 'kb_article_page_layout' => 'Article'  show all the time since V2 makes it more complex to filter
					),
				),
				'inputs'         => array(
					'0' => $form->text( $elay_specs['sidebar_search_title_font_color'] + array(
							'value'             => $elay_config['sidebar_search_title_font_color'],
							'input_class'       => 'ekb-color-picker',
							'input_group_class' => 'eckb-wizard-single-color',
							'data'              => array(
								'wizard_input'    => '1',
								'target_selector' => '.eckb-wizard-step-3 .elay-sidebar-template .elay-doc-search-container>h2, .eckb-wizard-step-4 .elay-sidebar-template .elay-doc-search-container>h2, .eckb-wizard-step-3 #eckb-article-page-container-v2 .elay-doc-search-title, .eckb-wizard-step-4 #eckb-article-page-container-v2 .elay-doc-search-title',
								'style_name'      => 'color'
							)
						) ),
					'1' => $form->text( $elay_specs['sidebar_search_background_color'] + array(
							'value'             => $elay_config['sidebar_search_background_color'],
							'input_class'       => 'ekb-color-picker',
							'input_group_class' => 'eckb-wizard-single-color',
							'data'              => array(
								'wizard_input'    => '1',
								'target_selector' => '.eckb-wizard-step-3 .elay-sidebar-template .elay-doc-search-container, .eckb-wizard-step-4 .elay-sidebar-template .elay-doc-search-container, .eckb-wizard-step-3 #eckb-article-page-container-v2 .elay-doc-search-container, .eckb-wizard-step-4 #eckb-article-page-container-v2 .elay-doc-search-container',
								'style_name'      => 'background-color'
							)
						) ),
					'2' => $form->text_fields_horizontal( array(
						'id'                => 'input_text_field',
						'input_class'       => 'ekb-color-picker',
						'label'             => __( 'Input Text Field', 'echo-elegant-layouts' ),
						'input_group_class' => 'ep' . 'kb-wizard-dual-color',
					), $sidebar_arg1_input_text_field, $sidebar_arg2_input_text_field ),
					'3' => $form->text_fields_horizontal( array(
						'id'                => 'button',
						'input_class'       => 'ekb-color-picker',
						'label'             => __( 'Search Button', 'echo-elegant-layouts' ),
						'input_group_class' => 'ep' . 'kb-wizard-dual-color',
					), $sidebar_arg1_button, $sidebar_arg2_button ),
				)
			) );

		}
		
	}

	/**
	 * Add presets for Grid/Sidebar
	 *
	 * @param $presets
	 * @param $preset_id
	 * @return array
	 */
	public static function get_color_presets( $presets, $preset_id ) {

		$preset_config_default = array(
			'grid_background_color'                     => '#FFFFFF',
			'grid_search_title_font_color'              => '#FFFFFF',
			'grid_search_background_color'              => '#827a74',
			'grid_search_text_input_background_color'   => '#FFFFFF',
			'grid_search_text_input_border_color'       => '#FFFFFF',
			'grid_search_btn_background_color'          => '#686868',
			'grid_search_btn_border_color'              => '#F1F1F1',
			'grid_section_head_font_color'              => '#000000',
			'grid_section_head_background_color'        => '#FFFFFF',
			'grid_section_head_description_font_color'  => '#B3B3B3',
			'grid_section_body_background_color'        => '#FFFFFF',
			'grid_section_border_color'                 => '#E1E0E0',
			'grid_section_divider_color'                => '#E1E0E0',
			'grid_section_head_icon_color'              => '#FFFFFF',
			'grid_section_body_text_color'              => '#000000',
			'sidebar_background_color'                  => '#fdfdfd',
			'sidebar_search_title_font_color'           => '#000000',
			'sidebar_search_background_color'           => '#e0e0e0',
			'sidebar_search_text_input_background_color'=> '#FFFFFF',
			'sidebar_search_text_input_border_color'    => '#FFFFFF',
			'sidebar_search_btn_background_color'       => '#686868',
			'sidebar_search_btn_border_color'           => '#F1F1F1',
			'sidebar_article_font_color'                => '#333232',
			'sidebar_article_icon_color'                => '#333232',
			'sidebar_article_active_font_color'         => '#000000',
			'sidebar_article_active_background_color'   => '#e8e8e8',
			'sidebar_section_head_font_color'           => '#000000',
			'sidebar_section_head_background_color'     => '#7d7d7d',
			'sidebar_section_head_description_font_color' => '#b3b3b3',
			'sidebar_section_border_color'              => '#7d7d7d',
			'sidebar_section_divider_color'             => '#FFFFFF',
			'sidebar_section_category_font_color'       => '#000000',
			'sidebar_section_category_icon_color'       => '#868686'
		);

		switch ( $preset_id ) {
			case 1:
				$preset_config = array(
					'grid_section_head_font_color'              => '#3a3a3a',
					'grid_section_body_text_color'              => '#3a3a3a',

					'grid_section_head_background_color'        => '#eded00',
					'grid_section_head_description_font_color'  => '#515151',
					'grid_section_head_icon_color'              => '#efc300',
					'grid_section_divider_color'                => '#515151',

					'grid_section_body_background_color'        => '#FFFFFF',
					'grid_section_border_color'                 => '#eeee22',

					'sidebar_section_head_font_color'           => '#3a3a3a',
					'sidebar_section_head_background_color'     => '#eded00',
					'sidebar_section_head_description_font_color' => '#515151',
					'sidebar_section_divider_color'             => '#515151',

					'sidebar_section_category_font_color'       => '#40474f',
					'sidebar_section_category_icon_color'       => '#efc300',
					'sidebar_section_border_color'              => '#eeee22',

					'sidebar_article_font_color'                => '#3a3a3a',
					'sidebar_article_icon_color'                => '#becc00',
				);
				break;
			// BLUE
			case 3:
				$preset_config = array(
					'grid_section_head_font_color'              => '#53ccfb',

					'grid_section_head_background_color'        => '#FFFFFF',
					'grid_section_head_description_font_color'  => '#b3b3b3',
					'grid_section_head_icon_color'              => '#868686',
					'grid_section_divider_color'                => '#c5c5c5',

					'grid_section_body_background_color'        => '#FFFFFF',
					'grid_section_border_color'                 => '#dbdbdb',

					'sidebar_section_head_font_color'           => '#53ccfb',
					'sidebar_section_head_background_color'     => '#FFFFFF',
					'sidebar_section_head_description_font_color' => '#b3b3b3',
					'sidebar_section_divider_color'             => '#c5c5c5',

					'sidebar_section_category_font_color'       => '#868686',
					'sidebar_section_category_icon_color'       => '#868686',
					'sidebar_section_border_color'              => '#dbdbdb'
				);
				break;
			case 4:
				$preset_config = array(
					'grid_section_head_font_color'              => '#333333',

					'grid_section_head_background_color'        => '#FFFFFF',
					'grid_section_head_description_font_color'  => '#515151',
					'grid_section_head_icon_color'              => '#039be5',
					'grid_section_divider_color'                => '#039be5',

					'grid_section_body_background_color'        => '#FFFFFF',
					'grid_section_border_color'                 => '#039be5',

					'sidebar_section_head_font_color'           => '#333333',
					'sidebar_section_head_background_color'     => '#039be5',
					'sidebar_section_head_description_font_color' => '#b3b3b3',
					'sidebar_section_divider_color'             => '#039be5',

					'sidebar_section_category_font_color'       => '#40474f',
					'sidebar_section_category_icon_color'       => '#039be5',
					'sidebar_section_border_color'              => '#039be5',

					'sidebar_article_font_color'                => '#333333',
					'sidebar_article_icon_color'                => '#039be5',
				);
				break;
			case 5:
				$preset_config = array(
					'grid_section_head_font_color'              => '#FFFFFF',

					'grid_section_head_background_color'        => '#4398ba',
					'grid_section_head_description_font_color'  => '#FFFFFF',
					'grid_section_head_icon_color'              => '#000000',
					'grid_section_divider_color'                => '#CDCDCD',

					'grid_section_body_background_color'        => '#f9f9f9',
					'grid_section_border_color'                 => '#F7F7F7',

					'sidebar_section_head_font_color'           => '#FFFFFF',
					'sidebar_section_head_background_color'     => '#4398ba',
					'sidebar_section_head_description_font_color' => '#FFFFFF',
					'sidebar_section_divider_color'             => '#CDCDCD',

					'sidebar_section_category_font_color'       => '#868686',
					'sidebar_section_category_icon_color'       => '#000000',
					'sidebar_section_border_color'              => '#F7F7F7',
				);
				break;
			// GREEN
			case 6:
				$preset_config = array(
					'grid_section_head_font_color'              => '#4a714e',

					'grid_section_head_background_color'        => '#FFFFFF',
					'grid_section_head_description_font_color'  => '#bfdac1',
					'grid_section_head_icon_color'              => '#a7d686',
					'grid_section_divider_color'                => '#c5c5c5',

					'grid_section_body_background_color'        => '#FFFFFF',
					'grid_section_border_color'                 => '#dbdbdb',

					'sidebar_article_font_color'                => '#333333',
					'sidebar_article_icon_color'                => '#81d742',

					'sidebar_section_head_font_color'           => '#4a714e',
					'sidebar_section_head_background_color'     => '#b6d6a9',
					'sidebar_section_head_description_font_color' => '#bfdac1',
					'sidebar_section_divider_color'             => '#c5c5c5',

					'sidebar_section_category_font_color'       => '#b1d8b4',
					'sidebar_section_category_icon_color'       => '#a7d686',
					'sidebar_section_border_color'              => '#dbdbdb'
				);
				break;
			case 7:
				$preset_config = array(
					'grid_section_head_font_color'              => '#81d742',

					'grid_section_head_background_color'        => '#fcfcfc',
					'grid_section_head_description_font_color'  => '#515151',
					'grid_section_head_icon_color'              => '#333333',
					'grid_section_divider_color'                => '#81d742',

					'grid_section_body_background_color'        => '#FFFFFF',
					'grid_section_border_color'                 => '#dddddd',

					'sidebar_section_head_font_color'           => '#81d742',
					'sidebar_section_head_background_color'     => '#fcfcfc',
					'sidebar_section_head_description_font_color' => '#515151',
					'sidebar_section_divider_color'             => '#81d742',

					'sidebar_section_category_font_color'       => '#40474f',
					'sidebar_section_category_icon_color'       => '#333333',
					'sidebar_section_border_color'              => '#dddddd'
				);
				break;
			case 8:
				$preset_config = array(
					'grid_section_head_font_color'              => '#FFFFFF',

					'grid_section_head_background_color'        => '#628365',
					'grid_section_head_description_font_color'  => '#FFFFFF',
					'grid_section_head_icon_color'              => '#FFFFFF',
					'grid_section_divider_color'                => '#c5c5c5',

					'grid_section_body_background_color'        => '#edf4ee',
					'grid_section_border_color'                 => '#dbdbdb',

					'sidebar_section_head_font_color'           => '#FFFFFF',
					'sidebar_section_head_background_color'     => '#628365',
					'sidebar_section_head_description_font_color' => '#FFFFFF',
					'sidebar_section_divider_color'             => '#c5c5c5',

					'sidebar_section_category_font_color'       => '#868686',
					'sidebar_section_category_icon_color'       => '#FFFFFF',
					'sidebar_section_border_color'              => '#dbdbdb',
				);
				break;
			// RED
			case 9:
				$preset_config = array(
					'grid_section_head_font_color'              => '#fb8787',

					'grid_section_head_background_color'        => '#FFFFFF',
					'grid_section_head_description_font_color'  => '#b3b3b3',
					'grid_section_head_icon_color'              => '#868686',
					'grid_section_divider_color'                => '#c5c5c5',

					'grid_section_body_background_color'        => '#FFFFFF',
					'grid_section_border_color'                 => '#dbdbdb',

					'sidebar_section_head_font_color'           => '#fb8787',
					'sidebar_section_head_background_color'     => '#FFFFFF',
					'sidebar_section_head_description_font_color' => '#b3b3b3',
					'sidebar_section_divider_color'             => '#c5c5c5',

					'sidebar_section_category_font_color'       => '#868686',
					'sidebar_section_category_icon_color'       => '#868686',
					'sidebar_section_border_color'              => '#dbdbdb',
				);
				break;
			case 10:
				$preset_config = array(
					'grid_section_head_font_color'              => '#CC0000',

					'grid_section_head_background_color'        => '#f9e5e5',
					'grid_section_head_description_font_color'  => '#e57f7f',
					'grid_section_head_icon_color'              => '#868686',
					'grid_section_divider_color'                => '#CDCDCD',

					'grid_section_body_background_color'        => '#FFFFFF',
					'grid_section_border_color'                 => '#F7F7F7',

					'sidebar_section_head_font_color'           => '#CC0000',
					'sidebar_section_head_background_color'     => '#f9e5e5',
					'sidebar_section_head_description_font_color' => '#e57f7f',
					'sidebar_section_divider_color'             => '#CDCDCD',

					'sidebar_section_category_font_color'       => '#868686',
					'sidebar_section_category_icon_color'       => '#868686',
					'sidebar_section_border_color'              => '#F7F7F7',
				);
				break;
			case 11:
				$preset_config = array(
					'grid_section_head_font_color'              => '#FFFFFF',

					'grid_section_head_background_color'        => '#fb6262',
					'grid_section_head_description_font_color'  => '#FFFFFF',
					'grid_section_head_icon_color'              => '#FFFFFF',
					'grid_section_divider_color'                => '#CDCDCD',

					'grid_section_body_background_color'        => '#fefcfc',
					'grid_section_border_color'                 => '#F7F7F7',

					'sidebar_section_head_font_color'           => '#FFFFFF',
					'sidebar_section_head_background_color'     => '#fb6262',
					'sidebar_section_head_description_font_color' => '#FFFFFF',
					'sidebar_section_divider_color'             => '#CDCDCD',

					'sidebar_section_category_font_color'       => '#868686',
					'sidebar_section_category_icon_color'       => '#FFFFFF',
					'sidebar_section_border_color'              => '#F7F7F7',
				);
				break;
			// GRAY
			case 12:
				$preset_config = array(
					'grid_section_head_font_color'              => '#827a74',

					'grid_section_head_background_color'        => '#FFFFFF',
					'grid_section_head_description_font_color'  => '#b3b3b3',
					'grid_section_head_icon_color'              => '#868686',
					'grid_section_divider_color'                => '#dadada',

					'grid_section_body_background_color'        => '#FFFFFF',
					'grid_section_border_color'                 => '#dbdbdb',

					'sidebar_section_head_font_color'           => '#827a74',
					'sidebar_section_head_background_color'     => '#FFFFFF',
					'sidebar_section_head_description_font_color' => '#b3b3b3',
					'sidebar_section_divider_color'             => '#dadada',

					'sidebar_section_category_font_color'       => '#868686',
					'sidebar_section_category_icon_color'       => '#868686',
					'sidebar_section_border_color'              => '#dbdbdb',
				);
				break;
			case 13:
				$preset_config = array(
					'grid_section_head_font_color'              => '#525252',

					'grid_section_head_background_color'        => '#f1f1f1',
					'grid_section_head_description_font_color'  => '#b3b3b3',
					'grid_section_head_icon_color'              => '#000000',
					'grid_section_divider_color'                => '#CDCDCD',

					'grid_section_body_background_color'        => '#fdfdfd',
					'grid_section_border_color'                 => '#F7F7F7',

					'sidebar_section_head_font_color'           => '#525252',
					'sidebar_section_head_background_color'     => '#f1f1f1',
					'sidebar_section_head_description_font_color' => '#b3b3b3',
					'sidebar_section_divider_color'             => '#CDCDCD',

					'sidebar_section_category_font_color'       => '#868686',
					'sidebar_section_category_icon_color'       => '#000000',
					'sidebar_section_border_color'              => '#F7F7F7',
				);
				break;
			case 14:
				$preset_config = array(
					'grid_section_head_font_color'              => '#FFFFFF',

					'grid_section_head_background_color'        => '#7d7d7d',
					'grid_section_head_description_font_color'  => '#bfbfbf',
					'grid_section_head_icon_color'              => '#FFFFFF',
					'grid_section_divider_color'                => '#dddddd',

					'grid_section_body_background_color'        => '#FFFFFF',
					'grid_section_border_color'                 => '#dddddd',

					'sidebar_section_head_font_color'           => '#FFFFFF',
					'sidebar_section_head_background_color'     => '#7d7d7d',
					'sidebar_section_head_description_font_color' => '#bfbfbf',
					'sidebar_section_divider_color'             => '#dddddd',

					'sidebar_section_category_font_color'       => '#40474f',
					'sidebar_section_category_icon_color'       => '#FFFFFF',
					'sidebar_section_border_color'              => '#dddddd',
				);
				break;
			default:
				$preset_config = array();
		}

		// color presets
		$preset_config['grid_search_title_font_color'] = $presets['search_title_font_color'];
		$preset_config['grid_search_background_color'] = $presets['search_background_color'];
		$preset_config['grid_search_text_input_background_color'] = $presets['search_text_input_background_color'];
		$preset_config['grid_search_text_input_border_color'] = $presets['search_text_input_border_color'];
		$preset_config['grid_search_btn_background_color'] = $presets['search_btn_background_color'];
		$preset_config['grid_search_btn_border_color'] = $presets['search_btn_border_color'];
		$preset_config['sidebar_search_title_font_color'] = $presets['search_title_font_color'];
		
		$preset_config['sidebar_search_background_color'] = $presets['search_background_color'];
		$preset_config['sidebar_search_text_input_background_color'] = $presets['search_text_input_background_color'];
		$preset_config['sidebar_search_text_input_border_color'] = $presets['search_text_input_border_color'];
		$preset_config['sidebar_search_btn_background_color'] = $presets['search_btn_background_color'];
		$preset_config['sidebar_search_btn_border_color'] = $presets['search_btn_border_color'];

		$preset_config['article_search_title_font_color'] = $presets['search_title_font_color'];
		$preset_config['article_search_background_color'] = $presets['search_background_color'];
		$preset_config['article_search_text_input_background_color'] = $presets['search_text_input_background_color'];
		$preset_config['article_search_text_input_border_color'] = $presets['search_text_input_border_color'];
		$preset_config['article_search_btn_background_color'] = $presets['search_btn_background_color'];
		$preset_config['article_search_btn_border_color'] = $presets['search_btn_border_color'];
		$preset_config['article_search_title_font_color'] = $presets['search_title_font_color'];

		$preset_config = array_merge($preset_config_default, $preset_config);

		return array_merge($presets, $preset_config);
	}
}