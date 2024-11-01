<?php
/**
 * Quickshop Settings Class
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( ! class_exists( 'WoocommerceQuickshopLiteSettings' ) ) {

class WoocommerceQuickshopLiteSettings {

	var $tab_name = 'woocommerce-quickshop-lite';
	
	/**
	 * Quickshop settings constructor.
	 */
	function __construct() {
		$this->defaults = quickshop_get_defaults();
		
		add_action( 'admin_init',  array( &$this, 'load_hooks' ) );
	}
	
	
	/**
	 * Load the admin hooks.
	 */
	function load_hooks() {	
		add_filter( 'woocommerce_settings_tabs_array', array( &$this, 'add_settings_tab' ) );
		add_action( 'woocommerce_settings_tabs_' . $this->tab_name, array( &$this, 'create_settings_page' ) );
		add_action( 'woocommerce_update_options_' . $this->tab_name, array( &$this, 'save_settings_page' ) );
	}
	
	
	/**
	 * Add a tab to the settings page.
	 */
	function add_settings_tab($tabs) {
		$tabs[$this->tab_name] = __( 'Quickshop', 'woocommerce-quickshop' );
		return $tabs;
	}
	
	
	/**
	 * Create the settings page content.
	 */
	function create_settings_page() {
		global $woocommerce;
		
		?>
		<style type="text/css">
        	table.form-table {
				position:relative;
				width:100%;
			}
			table tr.disabled,
			table tr.disabled th,
			table tr.disabled label,
			table tr.disabled input {
				color:#999;
			}
			table tr.disabled label,
			table tr.disabled input {
				cursor:default;
			}
			
			.infobox {
				margin-bottom:20px;
				padding:0 17px 19px; 
				border:1px solid #E1E1E1;
				border-radius:3px;background:#fff;
				box-shadow:0 1px 3px rgba(0, 0, 0, 0.07);
			}
			.infobox h2 {
				font-size:22px;
				line-height:24px;
				font-weight:normal;
				color:#222;
				padding:21px 0 10px;
			}
			.infobox ul {
				margin:0;
				padding:0;
			}
			.infobox ul li {
				font-size:12px;
				line-height:24px;
				margin:0;
				padding:0;
			}
			.infobox ul.features {
				margin:12px 0;
			}
			.infobox ul.features li {
				list-style:decimal inside none;
				margin-bottom:6px;
			}
			.infobox .upgrade_button {
				width:99.8%;
				text-align:center;
				background:#2A99EF;
				background:-webkit-linear-gradient(center top, #2A99EF, #237BBD);
				background:-moz-linear-gradient(center top, #2A99EF, #237BBD);
				background:-ms-linear-gradient(center top, #2A99EF, #237BBD);
				background:-o-linear-gradient(center top, #2A99EF, #237BBD);
				background:linear-gradient(center top, #2A99EF, #237BBD);
				border-color:#2473B0 #2473B0 #20608F;
				border-radius:3px;
				border-style:solid;
				border-width:1px;
				box-shadow:0 1px 2px rgba(0, 0, 0, 0.3), 0 1px rgba(255, 255, 255, 0.25) inset;
				color:#fff;
				display:inline-block;
				font-size:14px;
				line-height:14px;
				text-decoration:none;
				margin-top:8px;
				padding:11px 0 13px;
				text-shadow:0 1px 1px rgba(0, 0, 0, 0.4);
			}
			.infobox .upgrade_button:hover {
				background:-moz-linear-gradient(center top, #51adf5, #2a86cb);
				background:linear-gradient(center top, #51adf5, #2a86cb);
			}
			.infobox .upgrade_button:active {
				background:-moz-linear-gradient(center top, #237BBD, #2A99EF);
				background:linear-gradient(center top, #237BBD, #2A99EF);
			}
			@media screen and (max-width: 1050px) {
				#quickshop_sidebar {
					display:none;
				}
			}
        </style>
        
        <table class="form-table">
        
        	<tr valign="top">
        		<td>
                    <div id="quickshop_sidebar" style="position:absolute; top:70px; right:0; z-index: 1000; width:262px;">
                        
                        <!--<div class="infobox">
                        	<h2>Quickshop Lite v1.0</h2>
                            
                            <ul>
                                <li><a href="#changelog">Changelog</a></li>
                                <li><a href="#docs">Documentation</a></li>
                                <li><a href="#support">Support</a></li>
                                <li><a href="http://quickshop.bitmakers.co">Quickshop Home</a></li>
                            </ul>
                        </div>-->
                        
                        <div class="infobox">
                            <h2>Upgrade</h2>
                            <p>Take a look at the additional features available with the full version:</p>
                            
                            <h3>Additional Features</h3>
                            <ul class="features">
                                <li>Ajax add-to-cart (no page reloading).</li>
                                <li>Custom image dimensions.
                                <li>Display full description or summary.</li>
                                <li>Gallery with zoom option.</li>
                                <li>Include Quickshop links anywhere.</li>
                                <li>Product-view caching (fast loading).</li>
                                <li>Responsive.</li>
                                <li>Related products slider.</li>
                                <li>Social share integration.</li>
                                <li>Support.</li>
                            </ul>
                            
                            <a href="http://quickshop.bitmakers.co/#buy" target="_blank" class="upgrade_button">Upgrade Now</a>
                        </div>
                    
                    </div>
        
        			<div>	        
        
        <h3>General Options</h3>
        
        <table class="form-table">
            <tbody>
                <tr valign="top" class="disabled">
                    <th class="titledesc" scope="row">
                    	Caching
                        <img class="help_tip" data-tip="Cache the product views after they have loaded for better performance." src="<?php echo $woocommerce->plugin_url() . '/assets/images/help.png'; ?>" height="16" width="16" />
                    </th>
                    <td class="forminp">
                        <fieldset>
                        	<legend class="screen-reader-text"><span>Cache product views</span></legend>
                    		<label for="quickshop_cache_product_views">
                    			<input disabled="disabled" type="checkbox">
                    			Cache product views (Full version)
                            </label>
                            <br />
                    	</fieldset>
                    </td>
                </tr>
                <tr valign="top" class="disabled">
                    <th class="titledesc" scope="row">
                    	Responsive
                        <img class="help_tip" data-tip="Enable if your WooCommerce theme has a responsive layout." src="<?php echo $woocommerce->plugin_url() . '/assets/images/help.png'; ?>" height="16" width="16" />
                    </th>
                    <td class="forminp">
                        <fieldset>
                        	<legend class="screen-reader-text"><span>Include media queries for responsive layouts</span></legend>
                    		<label for="quickshop_is_responsive">
                    			<input disabled="disabled" type="checkbox">
                    			Enable support for responsive layouts (Full version)
                            </label>
                            <br>
                    	</fieldset>
                    </td>
                </tr>
                <tr valign="top" class="">
                    <th class="titledesc" scope="row">Styling</th>
                    <td class="forminp">
                        <fieldset>
                        	<legend class="screen-reader-text"><span>Include Quickshop product styles</span></legend>
                    		<label for="quickshop_include_product_styles">
                    			<input type="checkbox" <?php checked( quickshop_get_setting( 'include_product_styles' ) ); ?> value="1" id="quickshop_include_product_styles" name="quickshop_include_product_styles">
                    			Include Quickshop product styles
                            </label>
                            <br />
                    	</fieldset>
                    </td>
                </tr>
            </tbody>
        </table>
        
        <h3>Quickshop Buttons</h3>
        
        <table class="form-table">
            <tbody>
                <tr valign="top" class="">
                    <th class="titledesc" scope="row">Add Buttons</th>
                    <td class="forminp">
                        <fieldset>
                        	<legend class="screen-reader-text"><span>Add Quickshop buttons automatically</span></legend>
                    		<label for="quickshop_add_buttons">
                    			<input type="checkbox" <?php checked( quickshop_get_setting( 'add_buttons' ) ); ?> value="1" id="quickshop_add_buttons" name="quickshop_add_buttons">
                    			Add Quickshop buttons automatically
                            </label>
                            <br />
                    	</fieldset>
                        <div style="margin-top:5px;">
                            <strong>Note</strong>: the <code>do_action( 'woocommerce_after_shop_loop_item' );</code> hook is used to include the Quickshop buttons (more info in the <a href="http://quickshop.bitmakers.co/docs/#compatibility" target="_blank">documentation</a>).
                        </div>
                    </td>
                </tr>
                <tr valign="top">
					<th class="titledesc" scope="row">
						<label for="quickshop_button_text">Button Text</label>
					</th>
                    <td class="forminp">
                    	<input type="text" value="<?php echo quickshop_get_setting( 'button_text', '' ); ?>" style="min-width:280px;" id="quickshop_button_text" name="quickshop_button_text">
                    </td>
                </tr>
                <tr valign="top">
					<th class="titledesc" scope="row">
                    	Position
                        <img class="help_tip" data-tip="Set a position for the Quickshop buttons (overrides the default CSS)." src="<?php echo $woocommerce->plugin_url() . '/assets/images/help.png'; ?>" height="16" width="16" />
                    </th>
                    <td class="forminp">
                    	Top <input type="text" value="<?php echo quickshop_get_setting( 'button_top_position', '' ); ?>" size="3" id="quickshop_button_top_position" name="quickshop_button_top_position">
                    	Left <input type="text" value="<?php echo quickshop_get_setting( 'button_left_position', '' ); ?>" size="3" id="quickshop_button_left_position" name="quickshop_button_left_position">                        
                    </td>
                </tr>
            </tbody>
        </table>
        
        <h3>Modal Window</h3>
        
        <table class="form-table">
            <tbody>
            	<!--<tr valign="top" class="disabled">
                    <th class="titledesc" scope="row">Auto Close</th>
                    <td class="forminp">
                        <fieldset>
                            <legend class="screen-reader-text"><span>Auto Close</span></legend>
                            <label for="quickshop_modal_auto_close">
                            <input type="checkbox" disabled="disabled">
                            Close the modal after a product is added to the cart (Full Version)</label> <br>
                        </fieldset>
                    </td>
                </tr>-->
                <tr valign="top">
					<th class="titledesc" scope="row">
                    	Modal Window Size
                        <img class="help_tip" data-tip="For products with varying height, enter 'auto' in the Height field." src="<?php echo $woocommerce->plugin_url() . '/assets/images/help.png'; ?>" height="16" width="16" />
                    </th>
                    <td class="forminp">
                    	Width <input type="text" value="<?php echo quickshop_get_setting( 'modal_width', '775' ); ?>" size="3" id="quickshop_modal_width" name="quickshop_modal_width">
                    	Height <input type="text" value="<?php echo quickshop_get_setting( 'modal_height', 'auto' ); ?>" size="3" id="quickshop_modal_height" name="quickshop_modal_height">
                    </td>
                </tr>
                <tr valign="top">
					<th scope="row" class="titledesc">
						<label for="quickshop_overlay_color">Overlay Color</label>
					</th>
                    <td class="forminp">
                        <div class="color_box">
                            <strong><img class="help_tip" data-tip="Background color for the overlay behind the modal window." src="<?php echo $woocommerce->plugin_url() . '/assets/images/help.png'; ?>" height="16" width="16" /> Overlay</strong>
                            <input type="text" value="<?php echo quickshop_get_setting( 'overlay_color', '#E9E9E9' ); ?>" id="quickshop_overlay_color" name="quickshop_overlay_color" class="colorpick" style="<?php echo quickshop_get_setting( 'overlay_color', '#E9E9E9' ); ?>"> 
                            <div class="colorpickdiv" id="colorPickerDiv_quickshop_overlay_color" style="display: none;"></div>
                        </div>
                    </td>
                </tr>
                <tr valign="top" class="">
                    <th class="titledesc" scope="row">Overlay Opacity</th>
                    <td class="forminp">
                    	<input type="text" value="<?php echo quickshop_get_setting( 'overlay_opacity', '0.7' ); ?>" size="3" id="quickshop_overlay_opacity" name="quickshop_overlay_opacity"> Set the opacity for the overlay background
                    </td>
                </tr>
                <tr valign="top">
					<th class="titledesc" scope="row">
						<label for="quickshop_preloader_text">Preloader Text</label>
					</th>
                    <td class="forminp">
                    	<input type="text" value="<?php echo quickshop_get_setting( 'preloader_text', 'Loading..' ); ?>" style="min-width:280px;" id="quickshop_preloader_text" name="quickshop_preloader_text">
                    </td>
                </tr>
                <!--<tr valign="top" class="disabled">
					<th class="titledesc" scope="row">
						<label for="quickshop_processing_text">Processing Text</label>
					</th>
                    <td class="forminp">
                    	<input disabled="disabled" type="text" value="Adding to cart.." style="min-width:280px;"> (Full Version)
                    </td>
                </tr>-->
                <tr valign="top" class="disabled">
					<th class="titledesc" scope="row">
                    	<label for="quickshop_product_summary">Product Summary</label>
                        <img class="help_tip" data-tip="Select the product summary content that will display in the modal window." src="<?php echo $woocommerce->plugin_url() . '/assets/images/help.png'; ?>" height="16" width="16" />
                    </th>
                    <td class="forminp">
                    	<select disabled="disabled" class="" style="min-width:150px;" id="quickshop_product_summary" name="quickshop_product_summary">
                            <?php $values = array('Full Description' => 'full', 'Short Description' => 'excerpt'); ?>
							<?php foreach ((array) $values as $key => $value): ?>
                            	<option><?php echo $key; ?></option>
                            <?php endforeach; ?>
                       </select>
                       (Full version)
                    </td>
                </tr>
                <tr valign="top" class="disabled">
					<th class="titledesc" scope="row">
                    	<label for="quickshop_related_products_slider">Related Products Slider</label>
                        <img class="help_tip" data-tip="Display a 'related products' slider carousel below the content." src="<?php echo $woocommerce->plugin_url() . '/assets/images/help.png'; ?>" height="16" width="16" />
                    </th>
                    <td class="forminp">
                    	<select disabled="disabled" style="min-width:150px;" id="quickshop_related_products_slider" name="quickshop_related_products_slider">
                            <?php $values = array('Enable/Loop' => 'loop', 'Enable' => 'true', '(Disable)' => 'false',); ?>
							<?php foreach ((array) $values as $key => $value): ?>
                            	<option><?php echo $key; ?></option>
                            <?php endforeach; ?>
                       </select>
                       (Full version)
                    </td>
                </tr>
            </tbody>
		</table>
        
        <h3>Image Zoom</h3>
        
        <table class="form-table">
            <tbody>
            	<tr valign="top" class="disabled">
                    <th class="titledesc" scope="row">Image Zoom</th>
                    <td class="forminp">
                        <fieldset>
                            <legend class="screen-reader-text"><span>Images Zoom</span></legend>
                            <label for="quickshop_zoom">
                            <input disabled="disabled" type="checkbox">
                            Enable zoom for product images (Full version)</label> <br>
                        </fieldset>
                    </td>
                </tr>
                <tr valign="top" class="disabled">
					<th class="titledesc" scope="row">
                    	<label for="quickshop_product_summary">Type</label>
                        <img class="help_tip" data-tip="Select the zoom type/action" src="<?php echo $woocommerce->plugin_url() . '/assets/images/help.png'; ?>" height="16" width="16" />
                    </th>
                    <td class="forminp">
                    	<select disabled="disabled"  class="" style="min-width:150px;" id="quickshop_zoom_type" name="quickshop_zoom_type">
                            <?php $values = array('Click and hover' => 'click', 'Click and hold' => 'grab'); ?>
							<?php foreach ((array) $values as $key => $value): ?>
                            	<option><?php echo $key; ?></option>
                            <?php endforeach; ?>
                       </select>
                       (Full version)
                    </td>
                </tr>
                <tr valign="top" class="disabled">
					<th class="titledesc" scope="row">
                    	<label for="quickshop_zoom_cursor">Mouse Cursor</label>
                        <img class="help_tip" data-tip="Select which mouse cursor to use when zooming an image." src="<?php echo $woocommerce->plugin_url() . '/assets/images/help.png'; ?>" height="16" width="16" />
                    </th>
                    <td class="forminp">
                    	<select disabled="disabled" class="" style="min-width:150px;" id="quickshop_zoom_cursor" name="quickshop_zoom_cursor">
                            <?php $values = array('Crosshair' => 'crosshair', 'Move' => 'move', 'Default' => 'default', '(None)' => 'none'); ?>
							<?php foreach ((array) $values as $key => $value): ?>
                            	<option><?php echo $key; ?></option>
                            <?php endforeach; ?>
                       </select>
                       (Full version)
                    </td>
                </tr>
            </tbody>
		</table>
        
        <h3>Image Options</h3>
        <p><strong>Note:</strong> the <strong>Lite</strong> version use the default WooCommerce image options from the <a href="<?php echo home_url(); ?>/wp-admin/admin.php?page=woocommerce_settings&tab=catalog">Catalog</a> tab.</p>
        
        <table class="form-table">
        	<tbody>
                <tr valign="top" class="disabled">
                	<th class="titledesc" scope="row">
                    	Product Image
                        <img class="help_tip" data-tip="Image size used by the product image." src="<?php echo $woocommerce->plugin_url() . '/assets/images/help.png'; ?>" height="16" width="16" />
                    </th>
                    <td class="forminp">
                        Width <input disabled="disabled" type="text" size="3">
                        Height <input disabled="disabled" type="text" size="3">
                        <label>Hard Crop <input disabled="disabled" type="checkbox"> &nbsp;(Full version)</label>
                    </td>
                </tr>
                <tr valign="top" class="disabled">
                    <th class="titledesc" scope="row">
                    	Product Thumbnails
                        <img class="help_tip" data-tip="Image size used by the product thumbnail images." src="<?php echo $woocommerce->plugin_url() . '/assets/images/help.png'; ?>" height="16" width="16" />
                    </th>
                    <td class="forminp">
                        Width <input disabled="disabled" type="text" size="3">
                        Height <input disabled="disabled" type="text" size="3">
                        <label>Hard Crop <input disabled="disabled" type="checkbox"> &nbsp;(Full version)</label>
                    </td>
                </tr>
                <tr valign="top" class="disabled">
            		<th class="titledesc" scope="row">
                    	Related Products
                        <img class="help_tip" data-tip="Image size used by the related product images." src="<?php echo $woocommerce->plugin_url() . '/assets/images/help.png'; ?>" height="16" width="16" />
                    </th>
                    <td class="forminp">
                        Width <input disabled="disabled"  type="text" size="3">
                        Height <input disabled="disabled"  type="text" size="3">
                        <label>Hard Crop <input disabled="disabled" type="checkbox"> &nbsp;(Full version)</label>
                    </td>
                </tr>
            </tbody>
        </table>
        
        </div>
        
        </td>
        </tr>
        </table>

        <script type="text/javascript">
        	jQuery(window).load(function(){
				// Color picker
				jQuery('.colorpick').each(function(){
					jQuery('.colorpickdiv', jQuery(this).parent()).farbtastic(this);
					jQuery(this).click(function(){
						if (jQuery(this).val() == "") jQuery(this).val('#');
						jQuery('.colorpickdiv', jQuery(this).parent()).show();
					});
				});
				jQuery(document).mousedown(function(){
					jQuery('.colorpickdiv').hide();
				});
			});
		</script>			
		<?php
	}
	
	
	/**
	 * Remove the settings prefix
	 */
	function remove_prefix($setting) {
		return end( explode( 'quickshop_', $setting ) );
	}
	
	
	/**
	 * Save settings
	 */
	function save_settings_page() {
		if ( ! wp_verify_nonce( $_REQUEST['_wpnonce'], 'woocommerce-settings' ) ) 
			die( __( 'Action failed. Please refresh the page and retry.', 'woocommerce' ) );
		
		$settings = array();
		
		foreach ( $_POST as $key => $value ) {
			if ( !empty( $value ) ) {
				if ( strpos( $key, 'quickshop_' ) !== false ) {
					$key = $this->remove_prefix($key);
					
					$settings[$key] = $value;
				}
			} else {
				$key = $this->remove_prefix($key);
				
				// Set the default setting if the value is empty
				if ($this->defaults[$key]) {
					$settings[$key] = $this->defaults[$key];
				}
			}
		}
		
		update_option( 'quickshop_settings', $settings );
	}
	
}

/**
 * Init quickshop settings class.
 */
$woocommerce_quickshop_settings = new WoocommerceQuickshopLiteSettings();

}