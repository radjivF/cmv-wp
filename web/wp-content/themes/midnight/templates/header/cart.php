<?php
/**
 * Cart Page
 *
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 2.3.8
 */
?>

<div class="shop_table cart">
    <ul>
        <?php
        $cart_k = 0;
        $cart_all = WC()->cart->get_cart();
        foreach( array_reverse( $cart_all ) as $cart_item_key => $cart_item ) {
            
            if( $cart_k >= 4 ) { break; }
            
            $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
            $product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

            if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
                ?>
                <li class="bw-table">
                    
                    <?php $thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key ); ?>
                    <div class="bw-cell bw-prod-img">
                        <a href="<?php echo get_permalink( $product_id ); ?>">
                        <?php
                            if( get_post_thumbnail_id( $product_id ) ) {
                                echo $thumbnail;
                            }else{
                                echo "<img src='" . Bw::empty_img('70x98') . "' alt=''>";
                            }
                        ?>
                        </a>
                    </div>
                    
                    <div class="bw-cell bw-prod-content">
                        
                        <?php
                            if ( ! $_product->is_visible() ) {
                                echo apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key ) . '&nbsp;';
                            } else {
                                echo apply_filters( 'woocommerce_cart_item_name', sprintf( '<a class="bw-prod-title" href="%s">%s </a>', esc_url( $_product->get_permalink( $cart_item ) ), $_product->get_title() ), $cart_item, $cart_item_key );
                            }
                        ?>

                        <div class="bw-prod-price">
                            <?php
                                echo $_product->get_price_html();
                            ?>
                        </div>

                        <div class="bw-prod-quantity">
                            <?php
                                $product_quantity = $_product->is_sold_individually() ? 1 : $cart_item['quantity'];
                                echo apply_filters( 'woocommerce_cart_item_quantity', esc_html__( 'qty: ', 'midnight' ) . sprintf( '%02d', $product_quantity ), $cart_item_key, $cart_item );
                                echo ' - ' . apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
                            ?>
                        </div>
                        
                    </div>
                <li>
                <?php
            }
            $cart_k++;
        }
        ?>
    </ul>
    
    <?php
    
    if( count( $cart_all ) <= 0 ) {
        echo '<p>' . esc_html__('No products in the cart', 'midnight') . '</p>';
    }
    
    if( count( $cart_all ) > 4 ) {
        echo '<span class="bw-prod-more">...</span>';
    }
    
    if( count( $cart_all ) > 0 ) {
        global $woocommerce;
        echo '<div class="bw-prod-subtotal">' . esc_html__('Subtotal:', 'midnight') . '<span>' . WC()->cart->get_cart_total() . '</span></div>';
        echo '<div class="bw-prod-conbox bw-prod-conbox-bottom">'.
            '<a class="bw-prod-button bw-prodb-half" href="' . esc_url( $woocommerce->cart->get_cart_url() ) . '">' . esc_html__('View cart', 'midnight') . '</a>'.
            '<a class="bw-prod-button bw-prodb-half bw-prodb-last bw-prodb-focus" href="' . esc_url( $woocommerce->cart->get_checkout_url() ) . '">' . esc_html__('Check out', 'midnight') . '</a>'.
        '</div>';
    }
    ?>

</div>



