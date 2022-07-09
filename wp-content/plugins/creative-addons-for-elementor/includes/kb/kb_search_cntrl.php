<?php
namespace Creative_Addons\Includes\Kb;

use Creative_Addons\Includes\Utilities;

defined( 'ABSPATH' ) || exit();

/**
 * Handle KB Basic Search for KB Search Elementor widget
 */
class KB_Search_Cntrl {
	
	public function __construct() {
		add_action( 'wp_ajax_crel-search-kb', array($this, 'search_kb') );
		add_action( 'wp_ajax_nopriv_crel-search-kb', array($this, 'search_kb') );
	}
	
	/**
	 * Process AJAX search request
	 */
	public function search_kb() {

		// we don't need nonce and permission check here

		$kb_id = Utilities::sanitize_get_id( $_GET['crel_kb_id'] );
		if ( is_wp_error( $kb_id ) ) {
			wp_die( json_encode( array( 'status' => 'error', 'search_result' => esc_html__( 'Error occurred. Please try again later.', 'creative-addons-for-elementor' ), 'show_more' => false ) ) );
		}

		$kb_config = KB_Utilities::get_kb_config( $kb_id );
		if ( empty($kb_config) || ! is_array($kb_config) ) {
			return;
		}

		// remove question marks
		$search_terms = Utilities::get( 'search_words' );
		$search_terms = stripslashes( $search_terms );
		$search_terms = str_replace('?', '', $search_terms);
		$search_terms = str_replace( array( "\r", "\n" ), '', $search_terms );

		// require minimum size of search word(s)
		if ( empty($search_terms) ) {
			wp_die( json_encode( array( 'status' => 'error', 'search_result' => esc_html( $kb_config['min_search_word_size_msg'] ), 'show_more' => false ) ) );
		}

		$list_size = intval( Utilities::get( 'crel_list_size' ) );
		if ( empty( $list_size ) || ( $list_size  > 0 && $list_size < 3 ) ) {
			$list_size = 10; // default value
		}

		// search for given keyword(s)
		$result = $this->execute_search( $kb_id, $search_terms, $list_size  );

		if ( empty($result) ) {
			$search_result = '<li class="crel-sbsr__list-item"><div class="crel-sbsr__list-no-results"><span>' . $kb_config['no_results_found'] . '</span></div></li>';
			wp_die( json_encode( array( 'status' => 'error', 'search_result' => $search_result, 'show_more' => false ) ) );

		} else {

			// ensure that links have https if the current schema is https
			set_current_screen('front');

			$search_result = '';
			$show_more = false;
			if ( $list_size > 0 && count($result) > $list_size ) {
				$show_more = true;
				array_pop($result);
			}
			
			// display one line for each search result
			foreach( $result as $post ) {

				$article_url = get_permalink( $post->ID );
				if ( empty($article_url) || is_wp_error( $article_url )) {
					continue;
				}

				// linked articles have their own icon
				$article_title_icon = 'crel_ep_font_icon_document';
				if ( has_filter( 'eckb_single_article_filter' ) ) {
					$article_title_icon = apply_filters( 'eckb_article_icon_filter', $article_title_icon, $post->ID );
					$article_title_icon = empty( $article_title_icon ) ? 'crelfa-file-text-o' : $article_title_icon;
				}

				// linked articles have open in new tab option
				$link_editor_config = Utilities::get_postmeta( $post->ID, 'kblk-link-editor-data', [], true );
				$new_tab            = empty( $link_editor_config['open-new-tab'] ) ? '' : 'target="_blank"';
				$article_title_icon = KB_Utilities::replace_icons_name($article_title_icon);
				
				$search_result .=
					'<li class="crel-sbsr__list-item">' . 
						'<a class="crel-sbsr__list-item__inner" href="' .  esc_url( $article_url ) . '" ' . $new_tab . '>' .
							'<div class="crel-sbsr__list-item__article">' .
								'<div class="crel-sbsr__list-item__article__icon crelfa ' . esc_attr($article_title_icon) . '"></div>' .
								'<div class="crel-sbsr__list-item__article__text">' . esc_html($post->post_title) . '</div>' .
							'</div>' .
						'</a>' .
					'</li>';
			}
			
			// we are done here
			wp_die( json_encode( array( 'status' => 'success', 'search_result' => $search_result, 'show_more' => $show_more ) ) );
		}
	}
	
	/**
	 * Call WP query to get matching terms (any term OR match)
	 *
	 * @param $kb_id
	 * @param $search_terms,
	 * @param $list_size,
	 * @return array
	 */
	private function execute_search( $kb_id, $search_terms, $list_size ) {

		// add-ons can adjust the search (like Links Editor)
		if ( has_filter( 'eckb_execute_search_filter' ) ) {
			$result = apply_filters('eckb_execute_search_filter', '', $kb_id, $search_terms );
			if ( is_array($result) ) {
				return $result;
			}
		}

		$result = array();
		$search_params = array(
				's' => $search_terms,
				'post_type' => KB_Handler::get_post_type( $kb_id ),
				'ignore_sticky_posts' => true,  // sticky posts will not show at the top
				'posts_per_page' => $list_size + 1,         // limit search results
				'no_found_rows' => true,        // query only posts_per_page rather than finding total nof posts for pagination etc.
				'cache_results' => false,       // don't need that for mostly unique searches
				'orderby' => 'relevance'
		);

		// define post_status only for older versions of KB
		if ( ! Utilities::is_new_user( '7.5.0' ) ) {
			$search_params['post_status'] = KB_Utilities::is_amag_on( true ) ? array('publish', 'private') : array('publish');
		}

		$found_posts_obj = new \WP_Query( $search_params );
		if ( ! empty($found_posts_obj->posts) ) {
			$result = $found_posts_obj->posts;
			wp_reset_postdata();
		}

		return $result;
	}
}
