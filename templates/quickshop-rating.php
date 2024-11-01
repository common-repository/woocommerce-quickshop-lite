<?php
/**
 * Quickshop - Star Rating
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if ( get_option( 'woocommerce_enable_review_rating' ) == 'no' )
	return;
?>

<?php if ( $average_rating > 0 ) : ?>

    <div class="qs_rating">
    
        <div itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating" class="star-rating" title="<?php echo sprintf(__( 'Rated %d out of 5', 'woocommerce' ), $average_rating); ?>">
            <span style="width:<?php echo ( $average_rating / 5 ) * 100; ?>%">
            	<span itemprop="ratingValue"><?php echo $average_rating; ?></span>
				<?php _e( 'out of 5', 'woocommerce' ); ?>
            </span>
        </div>
        
        <span itemprop="ratingCount" class="count">(<?php echo $count; ?> ratings)</span>

    </div>

<?php endif; ?>