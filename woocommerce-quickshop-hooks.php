<?php
/**
 * Quickshop Hooks
 *
 * Action/filter hooks used for Quickshop functions/templates
 */
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/** Template Hooks ********************************************************/

if ( ! is_admin() || defined('DOING_AJAX') ) {
	
	/**
	 * Sale Flash
	 */
	add_action( 'quickshop_sale_flash', 'quickshop_show_product_sale_flash' );


	/**
	 * Product Image
	 */
	add_action( 'quickshop_product_image', 'quickshop_show_product_image' );
			
	
	/**
	 * Product Title
	 */
	add_action( 'quickshop_title', 'quickshop_show_title' );
	
	
	/**
	 * Product Price
	 */
	add_action( 'quickshop_price', 'quickshop_show_price' );
	
	
	/**
	 * Product Rating
	 */
	add_action( 'quickshop_rating', 'quickshop_show_rating' );
	
	
	/**
	 * Product Description
	 */
	add_action( 'quickshop_description', 'quickshop_show_description' );
	
	
	/**
	 * Product Add to Cart
	 */
	add_action( 'quickshop_add_to_cart', 'quickshop_add_to_cart' );
	
	add_action( 'quickshop_simple_add_to_cart', 'quickshop_simple_add_to_cart' );
	add_action( 'quickshop_grouped_add_to_cart', 'quickshop_grouped_add_to_cart' );
	add_action( 'quickshop_variable_add_to_cart', 'quickshop_variable_add_to_cart' );
	add_action( 'quickshop_external_add_to_cart', 'quickshop_external_add_to_cart' );
	
	
	/**
	 * Product Meta
	 */
	add_action( 'quickshop_meta', 'quickshop_show_product_meta' );
	
}