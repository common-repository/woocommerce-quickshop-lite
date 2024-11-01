<?php
/**
 * Quickshop - External product add to cart
 */
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

?>
<p class="cart"><a href="<?php echo esc_url( $product_url ); ?>" rel="nofollow" class="single_add_to_cart_button button qs_product_type_external alt"><?php echo apply_filters('single_add_to_cart_text', $button_text, 'external'); ?></a></p>