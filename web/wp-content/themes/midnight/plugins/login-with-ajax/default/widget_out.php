<div class="lwa lwa-default">
    
    <form class="lwa-form bw-form bw-form-login bw-form-active" action="<?php echo esc_attr( LoginWithAjax::$url_login ); ?>" method="post">
        <input class="bw-form-input bw-form-input-username" type="text" name="log" placeholder="<?php esc_html_e( 'Username', 'login-with-ajax' ); ?>">
        <input class="bw-form-input" type="password" name="pwd" placeholder="<?php esc_html_e( 'Password', 'login-with-ajax' ) ?>">
        <?php do_action('login_form'); ?>
        <span class="lwa-status"></span>
        <div class="bw-align-center">
            <input type="submit" name="wp-submit" class="lwa_wp-submit bw-submit" value="<?php esc_html_e('Log In', 'login-with-ajax'); ?>" tabindex="100" />
            <input type="hidden" name="lwa_profile_link" value="<?php echo esc_attr( $lwa_data['profile_link'] ); ?>" />
            <input type="hidden" name="login-with-ajax" value="login" />
        </div>
        
        <div class="bw-extra bw-align-center">
            <?php if( ! empty( $lwa_data['remember'] ) ): ?>
            <a href="#" data-action="password" class="lwa-links-remember bw-form-trigger" title="<?php esc_html_e('Lost your passwordddd?','login-with-ajax')?>">
                <?php esc_html_e('Lost your password?','login-with-ajax') ?>
            </a>
            <?php endif; ?>
        </div>
    </form>
    <?php if( get_option('users_can_register') && ! empty( $lwa_data['registration'] ) ): ?>
        <form class="lwa-register-form bw-form bw-form-register" action="<?php echo esc_attr( LoginWithAjax::$url_register ); ?>" method="post">
            <input type="text" name="user_login" class="bw-form-input user_login input" placeholder="<?php esc_html_e( 'Username', 'login-with-ajax' ); ?>">
            <input type="text" name="user_email" class="bw-form-input user_email input" placeholder="<?php esc_html_e( 'E-mail', 'login-with-ajax' ); ?>">
            <?php do_action('register_form'); ?>
            <?php do_action('lwa_register_form'); ?>
        
            <span class="lwa-status"></span>
            <div class="bw-align-center">
                <input type="submit" name="wp-submit" class="wp-submitbutton-primary bw-submit" value="<?php esc_html_e('Register', 'login-with-ajax'); ?>" tabindex="100" />
                <input type="hidden" name="login-with-ajax" value="register" />
            </div>

            <div class="bw-extra bw-align-center"><?php esc_html_e('A password will be e-mailed to you.','login-with-ajax'); ?></div>
        </form>
    <?php endif; ?>

    <?php if( ! empty( $lwa_data['remember'] ) ): ?>
    <form class="lwa-remember bw-form bw-form-password" action="<?php echo esc_attr( LoginWithAjax::$url_remember ) ?>" method="post">
        <input type="text" name="user_login" class="lwa-user-remember bw-form-input" placeholder="<?php esc_html_e( 'Enter username or email', 'login-with-ajax' ) ?>">
        <?php do_action('lostpassword_form'); ?>
        <span class="lwa-status"></span>

        <div class="bw-align-center">
            <input type="submit" value="<?php esc_html_e("Get New Password", 'login-with-ajax'); ?>" class="lwa-button-remember bw-submit" />
            <input type="hidden" name="login-with-ajax" value="remember" />
        </div>
    </form>
    <?php endif; ?>
</div>
