<?php
namespace Creative_Addons\Includes\System;

use Creative_Addons\Includes\Utilities;

defined( 'ABSPATH' ) || exit();

/**
 * If user is deactivating plugin, find out why
 */
class Deactivate_Feedback {

	public function __construct() {
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_feedback_dialog_scripts' ] );
		add_action( 'wp_ajax_crel_deactivate_feedback', [ $this, 'ajax_crel_deactivate_feedback' ] );
	}

	/**
	 * Enqueue feedback dialog scripts.
	 */
	public function enqueue_feedback_dialog_scripts() {
		add_action( 'admin_footer', [ $this, 'output_deactivate_feedback_dialog' ] );

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		wp_register_script( 'crel-dialog', CREATIVE_ADDONS_DIR_URL . 'assets/js/vendor/dialog' . $suffix . '.js', array('jquery'), CREATIVE_ADDONS_VERSION );
		wp_register_script( 'crel-admin-feedback', CREATIVE_ADDONS_DIR_URL . 'assets/js/admin-feedback' . $suffix . '.js', array('jquery'), CREATIVE_ADDONS_VERSION );
		wp_register_style( 'crel-admin-feedback-style', CREATIVE_ADDONS_DIR_URL . 'assets/css/admin/admin-plugin-feedback' . $suffix . '.css', array(), CREATIVE_ADDONS_VERSION );

		wp_enqueue_script( 'crel-dialog' );
		wp_enqueue_script( 'crel-admin-feedback' );
		wp_enqueue_style( 'crel-admin-feedback-style' );
	}

	/**
	 * Display a dialog box to ask the user why they deactivated the KB.
	 */
	public function output_deactivate_feedback_dialog() {

		$first_version = get_option('crel_version_first');
		$current_version = get_option('crel_version');
		if ( version_compare( $first_version, $current_version, '==' ) ) {
			$deactivate_reasons = $this->get_deactivate_reasons( 1 );
		} else {
			$deactivate_reasons = $this->get_deactivate_reasons( 2 );
		} 	?>

		<div id="crel-deactivate-feedback-dialog-wrapper">
			<div id="crel-deactivate-feedback-dialog-header">
				<span id="crel-deactivate-feedback-dialog-header-title"><?php echo __( 'Quick Feedback', 'creative-addons-for-elementor' ); ?></span>
			</div>
			<form id="crel-deactivate-feedback-dialog-form" method="post">				<?php
				wp_nonce_field( '_crel_deactivate_feedback_nonce' );				?>
				<input type="hidden" name="action" value="crel_deactivate_feedback" />

				<div id="crel-deactivate-feedback-dialog-form-caption"><?php echo __( 'If you have a moment, please share why you are deactivating Creative Add-ons:', 'creative-addons-for-elementor' ); ?></div>
				<div id="crel-deactivate-feedback-dialog-form-body">
					<div id="crel-deactivate-feedback-dialog-form-error" style="display:none;"><?php echo __( 'Please Select an Option', 'creative-addons-for-elementor' ); ?></div>					<?php

						foreach ( $deactivate_reasons as $reason_key => $reason ) :		?>
							<div class="crel-deactivate-feedback-dialog-input-wrapper">
								<input id="crel-deactivate-feedback-<?php echo esc_attr( $reason_key ); ?>" class="crel-deactivate-feedback-dialog-input" type="radio" name="reason_key" value="<?php echo esc_attr( $reason_key ); ?>" />
								<label for="crel-deactivate-feedback-<?php echo esc_attr( $reason_key ); ?>" class="crel-deactivate-feedback-dialog-label"><?php echo esc_html( $reason['title'] ); ?></label>
								<?php if ( ! empty( $reason['alert'] ) ) : ?>
									<div class="crel-feedback-text"><?php echo $reason['alert']; ?></div>
								<?php endif; ?>
								<?php if ( ! empty( $reason['input_placeholder'] ) ) : ?>
											 <input class="crel-feedback-text" type="text" name="reason_<?php echo esc_attr( $reason_key ); ?>" placeholder="<?php echo esc_attr( $reason['input_placeholder'] ); ?>" />
								<?php endif; ?>
								<?php if ( ! empty( $reason['contact_me'] ) ) : ?>
									<div class="crel-feedback-checkbox">
										<input id="crel-deactivate-feedback-contact" class="crel-deactivate-feedback-dialog-input" type="checkbox" name="contact_me_<?php echo esc_attr( $reason_key ); ?>" value="yes" /><label for="crel-deactivate-feedback-contact" class="crel-deactivate-feedback-dialog-label"><?php echo __( 'Contact Me', 'creative-addons-for-elementor' ); ?></label>
									</div>
								<?php endif; ?>
								<?php if ( ! empty( $reason['button'] ) ) : ?>
									<div class="crel-feedback-button"><a class="crel-feedback-button__green" target="_blank" href="<?php echo $reason['button']['url']; ?>"><?php echo $reason['button']['title']; ?></a></div>
								<?php endif; ?>
							</div>					<?php
						endforeach; ?>
				</div>
			</form>
		</div>		<?php
	}

