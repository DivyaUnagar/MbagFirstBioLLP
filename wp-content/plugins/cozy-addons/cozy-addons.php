<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://cozythemes.com/
 * @since             1.0.0
 * @package           Cozy_Addons
 *
 * @wordpress-plugin
 * Plugin Name:       Cozy Blocks
 * Plugin URI:        https://cozythemes.com/cozy-addons
 * Description:       Streamline your website designs with our library of advanced blocks designed to extend the WordPress Site Editor.
 * Version:           2.1.25
 * Author:            CozyThemes
 * Author URI:        https://cozythemes.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       cozy-addons
 * Domain Path:       /languages/
 * Requires at least: 5.8
 * Requires PHP: 7.3
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! function_exists( 'cc_fs' ) ) {
	// Create a helper function for easy SDK access.
	function cc_fs() {
		global $cc_fs;
		if ( ! isset( $cc_fs ) ) {
			// Include Freemius SDK.
			require_once __DIR__ . '/freemius/start.php';

			$cc_fs = fs_dynamic_init(
				array(
					'id'                  => '12692',
					'slug'                => 'cozy-addons',
					'premium_slug'        => 'cozy-companions-premium',
					'type'                => 'plugin',
					'public_key'          => 'pk_fbca81b65cb25c89dcf0662ce4cc6',
					'is_premium'          => true,
					'premium_suffix'      => 'Pro',
					// If your plugin is a serviceware, set this option to false.
					'has_premium_version' => false,
					'has_addons'          => false,
					'has_affiliation'     => true,
					'has_paid_plans'      => true,
					'menu'                => array(
						'slug'    => '_cozy_companions',
						'support' => false,
					),
				)
			);
		}

		return $cc_fs;
	}

	// Init Freemius.
	cc_fs();
	// Signal that SDK was initiated.
	do_action( 'cc_fs_loaded' );
}
define( 'COZY_ADDONS_PLUGIN_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'COZY_ADDONS_PLUGIN_URL', plugins_url( '', __FILE__ ) );
if ( ! defined( 'CT_COMPANION_SDK_URL' ) ) {
	define( 'CT_COMPANION_SDK_URL', COZY_ADDONS_PLUGIN_URL . '/admin/ct-companions/' );
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-cozy-addons-activator.php
 */
function activate_cozy_addons() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-cozy-addons-activator.php';
	Cozy_Addons_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-cozy-addons-deactivator.php
 */
function deactivate_cozy_addons() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-cozy-addons-deactivator.php';
	Cozy_Addons_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_cozy_addons' );
register_deactivation_hook( __FILE__, 'deactivate_cozy_addons' );

define( 'COZY_ADDONS_VERSION', '2.1.25' );

if ( ! class_exists( 'Cozy_Addons' ) ) :
	final class Cozy_Addons {
		/**
		 * Minimum PHP Version
		 *
		 * @since 1.0.0
		 *
		 * @var string Minimum PHP version required to run the plugin.
		 */
		const MINIMUM_PHP_VERSION = '7.0';

		/**
		 * Instance
		 *
		 * @since 1.0.0
		 *
		 * @access private
		 * @static
		 *
		 * @var Cozy_Addons The single instance of the class.
		 */
		private static $_instance = null;

		/**
		 * Instance
		 *
		 * Ensures only one instance of the class is loaded or can be loaded.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 * @static
		 *
		 * @return Cozy_Addons An instance of the class.
		 */
		public static function instance() {

			if ( is_null( self::$_instance ) ) {
				self::$_instance = new self();
			}
			return self::$_instance;
		}

		/**
		 * Constructor
		 *
		 * @since 1.0.0
		 * @access public
		 */
		public function __construct() {
			// Load translation.
			add_action( 'init', array( $this, 'i18n' ) );

			// Init Plugin.
			$this->cozy_addons_load_files();
			add_action( 'plugins_loaded', array( $this, 'init' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'cozy_addons_dashboard_style' ) );
		}

		private function cozy_addons_load_files() {
			/**
			 * Register menu for cozy addons
			 */
			require_once COZY_ADDONS_PLUGIN_DIR . 'admin/admin-notice.php';
			require_once COZY_ADDONS_PLUGIN_DIR . 'admin/functions.php';
			require COZY_ADDONS_PLUGIN_DIR . 'admin/ct-companions/ct-companions.php';

			// Cozy Blocks CPT
			require_once COZY_ADDONS_PLUGIN_DIR . 'admin/cpt/cpt-init.php';
		}

		/**
		 * Load Textdomain
		 *
		 * Load plugin localization files.
		 *
		 * Fired by `init` action hook.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function i18n() {
			$lang_dir = dirname( plugin_basename( __FILE__ ) ) . '/languages/';

			load_plugin_textdomain( 'cozy-addons', false, $lang_dir );
		}

		/**
		 * Initialize the plugin
		 *
		 * Load the plugin only after Elementor (and other plugins) are loaded.
		 * Checks for basic plugin requirements, if one check fail don't continue,
		 * if all check have passed load the files required to run the plugin.
		 *
		 * Fired by `plugins_loaded` action hook.
		 *
		 * @since 1.0.0
		 *
		 * @access public
		 */
		public function init() {
			// Register cozy block.
			if ( cozy_addons_is_block_theme() && file_exists( COZY_ADDONS_PLUGIN_DIR . 'cozy-blocks/cozy-block.php' ) ) {
				require_once COZY_ADDONS_PLUGIN_DIR . 'cozy-blocks/cozy-block.php';
			}
		}

		public function cozy_addons_dashboard_style() {
			wp_enqueue_style( 'cozy-addons-admin-style', plugin_dir_url( __FILE__ ) . '/admin/css/cozy-addons-admin.css', array(), '', 'all' );
		}
	}

	// Instantiate Cozy Addons.
	Cozy_Addons::instance();

endif;

/**
 * Handles the rollback process for the "Cozy Addons" plugin.
 *
 * This function is triggered when the `action` query parameter is set to `cozy_addons_rollback`.
 * It verifies the request nonce, fetches the previous plugin version from the plugin versions list,
 * downloads the corresponding package, deactivates and deletes the current plugin version, and installs
 * and activates the previous version.
 *
 * @return void
 */
function cozy_addons_rollback_html_schema() {

	$is_cozy_addons_rollback = isset( $_GET['action'] ) && 'cozy_addons_rollback' === sanitize_text_field( wp_unslash( $_GET['action'] ) ) ? true : false;
	if ( ! $is_cozy_addons_rollback ) {
		return;
	}
	$wp_nonce = isset( $_GET['_wpnonce'] ) ? sanitize_text_field( wp_unslash( $_GET['_wpnonce'] ) ) : '';

	$rollback_version = isset( $_GET['version'] ) ? sanitize_text_field( wp_unslash( $_GET['version'] ) ) : '';

	if ( empty( $wp_nonce ) || ! wp_verify_nonce( $wp_nonce, 'cozy_addons_rollback_action' ) ) {
		wp_die( esc_html__( 'Not allowed!', 'cozy-addons' ) );
	}

	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'You do not have permission to perform this action.', 'cozy-addons' ) );
	}

	$versions = cozy_addons_get_plugin_versions();

	$previous_version = array();

	if ( ! empty( $rollback_version ) ) {
		$previous_version = array_filter(
			$versions,
			function ( $version_info ) use ( $rollback_version ) {
				return version_compare( $version_info['version'], $rollback_version, '=' );
			}
		);
	} else {
		$previous_version = array_filter(
			$versions,
			function ( $version_info ) {
				return version_compare( $version_info['version'], COZY_ADDONS_VERSION, '<' );
			}
		);
	}

	$previous_version = array_values( $previous_version );

	if ( empty( $previous_version ) ) {
		wp_die( esc_html__( 'Not allowed!', 'cozy-addons' ) );
	}

	$styles = "
		html {
			background: #f1f1f1;
		}
		body {
			background: #fff;
			border: 1px solid #ccd0d4;
			color: #444;
			font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen-Sans, Ubuntu, Cantarell, 'Helvetica Neue', sans-serif;
			margin: 2em auto;
			padding: 1em 2em;
			max-width: 700px;
			-webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, .04);
			box-shadow: 0 1px 1px rgba(0, 0, 0, .04);
		}
		h2 {
			border-bottom: 1px solid #dadada;
			clear: both;
			color: #666;
			font-size: 24px;
			margin: 30px 0 0 0;
			padding: 0;
			padding-bottom: 7px;
		}
		a {
			color: #2271b1;
		}
		a:hover,
		a:active {
			color: #135e96;
		}
		a:focus {
			color: #043959;
			box-shadow: 0 0 0 2px #2271b1;
			outline: 2px solid transparent;
		}
		.button {
			background: #f3f5f6;
			border: 1px solid #016087;
			color: #016087;
			display: inline-block;
			text-decoration: none;
			font-size: 13px;
			line-height: 2;
			height: 28px;
			margin: 0;
			padding: 0 10px 1px;
			cursor: pointer;
			-webkit-border-radius: 3px;
			-webkit-appearance: none;
			border-radius: 3px;
			white-space: nowrap;
			-webkit-box-sizing: border-box;
			-moz-box-sizing:    border-box;
			box-sizing:         border-box;

			vertical-align: top;
		}

		.button.disabled {
			margin-right: 16px;
			cursor: not-allowed;
			opacity: 0.5;
		}

		.button:hover,
		.button:focus {
			background: #f1f1f1;
		}

		.button:focus {
			background: #f3f5f6;
			border-color: #007cba;
			-webkit-box-shadow: 0 0 0 1px #007cba;
			box-shadow: 0 0 0 1px #007cba;
			color: #016087;
			outline: 2px solid transparent;
			outline-offset: 0;
		}

		.button:active {
			background: #f3f5f6;
			border-color: #7e8993;
			-webkit-box-shadow: none;
			box-shadow: none;
		}

		@keyframes spin {
			0% {
				transform: rotate(0deg);
			}
			100% {
				transform: rotate(360deg);
			}
		}

		#loader-icon {
			vertical-align: middle;
			width: 12px;
			height: 12px;
			animation: spin 2s linear infinite;
			margin-right: 3px;
			margin-top: -3px;
		}

		.display-none {
			display: none;
		}

		#rollback-log {
			margin-top: 16px;
			padding: 0 14px;
		}

		.footer {
			margin: 20px 0 12px 0;
		}

	";

	echo '<style type="text/css">';
	echo esc_html( $styles );
	echo '</style>';

	echo '<h2>' . sprintf(
		/* translators: %s: Cozy Blocks rollback version */
		esc_html__( 'Confirm rollback of Cozy Blocks to v%s!', 'cozy-addons' ),
		esc_html( $previous_version[0]['version'] )
	) . '</h2>';

	echo '<div id="rollback-log"></div>';

	echo '<div class="footer">';
	echo '<button id="cozy-rollback__confirm" class="button" style="margin-right:16px;">';
	echo '<svg id="loader-icon" class="display-none" width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
		<path d="M6.66667 1.33334C8.39333 1.33334 9.92933 2.15334 10.9047 3.42867L9.33333 5H13.3333V1L11.854 2.47934C11.2298 1.70449 10.4397 1.07951 9.54197 0.650429C8.64423 0.221346 7.66168 -0.000917878 6.66667 2.84892e-06C2.98467 2.84892e-06 0 2.98467 0 6.66667H1.33333C1.33333 5.25218 1.89524 3.89563 2.89543 2.89543C3.89562 1.89524 5.25218 1.33334 6.66667 1.33334ZM12 6.66667C12 7.782 11.6504 8.86927 11.0003 9.77553C10.3502 10.6818 9.4323 11.3614 8.37579 11.7189C7.31928 12.0763 6.1773 12.0935 5.11051 11.7681C4.04371 11.4426 3.10578 10.7909 2.42867 9.90467L4 8.33334H0V12.3333L1.47933 10.854C2.10356 11.6289 2.89363 12.2538 3.79137 12.6829C4.68911 13.112 5.67166 13.3343 6.66667 13.3333C10.3487 13.3333 13.3333 10.3487 13.3333 6.66667H12Z" fill="#135E96"/>
		</svg>
		';
	echo '<span>' . esc_html__( 'Confirm', 'cozy-addons' ) . '</span>';
	echo '</button>';

	echo '<a id="plugins-page-redirection" class="display-none" href="' . esc_url( admin_url( 'plugins.php' ) ) . '"> ' . esc_html__( 'Go to Plugins page', 'cozy-addons' ) . '</a>';
	echo '<div>';

	$ajax_url = esc_url( admin_url( 'admin-ajax.php' ) );

	$download_nonce = wp_create_nonce( 'cozy_addons_rollback_version_download' );
	$activate_nonce = wp_create_nonce( 'cozy_addons_rollback_version_activate' );

	$script = "
		jQuery(document).ready(function() {
			const rollbackLogs = jQuery(`#rollback-log`);
			const redirectionBtn = jQuery(`#plugins-page-redirection`);

			jQuery(`#cozy-rollback__confirm`).click(function() {
				const button = jQuery(this);
				button.addClass(`disabled`);

				const loaderIcon = jQuery(this).find(`#loader-icon`);
				loaderIcon.removeClass(`display-none`);

				rollbackLogs.append(`Downloading the plugin from {$previous_version[0]['url']}...\\n`);

				 // Simulate AJAX call to execute PHP rollback logic
				jQuery.ajax({
					url: `$ajax_url`, // WordPress AJAX handler
					type: `POST`,
					data: {
						action: `cozy_addons_download_plugin_rollback_version`,
						nonce: `{$download_nonce}`,
						downloadURL: `{$previous_version[0]['url']}`,
					},
					success: function(response) {
						if (response.success) {
							// Display step 2: Deactivate plugin
							rollbackLogs.append(`Unpacking and installing the plugin...\\n`);

							const tempFile = response.data.tempFile;
							
							// Simulate next step in PHP
							jQuery.ajax({
								url: `$ajax_url`,
								type: `POST`,
								data: {
									action: `cozy_addons_activate_rollback_version`,
									nonce: `{$activate_nonce}`,
									tempURL: tempFile,
								},
								success: function(response) {
									if (response.success) {
										rollbackLogs.append(`Plugin installed and activated\\n`);
									} else {
										rollbackLogs.append(`Error during plugin installation!\\n`);
									}
									button.remove();
									redirectionBtn.removeClass(`display-none`);
								}, 
								error: function() {
									rollbackLogs.append(`There was an issue with the rollback process. Please try again.\\n`);
									button.remove();
									redirectionBtn.removeClass(`display-none`);
								},
							});
						} else {
							rollbackLogs.append(`Error during download!\\n`);
							button.remove();
							redirectionBtn.removeClass(`display-none`);
						}
					},
					error: function() {
						rollbackLogs.append(`There was an issue with the rollback process. Please try again.\\n`);
						button.remove();
						redirectionBtn.removeClass(`display-none`);
					}
				});
			});
		});

	";

	echo '<script src="' . esc_url( trailingslashit( COZY_ADDONS_PLUGIN_URL ) ) . 'public/js/jquery.js"></script><script>';
	echo esc_html( $script );
	echo '</script>';

	exit;
}
add_action( 'admin_post_cozy_addons_rollback', 'cozy_addons_rollback_html_schema' );
