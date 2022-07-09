<?php
/**
 * Plugin Name: Creative Addons for Elementor
 * Plugin URI: https://www.creative-addons.com
 * Description: Creative Addons makes writing professional documents and articles easy.
 * Version: 1.3.1
 * Elementor tested up to: 3.5.5
 * Elementor Pro tested up to: 3.4.2
 * Author: Echo Plugins
 * Author URI: https://www.creative-addons.com/about-us/
 * Text Domain: creative-addons-for-elementor
 * Domain Path: languages
 * License: GNU General Public License v2.0
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Elementor KB is distributed under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 2 of the License, or
 * any later version.
 *
 * Elementor KB is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Elementor KB. If not, see <http://www.gnu.org/licenses/>.
 *
*/

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'CREATIVE_ADDONS_VERSION', '1.3.1' );
define( 'CREATIVE_ADDONS_PLUGIN_NAME', 'Creative Addons for Elementor' );
define( 'CREATIVE_ADDONS_MINIMUM_ELEMENTOR_VERSION', '2.5.0' );
define( 'CREATIVE_ADDONS_MINIMUM_PHP_VERSION', '5.6' );
define( 'CREATIVE_ADDONS__FILE__', __FILE__ );

define( 'CREATIVE_ADDONS_DIR_PATH', plugin_dir_path( CREATIVE_ADDONS__FILE__ ) );
define( 'CREATIVE_ADDONS_DIR_URL', plugin_dir_url( CREATIVE_ADDONS__FILE__ ) );
define( 'CREATIVE_ADDONS_URL', plugins_url( '/', CREATIVE_ADDONS__FILE__ ) );

define( 'CREATIVE_ADDONS_ASSETS', trailingslashit( CREATIVE_ADDONS_DIR_URL . 'assets' ) );
define( 'CREATIVE_ADDONS_ASSETS_PATH', CREATIVE_ADDONS_DIR_PATH . 'assets/' );
define( 'CREATIVE_ADDONS_ASSETS_URL', CREATIVE_ADDONS_URL . 'assets/' );

/**
 * Load the plugin after Elementor loads.
 */
function crel_load_plugin() {

	load_plugin_textdomain( 'creative-addons-for-elementor' );

	// Check that builder is installed and activated
	if ( ! did_action( 'elementor/loaded' ) ) {
		add_action( 'admin_notices', 'crel_admin_notice_builder_is_missing' );
		return;
	}

	// Check that Elementor version is not too old
	if ( ! version_compare( ELEMENTOR_VERSION, CREATIVE_ADDONS_MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
		add_action( 'admin_notices', 'crel_admin_notice_elementor_is_old' );
		return;
	}

	// Check for required PHP version
	if ( version_compare( PHP_VERSION, CREATIVE_ADDONS_MINIMUM_PHP_VERSION, '<' ) ) {
		add_action( 'admin_notices', 'crel_admin_notice_php_is_old' );
		return;
	}

	require CREATIVE_ADDONS_DIR_PATH . 'creative-addons-for-elementor-plugin.php';
}
add_action( 'plugins_loaded', 'crel_load_plugin' );

/**
 * Show Admin notice if the builder is missing
 */
function crel_admin_notice_builder_is_missing() {
	$notice = sprintf(
	/* translators: 1: Plugin name */
		__( '%1$s needs Elementor plugin to be installed and activated in order to work.', 'creative-addons-for-elementor' ),
		'<strong>' . __( 'Creative Addons for Elementor', 'creative-addons-for-elementor' ) . '</strong>'
	);

	printf( '<div class="notice crel-notice notice-warning is-dismissible"><p style="padding: 13px 0">%1$s</p></div>', $notice );  // TODO DAVE
	// OR 	echo '<div class="error"><p>' . $message . '</p></div>'; // TODO DAVE
}

/**
 * Show Admin notice if Elementor version is old
 */
function crel_admin_notice_elementor_is_old() {
	$notice = sprintf(
	/* translators: 1: Plugin name 2: Required Elementor version */
		esc_html__( '"%1$s" requires Elementor version to be %2$s or greater.', 'creative-addons-for-elementor' ),
		'<strong>' . esc_html__( 'Creative Addons for Elementor', 'creative-addons-for-elementor' ) . '</strong>',
		CREATIVE_ADDONS_MINIMUM_ELEMENTOR_VERSION
	);

	printf( '<div class="notice crel-notice notice-warning is-dismissible"><p style="padding: 13px 0">%1$s</p></div>', $notice );  // DAVE TODO
	// OR 	echo '<div class="error"><p>' . $message . '</p></div>';
}

/**
 * Show Admin notice if PHP version is old
 */
function crel_admin_notice_php_is_old() {
	$notice = sprintf(
	/* translators: 1: Plugin name 2: Minimum PHP version */
		esc_html__( '"%1$s" requires PHP version to be %2$s or greater.', 'creative-addons-for-elementor' ),
		'<strong>' . esc_html__( 'Creative Addons for Elementor', 'creative-addons-for-elementor' ) . '</strong>',
		CREATIVE_ADDONS_MINIMUM_PHP_VERSION
	);

	printf( '<div class="notice crel-notice notice-warning is-dismissible"><p style="padding: 13px 0">%1$s</p></div>', $notice );  // DAVE TODO
	// OR 	echo '<div class="error"><p>' . $message . '</p></div>';
}

require_once CREATIVE_ADDONS_DIR_PATH . 'includes/system/plugin-setup.php';
