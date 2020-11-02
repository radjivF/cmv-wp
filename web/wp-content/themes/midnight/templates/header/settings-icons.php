<?php if( Bw::get_option('enable_search') ) : ?>
<div class="bw-setting-icon bw-cell bw-open-modal" data-modal="bw-search">
    <i class="fa fa-search"></i>
</div>
<?php endif; ?>
<?php if( Bw::get_option('enable_top_user_login') ): ?>
<div class="bw-setting-icon bw-cell<?php if( ! is_user_logged_in() ) { echo ' bw-open-modal'; } ?>"<?php if( ! is_user_logged_in() ) { echo ' data-modal="bw-profile"'; } ?>>
    <i class="fa <?php echo is_user_logged_in() ? 'fa-gear' : 'fa-unlock'; ?>"></i>
    <?php if( is_user_logged_in() ): ?>
        <div class="bw-top-prods-holder">
            <div class="bw-top-prods bw-drop-user">
                <?php global $current_user; ?>
                <div class="bw-drop-user-data">
                    <div class="bw-drop-user-avatar">
                        <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>">
                            <?php echo Bw::avatar( 96 ); ?>
                        </a>
                    </div>
                    <div class="bw-drop-user-info bw-table">
                        <div class="bw-cell">
                            <span class="bw-drop-user-name"><strong><?php echo esc_html( $current_user->display_name); ?></strong><em><?php echo '#' . (int)$current_user->ID; ?></em></span>
                        </div>
                    </div>
                </div>
                <span class="bw-drop-user-separator"></span>
                <div class="bw-drop-user-nav">
                    <a class="<?php if( get_option('woocommerce_myaccount_page_id') == get_the_ID() and ! ( function_exists( 'is_wc_endpoint_url' ) and is_wc_endpoint_url( 'edit-account' ) ) ) { echo 'bw-active'; } ?>" href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>"><i class="fa fa-user"></i><?php _e('My account','midnight'); ?></a>
                    <?php if ( has_nav_menu( 'my_account' ) ) :
                    wp_nav_menu(array(
                        'theme_location' => 'my_account',
                        'container' => '',
                        'depth' => 0,
                    ));
                    endif; ?>
                    <a href="<?php echo wp_logout_url(); ?>"><i class="fa fa-lock"></i><?php _e('Log Out','midnight'); ?></a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php endif; ?>