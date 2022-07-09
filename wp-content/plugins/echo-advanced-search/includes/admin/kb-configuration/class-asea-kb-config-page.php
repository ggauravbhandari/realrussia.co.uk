<?php  if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Display configuration fields for Advanced Search
 *
 */
class ASEA_KB_Config_Page {

	public function __construct() {
		add_filter( 'eckb_kb_config_option_group',  array( $this, 'kb_config_option_group' ), 10, 3 );

		ASEA_KB_Wizard::register_all_wizard_hooks();
	}

	/**
	 * Replace KB core Settings with Advanced Search settings
	 *
	 * @param $args
	 * @param $kb_config
	 * @param $kb_page_layout
	 *
	 * @return array
	 */
	public function kb_config_option_group( $args, $kb_config, $kb_page_layout ) {

		// add ASEA configuration
		$asea_config = asea_get_instance()->kb_config_obj->get_kb_config( $kb_config['id'] );
		if ( is_wp_error($asea_config) ) {
			return $args;
		}

		$kb_config = array_merge($asea_config, $kb_config);

		$menu_classes = empty($args['class']) ? '' : $args['class'];

		$is_main_page_config = $kb_page_layout == 'Basic' || $kb_page_layout == 'Tabs' || $kb_page_layout == 'Grid' || $kb_page_layout == 'Categories' || $kb_page_layout == 'Modular' ||
		                       ( $kb_page_layout == 'Sidebar' && $kb_config['kb_main_page_layout'] == 'Sidebar' );
		$page_ix = $is_main_page_config ? 'mp' : 'ap';

		if ( strpos($menu_classes, 'eckb-mm-mp-links-tuning-searchbox-advanced') !== false || strpos($menu_classes, 'eckb-mm-ap-links-tuning-searchbox-advanced') !== false ) {
			$this->set_search_box_advanced_options( $kb_config, $page_ix );
			return $args;
		}
		else if ( strpos($menu_classes, 'eckb-mm-mp-links-tuning-searchbox-colors') !== false ) {
			$this->set_search_box_color_options( $kb_config, $page_ix );
			return $args;
		}
		else if ( strpos($menu_classes, 'eckb-mm-mp-links-tuning-searchbox-layout') !== false ) {
			$this->set_search_box_setup_options( $kb_config, $page_ix );
			return $args;
		}
		else if ( strpos($menu_classes, 'eckb-mm-mp-links-tuning-searchbox-text') !== false || strpos($menu_classes, 'eckb-mm-mp-links-alltext-text-searchbox') !== false ) {
			$this->set_search_box_text_options( $kb_config, $page_ix );
			return $args;
		}

		return $args;
	}

