<?php  if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Display Article Rating and Feedback configuration on KB Configuration page
 *
 * @copyright   Copyright (C) 2018, Echo Plugins
 * @license http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */
class EPRF_KB_Config_Page {

	public function __construct() {
        add_filter( Eprf_KB_Core::EPRF_KB_ARTICLE_PAGE_ADD_ON_LINKS, array( $this, 'get_plugin_menu' ), 10, 3 );
        add_action( Eprf_KB_Core::EPRF_KB_ARTICLE_PAGE_ADD_ON_MENU_CONTENT, array( $this, 'display_plugin_menu_content' ) );
        add_action( Eprf_KB_Core::EPRF_KB_ARTICLE_CONFIG_SIDEBAR_CONTENT, array( $this, 'display_plugin_sidebar_content' ) );
		
		EPRF_KB_Wizard::register_all_wizard_hooks();
	}

	public function get_plugin_menu( $article_page_add_on_links, $kb_article_page_layout, $kb_config ) {
        return $article_page_add_on_links + array( 20 => 'Rating and Feedback' );
    }

    /**
     * Show configuration within Sidebar content (right side of the menu) if applicable
     *
     * @param $kb_config
     */
    public function display_plugin_menu_content( $kb_config ) {
	    $this->mega_menu_item_content( array(
			    'id'        => 'eckb-mm-ap-links-ratingandfeedback',
			    'sections'  => array(
					    array(
							    'heading' => 'Features',
							    'links' => array( 'Article Rating', 'Article Feedback' )
					    ),
			    )
	    ));
    }

