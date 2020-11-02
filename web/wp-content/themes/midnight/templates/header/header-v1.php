<?php
$header_class  = '';

$header_class .= Bw::float_option('enable_hv1_borders') ? ' bw-frame-borders' : '';
$header_class .= Bw::float_option('enable_hv1_dark') ? ' bw-dark-header' : '';
$header_class .= Bw::float_option('disable_hv1_nav_borders') ? ' bw-hide-borders' : '';

if( Bw::get_option('enable_top_user_login') and ! is_user_logged_in() ) { get_template_part('templates/modal-profile'); }
?>
<header class="bw-header bw-header-v1<?php echo esc_attr( $header_class ); ?>">
    
    <div class="bw-header-top">
        <div class="bw-row">
            <div class="bw-table">
                <div class="bw-cell bw-part-left bw-no-select">
                    <?php if( Bw::get_option('enable_search') ): ?>
                    <span class="bw-search bw-open-modal" data-modal="bw-search"><?php _e( 'Search', 'midnight' ); ?></span>
                    <?php endif; ?>
                </div>
                <div class="bw-cell bw-part-right">
                    <div class="bw-table">
                        <div class="bw-cell bw-top-menu-holder">
                            <?php if ( has_nav_menu( 'top_secondary' ) ): ?>
                                <?php wp_nav_menu( array( 'theme_location' => 'top_secondary', 'container' => '', 'items_wrap' => '<ul id="%1$s" class="bw-top-menu %2$s">%3$s</ul>' ) ); ?>
                            <?php endif; ?>
                            <ul class="bw-top-menu">
                                <li>
                                    <?php if( Bw::get_option('enable_top_user_login') ): ?>
                                        <?php if( ! is_user_logged_in() ) : ?>
                                            <a href="#" class="bw-open-modal" data-modal="bw-profile">
                                                <?php esc_html_e('Login / Join', 'midnight'); ?>
                                            </a>
                                        <?php else: ?>
                                            <a class="bw-user-top-link" href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>">
                                                <?php global $current_user; ?>
                                                <div class="bw-top-avatar"><?php echo Bw::avatar( 18 ); ?></div>
                                                <div class="bw-top-username"><?php echo esc_html( $current_user->display_name );  ?></div>
                                            </a>
                                            <div class="bw-top-prods-holder">
                                                <div class="bw-top-prods bw-drop-user">
                                                    <div class="bw-drop-user-data">
                                                        <div class="bw-drop-user-avatar">
                                                            <a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>">
                                                                <?php echo Bw::avatar( 96 ); ?>
                                                            </a>
                                                        </div>
                                                        <div class="bw-drop-user-info bw-table">
                                                            <div class="bw-cell">
                                                                <span class="bw-drop-user-name"><strong><?php echo esc_attr( $current_user->display_name); ?></strong><em><?php echo '#' . (int)$current_user->ID; ?></em></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <span class="bw-drop-user-separator"></span>
                                                    <div class="bw-drop-user-nav">
                                                        <a class="<?php if( get_option('woocommerce_myaccount_page_id') == get_the_ID() and ! ( function_exists('edit') and is_wc_endpoint_url( 'edit-account' ) ) ) { echo 'bw-active'; } ?>" href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>"><i class="fa fa-user"></i><?php _e('My account','midnight'); ?></a>
                                                        <?php if ( has_nav_menu( 'my_account' ) ) :
                                                        wp_nav_menu(array(
                                                            'theme_location' => 'my_account',
                                                            'container' => '',
                                                            'depth' => 0,
                                                            'items_wrap' => '<ul id="%1$s" class="bw-menu-user-account-top %2$s">%3$s</ul>'
                                                        ));
                                                        endif; ?>
                                                        <a href="<?php echo wp_logout_url(); ?>"><i class="fa fa-lock"></i><?php _e('Log Out','midnight'); ?></a>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </li>
                            </ul>
                        </div>
                        <?php get_template_part('templates/header/shopping-icons'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php $header_v1_height = Bw::float_option('header_v1_height'); ?>
    <?php $header_height = !empty( $header_v1_height ) ? ' style="min-height:' . (int)$header_v1_height . 'px"' : ''; ?>
    <div class="bw-logo bw-table"<?php echo $header_height; ?>>
        <div class="bw-row bw-cell">
            <?php Bw::logo(); ?>
        </div>
    </div>
    
    <div class="bw-row">
        <?php Bw_megamenu::main_nav(); ?>
    </div>
    
</header>