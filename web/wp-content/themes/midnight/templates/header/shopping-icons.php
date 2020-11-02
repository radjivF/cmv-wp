<?php $woo_active = Bw_woo::woo_active_plugin(); ?>
<?php if( $woo_active and Bw_woo::wishlist_active_plugin() ): ?>
    <?php global $yith_wcwl; ?>
    <?php $yith_page_id = get_option( 'yith_wcwl_wishlist_page_id' ); ?>
    <div class="bw-setting-icon bw-cell bw-wishlist">
        <a href="<?php echo ! empty( $yith_page_id ) ? get_permalink( $yith_page_id ) : '#'; ?>">
            <?php $yith_wcwl_count_products = $yith_wcwl->count_products(); ?>
            <?php if( (int)$yith_wcwl_count_products > 0 ): ?><sub class="bw-round animated"><?php echo (int)$yith_wcwl_count_products; ?></sub><?php endif; ?>
        </a>
        <img src="<?php echo BW_URI_ASSETS . 'img/wishlist_' . Bw::iwish() . '.png'; ?>" alt="">
        <div class="bw-top-prods-holder bw-top-prods-wishlist">
            <?php get_template_part('templates/header/prod-wishlist'); ?>
        </div>
    </div>
<?php endif; ?>

<?php if( $woo_active ): ?>
    <div class="bw-setting-icon bw-cell bw-shopcart">
        <a class="cart-contents" href="<?php echo WC()->cart->get_cart_url(); ?>">
            <?php $cart_contents_count = WC()->cart->cart_contents_count; ?>
            <?php if( (int)$cart_contents_count > 0 ): ?><sub class="bw-round animated"><?php echo (int)$cart_contents_count; ?></sub><?php endif; ?>
        </a>
        <img src="<?php echo BW_URI_ASSETS . 'img/cart_' . Bw::icart() . '.png'; ?>" alt="">
        <div class="bw-top-prods-holder bw-top-prods-cart">
            <div class="bw-top-prods">
                <?php get_template_part( 'templates/header/cart' ); ?>
            </div>
        </div>
    </div>
<?php endif; ?>