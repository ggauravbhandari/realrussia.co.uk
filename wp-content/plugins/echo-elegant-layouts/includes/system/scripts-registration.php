<?php

/**  Register JS and CSS files  */

/**
 * FRONT-END pages using our plugin features
 */
function elay_load_public_resources() {
	global $eckb_kb_id;
	
	elay_register_public_resources();
	
	$post = empty($GLOBALS['post']) ? '' : $GLOBALS['post'];
	if ( ! class_exists( ELAY_KB_Core::ELAY_KB_KNOWLEDGE_BASE) || empty($post) || empty($eckb_kb_id) ) {
		return;
	}

	elay_enqueue_public_resources();
}
add_action( 'wp_enqueue_scripts', 'elay_load_public_resources' );

/**
 * Register for FRONT-END pages using our plugin features
 */
function elay_register_public_resources() {

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	wp_register_style( 'elay-public-styles', Echo_Elegant_Layouts::$plugin_url . 'css/public-styles' . $suffix . '.css', array(), Echo_Elegant_Layouts::$version );
	
	if ( is_rtl() ) {
		wp_register_style( 'elay-public-styles-rtl', Echo_Elegant_Layouts::$plugin_url . 'css/public-styles-rtl' . $suffix . '.css', array(), Echo_Elegant_Layouts::$version );
	}
	
	wp_register_script( 'elay-public-scripts', Echo_Elegant_Layouts::$plugin_url . 'js/public-scripts' . $suffix . '.js', array( 'jquery' ), Echo_Elegant_Layouts::$version );
	wp_localize_script( 'elay-public-scripts', 'elay_vars', array(
		'ajaxurl'               => admin_url( 'admin-ajax.php', 'relative' ),
		'msg_try_again'         => esc_html__( 'Please try again later.', 'echo-knowledge-base' ),
		'error_occurred'        => esc_html__( 'Error occurred', 'echo-knowledge-base' ) . ' (16)',
		'not_saved'             => esc_html__( 'Error occurred - configuration NOT saved (6).', 'echo-knowledge-base' ),
		'unknown_error'         => esc_html__( 'Unknown error', 'echo-knowledge-base' ) . ' (17)',
		'reload_try_again'      => esc_html__( 'Please reload the page and try again.', 'echo-knowledge-base' ),
		'save_config'           => esc_html__( 'Saving configuration', 'echo-knowledge-base' ),
		'input_required'        => esc_html__( 'Input is required', 'echo-knowledge-base' ),
		'reduce_name_size'      => esc_html__( 'Warning: Please reduce your name size. Tab will only show first 25 characters', 'echo-knowledge-base' ),
		'nonce'                 => wp_create_nonce( "_wpnonce_elay_ajax_action" ),
	));
}

/**
 * Queue for FRONT-END pages using our plugin features
 * @noinspection PhpUnusedParameterInspection
 * @param int $kb_id
 */
function elay_enqueue_public_resources( $kb_id=0 ) {
	wp_enqueue_style( 'elay-public-styles' );
	
	if ( is_rtl() ) {
		wp_enqueue_style( 'elay-public-styles-rtl' );
	}
	wp_enqueue_script( 'elay-public-scripts' );

	elay_enqueue_google_fonts();
	do_action( 'epkb_enqueue_font_scripts');
}
add_action( 'epkb_enqueue_scripts', 'elay_enqueue_public_resources' );

/**
 * Only used for KB Configuration page
 */
function elay_kb_config_load_public_css() {

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	wp_enqueue_style( 'elay-public-styles', Echo_Elegant_Layouts::$plugin_url . 'css/public-styles' . $suffix . '.css', array(), Echo_Elegant_Layouts::$version );
	
	if ( is_rtl() ) {
		wp_enqueue_style( 'elay-public-styles-rtl', Echo_Elegant_Layouts::$plugin_url . 'css/public-styles-rtl' . $suffix . '.css', array(), Echo_Elegant_Layouts::$version );
	}
}

/**
 * ADMIN-PLUGIN MENU PAGES (Plugin settings, reports, lists etc.)
 */
