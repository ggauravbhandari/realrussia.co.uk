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
 * Image Guide widget for Elementor
 */
class Image_Guide extends Creative_Widget_Base {
	
	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Image Guide', 'creative-addons-for-elementor' );
	}
	
	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'crelfont crel-image-guide-icon'; 
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
		return [ 'image', 'guide', 'instruction', 'spot', 'numbers', 'diagram' ];
	}

	protected function get_config_defaults() {
		return [
			// Content settings 
			'crel_image_guide__layout_type'         => 'row-reverse',
			'crel_image_guide__layout_type_mobile'  => 'column',
			'crel_image_guide__layout_type_tablet'  => 'column',
			'crel_image_guide__ratio' => '50',
			'crel_image_guide__description_position' => 'description-top',
			'crel_image_guide__image' => [ 'url' => Utils::get_placeholder_image_src() ],
			'image_size' => 'large',
			'crel_image_guide__image_align' => 'center',
			'crel_image_guide__caption_text' => '',
			'crel_image_guide__description' => '<p>Lorem ipsum, or lipsum as it is sometimes known, is dummy text used in laying out print, graphic or web designs.</p>',
			
			'crel_image_guide__spots' => [
				[
					'crel_image_guide__spot_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Id eu nisl nunc mi. ',
					'crel_image_guide__spot_X' =>  [
						'size' => '10',
						'unit' => '%',
						'sizes' => []
					],
					'crel_image_guide__spot_Y' =>  [
						'size' => '10',
						'unit' => '%',
						'sizes' => []
					],
					'crel_image_guide__spot_icon' =>  [],
				],
				[
					'crel_image_guide__spot_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Id eu nisl nunc mi. ',
					'crel_image_guide__spot_X' =>  [
						'size' => '30',
						'unit' => '%',
						'sizes' => []
					],
					'crel_image_guide__spot_Y' =>  [
						'size' => '30',
						'unit' => '%',
						'sizes' => []
					],
					'crel_image_guide__spot_icon' =>  [],
				],
				[
					'crel_image_guide__spot_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Id eu nisl nunc mi. ',
					'crel_image_guide__spot_X' =>  [
						'size' => '70',
						'unit' => '%',
						'sizes' => []
					],
					'crel_image_guide__spot_Y' =>  [
						'size' => '70',
						'unit' => '%',
						'sizes' => []
					],
					'crel_image_guide__spot_icon' =>  [],
				]
			],
			
			// Style settings 
			'crel_image_guide__list_type'                               => 'crel-image-guide--lower-alpha',


			// STYLE TAB =====================================================================/

			// General -------------------------------------------------------------------/
			'crel_image_guide__rows_spacing'                            => [
				'size' => '0',
				'unit' => 'px',
				'sizes' => []
			],

			// Image ---------------------------------------------------------------------/
			'crel_image_guide__image_padding'                           => [
				'top'       => '0',
				'left'      => '0',
				'right'     => '0',
				'bottom'    => '0',
				'unit'      => 'px'
			],
			'crel_image_guide__image_border_border'                     => 'solid',
			'crel_image_guide__image_border_width'                      => [
				'top'       => '1',
				'right'     => '1',
				'bottom'    => '1',
				'left'      => '1',
				'isLinked'  => false,
				'unit'      => 'px'
			],
			'crel_image_guide__image_border_color'                      => '#020101',
			'crel_image_guide__image_border_radius'                     => [
				'top'       => '0',
				'left'      => '0',
				'right'     => '0',
				'bottom'    => '0',
				'unit'      => 'px'
			],
			'crel_image_guide__image_box_shadow_box_shadow_type'        => [
				'box_shadow_type' => [
					'default' => 'no',
				],
			],
			'crel_image_guide__image_box_shadow_box_shadow'             => [
				'horizontal' => 0,
				'vertical' => 0,
				'blur' => 0,
				'spread' => 0,
				'color' => '',
			],
			'crel_image_guide__image_box_max_width'                            => [
				'size' => '',
				'unit' => 'px',
				'sizes' => []
			],

			// Image Caption -------------------------------------------------------------/
			'crel_image_guide__image_caption_bg_color'                  => '#ffffff',
			'crel_image_guide__image_caption_padding'                   => [
				'top'       => '0',
				'left'      => '0',
				'right'     => '0',
				'bottom'    => '0',
				'unit'      => 'px'
			],
			'crel_image_guide__image_caption_margin'                    => [
				'top'       => '0',
				'left'      => '0',
				'right'     => '0',
				'bottom'    => '0',
				'unit'      => 'px'
			],
			'crel_image_guide__image_caption_border_radius'             => [
				'top'       => '0',
				'left'      => '0',
				'right'     => '0',
				'bottom'    => '0',
				'unit'      => 'px'
			],

			// Spots ---------------------------------------------------------------------/
			'crel_image_guide__spot_width'                              => [
				'size' => '44',
				'unit' => 'px',
				'sizes' => []
			],
			'crel_image_guide__spot_height'                             => [
				'size' => '44',
				'unit' => 'px',
				'sizes' => []
			],
			'crel_image_guide__spot_padding'                            => [
				'top' => '0',
				'left' => '0',
				'right' => '0',
				'bottom' => '0',
				'unit' => 'px'
			],
			'crel_image_guide__spot_pulse_toggle'                       => 'yes',
			'crel_image_guide__spot_bg_color'                           => '#FCE205',
			'crel_image_guide__spot_box_shadow_box_shadow_type'         => [
				'box_shadow_type' => [
					'default' => 'no',
				],
			],
			'crel_image_guide__spot_box_shadow_box_shadow'              => [
				'horizontal'    => 0,
				'vertical'      => 0,
				'blur'          => 10,
				'spread'        => 0,
				'color'         => '#000000',
			],
			'crel_image_guide__spot_hover_bg_color'                     => '#00a9ff',
			'crel_image_guide__spot_hover_box_shadow'                   => '',
			'crel_image_guide__spot_font_size'                          => [
				'size' => '20',
				'unit' => 'px',
				'sizes' => []
			],
			'crel_image_guide__spot_text_color'                         => '#000000',
			'crel_image_guide__spot_hover_text_color'                   => '#ffffff',
			'crel_image_guide__spot_hover_border_color'                 => '#ffffff',
			'crel_image_guide__spot_border_border'                      => 'solid',
			'crel_image_guide__spot_border_color'                       => '#ffffff',
			'crel_image_guide__spot_border_width'                       => [
				'top'       => '2',
				'left'      => '2',
				'right'     => '2',
				'bottom'    => '2',
				'unit'      => 'px',
				'isLinked'  => false
			],
			'crel_image_guide__spot_border_radius'                      => [
				'top'       => '30',
				'left'      => '30',
				'right'     => '30',
				'bottom'    => '30',
				'unit'      => 'px'
			],

			// Description  --------------------------------------------------------------/
			'crel_image_guide__description_margin'                      => [
				'top'       => '0',
				'left'      => '10',
				'right'     => '10',
				'bottom'    => '10',
				'unit'      => 'px',
				'isLinked' => false
			],

			// List container  -----------------------------------------------------------/
			'crel_image_guide__list_bgColor'                            => '#FFFFFF',
			'crel_image_guide__list_padding'                            => [
				'top'       => '10',
				'left'      => '10',
				'right'     => '10',
				'bottom'    => '10',
				'unit'      => 'px'
			],
			'crel_image_guide__list_margin'                             => [
				'top'       => '0',
				'left'      => '10',
				'right'     => '10',
				'bottom'    => '10',
				'unit'      => 'px',
				'isLinked' => false
			],

			// List Icon  ----------------------------------------------------------------/
			'crel_image_guide__list_spot_toggle'                        => 'yes',

			// Container
			'crel_image_guide__list_spot_width'                         => [
				'size' => '35',
				'unit' => 'px',
				'sizes' => []
			],
			'crel_image_guide__list_spot_height'                        => [
				'size' => '34',
				'unit' => 'px',
				'sizes' => []
			],
			'crel_image_guide__list_spot_padding'                       => [
				'top' => '0',
				'left' => '0',
				'right' => '0',
				'bottom' => '0',
				'unit' => 'px'
			],
			'crel_image_guide__list_spot_margin'                        => [
				'top' => '0',
				'left' => is_rtl() ? '10' : '0',
				'right' => is_rtl() ? '0' : '10',
				'bottom' => '10',
				'unit' => 'px'
			],
			'crel_image_guide__list_spot_bg_color'                      => '#FCE205',
			'crel_image_guide__list_spot_hover_bg_color'                => '#00a9ff',
			'crel_image_guide__list_spot_box_shadow_shadow_type'        => [
				'box_shadow_type' => [
					'default' => 'no',
				],
			],
			'crel_image_guide__list_spot_box_shadow_box_shadow'         => [
				'horizontal' => 0,
				'vertical' => 0,
				'blur' => 0,
				'spread' => 0,
				'color' => '',
			],
			'crel_image_guide__list_spot_hover_box_shadow_shadow_type'  => [
				'box_shadow_type' => [
					'default' => 'no',
				],
			],
			'crel_image_guide__list_spot_hover_box_shadow_box_shadow'   => [
				'horizontal' => 0,
				'vertical' => 0,
				'blur' => 0,
				'spread' => 0,
				'color' => '',
			],

			// Icon
			'crel_image_guide__list_spot_font_size'                     => [
				'size' => '12',
				'unit' => 'px',
				'sizes' => []
			],
			'crel_image_guide__list_spot_prefix_typography_font_size'   => [
				'size' => '12',
				'unit' => 'px',
				'sizes' => []
			],
			'crel_image_guide__list_spot_text_color'                    => '#000000',
			'crel_image_guide__list_spot_hover_text_color'              => '#ffffff',

			// Border
			'crel_image_guide__list_spot_border_border'                 => 'solid',
			'crel_image_guide__list_spot_border_color'                  => '#ffffff',
			'crel_image_guide__list_spot_border_width'                  => [
				'top'       => '2',
				'left'      => '2',
				'right'     => '2',
				'bottom'    => '2',
				'unit'      => 'px',
				'isLinked'  => false
			],
			'crel_image_guide__list_spot_border_radius'                 => [
				'top'       => '50',
				'left'      => '50',
				'right'     => '50',
				'bottom'    => '50',
				'unit'      => 'px'
			],
			
			
			'crel_image_guide__image_caption_text_color' => '#020101',
			'crel_image_guide__description_color' => '#020101',
			'crel_image_guide__list_text_color' => '#020101',
			'crel_image_guide__caption_Typography_typography' => 'custom',
			'crel_image_guide__caption_Typography_font_size' => [
				'size' => 16,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_image_guide__description_typography_typography' => 'custom',
			'crel_image_guide__description_typography_font_size' => [
				'size' => 16,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_image_guide__list_spot_text_typography_typography' => 'custom',
			'crel_image_guide__list_spot_text_typography_font_size' => [
				'size' => 16,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_image_guide__spot_label_typography_typography' => 'custom',
			'crel_image_guide__spot_label_typography_font_size'         => [
					'size'      => 20,
					'unit'      => 'px',
					'sizes'     => []
				],
		];
	}

	protected function get_config_rtl_defaults() {
		return [];
	}

	protected function get_presets_defaults() {
		return [
			// CONTENT TAB ===================================================================/

			'crel_image_guide__list_type'                               => 'crel-image-guide--lower-alpha',
			'crel_image_guide__spots' => [
				[
					'crel_image_guide__spot_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Id eu nisl nunc mi. ',
					'crel_image_guide__spot_X' =>  [
						'size' => '10',
						'unit' => '%',
						'sizes' => []
					],
					'crel_image_guide__spot_Y' =>  [
						'size' => '10',
						'unit' => '%',
						'sizes' => []
					],
					'crel_image_guide__spot_icon' =>  [],
				],
				[
					'crel_image_guide__spot_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Id eu nisl nunc mi. ',
					'crel_image_guide__spot_X' =>  [
						'size' => '30',
						'unit' => '%',
						'sizes' => []
					],
					'crel_image_guide__spot_Y' =>  [
						'size' => '30',
						'unit' => '%',
						'sizes' => []
					],
					'crel_image_guide__spot_icon' =>  [],
				],
				[
					'crel_image_guide__spot_text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Id eu nisl nunc mi. ',
					'crel_image_guide__spot_X' =>  [
						'size' => '70',
						'unit' => '%',
						'sizes' => []
					],
					'crel_image_guide__spot_Y' =>  [
						'size' => '70',
						'unit' => '%',
						'sizes' => []
					],
					'crel_image_guide__spot_icon' =>  [],
				]
			],

			// STYLE TAB =====================================================================/

			// General -------------------------------------------------------------------/
			'crel_image_guide__rows_spacing'                            => [
				'size' => '0',
				'unit' => 'px',
				'sizes' => []
			],

			// Image ---------------------------------------------------------------------/
			'crel_image_guide__image_padding'                           => [
				'top'       => '0',
				'left'      => '0',
				'right'     => '0',
				'bottom'    => '0',
				'unit'      => 'px'
			],
			'crel_image_guide__image_border_border'                     => 'solid',
			'crel_image_guide__image_border_width'                      => [
				'top'       => '1',
				'right'     => '1',
				'bottom'    => '1',
				'left'      => '1',
				'isLinked'  => false,
				'unit'      => 'px'
			],
			'crel_image_guide__image_border_color'                      => '#020101',
			'crel_image_guide__image_border_radius'                     => [
				'top'       => '0',
				'left'      => '0',
				'right'     => '0',
				'bottom'    => '0',
				'unit'      => 'px'
			],
			'crel_image_guide__image_box_shadow_box_shadow_type'        => [
				'box_shadow_type' => [
					'default' => 'no',
				],
			],
			'crel_image_guide__image_box_shadow_box_shadow'             => [
				'horizontal' => 0,
				'vertical' => 0,
				'blur' => 0,
				'spread' => 0,
				'color' => '',
			],

			// Image Caption -------------------------------------------------------------/
			'crel_image_guide__caption_Typography_font_size'            => [
				'size'      => '16',
				'unit'      => 'px',
				'sizes'     => []
			],
			'crel_image_guide__caption_Typography_font_style'           => '',
			'crel_image_guide__image_caption_text_color'                => '#020101',
			'crel_image_guide__image_caption_bg_color'                  => '#ffffff',
			'crel_image_guide__image_caption_padding'                   => [
				'top'       => '0',
				'left'      => '0',
				'right'     => '0',
				'bottom'    => '0',
				'unit'      => 'px'
			],
			'crel_image_guide__image_caption_margin'                    => [
				'top'       => '0',
				'left'      => '0',
				'right'     => '0',
				'bottom'    => '0',
				'unit'      => 'px'
			],
			'crel_image_guide__image_caption_border_radius'             => [
				'top'       => '0',
				'left'      => '0',
				'right'     => '0',
				'bottom'    => '0',
				'unit'      => 'px'
			],

			// Spots ---------------------------------------------------------------------/
			'crel_image_guide__spot_width'                              => [
				'size' => '44',
				'unit' => 'px',
				'sizes' => []
			],
			'crel_image_guide__spot_height'                             => [
				'size' => '44',
				'unit' => 'px',
				'sizes' => []
			],
			'crel_image_guide__spot_padding'                            => [
				'top' => '0',
				'left' => '0',
				'right' => '0',
				'bottom' => '0',
				'unit' => 'px'
			],
			'crel_image_guide__spot_pulse_toggle'                       => 'yes',
			'crel_image_guide__spot_bg_color'                           => '#FCE205',
			'crel_image_guide__spot_box_shadow_box_shadow_type'         => [
				'box_shadow_type' => [
					'default' => 'no',
				],
			],
			'crel_image_guide__spot_box_shadow_box_shadow'              => [
				'horizontal'    => 0,
				'vertical'      => 0,
				'blur'          => 10,
				'spread'        => 0,
				'color'         => '#000000',
			],
			'crel_image_guide__spot_hover_bg_color'                     => '#00a9ff',
			'crel_image_guide__spot_hover_box_shadow'                   => '',
			'crel_image_guide__spot_font_size'                          => [
				'size' => '20',
				'unit' => 'px',
				'sizes' => []
			],
			'crel_image_guide__spot_label_typography_font_size'         => [
				'size'      => '20',
				'unit'      => 'px',
				'sizes'     => []
			],
			'crel_image_guide__spot_text_color'                         => '#000000',
			'crel_image_guide__spot_hover_text_color'                   => '#ffffff',
			'crel_image_guide__spot_hover_border_color'                 => '#ffffff',
			'crel_image_guide__spot_border_border'                      => 'solid',
			'crel_image_guide__spot_border_color'                       => '#ffffff',
			'crel_image_guide__spot_border_width'                       => [
				'top'       => '2',
				'left'      => '2',
				'right'     => '2',
				'bottom'    => '2',
				'unit'      => 'px',
				'isLinked'  => false
			],
			'crel_image_guide__spot_border_radius'                      => [
				'top'       => '30',
				'left'      => '30',
				'right'     => '30',
				'bottom'    => '30',
				'unit'      => 'px'
			],

			// Description  --------------------------------------------------------------/
			'crel_image_guide__description_typography_typography'       => 'custom',
			'crel_image_guide__description_typography_line_height'      => [
				'size' => '',
				'unit' => 'em',
				'sizes' => []
			],
			'crel_image_guide__description_color'                       => '#020101',
			'crel_image_guide__description_typography_font_size'        => [
				'size'      => '16',
				'unit'      => 'px',
				'sizes'     => []
			],
			'crel_image_guide__description_margin'                      => [
				'top'       => '0',
				'left'      => '10',
				'right'     => '10',
				'bottom'    => '10',
				'unit'      => 'px',
				'isLinked' => false
			],

			// List container  -----------------------------------------------------------/
			'crel_image_guide__list_bgColor'                            => '#FFFFFF',
			'crel_image_guide__list_padding'                            => [
				'top'       => '10',
				'left'      => '10',
				'right'     => '10',
				'bottom'    => '10',
				'unit'      => 'px'
			],
			'crel_image_guide__list_margin'                             => [
				'top'       => '0',
				'left'      => '10',
				'right'     => '10',
				'bottom'    => '10',
				'unit'      => 'px',
				'isLinked' => false
			],

			// List Icon  ----------------------------------------------------------------/
			'crel_image_guide__list_spot_toggle'                        => 'yes',

			// Container
			'crel_image_guide__list_spot_width'                         => [
				'size' => '35',
				'unit' => 'px',
				'sizes' => []
			],
			'crel_image_guide__list_spot_height'                        => [
				'size' => '34',
				'unit' => 'px',
				'sizes' => []
			],
			'crel_image_guide__list_spot_padding'                       => [
				'top' => '0',
				'left' => '0',
				'right' => '0',
				'bottom' => '0',
				'unit' => 'px'
			],
			'crel_image_guide__list_spot_margin'                        => [
				'top' => '0',
				'left' => is_rtl() ? '10' : '0',
				'right' => is_rtl() ? '0' : '10',
				'bottom' => '10',
				'unit' => 'px'
			],
			'crel_image_guide__list_spot_bg_color'                      => '#FCE205',
			'crel_image_guide__list_spot_hover_bg_color'                => '#00a9ff',
			'crel_image_guide__list_spot_box_shadow_shadow_type'        => [
				'box_shadow_type' => [
					'default' => 'no',
				],
			],
			'crel_image_guide__list_spot_box_shadow_box_shadow'         => [
				'horizontal' => 0,
				'vertical' => 0,
				'blur' => 0,
				'spread' => 0,
				'color' => '',
			],
			'crel_image_guide__list_spot_hover_box_shadow_shadow_type'  => [
				'box_shadow_type' => [
					'default' => 'no',
				],
			],
			'crel_image_guide__list_spot_hover_box_shadow_box_shadow'   => [
				'horizontal' => 0,
				'vertical' => 0,
				'blur' => 0,
				'spread' => 0,
				'color' => '',
			],

			// Icon
			'crel_image_guide__list_spot_font_size'                     => [
				'size' => '12',
				'unit' => 'px',
				'sizes' => []
			],
			'crel_image_guide__list_spot_prefix_typography_font_size'   => [
				'size' => '12',
				'unit' => 'px',
				'sizes' => []
			],
			'crel_image_guide__list_spot_text_color'                    => '#000000',
			'crel_image_guide__list_spot_hover_text_color'              => '#ffffff',

			// Border
			'crel_image_guide__list_spot_border_border'                 => 'solid',
			'crel_image_guide__list_spot_border_color'                  => '#ffffff',
			'crel_image_guide__list_spot_border_width'                  => [
				'top'       => '2',
				'left'      => '2',
				'right'     => '2',
				'bottom'    => '2',
				'unit'      => 'px',
				'isLinked'  => false
			],
			'crel_image_guide__list_spot_border_radius'                 => [
				'top'       => '50',
				'left'      => '50',
				'right'     => '50',
				'bottom'    => '50',
				'unit'      => 'px'
			],

			// List Text  ----------------------------------------------------------------/
			'crel_image_guide__list_spot_text_typography_typography'    => 'custom',
			'crel_image_guide__list_spot_text_typography_font_size'     => [
				'size' => '16',
				'unit' => 'px',
				'sizes' => []
			],
			'crel_image_guide__list_spot_text_typography_line_height'   => [
				'size' => '',
				'unit' => 'em',
				'sizes' => []
			],
			'crel_image_guide__list_text_color'                         => '#020101',
		];
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
			'title' => __( 'Design 1: Yellow, Alpha, Circles', 'creative-addons-for-elementor' ),
			'preview_url' => $this->preview_url( 'img-guide-design-1.jpg' ),
			'options' => array(


			)
		);

		$options['design-2'] = array(
			'title' => __( 'Design 2: White, Numbers, Circles', 'creative-addons-for-elementor' ),
			'preview_url' => $this->preview_url( 'img-guide-design-2.jpg' ),
			'options' => array(

				// CONTENT TAB ===================================================================/

				'crel_image_guide__list_type'                               => 'crel-image-guide--decimal',
				'crel_image_guide__spots' => [
					[
						'crel_image_guide__spot_icon' =>  [],
					],
					[
						'crel_image_guide__spot_icon' =>  [],
					],
					[
						'crel_image_guide__spot_icon' =>  [],
					],
				],

				// STYLE TAB =====================================================================/

				// General -------------------------------------------------------------------/
				'crel_image_guide__rows_spacing'                            => [
					'size' => '0',
					'unit' => 'px',
					'sizes' => []
				],

				// Image ---------------------------------------------------------------------/
				'crel_image_guide__image_padding'                           => [
					'top'       => '0',
					'left'      => '0',
					'right'     => '0',
					'bottom'    => '0',
					'unit'      => 'px'
				],
				'crel_image_guide__image_border_border'                     => 'solid',
				'crel_image_guide__image_border_width'                      => [
					'top'       => '1',
					'right'     => '1',
					'bottom'    => '1',
					'left'      => '1',
					'isLinked'  => false,
					'unit'      => 'px'
				],
				'crel_image_guide__image_border_color'                      => '#020101',
				'crel_image_guide__image_border_radius'                     => [
					'top'       => '0',
					'left'      => '0',
					'right'     => '0',
					'bottom'    => '0',
					'unit'      => 'px'
				],
				'crel_image_guide__image_box_shadow_box_shadow_type'        => [
					'box_shadow_type' => [
						'default' => 'no',
					],
				],
				'crel_image_guide__image_box_shadow_box_shadow'             => [
					'horizontal' => 0,
					'vertical' => 0,
					'blur' => 0,
					'spread' => 0,
					'color' => '',
				],

				// Image Caption -------------------------------------------------------------/
				'crel_image_guide__caption_Typography_font_size'            => [
					'size'      => '13',
					'unit'      => 'px',
					'sizes'     => []
				],
				'crel_image_guide__caption_Typography_font_style'           => 'italic',
				'crel_image_guide__image_caption_text_color'                => '#020101',
				'crel_image_guide__image_caption_bg_color'                  => '#ffffff',
				'crel_image_guide__image_caption_padding'                   => [
					'top'       => '0',
					'left'      => '0',
					'right'     => '0',
					'bottom'    => '0',
					'unit'      => 'px'
				],
				'crel_image_guide__image_caption_margin'                    => [
					'top'       => '0',
					'left'      => '0',
					'right'     => '0',
					'bottom'    => '0',
					'unit'      => 'px'
				],
				'crel_image_guide__image_caption_border_radius'             => [
					'top'       => '0',
					'left'      => '0',
					'right'     => '0',
					'bottom'    => '0',
					'unit'      => 'px'
				],

				// Spots ---------------------------------------------------------------------/
				'crel_image_guide__spot_width'                              => [
					'size' => '44',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_image_guide__spot_height'                             => [
					'size' => '44',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_image_guide__spot_padding'                            => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '0',
					'unit' => 'px'
				],
				'crel_image_guide__spot_pulse_toggle'                       => 'yes',
				'crel_image_guide__spot_bg_color'                           => '#FFFFFF',
				'crel_image_guide__spot_box_shadow_box_shadow_type'         => [
					'box_shadow_type' => [
						'default' => 'no',
					],
				],
				'crel_image_guide__spot_box_shadow_box_shadow'              => [
					'horizontal'    => 0,
					'vertical'      => 0,
					'blur'          => 10,
					'spread'        => 0,
					'color'         => '#000000',
				],
				'crel_image_guide__spot_hover_bg_color'                     => '#00a9ff',
				'crel_image_guide__spot_hover_box_shadow'                   => '',
				'crel_image_guide__spot_font_size'                          => [
					'size' => '20',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_image_guide__spot_label_typography_font_size'         => [
					'size'      => '20',
					'unit'      => 'px',
					'sizes'     => []
				],
				'crel_image_guide__spot_text_color'                         => '#000000',
				'crel_image_guide__spot_hover_text_color'                   => '#ffffff',
				'crel_image_guide__spot_hover_border_color'                 => '#ffffff',
				'crel_image_guide__spot_border_border'                      => 'solid',
				'crel_image_guide__spot_border_color'                       => '#ffffff',
				'crel_image_guide__spot_border_width'                       => [
					'top'       => '2',
					'left'      => '2',
					'right'     => '2',
					'bottom'    => '2',
					'unit'      => 'px',
					'isLinked'  => false
				],
				'crel_image_guide__spot_border_radius'                      => [
					'top'       => '30',
					'left'      => '30',
					'right'     => '30',
					'bottom'    => '30',
					'unit'      => 'px'
				],

				// Description  --------------------------------------------------------------/
				'crel_image_guide__description_color'                       => '#020101',
				'crel_image_guide__description_typography_font_size'        => [
					'size'      => '15',
					'unit'      => 'px',
					'sizes'     => []
				],
				'crel_image_guide__description_margin'                      => [
					'top'       => '0',
					'left'      => '10',
					'right'     => '10',
					'bottom'    => '10',
					'unit'      => 'px',
					'isLinked' => false
				],

				// List container  -----------------------------------------------------------/
				'crel_image_guide__list_bgColor'                            => '#F4F4F4',
				'crel_image_guide__list_padding'                            => [
					'top'       => '10',
					'left'      => '10',
					'right'     => '10',
					'bottom'    => '10',
					'unit'      => 'px'
				],
				'crel_image_guide__list_margin'                             => [
					'top'       => '0',
					'left'      => '10',
					'right'     => '10',
					'bottom'    => '10',
					'unit'      => 'px',
					'isLinked' => false
				],

				// List Icon  ----------------------------------------------------------------/
				'crel_image_guide__list_spot_toggle'                        => 'yes',

				// Container
				'crel_image_guide__list_spot_width'                         => [
					'size' => '35',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_image_guide__list_spot_height'                        => [
					'size' => '34',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_image_guide__list_spot_padding'                       => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '0',
					'unit' => 'px'
				],
				'crel_image_guide__list_spot_margin'                        => [
					'top' => '0',
					'left' => is_rtl() ? '10' : '0',
					'right' => is_rtl() ? '0' : '10',
					'bottom' => '10',
					'unit' => 'px'
				],
				'crel_image_guide__list_spot_bg_color'                      => '#FFFFFF',
				'crel_image_guide__list_spot_hover_bg_color'                => '#00a9ff',
				'crel_image_guide__list_spot_box_shadow_shadow_type'        => [
					'box_shadow_type' => [
						'default' => 'no',
					],
				],
				'crel_image_guide__list_spot_box_shadow_box_shadow'         => [
					'horizontal' => 0,
					'vertical' => 0,
					'blur' => 0,
					'spread' => 0,
					'color' => '',
				],
				'crel_image_guide__list_spot_hover_box_shadow_shadow_type'  => [
					'box_shadow_type' => [
						'default' => 'no',
					],
				],
				'crel_image_guide__list_spot_hover_box_shadow_box_shadow'   => [
					'horizontal' => 0,
					'vertical' => 0,
					'blur' => 0,
					'spread' => 0,
					'color' => '',
				],

				// Icon
				'crel_image_guide__list_spot_font_size'                     => [
					'size' => '12',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_image_guide__list_spot_prefix_typography_font_size'   => [
					'size' => '12',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_image_guide__list_spot_text_color'                    => '#000000',
				'crel_image_guide__list_spot_hover_text_color'              => '#ffffff',

				// Border
				'crel_image_guide__list_spot_border_border'                 => 'solid',
				'crel_image_guide__list_spot_border_color'                  => '#ffffff',
				'crel_image_guide__list_spot_border_width'                  => [
					'top'       => '2',
					'left'      => '2',
					'right'     => '2',
					'bottom'    => '2',
					'unit'      => 'px',
					'isLinked'  => false
				],
				'crel_image_guide__list_spot_border_radius'                 => [
					'top'       => '50',
					'left'      => '50',
					'right'     => '50',
					'bottom'    => '50',
					'unit'      => 'px'
				],

				// List Text  ----------------------------------------------------------------/
				'crel_image_guide__list_spot_text_typography_font_size'     => [
					'size' => '14',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_image_guide__list_text_color'                         => '#020101',


			)
		);

		$options['design-3'] = array(
			'title' => __( 'Design 3: White Grey, Numbers, Circles', 'creative-addons-for-elementor' ),
			'preview_url' => $this->preview_url( 'img-guide-design-3.jpg' ),
			'options' => array(

				// CONTENT TAB ===================================================================/

				'crel_image_guide__list_type'                               => 'crel-image-guide--decimal',
				'crel_image_guide__spots' => [
					[
						'crel_image_guide__spot_icon' =>  [],
					],
					[
						'crel_image_guide__spot_icon' =>  [],
					],
					[
						'crel_image_guide__spot_icon' =>  [],
					],
				],

				// STYLE TAB =====================================================================/

				// General -------------------------------------------------------------------/
				'crel_image_guide__rows_spacing'                            => [
					'size' => '0',
					'unit' => 'px',
					'sizes' => []
				],

				// Image ---------------------------------------------------------------------/
				'crel_image_guide__image_padding'                           => [
					'top'       => '0',
					'left'      => '0',
					'right'     => '0',
					'bottom'    => '0',
					'unit'      => 'px'
				],
				'crel_image_guide__image_border_border'                     => 'solid',
				'crel_image_guide__image_border_width'                      => [
					'top'       => '1',
					'right'     => '1',
					'bottom'    => '1',
					'left'      => '1',
					'isLinked'  => false,
					'unit'      => 'px'
				],
				'crel_image_guide__image_border_color'                      => '#020101',
				'crel_image_guide__image_border_radius'                     => [
					'top'       => '0',
					'left'      => '0',
					'right'     => '0',
					'bottom'    => '0',
					'unit'      => 'px'
				],
				'crel_image_guide__image_box_shadow_box_shadow_type'        => [
					'box_shadow_type' => [
						'default' => 'no',
					],
				],
				'crel_image_guide__image_box_shadow_box_shadow'             => [
					'horizontal' => 0,
					'vertical' => 0,
					'blur' => 0,
					'spread' => 0,
					'color' => '',
				],

				// Image Caption -------------------------------------------------------------/
				'crel_image_guide__caption_Typography_font_size'            => [
					'size'      => '13',
					'unit'      => 'px',
					'sizes'     => []
				],
				'crel_image_guide__caption_Typography_font_style'           => 'italic',
				'crel_image_guide__image_caption_text_color'                => '#020101',
				'crel_image_guide__image_caption_bg_color'                  => '#ffffff',
				'crel_image_guide__image_caption_padding'                   => [
					'top'       => '0',
					'left'      => '0',
					'right'     => '0',
					'bottom'    => '0',
					'unit'      => 'px'
				],
				'crel_image_guide__image_caption_margin'                    => [
					'top'       => '0',
					'left'      => '0',
					'right'     => '0',
					'bottom'    => '0',
					'unit'      => 'px'
				],
				'crel_image_guide__image_caption_border_radius'             => [
					'top'       => '0',
					'left'      => '0',
					'right'     => '0',
					'bottom'    => '0',
					'unit'      => 'px'
				],

				// Spots ---------------------------------------------------------------------/
				'crel_image_guide__spot_width'                              => [
					'size' => '50',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_image_guide__spot_height'                             => [
					'size' => '50',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_image_guide__spot_padding'                            => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '0',
					'unit' => 'px'
				],
				'crel_image_guide__spot_pulse_toggle'                       => 'yes',
				'crel_image_guide__spot_bg_color'                           => '#ffffff',
				'crel_image_guide__spot_box_shadow_box_shadow_type'         => [
					'box_shadow_type' => [
						'default' => 'no',
					],
				],
				'crel_image_guide__spot_box_shadow_box_shadow'              => [
					'horizontal'    => 0,
					'vertical'      => 0,
					'blur'          => 10,
					'spread'        => 0,
					'color'         => '#000000',
				],
				'crel_image_guide__spot_hover_bg_color'                     => '#00a9ff',
				'crel_image_guide__spot_hover_box_shadow'                   => '',
				'crel_image_guide__spot_font_size'                          => [
					'size' => '20',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_image_guide__spot_label_typography_font_size'         => [
					'size'      => '20',
					'unit'      => 'px',
					'sizes'     => []
				],
				'crel_image_guide__spot_text_color'                         => '#000000',
				'crel_image_guide__spot_hover_text_color'                   => '#ffffff',
				'crel_image_guide__spot_hover_border_color'                 => '#ffffff',
				'crel_image_guide__spot_border_border'                      => 'solid',
				'crel_image_guide__spot_border_color'                       => '#434343',
				'crel_image_guide__spot_border_width'                       => [
					'top'       => '4',
					'left'      => '4',
					'right'     => '4',
					'bottom'    => '4',
					'unit'      => 'px',
					'isLinked'  => false
				],
				'crel_image_guide__spot_border_radius'                      => [
					'top'       => '50',
					'left'      => '50',
					'right'     => '50',
					'bottom'    => '50',
					'unit'      => 'px'
				],

				// Description  --------------------------------------------------------------/
				'crel_image_guide__description_typography_typography'       => 'custom',
				'crel_image_guide__description_typography_line_height'      => [
					'size' => '1.5',
					'unit' => 'em',
					'sizes' => []
				],
				'crel_image_guide__description_color'                       => '#020101',
				'crel_image_guide__description_typography_font_size'        => [
					'size'      => '15',
					'unit'      => 'px',
					'sizes'     => []
				],
				'crel_image_guide__description_margin'                      => [
					'top'       => '0',
					'left'      => '10',
					'right'     => '10',
					'bottom'    => '10',
					'unit'      => 'px',
					'isLinked' => false
				],

				// List container  -----------------------------------------------------------/
				'crel_image_guide__list_bgColor'                            => '#FFFFFF',
				'crel_image_guide__list_padding'                            => [
					'top'       => '10',
					'left'      => '10',
					'right'     => '10',
					'bottom'    => '10',
					'unit'      => 'px'
				],
				'crel_image_guide__list_margin'                             => [
					'top'       => '0',
					'left'      => '10',
					'right'     => '10',
					'bottom'    => '10',
					'unit'      => 'px',
					'isLinked' => false
				],

				// List Icon  ----------------------------------------------------------------/
				'crel_image_guide__list_spot_toggle'                        => 'yes',

				// Container
				'crel_image_guide__list_spot_width'                         => [
					'size' => '35',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_image_guide__list_spot_height'                        => [
					'size' => '34',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_image_guide__list_spot_padding'                       => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '0',
					'unit' => 'px'
				],
				'crel_image_guide__list_spot_margin'                        => [
					'top' => '0',
					'left' => is_rtl() ? '10' : '0',
					'right' => is_rtl() ? '0' : '10',
					'bottom' => '10',
					'unit' => 'px'
				],
				'crel_image_guide__list_spot_bg_color'                      => '#ffffff',
				'crel_image_guide__list_spot_hover_bg_color'                => '#00a9ff',
				'crel_image_guide__list_spot_box_shadow_shadow_type'        => [
					'box_shadow_type' => [
						'default' => 'no',
					],
				],
				'crel_image_guide__list_spot_box_shadow_box_shadow'         => [
					'horizontal' => 0,
					'vertical' => 0,
					'blur' => 0,
					'spread' => 0,
					'color' => '',
				],
				'crel_image_guide__list_spot_hover_box_shadow_shadow_type'  => [
					'box_shadow_type' => [
						'default' => 'no',
					],
				],
				'crel_image_guide__list_spot_hover_box_shadow_box_shadow'   => [
					'horizontal' => 0,
					'vertical' => 0,
					'blur' => 0,
					'spread' => 0,
					'color' => '',
				],

				// Icon
				'crel_image_guide__list_spot_font_size'                     => [
					'size' => '12',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_image_guide__list_spot_prefix_typography_font_size'   => [
					'size' => '12',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_image_guide__list_spot_text_color'                    => '#000000',
				'crel_image_guide__list_spot_hover_text_color'              => '#ffffff',

				// Border
				'crel_image_guide__list_spot_border_border'                 => 'solid',
				'crel_image_guide__list_spot_border_color'                  => '#434343',
				'crel_image_guide__list_spot_border_width'                  => [
				'top'       => '2',
				'left'      => '2',
				'right'     => '2',
				'bottom'    => '2',
				'unit'      => 'px',
				'isLinked'  => false
			],
				'crel_image_guide__list_spot_border_radius'                 => [
				'top'       => '50',
				'left'      => '50',
				'right'     => '50',
				'bottom'    => '50',
				'unit'      => 'px'
			],

				// List Text  ----------------------------------------------------------------/
				'crel_image_guide__list_spot_text_typography_typography'    => 'custom',
				'crel_image_guide__list_spot_text_typography_font_size'     => [
					'size' => '14',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_image_guide__list_spot_text_typography_line_height'   => [
					'size' => '1.5',
					'unit' => 'em',
					'sizes' => []
				],
				'crel_image_guide__list_text_color'                         => '#020101',



			)
		);

		$options['design-4'] = array(
			'title' => __( 'Design 4: Green, Alpha, Pointers', 'creative-addons-for-elementor' ),
			'preview_url' => $this->preview_url( 'img-guide-design-4.jpg' ),
			'options' => array(




				// CONTENT TAB ===================================================================/

				'crel_image_guide__list_type'                               => 'crel-image-guide--upper-alpha',
				'crel_image_guide__spots' => [
					[
						'crel_image_guide__spot_icon' =>  [],
					],
					[
						'crel_image_guide__spot_icon' =>  [],
					],
					[
						'crel_image_guide__spot_icon' =>  [],
					],
				],

				// STYLE TAB =====================================================================/

				// General -------------------------------------------------------------------/
				'crel_image_guide__rows_spacing'                            => [
					'size' => '0',
					'unit' => 'px',
					'sizes' => []
				],

				// Image ---------------------------------------------------------------------/
				'crel_image_guide__image_padding'                           => [
					'top'       => '0',
					'left'      => '0',
					'right'     => '0',
					'bottom'    => '0',
					'unit'      => 'px'
				],
				'crel_image_guide__image_border_border'                     => 'solid',
				'crel_image_guide__image_border_width'                      => [
					'top'       => '1',
					'right'     => '1',
					'bottom'    => '1',
					'left'      => '1',
					'isLinked'  => false,
					'unit'      => 'px'
				],
				'crel_image_guide__image_border_color'                      => '#020101',
				'crel_image_guide__image_border_radius'                     => [
					'top'       => '0',
					'left'      => '0',
					'right'     => '0',
					'bottom'    => '0',
					'unit'      => 'px'
				],
				'crel_image_guide__image_box_shadow_box_shadow_type'        => [
					'box_shadow_type' => [
						'default' => 'no',
					],
				],
				'crel_image_guide__image_box_shadow_box_shadow'             => [
					'horizontal' => 0,
					'vertical' => 0,
					'blur' => 0,
					'spread' => 0,
					'color' => '',
				],

				// Image Caption -------------------------------------------------------------/
				'crel_image_guide__caption_Typography_font_size'            => [
					'size'      => '13',
					'unit'      => 'px',
					'sizes'     => []
				],
				'crel_image_guide__caption_Typography_font_style'           => 'italic',
				'crel_image_guide__image_caption_text_color'                => '#020101',
				'crel_image_guide__image_caption_bg_color'                  => '#ffffff',
				'crel_image_guide__image_caption_padding'                   => [
					'top'       => '0',
					'left'      => '0',
					'right'     => '0',
					'bottom'    => '0',
					'unit'      => 'px'
				],
				'crel_image_guide__image_caption_margin'                    => [
					'top'       => '0',
					'left'      => '0',
					'right'     => '0',
					'bottom'    => '0',
					'unit'      => 'px'
				],
				'crel_image_guide__image_caption_border_radius'             => [
					'top'       => '0',
					'left'      => '0',
					'right'     => '0',
					'bottom'    => '0',
					'unit'      => 'px'
				],

				// Spots ---------------------------------------------------------------------/
				'crel_image_guide__spot_width'                              => [
					'size' => '44',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_image_guide__spot_height'                             => [
					'size' => '44',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_image_guide__spot_padding'                            => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '0',
					'unit' => 'px'
				],
				'crel_image_guide__spot_pulse_toggle'                       => 'yes',
				'crel_image_guide__spot_bg_color'                           => '#88C807',
				'crel_image_guide__spot_box_shadow_box_shadow_type'         => [
					'box_shadow_type' => [
						'default' => 'no',
					],
				],
				'crel_image_guide__spot_box_shadow_box_shadow'              => [
					'horizontal'    => 0,
					'vertical'      => 0,
					'blur'          => 10,
					'spread'        => 0,
					'color'         => '#000000',
				],
				'crel_image_guide__spot_hover_bg_color'                     => '#00a9ff',
				'crel_image_guide__spot_hover_box_shadow'                   => '',
				'crel_image_guide__spot_font_size'                          => [
					'size' => '20',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_image_guide__spot_label_typography_font_size'         => [
					'size'      => '20',
					'unit'      => 'px',
					'sizes'     => []
				],
				'crel_image_guide__spot_text_color'                         => '#ffffff',
				'crel_image_guide__spot_hover_text_color'                   => '#ffffff',
				'crel_image_guide__spot_hover_border_color'                 => '#ffffff',
				'crel_image_guide__spot_border_border'                      => 'solid',
				'crel_image_guide__spot_border_color'                       => '#ffffff',
				'crel_image_guide__spot_border_width'                       => [
					'top'       => '2',
					'left'      => '2',
					'right'     => '2',
					'bottom'    => '2',
					'unit'      => 'px',
					'isLinked'  => false
				],
				'crel_image_guide__spot_border_radius'                      => [
					'top'       => '30',
					'left'      => is_rtl() ? '0' : '30',
					'right'     => '30',
					'bottom'    => is_rtl() ? '30' : '0',
					'unit'      => 'px'
				],

				// Description  --------------------------------------------------------------/
				'crel_image_guide__description_color'                       => '#020101',
				'crel_image_guide__description_typography_font_size'        => [
					'size'      => '15',
					'unit'      => 'px',
					'sizes'     => []
				],
				'crel_image_guide__description_margin'                      => [
					'top'       => '0',
					'left'      => '10',
					'right'     => '10',
					'bottom'    => '10',
					'unit'      => 'px',
					'isLinked' => false
				],

				// List container  -----------------------------------------------------------/
				'crel_image_guide__list_bgColor'                            => '#FFFFFF',
				'crel_image_guide__list_padding'                            => [
					'top'       => '0',
					'left'      => '0',
					'right'     => '0',
					'bottom'    => '0',
					'unit'      => 'px'
				],
				'crel_image_guide__list_margin'                             => [
					'top'       => '0',
					'left'      => '10',
					'right'     => '10',
					'bottom'    => '10',
					'unit'      => 'px',
					'isLinked' => false
				],

				// List Icon  ----------------------------------------------------------------/
				'crel_image_guide__list_spot_toggle'                        => 'yes',

				// Container
				'crel_image_guide__list_spot_width'                         => [
					'size' => '35',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_image_guide__list_spot_height'                        => [
					'size' => '34',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_image_guide__list_spot_padding'                       => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '0',
					'unit' => 'px'
				],
				'crel_image_guide__list_spot_margin'                        => [
					'top' => '0',
					'left' => is_rtl() ? '10' : '0',
					'right' => is_rtl() ? '0' : '10',
					'bottom' => '10',
					'unit' => 'px'
				],
				'crel_image_guide__list_spot_bg_color'                      => '#88C807',
				'crel_image_guide__list_spot_hover_bg_color'                => '#00a9ff',
				'crel_image_guide__list_spot_box_shadow_shadow_type'        => [
					'box_shadow_type' => [
						'default' => 'no',
					],
				],
				'crel_image_guide__list_spot_box_shadow_box_shadow'         => [
					'horizontal' => 0,
					'vertical' => 0,
					'blur' => 0,
					'spread' => 0,
					'color' => '',
				],
				'crel_image_guide__list_spot_hover_box_shadow_shadow_type'  => [
					'box_shadow_type' => [
						'default' => 'no',
					],
				],
				'crel_image_guide__list_spot_hover_box_shadow_box_shadow'   => [
					'horizontal' => 0,
					'vertical' => 0,
					'blur' => 0,
					'spread' => 0,
					'color' => '',
				],

				// Icon
				'crel_image_guide__list_spot_font_size'                     => [
					'size' => '12',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_image_guide__list_spot_prefix_typography_font_size'   => [
					'size' => '12',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_image_guide__list_spot_text_color'                    => '#ffffff',
				'crel_image_guide__list_spot_hover_text_color'              => '#ffffff',

				// Border
				'crel_image_guide__list_spot_border_border'                 => 'solid',
				'crel_image_guide__list_spot_border_color'                  => '#ffffff',
				'crel_image_guide__list_spot_border_width'                  => [
					'top'       => '2',
					'left'      => '2',
					'right'     => '2',
					'bottom'    => '2',
					'unit'      => 'px',
					'isLinked'  => false
				],
				'crel_image_guide__list_spot_border_radius'                 => [
					'top'       => '50',
					'left'      => '50',
					'right'     => '50',
					'bottom'    => '50',
					'unit'      => 'px'
				],

				// List Text  ----------------------------------------------------------------/
				'crel_image_guide__list_spot_text_typography_font_size'     => [
					'size' => '14',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_image_guide__list_text_color'                         => '#020101',


			)
		);

		$options['design-5'] = array(
			'title' => __( 'Design 5: White Purple, Mix icons, Circles', 'creative-addons-for-elementor' ),
			'preview_url' => $this->preview_url( 'img-guide-design-5.jpg' ),
			'options' => array(

				// CONTENT TAB ===================================================================/

				'crel_image_guide__list_type'                               => 'crel-image-guide--icons',
				'crel_image_guide__spots' => [
				[
					'crel_image_guide__spot_icon' =>  [
						'value' => 'fas fa-info',
						'library' => 'fa-solid',
					],
				],
				[
					'crel_image_guide__spot_icon' =>  [
						'value' => 'fas fa-plus',
						'library' => 'fa-solid',
					],
				],
				[
					'crel_image_guide__spot_icon' =>  [
						'value' => 'fas fa-lock',
						'library' => 'fa-solid',
					],
				]
			],

				// STYLE TAB =====================================================================/

				// General -------------------------------------------------------------------/
				'crel_image_guide__rows_spacing'                            => [
					'size' => '0',
					'unit' => 'px',
					'sizes' => []
				],

				// Image ---------------------------------------------------------------------/
				'crel_image_guide__image_padding'                           => [
					'top'       => '0',
					'left'      => '0',
					'right'     => '0',
					'bottom'    => '0',
					'unit'      => 'px'
				],
				'crel_image_guide__image_border_border'                     => 'solid',
				'crel_image_guide__image_border_width'                      => [
					'top'       => '1',
					'right'     => '1',
					'bottom'    => '1',
					'left'      => '1',
					'isLinked'  => false,
					'unit'      => 'px'
				],
				'crel_image_guide__image_border_color'                      => '#020101',
				'crel_image_guide__image_border_radius'                     => [
					'top'       => '0',
					'left'      => '0',
					'right'     => '0',
					'bottom'    => '0',
					'unit'      => 'px'
				],
				'crel_image_guide__image_box_shadow_box_shadow_type'        => [
					'box_shadow_type' => [
						'default' => 'no',
					],
				],
				'crel_image_guide__image_box_shadow_box_shadow'             => [
					'horizontal' => 0,
					'vertical' => 0,
					'blur' => 0,
					'spread' => 0,
					'color' => '',
				],

				// Image Caption -------------------------------------------------------------/
				'crel_image_guide__caption_Typography_font_size'            => [
					'size'      => '13',
					'unit'      => 'px',
					'sizes'     => []
				],
				'crel_image_guide__caption_Typography_font_style'           => 'italic',
				'crel_image_guide__image_caption_text_color'                => '#020101',
				'crel_image_guide__image_caption_bg_color'                  => '#ffffff',
				'crel_image_guide__image_caption_padding'                   => [
					'top'       => '0',
					'left'      => '0',
					'right'     => '0',
					'bottom'    => '0',
					'unit'      => 'px'
				],
				'crel_image_guide__image_caption_margin'                    => [
					'top'       => '0',
					'left'      => '0',
					'right'     => '0',
					'bottom'    => '0',
					'unit'      => 'px'
				],
				'crel_image_guide__image_caption_border_radius'             => [
					'top'       => '0',
					'left'      => '0',
					'right'     => '0',
					'bottom'    => '0',
					'unit'      => 'px'
				],

				// Spots ---------------------------------------------------------------------/
				'crel_image_guide__spot_width'                              => [
					'size' => '44',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_image_guide__spot_height'                             => [
					'size' => '44',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_image_guide__spot_padding'                            => [
					'top' => '4',
					'left' => '4',
					'right' => '4',
					'bottom' => '4',
					'unit' => 'px'
				],
				'crel_image_guide__spot_pulse_toggle'                       => 'yes',
				'crel_image_guide__spot_bg_color'                           => '#FCE6FF',
				'crel_image_guide__spot_box_shadow_box_shadow_type'         => [
					'box_shadow_type' => [
						'default' => 'no',
					],
				],
				'crel_image_guide__spot_box_shadow_box_shadow'              => [
					'horizontal'    => 0,
					'vertical'      => 0,
					'blur'          => 10,
					'spread'        => 0,
					'color'         => '#000000',
				],
				'crel_image_guide__spot_hover_bg_color'                     => '#00a9ff',
				'crel_image_guide__spot_hover_box_shadow'                   => '',
				'crel_image_guide__spot_font_size'                          => [
					'size' => '20',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_image_guide__spot_label_typography_font_size'         => [
					'size'      => '20',
					'unit'      => 'px',
					'sizes'     => []
				],
				'crel_image_guide__spot_text_color'                         => '#000000',
				'crel_image_guide__spot_hover_text_color'                   => '#ffffff',
				'crel_image_guide__spot_hover_border_color'                 => '#ffffff',
				'crel_image_guide__spot_border_border'                      => 'double',
				'crel_image_guide__spot_border_color'                       => '#A307DF',
				'crel_image_guide__spot_border_width'                       => [
					'top'       => '4',
					'left'      => '4',
					'right'     => '4',
					'bottom'    => '4',
					'unit'      => 'px',
					'isLinked'  => false
				],
				'crel_image_guide__spot_border_radius'                      => [
					'top'       => '30',
					'left'      => '30',
					'right'     => '30',
					'bottom'    => '30',
					'unit'      => 'px'
				],

				// Description  --------------------------------------------------------------/
				'crel_image_guide__description_color'                       => '#020101',
				'crel_image_guide__description_typography_font_size'        => [
					'size'      => '15',
					'unit'      => 'px',
					'sizes'     => []
				],
				'crel_image_guide__description_margin'                      => [
					'top'       => '0',
					'left'      => '10',
					'right'     => '10',
					'bottom'    => '10',
					'unit'      => 'px',
					'isLinked' => false
				],

				// List container  -----------------------------------------------------------/
				'crel_image_guide__list_bgColor'                            => '#F4F4F4',
				'crel_image_guide__list_padding'                            => [
					'top'       => '10',
					'left'      => '10',
					'right'     => '10',
					'bottom'    => '10',
					'unit'      => 'px'
				],
				'crel_image_guide__list_margin'                             => [
					'top'       => '10',
					'left'      => '10',
					'right'     => '10',
					'bottom'    => '10',
					'unit'      => 'px',
					'isLinked' => false
				],

				// List Icon  ----------------------------------------------------------------/
				'crel_image_guide__list_spot_toggle'                        => 'yes',

				// Container
				'crel_image_guide__list_spot_width'                         => [
					'size' => '35',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_image_guide__list_spot_height'                        => [
					'size' => '34',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_image_guide__list_spot_padding'                       => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '0',
					'unit' => 'px'
				],
				'crel_image_guide__list_spot_margin'                        => [
					'top' => '0',
					'left' => is_rtl() ? '10' : '0',
					'right' => is_rtl() ? '0' : '10',
					'bottom' => '10',
					'unit' => 'px'
				],
				'crel_image_guide__list_spot_bg_color'                      => '#FFFFFF',
				'crel_image_guide__list_spot_hover_bg_color'                => '#00a9ff',
				'crel_image_guide__list_spot_box_shadow_shadow_type'        => [
					'box_shadow_type' => [
						'default' => 'no',
					],
				],
				'crel_image_guide__list_spot_box_shadow_box_shadow'         => [
					'horizontal' => 0,
					'vertical' => 0,
					'blur' => 0,
					'spread' => 0,
					'color' => '',
				],
				'crel_image_guide__list_spot_hover_box_shadow_shadow_type'  => [
					'box_shadow_type' => [
						'default' => 'no',
					],
				],
				'crel_image_guide__list_spot_hover_box_shadow_box_shadow'   => [
					'horizontal' => 0,
					'vertical' => 0,
					'blur' => 0,
					'spread' => 0,
					'color' => '',
				],

				// Icon
				'crel_image_guide__list_spot_font_size'                     => [
					'size' => '12',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_image_guide__list_spot_prefix_typography_font_size'   => [
					'size' => '12',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_image_guide__list_spot_text_color'                    => '#000000',
				'crel_image_guide__list_spot_hover_text_color'              => '#ffffff',

				// Border
				'crel_image_guide__list_spot_border_border'                 => 'solid',
				'crel_image_guide__list_spot_border_color'                  => '#A307DF',
				'crel_image_guide__list_spot_border_width'                  => [
					'top'       => '2',
					'left'      => '2',
					'right'     => '2',
					'bottom'    => '2',
					'unit'      => 'px',
					'isLinked'  => false
				],
				'crel_image_guide__list_spot_border_radius'                 => [
					'top'       => '50',
					'left'      => '50',
					'right'     => '50',
					'bottom'    => '50',
					'unit'      => 'px'
				],

				// List Text  ----------------------------------------------------------------/
				'crel_image_guide__list_spot_text_typography_font_size'     => [
					'size' => '14',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_image_guide__list_text_color'                         => '#020101',


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
			'crel_image_guide_section_layout',
			[
				'label' => __( 'Layout', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		
			// Layout Type
			$this->add_control_responsive(
				'crel_image_guide__layout_type',
				[
					'label'     => __( 'Layout Type', 'creative-addons-for-elementor' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						'column'   => __( 'Image above text', 'creative-addons-for-elementor' ),
						'row-reverse' => is_rtl() ? __( 'Image left of text', 'creative-addons-for-elementor' ) : __( 'Image right of text', 'creative-addons-for-elementor' ),
						'column-reverse' => __( 'Image below of text', 'creative-addons-for-elementor' ),
						'row'  => is_rtl() ? __( 'Image right of text', 'creative-addons-for-elementor' ) : __( 'Image left of text', 'creative-addons-for-elementor' ),
					],
					'selectors' => [
						'{{WRAPPER}} .crel-image-guide__container' => 'flex-direction: {{VALUE}};',
					],
				]
			);
			
			/* Fake control to trigger view update, hidden in styles  */
			$this->add_control(
				'crel_image_guide__layout_type_trigger',
				[
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						'1'   => '1',
					],
				]
			);
			
			// Sides Width Ratio (width of the blocks)
			$this->add_control(
				'crel_image_guide__ratio',
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
						'crel_image_guide__layout_type'	=> ['row-reverse', 'row']
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
			'crel_image_guide_image_section',
			[
				'label' => __( 'Image', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		
			// Image
			$this->add_control(
				'crel_image_guide__image',
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
			
			if ( is_rtl() ) {
				// Alignment
				$this->add_control_responsive(
					'crel_image_guide__image_align',
					[
						'label' => __( 'Alignment', 'creative-addons-for-elementor' ),
						'type' => Controls_Manager::CHOOSE,
						'options' => [
							'right' => [
								'title' => __( 'Right', 'creative-addons-for-elementor' ),
								'icon' => 'eicon-text-align-right',
							],
							'center' => [
								'title' => __( 'Center', 'creative-addons-for-elementor' ),
								'icon' => 'eicon-text-align-center',
							],
							'left' => [
								'title' => __( 'Left', 'creative-addons-for-elementor' ),
								'icon' => 'eicon-text-align-left',
							],
						],
						'selectors' => [
							'{{WRAPPER}} .crel-image-guide__image' => 'text-align: {{VALUE}};',
						],
					]
				);
			} else {
				// Alignment
				$this->add_control_responsive(
					'crel_image_guide__image_align',
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
							'{{WRAPPER}} .crel-image-guide__image' => 'text-align: {{VALUE}};',
						],
					]
				);
			}
			

			// Image Custom Caption
			$this->add_control(
				'crel_image_guide__caption_text',
				[
					'label' => __( 'Caption', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::TEXT,
					'placeholder' => __( 'Enter your image caption', 'creative-addons-for-elementor' ),
				]
			);
		
		$this->end_controls_section();
		
		// DESCRIPTION --------------------------------------------------[SECTION]-------------/
		$this->start_controls_section(
			'crel_image_guide_text_section',
			[
				'label' => __( 'Description', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

			// Description position inside text block
			$this->add_control(
				'crel_image_guide__description_position',
				[
					'label'     => __( 'Description Position', 'creative-addons-for-elementor' ),
					'type'      => Controls_Manager::SELECT,
					'options'   => [
						'description-top'   => __( 'Description above spots', 'creative-addons-for-elementor' ),
						'description-bottom' => __( 'Description below spots', 'creative-addons-for-elementor' ),
					],
				]
			);
		
			// Text
			$this->add_control(
				'crel_image_guide__description',
				[
					'label'         => __( 'Description', 'creative-addons-for-elementor'),
					'type'          => Controls_Manager::WYSIWYG,
					'label_block'   => true,
				]
			);
		
		$this->end_controls_section();

		// SPOTS --------------------------------------------------------[SECTION]-------------/
		$this->start_controls_section(
			'crel_image_guide_spots_section',
			[
				'label' => __( 'Spots', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);

		   // List Type
		   $this->add_control(
			   'crel_image_guide__list_type',
			   [
				   'label'       	=> __( 'Spots Type', 'creative-addons-for-elementor'),
				   'type' 			=> Controls_Manager::SELECT,
				   'label_block' 	=> false,
				   'force_preset' => true,
				   'options' 		=> [
					   'crel-image-guide--decimal'  	               => __( 'Decimal ', 'creative-addons-for-elementor'),
					   'crel-image-guide--lower-alpha' 	            => __( 'Lower Alpha', 'creative-addons-for-elementor'),
					   'crel-image-guide--icons' 	                  => __( 'Icons', 'creative-addons-for-elementor'),
					   'crel-image-guide--decimal-leading-zero' 	   => __( 'Decimal Leading Zero', 'creative-addons-for-elementor'),
					   'crel-image-guide--upper-alpha' 	            => __( 'Upper Alpha', 'creative-addons-for-elementor'),
					   'crel-image-guide--lower-roman' 	            => __( 'Lower Roman', 'creative-addons-for-elementor'),
					   'crel-image-guide--lower-greek' 	            => __( 'Lower Greek', 'creative-addons-for-elementor'),
					   'crel-image-guide--armenian' 	               => __( 'Armenian', 'creative-addons-for-elementor'),
					   'crel-image-guide--georgian' 	               => __( 'Georgian', 'creative-addons-for-elementor'),
				   ],
			   ]
		   );

			$repeater = new Repeater();
			
			$repeater->start_controls_tabs(
				'spots_tabs'
			);


				// Text Tab -----------------------------------/
				$repeater->start_controls_tab(
					'text_tab',
					[
						'label' => __( 'List Text', 'creative-addons-for-elementor' ),
					]
				);

				// Desc text
				$repeater->add_control(
					'crel_image_guide__spot_text',
					[
						'label_block'   => true,
						'type'          => Controls_Manager::WYSIWYG,
						'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Culpa enim esse excepturi nemo nesciunt officia officiis optio.', 'creative-addons-for-elementor' ) ,
					]
				);

				$repeater->end_controls_tab();


				// Icon Tab -----------------------------------/
				$repeater->start_controls_tab(
					'icon_tab',
					[
						'label' => __( 'Icon', 'creative-addons-for-elementor' ),
					]
				);

					// Icon
					$repeater->add_control(
						'crel_image_guide__spot_icon',
						[
							'type' => Controls_Manager::ICONS,
							'skin' => 'media',
							'force_preset' => true,
							'default' => [
								'value' => 'fas fa-info',
								'library' => 'fa-solid',
							],
						]
					);

					// X Position
					$repeater->add_responsive_control(
						'crel_image_guide__spot_X',
						[
							'label' => __( 'X Position', 'creative-addons-for-elementor'),
							'type' => Controls_Manager::SLIDER,
							'range' => [
								'%' => [
									'min' => 0,
									'max' => 100,
									'step' => 1,
								]
							],
							'default' => [
								'size' => '50',
								'unit' => '%',
								'sizes' => []
							],
							'selectors' => [
								'{{WRAPPER}} {{CURRENT_ITEM}}' => 'left: {{SIZE}}{{UNIT}};',
							],
						]
					);

					// Y Position
					$repeater->add_responsive_control(
						'crel_image_guide__spot_Y',
						[
							'label' => __( 'Y Position', 'creative-addons-for-elementor'),
							'type' => Controls_Manager::SLIDER,
							'range' => [
								'px' => [
									'min' => 0,
									'max' => 100,
									'step' => 1,
								]
							],
							'default' => [
								'size' => '50',
								'unit' => '%',
								'sizes' => []
							],
							'selectors' => [
								'{{WRAPPER}} {{CURRENT_ITEM}}' => 'top: {{SIZE}}{{UNIT}};',
							],
						]
					);
				
				$repeater->end_controls_tab();



				
			$repeater->end_controls_tabs();
			
			$this->add_control(
				'crel_image_guide__spots',
				[
					'label'     => __( 'Spots', 'creative-addons-for-elementor' ),
					'type'      => Controls_Manager::REPEATER,
					'fields'    => $repeater->get_controls(),
				]
			);

		$this->end_controls_section();
	}

	/**
	 * STYLE tab for this widget
	 */
	protected function register_style_controls() {

		// STYLE ===================================[ TAB ]====================================/

		// GENERAL --------------------------------------------------[SECTION]-------------/
		$this->start_controls_section(
			'crel_image_guide__general_section_style',
				[
					'label' => __( 'General', 'creative-addons-for-elementor' ),
					'tab' => Controls_Manager::TAB_STYLE
				]
			);
			
			// Space between Rows
			$this->add_control_responsive(
				'crel_image_guide__rows_spacing',
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
						
						'{{WRAPPER}} .crel-column .crel-image-guide__image'    => 'padding-bottom: calc({{SIZE}}px / 2);',
						'{{WRAPPER}} .crel-column .crel-image-guide__text'    => 'padding-top: calc({{SIZE}}px / 2);',
						
						'{{WRAPPER}} .crel-column-reverse .crel-image-guide__image'    => 'padding-top: calc({{SIZE}}px / 2);',
						'{{WRAPPER}} .crel-column-reverse .crel-image-guide__text'    => 'padding-bottom: calc({{SIZE}}px / 2);',
						
						'{{WRAPPER}} .crel-row-reverse .crel-image-guide__image'    => is_rtl() ? 'padding-right: calc({{SIZE}}px / 2);' : 'padding-left: calc({{SIZE}}px / 2);',
						'{{WRAPPER}} .crel-row-reverse .crel-image-guide__text'    => is_rtl() ? 'padding-left: calc({{SIZE}}px / 2);' : 'padding-right: calc({{SIZE}}px / 2);',
						
						'{{WRAPPER}} .crel-row .crel-image-guide__image'    => is_rtl() ? 'padding-left: calc({{SIZE}}px / 2);' : 'padding-right: calc({{SIZE}}px / 2);',
						'{{WRAPPER}} .crel-row .crel-image-guide__text'    => is_rtl() ? 'padding-right: calc({{SIZE}}px / 2);' : 'padding-left: calc({{SIZE}}px / 2);',
						
						'(tablet)
						{{WRAPPER}} .crel-column .crel-image-guide__image, 
						{{WRAPPER}} .crel-column .crel-image-guide__text,
						{{WRAPPER}} .crel-column-reverse .crel-image-guide__image, 
						{{WRAPPER}} .crel-column-reverse .crel-image-guide__text,
						{{WRAPPER}} .crel-row .crel-image-guide__image, 
						{{WRAPPER}} .crel-row .crel-image-guide__text,
						{{WRAPPER}} .crel-row-reverse .crel-image-guide__image, 
						{{WRAPPER}} .crel-row-reverse .crel-image-guide__text,
						
						{{WRAPPER}} .crel-tablet-column .crel-image-guide__image, 
						{{WRAPPER}} .crel-tablet-column .crel-image-guide__text,
						{{WRAPPER}} .crel-tablet-column-reverse .crel-image-guide__image, 
						{{WRAPPER}} .crel-tablet-column-reverse .crel-image-guide__text,
						{{WRAPPER}} .crel-tablet-row-reverse .crel-image-guide__image, 
						{{WRAPPER}} .crel-tablet-row-reverse .crel-image-guide__text,
						{{WRAPPER}} .crel-tablet-row-reverse .crel-image-guide__image, 
						{{WRAPPER}} .crel-tablet-row-reverse .crel-image-guide__text'    => 'padding: 0!important;',
						
						'(tablet){{WRAPPER}} .crel-tablet-column .crel-image-guide__image'    => 'padding-bottom: calc({{SIZE}}px / 2)!important;',
						'(tablet){{WRAPPER}} .crel-tablet-column .crel-image-guide__text'    => 'padding-top: calc({{SIZE}}px / 2)!important;',
						
						'(tablet){{WRAPPER}} .crel-tablet-column-reverse .crel-image-guide__image'    => 'padding-top: calc({{SIZE}}px / 2)!important;',
						'(tablet){{WRAPPER}} .crel-tablet-column-reverse .crel-image-guide__text'    => 'padding-bottom: calc({{SIZE}}px / 2)!important;',
						
						'(tablet){{WRAPPER}} .crel-tablet-row-reverse .crel-image-guide__image'    => is_rtl() ? 'padding-right: calc({{SIZE}}px / 2)!important;' : 'padding-left: calc({{SIZE}}px / 2)!important;',
						'(tablet){{WRAPPER}} .crel-tablet-row-reverse .crel-image-guide__text'    => is_rtl() ? 'padding-left: calc({{SIZE}}px / 2)!important;' : 'padding-right: calc({{SIZE}}px / 2)!important;',
						
						'(tablet){{WRAPPER}} .crel-tablet-row .crel-image-guide__image'    => is_rtl() ? 'padding-left: calc({{SIZE}}px / 2)!important;' : 'padding-right: calc({{SIZE}}px / 2)!important;',
						'(tablet){{WRAPPER}} .crel-tablet-row .crel-image-guide__text'    => is_rtl() ? 'padding-right: calc({{SIZE}}px / 2)!important;' : 'padding-left: calc({{SIZE}}px / 2)!important;',
						
						'(mobile)
						{{WRAPPER}} .crel-column .crel-image-guide__image, 
						{{WRAPPER}} .crel-column .crel-image-guide__text,
						{{WRAPPER}} .crel-column-reverse .crel-image-guide__image, 
						{{WRAPPER}} .crel-column-reverse .crel-image-guide__text,
						{{WRAPPER}} .crel-row .crel-image-guide__image, 
						{{WRAPPER}} .crel-row .crel-image-guide__text,
						{{WRAPPER}} .crel-row-reverse .crel-image-guide__image, 
						{{WRAPPER}} .crel-row-reverse .crel-image-guide__text,
						{{WRAPPER}} .crel-tablet-column .crel-image-guide__image, 
						{{WRAPPER}} .crel-tablet-column .crel-image-guide__text,
						{{WRAPPER}} .crel-tablet-column-reverse .crel-image-guide__image, 
						{{WRAPPER}} .crel-tablet-column-reverse .crel-image-guide__text,
						{{WRAPPER}} .crel-tablet-row-reverse .crel-image-guide__image, 
						{{WRAPPER}} .crel-tablet-row-reverse .crel-image-guide__text,
						{{WRAPPER}} .crel-tablet-row-reverse .crel-image-guide__image, 
						{{WRAPPER}} .crel-tablet-row-reverse .crel-image-guide__text'    => 'padding: 0!important;',
						
						'(mobile){{WRAPPER}} .crel-mobile-column .crel-image-guide__image'    => 'padding-bottom: calc({{SIZE}}px / 2)!important;',
						'(mobile){{WRAPPER}} .crel-mobile-column .crel-image-guide__text'    => 'padding-top: calc({{SIZE}}px / 2)!important;',
						
						'(mobile){{WRAPPER}} .crel-mobile-column-reverse .crel-image-guide__image'    => 'padding-top: calc({{SIZE}}px / 2)!important;',
						'(mobile){{WRAPPER}} .crel-mobile-column-reverse .crel-image-guide__text'    => 'padding-bottom: calc({{SIZE}}px / 2)!important;',
						
						'(mobile){{WRAPPER}} .crel-mobile-row-reverse .crel-image-guide__image'    => is_rtl() ? 'padding-right: calc({{SIZE}}px / 2)!important;' : 'padding-left: calc({{SIZE}}px / 2)!important;',
						'(mobile){{WRAPPER}} .crel-mobile-row-reverse .crel-image-guide__text'    => is_rtl() ? 'padding-left: calc({{SIZE}}px / 2)!important;' : 'padding-right: calc({{SIZE}}px / 2)!important;',
						
						'(mobile){{WRAPPER}} .crel-mobile-row .crel-image-guide__image'    => is_rtl() ? 'padding-left: calc({{SIZE}}px / 2)!important;' : 'padding-right: calc({{SIZE}}px / 2)!important;',
						'(mobile){{WRAPPER}} .crel-mobile-row .crel-image-guide__text'    => is_rtl() ? 'padding-right: calc({{SIZE}}px / 2)!important;' : 'padding-left: calc({{SIZE}}px / 2)!important;',
					]
				]
			);
			
		$this->end_controls_section();

		// IMAGE ----------------------------------------------------[SECTION]-------------/
		$this->start_controls_section(
			'crel_image_guide__image_section_style',
			[
				'label' => __( 'Image', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE
			]
		);

			$this->add_control_responsive(
				'crel_image_guide__image_padding',
				[
					'label' => __( 'Padding', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						'{{WRAPPER}} .crel-image-guide__image-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'separator' => 'after'
				]
			);
			
			$this->add_control_group(
				Group_Control_Border::get_type(),
				[
					'name' => 'crel_image_guide__image_border',
					'selector' => '{{WRAPPER}} .crel-image-guide__image-wrap',
				]
			);
			
			$this->add_control_responsive(
				'crel_image_guide__image_border_radius',
				[
					'label' => __( 'Border Radius', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors' => [
						'{{WRAPPER}} .crel-image-guide__image-wrap, {{WRAPPER}} .crel-image-guide__image-wrap img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'separator' => 'after'
				]
			);
			
			$this->add_control_group(
				Group_Control_Box_Shadow::get_type(),
				[
					'name' => 'crel_image_guide__image_box_shadow',
					'selector' => '{{WRAPPER}} .crel-image-guide__image-wrap',
				]
			);

		// Space between Rows
		$this->add_control_responsive(
			'crel_image_guide__image_box_max_width',
			[
				'label' => __( 'Maximal width of the image block', 'creative-addons-for-elementor'),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 2000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					]
				],
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .crel-image-guide__image-spots'    => 'max-width: {{SIZE}}{{UNIT}};',
				]
			]
		);
		
		$this->end_controls_section();

		// IMAGE CAPTION --------------------------------------------[SECTION]-------------/
		$this->start_controls_section(
            'crel_image_guide__image_caption_section_style',
            [
                'label' => __( 'Image Caption', 'creative-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

			// Caption Typography
			$this->add_control_group(
				Group_Control_Typography::get_type(),
				[
					'label'     => __( 'Typography', 'creative-addons-for-elementor' ),
					'name' => 'crel_image_guide__caption_Typography',
					'selector' => '{{WRAPPER}} .crel-image-guide__caption-text',
				]
			);
			
			$this->add_control(
				'crel_image_guide__image_caption_text_color',
				[
					'label' => __( 'Text Color', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crel-image-guide__caption-text' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_control(
				'crel_image_guide__image_caption_bg_color',
				[
					'label' => __( 'Background Color', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crel-image-guide__caption-text' => 'background-color: {{VALUE}}',
					],
				]
			);
			
			$this->add_control_responsive(
				'crel_image_guide__image_caption_padding',
				[
					'label' => __( 'Padding', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => ['px', 'em', '%'],
					'selectors' => [
						'{{WRAPPER}} .crel-image-guide__caption-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			
			$this->add_control_responsive(
				'crel_image_guide__image_caption_margin',
				[
					'label' => __( 'Margin', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => ['px', 'em', '%'],
					'selectors' => [
						'{{WRAPPER}} .crel-image-guide__caption-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			
			$this->add_control_responsive(
				'crel_image_guide__image_caption_border_radius',
				[
					'label' => __( 'Border Radius', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%' ],
					'selectors' => [
						'{{WRAPPER}} .crel-image-guide__caption-text' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			
		$this->end_controls_section();

		// SPOTS ----------------------------------------------------[SECTION]-------------/
		$this->start_controls_section(
            'crel_image_guide__spots_section_style',
            [
                'label' => __( 'Image Spots', 'creative-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

			// Container
			$this->add_control(
				'crel_image_guide__container_heading',
				[
					'label' => __( 'Container', 'creative-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control_responsive(
				'crel_image_guide__spot_width',
				[
					'label' => __( 'Width', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => ['px'],
					'range' => [
						'px' => [
							'min' => 20,
							'max' => 500,
						]
					],
					'selectors' => [
						'{{WRAPPER}} .crel-image-guide__image .crel-image-guide-icon' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);
			$this->add_control_responsive(
			'crel_image_guide__spot_height',
			[
				'label' => __( 'Height', 'creative-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 20,
						'max' => 500,
					]
				],
				'selectors' => [
					'{{WRAPPER}} .crel-image-guide__image .crel-image-guide-icon' => 'height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
				],
			]
			);
			$this->add_control_responsive(
			'crel_image_guide__spot_padding',
			[
				'label' => __( 'Padding', 'creative-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .crel-image-guide__spot' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
			);

		$this->add_control_responsive(
			'crel_image_guide__spot_margin',
			[
				'label' => __( 'Margin', 'creative-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .crel-image-guide__image .crel-image-guide-icon:before' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
				'condition'	=> [
					'crel_image_guide__list_spot_toggle'	=> 'yes',
					'crel_image_guide__list_type!'	=> 'crel-image-guide--icons'
				]
			]
		);


			// Show Icon toggle
			$this->add_control(
				'crel_image_guide__spot_pulse_toggle',
				[
					'label' => __( 'Show Pulse', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::SWITCHER,
					'label_on'  => __( 'Yes', 'creative-addons-for-elementor'),
					'label_off' => __( 'No', 'creative-addons-for-elementor'),
				]
			);

			$this->start_controls_tabs( 'crel-image-guide__tabs_spot' );

				// Normal Tab
				$this->start_controls_tab(
					'crel_image_guide__tab_spot_normal',
					[
						'label' => __( 'Normal', 'creative-addons-for-elementor' ),
					]
				);

					$this->add_control(
						'crel_image_guide__spot_bg_color',
						[
							'label' => __( 'Background Color', 'creative-addons-for-elementor' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .crel-image-guide__spot' => 'background-color: {{VALUE}}',
							],
						]
					);

					$this->add_control_group(
						Group_Control_Box_Shadow::get_type(),
						[
							'name' => 'crel_image_guide__spot_box_shadow',
							'selector' => '{{WRAPPER}} .crel-image-guide__spot'
						]
					);

				$this->end_controls_tab();

				// Hover Tab
				$this->start_controls_tab(
					'crel_image_guide__tab_spot_hover',
					[
						'label' => __( 'Hover/Active', 'creative-addons-for-elementor' ),
					]
				);

					$this->add_control(
						'crel_image_guide__spot_hover_bg_color',
						[
							'label' => __( 'Active Background Color', 'creative-addons-for-elementor' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .crel-image-guide__spot:hover, {{WRAPPER}} .crel-image-guide__spot:focus, {{WRAPPER}} .crel-image-guide__spot.crel-image-guide__spot--active' => 'background-color: {{VALUE}}',
							],
						]
					);

					$this->add_control(
						'crel_image_guide__spot_hover_border_color',
						[
							'label' => __( 'Hover Border Color', 'creative-addons-for-elementor' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .crel-image-guide__spot:hover, {{WRAPPER}} .crel-image-guide__spot:focus, {{WRAPPER}} .crel-image-guide__spot.crel-image-guide__spot--active' => 'border-color: {{VALUE}}',
							],
						]
					);
		
					$this->add_control_group(
						Group_Control_Box_Shadow::get_type(),
						[
							'name' => 'crel_image_guide__spot_hover_box_shadow',
							'selector' => '{{WRAPPER}} .crel-image-guide__spot:hover, {{WRAPPER}} .crel-image-guide__spot:focus, {{WRAPPER}} .crel-image-guide__spot.crel-image-guide__spot--active'
						]
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

			// Icon/Text
			$this->add_control(
				'crel_image_guide__text_heading',
				[
					'label' => __( 'Icon', 'creative-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control_responsive(
				'crel_image_guide__spot_font_size',
				[
					'label' => __( 'Icon Size', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => ['px'],
					'selectors' => [
						'{{WRAPPER}} .crel-image-guide__spot i' => 'font-size: {{SIZE}}{{UNIT}};',
					],
					'condition'	=> [
						'crel_image_guide__list_type'	=> 'crel-image-guide--icons'
					]
				]
			);
			$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' => __( 'Spot Label Typography', 'creative-addons-for-elementor' ),
				'name' => 'crel_image_guide__spot_label_typography',
				'selector' => '{{WRAPPER}} .crel-image-guide__spot span',
				'condition'	=> [
					'crel_image_guide__list_type!'	=> 'crel-image-guide--icons'
				]
			]
		);

			$this->start_controls_tabs( 'crel-image-guide__tabs_iconText' );

				// Normal Tab
				$this->start_controls_tab(
			'crel_image_guide__tab_iconText_normal',
				[
					'label' => __( 'Normal', 'creative-addons-for-elementor' ),
				]
				);

					$this->add_control(
			'crel_image_guide__spot_text_color',
			[
				'label' => __( 'Text Color', 'creative-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .crel-image-guide__spot' => 'color: {{VALUE}}',
				],
			]
		);

				$this->end_controls_tab();

				// Hover Tab
				$this->start_controls_tab(
			'crel_image_guide__tab_iconText_hover',
				[
					'label' => __( 'Hover/Active', 'creative-addons-for-elementor' ),
				]
				);

					$this->add_control(
			'crel_image_guide__spot_hover_text_color',
			[
				'label' => __( 'Hover Text Color', 'creative-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .crel-image-guide__spot:hover, {{WRAPPER}} .crel-image-guide__spot:focus, {{WRAPPER}} .crel-image-guide__spot.crel-image-guide__spot--active' => 'color: {{VALUE}}',
				],
			]
		);

				$this->end_controls_tab();

			$this->end_controls_tabs();


			// Border
			$this->add_control(
				'crel_image_guide__border_heading',
				[
					'label' => __( 'Border', 'creative-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);
			$this->add_control_group(
			Group_Control_Border::get_type(),
			[
				'name' => 'crel_image_guide__spot_border',
				'selector' => '{{WRAPPER}} .crel-image-guide__spot'
			]
		);
			$this->add_control_responsive(
			'crel_image_guide__spot_border_radius',
			[
				'label' => __( 'Border Radius', 'creative-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .crel-image-guide__spot' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->end_controls_section();

		// DESCRIPTION ----------------------------------------------[SECTION]-------------/
		$this->start_controls_section(
            'crel_image_guide__spots_section_description',
            [
                'label' => __( 'Description', 'creative-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );
			
			$this->add_control(
				'crel_image_guide__description_color',
				[
					'label' => __( 'Color', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crel-image-guide__description, {{WRAPPER}} .crel-image-guide__description p' => 'color: {{VALUE}}',
					],
				]
			);

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'label' => __( 'Typography', 'creative-addons-for-elementor' ),
					'name' => 'crel_image_guide__description_typography',
					'selector' => '{{WRAPPER}} .crel-image-guide__description, {{WRAPPER}} .crel-image-guide__description p',
				]
			);
			
			$this->add_control_responsive(
				'crel_image_guide__description_margin',
				[
					'label' => __( 'Margin', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => ['px', 'em', '%'],
					'selectors' => [
						'{{WRAPPER}} .crel-image-guide__description ' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			
		$this->end_controls_section();


		// LIST CONTAINER -------------------------------------------[SECTION]-------------/
		$this->start_controls_section(
			'crel_image_guide__spots_section_container',
			[
				'label' => __( 'List Container', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		
			// Background Color
			$this->add_control(
				'crel_image_guide__list_bgColor',
				[
					'label' => __( 'Background Color', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crel-spots__list-wrap .crel-image-guide__list-item' => 'background-color: {{VALUE}}',
					],
				]
			);

			// Padding
			$this->add_control_responsive(
			'crel_image_guide__list_padding',
			[
				'label' => __( 'Padding', 'creative-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => ['px', 'em', '%'],
				'selectors' => [
					'{{WRAPPER}} .crel-spots__list-wrap .crel-image-guide__list-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

			// Margin
			$this->add_control_responsive(
				'crel_image_guide__list_margin',
				[
					'label' => __( 'Margin', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => ['px', 'em', '%'],
					'selectors' => [
						'{{WRAPPER}} .crel-spots__list-wrap .crel-image-guide__list-item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);


		$this->end_controls_section();


		// LIST ICON ------------------------------------------------[SECTION]-------------/
		$this->start_controls_section(
            'crel_image_guide__spots_section_label',
            [
                'label' => __( 'List Icon', 'creative-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

			// Show Icon toggle
			$this->add_control(
			'crel_image_guide__list_spot_toggle',
			[
				'label' => __( 'Show Icon', 'creative-addons-for-elementor'),
				'type' => Controls_Manager::SWITCHER,
				'label_on'  => __( 'Yes', 'creative-addons-for-elementor'),
				'label_off' => __( 'No', 'creative-addons-for-elementor'),
			]
			);

			// Container -----------------------------------------/
			$this->add_control(
			'crel_image_guide___list_spot_container_heading',
			[
				'label' => __( 'Container', 'creative-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
			);

				// Width
				$this->add_control_responsive(
				'crel_image_guide__list_spot_width',
				[
					'label' => __( 'Width', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => ['px'],
					'range' => [
						'px' => [
							'min' => 20,
							'max' => 500,
						]
					],
					'selectors' => [
						'{{WRAPPER}} .crel-image-guide__list-icon' => 'min-width: {{SIZE}}{{UNIT}};',
					],
					'condition'	=> [
						'crel_image_guide__list_spot_toggle'	=> 'yes'
					]
				]
				);

				// Height
				$this->add_control_responsive(
				'crel_image_guide__list_spot_height',
				[
					'label' => __( 'Height', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => ['px'],
					'range' => [
						'px' => [
							'min' => 20,
							'max' => 500,
						]
					],
					'selectors' => [
						'{{WRAPPER}} .crel-image-guide__list-icon' => 'height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
					],
					'condition'	=> [
						'crel_image_guide__list_spot_toggle'	=> 'yes'
					]
				]
				);

				// Padding
				$this->add_control_responsive(
				'crel_image_guide__list_spot_padding',
				[
					'label' => __( 'Padding', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => ['px', 'em', '%'],
					'selectors' => [
						'{{WRAPPER}} .crel-image-guide__list-icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'	=> [
						'crel_image_guide__list_spot_toggle'	=> 'yes'
					]
				]
				);

				// Margin
				$this->add_control_responsive(
				'crel_image_guide__list_spot_margin',
				[
					'label' => __( 'Margin', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => ['px', 'em', '%'],
					'selectors' => [
						'{{WRAPPER}} .crel-image-guide__list-icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
					'condition'	=> [
						'crel_image_guide__list_spot_toggle'	=> 'yes'
					]
				]
			);

			$this->start_controls_tabs( 'crel-image-guide__tabs_container_listIcon' );

				// Normal Tab
				$this->start_controls_tab(
					'crel_image_guide__tab_container_listIcon_normal',
					[
						'label' => __( 'Normal', 'creative-addons-for-elementor' ),
						'condition'	=> [
							'crel_image_guide__list_spot_toggle'	=> 'yes'
						]
					]
				);

					// Background Color
					$this->add_control(
						'crel_image_guide__list_spot_bg_color',
						[
							'label' => __( 'Background Color', 'creative-addons-for-elementor' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .crel-image-guide__list-icon' => 'background-color: {{VALUE}}',
							],
							'condition'	=> [
								'crel_image_guide__list_spot_toggle'	=> 'yes'
							],
						]
					);

					// Box Shadow
					$this->add_control_group(
						Group_Control_Box_Shadow::get_type(),
						[
							'name' => 'crel_image_guide__list_spot_box_shadow',
							'selector' => '{{WRAPPER}} .crel-image-guide__list-icon',
							'condition'	=> [
								'crel_image_guide__list_spot_toggle'	=> 'yes'
							],
						]
					);

				$this->end_controls_tab();

				// Hover Tab
				$this->start_controls_tab(
					'crel_image_guide__tab_container_listIcon_hover',
					[
						'label' => __( 'Hover/Active', 'creative-addons-for-elementor' ),
						'condition'	=> [
							'crel_image_guide__list_spot_toggle'	=> 'yes'
						]
					]
				);

					// Hover Background Color
					$this->add_control(
					'crel_image_guide__list_spot_hover_bg_color',
					[
						'label' => __( 'Background Color', 'creative-addons-for-elementor' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .crel-image-guide__list-item:hover .crel-image-guide__list-icon, {{WRAPPER}} .crel-image-guide__list-item.crel-image-guide__spot--active .crel-image-guide__list-icon' => 'background-color: {{VALUE}}',
						],
						'condition'	=> [
							'crel_image_guide__list_spot_toggle'	=> 'yes'
						],
					]
					);

					// Hover Box Shadow
					$this->add_control_group(
						Group_Control_Box_Shadow::get_type(),
						[
							'name' => 'crel_image_guide__list_spot_hover_box_shadow',
							'selector' => '{{WRAPPER}} .crel-image-guide__list-item:hover .crel-image-guide__list-icon,  {{WRAPPER}} .crel-image-guide__list-item.crel-image-guide__spot--active .crel-image-guide__list-icon',
							'condition'	=> [
								'crel_image_guide__list_spot_toggle'	=> 'yes'
							],
						]
					);

				$this->end_controls_tab();


			$this->end_controls_tabs();

			// Icon/Text -----------------------------------------/
			$this->add_control(
				'crel_image_guide___list_spot_iconText_heading',
				[
					'label' => __( 'Icon', 'creative-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

				// Font / Icon Size
				$this->add_control_responsive(
				'crel_image_guide__list_spot_font_size',
				[
					'label' => __( 'Icon Size', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => ['px'],
					'selectors' => [
						'{{WRAPPER}} .crel-image-guide__list-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
					],
					'condition'	=> [
						'crel_image_guide__list_spot_toggle'	=> 'yes',
						'crel_image_guide__list_type'	=> 'crel-image-guide--icons'
					]
				]
				);

				// Prefix Typography
				$this->add_group_control(
					Group_Control_Typography::get_type(),
					[
						'label' => __( 'Icon Size', 'creative-addons-for-elementor' ),
						'name' => 'crel_image_guide__list_spot_prefix_typography',
						'selector' => '{{WRAPPER}} .crel-image-guide__list-icon span',
						'condition'	=> [
							'crel_image_guide__list_spot_toggle'	=> 'yes',
							'crel_image_guide__list_type!'	=> 'crel-image-guide--icons'
						]
					]
				);


			$this->start_controls_tabs( 'crel-image-guide__tabs_list_spot' );

				// Normal Tab
				$this->start_controls_tab(
					'crel_image_guide__tab_list_spot_normal',
					[
						'label' => __( 'Normal', 'creative-addons-for-elementor' ),
						'condition'	=> [
							'crel_image_guide__list_spot_toggle'	=> 'yes'
						]
					]
				);

					// Text Color
					$this->add_control(
					'crel_image_guide__list_spot_text_color',
					[
						'label' => __( 'Text Color', 'creative-addons-for-elementor' ),
						'type' => Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .crel-image-guide__list-icon' => 'color: {{VALUE}}',
						],
						'condition'	=> [
							'crel_image_guide__list_spot_toggle'	=> 'yes'
						],
					]
				);

				$this->end_controls_tab();

				// Hover/Active
				$this->start_controls_tab(
					'crel_image_guide__list_tab_spot_hover',
					[
						'label' => __( 'Hover/Active', 'creative-addons-for-elementor' ),
						'condition'	=> [
							'crel_image_guide__list_spot_toggle'	=> 'yes'
						]
					]
				);

					// Text Color
					$this->add_control(
						'crel_image_guide__list_spot_hover_text_color',
						[
							'label' => __( 'Text Color', 'creative-addons-for-elementor' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
								'{{WRAPPER}} .crel-image-guide__list-item:hover .crel-image-guide__list-icon, {{WRAPPER}} .crel-image-guide__list-item.crel-image-guide__spot--active .crel-image-guide__list-icon' => 'color: {{VALUE}}',
							],
							'condition'	=> [
								'crel_image_guide__list_spot_toggle'	=> 'yes'
							],
						]
					);

				$this->end_controls_tab();

			$this->end_controls_tabs();

			// Border ------------------------------------------/
			$this->add_control(
				'crel_image_guide___list_spot_border_heading',
				[
					'label' => __( 'Border', 'creative-addons-for-elementor' ),
					'type' => \Elementor\Controls_Manager::HEADING,
					'separator' => 'before',
				]
			);

				// Border
				$this->add_control_group(
					Group_Control_Border::get_type(),
					[
						'name' => 'crel_image_guide__list_spot_border',
						'selector' => '{{WRAPPER}} .crel-image-guide__list-icon',
						'condition'	=> [
							'crel_image_guide__list_spot_toggle'	=> 'yes'
						]
					]
				);

				// Border Radius
				$this->add_control_responsive(
					'crel_image_guide__list_spot_border_radius',
					[
						'label' => __( 'Border Radius', 'creative-addons-for-elementor' ),
						'type' => Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%' ],
						'selectors' => [
							'{{WRAPPER}} .crel-image-guide__list-icon' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);

			$this->end_controls_section();

		// LIST TEXT ------------------------------------------------[SECTION]-------------/
		$this->start_controls_section(
            'crel_image_guide__spots_section_label_text',
            [
                'label' => __( 'List Text', 'creative-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'label' => __( 'Typography', 'creative-addons-for-elementor' ),
					'name' => 'crel_image_guide__list_spot_text_typography',
					'selector' => '{{WRAPPER}} .crel-image-guide__list-text, {{WRAPPER}} .crel-image-guide__list-text p',
				]
			);
			
			$this->add_control(
				'crel_image_guide__list_text_color',
				[
					'label' => __( 'Color', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crel-image-guide__list-text' => 'color: {{VALUE}};',
					],
					'separator'     => 'after',
				]
			);
			
		$this->end_controls_section();
	}
	
	protected function render() {

		$pulse = '';
		$settings = $this->get_settings_for_display();
		if ( $settings['crel_image_guide__spot_pulse_toggle'] ) {
			$pulse = 'crel-image-guide__image--spotPulse';
		}
		
		$settings = $this->get_settings_for_display(); 
		$layout = esc_attr( 'crel-' . $settings['crel_image_guide__layout_type'] );
		
		if ( !empty( $settings['crel_image_guide__layout_type_desktop'] ) ) {
			$layout .= ' crel-desktop-' . esc_attr( $settings['crel_image_guide__layout_type_desktop'] );
		}
		
		if ( !empty( $settings['crel_image_guide__layout_type_tablet'] ) ) {
			$layout .= ' crel-tablet-' . esc_attr( $settings['crel_image_guide__layout_type_tablet'] );
		}
		
		if ( !empty( $settings['crel_image_guide__layout_type_mobile'] ) ) {
			$layout .= ' crel-mobile-' . esc_attr( $settings['crel_image_guide__layout_type_mobile'] );
		}
		
		
		?>
		
		<div class="crel-image-guide__container <?php echo $layout; ?> <?php echo esc_attr( $settings['crel_image_guide__list_type'] ); ?>">
			<div class="crel-image-guide__image">
				<div class="crel-image-guide__image-spots <?php echo $pulse; ?>"><?php
					$this->render_image();
					$this->render_spots_points(); ?>
				</div><?php 
				
				$this->add_render_attribute( 'crel_image_guide__caption_text', [
					'class' => [ 'crel-image-guide__caption-text' ]
				] );
					
				$this->add_inline_editing_attributes( 'crel_image_guide__caption_text', 'none' ); ?>
				
				<div <?php echo $this->get_render_attribute_string( 'crel_image_guide__caption_text' ); ?>><?php echo esc_attr( $settings['crel_image_guide__caption_text'] ); ?></div>
			</div>
			<div class="crel-image-guide__text crel-<?php echo esc_attr( $settings['crel_image_guide__description_position'] ); ?>"><?php
				$this->render_spots_list();
				$this->render_description(); ?>
			</div>
		</div><?php
	}
	
	protected function render_image() {
		
		$settings = $this->get_settings_for_display();
		$image_data = $settings['crel_image_guide__image'];
		$style = '';
		$srcset = ''; 
		$image_alt = '';
		
		if ( $image_data['id'] ) {
			// not a placeholder image
			$post_meta = get_post_meta( $image_data['id'], '_wp_attachment_image_alt', true );
			if ( ! empty($post_meta) ) {
				$image_alt = trim( strip_tags( $post_meta ) );
			}
			
			$image_url = Group_Control_Image_Size::get_attachment_image_src( $image_data['id'], 'image', $settings );
			
			$srcset = wp_get_attachment_image_srcset( $image_data['id'], $settings['image_size']);
			if ( $srcset ) $srcset = 'srcset="' . $srcset . '"';
			
		} else {
			$image_alt = '';
			$image_url = esc_url( $image_data['url'] );
		
			foreach ( $this->get_image_sizes() as $size_name => $size_data ) {
				if ( $settings['image_size'] == $size_name ) {
					$style = ( $size_data['width'] ? 'max-width: ' . $size_data['width'] . 'px; ' : '' ) . ( $size_data['height'] ? 'max-height: ' . $size_data['height'] . 'px; ' : '' );
				}
			}
		}
		
		if ( empty( $image_url ) ) {
			$image_url = $image_full = Utils::get_placeholder_image_src();
		} ?>
		
		<div style="<?php echo $style; ?>" class="crel-image-guide__image-wrap">
			<img src="<?php echo $image_url; ?>" alt="<?php echo esc_attr( $image_alt ); ?>" <?php echo $srcset; ?> loading="lazy">
		</div><?php

	}
	
	protected function render_spots_points() {
		$settings = $this->get_settings_for_display();
		$spots = $settings['crel_image_guide__spots'];
		
		foreach ( $spots as $key => $item ) { ?>
			<div class="crel-image-guide__spot elementor-repeater-item-<?php echo $item['_id']; ?>" data-index="<?php echo $key; ?>"><?php
				if ( 'crel-image-guide--icons' == $settings['crel_image_guide__list_type'] ) {
					Icons_Manager::render_icon( $item['crel_image_guide__spot_icon'], array( 'class' => 'crel-image-guide-icon' ) );
				} else {
					echo '<span class="crel-image-guide-icon crel-image-guide-number-icon"></span>';
				} ?>
			</div><?php
		}
	}
	
	protected function render_spots_list() {
		$settings = $this->get_settings_for_display();
		$spots = $settings['crel_image_guide__spots']; ?>
		
		<ul class="crel-spots__list-wrap"><?php 
			foreach ( $spots as $key => $item ) { ?>
				<li class="crel-image-guide__list-item" data-index="<?php echo $key; ?>"><?php
					if ( $settings['crel_image_guide__list_spot_toggle'] ) { ?>
						<div class="crel-image-guide__list-icon"><?php
							if ( 'crel-image-guide--icons' == $settings['crel_image_guide__list_type'] ) {
								Icons_Manager::render_icon( $item['crel_image_guide__spot_icon'] );
							} else {
								echo '<span class="crel-image-guide-number-icon"></span>';
							} ?>
						</div><?php 
					} 
					
					$field_key = $this->get_repeater_setting_key( 'crel_image_guide__spot_text', 'crel_image_guide__spots', $key );
					$this->add_render_attribute( $field_key, [
						'class' => [ 'crel-image-guide__list-text' ],
					] );
					$this->add_inline_editing_attributes( $field_key ); ?>
					
					<div <?php echo $this->get_render_attribute_string( $field_key ); ?>><?php echo  $this->parse_text_editor( $item['crel_image_guide__spot_text'] ); ?></div>
				</li><?php
			} ?>
		</ul><?php
	}
	
	protected function render_description() {
		$settings = $this->get_settings_for_display();
		$description = $settings['crel_image_guide__description'];
		$this->add_render_attribute( 'crel_image_guide__description', [
			'class' => [ 'crel-image-guide__description', 'elementor-text-editor' ]
		] );
		$this->add_inline_editing_attributes( 'crel_image_guide__description', 'advanced' )?>
		
		<div <?php echo $this->get_render_attribute_string( 'crel_image_guide__description' ); ?>><?php echo $this->parse_text_editor( $description ); ?></div><?php
	}
	
	protected function content_template() { 
		$image_sizes = $this->get_image_sizes(); ?>
		
		<#
			let layout = 'crel-' + settings.crel_image_guide__layout_type;
			
			if ( typeof settings.crel_image_guide__layout_type_desktop != 'undefined' && settings.crel_image_guide__layout_type_desktop ) {
				layout += ' crel-desktop-' + settings.crel_image_guide__layout_type_desktop;
			}
			
			if ( typeof settings.crel_image_guide__layout_type_tablet != 'undefined' && settings.crel_image_guide__layout_type_tablet ) {
				layout += ' crel-tablet-' + settings.crel_image_guide__layout_type_tablet;
			}
			
			if ( typeof settings.crel_image_guide__layout_type_mobile != 'undefined' && settings.crel_image_guide__layout_type_mobile ) {
				layout += ' crel-mobile-' + settings.crel_image_guide__layout_type_mobile;
			}

		#>
		<div class="crel-image-guide__container {{{layout}}} {{{settings.crel_image_guide__list_type}}}">
			<div class="crel-image-guide__image">

				<#
				pulse = '';
				if ( settings.crel_image_guide__spot_pulse_toggle ) {
				pulse = 'crel-image-guide__image--spotPulse';
				} #>

				<div class="crel-image-guide__image-spots {{{pulse}}}"><#
					
					function getIconHTML( icon ) {
						if ( 'crel-image-guide--icons' == settings.crel_image_guide__list_type && icon ) {
							let iconHTML = elementor.helpers.renderIcon( view, icon, { 'class' : 'crel-image-guide-icon' }, 'i' , 'object' );
							return  iconHTML.value;
						} 
						
						return '<span class="crel-image-guide-icon crel-image-guide-number-icon"></span>';
					}
					
					let image_url = '';
					let style = '';
					
					<?php foreach ( $image_sizes as $size_name => $size_data ) { ?>					
						if ( settings.image_size == '<?php echo $size_name; ?>' ) { 
							style = '<?php 
								echo $size_data['width'] ? 'max-width: ' . $size_data['width'] . 'px; ' : ' ';
								echo $size_data['height'] ? 'max-height: ' . $size_data['height'] . 'px; ' : ' '; ?>';
						}
					<?php } ?>
					
					if ( typeof settings.crel_image_guide__image.id == 'undefined' || ! settings.crel_image_guide__image.id ) {
						image_url = settings.crel_image_guide__image.url;
					} else {
						let image = {
							id: settings.crel_image_guide__image.id,
							url: settings.crel_image_guide__image.url,
							size: settings.image_size,
							dimension: settings.image_custom_dimension,
							model: view.getEditModel()
						}
						
						image_url = elementor.imagesManager.getImageUrl( image );
					}
					
					if ( ! image_url ) {
						image_url = '<?php echo Utils::get_placeholder_image_src(); ?>';
					} #>
						
					<div style="{{{style}}}" class="crel-image-guide__image-wrap">
						<img src="{{{image_url}}}">
					</div>
					
					<# _.each( settings.crel_image_guide__spots, function( spot, index ) { #>
						<div class="crel-image-guide__spot elementor-repeater-item-{{{spot._id}}}" data-index="{{{index}}}">{{{ getIconHTML( spot.crel_image_guide__spot_icon ) }}}</div>
					<# }); #>
					
				</div><#
				
				view.addRenderAttribute( 'crel_image_guide__caption_text',	{
					'class': [ 'crel-image-guide__caption-text' ],
				} );
				view.addInlineEditingAttributes( 'crel_image_guide__caption_text', 'none' ); #>
				
				<div {{{ view.getRenderAttributeString( 'crel_image_guide__caption_text' ) }}}>
					{{{settings.crel_image_guide__caption_text}}}
				</div>
			</div>
			<div class="crel-image-guide__text crel-{{{settings.crel_image_guide__description_position}}}">
				<ul class="crel-spots__list-wrap">
					<# _.each( settings.crel_image_guide__spots, function( spot, index ) { #>
						<li class="crel-image-guide__list-item" data-index="{{{index}}}">
							<# if ( settings.crel_image_guide__list_spot_toggle ) { #>
								<div class="crel-image-guide__list-icon">{{{ getIconHTML( spot.crel_image_guide__spot_icon ) }}}</div>
							<# } 
							
								let field_key = view.getRepeaterSettingKey( 'crel_image_guide__spot_text', 'crel_image_guide__spots', index );
								
								view.addRenderAttribute( field_key, {
									'class': [ 'crel-image-guide__list-text' ],
								} );

								view.addInlineEditingAttributes( field_key ); #>
							<div {{{ view.getRenderAttributeString( field_key ) }}}>{{{spot.crel_image_guide__spot_text}}}</div>
						</li>
					<# }); #>
				</ul><#
				
				view.addRenderAttribute( 'crel_image_guide__description',	{
					'class': [ 'crel-image-guide__description', 'elementor-text-editor' ],
				} );
				view.addInlineEditingAttributes( 'crel_image_guide__description', 'advanced' ); #>
				
				<div {{{ view.getRenderAttributeString( 'crel_image_guide__description' ) }}}>
					{{{settings.crel_image_guide__description}}}
				</div>
			</div>
		</div><?php
	}
	
	protected function preview_url( $img ) {
		return CREATIVE_ADDONS_ASSETS_URL . 'images/presets/img-guide/' . $img;
	}
}
