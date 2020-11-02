<div class="bw-hm">
    <div class="bw-hm-top">
        <?php if( Bw::get_option('enable_top_user_login') ): ?>
        <?php global $current_user; ?>
        <a class="bw-hm-user" href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>">
            <?php if( is_user_logged_in() ): ?><div class="bw-hm-avatar"><?php echo Bw::avatar( 22 ); ?></div><?php endif; ?>
            <div class="bw-hm-username"><?php echo is_user_logged_in() ? esc_html( $current_user->display_name ) : 'Login / Register';  ?></div>
        </a>
        <?php endif; ?>
        <i class="bw-hm-search-icon fa fa-search"></i>
        <div class="bw-hm-search"><?php get_search_form(); ?></div>
    </div>
    <div class="bw-hm-main bw-table">
        <div class="bw-cell">
            <?php $logo_mobile = Bw::get_option( 'logo_mobile' ); ?>
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="bw-hm-logo">
                <?php
                if( ! empty( $logo_mobile ) ) {
                    echo '<img src="' . esc_url( $logo_mobile ) . '" alt="">';
                }else{
                    echo '<h3>' . get_bloginfo( 'name' ) . '</h3>';
                }
                ?>
            </a>
        </div>
        <div class="bw-hm-icons">
            <?php $woo_active = Bw_woo::woo_active_plugin(); ?>
            <?php if( $woo_active and Bw_woo::wishlist_active_plugin() ): ?>
                <?php global $yith_wcwl; ?>
                <?php $yith_page_id = get_option( 'yith_wcwl_wishlist_page_id' ); ?>
                <a href="<?php echo ! empty( $yith_page_id ) ? get_permalink( $yith_page_id ) : '#'; ?>">
                    <i class="bw-hm-icon bw-hm-icon-wish"><img src="<?php echo BW_URI_ASSETS . 'img/wishlist_black.png'; ?>" alt=""></i>
                </a>
            <?php endif; ?>
            <?php if( $woo_active ): ?>
                <a href="<?php echo WC()->cart->get_cart_url(); ?>">
                    <i class="bw-hm-icon bw-hm-icon-cart"><img src="<?php echo BW_URI_ASSETS . 'img/cart_black.png'; ?>" alt=""></i>
                </a>
            <?php endif; ?>
            <i class="bw-hm-icon bw-hm-icon-menu"><img src="<?php echo BW_URI_ASSETS . 'img/menu_black.png'; ?>" alt=""></i>
        </div>
    </div>
    <div class="bw-hm-nav">
        <?php if( has_nav_menu( 'mobile' ) ): ?>
            <?php wp_nav_menu( array( 'theme_location' => 'mobile', 'container' => '', 'items_wrap' => '<ul id="%1$s" class="bw-mobile-menu %2$s">%3$s</ul>' ) ); ?>
        <?php else: ?>
            <?php esc_html_e('Please select mobile menu.', 'midnight'); ?>
        <?php endif; ?>
    </div>
</div>