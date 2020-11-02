<?php
/**
 * Product loop sale flash
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post, $product;

?>
<?php if ( $product->is_on_sale() ) : ?>

	<?php echo apply_filters( 'woocommerce_sale_flash', '<span class="onsale bw-no-pointer">' . esc_html__( 'Sale', 'woocommerce' ) . '</span>', $post, $product ); ?>

<?php else: ?>
    
    <?php if( Bw::get_meta('is_new') ) { echo '<span class="onsale bw-isnew bw-no-pointer">' . esc_html__( 'New', 'midnight' ) . '</span>'; } ?>
    
<?php endif; ?>