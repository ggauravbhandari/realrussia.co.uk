<?php
namespace Creative_Addons\includes\admin;

use Creative_Addons\Includes\Utilities;


if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Display New Features page
 *
 * @copyright   Copyright (C) 2019, Echo Plugins
 * @license http://opensource.org/licenses/gpl-2.0.php GNU Public License
 */
class New_Features_Page {

	/**
	 * Filter crel features array to add latest
	 * @param $features
	 * @return array
	 */
	private static function crel_features_list( $features=array() ) {

		$features['2021.05.20'] = array(
			'plugin'            => __( 'Widget', 'creative-addons-for-elementor'),
			'title'             => __( 'Code Block', 'creative-addons-for-elementor'),
			'description'       => '<p>' . __( "Embed source code examples in your article. The user can copy and expand the code. Show code examples in CSS, HTML, JS, PHP, C# and more.", 'creative-addons-for-elementor') . '</p>',
			'image'             => 'https://www.creative-addons.com/wp-content/uploads/2021/06/Code-block-top-image-5.png',
			'learn_more_url'    => 'https://www.creative-addons.com/elementor-widgets/code-block/',
			'plugin-type'       => 'elementor',
			'type'              => 'widget',
			'label'              => 'New Widget'
		);

		$features['2021.02.12'] = array(
			'plugin'            => __( 'Widget', 'creative-addons-for-elementor'),
			'title'             => __( 'Image Guide', 'creative-addons-for-elementor'),
			'description'       => '<p>' . __( "Add hotspots to screenshots and images, and connect each hotspot to a note.", 'creative-addons-for-elementor') . '</p>',
			'video'             => 'https://www.youtube.com/embed/SZEP_zxBvy4',
			'learn_more_url'    => 'https://www.creative-addons.com/elementor-widgets/image-guide/',
			'plugin-type'       => 'elementor',
			'type'              => 'widget',
			'label'              => 'New Widget'

		);

		$features['2021.02.13'] = array(
			'plugin'            => __( 'Widget', 'creative-addons-for-elementor'),
			'title'             => __( 'Text and Image', 'creative-addons-for-elementor'),
			'description'       => '<p>' . __( 'Easy way to add text and image combo with one widget.', 'creative-addons-for-elementor') . '</p>',
			'video'             => 'https://www.youtube.com/embed/0Lpi-M2i32U',
			'learn_more_url'    => 'https://www.creative-addons.com/elementor-widgets/text-image/',
			'plugin-type'       => 'elementor',
			'type'              => 'widget',
			'label'              => 'New Widget'

		);

		return $features;
	}

	/**
	 * Count new features to be used in Crel New Features menu item title
	 * @param $count
	 * @return int
	 */
	private static function get_new_crel_features_count( $count=0 ) {

		// if user did't see last new features
		$last_seen_version = Utilities::get_wp_option( 'crel_last_seen_version', '' );
		$features_list = self::crel_features_list();
		foreach ( $features_list as $key => $val ) {
			if ( version_compare( $last_seen_version, $key ) < 0 ) {
				$count++;
			}
		}

		return $count;
	}

	/**
	 * Show number of new features in red on New Features menu item in admin.
	 */
	public static function get_menu_item_title() {

		$counter = '';
		$crel_new_features_count = self::get_new_crel_features_count();


		if ( ! empty($crel_new_features_count) && Utilities::is_positive_int($crel_new_features_count) ) {
			$counter = '<span class="update-plugins"><span class="plugin-count">' . $crel_new_features_count . '</span></span>';
		}

		return '<span style="color:#5cb85c;">' . __( 'New Features', 'creative-addons-for-elementor' ) . '<span class="dashicons dashicons-star-filled" style="font-size: 13px;line-height: 20px;"></span></span>' . $counter;
	}

