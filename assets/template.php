<?php
/**
 * Template for Card grid module
 *
 * $this is an instace of the CardGrid object.
 *
 * Available properties:
 * $this->heading (string) Module heading.
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
