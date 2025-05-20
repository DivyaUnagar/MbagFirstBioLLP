<?php
namespace QuiqOwl\Api;

class Product extends Base {
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
	 * Register REST Routes
	 *
	 * @return void
	 */
	public function register() {
		$this->get(
			'product-attributes',
			array(
				'callback' => array( $this, 'get_wc_attributes' ),
			)
		);
	}

	public function get_wc_attributes() {
		if ( ! function_exists( '\WC' ) ) {
			return rest_ensure_response( array() );
		}

		$wc_attr_tax = wc_get_attribute_taxonomies();

		return rest_ensure_response( $wc_attr_tax );
	}
}