    public function display_plugin_sidebar_content( $kb_config ) {

        echo '<div class="ep'.'kb-config-sidebar" id="ep'.'kb-config-article-features-sidebar">';
        echo    '<div class="ep'.'kb-config-sidebar-options">';
                $feature_specs = Eprf_KB_Config_Specs::get_fields_specification();
                $add_on_config = eprf_get_instance()->kb_config_obj->get_kb_config_or_default( $kb_config['id'] );
                $form          = new Eprf_KB_Config_Elements();
				
				// ARTICLE RATING OPRIONS
	            $form->option_group( $feature_specs, array(
			            'option-heading'    => 'Rating Mode',
			            'class'             => 'eckb-mm-ap-links-ratingandfeedback-features-articlerating',
			            'inputs'            => array(
								'0' => $form->dropdown( $feature_specs['rating_mode'] + array(
												'value'             => $add_on_config['rating_mode'],
												'current'           => $add_on_config['rating_mode'],
												'input_group_class' => 'config-col-12 rating-mode',
												'label_class'       => 'config-col-4',
												'input_class'       => 'config-col-6'
										) ),
					            '1' => $form->text( $feature_specs['rating_element_color'] + array(
									            'value'             => $add_on_config['rating_element_color'],
									            'input_group_class' => 'config-col-12 stars-mode',
									            'class'             => 'ekb-color-picker',
									            'label_class'       => 'config-col-4',
									            'input_class'       => 'config-col-7 ekb-color-picker'
							            ) ),
								'2' => $form->text( $feature_specs['rating_like_color'] + array(
									            'value'             => $add_on_config['rating_like_color'],
									            'input_group_class' => 'config-col-12 likedislike-mode',
									            'class'             => 'ekb-color-picker',
									            'label_class'       => 'config-col-4',
									            'input_class'       => 'config-col-7 ekb-color-picker'
							            ) ),
								'3' => $form->text( $feature_specs['rating_dislike_color'] + array(
									            'value'             => $add_on_config['rating_dislike_color'],
									            'input_group_class' => 'config-col-12 likedislike-mode',
									            'class'             => 'ekb-color-picker',
									            'label_class'       => 'config-col-4',
									            'input_class'       => 'config-col-7 ekb-color-picker'
							            ) ),
								'4' => $form->text( $feature_specs['rating_element_size'] + array(
										'value'             => $add_on_config['rating_element_size'],
										'input_group_class' => 'config-col-12',
										'label_class'       => 'config-col-4',
										'input_class'       => 'config-col-2'
									) )
			    )));

	            $form->option_group( $feature_specs, array(
			            'option-heading'    => 'Rating Layout',
			            'class'             => 'eckb-mm-ap-links-ratingandfeedback-features-articlerating ',
			            'inputs'            => array(
					            '0' => $form->radio_buttons_vertical( $feature_specs['rating_layout'] + array(
							            'value'             => $add_on_config['rating_layout'],
							            'current'           => $add_on_config['rating_layout'],
							            'input_group_class' => 'config-col-12',
							            'main_label_class'  => 'config-col-4',
							            'input_class'       => 'config-col-8',
							            'radio_class'       => 'config-col-12')),
								'2' => $form->radio_buttons_vertical( $feature_specs['rating_like_style'] + array(
										'value'             => $add_on_config['rating_like_style'],
										'current'           => $add_on_config['rating_like_style'],
										'input_group_class' => 'config-col-12 likedislike-mode',
										'main_label_class'  => 'config-col-4',
										'input_class'       => 'config-col-8',
										'radio_class'       => 'config-col-12')),
								'3' => $form->text( $feature_specs['rating_like_style_yes_button'] + array(
										'value'             => $add_on_config['rating_like_style_yes_button'],
										'input_group_class' => 'config-col-12 likedislike-mode',
										'label_class'       => 'config-col-4',
										'input_class'       => 'config-col-5') ),
								'4' => $form->text( $feature_specs['rating_like_style_no_button'] + array(
										'value'             => $add_on_config['rating_like_style_no_button'],
										'input_group_class' => 'config-col-12 likedislike-mode',
										'label_class'       => 'config-col-4',
										'input_class'       => 'config-col-5') ),
								'5' => $form->text( $feature_specs['rating_out_of_stars_text'] + array(
										'value'             => $add_on_config['rating_out_of_stars_text'],
										'input_group_class' => 'config-col-12 stars-mode',
										'label_class'       => 'config-col-4',
										'input_class'       => 'config-col-7'
									) ),
								'6' => $form->text( $feature_specs['rating_stars_text'] + array(
										'value'             => $add_on_config['rating_stars_text'],
										'input_group_class' => 'config-col-12 stars-mode',
										'label_class'       => 'config-col-4',
										'input_class'       => 'config-col-7'
									) ),
								'7' => $form->text( $feature_specs['rating_stars_text_1'] + array(
										'value'             => $add_on_config['rating_stars_text_1'],
										'input_group_class' => 'config-col-12 stars-mode',
										'label_class'       => 'config-col-4',
										'input_class'       => 'config-col-7'
									) ),
								'8' => $form->text( $feature_specs['rating_stars_text_2'] + array(
										'value'             => $add_on_config['rating_stars_text_2'],
										'input_group_class' => 'config-col-12 stars-mode',
										'label_class'       => 'config-col-4',
										'input_class'       => 'config-col-7'
									) ),
								'9' => $form->text( $feature_specs['rating_stars_text_3'] + array(
										'value'             => $add_on_config['rating_stars_text_3'],
										'input_group_class' => 'config-col-12 stars-mode',
										'label_class'       => 'config-col-4',
										'input_class'       => 'config-col-7'
									) ),
								'10' => $form->text( $feature_specs['rating_stars_text_4'] + array(
										'value'             => $add_on_config['rating_stars_text_4'],
										'input_group_class' => 'config-col-12 stars-mode',
										'label_class'       => 'config-col-4',
										'input_class'       => 'config-col-7'
									) ),
								'11' => $form->text( $feature_specs['rating_stars_text_5'] + array(
										'value'             => $add_on_config['rating_stars_text_5'],
										'input_group_class' => 'config-col-12 stars-mode',
										'label_class'       => 'config-col-4',
										'input_class'       => 'config-col-7'
									) ),

			            )));

	            $form->option_group( $feature_specs, array(
			            'option-heading'    => 'Rating Details',
			            'class'             => 'eckb-mm-ap-links-ratingandfeedback-features-articlerating',
			            'inputs'            => array(
								'1' => $form->text( $feature_specs['rating_text_value'] + array(
												'value'             => $add_on_config['rating_text_value'],
												'input_group_class' => 'config-col-12',
												'label_class'       => 'config-col-4',
												'input_class'       => 'config-col-7'
										) ),
								/** '2' => $form->text( $feature_specs['rating_after_vote_text'] + array(
												'value'             => $add_on_config['rating_after_vote_text'],
												'input_group_class' => 'config-col-12',
												'label_class'       => 'config-col-4',
												'input_class'       => 'config-col-7'
										) ), */
					            '3' => $form->text( $feature_specs['rating_text_color'] + array(
									            'value'             => $add_on_config['rating_text_color'],
									            'input_group_class' => 'config-col-12',
									            'class'             => 'ekb-color-picker',
									            'label_class'       => 'config-col-4',
									            'input_class'       => 'config-col-5 ekb-color-picker'
							            ) ),
								'4' => $form->text( $feature_specs['rating_dropdown_color'] + array(
									            'value'             => $add_on_config['rating_dropdown_color'],
									            'input_group_class' => 'config-col-12',
									            'class'             => 'ekb-color-picker',
									            'label_class'       => 'config-col-4',
									            'input_class'       => 'config-col-5 ekb-color-picker'
							            ) ),
			    )));

	            $form->option_group( $feature_specs, array(
			            'option-heading'    => 'Rating Confirmation',
			            'class'             => 'eckb-mm-ap-links-ratingandfeedback-features-articlerating',
			            'inputs'            => array(
								'0' => $form->text( $feature_specs['rating_confirmation_positive'] + array(
												'value'             => $add_on_config['rating_confirmation_positive'],
												'input_group_class' => 'config-col-12',
												'label_class'       => 'config-col-4',
												'input_class'       => 'config-col-7'
										) ),
								'1' => $form->text( $feature_specs['rating_confirmation_negative'] + array(
												'value'             => $add_on_config['rating_confirmation_negative'],
												'input_group_class' => 'config-col-12',
												'label_class'       => 'config-col-4',
												'input_class'       => 'config-col-7'
										) ),
			    )));	
				
				// ARTICLE FEEDBACK OPRIONS
				$form->option_group( $feature_specs, array(
			            'option-heading'    => 'Rating Feedback Form',
			            'class'             => 'eckb-mm-ap-links-ratingandfeedback-features-articlefeedback',
			            'inputs'            => array(
				                '0' => $form->dropdown( $feature_specs['rating_feedback_trigger_stars'] + array(
						                        'value'             => $add_on_config['rating_feedback_trigger_stars'],
						                        'current'           => $add_on_config['rating_feedback_trigger_stars'],
												'input_group_class' => 'config-col-12 stars-mode',
						                        'label_class'       => 'config-col-4',
						                        'input_class'       => 'config-col-7'
					            ) ),
								'1' => $form->dropdown( $feature_specs['rating_feedback_trigger_like'] + array(
						                        'value'             => $add_on_config['rating_feedback_trigger_like'],
						                        'current'           => $add_on_config['rating_feedback_trigger_like'],
												'input_group_class' => 'config-col-12 likedislike-mode',
						                        'label_class'       => 'config-col-4',
						                        'input_class'       => 'config-col-7'
					            ) ),
								'2' => $form->text( $feature_specs['rating_feedback_title'] + array(
												'value'             => $add_on_config['rating_feedback_title'],
												'input_group_class' => 'config-col-12',
												'label_class'       => 'config-col-4',
												'input_class'       => 'config-col-5'
										) ),
								'3' => $form->checkbox( $feature_specs['rating_feedback_name_prompt'] + array(
												'value'             => $add_on_config['rating_feedback_name_prompt'],
												'input_group_class' => 'config-col-12',
												'label_class'       => 'config-col-4',
												'input_class'       => 'config-col-7'
										) ),
								'4' => $form->checkbox( $feature_specs['rating_feedback_email_prompt'] + array(
												'value'             => $add_on_config['rating_feedback_email_prompt'],
												'input_group_class' => 'config-col-12',
												'label_class'       => 'config-col-4',
												'input_class'       => 'config-col-7'
										) ),
								'5' => $form->textarea( $feature_specs['rating_feedback_description'] + array(
												'value'             => $add_on_config['rating_feedback_description'],
												'input_group_class' => 'config-col-12',
												'label_class'       => 'config-col-4',
												'input_class'       => 'config-col-7'
										) ),
								'6' => $form->text( $feature_specs['rating_feedback_support_link_text'] + array(
												'value'             => $add_on_config['rating_feedback_support_link_text'],
												'input_group_class' => 'config-col-12',
												'label_class'       => 'config-col-4',
												'input_class'       => 'config-col-5'
										) ),
								'7' => $form->text( $feature_specs['rating_feedback_support_link_url'] + array(
												'value'             => $add_on_config['rating_feedback_support_link_url'],
												'input_group_class' => 'config-col-12',
												'label_class'       => 'config-col-4',
												'input_class'       => 'config-col-5'
										) ),
								'8' => $form->text( $feature_specs['rating_feedback_button_color'] + array(
									            'value'             => $add_on_config['rating_feedback_button_color'],
									            'input_group_class' => 'config-col-12 stars-mode',
									            'class'             => 'ekb-color-picker',
									            'label_class'       => 'config-col-4',
									            'input_class'       => 'config-col-7 ekb-color-picker'
							            ) ),
								'9' => $form->text( $feature_specs['rating_feedback_button_text'] + array(
												'value'             => $add_on_config['rating_feedback_button_text'],
												'input_group_class' => 'config-col-12',
												'label_class'       => 'config-col-4',
												'input_class'       => 'config-col-5'
										) )
								
			    )));
        echo    '</div>';
        echo '</div>';
    }

