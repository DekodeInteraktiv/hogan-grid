<?php
/**
 * Custom template tags for this plugin
 *
 * @package Hogan
 */

namespace Dekode\Hogan;

/**
 * Setup card data for different post types.
 *
 * @param array $card_raw Post ID and type.
 * @return void
 */
function setup_card( $card_raw ) {

	switch ( $card_raw['content_type'] ) {

		// case 'savage-custom-card':
		// 	break;
		// post, page.
		default:
			$image = get_the_post_thumbnail( $card_raw['id'], 'post-thumbnail' );
			if ( empty( $image ) ) {
				$card = sprintf( '<a href="%s"><div>%s</div></a>', get_the_permalink( $card_raw['id'] ), get_the_title( $card_raw['id'] ) );
			} else {
				$card = sprintf( '<a href="%s">%s<div>%s</div></a>', get_the_permalink( $card_raw['id'] ), get_the_post_thumbnail( $card_raw['id'], 'post-thumbnail' ) , get_the_title( $card_raw['id'] ) );
			}
			break;
	}

	echo $card;
}
