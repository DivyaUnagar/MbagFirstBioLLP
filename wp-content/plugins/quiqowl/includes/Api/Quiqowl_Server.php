<?php

namespace QuiqOwl\Api;

class Quiqowl_Server {
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

	public function __construct() {
		add_action( 'rest_api_init', array( $this, 'register_routes' ) );
	}

	public function register_routes() {
		$routes = $this->routes();

		foreach ( $routes as $route ) {
			$route->register();
		}
	}

	public function routes() {
		return array(
			'product' => Product::get_instance(),
		);
	}
}
