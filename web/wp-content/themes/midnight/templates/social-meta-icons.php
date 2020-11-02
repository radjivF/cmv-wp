<?php

echo '<div class="bw-table bw-share-meta"><div class="bw-cell bw-wish-cell">';

global $product;
if( class_exists('BW_YITH') ) {
    BW_YITH::add_to_wishlist_button( get_permalink(), $product->product_type, $product->exists );
}

echo '</div> <!-- bw-cell -->';

$enable_facebook_sharing = Bw::get_option('enable_facebook_sharing');
$enable_twitter_sharing = Bw::get_option('enable_twitter_sharing');
$enable_google_sharing = Bw::get_option('enable_google_sharing');
$enable_tumblr_sharing = Bw::get_option('enable_tumblr_sharing');
$enable_digg_sharing = Bw::get_option('enable_digg_sharing');
$enable_delicious_sharing = Bw::get_option('enable_delicious_sharing');

if( $enable_facebook_sharing or $enable_twitter_sharing or $enable_google_sharing or $enable_tumblr_sharing or $enable_digg_sharing or $enable_delicious_sharing ) {
    
    echo '<div class="bw-cell bw-share-cell">';
    echo '<span>';esc_html_e( 'Share with: ', 'midnight' );echo '</span>';

    $share_link = get_permalink( get_the_ID() );
    $share_title = get_the_title( get_the_ID() );

    if( $enable_facebook_sharing ) {
        $share_href_f = esc_url( 'http://www.facebook.com/share.php?u=' . $share_link . '&title=' . $share_title );
        echo '<a class="bw-add-share" href="' . $share_href_f . '"><i class="fa fa-facebook"></i></a>';
    }

    if( $enable_twitter_sharing ) {
        $share_href_t = esc_url( 'http://twitter.com/intent/tweet?status=' . $share_title . '+' . $share_link );
        echo '<a class="bw-add-share" href="' . $share_href_t . '"><i class="fa fa-twitter"></i></a>';
    }

    if( $enable_google_sharing ) {
        $share_href_g = esc_url( 'https://plus.google.com/share?url=' . $share_link );
        echo '<a class="bw-add-share" href="' . $share_href_g . '"><i class="fa fa-google-plus"></i></a>';
    }

    if( $enable_tumblr_sharing ) {
        $share_href_tb = esc_url( 'http://www.tumblr.com/share?v=3&u=' . $share_link . '&t=' . $share_title );
        echo '<a class="bw-add-share" href="' . $share_href_tb . '"><i class="fa fa-tumblr"></i></a>';
    }

    if( $enable_digg_sharing ) {
        $share_href_dg = esc_url( 'https://digg.com/submit?url=' . $share_link . '&title=' . $share_title );
        echo '<a class="bw-add-share" href="' . $share_href_dg . '"><i class="fa fa-digg"></i></a>';
    }

    if( $enable_delicious_sharing ) {
        $share_href_d = esc_url( 'http://del.icio.us/post?url=' . $share_link . '&title=' . $share_title );
        echo '<a class="bw-add-share" href="' . $share_href_d . '"><i class="fa fa-delicious"></i></a>';
    }

    echo '</div>';

}

echo '</div> <!-- bw-share-meta -->';