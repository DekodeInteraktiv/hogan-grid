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

if ( ! defined( 'ABSPATH' ) || ! ( $this instanceof Grid ) || ! function_exists( 'savage_get_card' ) ) {
	return;
}

$classnames = hogan_classnames( apply_filters( 'hogan/module/grid/grid_outer_classes', [
	'hogan-grid',
	'hogan-grid-text-' . $this->text_align,
	'hogan-grid-size-' . $this->grid_size,
], $this ) );
?>
<div class="<?php echo esc_attr( $classnames ); ?>">

	<?php
	$classnames = hogan_classnames( apply_filters( 'hogan/module/grid/grid_inner_classes', [
		'hogan-grid-inner',
	], $this ) );
	?>

	<div class="<?php echo esc_attr( $classnames ); ?>">
		<?php
		foreach ( $this->collection as $card_args ) :
			$card       = savage_get_card( $card_args );
			$classnames = hogan_classnames( apply_filters( 'hogan/module/grid/item_classes', array_merge( [
				'hogan-grid-item',
				'hogan-grid-item-size-' . $card_args['size'],
				'hogan-grid-item-type-' . $card_args['type'],
			], $card['classnames'] ), $card, $this ) );
			?>
			<div class="<?php echo esc_attr( $classnames ); ?>">
				<div class="hogan-grid-item-inner">
					<?php
					echo $card['markup']; // WPCS: XSS OK.
					?>
				</div>
			</div>
			<?php
		endforeach;
		?>
	</div>
</div>
