<?php
namespace Creative_Addons\Widgets;

use Creative_Addons\Includes\Kb\KB_Utilities;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes;
use Creative_Addons\Includes\Utilities;
use Creative_Addons\Includes\System\Logging;
use Creative_Addons\Includes\Kb\KB_Handler;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;

defined( 'ABSPATH' ) || exit();

/**
 * KB Categories widget for Elementor
 */
class KB_Categories extends Creative_Widget_Base {

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'KB Categories', 'creative-addons-for-elementor' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'crelfont crel-kb-category-list-icon';
	}

	/**
	 * Retrieve the widget Demo URL.
	 *
	 * @return string Widget Demo URL.
	 */
	public function get_demo_url() {
		return 'https://www.creative-addons.com/elementor-widgets/knowledge-base-categories/';
	}

	/**
	 * Retrieve the widget Documentation URL.
	 *
	 * @return string Widget Documentation URL.
	 */
	public function get_documentation_url() {
		return 'https://www.creative-addons.com/elementor-docs/kb-categories-widget/';
	}

	public function is_editable() {
		return KB_Utilities::is_kb_plugin_active();
	}
	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'category', 'categories', 'list', 'knowledgebase', 'kb', 'knowledge' ];
	}

	protected function get_config_defaults() {
		return [
			// Title -----------------/
			'crel_kbCategories__title_toggle'                   => 'yes',
			'crel_kbCategories__title_text'                     => __( 'Categories', 'creative-addons-for-elementor' ),
			'crel_kbCategories__title_HTMLTag'                  => 'h3',

			'crel_kbCategories__categories_filter'              => 'all',
			'crel_kbCategories__categories_ids_text'            => '',

			'crel_kbCategories__title_padding'                  => [
				'top'       => '0',
				'right'     => '0',
				'bottom'    => '10',
				'left'      => '0',
				'unit'      => 'px'
			],
			'crel_kbCategories__title_alignment'                => 'flex-start',
			'crel_kbCategories__title_color'                    => '',
			'crel_kbCategories__title_backgroundColor'          => '',

			'crel_kbCategories__title_typography_typography'    => 'custom',
			'crel_kbCategories__title_typography_font_size'     => [
				'size' => '24',
				'unit' => 'px',
				'sizes' => []
			],
			'crel_kbCategories__title_typography_font_style'    => 'normal',
			'crel_kbCategories__title_typography_font_weight'   => 'bold',
			'crel_kbCategories__title_borderType_width'         => [
				'top' => '0',
				'left' => '0',
				'right' => '0',
				'bottom' => '2',
				'unit' => 'px',
				'isLinked' => false
			],
			'crel_kbCategories__title_borderType_border'        => 'none',
			'crel_kbCategories__title_borderType_color'         => '#000000',
			'crel_kbCategories__title_margin'                   => [
				'top'       => '0',
				'right'     => '0',
				'bottom'    => '10',
				'left'      => '0',
				'unit'      => 'px'
			],

			// List -----------------/
			'crel_kbCategories__list_layout'                    => 'col',
			'crel_kbCategories__list_paddingTopBottom'          => [
				'size' => 10,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_kbCategories__list_alignment'                 => 'flex-start',
			'crel_kbCategories__icon_position'                  => 'icon-first',
			'crel_kbCategories__list_offSet'                    => [
				'size' => 20,
				'unit' => 'px',
				'sizes' => []
			],

			// Category -------------/
			'crel_kbCategories__cat_typography_typography'      => 'custom',
			'crel_kbCategories__cat_typography_font_size'       => [
				'size' => '16',
				'unit' => 'px',
				'sizes' => []
			],
			'crel_kbCategories__cat_typography_font_style'      => 'normal',
			'crel_kbCategories__cat_typography_font_weight'     => 'normal',
			'crel_kbCategories__fixedWidth_toggle'              => 'no',
			'crel_kbCategories__cat_width'                      => [
				'size' => 500,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_kbCategories__cat_margin'                     => [
				'top'       => '0',
				'left'      => '0',
				'right'     => '0',
				'bottom'    => '0',
				'unit'      => 'px'
			],
			'crel_kbCategories__cat_padding'                    => [
				'top'       => '0',
				'left'      => '0',
				'right'     => '0',
				'bottom'    => '0',
				'unit'      => 'px'
			],
			'crel_kbCategories__cat_color'                      => '#000000',
			'crel_kbCategories__cat_backgroundColor'            => '',
			'crel_kbCategories__cat_borderType_width'           => [
				'top' => '0',
				'left' => '0',
				'right' => '0',
				'bottom' => '0',
				'unit' => 'px',
				'isLinked' => false
			],
			'crel_kbCategories__cat_borderType_border'          => 'none',
			'crel_kbCategories__cat_borderType_color'           => '#000000',
			'crel_kbCategories__cat_colorHover'                 => '',
			'crel_kbCategories__cat_backgroundColorHover'       => '',

			// Category Icon --------/
			'crel_kbCategories__icon_size'                      => [
				'size' => '30',
				'unit' => 'px',
				'sizes' => []
			],
			'crel_kbCategories__icon_margin'                    => [
				'size' => 14,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_kbCategories__icon_padding'                   => [
				'top'       => '0',
				'right'     => '5',
				'bottom'    => '0',
				'left'      => '0',
				'unit'      => 'px'
			],
			'crel_kbCategories__icon_color'                     => '',
			'crel_kbCategories__icon_colorHover'                => '',
		];
	}

	protected function get_config_rtl_defaults() {
		return [];
	}

	protected function get_presets_defaults() {
		return [

			// Title -----------------/
			'crel_kbCategories__title_toggle'                   => 'yes',
			'crel_kbCategories__title_HTMLTag'                  => 'h3',

			'crel_kbCategories__categories_filter'              => 'all',
			'crel_kbCategories__categories_ids_text'            => '',

			'crel_kbCategories__title_padding'                  => [
				'top'       => '0',
				'right'     => '0',
				'bottom'    => '10',
				'left'      => '0',
				'unit'      => 'px'
			],
			'crel_kbCategories__title_alignment'                => 'flex-start',
			'crel_kbCategories__title_color'                    => '',
			'crel_kbCategories__title_backgroundColor'          => '',

			'crel_kbCategories__title_typography_typography'    => 'custom',
			'crel_kbCategories__title_typography_font_size'     => [
				'size' => '24',
				'unit' => 'px',
				'sizes' => []
			],
			'crel_kbCategories__title_typography_font_style'    => 'normal',
			'crel_kbCategories__title_typography_font_weight'   => 'bold',
			'crel_kbCategories__title_borderType_width'         => [
				'top' => '0',
				'left' => '0',
				'right' => '0',
				'bottom' => '2',
				'unit' => 'px',
				'isLinked' => false
			],
			'crel_kbCategories__title_borderType_border'        => 'none',
			'crel_kbCategories__title_borderType_color'         => '#000000',
			'crel_kbCategories__title_margin'                   => [
				'top'       => '0',
				'right'     => '0',
				'bottom'    => '10',
				'left'      => '0',
				'unit'      => 'px'
			],

			// List -----------------/
			'crel_kbCategories__list_layout'                    => 'col',
			'crel_kbCategories__list_paddingTopBottom'          => [
				'size' => 10,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_kbCategories__list_alignment'                 => 'flex-start',
			'crel_kbCategories__icon_position'                  => 'icon-first',
			'crel_kbCategories__list_offSet'                    => [
					'size' => 20,
					'unit' => 'px',
					'sizes' => []
			],

			// Category -------------/
			'crel_kbCategories__cat_typography_typography'      => 'custom',
			'crel_kbCategories__cat_typography_font_size'       => [
				'size' => '16',
				'unit' => 'px',
				'sizes' => []
			],
			'crel_kbCategories__cat_typography_font_style'      => 'normal',
			'crel_kbCategories__cat_typography_font_weight'     => 'normal',
			'crel_kbCategories__fixedWidth_toggle'              => 'no',
			'crel_kbCategories__cat_width'                      => [
				'size' => 500,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_kbCategories__cat_margin'                     => [
				'top'       => '0',
				'left'      => '0',
				'right'     => '0',
				'bottom'    => '0',
				'unit'      => 'px'
			],
			'crel_kbCategories__cat_padding'                    => [
				'top'       => '0',
				'left'      => '0',
				'right'     => '0',
				'bottom'    => '0',
				'unit'      => 'px'
			],
			'crel_kbCategories__cat_color'                      => '#000000',
			'crel_kbCategories__cat_backgroundColor'            => '',
			'crel_kbCategories__cat_borderType_width'           => [
				'top' => '0',
				'left' => '0',
				'right' => '0',
				'bottom' => '0',
				'unit' => 'px',
				'isLinked' => false
			],
			'crel_kbCategories__cat_borderType_border'          => 'none',
			'crel_kbCategories__cat_borderType_color'           => '#000000',
			'crel_kbCategories__cat_colorHover'                 => '',
			'crel_kbCategories__cat_backgroundColorHover'       => '',

			// Category Icon --------/
			'crel_kbCategories__icon_size'                      => [
				'size' => '14',
				'unit' => 'px',
				'sizes' => []
			],
			'crel_kbCategories__icon_margin'                    => [
				'size' => 14,
				'unit' => 'px',
				'sizes' => []
			],
			'crel_kbCategories__icon_padding'                   => [
				'top'       => '0',
				'right'     => '5',
				'bottom'    => '0',
				'left'      => '0',
				'unit'      => 'px'
			],
			'crel_kbCategories__icon_color'                     => '',
			'crel_kbCategories__icon_colorHover'                => '',
			
		];
	}

	protected function get_presets_rtl_defaults() {
		return [];
	}
	
	protected function get_config_old_defaults() {
		return [
			'crel_kbCategories__title_color'                    => '',
			'crel_kbCategories__title_typography_typography'    => 'custom',
			'crel_kbCategories__title_typography_font_size'     => [
				'size' => '24',
				'unit' => 'px',
				'sizes' => []
			],
			'crel_kbCategories__title_typography_font_style'    => 'normal',
			'crel_kbCategories__title_typography_font_weight'   => 'bold',
			'crel_kbCategories__cat_typography_typography'      => 'custom',
			'crel_kbCategories__cat_typography_font_size'       => [
				'size' => '16',
				'unit' => 'px',
				'sizes' => []
			],
			'crel_kbCategories__cat_typography_font_style'      => 'normal',
			'crel_kbCategories__cat_typography_font_weight'     => 'normal',
			'crel_kbCategories__cat_color'                      => '#000000',
			'crel_kbCategories__cat_colorHover'                 => '',
			'crel_kbCategories__cat_backgroundColorHover'       => '',

			'crel_kbCategories__icon_color'                     => '',
			'crel_kbCategories__icon_colorHover'                => '',
		];
	}

	/**
	 * Return presets for this widget
	 */
	public function get_presets_options() {

		$options = array();

		$options['default'] = array(
			'title' => 'List Layout 1',
			'preview_url' => $this->presets_preview_url( 'kb-categories-design-1.png' ),
			'options' => array()
		);


		// Design 2
		$options['design-2'] = array(
			'title' => __( 'List Layout 2', 'creative-addons-for-elementor'),
			'preview_url' => $this->presets_preview_url( 'kb-categories-design-2.png' ),
			'options' => array(

				// Title
				'crel_kbCategories__title_alignment'        => 'center',

				// Category
				'crel_kbCategories__cat_backgroundColor'    => '#F4F4F4',
				'crel_kbCategories__cat_padding'            => [
					'top'       => '8',
					'left'      => '8',
					'right'     => '8',
					'bottom'    => '8',
					'unit'      => 'px'
				],
				'crel_kbCategories__cat_borderType_border'  => 'solid',
				'crel_kbCategories__cat_borderType_width'   => [
					'top' => '1',
					'left' => '1',
					'right' => '4',
					'bottom' => '4',
					'unit' => 'px'
				],
				'crel_kbCategories__cat_borderType_color'   => '#CCCCCC',

				// Category Icon
				'crel_kbCategories__icon_size'              => [
					'size' => '40',
					'unit' => 'px',
					'sizes' => []
				],

			)
		);

		// Design 3
		$options['design-3'] = array(
			'title' => __( 'List Layout 3', 'creative-addons-for-elementor'),
			'preview_url' => $this->presets_preview_url( 'kb-categories-design-3.png' ),
			'options' => array(

				// Title
				'crel_kbCategories__title_alignment'        => 'center',

				// Category
				'crel_kbCategories__cat_backgroundColor'    => '#F4F4F4',
				'crel_kbCategories__cat_padding'            => [
					'top'       => '8',
					'left'      => '8',
					'right'     => '8',
					'bottom'    => '8',
					'unit'      => 'px'
				],
				'crel_kbCategories__cat_borderType_border'  => 'solid',
				'crel_kbCategories__cat_borderType_width'   => [
					'top' => '1',
					'left' => '1',
					'right' => '1',
					'bottom' => '1',
					'unit' => 'px'
				],
				'crel_kbCategories__cat_borderType_color'   => '#CCCCCC',

				// Category Icon
				'crel_kbCategories__icon_size'              => [
					'size' => '40',
					'unit' => 'px',
					'sizes' => []
				],

			)
		);

		// Design 4
		$options['design-4'] = array(
			'title' => __( 'List Layout 4', 'creative-addons-for-elementor'),
			'preview_url' => $this->presets_preview_url( 'kb-categories-design-4.png' ),

			'options' => array(

				// Title
				'crel_kbCategories__title_alignment'        => 'center',

				// Category
				'crel_kbCategories__cat_padding'            => [
					'top'       => '0',
					'left'      => '8',
					'right'     => '8',
					'bottom'    => '8',
					'unit'      => 'px'
				],
				'crel_kbCategories__cat_borderType_border'  => 'solid',
				'crel_kbCategories__cat_borderType_width'   => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '1',
					'unit' => 'px'
				],
				'crel_kbCategories__cat_borderType_color'   => '#000000',

				// Category Icon
				'crel_kbCategories__icon_size'              => [
					'size' => '40',
					'unit' => 'px',
					'sizes' => []
				],

			)
		);

		// Design 5
		$options['design-5'] = array(
			'title' => __( 'Box Layout 1', 'creative-addons-for-elementor'),
			'preview_url' => $this->presets_preview_url( 'kb-categories-design-5.png' ),

			'options' => array(

				'crel_kbCategories__title_alignment'        => 'center',
				
				// List
				'crel_kbCategories__list_layout'            => 'row',
				'crel_kbCategories__list_alignment'         => 'center',

				// Category
				'crel_kbCategories__cat_backgroundColor'    => '#f7f7f7',
				'crel_kbCategories__cat_padding'            => [
					'top'       => '20',
					'left'      => '20',
					'right'     => '20',
					'bottom'    => '20',
					'unit'      => 'px'
				],
				'crel_kbCategories__fixedWidth_toggle'      => 'yes',
				'crel_kbCategories__cat_width'              => [
					'size' => '250',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_kbCategories__cat_borderType_border'  => 'solid',
				'crel_kbCategories__cat_borderType_color'   => '#CCCCCC',
				'crel_kbCategories__cat_borderType_width'   => [
					'top'       => '1',
					'left'      => '1',
					'right'     => '1',
					'bottom'    => '4',
					'unit'      => 'px'
				],

				// Category Icon
				'crel_kbCategories__icon_size'              => [
					'size' => '40',
					'unit' => 'px',
					'sizes' => []
				],
			)
		);

		// Design 6
		$options['design-6'] = array(
			'title' => __( 'Box Layout 2', 'creative-addons-for-elementor'),
			'preview_url' => $this->presets_preview_url( 'kb-categories-design-6.png' ),

			'options' => array(

				'crel_kbCategories__title_alignment'        => 'center',

				// List
				'crel_kbCategories__list_layout'            => 'row',
				'crel_kbCategories__list_alignment'         => 'center',

				// Category
				'crel_kbCategories__cat_backgroundColor'    => '#f7f7f7',
				'crel_kbCategories__cat_padding'            => [
					'top'       => '20',
					'left'      => '20',
					'right'     => '20',
					'bottom'    => '20',
					'unit'      => 'px'
				],
				'crel_kbCategories__fixedWidth_toggle'      => 'yes',
				'crel_kbCategories__cat_width'              => [
					'size' => '350',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_kbCategories__cat_borderType_border'  => 'double',
				'crel_kbCategories__cat_borderType_color'   => '#CCCCCC',
				'crel_kbCategories__cat_borderType_width'   => [
					'top'       => '4',
					'left'      => '4',
					'right'     => '4',
					'bottom'    => '4',
					'unit'      => 'px'
				],

				// Category Icon
				'crel_kbCategories__icon_size'              => [
					'size' => '40',
					'unit' => 'px',
					'sizes' => []
				],
			)
		);

		// Design 7
		$options['design-7'] = array(
			'title' => __( 'Box Layout 3', 'creative-addons-for-elementor'),
			'preview_url' => $this->presets_preview_url( 'kb-categories-design-7.png' ),

			'options' => array(

				// List
				'crel_kbCategories__list_layout'            => 'row',

				// Category
				'crel_kbCategories__cat_backgroundColor'    => '#f7f7f7',
				'crel_kbCategories__cat_padding'            => [
					'top'       => '20',
					'left'      => '20',
					'right'     => '20',
					'bottom'    => '20',
					'unit'      => 'px'
				],
				'crel_kbCategories__fixedWidth_toggle'      => 'yes',
				'crel_kbCategories__cat_width'              => [
					'size' => '350',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_kbCategories__cat_borderType_border'  => 'groove',
				'crel_kbCategories__cat_borderType_color'   => '#CCCCCC',
				'crel_kbCategories__cat_borderType_width'   => [
					'top'       => '6',
					'left'      => '6',
					'right'     => '6',
					'bottom'    => '6',
					'unit'      => 'px'
				],

				// Category Icon
				'crel_kbCategories__icon_size'              => [
					'size' => '40',
					'unit' => 'px',
					'sizes' => []
				],
			)
		);

		// Design 8
		$options['design-8'] = array(
			'title' => __( 'Box Layout 4', 'creative-addons-for-elementor'),
			'preview_url' => $this->presets_preview_url( 'kb-categories-design-8.png' ),

			'options' => array(

				// Title
				'crel_kbCategories__title_alignment'        => 'center',

				// List
				'crel_kbCategories__list_layout'            => 'row',
				'crel_kbCategories__list_alignment'         => 'center',

				// Category
				'crel_kbCategories__cat_color'              => '#000000',
				'crel_kbCategories__cat_backgroundColor'    => '',
				'crel_kbCategories__cat_padding'            => [
					'top'       => '12',
					'left'      => '12',
					'right'     => '12',
					'bottom'    => '12',
					'unit'      => 'px'
				],
				'crel_kbCategories__cat_margin'             => [
					'top'       => '0',
					'left'      => '5',
					'right'     => '5',
					'bottom'    => '0',
					'unit'      => 'px'
				],
				'crel_kbCategories__fixedWidth_toggle'      => 'no',
				'crel_kbCategories__cat_borderType_border'  => 'solid',
				'crel_kbCategories__cat_borderType_width'   => [
					'top' => '1',
					'left' => '0',
					'right' => '0',
					'bottom' => '1',
					'unit' => 'px'
				],
				'crel_kbCategories__cat_borderType_color'   => '#000000',

				// Category Icon
				'crel_kbCategories__icon_size'              => [
					'size' => '40',
					'unit' => 'px',
					'sizes' => []
				],

			)
		);

		// Design 9
		$options['design-9'] = array(
			'title' => __( 'Box Layout 5', 'creative-addons-for-elementor'),
			'preview_url' => $this->presets_preview_url( 'kb-categories-design-9.png' ),

			'options' => array(

				// Title
				'crel_kbCategories__title_alignment'        => 'center',

				// List
				'crel_kbCategories__list_layout'            => 'row',
				'crel_kbCategories__list_alignment'         => 'center',

				// Category
				'crel_kbCategories__cat_color'              => '#000000',
				'crel_kbCategories__cat_backgroundColor'    => '#F8F8F8',
				'crel_kbCategories__cat_padding'            => [
					'top'       => '12',
					'left'      => '12',
					'right'     => '12',
					'bottom'    => '12',
					'unit'      => 'px'
				],
				'crel_kbCategories__cat_margin'            => [
					'top'       => '0',
					'left'      => '5',
					'right'     => '5',
					'bottom'    => '0',
					'unit'      => 'px'
				],
				'crel_kbCategories__fixedWidth_toggle'      => 'no',
				'crel_kbCategories__cat_borderType_border'  => 'solid',
				'crel_kbCategories__cat_borderType_width'   => [
					'top' => '0',
					'left' => '1',
					'right' => '1',
					'bottom' => '0',
					'unit' => 'px'
				],
				'crel_kbCategories__cat_borderType_color'   => '#000000',

				// Category Icon
				'crel_kbCategories__icon_size'              => [
					'size' => '40',
					'unit' => 'px',
					'sizes' => []
				],

			)
		);

		// Design 10
		$options['design-10'] = array(
			'title' => __( 'Box Layout 6', 'creative-addons-for-elementor'),
			'preview_url' => $this->presets_preview_url( 'kb-categories-design-10.png' ),

			'options' => array(

				// Title
				'crel_kbCategories__title_alignment'        => 'center',

				// List
				'crel_kbCategories__list_layout'            => 'row',
				'crel_kbCategories__list_alignment'         => 'center',

				// Category
				'crel_kbCategories__cat_color'              => '#000000',
				'crel_kbCategories__cat_backgroundColor'    => '',
				'crel_kbCategories__cat_padding'            => [
					'top'       => '12',
					'left'      => '12',
					'right'     => '12',
					'bottom'    => '12',
					'unit'      => 'px'
				],
				'crel_kbCategories__cat_margin'            => [
					'top'       => '0',
					'left'      => '5',
					'right'     => '5',
					'bottom'    => '0',
					'unit'      => 'px'
				],
				'crel_kbCategories__fixedWidth_toggle'      => 'no',
				'crel_kbCategories__cat_borderType_border'  => 'solid',
				'crel_kbCategories__cat_borderType_width'   => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '0',
					'unit' => 'px'
				],
				'crel_kbCategories__cat_borderType_color'   => '#000000',

				// Category Icon
				'crel_kbCategories__icon_size'              => [
					'size' => '40',
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

        $this->start_controls_section(
            'crel_kbCategories__content_section_content',
            [
                'label' => __( 'Content', 'creative-addons-for-elementor' ),
                'tab' => Controls_Manager::TAB_CONTENT
            ]
        );
			
			// Show Title Toggle
			$this->add_control(
				'crel_kbCategories__title_toggle',
				[
					'label'     => __( 'Show Title', 'creative-addons-for-elementor'),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => __( 'Yes', 'creative-addons-for-elementor'),
					'label_off' => __( 'No', 'creative-addons-for-elementor'),
					'force_preset' => true
				]
			);

			// Title Text
			$this->add_control(
				'crel_kbCategories__title_text',
				[
					'label' => __( 'Title', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::TEXT,
					'placeholder' => __( 'Type your text here', 'creative-addons-for-elementor' ),
					'condition'	=> [
						'crel_kbCategories__title_toggle'	=> 'yes'
					]
				]
			);
			
			// Title HTML Tag
			$this->add_control(
			'crel_kbCategories__title_HTMLTag',
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
					'crel_kbCategories__title_toggle'	=> 'yes'
				]
			]
		);

			// Category Filter
			$this->add_control(
				'crel_kbCategories__categories_filter',
				[
					'label' => __( 'Show Categories', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::SELECT,
					'options' => array(
						'all' => __( 'All', 'creative-addons-for-elementor' ),
						'top' => __( 'Top', 'creative-addons-for-elementor' ),
					)
				]
			);
			
			$this->add_control(
				'crel_kbCategories__categories_ids_text',
				[
					'label' => __( 'Category ID(s):', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::TEXT,
					'placeholder' => __( 'Add categories id, separated by comma', 'creative-addons-for-elementor' ),
				]
			);

        $this->end_controls_section();
    }

	protected function register_style_controls() {
		
		// TITLE  ----------------------------------[SECTION]-------------/
	    $this->start_controls_section(
		    'crel_kbCategories__Title__section__StyleTab',
		    [
			    'label' => __( 'Title', 'creative-addons-for-elementor' ),
			    'tab' => Controls_Manager::TAB_STYLE,
		    ]
	    );
			
			
			// Title Padding
			$this->add_responsive_control(
				'crel_kbCategories__title_padding',
				[
					'label' => __( 'Padding', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						'{{WRAPPER}} .crel-kb-cat-list-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],

				]
			);
			
			// Alignment
			$this->add_control(
				'crel_kbCategories__title_alignment',
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
						'{{WRAPPER}} .crel-kb-cat-list-title'           => 'justify-content: {{VALUE}};',
					],
				]
			);
			
			// Title Color
			$this->add_control(
				'crel_kbCategories__title_color',
				[
					'label' => __( 'Text Color', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crel-kb-cat-list-title' => 'color: {{VALUE}};',
					],
				]
			);

			// Background Color
			$this->add_control(
				'crel_kbCategories__title_backgroundColor',
				[
					'label' => __( 'Background Color', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crel-kb-cat-list-title' => 'background-color: {{VALUE}};',
					],
				]
			);

			// Title Typography
			$this->add_group_control(
				Group_Control_Typography::get_type(),
				[
					'name' => 'crel_kbCategories__title_typography',
					'selector' => '{{WRAPPER}} .crel-kb-cat-list-title',
				]
			);
			
			// Border Type
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'crel_kbCategories__title_borderType',
					'label' => esc_html__( 'Border', 'creative-addons-for-elementor'),
					'selector' => '{{WRAPPER}} .crel-kb-cat-list-title',
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

			// Title Margin
			$this->add_responsive_control(
				'crel_kbCategories__title_margin',
				[
					'label' => __( 'Margin', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						'{{WRAPPER}} .crel-kb-cat-list-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],

				]
			);
			
	    $this->end_controls_section();

		// List  ----------------------------------[SECTION]-------------/

		$this->start_controls_section(
				'crel_kbCategories__List__section__StyleTab',
				[
						'label' => __( 'List', 'creative-addons-for-elementor' ),
						'tab' => Controls_Manager::TAB_STYLE,
				]
		);

			// Layout
			$this->add_responsive_control(
				'crel_kbCategories__list_layout',
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
					'crel_kbCategories__list_paddingTopBottom',
					[
							'label' => __( 'Space Between', 'creative-addons-for-elementor' ),
							'type' => Controls_Manager::SLIDER,
							'range' => [
									'px' => [
											'max' => 50,
									],
							],
							'selectors' => [
								'{{WRAPPER}} .crel-kb-categories-list--col .crel-kb-cat-list-item__item:not(:first-child)' => 'padding-top: calc({{SIZE}}{{UNIT}}/2)',
								'{{WRAPPER}} .crel-kb-categories-list--col .crel-kb-cat-list-item__item:not(:last-child)' => 'padding-bottom: calc({{SIZE}}{{UNIT}}/2)',
								'{{WRAPPER}} .crel-kb-categories-list--row .crel-kb-cat-list-item__item' => 'padding: calc({{SIZE}}{{UNIT}}/2)',
							],

					]
			);

			// List OffSet
			$this->add_responsive_control(
				'crel_kbCategories__list_offSet',
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
						'{{WRAPPER}} .crel-kb-categories-list--col .crel-kb-cat-list-item__item--level-1>a' => 'padding-left: {{SIZE}}px !important;',
						'{{WRAPPER}} .crel-kb-categories-list--col .crel-kb-cat-list-item__item--level-2>a' => 'padding-left: calc({{SIZE}}{{UNIT}}*2) !important;',
						'{{WRAPPER}} .crel-kb-categories-list--col .crel-kb-cat-list-item__item--level-3>a' => 'padding-left: calc({{SIZE}}{{UNIT}}*3) !important;',
						'{{WRAPPER}} .crel-kb-categories-list--col .crel-kb-cat-list-item__item--level-4>a' => 'padding-left: calc({{SIZE}}{{UNIT}}*4) !important;',
						'{{WRAPPER}} .crel-kb-categories-list--col .crel-kb-cat-list-item__item--level-5>a' => 'padding-left: calc({{SIZE}}{{UNIT}}*5) !important;',
					],
					'condition'	=> [
						'crel_kbCategories__list_layout'	=> 'col'
					],
				]
			);

			// Alignment
			$this->add_control(
				'crel_kbCategories__list_alignment',
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
						'{{WRAPPER}} .crel-kb-cat-list-items-container' => 'justify-content: {{VALUE}};',
						'{{WRAPPER}} .crel-kb-cat-list-item__item a'    => 'justify-content: {{VALUE}};',
					],
				]
			);

			// Icon Position
			$this->add_responsive_control(
			    'crel_kbCategories__icon_position',
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

		// Category -------------------------------[SECTION]-------------/
		$this->start_controls_section(
			'crel_kbCategories_section_text_style',
			[
				'label' => __( 'Category', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

			// Typography
			$this->add_group_control(
				'typography',
				[
					'name' => 'crel_kbCategories__cat_typography',
					'selector' => '{{WRAPPER}} .crel-kb-cat-list-item__item a',
					'scheme' => Schemes\Typography::TYPOGRAPHY_3,
				]
			);

			// Fixed Width Toggle
			$this->add_control(
				'crel_kbCategories__fixedWidth_toggle',
				[
					'label'     => __( 'Fixed Width', 'creative-addons-for-elementor'),
					'type'      => Controls_Manager::SWITCHER,
					'label_on'  => __( 'Yes', 'creative-addons-for-elementor'),
					'label_off' => __( 'No', 'creative-addons-for-elementor'),
					'condition'	=> [
						'crel_kbCategories__list_layout'	=> 'row'
					]

				]
			);

			// Fixed Width
			$this->add_responsive_control(
				'crel_kbCategories__cat_width',
				[
					'label' => __( 'Fixed Width', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::SLIDER,
					'range' => [
						'px' => [
							'max' => 1500,
						],
					],
					'selectors' => [
						'{{WRAPPER}} .crel-kb-cat-list-items-container li' => 'width:{{SIZE}}{{UNIT}}',
					],
					'condition'	=> [
						'crel_kbCategories__fixedWidth_toggle'	=> 'yes'
					]
				]
			);

			// Margin
			$this->add_responsive_control(
				'crel_kbCategories__cat_margin',
				[
					'label' => __( 'Margin', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						'{{WRAPPER}} .crel-kb-cat-list-item__item' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			// Padding
			$this->add_responsive_control(
				'crel_kbCategories__cat_padding',
				[
					'label' => __( 'Padding', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						'{{WRAPPER}} .crel-kb-cat-list-item__item a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			// Text Color
			$this->add_control(
				'crel_kbCategories__cat_color',
				[
					'label' => __( 'Text Color', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crel-kb-cat-list-item__item .crel-kb-cat-list-items__item__text' => 'color: {{VALUE}};',
					],
					'scheme' => [
						'type' => Schemes\Color::get_type(),
						'value' => Schemes\Color::COLOR_2,
					],
				]
			);

			// Background Color
			$this->add_control(
				'crel_kbCategories__cat_backgroundColor',
				[
					'label' => __( 'Background Color', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crel-kb-cat-list-item__item a' => 'background-color: {{VALUE}};',
					],
				]
			);

			// Border Type
			$this->add_group_control(
				Group_Control_Border::get_type(),
				[
					'name' => 'crel_kbCategories__cat_borderType',
					'label' => esc_html__( 'Border', 'creative-addons-for-elementor'),
					'selector' => '{{WRAPPER}} .crel-kb-cat-list-item__item a'
				]
			);

			// Text Hover Color
			$this->add_control(
				'crel_kbCategories__cat_colorHover',
				[
					'label' => __( 'Hover', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crel-kb-cat-list-item__item a:hover .crel-kb-cat-list-items__item__text' => 'color: {{VALUE}};',
					],
				]
			);

			// Hover Background Color
			$this->add_control(
				'crel_kbCategories__cat_backgroundColorHover',
				[
					'label' => __( 'Hover Background Color', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::COLOR,
					'selectors' => [
						'{{WRAPPER}} .crel-kb-cat-list-item__item:hover' => 'background-color: {{VALUE}};',
					],
				]
			);

		$this->end_controls_section();

		// Category - Icon  ----------------------------------[SECTION]-------------/
		$this->start_controls_section(
				'crel_kbCategories_section_icon_style',
				[
						'label' => __( 'Category - Icon', 'creative-addons-for-elementor' ),
						'tab' => Controls_Manager::TAB_STYLE,
				]
		);
		
			// populate with random number and update with JS if user changes KB #
			$link_template = str_replace( '155', 'crel_kb_id', 'edit-tags.php?taxonomy=' . KB_Handler::get_category_taxonomy_name( 155 ) .'&post_type=' .
															   KB_Handler::get_post_type( 155 ) );
			
			$this->add_notice_control( sprintf( __( 'You can edit categories icons on the %s Knowledge Base Categories page %s',
			 'creative-addons-for-elementor' ), '<a href="' . admin_url( $link_template ) . '" target="_blank">', '</a>' ), 'info', [], 'crel_kbCategories_redirect_to_category' );

			// Icon Size
			$this->add_responsive_control(
					'crel_kbCategories__icon_size',
					[
							'label' => __( 'Size', 'creative-addons-for-elementor' ),
							'type' => Controls_Manager::SLIDER,
							'range' => [
									'px' => [
											'min' => 6,
									],
							],
							'selectors' => [
									'{{WRAPPER}} .crel-kb-cat-list-item__item .crel-kb-cat-list-items__item__icon i' => 'font-size: {{SIZE}}{{UNIT}};',
									'{{WRAPPER}} .crel-kb-cat-list-item__item .crel-kb-cat-list-items__item__icon img' => 'max-height: {{SIZE}}{{UNIT}};',
							],
					]
			);
			
			 // Icon Margin
			$this->add_responsive_control(
				'crel_kbCategories__icon_margin',
				[
					'label' => __( 'Margin', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						'{{WRAPPER}} .crel-kb-cat-list-item__item .crel-kb-cat-list-items__item__icon' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			// Icon Padding
			$this->add_responsive_control(
				'crel_kbCategories__icon_padding',
				[
					'label' => __( 'Padding', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', 'em', '%' ],
					'selectors' => [
						'{{WRAPPER}} .crel-kb-cat-list-item__item .crel-kb-cat-list-items__item__icon' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			// Icon Color
			$this->add_control(
					'crel_kbCategories__icon_color',
					[
							'label' => __( 'Color', 'creative-addons-for-elementor' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
									'{{WRAPPER}} .crel-kb-cat-list-item__item .crel-kb-cat-list-items__item__icon i' => 'color: {{VALUE}};',
							],
							'scheme' => [
									'type' => Schemes\Color::get_type(),
									'value' => Schemes\Color::COLOR_1,
							],
					]
			);

			// Icon Color Hover
			$this->add_control(
					'crel_kbCategories__icon_colorHover',
					[
							'label' => __( 'Hover', 'creative-addons-for-elementor' ),
							'type' => Controls_Manager::COLOR,
							'selectors' => [
									'{{WRAPPER}} .crel-kb-cat-list-item__item a:hover .crel-kb-cat-list-items__item__icon i' => 'color: {{VALUE}};',
							],
					]
			);

		$this->end_controls_section();




	}

	/**
	 * Render the widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	 */
	protected function render() {
		
		if ( ! $this->is_kb_plugin_activated() ) {
			return;
		}
		
		$settings = $this->get_settings_for_display();

		$categories_filter = empty($settings['crel_kbCategories__categories_filter']) ? 'all' : esc_attr( $settings['crel_kbCategories__categories_filter'] );
		$kb_id = $this->get_current_kb_id();
		$kb_config = KB_Utilities::get_kb_config( $kb_id );
		
		if ( empty( $kb_config['section_head_category_icon_location'] ) || $kb_config['section_head_category_icon_location'] == 'no_icons' ) {
			$categories_icons = false;
		} else {
			$categories_icons = Utilities::get_kb_option( $kb_id, KB_Handler::CATEGORIES_ICONS, array(), true );
		}


		$layout         = esc_attr($settings['crel_kbCategories__list_layout']);
		$title_active   = esc_attr($settings['crel_kbCategories__title_toggle']);
		$tag            = esc_attr($settings['crel_kbCategories__title_HTMLTag']);
		$category_title = esc_html($settings['crel_kbCategories__title_text']);
	    $icon_loc       = esc_attr($settings['crel_kbCategories__icon_position']);       ?>
		
		<div class="crel-kb-categories-list-container crel-kb-categories-list--<?php echo $layout ?> crel-kb-categories-list--<?php echo $icon_loc; ?>">

			<div class="crel-kb-cat-list__inner"><?php
				
				if ( $title_active === 'yes' ) {
					echo '<' . $tag . ' class="crel-kb-cat-list-title" >' . $category_title . '</'.$tag.'>';
				}
				
				$terms = $this->execute_search( $kb_id, $categories_filter, $this->retrieve_category_ids( $settings['crel_kbCategories__categories_ids_text'] ) );

				if ( empty($terms) ) {
		            echo esc_html__( 'Coming Soon', 'creative-addons-for-elementor' );

		        } else { ?>

						<ul class="crel-kb-cat-list-items-container">			        <?php
						   foreach( $terms as $category ) {
								$category_Level = 'crel-kb-cat-list-item__item--level-' . $category->level;
								$category_url = get_term_link( $category );
								if ( empty($category_url) || is_wp_error( $category_url ) ) {
									continue;
								} ?>

								<!-- List Item -->
								<li id="<?php echo 'crel-cat-' . $category->term_id; ?>" class="crel-kb-cat-list-item__item <?php echo esc_attr( $category_Level ); ?>">
									<a href="<?php echo esc_url( $category_url ); ?>">
										<?php if ( $categories_icons) $this->show_category_icon( $category->term_id, $categories_icons ); ?>
									   <span class="crel-kb-cat-list-items__item__text"><?php echo esc_html( $category->name ); ?></span>
									</a>
								</li>           <?php
						   }       ?>
						</ul>			        <?php

		        }       ?>
			</div>

		</div>		<?php
	}

	/**
	 * STYLE tab for this widget
	 * @param $attributes
	 * @return array
	 */
	private function retrieve_category_ids( $attributes ) {

	    $in_category_ids = empty( $attributes ) ? '' : Utilities::sanitize_comma_separated_ints( $attributes );

	    // get articles for each category
	    $category_ids = array();
	    foreach( explode(',', $in_category_ids) as $category_id ) {

		    if ( Utilities::is_positive_int( $category_id ) ) {
			    $category_ids[] = $category_id;
		    }
	    }

	    return $category_ids;
    }
	
	/**
	 * Call WP query to get matching terms (any term OR match)
	 *
	 * @param $kb_id
	 * @param $filter
	 * @param string $category_ids
	 *
	 * @return array
	 */
    private function execute_search( $kb_id, $filter, $category_ids='' ) {

	    if ( empty($category_ids) ) {
	    	if ( $filter == 'all' ) {
			    $args = array(
				    'orderby'    => 'name',
				    'hide_empty' => false  // if 'hide_empty' then do not return categories with no articles
			    );
		    } else {
			    $args = array(
				    'parent'     => 0,
				    'orderby'    => 'name',
				    'hide_empty' => false  // if 'hide_empty' then do not return categories with no articles
			    );
		    }
	    } else {
	    	$args = array(
			    'orderby'    => 'name',
			    'include'    => $category_ids
	        );
	    }

	    $terms = get_terms( KB_Handler::get_category_taxonomy_name( $kb_id ), $args );
	    if ( is_wp_error( $terms ) ) {
		    Logging::add_log( 'cannot get terms for kb_id', $kb_id, $terms );
		    return array();
	    } else if ( empty($terms) || ! is_array($terms) ) {
		    return array();
	    }
		
		$terms = array_values($terms); // rearrange array keys
		$terms = $this->sort_categories( $terms, $kb_id );
		
		if ( $filter == 'all' ) {
			$terms = $this->add_levels_to_categories( $terms, $kb_id );
		}
		
	    return $terms;   
    }
	
	// sort as in the KB config
	private function sort_categories( $terms, $kb_id ) {
		$sorted_terms = array();
		
		$category_seq_data = Utilities::get_kb_option( $kb_id, KB_Handler::KB_CATEGORIES_SEQ_META, array(), true );
		if ( empty($category_seq_data) ) {
			return $terms;
		}
		
		foreach ( $category_seq_data as $id_1 => $lvl2 ) {
			$sorted_terms[$id_1] = false;
			
			if ( $lvl2 ) {
				foreach ( $lvl2 as $id_2 => $lvl3 ) {
					$sorted_terms[$id_2] = false;
					
					if ( $lvl3 ) {
						foreach ( $lvl3 as $id_3 => $lvl4 ) {
							$sorted_terms[$id_3] = false;
							
							if ( $lvl4 ) {
								foreach ( $lvl4 as $id_4 => $lvl5 ) {
									$sorted_terms[$id_4] = false;
									
									if ( $lvl5 ) {
										foreach ( $lvl5 as $id_5 => $lvl6 ) {
											$sorted_terms[$id_5] = false;
											
											if ( $lvl6 ) {
												foreach ( $lvl6 as $id_6 => $lvl7 ) {
													$sorted_terms[$id_6] = false;
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}
		} 
		
		foreach ( $terms as $term ) {
			if ( isset( $sorted_terms[$term->term_id] ) ) {
				$sorted_terms[$term->term_id] = $term;
			}
		}
		
		// remove not used categories 
		foreach ( $sorted_terms as $term_id => $term ) {
			if ( ! $term ) {
				unset( $sorted_terms[$term_id] );
			}
		}
		
		return $sorted_terms;
	}
	
	private function add_levels_to_categories( $terms, $kb_id ) {
		$new_terms = array();
		
		// add ancestors to all categories 
		foreach ( $terms as $category ) {
			$category->ancestors = get_ancestors( $category->term_id, KB_Handler::get_category_taxonomy_name( $kb_id ) );
		}
		// build new array with all accentors
		foreach ( $terms as $category ) {
			$new_terms[$category->term_id] = array(
				'name' => $category->name,
				'ancestors' => get_ancestors( $category->term_id, KB_Handler::get_category_taxonomy_name( $kb_id ) )
			);
		}

		foreach ( $new_terms as $term_id => $category ) {
			
			$have_parent = false;
			
			foreach ( $category['ancestors'] as $ancestor_id ) {
				if ( isset( $new_terms[$ancestor_id] ) ) {
					$new_terms[$ancestor_id]['children'][$term_id] = &$new_terms[$term_id];
					$have_parent = true;
					break;
				}
			}
			
			// if we are here - there no ancestors in current list for the current article - null it
			if ( !$have_parent ) {
				$category['ancestors'] = array();
			}
			
		}
		
		// now we have a tree and we should show it like a list.
		$list_with_depth = array();
		
		foreach ( $new_terms as $term_id => $category ) {
			// level 0
			if ( empty( $category['ancestors'] ) ) {
				foreach ( $terms as $tid => $term ) {
					if ( $term->term_id == $term_id ) {
						$term->level = 0;
						$list_with_depth[] = $term;
						unset( $terms[$tid] );
					}
				}
				
				if ( ! empty( $category['children'] ) ) {
					// level 1
					foreach ( $category['children'] as $id_1 => $category_1 ) {
						foreach ( $terms as $tid => $term ) {
							if ( $term->term_id == $id_1 ) {
								$term->level = 1;
								$list_with_depth[] = $term;
								unset( $terms[$tid] );
							}
						}
						
						// level 2
						if ( ! empty( $category_1['children'] ) ) {
							foreach ( $category_1['children'] as $id_2 => $category_2 ) {
								foreach ( $terms as $tid => $term ) {
									if ( $term->term_id == $id_2 ) {
										$term->level = 2;
										$list_with_depth[] = $term;
										unset( $terms[$tid] );
									}
								}
								
								// level 3
								if ( ! empty( $category_2['children'] ) ) {
									foreach ( $category_2['children'] as $id_3 => $category_3 ) {
										foreach ( $terms as $tid => $term ) {
											if ( $term->term_id == $id_3 ) {
												$term->level = 3;
												$list_with_depth[] = $term;
												unset( $terms[$tid] );
											}
										}
										
										// level 4
										if ( ! empty( $category_3['children'] ) ) {
											foreach ( $category_3['children'] as $id_4 => $category_4 ) {
												foreach ( $terms as $tid => $term ) {
													if ( $term->term_id == $id_4 ) {
														$term->level = 4;
														$list_with_depth[] = $term;
														unset( $terms[$tid] );
													}
												}
												
												// level 5
												if ( ! empty( $category_4['children'] ) ) {
													foreach ( $category_4['children'] as $id_5 => $category_5 ) {
														foreach ( $terms as $tid => $term ) {
															if ( $term->term_id == $id_5 ) {
																$term->level = 5;
																$list_with_depth[] = $term;
																unset ( $terms[$tid] );
															}
														}
														
														// level 6 - not now
														
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}

		return $list_with_depth;
	}

	/**
	 * Display KB Category icon based on existing configuration.
	 * @param $term_id
	 * @param $categories_icons
	 */
	private function show_category_icon( $term_id, $categories_icons ) {
		$icon = KB_Handler::get_category_icon( $term_id, $categories_icons );
		if ( empty($icon['type']) ) {
			return;
		}

		if ( $icon['type'] == 'font' ) {		
			$icon['name'] = KB_Utilities::replace_icons_name($icon['name']);		?>
			<span class="crel-kb-cat-list-items__item__icon"><i aria-hidden="true" class="crelfa <?php echo esc_attr( $icon['name'] ); ?>"></i></span><?php
		} else { ?>
			<span class="crel-kb-cat-list-items__item__icon"><img src="<?php echo esc_attr( $icon['image_thumbnail_url'] ); ?>"></span><?php
		}
	}
}