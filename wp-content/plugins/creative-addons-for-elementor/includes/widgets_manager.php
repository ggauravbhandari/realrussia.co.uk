<?php
namespace Creative_Addons\Includes;

use Creative_Addons\Includes\System\Logging;
use Elementor\Plugin;
use Elementor\Elements_Manager;

defined( 'ABSPATH' ) || exit();

class Widgets_Manager {

    /**
     * Initialize
     */
    public static function init() {
        add_action( 'elementor/widgets/widgets_registered', [ __CLASS__, 'register' ] );
	    add_action( 'elementor/elements/categories_registered', [ __CLASS__, 'add_category' ] );
		add_action( 'elementor/editor/after_enqueue_scripts', [ __CLASS__, 'hide_widgets' ]);
    }

	/**
	 * Register all widgets
	 */
	public static function register() {
		// include widgets parent class
		include_once( CREATIVE_ADDONS_DIR_PATH . 'widgets/creative_widget_base.php' );
		
		foreach ( self::get_widgets_list() as $widget_class ) {
			self::register_widget( $widget_class );
		}
	}
	
	/** 
	 * Add styles to hide inactive widgets 
	 */
	public static function hide_widgets() {
		// styles to hide widgets 
		$hide_widget_styles = '';
		$inactive_widgets = self::get_inactive_widgets();
		$i = 1;
		
		foreach ( self::get_widgets_list() as $widget_class ) {
			if ( in_array( $widget_class, $inactive_widgets ) ) {
				$hide_widget_styles .= '#elementor-panel-category-creative_addons_category .elementor-panel-category-items .elementor-element-wrapper:nth-child(' . $i . ') {display: none;}';
			}
			
			$i++;
		}
		
		wp_add_inline_style( 'creative_preset', $hide_widget_styles);
	}

	/**
	 * Register each widget
	 * @param $widget_class
	 */
	protected static function register_widget( $widget_class ) {
		$widget_file = CREATIVE_ADDONS_DIR_PATH . 'widgets/' . strtolower( $widget_class ). '.php';
		if ( ! is_readable( $widget_file ) ) {
			Logging::add_log('Could not read file for widget: ' . $widget_file);
			return;
		}

		include_once( $widget_file );
		$widget_class_name = '\Creative_Addons\Widgets\\' . $widget_class;
		if ( class_exists( $widget_class_name ) ) {
			Plugin::instance()->widgets_manager->register_widget_type( new $widget_class_name );
		}
	}

	/**
	 * Add Creative widgets category for Elementor
	 *
	 * @param $elements_manager
	 *
	 * @noinspection PhpUnused*/
	public static function add_category( Elements_Manager $elements_manager ) {
		$elements_manager->add_category(
			'creative_addons_category',
			[
				'title' => __( 'Creative Addons', 'creative-addons-for-elementor' ),
				'icon' => 'fa fa-file', // not used but required
			]
		);
	}

	/**
	 * Get list of free and pro Creative widgets
	 * @return mixed
	 */
    public static function get_all_widgets_list() {
        $widgets_list = self::get_widgets_list();
        return apply_filters( 'creative_addons_get_widgets_list', $widgets_list );
    }

    /**
     * Get list of free Creative widgets
     * @return array
     */
    public static function get_widgets_list() {
		
		$widgets_list = [ 
			'notification-box' => 'Notification_Box', 
			'advanced-heading' => 'Advanced_Heading', 
			'steps' => 'Steps',
			'text-image' => 'Text_Image',
			'image-guide' => 'Image_Guide',
			'code-block' => 'Code_Block',
			'advanced-lists' => 'Advanced_Lists',
		];
		
		$widgets_list = array_merge( $widgets_list, self::get_kb_widgets_list());
		
        return $widgets_list;
    }

	/**
	 * Get list of KB Creative widgets
	 * @return array
	 */
	public static function get_kb_widgets_list() {
		return [ 
			'knowledge-base' => 'Knowledge_Base', 
			'kb-search-box' => 'KB_Search_Box', 
			'kb-recent-articles' => 'KB_Recent_Articles', 
			'kb-categories' => 'KB_Categories' ];
	}

	public static function get_inactive_widgets() {
		return Utilities::get_wp_option('crel_inactive_widgets', [], true );
	}

	public static function set_inactive_widgets( $widgets=[] ) {
		Utilities::save_wp_option( 'crel_inactive_widgets', $widgets, true );
	}

	public static function get_widget_template( $widget, $template_name ) {

	}

}
