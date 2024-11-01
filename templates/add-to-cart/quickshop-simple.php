<?php
/**
 * Quickshop - Simple product add to cart
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $woocommerce, $product, $post;

if ( ! $product->is_purchasable() ) return;
?>

<?php
	// Availability
	$availability = $product->get_availability();

	if ($availability['availability']) :
		echo '<span class="stock ' . esc_attr( $availability['class'] ) . '">Availability: ' . apply_filters( 'woocommerce_stock_html', '<strong class="' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</strong>', $availability['availability'] ) . '</span>';
    endif;
?>

<?php if ( $product->is_in_stock() ) : ?>

	<form action="<?php echo esc_url( $product->add_to_cart_url() ); ?>" class="cart" method="post" enctype='multipart/form-data'>

	 	<?php
	 		if ( ! $product->is_sold_individually() )
	 			woocommerce_quantity_input( array( 
					'min_value' => apply_filters( 'woocommerce_quantity_input_min', 1, $product ),
	 				'max_value' => apply_filters( 'woocommerce_quantity_input_max', $product->backorders_allowed() ? '' : $product->get_stock_quantity(), $product )
				) );
	 	?>

	 	<button type="submit" class="single_add_to_cart_button button qs_button qs_product_type_simple alt" data-product_id="<?php echo $post->ID; ?>"><?php echo apply_filters('single_add_to_cart_text', __('Add to cart', 'woocommerce'), $product->product_type); ?></button>

	</form>

<?php endif; ?>