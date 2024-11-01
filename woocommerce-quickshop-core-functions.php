<?php
/**
 * Quickshop Core Functions
 *
 * Functions available on both the front-end and admin.
 */
 
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Get other templates (e.g. product attributes) passing attributes and including the file.
 */
function quickshop_get_template( $template_name, $args = array(), $template_path = '', $default_path = '' ) {
	if ( $args && is_array($args) ) {
		extract( $args );
	}
		
	$located = quickshop_locate_template( $template_name, $template_path, $default_path );
	include( $located );
}


/**
 * Locate a template and return the path for inclusion.
 *
 * This is the load order:
 *
 *		yourtheme		/	$template_path	/	$template_name
 *		yourtheme		/	$template_name
 *		$default_path	/	$template_name
 */
function quickshop_locate_template( $template_name, $template_path = '', $default_path = '' ) {
	global $woocommerce_quickshop;

	if ( ! $template_path ) $template_path = $woocommerce_quickshop->template_url;
	if ( ! $default_path ) $default_path = $woocommerce_quickshop->plugin_path() . '/templates/';
	
	// Look within passed path within the theme - this is priority
	$template = locate_template(
		array(
			trailingslashit( $template_path ) . $template_name,
			$template_name
		)
	);

	// Get default template
	if ( ! $template ) {
		$template = $default_path . $template_name;
	}
	
	// Return what we found
	return apply_filters('quickshop_locate_template', $template, $template_name, $template_path);
}


/**
 * Get the default Quickshop settings
 */
function quickshop_get_defaults() {
	$defaults = array(
		'include_product_styles'  => '1',
		'button_text'             => 'Quickshop',
		'button_top_position'     => '',
		'button_left_position'    => '',
		'modal_auto_close'        => '1',
		'modal_width'             => '754',
		'modal_height'            => 'auto',
		'overlay_color'           => '#E9E9E9',
		'overlay_opacity'         => '0.7',
		'preloader_text'          => 'Loading..'
	);
	
	return $defaults;
}


/**
 * Get a setting
 */		
function quickshop_get_setting($setting, $default = false) {
	global $quickshop_settings;
	
	return (isset($quickshop_settings[$setting]) ? $quickshop_settings[$setting] : $default);
}


/**
 * Get the size of the main product image
 */
/*function quickshop_product_image_size() {
	global $quickshop_settings;
	
	return array($quickshop_settings['product_image_width'], $quickshop_settings['product_image_height']);
}*/


/**
 * Get attachment id's for the product gallery
 */
function quickshop_get_attachment_ids() {
	global $product;
	
	if ( ! isset( $product->product_image_gallery ) ) {
		// Backwards compat
		/*$attachment_ids = get_posts( array(
			'post_parent' 	 => $product->id,
			'numberposts' 	 => -1,
			'post_type' 	 => 'attachment',
			'post_status' 	 => null,
			'post__not_in'	 => array( get_post_thumbnail_id() ),
			'orderby'		 => 'menu_order',
			'order'			 => 'ASC',
			'post_mime_type' => 'image',
			'fields'         => 'ids'
		) );*/
		$attachment_ids = array_diff( get_posts( 'post_parent=' . $product->id . '&numberposts=-1&post_type=attachment&orderby=menu_order&order=ASC&post_mime_type=image&fields=ids' ), array( get_post_thumbnail_id( $product->id ) ) );
		$product->product_image_gallery = implode( ',', $attachment_ids );
	}

	return array_filter( (array) explode( ',', $product->product_image_gallery ) );
}