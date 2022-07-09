<?php

/**
 * Lists all KB configuration settings and adds filter to get configuration from add-ons.
 *
 * @copyright   Copyright (C) 2018, Echo Plugins
 */
class EPRF_KB_Config_Specs {

	private static $cached_specs = array();

	/**
	 * Defines how KB configuration fields will be displayed, initialized and validated/sanitized
	 *
	 * ALL FIELDS ARE MANDATORY by default ( otherwise use 'mandatory' => false )
	 *
	 * @return array with KB config specification
	 */
	public static function get_fields_specification() {

		// retrieve settings if already cached
		if ( ! empty(self::$cached_specs) && is_array(self::$cached_specs) ) {
			return self::$cached_specs;
		}

		// get all configuration
		$config_specification = array(

			// RATING ELEMENT SETUP
			'rating_switch_off' => array(
				'label'       => __( 'Switch off Rating for this KB', 'echo-article-rating-and-feedback' ),
				'name'        => 'rating_switch_off',
				'type'        => EPRF_Input_Filter::CHECKBOX,
				'default'     => 'off'
			),
			'article_content_enable_rating_element' => array(
				'label'       => __( 'Rating Element', 'echo-article-rating-and-feedback' ),
				'name'        => 'article_content_enable_rating_element',
				'type'        => EPRF_Input_Filter::CHECKBOX,
				'default'     => 'on'
			),
			'rating_element_row' => array(
				'label'       => __( 'Row', 'echo-article-rating-and-feedback' ),
				'name'        => 'rating_element_row',
				'type'        => EPRF_Input_Filter::SELECTION,
				'options'     => array(
					'1'  => _x( 'Row 1', 'echo-article-rating-and-feedback' ),
					'2'  => _x( 'Row 2', 'echo-article-rating-and-feedback' ),
					'3'  => _x( 'Row 3', 'echo-article-rating-and-feedback' ),
					'4'  => _x( 'Row 4', 'echo-article-rating-and-feedback' ),
					'5'  => _x( 'Row 5', 'echo-article-rating-and-feedback' ),
					'article-bottom'  => _x( 'Article Bottom', 'echo-article-rating-and-feedback' ) ),
				'default'     => 'article-bottom'
			),
			'rating_element_alignment' => array(
				'label'       => __( 'Alignment', 'echo-article-rating-and-feedback' ),
				'name'        => 'rating_element_alignment',
				'type'        => EPRF_Input_Filter::SELECTION,
				'options'     => array(
					'left'  => _x( 'Left', 'echo-article-rating-and-feedback' ),
					'right' => _x( 'Right', 'echo-article-rating-and-feedback' ) ),
				'default'     => 'left'
			),
			'rating_element_sequence' => array(
				'label'       => __( 'Sequence in the Alignment', 'echo-article-rating-and-feedback' ),
				'name'        => 'rating_element_sequence',
				'type'        => EPRF_Input_Filter::SELECTION,
				'options'     => array(
					'1' => _x( '1', 'echo-article-rating-and-feedback' ),
					'2' => _x( '2', 'echo-article-rating-and-feedback' ),
					'3' => _x( '3', 'echo-article-rating-and-feedback' ),
					'4' => _x( '4', 'echo-article-rating-and-feedback' ),
					'5' => _x( '5', 'echo-article-rating-and-feedback' ) ),
				'default'     => '1'
			),

			'rating_stats_footer_toggle' => array(
				'label'       => __( 'Show Rating Stats', 'echo-article-rating-and-feedback' ),
				'name'        => 'rating_stats_footer_toggle',
				'type'        => EPRF_Input_Filter::CHECKBOX,
				'default'     => 'off'
			),

			// RATING STATISTICS
			'article_content_enable_rating_stats' => array(
				'label'       => __( 'Rating Statistics', 'echo-article-rating-and-feedback' ),
				'name'        => 'article_content_enable_rating_stats',
				'type'        => EPRF_Input_Filter::CHECKBOX,
				'default'     => 'on'
			),
			'rating_statistics_row' => array(
				'label'       => __( 'Row', 'echo-article-rating-and-feedback' ),
				'name'        => 'rating_statistics_row',
				'type'        => EPRF_Input_Filter::SELECTION,
				'options'     => array(
					'1' => _x( 'Row 1', 'echo-article-rating-and-feedback' ),
					'2' => _x( 'Row 2', 'echo-article-rating-and-feedback' ),
					'3' => _x( 'Row 3', 'echo-article-rating-and-feedback' ),
					'4' => _x( 'Row 4', 'echo-article-rating-and-feedback' ),
					'5' => _x( 'Row 5', 'echo-article-rating-and-feedback' )
				),
				'default'     => '3'
			),
			'rating_statistics_alignment' => array(
				'label'       => __( 'Alignment', 'echo-article-rating-and-feedback' ),
				'name'        => 'rating_statistics_alignment',
				'type'        => EPRF_Input_Filter::SELECTION,
				'options'     => array(
					'left'  => _x( 'Left', 'echo-article-rating-and-feedback' ),
					'right' => _x( 'Right', 'echo-article-rating-and-feedback' )
				),
				'default'     => 'left'
			),
			'rating_statistics_sequence' => array(
				'label'       => __( 'Sequence in the Alignment', 'echo-article-rating-and-feedback' ),
				'name'        => 'rating_statistics_sequence',
				'type'        => EPRF_Input_Filter::SELECTION,
				'options'     => array(
					'1' => _x( '1', 'echo-article-rating-and-feedback' ),
					'2' => _x( '2', 'echo-article-rating-and-feedback' ),
					'3' => _x( '3', 'echo-article-rating-and-feedback' ),
					'4' => _x( '4', 'echo-article-rating-and-feedback' ),
					'5' => _x( '5', 'echo-article-rating-and-feedback' )
				),
				'default'     => '4'
			),

			// RATING ELEMENT
			'rating_layout' => array(
				'label'       => __( 'Rating Layout', 'echo-article-rating-and-feedback' ),
					'name'        => 'rating_layout',
				'type'        => EPRF_Input_Filter::SELECTION,
				'options'     => array(
					'rating_layout_1' => 'Text beside Rating Element',
					'rating_layout_2' => 'Text above Rating Element',
					//'rating_layout_3'          => 'Text beside Rating Element beside Statistics',
					//'rating_layout_4'          => 'Text above Rating Element beside Statistics',
				),
				'default'     => 'rating_layout_1',
			),
			'rating_mode' => array(
				'label'       => __( 'Mode', 'echo-article-rating-and-feedback' ),
				'name'        => 'rating_mode',
				'type'        => EPRF_Input_Filter::SELECTION,
				'options'     => array(
					'eprf-rating-mode-five-stars'   => __( '5 Stars', 'echo-article-rating-and-feedback' ),
					'eprf-rating-mode-like-dislike' => __( 'Like / Dislike', 'echo-article-rating-and-feedback' ),
				),
				'default'     => 'eprf-rating-mode-five-stars'
			),
			'rating_element_color' => array(
				'label'       => __( 'Rating Element', 'echo-article-rating-and-feedback' ),
				'name'        => 'rating_element_color',
				'size'        => '10',
				'max'         => '7',
				'min'         => '7',
				'type'        => EPRF_Input_Filter::COLOR_HEX,
				'default'     => '#1e73be'
			),
			'rating_like_color' => array(
				'label'       => __( 'Button Up ', 'echo-article-rating-and-feedback' ),
				'name'        => 'rating_like_color',
				'size'        => '10',
				'max'         => '7',
				'min'         => '7',
				'type'        => EPRF_Input_Filter::COLOR_HEX,
				'default'     => '#81d742'
			),
			'rating_dislike_color' => array(
				'label'       => __( 'Button Down', 'echo-article-rating-and-feedback' ),
				'name'        => 'rating_dislike_color',
				'size'        => '10',
				'max'         => '7',
				'min'         => '7',
				'type'        => EPRF_Input_Filter::COLOR_HEX,
				'default'     => '#dd3333'
			),
			'rating_element_size'  => array(
				'label'       => __( 'Rating Element Size', 'echo-article-rating-and-feedback' ),
				'name'        => 'rating_element_size',
				'max'         => '50',
				'min'         => '1',
				'type'        => EPRF_Input_Filter::NUMBER,
				'default'     => 30
			),
			'rating_out_of_stars_text' => array(
				'label'       => __( 'Out Of Stars Text', 'echo-article-rating-and-feedback' ),
				'name'        => 'rating_out_of_stars_text',
				'size'        => '30',
				'max'         => '50',
				'min'         => '0',
				'mandatory'   => false,
				'type'        => EPRF_Input_Filter::TEXT,
				'default'     => __( 'out of 5 stars', 'echo-article-rating-and-feedback' )
			),
			'rating_stars_text' => array(
				'label'       => __( 'Stars Text', 'echo-article-rating-and-feedback' ),
				'name'        => 'rating_stars_text',
				'size'        => '30',
				'max'         => '50',
				'min'         => '0',
				'mandatory'   => false,
				'type'        => EPRF_Input_Filter::TEXT,
				'default'     => __( 'Stars', 'echo-article-rating-and-feedback' )
			),
			'rating_stars_text_1' => array(
				'label'       => __( 'Rating Hover Description 1', 'echo-article-rating-and-feedback' ),
				'name'        => 'rating_stars_text_1',
				'size'        => '30',
				'max'         => '50',
				'min'         => '0',
				'mandatory'   => false,
				'type'        => EPRF_Input_Filter::TEXT,
				'default'     => __( 'Unusable Documentation', 'echo-article-rating-and-feedback' )
			),
			'rating_stars_text_2' => array(
				'label'       => __( 'Rating Hover Description 2', 'echo-article-rating-and-feedback' ),
				'name'        => 'rating_stars_text_2',
				'size'        => '30',
				'max'         => '50',
				'min'         => '0',
				'mandatory'   => false,
				'type'        => EPRF_Input_Filter::TEXT,
				'default'     => __( 'Poor Documentation', 'echo-article-rating-and-feedback' )
			),
			'rating_stars_text_3' => array(
				'label'       => __( 'Rating Hover Description 3', 'echo-article-rating-and-feedback' ),
				'name'        => 'rating_stars_text_3',
				'size'        => '30',
				'max'         => '50',
				'min'         => '0',
				'mandatory'   => false,
				'type'        => EPRF_Input_Filter::TEXT,
				'default'     => __( 'OK Documentation', 'echo-article-rating-and-feedback' )
			),
			'rating_stars_text_4' => array(
				'label'       => __( 'Rating Hover Description 4', 'echo-article-rating-and-feedback' ),
				'name'        => 'rating_stars_text_4',
				'size'        => '30',
				'max'         => '50',
				'min'         => '0',
				'mandatory'   => false,
				'type'        => EPRF_Input_Filter::TEXT,
				'default'     => __( 'Good Documentation', 'echo-article-rating-and-feedback' )
			),
			'rating_stars_text_5' => array(
				'label'       => __( 'Rating Hover Description 5', 'echo-article-rating-and-feedback' ),
				'name'        => 'rating_stars_text_5',
				'size'        => '30',
				'max'         => '50',
				'min'         => '0',
				'mandatory'   => false,
				'type'        => EPRF_Input_Filter::TEXT,
				'default'     => __( 'Excellent Documentation', 'echo-article-rating-and-feedback' )
			),
			'rating_like_style'   => array(
				'label'       => __( 'Like/Dislike Style', 'echo-article-rating-and-feedback' ),
				'name'        => 'rating_like_style',
				'type'        => EPRF_Input_Filter::SELECTION,
				'options'     => array(
					'rating_like_style_1' => 'Thumbs Up / Down',
					'rating_like_style_2' => 'Check / Cross',
					'rating_like_style_3' => 'Arrow Up / Down',
					'rating_like_style_4' => 'Buttons',
				),
				'default'     => 'rating_like_style_1',
			),
			'rating_like_style_yes_button' => array(
				'label'       => __( 'Button Positive Text', 'echo-article-rating-and-feedback' ),
				'name'        => 'rating_like_style_yes_button',
				'size'        => '30',
				'max'         => '50',
				'min'         => '0',
				'mandatory'   => false,
				'type'        => EPRF_Input_Filter::TEXT,
				'default'     => __( 'Yes', 'echo-article-rating-and-feedback' )
			),
			'rating_like_style_no_button' => array(
				'label'       => __( 'Button Negative Text', 'echo-article-rating-and-feedback' ),
				'name'        => 'rating_like_style_no_button',
				'size'        => '30',
				'max'         => '50',
				'min'         => '0',
				'mandatory'   => false,
				'type'        => EPRF_Input_Filter::TEXT,
				'default'     => __( 'No', 'echo-article-rating-and-feedback' )
			),
			'rating_text_value'   => array(
				'label'       => __( 'Rating Instructions', 'echo-article-rating-and-feedback' ),
				'name'        => 'rating_text_value',
				'size'        => '50',
				'max'         => '200',
				'min'         => '1',
				'mandatory'   => false,
				'type'        => EPRF_Input_Filter::TEXT,
				'default'     => __( 'Was this article helpful?', 'echo-article-rating-and-feedback' )
			),
			'rating_text_color' => array(
				'label'       => __( 'Text', 'echo-article-rating-and-feedback' ),
				'name'        => 'rating_text_color',
				'size'        => '10',
				'max'         => '7',
				'min'         => '7',
				'type'        => EPRF_Input_Filter::COLOR_HEX,
				'default'     => '#000000'
			),
			'rating_dropdown_color' => array(
				'label'       => __( 'Stats Drop-Down', 'echo-article-rating-and-feedback' ),
				'name'        => 'rating_dropdown_color',
				'size'        => '10',
				'max'         => '7',
				'min'         => '7',
				'type'        => EPRF_Input_Filter::COLOR_HEX,
				'default'     => '#1e73be'
			),
			'rating_text_typography' => array(
				'label'       => __( 'Typography', 'echo-knowledge-base' ),
				'name'        => 'rating_text_typography',
				'type'        => EPRF_Input_Filter::TYPOGRAPHY,
				'default' => array(
					'font-family'     => '',
					'font-size'       => '16',
					'font-size-units' => 'px',
					'font-weight'     => '',
				)
			),

			// RATING CONFIRMATION
			'rating_confirmation_positive' => array(
				'label'       => __( 'Show message after user voted.', 'echo-article-rating-and-feedback' ),
				'name'        => 'rating_confirmation_positive',
				'size'        => '50',
				'max'         => '200',
				'min'         => '0',
				'type'        => EPRF_Input_Filter::TEXT,
				'default'     => __( 'Your vote has been submitted. Thanks!', 'echo-article-rating-and-feedback' )
			),
			'rating_confirmation_negative' => array(
				'label'       => __( 'Show message if user voted twice.', 'echo-article-rating-and-feedback' ),
				'name'        => 'rating_confirmation_negative',
				'size'        => '50',
				'max'         => '200',
				'min'         => '0',
				'type'        => EPRF_Input_Filter::TEXT,
				'default'     => __( 'We already received your feedback.', 'echo-article-rating-and-feedback' )
			),

			// ARTICLE FEEDBACK OPRIONS
			'rating_feedback_title' => array(
				'label'       => __( 'Form Title', 'echo-article-rating-and-feedback' ),
				'name'        => 'rating_feedback_title',
				'type'        => EPRF_Input_Filter::TEXT,
				'max'         => '200',
				'min'         => '0',
				'default'     => __( 'How can we improve this article?', 'echo-article-rating-and-feedback' ),
			),
			'rating_feedback_required_title' => array(
				'label'   => __( 'Reason for required form submission', 'echo-article-rating-and-feedback' ),
				'name'    => 'rating_feedback_required_title',
				'type'    => EPRF_Input_Filter::TEXT,
				'max'     => '200',
				'min'     => '0',
				'default' => __( 'Please submit the reason for your vote so that we can improve the article.', 'echo-article-rating-and-feedback' ),
			),
			'rating_feedback_name_prompt' => array(
				'label'       => __( 'Show the Name Field?', 'echo-article-rating-and-feedback' ),
				'name'        => 'rating_feedback_name_prompt',
				'type'        => EPRF_Input_Filter::CHECKBOX,
				'default'     => 'on'
			),
			'rating_feedback_email_prompt' => array(
				'label'       => __( 'Show the Email Field?', 'echo-article-rating-and-feedback' ),
				'name'        => 'rating_feedback_email_prompt',
				'type'        => EPRF_Input_Filter::CHECKBOX,
				'default'     => 'on'
			),
			'rating_feedback_name' => array(
				'label'       => __( 'Name Hint for the User', 'echo-article-rating-and-feedback' ),
				'name'        => 'rating_feedback_name',
				'type'        => EPRF_Input_Filter::TEXT,
				'max'         => '200',
				'min'         => '0',
				'default'     => __( 'Name', 'echo-article-rating-and-feedback' ),
				'mandatory'   => false
			),
			'rating_feedback_email' => array(
				'label'       => __( 'Email Hint for the User', 'echo-article-rating-and-feedback' ),
				'name'        => 'rating_feedback_email',
				'type'        => EPRF_Input_Filter::TEXT,
				'max'         => '200',
				'min'         => '0',
				'default'     => __( 'Email', 'echo-article-rating-and-feedback' ),
				'mandatory'   => false
			),
			'rating_feedback_description' => array(
				'label'       => __( 'Description Hint for the User', 'echo-article-rating-and-feedback' ),
				'name'        => 'rating_feedback_description',
				'type'        => EPRF_Input_Filter::TEXT,
				'max'         => '200',
				'min'         => '0',
				'default'     => '',
				'mandatory'   => false
			),
			'rating_feedback_support_link_text' => array(
				'label'       => __( 'Text for Support URL Link', 'echo-article-rating-and-feedback' ),
				'name'        => 'rating_feedback_support_link_text',
				'type'        => EPRF_Input_Filter::TEXT,
				'max'         => '200',
				'min'         => '0',
				'default'     => 'Need help?',
				'mandatory'   => false
			),
			'rating_feedback_support_link_url' => array(
				'label'       => __( 'Support Link URL (format: https://&lt;your link&gt;)', 'echo-article-rating-and-feedback' ),
				'name'        => 'rating_feedback_support_link_url',
				'type'        => EPRF_Input_Filter::TEXT,
				'max'         => '200',
				'min'         => '0',
				'default'     => '',
				'mandatory'   => false
			),
			'rating_feedback_button_color' => array(
				'label'       => __( 'Submit Button', 'echo-article-rating-and-feedback' ),
				'name'        => 'rating_feedback_button_color',
				'size'        => '10',
				'max'         => '7',
				'min'         => '7',
				'type'        => EPRF_Input_Filter::COLOR_HEX,
				'default'     => '#000000'
			),
			'rating_feedback_button_text' => array(
				'label'       => __( 'Submit Button Text', 'echo-article-rating-and-feedback' ),
				'name'        => 'rating_feedback_button_text',
				'type'        => EPRF_Input_Filter::TEXT,
				'default'     => __( 'Submit', 'echo-article-rating-and-feedback' ),
			),
			'rating_feedback_trigger_stars' => array(
				'label'       => __( 'When Does the Feedback Form Becomes Visible?', 'echo-article-rating-and-feedback' ),
				'name'        => 'rating_feedback_trigger_stars',
				'type'        => EPRF_Input_Filter::SELECTION,
				'options'     => array(
					'never'         => __( 'Only if feedback is forced', 'echo-article-rating-and-feedback' ),
					'always'        => __( 'Always', 'echo-article-rating-and-feedback' ), //important to be second or first in the list
					'negative-four' => __( 'If user votes less than 4 stars', 'echo-article-rating-and-feedback' ),
					'negative-five' => __( 'If user votes less than 5 stars', 'echo-article-rating-and-feedback' ),
					'user-votes'    => __( 'If user votes', 'echo-article-rating-and-feedback' ),
				),
				'default'     => 'negative-four'
			),
			'rating_feedback_required_stars' => array(
				'label'       => __( 'Show Feedback Form and Force Feedback', 'echo-article-rating-and-feedback' ),
				'name'        => 'rating_feedback_required_stars',
				'type'        => EPRF_Input_Filter::SELECTION,
				'options'     => array(
					'never'         => __( 'Never', 'echo-article-rating-and-feedback' ),
					'negative-four' => __( 'If user votes less than 4 stars', 'echo-article-rating-and-feedback' ),
					'negative-five' => __( 'If user votes less than 5 stars', 'echo-article-rating-and-feedback' ),
				),
				'default' => 'never'
			),
			'rating_feedback_trigger_like' => array(
				'label'       => __( 'When Does the Feedback Form Becomes Visible?', 'echo-article-rating-and-feedback' ),
				'name'        => 'rating_feedback_trigger_like',
				'type'        => EPRF_Input_Filter::SELECTION,
				'options'     => array(
					'never'   => __( 'Only if feedback is forced', 'echo-article-rating-and-feedback' ),
					'always'  => __( 'Always', 'echo-article-rating-and-feedback' ), // important to be second or first in the list
					'dislike' => __( 'If user votes down', 'echo-article-rating-and-feedback' ),
				),
				'default'     => 'dislike'
			),
			'rating_feedback_required_like' => array(
				'label'       => __( 'Show Feedback Form and Force Feedback' ),
				'name'        => 'rating_feedback_required_like',
				'type'        => EPRF_Input_Filter::SELECTION,
				'options'     => array(
					'never'         => __( 'Never', 'echo-article-rating-and-feedback' ),
					'negative-five' => __( 'If user votes down', 'echo-article-rating-and-feedback' ),
				),
				'default' => 'never'
			),
		);

		self::$cached_specs = $config_specification;

		return self::$cached_specs;
	}

	/**
	 * Get KB default configuration
	 *
	 * @return array contains default values for KB configuration
	 */
	public static function get_default_kb_config() {
		$config_specs = self::get_fields_specification();

		$configuration = array();
		foreach( $config_specs as $key => $spec ) {
			$default = isset($spec['default']) ? $spec['default'] : '';
			$configuration += array( $key => $default );
		}

		return $configuration;
	}

	/**
	 * Get names of all configuration items for KB configuration
	 * @return array
	 */
	public static function get_specs_item_names() {
		return array_keys( self::get_fields_specification() );
	}

	/**
	 * Return default values from given specification.
	 * @param $config_specs
	 * @return array
	 */
	public static function get_specs_defaults( $config_specs ) {
		$default_configuration = array();
		foreach( $config_specs as $key => $spec ) {
			$default = isset($spec['default']) ? $spec['default'] : '';
			$default_configuration += array( $key => $default );
		}
		return $default_configuration;
	}
}
