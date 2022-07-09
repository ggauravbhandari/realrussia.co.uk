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
 * Steps widget for Elementor
 */
class Steps extends Creative_Widget_Base {
	
	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
		$this->register_crel_script( 'steps' );
	}
	
	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Steps', 'creative-addons-for-elementor' );
	}
	
	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'crelfont crel-steps-icon';
	}

	/**
	 * Retrieve the widget Demo URL.
	 *
	 * @return string Widget Demo URL.
	 */
	public function get_demo_url() {
		return 'https://www.creative-addons.com/elementor-widgets/steps/';
	}

	/**
	 * Retrieve the widget Documentation URL.
	 *
	 * @return string Widget Documentation URL.
	 */
	public function get_documentation_url() {
		return 'https://www.creative-addons.com/elementor-docs/steps-widget/';
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
		return [ 'steps', 'info', 'text', 'instruction', 'guide' ];
	}

	protected function get_config_defaults() {
		return [

			// Content Tab -------------------------------------------------/
			'crel_steps__title_text'                                => __( 'Steps Title', 'creative-addons-for-elementor' ),
			'crel_steps__list_type' 		                        => 'crel-steps--decimal',
			'crel_steps__titlePrefix_text'                          => __( '', 'creative-addons-for-elementor' ),
			'crel_steps__titleHTML_tag'                             => 'h3',
			'crel_steps__list'   => [
				[
					'crel_steps__title_text'    => __( 'First Step', 'creative-addons-for-elementor' ),
					'crel_steps__desc_text'          => __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Culpa enim esse excepturi nemo nesciunt officia officiis optio.', 'creative-addons-for-elementor' ),
					'crel_steps__layout_type' => 'layout-img-right',
					'crel_steps__structure' => 'structure-50-50',
					'crel_steps__image' => [
						'url' => Utils::get_placeholder_image_src(),
					],
					'crel_steps__open_lightbox' => 'yes',
				],
				[
					'crel_steps__title_text'    => __( 'Second Step', 'creative-addons-for-elementor' ),
					'crel_steps__desc_text'          => __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Culpa enim esse excepturi nemo nesciunt officia officiis optio.', 'creative-addons-for-elementor' ),
					'crel_steps__layout_type' => 'layout-img-right',
					'crel_steps__structure' => 'structure-50-50',
					'crel_steps__image' => [
						'url' => Utils::get_placeholder_image_src(),
					],
					'crel_steps__open_lightbox' => 'yes',
				],
			],
			'crel_steps__anchorLink_icon' => [
				'value' => 'fas fa-link',
				'library' => 'fa-solid',
			],

			// Style Tab ---------------------------------------------------/

			// General ---------------------------------/
			'crel_steps__container_backgroundColor'                 => '#FFFFFF',
			'crel_steps__list_spacing'                              => [
				'size' => '50',
				'unit' => 'px',
				'sizes' => []
			],
			'crel_steps__blocks_spacing'                            => [
				'size' => '14',
				'unit' => 'px',
				'sizes' => []
			],

			// Header ----------------------------------/
			'crel_steps__header_layout'                             => 'crel-step-header__inner--row',
			'crel_steps__header_paddingLeftRight'                   => [
				'size' => 5,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_steps__header_paddingTopBottom'                   => [
				'size' => 10,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_steps__header_marginBottom'                       => [
				'size'  => 20,
				'unit'  => 'px',
				'sizes' => []
			],
			'crel_steps__header_backgroundColor'                    => '#FFFFFF',
			'crel_steps__header_borderRadius'                       => [
				'top'       => '0',
				'left'      => '0',
				'right'     => '0',
				'bottom'    => '0',
				'unit'      => 'px'
			],
			'crel_steps__header_BorderType_border'                  => 'solid',
			'crel_steps__header_BorderType_width'                   => [
				'top' => '0',
				'left' => '0',
				'right' => '0',
				'bottom' => '2',
				'unit' => 'px',
				'isLinked' => false
			],
			'crel_steps__header_BorderType_color'                   => '#000000',
			'crel_steps__headerMiddleDivider__toggle'               => 'no',
			'crel_steps__headerMiddleDivider_BorderType_border'     => '',
			'crel_steps__headerMiddleDivider_BorderType_width'      => [
				'top' => '0',
				'left' => '0',
				'right' => '0',
				'bottom' => '2',
				'unit' => 'px',
				'isLinked' => false
			],
			'crel_steps__headerMiddleDivider_BorderType_color'      => '#000000',
			'crel_steps__headerMiddleDivider_marginLeft'            => [
				'size' => 10,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_steps__headerMiddleDivider_marginRight'           => [
				'size' => 0,
				'unit' => 'px',
				'sizes' => []
			],

			// Prefix / Counter Container --------------/
			'crel_steps__prefixCounterContainer_layout' 		    => 'crel-step-header__step--row',
			'crel_steps__prefixCounterContainer_padding'            => [
				'top'       => '0',
				'left'      => '0',
				'right'     => '0',
				'bottom'    => '0',
				'unit'      => 'px'
			],
			'crel_steps__prefixCounterContainer_borderRadius'       => [
				'top'       => '10',
				'left'      => '0',
				'right'     => '0',
				'bottom'    => '0',
				'unit'      => 'px',
				'isLinked' => false
			],
			'crel_steps__prefixCounterContainer__backgroundColor'   => '#FFFFFF',
			'crel_steps__prefixCounterContainer_BorderType_border'  => '',
			'crel_steps__prefixCounterContainer_BorderType_width'   => [
				'top' => '0',
				'left' => '0',
				'right' => '0',
				'bottom' => '2',
				'unit' => 'px',
				'isLinked' => false
			],
			'crel_steps__prefixCounterContainer_BorderType_color'   => '#000000',

			// Title Prefix ----------------------------/
			'crel_steps__prefix_paddingLeftRight'                   => [
				'size' => 0,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_steps__prefix_paddingTopBottom'                   => [
				'size' => 0,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_steps__prefix_startingSpace'                      => [
				'size' => 0,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_steps__prefix_backgroundColor'                    => '#FFFFFF',
			'crel_steps__prefix_borderRadius'                       => [
				'size' => 0,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_steps__prefix_rotate'                             => [
				'unit' => 'deg',
				'sizes' => []
			],
			
			// Counter ---------------------------------/
			
			'crel_steps__stepNum_padding'                  => [
				'top'       => '0',
				'left'      => '0',
				'right'     => '0',
				'bottom'    => '0',
				'unit'      => 'px'
			],
			'crel_steps__stepNum_startingSpace'                     => [
				'size' => 0,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_steps__stepNum_backgroundColor'                   => '#ffffff',
			'crel_steps__stepNum_borderRadius'                      => [
				'size' => 0,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_steps__stepNum_BorderType_border'                 => '',
			'crel_steps__stepNum_BorderType_width'                  => [
				'top' => '0',
				'left' => '0',
				'right' => '0',
				'bottom' => '2',
				'unit' => 'px',
				'isLinked' => false
			],
			'crel_steps__stepNum_BorderType_color'                  => '#000000',
			'crel_steps__stepNum_typography_typography'             => 'custom',
			'crel_steps__stepNum_typography_font_size'              => [
				'size' => 25,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_steps__stepNum_typography_font_weight'            => 'bold',
			'crel_steps__stepNum_typography_line_height'            => [
					'size' => '0.9',
					'unit' => 'em',
					'sizes' => []
			],


			// Title -----------------------------------/
			'crel_steps__title_backgroundColor'                     => '',
			'crel_steps__title_startingSpace'                       => [
				'size' => 5,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_steps__title_typography_typography'               => 'custom',
			'crel_steps__title_typography_font_size'                => [
					'size'  => 25,
					'unit'  => 'px',
					'sizes' => []
			],
			'crel_steps__title_typography_line_height'            => [
				'size' => '0.9',
				'unit' => 'em',
				'sizes' => []
			],


			// Anchor Link -------------------------------/
			'crel_steps__anchorLink_size'                             => [
				'size' => 20,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_steps__anchorLink_startingSpace'                    => [
				'size' => 12,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_steps__anchorLink_visibility' 		                => 'crel-steps--link-icon-show',

			// Body ------------------------------------/
			'crel_steps__body_paddingLeftRight'                     => [
				'size' => 20,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_steps__body_paddingTopBottom'                     => [
				'size' => 24,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_steps__body_backgroundColor'                      => '#FFFFFF',
			'crel_steps__body_borderRadius'                         => [
				'size' => 0,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_steps__body_borderType_border'                           => '',

			// Text Editor -----------------------------/
			'crel_steps__text_align'                                => 'left',
			

			// Image -----------------------------------/
			'crel_steps__image_borderType_border'                   => 'solid',
			'crel_steps__image_borderType_width'                    => [
				'top'       => '2',
				'left'      => '2',
				'right'     => '2',
				'bottom'    => '2',
				'unit' => 'px'
			],
			'crel_steps__image_borderRadius'                        => [
				'size' => 0,
				'unit' => 'px',
				'sizes' => []
			],

			'crel_steps__caption_backgroundColor'                   => '#FFFFFF',
			'crel_steps__caption_paddingLeftRight'                  => [
				'size' => 20,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_steps__caption_paddingTopBottom'                  => [
				'size' => 20,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_steps__caption_marginTop'                         => [
				'size' => 0,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_steps__caption_width'                             => [
				'size' => 50,
				'unit' => 'px',
				'sizes' => []
			],
			
			'crel_steps__prefix_color' => '#000000',
			'crel_steps__stepNum_color' => '#000000',
			'crel_steps__title_color' => '#000000',
			'crel_steps__anchorLink_color' => '#000000',
			'crel_steps__anchorLink_colorHover' => '',
			'crel_steps__text_textColor' => '#000000',
			'crel_steps__caption_color' => '#000000',
			
			'crel_steps__prefix_typography_typography'              => 'custom',
			'crel_steps__prefix_typography_font_size'               => [
					'size' => '25',
					'unit' => 'px',
					'sizes' => []
				],
			'crel_steps__prefix_typography_font_weight'             => 'bold',
			
			'crel_steps__title_typography_typography'              => 'custom',
			'crel_steps__title_typography_font_size'               => [
					'size' => '25',
					'unit' => 'px',
					'sizes' => []
				],
			'crel_steps__title_typography_font_weight'             => 'bold',
			
			'crel_steps__text_ButtonTypography_typography'              => 'custom',
			'crel_steps__text_ButtonTypography_font_size'               => [
					'size' => '14',
					'unit' => 'px',
					'sizes' => []
				],
			'crel_steps__text_ButtonTypography_font_weight'             => 'normal',
			'crel_steps__text_ButtonTypography_line_height'               => [
					'size' => '1.5',
					'unit' => 'em',
					'sizes' => []
				],
				
			'crel_steps__caption_typography_typography'              => 'custom',
			'crel_steps__caption_typography_font_size'               => [
					'size' => '16',
					'unit' => 'px',
					'sizes' => []
				],
		];
	}

	protected function get_config_rtl_defaults() {
		return [
			'crel_steps__headerMiddleDivider_marginLeft' => [
				'size' => 0,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_steps__headerMiddleDivider_marginRight' => [
				'size' => 10,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_steps__title_startingSpace' => [
				'size' => -5,
				'unit' => 'px',
				'sizes' => []
			],
		  'crel_steps__anchorLink_startingSpace' => [
			  'size' => -12,
			  'unit' => 'px',
			  'sizes' => []
		  ]
		];
	}

	protected function get_presets_defaults() {
		return [

		 // Other -------------------------------------------------------/
		 'crel_steps__layout_type'                              => 'layout-img-right',
		 'crel_steps__structure'                                => 'structure-50-50',
		 'crel_steps__image'                                    => [
				'url' => Utils::get_placeholder_image_src(),
			],
		 'crel_steps__caption_text'                             => '',
		 'crel_steps__open_lightbox'                            => 'yes',
		 'crel_steps__block_id'                                 => '',
		 'crel_steps__anchorLink_icon'                            => [
				'value' => 'fas fa-link',
				'library' => 'fa-solid',
			],

		 // Content Tab -------------------------------------------------/
		 'crel_steps__title_text'                               => __( 'New Step', 'creative-addons-for-elementor' ),
		 'crel_steps__list_type' 		                        => 'crel-steps--decimal',
		 'crel_steps__titlePrefix_text'                         => '',
		 'crel_steps__titleHTML_tag'                            => 'h3',
		 'crel_steps__desc_text'                                => __( 'Instructions text', 'creative-addons-for-elementor' ),

		 // Style Tab ---------------------------------------------------/

		 // General ---------------------------------/
		 'crel_steps__container_backgroundColor'                => '#FFFFFF',
		 'crel_steps__list_spacing'                             => [
				'size' => '50',
				'unit' => 'px',
				'sizes' => []
			],
		 'crel_steps__blocks_spacing'                           => [
				'size' => '14',
				'unit' => 'px',
				'sizes' => []
			],
		  // Header ----------------------------------/
		 'crel_steps__header_layout'                            => 'crel-step-header__inner--row',
		 'crel_steps__header_paddingLeftRight'                  => [
			  'size' => '10',
			  'unit' => 'px',
			  'sizes' => []
		  ],
		 'crel_steps__header_paddingTopBottom'                  => [
				'size' => '0',
				'unit' => 'px',
				'sizes' => []
			],
		 'crel_steps__header_marginBottom'                      => [
				'size'  => 20,
				'unit'  => 'px',
				'sizes' => []
			],
		 'crel_steps__header_backgroundColor'                   => '#FFFFFF',
		 'crel_steps__header_borderRadius'                      => [
				'top'       => '10',
				'left'      => '0',
				'right'     => '10',
				'bottom'    => '0',
				'unit'      => 'px'
		  ],
		 'crel_steps__header_BorderType'                        => 'solid',
		 'crel_steps__header_BorderType_width'                  => [
			  'top'       => '0',
			  'left'      => '0',
			  'right'     => '0',
			  'bottom'    => '2',
			  'unit'      => 'px',
			  'isLinked' => false
		  ],
		 'crel_steps__header_BorderType_color'                  => '#9d38a7',
		 'crel_steps__headerMiddleDivider__toggle'              => 'no',
		 'crel_steps__headerMiddleDivider_BorderType_border'    => '',
		 'crel_steps__headerMiddleDivider_BorderType_width'     => [
				'top' => '0',
				'left' => '0',
				'right' => '0',
				'bottom' => '2',
				'unit' => 'px',
				'isLinked' => false
			],
		 'crel_steps__headerMiddleDivider_BorderType_color'     => '#000000',
		 'crel_steps__headerMiddleDivider_marginLeft'           => [
				'size' => 10,
				'unit' => 'px',
				'sizes' => []
			],
		 'crel_steps__headerMiddleDivider_marginRight'          => [
				'size' => 0,
				'unit' => 'px',
				'sizes' => []
			],

		 // Prefix / Counter Container --------------/
		 'crel_steps__prefixCounterContainer_layout'             => 'crel-step-header__step--row',
		 'crel_steps__prefixCounterContainer_padding'            => [
				'top'       => '5',
				'left'      => '15',
				'right'     => '15',
				'bottom'    => '10',
				'unit'      => 'px'
			],
		 'crel_steps__prefixCounterContainer_borderRadius'       => [
				'top'       => '10',
				'left'      => '0',
				'right'     => '0',
				'bottom'    => '0',
				'unit'      => 'px',
				'isLinked' => false
			],
		 'crel_steps__prefixCounterContainer__backgroundColor'   => '#FFFFFF',
		 'crel_steps__prefixCounterContainer_BorderType_border'  => '',
		 'crel_steps__prefixCounterContainer_BorderType_width'   => [
				'top'       => '0',
				'left'      => '0',
				'right'     => '0',
				'bottom'    => '2',
				'unit'      => 'px'
			],
		 'crel_steps__prefixCounterContainer_BorderType_color'   => '#000000',

		 // Title Prefix ----------------------------/
		 'crel_steps__prefix_paddingLeftRight'                   => [
				'size' => '0',
				'unit' => 'px',
				'sizes' => []
			],
		 'crel_steps__prefix_paddingTopBottom'                   => [
				'size' => '0',
				'unit' => 'px',
				'sizes' => []
			],
		 'crel_steps__prefix_startingSpace'                      => [
				'size' => 0,
				'unit' => 'px',
				'sizes' => []
			],
		 'crel_steps__prefix_color'                              => '#FFFFFF',
		 'crel_steps__prefix_backgroundColor'                    => '#9d38a7',
		 'crel_steps__prefix_borderRadius'                       => [
				'size' => '0',
				'unit' => 'px',
				'sizes' => []
			],
		 'crel_steps__prefix_rotate'                             => [
				'unit' => 'deg',
				'sizes' => []
			],
		 'crel_steps__prefix_typography_typography'              => 'custom',
		 'crel_steps__prefix_typography_font_size'               => [
				'size' => '25',
				'unit' => 'px',
				'sizes' => []
			],
		 'crel_steps__prefix_typography_font_weight'             => 'bold',
		 'crel_steps__prefix_typography_text_transform'          => '',

		 // Counter ---------------------------------/
		 'crel_steps__stepNum_typography_typography'             => 'custom',
		 'crel_steps__stepNum_typography_font_size'              => [
				'size' => 25,
				'unit' => 'px',
				'sizes' => []
			],
		 'crel_steps__stepNum_typography_font_weight'            => 'bold',
		 'crel_steps__stepNum_typography_line_height'            => [
				'size' => '0.9',
				'unit' => 'em',
				'sizes' => []
			],
		 'crel_steps__stepNum_padding'                  => [
			 'top'       => '0',
			 'left'      => '0',
			 'right'     => '0',
			 'bottom'    => '0',
			 'unit'      => 'px'
		],
		 'crel_steps__stepNum_startingSpace'                     => [
			'size' => 0,
			'unit' => 'px',
			'sizes' => []
		],
		 'crel_steps__stepNum_color'                             => '#000000',
		 'crel_steps__stepNum_backgroundColor'                   => '#ffffff',
		 'crel_steps__stepNum_borderRadius'                      => [
			'size' => '0',
			'unit' => 'px',
			'sizes' => []
		],
		 'crel_steps__stepNum_BorderType_border'                 => '',
		 'crel_steps__stepNum_BorderType_width'                  => [
				'top' => '0',
				'left' => '0',
				'right' => '0',
				'bottom' => '2',
				'unit' => 'px',
				'isLinked' => false
			],
		 'crel_steps__stepNum_BorderType_color'                  => '#000000',

		 // Title -----------------------------------/
		 'crel_steps__title_typography_typography'               => 'custom',
		 'crel_steps__title_typography_font_size'                => [
				'size' => 25,
				'unit' => 'px',
				'sizes' => []
			],
		 'crel_steps__title_typography_font_weight'              => 'bold',
		 'crel_steps__title_typography_text_transform'           => '',
		 'crel_steps__title_color'                               => '#000000',
		 'crel_steps__title_backgroundColor'                     => '',
		 'crel_steps__title_startingSpace'                       => [
				'size' => 5,
				'unit' => 'px',
				'sizes' => []
			],

         // Anchor Link -------------------------------/
		 'crel_steps__anchorLink_size'                             => [
				'size' => 20,
				'unit' => 'px',
				'sizes' => []
			],
		 'crel_steps__anchorLink_startingSpace'                    => [
				'size' => 12,
				'unit' => 'px',
				'sizes' => []
			],
		 'crel_steps__anchorLink_visibility' 		                 => 'crel-steps--link-icon-show',
		 'crel_steps__anchorLink_color'                            => '#000000',

		 // Body ------------------------------------/
		 'crel_steps__body_paddingLeftRight'                     => [
				'size' => '20',
				'unit' => 'px',
				'sizes' => []
			],
		 'crel_steps__body_paddingTopBottom'                     => [
				'size' => '24',
				'unit' => 'px',
				'sizes' => []
			],
		 'crel_steps__body_backgroundColor'                      => '#FFFFFF',
		 'crel_steps__body_borderRadius'                         => [
				'size' => 0,
				'unit' => 'px',
				'sizes' => []
			],
		 'crel_steps__body_borderType_border'                           => '',

		 // Text Editor -----------------------------/
		 'crel_steps__text_align'                                => 'left',
		 'crel_steps__text_textColor'                            => '#000000',
		 'crel_steps__text_ButtonTypography_typography'          => 'custom',
		 'crel_steps__text_ButtonTypography_font_size'           => [
				'size' => '14',
				'unit' => 'px',
				'sizes' => []
			],
		 'crel_steps__text_ButtonTypography_font_weight'         => 'normal',
		 'crel_steps__text_ButtonTypography_line_height'         => [
				'size' => '1.5',
				'unit' => 'em',
				'sizes' => []
			],

		 // Image -----------------------------------/
		 'crel_steps__image_borderType_border'                  => 'solid',
		 'crel_steps__image_borderType_width'                   => [
				'top'       => '2',
				'left'      => '2',
				'right'     => '2',
				'bottom'    => '2',
				'unit' => 'px'
			],
		 'crel_steps__image_borderRadius'                        => [
				'size' => 0,
				'unit' => 'px',
				'sizes' => []
			],

		 'crel_steps__caption_color'                             => '#000000',
		 'crel_steps__caption_backgroundColor'                   => '#FFFFFF',
		 'crel_steps__caption_paddingLeftRight'                  => [
				'size' => 20,
				'unit' => 'px',
				'sizes' => []
			],
		 'crel_steps__caption_paddingTopBottom'                  => [
				'size' => 20,
				'unit' => 'px',
				'sizes' => []
			],
		 'crel_steps__caption_marginTop'                         => [
				'size' => 0,
				'unit' => 'px',
				'sizes' => []
			],
		 'crel_steps__caption_width'                             => [
				'size' => 50,
				'unit' => 'px',
				'sizes' => []
			],

		  'crel_steps__header_BorderType_border'                 => 'solid',
		];
	}

	protected function get_presets_rtl_defaults() {
		return [
		  'crel_steps__headerMiddleDivider_marginLeft' => [
			  'size' => 0,
			  'unit' => 'px',
			  'sizes' => []
		  ],
		  'crel_steps__headerMiddleDivider_marginRight' => [
			  'size' => 10,
			  'unit' => 'px',
			  'sizes' => []
		  ],
		  'crel_steps__title_startingSpace' => [
			  'size' => -5,
			  'unit' => 'px',
			  'sizes' => []
		  ],
		  'crel_steps__anchorLink_startingSpace' => [
			  'size' => -12,
			  'unit' => 'px',
			  'sizes' => []
		  ]
		];
	}

	/**
	 * Return presets for this widget
	 */
	public function get_presets_options() {

		$options = array();
		$brand_color = '#9d38a7';

		$options['default'] = array(
			'title' => __( 'Design 1', 'creative-addons-for-elementor' ),
			'preview_url' => $this->presets_preview_url( 'steps-design-1.jpg' ),
			'options' => array(
				'crel_steps__prefixCounterContainer_padding'            => [
					'top'       => '0',
					'left'      => '0',
					'right'     => '0',
					'bottom'    => '0',
					'unit'      => 'px'
				],
				'crel_steps__header_paddingTopBottom'                   => [
					'size' => '5',
					'unit' => 'px',
					'sizes' => []
				],
			)
		);


		// Design 2
		$options['design-2'] = array(
			'title' => __( 'Design 2', 'creative-addons-for-elementor' ),
			'preview_url' => $this->presets_preview_url( 'steps-design-2.jpg' ),
			'options' => array(

				// Header ----------------------------------/
				'crel_steps__header_paddingTopBottom'                   => [
					'size' => '5',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__header_BorderType_color'                   => '#CCCCCC',
				'crel_steps__headerMiddleDivider__toggle'               => 'yes',
				'crel_steps__headerMiddleDivider_BorderType_border'     => 'solid',
				'crel_steps__headerMiddleDivider_BorderType_width'      => [
					'top'       => '0',
					'left'      => '0',
					'right'     => '0',
					'bottom'    => '2',
					'unit'      => 'px'
				],
				'crel_steps__headerMiddleDivider_BorderType_color'      => '#CCCCCC',
				'crel_steps__header_BorderType_border'                  => '',

				// Prefix / Counter Container --------------/
				'crel_steps__prefixCounterContainer_padding'            => [
					'top'       => '0',
					'left'      => '0',
					'right'     => '0',
					'bottom'    => '0',
					'unit'      => 'px'
				],

				// Counter ---------------------------------/
				'crel_steps__stepNum_typography_font_size'              => [
					'size' => '28',
					'unit' => 'px',
					'sizes' => []
				],

			)
		);


		// Design 3
		$options['design-3'] = array(
			'title' => __( 'Design 3', 'creative-addons-for-elementor' ),
			'preview_url' => $this->presets_preview_url( 'steps-design-3.jpg' ),
			'options' => array(

				// Header ----------------------------------/
				'crel_steps__header_paddingLeftRight'                   => [
					'size' => 0,
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__header_BorderType'                         => 'solid',
				'crel_steps__header_BorderType_width'                   => [
					'top'       => '0',
					'left'      => '0',
					'right'     => '0',
					'bottom'    => '2',
					'unit'      => 'px'
				],

				// Prefix / Counter Container --------------/
				'crel_steps__prefixCounterContainer_borderRadius'       => [
					'top'       => is_rtl() ? '0' : '10',
					'left'      => '0',
					'right'     => is_rtl() ? '10' : '0',
					'bottom'    => '0',
					'unit'      => 'px'
				],
				'crel_steps__prefixCounterContainer__backgroundColor'   => $brand_color,

				// Counter ---------------------------------/
				'crel_steps__stepNum_color'                             => '#FFFFFF',
				'crel_steps__stepNum_backgroundColor'                   => $brand_color,

				// Title -----------------------------------/
				'crel_steps__title_startingSpace'                       => [
					'size' => '23',
					'unit' => 'px',
					'sizes' => []
				],
			)
		);

		// Design 4
		$options['design-4'] = array(
			'title' => __( 'Design 4', 'creative-addons-for-elementor' ),
			'preview_url' => $this->presets_preview_url( 'steps-design-4.jpg' ),
			'options' => array(

				// Header ----------------------------------/
				'crel_steps__header_paddingLeftRight'                   => [
					'size' => 0,
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__header_borderRadius'                       => [
					'top'       => '0',
					'left'      => '0',
					'right'     => '0',
					'bottom'    => '0',
					'unit'      => 'px'
				],
				'crel_steps__header_BorderType_border'                  => '',

				// Prefix / Counter Container --------------/
				'crel_steps__prefixCounterContainer_borderRadius'       => [
					'top'       => '10',
					'left'      => is_rtl() ? '10' : '0',
					'right'     => '10',
					'bottom'    => is_rtl() ? '0' : '10',
					'unit'      => 'px'
				],
				'crel_steps__prefixCounterContainer__backgroundColor'   => $brand_color,

				// Counter ---------------------------------/
				'crel_steps__stepNum_color'                             => '#FFFFFF',
				'crel_steps__stepNum_backgroundColor'                   => $brand_color,

				// Title -----------------------------------/
				'crel_steps__title_startingSpace'                       => [
					'size' => '23',
					'unit' => 'px',
					'sizes' => []
				],
			)
		);

		// Design 5
		$options['design-5'] = array(
			'title' => __( 'Design 5', 'creative-addons-for-elementor' ),
			'preview_url' => $this->presets_preview_url( 'steps-design-5.jpg' ),
			'options' => array(

				// General Section -------------------------/
				'crel_steps__blocks_spacing' => [
					'size' => 10,
					'unit' => 'px',
					'sizes' => []
				],

				// Header ----------------------------------/
				'crel_steps__header_paddingLeftRight'                   => [
					'size' => 0,
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__header_borderRadius'                       => [
					'top'       => '0',
					'left'      => '0',
					'right'     => '0',
					'bottom'    => '0',
					'unit'      => 'px'
				],
				'crel_steps__header_BorderType_border'                  => '',

				// Prefix / Counter Container --------------/
				'crel_steps__prefixCounterContainer_padding'            => [
					'top'       => '9',
					'left'      => '9',
					'right'     => '9',
					'bottom'    => '9',
					'unit'      => 'px'
				],
				'crel_steps__prefixCounterContainer_borderRadius'       => [
					'top'       => '40',
					'left'      => '40',
					'right'     => '40',
					'bottom'    => '40',
					'unit'      => 'px'
				],
				'crel_steps__prefixCounterContainer_BorderType_border'  => 'solid',
				'crel_steps__prefixCounterContainer_BorderType_color'   => '#277FC5',
				'crel_steps__prefixCounterContainer_BorderType_width'   => [
					'top' => '2',
					'left' => '2',
					'right' => '2',
					'bottom' => '2',
					'unit' => 'px',
					'isLinked' => false
				],

				// Title Prefix ----------------------------/
				'crel_steps__prefix_backgroundColor'                    => '#FFFFFF',

				// Counter ---------------------------------/
				'crel_steps__stepNum_padding'                  => [
					'top'       => '10',
					'left'      => '13',
					'right'     => '13',
					'bottom'    => '10',
					'unit'      => 'px'
				],
				'crel_steps__stepNum_BorderType_border'                 => 'solid',
				'crel_steps__stepNum_BorderType_width'                  => [
					'top'       => '4',
					'left'      => '4',
					'right'     => '4',
					'bottom'    => '4',
					'unit'      => 'px'
				],
				'crel_steps__stepNum_BorderType_color'                  => '#277FC5',
				'crel_steps__stepNum_borderRadius'                      => [
					'size' => '50',
					'unit' => 'px',
					'sizes' => []
				],

				// Title -----------------------------------/
				'crel_steps__title_startingSpace'                       => [
					'size' => '23',
					'unit' => 'px',
					'sizes' => []
				],

			)
		);

		// Design 6
		$options['design-6'] = array(
			'title' => __( 'Design 6', 'creative-addons-for-elementor' ),
			'preview_url' => $this->presets_preview_url( 'steps-design-6.jpg' ),
			'options' => array(

				// Header ----------------------------------/
				'crel_steps__header_paddingTopBottom'                   => [
					'size' => '10',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__header_paddingLeftRight'                   => [
					'size' => '20',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__header_backgroundColor'                    => '#E8E7E7',
				'crel_steps__header_borderRadius'                       => [
					'top' => '10',
					'left' => '10',
					'right' => '10',
					'bottom' => '10',
					'unit' => 'px'
				],
				'crel_steps__header_marginBottom'                       => [
					'size' => '10',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__header_BorderType_border'                  => '',

				// Prefix / Counter Container --------------/
				'crel_steps__prefixCounterContainer__backgroundColor'   => '#E8E7E7',
				'crel_steps__prefixCounterContainer_padding'            => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '0',
					'unit' => 'px'
				],

				// Counter ---------------------------------/
				'crel_steps__stepNum_backgroundColor'                   => '#E8E7E7',
				'crel_steps__stepNum_typography_font_size'              => [
					'size' => '24',
					'unit' => 'px',
					'sizes' => []
				],

			)
		);

		// Design 7
		$options['design-7'] = array(
			'title' => __( 'Design 7', 'creative-addons-for-elementor' ),
			'preview_url' => $this->presets_preview_url( 'steps-design-7.jpg' ),
			'options' => array(

				// Header ----------------------------------/
				'crel_steps__header_paddingTopBottom'                   => [
					'size' => '0',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__header_paddingLeftRight'                   => [
					'size' => '0',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__header_backgroundColor'                    => '#842A8D',
				'crel_steps__header_borderRadius'                       => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '0',
					'unit' => 'px'
				],
				'crel_steps__header_marginBottom'                       => [
					'size' => '0',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__header_BorderType_border'                  => '',

				// Prefix / Counter Container --------------/
				'crel_steps__titlePrefix_text'                          => __( 'STEP', 'creative-addons-for-elementor' ),
				'crel_steps__prefixCounterContainer__backgroundColor'   => '#E8E7E7',
				'crel_steps__prefixCounterContainer_padding'            => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '0',
					'unit' => 'px'
				],

				// Title Prefix ----------------------------/
				'crel_steps__prefix_paddingTopBottom'                   => [
					'size' => '12',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__prefix_paddingLeftRight'                   => [
					'size' => '11',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__prefix_typography_typography'              => 'custom',
				'crel_steps__prefix_typography_font_size'               => [
					'size' => '16',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__prefix_typography_line_height'   => [
					'size' => '1.5',
					'unit' => 'em',
					'sizes' => []
				],

				// Counter ---------------------------------/
				'crel_steps__stepNum_typography_typography'             => 'custom',
				'crel_steps__stepNum_typography_font_size'              => [
					'size' => 16,
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__stepNum_color'                             => '#FFFFFF',
				'crel_steps__stepNum_backgroundColor'                   => '#BB57C5',
				'crel_steps__stepNum_padding'                  => [
					'top'       => '17',
					'left'      => '11',
					'right'     => '11',
					'bottom'    => '17',
					'unit'      => 'px'
				],

				// Title -----------------------------------/
				'crel_steps__title_color'                               => '#FFFFFF',
				'crel_steps__title_startingSpace'                       => [
					'size' => '17',
					'unit' => 'px',
					'sizes' => []
				],

			)
		);

		// Design 8
		$options['design-8'] = array(
			'title' => __( 'Design 8', 'creative-addons-for-elementor' ),
			'preview_url' => $this->presets_preview_url( 'steps-design-8.jpg' ),
			'options' => array(

				// Header ----------------------------------/
				'crel_steps__header_paddingTopBottom'                   => [
					'size' => '15',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__header_paddingLeftRight'                   => [
					'size' => '15',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__header_backgroundColor'                    => '#842A8D',
				'crel_steps__header_borderRadius'                       => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '0',
					'unit' => 'px'
				],
				'crel_steps__header_marginBottom'                       => [
					'size' => '0',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__header_BorderType_color'                   => '#000000',
				'crel_steps__header_BorderType_width'                   => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '5',
					'unit' => 'px'
				],

				// Prefix / Counter Container --------------/
				'crel_steps__titlePrefix_text'                          => __( 'STEP', 'creative-addons-for-elementor' ),
				'crel_steps__prefixCounterContainer__backgroundColor'   => '#E8E7E7',
				'crel_steps__prefixCounterContainer_padding'            => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '0',
					'unit' => 'px'
				],

				// Title Prefix ----------------------------/
				'crel_steps__prefix_paddingTopBottom'                   => [
					'size' => '10',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__prefix_paddingLeftRight'                   => [
					'size' => '11',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__prefix_typography_typography'              => 'custom',
				'crel_steps__prefix_typography_font_size'               => [
					'size' => '16',
					'unit' => 'px',
					'sizes' => []
				],

				'crel_steps__prefix_typography_line_height'   => [
					'size' => '1.5',
					'unit' => 'em',
					'sizes' => []
				],

				// Counter ---------------------------------/
				'crel_steps__stepNum_typography_typography'             => 'custom',
				'crel_steps__stepNum_typography_font_size'              => [
					'size' => 16,
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__stepNum_color'                             => '#FFFFFF',
				'crel_steps__stepNum_backgroundColor'                   => '#BB57C5',
				'crel_steps__stepNum_padding'                  => [
					'top'       => '15',
					'left'      => '11',
					'right'     => '11',
					'bottom'    => '15',
					'unit'      => 'px'
				],

				// Title -----------------------------------/
				'crel_steps__title_color'                               => '#FFFFFF',
				'crel_steps__title_startingSpace'                       => [
					'size' => '17',
					'unit' => 'px',
					'sizes' => []
				],

			)
		);

		// Design 9
		$options['design-9'] = array(
			'title' => __( 'Design 9', 'creative-addons-for-elementor' ),
			'preview_url' => $this->presets_preview_url( 'steps-design-9.jpg' ),
			'options' => array(

				// Header ----------------------------------/
				'crel_steps__header_paddingTopBottom'                   => [
					'size' => '8',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__header_paddingLeftRight'                   => [
					'size' => '15',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__header_backgroundColor'                    => '#842A8D',
				'crel_steps__header_borderRadius'                       => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '0',
					'unit' => 'px'
				],
				'crel_steps__header_marginBottom'                       => [
					'size' => '0',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__header_BorderType_color'                   => '#000000',
				'crel_steps__header_BorderType_width'                   => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '5',
					'unit' => 'px'
				],

				// Prefix / Counter Container --------------/
				'crel_steps__prefixCounterContainer_layout'             => 'crel-step-header__step--col',
				'crel_steps__titlePrefix_text'                          => __( 'STEP', 'creative-addons-for-elementor' ),
				'crel_steps__prefixCounterContainer__backgroundColor'   => '#FFFFFF',
				'crel_steps__prefixCounterContainer_padding'            => [
					'top'       => '8',
					'left'      => '6',
					'right'     => '6',
					'bottom'    => '8',
					'unit' => 'px'
				],
				'crel_steps__prefixCounterContainer_borderRadius'       => [
					'top'       => '18',
					'left'      => '18',
					'right'     => '18',
					'bottom'    => '18',
					'unit' => 'px'
				],
				'crel_steps__prefixCounterContainer_BorderType_border'  => 'solid',
				'crel_steps__prefixCounterContainer_BorderType_width'   => [
					'top'       => '0',
					'left'      => '0',
					'right'     => '0',
					'bottom'    => '4',
					'unit' => 'px'
				],
				'crel_steps__prefixCounterContainer_BorderType_color'   => '#000000',

				// Title Prefix ----------------------------/
				'crel_steps__prefix_paddingTopBottom'                   => [
					'size' => '0',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__prefix_paddingLeftRight'                   => [
					'size' => '0',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__prefix_color'                              => '#000000',
				'crel_steps__prefix_backgroundColor'                    => '#FFFFFF',
				'crel_steps__prefix_typography_typography'              => 'custom',
				'crel_steps__prefix_typography_font_size'               => [
					'size' => '16',
					'unit' => 'px',
					'sizes' => []
				],

				// Counter ---------------------------------/
				'crel_steps__stepNum_typography_typography'             => 'custom',
				'crel_steps__stepNum_typography_font_size'              => [
					'size' => 24,
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__stepNum_color'                             => '#000000',
				'crel_steps__stepNum_backgroundColor'                   => '#FFFFFF',
				'crel_steps__stepNum_padding'                  => [
					'top'       => '0',
					'left'      => '0',
					'right'     => '0',
					'bottom'    => '0',
					'unit'      => 'px'
				],

				// Title -----------------------------------/
				'crel_steps__title_color'                               => '#FFFFFF',
				'crel_steps__title_startingSpace'                       => [
					'size' => '17',
					'unit' => 'px',
					'sizes' => []
				],
			)
		);

		// Design 10
		$options['design-10'] = array(
			'title' => __( 'Design 10', 'creative-addons-for-elementor' ),
			'preview_url' => $this->presets_preview_url( 'steps-design-10.jpg' ),
			'options' => array(

				// Header ----------------------------------/
				'crel_steps__header_paddingTopBottom'                   => [
					'size' => '15',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__header_paddingLeftRight'                   => [
					'size' => '15',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__header_backgroundColor'                    => '#842A8D',
				'crel_steps__header_borderRadius'                       => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '0',
					'unit' => 'px'
				],
				'crel_steps__header_marginBottom'                       => [
					'size' => '0',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__header_BorderType_color'                   => '#DDB1FF',
				'crel_steps__header_BorderType_width'                   => [
					'top' => '5',
					'left' => '5',
					'right' => '5',
					'bottom' => '5',
					'unit' => 'px'
				],

				// Prefix / Counter Container --------------/
				'crel_steps__prefixCounterContainer_layout'             => 'crel-step-header__step--col',
				'crel_steps__titlePrefix_text'                          => __( 'STEP', 'creative-addons-for-elementor' ),
				'crel_steps__prefixCounterContainer__backgroundColor'   => '#FFFFFF',
				'crel_steps__prefixCounterContainer_padding'            => [
					'top'       => '8',
					'left'      => '15',
					'right'     => '15',
					'bottom'    => '8',
					'unit' => 'px'
				],
				'crel_steps__prefixCounterContainer_borderRadius'       => [
					'top'       => '18',
					'left'      => '18',
					'right'     => '18',
					'bottom'    => '18',
					'unit' => 'px'
				],
				'crel_steps__prefixCounterContainer_BorderType_border'  => 'solid',
				'crel_steps__prefixCounterContainer_BorderType_width'   => [
					'top'       => '4',
					'left'      => '4',
					'right'     => '4',
					'bottom'    => '4',
					'unit' => 'px'
				],
				'crel_steps__prefixCounterContainer_BorderType_color'   => '#D58CED',

				// Title Prefix ----------------------------/
				'crel_steps__prefix_typography_typography'              => 'custom',
				'crel_steps__prefix_typography_font_size'               => [
					'size' => '16',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__prefix_paddingTopBottom'                   => [
					'size' => '0',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__prefix_paddingLeftRight'                   => [
					'size' => '0',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__prefix_color'                              => '#000000',
				'crel_steps__prefix_backgroundColor'                    => '#FFFFFF',

				// Counter ---------------------------------/
				'crel_steps__stepNum_typography_typography'             => 'custom',
				'crel_steps__stepNum_typography_font_size'              => [
					'size' => 24,
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__stepNum_color'                             => '#000000',
				'crel_steps__stepNum_backgroundColor'                   => '#FFFFFF',
				'crel_steps__stepNum_padding'                  => [
					'top'       => '0',
					'left'      => '0',
					'right'     => '0',
					'bottom'    => '0',
					'unit'      => 'px'
				],

				// Title -----------------------------------/
				'crel_steps__title_color'                               => '#FFFFFF',
				'crel_steps__title_startingSpace'                       => [
					'size' => '17',
					'unit' => 'px',
					'sizes' => []
				],

			)
		);

		// Design 11
		$options['design-11'] = array(
			'title' => __( 'Design 11', 'creative-addons-for-elementor' ),
			'preview_url' => $this->presets_preview_url( 'steps-design-11.jpg' ),
			'options' => array(

				// Header ----------------------------------/
				'crel_steps__header_paddingTopBottom'                   => [
					'size' => '10',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__header_paddingLeftRight'                   => [
					'size' => '15',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__header_backgroundColor'                    => '#842A8D',
				'crel_steps__header_borderRadius'                       => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '0',
					'unit' => 'px'
				],
				'crel_steps__header_marginBottom'                       => [
					'size' => '0',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__header_BorderType_color'                   => '#DDB1FF',
				'crel_steps__header_BorderType_width'                   => [
					'top' => '3',
					'left' => '3',
					'right' => '3',
					'bottom' => '3',
					'unit' => 'px'
				],

				// Prefix / Counter Container --------------/
				'crel_steps__prefixCounterContainer_layout'             => 'crel-step-header__step--row',
				'crel_steps__titlePrefix_text'                          => __( 'STEP', 'creative-addons-for-elementor' ),
				'crel_steps__prefixCounterContainer__backgroundColor'   => '#FFFFFF',
				'crel_steps__prefixCounterContainer_padding'            => [
					'top'       => '8',
					'left'      => '15',
					'right'     => '15',
					'bottom'    => '8',
					'unit' => 'px'
				],
				'crel_steps__prefixCounterContainer_borderRadius'       => [
					'top'       => '18',
					'left'      => '18',
					'right'     => '18',
					'bottom'    => '18',
					'unit' => 'px'
				],
				'crel_steps__prefixCounterContainer_BorderType_border'  => 'solid',
				'crel_steps__prefixCounterContainer_BorderType_width'   => [
					'top'       => '4',
					'left'      => '4',
					'right'     => '4',
					'bottom'    => '4',
					'unit' => 'px'
				],
				'crel_steps__prefixCounterContainer_BorderType_color'   => '#D58CED',

				// Title Prefix ----------------------------/
				'crel_steps__prefix_typography_typography'              => 'custom',
				'crel_steps__prefix_typography_font_size'               => [
					'size' => '16',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__prefix_paddingTopBottom'                   => [
					'size' => '0',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__prefix_paddingLeftRight'                   => [
					'size' => '0',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__prefix_color'                              => '#000000',
				'crel_steps__prefix_backgroundColor'                    => '#FFFFFF',

				// Counter ---------------------------------/
				'crel_steps__stepNum_typography_typography'             => 'custom',
				'crel_steps__stepNum_typography_font_size'              => [
					'size' => 24,
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__stepNum_color'                             => '#000000',
				'crel_steps__stepNum_backgroundColor'                   => '#FFFFFF',
				'crel_steps__stepNum_padding'                  => [
					'top'       => '4',
					'left'      => '6',
					'right'     => '6',
					'bottom'    => '4',
					'unit'      => 'px'
				],

				// Title -----------------------------------/
				'crel_steps__title_color'                               => '#FFFFFF',
				'crel_steps__title_startingSpace'                       => [
					'size' => '17',
					'unit' => 'px',
					'sizes' => []
				],

			)
		);

		// Design 12
		$options['design-12'] = array(
			'title' => __( 'Design 12', 'creative-addons-for-elementor' ),
			'preview_url' => $this->presets_preview_url( 'steps-design-12.jpg' ),
			'options' => array(


				// Header  ------------------------/
				'crel_steps__header_paddingTopBottom'                   => [
					'size' => '0',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__header_paddingLeftRight'                   => [
					'size' => '0',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__header_backgroundColor'                    => '#f7f7f7',
				'crel_steps__header_borderRadius'                       => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '0',
					'unit' => 'px'
				],
				'crel_steps__header_marginBottom'                       => [
					'size' => '0',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__header_BorderType_color'                   => '#842A8D',
				'crel_steps__header_BorderType_width'                   => [
					'top' => '3',
					'left' => '3',
					'right' => '3',
					'bottom' => '0',
					'unit' => 'px'
				],

				// Prefix / Counter Container -----/
				'crel_steps__prefixCounterContainer_layout'             => 'crel-step-header__step--row',
				'crel_steps__titlePrefix_text'                          => __( 'STEP', 'creative-addons-for-elementor' ),
				'crel_steps__prefixCounterContainer__backgroundColor'   => '#f7f7f7',
				'crel_steps__prefixCounterContainer_padding'            => [
					'top'       => '0',
					'left'      => '0',
					'right'     => '0',
					'bottom'    => '20',
					'unit' => 'px'
				],
				'crel_steps__prefixCounterContainer_borderRadius'       => [
					'top'       => '0',
					'left'      => '0',
					'right'     => '0',
					'bottom'    => '0',
					'unit' => 'px'
				],
				'crel_steps__prefixCounterContainer_BorderType_border'  => '',
				'crel_steps__prefixCounterContainer_BorderType_width'   => [
					'top'       => '4',
					'left'      => '4',
					'right'     => '4',
					'bottom'    => '4',
					'unit' => 'px'
				],
				'crel_steps__prefixCounterContainer_BorderType_color'   => '#D58CED',

				// Title Prefix -------------------/
				'crel_steps__prefix_typography_font_size'               => [
					'size' => '18',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__prefix_paddingTopBottom'                   => [
					'size' => '10',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__prefix_paddingLeftRight'                   => [
					'size' => '10',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__prefix_color'                              => '#FFFFFF',
				'crel_steps__prefix_backgroundColor'                    => '#842A8D',

				// Counter ------------------------/
				'crel_steps__stepNum_color'                             => '#FFFFFF',
				'crel_steps__stepNum_backgroundColor'                   => '#842A8D',
				'crel_steps__stepNum_typography_font_size'              => [
					'size' => '30',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__stepNum_padding'                  => [
					'top'       => '10',
					'left'      => '11',
					'right'     => '11',
					'bottom'    => '10',
					'unit'      => 'px'
				],

				// Title --------------------------/
				'crel_steps__title_typography_font_size'                => [
					'size' => '25',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__title_color'                               => '#282828',
				'crel_steps__title_startingSpace'                       => [
					'size' => '17',
					'unit' => 'px',
					'sizes' => []
				],

				// Anchor Link ----------------------/

				// Body ---------------------------/
				'crel_steps__body_paddingLeftRight'                     => [
					'size' => '15',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__body_paddingTopBottom'                     => [
					'size' => '24',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__body_borderType_border'                           => 'solid',
				'crel_steps__body_borderType_width'                     => [
					'top'       => '0',
					'left'      => '3',
					'right'     => '3',
					'bottom'    => '3',
					'unit' => 'px'
				],
				'crel_steps__body_borderType_color'                     => '#842A8D',


				// Text Editor --------------------/

				// Image --------------------------/
			)
		);

		// Design 13 ( Commented out for now, maybe look into this in the future. Issue is if numbers are large they push the content.
		/*$options['design-13'] = array(
			'title' => 'Design 13', 'creative-addons-for-elementor',
			'preview_url' => $this->preview_url( 'steps-design-13.jpg' ),
			'options' => array(

				'crel_steps__titlePrefix_text'                          => __( 'STEP', 'creative-addons-for-elementor' ),

				// Style Tab ---------------------------------------------------/

				// General  -----------------------/

				// Header  ------------------------/
				'crel_steps__header_paddingTopBottom'                   => [
					'size' => '0',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__header_paddingLeftRight'                   => [
					'size' => '0',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__header_backgroundColor'                    => '#f7f7f7',
				'crel_steps__header_borderRadius'                       => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '0',
					'unit' => 'px'
				],
				'crel_steps__header_marginBottom'                       => [
					'size' => '0',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__header_BorderType_color'                   => '#842A8D',
				'crel_steps__header_BorderType_width'                   => [
					'top' => '3',
					'left' => '3',
					'right' => '3',
					'bottom' => '0',
					'unit' => 'px'
				],

				// Prefix / Counter Container -----/
				'crel_steps__prefixCounterContainer_layout'             => 'crel-step-header__step--row',
				'crel_steps__prefixCounterContainer__backgroundColor'   => '#f7f7f7',
				'crel_steps__prefixCounterContainer_padding'            => [
					'top'       => '0',
					'left'      => '0',
					'right'     => '0',
					'bottom'    => '0',
					'unit' => 'px'
				],
				'crel_steps__prefixCounterContainer_borderRadius'       => [
					'top'       => '0',
					'left'      => '0',
					'right'     => '0',
					'bottom'    => '0',
					'unit' => 'px'
				],
				'crel_steps__prefixCounterContainer_BorderType_border'  => '',
				'crel_steps__prefixCounterContainer_BorderType_width'   => [
					'top'       => '4',
					'left'      => '4',
					'right'     => '4',
					'bottom'    => '4',
					'unit' => 'px'
				],
				'crel_steps__prefixCounterContainer_BorderType_color'   => '#D58CED',

				// Title Prefix -------------------/
				'crel_steps__prefix_typography_font_size'               => [
					'size' => '18',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__prefix_paddingTopBottom'                   => [
					'size' => '10',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__prefix_paddingLeftRight'                   => [
					'size' => '10',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__prefix_color'                              => '#FFFFFF',
				'crel_steps__prefix_backgroundColor'                    => '#842A8D',
				'crel_steps__prefix_startingSpace'                      => [
					'size' => '-103',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__prefix_startingSpace_mobile'               => [
					'size' => '-2',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__prefix_startingSpace_tablet'               => [
					'size' => '-2',
					'unit' => 'px',
					'sizes' => []
				],

				// Counter ------------------------/
				'crel_steps__stepNum_color'                             => '#FFFFFF',
				'crel_steps__stepNum_backgroundColor'                   => '#842A8D',
				'crel_steps__stepNum_typography_font_size'              => [
					'size' => '30',
					'unit' => 'px',
					'sizes' => []
				],

				'crel_steps__stepNum_padding'                  => [
					'top'       => '0',
				'left'      => '0',
				'right'     => '0',
				'bottom'    => '0',
				'unit'      => 'px'
				],

				// Title --------------------------/
				'crel_steps__title_typography_font_size'                => [
					'size' => '25',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__title_color'                               => '#282828',
				'crel_steps__title_startingSpace'                       => [
					'size' => '17',
					'unit' => 'px',
					'sizes' => []
				],

				// Anchor Link ----------------------/

				// Body ---------------------------/
				'crel_steps__body_paddingLeftRight'                     => [
					'size' => '15',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__body_paddingTopBottom'                     => [
					'size' => '24',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__body_borderType_border'                           => 'solid',
				'crel_steps__body_borderType_width'                     => [
					'top'       => '0',
					'left'      => '3',
					'right'     => '3',
					'bottom'    => '3',
					'unit' => 'px'
				],
				'crel_steps__body_borderType_color'               => '#842A8D',


				// Text Editor --------------------/

				// Image --------------------------/
			)
		);*/

		// Design 14
		$options['design-14'] = array(
			'title' => __( 'Design 13', 'creative-addons-for-elementor' ),
			'preview_url' => $this->presets_preview_url( 'steps-design-14.jpg' ),
			'options' => array(

				// Style Tab ---------------------------------------------------/

				// General  -----------------------/

				// Header  ------------------------/
				'crel_steps__header_layout'                            => 'crel-step-header__inner--col',
				'crel_steps__header_paddingTopBottom'                   => [
					'size' => '5',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__header_paddingLeftRight'                   => [
					'size' => '0',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__header_backgroundColor'                    => '#f7f7f7',
				'crel_steps__header_borderRadius'                       => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '0',
					'unit' => 'px'
				],
				'crel_steps__header_marginBottom'                       => [
					'size' => '0',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__header_BorderType_border'                  => 'solid',
				'crel_steps__header_BorderType_color'                   => '#000000',
				'crel_steps__header_BorderType_width'                   => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '3',
					'unit' => 'px'
				],

				// Prefix / Counter Container -----/
				'crel_steps__prefixCounterContainer_layout'             => 'crel-step-header__step--row',
				'crel_steps__titlePrefix_text'                          => __( 'STEP', 'creative-addons-for-elementor' ),
				'crel_steps__prefixCounterContainer__backgroundColor'   => '#f7f7f7',
				'crel_steps__prefixCounterContainer_padding'            => [
					'top'       => '0',
					'left'      => '0',
					'right'     => '0',
					'bottom'    => '0',
					'unit' => 'px'
				],
				'crel_steps__prefixCounterContainer_borderRadius'       => [
					'top'       => '0',
					'left'      => '0',
					'right'     => '0',
					'bottom'    => '0',
					'unit' => 'px'
				],
				'crel_steps__prefixCounterContainer_BorderType_border'  => '',
				'crel_steps__prefixCounterContainer_BorderType_width'   => [
					'top'       => '4',
					'left'      => '4',
					'right'     => '4',
					'bottom'    => '4',
					'unit' => 'px'
				],
				'crel_steps__prefixCounterContainer_BorderType_color'   => '#D58CED',

				// Title Prefix -------------------/
				'crel_steps__prefix_typography_font_size'               => [
					'size' => '18',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__prefix_paddingTopBottom'                   => [
					'size' => '0',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__prefix_paddingLeftRight'                   => [
					'size' => '10',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__prefix_color'                              => '#282828',
				'crel_steps__prefix_backgroundColor'                    => '#f7f7f7',

				// Counter ------------------------/
				'crel_steps__stepNum_color'                             => '#282828',
				'crel_steps__stepNum_backgroundColor'                   => '#f7f7f7',
				'crel_steps__stepNum_typography_font_size'              => [
					'size' => '23',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__stepNum_padding'                  => [
					'top'       => '0',
					'left'      => '0',
					'right'     => '0',
					'bottom'    => '0',
					'unit'      => 'px'
				],

				// Title --------------------------/
				'crel_steps__title_typography_font_size'                => [
					'size' => '25',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__title_color'                               => '#282828',
				'crel_steps__title_startingSpace'                       => [
					'size' => '10',
					'unit' => 'px',
					'sizes' => []
				],

				// Anchor Link ----------------------/

				// Body ---------------------------/
				'crel_steps__body_paddingLeftRight'                     => [
					'size' => '15',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__body_paddingTopBottom'                     => [
					'size' => '24',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__body_borderType_border'                           => '',
				'crel_steps__body_borderType_width'                     => [
					'top'       => '0',
					'left'      => '7',
					'right'     => '7',
					'bottom'    => '7',
					'unit' => 'px'
				],
				'crel_steps__body_borderType_color'               => '#842A8D',


				// Text Editor --------------------/

				// Image --------------------------/
				'crel_steps__image_borderType_border'             => 'solid',
				'crel_steps__image_borderType_width'              => [
					'top'       => '3',
					'left'      => '3',
					'right'     => '3',
					'bottom'    => '3',
					'unit' => 'px'
				],
			)
		);

		// Design 15
		$options['design-15'] = array(
			'title' => __( 'Design 14', 'creative-addons-for-elementor' ),
			'preview_url' => $this->presets_preview_url( 'steps-design-15.jpg' ),
			'options' => array(

				// Style Tab ---------------------------------------------------/

				// General  -----------------------/

				// Header  ------------------------/
				'crel_steps__header_layout'                             => 'crel-step-header__inner--col',
				'crel_steps__header_paddingTopBottom'                   => [
					'size' => '5',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__header_paddingLeftRight'                   => [
					'size' => '0',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__header_backgroundColor'                    => '#f7f7f7',
				'crel_steps__header_borderRadius'                       => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '0',
					'unit' => 'px'
				],
				'crel_steps__header_marginBottom'                       => [
					'size' => '10',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__header_BorderType_border'                  => 'groove',
				'crel_steps__header_BorderType_color'                   => '#C807DC',
				'crel_steps__header_BorderType_width'                   => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '10',
					'unit' => 'px'
				],

				// Prefix / Counter Container -----/
				'crel_steps__prefixCounterContainer_layout'             => 'crel-step-header__step--row',
				'crel_steps__titlePrefix_text'                          => __( 'STEP', 'creative-addons-for-elementor' ),
				'crel_steps__prefixCounterContainer__backgroundColor'   => '#f7f7f7',
				'crel_steps__prefixCounterContainer_padding'            => [
					'top'       => '0',
					'left'      => '0',
					'right'     => '0',
					'bottom'    => '0',
					'unit' => 'px'
				],
				'crel_steps__prefixCounterContainer_borderRadius'       => [
					'top'       => '0',
					'left'      => '0',
					'right'     => '0',
					'bottom'    => '0',
					'unit' => 'px'
				],
				'crel_steps__prefixCounterContainer_BorderType_border'  => '',
				'crel_steps__prefixCounterContainer_BorderType_width'   => [
					'top'       => '4',
					'left'      => '4',
					'right'     => '4',
					'bottom'    => '4',
					'unit' => 'px'
				],
				'crel_steps__prefixCounterContainer_BorderType_color'   => '#D58CED',

				// Title Prefix -------------------/
				'crel_steps__prefix_typography_font_size'               => [
					'size' => '18',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__prefix_paddingTopBottom'                   => [
					'size' => '0',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__prefix_paddingLeftRight'                   => [
					'size' => '10',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__prefix_color'                              => '#282828',
				'crel_steps__prefix_backgroundColor'                    => '#f7f7f7',

				// Counter ------------------------/
				'crel_steps__stepNum_color'                             => '#282828',
				'crel_steps__stepNum_backgroundColor'                   => '#f7f7f7',
				'crel_steps__stepNum_typography_font_size'              => [
					'size' => '23',
					'unit' => 'px',
					'sizes' => []
				],

				'crel_steps__stepNum_padding'                  => [
					'top'       => '0',
					'left'      => '0',
					'right'     => '0',
					'bottom'    => '0',
					'unit'      => 'px'
				],

				// Title --------------------------/
				'crel_steps__title_typography_font_size'                => [
					'size' => '25',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__title_color'                               => '#282828',
				'crel_steps__title_startingSpace'                       => [
					'size' => '10',
					'unit' => 'px',
					'sizes' => []
				],

				// Anchor Link ----------------------/

				// Body ---------------------------/
				'crel_steps__body_paddingLeftRight'                     => [
					'size' => '15',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__body_paddingTopBottom'                     => [
					'size' => '24',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__body_borderType_border'                           => '',
				'crel_steps__body_borderType_width'                     => [
					'top'       => '0',
					'left'      => '7',
					'right'     => '7',
					'bottom'    => '7',
					'unit' => 'px'
				],
				'crel_steps__body_borderType_color'                     => '#842A8D',


				// Text Editor --------------------/

				// Image --------------------------/
				'crel_steps__image_borderType_border'                   => 'solid',
				'crel_steps__image_borderType_width'                    => [
					'top'       => '3',
					'left'      => '3',
					'right'     => '3',
					'bottom'    => '3',
					'unit' => 'px'
				],
			)
		);

		// Design 16
		$options['design-16'] = array(
			'title' => __( 'Design 15', 'creative-addons-for-elementor' ),
			'preview_url' => $this->presets_preview_url( 'steps-design-16.jpg' ),
			'options' => array(

				// Style Tab ---------------------------------------------------/

				// General  -----------------------/

				// Header  ------------------------/
				'crel_steps__header_paddingTopBottom'                   => [
					'size' => '6',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__header_paddingLeftRight'                   => [
					'size' => '15',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__header_backgroundColor'                    => '#f7f7f7',
				'crel_steps__header_BorderType_border'                  => '',
				'crel_steps__header_borderRadius'                       => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '0',
					'unit' => 'px'
				],
				'crel_steps__header_marginBottom'                       => [
					'size' => '0',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__header_BorderType_color'                   => '#DDB1FF',
				'crel_steps__header_BorderType_width'                   => [
					'top' => '7',
					'left' => '7',
					'right' => '7',
					'bottom' => '7',
					'unit' => 'px'
				],

				// Prefix / Counter Container -----/
				'crel_steps__prefixCounterContainer_layout'             => 'crel-step-header__step--col',
				'crel_steps__titlePrefix_text'                          => __( 'STEP', 'creative-addons-for-elementor' ),
				'crel_steps__prefixCounterContainer__backgroundColor'   => '#C258F0',
				'crel_steps__prefixCounterContainer_padding'            => [
					'top'       => '8',
					'left'      => '13',
					'right'     => '13',
					'bottom'    => '8',
					'unit' => 'px'
				],
				'crel_steps__prefixCounterContainer_borderRadius'       => [
					'top'       => '50',
					'left'      => '50',
					'right'     => '50',
					'bottom'    => '50',
					'unit' => 'px'
				],
				'crel_steps__prefixCounterContainer_BorderType_border'  => 'solid',
				'crel_steps__prefixCounterContainer_BorderType_width'   => [
					'top'       => '4',
					'left'      => '4',
					'right'     => '4',
					'bottom'    => '4',
					'unit' => 'px'
				],
				'crel_steps__prefixCounterContainer_BorderType_color'   => '#D68FED',

				// Title Prefix -------------------/
				'crel_steps__prefix_paddingTopBottom'                   => [
					'size' => '0',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__prefix_paddingLeftRight'                   => [
					'size' => '0',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__prefix_color'                              => '#FFFFFF',
				'crel_steps__prefix_backgroundColor'                    => '#C258F0',
				'crel_steps__prefix_typography_font_size'               =>  [
					'size' => '16',
					'unit' => 'px',
					'sizes' => []
				],

				// Counter ------------------------/
				'crel_steps__stepNum_color'                             => '#FFFFFF',
				'crel_steps__stepNum_backgroundColor'                   => '#C258F0',
				'crel_steps__stepNum_typography_font_size'              => [
					'size' => '24',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__stepNum_padding'                  => [
					'top'       => '0',
					'left'      => '0',
					'right'     => '0',
					'bottom'    => '0',
					'unit'      => 'px'
				],

				// Title --------------------------/
				'crel_steps__title_color'                               => '#282828',
				'crel_steps__title_startingSpace'                       => [
					'size' => '17',
					'unit' => 'px',
					'sizes' => []
				],

				// Anchor Link ----------------------/

				// Body ---------------------------/

				// Text Editor --------------------/

				// Image --------------------------/
			)
		);

		// Design 17
		$options['design-17'] = array(
			'title' => __( 'Design 16', 'creative-addons-for-elementor' ),
			'preview_url' => $this->presets_preview_url( 'steps-design-17.jpg' ),
			'options' => array(


				// Header  ------------------------/
				'crel_steps__header_paddingTopBottom'                   => [
					'size' => '6',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__header_paddingLeftRight'                   => [
					'size' => '15',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__header_backgroundColor'                    => '#FCE1FC',
				'crel_steps__header_BorderType_border'                  => 'groove',
				'crel_steps__header_borderRadius'                       => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '0',
					'unit' => 'px'
				],
				'crel_steps__header_marginBottom'                       => [
					'size' => '0',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__header_BorderType_color'                   => '#EB72F8',
				'crel_steps__header_BorderType_width'                   => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '7',
					'unit' => 'px'
				],

				// Prefix / Counter Container -----/
				'crel_steps__prefixCounterContainer_layout'             => 'crel-step-header__step--row',
				'crel_steps__titlePrefix_text'                          => __( 'STEP', 'creative-addons-for-elementor' ),
				'crel_steps__prefixCounterContainer__backgroundColor'   => '#C258F0',
				'crel_steps__prefixCounterContainer_padding'            => [
					'top'       => '3',
					'left'      => '15',
					'right'     => '6',
					'bottom'    => '5',
					'unit' => 'px'
				],
				'crel_steps__prefixCounterContainer_borderRadius'       => [
					'top'       => '50',
					'left'      => '50',
					'right'     => '50',
					'bottom'    => '50',
					'unit' => 'px'
				],
				'crel_steps__prefixCounterContainer_BorderType_border'  => 'solid',
				'crel_steps__prefixCounterContainer_BorderType_width'   => [
					'top'       => '4',
					'left'      => '4',
					'right'     => '4',
					'bottom'    => '4',
					'unit' => 'px'
				],
				'crel_steps__prefixCounterContainer_BorderType_color'   => '#D68FED',

				// Title Prefix -------------------/
				'crel_steps__prefix_paddingTopBottom'                   => [
					'size' => '0',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__prefix_paddingLeftRight'                   => [
					'size' => '0',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__prefix_color'                              => '#FFFFFF',
				'crel_steps__prefix_backgroundColor'                    => '#C258F0',

				// Counter ------------------------/
				'crel_steps__stepNum_color'                             => '#FFFFFF',
				'crel_steps__stepNum_backgroundColor'                   => '#C258F0',
				'crel_steps__stepNum_typography_font_size'              => [
					'size' => '19',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__stepNum_padding'                  => [
					'top'       => '5',
					'left'      => '8',
					'right'     => '8',
					'bottom'    => '5',
					'unit'      => 'px'
				],
				'crel_steps__stepNum_startingSpace'                     => [
					'size' => '13',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__stepNum_borderRadius'                      => [
					'size' => '126',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__stepNum_BorderType_border'                 => 'dotted',
				'crel_steps__stepNum_BorderType_color'                  => '#FFFFFF',
				'crel_steps__stepNum_BorderType_width'                  => [
					'top'       => '2',
					'left'      => '2',
					'right'     => '2',
					'bottom'    => '2',
					'unit' => 'px'
				],

				// Title --------------------------/
				'crel_steps__title_color'                               => '#C258F0',
				'crel_steps__title_startingSpace'                       => [
					'size' => '17',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__title_typography_font_size_mobile' => [
					'size' => '16',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__title_typography_font_size_tablet' => [
					'size' => '24',
					'unit' => 'px',
					'sizes' => []
				],
				// Anchor Link ----------------------/

				// Body ---------------------------/

				// Text Editor --------------------/

				// Image --------------------------/
			)
		);

		// Design 18
		$options['design-18'] = array(
			'title' => __( 'Design 17', 'creative-addons-for-elementor' ),
			'preview_url' => $this->presets_preview_url( 'steps-design-18.jpg' ),
			'options' => array(

				// Style Tab ---------------------------------------------------/

				// General  -----------------------/

				// Header  ------------------------/
				'crel_steps__header_paddingTopBottom'                   => [
					'size' => '6',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__header_paddingLeftRight'                   => [
					'size' => '15',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__header_backgroundColor'                    => '#ffffff',
				'crel_steps__header_BorderType_border'                  => 'solid',
				'crel_steps__header_borderRadius'                       => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '0',
					'unit' => 'px'
				],
				'crel_steps__header_marginBottom'                       => [
					'size' => '0',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__header_BorderType_color'                   => '#B633C4',
				'crel_steps__header_BorderType_width'                   => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '7',
					'unit' => 'px'
				],

				// Prefix / Counter Container -----/
				'crel_steps__prefixCounterContainer_layout'             => 'crel-step-header__step--row',
				'crel_steps__titlePrefix_text'                          => __( 'STEP', 'creative-addons-for-elementor' ),
				'crel_steps__prefixCounterContainer__backgroundColor'   => '#C258F0',
				'crel_steps__prefixCounterContainer_padding'            => [
					'top'       => '2',
					'left'      => '15',
					'right'     => '6',
					'bottom'    => '4',
					'unit' => 'px'
				],
				'crel_steps__prefixCounterContainer_borderRadius'       => [
					'top'       => '50',
					'left'      => '50',
					'right'     => '50',
					'bottom'    => '50',
					'unit' => 'px'
				],
				'crel_steps__prefixCounterContainer_BorderType_border'  => 'solid',
				'crel_steps__prefixCounterContainer_BorderType_width'   => [
					'top'       => '4',
					'left'      => '4',
					'right'     => '4',
					'bottom'    => '4',
					'unit' => 'px'
				],
				'crel_steps__prefixCounterContainer_BorderType_color'   => '#D68FED',

				// Title Prefix -------------------/
				'crel_steps__prefix_paddingTopBottom'                   => [
					'size' => '0',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__prefix_paddingLeftRight'                   => [
					'size' => '0',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__prefix_color'                              => '#FFFFFF',
				'crel_steps__prefix_backgroundColor'                    => '#C258F0',

				// Counter ------------------------/
				'crel_steps__stepNum_color'                             => '#FFFFFF',
				'crel_steps__stepNum_backgroundColor'                   => '#C258F0',
				'crel_steps__stepNum_typography_font_size'              => [
					'size' => '19',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__stepNum_padding'                  => [
					'top'       => '5',
					'left'      => '8',
					'right'     => '8',
					'bottom'    => '5',
					'unit'      => 'px'
				],
				'crel_steps__stepNum_startingSpace'                     => [
					'size' => '13',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__stepNum_borderRadius'                      => [
					'size' => '126',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__stepNum_BorderType_border'                 => 'dotted',
				'crel_steps__stepNum_BorderType_color'                  => '#FFFFFF',
				'crel_steps__stepNum_BorderType_width'                  => [
					'top'       => '2',
					'left'      => '2',
					'right'     => '2',
					'bottom'    => '2',
					'unit' => 'px'
				],

				// Title --------------------------/
				'crel_steps__title_color'                               => '#282828',
				'crel_steps__title_startingSpace'                       => [
					'size' => '17',
					'unit' => 'px',
					'sizes' => []
				],

				// Anchor Link ----------------------/

				// Body ---------------------------/
				'crel_steps__body_paddingLeftRight'                     => [
					'size' => '15',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__body_paddingTopBottom'                     => [
					'size' => '24',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__body_borderType_border'                           => 'solid',
				'crel_steps__body_borderType_width'                     => [
					'top'       => '5',
					'left'      => '5',
					'right'     => '5',
					'bottom'    => '5',
					'unit' => 'px'
				],
				'crel_steps__body_borderType_color'                     => '#F58DFF',

				// Text Editor --------------------/

				// Image --------------------------/
				'crel_steps__image_borderType_border'                   => 'double',
				'crel_steps__image_borderType_width'                    => [
					'top'       => '4',
					'left'      => '4',
					'right'     => '4',
					'bottom'    => '4',
					'unit' => 'px'
				],
				'crel_steps__image_borderType_color'                    => '#F58DFF',
			)
		);

		// Design 19
		$options['design-19'] = array(
			'title' => __( 'Design 18', 'creative-addons-for-elementor' ),
			'preview_url' => $this->presets_preview_url( 'steps-design-19.jpg' ),
			'options' => array(

				// Style Tab ---------------------------------------------------/

				// General  -----------------------/

				// Header  ------------------------/
				'crel_steps__header_paddingTopBottom'                   => [
					'size' => '6',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__header_paddingLeftRight'                   => [
					'size' => '10',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__header_backgroundColor'                    => '#FFFFFF',
				'crel_steps__header_borderRadius'                       => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '0',
					'unit' => 'px'
				],
				'crel_steps__header_marginBottom'                       => [
					'size' => '0',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__header_BorderType_border'                  => 'solid',
				'crel_steps__header_BorderType_color'                   => '#DDB1FF',
				'crel_steps__header_BorderType_width'                   => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '1',
					'unit' => 'px'
				],

				// Prefix / Counter Container -----/
				'crel_steps__prefixCounterContainer_layout'             => 'crel-step-header__step--col',
				'crel_steps__titlePrefix_text'                          => __( '', 'creative-addons-for-elementor' ),
				'crel_steps__prefixCounterContainer__backgroundColor'   => '#C258F0',
				'crel_steps__prefixCounterContainer_padding'            => [
					'top'       => '8',
					'left'      => '13',
					'right'     => '13',
					'bottom'    => '8',
					'unit' => 'px'
				],
				'crel_steps__prefixCounterContainer_borderRadius'       => [
					'top'       => '50',
					'left'      => '50',
					'right'     => '50',
					'bottom'    => '50',
					'unit' => 'px'
				],
				'crel_steps__prefixCounterContainer_BorderType_border'  => 'solid',
				'crel_steps__prefixCounterContainer_BorderType_width'   => [
					'top'       => '3',
					'left'      => '3',
					'right'     => '3',
					'bottom'    => '3',
					'unit' => 'px'
				],
				'crel_steps__prefixCounterContainer_BorderType_color'   => '#D68FED',

				// Title Prefix -------------------/
				'crel_steps__prefix_paddingTopBottom'                   => [
					'size' => '0',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__prefix_paddingLeftRight'                   => [
					'size' => '0',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__prefix_color'                              => '#FFFFFF',
				'crel_steps__prefix_backgroundColor'                    => '#C258F0',
				'crel_steps__prefix_typography_font_size'               =>  [
					'size' => '16',
					'unit' => 'px',
					'sizes' => []
				],

				// Counter ------------------------/
				'crel_steps__stepNum_color'                             => '#FFFFFF',
				'crel_steps__stepNum_backgroundColor'                   => '#C258F0',
				'crel_steps__stepNum_typography_font_size'              => [
					'size' => '24',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_steps__stepNum_padding'                  => [
					'top'       => '0',
					'left'      => '0',
					'right'     => '0',
					'bottom'    => '0',
					'unit'      => 'px'
				],

				// Title --------------------------/
				'crel_steps__title_color'                               => '#282828',
				'crel_steps__title_startingSpace'                       => [
					'size' => '17',
					'unit' => 'px',
					'sizes' => []
				],

				// Anchor Link ----------------------/

				// Body ---------------------------/

				// Text Editor --------------------/

				// Image --------------------------/
			),
		);

		// Design 20
		$options['design-20'] = array(
			'title' => __( 'Design 19', 'creative-addons-for-elementor' ),
			'preview_url' => $this->presets_preview_url( 'steps-design-19.jpg' ),
			'options' => array(
				
				'crel_steps__titlePrefix_text' => __( 'Step', 'creative-addons-for-elementor' ),
				'crel_steps__anchorLink_toggle' => 'yes',
				
				'crel_steps__header_paddingLeftRight' => [
					'size' => '0',
					'unit' => 'px',
					'sizes' => []
				],
				
				'crel_steps__header_marginBottom' => [
					'size' => '0',
					'unit' => 'px',
					'sizes' => []
				],
				
				'crel_steps__header_borderRadius'                       => [
					'top' => '10',
					'left' => '0',
					'right' => '10',
					'bottom' => '0',
					'unit' => 'px',
					'isLinked' => false
				],
				
				'crel_steps__header_BorderType_border'                  => 'solid',
				'crel_steps__header_BorderType_color'                   => '#76C2FF',
				'crel_steps__header_BorderType_width'                   => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '1',
					'unit' => 'px',
					'isLinked' => false
				],
				
				'crel_steps__prefixCounterContainer_padding'            => [
					'top'       => '5',
					'left'      => '15',
					'right'     => '15',
					'bottom'    => '6',
					'unit'      => 'px',
					'isLinked' => false
				],
				
				'crel_steps__prefixCounterContainer__backgroundColor' => '#76C2FF',
				
				'crel_steps__prefix_typography_typography'              => 'custom',
				
				'crel_steps__prefix_typography_font_size'               => [
					'size' => '20',
					'unit' => 'px',
					'sizes' => []
				],
				
				'crel_steps__prefix_typography_font_weight'              => 'normal',
				
				'crel_steps__prefix_typography_line_height'            => [
					'size' => '1',
					'unit' => 'em',
					'sizes' => []
				],
				
				'crel_steps__prefix_typography_letter_spacing'            => [
					'size' => '-0.9',
					'unit' => 'px',
					'sizes' => []
				],
	
				'crel_steps__prefix_backgroundColor' => '#76C2FF',
				
				'crel_steps__stepNum_typography_font_size'               => [
					'size' => '21',
					'unit' => 'px',
					'sizes' => []
				],
				
				'crel_steps__stepNum_typography_line_height'            => [
					'size' => '1',
					'unit' => 'em',
					'sizes' => []
				],
				
				'crel_steps__stepNum_startingSpace'            => [
					'size' => '12',
					'unit' => 'px',
					'sizes' => []
				],
				
				'crel_steps__stepNum_color' => '#FFFFFF',
	
				'crel_steps__stepNum_backgroundColor' => '#76C2FF',
				
				'crel_steps__title_startingSpace'            => [
					'size' => '23',
					'unit' => 'px',
					'sizes' => []
				],
				
				'crel_steps__body_paddingTopBottom' => [
					'size' => '22',
					'unit' => 'px',
					'sizes' => []
				],
				
				'crel_steps__body_backgroundColor' => '#F5F5F5',
				
				'crel_steps__image_borderType_color'                   => '#208BE0',
				
				'crel_steps__caption_backgroundColor' => '#F5F5F5',
				
				'crel_steps__caption_typography_typography'              => 'custom',
				
				'crel_steps__caption_typography_font_size'               => [
					'size' => '12',
					'unit' => 'px',
					'sizes' => []
				],
				
			),
		);

		return $options;
	}

	protected function get_config_old_defaults() {
		return [
			'crel_steps__prefix_color'                              => '#000000',
			'crel_steps__prefix_typography_typography'              => 'custom',
			'crel_steps__prefix_typography_font_size'               => [
				'size' => '25',
				'unit' => 'px',
				'sizes' => []
			],
			'crel_steps__prefix_typography_font_weight'             => 'bold',
			'crel_steps__prefix_typography_text_transform'          => '',
			
			'crel_steps__stepNum_color'                             => '#000000',
			'crel_steps__stepNum_typography_typography'             => 'custom',
			'crel_steps__stepNum_typography_font_size'              => [
				'size' => 25,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_steps__stepNum_typography_font_weight'            => 'bold',
			'crel_steps__stepNum_typography_line_height'            => [
				'size' => '0.9',
				'unit' => 'em',
				'sizes' => []
			],
			'crel_steps__title_typography_typography'               => 'custom',
			'crel_steps__title_typography_font_size'                => [
				'size' => 25,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_steps__title_typography_font_weight'              => 'bold',
			'crel_steps__title_typography_text_transform'           => '',
			'crel_steps__title_color'                               => '#000000',
			'crel_steps__anchorLink_color'                          => '#000000',
			'crel_steps__text_textColor'                            => '#000000',
			'crel_steps__text_ButtonTypography_typography'          => 'custom',
			'crel_steps__text_ButtonTypography_font_size'           => [
				'size' => '14',
				'unit' => 'px',
				'sizes' => []
			],
			'crel_steps__text_ButtonTypography_font_weight'         => 'normal',
			'crel_steps__text_ButtonTypography_line_height'         => [
				'size' => '1.5',
				'unit' => 'em',
				'sizes' => []
			],
			'crel_steps__caption_color'                             => '#000000',
		];
	}
	
	/**
	 * CONTENT tab for this widget
	 */
	protected function register_content_controls() {

		// CONTENT =================================[ TAB ]====================================/

	   // GENERAL ------------------------------------------[SECTION]-------------/

	   $this->start_controls_section(
		   'crel_steps__general__section_content',
		   [
			   'label' => __( 'General', 'creative-addons-for-elementor' ),
			   'tab' => Controls_Manager::TAB_CONTENT,
		   ]
	   );

	   // 1st List Type
	   $this->add_control(
		   'crel_steps__list_type',
		   [
			   'label'       	=> __( 'List Type', 'creative-addons-for-elementor'),
			   'type' 			=> Controls_Manager::SELECT,
			   'label_block' 	=> false,
			   'options' 		=> [
				   'crel-steps--decimal'  	                => __( 'Decimal ', 'creative-addons-for-elementor'),
				   'crel-steps--decimal-leading-zero' 	    => __( 'Decimal Leading Zero', 'creative-addons-for-elementor'),
				   'crel-steps--upper-alpha' 	            => __( 'Upper Alpha', 'creative-addons-for-elementor'),
				   'crel-steps--lower-alpha' 	            => __( 'Lower Alpha', 'creative-addons-for-elementor'),
				   'crel-steps--lower-roman' 	            => __( 'Lower Roman', 'creative-addons-for-elementor'),
				   'crel-steps--lower-greek' 	            => __( 'Lower Greek', 'creative-addons-for-elementor'),
				   'crel-steps--armenian' 	                => __( 'Armenian', 'creative-addons-for-elementor'),
				   'crel-steps--georgian' 	                => __( 'Georgian', 'creative-addons-for-elementor'),
			   ],
		   ]
	   );

	   // Prefix
	   $this->add_control(
		   'crel_steps__titlePrefix_text',
		   [
			   'label'         => __( 'Title Prefix', 'creative-addons-for-elementor' ),
			   'type'          => Controls_Manager::TEXT,
			   'placeholder'   => __( 'Step', 'creative-addons-for-elementor' ),
			   'force_preset' => true
		   ]
	   );

	   // Title HTML Tag
	   $this->add_control(
		   'crel_steps__titleHTML_tag',
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

	   // Show Link Toggle
	   $this->add_control(
		   'crel_steps__anchorLink_toggle',
		   [
			   'label' => __( 'Show Anchor Link', 'creative-addons-for-elementor'),
			   'type' => Controls_Manager::SWITCHER,
			   'label_on'  => __( 'Yes', 'creative-addons-for-elementor'),
			   'label_off' => __( 'No', 'creative-addons-for-elementor'),
		   ]
	   );

	   // Anchor Link
	   $this->add_control(
		   'crel_steps__anchorLink_icon',
		   [
			   'label' => __( 'Icon', 'creative-addons-for-elementor'),
			   'type' => Controls_Manager::ICONS,

			   'condition'	=> [
				   'crel_steps__anchorLink_toggle'	=> 'yes'
			   ]
		   ]
	   );

	   $this->end_controls_section();
	   

		// STEPS CONTENT ------------------------------------[SECTION]-------------/

		$this->start_controls_section(
			'crel_steps__steps_section_content',
			[
				'label' => __( 'Steps', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

			$repeater = new Repeater();
			
			$repeater->start_controls_tabs(
				'steps_tabs'
			);
			
				$repeater->start_controls_tab(
					'title_tab',
					[
						'label' => __( 'Title', 'creative-addons-for-elementor' ),
					]
				);
				
					// Title
					$repeater->add_control(
							'crel_steps__title_text',
							[
								'label'         => __( 'Title', 'creative-addons-for-elementor' ),
								'type'          => Controls_Manager::TEXT,
								'default'   => __( 'NEW STEP', 'creative-addons-for-elementor' ),
							]
						);

					// Layout Type
					$repeater->add_control(
						'crel_steps__layout_type',
						[
							'label'     => __( 'Layout Type', 'creative-addons-for-elementor' ),
							'type'      => Controls_Manager::SELECT,
							'options'   => [
								'layout-img-top'   => __( 'Image above text', 'creative-addons-for-elementor' ),
								'layout-img-right' => is_rtl() ? __( 'Image left of text', 'creative-addons-for-elementor' ) : __( 'Image right of text', 'creative-addons-for-elementor' ),
								'layout-img-below' => __( 'Image below of text', 'creative-addons-for-elementor' ),
								'layout-img-left'  => is_rtl() ? __( 'Image right of text', 'creative-addons-for-elementor' ) : __( 'Image left of text', 'creative-addons-for-elementor' ),
								'no-image'         => __( 'No Image', 'creative-addons-for-elementor' ),
							],
							'separator' => 'before',
							'default' => 'layout-img-right',
						]
					);

					// Structure
					$repeater->add_control(
						'crel_steps__structure',
						[
							'label'     => __( 'Structure', 'creative-addons-for-elementor' ),
							'type'      => Controls_Manager::SELECT,
							'options'   => [
								'structure-50-50'   => __( 'Columns', 'creative-addons-for-elementor' ) . ' 50, 50',
								'structure-33-66'   => is_rtl() ? __( 'Columns', 'creative-addons-for-elementor' ) . ' 66, 33' : __( 'Columns', 'creative-addons-for-elementor' ) . ' 33, 66',
								'structure-66-33'   => is_rtl() ? __( 'Columns', 'creative-addons-for-elementor' ) . ' 33, 66' : __( 'Columns', 'creative-addons-for-elementor' ) . ' 66, 33',
								'structure-75-25'   => is_rtl() ? __( 'Columns', 'creative-addons-for-elementor' ) . ' 25, 75' : __( 'Columns', 'creative-addons-for-elementor' ) . ' 75, 25',
								'structure-25-75'   => is_rtl() ? __( 'Columns', 'creative-addons-for-elementor' ) . ' 75, 25' : __( 'Columns', 'creative-addons-for-elementor' ) . ' 25, 75',
							],
							'separator' => 'after',
							//'force_preset' => true // add this if preset don't have effect  but should
							'default' => 'structure-50-50',
						]
					);
					
				$repeater->end_controls_tab();
			
				$repeater->start_controls_tab(
					'text_tab',
					[
						'label' => __( 'Text', 'creative-addons-for-elementor' ),
					]
				);
						
					// Text
					$repeater->add_control(
						'crel_steps__desc_text',
						[
							'label'         => __( 'Text', 'creative-addons-for-elementor'),
							'type'          => Controls_Manager::WYSIWYG,
							'label_block'   => true,
							'separator'     => 'after',
							'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Culpa enim esse excepturi nemo nesciunt officia officiis optio.', 'creative-addons-for-elementor' ),
						]
					);
					
				$repeater->end_controls_tab();
				
				$repeater->start_controls_tab(
					'image_tab',
					[
						'label' => __( 'Image', 'creative-addons-for-elementor' ),
					]
				);
						
					// Image
					$repeater->add_control(
						'crel_steps__image',
						[
							'label' => __( 'Image', 'creative-addons-for-elementor'),
							'type' => Controls_Manager::MEDIA,
							'default' => [
								'url' => Utils::get_placeholder_image_src(),
							],
							'condition'	=> [
								'crel_steps__layout_type!'	=> 'no-image'
							]
						]
					);
					
					// Size
					$repeater->add_group_control(
						Group_Control_Image_Size::get_type(),
						[
							'name' => 'image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `image_size` and `image_custom_dimension`.
							'default' => 'large',
							'separator' => 'none',
						]
					);
					
					// Alignment
					$repeater->add_responsive_control(
						'crel_steps__image_align',
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
								'{{WRAPPER}} {{CURRENT_ITEM}} .crel-steps-img' => 'text-align: {{VALUE}};',
							],
							'condition'	=> [
								'crel_steps__layout_type!'	=> 'no-image'
							]
						]
					);

					// Image Custom Caption
					$repeater->add_control(
						'crel_steps__caption_text',
						[
							'label' => __( 'Caption', 'creative-addons-for-elementor' ),
							'type' => Controls_Manager::TEXT,
							'placeholder' => __( 'Enter your image caption', 'creative-addons-for-elementor' ),
							'condition'	=> [
								'crel_steps__layout_type!'	=> 'no-image'
							]
						]
					);

					// Image LightBox
					$repeater->add_control(
						'crel_steps__open_lightbox',
						[
							'label' => __( 'Lightbox', 'creative-addons-for-elementor' ),
							'type' => Controls_Manager::SELECT,
							'options' => [
								'yes' => __( 'Yes', 'creative-addons-for-elementor' ),
								'no' => __( 'No', 'creative-addons-for-elementor' ),
							],
							'condition'	=> [
								'crel_steps__layout_type!'	=> 'no-image'
								]
						]
					);
					
					$repeater->add_control(
						'crel_steps__block_id',
						[
							'label' => __( 'Block ID', 'creative-addons-for-elementor' ),
							'type' => Controls_Manager::TEXT,
							'placeholder' => __( 'title-1', 'creative-addons-for-elementor' ),
							'description' => __( 'This value will be used in the url for the section, like this: http://site.com/#title-1. Not required. By default, will use Heading Text', 'creative-addons-for-elementor' ),
						]
					);
				
				$repeater->end_controls_tab();
			
			$repeater->end_controls_tabs();

			$this->add_control(
			'crel_steps__list',
			[
				'label'     => __( 'Steps', 'creative-addons-for-elementor' ),
				'type'      => Controls_Manager::REPEATER,
				'fields'    => $repeater->get_controls(),
				'title_field' => '{{{ crel_steps__title_text }}}',
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
			'crel_steps__container_section_style',
				[
					'label' => __( 'Container', 'creative-addons-for-elementor' ),
					'tab' => Controls_Manager::TAB_STYLE
				]
			);

			// Container Background Color
			$this->add_control(
				'crel_steps__container_backgroundColor',
				[
					'label' => __( 'Background Color', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crel-steps-container' => 'background-color: {{VALUE}};',
					]
				]
			);

			// Space between each Step
			$this->add_responsive_control(
			'crel_steps__list_spacing',
			[
				'label' => __( 'Space between each Step', 'creative-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 200,
						'step' => 1,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .crel-step' => 'margin-bottom: {{SIZE}}px;',
				]
			]
		);
			
			$this->add_responsive_control(
				'crel_steps__blocks_spacing',
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
						// layout-img-top
						'{{WRAPPER}} .crel-layout-img-top .elementor-row:first-child .crel-step-body__col-both'    => 'padding-bottom: calc({{SIZE}}px / 2);',
						'{{WRAPPER}} .crel-layout-img-top .elementor-row:last-child .crel-step-body__col-both'    => 'padding-top: calc({{SIZE}}px / 2);',
						
						// layout-img-right
						'(desktop){{WRAPPER}} .crel-layout-img-right .crel-step-body__col-left'     => is_rtl() ? 'padding-left: calc({{SIZE}}px / 2);' : 'padding-right: calc({{SIZE}}px / 2);',
						'(desktop){{WRAPPER}} .crel-layout-img-right .crel-step-body__col-right'    => is_rtl() ? 'padding-right: calc({{SIZE}}px / 2);' : 'padding-left: calc({{SIZE}}px / 2);',
						'(tablet){{WRAPPER}} .crel-layout-img-right .crel-step-body__col-left'     => is_rtl() ? 'padding-left: calc({{SIZE}}px / 2);' : 'padding-right: calc({{SIZE}}px / 2);',
						'(tablet){{WRAPPER}} .crel-layout-img-right .crel-step-body__col-right'    => is_rtl() ? 'padding-right: calc({{SIZE}}px / 2);' : 'padding-left: calc({{SIZE}}px / 2);',
						'(mobile){{WRAPPER}} .crel-layout-img-right .crel-step-body__col-left'     =>  'padding-bottom: {{SIZE}}px; padding-left: 0; padding-right: 0;',
						'(mobile){{WRAPPER}} .crel-layout-img-right .crel-step-body__col-right'    => 'padding-top: {{SIZE}}px; padding-left: 0; padding-right: 0;',
						
						// layout-img-below
						'{{WRAPPER}} .crel-layout-img-below .elementor-row:first-child .crel-step-body__col-both'    => 'padding-bottom: calc({{SIZE}}px / 2);',
						'{{WRAPPER}} .crel-layout-img-below .elementor-row:last-child .crel-step-body__col-both'    => 'padding-top: calc({{SIZE}}px / 2);',
						
						// layout-img-left 
						'(desktop){{WRAPPER}} .crel-layout-img-left .crel-step-body__col-left'     => is_rtl() ? 'padding-left: calc({{SIZE}}px / 2);' : 'padding-right: calc({{SIZE}}px / 2);',
						'(desktop){{WRAPPER}} .crel-layout-img-left .crel-step-body__col-right'    => is_rtl() ? 'padding-right: calc({{SIZE}}px / 2);' : 'padding-left: calc({{SIZE}}px / 2);',
						'(tablet){{WRAPPER}} .crel-layout-img-left .crel-step-body__col-left'     => is_rtl() ? 'padding-left: calc({{SIZE}}px / 2);' : 'padding-right: calc({{SIZE}}px / 2);',
						'(tablet){{WRAPPER}} .crel-layout-img-left .crel-step-body__col-right'    => is_rtl() ? 'padding-right: calc({{SIZE}}px / 2);' : 'padding-left: calc({{SIZE}}px / 2);',
						'(mobile){{WRAPPER}} .crel-layout-img-left .crel-step-body__col-left'     =>  'padding-bottom: {{SIZE}}px; padding-left: 0; padding-right: 0;',
						'(mobile){{WRAPPER}} .crel-layout-img-left .crel-step-body__col-right'    => 'padding-top: {{SIZE}}px; padding-left: 0; padding-right: 0;',
					]
				]
			);
			
		$this->end_controls_section();


		// HEADER ----------------------------[SECTION]-------------/
		$this->start_controls_section(
			'crel_steps__header_section_style',
			[
				'label' => __( 'Header', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

			// Layout ( Flex Direction ) ( This controls if the Prefix + number is above the title or not.
			$this->add_control(
				'crel_steps__header_layout',
				[
					'label'       	=> __( 'Layout', 'creative-addons-for-elementor'),
					'type' 			=> Controls_Manager::SELECT,
					'label_block' 	=> false,
					'options' 		=> [
						'crel-step-header__inner--row'   => __( 'Row - All text in a Row', 'creative-addons-for-elementor'),
						'crel-step-header__inner--col'   => __( 'Col - Prefix + Number above Title', 'creative-addons-for-elementor'),
					],
					'separator'     => 'before'
				]
			);

			// Header Padding Left / Right
			$this->add_responsive_control(
				'crel_steps__header_paddingLeftRight',
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
						'{{WRAPPER}} .crel-step-header' => 'padding-left: {{SIZE}}px; padding-right: {{SIZE}}px;'
					]
				]
			);

			// Header Padding Top / Bottom
			$this->add_responsive_control(
				'crel_steps__header_paddingTopBottom',
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
						'{{WRAPPER}} .crel-step-header' => 'padding-top: {{SIZE}}px; padding-bottom: {{SIZE}}px;'
					],

				]
			);

			// Header Margin Bottom
			$this->add_responsive_control(
				'crel_steps__header_marginBottom',
				[
					'label' => __( 'Margin Bottom', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
							'step' => 1,
						]
					],
					'selectors' => [
						'{{WRAPPER}} .crel-step-header' => 'margin-bottom: {{SIZE}}px;'
					]
				]
			);

			// Header Background Color
			$this->add_control(
				'crel_steps__header_backgroundColor',
				[
					'label' => __( 'Background Color', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crel-step-header' => 'background-color: {{VALUE}};',
					]
				]
			);

			// Header Border Radius ( Top, left , bottom , right )
			$this->add_responsive_control(
				'crel_steps__header_borderRadius',
				[
					'label' => __( 'Border Radius', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						'{{WRAPPER}} .crel-step-header' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			// Header Border Type
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crel_steps__header_BorderType',
					'label'     => __( 'Border', 'creative-addons-for-elementor'),
					'selector'  => '{{WRAPPER}} .crel-step-header',
				]
			);

			// Middle Divider Toggle
			$this->add_control(
				'crel_steps__headerMiddleDivider__toggle',
				[
					'label' => __( 'Middle Divider', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::SWITCHER,
					'label_on'  => __( 'Yes', 'creative-addons-for-elementor'),
					'label_off' => __( 'No', 'creative-addons-for-elementor'),
				]
			);

			// Border Type
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crel_steps__headerMiddleDivider_BorderType',
					'label'     => __( 'Border', 'creative-addons-for-elementor'),
					'selector'  => '{{WRAPPER}} .crel-step-header__inner__middle-divider',
					'condition'	=> [
						'crel_steps__headerMiddleDivider__toggle'	=> 'yes'
					]
				]
			);

			// Margin left
			$this->add_responsive_control(
				'crel_steps__headerMiddleDivider_marginLeft',
				[
					'label' => __( 'Margin Left', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
							'step' => 1,
						]
					],
					'selectors' => [
						'{{WRAPPER}} .crel-step-header__inner__middle-divider' => 'margin-left: {{SIZE}}px;'
					],
					'condition'	=> [
						'crel_steps__headerMiddleDivider__toggle'	=> 'yes'
					]
				]
			);

			// Margin Right
			$this->add_responsive_control(
				'crel_steps__headerMiddleDivider_marginRight',
				[
					'label' => __( 'Margin Right', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
							'step' => 1,
						]
					],
					'selectors' => [
						'{{WRAPPER}} .crel-step-header__inner__middle-divider' => 'margin-right: {{SIZE}}%;'
					],
					'condition'	=> [
						'crel_steps__headerMiddleDivider__toggle'	=> 'yes'
					]
				]
			);

		$this->end_controls_section();


		// PREFIX + COUNTER CONTAINER --------[SECTION]-------------/
		$this->start_controls_section(
			'crel_steps__prefix_counter_container_Section_style',
			[
				'label' => __( 'Prefix/Counter Container', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

			// Layout ( Flex Direction )
			$this->add_control(
				'crel_steps__prefixCounterContainer_layout',
				[
					'label'       	=> __( 'Layout', 'creative-addons-for-elementor'),
					'type' 			=> Controls_Manager::SELECT,
					'label_block' 	=> false,
					'options' 		=> [
						'crel-step-header__step--row'   => __( 'Row', 'creative-addons-for-elementor'),
						'crel-step-header__step--col'   => __( 'Col', 'creative-addons-for-elementor'),
					],
					'separator'     => 'before'
				]
			);

			// Padding ( Top, left , bottom , right )
			$this->add_responsive_control(
				'crel_steps__prefixCounterContainer_padding',
				[
					'label' => __( 'Padding', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						'{{WRAPPER}} .crel-step-header__step-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			// Border Radius ( Top, left , bottom , right )
			$this->add_responsive_control(
			'crel_steps__prefixCounterContainer_borderRadius',
				[
					'label' => __( 'Border Radius', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						'{{WRAPPER}} .crel-step-header__step-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			// Background color
			$this->add_control(
			'crel_steps__prefixCounterContainer__backgroundColor',
			[
				'label' => __( 'Background Color', 'creative-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .crel-step-header__step-container' => 'background-color: {{VALUE}};',
				]
			]
		);

			// Border Type
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crel_steps__prefixCounterContainer_BorderType',
					'label'     => __( 'Border', 'creative-addons-for-elementor'),
					'selector'  => '{{WRAPPER}} .crel-step-header__step-container',
				]
			);


		$this->end_controls_section();

		// PREFIX ----------------------------[SECTION]-------------/
		$this->start_controls_section(
			'crel_steps__prefix_Section_style',
			[
				'label' => __( 'Title Prefix', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

			// Prefix Typography
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'label'     => __( 'Typography', 'creative-addons-for-elementor' ),
					'name'      => 'crel_steps__prefix_typography',
					'selector'  => '{{WRAPPER}} .crel-step-header__step__prefix',
				]
			);

			// Prefix Padding Left / Right
			$this->add_responsive_control(
				'crel_steps__prefix_paddingLeftRight',
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
						'{{WRAPPER}} .crel-step-header__step__prefix' => 'padding-left: {{SIZE}}px; padding-right: {{SIZE}}px;'
					]
				]
			);

			// Prefix Padding Top / Bottom
			$this->add_responsive_control(
				'crel_steps__prefix_paddingTopBottom',
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
						'{{WRAPPER}} .crel-step-header__step__prefix' => 'padding-top: {{SIZE}}px; padding-bottom: {{SIZE}}px;'
					],

				]
			);

			// Prefix Margin Left
			$this->add_responsive_control(
			'crel_steps__prefix_startingSpace',
			[
				'label' => __( 'Starting Space', 'creative-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => -200,
						'max' => 200,
						'step' => 1,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .crel-step-header__step__prefix' => is_rtl() ? 'margin-right: calc( 0px - {{SIZE}}px );' : 'margin-left: {{SIZE}}px;',
				]
			]
		);

			// Prefix Color
			$this->add_control(
				'crel_steps__prefix_color',
				[
					'label' => __( 'Color', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crel-step-header__step__prefix' => 'color: {{VALUE}};',
					],
				]
			);

			// Prefix Background Color
			$this->add_control(
				'crel_steps__prefix_backgroundColor',
				[
					'label' => __( 'Background Color', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crel-step-header__step__prefix' => 'background-color: {{VALUE}};',
					]
				]
			);

			// Prefix border-radius
			$this->add_responsive_control(
				'crel_steps__prefix_borderRadius',
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
						'{{WRAPPER}} .crel-step-header__step__prefix' => 'border-radius: {{SIZE}}px;',
					]
				]
			);

			// Prefix Rotate
			$this->add_control(
				'crel_steps__prefix_rotate',
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
						'(desktop){{WRAPPER}} .crel-step-header__step__prefix' => '-ms-transform: translate({{media_offset_x.SIZE || 0}}px, {{media_offset_y.SIZE || 0}}px) rotate({{SIZE}}deg); -webkit-transform: translate({{media_offset_x.SIZE || 0}}px, {{media_offset_y.SIZE || 0}}px) rotate({{SIZE}}deg); transform: translate({{media_offset_x.SIZE || 0}}px, {{media_offset_y.SIZE || 0}}px) rotate({{SIZE}}deg);',
						'(tablet){{WRAPPER}} .crel-step-header__step__prefix' => '-ms-transform: translate({{media_offset_x_tablet.SIZE || 0}}px, {{media_offset_y_tablet.SIZE || 0}}px) rotate({{SIZE}}deg); -webkit-transform: translate({{media_offset_x_tablet.SIZE || 0}}px, {{media_offset_y_tablet.SIZE || 0}}px) rotate({{SIZE}}deg); transform: translate({{media_offset_x_tablet.SIZE || 0}}px, {{media_offset_y_tablet.SIZE || 0}}px) rotate({{SIZE}}deg);',
						'(mobile){{WRAPPER}} .crel-step-header__step__prefix' => '-ms-transform: translate({{media_offset_x_mobile.SIZE || 0}}px, {{media_offset_y_mobile.SIZE || 0}}px) rotate({{SIZE}}deg); -webkit-transform: translate({{media_offset_x_mobile.SIZE || 0}}px, {{media_offset_y_mobile.SIZE || 0}}px) rotate({{SIZE}}deg); transform: translate({{media_offset_x_mobile.SIZE || 0}}px, {{media_offset_y_mobile.SIZE || 0}}px) rotate({{SIZE}}deg);',
					],
				]
			);

		$this->end_controls_section();

		// COUNTER ----------------------------[SECTION]-------------/
		$this->start_controls_section(
			'crel_steps__num_section_style',
			[
				'label' => __( 'Counter', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

			// Counter Typography
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'label'     => 'Typography',
					'name'      => 'crel_steps__stepNum_typography',
					'selector'  => '{{WRAPPER}} .crel-step-header__step__counter',
				]
			);


			// Counter Padding ( Top, left , bottom , right )
			$this->add_responsive_control(
				'crel_steps__stepNum_padding',
				[
					'label' => __( 'Padding', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						'{{WRAPPER}} .crel-step-header__step__counter' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);



		// Counter Margin Left
			$this->add_responsive_control(
				'crel_steps__stepNum_startingSpace',
				[
					'label' => __( 'Starting Space', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => -200,
							'max' => 200,
							'step' => 1,
						]
					],
					'selectors' => [
						'{{WRAPPER}} .crel-step-header__step__counter' => is_rtl() ? 'margin-right: calc( 0px - {{SIZE}}px );' : 'margin-left: {{SIZE}}px;',
					]
				]
			);

			// Counter Color
			$this->add_control(
				'crel_steps__stepNum_color',
				[
					'label' => __( 'Color', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crel-step-header__step__counter' => 'color: {{VALUE}};',
					],
				]
			);

			// Counter Background Color
			$this->add_control(
				'crel_steps__stepNum_backgroundColor',
				[
					'label' => __( 'Background Color', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crel-step-header__step__counter' => 'background-color: {{VALUE}};',
					]
				]
			);

			// Counter border-radius
			$this->add_responsive_control(
				'crel_steps__stepNum_borderRadius',
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
						'{{WRAPPER}} .crel-step-header__step__counter' => 'border-radius: {{SIZE}}px;',
					]
				]
			);

			// Border Type
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crel_steps__stepNum_BorderType',
					'label'     => __( 'Border', 'creative-addons-for-elementor'),
					'selector'  => '{{WRAPPER}} .crel-step-header__step__counter',
				]
			);

		$this->end_controls_section();

		// TITLE ----------------------------[SECTION]-------------/
		$this->start_controls_section(
			'crel_steps__title_section_style',
			[
				'label' => __( 'Title', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

			// Title Typography
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'label'     => 'Typography',
					'name'      => 'crel_steps__title_typography',
					'selector'  => '{{WRAPPER}} .crel-step-header__inner .crel-step-header__inner__title .crel-step-header__title__text',
				]
			);

			// Title Color
			$this->add_control(
				'crel_steps__title_color',
				[
					'label' => __( 'Color', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crel-step-header__inner .crel-step-header__inner__title .crel-step-header__title__text' => 'color: {{VALUE}};',
					],
				]
			);

			// Title Background Color
			$this->add_control(
				'crel_steps__title_backgroundColor',
				[
					'label' => __( 'Background Color', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crel-step-header__inner .crel-step-header__inner__title .crel-step-header__title__text' => 'background-color: {{VALUE}};',
					]
				]
			);

			// Title Starting Space
			$this->add_responsive_control(
				'crel_steps__title_startingSpace',
				[
					'label' => __( 'Starting Space', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => -200,
							'max' => 200,
							'step' => 1,
						]
					],
					'selectors' => [
						'{{WRAPPER}} .crel-step-header__inner .crel-step-header__inner__title .crel-step-header__title__text' => is_rtl() ? 'margin-right: calc( 0px - {{SIZE}}px ) !important;' : 'margin-left: {{SIZE}}px !important;',
					]
				]
			);


		$this->end_controls_section();

		// Anchor Link ------------------------[SECTION]-------------/
		$this->start_controls_section(
			'crel_steps__anchorLink_section_style',
			[
				'label' => __( 'Anchor Link', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

			// Anchor Link Size
			$this->add_responsive_control(
				'crel_steps__anchorLink_size',
				[
					'label' => __( 'Icon Size', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 2,
							'max' => 1500,
							'step' => 1,
						]
					],
					'selectors' => [
						'{{WRAPPER}} .crel-step-header__title__link__icon'  => 'font-size: {{SIZE}}px;',
					]
				]
			);

			// Anchor Link Margin Left
			$this->add_responsive_control(
				'crel_steps__anchorLink_startingSpace',
				[
					'label' => __( 'Starting Space', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => -200,
							'max' => 200,
							'step' => 1,
						]
					],
					'selectors' => [
						'{{WRAPPER}} .crel-step-header__title__link' => is_rtl() ? 'margin-right: calc( 0px - {{SIZE}}px );' : 'margin-left: {{SIZE}}px;',
					]
				]
			);

			// Anchor Link Visibility
			$this->add_control(
				'crel_steps__anchorLink_visibility',
				[
					'label'       	=> __( 'Icon Visibility', 'creative-addons-for-elementor'),
					'type' 			=> Controls_Manager::SELECT,
					'label_block' 	=> false,
					'options' 		=> [
						'crel-steps--link-icon-show' 	    => __( 'Show all the time', 'creative-addons-for-elementor'),
						'crel-steps--link-icon-hover'     => __( 'Show On heading hover', 'creative-addons-for-elementor'),
					],
					'separator'     => 'before'
				]
			);

			$this->start_controls_tabs( '_tabs_button' );
				// Normal Tab ----------------------------/
				$this->start_controls_tab(
					'crel_steps__tabAnchorLink_normal',
					[
						'label' => __( 'Normal', 'creative-addons-for-elementor' ),
					]
				);

					// Anchor Link Color
					$this->add_control(
						'crel_steps__anchorLink_color',
						[
							'label' => __( 'Color', 'creative-addons-for-elementor' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .crel-step-header__title__link__icon' => 'color: {{VALUE}};',
							],
						]
					);

				$this->end_controls_tab();

				// Hover Tab -----------------------------/
				$this->start_controls_tab(
					'crel_steps__tabAnchorLink_hover',
					[
						'label' => __( 'Hover', 'creative-addons-for-elementor' ),
					]
				);

					// Anchor Link Color
					$this->add_control(
						'crel_steps__anchorLink_colorHover',
						[
							'label' => __( 'Color', 'creative-addons-for-elementor' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .crel-step-header__title__link__icon:hover' => 'color: {{VALUE}};',
							],
						]
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();



		$this->end_controls_section();

		// BODY ----------------------------[SECTION]-------------/
		$this->start_controls_section(
			'crel_steps__body_section_style',
			[
				'label' => __( 'Body', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

			// BODY Padding Left / Right
			$this->add_responsive_control(
				'crel_steps__body_paddingLeftRight',
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
						'{{WRAPPER}} .crel-step-body' => 'padding-left: {{SIZE}}px; padding-right: {{SIZE}}px;'
					]
				]
			);

			// BODY Padding Top / Bottom
			$this->add_responsive_control(
				'crel_steps__body_paddingTopBottom',
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
						'{{WRAPPER}} .crel-step-body' => 'padding-top: {{SIZE}}px; padding-bottom: {{SIZE}}px;'
					],

				]
			);

			// BODY Background Color
			$this->add_control(
				'crel_steps__body_backgroundColor',
				[
					'label' => __( 'Background Color', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crel-step-body' => 'background-color: {{VALUE}};',
					]
				]
			);

			// BODY border-radius
			$this->add_responsive_control(
				'crel_steps__body_borderRadius',
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
						'{{WRAPPER}} .crel-step-body' => 'border-radius: {{SIZE}}px;',
					]
				]
			);

			// BODY Border Type
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crel_steps__body_borderType',
					'label'     => __( 'Border', 'creative-addons-for-elementor'),
					'selector'  => '{{WRAPPER}} .crel-step-body',
				]
			);

		$this->end_controls_section();

		// TEXT EDITOR ---------------------[SECTION]-------------/
		$this->start_controls_section(
			'crel_steps__textEditor_section_style',
			[
				'label' => __( 'Text Editor', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

			// Text Alignment
			$this->add_responsive_control(
				'crel_steps__text_align',
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
				'crel_steps__text_textColor',
				[
					'label' => __( 'Color', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .elementor-text-editor, {{WRAPPER}} .elementor-text-editor p' => 'color: {{VALUE}};',
					],
				]
			);

			// Text Typography
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'crel_steps__text_ButtonTypography',
					'selector' => '{{WRAPPER}} .elementor-text-editor, {{WRAPPER}} .elementor-text-editor p',
				]
			);

		$this->end_controls_section();

		// IMAGE -------------------------[SECTION]-------------/
		$this->start_controls_section(
			'crel_steps__image_section_style',
			[
				'label' => __( 'Image', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

			// Image Border Type
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crel_steps__image_borderType',
					'label'     => __( 'Border', 'creative-addons-for-elementor'),
					'selector'  => '{{WRAPPER}} .crel-steps-img img',
				]
			);

			// Image border-radius
			$this->add_responsive_control(
				'crel_steps__image_borderRadius',
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
						'{{WRAPPER}} .crel-steps-img img'   => 'border-radius: {{SIZE}}px;',
					]
				]
			);

		$this->add_control(
			'crel_steps__caption_heading',
			[
				'label' => __( 'Caption', 'creative-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

			// Caption Color
			$this->add_control(
				'crel_steps__caption_color',
				[
					'label' => __( 'Color', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crel-caption-text' => 'color: {{VALUE}};',
					],
				]
			);

			// Caption Background Color
			$this->add_control(
				'crel_steps__caption_backgroundColor',
				[
					'label' => __( 'Background Color', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crel-caption-text' => 'background-color: {{VALUE}};',
					]
				]
			);

			// Caption Typography
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'crel_steps__caption_typography',
					'selector' => '{{WRAPPER}} .crel-caption-text',
				]
			);

			// Caption Padding Left / Right
			$this->add_responsive_control(
				'crel_steps__caption_paddingLeftRight',
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
			$this->add_responsive_control(
				'crel_steps__caption_paddingTopBottom',
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
			$this->add_responsive_control(
				'crel_steps__caption_marginTop',
				[
					'label' => __( 'Space Between Image', 'creative-addons-for-elementor'),
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
			$this->add_responsive_control(
				'crel_steps__caption_width',
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
	 * Renders the Icon / Image HTML
	 * @param $image_data
	 * @param $item
	 */
	protected function render_steps_image( $image_data, $item ) {

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
			
			$image_url = Group_Control_Image_Size::get_attachment_image_src( $image_data['id'], 'image', $item );
			
			$srcset = wp_get_attachment_image_srcset( $image_data['id'], $item['image_size']);
			if ( $srcset ) $srcset = 'srcset="' . $srcset . '"';
			
		} else {
			$image_alt = '';
			$image_url = esc_url($image_data['url']);
		
			foreach ( $this->get_image_sizes() as $size_name => $size_data ) {
				if ( $item['image_size'] == $size_name ) {
					$style = ( $size_data['width'] ? 'max-width: ' . $size_data['width'] . 'px; ' : '' ) . ( $size_data['height'] ? 'max-height: ' . $size_data['height'] . 'px; ' : '' );
				}
			}
		}

		//Light box
		$lightBox  = $item['crel_steps__open_lightbox'];
		$caption   = esc_attr($item['crel_steps__caption_text']);
		$image_full = esc_url($image_data['url']);
		
		if ( ! $image_url ) {
			$image_url = $image_full = Utils::get_placeholder_image_src();
		}
		
		// turn off lightbox on admin side 
		if ( is_admin() ) {
			$image_full = '';
		}
		
		echo '<div class="crel-steps-img elementor-image">';

		    if ( $caption ) { ?>
		    	<figure class="crel-caption">		    <?php
		    }

				if ( $lightBox === 'yes' ) { ?>
					<a href="<?php echo $image_full; ?>" data-elementor-open-lightbox="yes" data-elementor-lightbox-title=" ">
				<?php } ?>
						<span style="<?php echo $style; ?>" class="crel-steps-img-wrap">
							<img src="<?php echo $image_url; ?>" alt="<?php echo esc_attr($image_alt); ?>"  <?php echo $srcset; ?> loading="lazy" >
						</span>

				<?php if ( $lightBox === 'yes' ) { ?>
					</a>
				<?php }

				if ( $caption ) { ?>
					<figcaption class="crel-widget-image-caption crel-caption-text"><?php echo $caption; ?></figcaption>
				<?php }

			if ( $caption ) { ?>
				</figure>		    <?php
			}

		echo '</div>';
	}

	/**
	 * Renders Anchor Link / HTML
	 * @param $heading_text
	 */
	protected function render_steps_link( $heading_text ) {
		$settings = $this->get_settings_for_display();

		$main_icon              = $settings['crel_steps__anchorLink_icon'];
		$link_active            = esc_attr($settings['crel_steps__anchorLink_toggle']);
		
		$copy_text = sprintf( __( 'Copy link to this section: %1$s', 'creative-addons-for-elementor'), $heading_text );
		$copied_text = __( 'Copied to clipboard!', 'creative-addons-for-elementor');
		
		if ( $link_active === 'yes' ) { ?>
			<div class="crel-step-header__title__link" aria-label="<?php echo $copy_text; ?>" data-copy_text="<?php echo $copy_text; ?>" data-copied="<?php echo $copied_text; ?>">
				<div class="crel-step-header__title__link__icon"><?php Icons_Manager::render_icon( $main_icon, [], 'span' ); ?></div>
				<div class="crel-step-header__title__link__icon_hover-popup">
					<div class="crel-step-header__title__link__icon_hover-popup__inner">
						<?php echo $copy_text; ?>
					</div>
				</div>
			</div>		<?php
		}
	}

	protected function render_steps_title( $title, $title_html_tag, $index, $i, $prefix ){
		$field_key = $this->get_repeater_setting_key( 'crel_steps__title_text', 'crel_steps__list', $index );
		$this->add_render_attribute( $field_key, [
			'class' => [ 'crel-step-header__title__text' ],
		] );

		$this->add_inline_editing_attributes( $field_key, 'none' );
		
		echo '<div class="crel-step-header__inner__title">' ?>
			<<?php echo esc_attr( $title_html_tag ); ?> <?php echo $this->get_render_attribute_string( $field_key ); ?>>
				<span class="crel-hidden-title-prefix" aria-hidden="true"><?php echo $prefix; ?> <?php echo $i; ?></span>
				<?php echo esc_html( $title ); ?>
			</<?php echo esc_attr( $title_html_tag ); ?>>
			
			<?php $this->render_steps_link( $title ); ?>

		<?php echo '</div>';
	}

	private function render_text_column( $text , $col_size, $side, $index ) {
		$field_key = $this->get_repeater_setting_key( 'crel_steps__desc_text', 'crel_steps__list', $index );
		
		$this->add_render_attribute( $field_key, [
			'class' => [ 'elementor-text-editor', 'elementor-clearfix' ]
		] );
		
		$this->add_inline_editing_attributes( $field_key, 'advanced' );	?>

		<div class="elementor-element elementor-column crel-step-body__col-<?php echo esc_attr( $side ); ?> <?php echo esc_attr( $col_size ); ?> elementor-top-column">
			<div class="elementor-column-wrap  elementor-element-populated">
				<div class="elementor-widget-wrap">
					<div class="elementor-element elementor-widget elementor-widget-text-editor">
						<div class="elementor-widget-container">
							<div <?php echo $this->get_render_attribute_string( $field_key ); ?>>
								<?php echo wp_kses_post( $text ); ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>	<?php
	}

	private function render_img_column( $image , $settings, $col_size, $side ) { ?>
		<div class="elementor-element elementor-column crel-step-body__col-<?php echo esc_attr( $side ); ?> <?php echo esc_attr( $col_size ); ?> elementor-top-column">
			<div class="elementor-column-wrap  elementor-element-populated">
				<div class="elementor-widget-wrap">
					<div class="elementor-element elementor-widget elementor-widget-image">
						<div class="elementor-widget-container">
							<?php $this->render_steps_image( $image, $settings ); ?>
						</div>
					</div>
				</div>
			</div>
		</div>	<?php
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		$list_Types             = esc_attr($settings['crel_steps__list_type']);
		$prefix                 = esc_attr($settings['crel_steps__titlePrefix_text']);
		$titleTag               = esc_attr($settings['crel_steps__titleHTML_tag']);
		$anchorLink_visibility    = esc_attr($settings['crel_steps__anchorLink_visibility']);
		$prefixCounterLayout    = esc_attr($settings['crel_steps__prefixCounterContainer_layout']);
		$headerLayout           = esc_attr($settings['crel_steps__header_layout']);

		?>

		<!-- Steps -->
		<div class="crel-steps-container <?php echo $list_Types.' '.$anchorLink_visibility; ?> ">

		<!-- Step -->		<?php
		$i = 1;
		foreach ( $settings['crel_steps__list'] as $key => $item ) :

			$structure            = $item['crel_steps__structure'];

			$leftCol    = '';
			$rightCol   = '';
			switch ($structure) {
				case 'structure-50-50':
					$leftCol    = 'elementor-col-50';
					$rightCol   = 'elementor-col-50';
					break;
				case 'structure-33-66':
					$leftCol    = 'elementor-col-33';
					$rightCol   = 'elementor-col-66';
					break;
				case 'structure-66-33':
					$leftCol    = 'elementor-col-66';
					$rightCol   = 'elementor-col-33';
					break;
				case 'structure-75-25':
					$leftCol    = 'elementor-col-75';
					$rightCol   = 'elementor-col-25';
					break;
				case 'structure-25-75':
					$leftCol    = 'elementor-col-25';
					$rightCol   = 'elementor-col-75';
					break;
			}
			
			if ( $item['crel_steps__block_id'] ) {
				$titleID = $item['crel_steps__block_id'];
			} else {
				$titleID = sanitize_title($item['crel_steps__title_text']);
			}			?>

			<div class="crel-step elementor-repeater-item-<?php echo $item['_id']; ?>" id="<?php echo esc_attr($titleID); ?>" >

				<!----- HEADER -------------->
				<div class="crel-step-header">

					<div class="elementor-row">
						<div class="elementor-element elementor-column elementor-col-100 elementor-top-column">
							<div class="elementor-column-wrap  elementor-element-populated">
								<div class="elementor-widget-wrap">
									<div class="elementor-element elementor-widget elementor-widget-heading">
										<div class="crel-step-header__inner <?php echo $headerLayout; ?> elementor-widget-container">

											<div class="crel-step-header__step-container <?php echo $prefixCounterLayout; ?>">
												<div class="crel-step-header__step__prefix"><?php echo $prefix; ?></div>
												<div class="crel-step-header__step__counter"></div>
											</div>
											<?php $this->render_steps_title( $item['crel_steps__title_text'], $titleTag, $key, $i,  $prefix ); ?>
											<div class="crel-step-header__inner__middle-divider"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

				</div>

				<!----- BODY ---------------->
				<div class="crel-step-body crel-<?php echo $item['crel_steps__layout_type']; ?>">

					<!----- TWO COLUMNS HTML IMG ON RIGHT ----------------------------------------------------------->
					<?php if ( $item['crel_steps__layout_type'] === 'layout-img-right' ): ?>
					<div class="elementor-row">

						<!-- COL 1 TXT -->
						<?php $this->render_text_column( $item['crel_steps__desc_text'], $leftCol, 'left', $key ) ?>

						<!-- COL 2 IMG -->
						<?php $this->render_img_column( $item['crel_steps__image'], $item ,$rightCol , 'right' ); ?>

					</div>

					<!----- TWO COLUMNS HTML IMG ON LEFT ------------------------------------------------------------>
					<?php elseif ( $item['crel_steps__layout_type'] === 'layout-img-left' ): ?>
					<div class="elementor-row">

						<!-- COL 1 IMG -->
						<?php $this->render_img_column( $item['crel_steps__image'], $item ,$leftCol , 'left' ); ?>

						<!-- COL 2 TXT -->
						<?php $this->render_text_column( $item['crel_steps__desc_text'], $rightCol, 'right', $key ) ?>

					</div>

					<!----- TWO ROWS HTML IMG ON TOP ---------------------------------------------------------------->
					<?php elseif ( $item['crel_steps__layout_type'] === 'layout-img-top' ): ?>

					<!-- ROW 1 IMG -->
					<div class="elementor-row">
						<?php $this->render_img_column( $item['crel_steps__image'], $item ,'elementor-col-100', 'both' ); ?>
					</div>

					<!-- ROW 2 TXT -->
					<div class="elementor-row">
						<?php $this->render_text_column( $item['crel_steps__desc_text'], 'elementor-col-100', 'both', $key ) ?>
					</div>

					<!----- TWO COLUMNS HTML IMG ON BOTTOM ---------------------------------------------------------->
					<?php elseif ( $item['crel_steps__layout_type'] === 'layout-img-below' ): ?>

					<!-- ROW 1 TXT -->
					<div class="elementor-row">
						<?php $this->render_text_column( $item['crel_steps__desc_text'], 'elementor-col-100', 'both', $key ) ?>
					</div>

					<!-- ROW 2 IMG -->
					<div class="elementor-row">
						<?php $this->render_img_column( $item['crel_steps__image'], $item ,'elementor-col-100', 'both' ); ?>
					</div>


					<!----- ONE COLUMN HTML IMG OFF ---------------------------------------------------------->
					<?php elseif ( $item['crel_steps__layout_type'] === 'no-image' ): ?>

					<!-- ROW 1 TXT -->
					<div class="elementor-row">
						<?php $this->render_text_column( $item['crel_steps__desc_text'], 'elementor-col-100', 'both', $key ) ?>
					</div>


					<?php endif; ?>

				</div>

			</div><?php 
			$i++;
			endforeach; ?>

		</div>		<?php
	}
	
	protected function content_template() { 
	
		$image_sizes = $this->get_image_sizes(); ?>
		
		<!-- Steps -->
		<div class="crel-steps-container {{{ settings.crel_steps__list_type }}} {{{ settings.crel_steps__anchorLink_visibility }}}">
		
		<# if ( settings.crel_steps__list.length ) { 
			
			
			_.each( settings.crel_steps__list, function( item, index ) { 

				let structure  = item.crel_steps__structure;
				let leftCol    = '';
				let rightCol   = '';
				let titleID = '';
				let image_url = '';
				let full_image_url = ''; //empty to turn off lightbox in admin
				let style = '';
				
				<?php
					
					foreach ( $image_sizes as $size_name => $size_data ) { ?>					
						if ( item.image_size == '<?php echo $size_name; ?>' ) { 
							style = '<?php 
								echo $size_data['width'] ? 'max-width: ' . $size_data['width'] . 'px; ' : ' ';
								echo $size_data['height'] ? 'max-height: ' . $size_data['height'] . 'px; ' : ' '; ?>';
						}<?php
					} ?>
					
				if ( typeof item.crel_steps__image.id == 'undefined' || ! item.crel_steps__image.id ) {
					image_url = item.crel_steps__image.url; 

				} else {
					let image = {
						id: item.crel_steps__image.id,
						url: item.crel_steps__image.url,
						size: item.image_size,
						dimension: item.image_custom_dimension,
						model: view.getEditModel()
					}
					image_url = elementor.imagesManager.getImageUrl( image );
				}
				
				if ( ! image_url ) {
					image_url = '<?php echo Utils::get_placeholder_image_src(); ?>';
				}

				switch (structure) {
					case 'structure-50-50':
						leftCol    = 'elementor-col-50';
						rightCol   = 'elementor-col-50';
						break;
					case 'structure-33-66':
						leftCol    = 'elementor-col-33';
						rightCol   = 'elementor-col-66';
						break;
					case 'structure-66-33':
						leftCol    = 'elementor-col-66';
						rightCol   = 'elementor-col-33';
						break;
					case 'structure-75-25':
						leftCol    = 'elementor-col-75';
						rightCol   = 'elementor-col-25';
						break;
					case 'structure-25-75':
						leftCol    = 'elementor-col-25';
						rightCol   = 'elementor-col-75';
						break;
				}			
				
				if ( item.crel_steps__block_id ) {
					titleID = item.crel_steps__block_id;
				} else {
					titleID = item.crel_steps__title_text.replace( /[^A-Za-z0-9 ]/gi, '' ).toLowerCase().replace( / /gi, '_' );
				}			#>
			
				<!-- Step -->
				<div class="crel-step elementor-repeater-item-{{{item._id}}}" id="{{{ titleID }}}" >

					<!----- HEADER -------------->
					<div class="crel-step-header"><div class="elementor-row"><div class="elementor-element elementor-column elementor-col-100 elementor-top-column"><div class="elementor-column-wrap  elementor-element-populated"><div class="elementor-widget-wrap"><div class="elementor-element elementor-widget elementor-widget-heading">
						<div class="crel-step-header__inner {{{ settings.crel_steps__header_layout }}} elementor-widget-container">

							<div class="crel-step-header__step-container {{{ settings.crel_steps__prefixCounterContainer_layout }}} " >
								<div class="crel-step-header__step__prefix">{{{ settings.crel_steps__titlePrefix_text }}}</div>
								<div class="crel-step-header__step__counter"></div>
							</div>
							<#
								var field_key = view.getRepeaterSettingKey( 'crel_steps__title_text', 'crel_steps__list', index );
								
								view.addRenderAttribute( field_key, {
									'class': [ 'crel-step-header__title__text' ],
								} );

								view.addInlineEditingAttributes( field_key, 'none' ); #>
							<div class="crel-step-header__inner__title">
								<{{{ settings.crel_steps__titleHTML_tag }}} {{{ view.getRenderAttributeString( field_key ) }}}>{{{ item.crel_steps__title_text }}}</{{{ settings.crel_steps__titleHTML_tag }}}><?php
								
								$copy_text = __( 'Copy link to this section: ', 'creative-addons-for-elementor' );
								$copied_text = __( 'Link copy on Preview not available', 'creative-addons-for-elementor'); ?><#
								
								
								if ( settings.crel_steps__anchorLink_toggle == 'yes' ) { #>
									<div class="crel-step-header__title__link" aria-label="<?php echo $copy_text; ?>{{{ item.crel_steps__title_text }}}" data-copy_text="<?php echo $copy_text; ?>{{{ item.crel_steps__title_text }}}" data-copied="<?php echo $copied_text; ?>">
										<div class="crel-step-header__title__link__icon">
											<# let iconHTML = elementor.helpers.renderIcon( view, settings.crel_steps__anchorLink_icon, {}, 'i' , 'object' ); #>
											{{{ iconHTML.value }}}
										</div>
										<div class="crel-step-header__title__link__icon_hover-popup">
											<div class="crel-step-header__title__link__icon_hover-popup__inner">
												<?php echo $copy_text; ?>{{{ item.crel_steps__title_text }}}
											</div>
										</div>
									</div>		<#
								} #>
								
							</div>
							<div class="crel-step-header__inner__middle-divider"></div>
						</div>
					</div></div></div></div></div></div>
					
					<!----- BODY ---------------->
					<div class="crel-step-body crel-{{{item.crel_steps__layout_type}}}">

						<!----- TWO COLUMNS HTML IMG ON RIGHT ----------------------------------------------------------->
						<# if ( item.crel_steps__layout_type == 'layout-img-right' ) { #>
						
							<div class="elementor-row">

								<!-- COL 1 TXT -->
								<div class="elementor-element elementor-column crel-step-body__col-left {{{ leftCol }}} elementor-top-column">
									<div class="elementor-column-wrap  elementor-element-populated">
										<div class="elementor-widget-wrap">
											<div class="elementor-element elementor-widget elementor-widget-text-editor">
												<div class="elementor-widget-container"><#
													var desc_key = view.getRepeaterSettingKey( 'crel_steps__desc_text', 'crel_steps__list', index );
													
													view.addRenderAttribute( desc_key,	{
														'class': [ 'elementor-text-editor', 'elementor-clearfix' ],
													} );
													
													view.addInlineEditingAttributes( desc_key, 'none' ); #>
													<div {{{ view.getRenderAttributeString( desc_key ) }}}>
													{{{ item.crel_steps__desc_text }}}
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								
								<!-- COL 2 IMG -->
								<div class="elementor-element elementor-column crel-step-body__col-right {{{ rightCol }}} elementor-top-column"><div class="elementor-column-wrap  elementor-element-populated"><div class="elementor-widget-wrap"><div class="elementor-element elementor-widget elementor-widget-image"><div class="elementor-widget-container"><div class="crel-steps-img elementor-image"><#
									if ( item.crel_steps__caption_text ) { #>
										<figure class="crel-caption">		    <#
									}

										if ( item.crel_steps__open_lightbox == 'yes' ) { #>
											<a href="{{{ full_image_url }}}" data-elementor-open-lightbox="yes" data-elementor-lightbox-title=" " style="{{{style}}}" ><#
										} #>
												<span style="{{{style}}}" class="crel-steps-img-wrap"><img src="{{{ image_url }}}"></span><#

										if ( item.crel_steps__open_lightbox == 'yes' ) { #>
											</a><#
										}

									if ( item.crel_steps__caption_text ) { #>
											<figcaption class="crel-widget-image-caption crel-caption-text">{{{ item.crel_steps__caption_text }}}</figcaption>
										</figure>		    <#
									} #>

								</div></div></div></div></div></div>
							</div>

						<# } else if ( item.crel_steps__layout_type == 'layout-img-left' ) { #>
						<!----- TWO COLUMNS HTML IMG ON LEFT ------------------------------------------------------------>
						
							<div class="elementor-row">
								
								<!-- COL 2 IMG -->
								<div class="elementor-element elementor-column crel-step-body__col-left {{{ leftCol }}} elementor-top-column"><div class="elementor-column-wrap  elementor-element-populated"><div class="elementor-widget-wrap"><div class="elementor-element elementor-widget elementor-widget-image"><div class="elementor-widget-container"><div class="crel-steps-img elementor-image"><#
									if ( item.crel_steps__caption_text ) { #>
										<figure class="crel-caption">		    <#
									}

										if ( item.crel_steps__open_lightbox == 'yes' ) { #>
											<a href="{{{ full_image_url }}}" data-elementor-open-lightbox="yes" data-elementor-lightbox-title=" " style="{{{style}}}" ><#
										} #>
												<span style="{{{style}}}" class="crel-steps-img-wrap"><img src="{{{ image_url }}}"></span><#

										if ( item.crel_steps__open_lightbox == 'yes' ) { #>
											</a><#
										}

									if ( item.crel_steps__caption_text ) { #>
											<figcaption class="crel-widget-image-caption crel-caption-text">{{{ item.crel_steps__caption_text }}}</figcaption>
										</figure>		    <#
									} #>

								</div></div></div></div></div></div>
								
								<!-- COL 1 TXT -->
								<div class="elementor-element elementor-column crel-step-body__col-right {{{ rightCol }}} elementor-top-column">
									<div class="elementor-column-wrap  elementor-element-populated">
										<div class="elementor-widget-wrap">
											<div class="elementor-element elementor-widget elementor-widget-text-editor">
												<div class="elementor-widget-container"><#
													var desc_key = view.getRepeaterSettingKey( 'crel_steps__desc_text', 'crel_steps__list', index );
													
													view.addRenderAttribute( desc_key,	{
														'class': [ 'elementor-text-editor', 'elementor-clearfix' ],
													} );
													
													view.addInlineEditingAttributes( desc_key, 'none' ); #>
													<div {{{ view.getRenderAttributeString( desc_key ) }}}>
													{{{ item.crel_steps__desc_text }}}
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								
							</div>

						<!----- TWO ROWS HTML IMG ON TOP ---------------------------------------------------------------->
						<# } else if ( item.crel_steps__layout_type == 'layout-img-top' ) { #>

						<!-- ROW 1 IMG -->
						<div class="elementor-row">
							
							<div class="elementor-element elementor-column crel-step-body__col-both elementor-col-100 elementor-top-column"><div class="elementor-column-wrap  elementor-element-populated"><div class="elementor-widget-wrap"><div class="elementor-element elementor-widget elementor-widget-image"><div class="elementor-widget-container"><div class="crel-steps-img elementor-image"><#
									if ( item.crel_steps__caption_text ) { #>
										<figure class="crel-caption">		    <#
									}

										if ( item.crel_steps__open_lightbox == 'yes' ) { #>
											<a href="{{{ full_image_url }}}" data-elementor-open-lightbox="yes" data-elementor-lightbox-title=" " style="{{{style}}}" ><#
										} #>
												<span style="{{{style}}}" class="crel-steps-img-wrap"><img src="{{{ image_url }}}"></span><#

										if ( item.crel_steps__open_lightbox == 'yes' ) { #>
											</a><#
										}

									if ( item.crel_steps__caption_text ) { #>
											<figcaption class="crel-widget-image-caption crel-caption-text">{{{ item.crel_steps__caption_text }}}</figcaption>
										</figure>		    <#
									} #>

								</div></div></div></div></div></div>
								
						</div>

						<!-- ROW 2 TXT -->
						<div class="elementor-row">
							<div class="elementor-element elementor-column crel-step-body__col-both elementor-col-100 elementor-top-column">
								<div class="elementor-column-wrap  elementor-element-populated">
									<div class="elementor-widget-wrap">
										<div class="elementor-element elementor-widget elementor-widget-text-editor">
											<div class="elementor-widget-container"><#
													var desc_key = view.getRepeaterSettingKey( 'crel_steps__desc_text', 'crel_steps__list', index );
													
													view.addRenderAttribute( desc_key,	{
														'class': [ 'elementor-text-editor', 'elementor-clearfix' ],
													} );
													
													view.addInlineEditingAttributes( desc_key, 'none' ); #>
													<div {{{ view.getRenderAttributeString( desc_key ) }}}>
													{{{ item.crel_steps__desc_text }}}
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>	
						</div>

						<!----- TWO COLUMNS HTML IMG ON BOTTOM ---------------------------------------------------------->
						<# } else if ( item.crel_steps__layout_type == 'layout-img-below' ) { #>

						<!-- ROW 2 TXT -->
						<div class="elementor-row">
							<div class="elementor-element elementor-column crel-step-body__col-both elementor-col-100 elementor-top-column">
								<div class="elementor-column-wrap  elementor-element-populated">
									<div class="elementor-widget-wrap">
										<div class="elementor-element elementor-widget elementor-widget-text-editor">
											<div class="elementor-widget-container"><#
													var desc_key = view.getRepeaterSettingKey( 'crel_steps__desc_text', 'crel_steps__list', index );
													
													view.addRenderAttribute( desc_key,	{
														'class': [ 'elementor-text-editor', 'elementor-clearfix' ],
													} );
													
													view.addInlineEditingAttributes( desc_key, 'none' ); #>
													<div {{{ view.getRenderAttributeString( desc_key ) }}}>
													{{{ item.crel_steps__desc_text }}}
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>	
						</div>
						

						<!-- ROW 1 IMG -->
						<div class="elementor-row">
							
							<div class="elementor-element elementor-column crel-step-body__col-both elementor-col-100 elementor-top-column"><div class="elementor-column-wrap  elementor-element-populated"><div class="elementor-widget-wrap"><div class="elementor-element elementor-widget elementor-widget-image"><div class="elementor-widget-container"><div class="crel-steps-img elementor-image"><#
									if ( item.crel_steps__caption_text ) { #>
										<figure class="crel-caption">		    <#
									}

										if ( item.crel_steps__open_lightbox == 'yes' ) { #>
											<a href="{{{ full_image_url }}}" data-elementor-open-lightbox="yes" data-elementor-lightbox-title=" " style="{{{style}}}" ><#
										} #>
												<span style="{{{style}}}" class="crel-steps-img-wrap"><img src="{{{ image_url }}}"></span><#

										if ( item.crel_steps__open_lightbox == 'yes' ) { #>
											</a><#
										}

									if ( item.crel_steps__caption_text ) { #>
											<figcaption class="crel-widget-image-caption crel-caption-text">{{{ item.crel_steps__caption_text }}}</figcaption>
										</figure>		    <#
									} #>

								</div></div></div></div></div></div>
								
						</div><# 
						} else if ( item.crel_steps__layout_type == 'no-image' ) { #>

						<!-- ROW 2 TXT -->
						<div class="elementor-row">
							<div class="elementor-element elementor-column crel-step-body__col-both elementor-col-100 elementor-top-column">
								<div class="elementor-column-wrap  elementor-element-populated">
									<div class="elementor-widget-wrap">
										<div class="elementor-element elementor-widget elementor-widget-text-editor">
											<div class="elementor-widget-container"><#
													var desc_key = view.getRepeaterSettingKey( 'crel_steps__desc_text', 'crel_steps__list', index );
													
													view.addRenderAttribute( desc_key,	{
														'class': [ 'elementor-text-editor', 'elementor-clearfix' ],
													} );
													
													view.addInlineEditingAttributes( desc_key, 'none' ); #>
													<div {{{ view.getRenderAttributeString( desc_key ) }}}>
													{{{ item.crel_steps__desc_text }}}
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>	
						</div><# 
						} #>

					</div>

				</div> <#
			} ); // close each
		} #>

		</div>		<?php
	}

	protected function preview_url( $img ) {
		return CREATIVE_ADDONS_ASSETS_URL . 'images/presets/steps/' . $img;
	}
}