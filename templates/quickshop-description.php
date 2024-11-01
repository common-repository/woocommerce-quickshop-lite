<?php
/**
 * Quickshop - Product Description
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post;
?>
<div class="product_description">	
	<?php echo wpautop( $post->post_content ); ?>
</div>