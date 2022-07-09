<?php
namespace Creative_Addons\includes;

use Elementor\Core\Files\CSS\Post as Post_CSS;
use Elementor\Icons_Manager;
use Elementor\Plugin;

defined( 'ABSPATH' ) || exit();

class Cache_Manager {

	private static $widgets_cache;

	/**
	 * Register hooks for post save/delete
	 */
	public static function init() {
		add_action( 'elementor/editor/after_save', [ __CLASS__, 'cache_widgets' ], 10, 2 );
		add_action( 'after_delete_post', [ __CLASS__, 'delete_cache' ] );
		add_action( 'elementor/core/files/clear_cache', [ __CLASS__, 'clear_css_cache' ] );	
	}

	/**
	 * Called after Elementor saves data to the database. Cache both post widget data and CSS files.
	 *
	 * @param $post_id
	 * @param $editor_data
	 *
	 * @noinspection PhpUnused*/
	public static function cache_widgets( $post_id, $editor_data ) {
		
		if ( ! Utilities::is_published( $post_id ) && ! Utilities::is_private( $post_id ) ) {
			return;
		}

		// regenerate Widgets post meta
		self::$widgets_cache = new Cache_Widgets( $post_id, $editor_data );
		self::$widgets_cache->save();

		// regenerate CSS files
		$cache_assets = new Cache_assets( $post_id, self::$widgets_cache );
		$cache_assets->delete_file();
	}

	/** @noinspection PhpUnused */
	/**
	 * User is deleting post so delete our cache data
	 * @param $post_id
	 */
	public static function delete_cache( $post_id ) {
		// Delete to regenerate cache file
		$cache_assets = new Cache_assets( $post_id );
		$cache_assets->delete_file();

		self::$widgets_cache = new Cache_Widgets( $post_id );
		self::$widgets_cache->delete_cache();
	}

	/** @noinspection PhpUnused */
	public static function clear_css_cache( ) {
		Files_Manager::delete_all_files( Files_Manager::get_plugin_base_uploads_dir() . 'cache/' );
	}

	public static function get_widgets_cache() {
		return self::$widgets_cache;
	}
}
