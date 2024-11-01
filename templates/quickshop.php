<?php
/**
 * Main Quickshop template for displaying products.
 *
 * Override this template by copying it to yourtheme/woocommerce/quickshop.php
 */
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product;
?>
<div itemscope itemtype="http://schema.org/Product" class="qs_wrapper product product-<?php echo $product->id; ?>">
	    
	<div class="images">
    	
        <!-- On-Sale Flash -->
        <?php do_action( 'quickshop_sale_flash' ); ?>
        <!-- /On-Sale Flash -->
        		
        <!-- Product Image -->
		<?php do_action( 'quickshop_product_image' ); ?>
        <!-- /Product Image -->
    
    </div>
        
    <div class="summary">
    
        <div class="product_details">
                        
            <!-- Title -->
			<?php do_action( 'quickshop_title' ); ?>
            <!-- /Title -->
            
            <!-- Price and Stock -->
            <?php do_action( 'quickshop_price' ); ?>
            <!-- /Price and Stock -->
            
            <!-- Star Rating -->
			<?php do_action( 'quickshop_rating' ); ?>
            <!-- /Star Rating -->
            
            <!-- Description -->
            <?php do_action( 'quickshop_description' ); ?>
            <!-- /Description -->
    
        </div>
    
        <!-- Quantity and Add to Cart -->
        <?php do_action( 'quickshop_add_to_cart' ); ?>
        <!-- /Quantity and Add to Cart -->
        
        <!-- Product Meta -->
        <?php do_action( 'quickshop_meta' ); ?>
        <!-- /Product Meta -->
    
    </div>
    
</div>