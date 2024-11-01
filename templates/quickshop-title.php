<?php
/**
 * Quickshop - Single Product Title
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post;
?>
<h1 itemprop="name" class="product_title entry-title"><?php echo $post->post_title; ?></h1>