	/**
	 * Replace KB core Layout Settings with Advanced Setup settings
	 *
	 * @param $kb_config
	 * @param $ix
	 */
	private function set_search_box_setup_options( $kb_config, $ix ) {

		$feature_specs = ASEA_KB_Config_Specs::get_fields_specification();
		$form = new ASEA_KB_Config_Elements();

		$form->option_group_filter( $kb_config, $feature_specs, array(
			'option-heading' => 'Advanced Search Box - Setup',
			'class'        => 'eckb-mm-mp-links-alllayout-layout-advancedsearchbox-layout  eckb-mm-mp-links-alllayout-layout-searchbox
			                   eckb-mm-mp-links-tuning-advancedsearchbox-setup eckb-mm-ap-links-tuning-advancedsearchbox-setup',
			'inputs' => array(
				'0' => $form->dropdown( $feature_specs['advanced_search_' . $ix . '_box_visibility'] + array(
						'value' => $kb_config['advanced_search_' . $ix . '_box_visibility'],
						'current' => $kb_config['advanced_search_' . $ix . '_box_visibility'],
						'label_class' => 'config-col-5',
						'input_class' => 'config-col-6'
					) ),
				'1' => $form->text( $feature_specs['advanced_search_' . $ix . '_auto_complete_wait'] + array(
						'value' => $kb_config['advanced_search_' . $ix . '_auto_complete_wait'],
						'input_group_class' => 'config-col-12',
						'label_class' => 'config-col-5',
						'input_class' => 'config-col-6'
					) ),
				'2' => $form->text( $feature_specs['advanced_search_' . $ix . '_results_list_size'] + array(
						'value' => $kb_config['advanced_search_' . $ix . '_results_list_size'],
						'input_group_class' => 'config-col-12',
						'label_class' => 'config-col-5',
						'input_class' => 'config-col-4'
					) ),
				'3' => $form->text( $feature_specs['advanced_search_' . $ix . '_results_page_size'] + array(
						'value' => $kb_config['advanced_search_' . $ix . '_results_page_size'],
						'input_group_class' => 'config-col-12',
						'label_class' => 'config-col-5',
						'input_class' => 'config-col-4'
					) ),
				'4' => $form->checkbox( $feature_specs['advanced_search_' . $ix . '_show_top_category'] + array(
								'value'             => $kb_config['advanced_search_' . $ix . '_show_top_category'],
								'id'                => 'advanced_search_' . $ix . '_show_top_category',
								'input_group_class' => 'config-col-12',
								'label_class'       => 'config-col-5',
								'input_class'       => 'config-col-6'
						) ),
			)
		) );

		$arg1_search_box_padding_vertical   = $feature_specs['advanced_search_' . $ix . '_box_padding_top'] + array( 'value' => $kb_config['advanced_search_' . $ix . '_box_padding_top'], 'current' => $kb_config['advanced_search_' . $ix . '_box_padding_top'], 'text_class' => 'config-col-6' );
		$arg2_search_box_padding_vertical   = $feature_specs['advanced_search_' . $ix . '_box_padding_bottom'] + array( 'value' => $kb_config['advanced_search_' . $ix . '_box_padding_bottom'], 'current' => $kb_config['advanced_search_' . $ix . '_box_padding_bottom'], 'text_class' => 'config-col-6' );
		$arg1_search_box_padding_horizontal = $feature_specs['advanced_search_' . $ix . '_box_padding_left'] + array( 'value' => $kb_config['advanced_search_' . $ix . '_box_padding_left'], 'current' => $kb_config['advanced_search_' . $ix . '_box_padding_left'], 'text_class' => 'config-col-6' );
		$arg2_search_box_padding_horizontal = $feature_specs['advanced_search_' . $ix . '_box_padding_right'] + array( 'value' => $kb_config['advanced_search_' . $ix . '_box_padding_right'], 'current' => $kb_config['advanced_search_' . $ix . '_box_padding_right'], 'text_class' => 'config-col-6' );

		$arg1_search_box_margin_vertical = $feature_specs['advanced_search_' . $ix . '_box_margin_top'] + array( 'value' => $kb_config['advanced_search_' . $ix . '_box_margin_top'], 'current' => $kb_config['advanced_search_' . $ix . '_box_margin_top'], 'text_class' => 'config-col-6' );
		$arg2_search_box_margin_vertical = $feature_specs['advanced_search_' . $ix . '_box_margin_bottom'] + array( 'value' => $kb_config['advanced_search_' . $ix . '_box_margin_bottom'], 'current' => $kb_config['advanced_search_' . $ix . '_box_margin_bottom'], 'text_class' => 'config-col-6' );

		$arg1_search_description_below_title_padding_vertical = $feature_specs['advanced_search_' . $ix . '_description_below_title_padding_top'] + array( 'value' => $kb_config['advanced_search_' . $ix . '_description_below_title_padding_top'], 'current' => $kb_config['advanced_search_' . $ix . '_description_below_title_padding_top'], 'text_class' => 'config-col-6' );
		$arg2_search_description_below_title_padding_vertical = $feature_specs['advanced_search_' . $ix . '_description_below_title_padding_bottom'] + array( 'value' => $kb_config['advanced_search_' . $ix . '_description_below_title_padding_bottom'], 'current' => $kb_config['advanced_search_' . $ix . '_description_below_title_padding_bottom'], 'text_class' => 'config-col-6' );

		$arg1_search_description_below_input_padding_vertical = $feature_specs['advanced_search_' . $ix . '_description_below_input_padding_top'] + array( 'value' => $kb_config['advanced_search_' . $ix . '_description_below_input_padding_top'], 'current' => $kb_config['advanced_search_' . $ix . '_description_below_input_padding_top'], 'text_class' => 'config-col-6' );
		$arg2_search_description_below_input_padding_vertical = $feature_specs['advanced_search_' . $ix . '_description_below_input_padding_bottom'] + array( 'value' => $kb_config['advanced_search_' . $ix . '_description_below_input_padding_bottom'], 'current' => $kb_config['advanced_search_' . $ix . '_description_below_input_padding_bottom'], 'text_class' => 'config-col-6' );


		$arg1_title_text_shadow         = $feature_specs['advanced_search_' . $ix . '_title_text_shadow_x_offset'] + array( 'value' => $kb_config['advanced_search_' . $ix . '_title_text_shadow_x_offset'], 'current' => $kb_config['advanced_search_' . $ix . '_title_text_shadow_x_offset'], 'text_class' => 'config-col-6' );
		$arg2_title_text_shadow         = $feature_specs['advanced_search_' . $ix . '_title_text_shadow_y_offset'] + array( 'value' => $kb_config['advanced_search_' . $ix . '_title_text_shadow_y_offset'], 'current' => $kb_config['advanced_search_' . $ix . '_title_text_shadow_y_offset'], 'text_class' => 'config-col-6' );
		$arg3_title_text_shadow         = $feature_specs['advanced_search_' . $ix . '_title_text_shadow_blur'] + array( 'value' => $kb_config['advanced_search_' . $ix . '_title_text_shadow_blur'], 'current' => $kb_config['advanced_search_' . $ix . '_title_text_shadow_blur'], 'text_class' => 'config-col-6' );

		$arg1_description_below_title_shadow         = $feature_specs['advanced_search_' . $ix . '_description_below_title_text_shadow_x_offset'] + array( 'value' => $kb_config['advanced_search_' . $ix . '_description_below_title_text_shadow_x_offset'], 'current' => $kb_config['advanced_search_' . $ix . '_description_below_title_text_shadow_x_offset'], 'text_class' => 'config-col-6' );
		$arg2_description_below_title_shadow         = $feature_specs['advanced_search_' . $ix . '_description_below_title_text_shadow_y_offset'] + array( 'value' => $kb_config['advanced_search_' . $ix . '_description_below_title_text_shadow_y_offset'], 'current' => $kb_config['advanced_search_' . $ix . '_description_below_title_text_shadow_y_offset'], 'text_class' => 'config-col-6' );
		$arg3_description_below_title_shadow         = $feature_specs['advanced_search_' . $ix . '_description_below_title_text_shadow_blur'] + array( 'value' => $kb_config['advanced_search_' . $ix . '_description_below_title_text_shadow_blur'], 'current' => $kb_config['advanced_search_' . $ix . '_description_below_title_text_shadow_blur'], 'text_class' => 'config-col-6' );


		//Search Box Container ---------------------------------------------------/
		$form->option_group_filter( $kb_config, $feature_specs, array(
			'option-heading' => 'Search Box Container',
			'class'        => 'eckb-mm-mp-links-alllayout-layout-advancedsearchbox-layout  eckb-mm-mp-links-alllayout-layout-searchbox
			                   eckb-mm-mp-links-tuning-advancedsearchbox-setup eckb-mm-ap-links-tuning-advancedsearchbox-setup',
			'inputs' => array(
				'0' => $form->multiple_number_inputs(
					array(
						'id'                => 'advanced_search_' . $ix . '_box_padding',
						'input_group_class' => '',
						'main_label_class'  => '',
						'input_class'       => '',
						'label'             => 'Padding( px )'
					),
					array( $arg1_search_box_padding_vertical, $arg2_search_box_padding_vertical ,$arg1_search_box_padding_horizontal, $arg2_search_box_padding_horizontal )
				),
				'1' => $form->multiple_number_inputs(
					array(
						'id'                => 'advanced_search_' . $ix . '_box_margin',
						'input_group_class' => '',
						'main_label_class'  => '',
						'input_class'       => '',
						'label'             => 'Margin( px )'
					),
					array( $arg1_search_box_margin_vertical, $arg2_search_box_margin_vertical )
				),
				'3' => $form->text( $feature_specs['advanced_search_' . $ix . '_box_font_width'] + array(
						'value'             => $kb_config['advanced_search_' . $ix . '_box_font_width'],
						'input_group_class' => 'config-col-12',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-4'
					) ),

			)));

		//Search Title ---------------------------------------------------/
		$form->option_group_filter( $kb_config, $feature_specs, array(
			'option-heading' => 'Search Title',
			'class'        => 'eckb-mm-mp-links-alllayout-layout-advancedsearchbox-layout  eckb-mm-mp-links-alllayout-layout-searchbox
			                   eckb-mm-mp-links-tuning-advancedsearchbox-setup eckb-mm-ap-links-tuning-advancedsearchbox-setup',
			'inputs' => array(
				'2' => $form->text( $feature_specs['advanced_search_' . $ix . '_title_padding_bottom'] + array(
						'value'             => $kb_config['advanced_search_' . $ix . '_title_padding_bottom'],
						'input_group_class' => 'config-col-12',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-4'
					) ),
				'3' => $form->multiple_number_inputs(
					array(
						'id'                => 'advanced_search_' . $ix . '_text_title_shadow_position_group',
						'input_group_class' => '',
						'main_label_class'  => '',
						'input_class'       => '',
						'label'             => 'Text Shadow'
					),
					array( $arg1_title_text_shadow, $arg2_title_text_shadow, $arg3_title_text_shadow )
				),
				'4' => $form->checkbox( $feature_specs['advanced_search_' . $ix . '_title_text_shadow_toggle'] + array(
						'value'             => $kb_config['advanced_search_' . $ix . '_title_text_shadow_toggle'],
						'id'                => 'advanced_search_' . $ix . '_title_text_shadow_toggle',
						'input_group_class' => 'config-col-12',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-2'
					) ),

			)
		));

		//Description Below Search Title -------------------------------------------/
		$form->option_group_filter( $kb_config, $feature_specs, array(
			'option-heading' => 'Description Below Search Title',
			'class'        => 'eckb-mm-mp-links-alllayout-layout-advancedsearchbox-layout  eckb-mm-mp-links-alllayout-layout-searchbox
			                   eckb-mm-mp-links-tuning-advancedsearchbox-setup eckb-mm-ap-links-tuning-advancedsearchbox-setup',
			'inputs' => array(

				'1' => $form->multiple_number_inputs(
					array(
						'id'                => 'advanced_search_' . $ix . '_description_below_title_padding',
						'input_group_class' => '',
						'main_label_class'  => '',
						'input_class'       => '',
						'label'             => 'Padding( px )'
					),
					array( $arg1_search_description_below_title_padding_vertical, $arg2_search_description_below_title_padding_vertical )
				),
				'3' => $form->multiple_number_inputs(
					array(
						'id'                => 'advanced_search_' . $ix . '_description_below_title_shadow_position_group',
						'input_group_class' => '',
						'main_label_class'  => '',
						'input_class'       => '',
						'label'             => 'Text Shadow'
					),
					array( $arg1_description_below_title_shadow, $arg2_description_below_title_shadow ,$arg3_description_below_title_shadow )
				),
				'4' => $form->checkbox( $feature_specs['advanced_search_' . $ix . '_description_below_title_text_shadow_toggle'] + array(
						'value'             => $kb_config['advanced_search_' . $ix . '_description_below_title_text_shadow_toggle'],
						'id'                => 'advanced_search_' . $ix . '_description_below_title_text_shadow_toggle',
						'input_group_class' => 'config-col-12',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-2'
					) ),
			)
		));

		//Description Below Search Input -------------------------------------------/
		$form->option_group_filter( $kb_config, $feature_specs, array(
			'option-heading' => 'Description Below Search Input',
			'class'        => 'eckb-mm-mp-links-alllayout-layout-advancedsearchbox-layout  eckb-mm-mp-links-alllayout-layout-searchbox
			                   eckb-mm-mp-links-tuning-advancedsearchbox-setup eckb-mm-ap-links-tuning-advancedsearchbox-setup',
			'inputs' => array(

				'1' => $form->multiple_number_inputs(
					array(
						'id'                => 'advanced_search_' . $ix . '_description_below_input_padding',
						'input_group_class' => '',
						'main_label_class'  => '',
						'input_class'       => '',
						'label'             => 'Padding( px )'
					),
					array( $arg1_search_description_below_input_padding_vertical, $arg2_search_description_below_input_padding_vertical )
				),
			)
		));

		//Search Results -----------------------------------------------------------/
		$form->option_group_filter( $kb_config, $feature_specs, array(
			'option-heading' => 'Search Results',
			'class'        => 'eckb-mm-mp-links-alllayout-layout-advancedsearchbox-layout  eckb-mm-mp-links-alllayout-layout-searchbox
			                   eckb-mm-mp-links-tuning-advancedsearchbox-setup eckb-mm-ap-links-tuning-advancedsearchbox-setup',
			'inputs' => array(

				'0' => $form->text( $feature_specs['advanced_search_' . $ix . '_search_results_article_font_size'] + array(
						'value'             => $kb_config['advanced_search_' . $ix . '_search_results_article_font_size'],
						'input_group_class' => 'config-col-12',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-4'
					) )
			)
		));
	}

