<?php
namespace Creative_Addons\Widgets;

use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Creative_Addons\Includes\Kb\KB_Utilities;
use Creative_Addons\Includes\Kb\KB_Handler;
use Creative_Addons\Includes\Utilities;

defined( 'ABSPATH' ) || exit();

/**
 * KB Recent Articles widget for Elementor
 */
class KB_Recent_Articles extends Creative_Widget_Base {

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
        return __( 'KB Recent Articles', 'creative-addons-for-elementor' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
        return 'crelfont crel-kb-article-list-icon';
	}

	/**
	 * Retrieve the widget Demo URL.
	 *
	 * @return string Widget Demo URL.
	 */
	public function get_demo_url() {
		return 'https://www.creative-addons.com/elementor-widgets/knowledge-base-recent-articles/';
	}

	/**
	 * Retrieve the widget Documentation URL.
	 *
	 * @return string Widget Documentation URL.
	 */
	public function get_documentation_url() {
		return 'https://www.creative-addons.com/elementor-docs/kb-recent-articles-widget/';
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
		return [ 'article', 'post', 'list', 'document', 'knowledgebase', 'kb', 'knowledge' ];
	}

	protected function get_config_defaults() {
		return [
			// Title -----------------/
			'crel_kbRecentArticles__title_toggle'                       => 'yes',
			'crel_kbRecentArticles__title_text'                         => __( 'Recent Articles', 'creative-addons-for-elementor' ),
			'crel_kbRecentArticles__title_HTMLTag'                      => 'h3',


			'crel_kbRecentArticles__title_padding'                      => [
				'top'       => '0',
				'right'     => '0',
				'bottom'    => '10',
				'left'      => '0',
				'unit'      => 'px'
			],
			'crel_kbRecentArticles__title_alignment'                    => 'flex-start',
			'crel_kbRecentArticles__title_color'                        => '',
			'crel_kbRecentArticles__title_backgroundColor'              => '',

			'crel_kbRecentArticles__title_typography_typography'        => 'custom',
			'crel_kbRecentArticles__title_typography_font_size'         => [
				'size' => '24',
				'unit' => 'px',
				'sizes' => []
			],
			'crel_kbRecentArticles__title_typography_font_style'        => 'normal',
			'crel_kbRecentArticles__title_typography_font_weight'       => 'bold',
			'crel_kbRecentArticles__title_borderType_width'             => [
				'top' => '0',
				'left' => '0',
				'right' => '0',
				'bottom' => '2',
				'unit' => 'px',
				'isLinked' => false
			],
			'crel_kbRecentArticles__title_borderType_border'            => 'none',
			'crel_kbRecentArticles__title_borderType_color'             => '#000000',
			'crel_kbRecentArticles__title_margin'                       => [
				'top'       => '0',
				'right'     => '0',
				'bottom'    => '10',
				'left'      => '0',
				'unit'      => 'px'
			],

			// List -----------------/
			'crel_kbRecentArticles__list_orderBy'                       => 'date',
			'crel_kbRecentArticles__list_nofArticles'                   => '5',
			'crel_kbRecentArticles__list_layout'                        => 'col',
			'crel_kbRecentArticles__list_paddingTopBottom'              => [
				'size' => 10,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_kbRecentArticles__list_alignment'                     => 'flex-start',
			'crel_kbRecentArticles__icon_position'                      => 'icon-first',

			// Article --------------/
			'crel_kbRecentArticles__articleText_typography'             => 'custom',
			'crel_kbRecentArticles__articleText_font_size'              => [
				'size' => '16',
				'unit' => 'px',
				'sizes' => []
			],
			'crel_kbRecentArticles__articleText_font_style'             => 'normal',
			'crel_kbRecentArticles__articleText_font_weight'            => 'normal',
			'crel_kbRecentArticles__fixedWidth_toggle'                  => 'no',
			'crel_kbRecentArticles__articleText_width'                  => [
				'size' => 500,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_kbRecentArticles__articleText_margin'                 => [
				'top'       => '0',
				'left'      => '0',
				'right'     => '0',
				'bottom'    => '0',
				'unit'      => 'px'
			],
			'crel_kbRecentArticles__articleText_padding'                => [
				'top'       => '0',
				'left'      => '0',
				'right'     => '0',
				'bottom'    => '0',
				'unit'      => 'px'
			],
			'crel_kbRecentArticles__articleText_color'                  => '#000000',
			'crel_kbRecentArticles__articleText_backgroundColor'        => '',
			'crel_kbRecentArticles__articleText_borderType_width'       => [
				'top' => '0',
				'left' => '0',
				'right' => '0',
				'bottom' => '0',
				'unit' => 'px',
				'isLinked' => false
			],
			'crel_kbRecentArticles__articleText_borderType_border'      => 'none',
			'crel_kbRecentArticles__articleText_borderType_color'       => '#000000',
			'crel_kbRecentArticles__articleText_colorHover'             => '',
			'crel_kbRecentArticles__articleText_backgroundColorHover'   => '',

			// Category Icon --------/
			'crel_kbRecentArticles__icon_size'                          => [
				'size' => '14',
				'unit' => 'px',
				'sizes' => []
			],
			'crel_kbRecentArticles__icon_margin'                        => [
				'size' => 14,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_kbRecentArticles__icon_padding'                       => [
				'top'       => '0',
				'right'     => '5',
				'bottom'    => '0',
				'left'      => '0',
				'unit'      => 'px'
			],
			'crel_kbRecentArticles__icon_color'                         => '',
			'crel_kbRecentArticles__icon_colorHover'                    => '',
		];
	}

	protected function get_config_rtl_defaults() {
		return [
			'crel_kbRecentArticles__icon_padding'       => [
				'top'       => '0',
				'right'     => '0',
				'bottom'    => '0',
				'left'      => '5',
				'unit' => 'px'
			],
		];
	}

	protected function get_presets_defaults() {
		return [

			// Title -----------------/
			'crel_kbRecentArticles__title_toggle'                       => 'yes',
			'crel_kbRecentArticles__title_HTMLTag'                      => 'h3',


			'crel_kbRecentArticles__title_padding'                      => [
				'top'       => '0',
				'right'     => '0',
				'bottom'    => '10',
				'left'      => '0',
				'unit'      => 'px'
			],
			'crel_kbRecentArticles__title_alignment'                    => 'flex-start',
			'crel_kbRecentArticles__title_color'                        => '',
			'crel_kbRecentArticles__title_backgroundColor'              => '',

			'crel_kbRecentArticles__title_typography_typography'        => 'custom',
			'crel_kbRecentArticles__title_typography_font_size'         => [
				'size' => '24',
				'unit' => 'px',
				'sizes' => []
			],
			'crel_kbRecentArticles__title_typography_font_style'        => 'normal',
			'crel_kbRecentArticles__title_typography_font_weight'       => 'bold',
			'crel_kbRecentArticles__title_borderType_width'             => [
				'top' => '0',
				'left' => '0',
				'right' => '0',
				'bottom' => '2',
				'unit' => 'px',
				'isLinked' => false
			],
			'crel_kbRecentArticles__title_borderType_border'            => 'none',
			'crel_kbRecentArticles__title_borderType_color'             => '#000000',
			'crel_kbRecentArticles__title_margin'                       => [
				'top'       => '0',
				'right'     => '0',
				'bottom'    => '10',
				'left'      => '0',
				'unit'      => 'px'
			],

			// List -----------------/
			'crel_kbRecentArticles__list_orderBy'                       => 'date',
			'crel_kbRecentArticles__list_nofArticles'                   => '5',
			'crel_kbRecentArticles__list_layout'                        => 'col',
			'crel_kbRecentArticles__list_paddingTopBottom'              => [
				'size' => 10,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_kbRecentArticles__list_alignment'                     => 'flex-start',
			'crel_kbRecentArticles__icon_position'                      => 'icon-first',

			// Article --------------/
			'crel_kbRecentArticles__articleText_typography'             => 'custom',
			'crel_kbRecentArticles__articleText_font_size'              => [
				'size' => '16',
				'unit' => 'px',
				'sizes' => []
			],
			'crel_kbRecentArticles__articleText_font_style'             => 'normal',
			'crel_kbRecentArticles__articleText_font_weight'            => 'normal',
			'crel_kbRecentArticles__fixedWidth_toggle'                  => 'no',
			'crel_kbRecentArticles__articleText_width'                  => [
				'size' => 500,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_kbRecentArticles__articleText_margin'                 => [
				'top'       => '0',
				'left'      => '0',
				'right'     => '0',
				'bottom'    => '0',
				'unit'      => 'px'
			],
			'crel_kbRecentArticles__articleText_padding'                => [
				'top'       => '0',
				'left'      => '0',
				'right'     => '0',
				'bottom'    => '0',
				'unit'      => 'px'
			],
			'crel_kbRecentArticles__articleText_color'                  => '#000000',
			'crel_kbRecentArticles__articleText_backgroundColor'        => '',
			'crel_kbRecentArticles__articleText_borderType_width'       => [
				'top' => '0',
				'left' => '0',
				'right' => '0',
				'bottom' => '0',
				'unit' => 'px',
				'isLinked' => false
			],
			'crel_kbRecentArticles__articleText_borderType_border'      => 'none',
			'crel_kbRecentArticles__articleText_borderType_color'       => '#000000',
			'crel_kbRecentArticles__articleText_colorHover'             => '',
			'crel_kbRecentArticles__articleText_backgroundColorHover'   => '',

			// Category Icon --------/
			'crel_kbRecentArticles__icon_size'                          => [
				'size' => '14',
				'unit' => 'px',
				'sizes' => []
			],
			'crel_kbRecentArticles__icon_margin'                        => [
				'size' => 14,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_kbRecentArticles__icon_padding'                       => [
				'top'       => '0',
				'right'     => '5',
				'bottom'    => '0',
				'left'      => '0',
				'unit'      => 'px'
			],
			'crel_kbRecentArticles__icon_color'                         => '',
			'crel_kbRecentArticles__icon_colorHover'                    => '',
		];
	}

	protected function get_presets_rtl_defaults() {
		return [];
	}
	
	protected function get_config_old_defaults() {
		return [
			'crel_kbRecentArticles__title_color'                        => '',
			'crel_kbRecentArticles__title_typography_typography'        => 'custom',
			'crel_kbRecentArticles__title_typography_font_size'         => [
				'size' => '24',
				'unit' => 'px',
				'sizes' => []
			],
			'crel_kbRecentArticles__title_typography_font_style'        => 'normal',
			'crel_kbRecentArticles__title_typography_font_weight'       => 'bold',
			'crel_kbRecentArticles__articleText_typography'             => 'custom',
			'crel_kbRecentArticles__articleText_font_size'              => [
				'size' => '16',
				'unit' => 'px',
				'sizes' => []
			],
			'crel_kbRecentArticles__articleText_font_style'             => 'normal',
			'crel_kbRecentArticles__articleText_font_weight'            => 'normal',
			'crel_kbRecentArticles__articleText_color'                  => '#000000',
			'crel_kbRecentArticles__articleText_colorHover'             => '',
			'crel_kbRecentArticles__icon_color'                         => '',
			'crel_kbRecentArticles__icon_colorHover'                    => '',
		];
	}
	
	/**
	 * Return presets for this widget
	 */
	public function get_presets_options() {

		$options = array();

		$options['default'] = array(
			'title' => 'List Layout 1',
			'preview_url' => $this->presets_preview_url( 'kb-recent-articles-design-1.png' ),
			'options' => array()
		);

		// Design 2
		$options['design-2'] = array(
			'title' => __( 'List Layout 2', 'creative-addons-for-elementor'),
			'preview_url' => $this->presets_preview_url( 'kb-recent-articles-design-2.png' ),

			'options' => array(

				// Title
				'crel_kbRecentArticles__title_alignment'        => 'center',

				// Category
				'crel_kbRecentArticles__articleText_backgroundColor'    => '#F4F4F4',
				'crel_kbRecentArticles__articleText_padding'            => [
					'top'       => '8',
					'left'      => '8',
					'right'     => '8',
					'bottom'    => '8',
					'unit'      => 'px'
				],
				'crel_kbRecentArticles__articleText_borderType_border'  => 'solid',
				'crel_kbRecentArticles__articleText_borderType_width'   => [
					'top' => '1',
					'left' => '1',
					'right' => '4',
					'bottom' => '4',
					'unit' => 'px'
				],
				'crel_kbRecentArticles__articleText_borderType_color'   => '#CCCCCC',

				// Category Icon
				'crel_kbRecentArticles__icon_size'              => [
					'size' => '24',
					'unit' => 'px',
					'sizes' => []
				],

			)
		);

		// Design 3
		$options['design-3'] = array(
			'title' => __( 'List Layout 3', 'creative-addons-for-elementor'),
			'preview_url' => $this->presets_preview_url( 'kb-recent-articles-design-3.png' ),

			'options' => array(

				// Title
				'crel_kbRecentArticles__title_alignment'        => 'center',

				// Category
				'crel_kbRecentArticles__articleText_backgroundColor'    => '#F4F4F4',
				'crel_kbRecentArticles__articleText_padding'            => [
					'top'       => '8',
					'left'      => '8',
					'right'     => '8',
					'bottom'    => '8',
					'unit'      => 'px'
				],
				'crel_kbRecentArticles__articleText_borderType_border'  => 'solid',
				'crel_kbRecentArticles__articleText_borderType_width'   => [
					'top' => '1',
					'left' => '1',
					'right' => '1',
					'bottom' => '1',
					'unit' => 'px'
				],
				'crel_kbRecentArticles__articleText_borderType_color'   => '#CCCCCC',

				// Category Icon
				'crel_kbRecentArticles__icon_size'              => [
					'size' => '24',
					'unit' => 'px',
					'sizes' => []
				],

			)
		);

		// Design 4
		$options['design-4'] = array(
			'title' => __( 'List Layout 4', 'creative-addons-for-elementor'),
			'preview_url' => $this->presets_preview_url( 'kb-recent-articles-design-4.png' ),

			'options' => array(

				// Title
				'crel_kbRecentArticles__title_alignment'        => 'center',

				// Category
				'crel_kbRecentArticles__articleText_padding'            => [
					'top'       => '0',
					'left'      => '8',
					'right'     => '8',
					'bottom'    => '8',
					'unit'      => 'px'
				],
				'crel_kbRecentArticles__articleText_borderType_border'  => 'solid',
				'crel_kbRecentArticles__articleText_borderType_width'   => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '1',
					'unit' => 'px'
				],
				'crel_kbRecentArticles__articleText_borderType_color'   => '#000000',

				// Category Icon
				'crel_kbRecentArticles__icon_size'              => [
					'size' => '24',
					'unit' => 'px',
					'sizes' => []
				],

			)
		);

		// Design 5
		$options['design-5'] = array(
			'title' => __( 'Box Layout 1', 'creative-addons-for-elementor'),
			'preview_url' => $this->presets_preview_url( 'kb-recent-articles-design-5.png' ),

			'options' => array(

				'crel_kbRecentArticles__title_alignment'        => 'center',


				// List
				'crel_kbRecentArticles__list_layout'            => 'row',
				'crel_kbRecentArticles__list_alignment'         => 'center',

				// Category
				'crel_kbRecentArticles__articleText_backgroundColor'    => '#f7f7f7',
				'crel_kbRecentArticles__articleText_padding'            => [
					'top'       => '20',
					'left'      => '20',
					'right'     => '20',
					'bottom'    => '20',
					'unit'      => 'px'
				],
				'crel_kbRecentArticles__fixedWidth_toggle'      => 'yes',
				'crel_kbRecentArticles__articleText_width'              => [
					'size' => '250',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_kbRecentArticles__articleText_borderType_border'  => 'solid',
				'crel_kbRecentArticles__articleText_borderType_color'   => '#CCCCCC',
				'crel_kbRecentArticles__articleText_borderType_width'   => [
					'top'       => '1',
					'left'      => '1',
					'right'     => '1',
					'bottom'    => '4',
					'unit'      => 'px'
				],

				// Category Icon
				'crel_kbRecentArticles__icon_size'              => [
					'size' => '24',
					'unit' => 'px',
					'sizes' => []
				],
			)
		);

		// Design 6
		$options['design-6'] = array(
			'title' => __( 'Box Layout 2', 'creative-addons-for-elementor'),
			'preview_url' => $this->presets_preview_url( 'kb-recent-articles-design-6.png' ),

			'options' => array(

				'crel_kbRecentArticles__title_alignment'        => 'center',

				// List
				'crel_kbRecentArticles__list_layout'            => 'row',
				'crel_kbRecentArticles__list_alignment'         => 'center',

				// Category
				'crel_kbRecentArticles__articleText_backgroundColor'    => '#f7f7f7',
				'crel_kbRecentArticles__articleText_padding'            => [
					'top'       => '20',
					'left'      => '20',
					'right'     => '20',
					'bottom'    => '20',
					'unit'      => 'px'
				],
				'crel_kbRecentArticles__fixedWidth_toggle'      => 'yes',
				'crel_kbRecentArticles__articleText_width'              => [
					'size' => '350',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_kbRecentArticles__articleText_borderType_border'  => 'double',
				'crel_kbRecentArticles__articleText_borderType_color'   => '#CCCCCC',
				'crel_kbRecentArticles__articleText_borderType_width'   => [
					'top'       => '4',
					'left'      => '4',
					'right'     => '4',
					'bottom'    => '4',
					'unit'      => 'px'
				],

				// Category Icon
				'crel_kbRecentArticles__icon_size'              => [
					'size' => '24',
					'unit' => 'px',
					'sizes' => []
				],
			)
		);

		// Design 7
		$options['design-7'] = array(
			'title' => __( 'Box Layout 3', 'creative-addons-for-elementor'),
			'preview_url' => $this->presets_preview_url( 'kb-recent-articles-design-7.png' ),

			'options' => array(

				// List
				'crel_kbRecentArticles__list_layout'            => 'row',

				// Category
				'crel_kbRecentArticles__articleText_backgroundColor'    => '#f7f7f7',
				'crel_kbRecentArticles__articleText_padding'            => [
					'top'       => '20',
					'left'      => '20',
					'right'     => '20',
					'bottom'    => '20',
					'unit'      => 'px'
				],
				'crel_kbRecentArticles__fixedWidth_toggle'      => 'yes',
				'crel_kbRecentArticles__articleText_width'              => [
					'size' => '350',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_kbRecentArticles__articleText_borderType_border'  => 'groove',
				'crel_kbRecentArticles__articleText_borderType_color'   => '#CCCCCC',
				'crel_kbRecentArticles__articleText_borderType_width'   => [
					'top'       => '6',
					'left'      => '6',
					'right'     => '6',
					'bottom'    => '6',
					'unit'      => 'px'
				],

				// Category Icon
				'crel_kbRecentArticles__icon_size'              => [
					'size' => '24',
					'unit' => 'px',
					'sizes' => []
				],
			)
		);

		// Design 8
		$options['design-8'] = array(
			'title' => __( 'Box Layout 4', 'creative-addons-for-elementor'),
			'preview_url' => $this->presets_preview_url( 'kb-recent-articles-design-8.png' ),

			'options' => array(

				// Title
				'crel_kbRecentArticles__title_alignment'        => 'center',

				// List
				'crel_kbRecentArticles__list_layout'            => 'row',
				'crel_kbRecentArticles__list_alignment'         => 'center',

				// Category
				'crel_kbRecentArticles__articleText_color'              => '#000000',
				'crel_kbRecentArticles__articleText_backgroundColor'    => '',
				'crel_kbRecentArticles__articleText_padding'            => [
					'top'       => '12',
					'left'      => '12',
					'right'     => '12',
					'bottom'    => '12',
					'unit'      => 'px'
				],
				'crel_kbRecentArticles__articleText_margin'             => [
					'top'       => '0',
					'left'      => '5',
					'right'     => '5',
					'bottom'    => '0',
					'unit'      => 'px'
				],
				'crel_kbRecentArticles__fixedWidth_toggle'      => 'no',
				'crel_kbRecentArticles__articleText_borderType_border'  => 'solid',
				'crel_kbRecentArticles__articleText_borderType_width'   => [
					'top' => '1',
					'left' => '0',
					'right' => '0',
					'bottom' => '1',
					'unit' => 'px'
				],
				'crel_kbRecentArticles__articleText_borderType_color'   => '#000000',

				// Category Icon
				'crel_kbRecentArticles__icon_size'              => [
					'size' => '24',
					'unit' => 'px',
					'sizes' => []
				],

			)
		);

		// Design 9
		$options['design-9'] = array(
			'title' => __( 'Box Layout 5', 'creative-addons-for-elementor'),
			'preview_url' => $this->presets_preview_url( 'kb-recent-articles-design-9.png' ),

			'options' => array(

				// Title
				'crel_kbRecentArticles__title_alignment'                => 'center',

				// List
				'crel_kbRecentArticles__list_layout'                    => 'row',
				'crel_kbRecentArticles__list_alignment'                 => 'center',

				// Category
				'crel_kbRecentArticles__articleText_color'              => '#000000',
				'crel_kbRecentArticles__articleText_backgroundColor'    => '#F8F8F8',
				'crel_kbRecentArticles__articleText_padding'            => [
					'top'       => '12',
					'left'      => '12',
					'right'     => '12',
					'bottom'    => '12',
					'unit'      => 'px'
				],
				'crel_kbRecentArticles__articleText_margin'             => [
					'top'       => '0',
					'left'      => '5',
					'right'     => '5',
					'bottom'    => '0',
					'unit'      => 'px'
				],
				'crel_kbRecentArticles__fixedWidth_toggle'              => 'no',
				'crel_kbRecentArticles__articleText_borderType_border'  => 'solid',
				'crel_kbRecentArticles__articleText_borderType_width'   => [
					'top' => '0',
					'left' => '1',
					'right' => '1',
					'bottom' => '0',
					'unit' => 'px'
				],
				'crel_kbRecentArticles__articleText_borderType_color'   => '#000000',

				// Category Icon
				'crel_kbRecentArticles__icon_size'                      => [
					'size' => '24',
					'unit' => 'px',
					'sizes' => []
				],

			)
		);

		// Design 10
		$options['design-10'] = array(
			'title' => __( 'Box Layout 6', 'creative-addons-for-elementor'),
			'preview_url' => $this->presets_preview_url( 'kb-recent-articles-design-10.png' ),

			'options' => array(

				// Title
				'crel_kbRecentArticles__title_alignment'        => 'center',

				// List
				'crel_kbRecentArticles__list_layout'            => 'row',
				'crel_kbRecentArticles__list_alignment'         => 'center',

				// Category
				'crel_kbRecentArticles__articleText_color'              => '#000000',
				'crel_kbRecentArticles__articleText_backgroundColor'    => '',
				'crel_kbRecentArticles__articleText_padding'            => [
					'top'       => '12',
					'left'      => '12',
					'right'     => '12',
					'bottom'    => '12',
					'unit'      => 'px'
				],
				'crel_kbRecentArticles__articleText_margin'            => [
					'top'       => '0',
					'left'      => '5',
					'right'     => '5',
					'bottom'    => '0',
					'unit'      => 'px'
				],
				'crel_kbRecentArticles__fixedWidth_toggle'      => 'no',
				'crel_kbRecentArticles__articleText_borderType_border'  => 'solid',
				'crel_kbRecentArticles__articleText_borderType_width'   => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '0',
					'unit' => 'px'
				],
				'crel_kbRecentArticles__articleText_borderType_color'   => '#000000',

				// Category Icon
				'crel_kbRecentArticles__icon_size'              => [
					'size' => '24',
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

		// GET OR SET VALUES ---/

		// CONTENT =================================[ TAB ]====================================/

		// TITLE  ----------------------------------[SECTION]-------------/
		$this->start_controls_section(
			'crel_kbRecentArticles__Title__section__ContentTab',
			[
				'label' => __( 'Title', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT
			]
		);

		// Show Title Toggle
		$this->add_control(
			'crel_kbRecentArticles__title_toggle',
			[
				'label'     => __( 'Show Title', 'creative-addons-for-elementor'),
				'type'      => Controls_Manager::SWITCHER,
				'label_on'  => __( 'Yes', 'creative-addons-for-elementor'),
				'label_off' => __( 'No', 'creative-addons-for-elementor'),
				'force_preset' => true
			]
		);

		// Title
		$this->add_control(
			'crel_kbRecentArticles__title_text',
			[
				'label' => __( 'Title', 'creative-addons-for-elementor' ),
				'type' => Controls_Manager::TEXT,
				'placeholder' => __( 'Type your text here', 'creative-addons-for-elementor' ),
				'condition'	=> [
					'crel_kbRecentArticles__title_toggle'	=> 'yes'
				]
			]
		);

		// Title HTML Tag
		$this->add_control(
			'crel_kbRecentArticles__title_HTMLTag',
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
					'crel_kbRecentArticles__title_toggle'	=> 'yes'
				],
			]
		);

		$this->end_controls_section();

		// ARTICLES  -------------------------------[SECTION]-------------/
		$this->start_controls_section(
			'crel_kbRecentArticles__Articles__section__ContentTab',
			[
				'label' => __( 'Articles', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT
			]
		);

		// Order By
		$this->add_control(
			'crel_kbRecentArticles__list_orderBy',
			[
				'label' => __( 'Order By', 'creative-addons-for-elementor' ),
				'type' => Controls_Manager::SELECT,
				'options' => array(
					'date' => __( 'Creation Date', 'creative-addons-for-elementor' ),
					'modified' => __( 'Modification Date', 'creative-addons-for-elementor' ),
				)
			]
		);

		// Number of Articles
		$this->add_control(
			'crel_kbRecentArticles__list_nofArticles',
			[
				'label' => __( 'Number of Articles', 'creative-addons-for-elementor' ),
				'type' => Controls_Manager::NUMBER,
				'min' => -1,
				'step' => 1,
			]
		);

		$this->end_controls_section();
	}

	/**
	 * STYLE tab for this widget
	 */
    protected function register_style_controls() {

	    // STYLE ===================================[ TAB ]====================================/

	    // TITLE  ----------------------------------[SECTION]-------------/
	    $this->start_controls_section(
		    'crel_kbRecentArticles__Title__section__StyleTab',
		    [
			    'label' => __( 'Title', 'creative-addons-for-elementor' ),
			    'tab' => Controls_Manager::TAB_STYLE,
		    ]
	    );

		    // Title Padding
		    $this->add_responsive_control(
			    'crel_kbRecentArticles__title_padding',
			    [
				    'label' => __( 'Padding', 'creative-addons-for-elementor' ),
				    'type' => Controls_Manager::DIMENSIONS,
				    'size_units' => [ 'px', 'em', '%' ],
				    'selectors' => [
					    '{{WRAPPER}} .crel-kb-article-list-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				    ],

			    ]
		    );

			// Alignment
			$this->add_control(
				'crel_kbRecentArticles__title_alignment',
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
						'{{WRAPPER}} .crel-kb-article-list-title'           => 'justify-content: {{VALUE}};',
					],
				]
			);

		    // Title Color
		    $this->add_control(
			    'crel_kbRecentArticles__title_color',
			    [
				    'label' => __( 'Text Color', 'creative-addons-for-elementor' ),
				    'type' => Controls_Manager::COLOR,
				    'selectors' => [
					    '{{WRAPPER}} .crel-kb-article-list-title' => 'color: {{VALUE}};',
				    ],
			    ]
		    );

		    // Background Color
		    $this->add_control(
			    'crel_kbRecentArticles__title_backgroundColor',
			    [
				    'label' => __( 'Background Color', 'creative-addons-for-elementor' ),
				    'type' => Controls_Manager::COLOR,
				    'selectors' => [
					    '{{WRAPPER}} .crel-kb-article-list-title' => 'background-color: {{VALUE}};',
				    ],
			    ]
		    );

		    // Title Typography
		    $this->add_group_control(
			    Group_Control_Typography::get_type(),
			    [
				    'name' => 'crel_kbRecentArticles__title_typography',
				    'selector' => '{{WRAPPER}} .crel-kb-article-list-title',
			    ]
		    );
			
			
			// Border Type
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'crel_kbRecentArticles___title_borderType',
					'label' => esc_html__( 'Border', 'creative-addons-for-elementor'),
					'selector' => '{{WRAPPER}} .crel-kb-article-list-title',
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
			
			$this->add_responsive_control(
				'crel_kbRecentArticles__title_margin',
				[
					'label' => __( 'Margin', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						'{{WRAPPER}} .crel-kb-article-list-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);
			
	    $this->end_controls_section();

	    // List ---------------------------------[SECTION]-------------/
	    $this->start_controls_section(
		    'crel_kbRecentArticles__List__section__StyleTab',
		    [
			    'label' => __( 'List', 'creative-addons-for-elementor' ),
			    'tab' => Controls_Manager::TAB_STYLE,
		    ]
	    );

		    // Layout
		    $this->add_responsive_control(
			    'crel_kbRecentArticles__list_layout',
			    [
				    'label' => __( 'Layout', 'creative-addons-for-elementor' ),
				    'type' => Controls_Manager::CHOOSE,
				    'label_block' => false,
				    'options' => [
					    'col' => [
						    'title' => __( 'Column', 'creative-addons-for-elementor' ),
						    'icon' => 'eicon-editor-list-ul',
					    ],
					    'row' => [
						    'title' => __( 'Row', 'creative-addons-for-elementor' ),
						    'icon' => 'eicon-ellipsis-h',
					    ],
				    ],
				    'toggle' => false,
				    'style_transfer' => true,
			    ]
		    );

		    // Space Between
		    $this->add_responsive_control(
			    'crel_kbRecentArticles__list_paddingTopBottom',
			    [
				    'label' => __( 'Space Between', 'creative-addons-for-elementor' ),
				    'type' => Controls_Manager::SLIDER,
				    'range' => [
					    'px' => [
						    'max' => 50,
					    ],
				    ],
				    'selectors' => [
					    '{{WRAPPER}} .crel-kb-article-list--col .crel-kb-article-list-items__item:not(:first-child)' => 'padding-top: calc({{SIZE}}{{UNIT}}/2)',
					    '{{WRAPPER}} .crel-kb-article-list--col .crel-kb-article-list-items__item:not(:last-child)' => 'padding-bottom: calc({{SIZE}}{{UNIT}}/2)',
					    '{{WRAPPER}} .crel-kb-article-list--row .crel-kb-article-list-items__item' => 'padding: calc({{SIZE}}{{UNIT}}/2)',
				    ],
			    ]
		    );

		    // Alignment
		    $this->add_control(
			    'crel_kbRecentArticles__list_alignment',
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
					    '{{WRAPPER}} .crel-kb-article-list-items-container' => 'justify-content: {{VALUE}};',
					    '{{WRAPPER}} .crel-kb-article-list-items__item a'   => 'justify-content: {{VALUE}};',
				    ],
			    ]
		    );

		    // Icon Position
		    $this->add_responsive_control(
			    'crel_kbRecentArticles__icon_position',
			    [
				    'label' => __( 'Icon Position', 'creative-addons-for-elementor' ),
				    'type' => Controls_Manager::CHOOSE,
				    'label_block' => false,
				    'options' => [
					    'icon-first' => [
						     'title' => __( is_rtl() ? 'Right' : 'Left', 'creative-addons-for-elementor' ),
						    'icon' => is_rtl() ? 'eicon-h-align-right' : 'eicon-h-align-left',
					    ],
					    'icon-last' => [
						    'title' => __( is_rtl() ? 'Left' : 'Right', 'creative-addons-for-elementor' ),
						    'icon' =>  is_rtl() ? 'eicon-h-align-left' : 'eicon-h-align-right',
					    ],
				    ],
				    'toggle' => false,
				    'style_transfer' => true,
			    ]
		    );

	    $this->end_controls_section();

	    // ARTICLES  -------------------------------[SECTION]-------------/
	    $this->start_controls_section(
		    'crel_kbRecentArticles__Article__section__StyleTab',
		    [
			    'label' => __( 'Article', 'creative-addons-for-elementor' ),
			    'tab' => Controls_Manager::TAB_STYLE,
		    ]
	    );

		    // Article Typography
		    $this->add_group_control(
			    Group_Control_Typography::get_type(),
			    [
				    'name' => 'crel_kbRecentArticles__articleText_typography',
				    'selector' => '{{WRAPPER}} .crel-kb-article-list-items__item a',
			    ]
		    );

		    // Fixed Width Toggle
		    $this->add_control(
			    'crel_kbRecentArticles__fixedWidth_toggle',
			    [
				    'label'     => __( 'Fixed Width', 'creative-addons-for-elementor'),
				    'type'      => Controls_Manager::SWITCHER,
				    'label_on'  => __( 'Yes', 'creative-addons-for-elementor'),
				    'label_off' => __( 'No', 'creative-addons-for-elementor'),
				    'condition'	=> [
					    'crel_kbRecentArticles__list_layout'	=> 'row'
				    ]

			    ]
		    );

		    // Fixed Width
		    $this->add_responsive_control(
			    'crel_kbRecentArticles__articleText_width',
			    [
				    'label' => __( 'Fixed Width', 'creative-addons-for-elementor' ),
				    'type' => Controls_Manager::SLIDER,
				    'range' => [
					    'px' => [
						    'max' => 1500,
					    ],
				    ],
				    'selectors' => [
					    '{{WRAPPER}} .crel-kb-article-list-items-container li' => 'width:{{SIZE}}{{UNIT}}',
				    ],
				    'condition'	=> [
					    'crel_kbRecentArticles__fixedWidth_toggle'	=> 'yes'
				    ]
			    ]
		    );

		    // Article Margin
		    $this->add_responsive_control(
			    'crel_kbRecentArticles__articleText_margin',
			    [
				    'label' => __( 'Margin', 'creative-addons-for-elementor' ),
				    'type' => Controls_Manager::DIMENSIONS,
				    'size_units' => [ 'px', 'em', '%' ],
				    'selectors' => [
					    '{{WRAPPER}} .crel-kb-article-list-items__item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				    ],
			    ]
		    );

		    // Article Padding
		    $this->add_responsive_control(
			    'crel_kbRecentArticles__articleText_padding',
			    [
				    'label' => __( 'Padding', 'creative-addons-for-elementor' ),
				    'type' => Controls_Manager::DIMENSIONS,
				    'size_units' => [ 'px', 'em', '%' ],
				    'selectors' => [
					    '{{WRAPPER}} .crel-kb-article-list-items__item a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				    ],
			    ]
		    );

		    // Article Text Color
		    $this->add_control(
			    'crel_kbRecentArticles__articleText_color',
			    [
				    'label' => __( 'Text Color', 'creative-addons-for-elementor' ),
				    'type' => Controls_Manager::COLOR,
				    'selectors' => [
					    '{{WRAPPER}} .crel-kb-article-list-items__item__text' => 'color: {{VALUE}};',
				    ],
			    ]
		    );

		    // Article Background Color
		    $this->add_control(
			    'crel_kbRecentArticles__articleText_backgroundColor',
			    [
				    'label' => __( 'Background Color', 'creative-addons-for-elementor' ),
				    'type' => Controls_Manager::COLOR,
				    'selectors' => [
					    '{{WRAPPER}} .crel-kb-article-list-items__item a' => 'background-color: {{VALUE}};',
				    ],
			    ]
		    );

		    // Icon Border Type
		    $this->add_group_control(
			    Group_Control_Border::get_type(),
			    [
				    'name' => 'crel_kbRecentArticles__articleText_borderType',
				    'label' => esc_html__( 'Border', 'creative-addons-for-elementor'),
				    'selector' => '{{WRAPPER}} .crel-kb-article-list-items__item a'
			    ]
		    );

		    // Article Hover Text Color
		    $this->add_control(
			    'crel_kbRecentArticles__articleText_colorHover',
			    [
				    'label' => __( 'Hover Text Color', 'creative-addons-for-elementor' ),
				    'type' => Controls_Manager::COLOR,
				    'selectors' => [
					    '{{WRAPPER}} .crel-kb-article-list-items__item:hover .crel-kb-article-list-items__item__text ' => 'color: {{VALUE}};',
				    ],
			    ]
		    );

		    // Article Hover Background Color
		    $this->add_control(
			    'crel_kbRecentArticles__articleText_backgroundColorHover',
			    [
				    'label' => __( 'Hover Background Color', 'creative-addons-for-elementor' ),
				    'type' => Controls_Manager::COLOR,
				    'selectors' => [
					    '{{WRAPPER}} .crel-kb-article-list-items__item a:hover ' => 'background-color: {{VALUE}};',
				    ],
			    ]
		    );

		    // Article Hover Icon Color
		    $this->add_control(
			    'crel_kbRecentArticles__icon_colorHover',
			    [
				    'label' => __( 'Icon Hover Color', 'creative-addons-for-elementor' ),
				    'type' => Controls_Manager::COLOR,
				    'selectors' => [
					    '{{WRAPPER}} .crel-kb-article-list-items__item a:hover .crel-kb-article-list-items__item__icon .crel-recent-articles-icon' => 'color: {{VALUE}};',
				    ],
			    ]
		    );

	    $this->end_controls_section();

	    // Article - Icon ------------------------------[SECTION]-------------/
	    $this->start_controls_section(
		    'crel_kbRecentArticles__ArticleIcon__section__StyleTab',
		    [
			    'label' => __( 'Article - Icon', 'creative-addons-for-elementor' ),
			    'tab' => Controls_Manager::TAB_STYLE,
		    ]
	    );

		    // Icon Size
		    $this->add_responsive_control(
			    'crel_kbRecentArticles__icon_size',
			    [
				    'label' => __( 'Icon Size', 'creative-addons-for-elementor'),
				    'type' => Controls_Manager::SLIDER,
				    'range' => [
					    'px' => [
						    'min' => 5,
						    'max' => 200,
						    'step' => 1,
					    ]
				    ],
				    'selectors' => [
					    '{{WRAPPER}} .crel-recent-articles-icon' => 'font-size: {{SIZE}}px;',
				    ]
			    ]
		    );

		    // Icon Margin
		    $this->add_responsive_control(
			    'crel_kbRecentArticles__icon_margin',
			    [
				    'label' => __( 'Margin', 'creative-addons-for-elementor' ),
				    'type' => Controls_Manager::DIMENSIONS,
				    'size_units' => [ 'px', 'em', '%' ],
				    'selectors' => [
					    '{{WRAPPER}} .crel-kb-article-list-items__item__icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				    ],
			    ]
		    );

		    // Icon Padding
		    $this->add_responsive_control(
			    'crel_kbRecentArticles__icon_padding',
			    [
				    'label' => __( 'Padding', 'creative-addons-for-elementor' ),
				    'type' => Controls_Manager::DIMENSIONS,
				    'size_units' => [ 'px', 'em', '%' ],
				    'selectors' => [
					    '{{WRAPPER}} .crel-kb-article-list-items__item__icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				    ],
			    ]
		    );

		    // Icon Color
		    $this->add_control(
			    'crel_kbRecentArticles__icon_color',
			    [
				    'label' => __( 'Color', 'creative-addons-for-elementor' ),
				    'type' => Controls_Manager::COLOR,
				    'selectors' => [
					    '{{WRAPPER}} .crel-recent-articles-icon' => 'color: {{VALUE}};',
				    ],
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
		
		if ( ! $this->is_kb_plugin_activated() ) {
			return;
		}
		
		$settings = $this->get_settings_for_display();
		$result = $this->execute_search( $this->get_current_kb_id(), $settings['crel_kbRecentArticles__list_nofArticles'], $settings['crel_kbRecentArticles__list_orderBy'] );

	    $title                  = esc_html($settings['crel_kbRecentArticles__title_text']);
	    $title_html_tag         = esc_attr($settings['crel_kbRecentArticles__title_HTMLTag']);
	    $title_active           = esc_attr($settings['crel_kbRecentArticles__title_toggle']);
	    $layout                 = esc_attr($settings['crel_kbRecentArticles__list_layout']);
	    $article_icon_loc       = esc_attr($settings['crel_kbRecentArticles__icon_position']);        ?>

		<div class="crel-kb-article-list-container crel-kb-article-list--<?php echo $layout . ' crel-kb-article-list--' . $article_icon_loc; ?>">
			<div class="crel-kb-article-list__inner"><?php

			    if ( $title_active === 'yes' ) {
				    echo '<' . $title_html_tag . ' class="crel-kb-article-list-title" >' . $title . '</' . $title_html_tag . '>';
			    }

		        if ( empty( $result ) ) {
		            echo esc_html__( 'Coming Soon', 'creative-addons-for-elementor' );
		        } else { ?>
		            <ul class="crel-kb-article-list-items-container"><?php
		            foreach( $result as $article ) {

		                $article_url = get_permalink( $article->ID );
		                if ( empty( $article_url ) || is_wp_error( $article_url )) {
		                    continue;
		                }

			            // get article icon filter if applicable
			            $article_title_icon = 'crel-recent-articles-icon crel_ep_font_icon_document';
			            if ( has_filter( 'eckb_single_article_filter' ) ) {
				            $article_title_icon_filter = apply_filters( 'eckb_article_icon_filter', '', $article->ID );
				            $article_title_icon = empty( $article_title_icon_filter ) ? $article_title_icon : 'crel-recent-articles-icon ' . $article_title_icon_filter . '';
			            } 
						
						$article_title_icon = KB_Utilities::replace_icons_name( $article_title_icon ); ?>
						
			            <!-- List Item -->
			            <li id="<?php echo 'crel-article-' . $article->ID; ?>" class="crel-kb-article-list-items__item">
		                    <a href="<?php echo esc_url( $article_url ); ?>">
			                    <span class="crel-kb-article-list-items__item__icon"><i aria-hidden="true" class="crelfa <?php echo esc_attr( $article_title_icon ); ?>"></i></span>
			                    <span class="crel-kb-article-list-items__item__text"><?php echo esc_html( $article->post_title ); ?></span>
		                    </a>
		                </li> <?php 
		            } ?>
					</ul><?php
		        } ?>
			</div>

		</div>		<?php
	}

    /**
     * Call WP query to get matching terms (any term OR match)
     *
     * @param $kb_id
     * @param $nof_articles
     * @param $orderby
     * @return array
     */
    private function execute_search( $kb_id, $nof_articles, $orderby ) {

        $result = array();
        $search_params = array(
            'post_type' => KB_Handler::get_post_type( $kb_id ),
            'ignore_sticky_posts' => true,      // sticky posts will not show at the top
            'posts_per_page' => KB_Utilities::is_amag_on( true ) ? -1 : $nof_articles,  // limit search results
            'no_found_rows' => true,            // query only posts_per_page rather than finding total nof posts for pagination etc.
            'orderby' => $orderby,
            'order'   => 'DESC'
        );

	    // define post_status only for older versions of KB
	    if ( ! Utilities::is_new_user( '7.5.0' ) ) {
		    $search_params['post_status'] = KB_Utilities::is_amag_on( true ) ? array('publish', 'private') : array('publish');
	    }

        $found_posts = new \WP_Query( $search_params );
        if ( ! empty($found_posts->posts) ) {
            $result = $found_posts->posts;
            wp_reset_postdata();
        }

	    // for Access Manager we query all and then we need to limit the number of articles per widget parameter
	    if ( KB_Utilities::is_amag_on( true ) && count($result) > $nof_articles ) {
		    $result = array_splice($result, 0, $nof_articles);
	    }

        return $result;
    }
}