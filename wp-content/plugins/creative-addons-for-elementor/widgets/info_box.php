<?php
namespace Creative_Addons\Widgets;

use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;

defined( 'ABSPATH' ) || exit();

/**
 * Info Box widget for Elementor
 * TODO FUTURE
 */
class Info_Box extends Creative_Widget_Base {

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Info Box', 'creative-addons-for-elementor' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'fa fa-info-circle';
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
		return [ 'info', 'card', 'blurb', 'box', 'info box', 'text'  ];
	}

	protected function get_config_defaults() {
		return [
			'crel_InfoBox__IconType' => 'icon',
			'crel_InfoBox__IconImage' => [
				'url' => Utils::get_placeholder_image_src(),
			],
			'crel_InfoBox__FontIcon' => [
				'value' => 'fa-building',
				'library' => 'fa-info-circle',
			],
			'crel_InfoBox__TitleText' => __( 'Info Box Title', 'creative-addons-for-elementor' ),
			'crel_InfoBox__TitleHTMLTag' => 'h2',
			'crel_InfoBox__DescText' => __( 'Write a short description to describe the title.', 'creative-addons-for-elementor'),
			'crel_InfoBox__ButtonText' => __( 'Learn More', 'creative-addons-for-elementor' ),
			'crel_InfoBox__ButtonURL'		=> [
				'url'	=> '#'
			],
			'crel_InfoBox__IconPosition' 		=> 'crel-info-box-icon--left',
			'crel_InfoBox__IconSize' => [
				'size' => 40,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_InfoBox__IconContainerSize' => [
				'size' => 40,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_InfoBox__BorderRadius' => [
				'size' => 40,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_InfoBox__IconRotate' => [
				'unit' => 'deg',
				'sizes' => []
			],
			'crel_InfoBox__ButtonBorderRadius' => [
				'size' => 0,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_InfoBox__ButtonIconSize' => [
				'size' => 40,
				'unit' => 'px',
				'sizes' => []
			],
		];
	}

	protected function get_config_rtl_defaults() {
		return '';
	}

	protected function get_presets_defaults() {
		return ''; // TODO FUTURE
	}

	protected function get_presets_rtl_defaults() {
		return '';
	}
	/**
	 * Return presets for this widget
	 */
	public function get_presets_options() {

		$options = array();

		$options['default'] = array(
			'title' => 'default config + presets',
			'options' => array()
		);

		$options[''] = array(
			'title' => __( 'Select ...', 'creative-addons-for-elementor'),
			'options' => array()
		);

		$options['design-1'] = array(
			'title' => __( 'Design 1', 'creative-addons-for-elementor'),
			'options' => array(
				'crel_InfoBox__TitleColor' => '#000000',
				'crel_InfoBox__TitleHTMLTag' => 'h1',
				'crel_InfoBox__ButtonToggle' => 'yes',
				'crel_InfoBox__TitleText' => 'hello5',
			)
		);

		$options['design-2'] = array(
			'title' => __( 'Design 2', 'creative-addons-for-elementor'),
			'options' => array(
				'crel_InfoBox__TitleColor' => '#ff0000',
				'crel_InfoBox__TitleHTMLTag' => 'h2',
				'crel_InfoBox__ButtonToggle' => 'no',
				'crel_InfoBox__TitleText' => 'Hello World!!!',
			)
		);
		return $options;
	}

	/**
	 * CONTENT tab for this widget
	 */
	protected function register_content_controls() {

		// CONTENT =================================[ TAB ]====================================/

		// ICON / IMAGE ----------------------------[SECTION]-------------/

		$this->start_controls_section(
			'crel_InfoBox__IconImage__section',
			[
				'label' => __( 'Icon / Image', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT
			]
		);

			// Icon Type selection
			$this->add_responsive_control(
				'crel_InfoBox__IconType',
				[
					'label' => __( 'Image or Icon', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::CHOOSE,
					'label_block' => true,
					'options' => [
						'none' => [
							'title' => __( 'None', 'creative-addons-for-elementor'),
							'icon' => 'fa fa-ban',
						],
						'number' => [
							'title' => __( 'Number', 'creative-addons-for-elementor'),
							'icon' => 'fa fa-keyboard',
						],
						'icon' => [
							'title' => __( 'Icon', 'creative-addons-for-elementor'),
							'icon' => 'fa fa-laugh',
						],
						'img' => [
							'title' => __( 'Image', 'creative-addons-for-elementor'),
							'icon' => 'fa fa-picture-o',
						]
					],
				]
			);

			// Icon Image
			$this->add_control(
				'crel_InfoBox__IconImage',
				[
					'label' => __( 'Icon Image', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::MEDIA,
					'default' => [
						'url' => Utils::get_placeholder_image_src(),
					],
					'condition' => [
						'crel_InfoBox__IconType' => 'img'
					]
				]
			);

			// Icon Font Icon
			$this->add_control(
				'crel_InfoBox__FontIcon',
				[
					'label' => __( 'Icon', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::ICONS,
					'condition' => [
						'crel_InfoBox__IconType' => 'icon'
					]
				]
			);

			// Icon - Number
			$this->add_control(
				'crel_InfoBox__NumberIcon',
				[
					'label' => __( 'Number', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::TEXT,
					'condition' => [
						'crel_InfoBox__IconType' => 'number'
					]
				]
			);

		$this->end_controls_section();


		// TITLE & DESCRIPTION ---------------------[SECTION]-------------/

		$this->start_controls_section(
			'crel_InfoBox__TitleDesc__section',
			[
				'label' => __( 'Title & Description', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		// Title
		$this->add_control(
			'crel_InfoBox__TitleText',
			[
				'label' => __( 'Title', 'creative-addons-for-elementor' ),
				'label_block' => true,
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Type Info Box Title', 'creative-addons-for-elementor' ),
			]
		);

		// Title HTML Tag
		$this->add_control(
			'crel_InfoBox__TitleHTMLTag',
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
			]
		);

		// Description
		$this->add_control(
			'crel_InfoBox__DescText',
			[
				'label' => __( 'Description', 'creative-addons-for-elementor'),
				'type' => Controls_Manager::WYSIWYG,
				'label_block' => true,
			]
		);

		$this->end_controls_section();


		// BUTTON ----------------------------------[SECTION]-------------/

		$this->start_controls_section(
			'crel_InfoBox__Button__section_content',
			[
				'label' => __( 'Button', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

			// Show Button Toggle
			$this->add_control(
				'crel_InfoBox__ButtonToggle',
				[
					'label' => __( 'Show Button', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::SWITCHER,
					'label_on' => __( 'Yes', 'creative-addons-for-elementor'),
					'label_off' => __( 'No', 'creative-addons-for-elementor'),

				]
			);

			// Button Text
			$this->add_control(
				'crel_InfoBox__ButtonText',
				[
					'label' => __( 'Button Text', 'creative-addons-for-elementor' ),
					'label_block' => true,
					'type' => Controls_Manager::TEXT,
					'placeholder' => __( 'Learn More', 'creative-addons-for-elementor' ),
					'condition'	=> [
						'crel_InfoBox__ButtonToggle'	=> 'yes'
					]
				]
			);

			// Button Link
			$this->add_control(
				'crel_InfoBox__ButtonURL',
				[
					'label' => __( 'Link URL', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::URL,
					'label_block' => true,
					'placeholder' => __( 'Enter link URL for the button', 'creative-addons-for-elementor'),
					'show_external'	=> true,
					'title' => __( 'Enter heading for the button', 'creative-addons-for-elementor'),
					'condition'	=> [
						'crel_InfoBox__ButtonToggle'	=> 'yes'
					]
				]
			);

			// Button Icon
			$this->add_control(
				'crel_InfoBox__ButtonIcon',
				[
					'label' => __( 'Icon', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::ICONS,
					'condition'	=> [
						'crel_InfoBox__ButtonToggle'	=> 'yes'
					]
				]
			);


		$this->end_controls_section();

	}

	/**
	 * STYLE tab for this widget
	 */
	protected function register_style_controls() {

		// STYLE ===================================[ TAB ]====================================/

		// GENERAL ---------------------------------[SECTION]-------------/

		$this->start_controls_section(
			'crel_InfoBox__General__section',
			[
				'label' => __( 'General', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

			// Icon Position
			$this->add_control(
				'crel_InfoBox__IconPosition',
				[
					'label'       	=> __( 'Position Style', 'creative-addons-for-elementor'),
					'type' 			=> Controls_Manager::SELECT,
					'label_block' 	=> false,
					'options' 		=> [
						'crel-info-box-icon--top'  	=> __( 'Top', 'creative-addons-for-elementor'),
						'crel-info-box-icon--left' 	=> __( 'Left', 'creative-addons-for-elementor'),
						'crel-info-box-icon--right' => __( 'Right', 'creative-addons-for-elementor'),
					],

				]
			);

		$this->end_controls_section();

		// ICON / IMAGE ----------------------------[SECTION]-------------/

		$this->start_controls_section(
			'crel_InfoBox__IconImg__section',
			[
				'label' => __( 'Icon / Image', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

			// Icon Size
			$this->add_responsive_control(
				'crel_InfoBox__IconSize',
				[
					'label' => __( 'Icon Size', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 20,
							'max' => 200,
							'step' => 1,
						]
					],
					'selectors' => [
						'{{WRAPPER}} .crel-info-box__icon__inner' => 'font-size: {{SIZE}}px;',
						'{{WRAPPER}} .crel-info-box__icon__inner img'	=> 'height: {{SIZE}}px; width: {{SIZE}}px;'
					]
				]
			);

			// Icon Container Size
			$this->add_responsive_control(
				'crel_InfoBox__IconContainerSize',
				[
					'label' => __( 'Icon Container Size', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 10,
							'max' => 500,
							'step' => 1,
						]
					],
					'selectors' => [
						'{{WRAPPER}} .crel-info-box__icon'	=> 'height: {{SIZE}}px; width: {{SIZE}}px;'
					]
				]
			);

			// Icon Margin
			$this->add_responsive_control(
				'crel_InfoBox__IconMargin',
				[
					'label' => __( 'Margin', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						'{{WRAPPER}} .crel-info-box__icon__inner' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			// Icon Padding
			$this->add_responsive_control(
				'crel_InfoBox__IconPadding',
				[
					'label' => __( 'Padding', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						'{{WRAPPER}} .crel-info-box__icon__inner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			// Icon Color
			$this->add_control(
				'crel_InfoBox__IconColor',
				[
					'label' => __( 'Color', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crel-info-box__icon__inner' => 'color: {{VALUE}};',
					],
				]
			);

			// Icon Background Color
			$this->add_control(
				'crel_InfoBox__IconBackgroundColor',
				[
					'label' => __( 'Background Color', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crel-info-box__icon__inner' => 'background-color: {{VALUE}};',
					],
				]
			);

			// Icon Border Type
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'crel_InfoBox__IconBorderType',
					'label' => __( 'Border', 'creative-addons-for-elementor'),
					'selector' => '{{WRAPPER}} .crel-info-box__icon__inner'
				]
			);

			// Icon Border Radius
			$this->add_responsive_control(
				'crel_InfoBox__BorderRadius',
				[
					'label' => __( 'Border Radius', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 200,
							'step' => 1,
						]
					],
					'selectors' => [
						'{{WRAPPER}} .crel-info-box__icon__inner' => 'border-radius: {{SIZE}}px;'
					]
				]
			);

			// Icon Box Shadow
			$this->add_group_control(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'crel_InfoBox__IconShadow',
					'selector' => '{{WRAPPER}} .crel-info-box__icon__inner',
				]
			);

			// Icon Rotate
			$this->add_control(
				'crel_InfoBox__IconRotate',
				[
					'label' => __( 'Rotate', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => [ 'deg' ],

					'range' => [
						'deg' => [
							'min' => 0,
							'max' => 360,
						],
					],
					'selectors' => [
						// Icon rotate styles
						'{{WRAPPER}} .crel-infobox-figure--icon > i' => '-ms-transform: rotate(-{{SIZE}}{{UNIT}}); -webkit-transform: rotate(-{{SIZE}}{{UNIT}}); transform: rotate(-{{SIZE}}{{UNIT}});',
						// Icon box transform styles
						'(desktop){{WRAPPER}} .crel-info-box__icon__inner' => '-ms-transform: translate({{media_offset_x.SIZE || 0}}px, {{media_offset_y.SIZE || 0}}px) rotate({{SIZE}}deg); -webkit-transform: translate({{media_offset_x.SIZE || 0}}px, {{media_offset_y.SIZE || 0}}px) rotate({{SIZE}}deg); transform: translate({{media_offset_x.SIZE || 0}}px, {{media_offset_y.SIZE || 0}}px) rotate({{SIZE}}deg);',
						'(tablet){{WRAPPER}} .crel-info-box__icon__inner' => '-ms-transform: translate({{media_offset_x_tablet.SIZE || 0}}px, {{media_offset_y_tablet.SIZE || 0}}px) rotate({{SIZE}}deg); -webkit-transform: translate({{media_offset_x_tablet.SIZE || 0}}px, {{media_offset_y_tablet.SIZE || 0}}px) rotate({{SIZE}}deg); transform: translate({{media_offset_x_tablet.SIZE || 0}}px, {{media_offset_y_tablet.SIZE || 0}}px) rotate({{SIZE}}deg);',
						'(mobile){{WRAPPER}} .crel-info-box__icon__inner' => '-ms-transform: translate({{media_offset_x_mobile.SIZE || 0}}px, {{media_offset_y_mobile.SIZE || 0}}px) rotate({{SIZE}}deg); -webkit-transform: translate({{media_offset_x_mobile.SIZE || 0}}px, {{media_offset_y_mobile.SIZE || 0}}px) rotate({{SIZE}}deg); transform: translate({{media_offset_x_mobile.SIZE || 0}}px, {{media_offset_y_mobile.SIZE || 0}}px) rotate({{SIZE}}deg);',
					],
				]
			);

		$this->end_controls_section();

		// TITLE -----------------------------------[SECTION]-------------/

		$this->start_controls_section(
			'crel_InfoBox__title__section',
			[
				'label' => __( 'Title', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		// Title Padding
		$this->add_responsive_control(
			'crel_InfoBox__TitlePadding',
			[
				'label' => __( 'Padding', 'creative-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .crel-info-box__body__title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// Title Color
		$this->add_control(
			'crel_InfoBox__TitleColor',
			[
				'label' => __( 'Text Color', 'creative-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .crel-info-box__body__title' => 'color: {{VALUE}};',
				],
			]
		);


		// Title Typography
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'crel_InfoBox__TitleTypography',
				'selector' => '{{WRAPPER}} .crel-info-box__body__title',
			]
		);


		$this->end_controls_section();

		// DESCRIPTION -----------------------------[SECTION]-------------/

		$this->start_controls_section(
			'crel_InfoBox__desc__section',
			[
				'label' => __( 'Description', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		// Desc Padding
		$this->add_responsive_control(
			'crel_InfoBox__DescPadding',
			[
				'label' => __( 'Padding', 'creative-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .crel-info-box__body__desc' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// Desc Color
		$this->add_control(
			'crel_InfoBox__DescColor',
			[
				'label' => __( 'Text Color', 'creative-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .crel-info-box__body__desc' => 'color: {{VALUE}};',
				],
			]
		);

		// Desc Typography
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'crel_InfoBox__DescTypography',
				'selector' => '{{WRAPPER}} .crel-info-box__body__desc p',
			]
		);


		$this->end_controls_section();

		// BUTTON ----------------------------------[SECTION]-------------/

		$this->start_controls_section(
			'crel_InfoBox__Button__section_style',
			[
				'label' => __( 'Button', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		// Button Padding
		$this->add_responsive_control(
			'crel_InfoBox__ButtonPadding',
			[
				'label' => __( 'Padding', 'creative-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .crel-info-box__body__learn-more-btn a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		// Button Typography
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'crel_InfoBox__ButtonTypography',
				'selector' => '{{WRAPPER}} .crel-info-box__body__learn-more-btn a',
			]
		);

		// Button Border Type
		$this->add_group_control(
			Group_Control_Border::get_type(),
			[
				'name' => 'crel_InfoBox__ButtonBorderType',
				'label' => __( 'Border', 'creative-addons-for-elementor'),
				'selector' => '{{WRAPPER}} .crel-info-box__body__learn-more-btn a'
			]
		);

		// Button Border Radius
		$this->add_responsive_control(
			'crel_InfoBox__ButtonBorderRadius',
			[
				'label' => __( 'Border Radius', 'creative-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .crel-info-box__body__learn-more-btn a' => 'border-radius: {{SIZE}}px;'
				]
			]
		);

		// Button Icon Size
		$this->add_responsive_control(
			'crel_InfoBox__ButtonIconSize',
			[
				'label' => __( 'Icon Size', 'creative-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 100,
						'step' => 1,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .crel-info-box__body__learn-more-btn .crel-info-box__body__learn-more-btn__icon' => 'font-size: {{SIZE}}px;'
				]
			]
		);

		$this->start_controls_tabs( '_tabs_button' );
		// Normal Tab ----------------------------/

		$this->start_controls_tab(
			'crel_InfoBox__TabButton_Normal',
			[
				'label' => __( 'Normal', 'creative-addons-for-elementor' ),
			]
		);

		// Button Text Color
		$this->add_control(
			'crel_InfoBox__ButtonColor',
			[
				'label' => __( 'Text Color', 'creative-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .crel-info-box__body__learn-more-btn a' => 'color: {{VALUE}};',
				],
			]
		);

		// Button Background Color
		$this->add_control(
			'crel_InfoBox__ButtonBackgroundColor',
			[
				'label' => __( 'Background Color', 'creative-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .crel-info-box__body__learn-more-btn a' => 'background-color: {{VALUE}};',
				],
			]
		);

		// Button Icon Color
		$this->add_control(
			'crel_InfoBox__ButtonIconColor',
			[
				'label' => __( 'Icon Color', 'creative-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .crel-info-box__body__learn-more-btn__icon' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		// Hover Tab -----------------------------/

		$this->start_controls_tab(
			'crel_InfoBox__TabButton_Hover',
			[
				'label' => __( 'Hover', 'creative-addons-for-elementor' ),
			]
		);

		// Button Hover - Text Color
		$this->add_control(
			'crel_InfoBox__ButtonColorHover',
			[
				'label' => __( 'Text Color', 'creative-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .crel-info-box__body__learn-more-btn a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		// Button Hover - Background Color
		$this->add_control(
			'crel_InfoBox__ButtonBackgroundColorHover',
			[
				'label' => __( 'Background Color', 'creative-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .crel-info-box__body__learn-more-btn a:hover' => 'background-color: {{VALUE}};',
				],
			]
		);

		// Button Hover - Icon Color
		$this->add_control(
			'crel_InfoBox__ButtonIconColorHover',
			[
				'label' => __( 'Icon Color', 'creative-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .crel-info-box__body__learn-more-btn:hover .crel-info-box__body__learn-more-btn__icon' => 'color: {{VALUE}};',
				],
			]
		);

		// Border Hover - Color
		$this->add_control(
			'crel_InfoBox__ButtonBorderColorHover',
			[
				'label' => __( 'Border Color', 'creative-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .crel-info-box__body__learn-more-btn:hover a' => 'border-color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

	}

	/**
	 * Renders the Icon / Image HTML
	 */
	protected function render_info_box_icon() {
		$settings = $this->get_settings_for_display();

		// ICON / IMAGE -----------------------------/
		$main_icon              = esc_attr( $settings['crel_InfoBox__FontIcon']['value'] );
		$number                 = esc_html( $settings['crel_InfoBox__NumberIcon'] );
		$image_data             = $settings['crel_InfoBox__IconImage'];

	   $icon_type = $settings['crel_InfoBox__IconType'];
		switch ($icon_type) {
			case 'none':
				echo '';
				break;

			case 'number': ?>
				<div class="crel-info-box__icon crel-info-box__icon--number">
					<div class="crel-info-box__icon__inner"><?php echo $number; ?></div>
				</div>				<?php
				break;

			case 'icon': ?>
				<div class="crel-info-box__icon">
					<div class="crel-info-box__icon__inner fa <?php echo $main_icon; ?>"></div>
				</div>				<?php
				break;

			case 'img':
				if ( $image_data['id'] ) {
					// not a placeholder image
					$image_alt = trim( strip_tags( get_post_meta( $image_data['id'], '_wp_attachment_image_alt', true ) ) );
				} else {
					$image_alt = '';
				}	?>

				<div class="crel-info-box__icon crel-info-box__icon--img">
					<div class="crel-info-box__icon__inner"><img src="<?php echo esc_url( $image_data['url'] ); ?>" alt="<?php echo $image_alt; ?>"></div>
				</div>				<?php break;
		}

	}
	
	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.1.0
	 *
	 * @access protected
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		// ICON
		$main_icon_position     = esc_attr( $settings['crel_InfoBox__IconPosition'] );

		// TITLE & DESCRIPTION ----------------------/
		$title                  = esc_html( $settings['crel_InfoBox__TitleText'] );
		$title_html_tag         = esc_attr( $settings['crel_InfoBox__TitleHTMLTag'] );
		$desc                   = esc_html( $settings['crel_InfoBox__DescText'] );

		// BUTTON ----------------------------------/
		$button_text            = esc_html( $settings['crel_InfoBox__ButtonText'] );
		$button_url             = esc_url( $settings['crel_InfoBox__ButtonURL']['url'] );
		$button_url_external    = esc_url( $settings['crel_InfoBox__ButtonURL']['is_external'] );
		$button_url_nofollow    = esc_url( $settings['crel_InfoBox__ButtonURL']['nofollow'] );
		$button_icon            = esc_attr( $settings['crel_InfoBox__ButtonIcon']['value'] );

		$button_icon_html       = '';
		if ( $button_icon ) {
			$button_icon_html       = '<span class="crel-info-box__body__learn-more-btn__icon fa ' . $button_icon . '"></span>';
		}		?>

		<!-- Info Box -->
		<div class="crel-info-box-container <?php echo $main_icon_position; ?>">

			<?php $this->render_info_box_icon(); ?>

			<div class="crel-info-box__body">

				<?php echo '<' . $title_html_tag . ' class="crel-info-box__body__title">' ?><?php echo $title; ?><?php echo '</' . $title_html_tag . '>'; ?>
				<div class="crel-info-box__body__desc"><?php echo $desc; ?></div>


				<?php	if ( $settings['crel_InfoBox__ButtonToggle'] === 'yes' ) { ?>
					<span class="crel-info-box__body__learn-more-btn">
					<a href="<?php echo $button_url; ?>" target="<?php echo $button_url_external; ?>" rel="<?php echo $button_url_nofollow; ?>">
						<span class="crel-info-box__body__learn-more-btn__text"><?php echo $button_text; ?></span>
						<?php echo $button_icon_html; ?>
					</a>
				</span>
				<?php } ?>

			</div>

		</div>		<?php
	}

	/**
	 * Dynamically render Info Box
	 */
	protected function content_template() {		?>

		<!-- Info Box -->
		<div class="crel-info-box-container {{{ settings.crel_InfoBox__IconPosition}}}">

			<?php $this->render_js_info_box_icon(); ?>

			<div class="crel-info-box__body">

				<{{{ settings.crel_InfoBox__TitleHTMLTag}}} class="crel-info-box__body__title">{{{ settings.crel_InfoBox__TitleText }}}</{{{ settings.crel_InfoBox__TitleHTMLTag}}}>
				<div class="crel-info-box__body__desc">{{{ settings.crel_InfoBox__DescText}}}</div>

				<# if ( settings.crel_InfoBox__ButtonToggle == 'yes' ) { #>
					<span class="crel-info-box__body__learn-more-btn">
						<a href="{{{ settings.crel_InfoBox__ButtonURL.url}}}"
     						target="{{{ settings.crel_InfoBox__ButtonURL.is_external}}}" 
							rel="{{{ settings.crel_InfoBox__ButtonURL.nofollow}}}">
							<span class="crel-info-box__body__learn-more-btn__text">{{{ settings.crel_InfoBox__ButtonText}}}</span>
							
							<# if ( settings.crel_InfoBox__ButtonIcon.value ) { #>
								<span class="crel-info-box__body__learn-more-btn__icon fa {{{ settings.crel_InfoBox__ButtonIcon.value }}}"></span>
							<# } #>
						</a>
					</span>
				<# } #>
			</div>

		</div>		<?php
	}

	/**
	 * Renders the Icon / Image HTML for JS template
	 */
	protected function render_js_info_box_icon() { ?>

		<# switch ( settings.crel_InfoBox__IconType ) {
		case 'none': #>

		<#
		break;

		case 'number': #>
		<div class="crel-info-box__icon crel-info-box__icon--number">
			<div class="crel-info-box__icon__inner">{{{ settings.crel_InfoBox__NumberIcon }}}</div>
		</div>
		<# break;

		case 'icon': #>
		<div class="crel-info-box__icon">
			<div class="crel-info-box__icon__inner fa {{{ settings.crel_InfoBox__FontIcon.value }}}"></div>
		</div>
		<# break;

		case 'img':
		
		if ( typeof settings.crel_InfoBox__IconImage !== 'undefined' ) {

			let image = {
				id: settings.crel_InfoBox__IconImage.id,
				url: settings.crel_InfoBox__IconImage.url,
				model: view.getEditModel()
			};

			let image_url = elementor.imagesManager.getImageUrl( image );

		#>
		<div class="crel-info-box__icon crel-info-box__icon--img">
			<div class="crel-info-box__icon__inner"><img src="{{{ image_url }}}" alt=""></div>
		</div><#
		}

		break;
		} #> <?php
	}
}
