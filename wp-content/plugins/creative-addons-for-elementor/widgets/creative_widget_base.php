<?php
namespace Creative_Addons\Widgets;

use Creative_Addons\Controls\Creative_Preset;
use Creative_Addons\Includes\Widgets_Manager;
use Creative_Addons\Includes\Kb\KB_Utilities;
use Elementor\Controls_Manager;
use Elementor\Widget_Base;
use Creative_Addons\Includes\Utilities;
use Creative_Addons\Includes\Utilities_Plugin;

defined( 'ABSPATH' ) || exit();

/**
 * Creative Addons - base class for widgets
 */
abstract class Creative_Widget_Base extends Widget_Base {
	
	protected $widget_scripts = array();
	protected $widget_styles = array();
	protected $notice_id = 0;
	protected $defaults = [
		'config_regular' => [],
		'config_rtl' => [],
		'presets_regular' => [],
		'presets_rtl' => []
	];
	protected $disable_color_schemes = false;
	protected $disable_typography_schemes = false;
	
	public function __construct($data = [], $args = null) {
		parent::__construct($data, $args);
		
		$this->defaults = [
			'config_regular' => $this->get_config_defaults(),
			'config_rtl' => $this->get_config_rtl_defaults(),
			'presets_regular' => $this->get_presets_defaults(),
			'presets_rtl' => $this->get_presets_rtl_defaults(),
		];
		
		if ( $this->get_config_old_defaults() && Utilities_Plugin::use_old_widgets_without_globals() ) {
			$this->defaults['config_regular'] = array_merge( $this->defaults['config_regular'], $this->get_config_old_defaults() );
		}
		
		if ( get_option( 'elementor_disable_color_schemes' ) == 'yes' ) {
			$this->disable_color_schemes = true;
		}
		
		if ( get_option( 'elementor_disable_typography_schemes' ) == 'yes' ) {
			$this->disable_typography_schemes = true;
		}
	}
	
    /**
     * Return name of the widget based on the class e.g. crel-advanced-heading
     * @return string widget name.
     */
    public function get_name() {
	    $class_name = strtolower($this->get_widget_class_name());
		$class_name = str_replace( '_', '-', $class_name );
	    return 'crel-' . substr($class_name, strrpos($class_name, '\\'));
    }

	/**
	 * Return widget claas name e.g. Advanced_heading
	 * @return string
	 */
    private function get_widget_class_name() {
	    $class_name = str_replace(__NAMESPACE__, '', $this->get_class_name());
	    return ltrim($class_name, '\\');
    }

	/**
	 * Retrieve the list of categories the widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * Note that currently Elementor supports only one category.
	 * When multiple categories passed, Elementor uses the first one.
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'creative_addons_category' ];
	}

	protected function presets_preview_url( $img ) {
		$widget_name = str_replace('_', '-', $this->get_widget_class_name());
		return CREATIVE_ADDONS_ASSETS_URL . 'images/presets/' . strtolower($widget_name) . '/' . $img;
	}

	/**
	 * Get URL of widget documentation e.g. https://www.creative-addons.com/elementor-docs/advanced-heading-widget
	 * @return string
	 */
	public function get_documentation_url() {
	    $widget_name = str_replace('_', '-', $this->get_widget_class_name());
        return 'https://www.creative-addons.com/elementor-docs/' . strtolower($widget_name) . '-widget/';
    }

	/**
	 * Retrieve the widget Demo URL.
	 *
	 * @return string Widget Demo URL.
	 */
	public function get_demo_url() {
		$widget_name = str_replace('_', '-', $this->get_widget_class_name());
		return 'https://www.creative-addons.com/elementor-widgets/' . strtolower($widget_name) . '/';
	}

    /**
     * Add custom HTML class e.g. <wrapper> creative-addons crel-advanced-heading
     * @return string
     */
    public function get_html_wrapper_class() {
        return parent::get_html_wrapper_class() .' creative-addons ' . $this->get_name();
    }

    /**
     * Register widget controls
     */
    protected function _register_controls() {
        do_action( 'creative_addons_start_register_controls', $this );

	    // only KB widgets will see the KB selection
        if ( in_array($this->get_widget_class_name(), Widgets_Manager::get_kb_widgets_list()) ) {
        	$this->add_kb_selection();
        }

	    $this->add_preset_selection();
	    $this->register_content_controls();
        $this->register_style_controls();

        do_action( 'creative_addons_end_register_controls', $this );
	}

