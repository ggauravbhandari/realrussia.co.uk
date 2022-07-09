<?php
namespace Creative_Addons\includes;

defined( 'ABSPATH' ) || exit();

/**
 *
 *
 * Class Cache_Widgets
 * @package Creative_Addons\includes
 */
class Cache_Widgets {

    const CACHE_POST_META_KEY = '_creative_addons_elements_cache';

    protected $post_id = 0;
	protected $is_published = false;
    protected $elementor_editor_data = null;
	protected $is_built_with_elementor = false;

	/**
	 * Setup cache for given post and its widgets meta data
	 *
	 * @param int   $post_id     The ID of the post.
	 * @param array $editor_data Sanitize posted data.
	 */
    public function __construct( $post_id=0, $editor_data=null ) {

        // should not happen
        if ( empty($post_id) || ( ! Utilities::is_published( $post_id ) && ! Utilities::is_private( $post_id ) ) || ! Utilities_Plugin::is_built_with_elementor( $post_id )  ) {
            return;
        }

	    $this->post_id = $post_id;
	    $this->is_published = true;
        $this->elementor_editor_data = is_null($editor_data) ? $this->elementor_editor_data : $editor_data;
	    $this->is_built_with_elementor = true;
    }

	/**
	 * Retrieve the cache
	 * @return array
	 */
    public function get_cache() {
	    $cache = get_post_meta( $this->get_post_id(), self::CACHE_POST_META_KEY, true );
	    if ( empty( $cache ) || ! is_array( $cache ) ) {
		    $cache = $this->save();
	    }

        return array_map( function( $widget_key ) {
                    return str_replace( 'crel-', '', $widget_key );
                }, array_keys( $cache ) );
    }

	/**
	 * Remove our post meta cache data
	 */
    public function delete_cache() {
        delete_post_meta( $this->get_post_id(), self::CACHE_POST_META_KEY );
    }

	/**
	 * Save post data for widgets into database
	 * @return array
	 */
    public function save() {

	    // first retrieve post data_container
        $data_container = $this->get_elementor_editor_data();
        if ( empty( $data_container ) ) {
            return [];
        }

        // find which of our widgets are used in the post to ca_widgets_cache them
        $ca_widgets_cache = [];
        Utilities_Plugin::elementor()->db->iterate_data( $data_container, function ( $element ) use ( &$ca_widgets_cache ) {

            $type = Utilities_Plugin::get_widget_type( $element );
            if ( strpos( $type, 'crel-' ) !== false ) {
	            isset($ca_widgets_cache[$type]) ? $ca_widgets_cache[$type]++ : $ca_widgets_cache[$type] = 1;
            }

            return $element;
        } );

        // Save ca_widgets_cache
        update_post_meta( $this->get_post_id(), self::CACHE_POST_META_KEY, $ca_widgets_cache );

        return $ca_widgets_cache;
    }

	/**
	 * Get Elementor data for given post
	 * @return array|null
	 */
	public function get_elementor_editor_data() {
		if ( ! $this->is_built_with_elementor || ! $this->is_published ) {
			return [];
		}

		if ( is_null( $this->elementor_editor_data ) ) {
			$document = Utilities_Plugin::elementor()->documents->get( $this->get_post_id() );
			$data = $document ? $document->get_elements_data() : array();
		} else {
			$data = $this->elementor_editor_data;
		}

		return $data;
	}

	public function get_post_id() {
		return $this->post_id;
	}
}