function elay_load_admin_plugin_pages_resources() {

	// if SCRIPT_DEBUG is off then use minified scripts
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	wp_enqueue_style( 'elay-admin-plugin-pages-styles', Echo_Elegant_Layouts::$plugin_url . 'css/admin-plugin-pages' . $suffix . '.css', array(), Echo_Elegant_Layouts::$version );
	
	if ( is_rtl() ) {
		wp_enqueue_style( 'elay-admin-plugin-pages-rtl', Echo_Elegant_Layouts::$plugin_url . 'css/admin-plugin-pages-rtl' . $suffix . '.css', array(), Echo_Elegant_Layouts::$version );
	}
	
	wp_enqueue_style( 'wp-color-picker' ); //Color picker

	wp_enqueue_script( 'elay-admin-plugin-pages-scripts', Echo_Elegant_Layouts::$plugin_url . 'js/admin-plugin-pages' . $suffix . '.js',
					array('jquery', 'jquery-ui-core','jquery-ui-dialog','jquery-effects-core','jquery-effects-bounce', 'jquery-ui-sortable'), Echo_Elegant_Layouts::$version );
	wp_localize_script( 'elay-admin-plugin-pages-scripts', 'elay_vars', array(
					'msg_try_again'         => esc_html__( 'Please try again later.', 'echo-knowledge-base' ),
					'error_occurred'        => esc_html__( 'Error occurred', 'echo-knowledge-base' ) . ' (11)',
					'not_saved'             => esc_html__( 'Error occurred - configuration NOT saved (12).', 'echo-knowledge-base' ),
					'unknown_error'         => esc_html__( 'Unknown error', 'echo-knowledge-base' ) . ' (13)',
					'reload_try_again'      => esc_html__( 'Please reload the page and try again.', 'echo-knowledge-base' ),
					'save_config'           => esc_html__( 'Saving configuration', 'echo-knowledge-base' ),
					'input_required'        => esc_html__( 'Input is required', 'echo-knowledge-base' ),
					'nonce'                 => wp_create_nonce( "_wpnonce_elay_ajax_action" ),
				));

	if ( ELAY_Utilities::get('page') == ELAY_KB_Core::ELAY_KB_CONFIGURATION_PAGE ) {
		wp_enqueue_script( 'elay-admin-kb-config-script', Echo_Elegant_Layouts::$plugin_url . 'js/admin-elay-config-script' . $suffix . '.js',
			array('jquery',	'jquery-ui-core', 'jquery-ui-dialog', 'jquery-effects-core', 'jquery-effects-bounce'), Echo_Elegant_Layouts::$version );
		wp_localize_script( 'elay-admin-kb-config-script', 'elay_vars', array(
			'msg_try_again'         => esc_html__( 'Please try again later.', 'echo-knowledge-base' ),
			'error_occurred'        => esc_html__( 'Error occurred', 'echo-knowledge-base' ) . ' (14)',
			'not_saved'             => esc_html__( 'Error occurred - configuration NOT saved.', 'echo-knowledge-base' ),
			'unknown_error'         => esc_html__( 'Unknown error', 'echo-knowledge-base' ) . ' (15)',
			'reload_try_again'      => esc_html__( 'Please reload the page and try again.', 'echo-knowledge-base' ),
			'save_config'           => esc_html__( 'Saving configuration', 'echo-knowledge-base' ),
			'input_required'        => esc_html__( 'Input is required', 'echo-knowledge-base' ),
			'nonce'                 => wp_create_nonce( "_wpnonce_elay_ajax_action" ),
		));
	}
		
	wp_enqueue_script( 'wp-color-picker' );
	wp_enqueue_style( 'wp-jquery-ui-dialog' );
}

/**
 * Certain styles need to be inserted in the header.
 *
 * @param $add_on_output
 * @param $kb_id
 * @param $is_kb_main_page
 * @return string
 */
function elay_frontend_kb_theme_styles_now( $add_on_output, $kb_id, $is_kb_main_page ) {

	$add_on_config = elay_get_instance()->kb_config_obj->get_kb_config_or_default( $kb_id );

	// if this is not Sidebar Layout then don't continue
	$article_page_layout = ELAY_KB_Core::get_value( $kb_id, 'kb_article_page_layout' );
	$main_page_layout = ELAY_KB_Core::get_value( $kb_id, 'kb_main_page_layout' );
	if ( ( $is_kb_main_page && $main_page_layout != ELAY_KB_Config_Layout_Sidebar::LAYOUT_NAME) ||
	     ( ! $is_kb_main_page && $article_page_layout != ELAY_KB_Config_Layout_Sidebar::LAYOUT_NAME ) ) {
		return $add_on_output;
	}

	$add_on_output .= '
		/* ELAY2 
		-----------------------------------------------------------------------*/
		#elay-content-container .elay-articles .active {
			background-color: ' . $add_on_config['sidebar_article_active_background_color'] . ' !important;
			border-radius: 4px;
            padding-left: 5px !important;
            padding-right: 5px !important; ';
			
			if ( is_rtl() ) {
				$add_on_output .= 'margin-right: -5px !important;';
			} else {
				$add_on_output .= 'margin-left: -5px !important;';
			}
			
            $add_on_output .= '
		}
		#elay-content-container .elay-articles .active span {
			color: ' . $add_on_config['sidebar_article_active_font_color'] . ' !important;
		}
		#elay-content-container .elay-articles .active i {
			color: ' . $add_on_config['sidebar_article_active_font_color'] . ' !important;
		}
	';

	return $add_on_output;

}
add_filter( 'eckb_frontend_kb_theme_style', 'elay_frontend_kb_theme_styles_now', 10, 3 );

/**
 * Enguque fonts that are configured in KB config
 */
function elay_enqueue_google_fonts() {
	global $eckb_kb_id;

	$kb_id = empty($eckb_kb_id) ? ELAY_KB_Config_DB::DEFAULT_KB_ID : $eckb_kb_id;
	$kb_config = elay_get_instance()->kb_config_obj->get_kb_config( $kb_id );

	foreach ( $kb_config as $name => $value ) {
		if ( is_array( $value ) && ! empty( $value['font-family'] ) ) {
			$font_link = ELAY_Typography::get_google_font_link( $value['font-family'] );
			if ( ! empty($font_link) ) {
				wp_enqueue_style( 'epkb-font-' . sanitize_title( $value['font-family']), $font_link );
			}
		}
	}
}