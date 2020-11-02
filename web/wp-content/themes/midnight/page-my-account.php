<?php
/*
Template name: My Account Sidebar
This templates add My account to the sidebar. 
*/

get_header(); 
?>

<div class="bw-container bw-container-account bw-row<?php echo is_user_logged_in() ? ' bw-has-sidebar' : ' bw-container-join'; ?>">
    
    <?php if( is_user_logged_in() ) { ?>

        <div class="bw-sidebar bw-account-used-sidebar">
            
            <div class="bw-account-user">
                <?php
                    global $current_user;
                    $current_user = wp_get_current_user();
                    echo Bw::avatar( 100 );
                ?>
                <?php if( ! empty( $current_user->user_firstname ) or ! empty( $current_user->user_lastname ) ): ?><h2 class="bw-user-name"><?php echo esc_attr( $current_user->user_firstname ) . ' ' . esc_attr( $current_user->user_lastname ); ?></h2><?php endif; ?>
                <span class="bw-user-nickname"><?php echo esc_attr( $current_user->display_name ); ?> <em><?php echo '#' . (int)$current_user->ID; ?></em></span>
                <span class="bw-logout-link"><a href="<?php echo wp_logout_url(); ?>"><?php _e('Log Out','woocommerce'); ?></a></span>
            </div>
            
            <div class="bw-account-nav">
                <?php if ( has_nav_menu( 'my_account' ) ) : ?>
                    <a class="<?php if( get_option('woocommerce_myaccount_page_id') == get_the_ID() and ! is_wc_endpoint_url( 'edit-account' ) ) { echo 'bw-active'; } ?>" href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>"><i class="fa fa-user"></i><?php _e('My account','midnight'); ?></a>
                    <?php
                        wp_nav_menu(array(
                            'theme_location' => 'my_account',
                            'depth' => 0,
                        ));
                    ?>
                    <a href="<?php echo wp_logout_url(); ?>"><i class="fa fa-lock"></i><?php _e('Log Out','midnight'); ?></a>
                <?php else: ?>
                    <p><?php esc_html__('Define your <b>My Account<b> navigation in <b>Appearance > Menus</b>.', 'peenapo'); ?></p>
                <?php endif; ?>
            </div><!-- .account-nav -->
            
        </div><!-- .row .vertical-tabs -->

    <?php } ?>
    
    <div class="bw-content bw-account-content">
        
        <?php if( has_excerpt() and ! is_user_logged_in() ) { ?>
        <div class="bw-page-excerpt">
            <?php the_excerpt(); ?>
        </div>
        <?php } ?>
        
        <?php while ( have_posts() ) : the_post(); ?>
            <?php if( is_user_logged_in() ): ?><h1 class="bw-title-inner"><?php the_title(); ?></h1><?php endif; ?>
            <?php the_content(); ?>
        <?php endwhile; ?>
        
    </div> <!-- .bw-content -->

</div> <!-- .bw-container -->

<?php get_footer();
