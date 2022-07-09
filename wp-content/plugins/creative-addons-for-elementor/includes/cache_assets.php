<?php
namespace Creative_Addons\includes;

defined( 'ABSPATH' ) || exit();

/**
 * Cache CSS for given post in upload directory of the plugin
 */
class Cache_Assets {

	// post being cached in file system
	protected $post_id = 0;

	// store cache of widgets
	protected $widgets_cache = null;

	/**
	 * Initialize assets cache
	 * @param int $post_id
	 * @param Cache_Widgets|null $widget_cache_instance
	 */
	public function __construct( $post_id=0, Cache_Widgets $widget_cache_instance=null ) {
		$this->post_id = $post_id;
		$this->widgets_cache = $widget_cache_instance;
	}

	public function has_cache() {
		if ( ! $this->is_cache_exists() ) {
			$this->save();
		}
		return $this->is_cache_exists();
	}

	/**
	 * Save CSS for CREL widgets used in this post
	 */
	public function save() {

		// if the post does not have our widgets then do not cache our CSS
		$widgets = $this->get_widgets_cache()->get_cache();
		$widgets_list = Widgets_Manager::get_all_widgets_list();
		$styles_content = '';
		$widgets_added = [];
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
		
		foreach ( $widgets as $index => $widget_name ) {

			if ( isset($widgets_added[$widget_name]) || ! in_array($widget_name, array_keys($widgets_list)) ) {
				continue;
			}

			// read minimized file for a given widget
			$styles_content .= ' /** CSS for widget: ' . $widget_name . ' **/ ' . Files_Manager::read( CREATIVE_ADDONS_DIR_PATH . "assets/css/front-end/widgets/{$widget_name}{$suffix}.css" );
			$widgets_added[$widget_name] = true;
		}

		// write all-widgets CSS into /upload file for the post
		Files_Manager::make_directory( $this->get_cache_assets_dir() );
		Files_Manager::write( $this->get_post_file_name(), $styles_content );
	}

	public function get_widgets_cache() {
		if ( is_null( $this->widgets_cache ) ) {
			$this->widgets_cache = new Cache_Widgets( $this->get_post_id() );
		}
		return $this->widgets_cache;
	}

	public function delete_file() {
		if ( $this->is_cache_exists() ) {
			Files_Manager::delete_file( $this->get_post_file_name() );
		}
	}
	public function delete_all() {
		$files = glob( $this->get_cache_assets_dir() . '*' );
		foreach ( $files as $file ) {
			if ( is_file( $file ) ) {
				unlink( $file );
			}
		}
	}


	/*************************  GET functions **************************/

	public function is_cache_exists() {
		return file_exists( $this->get_post_file_name() );
	}

	public function get_post_id() {
		return $this->post_id;
	}

	public function get_cache_assets_dir() {
		return Files_Manager::get_upload_path_dir( 'cache' );
	}

	public function get_cache_assets_url() {
		return Files_Manager::get_upload_path_url( 'cache' );
	}

	public function get_post_file_name() {
		return $this->get_cache_assets_dir() . 'creative-cache-' . $this->get_post_id() . '.css';
	}

	public function get_post_file_url() {
		return $this->get_cache_assets_url() . 'creative-cache-' . $this->get_post_id() . '.css';
	}
}
