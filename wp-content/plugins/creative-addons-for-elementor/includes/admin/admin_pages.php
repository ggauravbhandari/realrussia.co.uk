<?php
namespace Creative_Addons\Includes\Admin;

use Elementor\Utils;
use Creative_Addons\Includes\Utilities;
use Creative_Addons\Includes\Utilities_Plugin;
use Creative_Addons\Includes\Widgets_Manager;
use Creative_Addons\Widgets;
use Creative_Addons\Includes\HTML_Elements;
use Creative_Addons\Includes\System\Logging;
use Creative_Addons\Includes\Kb\KB_Utilities;

defined( 'ABSPATH' ) || exit();

/**
 * Display admin pages
 *
 */
class Admin_Pages {
	
	public function show_dashboard() {

		$active_tab = Utilities::get('tab', 'home'); 	?>

		<div class="crel-dashboard">

			<div class="crel-dashboard__tabs">

				<!-- Tabs -->
				<div class="crel-dashboard__tabs__nav">
					<a href="#crel-nav-home-content" id="crel-nav-home" class="crel-dashboard-tabs__nav__item <?php echo ( $active_tab == 'home' ) ? 'crel-dashboard-tabs__nav__item--active' : '' ?>"><?php _e( 'Home', 'creative-addons-for-elementor' ); ?></a>
					<a href="#crel-nav-widgets-content" id="crel-nav-widgets" class="crel-dashboard-tabs__nav__item <?php echo ( $active_tab == 'widgets' ) ? 'crel-dashboard-tabs__nav__item--active' : '' ?>"><?php _e( 'Widgets', 'creative-addons-for-elementor' ); ?></a>
					<a href="#crel-nav-presets-content" id="crel-nav-presets" class="crel-dashboard-tabs__nav__item <?php echo ( $active_tab == 'presets' ) ? 'crel-dashboard-tabs__nav__item--active' : '' ?>"><?php _e( 'Preset Library', 'creative-addons-for-elementor' ); ?></a>
					<a href="#crel-nav-debug-content" id="crel-nav-debug" class="crel-dashboard-tabs__nav__item <?php echo ( $active_tab == 'debug' ) ? 'crel-dashboard-tabs__nav__item--active' : '' ?>"><?php _e( 'Debug', 'creative-addons-for-elementor' ); ?></a>		<?php
					if ( Utilities_Plugin::use_old_widgets_without_globals() ) { ?>
						<a href="#crel-nav-settings-content" id="crel-nav-settings" class="crel-dashboard-tabs__nav__item <?php echo ( $active_tab == 'settings' ) ? 'crel-dashboard-tabs__nav__item--active' : '' ?>"><?php _e( 'Settings', 'creative-addons-for-elementor' ); ?></a>				<?php
					} ?>
				</div>

				<!-- Tabs Content -->
				<div class="crel-dashboard__tabs__content">

					<!-- Home Panel -->
					<div id="crel-nav-home-content" class="crel-dashboard-tabs__content__panel <?php echo ( $active_tab == 'home' ) ? 'crel-dashboard-tabs__content__panel--active' : '' ?>">
						<div class="crel-dashboard-row">
							<div class="crel-dashboard-tabs__content__left">
								<div class="crel-dashboard-tabs__content__panel__header">
									<img src="<?php echo CREATIVE_ADDONS_ASSETS_URL.'images/Top-banner-for-Settings-page.jpg'; ?>">
								</div>

								<div class="crel-dashboard-tabs__content__panel__body">

									<div class="crel-dashboard-row crel-dashboard-2col">									<?php
										 $this->info_box(
											'crelfa crelfa-book',
											__( 'Documentation', 'creative-addons-for-elementor' ),
											__( 'Find basic and advanced examples for our Creative widgets.', 'creative-addons-for-elementor' ),
											__( 'Documentation', 'creative-addons-for-elementor' ),
											'https://www.creative-addons.com/elementor-docs/');
										 $this->info_box(
											'crelfa crelfa-puzzle-piece',
											__( 'Submit Feature Request', 'creative-addons-for-elementor' ),
											__( 'Let us know your thoughts about our widgets and any features we can add!', 'creative-addons-for-elementor' ),
											__( 'Contact Us', 'creative-addons-for-elementor' ),
											'https://www.creative-addons.com/technical-support/'); ?>
									</div>

									<div class="crel-dashboard-row">									<?php
										 /* $this->info_box(
											'far crelfa-heart',
											'Show your Love',
											'We love to have you in Creative Addons family. We are making it more awesome everyday. Take your 2 minutes to review the plugin and spread the love to encourage us to keep it going.',
											'Leave a Review',
											'#'); */ ?>
									</div>

								</div>
							</div>
							<div class="crel-dashboard-tabs__content__right">	<?php
								if ( ! KB_Utilities::is_kb_plugin_active() ) {
									$this->display_ad();
								} ?>
							</div>
						</div>
					</div>

					<!-- Widgets Panel -->
					<div id="crel-nav-widgets-content" class="crel-dashboard-tabs__content__panel <?php echo ( $active_tab == 'widgets' ) ? 'crel-dashboard-tabs__content__panel--active' : '' ?>">

						<div class="crel-dashboard-tabs__content__panel__header">
							<div class="crel-dashboard-row crel-dashboard-2col">

								<div class="crel-dashboard__widget-info-container">
									<h2><?php _e( 'Creative Widgets', 'creative-addons-for-elementor' ); ?></h2>
									<p><?php _e( 'Here is a list of our widgets. You can enable or disable widgets to optimize your experience in the Elementor editor. All users will not see the disabled widgets when editing a page. After enabling or disabling widget(s), click the Save Changes button.', 'creative-addons-for-elementor' ); ?></p>
								</div>
								<div class="crel-dashboard__widget-save-container">
									<?php wp_nonce_field( 'crel_settings_nonce', 'crel_settings_nonce', false ); ?>
									<button type="submit" class="crel-dashboard__save-settings"><?php _e( 'Save Settings', 'creative-addons-for-elementor' ); ?></button>
									<div class="crel-dashboard__saving-error"></div>
								</div>

							</div>

						</div>

						<div class="crel-dashboard-tabs__content__panel__body">
							<div class="crel-dashboard-tabs__content__panel__body__widgets">									<?php

								$widgets = $this->get_widgets();
								foreach ( $widgets as $name => $widget ) { ?>
									<div class="crel-dashboard-widget-container">
										<div class="crel-dashboard-widget__icon"><i class="<?php echo $widget['icon']; ?>"></i></div>
										<div class="crel-dashboard-widget__info">
											<div class="crel-dashboard-widget__info__title"><?php echo $widget['title']; ?></div>
											<div class="crel-dashboard-widget__info__demo-link"><a href="<?php echo $widget['demo_url']; ?>" target="_blank" class="crelfa crelfa-laptop"></a></div>
											<div class="crel-dashboard-widget__info__info-link"><a href="<?php echo $widget['documentation_url']; ?>" target="_blank" class="crelfa crelfa-question-circle"></a></div>
										</div>

										<input id="<?php echo $widget['name']; ?>" type="checkbox" name="<?php echo $widget['name']; ?>" <?php checked( $widget['is_active'], true ); ?>>

										<label for="<?php echo $widget['name']; ?>"></label>
									</div>									<?php
								} ?>
							</div>
						</div>

					</div>

					<!-- Presets Panel -->
					<div id="crel-nav-presets-content" class="crel-dashboard-tabs__content__panel <?php echo ( $active_tab == 'presets' ) ? 'crel-dashboard-tabs__content__panel--active' : '' ?>">

						<div class="crel-dashboard-tabs__content__panel__header">
							<div class="crel-dashboard-row crel-dashboard-2col">

								<div class="crel-dashboard__widget-info-container">
									<h2><?php _e( 'Creative Presets', 'creative-addons-for-elementor' ); ?></h2>
									<p><?php _e( 'Here is a list of our presets. You can enable or disable presets to optimize your experience in the Elementor editor. No users will see the disabled presets when editing a page. After enabling or disabling preset(s), click the Save Changes button.', 'creative-addons-for-elementor' ); ?></p>
								</div>
								<div class="crel-dashboard__presets-save-container">
									<button type="submit" class="crel-dashboard__save-settings"><?php _e( 'Save Settings', 'creative-addons-for-elementor' ); ?></button>
									<div class="crel-dashboard__saving-error"></div>
								</div>

							</div>

						</div>

						<div class="crel-dashboard-tabs__content__panel__body">
							<div class="crel-dashboard-tabs__content__panel__body__presets">
								<div class="crel-dashboard-presets__header"><?php

									$has_widgets = false;
									$active_widget = Utilities::get('widget');

									foreach ( $widgets as $name => $widget ) {

										if ( ! $widget['is_active'] || ! $widget['presets'] ) {
											continue;
										}

										$has_widgets = true; ?>

										<div class="crel-dashboard-widget-container <?php echo ( $widget['name'] == $active_widget ) ? 'crel-dashboard-widget-container--active' : ''; ?>" data-name="<?php echo $widget['name']; ?>">
											<div class="crel-dashboard-widget__icon"><i class="<?php echo $widget['icon']; ?>"></i></div>
											<div class="crel-dashboard-widget__info">
												<div class="crel-dashboard-widget__info__title"><?php echo $widget['title']; ?></div>
											</div>
										</div> <?php
									} ?>

								</div>

								<div class="crel-dashboard-presets__content"><?php
									if ( ! $has_widgets ) { ?>
										<div class="crel-dashboard-presets__no-widgets">
											<i class="crelfa crelfa-exclamation-triangle"></i>
											<?php _e( 'All widgets are deactivated', 'creative-addons-for-elementor'); ?>
										</div><?php

									} else { ?>

										<div class="crel-dashboard-presets__widgets-preview__wrap"><?php
											 if ( empty($active_widget) ) {  ?>
												<div class="crel-dashboard-presets__widget-preview crel-dashboard-presets__widget-preview--not_selected crel-dashboard-presets__widget-preview--active">
													<i class="crelfa crelfa-exclamation-triangle"></i>
													<?php _e( 'Select widget first', 'creative-addons-for-elementor'); ?>
												</div><?php
											 }

											foreach ( $widgets as $name => $widget ) {
												if ( ! $widget['is_active'] ) {
													continue;
												}

												if ( class_exists( $widget['class_name'] ) ) {

													if ( 'Notification_Box' == $widget['name'] ) {
														// trigger notification box presets function ?>
														<div class="crel-dashboard-presets__widget-preview Notification_Box <?php echo ( $widget['name'] == $active_widget ) ? 'crel-dashboard-presets__widget-preview--active' : ''; ?>" ><?php
															$this->show_preset_box_v2( $widget ); ?>
														</div><?php
													} else {

														// skip if we have less than 2 presets as first we will skip
														if ( ! $widget['presets'] || count( $widget['presets'] ) < 2 ) {
															continue;
														}

														$this->show_preset_box( $widget );
													}
												}
											} ?>
										 
										</div><?php
									}	?>
								</div>
							</div>
						</div>

					</div>

					<!-- Debug Panel -->
					<div id="crel-nav-debug-content" class="crel-dashboard-tabs__content__panel <?php echo ( $active_tab == 'debug' ) ? 'crel-dashboard-tabs__content__panel--active' : '' ?>">

						<div class="crel-dashboard-tabs__content__panel__body">
							<div class="crel-dashboard-row">
								<div class="crel-dashboard__widget-info-container">
									<?php self::display_debug_info(); ?>
								</div>
							</div>

						</div>
					</div>

					<!-- Settings Panel -->
					<div id="crel-nav-settings-content" class="crel-dashboard-tabs__content__panel <?php echo ( $active_tab == 'settings' ) ? 'crel-dashboard-tabs__content__panel--active' : '' ?>">
						<div class="crel-dashboard-tabs__content__panel__header">
							<div class="crel-dashboard-row crel-dashboard-2col">

								<div class="crel-dashboard__widget-info-container">
									<h2><?php _e( 'Creative Settings', 'creative-addons-for-elementor' ); ?></h2>
									<p><?php _e( 'Here are settings for Creative Add-ons.', 'creative-addons-for-elementor' ); ?></p>
								</div>
								<div class="crel-dashboard__widget-save-container">
									<?php wp_nonce_field( 'crel_settings_nonce', 'crel_settings_nonce', false ); ?>
									<button type="submit" class="crel-dashboard__save-settings"><?php _e( 'Save Settings', 'creative-addons-for-elementor' ); ?></button>
									<div class="crel-dashboard__saving-error"></div>
								</div>

							</div>
						</div>
						<div class="crel-dashboard-tabs__content__panel__body__settings">
							<div class="crel-dashboard-row">
								<div class="crel-dashboard__widget-info-container">
									<div class="crel-dashboard-widget-container">
										<div class="crel-dashboard-widget__info">
											<div class="crel-dashboard-widget__info__title"><?php _e( 'UPGRADE: Allow Global Fonts and Colors', 'creative-addons-for-elementor' ); ?></div>
											<div class="crel-dashboard-widget__info__info-link"><a href="https://www.creative-addons.com/elementor-docs/allow-global-fonts-and-colors/" target="_blank" class="crelfa crelfa-question-circle"></a></div>
										</div>
										<input id="switch_to_globals" type="checkbox" name="switch_to_globals" <?php checked( ! Utilities_Plugin::use_old_widgets_without_globals(), true ); ?>>
										<label for="switch_to_globals"></label>
									</div>

								</div>
							</div>

							<div class="crel-dashboard-row crel-dashboard-2col">
								<div class="crel-dashboard__widget-info-container">
									<p>
										Elementor introduced the Global values on version 3.0.  For the safest transition for our customers who are upgrading we have created a toggle so that you can turn on these settings.

										It’s best that you back up your website before turning them on. We also recommend that you turn this option on as this is now the standard for Elementor.
									</p>
								</div>
							</div>

						</div>
					</div>

					
				</div>

				</div>

		</div>		<?php
	}

