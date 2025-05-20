<?php
namespace QuiqOwl;

final class Quiqowl_Admin {
	/**
	 * Holds the plugin admin instance.
	 *
	 * @access private
	 * @static
	 *
	 * @var static
	 */
	private static $instance = null;

	/**
	 * Sets up a single instance of the plugin admin.
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

	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_resources' ) );
		add_action( 'init', array( $this, 'load_admin_files' ) );
		// $this->load_admin_files();

		add_action( 'admin_menu', array( $this, 'register_quiqowl_menu' ) );
	}

	public function register_quiqowl_menu() {
		if ( ! menu_page_url( '_quiqowl' ) ) {
			add_menu_page( 'QuiqOwl', 'QuiqOwl', 'manage_options', '_quiqowl', array( $this, 'quiqowl_admin_dashboard_render' ), QUIQOWL_PLUGIN_URL . 'admin/assets/img/quiqowl_dark.png', '55.5' );
			add_submenu_page(
				'_quiqowl',
				'Dashboard',
				__( 'Dashboard', 'quiqowl' ),
				'manage_options',
				'_quiqowl',
			);

			add_submenu_page( '_quiqowl', 'Search Analytics', sprintf( '%s', quiqowl_premium_access() ? __( 'Search Analytics', 'quiqowl' ) : __( 'Search Analaytics (Pro)', 'quiqowl' ) ), 'manage_options', '_quiqowl-search-keyword', array( $this, 'quiqowl_search_keyword_analytics' ) );

			add_submenu_page( '_quiqowl', 'Product Analytics', sprintf( '%s', quiqowl_premium_access() ? __( 'Product Analytics', 'quiqowl' ) : __( 'Product Analaytics (Pro)', 'quiqowl' ) ), 'manage_options', '_quiqowl-product', array( $this, 'quiqowl_product_analytics' ) );
		}
	}

	public function quiqowl_admin_dashboard_render() {
		include_once QUIQOWL_PLUGIN_DIR . 'admin/dashboard.php';
	}

	public function quiqowl_search_keyword_analytics() {
		if ( ! quiqowl_premium_access() ) {
			header( 'location: https://untapwp.com/quiqowl/#quiqowl-pricing' );
			exit;
		}

		include_once QUIQOWL_PLUGIN_DIR . 'admin/pages/search-analytics.php';
	}

	public function quiqowl_product_analytics() {
		if ( ! quiqowl_premium_access() ) {
			header( 'location: https://untapwp.com/quiqowl/#quiqowl-pricing' );
			exit;
		}

		include_once QUIQOWL_PLUGIN_DIR . 'admin/pages/product-analytics.php';
	}

	public function enqueue_admin_resources() {
		// Load Admin Styles.
		wp_enqueue_style( 'quiqowl--admin-style', QUIQOWL_PLUGIN_URL . '/admin/assets/css/quiqowl-admin-style.css', array(), QUIQOWL_VERSION, false );

		// Load Admin Script.
		wp_enqueue_script( 'quiqowl--admin-script', QUIQOWL_PLUGIN_URL . '/admin/assets/js/quiqowl-admin-script.js', array( 'jquery' ), QUIQOWL_VERSION, false );
		wp_localize_script(
			'quiqowl--admin-script',
			'adminObject',
			array(
				'ajaxURL'       => admin_url( 'admin-ajax.php' ),
				'cartDataNonce' => wp_create_nonce( 'quiqowl-admin__product_cart_data' ),
			)
		);
	}

	public function load_admin_files() {
		// Load Helpers.
		require_once QUIQOWL_PLUGIN_DIR . 'admin/helpers/class-quiqowl-table.php';
	}
}
