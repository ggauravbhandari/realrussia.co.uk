<?php  if ( ! defined( 'ABSPATH' ) ) exit;

spl_autoload_register(array( 'KBLK_Autoloader', 'autoload'));

/**
 * A class which contains the autoload function, that the spl_autoload_register
 * will use to autoload PHP classes.
 *
 * @copyright   Copyright (C) 2018, Echo Plugins
 */
class KBLK_Autoloader {

	public static function autoload( $class ) {
		static $classes = null;

		if ( $classes === null ) {
			$classes = array(

				// CORE
				'kblk_utilities'                    =>  'includes/class-kblk-utilities.php',
				'kblk_local_utilities'              =>  'includes/class-kblk-local-utilities.php',
				'kblk_html_elements'                =>  'includes/class-kblk-html-elements.php',
				'kblk_input_filter'                 =>  'includes/class-kblk-input-filter.php',

				// SYSTEM
				'kblk_logging'                      =>  'includes/system/class-kblk-logging.php',
				'kblk_kb_core'                      =>  'includes/system/class-kblk-kb-core.php',
				'kblk_license_handler'              =>  'includes/system/class-kblk-license-handler.php',
				'kblk_upgrades'                     =>  'includes/system/class-kblk-upgrades.php',

				// ADMIN CORE
				'kblk_admin_notices'                =>  'includes/admin/class-kblk-admin-notices.php',
				'kblk_settings_page'                =>  'includes/admin/settings/class-kblk-settings-page.php',

				// ADMIN PLUGIN MENU PAGES
				// KB Configuration
				'kblk_kb_config_controller'         =>  'includes/admin/kb-configuration/class-kblk-kb-config-controller.php',
				'kblk_kb_config_specs'              =>  'includes/admin/kb-configuration/class-kblk-kb-config-specs.php',
				'kblk_kb_config_db'                 =>  'includes/admin/kb-configuration/class-kblk-kb-config-db.php',
				'kblk_kb_config_elements'           =>  'includes/admin/kb-configuration/class-kblk-kb-config-elements.php',
				'kblk_kb_config_page'               =>  'includes/admin/kb-configuration/class-kblk-kb-config-page.php',

				'kblk_add_ons_page'                 =>  'includes/admin/add-ons/class-kblk-add-ons-page.php',

				// FEATURES - KB
				'kblk_kb_handler'                   =>  'includes/features/kbs/class-kblk-kb-handler.php',

				// FEATURES - LINK
				'kblk_article_display_link'         =>  'includes/features/link/class-kblk-article-display-link.php',
				'kblk_article_editor_cntrl'         =>  'includes/features/link/class-kblk-article-editor-ctrl.php',
				'kblk_article_editor_view'          =>  'includes/features/link/class-kblk-article-editor-view.php',
				'kblk_article_link_icons'           =>  'includes/features/link/class-kblk-article-link-icons.php',
				'kblk_links_editor'                 =>  'includes/features/link/class-kblk-links-editor.php',
				'kblk_search_query'                 =>  'includes/features/link/class-kblk-search-query.php',
			);
		}

		$cn = strtolower( $class );
		if ( isset( $classes[ $cn ] ) ) {
			/** @noinspection PhpIncludeInspection */
			include_once( plugin_dir_path( Echo_Links_Editor::$plugin_file ) . $classes[ $cn ] );
		}
	}
}