	/**
	 * Show content of a menu item (list of links on the right side)
	 *
	 * @param array $args
	 */
	private function mega_menu_item_content( $args = array() ) {

		echo '<div class="ep'.'kb-mm-links ' . ( empty($args['class']) ? '' : $args['class'] ) . '" id="' . $args['id'] . '-list' . '">';
		$total = count( $args['sections'] );
		foreach( $args['sections'] as $section ) {
			if ( ! empty($section['exclude']) ) {
				$total = $total - 1;
			}
		}

		foreach( $args['sections'] as $section ) {

			if ( ! empty($section['exclude']) ) {
				continue;
			}

			echo '<section class="ep'.'kb-section-count-' . $total . '">' .
			     '	<h3>' . ( empty($section['heading']) ? '' :  __( $section['heading'], 'echo-article-rating-and-feedback' ) ) . '</h3>' .
			     '   <p>' . ( empty($section['info']) ? '' : $section['info'] ) .'</p>' .
			     '	<ul>';

			foreach ( $section[ 'links'] as $link ) {
				$linkID = $args['id'] . '-' . str_replace( array( ' ', ':' ), '', strtolower($section['heading'] . '-' . $link ) );
				echo '<li id="' . $linkID . '">' . __( $link, 'echo-article-rating-and-feedback' ) . '</li>';
			}

			echo '	</ul>' .
			     '</section>';
		}
		echo '</div>';
	}
}
