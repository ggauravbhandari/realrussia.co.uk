<?php

/**
 * Process front-end Ajax operations.
 */
class EPRF_Rating_Cntrl {

	public function __construct() {
		add_action( 'wp_ajax_eprf-update-rating', array($this, 'process_user_rating') );
		add_action( 'wp_ajax_nopriv_eprf-update-rating', array($this, 'process_user_rating') );		
		add_action( 'wp_ajax_eprf-add-comment', array($this, 'process_add_comment') );
		add_action( 'wp_ajax_nopriv_eprf-add-comment', array($this, 'process_add_comment') );
	}

	/**
	 * Record rating given by user
	 */
	public function process_user_rating() {

		// verify that the request is authentic
		if ( empty( $_REQUEST['_wpnonce_user_rating_action_ajax'] ) || ! wp_verify_nonce( $_REQUEST['_wpnonce_user_rating_action_ajax'], '_wpnonce_user_rating_action_ajax' ) ) {
			EPRF_Utilities::ajax_show_error_die(__( 'Refresh your page', 'echo-article-rating-and-feedback' ));
		}

		$article_id = EPRF_Utilities::get( 'article_id' );
		if ( empty($article_id) ) {
			wp_die( json_encode( array( 'status' => 'error', 'message' => $this->article_feedback_confirmation_msg( __('Could not vote', 'echo-article-rating-and-feedback') . ' (1)') ) ) );
		}

		$post = EPRF_Core_Utilities::get_kb_post_secure( $article_id );
		if ( empty($post) ) {
			wp_die( json_encode( array( 'status' => 'error', 'message' => $this->article_feedback_confirmation_msg( __('Could not vote', 'echo-article-rating-and-feedback')  . ' (2)') ) ) );
		}

		$kb_id = EPRF_KB_Handler::get_kb_id_from_post_type( $post->post_type );
		if ( is_wp_error($kb_id) ) {
			wp_die( json_encode( array( 'status' => 'error', 'message' => $this->article_feedback_confirmation_msg( __('Could not vote', 'echo-article-rating-and-feedback')  . ' (3)') ) ) );
		}

		$kb_config = eprf_get_instance()->kb_config_obj->get_kb_config( $kb_id, true );
		if ( is_wp_error($kb_config) ) {
			wp_die( json_encode( array( 'status' => 'error', 'message' => $this->article_feedback_confirmation_msg( __('Could not vote)', 'echo-article-rating-and-feedback')  . ' (4)') ) ) );
		}

		$rating_value = (float)EPRF_Utilities::get( 'rating_value' );  

		// validate rating value
		$rating_mode = $kb_config['rating_mode'];
		$valid_value = $rating_mode == 'eprf-rating-mode-five-stars' ? ( $rating_value > 0 && $rating_value <= 5 ) : ( $rating_value == 1 || $rating_value == 5 );
		if ( ! $valid_value ) {
			wp_die( json_encode( array( 'status' => 'error', 'message' => $this->article_feedback_confirmation_msg( __('Could not vote', 'echo-article-rating-and-feedback') . ' (5)' ) ) ) );
		}
	
		// check user already rated this article
		$db_handler = new EPRF_Rating_DB();
		$did_vote = $db_handler->has_article_user_IP($kb_id, $article_id);
		if ( is_wp_error( $did_vote ) ) {
			wp_die( json_encode( array( 'status' => 'error', 'message' => $this->article_feedback_confirmation_msg( __('Could not vote', 'echo-article-rating-and-feedback') . ' (6)') ) ) );
		}

		// did user already vote for this article?
		if ( $did_vote ) {
			wp_die( json_encode( array( 'status' => 'success', 'message' => $this->article_feedback_confirmation_msg( $kb_config['rating_confirmation_negative'] ) ) ) );
		}
		
		$user = EPRF_Utilities::get_current_user();		
		$user_id = $user ? $user->ID : 0;
		
		$saved = $db_handler->insert_rating_record( $kb_id, $article_id, $user_id, date('Y-m-d H:i:s'), $rating_value, $rating_mode, EPRF_Core_Utilities::get_ip_address() );
		if ( is_wp_error( $saved ) ) {
			wp_die( json_encode( array( 'status' => 'error', 'message' => $this->article_feedback_confirmation_msg( __('Could not record the vote', 'echo-article-rating-and-feedback') . ' (7)' ) ) ) );
		}

		// save average like meta field to have the field for query sorting
		$new_rating_data = $db_handler->get_article_ratings( $kb_id, $article_id );
		if ( is_wp_error( $new_rating_data ) ) {
			wp_die( json_encode( array( 'status' => 'error', 'message' => $this->article_feedback_confirmation_msg( __('Could not vote', 'echo-article-rating-and-feedback') . ' (8)' ) ) ) );
		}

		$new_rating = EPRF_Core_Utilities::calculate_article_rating_statistics($new_rating_data);
		
		$result = EPRF_Utilities::save_postmeta( $article_id, 'eprf-article-rating-average', $new_rating['average'], true );
		//$result_like = EPRF_Utilities::save_postmeta( $article_id, 'eprf-article-rating-like',  $new_rating['statistic']['like'], true );
		//$result_dislike = EPRF_Utilities::save_postmeta( $article_id, 'eprf-article-rating-dislike',  $new_rating['statistic']['dislike'], true );
		if ( is_wp_error($result) ) {
			wp_die( json_encode( array( 'status' => 'error', 'message' => $this->article_feedback_confirmation_msg( __('Could not vote', 'echo-article-rating-and-feedback') . ' (9)' ) ) ) );
		}
		
		wp_die( json_encode( array( 'status' => 'success', 'message' => $this->article_feedback_confirmation_msg( $kb_config['rating_confirmation_positive'] ), 'rating' => $new_rating ) ) );
	}
	
