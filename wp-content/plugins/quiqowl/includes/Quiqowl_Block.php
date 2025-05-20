<?php
namespace QuiqOwl;

/**
 * Triggers Block registration.
 *
 * This class is responsible for setting up and configuring the necessary
 * components for the blocks. It handles initialization routines,
 * including enqueueing scripts and styles.
 *
 * @package QuiqOwl
 * @subpackage Block
 */
final class Quiqowl_Block {
	/**
	 * Holds the block instance.
	 *
	 * @access private
	 * @static
	 *
	 * @var static
	 */
	private static $instance = null;

	/**
	 * Sets up a single instance of the block.
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
		add_action( 'plugins_loaded', array( $this, 'load_quiqowl_blocks' ) );
	}

	public function load_quiqowl_blocks() {
		add_action( 'init', array( $this, 'enqueue_block' ) );
	}

	public function enqueue_block() {
		register_block_type( QUIQOWL_PLUGIN_DIR . 'blocks/product-search/build' );
		$asset_file = include_once QUIQOWL_PLUGIN_DIR . 'blocks/product-search/build/index.asset.php';

		wp_register_script( 'quiqowl--product-search', QUIQOWL_PLUGIN_URL . 'blocks/product-search/build/index.js', $asset_file['dependencies'], $asset_file['version'], false );

		wp_set_script_translations( 'quiqowl--product-search', 'quiqowl', QUIQOWL_PLUGIN_DIR . 'languages' );

		wp_localize_script(
			'quiqowl--product-search',
			'quiqOwl',
			array(
				'isPremium'    => quiqowl_premium_access(),
				'pricingURL'   => 'https://untapwp.com/quiqowl/#quiqowl-pricing',
				'isBlockTheme' => quiqowl_is_block_theme(),
			)
		);

		wp_register_script( 'quiqowl--product-search--frontend-script', QUIQOWL_PLUGIN_URL . 'frontend/product-search.js', array( 'jquery' ), QUIQOWL_VERSION, false );

		wp_register_style( 'quiqowl--product-search--editor-style', QUIQOWL_PLUGIN_URL . 'blocks/product-search/build/index.css', array(), $asset_file['version'] );
		wp_register_style( 'quiqowl--product-search--style', QUIQOWL_PLUGIN_URL . 'blocks/product-search/build/style-index.css', array(), $asset_file['version'] );
	}
}
