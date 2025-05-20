<?php
namespace QuiqOwl;

use QuiqOwl\Api\Quiqowl_Server;

/**
 * Initializes the QuiqOwl plugin for AJAX search functionality.
 *
 * This class is responsible for setting up and configuring the necessary
 * components for the QuiqOwl plugin. It handles initialization routines,
 * including enqueueing scripts and styles,
 * and setting up AJAX handlers.
 *
 * @package QuiqOwl
 * @subpackage Initialization
 */
final class Quiqowl_Init {
	/**
	 * Holds the plugin instance.
	 *
	 * @access private
	 * @static
	 *
	 * @var static
	 */
	private static $instance = null;

	/**
	 * Sets up a single instance of the plugin.
	 *
	 * @static
	 *
	 * @return static An instance of the class.
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Initializes a new instance of the class.
	 *
	 * The constructor sets up the initial state of the object and performs any
	 * necessary setup tasks when a new instance of the class is created.
	 * This may include registering hooks, initializing properties, or configuring
	 * default settings.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		// Load translation.
		add_action( 'init', array( $this, 'add_plugin_compatibility_resources' ) );

		add_action( 'plugins_loaded', array( $this, 'quiqowl_rest_api_init' ) );

		// Load Admin Resources.
		require_once QUIQOWL_PLUGIN_DIR . 'admin/functions.php';
		\QuiqOwl\Quiqowl_Admin::get_instance();

		// Load Plugin Resources.
		\QuiqOwl\Quiqowl_Resources::get_instance();

		// Initialize blocks.
		\QuiqOwl\Quiqowl_Block::get_instance();
	}

	/**
	 * Load plugin compatibility
	 *
	 * Fired by `init` action hook.
	 *
	 * @since 1.0.0
	 *
	 * @access public
	 */
	public function add_plugin_compatibility_resources() {
		$this->i18n();
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
	 * @access private
	 */
	private function i18n() {

		load_plugin_textdomain( 'quiqowl' );
	}

	public function quiqowl_rest_api_init() {
		// WooCommerce HPOS compatibility.
		add_action(
			'before_woocommerce_init',
			function () {
				if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
					\Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', QUIQOWL_PLUGIN_DIR . 'quiqowl.php', true );
				}
			}
		);

		Quiqowl_Server::get_instance();
	}
}
