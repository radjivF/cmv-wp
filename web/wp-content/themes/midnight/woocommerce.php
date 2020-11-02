<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 */

get_header();

$shop_class = array();
$cols = '';
$shop_sidebar = $shop_sidebar_left = false;
$shop_cols = 4;

$default_shop_layout = Bw::get_option('shop_default_layout');

// overwrite default layout
$queried_object = get_queried_object();
if( is_object( $queried_object ) and ! is_shop() ) {
    $archive_shop_layout = get_field('layout', $queried_object);
    if( ! empty( $archive_shop_layout ) and $archive_shop_layout !== 'default' ) { $default_shop_layout = $archive_shop_layout; }
}

if( ! is_product() ) {
    switch( $default_shop_layout ) {
        case 'boxed_4_cols':
            break;
        case 'boxed_3_cols_right_sidebar':
            $shop_cols = 3;
            $shop_sidebar = true;
            break;
        case 'boxed_3_cols_left_sidebar':
            $shop_cols = 3;
            $shop_sidebar = true;
            $shop_sidebar_left = true;
            break;
        case 'boxed_3_cols':
            $shop_cols = 3;
            break;
        case 'boxed_2_cols_right_sidebar':
            $shop_cols = 2;
            $shop_sidebar = true;
            break;
        case 'boxed_2_cols_left_sidebar':
            $shop_cols = 2;
            $shop_sidebar = true;
            $shop_sidebar_left = true;
            break;
        case 'boxed_list_right_sidebar':
            $shop_cols = 1;
            $shop_sidebar = true;
            $shop_class[] = 'bw-product-listing';
            break;
        case 'boxed_list_left_sidebar':
            $shop_cols = 1;
            $shop_sidebar = true;
            $shop_sidebar_left = true;
            $shop_class[] = 'bw-product-listing';
            break;
        case 'full_6_cols':
            $shop_cols = 6;
            $shop_class[] = 'bw-fullwidth';
            break;
        default: // boxed_4_cols
            $shop_cols = 4;
    }
}

$shop_class[] = 'bw-cols-' . $shop_cols;

if( $shop_sidebar and ! is_product() ) { $shop_class[] = 'bw-has-sidebar'; }
if( $shop_sidebar_left and ! is_product() ) { $shop_class[] = 'bw-sidebar-left'; }

global $per_page, $wp_query;
$per_page = 500;

?>

<div class="bw-container <?php echo ( class_exists( 'Bwpb' ) and Bwpb::bw_check_status() ) ? '' : 'bw-row '; echo implode( ' ', $shop_class ); ?>">
    
    <?php if( $shop_sidebar and $shop_sidebar_left and ! is_product() ) { get_sidebar('shop'); } ?>
    
    <div class="bw-content bw-content-shop">
        <?php $woocommerce_loop['columns'] = $shop_cols; ?>
        <?php woocommerce_content(); ?>
    </div> <!-- .bw-content -->

    <?php if( $shop_sidebar and ! $shop_sidebar_left and ! is_product() ) { get_sidebar('shop'); } ?>
    
</div>

<?php get_footer();