	/**
	 * Send the user feedback when KB is deactivated.
	 */
	public function ajax_crel_deactivate_feedback() {
		global $wp_version;

		if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], '_crel_deactivate_feedback_nonce' ) ) {
			wp_send_json_error();
		}

		$reason_type = Utilities::post( 'reason_key', 'N/A' );
		$reason_input = Utilities::post( "reason_{$reason_type}", 'N/A' );
		$first_version = get_option('crel_version_first');
		$contact_user = isset($_POST["contact_me_{$reason_type}"]) ? 'Yes' : "No";

		$contact_email = '';
		$first_name = '';
		if ( $contact_user == 'Yes' ) {
			$user = Utilities::get_current_user();
			$contact_email = empty($user) ? '' : $user->user_email;
			$first_name = $user->first_name;
		}

		//Theme Name and Version
		$active_theme = wp_get_theme();
		$theme_info = $active_theme->get( 'Name' ) . ' ' . $active_theme->get( 'Version' );
		
		// send feedback
		$api_params = array(
			'crel_action'       => 'crel_process_user_feedback',
			'feedback_type'     => $reason_type,
			'feedback_input'    => $reason_input,
			'plugin_name'		=> 'CREL',
			'plugin_version'	=> CREATIVE_ADDONS_VERSION,
			'first_version'     => empty($first_version) ? 'N/A' : $first_version,
			'wp_version'        => $wp_version,
			'theme_info'        => $theme_info,
			'contact_user'      => $contact_email
		);

		// Call the API
		wp_remote_post(
			esc_url_raw( add_query_arg( $api_params, 'https://www.echoknowledgebase.com' ) ),
			array(
				'timeout'   => 15,
				'body'      => $api_params,
				'sslverify' => false
			)
		);

		if ( $contact_user == 'Yes' ) {
			$subject = __( 'Plugin Deactivation', 'creative-addons-for-elementor' );
			$message =  __( 'Name', 'creative-addons-for-elementor' ) . ': ' . $first_name . ' <br/>' .
				__( 'Email', 'creative-addons-for-elementor' ) . ': ' . $contact_email . ' <br/>' .
				__( 'Feedback Type', 'creative-addons-for-elementor' ) . ': ' . $reason_type . ' <br/>' .
				__( 'Feedback Input', 'creative-addons-for-elementor' ) . ': ' . $reason_input;

			// send the email
			$result = Utilities::send_email( $message, 'support@echoplugins.freshdesk.com', $contact_email, $first_name, $subject, __( 'Plugin Deactivation', 'creative-addons-for-elementor' ) );
			if ( empty( $result ) ) {
				wp_send_json_success();
			} else {
				wp_send_json_error( $result );
			}
		}

		wp_send_json_success();
	}

	private function get_deactivate_reasons( $type ) {

		switch ( $type ) {
		   case 1:
		   	$deactivate_reasons = [
				  'missing_feature' => [
					  'title' => __( 'I\'m missing a feature', 'creative-addons-for-elementor' ),
					  'input_placeholder' => __( 'Please tell us what is missing', 'creative-addons-for-elementor' ),
					  'contact_me' => true,
				  ],
				  'couldnt_get_the_plugin_to_work' => [
					  'title' => __( 'I couldn\'t get the plugin to work', 'creative-addons-for-elementor' ),
					  'input_placeholder' => __( 'Please share the reason', 'creative-addons-for-elementor' ),
					  //'alert' => sprintf( __( 'We can help you, usually within an hour! If this is our bug, we will give you our %s for free.', 'creative-addons-for-elementor' ), '<a href="' . $pro_link . '" target="_blank">PRO version</a>'),
					  'button' => [
						  'title' => __( 'Contact us for Help', 'creative-addons-for-elementor' ),
						  'url' => 'https://www.creative-addons.com/technical-support/'
			    ],
					  'contact_me' => true,
			    ],
				  'other' => [
					  'title' => __( 'Other', 'creative-addons-for-elementor' ),
					  'input_placeholder' => __( 'Please share the reason', 'creative-addons-for-elementor' ),
					  'button' => [
						  'title' => __( 'Contact us for Help', 'creative-addons-for-elementor' ),
						  'url' => 'https://www.creative-addons.com/technical-support/'
					  ]
				  ],
			   ];
			   break;
		    case 2:
			default:
				$deactivate_reasons = [
					'no_longer_needed' => [
						'title' => __( 'I no longer need the plugin', 'creative-addons-for-elementor' ),
						'input_placeholder' => '',
					],
					'missing_feature' => [
					   'title' => __( 'I\'m missing a feature', 'creative-addons-for-elementor' ),
					   'input_placeholder' => __( 'Please tell us what is missing', 'creative-addons-for-elementor' ),
						'contact_me' => true,
					],
				  'other' => [
					  'title' => __( 'Other', 'creative-addons-for-elementor' ),
					  'input_placeholder' => __( 'Please share the reason', 'creative-addons-for-elementor' ),
					  'button' => [
						  'title' => __( 'Contact us for Help', 'creative-addons-for-elementor' ),
						  'url' => 'https://www.creative-addons.com/technical-support/'
					  ]
				  ]
			   ];
			   break;
	   }

		return $deactivate_reasons;
	}
}
