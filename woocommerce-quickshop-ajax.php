<?php
/**
 * Quickshop Ajax handlers
 *
 * Handles AJAX requests via wp_ajax hook
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/** Frontend AJAX events **************************************************/

/**
 * AJAX	load product
 */
function quickshop_ajax_load_product() {
	global $woocommerce, $woocommerce_quickshop, $post, $product;
	
	$product_id = $_POST['product_id'];
	$post = get_post( $product_id );
	$jsonArr = array();
		
	if ( $woocommerce_quickshop->old_wc_version ) {
		$product = new WC_Product( $product_id );
				
		if ( $product->product_type == 'variable' ) {
			$jsonArr['is_variable'] = 'true';
			$jsonArr['variations'] = $product->get_available_variations();
		}
	} else {
		$product = get_product( $product_id );
		
		if ( $product->product_type == 'variable' ) {
			$jsonArr['is_variable'] = 'true';
		}
	}
		
	ob_start();
	quickshop_get_template( 'quickshop.php' );
	$template_str = ob_get_clean();
	
	$jsonArr['html']       = $template_str;
	$jsonArr['product_id'] = $product_id;
	
	$json = json_encode($jsonArr);
		
	echo $json;
			
	die();
}

add_action( 'wp_ajax_quickshop_ajax_load_product' , 'quickshop_ajax_load_product' );
add_action( 'wp_ajax_nopriv_quickshop_ajax_load_product', 'quickshop_ajax_load_product' );