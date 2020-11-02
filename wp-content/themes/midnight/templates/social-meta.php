<?php
$google_login = Bw::get_option('google_login');
$google_id = Bw::get_option('google_id');
?>

<?php if( $google_login && $google_id ): ?>
    <meta name="google-signin-clientid" content="<?php echo esc_attr( $google_id ); ?>" />
    <meta name="google-signin-scope" content="https://www.googleapis.com/auth/plus.login" />
    <meta name="google-signin-requestvisibleactions" content="http://schema.org/AddAction" />
    <meta name="google-signin-cookiepolicy" content="single_host_origin" />
<?php endif ?>

<?php if( is_single() && ! is_singular('property') && have_posts() ) { 
    $fb_post_id = get_the_ID();
    $fb_post_image = wp_get_attachment_image_src( get_post_thumbnail_id( $fb_post_id ), 'single-post-thumbnail' );
    $fb_post_excerpt = get_the_excerpt();
    $fb_post_title = get_the_title(); ?>
    <meta property="og:url" content="<?php the_permalink(); ?>" />
    <meta property="og:title" content="<?php echo esc_attr($fb_post_title); ?>" />
    <meta property="og:description" content="<?php echo esc_attr($fb_post_excerpt); ?>" />
    <meta property="og:image" content="<?php echo esc_url($fb_post_image[0]); ?>" />
<?php } else if(is_singular('property') && have_posts()) {
    $fb_post_id = get_the_ID();
    $fb_post_title = get_the_title();
    $fb_gallery = get_post_meta($fb_post_id, 'property_gallery', true);
    $fb_images = explode("~~~", $fb_gallery);
    ?>
    <meta property="og:url" content="<?php the_permalink(); ?>" />
    <meta property="og:title" content="<?php echo esc_attr($fb_post_title); ?>" />
    <meta property="og:description" content="<?php echo esc_attr($fb_post_title); ?>" />
    <meta property="og:image" content="<?php echo esc_url($fb_images[1]); ?>" />
<?php }