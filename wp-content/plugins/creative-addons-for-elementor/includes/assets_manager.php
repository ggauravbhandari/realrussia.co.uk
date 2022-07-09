<?php
namespace Creative_Addons\Includes;

use Elementor\Core\Files\CSS\Post as Post_CSS;
use Creative_Addons\Includes\Kb\KB_Handler;
use Creative_Addons\Includes\Kb\KB_Utilities;

defined( 'ABSPATH' ) || exit();

class Assets_Manager {

	public static function init() {

		add_action( 'wp_enqueue_scripts', [ __CLASS__, 'frontend_register_assets' ] );
		add_action( 'wp_enqueue_scripts', [ __CLASS__, 'frontend_enqueue_assets' ], 99 );

		// Elementor editor JS/CSS asssets
		add_action( 'elementor/editor/after_enqueue_scripts', [ __CLASS__, 'enqueue_elementor_editor_scripts' ] );
		add_action( 'elementor/css-file/post/enqueue', [ __CLASS__, 'enqueue_templates_assets' ] );

		add_action( 'admin_enqueue_scripts', [__CLASS__, 'enqueue_admin_assets'] );
	}

	/**
	 * FRONT-END: Register JS/CSS and localized text
	 * @noinspection PhpUnused
	 */
	public static function frontend_register_assets() {
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		// register CSS/JS
		wp_register_script( 'crel-public-scripts', CREATIVE_ADDONS_DIR_URL . 'assets/js/public-scripts' . $suffix . '.js', ['jquery'], CREATIVE_ADDONS_VERSION, true );
		wp_register_style( 'crel-public-styles', CREATIVE_ADDONS_DIR_URL . 'assets/css/front-end/front-end' . $suffix . '.css', [], CREATIVE_ADDONS_VERSION );  
		wp_register_style( 'crel-elementor-editor-styles', CREATIVE_ADDONS_DIR_URL . 'assets/css/front-end/elementor-editor' . $suffix . '.css', [], CREATIVE_ADDONS_VERSION );
		
		// localize text
		wp_localize_script( 'crel-public-scripts', 'crel_vars', array(
			'ajax_url' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('crel_nonce'),
		));
	}

	/**
	 * If KB core not active or installed then show user how can they get it
	 * @noinspection PhpUnused
	 */
	public static function enqueue_elementor_editor_scripts() { 
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		wp_enqueue_script( 'crel-admin-elementor-scripts', CREATIVE_ADDONS_DIR_URL . 'assets/js/admin-elementor' . $suffix . '.js', ['jquery'], CREATIVE_ADDONS_VERSION, true );
		
		// array with the links to the demo pages 
		// key is widget icon, value is a link. It is so, because we have only icon name different between widgets buttons (and titles, but they can be translated)
		$demo_links = array(
			'crel-kb-book-2-icon' => 'https://www.creative-addons.com/elementor-widgets/knowledge-base/',
			'crel-kb-search-icon' => 'https://www.creative-addons.com/elementor-widgets/knowledge-base-search/',
			'crel-kb-article-list-icon' => 'https://www.creative-addons.com/elementor-widgets/knowledge-base-recent-articles/',
			'crel-kb-category-list-icon' => 'https://www.creative-addons.com/elementor-widgets/knowledge-base-categories/',
		);
		
		// Ask user to activate or install KB Core plugin
		if ( KB_Utilities::is_kb_plugin_installed() ) {
			$crel_promo = array(
                /* translators: %s: Name of this plugin */
				'message' =>sprintf( __( 'To use this widget, activate %s plugin.', 'creative-addons-for-elementor' ), '<b>Knowledge Base</b>' ),
				'link_title' => __( 'Activate Plugin', 'creative-addons-for-elementor' ),
				'link_url' => admin_url( 'plugins.php' ) . '?s=echo%20knowledge%20base&plugin_status=inactive',
                'link_target' => 'target="_blank"',
				'link_title_2' => __( 'Demo', 'creative-addons-for-elementor' ),
				'link_url_2' => 'https://www.creative-addons.com/elementor-widgets/', // default link tp all widgets
				'link_urls' => $demo_links
			);
		} else {
			$crel_promo = array(
                /* translators: %s: Name of this plugin */
                'message' => sprintf( __( 'To use this widget, please install our FREE %s plugin.', 'creative-addons-for-elementor' ), '<b>Knowledge Base</b>' ),
                'link_title' => __( 'Install Plugin', 'creative-addons-for-elementor' ),
				'link_url' => admin_url( 'plugin-install.php' ) . '?s=echoplugins&tab=search&type=author',
				'link_target' => 'target="_blank"',
                'link_title_2' => __( 'Demo', 'creative-addons-for-elementor' ),
				'link_url_2' => 'https://www.creative-addons.com/elementor-widgets/', // default link tp all widgets
				'link_urls' => $demo_links
			);
		} 
		
		wp_localize_script( 'crel-admin-elementor-scripts', 'crel_promo', $crel_promo );
	}

