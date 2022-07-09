<?php

/**
 * Setup links and information on Plugins WordPress page
 *
 */


/**
 * Adds various links for plugin on the Plugins page displayed on the left
 *
 * @param   array $links contains current links for this plugin
 * @return  array returns an array of links
 */
function crel_add_plugin_action_links ( $links ) {
	$my_links = array(
		__( 'Configuration', 'creative-addons-for-elementor' )    => '<a href="' .  admin_url( 'admin.php?page=creative-addons&tab=widgets' ) . '">' . __( 'Settings', 'creative-addons-for-elementor' ) . '</a>',
	);

	return array_merge( $my_links, $links );
}
add_filter( 'plugin_action_links_' . plugin_basename( CREATIVE_ADDONS__FILE__ ), 'crel_add_plugin_action_links' , 10, 2 );

/**
 * Add info about plugin on the Plugins page displayed on the right.
 *
 * @param $links
 * @param $file
 * @return array
 */
function crel_add_plugin_row_meta($links, $file) {
	if ( $file != 'creative-addons-for-elementor/creative-addons-for-elementor.php' ) {
		return $links;
	}

	$links[] = '<a href="https://www.creative-addons.com/elementor-docs/" target="_blank">' . esc_html__( 'Docs & FAQs', 'creative-addons-for-elementor' ) . '</a>';
	$links[] = '<a href="https://www.creative-addons.com/support/" target="_blank">' . esc_html__( 'Support', 'creative-addons-for-elementor' ) . '</a>';

	return $links;
}
add_filter( 'plugin_row_meta', 'crel_add_plugin_row_meta', 10, 2 );
