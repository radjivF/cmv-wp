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

global $product, $woocommerce_loop;

// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) ) {
	$woocommerce_loop['loop'] = 0;
}

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) ) {
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );
}

// Ensure visibility
if ( ! $product || ! $product->is_visible() ) {
	return;
}

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] ) {
	$classes[] = 'first';
}
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] ) {
	$classes[] = 'last';
}
$classes[] = 'product bw-table';
?>
<li <?php post_class( $classes ); ?>>

	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

	<a class="bw-cell" href="<?php the_permalink(); ?>">

		<?php
			/**
			 * woocommerce_before_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_show_product_loop_sale_flash - 10
			 * @hooked woocommerce_template_loop_product_thumbnail - 10
			 */
			do_action( 'woocommerce_before_shop_loop_item_title' );

			/**
			 * woocommerce_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_template_loop_product_title - 10
			 */
			//do_action( 'woocommerce_shop_loop_item_title' );

			/**
			 * woocommerce_after_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_template_loop_rating - 5
			 * @hooked woocommerce_template_loop_price - 10
			 */
			//do_action( 'woocommerce_after_shop_loop_item_title' );
		?>

	</a>

	<div class="bw-listing-cont bw-cell">
        <?php global $woocommerce, $product; ?>
        <a href="<?php the_permalink(); ?>"><h3><?php the_title(); ?></h3></a>
        <?php echo $product->get_rating_html(); ?>
        <div class="price"><?php echo $product->get_price_html(); ?></div>
        <?php echo the_excerpt(); ?>
        <?php if ( $product->is_in_stock() and $product->is_purchasable() ) : ?>
            <a href="<?php the_permalink(); ?>" data-product_id="<?php echo esc_attr( $product->id ); ?>" class="bw-button add_to_cart_button product_type_simple bw-woo-button-cart<?php echo ( Bw_woo::is_product_in_cart( $product->id ) ? ' added' : '' ); ?>"><?php esc_html_e('Add to cart', 'midnight'); ?></a>
        <?php endif; ?>
        <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
    </div>

</li>
