<?php
namespace QuiqOwl;

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    QuiqOwl
 */
class Quiqowl_Activation {
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
	 * Handles the activation of the QuiqOwl plugin.
	 *
	 * This static method is called during the plugin activation process. It performs
	 * necessary setup tasks such as creating default options, setting up database tables,
	 * or performing any other initialization required for the plugin to function correctly.
	 *
	 * @access public
	 * @return void
	 */
	public function activate() {
		global $qo_db;
		$qo_db = new \QuiqOwl\Quiqowl_Database();

		$qo_db->create_table();
	}
}
