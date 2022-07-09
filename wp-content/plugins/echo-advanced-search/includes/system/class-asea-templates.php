<?php

/**
 * Handle loading ASEA templates
 
 * @copyright   Copyright (C) 2018, Echo Plugins 
 * Some code adapted from code in EDD/WooCommmerce (Copyright (c) 2017, Pippin Williamson) and WP.
 */
class ASEA_Templates {

	public function __construct() {
   		add_filter( 'template_include', array( __CLASS__, 'template_loader' ), 999 );
	}

	/**
	 * Load article templates. Templates are in the 'templates' folder.
	 *
	 * Templates can be overriden in /theme/knowledgebase/ folder.
	 *
	 * @param mixed $template
	 * @return string
	 */
	public static function template_loader( $template ) {
		/** @var WP_Query $wp_query */
        global $wp_query, $eckb_is_kb_main_page;

		// ignore non-page/post conditions
        if ( ! self::is_post_page() ) {
            return $template;
        }

		// get current post
		$post = isset($GLOBALS['post']) ? $GLOBALS['post'] : '';
		if ( empty($post) || ! $post instanceof WP_Post ) {
			return $template;
		}

        // ignore posts that are not KB Articles; KB Main Page should not be in a post
        if ( $post->post_type == 'post' ) {
            return $template;
        }

		// ignore WordPress search results page
		if ( $wp_query->is_search() ) {
			return $template;
		}

		// is this KB Main Page ?
		if ( ! $eckb_is_kb_main_page ) {
			// if not KB Main Page is this KB Article Page ?
			$kb_id = ASEA_KB_Handler::get_kb_id_from_post_type( $post->post_type );
			if ( is_wp_error( $kb_id ) ) {
				return $template;
			}
		}

        // handle KB search results page (backward compability)
		$search_keywords = ASEA_Utilities::get( _x('search', 'search query parameter in URL', 'echo-advanced-search') );
		$search_keywords_new = ASEA_Utilities::get( _x( 'kb-search', 'search query parameter in URL', 'echo-advanced-search' ) );
		if ( empty($search_keywords) && empty($search_keywords_new) ) {
			return $template;
		}

		// for KB search results load the template; if not found return default WP template
		$located_template = self::locate_template( 'search-results.php' );
		if ( empty($located_template) ) {
			return $template;
		}

		return $located_template;
	}

	/**
	 * Retrieve the name of the highest priority template file that exists.
	 *
	 * Searches in the STYLESHEETPATH before TEMPLATEPATH so that CHILD THEME which
	 * inherit from a PARENT THEME can just overload one file. If the template is
	 * not found in either of those, it looks in KB template folder last
	 *
	 * Taken from bbPress
	 *
	 * @param string|array $template_names Template file(s) to search for, in order.
	 * @return false|string The template filename if one is located.
	 */
	public static function locate_template( $template_names ) {

		// No file found yet
		$located = false;

		// loop through hierarchy of template names
		foreach ( (array) $template_names as $template_name ) {

			// Continue if template is empty
			if ( empty( $template_name ) ) {
				continue;
			}

			// Trim off any slashes from the template name
			$template_name = ltrim( $template_name, '/' );

			// loop through hierarchy of template file locations ( child -> parent -> our theme )
			foreach( self::get_theme_template_paths() as $template_path ) {
				if ( file_exists( $template_path . $template_name ) ) {
					$located = $template_path . $template_name;
					break;
				}
			}

			if ( $located ) {
				break;
			}
		}

		return $located;
	}

	/**
	 * Returns a list of paths to check for template locations:
	 * 1. Child Theme Template
	 * 2. Parent Theme Template
	 * 3. KB Template
	 *
	 * @return array
	 */
	private static function get_theme_template_paths() {

		$template_dir = self::get_theme_template_dir_name();

		$file_paths = array(
			1 => trailingslashit( get_stylesheet_directory() ) . $template_dir,
			10 => trailingslashit( get_template_directory() ) . $template_dir,
			100 => self::get_templates_dir()
		);

		$file_paths = apply_filters( 'asea_template_paths', $file_paths );

		// sort the file paths based on priority
		ksort( $file_paths, SORT_NUMERIC );

		return array_map( 'trailingslashit', $file_paths );
	}

	/**
	 * Retrieves a template part
	 *
	 * Taken from bbPress
	 *
	 * @param string $slug
	 * @param string $name Optional. Default null
	 * @param $kb_config - used in templates
	 * @param $article
	 * @param bool $load
	 *
	 * @return string
	 */
	public static function get_template_part( $slug, $name, /** @noinspection PhpUnusedParameterInspection */ $kb_config,
		/** @noinspection PhpUnusedParameterInspection */$article, $load = true ) {
		// Execute code for this part
		do_action( 'asea_get_template_part_' . $slug, $slug, $name );

		$load_template = apply_filters( 'asea_allow_template_part_' . $slug . '_' . $name, true );
		if ( false === $load_template ) {
			return '';
		}

		// Setup possible parts
		$templates = array();
		if ( isset( $name ) )
			$templates[] = $slug . '-' . $name . '.php';
		$templates[] = $slug . '.php';

		// Allow template parts to be filtered
		$templates = apply_filters( 'asea_get_template_part', $templates, $slug, $name );

		// Return the part that is found
		$template_path = self::locate_template( $templates );
		if ( ( true == $load ) && ! empty( $template_path ) ) {
			include( $template_path );
		}

		return $template_path;
	}

	/**
	 * Check if current post/page could be KB one
	 *
	 * @return bool
	 */
	public static function is_post_page() {
		global $wp_query;

		if ( ( isset( $wp_query->is_archive ) && $wp_query->is_archive ) ||
		     ( isset( $wp_query->is_embed ) && $wp_query->is_embed ) ||
		     ( isset( $wp_query->is_category ) && $wp_query->is_category ) ||
		     ( isset( $wp_query->is_tag ) && $wp_query->is_tag ) ||
		     ( isset( $wp_query->is_attachment ) && $wp_query->is_attachment ) ) {
			return false;
		}

		$post = isset($GLOBALS['post']) ? $GLOBALS['post'] : '';
		if ( empty($post) || ! $post instanceof WP_Post || empty($post->post_type) ) {
			return false;
		}

		return true;
	}

	/**
	 * Returns the path to the EP templates directory
	 * @return string
	 */
	private static function get_templates_dir() {
		return Echo_Advanced_Search::$plugin_dir . 'templates';
	}

	/**
	 * Returns name of directory inside child or parent theme folder where KB templates are located
	 * Themes can filter this by using the asea_templates_dir filter.
	 *
	 * @return string
	 */
	private static function get_theme_template_dir_name() {
		return trailingslashit( apply_filters( 'asea_templates_dir', 'kb_templates' ) );
	}
}