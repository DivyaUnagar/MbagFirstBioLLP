<?php
namespace QuiqOwl;

/**
 * Fired during plugin uninstall.
 *
 * This class defines all code necessary to run during the plugin uninstall.
 *
 * @since      1.0.0
 * @package    QuiqOwl
 */
final class Quiqowl_Uninstall {
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
	 * Handles the uninstallation of the Quiq Owl plugin.
	 *
	 * This static method is called during the plugin uninstallation process. It is responsible
	 * for performing tasks such as removing plugin data from the database, deleting plugin
	 * files, or any other cleanup required to completely remove the plugin from the system.
	 *
	 * @access public
	 * @return void
	 */
	public function uninstall() {
		// global $qo_db;

		// $qo_db->delete();
	}
}