	public function get_help() { ?>
		<div class="crel-dashboard crel-dashboard--get-help">
			<div class="crel-dashboard-row crel-dashboard-2col">									<?php
				$this->info_box(
					'crelfa crelfa-life-ring',
					__( 'Need Help?', 'creative-addons-for-elementor' ),
					__( 'Stuck with something? Contact us and we will help you get going again! We provide friendly and timely support.', 'creative-addons-for-elementor' ),
					__( 'Contact Us', 'creative-addons-for-elementor' ),
					'https://www.creative-addons.com/technical-support/'
				); ?>
			</div>
		</div> <?php 
	}

	private function get_widgets() {
		$widgets = [];

		$inactive_widgets = Widgets_Manager::get_inactive_widgets();
		foreach ( Widgets_Manager::get_all_widgets_list() as $widget_name ) {

			$widget_class_name = 'Creative_Addons\Widgets\\' . $widget_name;
			if ( class_exists( $widget_class_name ) ) {

				/** @var Widgets\Creative_Widget_Base $widget */
				$widget = new $widget_class_name();
				
				$widgets[$widget_name] = [
					'title' => $widget->get_title(),
					'icon' => $widget->get_icon(),
					'demo_url' => $widget->get_demo_url(),
					'documentation_url' => $widget->get_documentation_url(),
					'name' => $widget_name,
					'is_active' => ! in_array( $widget_name, $inactive_widgets ),
					'class_name' => $widget_class_name,
					'presets' => $widget->get_presets_options()
				];
			}
		}
		return $widgets;
	}

