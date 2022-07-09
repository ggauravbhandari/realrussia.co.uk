<?php
namespace Creative_Addons\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Icons_Manager;

defined( 'ABSPATH' ) || exit();

/**
 * Advanced Heading widget for Elementor
 */
class Advanced_Heading extends Creative_Widget_Base {

	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
		$this->register_crel_script( 'advanced_heading' );
	}

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Advanced Heading', 'creative-addons-for-elementor' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'crelfont crel-advanced-heading-icon';
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
		return [ 'title', 'heading', 'text', 'header', 'headline', 'badge', 'link', 'anchor', 'tag'  ];
	}

	protected function get_config_defaults() {
		return [

			// Container Section ----------------/
			'crel_advancedHeading__container_alignment'                         => 'crel-advanced-heading--align-left',
			'crel_advancedHeading__container_borderType'                        => 'solid',
			'crel_advancedHeading__container_borderType_border'                 => 'solid',
			'crel_advancedHeading__container_borderType_width'                  => [
				'top' => '0',
				'left' => '0',
				'right' => '0',
				'bottom' => '2',
				'unit' => 'px',
				'isLinked' => false
			],
			'crel_advancedHeading__container_borderType_color'                  => '#000',
			'crel_advancedHeading__container_borderRadius'                      => [
				'size' => 0,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_advancedHeading__container_padding'                           => [
				'size' => 10,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_advancedHeading__container_marginTop'                         => [
				'size' => 15,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_advancedHeading__container_marginBottom'                      => [
				'size' => 10,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_advancedHeading__containerMiddleDivider_textSpace'            => [
				'size' => 0,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_advancedHeading__containerMiddleDivider_width'                => [
				'size' => 100,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_advancedHeading__containerMiddleDivider_BorderType_border'    => 'none',
			'crel_advancedHeading__containerMiddleDivider_BorderType_width'     => [
				'top' => '0',
				'left' => '0',
				'right' => '0',
				'bottom' => '2',
				'unit' => 'px',
				'isLinked' => false
			],
			'crel_advancedHeading__containerMiddleDivider_BorderType_color'     => '#000000',

			// TITLE Section --------------------/
			'crel_advancedHeading__title_text'                          => __( 'Advanced Heading Title', 'creative-addons-for-elementor' ),
			'crel_advancedHeading__titleHTML_tag'                       => 'h2',
			'crel_advancedHeading__title_typography_typography'         => 'custom',
			'crel_advancedHeading__title_typography_font_size'         => [
				'size' => 30,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_advancedHeading__title_typography_font_size_mobile'   => [
				'size' => 18,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_advancedHeading__title_margin'                        => [
				'top'       => '0',
				'left'      => '0',
				'right'     => '0',
				'bottom'    => '0',
				'unit'      => 'px'
			],

			// LINK Section ---------------------/
			'crel_advancedHeading__showAnchorLink'                        => 'yes',
			'crel_advancedHeading__anchorLink'                            => [
				'value' => 'fas fa-link',
				'library' => 'fa-solid',
			],
			'crel_advancedHeading__linkId'                              => '',
			'crel_advancedHeading__anchorLink_size'                       => [
				'size' => 20,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_advancedHeading__anchorLink_size_mobile'                       => [
				'size' => 12,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_advancedHeading__anchorLink_padding'                    => [
				'size' => 15,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_advancedHeading__anchorLink_visibility' 	            => 'crel-advanced-heading--anchorLink-show',
			'crel_advancedHeading__anchorLink_alignment' 		            => 'crel-advanced-heading--anchorLink-right',
			'crel_advancedHeading__anchorLink_topPosition'                => [
				'size' => 10,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_advancedHeading__anchorLink_topPosition_mobile'         => [
				'size' => 21,
				'unit' => 'px',
				'sizes' => []
			],
			
			'crel_advancedHeading__anchorLink_padding_mobile'             => [
				'size' => 4,
				'unit' => 'px',
				'sizes' => []
			],

			// Badge Section --------------------/
			'crel_advancedHeading__badge_toggle'                        => 'no',
			'crel_advancedHeading__badge_text'                          => __( 'Version 1.0.0', 'creative-addons-for-elementor' ),
			'crel_advancedHeading__badge_paddingLeftRight'              => [
				'size' => 22,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_advancedHeading__badge_paddingTopBottom'              => [
				'size' => 5,
				'unit' => 'px',
				'sizes' => []
			],
			
			'crel_advancedHeading__badge_backgroundColor'               => '#F4F4F4',
			'crel_advancedHeading__badge_borderRadius'                  => [
				'size' => 12,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_advancedHeading__badge_position' 		                => 'crel-advanced-heading--badge-top',
			'crel_advancedHeading__badge_topPosition'                   => [
				'size' => -22,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_advancedHeading__badge_topPosition_mobile'            => [
				'size' => -17,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_advancedHeading__badge_paddingLeftRight_mobile'       => [
				'size' => 13,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_advancedHeading__container_backgroundColor' => '',
			
			'crel_advancedHeading__title_color' => '#000000',
			'crel_advancedHeading__anchorLink_colorHover' => '#6EC1E4',
			'crel_advancedHeading__badge_color' => '#000000',
			'crel_advancedHeading__anchorLink_color' => '#000000',
			
			'crel_advancedHeading__badge_typography_typography'         => 'custom',
			'crel_advancedHeading__badge_typography_font_size'         => [
				'size' => 30,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_advancedHeading__badge_typography_font_size_mobile'   => [
				'size' => 18,
				'unit' => 'px',
				'sizes' => []
			],
			
		];
	}

	protected function get_config_rtl_defaults() {
		return [

		];
	}

	protected function get_presets_defaults() {
		return array(

			// Container Section ----------------/
			'crel_advancedHeading__container_alignment'                         => 'crel-advanced-heading--align-left',
			'crel_advancedHeading__container_borderType'                        => 'solid',
			'crel_advancedHeading__container_borderType_border'                 => 'solid',
			'crel_advancedHeading__container_borderType_width'                  => [
				'top' => '0',
				'left' => '0',
				'right' => '0',
				'bottom' => '2',
				'unit' => 'px',
				'isLinked' => false
			],
			'crel_advancedHeading__container_borderType_color'                  => '#000',
			'crel_advancedHeading__container_borderRadius'                      => [
				'size' => 0,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_advancedHeading__containerMiddleDivider_toggle'   => '',
			'crel_advancedHeading__container_padding'                           => [
				'size' => 10,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_advancedHeading__container_marginTop'                         => [
				'size' => 15,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_advancedHeading__container_marginBottom'                      => [
				'size' => 10,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_advancedHeading__containerMiddleDivider_textSpace'            => [
				'size' => 0,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_advancedHeading__containerMiddleDivider_width'                => [
				'size' => 100,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_advancedHeading__containerMiddleDivider_BorderType_border'    => 'none',
			'crel_advancedHeading__containerMiddleDivider_BorderType_width'     => [
				'top' => '0',
				'left' => '0',
				'right' => '0',
				'bottom' => '2',
				'unit' => 'px',
				'isLinked' => false
			],
			'crel_advancedHeading__containerMiddleDivider_BorderType_color'     => '#000000',

			// TITLE Section --------------------/
			//'crel_advancedHeading__title_text' => __( 'Advanced Heading Title', 'creative-addons-for-elementor' ),
			'crel_advancedHeading__titleHTML_tag'                               => 'h2',
			'crel_advancedHeading__title_color'                                 => '#000000',
			'crel_advancedHeading__title_margin'                                => [
				'top'       => '0',
				'left'      => '0',
				'right'     => '0',
				'bottom'    => '0',
				'unit'      => 'px'
			],

			// LINK Section ---------------------/
			'crel_advancedHeading__showAnchorLink' => 'yes',
			'crel_advancedHeading__anchorLink_color'                => '#000000',
			'crel_advancedHeading__anchorLink' => [
				'value' => 'fas fa-link',
				'library' => 'fa-solid',
			],
			'crel_advancedHeading__linkId' => '',
			'crel_advancedHeading__anchorLink_size' => [
				'size' => 20,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_advancedHeading__anchorLink_padding' => [
				'size' => 15,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_advancedHeading__anchorLink_visibility' 		=> 'crel-advanced-heading--anchorLink-show',
			'crel_advancedHeading__anchorLink_alignment' 		=> 'crel-advanced-heading--anchorLink-right',
			'crel_advancedHeading__anchorLink_topPosition' => [
				'size' => 10,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_advancedHeading__anchorLink_colorHover'       => '#6EC1E4',

			// Badge Section --------------------/
			'crel_advancedHeading__badge_toggle' => 'no',
			'crel_advancedHeading__badge_text' => __( 'Version 1.0.0', 'creative-addons-for-elementor' ),
			'crel_advancedHeading__badge_paddingLeftRight' => [
				'size' => 22,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_advancedHeading__badge_paddingTopBottom' => [
				'size' => 5,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_advancedHeading__badge_typography_font_size'                  => [
				'size' => '30',
				'unit' => 'px',
				'sizes' => []
			],
			'crel_advancedHeading__badge_color'   => '#000000',
			'crel_advancedHeading__badge_backgroundColor'   => '#F4F4F4',
			'crel_advancedHeading__badge_typography_font_style'                 => '',
			'crel_advancedHeading__badge_borderRadius' => [
				'size' => 12,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_advancedHeading__badge_position' 		=> 'crel-advanced-heading--badge-top',
			'crel_advancedHeading__badge_topPosition' => [
				'size' => 10,
				'unit' => 'px',
				'sizes' => []
			],

			'crel_advancedHeading__container_backgroundColor' => '',
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
		
		$options['default'] = array(
			'title' => 'Black - Design 1',
			'preview_url'   => $this->presets_preview_url( 'advanced-heading-black-design-1.png' ),
			'options' => array()
		);

		// Black Style 2
		$options['design-2'] = array(
			'title' => 'Black - Design 2',
			'preview_url'   => $this->presets_preview_url( 'advanced-heading-black-design-2.png' ),
			'options' => array(

				// Container Section ----------------/
				'crel_advancedHeading__container_borderType_width'      => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '1',
					'unit' => 'px'
				],
				'crel_advancedHeading__container_borderType_color'      => '#eaecef',
				'crel_advancedHeading__container_backgroundColor'       => '#ffffff',
				'crel_advancedHeading__containerMiddleDivider_toggle'   => 'no',
				'crel_advancedHeading__container_padding'               => [
					'size' => 0,
					'unit' => 'px',
					'sizes' => []
				],


				// Title Section --------------------/
				'crel_advancedHeading__title_margin'                    => [
					'top'       => '0',
					'left'      => '0',
					'right'     => '0',
					'bottom'    => '10',
					'unit'      => 'px'
				],

				// LINK Section ---------------------/
				'crel_advancedHeading__showAnchorLink'                  => 'yes',
				'crel_advancedHeading__anchorLink_color'                => '#000000',
				'crel_advancedHeading__anchorLink_visibility' 		    => 'crel-advanced-heading--anchorLink-hover',
				'crel_advancedHeading__anchorLink_alignment' 	        => 'crel-advanced-heading--anchorLink-right'
			)
		);

		// Black Style 3
		$options['design-3'] = array(
			'title'         => 'Black - Design 3', 'creative-addons-for-elementor',
			'preview_url'   => $this->presets_preview_url( 'advanced-heading-black-design-3.png' ),
			'options'       => array(

				// Container Section ----------------/
				'crel_advancedHeading__container_borderType_width'                  => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '1',
					'unit' => 'px'
				],
				'crel_advancedHeading__container_borderType_color'                  => '#000000',
				'crel_advancedHeading__container_backgroundColor'                   => '#ffffff',
				'crel_advancedHeading__containerMiddleDivider_toggle'               => 'no',

				// LINK Section ---------------------/
				'crel_advancedHeading__showAnchorLink'                                => 'no',
				'crel_advancedHeading__anchorLink_color'                              => '#000000',

				// Badge Section --------------------/
				'crel_advancedHeading__badge_toggle'                                => 'yes',
				'crel_advancedHeading__badge_backgroundColor'                       => '#F5F5F5',
				'crel_advancedHeading__badge_paddingLeftRight'                      => [
					'size' => '9',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_advancedHeading__badge_paddingTopBottom'                      => [
					'size' => '0',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_advancedHeading__badge_typography_font_size'                  => [
					'size' => '13',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_advancedHeading__badge_typography_font_style'                 => 'italic',
				'crel_advancedHeading__badge_borderRadius'                          => [
					'size' => '5',
					'unit' => 'px',
					'sizes' => []
				],
			)
		);

		// Black Style 4
		$options['design-4'] = array(
			'title' => 'Black - Design 4', 'creative-addons-for-elementor',
			'preview_url'   => $this->presets_preview_url( 'advanced-heading-black-design-4.png' ),
			'options' => array(

				// Container Section ----------------/
				'crel_advancedHeading__container_borderType_width'                  => [
					'top' => '1',
					'left' => '0',
					'right' => '0',
					'bottom' => '1',
					'unit' => 'px'
				],
				'crel_advancedHeading__container_borderType_color'                  => '#000000',
				'crel_advancedHeading__container_backgroundColor'                   => '#ffffff',
				'crel_advancedHeading__containerMiddleDivider_toggle'               => 'no',

				// LINK Section ---------------------/
				'crel_advancedHeading__showAnchorLink'                                => 'no',
				'crel_advancedHeading__anchorLink_color'                              => '#000000',

				// Badge Section --------------------/
				'crel_advancedHeading__badge_backgroundColor'                       => '#F5F5F5',
				'crel_advancedHeading__badge_paddingLeftRight'                      => [
					'size' => '9',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_advancedHeading__badge_paddingTopBottom'                      => [
					'size' => '0',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_advancedHeading__badge_typography_font_size'                  => [
					'size' => '13',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_advancedHeading__badge_typography_font_style'                 => 'italic',
				'crel_advancedHeading__badge_borderRadius'                          => [
					'size' => '5',
					'unit' => 'px',
					'sizes' => []
				],
			)
		);

		// Black Style 5
		$options['design-5'] = array(
			'title' => 'Black - Design 5', 'creative-addons-for-elementor',
			'preview_url'   => $this->presets_preview_url( 'advanced-heading-black-design-5.png' ),
			'options' => array(

				// Container Section ----------------/
				'crel_advancedHeading__container_borderType_border'                 => 'none',
				'crel_advancedHeading__container_borderType_width'                  => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '1',
					'unit' => 'px'
				],
				'crel_advancedHeading__container_borderType_color'                  => '#000000',
				'crel_advancedHeading__container_backgroundColor'                   => '#ffffff',
				'crel_advancedHeading__containerMiddleDivider_toggle'               => 'yes',
				'crel_advancedHeading__containerMiddleDivider_BorderType_border'    => 'solid',
				'crel_advancedHeading__containerMiddleDivider_BorderType_width'     =>  [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '1',
					'unit' => 'px'
				],
				'crel_advancedHeading__containerMiddleDivider_textSpace'            => [
					'size' => '14',
					'unit' => 'px',
					'sizes' => []
				],

				// LINK Section ---------------------/
				'crel_advancedHeading__showAnchorLink'                                => 'no',
				'crel_advancedHeading__anchorLink_color'                              => '#000000',

				// Badge Section --------------------/
				'crel_advancedHeading__badge_backgroundColor'                       => '#ffffff'
			)
		);

		// Black Style 6
		$options['design-6'] = array(
			'title' => 'Black - Design 6', 'creative-addons-for-elementor',
			'preview_url'   => $this->presets_preview_url( 'advanced-heading-black-design-6.png' ),
			'options' => array(

				// Container Section ----------------/
				'crel_advancedHeading__container_alignment'                         => 'crel-advanced-heading--align-center',
				'crel_advancedHeading__container_borderType_border'                 => 'none',
				'crel_advancedHeading__container_borderType_width'                  => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '2',
					'unit' => 'px'
				],
				'crel_advancedHeading__container_borderType_color'                  => '#000000',
				'crel_advancedHeading__container_backgroundColor'                   => '#ffffff',
				'crel_advancedHeading__containerMiddleDivider_toggle'               => 'yes',
				'crel_advancedHeading__containerMiddleDivider_BorderType_border'    => 'solid',
				'crel_advancedHeading__containerMiddleDivider_textSpace'            => [
					'size' => '14',
					'unit' => 'px',
					'sizes' => []
				],

				// LINK Section ---------------------/
				'crel_advancedHeading__showAnchorLink'                                => 'no',
				'crel_advancedHeading__anchorLink_color'                              => '#000000',
				'crel_advancedHeading__anchorLink_topPosition'                        => [
					'size' => '-105',
					'unit' => 'px',
					'sizes' => []
				],

				// Badge Section --------------------/
				'crel_advancedHeading__badge_toggle'                                => 'no',
				'crel_advancedHeading__badge_backgroundColor'                       => '#E2F4FD',
				'crel_advancedHeading__badge_topPosition'                           =>  [
					'size' => '-22',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_advancedHeading__badge_typography_font_size'                  => [
					'size' => '13',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_advancedHeading__badge_typography_font_style'                 => 'italic',
			)
		);

		// Black Style 7
		$options['design-7'] = array(
			'title' => 'Black - Design 7', 'creative-addons-for-elementor',
			'preview_url'   => $this->presets_preview_url( 'advanced-heading-black-design-7.png' ),
			'options' => array(

				// Container Section ----------------/
				'crel_advancedHeading__container_alignment'                         => 'crel-advanced-heading--align-center',
				'crel_advancedHeading__container_borderType_border'                 => 'none',
				'crel_advancedHeading__container_borderType_width'                  => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '2',
					'unit' => 'px'
				],
				'crel_advancedHeading__container_borderType_color'                  => '#000000',
				'crel_advancedHeading__container_backgroundColor'                   => '#f7f7f7',
				'crel_advancedHeading__containerMiddleDivider_toggle'               => 'no',
				'crel_advancedHeading__containerMiddleDivider_BorderType_border'    => 'solid',
				'crel_advancedHeading__containerMiddleDivider_textSpace'            => [
					'size' => '14',
					'unit' => 'px',
					'sizes' => []
				],

				// LINK Section ---------------------/
				'crel_advancedHeading__showAnchorLink'                                => 'no',
				'crel_advancedHeading__anchorLink_color'                              => '#000000',
				'crel_advancedHeading__anchorLink_topPosition'                        => [
					'size' => '-105',
					'unit' => 'px',
					'sizes' => []
				],

				// Badge Section --------------------/
				'crel_advancedHeading__badge_backgroundColor'                       => '#E2F4FD',
				'crel_advancedHeading__badge_topPosition'                           =>  [
					'size' => '-22',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_advancedHeading__badge_typography_font_size'                  => [
					'size' => '13',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_advancedHeading__badge_typography_font_style'                 => 'italic',
			)
		);


		$blue = '#1396FF';

		// Blue Style 8
		$options['design-8'] = array(
			'title' => 'Blue - Design 8', 'creative-addons-for-elementor',
			'preview_url'   => $this->presets_preview_url( 'advanced-heading-black-design-8.png' ),
			'options' => array(

				// Container Section ----------------/
				'crel_advancedHeading__container_borderType_border'                 => 'groove',
				'crel_advancedHeading__container_borderType_width'                  => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '9',
					'unit' => 'px'
				],
				'crel_advancedHeading__container_borderType_color'                  => $blue,
				'crel_advancedHeading__container_backgroundColor'                   => '#f7f7f7',
				'crel_advancedHeading__container_borderRadius'                      => [
					'size' => '13',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_advancedHeading__containerMiddleDivider_toggle'               => 'no',

				// LINK Section ---------------------/
				'crel_advancedHeading__anchorLink_color'                              => $blue,

				// Badge Section --------------------/
				'crel_advancedHeading__badge_toggle'                                => 'yes',
				'crel_advancedHeading__badge_backgroundColor'                       => '#EEEEEE',
				
			)
		);

		// Blue Style 9
		$options['design-9'] = array(
			'title' => 'Blue - Design 9', 'creative-addons-for-elementor',
			'preview_url'   => $this->presets_preview_url( 'advanced-heading-black-design-9.png' ),
			'options' => array(

				// Container Section ----------------/
				'crel_advancedHeading__container_borderType_border'                 => 'groove',
				'crel_advancedHeading__container_borderType_width'                  => [
					'top' => '1',
					'left' => '0',
					'right' => '0',
					'bottom' => '9',
					'unit' => 'px'
				],
				'crel_advancedHeading__container_borderType_color'                  => $blue,
				'crel_advancedHeading__container_backgroundColor'                   => '#f7f7f7',
				'crel_advancedHeading__container_borderRadius'                      => [
					'size' => '28',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_advancedHeading__containerMiddleDivider_toggle'               => 'no',

				// LINK Section ---------------------/
				'crel_advancedHeading__anchorLink_color'                              => $blue,

				// Badge Section --------------------/
				'crel_advancedHeading__badge_toggle'                                => 'yes',
				'crel_advancedHeading__badge_backgroundColor'                       => '#EEEEEE',
			)
		);

		// Blue Style 10
		$options['design-10'] = array(
			'title' => 'Blue - Design 10', 'creative-addons-for-elementor',
			'preview_url'   => $this->presets_preview_url( 'advanced-heading-black-design-10.png' ),
			'options' => array(

				// Container Section ----------------/
				'crel_advancedHeading__container_borderType_width'                  => [
					'top' => '1',
					'left' => '0',
					'right' => '0',
					'bottom' => '4',
					'unit' => 'px'
				],
				'crel_advancedHeading__container_borderType_color'                  => $blue,
				'crel_advancedHeading__container_backgroundColor'                   => '#ffffff',
				'crel_advancedHeading__containerMiddleDivider_toggle'               => 'no',

				// LINK Section ---------------------/
				'crel_advancedHeading__anchorLink_color'                            => $blue,

				// Badge Section --------------------/
				'crel_advancedHeading__badge_toggle'                                => 'yes',
				'crel_advancedHeading__badge_backgroundColor'                       => '#EEEEEE',
				'crel_advancedHeading__badge_typography_font_size'                  => [
					'size' => '14',
					'unit' => 'px',
					'sizes' => []
				],
			)
		);

		// Blue Style 11
		$options['design-11'] = array(
			'title' => 'Blue - Design 11', 'creative-addons-for-elementor',
			'preview_url'   => $this->presets_preview_url( 'advanced-heading-black-design-11.png' ),
			'options' => array(

				// Container Section ----------------/
				'crel_advancedHeading__container_borderType_width'                  => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '4',
					'unit' => 'px'
				],
				'crel_advancedHeading__container_borderType_color'                  => $blue,
				'crel_advancedHeading__container_backgroundColor'                   => '#ffffff',
				'crel_advancedHeading__containerMiddleDivider_toggle'               => 'no',

				// LINK Section ---------------------/
				'crel_advancedHeading__anchorLink_color'                              => $blue,

				// Badge Section --------------------/
				'crel_advancedHeading__badge_toggle'                                => 'yes',
				'crel_advancedHeading__badge_backgroundColor'                       => '#E2F4FD',
				'crel_advancedHeading__badge_typography_font_size'                  => [
					'size' => '14',
					'unit' => 'px',
					'sizes' => []
				],
			)
		);

		// Blue Style 12
		$options['design-12'] = array(
			'title' => 'Blue - Design 12', 'creative-addons-for-elementor',
			'preview_url'   => $this->presets_preview_url( 'advanced-heading-black-design-12.png' ),
			'options' => array(

				// Container Section ----------------/
				'crel_advancedHeading__container_alignment'                         => 'crel-advanced-heading--align-center',
				'crel_advancedHeading__container_borderType_width'                  => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '4',
					'unit' => 'px'
				],
				'crel_advancedHeading__container_borderType_color'                  => $blue,
				'crel_advancedHeading__container_backgroundColor'                   => '#ffffff',
				'crel_advancedHeading__containerMiddleDivider_toggle'               => 'no',
				'crel_advancedHeading__container_marginTop'                         => [
					'size' => 50,
					'unit' => 'px',
					'sizes' => []
				],


				// LINK Section ---------------------/
				'crel_advancedHeading__anchorLink_color'                              => $blue,
				'crel_advancedHeading__anchorLink_topPosition'                            => [
					'size' => '19',
					'unit' => 'px',
					'sizes' => []
				],

				// Badge Section --------------------/
				'crel_advancedHeading__badge_toggle'                                => 'yes',
				'crel_advancedHeading__badge_backgroundColor'                       => '#E2F4FD',
				'crel_advancedHeading__badge_topPosition'                              =>  [
					'size' => '-22',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_advancedHeading__badge_typography_font_size'                  => [
					'size' => '13',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_advancedHeading__badge_typography_font_style'                 => 'italic',
			)
		);

		// Blue Style 13
		$options['design-13'] = array(
			'title' => 'Blue - Design 13', 'creative-addons-for-elementor',
			'preview_url'   => $this->presets_preview_url( 'advanced-heading-black-design-13.png' ),
			'options' => array(

				// Container Section ----------------/
				'crel_advancedHeading__container_alignment'                         => 'crel-advanced-heading--align-center',
				'crel_advancedHeading__container_borderType_width'                  => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '2',
					'unit' => 'px'
				],
				'crel_advancedHeading__container_borderType_color'                  => '#000000',
				'crel_advancedHeading__container_backgroundColor'                   => '#ffffff',
				'crel_advancedHeading__containerMiddleDivider_toggle'               => 'yes',
				'crel_advancedHeading__containerMiddleDivider_BorderType_border'    => 'solid',
				'crel_advancedHeading__containerMiddleDivider_width'                => [
					'size' => '50',
					'unit' => '%',
					'sizes' => []
				],
				'crel_advancedHeading__containerMiddleDivider_textSpace'            => [
					'size' => '14',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_advancedHeading__containerMiddleDivider_BorderType_color'     => $blue,
				'crel_advancedHeading__container_marginTop'                         => [
					'size' => 50,
					'unit' => 'px',
					'sizes' => []
				],

				// LINK Section ---------------------/
				'crel_advancedHeading__anchorLink_color'                              => $blue,
				'crel_advancedHeading__anchorLink_topPosition'                        => [
					'size' => '-105',
					'unit' => 'px',
					'sizes' => []
				],

				// Badge Section --------------------/
				'crel_advancedHeading__badge_toggle'                                => 'yes',
				'crel_advancedHeading__badge_backgroundColor'                       => '#E2F4FD',
				'crel_advancedHeading__badge_topPosition'                           =>  [
					'size' => '-22',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_advancedHeading__badge_typography_font_size'                  => [
					'size' => '13',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_advancedHeading__badge_typography_font_style'                 => 'italic',
			)
		);

		// Blue Style 14
		$options['design-14'] = array(
			'title' => 'Blue - Design 14', 'creative-addons-for-elementor',
			'preview_url'   => $this->presets_preview_url( 'advanced-heading-black-design-14.png' ),
			'options' => array(

				// Container Section ----------------/
				'crel_advancedHeading__container_alignment'                         => 'crel-advanced-heading--align-center',
				'crel_advancedHeading__container_borderType_width'                  => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '2',
					'unit' => 'px'
				],
				'crel_advancedHeading__container_borderType_color'                  => $blue,
				'crel_advancedHeading__container_backgroundColor'                   => '#E2F4FD',
				'crel_advancedHeading__containerMiddleDivider_toggle'               => 'no',
				'crel_advancedHeading__containerMiddleDivider_BorderType_border'    => 'solid',
				'crel_advancedHeading__containerMiddleDivider_width'                => [
					'size' => '50',
					'unit' => '%',
					'sizes' => []
				],
				'crel_advancedHeading__containerMiddleDivider_textSpace'            => [
					'size' => '14',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_advancedHeading__containerMiddleDivider_BorderType_color'     => $blue,
				'crel_advancedHeading__container_marginTop'                         => [
					'size' => 50,
					'unit' => 'px',
					'sizes' => []
				],


				// LINK Section ---------------------/
				'crel_advancedHeading__anchorLink_color'                              => $blue,
				'crel_advancedHeading__anchorLink_topPosition'                        => [
					'size' => '-105',
					'unit' => 'px',
					'sizes' => []
				],

				// Badge Section --------------------/
				'crel_advancedHeading__badge_toggle'                                => 'yes',
				'crel_advancedHeading__badge_backgroundColor'                       => '#E2F4FD',
				'crel_advancedHeading__badge_topPosition'                           =>  [
					'size' => '-22',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_advancedHeading__badge_typography_font_size'                  => [
					'size' => '13',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_advancedHeading__badge_typography_font_style'                 => 'italic',
				'crel_advancedHeading__badge_borderRadius'                          => [
					'size' => '5',
					'unit' => 'px',
					'sizes' => []
				],
			)
		);

		// Blue Style 15
		$options['design-15'] = array(
			'title' => 'Blue - Design 15', 'creative-addons-for-elementor',
			'preview_url'   => $this->presets_preview_url( 'advanced-heading-black-design-15.png' ),
			'options' => array(

				// Container Section ----------------/
				'crel_advancedHeading__container_alignment'                         => 'crel-advanced-heading--align-center',
				'crel_advancedHeading__container_borderType_border'                 => 'groove',
				'crel_advancedHeading__container_borderType_width'                  => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '10',
					'unit' => 'px'
				],
				'crel_advancedHeading__container_borderType_color'                  => $blue,
				'crel_advancedHeading__container_backgroundColor'                   => '#E2F4FD',
				'crel_advancedHeading__containerMiddleDivider_toggle'               => 'no',
				'crel_advancedHeading__containerMiddleDivider_BorderType_border'    => 'solid',
				'crel_advancedHeading__containerMiddleDivider_width'                => [
					'size' => '50',
					'unit' => '%',
					'sizes' => []
				],
				'crel_advancedHeading__containerMiddleDivider_textSpace'            => [
					'size' => '14',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_advancedHeading__containerMiddleDivider_BorderType_color'     => $blue,
				'crel_advancedHeading__container_marginTop'                         => [
					'size' => 50,
					'unit' => 'px',
					'sizes' => []
				],

				// LINK Section ---------------------/
				'crel_advancedHeading__anchorLink_color'                              => $blue,
				'crel_advancedHeading__anchorLink_topPosition'                        => [
					'size' => '-105',
					'unit' => 'px',
					'sizes' => []
				],

				// Badge Section --------------------/
				'crel_advancedHeading__badge_toggle'                                => 'yes',
				'crel_advancedHeading__badge_backgroundColor'                       => '#E2F4FD',
				'crel_advancedHeading__badge_topPosition'                           =>  [
					'size' => '-22',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_advancedHeading__badge_typography_font_size'                  => [
					'size' => '13',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_advancedHeading__badge_typography_font_style'                 => 'italic',
				'crel_advancedHeading__badge_borderRadius'                          => [
					'size' => '5',
					'unit' => 'px',
					'sizes' => []
				],
			)
		);

		// Blue Style 16
		$options['design-16'] = array(
			'title' => 'Blue - Design 16', 'creative-addons-for-elementor',
			'preview_url'   => $this->presets_preview_url( 'advanced-heading-black-design-16.png' ),
			'options' => array(

				// Container Section ----------------/
				'crel_advancedHeading__container_borderType_border'                 => 'none',
				'crel_advancedHeading__container_borderType_width'                  => [
					'top' => '1',
					'left' => '0',
					'right' => '0',
					'bottom' => '4',
					'unit' => 'px'
				],
				'crel_advancedHeading__container_borderType_color'                  => $blue,
				'crel_advancedHeading__container_backgroundColor'                   => '#ffffff',
				'crel_advancedHeading__containerMiddleDivider_toggle'               => 'yes',
				'crel_advancedHeading__containerMiddleDivider_BorderType_border'    => 'dotted',
				'crel_advancedHeading__containerMiddleDivider_BorderType_width'     =>  [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '6',
					'unit' => 'px'
				],
				'crel_advancedHeading__containerMiddleDivider_textSpace'            => [
					'size' => '14',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_advancedHeading__containerMiddleDivider_BorderType_color'     => $blue,

				// LINK Section ---------------------/
				'crel_advancedHeading__anchorLink_color'                              => $blue,

				// Badge Section --------------------/
				'crel_advancedHeading__badge_toggle'                                => 'yes',
				'crel_advancedHeading__badge_backgroundColor'                       => '#ffffff'
			)
		);

		return $options;
	}
	
	protected function get_config_old_defaults() {
		return [
			'crel_advancedHeading__title_color'                         => '#000000',
			'crel_advancedHeading__anchorLink_colorHover'                 => '#6EC1E4',
			'crel_advancedHeading__badge_color'                         => '#000000',
		];
	}
	
	/**
	 * CONTENT tab for this widget
	 */
	protected function register_content_controls() {

		// CONTENT =================================[ TAB ]====================================/

		
		// Anchor Link --------------------------------[SECTION]-------------/

		$this->start_controls_section(
			'crel_advancedHeading__iconImage__section_content',
			[
				'label' => __( 'Anchor Link', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT
			]
		);

			// Show Link Toggle
			$this->add_control(
				'crel_advancedHeading__showAnchorLink',
				[
					'label'         => __( 'Show Link', 'creative-addons-for-elementor'),
					'type'          => Controls_Manager::SWITCHER,
					'label_on'      => __( 'Yes', 'creative-addons-for-elementor'),
					'label_off'     => __( 'No', 'creative-addons-for-elementor'),
					'force_preset' => true
				]
			);

			// Anchor Link
			$this->add_control(
				'crel_advancedHeading__anchorLink',
				[
					'label' => __( 'Icon', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::ICONS,
					'fa4compatibility' => 'icon',
					'condition'	=> [
						'crel_advancedHeading__showAnchorLink'	=> 'yes'
					]
				]
			);
			
			// ID for Anchor Link
			$this->add_control(
				'crel_advancedHeading__linkId',
				[
					'label' => __( 'ID', 'creative-addons-for-elementor' ),
					'label_block' => true,
					'type' => Controls_Manager::TEXT,
					'placeholder' => __( 'my-title', 'creative-addons-for-elementor' ),
					'description' => __( 'The generated ID for the anchor link is show above. It is based on the initial text of the heading. ' .
					                     'If you change the title again, the ID will stay the same so that the current link is valid and working. ' .
					                     'You can change the ID and any existing links as needed.', 'creative-addons-for-elementor' ),
					'condition'	=> [
						'crel_advancedHeading__showAnchorLink'	=> 'yes'
					],
				]
			);

		$this->end_controls_section();


		// TITLE -----------------------------------[SECTION]-------------/
		$this->start_controls_section(
			'crel_advancedHeading__titleText__section_content',
			[
				'label' => __( 'Heading Text', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

			// Title
			$this->add_control(
				'crel_advancedHeading__title_text',
				[
					'label' => __( 'Title', 'creative-addons-for-elementor' ),
					'label_block' => true,
					'type' => Controls_Manager::TEXT,
					'placeholder' => __( 'Type Advanced Heading Title', 'creative-addons-for-elementor' ),
				]
			);

			// Title HTML Tag
			$this->add_control(
				'crel_advancedHeading__titleHTML_tag',
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
					'force_preset' => true
				]
			);

		$this->end_controls_section();

		// BADGE -------------------------------------[SECTION]-------------/

		$this->start_controls_section(
			'crel_advancedHeading__badgeText__section_content',
			[
				'label' => __( 'Badge Text', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

			// Show Link Toggle
			$this->add_control(
				'crel_advancedHeading__badge_toggle',
				[
					'label' => __( 'Show Badge', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::SWITCHER,
					'label_on'  => __( 'Yes', 'creative-addons-for-elementor'),
					'label_off' => __( 'No', 'creative-addons-for-elementor'),
					'force_preset' => true
				]
			);

			// Badge Text
			$this->add_control(
				'crel_advancedHeading__badge_text',
				[
					'label' => __( 'Badge Text', 'creative-addons-for-elementor' ),
					'label_block' => true,
					'type' => Controls_Manager::TEXT,
					'placeholder' => __( 'Type Badge Text', 'creative-addons-for-elementor' ),
					'condition'	=> [
						'crel_advancedHeading__badge_toggle'	=> 'yes'
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

		// CONTAINER ---------------------------------[SECTION]-------------/

		$this->start_controls_section(
			'crel_advancedHeading__general__section_style',
			[
				'label' => __( 'Container', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

			// Container Alignment
			$this->add_control(
				'crel_advancedHeading__container_alignment',
				[
					'label'       	=> __( 'Alignment', 'creative-addons-for-elementor'),
					'type' 			=> Controls_Manager::SELECT,
					'label_block' 	=> false,
					'options' 		=> [
						'crel-advanced-heading--align-left' 	=> is_rtl() ? __( 'Right', 'creative-addons-for-elementor') : __( 'Left', 'creative-addons-for-elementor'),
						'crel-advanced-heading--align-right'    => is_rtl() ? __( 'Left', 'creative-addons-for-elementor') : __( 'Right', 'creative-addons-for-elementor'),
						'crel-advanced-heading--align-center'   => __( 'Center', 'creative-addons-for-elementor'),
					]
				]
			);
			
			$this->add_control_group(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crel_advancedHeading__container_borderType',
					'label'     => __( 'Border', 'creative-addons-for-elementor'),
					'selector'  => '{{WRAPPER}} .crel-advanced-heading-container',
					'fields_options' => [
						'border' => [
							'separator'     => 'before',
						],
						'color' => [
							'separator'     => 'after',
						]
					],
				]
			);

			// Container Background Color
			$this->add_control(
				'crel_advancedHeading__container_backgroundColor',
				[
					'label' => __( 'Background Color', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crel-advanced-heading-container' => 'background-color: {{VALUE}};',
						'{{WRAPPER}} .crel-advanced-heading--align-center .crel-advanced-heading__title__text' => 'background-color: {{VALUE}};',
					],
				]
			);

			// Container Radius
			$this->add_control_responsive(
				'crel_advancedHeading__container_borderRadius',
				[
					'label' => __( 'Radius', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 200,
							'step' => 1,
						]
					],
					'selectors' => [
						'{{WRAPPER}} .crel-advanced-heading-container' => 'border-radius: {{SIZE}}px;'
					]
				]
			);

			// Container Padding
			$this->add_control_responsive(
				'crel_advancedHeading__container_padding',
				[
					'label' => __( 'Padding', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 200,
							'step' => 1,
						]
					],
					'selectors' => [
						'{{WRAPPER}} .crel-advanced-heading-container' => 'padding: {{SIZE}}px;'
					]
				]
			);

			// Container Margin Top
			$this->add_control_responsive(
				'crel_advancedHeading__container_marginTop',
				[
					'label' => __( 'Margin Top', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => -200,
							'max' => 1000,
							'step' => 1,
						]
					],
					'selectors' => [
						'{{WRAPPER}} .crel-advanced-heading-container' => 'margin-top: {{SIZE}}px;'
					],

				]
			);

			// Container Margin Bottom
			$this->add_control_responsive(
				'crel_advancedHeading__container_marginBottom',
				[
					'label' => __( 'Margin Bottom', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => -200,
							'max' => 1000,
							'step' => 1,
						]
					],
					'selectors' => [
						'{{WRAPPER}} .crel-advanced-heading-container' => 'margin-bottom: {{SIZE}}px;'
					]
				]
			);

			// Container Middle Divider Toggle
			$this->add_control(
				'crel_advancedHeading__containerMiddleDivider_toggle',
				[
					'label' => __( 'Middle Divider', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::SWITCHER,
					'label_on'  => __( 'Yes', 'creative-addons-for-elementor'),
					'label_off' => __( 'No', 'creative-addons-for-elementor'),
					'separator' => 'before',
				]
			);

			// Container Border Type
			$this->add_control_group(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crel_advancedHeading__containerMiddleDivider_BorderType',
					'label'     => __( 'Border', 'creative-addons-for-elementor'),
					'selector'  => '{{WRAPPER}} .crel-advanced-heading__middle-divider',
					'fields_options' => [],
					'condition'	=> [
						'crel_advancedHeading__containerMiddleDivider_toggle'	=> 'yes'
					]
				]
			);

			// Container Divider Space Between Text
			$this->add_control_responsive(
				'crel_advancedHeading__containerMiddleDivider_textSpace',
				[
					'label' => __( 'Divider Space Between Text', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 100,
							'step' => 1,
						]
					],
					'selectors' => [
						'{{WRAPPER}} .crel-advanced-heading--align-left .crel-advanced-heading__middle-divider' => 'margin-left: {{SIZE}}px;',
						'{{WRAPPER}} .crel-advanced-heading--align-right .crel-advanced-heading__middle-divider' => 'margin-right: {{SIZE}}px;',
						'{{WRAPPER}} .crel-advanced-heading--align-center .crel-advanced-heading__title__text' => 'padding:0 {{SIZE}}px;'
					],
					'condition'	=> [
						'crel_advancedHeading__containerMiddleDivider_toggle'	=> 'yes'
					]
				]
			);

			// Container Divider Width
			$this->add_control_responsive(
				'crel_advancedHeading__containerMiddleDivider_width',
				[
					'label' => __( 'Divider Width', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'%' => [
							'min' => 0,
							'max' => 100,
							'step' => 1,
						]
					],
					'selectors' => [
						'{{WRAPPER}} .crel-advanced-heading__middle-divider' => 'width: {{SIZE}}%;'
					],
					'condition'	=> [
						'crel_advancedHeading__containerMiddleDivider_toggle'	=> 'yes'
					]
				]
			);



		$this->end_controls_section();


		// TITLE -----------------------------------------[SECTION]-------------/

		$this->start_controls_section(
			'crel_advancedHeading__title__section_style',
			[
				'label' => __( 'Title', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,

			]
		);
		
			// Title Color
			$this->add_control(
				'crel_advancedHeading__title_color',
				[
					'label'         => __( 'Color', 'creative-addons-for-elementor' ),
					'type'          => Controls_Manager::COLOR,
					'selectors'     => [
						'{{WRAPPER}} .crel-advanced-heading__title__text' => 'color: {{VALUE}};',
					],
				]
			);

			// Title Typography
			$this->add_control_group(
				Group_Control_Typography::get_type(),
				[
					'name' => 'crel_advancedHeading__title_typography',
					'selector' => '{{WRAPPER}} .crel-advanced-heading__title__text',
				]
			);

			// Title Margin
			$this->add_control_responsive(
				'crel_advancedHeading__title_margin',
				[
					'label' => __( 'Margin', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						'{{WRAPPER}} .crel-advanced-heading__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

		$this->end_controls_section();


		// Anchor Link  ----------------------------[SECTION]-------------/

		$this->start_controls_section(
			'crel_advancedHeading__anchorLink__section_style',
			[
				'label' => __( 'Anchor Link', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

			// Anchor Link Size
			$this->add_control_responsive(
				'crel_advancedHeading__anchorLink_size',
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
						'{{WRAPPER}} .crel-advanced-heading__title__link .crel-advanced-heading__title__link__icon'                 => 'font-size: {{SIZE}}px;',
						'{{WRAPPER}} .crel-advanced-heading__title__link .crel-advanced-heading__title__link__icon svg'             => 'width: {{SIZE}}px;',
						'{{WRAPPER}} .crel-advanced-heading--align-center .crel-advanced-heading__title__link__icon'                => 'margin-left: calc( -{{SIZE}}px / 2 );',
						'{{WRAPPER}} .crel-advanced-heading--align-center .crel-advanced-heading__title__link__icon_hover-popup'    => 'margin-left: calc((-{{SIZE}}px / 2 - 22px)); top: calc({{SIZE}}px + 23px);'

					]
				]
			);

			// Anchor Link Margin - IF NOT( Center alignment )
			$this->add_control_responsive(
			'crel_advancedHeading__anchorLink_padding',
			[
				'label' => __( 'Margin ( Left / Right )', 'creative-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,

				'range' => [
					'px' => [
						'min' => 0,
						'max' => 500,
						'step' => 1,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .crel-advanced-heading__title__link'	=> 'margin-left: {{SIZE}}px; margin-right: {{SIZE}}px;'
				],
				'condition'	=> [
					'crel_advancedHeading__container_alignment!'	=> 'crel-advanced-heading--align-center'
				]
			]
		);

			// Anchor Link Visibility
			$this->add_control(
				'crel_advancedHeading__anchorLink_visibility',
				[
					'label'       	=> __( 'Icon Visibility', 'creative-addons-for-elementor'),
					'type' 			=> Controls_Manager::SELECT,
					'label_block' 	=> false,
					'options' 		=> [
						'crel-advanced-heading--anchorLink-show' 	    => __( 'Show all the time', 'creative-addons-for-elementor'),
						'crel-advanced-heading--anchorLink-hover'     => __( 'Show On heading hover', 'creative-addons-for-elementor'),
					],
					'separator'     => 'before'
				]
			);

			// Icon Alignment - IF NOT( Center alignment )
			$this->add_control(
				'crel_advancedHeading__anchorLink_alignment',
				[
					'label'       	=> __( 'Icon Alignment', 'creative-addons-for-elementor'),
					'type' 			=> Controls_Manager::SELECT,
					'label_block' 	=> false,
					'options' 		=> [
						'crel-advanced-heading--anchorLink-left' 	    => is_rtl() ? __( 'Right', 'creative-addons-for-elementor') : __( 'Left', 'creative-addons-for-elementor'),
						'crel-advanced-heading--anchorLink-right'     => is_rtl() ? __( 'Left', 'creative-addons-for-elementor') : __( 'Right', 'creative-addons-for-elementor'),
					],
					'condition'	=> [
						'crel_advancedHeading__container_alignment!'	=> 'crel-advanced-heading--align-center'
					]
				]
			);

			// Icon top position - IF( Center alignment )
			$this->add_control_responsive(
				'crel_advancedHeading__anchorLink_topPosition',
				[
					'label' => __( 'Top Position', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => -1000,
							'max' => 1000,
							'step' => 1,
						]
					],
					'selectors' => [
						'{{WRAPPER}} .crel-advanced-heading__title__link__icon' => 'top: {{SIZE}}px;'
					],
					'condition'	=> [
						'crel_advancedHeading__container_alignment'	=> 'crel-advanced-heading--align-center'
					]
				]
			);


			$this->start_controls_tabs( '_tabs_button' );
				// Normal Tab ----------------------------/
				$this->start_controls_tab(
				'crel_advancedHeading__tabAnchorLink_normal_style',
				[
					'label' => __( 'Normal', 'creative-addons-for-elementor' ),
				]
			);

					// Anchor Link Color
					$this->add_control(
						'crel_advancedHeading__anchorLink_color',
						[
							'label' => __( 'Color', 'creative-addons-for-elementor' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .crel-advanced-heading__title__link__icon' => 'color: {{VALUE}};',
							],
						]
					);

				$this->end_controls_tab();

				// Hover Tab -----------------------------/
				$this->start_controls_tab(
				'crel_advancedHeading__TabAnchorLink_hover_style',
					[
						'label' => __( 'Hover', 'creative-addons-for-elementor' ),
					]
				);

					// Anchor Link Color
					$this->add_control(
						'crel_advancedHeading__anchorLink_colorHover',
						[
							'label'         => __( 'Color', 'creative-addons-for-elementor' ),
							'type'          => Controls_Manager::COLOR,
							'selectors'     => [
								'{{WRAPPER}} .crel-advanced-heading__title__link__icon:hover' => 'color: {{VALUE}};',
							],
						]
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

		$this->end_controls_section();


		// BADGES ----------------------------------[SECTION]-------------/

		$this->start_controls_section(
			'crel_advancedHeading__badgeStyle__section_style',
			[
				'label' => __( 'Badge', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

			// Badge Padding ( Left / Right )
			$this->add_control_responsive(
				'crel_advancedHeading__badge_paddingLeftRight',
				[
					'label' => __( 'Padding ( Left / Right )', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::SLIDER,

					'range' => [
						'px' => [
							'min' => 0,
							'max' => 500,
							'step' => 1,
						]
					],
					'selectors' => [
						'{{WRAPPER}} .crel-advanced-heading__badge__text'	=> 'padding-left: {{SIZE}}px; padding-right: {{SIZE}}px;'
					]
				]
			);

			// Badge Padding ( Top / Bottom )
			$this->add_control_responsive(
				'crel_advancedHeading__badge_paddingTopBottom',
				[
					'label' => __( 'Padding ( Top / Bottom )', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 500,
							'step' => 1,
						]
					],
					'selectors' => [
						'{{WRAPPER}} .crel-advanced-heading__badge__text'	=> 'padding-top: {{SIZE}}px; padding-bottom: {{SIZE}}px;'
					]
				]
			);

			// Badge Color
			$this->add_control(
				'crel_advancedHeading__badge_color',
				[
					'label'     => __( 'Color', 'creative-addons-for-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crel-advanced-heading__badge__text' => 'color: {{VALUE}};',
					],
				]
			);

			// Badge Background Color
			$this->add_control(
				'crel_advancedHeading__badge_backgroundColor',
				[
					'label'     => __( 'Background Color', 'creative-addons-for-elementor' ),
					'type'      => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crel-advanced-heading__badge__text' => 'background-color: {{VALUE}};',
					],
				]
			);

			// Badge Radius
			$this->add_control_responsive(
				'crel_advancedHeading__badge_borderRadius',
				[
					'label' => __( 'Radius', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 200,
							'step' => 1,
						]
					],
					'selectors' => [
						'{{WRAPPER}} .crel-advanced-heading__badge__text' => 'border-radius: {{SIZE}}px;'
					]
				]
			);

			// Badge Position
			$this->add_control(
				'crel_advancedHeading__badge_position',
				[
					'label'       	=> __( 'Position', 'creative-addons-for-elementor'),
					'type' 			=> Controls_Manager::SELECT,
					'label_block' 	=> false,
					'options' 		=> [
						'crel-advanced-heading--badge-top' 	   => __( 'Top', 'creative-addons-for-elementor'),
						'crel-advanced-heading--badge-middle'    => __( 'Middle', 'creative-addons-for-elementor'),
						'crel-advanced-heading--badge-bottom'    => __( 'Bottom', 'creative-addons-for-elementor'),
					],
					'condition'	=> [
						'crel_advancedHeading__container_alignment'	=> '!crel-advanced-heading--align-center'
					]

				]
			);

			// Badge Typography
			$this->add_control_group(
				Group_Control_Typography::get_type(),
				[
					'name'      => 'crel_advancedHeading__badge_typography',
					'selector'  => '{{WRAPPER}} .crel-advanced-heading__badge__text',
				]
			);

			// Badge top position - IF( Center alignment is selected )
			$this->add_control_responsive(
				'crel_advancedHeading__badge_topPosition',
				[
					'label' => __( 'Top Position', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'min' => -100,
							'max' => 100,
							'step' => 1,
						]
					],
					'selectors' => [
						'{{WRAPPER}} .crel-advanced-heading__badge' => 'top: {{SIZE}}px;'
					],
					'condition'	=> [
						'crel_advancedHeading__container_alignment'	=> 'crel-advanced-heading--align-center'
					]
				]
			);

		$this->end_controls_section();
	}

	/**
	 * Renders Text and Link
	 */
	protected function render_advanced_heading_title(){
		$settings = $this->get_settings_for_display();

		$title = sanitize_text_field( $settings['crel_advancedHeading__title_text'] );
		$title_html_tag = esc_attr( $settings['crel_advancedHeading__titleHTML_tag'] );

		if ( $settings['crel_advancedHeading__linkId'] ) {
			$titleID = $settings['crel_advancedHeading__linkId'];
		} else {
			$titleID = $title;
		}

		// remove first not letters
		$titleID = preg_replace( '/(?![\-_])\p{P}/', '', $titleID );
		$titleID = str_replace( '$', '-', $titleID );
		$titleID = preg_replace( '/\s/', '-', $titleID );

		$i = strlen( $titleID );
		while ( $i && preg_match( '/^(-|\d)/', $titleID ) ) {
			$titleID = preg_replace( '/^(-|\d)/', '', $titleID );
			$i --;
		}

		if ( empty( $titleID ) ) {
			$titleID = 'crel-' . rand( 0, 999 );
		}


		$this->add_render_attribute( 'crel_advancedHeading__title_text', [
			'class' => [ 'crel-advanced-heading__title__text' ],
			'id' => $titleID,
		] );
		
		$this->add_inline_editing_attributes( 'crel_advancedHeading__title_text', 'none' );
		
		echo '<div class="crel-advanced-heading__title">' ?>

			<?php echo '<' . $title_html_tag . ' ' . $this->get_render_attribute_string( 'crel_advancedHeading__title_text' ) . '>' . $title . '</' . $title_html_tag . '>'; ?>
			<?php $this->render_advanced_heading_link(); ?>

		<?php echo '</div>';

	}

	/**
	 * Renders Anchor Link / HTML
	 */
	protected function render_advanced_heading_link() {
		$settings = $this->get_settings_for_display();

		$main_icon              = $settings['crel_advancedHeading__anchorLink'];
		//$heading_text           = $settings['crel_advancedHeading__title_text'];
		$link_active            = $settings['crel_advancedHeading__showAnchorLink'];
		$copy_text = __( 'Copy the URL link to this section to share', 'creative-addons-for-elementor'); // . ' ' . $heading_text;
		$copied_text = __( 'Link copied to the clipboard.', 'creative-addons-for-elementor');

		if ( $link_active === 'yes' ) { ?>
			<div class="crel-advanced-heading__title__link" aria-label="<?php echo $copy_text; ?>" data-copy_text="<?php echo $copy_text; ?>" data-copied="<?php echo $copied_text; ?>">
				<div class="crel-advanced-heading__title__link__icon"><?php Icons_Manager::render_icon( $main_icon, [], 'span' ); ?></div>
				<div class="crel-advanced-heading__title__link__icon_hover-popup">
					<div class="crel-advanced-heading__title__link__icon_hover-popup__inner">
						<?php echo $copy_text; ?>
					</div>
				</div>
			</div>		<?php
		}
	}

	/**
	 * Renders Badge
	 */
	protected function render_advanced_heading_badge() {
		$settings = $this->get_settings_for_display();

		$badge_text          = sanitize_text_field($settings['crel_advancedHeading__badge_text']);
		$badge_active        = esc_attr($settings['crel_advancedHeading__badge_toggle']);
		
		$this->add_render_attribute( 'crel_advancedHeading__badge_text', [
			'class' => [ 'crel-advanced-heading__badge__text' ]
		] );

		$this->add_inline_editing_attributes( 'crel_advancedHeading__badge_text', 'none' );

		if ( $badge_active === 'yes' ) {  ?>
			<div class="crel-advanced-heading__badge">
				<div <?php echo $this->get_render_attribute_string( 'crel_advancedHeading__badge_text' ); ?>> <?php echo $badge_text; ?></div>
			</div>		<?php
		}
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 */
	protected function render() {

		$settings = $this->get_settings_for_display();

		//GENERAL
		$main_alignment         = esc_attr($settings['crel_advancedHeading__container_alignment']);
		$badge_position           = esc_attr($settings['crel_advancedHeading__badge_position']);
		$anchorLink_visibility    = esc_attr($settings['crel_advancedHeading__anchorLink_visibility']);

		// ICON
		$icon_position          = esc_attr($settings['crel_advancedHeading__anchorLink_alignment']);		?>

		<!-- Advanced Heading -->
		<div class="crel-advanced-heading-container <?php echo $main_alignment.' '.$icon_position.' '.$badge_position.' '.$anchorLink_visibility; ?>">

			<!-- Text / Link -->
			<?php $this->render_advanced_heading_title(); ?>

			<!-- Badge -->
			<?php $this->render_advanced_heading_badge(); ?>

			<!-- Middle Divider -->
			<div class="crel-advanced-heading__middle-divider-container">
				<div class="crel-advanced-heading__middle-divider"></div>
			</div>

		</div>		<?php
	}
	
	/**
	 * Dynamically render Info Box
	 */
	protected function content_template() { ?>

		<!-- Advanced Heading -->
		<div class="crel-advanced-heading-container {{{settings.crel_advancedHeading__container_alignment}}} {{{settings.crel_advancedHeading__anchorLink_alignment}}} {{{settings.crel_advancedHeading__badge_position}}} {{{settings.crel_advancedHeading__anchorLink_visibility}}}">

			<!-- Text / Link -->
			<?php $this->render_js_advanced_heading_title(); ?>

			<!-- Badge -->
			<?php $this->render_js_advanced_heading_badge(); ?>

			<!-- Middle Divider -->
			<div class="crel-advanced-heading__middle-divider-container">
				<div class="crel-advanced-heading__middle-divider"></div>
			</div>

		</div>		<?php
	}
	
	/**
	 * Renders JS Text and Link
	 */
	protected function render_js_advanced_heading_title() { ?>
		<#
		let titleID = '';
			
		if ( settings.crel_advancedHeading__linkId ) {
			titleID = settings.crel_advancedHeading__linkId;
		} else {
			titleID = settings.crel_advancedHeading__title_text;
		}

		titleID = titleID.replace(/(?![\-_])\p{P}/gu,""); // punctuation
		titleID = titleID.replace('$',"-"); // $
		titleID = titleID.replace(/\s/g,"-"); // space

		let i = titleID.length;

		while ( i && ~titleID.search( /^(-|\d)/ ) ) { // first letter
			titleID = titleID.replace( /^(-|\d)/, '' );
			i--;
		}

		if ( titleID.length == 0 ) {
			titleID = 'crel-' + Math.floor(Math.random() * 999 );
		}

		view.addRenderAttribute( 'crel_advancedHeading__title_text',	{
			'class': [ 'crel-advanced-heading__title__text' ],
		} );
		view.addInlineEditingAttributes( 'crel_advancedHeading__title_text', 'none' ); #>
		
		<div class="crel-advanced-heading__title">
			<{{{settings.crel_advancedHeading__titleHTML_tag}}} id="{{{titleID}}}" {{{ view.getRenderAttributeString( 'crel_advancedHeading__title_text' ) }}}>
				{{{settings.crel_advancedHeading__title_text}}}
			</{{{settings.crel_advancedHeading__titleHTML_tag}}}>
			<?php $this->render_js_advanced_heading_link(); ?>
		</div> <?php
	}

	/**
	 * Renders JS Anchor Link / HTML
	 */
	protected function render_js_advanced_heading_link() {

		$copy_text = __( 'Copy the URL link to this section to share', 'creative-addons-for-elementor');
		$copied_text = __( 'Link copy on Preview not available', 'creative-addons-for-elementor'); ?>
		
		<# if ( settings.crel_advancedHeading__showAnchorLink == 'yes' ) { #>
			<div class="crel-advanced-heading__title__link" aria-label="<?php echo $copy_text; ?>" data-copy_text="<?php echo $copy_text; ?>" data-copied="<?php echo $copied_text; ?>">
			<# let iconHTML = elementor.helpers.renderIcon( view, settings.crel_advancedHeading__anchorLink, {}, 'i' , 'object' ); #>
				<div class="crel-advanced-heading__title__link__icon">{{{ iconHTML.value }}}</div>
				<div class="crel-advanced-heading__title__link__icon_hover-popup">
					<div class="crel-advanced-heading__title__link__icon_hover-popup__inner">
						<?php echo $copy_text; ?>{{{ settings.crel_advancedHeading__title_text }}}
					</div>
				</div>
			</div>
		<# } #> <?php
	}

	/**
	 * Renders JS Badge
	 */
	protected function render_js_advanced_heading_badge() {  ?>
		<# if ( settings.crel_advancedHeading__badge_toggle == 'yes' ) {
			view.addRenderAttribute( 'crel_advancedHeading__badge_text',	{
				'class': [ 'crel-advanced-heading__badge__text' ],
			} );

			view.addInlineEditingAttributes( 'crel_advancedHeading__badge_text', 'none' ); #>
			<div class="crel-advanced-heading__badge">
				<div {{{ view.getRenderAttributeString( 'crel_advancedHeading__badge_text' ) }}}> {{{ settings.crel_advancedHeading__badge_text }}}</div>
			</div>
		<# } #> <?php
	}
}
