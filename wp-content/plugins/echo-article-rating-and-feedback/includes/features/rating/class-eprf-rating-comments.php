<?php  // Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Prevent feedback to show on article pages.
 */
class EPRF_Rating_Comments  {

    public function __construct() {
        add_filter( 'parse_comment_query', array( $this, 'comment_where_filter' ));
	//	add_filter( 'get_comments_number', array( $this, 'comment_number_filter' ), 10, 2);
	//	add_filter( 'pre_wp_update_comment_count_now', array( $this, 'comment_number_filter2' ), 20, 3);
    }
	
	// filter for all functions like get_comments 
	public function comment_where_filter( $where ) {
		if ( !is_admin() ) {
			$where->query_vars['type__not_in'] = 'eprf-article';
		}
		
		return $where;
	}
	
	// filter comment_number function on the article page
	public function comment_number_filter( $number, $post_id ) {
		global $wpdb;

		$post = get_post( $post_id );

		// verify it is a KB article
		if ( EPRF_KB_Handler::is_kb_post_type( $post->post_type ) ) {

			$feedback_comments_count = (int) $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $wpdb->comments WHERE comment_post_ID = %d AND comment_type = 'eprf-article' ", $post_id ) );

			return abs($number - $feedback_comments_count);
		} else {
			return $number;
		}
	}
	
	public function comment_number_filter2( $new, $old, $post_id ) {
		global $wpdb;

		$new = (int) $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM $wpdb->comments WHERE comment_post_ID = %d AND comment_approved = '1' AND comment_type != 'eprf-article'", $post_id ) );

		return $new;
	}
}