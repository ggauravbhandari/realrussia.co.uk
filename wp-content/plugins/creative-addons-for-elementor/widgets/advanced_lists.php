<?php
namespace Creative_Addons\Widgets;

use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;

defined( 'ABSPATH' ) || exit();

/**
 * Advanced Lists widget for Elementor
 */
class Advanced_Lists extends Creative_Widget_Base {

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Advanced Lists', 'creative-addons-for-elementor' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'crelfont crel-advanced-list-icon';
	}

	/**
	 * Retrieve the widget Demo URL.
	 *
	 * @return string Widget Demo URL.
	 */
	public function get_demo_url() {
		return 'https://www.creative-addons.com/elementor-widgets/advanced-lists/';
	}

	/**
	 * Retrieve the widget Documentation URL.
	 *
	 * @return string Widget Documentation URL.
	 */
	public function get_documentation_url() {
		return 'https://www.creative-addons.com/elementor-docs/advanced-lists-widget/';
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
		return [ 'list', 'lists', 'text', 'bullet', 'number' ];
	}

	protected function get_config_defaults() {
		return [
			'crel_advancedLists__list_description' => __( 'List Description', 'creative-addons-for-elementor'),
			'crel_advancedLists__list_text' => '<ul><li>' . __( 'Item', 'creative-addons-for-elementor') . '<ul><li>' . __( 'Item', 'creative-addons-for-elementor') . '</li></ul></li><li>'. __( 'Item', 'creative-addons-for-elementor') . '</li></ul>',
			'crel_advancedLists__container_alignment' 		=> 'crel-advanced-list--align-left',
			'crel_advancedLists__description_typography_typography' => 'custom',
			'crel_advancedLists__description_typography_font_size'         => [
				'size' => 16,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_advancedLists__description_position' 		=> 'top',
			'crel_advancedLists__description_padding'       => [
				'top'       => '0',
				'right'     => '0',
				'bottom'    => '0',
				'left'      => '0',
				'isLinked' => false,
				'unit' => 'px'
			],
			'crel_advancedLists__1stList_type' 		=> 'crel-advanced-list-1st--disc',
			'crel_advancedLists__2ndList_type' 		=> 'crel-advanced-list-2nd--circle',
			'crel_advancedLists__3rdList_type' 		=> 'crel-advanced-list-3rd--square',
			
			'crel_advancedLists__1stList_typography_typography' => 'custom',
			'crel_advancedLists__1stList_typography_font_size'         => [
				'size' => 16,
				'unit' => 'px',
				'sizes' => []
			],
			
			'crel_advancedLists__list_offSet' => [
				'size' => 30,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_advancedLists__list_spacing' => [
				'size' => 9,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_advancedLists__container_backgroundColor_background'    => 'classic',
			'crel_advancedLists__container_padding'                       => [
				'size' => 0,
				'unit' => 'px',
				'sizes' => []
			],
			
			'crel_advancedLists__description_color' => '#000000',
			'crel_advancedLists__1stList_color' => '#000000',
			
		];
	}

	protected function get_config_rtl_defaults() {
		return [
			'crel_advancedLists__container_alignment' 	=> 'crel-advanced-list--align-right',
			'crel_advancedLists__description_padding'       => [
			  'top'       => '0',
			  'right'     => '0',
			  'bottom'    => '0',
			  'left'      => '0',
			  'isLinked' => false,
			  'unit'      => 'px'
			],
		];
	}

	protected function get_presets_defaults() {
		return [
			'crel_advancedLists__list_description' => __( 'List Description', 'creative-addons-for-elementor'),
			'crel_advancedLists__list_text' => '<ul><li>' . __( 'Item', 'creative-addons-for-elementor') . '<ul><li>' . __( 'Item', 'creative-addons-for-elementor') . '</li></ul></li><li>'. __( 'Item', 'creative-addons-for-elementor') . '</li></ul>',
			'crel_advancedLists__container_alignment' 		=> 'crel-advanced-list--align-left',
			'crel_advancedLists__description_position' 		=> 'top',
			'crel_advancedLists__description_padding'       => [
				'top'       => '0',
				'right'     => '0',
				'bottom'    => '0',
				'left'      => '0',
				'isLinked' => false,
				'unit'      => 'px'
			],
			'crel_advancedLists__1stList_type' 		=> 'crel-advanced-list-1st--disc',
			'crel_advancedLists__2ndList_type' 		=> 'crel-advanced-list-2nd--circle',
			'crel_advancedLists__3rdList_type' 		=> 'crel-advanced-list-3rd--square',
			'crel_advancedLists__list_offSet' => [
				'size' => 30,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_advancedLists__list_spacing' => [
				'size' => 9,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_advancedLists__list_bullet_size' => [
				'size' => 18,
				'unit' => 'px',
			],
			'crel_advancedLists__container_backgroundColor_background'    => 'classic',
			'crel_advancedLists__container_backgroundColor_color'         => '',
			'crel_advancedLists__container_backgroundColor_color_b'       => '',
			'crel_advancedLists__container_padding'                       => [
				'size' => 0,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_advancedLists__list_bullet_alignment' => [
				'size' => '',
				'unit' => 'px',
			],
		];
	}

	protected function get_presets_rtl_defaults() {
		return [
		  'crel_advancedLists__container_alignment' 	=> 'crel-advanced-list--align-right',
		  'crel_advancedLists__description_padding'       => [
			  'top'       => '0',
			  'right'     => '0',
			  'bottom'    => '0',
			  'left'      => '0',
			  'isLinked' => false,
			  'unit'      => 'px'
		  ],
		];
	}

	/**
	 * Return presets for this widget
	 */
	public function get_presets_options() {
		$options = array();

	   // Design 1: disc, circle, square
	   $options['default'] = array(
		   'title' => 'Design 1: disc, circle, square', 'creative-addons-for-elementor',
		   'preview_url' => $this->presets_preview_url( 'advanced-list-design-1.png' ),
		   'options' => array()
	   );

		// Design 2: number, alpha, disc
		$options['design-2'] = array(
			'title' => 'Design 2: number, alpha, disc', 'creative-addons-for-elementor',
			'preview_url' => $this->presets_preview_url( 'advanced-list-design-2.png' ),
			'options' => array(
				'crel_advancedLists__1stList_type'      => 'crel-advanced-list-1st--decimal',
				'crel_advancedLists__2ndList_type'      => 'crel-advanced-list-2nd--lower-alpha',
				'crel_advancedLists__3rdList_type'      => 'crel-advanced-list-3rd--disc',
				'crel_advancedLists__list_bullet_alignment' => [
					'size' => -1,
					'unit' => 'px',
				],
			)
		);

		// Design 3: alpha disc
		$options['design-3'] = array(
		   'title' => 'Design 3: alpha, disc', 'creative-addons-for-elementor',
			'preview_url' => $this->presets_preview_url( 'advanced-list-design-3.png' ),
		   'options' => array(
			   'crel_advancedLists__1stList_type'  => 'crel-advanced-list-1st--lower-alpha',
			   'crel_advancedLists__2ndList_type'  => 'crel-advanced-list-2nd--disc',
			   'crel_advancedLists__3rdList_type'  => 'crel-advanced-list-3rd--circle',
		   )
		);

		// Design 4: numbers disc
		$options['design-4'] = array(
			'title' => 'Design 4: numbers, disc', 'creative-addons-for-elementor',
			'preview_url' => $this->presets_preview_url( 'advanced-list-design-4.png' ),
			'options' => array(
				'crel_advancedLists__1stList_type'  => 'crel-advanced-list-1st--decimal',
				'crel_advancedLists__2ndList_type'  => 'crel-advanced-list-2nd--inherit',
				'crel_advancedLists__3rdList_type'  => 'crel-advanced-list-3rd--disc',
			)
		);

		// Design 5: Roman
		$options['design-5'] = array(
		   'title' => 'Design 5: Roman, disc', 'creative-addons-for-elementor',
			'preview_url' => $this->presets_preview_url( 'advanced-list-design-5.png' ),
		   'options' => array(
			   'crel_advancedLists__1stList_type'  => 'crel-advanced-list-1st--lower-roman',
			   'crel_advancedLists__2ndList_type'  => 'crel-advanced-list-2nd--inherit',
			   'crel_advancedLists__3rdList_type'  => 'crel-advanced-list-3rd--disc',
		   )
		);
		// Design 6: number, alpha, square
		$options['design-6'] = array(
			'title' => 'Design 6: number, alpha, square', 'creative-addons-for-elementor',
			'preview_url' => $this->presets_preview_url( 'advanced-list-design-6.png' ),
			'options' => array(
				'crel_advancedLists__1stList_type'  => 'crel-advanced-list-1st--decimal',
				'crel_advancedLists__2ndList_type'  => 'crel-advanced-list-2nd--lower-alpha',
				'crel_advancedLists__3rdList_type'  => 'crel-advanced-list-3rd--square',
				'crel_advancedLists__container_backgroundColor_background'    => 'gradient',
				'crel_advancedLists__container_backgroundColor_color'         => '#FFF',
				'crel_advancedLists__container_backgroundColor_color_b'       => '#E6E6E652',
				'crel_advancedLists__container_padding'                       => [
					'size' => 5,
					'unit' => 'px',
					'sizes' => []
				],
				'crel_advancedLists__list_spacing' => [
					'size' => 13,
					'unit' => 'px',
					'sizes' => []
				],
			)
		);

		return $options;
	}


	/**
	 * CONTENT tab for this widget
	 */
	protected function register_content_controls() {

		// CONTENT =================================[ TAB ]====================================/


		// TEXT ------------------------------------[SECTION]-------------/

		$this->start_controls_section(
			'crel_advancedLists__titleDesc__section_content',
			[
				'label' => __( 'Text', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

			// Description
			$this->add_control(
				'crel_advancedLists__list_description',
				[
					'label' => __( 'List Description', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::WYSIWYG,
					'label_block' => true,
					'conditions' => [
						'relation' => 'or',
						'terms' => [
							[
								'name' => 'crel_advancedLists__description_position',
								'operator' => '==',
								'value' => 'top',
							],
							[
								'name' => 'crel_advancedLists__description_position',
								'operator' => '==',
								'value' => 'bottom',
							],
						],
					],
					
				]
			);
			
			$this->add_control(
				'crel_advancedLists__list_text',
				[
					'label' => __( 'List Items', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::WYSIWYG,
					'label_block' => true
				]
			);

			// Formatting Help HTML Box
			$this->add_control(
				'important_note',
				[

					'type' => Controls_Manager::RAW_HTML,
					'raw' =>

						'
						<div class="crel-notice-box crel-notice-box--info">
							' . sprintf( __( 'Please note: Only the Page preview will show %s exact %s styling for this widget.', 'creative-addons-for-elementor' ), '<strong>', '</strong>' ) . '
						</div>
						
						<div class="crel-elementor-control-format-help">
							<h4>' . __( 'Formatting Help', 'creative-addons-for-elementor' ) . ' </h4>
					
							<ul>
								<li>
									<span class="crel-elementor-control-format-help__desc">' . __( 'Add List Item', 'creative-addons-for-elementor' ) . '</span>
									<span class="crel-elementor-control-format-help__info">' . __( 'Press ENTER', 'creative-addons-for-elementor' ) . '</span>
								</li>
								<li>
									<span class="crel-elementor-control-format-help__desc">' . __( 'Create Sub list', 'creative-addons-for-elementor' ) . '</span>
									<span class="crel-elementor-control-format-help__info">' . __( 'Press tab to indent selected line', 'creative-addons-for-elementor' ) . '</span>
								</li>
								<li>
									<span class="crel-elementor-control-format-help__desc">' . __( 'Remove Sub list', 'creative-addons-for-elementor' ) . '</span>
									<span class="crel-elementor-control-format-help__info">' . __( 'Press SHIFT + Tab to remove indent of the selected line', 'creative-addons-for-elementor' ) . '</span>
								</li>
								<li>
									<span class="crel-elementor-control-format-help__desc">' . __( 'Bold Text', 'creative-addons-for-elementor' ) . '</span>
									<span class="crel-elementor-control-format-help__info">' . __( 'Highlight the text and press CTRL + B', 'creative-addons-for-elementor' ) . '</span>
								</li>
							</ul>
						</div>',
				]
			);

		$this->end_controls_section();
	}

	/**
	 * STYLE tab for this widget
	 */
	protected function register_style_controls() {

		// STYLE ===================================[ TAB ]====================================/
		
		// GENERAL ----------------------------[SECTION]-------------/
		$this->start_controls_section(
			'crel_advancedLists__container__section_style',
			[
				'label' => __( 'Container', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);	
			
			// Container Position Style
			$this->add_control(
				'crel_advancedLists__container_alignment',
				[
					'label'       	=> __( 'Alignment', 'creative-addons-for-elementor'),
					'type' 			=> Controls_Manager::SELECT,
					'label_block' 	=> false,
					'options' 		=> [
						'crel-advanced-list--align-left' 	=> __( 'Left', 'creative-addons-for-elementor'),
						'crel-advanced-list--align-right'   => __( 'Right', 'creative-addons-for-elementor'),
					],
				]
			);

			// Background Gradient
			$this->add_control_group(
				Group_Control_Background::get_type(),
				[
					'name' => 'crel_advancedLists__container_backgroundColor',
					'label' => __( 'Background Gradient', 'plugin-domain' ),
					'types' => [ 'classic', 'gradient', 'video' ],
					'selector' => '{{WRAPPER}} .crel-advanced-lists-container',
					'separator' => 'before'
				]
			);

		// Container Padding
		$this->add_control_responsive(
			'crel_advancedLists__container_padding',
			[
				'label' => __( 'Container Padding', 'creative-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .crel-advanced-lists-container' => 'padding: {{SIZE}}px;'
				],
				'separator' => 'before'
			]
		);
		$this->end_controls_section();
		
		
		// DESCRIPTION ----------------------------[SECTION]-------------/
		$this->start_controls_section(
			'crel_advancedLists__description__section_style',
			[
				'label' => __( 'Description', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);	
			
			// description position
			$this->add_control(
				'crel_advancedLists__description_position',
				[
					'label'       	=> __( 'Position', 'creative-addons-for-elementor'),
					'type' 			=> Controls_Manager::SELECT,
					'label_block' 	=> false,
					'options' 		=> [
						'top' 	=> __( 'Above List', 'creative-addons-for-elementor'),
						'bottom'   => __( 'Under List', 'creative-addons-for-elementor'),
						'hide' => __( 'Hide', 'creative-addons-for-elementor'),
					]
				]
			);
			
			$this->add_responsive_control(
				'crel_advancedLists__description_padding',
				[
					'label' => __( 'Padding', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],

					'selectors' => [
						'{{WRAPPER}} .crel-advanced-lists__description' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'conditions' => [
						'relation' => 'or',
						'terms' => [
							[
								'name' => 'crel_advancedLists__description_position',
								'operator' => '==',
								'value' => 'top',
							],
							[
								'name' => 'crel_advancedLists__description_position',
								'operator' => '==',
								'value' => 'bottom',
							],
						],
					],
				]
			);
			
			$this->add_control(
				'crel_advancedLists__description_color',
				[
					'label' => __( 'Color', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crel-advanced-lists__description' => 'color: {{VALUE}};',
					],
				]
			);
			
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'label'     => __( 'Typography', 'creative-addons-for-elementor' ),
					'name'      => 'crel_advancedLists__description_typography',
					'selector'  => '{{WRAPPER}} .crel-advanced-lists__description',
				]
			);
		
		$this->end_controls_section();
		
		// TEXT ----------------------------[SECTION]-------------/

		$this->start_controls_section(
			'crel_advancedLists__items__section_style',
			[
				'label' => __( 'List Items', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

		// 1st List Type
			$this->add_control(
				'crel_advancedLists__1stList_type',
				[
					'label'       	=> __( '1st List Type', 'creative-addons-for-elementor'),
					'type' 			=> Controls_Manager::SELECT,
					'label_block' 	=> false,
					'options' 		=> [
						'crel-advanced-list-1st--disc'  	                => __( 'Disc', 'creative-addons-for-elementor'),
						'crel-advanced-list-1st--decimal'  	                => __( 'Decimal', 'creative-addons-for-elementor'),
						'crel-advanced-list-1st--decimal-leading-zero' 	    => __( 'Decimal Leading Zero', 'creative-addons-for-elementor'),
						'crel-advanced-list-1st--upper-alpha' 	            => __( 'Upper Alpha', 'creative-addons-for-elementor'),
						'crel-advanced-list-1st--lower-alpha' 	            => __( 'Lower Alpha', 'creative-addons-for-elementor'),
						'crel-advanced-list-1st--circle'  	                => __( 'Circle', 'creative-addons-for-elementor'),
						'crel-advanced-list-1st--square'  	                => __( 'Square', 'creative-addons-for-elementor'),
						'crel-advanced-list-1st--lower-roman' 	            => __( 'Lower Roman', 'creative-addons-for-elementor'),
						'crel-advanced-list-1st--lower-greek' 	            => __( 'Lower Greek', 'creative-addons-for-elementor'),
						'crel-advanced-list-1st--armenian' 	                => __( 'Armenian', 'creative-addons-for-elementor'),
						'crel-advanced-list-1st--georgian' 	                => __( 'Georgian', 'creative-addons-for-elementor'),
					],
				]
			);

			// 2nd List Type
			$this->add_control(
				'crel_advancedLists__2ndList_type',
				[
					'label'       	=> __( '2nd List Type ( Nested )', 'creative-addons-for-elementor'),
					'type' 			=> Controls_Manager::SELECT,
					'label_block' 	=> false,
					'options' 		=> [
						'crel-advanced-list-2nd--decimal'  	                => __( 'Decimal', 'creative-addons-for-elementor'),
						'crel-advanced-list-2nd--decimal-leading-zero' 	    => __( 'Decimal Leading Zero', 'creative-addons-for-elementor'),
						'crel-advanced-list-2nd--inherit' 	                => __( 'Inherit from Parent', 'creative-addons-for-elementor'),
						'crel-advanced-list-2nd--upper-alpha' 	            => __( 'Upper Alpha', 'creative-addons-for-elementor'),
						'crel-advanced-list-2nd--lower-alpha' 	            => __( 'Lower Alpha', 'creative-addons-for-elementor'),
						'crel-advanced-list-2nd--disc'  	                => __( 'Disc', 'creative-addons-for-elementor'),
						'crel-advanced-list-2nd--circle'  	                => __( 'Circle', 'creative-addons-for-elementor'),
						'crel-advanced-list-2nd--square'  	                => __( 'Square', 'creative-addons-for-elementor'),
						'crel-advanced-list-2nd--lower-roman' 	            => __( 'Lower Roman', 'creative-addons-for-elementor'),
						'crel-advanced-list-2nd--lower-greek' 	            => __( 'Lower Greek', 'creative-addons-for-elementor'),
						'crel-advanced-list-2nd--armenian' 	                => __( 'Armenian', 'creative-addons-for-elementor'),
						'crel-advanced-list-2nd--georgian' 	                => __( 'Georgian', 'creative-addons-for-elementor'),
					],
				]
			);

			// 3rd List Type
			$this->add_control(
				'crel_advancedLists__3rdList_type',
				[
					'label'       	=> __( '3rd List Type ( Nested )', 'creative-addons-for-elementor'),
					'type' 			=> Controls_Manager::SELECT,
					'label_block' 	=> false,
					'options' 		=> [
						'crel-advanced-list-3rd--decimal'  	                => __( 'Decimal', 'creative-addons-for-elementor'),
						'crel-advanced-list-3rd--decimal-leading-zero' 	    => __( 'Decimal Leading Zero', 'creative-addons-for-elementor'),
						'crel-advanced-list-3rd--inherit' 	                => __( 'Inherit from Parent', 'creative-addons-for-elementor'),
						'crel-advanced-list-3rd--upper-alpha' 	            => __( 'Upper Alpha', 'creative-addons-for-elementor'),
						'crel-advanced-list-3rd--lower-alpha' 	            => __( 'Lower Alpha', 'creative-addons-for-elementor'),
						'crel-advanced-list-3rd--disc'  	                => __( 'Disc', 'creative-addons-for-elementor'),
						'crel-advanced-list-3rd--circle'  	                => __( 'Circle', 'creative-addons-for-elementor'),
						'crel-advanced-list-3rd--square'  	                => __( 'Square', 'creative-addons-for-elementor'),
						'crel-advanced-list-3rd--lower-roman' 	            => __( 'Lower Roman', 'creative-addons-for-elementor'),
						'crel-advanced-list-3rd--lower-greek' 	            => __( 'Lower Greek', 'creative-addons-for-elementor'),
						'crel-advanced-list-3rd--armenian' 	                => __( 'Armenian', 'creative-addons-for-elementor'),
						'crel-advanced-list-3rd--georgian' 	                => __( 'Georgian', 'creative-addons-for-elementor'),
					],
				]
			);

			// List OffSet
			$this->add_responsive_control(
				'crel_advancedLists__list_offSet',
				[
					'label' => __( 'List Offset', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 200,
							'step' => 1,
						]
					],
					'selectors' => [
						'{{WRAPPER}} .crel-advanced-list--align-left ol' => 'padding-left: {{SIZE}}px !important;',
						'{{WRAPPER}} .crel-advanced-list--align-left ul' => 'padding-left: {{SIZE}}px !important;',
						'{{WRAPPER}} .crel-advanced-list--align-right ol' => 'padding-right: {{SIZE}}px !important;',
						'{{WRAPPER}} .crel-advanced-list--align-right ul' => 'padding-right: {{SIZE}}px !important;',
					]
				]
			);

			// List Spacing
			$this->add_responsive_control(
				'crel_advancedLists__list_spacing',
				[
					'label' => __( 'List Spacing', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 200,
							'step' => 1,
						]
					],
					'selectors' => [
						'{{WRAPPER}} ol li' => 'margin-top: {{SIZE}}px; margin-bottom: {{SIZE}}px;',
						'{{WRAPPER}} ul li' => 'margin-top: {{SIZE}}px; margin-bottom: {{SIZE}}px;',
					],
				]
			);

			// Bullet size
			$this->add_control(
				'crel_advancedLists__list_bullet_size',
				[
					'label' => __( 'Bullet size (use with Bullet Vertical Alignment)', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 50,
							'step' => 1,
						]
					],
					'selectors' => [
						'{{WRAPPER}} ol li:before' => 'font-size: {{SIZE}}px;',
						'{{WRAPPER}} ul li:before' => 'font-size: {{SIZE}}px;',
					],
					'separator'     => 'before'
				]
			);

			// Bullet Vertical Alignment
			$this->add_control(
				'crel_advancedLists__list_bullet_alignment',
				[
					'label' => __( 'Bullet Vertical Alignment', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => -100,
							'max' => 200,
							'step' => .5,
						]
					],
					'selectors' => [
						'{{WRAPPER}} ol li:before' => 'top: calc({{SIZE}}{{UNIT}})',
						'{{WRAPPER}} ul li:before' => 'top: calc({{SIZE}}{{UNIT}})',
					],
					'separator' => 'after'
				]
			);



			// 1st List Color
			$this->add_control(
				'crel_advancedLists__1stList_color',
				[
					'label' => __( '1st List Color', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} ol' => 'color: {{VALUE}};',
						'{{WRAPPER}} ul' => 'color: {{VALUE}};',
					],
				]
			);

			// 2nd List Color
			$this->add_control(
				'crel_advancedLists__2ndList_color',
				[
					'label' => __( '2nd List Color', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} ol ol' => 'color: {{VALUE}};',
						'{{WRAPPER}} ol ul' => 'color: {{VALUE}};',
						'{{WRAPPER}} ul ul' => 'color: {{VALUE}};',
						'{{WRAPPER}} ul ol' => 'color: {{VALUE}};',
					],
				]
			);

			// 3rd List Color
			$this->add_control(
				'crel_advancedLists__3rdList_color',
				[
					'label' => __( '3rd List Color', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} ol ol ol' => 'color: {{VALUE}};',
						'{{WRAPPER}} ol ol ul' => 'color: {{VALUE}};',
						'{{WRAPPER}} ol ul ol' => 'color: {{VALUE}};',
						'{{WRAPPER}} ul ul ul' => 'color: {{VALUE}};',
						'{{WRAPPER}} ul ul ol' => 'color: {{VALUE}};',
						'{{WRAPPER}} ul ol ul' => 'color: {{VALUE}};',
					],
					'separator' => 'after',
				]
			);

			// 1st List Typography
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'label'     => __( '1st List Typography', 'creative-addons-for-elementor' ),
					'name'      => 'crel_advancedLists__1stList_typography',
					'selector'  => '{{WRAPPER}} ol, {{WRAPPER}} ul',
				]
			);

			// 2nd List Typography
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'label'     => __( '2nd List Typography', 'creative-addons-for-elementor' ),
					'name'      => 'crel_advancedLists__2ndList_typography',
					'selector'  => '{{WRAPPER}} ol ol, {{WRAPPER}} ul ul',
				]
			);

			// 3rd List Typography
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'label'     => __( '3rd List Typography', 'creative-addons-for-elementor' ),
					'name'      => 'crel_advancedLists__3rdList_typography',
					'selector'  => '{{WRAPPER}} ol ol ol, {{WRAPPER}} ul ul ul',
				]
			);

		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		$text               = wp_kses( $settings['crel_advancedLists__list_text'] , 'post' );
		$main_alignment     = esc_attr( $settings['crel_advancedLists__container_alignment']);
		$list_1st_Types     = esc_attr( $settings['crel_advancedLists__1stList_type'] );
		$list_2nd_Types     = esc_attr( $settings['crel_advancedLists__2ndList_type'] );
		$list_3rd_Types     = esc_attr( $settings['crel_advancedLists__3rdList_type'] );
		$description               = wp_kses( $settings['crel_advancedLists__list_description'] , 'post' );
		$description_position           = esc_attr( $settings['crel_advancedLists__description_position'] );
		
		$this->add_render_attribute( 'crel_advancedLists__list_text', [
			'class' => [
				'crel-advanced-lists__inner',
				$list_1st_Types,
				$list_2nd_Types,
				$list_3rd_Types
			]
		] );

		$this->add_inline_editing_attributes( 'crel_advancedLists__list_text', 'advanced' );
		
		$this->add_render_attribute( 'crel_advancedLists__list_description', [
			'class' => [
				'crel-advanced-lists__description',
			]
		] );

		$this->add_inline_editing_attributes( 'crel_advancedLists__list_description', 'advanced' );
		
		?>

		<!-- Advanced Lists -->
		<div class="crel-advanced-lists-container <?php echo $main_alignment; ?>">
			
			<?php if ( $description_position == 'top' ) { ?>
				<div <?php echo $this->get_render_attribute_string( 'crel_advancedLists__list_description' ); ?>>
					<?php echo $description; ?>
				</div>
			<?php } ?>
			
			<div <?php echo $this->get_render_attribute_string( 'crel_advancedLists__list_text' ); ?>>
				<?php echo $text; ?>
			</div>
			
			<?php if ( $description_position == 'bottom' ) { ?>
				<div <?php echo $this->get_render_attribute_string( 'crel_advancedLists__list_description' ); ?>>
					<?php echo $description; ?>
				</div>
			<?php } ?>
			
		</div>		<?php
	}

	/**
	 * Dynamically render Advanced Lists
	 */
	protected function content_template() {		?>

		<div class="crel-advanced-lists-container {{{settings.crel_advancedLists__container_alignment}}}"><#
			view.addRenderAttribute( 'crel_advancedLists__list_text',	{
				'class': [ 
					'crel-advanced-lists__inner',
					settings.crel_advancedLists__1stList_type,
					settings.crel_advancedLists__2ndList_type,
					settings.crel_advancedLists__3rdList_type
				],
			} );
			
			view.addInlineEditingAttributes( 'crel_advancedLists__list_text', 'advanced' );

			view.addRenderAttribute( 'crel_advancedLists__list_description',	{
				'class': [ 
					'crel-advanced-lists__description',
				],
			} );
			
			view.addInlineEditingAttributes( 'crel_advancedLists__list_description', 'advanced' ); #>
			
			<# if ( settings.crel_advancedLists__description_position == 'top' ) { #>
				<div {{{ view.getRenderAttributeString( 'crel_advancedLists__list_description' ) }}}>
					{{{settings.crel_advancedLists__list_description}}}
				</div>
			<# } #>
			
			<div {{{ view.getRenderAttributeString( 'crel_advancedLists__list_text' ) }}}>
				{{{settings.crel_advancedLists__list_text}}}
			</div>
			
			<# if ( settings.crel_advancedLists__description_position == 'bottom' ) { #>
				<div {{{ view.getRenderAttributeString( 'crel_advancedLists__list_description' ) }}}>
					{{{settings.crel_advancedLists__list_description}}}
				</div>
			<# } #>

		</div>		<?php
	}
}