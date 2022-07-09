<?php
namespace Creative_Addons\Widgets;
use Creative_Addons\Includes\Utilities;
use Creative_Addons\Includes\Kb\KB_Utilities;
use Elementor\Plugin;

defined( 'ABSPATH' ) || exit();

/**
 * KNowledge Bases widget for Elementor
 */
class Knowledge_Base extends Creative_Widget_Base {

	/**
	 * Retrieve the widget title.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Knowledge Base', 'creative-addons-for-elementor' );
	}

	/**
	 * Retrieve the widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'crelfont crel-kb-book-2-icon';
	}

	/**
	 * Retrieve the widget Demo URL.
	 *
	 * @return string Widget Demo URL.
	 */
	public function get_demo_url() {
		return 'https://www.creative-addons.com/elementor-widgets/knowledge-base/';
	}

	/**
	 * Retrieve the widget Documentation URL.
	 *
	 * @return string Widget Documentation URL.
	 */
	public function get_documentation_url() {
		return 'https://www.creative-addons.com/elementor-docs/knowledge-base-widget/';
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
		return [ 'knowledgebase', 'kb', 'knowledge', 'docs', 'documentation', 'faq', 'documents' ];
	}

	/**
	 * Return presets for this widget
	 */
	/* public function get_presets_options() {
	} */

	/**
	 * CONTENT tab for this widget
	 */
	protected function register_content_controls() {}

	/**
	 * STYLE tab for this widget
	 */
	protected function register_style_controls() {}

	/**
	 * Render the widget output on the frontend.
	 * Written in PHP and used to generate the final HTML.
	 */
    protected function render() {
		if ( ! $this->is_kb_plugin_activated() ) {
			return;
		}
		
		$this->call_missed_kb_actions();
		
		echo do_shortcode( '[epkb-knowledge-base id=' . $this->get_current_kb_id() . ']' );
    }
	
	/**
	 * Run all absent actions for live preview of KB main page 
	 */
	
	protected function call_missed_kb_actions() {
		
		// set page type to "main"
		global $eckb_is_kb_main_page;
		$eckb_is_kb_main_page = true;
		
		if ( !Utilities::is_post_edit_screen()) {
			return;
		}
		
		// KB Core
		if ( class_exists('EPKB_Layouts_Setup') ) {
			new \EPKB_Layouts_Setup();
		}

		// ASEA 
		if ( KB_Utilities::is_asea_plugin_active() && class_exists('ASEA_Search_Box_View') && class_exists('ASEA_Search_Shortcode') ) {
			new \ASEA_Search_Box_View();
			new \ASEA_Search_Shortcode();
		}
		
		// ELAY 
		if ( KB_Utilities::is_elay_plugin_active() && class_exists('ELAY_Layout_Sidebar') && class_exists('ELAY_Layout_Sidebar_v2') && class_exists('ELAY_Layout_Grid') )  {
			new \ELAY_Layout_Sidebar();
			new \ELAY_Layout_Sidebar_v2();
			new \ELAY_Layout_Grid();
		}
	}
}