	/**
	 * FRONT-END: enqueue styles and scripts
	 * @noinspection PhpUnused
	 * @param string $post_id
	 */
	public static function frontend_enqueue_assets( $post_id='' ) {

		if ( empty($post_id) && ! is_singular() ) {
			return;
		}
		
		$post_id = empty($post_id) ? get_the_ID() : $post_id;

		// post being displayed on the front-end
		if ( Utilities_Plugin::is_built_with_elementor( $post_id ) && ( Utilities::is_published( $post_id ) || Utilities::is_private( $post_id ) ) && ! Utilities::is_post_being_edited() ) {

			// enqueue cached styles
			$cache_assets = new Cache_Assets( $post_id, Cache_Manager::get_widgets_cache() );

			// if our widgets is not on the page then do not enqueue
			$widgets = $cache_assets->get_widgets_cache()->get_cache();
			if ( empty($widgets) || ! is_array($widgets) ) {
				return;
			}

			// load all wigets common style
			wp_enqueue_style( 'crel-public-styles' );

			// enqueue individual widgets CSS
			if ( $cache_assets->has_cache() ) {
				wp_enqueue_style( 'creative-addons-' . $post_id, $cache_assets->get_post_file_url(), [ 'elementor-frontend' ], CREATIVE_ADDONS_VERSION . '.' . get_post_modified_time() );
			// this should not happen; fall-back
			} else {
				wp_enqueue_style( 'crel-elementor-editor-styles' );
			}

			wp_enqueue_script( 'crel-public-scripts' );
		}

		// post being edited in Elementor editor
		if ( Utilities::is_post_being_edited() ) {

			wp_enqueue_style( 'crel-public-styles' );
			wp_enqueue_style( 'crel-elementor-editor-styles' );
			wp_enqueue_script( 'crel-public-scripts' );

			// enable preview for KB widgets
			KB_Handler::load_KB_addons_assets();
		}
	}

	/**
	 * FRONT-END: enqueue styles and scripts for templates (header/footer/etc parts)
	 * @noinspection PhpUnused
	 * @param Post_CSS $file
	 */
	public static function enqueue_templates_assets( Post_CSS $file ) {
		if ( get_queried_object_id() === $file->get_post_id() ) {
			return;
		}

		$template_type = get_post_meta( $file->get_post_id(), '_elementor_template_type', true );
		if ( $template_type === 'kit' ) {
			return;
		}

		$post_id = $file->get_post_id();

		self::frontend_enqueue_assets( $post_id );
	}

	/**
	 * BACK-END: Register JS/CSS and localized text
	 * @noinspection PhpUnused
	 */
	public static function enqueue_admin_assets() {

		$page = Utilities::get('page');
		if ( ! empty($page) && $page != 'creative-addons' && $page != 'creative-addons-get-help' && $page != 'crel-new-features' ) {
			return;
		}

		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

		// register CSS/JS
		wp_register_script( 'crel-admin-scripts', CREATIVE_ADDONS_DIR_URL . 'assets/js/admin-scripts' . $suffix . '.js', ['jquery'], CREATIVE_ADDONS_VERSION, true );
		wp_register_style( 'crel-admin-styles', CREATIVE_ADDONS_DIR_URL . 'assets/css/admin/admin'  . $suffix . '.css', [], CREATIVE_ADDONS_VERSION );

		// localize text
		wp_localize_script( 'crel-admin-scripts', 'crel_vars', array(
			'saving_config'           => esc_html__( 'Saving widgets', 'creative-addons-for-elementor' ),
			'saved_config'           => esc_html__( 'Saved!', 'creative-addons-for-elementor' ),
			'save_config'           => esc_html__( 'Save Settings', 'creative-addons-for-elementor' ),
		));

		wp_enqueue_style( 'crel-admin-styles' );
		wp_enqueue_script( 'crel-admin-scripts' );
	}
}
