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
use Elementor\Plugin;

defined( 'ABSPATH' ) || exit();


/**
 * Code Block widget for Elementor
 */
class Code_Block extends Creative_Widget_Base {

	public function __construct($data = [], $args = null) {
		parent::__construct( $data, $args );
		$this->register_crel_script( 'code_block' );
		
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
		wp_register_script( 'creative-addons-code_block', CREATIVE_ADDONS_DIR_URL . 'assets/js/code_block' . $suffix . '.js', [ 'elementor-frontend' ], CREATIVE_ADDONS_VERSION, true );
		wp_register_script( 'creative-addons-prism', CREATIVE_ADDONS_DIR_URL . 'assets/js/vendor/prism.js' );
		
		$this->widget_scripts[] = 'creative-addons-prism';
		$this->widget_scripts[] = 'creative-addons-code_block';
		$this->widget_styles[] = 'creative-addons-prism';
	}
	
	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Code Block', 'creative-addons-for-elementor' );
	}
	
	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'crelfont crel-code-block-icon';
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
		return [ 'code', 'text', 'instruction', 'source', 'code block' ];
	}

	protected function get_config_defaults() {
		return [

			// Content Tab -------------------------------------------------/
			'crel_code_block__language' => 'php',
			'crel_Generic__Presets' => 'crel-default',
			'crel_code_block__text' => __(
'// hello world function
 function hell_world( $post_type_params ) {             
     $post_type_params[\'hierarchical\'] = true;
     if ( empty($post_type_params) ) {
         helper();
     }
     return \'success\';
 }',

			'creative-addons-for-elementor' ),
			'crel_code_block__toolbar_toggle'	                        => 'yes',

			'crel_code_block__copy_icon'                            => [
				'value' => 'fas fa-copy',
				'library' => 'fa-solid',
			],

			'crel_code_block__expand_icon'                            => [
				'value' => 'fas fa-expand',
				'library' => 'fa-solid',
			],
			// Style Tab ---------------------------------------------------/
			'crel_code_block__code_max_height'	                => [
				'size' => 250,
				'unit' => 'px',
				'sizes' => []
			],
			
			'crel_code_block__code_typography_typography'         => 'custom',
			
			'crel_code_block__code_typography_font_size'   => [
				'size' => 14,
				'unit' => 'px',
				'sizes' => []
			],
			
			// General ---------------------------------/
			
			// Advanced ---------------------------------/
			'crel_code_block__code_border_border' => 'solid',
			'crel_code_block__code_border_color' => '#ddd',
			'crel_code_block__code_border_width' => [
				'top' => '0',
				'right' => '0',
				'bottom' => '0',
				'left' => '0',
				'isLinked' => false,
				'unit' => 'px'
			],

			'crel_code_block__container_border'                     => 'solid',
			'crel_code_block__container_border_border'              => 'solid',
			'crel_code_block__container_border_width'               => [
				'top' => '1',
				'left' => '1',
				'right' => '1',
				'bottom' => '1',
				'unit' => 'px',
				'isLinked' => false
			],
			'crel_code_block__container_border_color'               => '#E5E5E5',
			'crel_code_block__container_border_radius'              => [
				'size' => '13',
				'unit' => 'px',
				'sizes' => []
			],
			'crel_code_block__language_color'                       => '#FBDE2D',
			'crel_code_block__language_border'                      => 'solid',
			'crel_code_block__language_border_border'               => 'solid',
			'crel_code_block__language_border_width'                => [
				'top' => '0',
				'left' => '0',
				'right' => '0',
				'bottom' => '1',
				'unit' => 'px',
				'isLinked' => false
			],
			'crel_code_block__language_border_color'                => '#E5E5E5',
			'crel_code_block__header_background_color'              => '#0A0E1E',
			'crel_code_block__language_header_padding'              => [
				'top'       => '12',
				'right'     => '12',
				'bottom'    => '12',
				'left'      => '12',
				'isLinked'  => false,
				'unit'      => 'px'
			],
			
		];
	}

	protected function get_config_rtl_defaults() {
		return [];
	}

	protected function get_presets_defaults() {
		return [
			'crel_code_block__language' => 'clike',
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
		
		$options['crel-default'] = array(
			'title' => __( 'Default', 'creative-addons-for-elementor' ),
			'preview_url'   => $this->presets_preview_url( 'code-block-design-1.jpg' ),
			'options' => array()
		);
		
		$options['crel-coy'] = array(
			'title' => __( 'Coy', 'creative-addons-for-elementor' ),
			'preview_url'   => $this->presets_preview_url( 'code-block-design-2.jpg' ),
			'options' => array(
				'crel_code_block__container_border'                     => 'none',
				'crel_code_block__container_border_border'              => 'none',
				'crel_code_block__container_border_width'               => [
					'top' => '1',
					'left' => '1',
					'right' => '1',
					'bottom' => '1',
					'unit' => 'px',
					'isLinked' => false
				],
				'crel_code_block__container_border_color'               => '#E5E5E5',
				'crel_code_block__container_border_radius'               => [
					'size' => '0',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_code_block__language_color'                       => '#358CCB',
				'crel_code_block__language_border'                      => 'solid',
				'crel_code_block__language_border_border'               => 'solid',
				'crel_code_block__language_border_width'                => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '1',
					'unit' => 'px',
					'isLinked' => false
				],
				'crel_code_block__language_border_color'                => '#E5E5E5',
				'crel_code_block__header_background_color'              => '#F5F8FB',
				'crel_code_block__language_header_padding'              => [
					'top'       => '12',
					'right'     => '12',
					'bottom'    => '12',
					'left'      => '12',
					'isLinked'  => false,
					'unit'      => 'px'
				],
			)

		);
		
		$options['crel-dark'] = array(
			'title' => __( 'Dark', 'creative-addons-for-elementor' ),
			'preview_url'   => $this->presets_preview_url( 'code-block-design-3.jpg' ),
			'options' => array(
				'crel_code_block__container_border'                     => 'none',
				'crel_code_block__container_border_border'              => 'none',
				'crel_code_block__container_border_width'               => [
					'top' => '1',
					'left' => '1',
					'right' => '1',
					'bottom' => '1',
					'unit' => 'px',
					'isLinked' => false
				],
				'crel_code_block__container_border_color'               => '#E5E5E5',
				'crel_code_block__container_border_radius'               => [
					'size' => '13',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_code_block__language_color'                       => '#FFFFFF',
				'crel_code_block__language_border'                      => 'solid',
				'crel_code_block__language_border_border'               => 'solid',
				'crel_code_block__language_border_width'                => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '1',
					'unit' => 'px',
					'isLinked' => false
				],
				'crel_code_block__language_border_color'                => '#E5E5E5',
				'crel_code_block__header_background_color'              => '#483B2F',
				'crel_code_block__language_header_padding'              => [
					'top'       => '12',
					'right'     => '12',
					'bottom'    => '12',
					'left'      => '12',
					'isLinked'  => false,
					'unit'      => 'px'
				],
			)
		);
		
		$options['crel-fanky'] = array(
			'title' => __( 'Fanky', 'creative-addons-for-elementor' ),
			'preview_url'   => $this->presets_preview_url( 'code-block-design-4.jpg' ),
			'options' => array(
				'crel_code_block__container_border'                     => 'solid',
				'crel_code_block__container_border_border'              => 'solid',
				'crel_code_block__container_border_width'               => [
					'top' => '1',
					'left' => '1',
					'right' => '1',
					'bottom' => '1',
					'unit' => 'px',
					'isLinked' => false
				],
				'crel_code_block__container_border_color'               => '#E5E5E5',
				'crel_code_block__container_border_radius'               => [
					'size' => '0',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_code_block__language_color'                       => '#000000',
				'crel_code_block__language_border'                      => 'solid',
				'crel_code_block__language_border_border'               => 'solid',
				'crel_code_block__language_border_width'                => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '1',
					'unit' => 'px',
					'isLinked' => false
				],
				'crel_code_block__language_border_color'                => '#CCCCCC',
				'crel_code_block__header_background_color'              => '#CCCCCC',
				'crel_code_block__language_header_padding'              => [
					'top'       => '12',
					'right'     => '12',
					'bottom'    => '12',
					'left'      => '12',
					'isLinked'  => false,
					'unit'      => 'px'
				],
			)
		);
		
		$options['crel-okaidia'] = array(
			'title' => __( 'Okaidia', 'creative-addons-for-elementor' ),
			'preview_url'   => $this->presets_preview_url( 'code-block-design-5.jpg' ),
			'options' => array(
				'crel_code_block__container_border'                     => 'solid',
				'crel_code_block__container_border_border'              => 'solid',
				'crel_code_block__container_border_width'               => [
					'top' => '1',
					'left' => '1',
					'right' => '1',
					'bottom' => '1',
					'unit' => 'px',
					'isLinked' => false
				],
				'crel_code_block__container_border_color'               => '#E5E5E5',
				'crel_code_block__container_border_radius'               => [
					'size' => '13',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_code_block__language_color'                       => '#FFA600',
				'crel_code_block__language_border'                      => 'solid',
				'crel_code_block__language_border_border'               => 'solid',
				'crel_code_block__language_border_width'                => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '1',
					'unit' => 'px',
					'isLinked' => false
				],
				'crel_code_block__language_border_color'                => '#0A0A0A',
				'crel_code_block__header_background_color'              => '#272822',
				'crel_code_block__language_header_padding'              => [
					'top'       => '12',
					'right'     => '12',
					'bottom'    => '12',
					'left'      => '12',
					'isLinked'  => false,
					'unit'      => 'px'
				],
			)
		);
		
		$options['crel-solarized-light'] = array(
			'title' => __( 'Solarized Light', 'creative-addons-for-elementor' ),
			'preview_url'   => $this->presets_preview_url( 'code-block-design-6.jpg' ),
			'options' => array(
				'crel_code_block__container_border'                      => 'solid',
				'crel_code_block__container_border_border'               => 'solid',
				'crel_code_block__container_border_width'                => [
					'top' => '1',
					'left' => '1',
					'right' => '1',
					'bottom' => '1',
					'unit' => 'px',
					'isLinked' => false
				],
				'crel_code_block__container_border_color'                => '#E5E5E5',
				'crel_code_block__container_border_radius'               => [
					'size' => '0',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_code_block__language_color'                       => '#000000',
				'crel_code_block__language_border'                      => 'solid',
				'crel_code_block__language_border_border'               => 'solid',
				'crel_code_block__language_border_width'                => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '1',
					'unit' => 'px',
					'isLinked' => false
				],
				'crel_code_block__language_border_color'                => '#E5E5E5',
				'crel_code_block__header_background_color'              => '#FEFFF1',
				'crel_code_block__language_header_padding'              => [
					'top'       => '12',
					'right'     => '12',
					'bottom'    => '12',
					'left'      => '12',
					'isLinked'  => false,
					'unit'      => 'px'
				],
			)
		);
		
		$options['crel-codemirror-default'] = array(
			'title' => __( 'Codemirror Default', 'creative-addons-for-elementor' ),
			'preview_url'   => $this->presets_preview_url( 'code-block-design-7.jpg' ),
			'options' => array(
				'crel_code_block__container_border'                     => 'solid',
				'crel_code_block__container_border_border'              => 'solid',
				'crel_code_block__container_border_width'               => [
					'top' => '1',
					'left' => '1',
					'right' => '1',
					'bottom' => '1',
					'unit' => 'px',
					'isLinked' => false
				],
				'crel_code_block__container_border_color'               => '#E5E5E5',
				'crel_code_block__container_border_radius'              => [
					'size' => '0',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_code_block__language_color'                       => '#A75AB2',
				'crel_code_block__language_border'                      => 'solid',
				'crel_code_block__language_border_border'               => 'solid',
				'crel_code_block__language_border_width'                => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '1',
					'unit' => 'px',
					'isLinked' => false
				],
				'crel_code_block__language_border_color'                => '#E5E5E5',
				'crel_code_block__header_background_color'              => '#FFFFFF',
				'crel_code_block__language_header_padding'              => [
					'top'       => '12',
					'right'     => '12',
					'bottom'    => '12',
					'left'      => '12',
					'isLinked'  => false,
					'unit'      => 'px'
				],
			)
		);
		
		$options['crel-blackboard'] = array(
			'title' => __( 'Blackboard', 'creative-addons-for-elementor' ),
			'preview_url'   => $this->presets_preview_url( 'code-block-design-8.jpg' ),
			'options' => array(
				'crel_code_block__container_border'                     => 'solid',
				'crel_code_block__container_border_border'              => 'solid',
				'crel_code_block__container_border_width'               => [
					'top' => '1',
					'left' => '1',
					'right' => '1',
					'bottom' => '1',
					'unit' => 'px',
					'isLinked' => false
				],
				'crel_code_block__container_border_color'               => '#E5E5E5',
				'crel_code_block__container_border_radius'              => [
					'size' => '13',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_code_block__language_color'                       => '#FBDE2D',
				'crel_code_block__language_border'                      => 'solid',
				'crel_code_block__language_border_border'               => 'solid',
				'crel_code_block__language_border_width'                => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '1',
					'unit' => 'px',
					'isLinked' => false
				],
				'crel_code_block__language_border_color'                => '#E5E5E5',
				'crel_code_block__header_background_color'              => '#0A0E1E',
				'crel_code_block__language_header_padding'              => [
					'top'       => '12',
					'right'     => '12',
					'bottom'    => '12',
					'left'      => '12',
					'isLinked'  => false,
					'unit'      => 'px'
				],
			)
		);
		
		$options['crel-hopscotch'] = array(
			'title' => __( 'Hopscotch', 'creative-addons-for-elementor' ),
			'preview_url'   => $this->presets_preview_url( 'code-block-design-9.jpg' ),
			'options' => array(
				'crel_code_block__container_border'                     => 'solid',
				'crel_code_block__container_border_border'              => 'solid',
				'crel_code_block__container_border_width'               => [
					'top' => '1',
					'left' => '1',
					'right' => '1',
					'bottom' => '1',
					'unit' => 'px',
					'isLinked' => false
				],
				'crel_code_block__container_border_color'               => '#E5E5E5',
				'crel_code_block__container_border_radius'              => [
					'size' => '13',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_code_block__language_color'                       => '#F7C757',
				'crel_code_block__language_border'                      => 'solid',
				'crel_code_block__language_border_border'               => 'solid',
				'crel_code_block__language_border_width'                => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '1',
					'unit' => 'px',
					'isLinked' => false
				],
				'crel_code_block__language_border_color'                => '#E5E5E5',
				'crel_code_block__header_background_color'              => '#2C242B',
				'crel_code_block__language_header_padding'              => [
					'top'       => '12',
					'right'     => '12',
					'bottom'    => '12',
					'left'      => '12',
					'isLinked'  => false,
					'unit'      => 'px'
				],
			)
		);
		
		$options['crel-dracula-1'] = array(
			'title' => __( 'Dracula - 1', 'creative-addons-for-elementor' ),
			'preview_url'   => $this->presets_preview_url( 'code-block-design-10.jpg' ),
			'options' => array(
				'crel_code_block__container_border'                     => 'solid',
				'crel_code_block__container_border_border'              => 'solid',
				'crel_code_block__container_border_width'               => [
					'top' => '1',
					'left' => '1',
					'right' => '1',
					'bottom' => '1',
					'unit' => 'px',
					'isLinked' => false
				],
				'crel_code_block__container_border_color'               => '#E5E5E5',
				'crel_code_block__container_border_radius'              => [
					'size' => '13',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_code_block__language_color'                       => '#F3BC69',
				'crel_code_block__language_border'                      => 'solid',
				'crel_code_block__language_border_border'               => 'solid',
				'crel_code_block__language_border_width'                => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '1',
					'unit' => 'px',
					'isLinked' => false
				],
				'crel_code_block__language_border_color'                => '#E5E5E5',
				'crel_code_block__header_background_color'              => '#2A2229',
				'crel_code_block__language_header_padding'              => [
					'top'       => '12',
					'right'     => '12',
					'bottom'    => '12',
					'left'      => '12',
					'isLinked'  => false,
					'unit'      => 'px'
				],
			)
		);
		
		$options['crel-dracula-2'] = array(
			'title' => __( 'Dracula - 2', 'creative-addons-for-elementor' ),
			'preview_url'   => $this->presets_preview_url( 'code-block-design-11.jpg' ),
			'options' => array(
				'crel_code_block__container_border'                     => 'solid',
				'crel_code_block__container_border_border'              => 'solid',
				'crel_code_block__container_border_width'               => [
					'top' => '1',
					'left' => '1',
					'right' => '1',
					'bottom' => '1',
					'unit' => 'px',
					'isLinked' => false
				],
				'crel_code_block__container_border_color'               => '#E5E5E5',
				'crel_code_block__container_border_radius'              => [
					'size' => '13',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_code_block__language_color'                       => '#E6EF86',
				'crel_code_block__language_border'                      => 'solid',
				'crel_code_block__language_border_border'               => 'solid',
				'crel_code_block__language_border_width'                => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '1',
					'unit' => 'px',
					'isLinked' => false
				],
				'crel_code_block__language_border_color'                => '#E5E5E5',
				'crel_code_block__header_background_color'              => '#21232E',
				'crel_code_block__language_header_padding'              => [
					'top'       => '12',
					'right'     => '12',
					'bottom'    => '12',
					'left'      => '12',
					'isLinked'  => false,
					'unit'      => 'px'
				],
			)
		);
		
		$options['crel-ttcn'] = array(
			'title' => __( 'TTCN', 'creative-addons-for-elementor' ),
			'preview_url'   => $this->presets_preview_url( 'code-block-design-12.jpg' ),
			'options' => array(
				'crel_code_block__container_border'                     => 'solid',
				'crel_code_block__container_border_border'              => 'solid',
				'crel_code_block__container_border_width'               => [
					'top' => '1',
					'left' => '1',
					'right' => '1',
					'bottom' => '1',
					'unit' => 'px',
					'isLinked' => false
				],
				'crel_code_block__container_border_color'               => '#E5E5E5',
				'crel_code_block__container_border_radius'              => [
					'size' => '0',
					'unit' => 'px',
					'sizes' => []
				],
				'crel_code_block__language_color'                       => '#181818',
				'crel_code_block__language_border'                      => 'solid',
				'crel_code_block__language_border_border'               => 'solid',
				'crel_code_block__language_border_width'                => [
					'top' => '0',
					'left' => '0',
					'right' => '0',
					'bottom' => '1',
					'unit' => 'px',
					'isLinked' => false
				],
				'crel_code_block__language_border_color'                => '#E5E5E5',
				'crel_code_block__header_background_color'              => '#FBFBFB',
				'crel_code_block__language_header_padding'              => [
					'top'       => '12',
					'right'     => '12',
					'bottom'    => '12',
					'left'      => '12',
					'isLinked'  => false,
					'unit'      => 'px'
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

		$this->start_controls_section(
			'crel_code_block__header_styles_section_controls',
			[
				'label' => __( 'Header Toolbar', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT
			]
		);

		// Show Header
		$this->add_control(
			'crel_code_block__toolbar_toggle',
			[
				'label' => __( 'Show Toolbar', 'creative-addons-for-elementor'),
				'type' => Controls_Manager::SWITCHER,
				'label_on'  => __( 'Yes', 'creative-addons-for-elementor'),
				'label_off' => __( 'No', 'creative-addons-for-elementor'),
				//'force_preset' => true
			]
		);

		$this->add_control(
			'crel_code_block__copy_icon',
			[
				'label' => __( 'Copy Icon', 'creative-addons-for-elementor'),
				'type' => Controls_Manager::ICONS,
				'fa4compatibility' => 'icon',
				'condition'	=> [
					'crel_code_block__toolbar_toggle'	=> 'yes'
				]
			]
		);

		$this->add_control(
			'crel_code_block__expand_icon',
			[
				'label' => __( 'Expand Icon', 'creative-addons-for-elementor'),
				'type' => Controls_Manager::ICONS,
				'description' => __( 'Icon will be hidden if the Code Block has no height limit.', 'creative-addons-for-elementor'),
				'fa4compatibility' => 'icon',
				'condition'	=> [
					'crel_code_block__toolbar_toggle'	=> 'yes'
				]
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'crel_code_block__general_section_controls',
				[
					'label' => __( 'Code', 'creative-addons-for-elementor' ),
					'tab' => Controls_Manager::TAB_CONTENT
				]
			);
			
			// Layout Type
			// link to actual prism build 
			// https://prismjs.com/download.html#themes=prism-tomorrow&languages=markup+css+clike+javascript+actionscript+arduino+aspnet+bash+batch+bbcode+brainfuck+bsl+c+csharp+cpp+coffeescript+css-
			//   extras+dart+django+docker+editorconfig+erlang+excel-formula+fsharp+fortran+git+go+graphql+groovy+haml+haskell+ignore+ini+j+java+json+json5+jsonp+js-templates+kotlin+latex+less+lisp+
			//   makefile+markup-templating+matlab+mongodb+nginx+pascal+perl+php+plsql+powershell+python+regex+ruby+rust+sass+scss+sql+stylus+twig+typescript+typoscript+vim+visual-basic+wiki+xml-doc&
			//   plugins=line-highlight+line-numbers+autolinker+highlight-keywords+inline-color+match-braces

			// Language
			$this->add_control(
				'crel_code_block__language',
				[
					'label'     => __( 'Language', 'creative-addons-for-elementor' ),
					'type'      => Controls_Manager::SELECT2,
					'options'   => $this->get_languages(),
				]
			);

			// Code Text block
			$this->add_control(
				'crel_code_block__text',
				[
					'type' => Controls_Manager::CODE,
					'language' => 'plain_text'
				]
			);

			// Line Numbers
			$this->add_control(
				'crel_code_block__line_numbers',
				[
					'label' => __( 'Line Numbers', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::SWITCHER,
					'label_on'  => __( 'Yes', 'creative-addons-for-elementor'),
					'label_off' => __( 'No', 'creative-addons-for-elementor'),
					//'force_preset' => true
				]
			);

			// First Line Number
			$this->add_control(
				'crel_code_block__line_numbers_start',
				[
					'label' => __( 'First Line Number', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::NUMBER,
					'step' => 1,
					'condition' => [
						'crel_code_block__line_numbers'	=> 'yes'
					]
				]
			);

			//Line Highlight
			$this->add_control(
				'crel_code_block__line_highlight',
				[
					'label' => __( 'Line Highlight', 'creative-addons-for-elementor' ),
					'label_block' => true,
					'type' => Controls_Manager::TEXT,
					'description' => __( 'Enter line numbers. Examples: 5 (5th line), 1-5 (lines 1 to 5)', 'creative-addons-for-elementor' ),
				]
			);

			// Line Wrap
			$this->add_control(
				'crel_code_block__line_warp',
				[
					'label' => __( 'Line Wrap', 'creative-addons-for-elementor'),
					'type' => Controls_Manager::SWITCHER,
					'label_on'  => __( 'Yes', 'creative-addons-for-elementor'),
					'label_off' => __( 'No', 'creative-addons-for-elementor'),
					'selectors' => [
						'{{WRAPPER}} .crel-code-block-container>pre' => 'white-space:pre-wrap;',
						'{{WRAPPER}} .crel-code-block-container>pre>code' => 'word-break: break-word;white-space: pre-wrap;'
					],
				]
			);
			
		$this->end_controls_section();
	}

	/**
	 * STYLE tab for this widget
	 */
	protected function register_style_controls() {

		// Container ---------------------------/
		$this->start_controls_section(
			'crel_code_block__container_section_controls',
			[
				'label' => __( 'Container', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

			// Border
			$this->add_control_group(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crel_code_block__container_border',
					'label'     => __( 'Border', 'creative-addons-for-elementor'),
					'selector'  => '{{WRAPPER}} .crel-code-block-container',
				]
			);

			// Border Radius
			$this->add_control_responsive(
				'crel_code_block__container_border_radius',
				[
					'label' => __( 'Border Radius', 'creative-addons-for-elementor' ),
					'type' => Controls_Manager::SLIDER,
					'size_units' => ['px'],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 500,
						]
					],
					'selectors' => [
						'{{WRAPPER}} .crel-code-block-container' => 'border-radius: {{SIZE}}px;',
					],
				]
			);

		$this->end_controls_section();

		// Language Header ---------------------/
		$this->start_controls_section(
			'crel_code_block__header_section_controls',
			[
				'label' => __( 'Language Header', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'crel_code_block__toolbar_toggle'	=> 'yes'
				]
			]
		);

		// Header ---------------------/
		$this->add_control(
			'crel_code_block__header_heading',
			[
				'label' => __( 'Header', 'creative-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		// Text Color
		$this->add_control(
			'crel_code_block__language_color',
			[
				'label' => __( 'Text Color', 'creative-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .crel-code-block-header-container' => 'color: {{VALUE}};'
				],
				'condition' => [
					'crel_code_block__toolbar_toggle'	=> 'yes'
				]
			]
		);

		// Background Color
		$this->add_control(
			'crel_code_block__header_background_color',
			[
				'label' => __( 'Background Color', 'creative-addons-for-elementor'),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .crel-code-block-header-container' => 'background-color: {{VALUE}};'
				],
				'condition' => [
					'crel_code_block__toolbar_toggle'	=> 'yes'
				]
			]
		);

		// Border
		$this->add_control_group(
			Group_Control_Border::get_type(),
			[
				'name'      => 'crel_code_block__language_border',
				'label'     => __( 'Border', 'creative-addons-for-elementor'),
				'selector'  => '{{WRAPPER}} .crel-code-block-header-container',
				'condition' => [
					'crel_code_block__toolbar_toggle'	=> 'yes'
				],
				'fields_options' => [
					'color' => [
						'separator'     => 'after',
					]
				],
			]
		);

		// Padding
		$this->add_control_responsive(
			'crel_code_block__language_header_padding',
			[
				'label' => __( 'Padding', 'creative-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .crel-code-block-header-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
				'condition' => [
					'crel_code_block__toolbar_toggle'	=> 'yes'
				]
			]
		);

		// Title  ---------------------/
		$this->add_control(
			'crel_code_block__title_heading',
			[
				'label' => __( 'Title', 'creative-addons-for-elementor' ),
				'type' => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		// Title Typography
		$this->add_control_group(
			Group_Control_Typography::get_type(),
			[
				'name' => 'crel_code_block__language_font_size',
				'selector' => '{{WRAPPER}} .crel-code-block__title',
				'condition' => [
					'crel_code_block__toolbar_toggle'	=> 'yes'
				]
			]
		);

		// Background Color
		$this->add_control(
			'crel_code_block__language_background_color',
			[
				'label' => __( 'Background Color', 'creative-addons-for-elementor' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .crel-code-block__title' => 'background-color: {{VALUE}};'
				],
				'condition' => [
					'crel_code_block__toolbar_toggle'	=> 'yes'
				]
			]
		);

		// Padding
		$this->add_control_responsive(
			'crel_code_block__language_padding',
			[
				'label' => __( 'Padding', 'creative-addons-for-elementor' ),
				'type' => Controls_Manager::DIMENSIONS,
				'selectors' => [
					'{{WRAPPER}} .crel-code-block__title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'
				],
				'condition' => [
					'crel_code_block__toolbar_toggle'	=> 'yes'
				]
			]
		);

		$this->end_controls_section();
		
		// Code --------------------------------/
		$this->start_controls_section(
			'crel_code_block__code_section_controls',
				[
					'label' => __( 'Code', 'creative-addons-for-elementor' ),
					'tab' => Controls_Manager::TAB_STYLE,
				]
			);

			
			$this->add_control_group(
				Group_Control_Border::get_type(),
				[
					'name'      => 'crel_code_block__code_border',
					'label'     => __( 'Border', 'creative-addons-for-elementor'),
					'selector'  => '{{WRAPPER}} .crel-code-block-container>pre',
				]
			);
			
			$this->add_control_responsive(
			'crel_code_block__code_max_height',
			[
				'label' => __( 'Block Max Height', 'creative-addons-for-elementor' ),
				'description' =>  __( 'Leave blank for no height limit.', 'creative-addons-for-elementor' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => ['px'],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 2000,
					]
				],
				'selectors' => [
					'{{WRAPPER}} pre' => 'max-height: {{SIZE}}{{UNIT}};',
				],
			]
			);
			
			// Code Typography
			$this->add_control_group(
				Group_Control_Typography::get_type(),
				[
					'name' => 'crel_code_block__code_typography',
					'selector' => '{{WRAPPER}} code',
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
		$language_title = '';
		$block_shortcodes = false;
		$language_slug = esc_attr( $settings['crel_code_block__language'] );
		
		if ( $language_slug == 'php-wordpress' ) {
			$language_slug = 'php';
			$block_shortcodes = Plugin::instance()->editor->is_edit_mode() ? false : true;
			$language_title = 'WordPress Shortcode';
		}
		
		if ( $settings['crel_code_block__toolbar_toggle'] == 'yes' ) {
			$language_list = $this->get_languages();
			
			if ( isset( $language_list[$language_slug] ) && ! $language_title) {
				$language_title = $language_list[$language_slug];
			}
		}
		
		$copy_icon              = $settings['crel_code_block__copy_icon'];
		$expand_icon              = $settings['crel_code_block__expand_icon'];
		$show_expand = ( Plugin::instance()->editor->is_edit_mode() || ! ( $settings['crel_code_block__code_max_height']['size'] === '' )  ) ? true : false;
		
		$line_highlight = $settings['crel_code_block__line_highlight'] ? 'data-line="' . esc_attr( $settings['crel_code_block__line_highlight'] ) . '"' : '';

		$line_numbers = $settings['crel_code_block__line_numbers'] == 'yes' ? 'line-numbers' : ''; 
		
		$start_line = $line_numbers && $settings['crel_code_block__line_numbers_start'] !== '' ? 'data-start="' . esc_attr( $settings['crel_code_block__line_numbers_start'] ) . '"' : '';
		
		$code = htmlentities($settings['crel_code_block__text']);
		
		if ( $block_shortcodes ) {
			$code = str_replace( '[', '%crel_bracket_open%', $code );
			$code = str_replace( ']', '%crel_bracket_close%', $code );
		}		?>
		
		<div class="<?php echo $line_numbers; ?> crel-code-block-container crel-loading language-<?php echo $language_slug; ?> <?php echo $settings['crel_Generic__Presets'] ? esc_attr( $settings['crel_Generic__Presets'] ) :
																																				'crel-default'; ?>" data-language_title="<?php echo $language_title; ?>"><?php
			if ( $language_title ) { ?>

				<div class="crel-code-block-header-container">
					<div class="crel-code-block__title"><?php echo $language_title; ?></div>
					<div class="crel-code-block__control-panel">
						<div class="crel-code-block__control-panel__help-text"></div>
						
						<div class="crel-code-block__control-copy" data-help="<?php _e( 'Copy', 'creative-addons-for-elementor' ); ?>" data-copied="<?php _e( 'Copied!', 'creative-addons-for-elementor' ); ?>">
							<?php Icons_Manager::render_icon( $copy_icon ); ?>
						</div><?php 
						
						if ( $show_expand ) { ?>
						
							<div class="crel-code-block__control-expand" data-help="<?php _e( 'Expand', 'creative-addons-for-elementor' ); ?>">
								<?php Icons_Manager::render_icon( $expand_icon ); ?>
							</div><?php 
						} ?>
						
					</div>
				</div>
				<?php
			} ?>
			<pre <?php echo $line_highlight; ?> <?php echo $start_line; ?>><code class="match-braces <?php echo $block_shortcodes ? 'crel-replace-brackets' : ''; ?>"><?php echo $code; ?></code></pre>
			<textarea class="crel-block-original-code"><?php echo $code; ?></textarea>
		</div>		<?php
	}
	
	protected function content_template() { ?>
		<#
			let language_title = '';
			let language_slug = settings.crel_code_block__language;
			
			if ( language_slug == 'php-wordpress'  ) {
				language_slug = 'php'; 
				language_title = 'WordPress Shortcode';
			}
			
			if ( settings.crel_code_block__toolbar_toggle == 'yes' ) {
				let language_list = <?php echo json_encode( $this->get_languages() ); ?>;

				if ( typeof language_list[language_slug] != 'undefined' && ! language_title ) {
					language_title = language_list[language_slug];
				}
			}
			
			let line_highlight = settings.crel_code_block__line_highlight ? 'data-line="' + settings.crel_code_block__line_highlight + '"' : '';
			
			let line_numbers = settings.crel_code_block__line_numbers == 'yes' ? 'line-numbers' : '';
			
			let start_line = line_numbers && settings.crel_code_block__line_numbers_start !== '' ? 'data-start="' + settings.crel_code_block__line_numbers_start + '"' : '';
		#>
		<div class="{{{ line_numbers }}} crel-code-block-container crel-loading language-{{{ language_slug }}} {{{ settings.crel_Generic__Presets ? settings.crel_Generic__Presets : 'crel-default' }}} " data-language_title="{{{ language_title }}}">
		<# if ( language_title ) { #>
			
				<div class="crel-code-block-header-container">
					<div class="crel-code-block__title">({{{language_title}}})</div>
					<div class="crel-code-block__control-panel">
						<div class="crel-code-block__control-panel__help-text"></div>
						<div class="crel-code-block__control-copy" data-help="<?php _e( 'Copy', 'creative-addons-for-elementor' ); ?>" data-copied="<?php _e( 'Copied!', 'creative-addons-for-elementor' ); ?>">
							{{{ elementor.helpers.renderIcon( view, settings.crel_code_block__copy_icon ) }}}
						</div>
						
						<div class="crel-code-block__control-expand" data-help="<?php _e( 'Expand', 'creative-addons-for-elementor' ); ?>">
							{{{ elementor.helpers.renderIcon( view, settings.crel_code_block__expand_icon ) }}}
						</div>
						
					</div>
				</div>
		<# } #>
			<pre {{{ line_highlight }}}  {{{ start_line }}}><code class="match-braces">{{{ settings.crel_code_block__text.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;') }}}</code></pre>
			<textarea class="crel-block-original-code">
				{{{ settings.crel_code_block__text.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;') }}}
			</textarea>
		</div>		<?php
	}

	protected function preview_url( $img ) {
		return CREATIVE_ADDONS_ASSETS_URL . 'images/presets/text-image/' . $img;
	}
	
	protected function get_languages() {
		return array(
			'html' => 'HTML',
			'css' => 'CSS',
			'regex' => 'Regex',
			'sass' => 'Sass (Sass)',
			'scss' => 'Sass (Scss)',
			'javascript' => 'JavaScript',
			'php-wordpress' => 'Wordpress Shortcode',
			'php' => 'PHP',
			'json' => 'JSON',
			'sql' => 'SQL',
			'perl' => 'Perl',
			'c' => 'C',
			'cpp' => 'C++',
			'csharp' => 'C#',
			'clike' => 'C-like',
			'groovy' => 'Groovy',
			'java' => 'Java',
			'markup-templating' => 'Markup templating',
			'python' => 'Pyton',
			'actionscript' => 'ActionScript',
			'arduino' => 'Arduino',
			'aspnet' => 'ASP.NET (C#)',
			'batch' => 'Batch',
			'coffeescript' => 'CoffeeScript',
			'dart' => 'Dart',
			'django' => 'Django/Jinja2',
			'docker' => 'Docker',
			'editorconfig' => 'EditorConfig',
			'erlang' => 'Erlang',
			'xlsx' => 'Excel Formula',
			'fsharp' => 'F#',
			'fortran' => 'Fortran',
			'git' => 'Git',
			'go' => 'Go',
			'graphql' => 'GraphQL',
			'haml' => 'Haml',
			'haskell' => 'Haskell',
			'ignore' => '.ignore',
			'ini' => 'Ini',
			'j' => 'J',
			'json5' => 'JSON5',
			'jsonp' => 'JSONP',
			'js-templates' => 'JS Templates',
			'kotlin' => 'Kotlin',
			'latex' => 'LaTeX',
			'less' => 'Less',
			'lisp' => 'Lisp',
			'makefile' => 'Makefile',
			'matlab' => 'MATLAB',
			'mongodb' => 'MongoDB',
			'nginx' => 'nginx',
			'pascal' => 'Pascal',
			'plsql' => 'PL/SQL',
			'powershell' => 'PowerShell',
			'ruby' => 'Ruby',
			'rust' => 'Rust',
			'stylus' => 'Stylus',
			'twig' => 'Twig',
			'typescript' => 'TypeScript',
			'typoscript' => 'TypoScript',
			'vim' => 'vim',
			'visual-basic' => 'Visual Basic',
			'wiki' => 'Wiki markup',
			'xml-doc' => 'XML doc (.net)',
		);
	}
}