	/**
	 * Replace KB core Text Settings with Advanced Text settings
	 *
	 * @param $kb_config
	 * @param $ix
	 */
	private function set_search_box_text_options( $kb_config, $ix ) {

		$feature_specs = ASEA_KB_Config_Specs::get_fields_specification();
		$form = new ASEA_KB_Config_Elements();

		$form->option_group_filter( $kb_config, $feature_specs, array(
			'option-heading' => 'Advanced Search Box - Text',
			'class'        => 'eckb-mm-mp-links-alltext-text-advancedsearchbox-text  eckb-mm-mp-links-alltext-text-searchbox eckb-mm-mp-links-tuning-advancedsearchbox-text eckb-mm-ap-links-tuning-advancedsearchbox-text',
			'inputs' => array(
				'0' => $form->text( $feature_specs['advanced_search_' . $ix . '_title'] +
				                    array( 'value' => $kb_config['advanced_search_' . $ix . '_title'], 'current' => $kb_config['advanced_search_' . $ix . '_title'],
				                           'input_group_class' => 'config-col-12',
				                           'label_class'       => 'config-col-3',
				                           'input_class'       => 'config-col-9'   ) ),
				'1' => $form->text( $feature_specs['advanced_search_' . $ix . '_description_below_title'] +
				                    array( 'value' => $kb_config['advanced_search_' . $ix . '_description_below_title'], 'current' => $kb_config['advanced_search_' . $ix . '_description_below_title'],
				                           'input_group_class' => 'config-col-12',
				                           'label_class'       => 'config-col-3',
				                           'input_class'       => 'config-col-9'   ) ),
				'2' => $form->text( $feature_specs['advanced_search_' . $ix . '_description_below_input'] +
				                    array( 'value' => $kb_config['advanced_search_' . $ix . '_description_below_input'], 'current' => $kb_config['advanced_search_' . $ix . '_description_below_input'],
				                           'input_group_class' => 'config-col-12',
				                           'label_class'       => 'config-col-3',
				                           'input_class'       => 'config-col-9'   ) ),
				'3' => $form->text( $feature_specs['advanced_search_' . $ix . '_box_hint'] +
				                    array( 'value' => $kb_config['advanced_search_' . $ix . '_box_hint'], 'current' => $kb_config['advanced_search_' . $ix . '_box_hint'],
				                           'input_group_class' => 'config-col-12',
				                           'label_class'       => 'config-col-3',
				                           'input_class'       => 'config-col-9'   ) ),
				'4' => $form->text( $feature_specs['advanced_search_' . $ix . '_results_msg'] +
				                    array( 'value' => $kb_config['advanced_search_' . $ix . '_results_msg'], 'current' => $kb_config['advanced_search_' . $ix . '_results_msg'],
				                           'input_group_class' => 'config-col-12',
				                           'label_class'       => 'config-col-3',
				                           'input_class'       => 'config-col-9'       ) ),
				'5' => $form->text( $feature_specs['advanced_search_' . $ix . '_no_results_found'] +
				                    array( 'value' => $kb_config['advanced_search_' . $ix . '_no_results_found'], 'current' => $kb_config['advanced_search_' . $ix . '_no_results_found'],
				                           'input_group_class' => 'config-col-12',
				                           'label_class'       => 'config-col-3',
				                           'input_class'       => 'config-col-9'   ) ),
				'6' => $form->text( $feature_specs['advanced_search_' . $ix . '_more_results_found'] +
				                    array( 'value' => $kb_config['advanced_search_' . $ix . '_more_results_found'], 'current' => $kb_config['advanced_search_' . $ix . '_more_results_found'],
				                           'input_group_class' => 'config-col-12',
				                           'label_class'       => 'config-col-3',
				                           'input_class'       => 'config-col-9'   ) ),
				'7' => $form->text( $feature_specs['advanced_search_' . $ix . '_filter_indicator_text'] +
									array( 'value' => $kb_config['advanced_search_' . $ix . '_filter_indicator_text'], 'current' => $kb_config['advanced_search_' . $ix . '_filter_indicator_text'],
										'input_group_class' => 'config-col-12',
										'label_class'       => 'config-col-3',
										'input_class'       => 'config-col-9'   ) ),
			)
		));
	}

