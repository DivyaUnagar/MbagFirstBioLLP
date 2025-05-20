<?php
namespace QuiqOwl;

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    QuiqOwl
 */
final class Quiqowl_Deactivation {
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
	 * Handles the deactivation of the Quiq Owl plugin.
	 *
	 * This static method is called during the plugin deactivation process. It performs
	 * necessary cleanup tasks such as removing temporary options, disabling scheduled
	 * events, or performing any other actions required to safely deactivate the plugin.
	 *
	 * @access public
	 * @return void
	 */
	public function deactivate() {
	}
}
