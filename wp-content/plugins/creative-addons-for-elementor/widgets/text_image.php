<?php
namespace Creative_Addons\Widgets;

use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Image_Size;
use Elementor\Repeater;
use Elementor\Icons_Manager;

defined( 'ABSPATH' ) || exit();


/**
 * Text and Image widget for Elementor
 */
class Text_Image extends Creative_Widget_Base {
	
	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Text and Image', 'creative-addons-for-elementor' );
	}
	
	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'crelfont crel-text-image-icon';
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
		return [ 'image', 'text', 'picture', 'description', 'text and image', 'image and text', 'instructions' ];
	}

	protected function get_config_defaults() {
		return [

			// Content Tab -------------------------------------------------/
			'crel_text_image__layout_type'      => 'row',
			'crel_text_image__layout_type_mobile' => 'column-reverse',
			'crel_text_image__structure'        => '50',
			'crel_text_image__text'             => '<p>' . __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Culpa enim esse excepturi nemo nesciunt officia officiis optio.', 'creative-addons-for-elementor' ) . '</p>',
			'crel_text_image__image'            => [
								'url' => Utils::get_placeholder_image_src(),
							],
			'image_size'                        => 'large',
			'crel_text_image__image_align'      => 'center',
			'crel_text_image__open_lightbox'    => 'yes',
			'crel_text_image__caption_text'     => '',

			// Style Tab ---------------------------------------------------/

			// General ---------------------------------/
			
			'crel_text_image__rows_spacing'                              => [
				'size' => '15',
				'unit' => 'px',
				'sizes' => []
			],

			// Body ------------------------------------/
			'crel_text_image__body_paddingLeftRight'                     => [
				'size' => 20,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_text_image__body_paddingTopBottom'                     => [
				'size' => 24,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_text_image__body_backgroundColor'                      => '#FFFFFF',
			'crel_text_image__body_borderRadius'                         => [
				'size' => 0,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_text_image__body_borderType_border'                           => '',

			// Text Editor -----------------------------/
			'crel_text_image__text_align'                                => 'left',
			'crel_text_image__text_textColor'                            => '#000000',
			'crel_text_image__text_ButtonTypography_typography'          => 'custom',
			'crel_text_image__text_ButtonTypography_font_size'           => [
				'size' => '14',
				'unit' => 'px',
				'sizes' => []
			],
			'crel_text_image__text_ButtonTypography_font_weight'         => 'normal',
			'crel_text_image__text_ButtonTypography_line_height'         => [
				'size' => '1.5',
				'unit' => 'em',
				'sizes' => []
			],

			// Image -----------------------------------/
			'crel_text_image__image_borderType_border'                   => 'solid',
			'crel_text_image__image_borderType_width'                    => [
				'top'       => '2',
				'left'      => '2',
				'right'     => '2',
				'bottom'    => '2',
				'unit' => 'px'
			],
			'crel_text_image__image_borderType_color'                    => '#A6A6A6',
			'crel_text_image__image_borderRadius'                        => [
				'size' => 0,
				'unit' => 'px',
				'sizes' => []
			],
			
			'crel_text_image__caption_typography_typography'          => 'custom',
			'crel_text_image__caption_typography_font_size'           => [
				'size' => '14',
				'unit' => 'px',
				'sizes' => []
			],
			'crel_text_image__caption_typography_font_weight'         => 'normal',
			'crel_text_image__caption_typography_line_height'         => [
				'size' => '1.5',
				'unit' => 'em',
				'sizes' => []
			],
			
			'crel_text_image__caption_color'                             => '#000000',
			'crel_text_image__caption_backgroundColor'                   => '#FFFFFF',
			'crel_text_image__caption_paddingLeftRight'                  => [
				'size' => 20,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_text_image__caption_paddingTopBottom'                  => [
				'size' => 20,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_text_image__caption_marginTop'                         => [
				'size' => 20,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_text_image__caption_width'                             => [
				'size' => 50,
				'unit' => '%',
				'sizes' => []
			],
			'crel_text_image__image__shadow_box_shadow_type'    => [
				'box_shadow_type' => [
					'default' => 'no',
				],
			],
			'crel_text_image__image__shadow_box_shadow'         => [
				'horizontal'    => 0,
				'vertical'      => 0,
				'blur'          => 0,
				'spread'        => 0,
				'color'         => '#000000',
			],

		];
	}

	protected function get_config_rtl_defaults() {
		return [];
	}

	protected function get_presets_defaults() {
		return array(

			// Image
			'crel_text_image__image_borderType_border'          => 'solid',
			'crel_text_image__image_borderType_color'           => '#A6A6A6',
			'crel_text_image__image_borderType_width'           => [
				'top'       => '2',
				'left'      => '2',
				'right'     => '2',
				'bottom'    => '2',
				'unit' => 'px'
			],
			'crel_text_image__image__shadow_box_shadow_type'    => [
				'box_shadow_type' => [
					'default' => 'no',
				],
			],
			'crel_text_image__image__shadow_box_shadow'         => [
				'horizontal'    => 0,
				'vertical'      => 0,
				'blur'          => 0,
				'spread'        => 0,
				'color'         => '#000000',
			],
			'crel_text_image__caption_text'                     => '',

			'crel_text_image__caption_width' => [
				'size' => 50,
				'unit' => '%',
				'sizes' => []
			],
		);
	}

	protected function get_presets_rtl_defaults() {
		return [];
	}

	/**
	 * Return presets for this widget
	 */
	public function get_presets_options() {

		$options = array();
		$brand_color = '#9d38a7';

		// Design 1: Text - Image - Grey Thin
		$options['default'] = array(
			'title' => __( 'Design 1: Text - Image - Grey Thin', 'creative-addons-for-elementor'),
			'preview_url' => $this->preview_url( 'text-image-design-1.jpg' ),
			'options' => array()
		);

		// Design 2: Text - Image - Grey Thick
		$options['design-2'] = array(
			'title' => __( 'Design 2: Text - Image - Grey Thick', 'creative-addons-for-elementor'),
			'preview_url' => $this->preview_url( 'text-image-design-2.jpg' ),
			'options' => array(

				// Image
				'crel_text_image__image_borderType_border'  => 'solid',
				'crel_text_image__image_borderType_color'   => '#E9ECED',
				'crel_text_image__image_borderType_width'   => [
					'top'       => '10',
					'right'     => '10',
					'bottom'    => '10',
					'left'      => '10',
					'isLinked'  => false,
					'unit'      => 'px'
				],
				'crel_text_image__image__shadow_box_shadow_type'    => [
					'box_shadow_type' => [
						'default' => 'no',
					],
				],
				'crel_text_image__image__shadow_box_shadow'         => [
					'horizontal'    => 0,
					'vertical'      => 0,
					'blur'          => 0,
					'spread'        => 0,
					'color'         => '#000000',
				],
			   'crel_text_image__caption_text'                     => ''
			)
		);


		//Design 3: Text - Image - Caption + Shadow
		$options['design-3'] = array(
			'title' => __( 'Design 3: Text - Image - Caption + Shadow', 'creative-addons-for-elementor'),
			'preview_url' => $this->preview_url( 'text-image-design-3.jpg' ),
			'options' => array(

				// Image
				'crel_text_image__image_borderType_border'          => 'solid',
				'crel_text_image__image_borderType_color'           => '#FFFFFF',
				'crel_text_image__image_borderType_width'           => [
					'top'       => '1',
					'right'     => '1',
					'bottom'    => '1',
					'left'      => '1',
					'isLinked'  => false,
					'unit'      => 'px'
				],
				'crel_text_image__image__shadow_box_shadow_type'    => [
					'box_shadow_type' => [
						'default' => 'no',
					],
				],
				'crel_text_image__image__shadow_box_shadow'         => [
					'horizontal'    => 0,
					'vertical'      => 0,
					'blur'          => 10,
					'spread'        => 0,
					'color'         => '#000000',
				],
				'crel_text_image__caption_text'                     => __( 'Click on Image to Zoom' , 'creative-addons-for-elementor'),
				
				'crel_text_image__caption_width' => [
					'size' => 100,
					'unit' => '%',
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

		// LAYOUT -------------------------------------------------------[SECTION]-------------/
		$this->start_controls_section(
			'crel_text_image__section_layout',
			[
				'label' => __( 'Layout', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

			// Layout Type
			$this->add_control_responsive(
				'crel_text_image__layout_type',
				[
					'label'     => __( 'Layout Type', 'creative-addons-for-elementor' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						'column-reverse'   => __( 'Image above text', 'creative-addons-for-elementor' ),
						'row-reverse' => is_rtl() ? __( 'Image right of text', 'creative-addons-for-elementor' ) : __( 'Image left of text', 'creative-addons-for-elementor' ),
						'column' => __( 'Image below text', 'creative-addons-for-elementor' ),
						'row'  => is_rtl() ? __( 'Image left of text', 'creative-addons-for-elementor' ) : __( 'Image right of text', 'creative-addons-for-elementor' ),
					],
					'separator' => 'before',
					'selectors' => [
						'{{WRAPPER}} .crel-text-image-container' => 'flex-direction: {{VALUE}};',
					],
				]
			);
			
			/* Fake control to trigger view update, hidden in styles  */
			$this->add_control(
				'crel_text_image__layout_type_trigger',
				[
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						'1'   => '1',
						'2' => '2'
					],
				]
			);

			// Structure
			$this->add_control(
				'crel_text_image__structure',
				[
					'label'     => __( 'Structure', 'creative-addons-for-elementor' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						'50'   => __( 'Columns', 'creative-addons-for-elementor' ) . ' 50, 50',
						'33'   => is_rtl() ? __( 'Columns', 'creative-addons-for-elementor' ) . ' 66, 33' : __( 'Columns', 'creative-addons-for-elementor' ) . ' 33, 66',
						'66'   => is_rtl() ? __( 'Columns', 'creative-addons-for-elementor' ) . ' 33, 66' : __( 'Columns', 'creative-addons-for-elementor' ) . ' 66, 33',
						'75'   => is_rtl() ? __( 'Columns', 'creative-addons-for-elementor' ) . ' 25, 75' : __( 'Columns', 'creative-addons-for-elementor' ) . ' 75, 25',
						'25'   => is_rtl() ? __( 'Columns', 'creative-addons-for-elementor' ) . ' 75, 25' : __( 'Columns', 'creative-addons-for-elementor' ) . ' 25, 75',
					],
					'condition'	=> [
						'crel_text_image__layout_type'	=> ['row-reverse', 'row']
					],
					'selectors' => [
						'{{WRAPPER}} .crel-row-reverse>div:last-child' => 'width: {{VALUE}}%',
						'{{WRAPPER}} .crel-row-reverse>div:first-child' => 'width: calc( 100% - {{VALUE}}%)',
						'{{WRAPPER}} .crel-row>div:first-child' => 'width: {{VALUE}}%',
						'{{WRAPPER}} .crel-row>div:last-child' => 'width: calc( 100% - {{VALUE}}%)',
						
						'(desktop){{WRAPPER}} .crel-desktop-row-reverse>div:last-child' => 'width: {{VALUE}}%',
						'(desktop){{WRAPPER}} .crel-desktop-row-reverse>div:first-child' => 'width: calc( 100% - {{VALUE}}%)',
						'(desktop){{WRAPPER}} .crel-desktop-row>div:first-child' => 'width: {{VALUE}}%',
						'(desktop){{WRAPPER}} .crel-desktop-row>div:last-child' => 'width: calc( 100% - {{VALUE}}%)',
						'(desktop){{WRAPPER}} .crel-desktop-column>div:first-child' => 'width: 100%',
						'(desktop){{WRAPPER}} .crel-desktop-column>div:last-child' => 'width: 100%',
						'(desktop){{WRAPPER}} .crel-desktop-column-reverse>div:first-child' => 'width: 100%',
						'(desktop){{WRAPPER}} .crel-desktop-column-reverse>div:last-child' => 'width: 100%',
						
						'(tablet){{WRAPPER}} .crel-tablet-row-reverse>div:last-child' => 'width: {{VALUE}}%',
						'(tablet){{WRAPPER}} .crel-tablet-row-reverse>div:first-child' => 'width: calc( 100% - {{VALUE}}%)',
						'(tablet){{WRAPPER}} .crel-tablet-row>div:first-child' => 'width: {{VALUE}}%',
						'(tablet){{WRAPPER}} .crel-tablet-row>div:last-child' => 'width: calc( 100% - {{VALUE}}%)',
						'(tablet){{WRAPPER}} .crel-tablet-column>div:first-child' => 'width: 100%',
						'(tablet){{WRAPPER}} .crel-tablet-column>div:last-child' => 'width: 100%',
						'(tablet){{WRAPPER}} .crel-tablet-column-reverse>div:first-child' => 'width: 100%',
						'(tablet){{WRAPPER}} .crel-tablet-column-reverse>div:last-child' => 'width: 100%',
						
						'(mobile){{WRAPPER}} .crel-mobile-row-reverse>div:last-child' => 'width: {{VALUE}}%',
						'(mobile){{WRAPPER}} .crel-mobile-row-reverse>div:first-child' => 'width: calc( 100% - {{VALUE}}%)',
						'(mobile){{WRAPPER}} .crel-mobile-row>div:first-child' => 'width: {{VALUE}}%',
						'(mobile){{WRAPPER}} .crel-mobile-row>div:last-child' => 'width: calc( 100% - {{VALUE}}%)',
						'(mobile){{WRAPPER}} .crel-mobile-column>div:first-child' => 'width: 100%',
						'(mobile){{WRAPPER}} .crel-mobile-column>div:last-child' => 'width: 100%',
						'(mobile){{WRAPPER}} .crel-mobile-column-reverse>div:first-child' => 'width: 100%',
						'(mobile){{WRAPPER}} .crel-mobile-column-reverse>div:last-child' => 'width: 100%',
					],
				]
			);
		$this->end_controls_section();

		// IMAGE --------------------------------------------------------[SECTION]-------------/
		$this->start_controls_section(
			'crel_text_image__section_image',
			[
				'label' => __( 'Image', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

			// Image
			$this->add_control(
				'crel_text_image__image',
				[
					'label' => __( 'Image', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::MEDIA,
				]
			);

			// Size
			$this->add_control_group(
				Group_Control_Image_Size::get_type(),
				[
					'name' => 'image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
					'separator' => 'none',
				]
			);

			// Alignment
			$this->add_control_responsive(
				'crel_text_image__image_align',
				[
					'label' => __( 'Alignment', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::CHOOSE,
					'options' => [
						'left' => [
							'title' => __( 'Left', 'creative-addons-for-elementor' ),
							'icon' => 'eicon-text-align-left',
						],
						'center' => [
							'title' => __( 'Center', 'creative-addons-for-elementor' ),
							'icon' => 'eicon-text-align-center',
						],
						'right' => [
							'title' => __( 'Right', 'creative-addons-for-elementor' ),
							'icon' => 'eicon-text-align-right',
						],
					],
					'selectors' => [
						'{{WRAPPER}} .crel-text-image-img' => 'text-align: {{VALUE}};',
					],
				]
			);

			// Image Custom Caption
			$this->add_control(
				'crel_text_image__caption_text',
				[
					'label' => __( 'Caption', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::TEXT,
					'placeholder' => __( 'Enter your image caption', 'creative-addons-for-elementor' ),
					'force_preset' => true
				]
			);

			// Image LightBox
			$this->add_control(
				'crel_text_image__open_lightbox',
				[
					'label' => __( 'Lightbox', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::SELECT,
					'options' => [
						'yes' => __( 'Yes', 'creative-addons-for-elementor' ),
						'no' => __( 'No', 'creative-addons-for-elementor' ),
					],

				]
			);
		$this->end_controls_section();


		// DESCRIPTION --------------------------------------------------[SECTION]-------------/
		$this->start_controls_section(
			'crel_text_image__section_description',
			[
				'label' => __( 'Description', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

			// Text
			$this->add_control(
				'crel_text_image__text',
				[
					'label'         => __( 'Text', 'creative-addons-for-elementor'),
					'type'          => Controls_Manager::WYSIWYG,
					'label_block'   => true,
					'separator'     => 'before',
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
			'crel_text_image__general_section_style',
				[
					'label' => __( 'General', 'creative-addons-for-elementor' ),
					'tab' => Controls_Manager::TAB_STYLE
				]
			);

			// Space between Rows
			$this->add_control_responsive(
				'crel_text_image__rows_spacing',
				[
					'label' => __( 'Space between Text and Image', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 200,
							'step' => 1,
						]
					],
					'selectors' => [
						'{{WRAPPER}} .crel-column .crel-text-image-body'    => 'padding-bottom: calc({{SIZE}}px / 2);',
						'{{WRAPPER}} .crel-column .crel-text-image-img'    => 'padding-top: calc({{SIZE}}px / 2);',
						
						'{{WRAPPER}} .crel-column-reverse .crel-text-image-body'    => 'padding-top: calc({{SIZE}}px / 2);',
						'{{WRAPPER}} .crel-column-reverse .crel-text-image-img'    => 'padding-bottom: calc({{SIZE}}px / 2);',
						
						'{{WRAPPER}} .crel-row-reverse .crel-text-image-body'    => is_rtl() ? 'padding-right: calc({{SIZE}}px / 2);' : 'padding-left: calc({{SIZE}}px / 2);',
						'{{WRAPPER}} .crel-row-reverse .crel-text-image-img'    => is_rtl() ? 'padding-left: calc({{SIZE}}px / 2);' : 'padding-right: calc({{SIZE}}px / 2);',
						
						'{{WRAPPER}} .crel-row .crel-text-image-body'    => is_rtl() ? 'padding-left: calc({{SIZE}}px / 2);' : 'padding-right: calc({{SIZE}}px / 2);',
						'{{WRAPPER}} .crel-row .crel-text-image-img'    => is_rtl() ? 'padding-right: calc({{SIZE}}px / 2);' : 'padding-left: calc({{SIZE}}px / 2);',
						
						'(tablet)
						{{WRAPPER}} .crel-column .crel-text-image-img, 
						{{WRAPPER}} .crel-column .crel-text-image-body,
						{{WRAPPER}} .crel-column-reverse .crel-text-image-img, 
						{{WRAPPER}} .crel-column-reverse .crel-text-image-body,
						{{WRAPPER}} .crel-row .crel-text-image-img, 
						{{WRAPPER}} .crel-row .crel-text-image-body,
						{{WRAPPER}} .crel-row-reverse .crel-text-image-img, 
						{{WRAPPER}} .crel-row-reverse .crel-text-image-body,
						
						{{WRAPPER}} .crel-tablet-column .crel-text-image-img, 
						{{WRAPPER}} .crel-tablet-column .crel-text-image-body,
						{{WRAPPER}} .crel-tablet-column-reverse .crel-text-image-img, 
						{{WRAPPER}} .crel-tablet-column-reverse .crel-text-image-body,
						{{WRAPPER}} .crel-tablet-row-reverse .crel-text-image-img, 
						{{WRAPPER}} .crel-tablet-row-reverse .crel-text-image-body,
						{{WRAPPER}} .crel-tablet-row-reverse .crel-text-image-img, 
						{{WRAPPER}} .crel-tablet-row-reverse .crel-text-image-body'    => 'padding: 0!important;',
						
						'(tablet){{WRAPPER}} .crel-tablet-column .crel-text-image-body'    => 'padding-bottom: calc({{SIZE}}px / 2)!important;',
						'(tablet){{WRAPPER}} .crel-tablet-column .crel-text-image-img'    => 'padding-top: calc({{SIZE}}px / 2)!important;',
						
						'(tablet){{WRAPPER}} .crel-tablet-column-reverse .crel-text-image-body'    => 'padding-top: calc({{SIZE}}px / 2)!important;',
						'(tablet){{WRAPPER}} .crel-tablet-column-reverse .crel-text-image-img'    => 'padding-bottom: calc({{SIZE}}px / 2)!important;',
						
						'(tablet){{WRAPPER}} .crel-tablet-row-reverse .crel-text-image-body'    => is_rtl() ? 'padding-right: calc({{SIZE}}px / 2)!important;' : 'padding-left: calc({{SIZE}}px / 2)!important;',
						'(tablet){{WRAPPER}} .crel-tablet-row-reverse .crel-text-image-img'    => is_rtl() ? 'padding-left: calc({{SIZE}}px / 2)!important;' : 'padding-right: calc({{SIZE}}px / 2)!important;',
						
						'(tablet){{WRAPPER}} .crel-tablet-row .crel-text-image-body'    => is_rtl() ? 'padding-left: calc({{SIZE}}px / 2)!important;' : 'padding-right: calc({{SIZE}}px / 2)!important;',
						'(tablet){{WRAPPER}} .crel-tablet-row .crel-text-image-img'    => is_rtl() ? 'padding-right: calc({{SIZE}}px / 2)!important;' : 'padding-left: calc({{SIZE}}px / 2)!important;',
						
						
						'(mobile)
						{{WRAPPER}} .crel-column .crel-text-image-img, 
						{{WRAPPER}} .crel-column .crel-text-image-body,
						{{WRAPPER}} .crel-column-reverse .crel-text-image-img, 
						{{WRAPPER}} .crel-column-reverse .crel-text-image-body,
						{{WRAPPER}} .crel-row .crel-text-image-img, 
						{{WRAPPER}} .crel-row .crel-text-image-body,
						{{WRAPPER}} .crel-row-reverse .crel-text-image-img, 
						{{WRAPPER}} .crel-row-reverse .crel-text-image-body,
						{{WRAPPER}} .crel-tablet-column .crel-text-image-img, 
						{{WRAPPER}} .crel-tablet-column .crel-text-image-body,
						{{WRAPPER}} .crel-tablet-column-reverse .crel-text-image-img, 
						{{WRAPPER}} .crel-tablet-column-reverse .crel-text-image-body,
						{{WRAPPER}} .crel-tablet-row-reverse .crel-text-image-img, 
						{{WRAPPER}} .crel-tablet-row-reverse .crel-text-image-body,
						{{WRAPPER}} .crel-tablet-row-reverse .crel-text-image-img, 
						{{WRAPPER}} .crel-tablet-row-reverse .crel-text-image-body'    => 'padding: 0!important;',
						
						'(mobile){{WRAPPER}} .crel-mobile-column .crel-text-image-body'    => 'padding-bottom: calc({{SIZE}}px / 2)!important;',
						'(mobile){{WRAPPER}} .crel-mobile-column .crel-text-image-img'    => 'padding-top: calc({{SIZE}}px / 2)!important;',
						
						'(mobile){{WRAPPER}} .crel-mobile-column-reverse .crel-text-image-body'    => 'padding-top: calc({{SIZE}}px / 2)!important;',
						'(mobile){{WRAPPER}} .crel-mobile-column-reverse .crel-text-image-img'    => 'padding-bottom: calc({{SIZE}}px / 2)!important;',
						
						'(mobile){{WRAPPER}} .crel-mobile-row-reverse .crel-text-image-body'    => is_rtl() ? 'padding-right: calc({{SIZE}}px / 2)!important;' : 'padding-left: calc({{SIZE}}px / 2)!important;',
						'(mobile){{WRAPPER}} .crel-mobile-row-reverse .crel-text-image-img'    => is_rtl() ? 'padding-left: calc({{SIZE}}px / 2)!important;' : 'padding-right: calc({{SIZE}}px / 2)!important;',
						
						'(mobile){{WRAPPER}} .crel-mobile-row .crel-text-image-body'    => is_rtl() ? 'padding-left: calc({{SIZE}}px / 2)!important;' : 'padding-right: calc({{SIZE}}px / 2)!important;',
						'(mobile){{WRAPPER}} .crel-mobile-row .crel-text-image-img'    => is_rtl() ? 'padding-right: calc({{SIZE}}px / 2)!important;' : 'padding-left: calc({{SIZE}}px / 2)!important;',
					]
				]
			);

		$this->end_controls_section();

		// BODY ----------------------------[SECTION]-------------/
		$this->start_controls_section(
			'crel_text_image__body_section_style',
			[
				'label' => __( 'Body', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

			// BODY Padding Left / Right
			$this->add_control_responsive(
				'crel_text_image__body_paddingLeftRight',
				[
					'label' => __( 'Padding ( Left / Right )', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
							'step' => 1,
						]
					],
					'selectors' => [
						'{{WRAPPER}} .crel-text-image-container' => 'padding-left: {{SIZE}}px; padding-right: {{SIZE}}px;'
					]
				]
			);

			// BODY Padding Top / Bottom
			$this->add_control_responsive(
				'crel_text_image__body_paddingTopBottom',
				[
					'label' => __( 'Padding ( Top / Bottom )', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
							'step' => 1,
						]
					],
					'selectors' => [
						'{{WRAPPER}} .crel-text-image-container' => 'padding-top: {{SIZE}}px; padding-bottom: {{SIZE}}px;'
					],

				]
			);

			// BODY Background Color
			$this->add_control(
				'crel_text_image__body_backgroundColor',
				[
					'label' => __( 'Background Color', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crel-text-image-container' => 'background-color: {{VALUE}};',
					]
				]
			);

			// BODY border-radius
			$this->add_control_responsive(
				'crel_text_image__body_borderRadius',
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
						'{{WRAPPER}} .crel-text-image-container' => 'border-radius: {{SIZE}}px;',
					]
				]
			);

			// BODY Border Type
			$this->add_control_group(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crel_text_image__body_borderType',
					'label'     => __( 'Border', 'creative-addons-for-elementor'),
					'selector'  => '{{WRAPPER}} .crel-text-image-container',
				]
			);

		$this->end_controls_section();

		// TEXT EDITOR ---------------------[SECTION]-------------/
		$this->start_controls_section(
			'crel_text_image__textEditor_section_style',
			[
				'label' => __( 'Description', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

			// Text Alignment
			$this->add_control_responsive(
				'crel_text_image__text_align',
				[
					'label' => __( 'Alignment', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::CHOOSE,
					'options' => [
						'left' => [
							'title' => __( 'Left', 'creative-addons-for-elementor' ),
							'icon' => 'fas fa-align-left',
						],
						'center' => [
							'title' => __( 'Center', 'creative-addons-for-elementor' ),
							'icon' => 'fas fa-align-center',
						],
						'right' => [
							'title' => __( 'Right', 'creative-addons-for-elementor' ),
							'icon' => 'fas fa-align-right',
						],
					],
					'selectors' => [
						'{{WRAPPER}} .elementor-text-editor, {{WRAPPER}} .elementor-text-editor p' => 'text-align: {{VALUE}};',
					]
				]
			);

			// Text Background Color
			$this->add_control(
				'crel_text_image__text_textColor',
				[
					'label' => __( 'Color', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .elementor-text-editor, {{WRAPPER}} .elementor-text-editor p' => 'color: {{VALUE}};',
					]
				]
			);

			// Text Typography
			$this->add_control_group(
				Group_Control_Typography::get_type(),
				[
					'name' => 'crel_text_image__text_ButtonTypography',
					'selector' => '{{WRAPPER}} .elementor-text-editor, {{WRAPPER}} .elementor-text-editor p',
				]
			);

		$this->end_controls_section();

		// IMAGE -------------------------[SECTION]-------------/
		$this->start_controls_section(
			'crel_text_image__image_section_style',
			[
				'label' => __( 'Image', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

			// Image Border Type
			$this->add_control_group(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crel_text_image__image_borderType',
					'label'     => __( 'Border', 'creative-addons-for-elementor'),
					'selector'  => '{{WRAPPER}} .crel-text-image-img img',
				]
			);

			// Image border-radius
			$this->add_control_responsive(
				'crel_text_image__image_borderRadius',
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
						'{{WRAPPER}} .crel-text-image-img img'   => 'border-radius: {{SIZE}}px;',
					]
				]
			);

			// Box Shadow
			$this->add_control_group(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'crel_text_image__image__shadow',
					'selector' => '{{WRAPPER}} .crel-text-image-img img',
				]
			);
			

		$this->end_controls_section();


		// IMAGE CAPTION --------------------------------------------[SECTION]-------------/
		$this->start_controls_section(
			'crel_text_image__image_caption_section_style',
			[
				'label' => __( 'Image Caption', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);
			// Caption Color
			$this->add_control(
				'crel_text_image__caption_color',
				[
					'label' => __( 'Color', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crel-caption-text' => 'color: {{VALUE}};',
					]
				]
			);

			// Caption Background Color
			$this->add_control(
				'crel_text_image__caption_backgroundColor',
				[
					'label' => __( 'Background Color', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crel-caption-text' => 'background-color: {{VALUE}};',
					]
				]
			);

			// Caption Typography
			$this->add_control_group(
				Group_Control_Typography::get_type(),
				[
					'name' => 'crel_text_image__caption_typography',
					'selector' => '{{WRAPPER}} .crel-caption-text',
				]
			);

			// Caption Padding Left / Right
			$this->add_control_responsive(
				'crel_text_image__caption_paddingLeftRight',
				[
					'label' => __( 'Padding ( Left / Right )', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
							'step' => 1,
						]
					],
					'selectors' => [
						'{{WRAPPER}} .crel-caption-text' => 'padding-left: {{SIZE}}px; padding-right: {{SIZE}}px;'
					]
				]
			);

			// Caption Padding Top / Bottom
			$this->add_control_responsive(
				'crel_text_image__caption_paddingTopBottom',
				[
					'label' => __( 'Padding ( Top / Bottom )', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
							'step' => 1,
						]
					],
					'selectors' => [
						'{{WRAPPER}} .crel-caption-text' => 'padding-top: {{SIZE}}px; padding-bottom: {{SIZE}}px;'
					],

				]
			);

			// Caption Margin Top
			$this->add_control_responsive(
				'crel_text_image__caption_marginTop',
				[
					'label' => __( 'Space From Image', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => -200,
							'max' => 200,
							'step' => 1,
						]
					],
					'selectors' => [
						'{{WRAPPER}} .crel-caption-text' => 'margin-top: {{SIZE}}px;',
					]
				]
			);

			// Caption Width
			$this->add_control_responsive(
				'crel_text_image__caption_width',
				[
					'label' => __( 'Width', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 10,
							'max' => 100,
							'step' => 1,
						]
					],
					'selectors' => [
						'{{WRAPPER}} .crel-caption-text' => 'width: {{SIZE}}%;',
					]
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
		
		$layout = 'crel-' . $settings['crel_text_image__layout_type'];
		
		if ( !empty( $settings['crel_text_image__layout_type_desktop'] ) ) {
			$layout .= ' crel-desktop-' . $settings['crel_text_image__layout_type_desktop'];
		}
		
		if ( !empty( $settings['crel_text_image__layout_type_tablet'] ) ) {
			$layout .= ' crel-tablet-' . $settings['crel_text_image__layout_type_tablet'];
		}
		
		if ( !empty( $settings['crel_text_image__layout_type_mobile'] ) ) {
			$layout .= ' crel-mobile-' . $settings['crel_text_image__layout_type_mobile'];
		} ?>
		
		<div class="crel-text-image-container <?php echo esc_attr( $layout ); ?>">
			<?php $this->render_text_column( $settings['crel_text_image__text'] ); ?>
			<?php $this->render_image( $settings['crel_text_image__image'], $settings ); ?>
		</div>		<?php
	}

	/**
	 * Renders the Icon / Image HTML
	 * @param $image_data
	 * @param $settings
	 */
	protected function render_image( $image_data, $settings ) {

		$style = '';
		$srcset = '';

		if ( $image_data['id'] ) {
			// not a placeholder image
			$post_meta = get_post_meta( $image_data['id'], '_wp_attachment_image_alt', true );
			if ( empty($post_meta) ) {
				$image_alt = '';
			} else {
				$image_alt = trim( strip_tags( $post_meta ) );
			}

			$image_url = Group_Control_Image_Size::get_attachment_image_src( $image_data['id'], 'image', $settings );

			$srcset = wp_get_attachment_image_srcset( $image_data['id'], $settings['image_size']);
			if ( $srcset ) $srcset = 'srcset="' . $srcset . '"';

		} else {
			$image_alt = '';
			$image_url = esc_url($image_data['url']);

			foreach ( $this->get_image_sizes() as $size_name => $size_data ) {
				if ( $settings['image_size'] == $size_name ) {
					$style = ( $size_data['width'] ? 'max-width: ' . $size_data['width'] . 'px; ' : '' ) . ( $size_data['height'] ? 'max-height: ' . $size_data['height'] . 'px; ' : '' );
				}
			}
		}

		//Light box
		$lightBox  = $settings['crel_text_image__open_lightbox'];
		$caption   = esc_attr($settings['crel_text_image__caption_text']);
		$image_full = esc_url($image_data['url']);

		if ( ! $image_url ) {
			$image_url = $image_full = Utils::get_placeholder_image_src();
		}

		// turn off lightbox on admin side
		if ( is_admin() ) {
			$image_full = '';
		}

		echo '<div class="crel-text-image-img elementor-image">';

		if ( $caption ) { ?>
			<figure class="crel-caption">		    <?php
		}

		if ( $lightBox === 'yes' ) { ?>
			<a href="<?php echo $image_full; ?>" data-elementor-open-lightbox="yes" data-elementor-lightbox-title=" ">
			<?php } else { ?>
			<div>
		<?php } ?>
			<span style="<?php echo $style; ?>" class="crel-text-image-img-wrap">
								<img src="<?php echo $image_url; ?>" alt="<?php echo esc_attr($image_alt); ?>" <?php echo $srcset; ?> loading="lazy">
							</span>

			<?php if ( $lightBox === 'yes' ) { ?>
			</a>
		<?php } else { ?>
			</div><?php
		}

		if ( $caption ) { ?>
			<figcaption class="crel-widget-image-caption crel-caption-text"><?php echo $caption; ?></figcaption>
		<?php }

		if ( $caption ) { ?>
			</figure>		    <?php
		}

		echo '</div>';
	}

	private function render_text_column( $text ) {

		$this->add_render_attribute( 'crel_text_image__text', [
			'class' => [ 'elementor-text-editor', 'elementor-clearfix' ]
		] );

		$this->add_inline_editing_attributes( 'crel_text_image__text', 'advanced' );	?>

		<div class="crel-text-image-body">
			<div <?php echo $this->get_render_attribute_string( 'crel_text_image__text' ); ?>>
				<?php echo wp_kses_post( $text ); ?>
			</div>
		</div>	<?php
	}

	protected function content_template() { 
	
		$image_sizes = $this->get_image_sizes(); ?>
		
		<# 
			let layout = 'crel-' + settings.crel_text_image__layout_type;
		
			if ( typeof settings.crel_text_image__layout_type_desktop != 'undefined' && settings.crel_text_image__layout_type_desktop ) {
				layout += ' crel-desktop-' + settings.crel_text_image__layout_type_desktop;
			}
			
			if ( typeof settings.crel_text_image__layout_type_tablet != 'undefined' && settings.crel_text_image__layout_type_tablet ) {
				layout += ' crel-tablet-' + settings.crel_text_image__layout_type_tablet;
			}
			
			if ( typeof settings.crel_text_image__layout_type_mobile != 'undefined' && settings.crel_text_image__layout_type_mobile ) {
				layout += ' crel-mobile-' + settings.crel_text_image__layout_type_mobile;
			}
			
		#>
		
		<div class="crel-text-image-container {{{layout}}}"><#
			
			let image_url = '';
			let full_image_url = ''; // empty to off lightbox
			let style = ''; <?php
					
			foreach ( $image_sizes as $size_name => $size_data ) { ?>					
				if ( settings.image_size == '<?php echo $size_name; ?>' ) { 
					style = '<?php 
						echo $size_data['width'] ? 'max-width: ' . $size_data['width'] . 'px; ' : ' ';
						echo $size_data['height'] ? 'max-height: ' . $size_data['height'] . 'px; ' : ' '; ?>';
				}<?php
			} ?>
					
			if ( typeof settings.crel_text_image__image.id == 'undefined' || ! settings.crel_text_image__image.id ) {
				image_url = settings.crel_text_image__image.url; 
			} else {
				let image = {
					id: settings.crel_text_image__image.id,
					url: settings.crel_text_image__image.url,
					size: settings.image_size,
					dimension: settings.image_custom_dimension,
					model: view.getEditModel()
				}

				image_url = elementor.imagesManager.getImageUrl( image );
			}
				
			if ( ! image_url ) {
				image_url = '<?php echo Utils::get_placeholder_image_src(); ?>';
			}
			
			#>
			
			<div class="crel-text-image-body"><#
				view.addRenderAttribute( 'crel_text_image__text',	{
					'class': [ 'elementor-text-editor', 'elementor-clearfix' ],
				} );
				view.addInlineEditingAttributes( 'crel_text_image__text', 'none' ); #>
				<div {{{ view.getRenderAttributeString( 'crel_text_image__text' ) }}}>
					{{{ settings.crel_text_image__text }}}
				</div>
			</div>
			<div class="crel-text-image-img elementor-image">
			<#
				if ( settings.crel_text_image__caption_text ) { #>
					<figure class="crel-caption">		    <#
				}

					if ( settings.crel_text_image__open_lightbox == 'yes' ) { #>
						<a href="{{{ full_image_url }}}" data-elementor-open-lightbox="yes" data-elementor-lightbox-title=" " style="{{{style}}}" ><#
					} else { #>
						<div><#
					} #>

						<span style="{{{style}}}" class="crel-text-image-img-wrap"><img src="{{{ image_url }}}"></span><#

					if ( settings.crel_text_image__open_lightbox == 'yes' ) { #>
						</a><#
					} else { #>
						</div><#
					}

				if ( settings.crel_text_image__caption_text ) { #>
					<figcaption class="crel-widget-image-caption crel-caption-text">{{{ settings.crel_text_image__caption_text }}}</figcaption>
				</figure>		    <#
				} #>

			</div>
			
			
		</div><?php
	}

	protected function preview_url( $img ) {
		return CREATIVE_ADDONS_ASSETS_URL . 'images/presets/text-image/' . $img;
	}

}