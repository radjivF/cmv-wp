<!DOCTYPE html>
<html <?php language_attributes(); ?>> 
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php get_template_part('templates/social-meta');
/**
 * Wordpress Head. This is REQUIRED! Never remove the wp_head
 */
wp_head(); ?>

</head>

<?php
$bclass  = 'bw-body-header-' . esc_attr( Bw::$hver );
$bclass .= Bw::float_option('enable_hv1_dark') ? ' bw-body-header-dark' : '';
$bclass .= Bw::get_meta('overlap_header') ? ' bw-overlap-header' : '';
$bclass .= Bw::get_option('shop_img_zoom') ? ' bw-image-zoom-enabled' : '';
?>
<body <?php body_class( Bw::body_class( $bclass ) ); ?>>

<div class="bw-wrapper">

<div id="bw-modal-bg"></div>
<div id="bw-modal-quick-look" class="bw-modal"></div>
<?php
get_template_part( 'templates/modal-newsletter' );
if( Bw::get_option('enable_search') ) {
    get_template_part( 'templates/modal-search' );
}
get_template_part( 'templates/header/header', esc_attr( Bw::$hver ) );
get_template_part( 'templates/header/header-mobile' );
get_template_part( 'templates/header/breadcrumb' );