    /**
     * Register content controls
     * @return void
     */
    abstract protected function register_content_controls();

    /**
     * Register style controls
     * @return void
     */
    abstract protected function register_style_controls();

	/**
	 * Register script for the widget from the folder /assets/js
	 * Use wp_register_script
	 * @param $name
	 */
	protected function register_crel_script( $name ) {
		$this->widget_scripts[] = 'creative-addons-' . $name;
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
		wp_register_script( 'creative-addons-' . $name, CREATIVE_ADDONS_DIR_URL . 'assets/js/' . $name . $suffix . '.js', [ 'elementor-frontend' ], CREATIVE_ADDONS_VERSION, true );
	}

	/**
	 * Add KB selection to KB widgets
	 */
	private function add_kb_selection() {

		$all_kb_configs = KB_Utilities::get_kb_configs();

		// show error if KB plugin is not active or config is missing
		if ( empty($all_kb_configs) ) {

			$this->start_controls_section(
				'crel_Generic__KB_Config__section__ContentTab',
				[
					'label' => __( 'Knowledge Base', 'creative-addons-for-elementor' ),
					'tab' => Controls_Manager::TAB_CONTENT
				]
			);

				$text = __( "We can't find any Knowledge Base configuration. Ensure that your Echo Knowledge Base plugin is active.", 'creative-addons-for-elementor' );
				$text = str_replace('.', '.<br>', $text);

				$this->add_notice_control( $text );
			
			$this->end_controls_section();
			return;
		}
		
		$this->start_controls_section(
				'crel_Generic__KB_Config__section__ContentTab',
				[
					'label' => __( 'Knowledge Base', 'creative-addons-for-elementor' ),
					'tab' => Controls_Manager::TAB_CONTENT
				]
			);

			$kb_id_options[KB_Utilities::DEFAULT_KB_ID] = 'Unknown'; // default, just in case, will be rewrited in the next foreach
			
			foreach ( $all_kb_configs as $one_kb_config ) {
				if ( $one_kb_config['id'] !== KB_Utilities::DEFAULT_KB_ID && KB_Utilities::is_kb_archived( $one_kb_config['status'] ) ) {
					continue;
				}
				$kb_id_options[$one_kb_config['id']] = esc_html( $one_kb_config[ 'kb_name' ] );
			}

			$wizard_url = esc_url( admin_url( "edit.php?post_type=ep"."kb_post_type_" . KB_Utilities::DEFAULT_KB_ID . "&page=ep"."kb-kb-configuration"));
			$this->add_control(
				'crel_kb_id',
				[
					'label' => sprintf( __( 'Knowledge Base %s', 'creative-addons-for-elementor' ), '<a href="'.$wizard_url.'" target="_blank"><i class="crelfa crelfa-external-link "></i></a>' ),
					'type' => Controls_Manager::SELECT,
					'options' => $kb_id_options,
					'default' => KB_Utilities::DEFAULT_KB_ID
				]
			);

		if ( ! defined('EM'.'KB_PLUGIN_NAME') && count( $all_kb_configs ) == 1 ) {
			$this->add_notice_control( sprintf( __( 'Get %s Multiple Knowledge Bases %s add-on to create more Knowledge Bases.', 'creative-addons-for-elementor' ),'<a href="https://www.echoknowledgebase.com/wordpress-plugin/multiple-knowledge-bases/" target="_blank">', '</a>'), 'note' );
		}
		
		$this->end_controls_section();
	}

	/**
	 * If KB plugin is not active then do not output anything
	 * @return bool
	 */
	protected function is_kb_plugin_activated() {
		return KB_Utilities::is_kb_plugin_active();
	}

	/**
	 * Get current KB ID from settings; KB > 1 even if MKB is not enabled
	 */
	protected function get_current_kb_id() {
		$settings = $this->get_settings_for_display();
		return empty($settings['crel_kb_id']) ? KB_Utilities::DEFAULT_KB_ID : $settings['crel_kb_id'];
	}

	public function get_script_depends() {
		return $this->widget_scripts;
	} 
	
	public function get_style_depends() {
		return $this->widget_styles;
	} 