	private function info_box( $icon, $title, $dec, $buttonText, $buttonURL ) { ?>

		<div class="crel-dashboard__info-box">

			<div class="crel-dashboard__info-box__header">
				<div class="crel-dashboard__info-box__header__icon <?php echo $icon; ?>"></div>
				<div class="crel-dashboard__info-box__header__title"><?php echo $title; ?></div>
			</div>

			<div class="crel-dashboard__info-box__body">
				<p><?php echo $dec; ?></p>
				<a href="<?php echo $buttonURL; ?>" target="_blank" class="crel-dashboard__info-box__body__btn"><?php echo $buttonText; ?></a>
			</div>

		</div>	<?php
	}

	/**
	 * Display Debug Data
	 */
	public function display_debug_info() {

		$is_debug_on = Utilities::get_wp_option( Admin_Handlers::CREL_DEBUG, false );
		$heading = $is_debug_on ? esc_html__( 'Debug Information:', 'creative-addons-for-elementor' ) :
			esc_html__( 'Enable debug when asked by Echo KB support team.', 'creative-addons-for-elementor' );     ?>

		<div class="form_options" id="crel_debug_info_tab_page">

			<section class="save-settings">    <?php
				$button_text = $is_debug_on ? __( 'Disable Debug', 'creative-addons-for-elementor' ) : __( 'Enable Debug', 'creative-addons-for-elementor' ); ?>
				<div class="submit crel_toggle_debug">
					<input type="hidden" id="_wpnonce_crel_toggle_debug" name="_wpnonce_crel_toggle_debug" value="<?php echo wp_create_nonce( "_wpnonce_crel_toggle_debug" ); ?>"/>
					<input type="hidden" name="action" value="crel_toggle_debug"/>
					<input type="submit" id="crel_toggle_debug" class="crel_toggle_debug crel-dashboard__btn" value="<?php echo $button_text; ?>" />
				</div>
			</section>

			<section>
				<h3><?php echo $heading; ?></h3>
			</section>     <?php
			if ( $is_debug_on ) {
				echo self::display_debug_data();        ?>

				<form action="<?php echo esc_url( admin_url( 'admin.php?page=creative-addons' ) ); ?>" method="post" dir="ltr">

					<section class="save-settings checkbox-input">
						<div class="crel_download_debug_info">
							<input type="hidden" id="_wpnonce_crel_download_debug_info" name="_wpnonce_crel_download_debug_info" value="<?php echo wp_create_nonce( "_wpnonce_crel_download_debug_info" ); ?>">
							<input type="hidden" name="action" value="crel_download_debug_info">
							<input type="submit" id="crel_download_debug_info" class="crel-dashboard__btn" value="<?php echo __( 'Download System Information', 'creative-addons-for-elementor' ); ?>">
						</div>
					</section>
				</form>     <?php
			}    ?>

		</div>      		<?php
	}

