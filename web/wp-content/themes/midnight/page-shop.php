<?php
/**
 * Template Name: Shop page
 */

get_header();

global $bw_page_id;
$bw_page_id = get_the_ID();
$hide_title = Bw::get_meta('hide_title');

$product_category = Bw::get_meta('product_category');
$content_outside = Bw::get_meta('content_outside');

global $wp_query;

$args = array(
    'post_type' => 'product',
    'tax_query' => array(
        array(
            'taxonomy'  => 'product_cat',
            'field'     => 'id', 
            'terms'     => $product_category
        )
    ),
    'paged' => Bw::current_page()
);

// overwrite number of posts based on get parameter.
if( isset( $_GET['bw_num_posts'] ) ) {
    $bw_num_posts = (int)$_GET['bw_num_posts'];
    if( $bw_num_posts > 0 and $bw_num_posts < 100 ) {
        $args['posts_per_page'] = $bw_num_posts;
    }
}

$wp_query = new WP_Query( $args );
setup_postdata( $wp_query );

$shop_class = array();
$cols = '';
$shop_sidebar = $shop_sidebar_left = false;
$shop_cols = 4;

$default_shop_layout = Bw::get_option('shop_default_layout');

// overwrite default layout
$queried_object = get_queried_object();

if( is_object( $queried_object ) ) {
    $archive_shop_layout = get_field('layout', $queried_object);
    if( ! empty( $archive_shop_layout ) and $archive_shop_layout !== 'default' ) { $default_shop_layout = $archive_shop_layout; }
}

// overwrite layout with page template settings.
if( get_post_type() == 'page' ) {
    $page_shop_layout = Bw::get_meta('layout');
    if( ! empty( $page_shop_layout ) and $page_shop_layout !== 'default' ) {
        $default_shop_layout = $page_shop_layout;
    }
}

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

$shop_class[] = 'bw-cols-' . $shop_cols;

if( $shop_sidebar ) { $shop_class[] = 'bw-has-sidebar'; }
if( $shop_sidebar_left ) { $shop_class[] = 'bw-sidebar-left'; }

if( $content_outside and Bw::current_page() < 2 ) {
    $content_page = get_post( (int)$bw_page_id );
    echo !empty( $content_page->post_content ) ? '<div class="bw-content-shop bw-content-shop-out">' . do_shortcode( $content_page->post_content ) . '</div>' : '';
} ?>

<div class="bw-container bw-row <?php echo implode( ' ', $shop_class ); ?>">
    
    <?php if( $shop_sidebar and $shop_sidebar_left ) { get_sidebar('shop'); } ?>
    
    <div class="bw-content bw-content-shop">
        
        <?php if( ! $hide_title ): ?>
        <?php get_template_part( 'templates/page-title' ); ?>
        <?php endif; ?>
        
        <?php $woocommerce_loop['columns'] = $shop_cols; ?>
        
        <?php
            if( ! $content_outside and Bw::current_page() < 2 ) {
                $content_page = get_post( (int)$bw_page_id );
                echo !empty( $content_page->post_content ) ? '<div class="bw-content-shop">' . do_shortcode( $content_page->post_content ) . '</div>' : '';
            }
        ?>
        
        <?php if ( have_posts() ) : ?>

            <?php do_action( 'woocommerce_before_shop_loop' ); ?>

            <?php woocommerce_product_loop_start(); ?>

                <?php woocommerce_product_subcategories(); ?>

                <?php while ( have_posts() ) : the_post(); ?>

                    <?php wc_get_template_part( 'content', 'product' ); ?>

                <?php endwhile; // end of the loop. ?>

            <?php woocommerce_product_loop_end(); ?>

            <?php do_action( 'woocommerce_after_shop_loop' ); ?>

        <?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

            <?php wc_get_template( 'loop/no-products-found.php' ); ?>

        <?php endif; ?>

    <?php wp_reset_postdata(); ?>
        
    </div> <!-- .bw-content -->

    <?php if( $shop_sidebar and ! $shop_sidebar_left ) { get_sidebar('shop'); } ?>
    
</div>

<?php get_footer();