	/**
	 * Replace KB core Color Settings with Advanced Color settings.
	 *
	 * @param $kb_config
	 * @param $ix
	 */
	private function set_search_box_color_options( $kb_config, $ix ) {

		$feature_specs = ASEA_KB_Config_Specs::get_fields_specification();

		$arg1_input_text_field = $feature_specs['advanced_search_' . $ix . '_text_input_background_color'] + array( 'value' => $kb_config['advanced_search_' . $ix . '_text_input_background_color'], 'current' => $kb_config['advanced_search_' . $ix . '_text_input_background_color'], 'class' => 'ekb-color-picker', 'text_class' => 'config-col-6' );
		$arg2_input_text_field = $feature_specs['advanced_search_' . $ix . '_text_input_border_color'] + array( 'value' => $kb_config['advanced_search_' . $ix . '_text_input_border_color'], 'current' => $kb_config['advanced_search_' . $ix . '_text_input_border_color'], 'class' => 'ekb-color-picker', 'text_class' => 'config-col-6' );

		$arg_gradient_from_color = $feature_specs['advanced_search_' . $ix . '_background_gradient_from_color'] + array( 'value' => $kb_config['advanced_search_' . $ix . '_background_gradient_from_color'], 'current' => $kb_config['advanced_search_' . $ix . '_background_gradient_from_color'], 'class' => 'ekb-color-picker', 'text_class' => 'config-col-6' );
		$arg_gradient_to_color = $feature_specs['advanced_search_' . $ix . '_background_gradient_to_color'] + array( 'value' => $kb_config['advanced_search_' . $ix . '_background_gradient_to_color'], 'current' => $kb_config['advanced_search_' . $ix . '_background_gradient_to_color'], 'class' => 'ekb-color-picker', 'text_class' => 'config-col-6' );

		$form = new ASEA_KB_Config_Elements();

		$form->option_group_filter( $kb_config, $feature_specs, array(
			'option-heading' => 'Advanced Search Box - Colors',
			'class'        => 'eckb-mm-mp-links-tuning-advancedsearchbox-colors eckb-mm-ap-links-tuning-advancedsearchbox-colors',
			'inputs' => array(
				'0' => $form->text( $feature_specs['advanced_search_' . $ix . '_title_font_color'] + array(
						'value'             => $kb_config['advanced_search_' . $ix . '_title_font_color'],
						'input_group_class' => 'config-col-12',
						'class'             => 'ekb-color-picker',
						'label_class'       => 'config-col-4',
						'input_class'       => 'config-col-8 ekb-color-picker'
					) ),
				'1' => $form->text( $feature_specs['advanced_search_' . $ix . '_title_font_shadow_color'] + array(
						'value'             => $kb_config['advanced_search_' . $ix . '_title_font_shadow_color'],
						'input_group_class' => 'config-col-12',
						'class'             => 'ekb-color-picker',
						'label_class'       => 'config-col-4',
						'input_class'       => 'config-col-8 ekb-color-picker'
					) ),
				'2' => $form->text( $feature_specs['advanced_search_' . $ix . '_description_below_title_font_shadow_color'] + array(
						'value'             => $kb_config['advanced_search_' . $ix . '_description_below_title_font_shadow_color'],
						'input_group_class' => 'config-col-12',
						'class'             => 'ekb-color-picker',
						'label_class'       => 'config-col-4',
						'input_class'       => 'config-col-8 ekb-color-picker'
					) ),
				'3' => $form->text( $feature_specs['advanced_search_' . $ix . '_link_font_color'] + array(
						'value'             => $kb_config['advanced_search_' . $ix . '_link_font_color'],
						'input_group_class' => 'config-col-12',
						'class'             => 'ekb-color-picker',
						'label_class'       => 'config-col-4',
						'input_class'       => 'config-col-8 ekb-color-picker'
					) ),
				'4' => $form->text( $feature_specs['advanced_search_' . $ix . '_background_color'] + array(
						'value' => $kb_config['advanced_search_' . $ix . '_background_color'],
						'input_group_class' => 'config-col-12',
						'class'             => 'ekb-color-picker',
						'label_class'       => 'config-col-4',
						'input_class'       => 'config-col-8 ekb-color-picker'
					) ),
				'5' => $form->text_fields_horizontal( array(
						'id'                => 'input_text_field',
						'input_group_class' => 'config-col-12',
						'main_label_class'  => 'config-col-4',
						'input_class'       => 'config-col-7 ekb-color-picker',
						'label'             => 'Input Text Field'
					), $arg1_input_text_field, $arg2_input_text_field ),
				'6' => $form->text_fields_horizontal( array(
						'id'                => 'input_text_field',
						'input_group_class' => 'config-col-12',
						'main_label_class'  => 'config-col-4',
						'input_class'       => 'config-col-7 ekb-color-picker',
						'label'             => 'Gradient Background'
				), $arg_gradient_from_color, $arg_gradient_to_color ),
				'7' => $form->text( $feature_specs['advanced_search_' . $ix . '_filter_box_font_color'] + array(
						'value'             => $kb_config['advanced_search_' . $ix . '_filter_box_font_color'],
						'input_group_class' => 'config-col-12',
						'class'             => 'ekb-color-picker',
						'label_class'       => 'config-col-4',
						'input_class'       => 'config-col-8 ekb-color-picker'
					) ),
				'8' => $form->text( $feature_specs['advanced_search_' . $ix . '_filter_box_background_color'] + array(
						'value'             => $kb_config['advanced_search_' . $ix . '_filter_box_background_color'],
						'input_group_class' => 'config-col-12',
						'class'             => 'ekb-color-picker',
						'label_class'       => 'config-col-4',
						'input_class'       => 'config-col-8 ekb-color-picker'
					) ),
				'9' => $form->text( $feature_specs['advanced_search_' . $ix . '_search_result_category_color'] + array(
						'value'             => $kb_config['advanced_search_' . $ix . '_search_result_category_color'],
						'input_group_class' => 'config-col-12',
						'class'             => 'ekb-color-picker',
						'label_class'       => 'config-col-4',
						'input_class'       => 'config-col-8 ekb-color-picker'
				) ),
			)
		));
	}