	public static function display_debug_data() {

		// ensure user has correct permissions
		if ( ! current_user_can( 'manage_options' ) ) {
			return __( 'No access', 'creative-addons-for-elementor' );
		}

		$output = '<textarea rows="30" cols="150" style="overflow:scroll;">';

		// display PHP and WP settings
		$output .= self::get_system_info();

		// display error logs
		$output .= "\n\nERROR LOG:\n";
		$output .= "==========\n";
		$logs = Logging::get_logs();
		foreach( $logs as $log ) {
			$output .= empty($log['plugin']) ? '' : $log['plugin'] . " ";
			$output .= empty($log['kb']) ? '' : $log['kb'] . " ";
			$output .= empty($log['date']) ? '' : $log['date'] . "\n";
			$output .= empty($log['message']) ? '' : $log['message'] . "\n";
			$output .= empty($log['trace']) ? '' : $log['trace'] . "\n\n";
		}

		// retrieve add-on data
		$add_on_output = apply_filters( 'crel_add_on_debug_data', '' );
		$output .= is_string($add_on_output) ? $add_on_output : '';

		$output .= '</textarea>';

		return $output;
	}

	/**
	 * Based on EDD system-info.php file
	 * @return string
	 */
	private static function get_system_info() {
		/** @var $wpdb Wpdb */
		global $wpdb;

		$host = defined( 'WPE_APIKEY' ) ? "Host: WP Engine" : '<unknown>';
		/** @var $theme_data WP_Theme */
		$theme_data = wp_get_theme();
		/** @noinspection PhpUndefinedFieldInspection */
		$theme = $theme_data->Name . ' ' . $theme_data->Version;

		ob_start();     ?>

		PHP and WordPress Information:
		==============================

		Multisite:                <?php echo is_multisite() ? 'Yes' . "\n" : 'No' . "\n" ?>

		SITE_URL:                 <?php echo site_url() . "\n"; ?>
		HOME_URL:                 <?php echo home_url() . "\n"; ?>

		WordPress Version:        <?php echo get_bloginfo( 'version' ) . "\n"; ?>
		Permalink Structure:      <?php echo get_option( 'permalink_structure' ) . "\n"; ?>
		Active Theme:             <?php echo $theme . "\n"; ?>
		Host:                     <?php echo $host . "\n"; ?>

		PHP Version:              <?php echo PHP_VERSION . "\n"; ?>

		PHP Post Max Size:        <?php echo ini_get( 'post_max_size' ) . "\n"; ?>
		PHP Time Limit:           <?php echo ini_get( 'max_execution_time' ) . "\n"; ?>
		PHP Max Input Vars:       <?php echo ini_get( 'max_input_vars' ) . "\n"; ?>
		WP_DEBUG:                 <?php echo defined( 'WP_DEBUG' ) ? WP_DEBUG ? 'Enabled' . "\n" : 'Disabled' . "\n" : 'Not set' . "\n" ?>

		WP Table Prefix:          <?php echo "Length: ". strlen( $wpdb->prefix ); ?>

		DISPLAY ERRORS:           <?php echo ( ini_get( 'display_errors' ) ) ? 'On (' . ini_get( 'display_errors' ) . ')' : 'N/A'; ?><?php echo "\n"; ?>
		FSOCKOPEN:                <?php echo ( function_exists( 'fsockopen' ) ) ? 'Your server supports fsockopen.' : 'Your server does not support fsockopen.'; ?><?php echo "\n"; ?>
		cURL:                     <?php echo ( function_exists( 'curl_init' ) ) ? 'Your server supports cURL:' : 'Your server does not support cURL.'; ?><?php echo "\n";

		if ( function_exists( 'curl_init' ) ) {
			$curl_values = curl_version();
			echo "\n\t\t\t\tVersion: " . $curl_values["version"];
			echo "\n\t\t\t\tSSL Version: " . $curl_values["ssl_version"];
			echo "\n\t\t\t\tLib Version: " . $curl_values["libz_version"] . "\n";
		}		?>

		SOAP Client:              <?php echo ( class_exists( 'SoapClient' ) ) ? 'Your server has the SOAP Client enabled.' : 'Your server does not have the SOAP Client enabled.'; ?><?php echo "\n";

		$plugins = get_plugins();
		$active_plugins = get_option( 'active_plugins', array() );

		echo "\n\n";
		echo "KB PLUGINS:	         \n\n";

		foreach ( $plugins as $plugin_path => $plugin ) {
			// If the plugin isn't active, don't show it.
			if ( ! in_array( $plugin_path, $active_plugins ) )
				continue;

			if ( in_array($plugin['Name'], array('KB - Article Rating and Feedback','KB - Links Editor','KB - Import Export','KB - Multiple Knowledge Bases','KB - Widgets',
				'Knowledge Base for Documents and FAQs', 'KB - Elegant Layouts'))) {
				echo "		" . $plugin['Name'] . ': ' . $plugin['Version'] ."\n";
			}
		}

		echo "\n\n";
		echo "OTHER PLUGINS:	         \n\n";

		foreach ( $plugins as $plugin_path => $plugin ) {
			// If the plugin isn't active, don't show it.
			if ( ! in_array( $plugin_path, $active_plugins ) )
				continue;

			if ( ! in_array($plugin['Name'], array('KB - Article Rating and Feedback','KB - Links Editor','KB - Import Export','KB - Multiple Knowledge Bases','KB - Widgets',
				'Knowledge Base for Documents and FAQs'))) {
				echo "		" . $plugin['Name'] . ': ' . $plugin['Version'] ."\n";
			}
		}

		if ( is_multisite() ) {		?>
			NETWORK ACTIVE PLUGINS:		<?php  echo "\n";

			$plugins = wp_get_active_network_plugins();
			$active_plugins = get_site_option( 'active_sitewide_plugins', array() );

			foreach ( $plugins as $plugin_path ) {
				$plugin_base = plugin_basename( $plugin_path );

				// If the plugin isn't active, don't show it.
				if ( ! array_key_exists( $plugin_base, $active_plugins ) ) {
					continue;
				}

				$plugin = get_plugin_data( $plugin_path );

				echo "		" . $plugin['Name'] . ': ' . $plugin['Version'] ."\n";
			}
		}

		return ob_get_clean();
	}
	
