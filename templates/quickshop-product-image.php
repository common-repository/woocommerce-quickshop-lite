<?php
/**
 * Quickshop - Product Images/Gallery
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $woocommerce;
?>
<div class="image_wrap">
<?php 
	if ( has_post_thumbnail( $post->ID ) ) {
		
		$image_id      = get_post_thumbnail_id( $post->ID );
		$full_image    = wp_get_attachment_url( $image_id );
		$product_image = wp_get_attachment_image_src( $image_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ) );
		$product_image = $product_image[0];
		$title         = get_the_title( $image_id );
	
	} else {
		
		$full_image    = woocommerce_placeholder_img_src();
		$product_image = $full_image;
		$title         = 'Placeholder';
	
	}
	
	printf( '<a href="%s" class="woocommerce-main-image zoom">%s</a>',
		$full_image,
		'<img src="' . $product_image . '" class="quickshop_product_image" title="' . $title . '" />'
	);
?>
</div>

<div class="full_product_details">
	<a href="<?php echo get_permalink($post->ID); ?>">Full Product Details &rarr;</a>
</div>