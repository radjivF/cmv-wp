<?php
$fb_login = Bw::get_option('facebook_login');
$fb_app_id = Bw::get_option('facebook_id');
?>
<?php if( $fb_login and $fb_app_id ) : ?>

<div class="bw-social-login bw-social-login-facebook">
    <?php esc_html_e('Sign in with Facebook', 'midnight'); ?>
</div>

<div id="fb-root"></div>

<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId      : <?php echo esc_js( $fb_app_id ); ?>,
            status     : true,
            cookie     : true,
            xfbml      : true,
            version    : 'v2.5'
        });
    };
    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<?php endif;