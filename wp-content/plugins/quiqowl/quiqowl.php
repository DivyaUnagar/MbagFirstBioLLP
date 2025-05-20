<?php
/**
 * Plugin Name:         QuiqOwl
 * Plugin URI:          https://untapwp.com/quiqowl
 * Description:         QuiqOwl integrates seamlessly with WooCommerce, offering customizable search options, smart filtering, and advanced indexing to streamline the shopping experience and boost conversions.
 * Version:             1.0.3
 * Author:              Untapwp
 * Author URI:          https://untapwp.com
 * License:             GPL-2.0+
 * License URI:         http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:         quiqowl
 * Domain Path:         /languages
 * WC requires at least: 7.6
 * WC tested up to: 9.3
 * Requires at least: 5.8
 * Requires PHP: 7.3
 * Requires Plugins: woocommerce
 *
 * @package QuiqOwl
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Plugin Constants.
define( 'QUIQOWL_VERSION', '1.0.3' );
define( 'QUIQOWL_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'QUIQOWL_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

require_once QUIQOWL_PLUGIN_DIR . 'autoload.php';

global $qo_db;

// Register Hooks.
register_activation_hook( __FILE__, array( \QuiqOwl\Quiqowl_Activation::get_instance(), 'activate' ) );
register_activation_hook( __FILE__, array( \QuiqOwl\Quiqowl_Deactivation::get_instance(), 'deactivate' ) );
register_activation_hook( __FILE__, array( \QuiqOwl\Quiqowl_Uninstall::get_instance(), 'uninstall' ) );

if ( ! function_exists( 'qui_fs' ) ) {
	/**
	 * Create a helper function for easy SDK access.
	 */
	function qui_fs() {
		global $qui_fs;

		if ( ! isset( $qui_fs ) ) {
			// Include Freemius SDK.
			require_once __DIR__ . '/freemius/start.php';

			$qui_fs = fs_dynamic_init(
				array(
					'id'                  => '16529',
					'slug'                => 'quiqowl',
					// 'premium_slug'        => 'quiqowl-premium',
					'type'                => 'plugin',
					'public_key'          => 'pk_65a6250dc1157bcade2c59c8aab5c',
					'is_premium'          => true,
					'premium_suffix'      => 'Pro',
					// If your plugin is a serviceware, set this option to false.
					'has_premium_version' => true,
					'has_addons'          => false,
					'has_paid_plans'      => true,
					'menu'                => array(
						'slug'    => '_quiqowl',
						'support' => false,
					),
				)
			);
		}

		return $qui_fs;
	}

	// Init Freemius.
	qui_fs();
	// Signal that SDK was initiated.
	do_action( 'qui_fs_loaded' );
}

/**
 * Retrieves the singleton instance of the Quiq Owl `Init` class.
 *
 * This function ensures that only one instance of the `Init` class is created
 * and returns that instance. It provides a centralized way to access the
 * initialization logic of the Quiq Owl plugin.
 *
 * @return \QuiqOwl\Init The singleton instance of the `Init` class.
 */
function quiqowl_init() {
	return \QuiqOwl\Quiqowl_Init::get_instance();
}

quiqowl_init();
