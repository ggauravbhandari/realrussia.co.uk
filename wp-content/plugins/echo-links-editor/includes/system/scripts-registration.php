<?php

/**  Register JS and CSS files  */

/**
 * FRONT-END pages using our plugin features
 */
function kblk_load_public_resources() {

	global $eckb_kb_id;

	// if this is not KB Main Page then do not load public resources
	if ( empty($eckb_kb_id) ) {
		return;
	}

	kblk_load_public_resources_now();
}
add_action( 'wp_enqueue_scripts', 'kblk_load_public_resources' );


function kblk_load_public_resources_now() {
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	//wp_enqueue_style( 'kblk-public-styles', Echo_Links_Editor::$plugin_url . 'css/public-styles' . $suffix . '.css', array(), Echo_Links_Editor::$version );
	wp_enqueue_script( 'kblk-public-scripts', Echo_Links_Editor::$plugin_url . 'js/public-scripts' . $suffix . '.js', array( 'jquery' ), Echo_Links_Editor::$version );
	wp_localize_script( 'kblk-public-scripts', 'kblk_vars', array(
		'msg_try_again'         => esc_html__( 'Please try again later.', 'echo-knowledge-base' ),
		'error_occurred'        => esc_html__( 'Error occurred (16)', 'echo-knowledge-base' ),
		'not_saved'             => esc_html__( 'Error occurred - configuration NOT saved.', 'echo-knowledge-base' ),
		'unknown_error'         => esc_html__( 'unknown error (17)', 'echo-knowledge-base' ),
		'reload_try_again'      => esc_html__( 'Please reload the page and try again.', 'echo-knowledge-base' ),
		'save_config'           => esc_html__( 'Saving configuration', 'echo-knowledge-base' ),
		'input_required'        => esc_html__( 'Input is required', 'echo-knowledge-base' ),
	));
}

/**
 * ADMIN-PLUGIN MENU PAGES (Plugin settings, reports, lists etc.)
 */
function kblk_load_admin_plugin_pages_resources(  ) {
	global $eckb_kb_id;
	
	// if SCRIPT_DEBUG is off then use minified scripts
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
	
	$add_article_url =  get_admin_url( null, 'post-new.php?post_type=epkb_post_type_' . $eckb_kb_id . '&linked-editor=yes' );
	
	wp_enqueue_style( 'kblk-admin-plugin-pages-styles', Echo_Links_Editor::$plugin_url . 'css/admin-plugin-pages' . $suffix . '.css', array(), Echo_Links_Editor::$version );
	wp_enqueue_script( 'kblk-admin-plugin-pages-scripts', Echo_Links_Editor::$plugin_url . 'js/admin-plugin-pages' . $suffix . '.js',
					array('jquery', 'jquery-ui-core','jquery-ui-dialog','jquery-effects-core','jquery-effects-bounce', 'jquery-ui-sortable'), Echo_Links_Editor::$version );
	wp_localize_script( 'kblk-admin-plugin-pages-scripts', 'kblk_vars', array(
					'msg_try_again'         => esc_html__( 'Please try again later.', 'echo-knowledge-base' ),
					'error_occurred'        => esc_html__( 'Error occurred (11)', 'echo-knowledge-base' ),
					'not_saved'             => esc_html__( 'Error occurred - configuration NOT saved (12).', 'echo-knowledge-base' ),
					'unknown_error'         => esc_html__( 'unknown error (13)', 'echo-knowledge-base' ),
					'reload_try_again'      => esc_html__( 'Please reload the page and try again.', 'echo-knowledge-base' ),
					'save_config'           => esc_html__( 'Saving configuration', 'echo-knowledge-base' ),
					'input_required'        => esc_html__( 'Input is required', 'echo-knowledge-base' ),
					'add_link_tag'     => sprintf( '<a href="%s" class="kblk-page-title-action">%s</a>', $add_article_url, __( 'Add New LINK Article', 'echo-knowledge-base' ))
				));

	wp_enqueue_style( 'wp-jquery-ui-dialog' );
}
