<?php
/**
 * REST API for archive
 *
 * @package Dekode\nt
 */

namespace Dekode\Hogan\Rest;

/**
 * Register our new routes.
 */
add_action(
	'rest_api_init', function() {
		$rest_api = new ReviewAPI();
		$rest_api->register_routes();
	}
);

/**
 * The booking queue implementation.
 */
class ReviewAPI extends \WP_REST_Controller {

	/**
	 * Register our routes to the WP REST API.
	 */
	public function register_routes() {
		register_rest_route(
			'hogan/grid',
			'/get',
			[
				'methods'             => \WP_REST_Server::READABLE,
				'callback'            => [ $this, 'get_module' ],
				'permission_callback' => [ $this, 'status_permissions_callback' ],
			]
		);
	}

	/**
	 * Get archive posts
	 *
	 * @param WP_REST_Request $request The REST request.
	 */
	public function get_module( $request ) {
		$post = $request->get_param( 'post' );
		$size = $request->get_param( 'size' );
		if( !$size ) {
			$size = 'small';
		}
		$hogan_grid = [
			'acf_fc_layout' => 'grid',
			'flex_grid'     => [
				0 => [
					'acf_fc_layout' => 'static_content',
					'card_style'    => $size,
					'posts_list'    => [$post],
				],
			],
		];

		ob_start();
		\hogan_module( 'grid', $hogan_grid );
		$output = ob_get_contents();
		ob_end_clean();

		return wp_send_json_success( $output );
	}

	public function status_permissions_callback( $request ) {
		return true;
	}
}