	/**
	 * The same function as parent but with our defaults
	 * @param $id
	 * @param array $args
	 * @param array $options
	 */
	public function add_control( $id, array $args, $options = [] ) {
		
		if ( isset( $this->defaults['config_regular'][$id] ) ) {
			$args['default'] = $this->defaults['config_regular'][$id];
		}
		
		if ( is_rtl() && isset( $this->defaults['config_rtl'][$id] ) ) {
			$args['default'] = $this->defaults['config_rtl'][$id];
		}
		
		if (  isset( $args['global'] ) && Utilities_Plugin::use_old_widgets_without_globals() ) {
			$args['global'] = [];
		}
		
		parent::add_control( $id, $args, $options );
	}

	/**
	 * add_group_control native elementor function + our defaults
	 * @param $group_name
	 * @param array $args
	 * @param array $options
	 */
	public function add_control_group( $group_name, array $args = [], array $options = [] ) {

		// set defaults for regular configuration
		if ( ! empty( $this->defaults['config_regular'] ) ) {
			foreach ($this->defaults['config_regular'] as $name_subname => $value ) {
				
				if ( false === strpos( $name_subname, $args['name'] . '_' ) ) {
					continue;
				}
				
				$subname = str_replace( $args['name'] . '_' , '', $name_subname );
				
				if ( !$subname ) {
					continue;
				}
				
				$args['fields_options'][$subname]['default'] = $value;
				
			}
		}

		// set defaults for RTL configuration
		if ( is_rtl() && ! empty( $this->defaults['config_rtl'] ) ) {
			foreach ($this->defaults['config_rtl'] as $name_subname => $value ) {
				
				if ( false === strpos( $name_subname, $args['name'] . '_' ) ) {
					continue;
				}
				
				$subname = str_replace( $args['name'] . '_' , '', $name_subname );
				
				if ( !$subname ) {
					continue;
				}
				
				$args['fields_options'][$subname]['default'] = $value;
			}
		}
		
		if ( isset( $args['global'] ) && Utilities_Plugin::use_old_widgets_without_globals() ) {
			$args['global'] = [];
		}
		
		parent::add_group_control( $group_name, $args, $options );
	}

	/**
	 * add_responsive_control native elementor function + our defaults
	 * @param $id
	 * @param array $args
	 * @param array $options
	 */
	public function add_control_responsive( $id, array $args, $options = []  ) {
		
		if ( isset( $this->defaults['config_regular'][$id] ) ) {
			$args['default'] = $this->defaults['config_regular'][$id];
		}
		
		if ( is_rtl() && isset( $this->defaults['config_rtl'][$id] ) ) {
			$args['default'] = $this->defaults['config_rtl'][$id];
		}
		
		if ( isset( $args['global'] ) && Utilities_Plugin::use_old_widgets_without_globals() ) {
			$args['global'] = [];
		}

		// add responsive defaults
		if ( isset ( $this->defaults['config_regular'][ $id . '_desktop' ] ) ) {
			$args['desktop_default'] = $this->defaults['config_regular'][ $id . '_desktop' ];
		}

		if ( is_rtl() && isset( $this->defaults['config_rtl'][$id . '_desktop' ] ) ) {
			$args['desktop_default'] = $this->defaults['config_rtl'][$id . '_desktop' ];
		}

		if ( isset ( $this->defaults['config_regular'][ $id . '_tablet' ] ) ) {
			$args['tablet_default'] = $this->defaults['config_regular'][ $id . '_tablet' ];
		}

		if ( is_rtl() && isset( $this->defaults['config_rtl'][$id . '_tablet' ] ) ) {
			$args['tablet_default'] = $this->defaults['config_rtl'][$id . '_tablet' ];
		}

		if ( isset ( $this->defaults['config_regular'][ $id . '_mobile' ] ) ) {
			$args['mobile_default'] = $this->defaults['config_regular'][ $id . '_mobile' ];
		}

		if ( is_rtl() && isset( $this->defaults['config_rtl'][$id . '_mobile' ] ) ) {
			$args['mobile_default'] = $this->defaults['config_rtl'][$id . '_mobile' ];
		}
		
		parent::add_responsive_control( $id, $args, $options );
	}