	/**
	 * Record comment given by user
	 */
	public function process_add_comment() {

		// verify that the request is authentic
		if ( empty( $_REQUEST['_wpnonce_user_comment_action_ajax'] ) || ! wp_verify_nonce( $_REQUEST['_wpnonce_user_comment_action_ajax'], '_wpnonce_user_comment_action_ajax' ) ) {
			EPRF_Utilities::ajax_show_error_die(__( 'Refresh your page', 'echo-article-rating-and-feedback' ));
		}

		$article_id = EPRF_Utilities::get( 'article_id' );
		if ( empty($article_id) ) {
			wp_die( json_encode( array( 'status' => 'error', 'message' => $this->article_feedback_confirmation_msg(  __('Could not vote', 'echo-article-rating-and-feedback') . ' (10)' ) ) ) );
		}

		$post = EPRF_Core_Utilities::get_kb_post_secure( $article_id );
		if ( empty($post) ) {
			wp_die( json_encode( array( 'status' => 'error', 'message' => $this->article_feedback_confirmation_msg( __('Could not vote', 'echo-article-rating-and-feedback') . ' (11)' ) ) ) );
		}

		$kb_id = EPRF_KB_Handler::get_kb_id_from_post_type( $post->post_type );
		if ( empty($kb_id) ) {
			wp_die( json_encode( array( 'status' => 'error', 'message' => $this->article_feedback_confirmation_msg(  __('Could not vote', 'echo-article-rating-and-feedback') . ' (12)' ) ) ) );
		}

		$kb_config = eprf_get_instance()->kb_config_obj->get_kb_config( $kb_id, true );
		if ( is_wp_error($kb_config) ) {
			wp_die( json_encode( array( 'status' => 'error', 'message' => $this->article_feedback_confirmation_msg(  __('Could not vote', 'echo-article-rating-and-feedback') . ' (13)' ) ) ) );
		}

		// no needs to filter data, wp_new_comment will do it
		$commentdata = array(
			'comment_post_ID'      => $article_id,
			'comment_approved'     => 0,
			'comment_author'       => EPRF_Utilities::get( 'name' ),
			'comment_author_email' => EPRF_Utilities::get( 'email' ),
			'comment_content'      => EPRF_Utilities::get( 'comment' ),
			'comment_type'         => 'eprf-article',
			'comment_author_url'   => ''
		);

		if ($user = EPRF_Utilities::get_current_user()) {
			$commentdata['user_ID'] = $user->ID;
		}

		// to enable multiple feedbacks per user: add_filter('duplicate_comment_id', '__return_false');
		$result = wp_new_comment( $commentdata, true );
		if ( is_wp_error($result) ) {
			wp_die( json_encode( array( 'status' => 'error', 'message' => $this->article_feedback_confirmation_msg( __('You have already submitted feedback.', 'echo-article-rating-and-feedback') ) ) ) );
		} else {
			wp_die( json_encode( array( 'status' => 'success', 'message' => $this->article_feedback_confirmation_msg( $kb_config['rating_confirmation_positive'] ) ) ) );
		}
	}

	public function article_feedback_confirmation_msg( $msg ){
		return '<div class="eprf-article-buttons__feedback-confirmation__msg">'.$msg.'</div>';
	}
}