<?php
/**
 * Template for Card grid module
 *
 * $this is an instace of the CardGrid object.
 *
 * Available properties:
 * $this->heading (string) Module heading.
 * $this->collection (array) Module heading.
 *
 * @package Hogan
 */

declare( strict_types = 1 );
namespace Dekode\Hogan;

if ( ! defined( 'ABSPATH' ) || ! ( $this instanceof Grid ) ) {
	return; // Exit if accessed directly.
}

if ( ! empty( $this->heading ) ) : ?>
	<h2 class="heading"><?php echo esc_html( $this->heading ); ?></h2>
<?php
endif;

foreach ( $this->collection as $group ) {

	switch ( $group['acf_fc_layout'] ) {
		case 'static_content':
			foreach ( $group['posts_list'] as $card ) {
				printf( '<a href="%s">%s</a>', esc_url( get_the_permalink( $card ) ), esc_html( get_the_title( $card ) ) );
			}
			break;

		default:
			break;
	}
}
