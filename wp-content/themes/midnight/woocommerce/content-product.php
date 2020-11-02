<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$default_shop_layout = Bw::get_option('shop_default_layout');

// overwrite default layout
$queried_object = get_queried_object();
if( is_object( $queried_object ) and ! is_shop() ) {
    $archive_shop_layout = get_field('layout', $queried_object);
    if( ! empty( $archive_shop_layout ) and $archive_shop_layout !== 'default' ) { $default_shop_layout = $archive_shop_layout; }
}

// overwrite layout with page template settings.
global $bw_page_id;
if( $bw_page_id ) {
    $page_shop_layout = Bw::get_meta('layout', $bw_page_id);
    if( ! empty( $page_shop_layout ) and $page_shop_layout !== 'default' ) {
        $default_shop_layout = $page_shop_layout;
    }
}

$product_layout = ( ( $default_shop_layout == 'boxed_list_right_sidebar' or $default_shop_layout == 'boxed_list_left_sidebar' ) and ( is_shop() or is_product_category() ) ) ? 'product-list' : 'product-standard';
wc_get_template_part( 'content', $product_layout );