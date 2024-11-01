<?php
/**
 * Quickshop - Product Meta
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $product;
?>
<div class="product_meta">

	<?php if ( $product->is_type( array( 'simple', 'variable' ) ) && get_option('woocommerce_enable_sku') == 'yes' && $product->get_sku() ) : ?>
        <div itemprop="productID" class="meta sku_wrapper"><?php _e( 'SKU:', 'woocommerce' ); ?> <span class="sku"><?php echo $product->get_sku(); ?></span></div>
	<?php endif; ?>

	<?php echo $product->get_categories( ', ', '<div class="meta posted_in">' . _n( 'Category:', 'Categories:', sizeof( get_the_terms( $post->ID, 'product_cat' ) ), 'woocommerce' ) . ' ', '.</div>' ); ?>

	<?php echo $product->get_tags( ', ', '<div class="meta tagged_as">' . _n( 'Tag:', 'Tags:', sizeof( get_the_terms( $post->ID, 'product_tag' ) ), 'woocommerce' ) . ' ', '.</div>' ); ?>
        
</div>