	/**
	 * Replace KB core Advanced Settings with ASES Advanced settings.
	 * @param $kb_config
	 * @param $ix
	 */
	private function set_search_box_advanced_options( $kb_config, $ix ) {
		$feature_specs = ASEA_KB_Config_Specs::get_fields_specification();

		$arg1_search_input_box_shadow   = $feature_specs['advanced_search_' . $ix . '_input_box_shadow_x_offset'] + array( 'value' => $kb_config['advanced_search_' . $ix . '_input_box_shadow_x_offset'], 'current' => $kb_config['advanced_search_' . $ix . '_input_box_shadow_x_offset'], 'text_class' => 'config-col-6' );
		$arg2_search_input_box_shadow   = $feature_specs['advanced_search_' . $ix . '_input_box_shadow_y_offset'] + array( 'value' => $kb_config['advanced_search_' . $ix . '_input_box_shadow_y_offset'], 'current' => $kb_config['advanced_search_' . $ix . '_input_box_shadow_y_offset'], 'text_class' => 'config-col-6' );
		$arg3_search_input_box_shadow   = $feature_specs['advanced_search_' . $ix . '_input_box_shadow_blur'] + array( 'value' => $kb_config['advanced_search_' . $ix . '_input_box_shadow_blur'], 'current' => $kb_config['advanced_search_' . $ix . '_input_box_shadow_blur'], 'text_class' => 'config-col-6' );
		$arg4_search_input_box_shadow   = $feature_specs['advanced_search_' . $ix . '_input_box_shadow_spread'] + array( 'value' => $kb_config['advanced_search_' . $ix . '_input_box_shadow_spread'], 'current' => $kb_config['advanced_search_' . $ix . '_input_box_shadow_spread'], 'text_class' => 'config-col-6' );

		$arg1_search_input_padding_shadow   = $feature_specs['advanced_search_' . $ix . '_input_box_padding_top'] + array( 'value' => $kb_config['advanced_search_' . $ix . '_input_box_padding_top'], 'current' => $kb_config['advanced_search_' . $ix . '_input_box_padding_top'], 'text_class' => 'config-col-6' );
		$arg2_search_input_padding_shadow   = $feature_specs['advanced_search_' . $ix . '_input_box_padding_bottom'] + array( 'value' => $kb_config['advanced_search_' . $ix . '_input_box_padding_bottom'], 'current' => $kb_config['advanced_search_' . $ix . '_input_box_padding_bottom'], 'text_class' => 'config-col-6' );
		$arg3_search_input_padding_shadow   = $feature_specs['advanced_search_' . $ix . '_input_box_padding_left'] + array( 'value' => $kb_config['advanced_search_' . $ix . '_input_box_padding_left'], 'current' => $kb_config['advanced_search_' . $ix . '_input_box_padding_left'], 'text_class' => 'config-col-6' );
		$arg4_search_input_padding_shadow   = $feature_specs['advanced_search_' . $ix . '_input_box_padding_right'] + array( 'value' => $kb_config['advanced_search_' . $ix . '_input_box_padding_right'], 'current' => $kb_config['advanced_search_' . $ix . '_input_box_padding_right'], 'text_class' => 'config-col-6' );

		$search_input_input_arg1 = $feature_specs['advanced_search_' . $ix . '_box_input_width'] + array(
				'value'             => $kb_config['advanced_search_' . $ix . '_box_input_width'],
				'input_group_class' => 'config-col-12',
				'label_class'       => 'config-col-6',
				'input_class'       => 'config-col-2'

			);
		$search_input_input_arg2 = $feature_specs['advanced_search_' . $ix . '_input_border_width'] + array(
				'value' => $kb_config['advanced_search_' . $ix . '_input_border_width'],
				'input_group_class' => 'config-col-12',
				'label_class'       => 'config-col-6',
				'input_class'       => 'config-col-2'
			);
		$search_input_input_arg3 = $feature_specs['advanced_search_' . $ix . '_input_box_radius'] + array(
				'value'             => $kb_config['advanced_search_' . $ix . '_input_box_radius'],
				'input_group_class' => 'config-col-12',
				'label_class'       => 'config-col-6',
				'input_class'       => 'config-col-2'

			);

		$form = new ASEA_KB_Config_Elements();

		//Input and Results Settings ---------------------------------------/
		$form->option_group_filter( $kb_config, $feature_specs, array(
			'option-heading' => 'Search Input and Results',
			'class'        => 'eckb-mm-mp-links-tuning-advancedsearchbox-advanced eckb-mm-ap-links-tuning-advancedsearchbox-advanced',
			'inputs' => array(

				'0' => $form->multiple_number_inputs(
					array(
						'id'                => 'advanced_search_' . $ix . '_box_input_width_group',
						'input_group_class' => '',
						'main_label_class'  => '',
						'input_class'       => '',
						'label'             => 'Search Box Input ( % ) ( px ) ( px )'
					),
					array( $search_input_input_arg1, $search_input_input_arg2, $search_input_input_arg3 )
				),
				'1' => $form->multiple_number_inputs(
					array(
						'id'                => 'advanced_search_' . $ix . '_input_padding_group',
						'input_group_class' => '',
						'main_label_class'  => '',
						'input_class'       => '',
						'label'             => 'Padding ( px )'
					),
					array( $arg1_search_input_padding_shadow, $arg2_search_input_padding_shadow ,$arg3_search_input_padding_shadow, $arg4_search_input_padding_shadow )
				),
				'2' => $form->multiple_number_inputs(
					array(
						'id'                => 'advanced_search_' . $ix . '_input_box_shadow_position_group',
						'input_group_class' => '',
						'main_label_class'  => '',
						'input_class'       => '',
						'label'             => 'Box Shadow Position'
					),
					array( $arg1_search_input_box_shadow, $arg2_search_input_box_shadow ,$arg3_search_input_box_shadow, $arg4_search_input_box_shadow )
				),
				'3' => $form->text( $feature_specs['advanced_search_' . $ix . '_input_box_shadow_rgba'] + array(
						'value'             => $kb_config['advanced_search_' . $ix . '_input_box_shadow_rgba'],
						'input_group_class' => 'config-col-12',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-4'
					) ),
				'4' => $form->dropdown( $feature_specs['advanced_search_' . $ix . '_input_box_search_icon_placement'] + array(
						'value' => $kb_config['advanced_search_' . $ix . '_input_box_search_icon_placement'],
						'current' => $kb_config['advanced_search_' . $ix . '_input_box_search_icon_placement'],
						'input_group_class' => 'config-col-12',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-4'
					)),
				'5' => $form->dropdown( $feature_specs['advanced_search_' . $ix . '_input_box_loading_icon_placement'] + array(
						'value' => $kb_config['advanced_search_' . $ix . '_input_box_loading_icon_placement'],
						'current' => $kb_config['advanced_search_' . $ix . '_input_box_loading_icon_placement'],
						'input_group_class' => 'config-col-12',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-4'
					)),
				'6' => $form->checkbox( $feature_specs['advanced_search_' . $ix . '_box_results_style'] + array(
						'value'             => $kb_config['advanced_search_' . $ix . '_box_results_style'],
						'id'                => 'advanced_search_' . $ix . '_box_results_style',
						'input_group_class' => 'config-col-12',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-6'
					) ),

			)
		));

		//Filter Box -------------------------------------------------------/
		$form->option_group_filter( $kb_config, $feature_specs, array(
			'option-heading' => 'Filter Box',
			'class'        => 'eckb-mm-mp-links-tuning-advancedsearchbox-advanced eckb-mm-ap-links-tuning-advancedsearchbox-advanced',
			'inputs' => array(

				'0' => $form->checkbox( $feature_specs['advanced_search_' . $ix . '_filter_toggle'] + array(
						'value'             => $kb_config['advanced_search_' . $ix . '_filter_toggle'],
						'id'                => 'advanced_search_' . $ix . '_filter_toggle',
						'input_group_class' => 'config-col-12',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-6'
					) ),

			)
		));


		//Background Image -------------------------------------------------/
		$form->option_group_filter( $kb_config, $feature_specs, array(
			'option-heading' => 'Background Image',
			'class'        => 'eckb-mm-mp-links-tuning-advancedsearchbox-advanced eckb-mm-ap-links-tuning-advancedsearchbox-advanced',
			'inputs' => array(

				'0' => $form->text( $feature_specs['advanced_search_' . $ix . '_background_image_url'] + array(
						'value'             => $kb_config['advanced_search_' . $ix . '_background_image_url'],
						'input_group_class' => 'config-col-12',
						'label_class'       => 'config-col-12',
						'input_class'       => 'config-col-12'
					) ),
				'1' => $form->dropdown( $feature_specs['advanced_search_' . $ix . '_background_image_position_x'] + array(
						'value' => $kb_config['advanced_search_' . $ix . '_background_image_position_x'],
						'current' => $kb_config['advanced_search_' . $ix . '_background_image_position_x'],
						'input_group_class' => 'config-col-12',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-4'
					)),
				'2' => $form->dropdown( $feature_specs['advanced_search_' . $ix . '_background_image_position_y'] + array(
						'value' => $kb_config['advanced_search_' . $ix . '_background_image_position_y'],
						'current' => $kb_config['advanced_search_' . $ix . '_background_image_position_y'],
						'input_group_class' => 'config-col-12',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-4'
					)),


			)
		));
		//Background Pattern Image -----------------------------------------/
		$form->option_group_filter( $kb_config, $feature_specs, array(
			'option-heading' => 'Background Pattern Image',
			'class'        => 'eckb-mm-mp-links-tuning-advancedsearchbox-advanced eckb-mm-ap-links-tuning-advancedsearchbox-advanced',
			'inputs' => array(

				'0' => $form->text( $feature_specs['advanced_search_' . $ix . '_background_pattern_image_url'] + array(
						'value'             => $kb_config['advanced_search_' . $ix . '_background_pattern_image_url'],
						'input_group_class' => 'config-col-12',
						'label_class'       => 'config-col-12',
						'input_class'       => 'config-col-12'
					) ),
				'1' => $form->dropdown( $feature_specs['advanced_search_' . $ix . '_background_pattern_image_position_x'] + array(
						'value' => $kb_config['advanced_search_' . $ix . '_background_pattern_image_position_x'],
						'current' => $kb_config['advanced_search_' . $ix . '_background_pattern_image_position_x'],
						'input_group_class' => 'config-col-12',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-4'
					)),
				'2' => $form->dropdown( $feature_specs['advanced_search_' . $ix . '_background_pattern_image_position_y'] + array(
						'value' => $kb_config['advanced_search_' . $ix . '_background_pattern_image_position_y'],
						'current' => $kb_config['advanced_search_' . $ix . '_background_pattern_image_position_y'],
						'input_group_class' => 'config-col-12',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-4'
					)),
				'3' => $form->text( $feature_specs['advanced_search_' . $ix . '_background_pattern_image_opacity'] + array(
						'value' => $kb_config['advanced_search_' . $ix . '_background_pattern_image_opacity'],
						'input_group_class' => 'config-col-12',
						'label_class' => 'config-col-5',
						'input_class' => 'config-col-2'
					) ),


			)
		));
		//Background Gradient ----------------------------------------------/
		$form->option_group_filter( $kb_config, $feature_specs, array(
			'option-heading' => 'Background Gradient',
			'class'        => 'eckb-mm-mp-links-tuning-advancedsearchbox-advanced eckb-mm-ap-links-tuning-advancedsearchbox-advanced',
			'inputs' => array(

				'0' => $form->text( $feature_specs['advanced_search_' . $ix . '_background_gradient_degree'] + array(
						'value'             => $kb_config['advanced_search_' . $ix . '_background_gradient_degree'],
						'input_group_class' => 'config-col-12',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-4'
					) ),
				'1' => $form->text( $feature_specs['advanced_search_' . $ix . '_background_gradient_opacity'] + array(
						'value'             => $kb_config['advanced_search_' . $ix . '_background_gradient_opacity'],
						'input_group_class' => 'config-col-12',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-4'
					) ),
				'2' => $form->checkbox( $feature_specs['advanced_search_' . $ix . '_background_gradient_toggle'] + array(
						'value'             => $kb_config['advanced_search_' . $ix . '_background_gradient_toggle'],
						'id'                => 'advanced_search_' . $ix . '_background_gradient_toggle',
						'input_group_class' => 'config-col-12',
						'label_class'       => 'config-col-5',
						'input_class'       => 'config-col-6'
					) ),


			)
		));
	}
}