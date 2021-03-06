<?php

/**
 * Shortcode - Search 
 *
 * @copyright   Copyright (c) 2018, Echo Plugins
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */
class ASEA_Search_Shortcode {

	public function __construct() {
		add_shortcode( 'eckb-advanced-search', array( $this, 'output_shortcode' ) );
	}

    /**
     * Output the shortcode
     * @param $attributes
     * @return string
     */
    public function output_shortcode( $attributes ) {
        global $eckb_kb_id;

	    $shortcode_ids = empty($attributes['kb_id']) ? ( empty($eckb_kb_id) ? array(ASEA_KB_Config_DB::DEFAULT_KB_ID) : array($eckb_kb_id) )
                                : explode(",", $attributes['kb_id']);

	    $shortcode_kb_ids = array();
	    foreach( $shortcode_ids as $shortcode_kb_id ) {
		    if (is_numeric($shortcode_kb_id) ) {
			    $shortcode_kb_ids[] = intval($shortcode_kb_id);
		    }
	    }

	    // validate KB IDs and filter duplicates
        $db_kb_config = new ASEA_KB_Core();
        $all_kb_ids = $db_kb_config->get_kb_ids();
        $search_kb_ids = array();
        foreach ( $shortcode_kb_ids as $kb_id ) {
            if ( in_array( $kb_id, $all_kb_ids ) && ! in_array($kb_id, $search_kb_ids) ) {
                $search_kb_ids[] = $kb_id;
            }
        }

        // get add-on configuration
        $kb_id = empty($search_kb_ids[0]) ? ASEA_KB_Config_DB::DEFAULT_KB_ID : $search_kb_ids[0];
        $kb_config = ASEA_KB_Core::get_kb_config( $kb_id );
        if ( is_wp_error($kb_config) ) {
            return '';
        }

		$kb_config['search_multiple_kbs'] = count($search_kb_ids) > 1 ? implode( ",", $search_kb_ids ) : '';
		$kb_config['seq_id'] = empty($attributes['seq_id']) ? 1 : $attributes['seq_id'];
	    $kb_config['advanced_search_mp_box_visibility'] = 'asea-visibility-search-form-1';   // always show search box
        $asea_config = asea_get_instance()->kb_config_obj->get_kb_config_or_default( $kb_id );

        $kb_config = array_merge($asea_config, $kb_config);

        // duplicate KB Main Page settings for search
		global $asea_use_main_page_settings;
		$asea_use_main_page_settings = true;

        asea_enqueue_public_resources( $kb_id );

        do_action( 'epkb_enqueue_font_scripts', $kb_id ); // Enqueue Fonts

        /* if ( function_exists('epkb_load_public_resources_now') ) {
            epkb_load_public_resources_now();
        }

        if ( function_exists( 'epkb_enqueue_public_resources' ) ) {
            epkb_enqueue_public_resources();
        } */

        // allows to adjust the widget title
        /* $title = empty($attributes['title']) ? '' : strip_tags( trim($attributes['title']) );
        $title = empty($title) ? esc_html__( 'Search by Knowledge Base', 'echo-advanced-search' ) : esc_html( $title );

        // allows to adjust the widget placeholder
        $placeholder = empty($attributes['placeholder']) ? '' : strip_tags( trim($attributes['placeholder']) );
        $placeholder = empty($placeholder) ? esc_html__( 'Search the documentation...', 'echo-advanced-search' ) : esc_html( $placeholder );

        // allows to adjust the widget button name
        $search_button_name = empty($attributes['button']) ? '' : strip_tags( trim($attributes['button']) );
        $search_button_name = empty($search_button_name) ? esc_html__( 'Search', 'echo-advanced-search' ) : esc_html( $search_button_name ); */


        // DISPLAY SEARCH BOX
        ob_start();

        do_action( 'eckb_advanced_search_box', $kb_config );

        return ob_get_clean();
    }
}