	/*	public static function get_widget_html( $widget_class_name, $options ) {
		$widget_instance = \Elementor\Plugin::instance()->elements_manager->create_element_instance(
			[
				'elType' => 'widget',
				'widgetType' => 'crel-notification-box',
				'id' => 'stubID',
				'settings' => [
					'crel_notificationBox__title_text' => 'Notification Box Title',
				],
			],
			[]
		);
		$widget_instance->render_content();
	}	*/
	
	protected function show_preset_box( $widget ) { 
	
		$first_preset = true;
		$active_widget = Utilities::get('widget') ? Utilities::get('widget') : '';
		$inactive_presets = Utilities_Plugin::get_users_inactive_presets(); ?>
		<div class="crel-dashboard-presets__widget-preview <?php echo $widget['name']; ?> <?php echo ( $widget['name'] == $active_widget ) ? 'crel-dashboard-presets__widget-preview--active' : ''; ?>"><?php
			
			foreach ( $widget['presets'] as $preset_name => $preset) {
				
				$preview_url = empty( $preset['preview_url'] ) ? Utils::get_placeholder_image_src() : $preset['preview_url']; 
				$disabled = ! empty( $inactive_presets ) && ! empty( $inactive_presets[$widget['name']] ) && in_array( $preset_name, $inactive_presets[$widget['name']] ); ?>
				
				<div class="crel-dashboard-presets__preset-preview">
					<h4><?php echo $preset['title']; ?></h4>
					<img src="<?php echo $preview_url; ?>"><?php 
					if ( $first_preset ) {
						$first_preset = false; 		?>
						<div class="crel-dashboard-presets__preset-preview__note"><?php _e( 'Default style cannot be disabled ', 'creative-addons-for-elementor' ); ?></div><?php
					} else { ?>
						<input id="<?php echo $widget['name']; ?>-<?php echo $preset_name; ?>" type="checkbox" name="<?php echo $widget['name']; ?>-<?php echo $preset_name; ?>" <?php checked( $disabled, false ); ?>  data-widget="<?php echo $widget['name']; ?>" data-preset="<?php echo $preset_name; ?>">
						<label for="<?php echo $widget['name']; ?>-<?php echo $preset_name; ?>"></label><?php
					} ?>
				</div><?php 
			} ?>
		</div><?php 
		
	}
	
