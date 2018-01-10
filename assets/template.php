<?php
/**
 * Template for Card grid module
 *
 * $this is an instace of the CardGrid object.
 *
 * Available properties:
 * $this->heading    (string) Module heading.
 * $this->collection (array)  Collection of cards to display.
 *
 * @package Hogan
 */

declare( strict_types = 1 );
namespace Dekode\Hogan;

if ( ! defined( 'ABSPATH' ) || ! ( $this instanceof Grid ) || ! function_exists( 'savage_card' ) ) {
	return;
}

if ( ! empty( $this->heading ) ) {
	hogan_component( 'heading', [
		'title' => $this->heading,
	] );
}

?>
<div class="hogan-grid">
	<div class="hogan-grid-inner">
		<?php
		foreach ( $this->collection as $card ) :
			$classnames = hogan_classnames( 'hogan-grid-item', 'hogan-grid-item-size-' . $card['size'] );
			?>
			<div class="<?php echo esc_attr( $classnames ); ?>">
				<div class="hogan-grid-item-inner">
					<?php savage_card( $card ); ?>
				</div>
			</div>
			<?php
		endforeach;
		?>
	</div>
</div>
