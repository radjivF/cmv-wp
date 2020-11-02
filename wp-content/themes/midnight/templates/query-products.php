<?php
$query_post_type = isset( $query_post_type ) ? $query_post_type : 'post';
$category = isset( $category ) ? $category : '';
$query_tax = isset( $query_tax ) ? $query_tax : array();
$number_of_posts = isset( $number_of_posts ) ? $number_of_posts : get_option('posts_per_page');
$query_require_img = isset( $query_require_img ) ? $query_require_img : false;
$query_offset = ( isset( $number_of_posts ) and Bw::current_page() > 1 ) ? ( ( Bw::current_page() - 1 ) * $number_of_posts ) : 0;

$post_args = array(
    'post_type'             => 'product',
    'posts_per_page'        => $number_of_posts,
    'offset'		        => $query_offset,
    'post_status'           => 'publish',
    'ignore_sticky_posts'   => true,
    'meta_query' 	        => array(),
    'tax_query'             => $query_tax
);

if( isset( $source ) ):
switch ( $source ):
    case 'featured':
        /** In this case return only posts marked as featured */
        $post_args['meta_query'] = array(
            'relation' => 'AND',
            array(
                'key' => '_featured',
                'value' => 'yes',
                'compare' => '='
            )
        );
        break;
    case 'best_sellers':
        $post_args['meta_key'] = 'total_sales';
        $post_args['orderby'] = 'meta_value_num';
        break;
    case 'sale':
        $post_args['meta_query'] = array(
            'relation' => 'AND',
            array(
                'key' => '_sale_price',
                'value' => 0,
                'compare' => '>'
            )
        );
        break;
    case 'new_badge':
        $post_args['meta_query'] = array(
            'relation' => 'AND',
            array(
                'key' => 'is_new',
                'value' => '1',
                'compare' => '='
            )
        );
        break;
    case 'latest' :
        $post_args['order'] = 'DESC';
        $post_args['orderby'] = 'date';
        break;
    case 'latest_by_cat' :
        $post_args['tax_query'] = array(
            array(
                'taxonomy'  => 'product_cat',
                'field'     => 'id', 
                'terms'     => array_filter( explode(',', $category) )
            )
        );
        break;
    case 'top_rating' :
        if( class_exists( 'WC_Query' ) ) {
            $wc_query = new WC_Query();
            add_filter( 'posts_clauses', array( $wc_query, 'order_by_rating_post_clauses' ) );
        }
        break;
        
endswitch;
endif;

if( $query_require_img ) {
    $post_args['meta_query'][] = array(
        'key' => '_thumbnail_id',
        'compare' => 'EXISTS'
    );
}

if( isset( $quary_raw ) ) {
    $post_args = array_merge( $post_args, $quary_raw );
}

global $post;

$output = new WP_Query( $post_args );