	protected function show_preset_box_v2( $widget ) {
		
		$user_settings = Utilities_Plugin::get_users_inactive_presets();
		
		// level 1 e.g. Type
		foreach ( $widget['presets'] as $label_2 => $options_2 ) {
			if ( ! is_array( $options_2['options'] ) || empty($options_2['options']) ) {
			 continue;
		   } ?>

			<div class="crel-dashboard-presets__preset-previews"> <?php

			// level 2 e.g. Color
			foreach ( $options_2['options'] as $label_3 => $options_3 ) {
				if ( $label_3 == 'color' || ! is_array( $options_2['options'] ) || empty($options_2['options']) ) {
					continue;
				}

				// level 3 e.g. Style
				$first_preset = true;
				foreach ( $options_3['options'] as $preset_name => $preset ) {

					if ( !$preset_name ) {
						continue;
					}

					// exactly presets
					$preview_url = empty( $preset['preview_url'] ) ? Utils::get_placeholder_image_src() : $preset['preview_url'];
					$disabled = ! empty( $user_settings ) && ! empty( $user_settings[$widget['name']] ) && in_array( $preset_name, $user_settings[$widget['name']] ); ?>

					<div class="crel-dashboard-presets__preset-preview notification-<?php echo $label_3; ?> " >
						<h4><?php echo $preset['title']; ?></h4>
						<img src="<?php echo $preview_url; ?>"><?php
					if ( $first_preset ) {
					   $first_preset = false; 		?>
							<div class="crel-dashboard-presets__preset-preview__note"><?php _e( 'Default style can not be disabled ', 'creative-addons-for-elementor' ); ?></div><?php
					} else { ?>
					   <input id="<?php echo $widget['name']; ?>-<?php echo $preset_name; ?>" type="checkbox" name="<?php echo $widget['name']; ?>-<?php echo $preset_name; ?>" <?php checked( $disabled, false ); ?>  data-widget="<?php echo $widget['name']; ?>" data-preset="<?php echo $preset_name; ?>">
					<label for="<?php echo $widget['name']; ?>-<?php echo $preset_name; ?>"></label><?php
						} ?>
					</div><?php
				}

			} ?>
			</div><?php
				
			// we need only 1 iteration
			break;
		}
	}

	/**
	 * Ad Box
	 */
	public function display_ad() {

		$HTML = New HTML_Elements();

		$HTML->advertisement_ad_box( array(
			'icon'              => 'crelfa-linode',
			'title'             => __( 'Knowledge Base Plugin', 'creative-addons-for-elementor' ),
			'img_url'           => 'https://www.echoknowledgebase.com/wp-content/uploads/2020/12/KB-Preview-ad.jpg',
			'desc'              =>  __( 'Import articles and categories into your knowledge base.', 'creative-addons-for-elementor' ),
			'list'              => array(
					__( 'Build powerful Documentation', 'creative-addons-for-elementor' ),
					__( 'Search Analytics', 'creative-addons-for-elementor' ),
					__( 'Content Restrictions', 'creative-addons-for-elementor' ),
					__( 'Multiple Knowledge Bases', 'creative-addons-for-elementor' ),
					__( 'User Ratings and FeedBack', 'creative-addons-for-elementor' ),
			),
			'btn_text'          => __( 'Learn More', 'creative-addons-for-elementor' ),
			'btn_url'           => 'https://www.echoknowledgebase.com/documentation/',
			'btn_color'         => 'green',

			'box_type'			   => 'new-feature',
		));
	}
	
}
