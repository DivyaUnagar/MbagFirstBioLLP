<?php
namespace QuiqOwl;

final class Quiqowl_Resources {
	/**
	 * Holds the resources instance.
	 *
	 * @access private
	 * @static
	 *
	 * @var static
	 */
	private static $instance = null;

	/**
	 * Sets up a single instance of the resources.
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
	 * Load plugin resources.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		// Assets for the editor only.
		add_action( 'enqueue_block_editor_assets', array( $this, 'load_quiqowl_block_editor_resources' ) );

		// Load assets during initialization.
		add_action( 'init', array( $this, 'load_quiqowl_init_resources' ) );

		// Enqueue assets.
		// add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_quiqowl_resources' ) );
	}

	/**
	 * Loads the block editor resources.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function load_quiqowl_block_editor_resources() {
		// Load block utils.
		$this->load_quiqowl_block_utils();

		// Load fonts.
		$this->load_quiqowl_google_fonts();

		// Load block editor stylesheets.
		$this->load_quiqowl_editor_stylesheets();
	}

	/**
	 * Loads the block resources.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function load_quiqowl_init_resources() {
		// Swiper
		wp_register_script( 'quiqowl--swiper-bundle', QUIQOWL_PLUGIN_URL . 'resources/js/swiper-bundle.js', array( 'jquery' ), '11.0.3', false );
		// Swiper styles.
		wp_register_style( 'quiqowl--swiper-bundle', QUIQOWL_PLUGIN_URL . 'resources/css/swiper-bundle.css', array(), '11.0.3' );

		// Register frontend script.
		// wp_register_script( 'quiqowl--frontend-script', QUIQOWL_PLUGIN_URL . 'resources/js/quiqowl-block-script.js', array( 'jquery' ), QUIQOWL_VERSION, false );
	}

	/**
	 * Generates the fonts option for the select control.
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function load_quiqowl_google_fonts() {
		if ( file_exists( QUIQOWL_PLUGIN_DIR . 'resources/font/google-fonts.php' ) ) {
			include_once QUIQOWL_PLUGIN_DIR . 'resources/font/google-fonts.php';
		}

		// Register the script for the block's editor.
		wp_register_script(
			'quiqowl--google-fonts', // Handle for the script.
			QUIQOWL_PLUGIN_URL . 'blocks/components/googleFonts.js', // Path to your JavaScript file.
			array( 'wp-blocks', 'wp-element', 'wp-editor' ), // Dependencies.
			QUIQOWL_VERSION,
			true
		);

		wp_localize_script(
			'quiqowl--google-fonts',
			'quiqOwlAssets',
			array(
				'googleFonts' => quiqowl_google_fonts(),

			)
		);
	}

	/**
	 * Register the block utils.
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function load_quiqowl_block_utils() {
		// Register the script for the block's editor.
		wp_register_script(
			'quiqowl--block-utils', // Handle for the script.
			QUIQOWL_PLUGIN_URL . 'blocks/components/utils.js', // Path to your JavaScript file.
			array( 'wp-blocks', 'wp-element', 'wp-editor' ), // Dependencies.
			QUIQOWL_VERSION,
			true
		);
	}

	/**
	 * Register block editor stylesheets.
	 *
	 * @since 1.0.0
	 * @access private
	 */
	private function load_quiqowl_editor_stylesheets() {
		wp_register_style( 'quiqowl--block-editor-styles', QUIQOWL_PLUGIN_URL . 'resources/css/block-editor.css', array(), QUIQOWL_VERSION, 'all' );
	}

	/**
	 * Enqueue scripts.
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function enqueue_quiqowl_resources() {
	}
}
