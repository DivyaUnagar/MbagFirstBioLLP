<?php
/**
 * Blocks rest api controller
 *
 * @package CozyBlock\RestApi\Controllers\V1
 */

namespace CozyBlock\RestApi\Controllers\V1;

use CozyBlock\Abstracts\RestControllerBase;
use WP_REST_Request;

/**
 * Exit if accessed directly.
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


class CF7 extends RestControllerBase {
	public function register_routes() {
		try {
			register_rest_route(
				'cozy-block/v1',
				'/cf7-shortcode-content',
				array(
					'methods'             => \WP_REST_Server::READABLE,
					'callback'            => array( $this, 'cozy_addons_get_cf7_render' ),
					'permission_callback' => '__return_true',
				)
			);

		} catch ( \Exception $e ) {
			// error_log( 'Error registering route: ' . $e->getMessage() );
		}
	}

	public function cozy_addons_get_cf7_render( WP_REST_Request $request ) {
		$shortcode = $request->get_param( 'shortcode' ) ? sanitize_text_field( wp_unslash( $request->get_param( 'shortcode' ) ) ) : '';

		$render = '';

		if ( ! empty( $shortcode ) ) {
			$render = do_shortcode( $shortcode );
		}

		return $render;
	}
}
