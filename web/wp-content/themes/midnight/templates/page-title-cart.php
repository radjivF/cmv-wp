<div class="bw-cart-title">
    <ul>
        <li <?php if( is_cart() or is_checkout() ) { echo 'class="bw-active"'; } ?>>
            <span>01</span>
            <h5><?php esc_html_e('Shopping cart', 'midnight'); ?></h5>
        </li>
        <li <?php if( is_checkout() ) { echo 'class="bw-active"'; } ?>>
            <span>02</span>
            <h5><?php esc_html_e('Check out', 'midnight'); ?></h5>
        </li>
        
        <li <?php if( is_wc_endpoint_url("order-received") ) { echo 'class="bw-active"'; } ?>>
            <span>03</span>
            <h5><?php esc_html_e('Order complete', 'midnight'); ?></h5>
        </li>
    </ul>
</div>

<?php if( is_wc_endpoint_url("order-received") ): ?>
    
    <div class="bw-order-received">
        <img src="<?php echo BW_URI_ASSETS; ?>img/order-received.png" alt="">
        <h2><?php esc_html_e('Thanks you for shopping with us, your order is complete!', 'midnight'); ?></h2>
        <a class="bw-button bw-button-light" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e('Home page', 'midnight'); ?></a>
        <a class="bw-button" href="<?php echo get_permalink( woocommerce_get_page_id( 'shop' ) ); ?>"><?php esc_html_e('Continue shopping', 'midnight'); ?></a>
    </div>
    
<?php endif; ?>