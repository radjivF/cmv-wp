<div id="bw-profile" class="bw-modal bw-modal-profile">
    
    <div class="bw-modal-logo">
        <?php $login_logo = Bw::get_option('login_logo'); ?>
        <?php if( ! empty( $login_logo ) ): ?>
            <img src="<?php echo esc_url( $login_logo ); ?>" alt="">
        <?php else: ?>
            <h3><?php bloginfo( 'name' ); ?></h3>
        <?php endif; ?>
    </div>
    
    <?php if ( get_option('users_can_register') ) : ?>
    <div class="bw-modal-title bw-align-center">
        <a href="#" data-action="login" class="bw-form-trigger bw-active"><?php esc_html_e('Log In', 'login-with-ajax'); ?></a>
        <a href="#" data-action="register" class="bw-form-trigger"><?php esc_html_e('Register','login-with-ajax') ?></a>
    </div>
    <?php endif; ?>
    
    <?php
        /* facebook */
        $fb_login = Bw::get_option('facebook_login');
        $fb_app_id = Bw::get_option('facebook_id');
        
        /* google plus */
        $google_login = Bw::get_option('google_login');
        $google_id = Bw::get_option('google_id');
    ?>
    
    <?php if( ( $fb_login and $fb_app_id ) or ( $google_login and $google_id ) ): ?>
    
        <?php get_template_part('templates/social-facebook-login'); ?>
        <?php get_template_part('templates/social-google-login'); ?>
        <?php wp_nonce_field('signin_ajax_nonce', 'securitySignin', true); ?>
        <span class="bw-social-separator"><em><?php esc_html_e('Or', 'midnight'); ?></em></span>
    
    <?php endif; ?>
    
    <?php if( function_exists( 'login_with_ajax' ) ) { login_with_ajax(); }else{ esc_html_e('Login with Ajax Plugin is required.','midnight'); } ?>

    <span class="bw-modal-close"></span>
    
</div>