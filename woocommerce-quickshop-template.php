<?php
/**
 * Quickshop Template Functions
 *
 * Functions used in the template files to output content - in most cases hooked in via the template actions. All functions are pluggable.
 */
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/** Quickshop Product ********************************************************/

if ( ! function_exists( 'quickshop_show_product_sale_flash' ) ) {

	/**
	 * Output the product sale flash.
	 */
	function quickshop_show_product_sale_flash() {
		quickshop_get_template( 'quickshop-sale-flash.php' );
	}
}
if ( ! function_exists( 'quickshop_show_product_gallery' ) ) {

	/**
	 * Output the product image.
	 */
	function quickshop_show_product_image() {
		quickshop_get_template( 'quickshop-product-image.php' );
	}
}
if ( ! function_exists( 'quickshop_show_title' ) ) {

	/**
	 * Output the product title.
	 */
	function quickshop_show_title() {
		quickshop_get_template( 'quickshop-title.php' );
	}
}
if ( ! function_exists( 'quickshop_show_price' ) ) {

	/**
	 * Output the product price.
	 */
	function quickshop_show_price() {
		quickshop_get_template( 'quickshop-price.php' );
	}
}
if ( ! function_exists( 'quickshop_show_rating' ) ) {

	/**
	 * Output the product rating.
	 */
	function quickshop_show_rating() {
		global $wpdb, $post;
		
		$average_rating = 0;
			
		$count = $wpdb->get_var( $wpdb->prepare("
			SELECT COUNT(meta_value) FROM $wpdb->commentmeta
			LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
			WHERE meta_key = 'rating'
			AND comment_post_ID = %d
			AND comment_approved = '1'
			AND meta_value > 0
		", $post->ID ) );
			
		$rating = $wpdb->get_var( $wpdb->prepare("
			SELECT SUM(meta_value) FROM $wpdb->commentmeta
			LEFT JOIN $wpdb->comments ON $wpdb->commentmeta.comment_id = $wpdb->comments.comment_ID
			WHERE meta_key = 'rating'
			AND comment_post_ID = %d
			AND comment_approved = '1'
		", $post->ID ) );
		
		if ( $count > 0 ) {
			$average_rating = number_format($rating / $count, 2);
		}

		quickshop_get_template( 'quickshop-rating.php', array(
			'average_rating' => $average_rating,
			'count'          => $count
		) );
	}
}
if ( ! function_exists( 'quickshop_show_description' ) ) {

	/**
	 * Output the product description.
	 */
	function quickshop_show_description() {
		quickshop_get_template( 'quickshop-description.php' );
	}
}
if ( ! function_exists( 'quickshop_show_product_meta' ) ) {

	/**
	 * Output the product meta.
	 */
	function quickshop_show_product_meta() {
		quickshop_get_template( 'quickshop-meta.php' );
	}
}
if ( ! function_exists( 'quickshop_add_to_cart' ) ) {	

	/**
	 * Trigger the single product add to cart action.
	 */
	function quickshop_add_to_cart() {
		global $product;
		do_action( 'quickshop_' . $product->product_type . '_add_to_cart'  );
	}
}
if ( ! function_exists( 'quickshop_simple_add_to_cart' ) ) {

	/**
	 * Output the simple product add to cart area.
	 */
	function quickshop_simple_add_to_cart() {
		quickshop_get_template( 'add-to-cart/quickshop-simple.php' );
	}
}
if ( ! function_exists( 'quickshop_grouped_add_to_cart' ) ) {

	/**
	 * Output the grouped product add to cart area.
	 */
	function quickshop_grouped_add_to_cart() {
		quickshop_get_template( 'add-to-cart/quickshop-grouped.php' );
	}
}
if ( ! function_exists( 'quickshop_variable_add_to_cart' ) ) {

	/**
	 * Output the variable product add to cart area.
	 */
	function quickshop_variable_add_to_cart() {
		global $woocommerce, $product;
		
		// Print variation script
		//wp_register_script('quickshop-wc-add-to-cart-variation', $woocommerce->plugin_url() . '/assets/js/frontend/add-to-cart-variation.js');
		//wp_print_scripts('quickshop-wc-add-to-cart-variation');
		
		//add_filter( 'single_product_large_thumbnail_size', 'quickshop_product_image_size' ); // Make sure any product-variation images use the dimensions set in the Quickshop settings
		
		// Load the template
		quickshop_get_template( 'add-to-cart/quickshop-variable.php', array(
			'available_variations' => $product->get_available_variations(),
			'attributes'   		   => $product->get_variation_attributes(),
			'selected_attributes'  => $product->get_variation_default_attributes()
		) );
		
		//remove_filter( 'single_product_large_thumbnail_size', 'quickshop_product_image_size' ); // Remove the image size filter after get_available_variations()
	}
}
if ( ! function_exists( 'quickshop_external_add_to_cart' ) ) {

	/**
	 * Output the external product add to cart area.
	 */
	function quickshop_external_add_to_cart() {
		global $product;

		$product_url = get_post_meta( $product->id, '_product_url', true  );
		$button_text = get_post_meta( $product->id, '_button_text', true  );

		if ( ! $product_url ) return;

		quickshop_get_template( 'add-to-cart/quickshop-external.php', array(
			'product_url' => $product_url,
			'button_text' => ( $button_text ) ? $button_text : __( 'Buy product', 'woocommerce' )
		) );
	}
}
if ( ! function_exists( 'quickshop_quantity_input' ) ) {

	/**
	 * Output the quantity input for add to cart forms.
	 */
	function quickshop_quantity_input( $args = array() ) {
		$defaults = array(
			'input_name'  => 'quantity',
			'input_value' => '1',
			'max_value'   => '',
			'min_value'   => '0'
		);

		$args = apply_filters( 'woocommerce_quantity_input_args', wp_parse_args( $args, $defaults  ) );

		quickshop_get_template( 'add-to-cart/quickshop-quantity.php', $args );
	}
}