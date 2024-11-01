<?php
/**
 * Plugin Name: WooCommerce Quickshop Lite
 * Plugin URI: http://quickshop.bitmakers.co/
 * Description: Enhance your WooCommerce store by adding quick-views to your product pages.
 * Version: 1.0.1
 * Author: Bitmakers
 * Author URI:
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WoocommerceQuickshopLite' ) ) {

class WoocommerceQuickshopLite {
	
	var $version = '1.0.1';
	
	var $plugin_path;
	
	/**
	 * Quickshop constructor.
	 */
	function __construct() {
		global $quickshop_settings;
		$quickshop_settings = $this->get_settings();
		
		// Include required files
		$this->includes();
		
		// Initialize the plugin once WooCommerce is active and initialized
		add_action( 'woocommerce_init', array( &$this, 'init' ), 0 );
		add_action( 'woocommerce_init', array( &$this, 'include_template_functions' ), 25 );
	}			
	
	
	/**
	 * Include required core files.
	 */
	function includes() {
		include( 'woocommerce-quickshop-core-functions.php' );
		
		if ( is_admin() ) $this->admin_includes();
		if ( defined('DOING_AJAX') ) $this->ajax_includes();
		if ( ! is_admin() || defined('DOING_AJAX') ) $this->frontend_includes();
	}
	
	
	/**
	 * Include required admin files.
	 */
	function admin_includes() {
		include( 'admin/woocommerce-quickshop-admin-settings.php' ); // Admin section
	}
	
	
	/**
	 * Include required ajax files.
	 */
	function ajax_includes() {
		include( 'woocommerce-quickshop-ajax.php' ); // Ajax functions for admin and the front-end
	}
	
	
	/**
	 * Include required frontend files.
	 */
	function frontend_includes() {
		include( 'woocommerce-quickshop-hooks.php' ); // Template hooks used on the front-end
	}
	
	
	/**
	 * Function used to Init WooCommerce Template Functions - This makes them pluggable by plugins and themes.
	 */
	function include_template_functions() {
		include( 'woocommerce-quickshop-template.php' );
	}
	
	
	/**
	 * Init Quickshop once WooCommerce is active.
	 */
	function init() {
		global $woocommerce, $quickshop_settings;
		
		$this->old_wc_version = ( version_compare( $woocommerce->version, '2.0', '<' ) ) ? true : false;
		$this->template_url = 'woocommerce/';
		
		add_action( 'wp_print_styles', array( &$this, 'frontend_styles') );
		add_action( 'wp_enqueue_scripts', array( &$this, 'frontend_scripts' ) );
		
		// Quickshop button hooks
		add_action( 'woocommerce_after_shop_loop_item', array( $this, 'insert_quickshop_button' ), 10 );
		add_action( 'quickshop_add_button', array( $this, 'insert_quickshop_button' ), 10 ); // Convenience hook for custom product loops
	}
			
		
	/**
	 * Insert a Quickshop button with the product id (must be used withing a product loop).
	 */
	function insert_quickshop_button() {
		global $quickshop_settings, $product;
				
		if ($quickshop_settings['button_top_position']) { $top = 'top:' . $quickshop_settings['button_top_position'] . 'px; margin-top:0;'; }
		if ($quickshop_settings['button_left_position']) { $left = ' left:' . $quickshop_settings['button_left_position'] . 'px; margin-left:0;'; }

		$style = 'style="' . $top . $left . '"';
		
		echo '<a  href="#quickshop" class="quickshop_button qsl_button" data-product_id="' . $product->id . '" ' . $style . '>' . $quickshop_settings['button_text'] . '</a>';
	}
	
	
	/**
	 * Get the plugin url.
	 */
	function plugin_url() {
		if ( $this->plugin_url ) return $this->plugin_url;
		return $this->plugin_url = plugins_url( basename( plugin_dir_path(__FILE__) ), basename( __FILE__ ) );
	}
	
	
	/**
	 * Get the plugin path.
	 */
	function plugin_path() {
		if ( $this->plugin_path ) return $this->plugin_path;
		return $this->plugin_path = untrailingslashit( plugin_dir_path( __FILE__ ) );
	}
	
	
	/**
	 * Register/queue frontend styles.
	 */
	function frontend_styles() {
		global $quickshop_settings;
		
		// Enqueue Quickshop base styles
		wp_enqueue_style( 'quickshop', $this->plugin_url() . '/assets/css/woocommerce-quickshop.css' );
		
		if ( $quickshop_settings['include_product_styles'] ) {
			// Enqueue Quickshop product styles
			wp_enqueue_style( 'quickshop-products', $this->plugin_url() . '/assets/css/woocommerce-quickshop-products.css' );
		}
	}
	
	
	/**
	 * Register/queue frontend scripts.
	 */
	function frontend_scripts() {
		global $woocommerce_quickshop, $quickshop_settings;
		
		// Enqueue variation scripts
		if ( $woocommerce_quickshop->old_wc_version ) {
			// Backwards compat
			wp_deregister_script( 'wc-add-to-cart-variation' );
			wp_register_script( 'wc-add-to-cart-variation', $this->plugin_url() . '/assets/js/frontend/add-to-cart-variation.min.js', array( 'jquery' ), $this->version, true );
		}
		
		wp_enqueue_script( 'wc-add-to-cart-variation' );
		wp_enqueue_script( 'woocommerce-quickshop', $this->plugin_url() . '/assets/js/woocommerce-quickshop.min.js', array( 'jquery' ), $this->version, true );
		
		// Variables for JS scripts
		wp_localize_script( 'woocommerce-quickshop', 'quickshop_params', $quickshop_settings );
	}
	
	
	/**
	 * Get the Quickshop settings
	 */
	function get_settings() {
		$settings = get_option( 'quickshop_settings' );
		
		if ( !$settings ) {
			// Defaults
			$settings = array(
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
		}
		
		return $settings;
	}

}

/**
 * Init quickshop class.
 */
$GLOBALS['woocommerce_quickshop'] = new WoocommerceQuickshopLite();

} // class_exists check