	/**
	 * Show notice to the user. Apply only inside some section.
	 * @param $text
	 * @param string $type - error (red), info (blue), warning (yellow), success (green)
	 * @param array $data - of the options for add_control( $label, $data ), not required
	 * @param string $label
	 */
	protected function add_notice_control( $text, $type = 'error', $data = array(), $label = '' ) {

		if ( ! $label ) {
			$this->notice_id++;
			$label = 'crel_notice_' . $this->notice_id;
		}

		$text = '<div class="crel-notice-box crel-notice-box--' . $type . '">' . $text . '</div>';

		$default_data = [
			'label' => '',
			'type' => Controls_Manager::RAW_HTML,
			'raw' => $text,
		];

		$data = array_merge( $default_data, $data );
		$this->add_control( $label, $data );
	}


	/***********************************************************************************
     *
	 *                          Presets Functions
	 *
	 ***********************************************************************************/

	/**
	 * Getters for default
	 * Usual option: 'name' => 'value'
	 * Group Option: 'name_optionName' => 'value'
	 */
	protected function get_config_defaults() {
		return [];
	}
	
	protected function get_config_old_defaults() {
		return [];
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

	/**
	 * Display REGULAR presets for this widget
	 */
	private function add_preset_selection() {
		if ( $this->get_name() == 'crel-notification-box' ) {
			$this->add_extended_preset_options();
		} else {
			$this->add_standard_preset_options();
		}
	}

	private function add_standard_preset_options() {

		$presets = $this->get_presets_options();
		$user_presets_settings = Utilities_Plugin::get_users_inactive_presets();
		$class_name = $this->get_widget_class_name();
		
		if ( empty($presets) ) {
			return;
		}

		// encode the presets and merge with defaults
		foreach( $presets as $key => $preset ) {
			
			// remove turned off presets
			if ( ! empty( $user_presets_settings[$class_name] ) && in_array( $key, $user_presets_settings[$class_name] ) ) {
				unset($presets[$key]);
				continue;
			}

			if ( is_rtl() ) {
				$defaults = array_merge( $this->defaults['presets_regular'], $this->defaults['presets_rtl']);
			} else {
				$defaults = $this->defaults['presets_regular'];
			}

			$preset_merged = array_merge( $defaults, $preset['options'] );

			$presets[$key]['options'] = htmlspecialchars( json_encode( $preset_merged ), ENT_QUOTES, 'UTF-8' );
		}

		// display presets
		$this->start_controls_section(
			'crel_Generic__Presets__section',
			[
				'label' => __( 'Presets', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT
			]
		);

		$this->add_control(
			'crel_Generic__Presets',
			[
				'label'       	=> esc_html__( 'Presets', 'creative-addons-for-elementor'),
				'type' 			=> Creative_Preset::TYPE,
				'default' 		=> '',
				'label_block' 	=> false,
				'options' 		=> $presets,
				'reset'           => true
			]
		);
		
		$this->notice_id++;
		
		$this->add_control( 
			'crel_presets-link_' . $this->notice_id, [
				'label' => '',
				'type' => Controls_Manager::RAW_HTML,
				'raw' => '<div class="crel-presets-link"><a href="' . admin_url( 'admin.php?page=creative-addons&tab=presets&widget=' . $this->get_widget_class_name() ) . '" target="_blank">' . __( 'Preset Library', 'creative-addons-for-elementor' ) . '</a></div>',
			]
		);
		
		$this->end_controls_section();
	}

	/**
	 * Return REGULAR presets for this widget
	 */
	public function get_presets_options() {
		return array();
	}

	/**
	 * Show this widget preset options  // TODO refactor
	 */
	private function add_extended_preset_options() {

		$presets_options_v2 = $this->get_presets_options();
		if ( !is_array( $presets_options_v2 ) ) {
			return;
		}
		
		$user_presets_settings = Utilities_Plugin::get_users_inactive_presets();
		$class_name = $this->get_widget_class_name();
		
		// level 1
		$presets_general = array();
		foreach ( $presets_options_v2 as $label_2 => $options_2 ) {
			if ( is_array( $options_2['options'] ) && $options_2['options'] ) {
				// level 2
				foreach ( $options_2['options'] as $label_3 => $options_3 ) {
					
					if ( $options_3['options'] ) {
						
						foreach ( $options_3['options'] as $preset_name => $preset ) {
							if ( ! empty( $user_presets_settings[$class_name] ) && in_array( $preset_name, 	$user_presets_settings[$class_name] ) ) {
								unset($options_3['options'][$preset_name]);
								unset($presets_options_v2[$label_2]['options'][$label_3]['options'][$preset_name]);
							}
						}
						
					}
					
					if ( $options_3['options'] ) {
						// level 3 (style)
						$presets_general[$label_2] = $options_2['title'];
					}
				}
			}
		}

		if ( empty($presets_general) ) {
			return;
		}

		$this->start_controls_section(
			'crel_Generic__Presets__section',
			[
				'label' => __( 'Presets', 'creative-addons-for-elementor' ),
				'tab' => Controls_Manager::TAB_CONTENT
			]
		);


		// show Type selection drop down
		$fake_select_options = '<option value="">' . __( 'Select ...', 'creative-addons-for-elementor') . '</option>';
		foreach ( $presets_general as $val => $name ) {
			$fake_select_options .= '<option value="' . $val . '">' . $name . '</option>';
		}

		$i = 0;
		$this->add_control(
			'crel_presets_v2_general',
			[
				'label'       	=>'',
				'type' 			=> Controls_Manager::RAW_HTML,
				'raw' 		=> '
				
				<div class="elementor-control-field ' . ( $i ? '' : 'crel-with-reset' ) . '">
					<label class="elementor-control-title">Type</label>
					<div class="elementor-control-input-wrapper elementor-control-unit-5">' . ( $i ? '' :
						'<i title="' . __( 'Reset Style', 'creative-addons-for-elementor' ) . '" class="eicon-redo crel-reset-design" aria-hidden="true"></i>' ) .
				                '<select data-setting="crel_presets_v2_general">' . $fake_select_options . '</select>
					</div>
				</div>',
				'content_classes' => 'crel-fake-select',
			]
		);

		// level 1
		foreach ( $presets_options_v2 as $label_2 => $options_2 ) {
			if ( is_array( $options_2['options'] ) && $options_2['options'] ) {

				// level 2
				foreach ( $options_2['options'] as $label_3 => $options_3 ) {
					if ( $options_3['options'] ) {
						// level 3 (style)
						$this->add_control(
							'crel_Generic__Presets_' . $i,
							[
								'label'       	=> $options_3['title'],
								'type' 			=> Creative_Preset::TYPE,
								'default' 		=> '',
								'label_block' 	=> false,
								'options' 		=> $options_3['options'],
								'reset'           => false,
								'select_class' => 'crel-preset-v2__select ' . $label_2 . ' ' . $label_3,
							]
						);

						$i++;
					}
				}
			}
		}
		
		$this->notice_id++;
		
		$this->add_control( 
			'crel_presets-link_' . $this->notice_id, [
				'label' => '',
				'type' => Controls_Manager::RAW_HTML,
				'raw' => '<div class="crel-presets-link"><a href="' . admin_url( 'admin.php?page=creative-addons&tab=presets&widget=' . $this->get_widget_class_name() ) . '" target="_blank">' . __( 'Presets Library', 'creative-addons-for-elementor' ) . '</a></div>',
			]
		);
		
		$this->end_controls_section();
	}
	
	/**
	 * Get all image sizes from Media library
	 * return array ( 'size_name' => [ width => '', height => '', crop => ''], ... )
	 * @param bool $unset_disabled
	 * @return array
	 */
	protected function get_image_sizes( $unset_disabled = true ) {
		$wais = & $GLOBALS['_wp_additional_image_sizes'];

		$sizes = array();

		foreach ( get_intermediate_image_sizes() as $_size ) {
			if ( in_array( $_size, array('thumbnail', 'medium', 'medium_large', 'large') ) ) {
				$sizes[ $_size ] = array(
					'width'  => get_option( "{$_size}_size_w" ),
					'height' => get_option( "{$_size}_size_h" ),
					'crop'   => (bool) get_option( "{$_size}_crop" ),
				);
			}
			else if ( isset( $wais[$_size] ) ) {
				$sizes[ $_size ] = array(
					'width'  => $wais[ $_size ]['width'],
					'height' => $wais[ $_size ]['height'],
					'crop'   => $wais[ $_size ]['crop'],
				);
			}

			// size registered, but has 0 width and height
			if( $unset_disabled && isset($sizes[ $_size ]) && ($sizes[ $_size ]['width'] == 0) && ($sizes[ $_size ]['height'] == 0) )
				unset( $sizes[ $_size ] );
		}

		return $sizes;
	}
}