	/**
	 * Display the New Features page
	 */
	public function display_new_features_page() {

		// update last seen version of KB and add-ons to current version

		ob_start(); ?>

		<!-- This is to catch WP JS garbage -->
		<div class="wrap">
			<h1></h1>
		</div>
		<div class="">		</div>
		<div id="crel-admin-page-wrap" class="crel-features-container">

			<!-- Top Banner -->
			<div class="crel-features__top-banner">
				<div class="crel-features__top-banner__inner">
					<h1><?php esc_html_e( 'New Features for Creative Addon', 'creative-addons-for-elementor' ); ?></h1>

				</div>

			</div>

			<!-- Tab Navigation -->
			<div class="crel-features__nav-container" >
				<ul id="new_features_tabs_nav">
					<li id="features" class="nav_tab active"><?php _e( 'New Features', 'creative-addons-for-elementor' ); ?></li>

				</ul>
			</div>

			<!-- Tab Panels -->
			<div class="crel-features__panel-container" id="new_features_tab_panel">
				<div id="crel-panel" class="crel-admin-page-tab-panel crel-features__panel crel-features__panel--active">
					<?php self::display_crel_features_details();  ?>
				</div>
			</div>

		</div>      <?php

	   self::update_last_seen_version();

		echo ob_get_clean();
	}

	/**
	 * Save which new features the user saw
	 */
	private static function update_last_seen_version() {

		$features_list = self::crel_features_list();
		krsort($features_list);
		$last_feature_date = key( $features_list );

		$result = Utilities::save_wp_option( 'crel_last_seen_version', $last_feature_date, true );
		if ( is_wp_error( $result ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Display all new features
	 */
	private static function display_crel_features_details() {
		$features = self::crel_features_list();  ?>
		<div class="crel-grid-row-5-col">			<?php
			foreach ( $features as $date => $feature ) {
				self::new_feature( $date, $feature );
			}        ?>
		</div>		<?php
	}

	/**
	 * Display feature information with image.
	 * @param $date
	 * @param array $values
	 */
	private static function new_feature( $date, $values = array () ) {
		global $wp_locale; 
		
		$season = explode('.', $date);
		if ( ! empty($season[0]) && ! empty($season[1]) ) {
			$monthName = ucfirst($wp_locale->get_month_abbrev($wp_locale->get_month($season[1])));
			$date = $monthName . ' ' . $season[0];
		}				?>

		<div class="crel-features__new-feature" class="add_on_product">

			<div class="crel-fnf__header">
				<span class="crel-fnf__header__new-feature"> <i class="crelfa crelfa-star" aria-hidden="true"></i><?php echo __( esc_html_e($values['label']), 'creative-addons-for-elementor' ); ?></span>
				<h3 class="crel-fnf__header__title"><?php esc_html_e($values['title']); ?></h3>

			</div>			<?php

			if ( isset($values['image']) ) {    ?>
				<div class="crel_img_zoom crel-fnf__img">
					<img src="<?php echo empty($values['image']) ? '' : $values['image']; ?>">
				</div>			<?php
			}
			if ( isset($values['video']) ) {    ?>
				<div class="crel-fnf__video">
					<iframe width="560" height="170" src="<?php echo $values['video']; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				</div>			<?php
			} ?>

			<div class="crel-fnf__meta">
				<div class="crel-fnf__meta__plugin"><?php esc_html_e($values['plugin']); ?></div>
				<div class="crel-fnf__meta__date"><?php echo $date ?></div>
			</div>

			<div class="crel-fnf__body">
				<p>
					<?php echo wp_kses_post($values['description']); ?>
				</p>
			</div>			<?php

			if ( ! empty($values['learn_more_url']) ) {
			   $button_name = empty($values['button_name']) ? __( 'Learn More', 'creative-addons-for-elementor' ) : $values['button_name'];    ?>
				<div class="crel-fnf__button-container">
					<a class="button primary-btn" href="<?php echo $values['learn_more_url']; ?>" target="_blank"><?php echo $button_name; ?></a>
				</div>			<?php
			}       ?>

		</div>    <?php
	}
}

