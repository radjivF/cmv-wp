<?php
$google_login = Bw::get_option('google_login');
$google_id = Bw::get_option('google_id');
?>
<?php if( $google_login and $google_id ): ?>

<div class="bw-social-login bw-social-login-google">
    <?php esc_html_e('Sign in with Google', 'midnight'); ?>
</div>

<?php endif; ?>