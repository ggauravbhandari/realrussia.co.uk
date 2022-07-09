<?php
namespace Creative_Addons\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Creative_Addons\Includes\Kb\KB_Utilities;
use Elementor\Group_Control_Background;


defined( 'ABSPATH' ) || exit();

/**
 * KB Search Box widget for Elementor
 */
class KB_Search_Box extends Creative_Widget_Base {

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __('KB Search', 'creative-addons-for-elementor');
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'crelfont crel-kb-search-icon';

		//return 'fab fa-searchengin';
	}

	/**
	 * Retrieve the widget Demo URL.
	 *
	 * @return string Widget Demo URL.
	 */
	public function get_demo_url() {
		return 'https://www.creative-addons.com/elementor-widgets/knowledge-base-search/';
	}

	/**
	 * Retrieve the widget Documentation URL.
	 *
	 * @return string Widget Documentation URL.
	 */
	public function get_documentation_url() {
		return 'https://www.creative-addons.com/elementor-docs/kb-search-box-widget/';
	}
	
	public function is_editable() {
		return KB_Utilities::is_kb_plugin_active();
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 2.1.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'search', 'knowledgebase', 'kb', 'knowledge' ];
	}

	protected function get_config_defaults() {

		return [
			'crel_kbSearchBox__title_color' => '#000000',
			'crel_kbSearchBox__title_typography'                  => 'custom',
			'crel_kbSearchBox__title_typography_font_size' => [
				'size' => 25,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_kbSearchBox__title_toggle'                                => 'yes',
			'crel_kbSearchBox__title_text'                                  => __( 'How can we Help?', 'creative-addons-for-elementor' ),
			'crel_kbSearchBox__title_HTMLTag'                               => 'h3',
			'crel_kbSearchBox__inputPlaceholder_text'                       => __('Have a question? Enter a search term.', 'creative-addons-for-elementor'),
			'crel_kbSearchBox__button_typography_typography'                  => 'custom',
			'crel_kbSearchBox__button_typography_font_size' => [
				'size' => 16,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_kbSearchBox__button_type'                                 => 'text',
			'crel_kbSearchBox__Button_Text'                                 => __('Search', 'creative-addons-for-elementor'),
			'crel_kbSearchBox__button_icon'                                 => [
				'value' => 'fas fa-search',
				'library' => 'fa-solid',
			],
			'crel_kbSearchBox__HelpURL'                                     => [
				'url' => '#'
			],
			'crel_kbSearchBox__title_padding'                               => [
				'top'       => '0',
				'right'     => '0',
				'bottom'    => '10',
				'left'      => '0',
			],
			'crel_kbSearchBox__list_alignment'                              => 'flex-start',
			'crel_kbSearchBox__input_backgroundColorFocus'                  => '#FBF2BA',
			'crel_kbSearchBox__input_borderRadius'                          => [
				'size' => 0,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_kbSearchBox__input_margin'                                => [
				'top'       => '0',
				'right'     => '0',
				'bottom'    => '0',
				'left'      => '0',
			],
			'crel_kbSearchBox__input_padding'                               => [
				'top'       => '20',
				'right'     => '20',
				'bottom'    => '20',
				'left'      => '20',
			],
			
			'crel_kbSearchBox__input_padding_mobile'                        => [
				'top'       => '10',
				'right'     => '10',
				'bottom'    => '10',
				'left'      => '10',
			],
			'crel_kbSearchBox__button_color' => '#ffffff',
			'crel_kbSearchBox__button_backgroundColor'                      => '#666666',
			'crel_kbSearchBox__button_width'                                => [
				'size' => 150,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_kbSearchBox__buttonIcon_size'                             => [
				'size' => 40,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_kbSearchBox__buttonIcon_size_mobile'                      => [
				'size' => 17,
				'unit' => 'px',
				'sizes' => []
			],

			'crel_kbSearchBox__button_padding'                              => [
				'top'       => '10',
				'left'      => '10',
				'right'     => '10',
				'bottom'    => '10',
				'unit'      => 'px'
			],
			
			'crel_kbSearchBox__InputTypography_typography'                  => 'custom',
			'crel_kbSearchBox__InputTypography_font_size' => [
				'size' => 16,
				'unit' => 'px',
				'sizes' => []
			],
			
			'crel_kbSearchBox__InputTypography_font_size_mobile' => [
				'size' => 14,
				'unit' => 'px',
				'sizes' => []
			],
			
			'crel_kbSearchBox__searchResults_alignment'                     => 'flex-start',
			'crel_kbSearchBox__searchResults_iconPosition'                  => 'icon-first',
			'crel_kbSearchBox__searchResults_maxHeight'                     => [
				'size' => 300,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_kbSearchBox__searchResults_typography_typography' => 'custom',
			'crel_kbSearchBox__searchResults_typography_font_size' => [
				'size' => 16,
				'unit' => 'px',
				'sizes' => []
			],
			
			'crel_kbSearchBox__searchResults_color' => '#000000',
			'crel_kbSearchBox__searchResults_backgroundColor'               => '#ECECEC',
			'crel_kbSearchBox__searchResults_padding'                       => [
				'top' => '0',
				'right' => '0',
				'bottom' => '0',
				'left' => '0',
			],
			'crel_kbSearchBox__searchResults_margin'                        => [
				'top' => '0',
				'right' => '0',
				'bottom' => '30',
				'left' => '0',
			],
			/*'crel_kbSearchBox__SearchResults_Zindex' => [
				'size' => 40,
				'unit' => 'px',
				'sizes' => []
			],*/

			// Search Results
			'crel_kbSearchBox__searchResultsItem_backgroundColor'           => '#ffffff',
			'crel_kbSearchBox__searchResults_backgroundColorHover'          => '#E8E8E8',
			'crel_kbSearchBox__searchResultsIcon_Size'                      => [
				'size' => 19,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_kbSearchBox__searchResultsItem_padding'                   => [
				'top' => '10',
				'right' => '10',
				'bottom' => '10',
				'left' => '10',
			],
			'crel_kbSearchBox__SearchResultsIcon_padding'                   => [
				'top' => '0',
				'right' => '10',
				'bottom' => '0',
				'left' => '0',
			],

		    'crel_kbSearchBox__searchResults_borderType_border'             => 'solid',
			'crel_kbSearchBox__searchResults_borderType_width'              => [
				'top'       => '1',
				'left'      => '1',
				'right'     => '1',
				'bottom'    => '1',
				'unit'      => 'px',
				'isLinked'  => false
			],
			'crel_kbSearchBox__searchResults_borderType_color'              => '#CCCCCC',


			'crel_kbSearchBox__AllResults_backgroundColor'                  => '#F4F4F4',
			'crel_kbSearchBox__allResults_padding'                          => [
				'top' => '20',
				'right' => '12',
				'bottom' => '20',
				'left' => '12',
			],
			'crel_kbSearchBox__allResults_width'                            => [
				'size' => 100,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_kbSearchBox__allResults_typography_typography' => 'custom',
			'crel_kbSearchBox__allResults_typography_font_size' => [
				'size' => 16,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_kbSearchBox__allResults_backgroundColorHover'             => '#E8E8E8',
			'crel_kbSearchBox__helpText_color'                              => '#ffffff',
			'crel_kbSearchBox__helpText_backgroundColor'                    => '#333333',
			'crel_kbSearchBox__helpText_padding'                            => [
				'top' => '20',
				'right' => '12',
				'bottom' => '20',
				'left' => '12',
			],
			
			'crel_kbSearchBox__helpText_typography_typography' => 'custom',
			'crel_kbSearchBox__helpText_typography_font_size' => [
				'size' => 16,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_kbSearchBox__helpText_width'                              => [
				'size' => 100,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_kbSearchBox__allResults_size'                             => 10,
			'crel_kbSearchBox__allResults_text'                             => __('See All Results', 'creative-addons-for-elementor'),
			'crel_kbSearchBox__helpText_text'                               => __('Could not find your question? Contact us here.', 'creative-addons-for-elementor'),
			'crel_kbSearchBox__input_color'                                 => '#666666',
			'crel_kbSearchBox__input_backgroundColor'                       => '#f7f7f7',
			'crel_kbSearchBox__button_color'                                => '#ffffff',

		];
	}

	protected function get_config_rtl_defaults() {
		return [];
	}

	protected function get_presets_defaults() {
		return [];
	}

	protected function get_presets_rtl_defaults() {
		return [];
	}
	
	protected function get_config_old_defaults() {
		return [
			'crel_kbSearchBox__button_backgroundColor'                      => '#666666',
			'crel_kbSearchBox__InputTypography_typography'                  => 'custom',
			'crel_kbSearchBox__InputTypography_typography_font_size_mobile' => [
				'size' => 14,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_kbSearchBox__helpText_backgroundColor'                    => '#333333',
		];
	}

	/**
	 * Return presets for this widget
	 */
	/* public function get_presets_options() {

		$options = array();

		$options['default'] = array(
			'title' => 'List Layout 1',
			'options' => array()
		);

		// Design 2
		$options['design-2'] = array(
			'title' => __( 'List Layout 2', 'creative-addons-for-elementor'),
			'options' => array(

			)
		);

		return $options;
	} */

	/**
	 * CONTENT tab for this widget
	 */
	protected function register_content_controls() {


		// TITLE  ----------------------------------[SECTION]-------------/
		$this->start_controls_section(
			'crel_kbSearchBox__Title__section__ContentTab',
			[
				'label' => __( 'Title', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT
			]
		);

		// Show Title Toggle
		$this->add_control(
			'crel_kbSearchBox__title_toggle',
			[
				'label'     => __( 'Show Title', 'creative-addons-for-elementor'),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => __( 'Yes', 'creative-addons-for-elementor'),
				'label_off' => __( 'No', 'creative-addons-for-elementor'),

			]
		);

		// Title
		$this->add_control(
			'crel_kbSearchBox__title_text',
			[
				'label' => __( 'Title', 'creative-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Type your text here', 'creative-addons-for-elementor' ),
				'condition'	=> [
					'crel_kbSearchBox__title_toggle'	=> 'yes'
				]
			]
		);

		// Title HTML Tag
		$this->add_control(
			'crel_kbSearchBox__title_HTMLTag',
			[
				'label' => __( 'Title HTML Tag', 'creative-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'h1'  => [
						'title' => 'H1',
						'icon' => 'eicon-editor-h1'
					],
					'h2'  => [
						'title' => 'H2',
						'icon' => 'eicon-editor-h2'
					],
					'h3'  => [
						'title' => 'H3',
						'icon' => 'eicon-editor-h3'
					],
					'h4'  => [
						'title' => 'H4',
						'icon' => 'eicon-editor-h4'
					],
					'h5'  => [
						'title' => 'H5',
						'icon' => 'eicon-editor-h5'
					],
					'h6'  => [
						'title' => 'H6',
						'icon' => 'eicon-editor-h6'
					]
				],
				'toggle' => false,
				'condition'	=> [
					'crel_kbSearchBox__title_toggle'	=> 'yes'
				]
			]
		);

		$this->end_controls_section();


		// SEARCH ----------------------------[SECTION]-------------/

		$this->start_controls_section(
			'crel_kbSearchBox__Search__section__ContentTab',
			[
				'label' => __('Search', 'creative-addons-for-elementor'),
				'tab' => Controls_Manager::TAB_CONTENT
			]);

		// Input Placeholder
		$this->add_control(
			'crel_kbSearchBox__inputPlaceholder_text', 
			[
				'label' => __('Placeholder', 'creative-addons-for-elementor'), 
				'label_block' => true, 
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('Have a question? Enter a search term.', 'creative-addons-for-elementor'),
			]);

		// Button type
		$this->add_control(
			'crel_kbSearchBox__button_type', 
			[
				'label' => esc_html__('Button Type', 'creative-addons-for-elementor'), 
				'type' => Controls_Manager::SELECT,
				'label_block' => false, 
				'options' => [
					'text' => esc_html__('Text', 'creative-addons-for-elementor'), 
					'icon' => esc_html__('Icon', 'creative-addons-for-elementor'),
				],
				'separator' => 'before',
			]);

		// Button Text ( Condition if Button type = Text )
		$this->add_control(
			'crel_kbSearchBox__Button_Text', 
			[
				'label' => __('Button Text', 'creative-addons-for-elementor'), 
				'label_block' => true, 
				'type' => Controls_Manager::TEXT,
				'placeholder' => __('Search', 'creative-addons-for-elementor'), 
				'condition' => ['crel_kbSearchBox__button_type' => 'text']
			]);

		// Icon Font Icon ( Condition if Button type = icon )
		$this->add_control(
			'crel_kbSearchBox__button_icon',
			[ 
				'label' => esc_html__('Icon', 'creative-addons-for-elementor'), 
				'type' => Controls_Manager::ICONS,
				'condition' => ['crel_kbSearchBox__button_type' => 'icon']
			]);


		$this->end_controls_section();

		// RESULTS ----------------------------[SECTION]-------------/

		$this->start_controls_section(
				'crel_kbSearchBox__Results__section__ContentTab',
				[
					'label' => __('Results', 'creative-addons-for-elementor'),
					'tab' => Controls_Manager::TAB_CONTENT
				]);

		// All Search Results text
		$this->add_control(
				'crel_kbSearchBox__allResults_size',
				[
					'label' => __('Size of Search Results List',
					'creative-addons-for-elementor'),
					'type' => Controls_Manager::NUMBER,
					'separator' => 'before',  'min' => 3, 'max' => 20, 'step' => 1,
				]);

		// All Search Results text
		$this->add_control(
				'crel_kbSearchBox__allResults_text', 
				[
					'label' => __('All Results Text', 'creative-addons-for-elementor'), 
					'label_block' => true, 'type' => Controls_Manager::TEXT,
					'placeholder' => __('See All Results', 'creative-addons-for-elementor'),
				]);


		// Show Custom Link URL
		$this->add_control(
				'crel_kbSearchBox__showHelpText_toggle',
				[
					'label' => __('Show Help Text', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::SWITCHER, 'label_on' => __('Yes', 'creative-addons-for-elementor'),
					'label_off' => __('No', 'creative-addons-for-elementor'), 'separator' => 'before',
				]);

		// Button Text
		$this->add_control(
				'crel_kbSearchBox__helpText_text', 
				[
					'label' => __('Help Text', 'creative-addons-for-elementor'), 
					'label_block' => true, 'type' => Controls_Manager::TEXT,
					'placeholder' => __('Could not find your question?, contact us here.', 
						'creative-addons-for-elementor'), 
					'condition' => [
						'crel_kbSearchBox__showHelpText_toggle' => 'yes'
					]
				]);

		// Button Link
		$this->add_control(
				'crel_kbSearchBox__HelpURL',
				[
					'label' => __('Help Link URL', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::URL,
					'label_block' => true,
					'placeholder' => __('Enter link URL', 'creative-addons-for-elementor'),
					'show_external' => true,
					'condition' => [
						'crel_kbSearchBox__showHelpText_toggle' => 'yes'
					]
				]);

		$this->end_controls_section();

	}

	/**
	 * STYLE tab for this widget
	 */
	protected function register_style_controls() {

		// TITLE  ----------------------------------[SECTION]-------------/
		$this->start_controls_section(
			'crel_kbSearchBox__Title__section__StyleTab',
			[
				'label' => __( 'Title', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		// Title Padding
		$this->add_control_responsive(
			'crel_kbSearchBox__title_padding',
			[
				'label' => __( 'Padding', 'creative-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .crel-search-box__title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// Title Color
		$this->add_control(
			'crel_kbSearchBox__title_color',
			[
				'label' => __( 'Text Color', 'creative-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .crel-search-box__title' => 'color: {{VALUE}};',
				],
			]
		);

		// Background Color
		$this->add_control(
			'crel_kbSearchBox__title_backgroundColor',
			[
				'label' => __( 'Background Color', 'creative-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .crel-search-box__title' => 'background-color: {{VALUE}};',
				],
			]
		);

		// Title Typography
		$this->add_control_group(
			Group_Control_Typography::get_type(),
			[
				'name' => 'crel_kbSearchBox__title_typography',
				'selector' => '{{WRAPPER}} .crel-search-box__title',
			]
		);

		// Alignment
		$this->add_control(
			'crel_kbSearchBox__list_alignment',
			[
				'label' => __( 'Alignment', 'creative-addons-for-elementor' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'flex-start' => [
						'title' => __( is_rtl() ? 'Right' : 'Left', 'creative-addons-for-elementor' ),
						'icon' => is_rtl() ? 'fa fa-align-right' : 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'creative-addons-for-elementor' ),
						'icon' => 'fa fa-align-center',
					],
					'flex-end' => [
						'title' => __( is_rtl() ? 'Left' : 'Right', 'creative-addons-for-elementor' ),
						'icon' => is_rtl() ? 'fa fa-align-left' : 'fa fa-align-right',
					],
				],
				'toggle' => false,
				'selectors' => [
					'{{WRAPPER}} .crel-search-box__title' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		// Input / Button Container ------------------------------------/
		$this->start_controls_section(
			'crel_kbSearchBox__input_button_container__section__StyleTab',
			[
				'label' => __( 'Input / Button Container', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

			// Input / Button Container Border Type
			$this->add_control_group(
				Group_Control_Border::get_type(),
				[
					'name' => 'crel_kbSearchBox__input_button_container_borderType',
					'label' => esc_html__('Border', 'creative-addons-for-elementor'),
					'selector' => '{{WRAPPER}} .crel-search-box__search-form__inner',
					'separator' => 'before',
				]);

			// Input / Button Container Background Gradient
			$this->add_control_group(
				Group_Control_Background::get_type(),
				[
					'name' => 'crel_kbSearchBox__input_button_container_backgroundColor',
					'label' => __( 'Background Gradient', 'plugin-domain' ),
					'types' => [ 'classic', 'gradient', 'video' ],
					'selector' => '{{WRAPPER}} .crel-search-box__search-form__inner',
					'separator' => 'before'
				]
			);

			// Input / Button Container Padding
			$this->add_control_responsive(
				'crel_kbSearchBox__input_button_container_padding',
				[
					'label' => __('Padding', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [
						'px',
						'em',
						'%'
					],
					'selectors' => [
						'{{WRAPPER}} .crel-search-box__search-form__inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]);

			// Input / Button Container Border Radius
			$this->add_control_responsive(
				'crel_kbSearchBox__input_button_container_borderRadius',
				[
					'label' => __('Border Radius', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 200,
							'step' => 1,
						]
					],
					'selectors' => [
						'{{WRAPPER}} .crel-search-box__search-form__inner' => 'border-radius: {{SIZE}}px;'
					]
				]);

			// Input Box Shadow
			$this->add_control_group(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'crel_kbSearchBox__input_button_container_shadow',
					'selector' => '{{WRAPPER}} .crel-search-box__search-form__inner',
				]);


		$this->end_controls_section();

		// INPUT ---------------------------------[SECTION]-------------/

		$this->start_controls_section(
			'crel_kbSearchBox__Input__section__StyleTab',
			[
				'label' => __('Input', 'creative-addons-for-elementor'), 
				'tab' => Controls_Manager::TAB_STYLE,
			]);

		// Input Placeholder Text Typography
		$this->add_control_group(
			Group_Control_Typography::get_type(), 
			[
				'name' => 'crel_kbSearchBox__InputTypography',
				'selector' => '{{WRAPPER}} .crel-search-box__search-form__input',
			]);


		// START TABS ----------------------------------------/
		$this->start_controls_tabs( '_tabs_button' );

			// Normal Tab ----------------------------/
			$this->start_controls_tab(
				'crel_kbSearchBox__Input_Normal',
				[
					'label' => __('Normal', 'creative-addons-for-elementor'),
				]);

				// Input Color
				$this->add_control(
					'crel_kbSearchBox__input_color',
					[
						'label' => __('Text Color', 'creative-addons-for-elementor'),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .crel-search-box__search-form__input' => 'color: {{VALUE}};',
						],
					]);

				// Input Background Color
				$this->add_control(
					'crel_kbSearchBox__input_backgroundColor',
					[
						'label' => __('Background Color', 'creative-addons-for-elementor'),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .crel-search-box__search-form__input' => 'background-color: {{VALUE}};',
						],
					]);
	
			$this->end_controls_tab();

			// Focus Tab -----------------------------/
			$this->start_controls_tab(
				'crel_kbSearchBox__Input_Focus',
				[
					'label' => __('Focus', 'creative-addons-for-elementor'),
				]);

				// Input Color
				$this->add_control(
					'crel_kbSearchBox__input_colorFocus',
					[
						'label' => __('Text Color', 'creative-addons-for-elementor'),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .crel-search-box__search-form__input:focus' => 'color: {{VALUE}};',
						],
					]);

				// Input Background Color
				$this->add_control(
					'crel_kbSearchBox__input_backgroundColorFocus',
					[
						'label' => __('Background Color', 'creative-addons-for-elementor'),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .crel-search-box__search-form__input:focus' => 'background-color: {{VALUE}};',
						],
					]);

			$this->end_controls_tab();

		$this->end_controls_tabs();

		// Input Border Type
		$this->add_control_group(
			Group_Control_Border::get_type(),
			[
				'name' => 'crel_kbSearchBox__input_borderType',
				'label' => esc_html__('Border', 'creative-addons-for-elementor'), 
				'selector' => '{{WRAPPER}} .crel-search-box__search-form__input',
				'separator' => 'before',
			]);

		// Input Border Radius
		$this->add_control_responsive(
		'crel_kbSearchBox__input_borderRadius',
		[
			'label' => __('Border Radius', 'creative-addons-for-elementor'),
			'type' => Controls_Manager::DIMENSIONS,
			'size_units' => [
				'px',
				'em',
				'%'
			],
			'selectors' => [
				'{{WRAPPER}} .crel-search-box__search-form__input' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		]);

		// Input Box Shadow
		$this->add_control_group(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'crel_kbSearchBox__input_shadow',
				'selector' => '{{WRAPPER}} .crel-search-box__search-form__input',
			]);

		// Input Margin
		$this->add_control_responsive(
			'crel_kbSearchBox__input_margin',
			[
				'label' => __('Margin', 'creative-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS, 
				'size_units' => [
					'px', 
					'em', 
					'%'
				],
				'selectors' => [
					'{{WRAPPER}} .crel-search-box__search-form__input' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'separator' => 'before',
			]);

		// Input Padding
		$this->add_control_responsive(
			'crel_kbSearchBox__input_padding',
			[
				'label' => __('Padding', 'creative-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS, 
				'size_units' => [
					'px',
					'em', 
					'%'
				],
				'selectors' => [
					'{{WRAPPER}} .crel-search-box__search-form__input' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]);

		$this->end_controls_section();



		// BUTTON / ICON ------------------------[SECTION]-------------/
		$this->start_controls_section(
			'crel_kbSearchBox__Button__section__StyleTab', 
			[
				'label' => __('Button / Icon ', 'creative-addons-for-elementor'), 
				'tab' => Controls_Manager::TAB_STYLE,
			]);

		// START TABS ----------------------------------------/
		$this->start_controls_tabs('crel_kbSearchBox__StyleTab__Button_tabs_button');

		// Normal Tab ----------------------------/
		$this->start_controls_tab(
			'crel_kbSearchBox__Button_Normal',
			[
				'label' => __('Normal', 'creative-addons-for-elementor'),
			]);

			// Button / Icon Color
			$this->add_control(
				'crel_kbSearchBox__button_color',
				[
					'label' => __('Icon/Text Color', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crel-search-box__search-form__submit' => 'color: {{VALUE}};',
					],
				]);

			// Button / Icon Background Color
			$this->add_control(
				'crel_kbSearchBox__button_backgroundColor',
				[
					'label' => __('Background Color', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crel-search-box__search-form__submit' => 'background-color: {{VALUE}};',
					],
				]);

			// Button Border Type
			$this->add_control_group(
				Group_Control_Border::get_type(),
				[
					'name' => 'crel_kbSearchBox__button_borderType',
					'label' => esc_html__('Border', 'creative-addons-for-elementor'),
					'selector' => '{{WRAPPER}} .crel-search-box__search-form__submit',
					'separator' => 'before',
				]);

			// Button Border Radius
			$this->add_control_responsive(
			'crel_kbSearchBox__button_borderRadius',
			[
				'label' => __('Border Radius', 'creative-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [
					'px',
					'em',
					'%'
				],
				'selectors' => [
					'{{WRAPPER}} .crel-search-box__search-form__submit' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]);

			// Button Box shadow
			$this->add_control_group(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'crel_kbSearchBox__button__shadow',
					'selector' => '{{WRAPPER}} .crel-search-box__search-form__submit',
				]);

			// Button Size ( Width )
			$this->add_control_responsive(
				'crel_kbSearchBox__button_width',
				[
					'label' => __('Button Width', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 20,
							'max' => 500,
							'step' => 1,
						]
					],
					'selectors' => [
						'{{WRAPPER}} .crel-search-box__search-form__submit' => 'min-width: {{SIZE}}px;'
					],
				]);

			// Button Typography ( Condition if Button type = Text )
			$this->add_control_group(
				Group_Control_Typography::get_type(),
				[
					'name' => 'crel_kbSearchBox__button_typography',
					'selector' => '{{WRAPPER}} .crel-search-box__search-form__submit',
					'condition' => [
						'crel_kbSearchBox__button_type' => 'text'
					]
				]);

			// Button Icon Size ( Condition if Button type = icon )
			$this->add_control_responsive(
				'crel_kbSearchBox__buttonIcon_size',
				[
					'label' => __('Icon Size', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 10,
							'max' => 100,
							'step' => 1,
						]
					],
					'selectors' => [
						'{{WRAPPER}} .crel-search-box__search-form__submit' => 'font-size: {{SIZE}}px;',
						'{{WRAPPER}} .crel-search-box__search-form__submit svg' => 'width: {{SIZE}}px;'
					],
					'condition' => [
						'crel_kbSearchBox__button_type' => 'icon'
					]
				]);


		$this->end_controls_tab();

		// Hover Tab ----------------------------/
		$this->start_controls_tab(
			'crel_kbSearchBox__Button_Hover', 
			[
				'label' => __('Hover', 'creative-addons-for-elementor'),
			]);

			// Button / Icon Color :Hover
			$this->add_control(
				'crel_kbSearchBox__button_colorHover',
				[
					'label' => __('Icon/Text Color', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crel-search-box__search-form__submit:hover' => 'color: {{VALUE}};',
					],
				]);

			// Button / Icon Background Color :Hover
			$this->add_control(
				'crel_kbSearchBox__button_backgroundColorHover',
				[
					'label' => __('Background Color', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crel-search-box__search-form__submit:hover' => 'background-color: {{VALUE}};',
					],
				]);
			
		$this->end_controls_tab();

		$this->end_controls_tabs();
		
		// Button tabs 
		
		// END TABS ----------------------------------------/

		// Buttons Margin
		$this->add_responsive_control(
			'crel_kbSearchBox__button_margin',
			[
				'label' => __( 'Margin', 'creative-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .crel-search-box__search-form__submit' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]);

		// Buttons Padding
		$this->add_responsive_control(
			'crel_kbSearchBox__button_padding',
			[
				'label' => __( 'Padding', 'creative-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .crel-search-box__search-form__submit' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]);
			
		$this->end_controls_section();


		// SEARCH RESULTS - GENERAL ------------------------------[SECTION]-------------/
		$this->start_controls_section(
			'crel_kbSearchBox__Result_General__section__StyleTab',
			[
				'label' => __('Search Results - General', 'creative-addons-for-elementor'), 
				'tab' => Controls_Manager::TAB_STYLE,
			]);

		// Alignment
		$this->add_control(
			'crel_kbSearchBox__searchResults_alignment',
			[
				'label' => __('Alignment', 'creative-addons-for-elementor'), 
				'type' => Controls_Manager::CHOOSE, 
				'label_block' => false, 
				'options' => [
					'flex-start' => [
						'title' => __( is_rtl() ? 'Right' : 'Left', 'creative-addons-for-elementor' ),
						'icon' => is_rtl() ? 'fa fa-align-right' : 'fa fa-align-left',
					], 
					'center' => [
						'title' => __('Center', 'creative-addons-for-elementor'), 
						'icon' => 'fa fa-align-center',
					],
					'flex-end' => [
						'title' => __( is_rtl() ? 'Left' : 'Right', 'creative-addons-for-elementor' ),
						'icon' => is_rtl() ? 'fa fa-align-left' : 'fa fa-align-right',
					],
				], 
				'toggle' => false, 

				'selectors' => [
					'{{WRAPPER}} .crel-sbsr__list-item__article' => 'justify-content: {{VALUE}};', 
					'{{WRAPPER}} .crel-sbsr__list-item__article__text' => 'justify-content: {{VALUE}};',
					'{{WRAPPER}} .crel-sbsr__list-no-results' => 'justify-content: {{VALUE}};',
				],
			]);

		// Icon Position
		$this->add_control_responsive(
			'crel_kbSearchBox__searchResults_iconPosition',
			[
				'label' => __('Icon Position', 'creative-addons-for-elementor'),
				'type' => Controls_Manager::CHOOSE, 
				'label_block' => false,
				'options' => [
					'icon-first' => [
						'title' => __( is_rtl() ? 'Right' : 'Left', 'creative-addons-for-elementor' ),
						'icon' => is_rtl() ? 'fa fa-align-right' : 'fa fa-align-left',
					],
					'icon-last' => [
						'title' =>__( is_rtl() ? 'Left' : 'Right', 'creative-addons-for-elementor' ),
						'icon' => is_rtl() ? 'fa fa-align-left' : 'fa fa-align-right',
					],
				],
				'toggle' => false,
				'style_transfer' => true,
			]);

		// Result Max Height
		$this->add_control_responsive(
			'crel_kbSearchBox__searchResults_maxHeight',
			[
				'label' => __('Max Height', 'creative-addons-for-elementor'), 
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 200, 
						'max' => 2000, 
						'step' => 1,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .crel-search-box__search-results__list-container' => 'max-height: {{SIZE}}px;',
				],
			]);

		// Result Border Type
		$this->add_control_group(
			Group_Control_Border::get_type(),
			[
				'name' => 'crel_kbSearchBox__searchResults_borderType',
				'label' => esc_html__('Border', 'creative-addons-for-elementor'), 
				'selector' => '{{WRAPPER}} .crel-search-box__search-results'
			]
		);

		// Result Background Color
		$this->add_control(
			'crel_kbSearchBox__searchResults_backgroundColor',
			[
				'label' => __('Background Color', 'creative-addons-for-elementor'), 
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .crel-search-box__search-results' => 'background-color: {{VALUE}};',
				],
			]);

		// Result Padding
		$this->add_control_responsive(
			'crel_kbSearchBox__searchResults_padding',
			[
				'label' => __('Container Padding', 'creative-addons-for-elementor'), 
				'type' => Controls_Manager::DIMENSIONS, 
				'size_units' => [
					'px',
					'em',
					'%'
				],
				'selectors' => [
					'{{WRAPPER}} .crel-search-box__search-results' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]);

		// Result Margin
		$this->add_control_responsive(
			'crel_kbSearchBox__searchResults_margin',
			[
				'label' => __('Container Margin', 'creative-addons-for-elementor'), 
				'type' => Controls_Manager::DIMENSIONS, 
				'size_units' => [
					'px',
					'em',
					'%'
				],
				'selectors' => [
					'{{WRAPPER}} .crel-search-box__search-results-container' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]);

		// Result Z-Index
		/*	$this->add_control_responsive(
				'crel_kbSearchBox__SearchResults_Zindex',
				[
					'label' => __( 'Z-Index', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::SLIDER,

					'range' => [
						'px' => [
							'min' => 0,
							'max' => 9999,
							'step' => 1,
						]
					],
					'selectors' => [
						'{{WRAPPER}} .crel-search-box__search-results' => 'z-index: {{SIZE}};'
					],
				]
			);*/


		$this->end_controls_section();

		// Search Results - List Items ----------------------------[SECTION]-------------/

		$this->start_controls_section(
			'crel_kbSearchBox__Result_List__section__StyleTab',
			[
				'label' => __('Search Results - List Items', 'creative-addons-for-elementor'), 
				'tab' => Controls_Manager::TAB_STYLE,
			]);

		// START TABS ----------------------------------------/
		$this->start_controls_tabs('crel_kbSearchBox__SearchResults_tabs_button');

		// Normal Tab ----------------------------/
		$this->start_controls_tab(
			'crel_kbSearchBox__SearchResults_Normal', 
			[
				'label' => __('Normal', 'creative-addons-for-elementor'),
			]);

		// Result Text Color
		$this->add_control(
			'crel_kbSearchBox__searchResults_color',
			[
				'label' => __('Text Color', 'creative-addons-for-elementor'), 
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .crel-sbsr__list-item__article__text' => 'color: {{VALUE}};',
				],
			]);

		// Result Background Color
		$this->add_control(
			'crel_kbSearchBox__searchResultsItem_backgroundColor',
			[
				'label' => __('Background Color', 'creative-addons-for-elementor'), 
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .crel-sbsr__list-item__inner' => 'background-color: {{VALUE}};', 
					'{{WRAPPER}} .crel-sbsr__list-no-results' => 'background-color: {{VALUE}};',
				],
			]);

		// Result Icon Color
		$this->add_control(
			'crel_kbSearchBox__searchResultsIcon_Color',
			[
				'label' => __('Icon Color', 'creative-addons-for-elementor'), 
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .crel-sbsr__list-item__article__icon' => 'color: {{VALUE}};',
				],
				'separator' => 'after',
			]);

		$this->end_controls_tab();

		// Hover Tab ----------------------------/
		$this->start_controls_tab(
			'crel_kbSearchBox__searchResults_hover', 
			[
				'label' => __('Hover', 'creative-addons-for-elementor'),
			]);

		// Result Text Color
		$this->add_control(
			'crel_kbSearchBox__searchResults_colorHover',
			[
				'label' => __('Text Color', 'creative-addons-for-elementor'), 
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .crel-sbsr__list-item__inner:hover .crel-sbsr__list-item__article__text' => 'color: {{VALUE}};',
				],
			]);

		// Result Background Color
		$this->add_control(
			'crel_kbSearchBox__searchResults_backgroundColorHover', 
			[
				'label' => __('Background Color', 'creative-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .crel-sbsr__list-item__inner:hover' => 'background-color: {{VALUE}};',
				],
			]);

		// Result Icon Color
		$this->add_control(
			'crel_kbSearchBox__searchResultsIcon_ColorHover', 
			[
				'label' => __('Icon Color', 'creative-addons-for-elementor'), 
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .crel-sbsr__list-item__inner:hover .crel-sbsr__list-item__article__icon' => 'color: {{VALUE}};',
				],
				'separator' => 'after',
			]);

		$this->end_controls_tab();

		$this->end_controls_tabs();
		// END TABS ----------------------------------------/


		// Result Typography
		$this->add_control_group(
			Group_Control_Typography::get_type(),
			[
				'name' => 'crel_kbSearchBox__searchResults_typography', 
				'selector' => '{{WRAPPER}} .crel-sbsr__list-item__article__text',
			]);

		// Result Icon Size
		$this->add_control_responsive(
			'crel_kbSearchBox__searchResultsIcon_Size', 
			[
				'label' => __('Icon Size', 'creative-addons-for-elementor'), 
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 5, 
						'max' => 100, 
						'step' => 1,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .crel-sbsr__list-item__article__icon' => 'font-size: {{SIZE}}px;'
				],
			]);

		// Result Border Type
		$this->add_control_group(
			Group_Control_Border::get_type(),
			[
				'name' => 'crel_kbSearchBox__searchResultsItem_borderType', 
				'label' => esc_html__('Border', 'creative-addons-for-elementor'),
				'selector' => '{{WRAPPER}} .crel-sbsr__list-item__inner, {{WRAPPER}} .crel-sbsr__list-no-results'
			]);

		// Result Item Padding
		$this->add_control_responsive(
			'crel_kbSearchBox__searchResultsItem_padding', 
			[
				'label' => __('Item Padding', 'creative-addons-for-elementor'), 
				'type' => Controls_Manager::DIMENSIONS, 
				'size_units' => [
					'px',
					'em', 
					'%'
				],
				'selectors' => [
					'{{WRAPPER}} .crel-sbsr__list-item__inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};', 
					'{{WRAPPER}} .crel-sbsr__list-no-results' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]);

		// Result Icon Padding
		$this->add_control_responsive(
			'crel_kbSearchBox__SearchResultsIcon_padding', 
			[
				'label' => __('Icon Padding', 'creative-addons-for-elementor'), 
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [
					'px', 
					'em', 
					'%'
				],
				'selectors' => [
					'{{WRAPPER}} .crel-sbsr__list-item__article__icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]);


		$this->end_controls_section();

		// SEARCH RESULTS - SEE ALL RESULTS ------------------------[SECTION]-------------/
		$this->start_controls_section(
			'crel_kbSearchBox__AllResults__section__StyleTab', 
			[
				'label' => __('Search Results - All Results Text', 'creative-addons-for-elementor'), 
				'tab' => Controls_Manager::TAB_STYLE,
			]);


		// START TABS ----------------------------------------/
		$this->start_controls_tabs('crel_kbSearchBox__AllResults_tabs_button');

		// Normal Tab ----------------------------/
		$this->start_controls_tab(
			'crel_kbSearchBox__AllResults_Normal', 
			[
				'label' => __('Normal', 'creative-addons-for-elementor'),
			]);

		// See All Text Color
		$this->add_control(
			'crel_kbSearchBox__allResults_color', 
			[
				'label' => __('Text Color', 'creative-addons-for-elementor'), 
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .crel-sbsr__all-results a' => 'color: {{VALUE}};',
				],
			]);

		//See All Background Color
		$this->add_control(
			'crel_kbSearchBox__AllResults_backgroundColor', 
			[
				'label' => __('Background Color', 'creative-addons-for-elementor'), 
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .crel-sbsr__all-results a' => 'background-color: {{VALUE}};',
				],
			]);

		// See All Padding
		$this->add_control_responsive(
			'crel_kbSearchBox__allResults_padding', 
			[
				'label' => __('Padding', 'creative-addons-for-elementor'), 
				'type' => Controls_Manager::DIMENSIONS, 
				'size_units' => [
					'px',
					'em',
					'%'
				],
				'selectors' => [
					'{{WRAPPER}} .crel-sbsr__all-results a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]);

		// See All Margin
		$this->add_control_responsive(
			'crel_kbSearchBox__allResults_margin', 
			[
				'label' => __('Margin', 'creative-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS, 
				'size_units' => [
					'px', 
					'em', 
					'%'
				], 
				'selectors' => [
					'{{WRAPPER}} .crel-sbsr__all-results a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]);

		// See All Border Type
		$this->add_control_group(
			Group_Control_Border::get_type(), 
			[
				'name' => 'crel_kbSearchBox__AllResults_BorderType', 
				'label' => esc_html__('Border', 'creative-addons-for-elementor'), 
				'selector' => '{{WRAPPER}} .crel-sbsr__all-results a'
			]);

		// See All Width
		$this->add_control_responsive(
			'crel_kbSearchBox__allResults_width',
			[
				'label' => __('Width(%)', 'creative-addons-for-elementor'), 
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 100, 
						'step' => 1,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .crel-sbsr__all-results a' => 'width: {{SIZE}}%;'
				],
			]);

		// Result Typography
		$this->add_control_group(
			Group_Control_Typography::get_type(),
			[
				'name' => 'crel_kbSearchBox__allResults_typography', 
				'selector' => '{{WRAPPER}} .crel-sbsr__all-results a',
			]);

		$this->end_controls_tab();


		// Hover Tab ----------------------------/
		$this->start_controls_tab(
			'crel_kbSearchBox__allResults_hover', 
			[
				'label' => __('Hover', 'creative-addons-for-elementor'),
			]);

		// See All Text Color :Hover
		$this->add_control(
			'crel_kbSearchBox__allResults_textColor_Hover',
			[
				'label' => __('Text Color', 'creative-addons-for-elementor'), 
				'type' => Controls_Manager::COLOR, 
				'selectors' => [	
					'{{WRAPPER}} .crel-sbsr__all-results a:hover' => 'color: {{VALUE}};',
				],
			]);

		//See All Background Color :Hover
		$this->add_control(
			'crel_kbSearchBox__allResults_backgroundColorHover',
			[
				'label' => __('Background Color', 'creative-addons-for-elementor'), 
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .crel-sbsr__all-results a:hover' => 'background-color: {{VALUE}};',
				],
			]);

		$this->end_controls_tab();

		$this->end_controls_tabs();
		// END TABS ----------------------------------------/

		$this->end_controls_section();

		// SEARCH RESULTS - HELP TEXT ------------------------------[SECTION]-------------/
		$this->start_controls_section(
			'crel_kbSearchBox__HelpText__section__StyleTab', 
			[
				'label' => __('Search Results - Help Text', 'creative-addons-for-elementor'), 
				'tab' => Controls_Manager::TAB_STYLE,
			]);

		// START TABS ----------------------------------------/
		$this->start_controls_tabs('crel_kbSearchBox__HelpText_tabs_button');

		// Normal Tab ----------------------------/
		$this->start_controls_tab(
			'crel_kbSearchBox__HelpText_Normal', 
			[
				'label' => __('Normal', 'creative-addons-for-elementor'),
			]);

		// Help Text Color
		$this->add_control(
			'crel_kbSearchBox__helpText_color',
			[
				'label' => __('Text Color', 'creative-addons-for-elementor'), 
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .crel-sbsr__help-text__text' => 'color: {{VALUE}};',
				],
			]);

		// Help Background Color
		$this->add_control(
			'crel_kbSearchBox__helpText_backgroundColor',
			[
				'label' => __('Background Color', 'creative-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .crel-sbsr__help-text a' => 'background-color: {{VALUE}};',
				],
			]);

		// Help Padding
		$this->add_control_responsive(
			'crel_kbSearchBox__helpText_padding', 
			[
				'label' => __('Padding', 'creative-addons-for-elementor'), 
				'type' => Controls_Manager::DIMENSIONS, 
				'size_units' => [
					'px', 
					'em', 
					'%'
				],
				'selectors' => [
					'{{WRAPPER}} .crel-sbsr__help-text a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]);

		// Help Margin
		$this->add_control_responsive(
			'crel_kbSearchBox__helpText_margin', 
			[
				'label' => __('Margin', 'creative-addons-for-elementor'),
				'type' => Controls_Manager::DIMENSIONS, 
				'size_units' => [
					'px',
					'em', 
					'%'
				],
				'selectors' => [
					'{{WRAPPER}} .crel-sbsr__help-text a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]);

		// Help Border Type
		$this->add_control_group(
			Group_Control_Border::get_type(),
			[
				'name' => 'crel_kbSearchBox__helpText_borderType', 
				'label' => esc_html__('Border', 'creative-addons-for-elementor'), 
				'selector' => '{{WRAPPER}} .crel-sbsr__help-text a'
			]);

		// Help Width
		$this->add_control_responsive(
			'crel_kbSearchBox__helpText_width', 
			[
				'label' => __('Width(%)', 'creative-addons-for-elementor'), 
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 5, 
						'max' => 100, 
						'step' => 1,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .crel-sbsr__help-text a' => 'width: {{SIZE}}%;'
				],
			]);

		// Result Typography
		$this->add_control_group(
			Group_Control_Typography::get_type(),
			[
				'name' => 'crel_kbSearchBox__helpText_typography', 
				'selector' => '{{WRAPPER}} .crel-sbsr__help-text__text',
			]);

		$this->end_controls_tab();

		// Hover Tab ----------------------------/
		$this->start_controls_tab(
			'crel_kbSearchBox__HelpText_Hover', 
			[
				'label' => __('Hover', 'creative-addons-for-elementor'),
			]);

		// See All Text Color :Hover
		$this->add_control(
			'crel_kbSearchBox__helpText_colorHover', 
			[
				'label' => __('Text Color', 'creative-addons-for-elementor'),
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .crel-sbsr__help-text a:hover .crel-sbsr__help-text__text' => 'color: {{VALUE}};',
				],
			]);

		//See All Background Color :Hover
		$this->add_control(
			'crel_kbSearchBox__helpText_backgroundColorHover', 
			[
				'label' => __('Background Color', 'creative-addons-for-elementor'), 
				'type' => Controls_Manager::COLOR, 
				'selectors' => [
					'{{WRAPPER}} .crel-sbsr__help-text a:hover' => 'background-color: {{VALUE}};',
				],
			]);

		$this->end_controls_tab();

		$this->end_controls_tabs();
		// END TABS ----------------------------------------/


		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 */
	protected function render() {
		
		if ( ! $this->is_kb_plugin_activated() ) {
			return;
		}
		
		$settings = $this->get_settings_for_display();

		// TITLE ---------------------------/
		$title                  = esc_html($settings['crel_kbSearchBox__title_text']);
		$title_html_tag         = esc_attr($settings['crel_kbSearchBox__title_HTMLTag']);
		$title_active           = esc_attr($settings['crel_kbSearchBox__title_toggle']);


		// INPUT -----------------------------------/
		$input_placeholder = esc_attr($settings['crel_kbSearchBox__inputPlaceholder_text']);

		// BUTTON ----------------------------------/
		$button_type = esc_attr($settings['crel_kbSearchBox__button_type']);
		$button_text = esc_attr($settings['crel_kbSearchBox__Button_Text']);
		$button_icon = $settings['crel_kbSearchBox__button_icon']; // this is an array

		// SEARCH RESULTS --------------------------/
		$article_icon_loc = esc_attr($settings['crel_kbSearchBox__searchResults_iconPosition']);
		$all_results_text = esc_attr($settings['crel_kbSearchBox__allResults_text']);
		$all_results_size = esc_attr($settings['crel_kbSearchBox__allResults_size']);

		$kb_id = $this->get_current_kb_id(); ?>

		<!-- Search Form -->
		<div class="crel-search-box-container crel-search-box--<?php echo $article_icon_loc; ?>">

			<!-- Search Title -->
			<?php
			if ( $title_active === 'yes' ) {
				echo '<' . $title_html_tag . ' class="crel-search-box__title" >' . $title . '</' . $title_html_tag . '>';
			}
			?>


			<form class="crel-search-box__search-form" role="search" action="" method="get">

				<div class="crel-search-box__search-form__inner">
					<input type="hidden" name="crel_kb_id" value="<?php echo $kb_id; ?>"/>
					<input type="hidden" name="crel_ajaxurl" value="<?php echo admin_url('admin-ajax.php', 'relative'); ?>"/>
					<input type="hidden" name="crel_list_size" value="<?php echo $all_results_size; ?>"/>
					<input placeholder="<?php echo $input_placeholder; ?>" class="crel-search-box__search-form__input" type="search" name="crel-search-widget" title="Search" value>
					<div class="crel-loading-spinner" style="display: none;"></div><?php 
						if ( $button_type === 'text' ) { ?>
							<button class="crel-search-box__search-form__submit" type="submit" title="Search" aria-label="Search"><?php echo $button_text; ?></button><?php 
						} else { ?>
							<button class="crel-search-box__search-form__submit" type="submit" title="Search" aria-label="Search">	<?php
							   \Elementor\Icons_Manager::render_icon( $button_icon, [ 'aria-hidden' => 'true' ] ); ?>
								<span class="crel-screen-only"><?php echo $button_text; ?></span>
							  </button><?php 
						} ?>
				</div>

			</form>

			<div class="crel-search-box__search-results-container">

				<div class="crel-search-box__search-results">
					<ul class="crel-search-box__search-results__list-container"></ul>

					<div class="crel-sbsr__all-results">
						<a href="#"><?php echo $all_results_text; ?></a>
					</div>

					<?php $this->render_help_text( $settings ); ?>
				</div>

			</div>

		</div>        <?php
	}

	/**
	 * Renders the help text and link
	 * @param $settings
	 */
	private function render_help_text( $settings ) {

		$help_text__toggle = isset($settings['crel_kbSearchBox__showHelpText_toggle']) ? esc_attr( $settings['crel_kbSearchBox__showHelpText_toggle'] ) : 'no';

		if ( $help_text__toggle === 'yes' ) {
			$help_text = esc_html( $settings['crel_kbSearchBox__helpText_text'] );
			$help_text__url_external = esc_attr( $settings['crel_kbSearchBox__HelpURL']['is_external'] );
			$help_text__url_nofollow = esc_attr( $settings['crel_kbSearchBox__HelpURL']['nofollow'] );
			$help_text__url = esc_attr( $settings['crel_kbSearchBox__HelpURL']['url'] ); ?>
			<div class="crel-sbsr__help-text">
				<a href="<?php echo $help_text__url; ?>" target="<?php echo $help_text__url_external; ?>" rel="<?php echo $help_text__url_nofollow; ?>">
					<span class="crel-sbsr__help-text__text"><?php echo $help_text; ?></span>
				</a>
			</div>        <?php
		}
	}
	
	/**
	 * Dynamically render Search Box
	 */
	protected function content_template() {		?>

		<!-- Search Form -->
		<div class="crel-search-box-container crel-search-box--{{{ settings.crel_kbSearchBox__searchResults_iconPosition }}}">
			<#
			if ( settings.crel_kbSearchBox__title_toggle == 'yes' ) { #>
				<{{{ settings.crel_kbSearchBox__title_HTMLTag }}} class="crel-search-box__title">{{{ settings.crel_kbSearchBox__title_text }}}</{{{ settings.crel_kbSearchBox__title_HTMLTag }}}>
			<# } #>

			<form class="crel-search-box__search-form" role="search" action="" method="get">

				<div class="crel-search-box__search-form__inner">
					<input type="hidden" name="crel_kb_id" value="1"/>
					<input type="hidden" name="crel_ajaxurl" value="/"/>
					<input type="hidden" name="crel_list_size" value="{{{ settings.crel_kbSearchBox__allResults_size }}}"/>
					<input placeholder="{{{ settings.crel_kbSearchBox__inputPlaceholder_text }}}" class="crel-search-box__search-form__input" type="search" name="crel-search-widget" title="Search" value>
					<div class="crel-loading-spinner" style="display: none;"></div><#
						if ( settings.crel_kbSearchBox__button_type == 'text' ) { #>
							<button class="crel-search-box__search-form__submit" type="submit" title="Search" aria-label="Search">{{{ settings.crel_kbSearchBox__Button_Text }}}</button><#
						} else { 
							let iconHTML = elementor.helpers.renderIcon( view, settings.crel_kbSearchBox__button_icon, { 'aria-hidden': true }, 'i' , 'object' ); #>
							<button class="crel-search-box__search-form__submit" type="submit" title="Search" aria-label="Search">
								{{{ iconHTML.value }}}
								<span class="crel-screen-only">{{{ settings.crel_kbSearchBox__Button_Text }}}</span>
							</button><#
						} #>
				</div>

			</form>

			<div class="crel-search-box__search-results-container">
				<div class="crel-search-box__search-results">
					<ul class="crel-search-box__search-results__list-container"></ul>
					<div class="crel-sbsr__all-results">
						<a href="#">{{{ settings.crel_kbSearchBox__allResults_text }}}</a>
					</div> <# 
						if ( settings.crel_kbSearchBox__showHelpText_toggle == 'yes' ) { #>
							<div class="crel-sbsr__help-text">
								<a href="{{{ settings.crel_kbSearchBox__HelpURL.url }}}" target="{{{ settings.crel_kbSearchBox__HelpURL.is_external }}}" rel="{{{ settings.crel_kbSearchBox__HelpURL.nofollow }}}">
									<span class="crel-sbsr__help-text__text">{{{ settings.crel_kbSearchBox__helpText_text }}}</span>
								</a>
							</div> <#
						} #>
				</div>
			</div>
		</div>        <?php
	}
}
