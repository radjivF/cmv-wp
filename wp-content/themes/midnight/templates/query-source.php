<?php
$query_post_type = isset( $query_post_type ) ? $query_post_type : 'post';
$query_tax = isset( $query_tax ) ? $query_tax : array();
$number_of_posts = isset( $number_of_posts ) ? (int)$number_of_posts : get_option('posts_per_page');
$query_require_img = isset( $query_require_img ) ? $query_require_img : false;
$query_offset = ( isset( $number_of_posts ) and Bw::current_page() > 1 ) ? ( ( Bw::current_page() - 1 ) * $number_of_posts ) : 0;

$post_args = array(
    'posts_per_page'        => $number_of_posts,
    'post_type'             => $query_post_type,
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
                'key' => 'bw_featured_post',
                'value' => '1',
                'compare' => '='
            )
        );
        break;
    
    case 'latest':
        /** Return the latest posts only */
        $post_args['order'] = 'DESC';
        $post_args['orderby'] = 'date';
        break;
    
    case 'latest_by_cat':
        /** Return posts from selected categories */
        $post_args['category'] = $category;
        break;
        
    case 'latest_by_format':
        /** Return posts with the selected post format */
        $terms = array();
        if (!isset($post_args['tax_query'])) {
            $post_args['tax_query'] = array();
        }
        foreach ( array_filter( explode( ',', $post_format ) ) as $key => $format ) {
            if ( $format == 'standard' ) {
                //if we need to include the standard post formats
                //then we need to include the posts that don't have a post format set
                $all_post_formats = get_theme_support('post-formats');
                if (!empty($all_post_formats[0]) && count($all_post_formats[0])) {
                    $allterms = array();
                    foreach ($all_post_formats[0] as $format2) {
                        $allterms[] = 'post-format-'.$format2;
                    }
                    
                    $post_args['tax_query']['relation'] = 'AND';
                    $post_args['tax_query'][] = array(
                        'taxonomy' => 'post_format',
                        'terms' => $allterms,
                        'field' => 'slug',
                        'operator' => 'NOT IN'
                    );
                }
            }else{
                $terms[] = 'post-format-' . $format;
            }
        }
        
        if ( ! empty( $terms ) ) {
            $post_args['tax_query'][] = array(
                'taxonomy' => 'post_format',
                'field' => 'slug',
                'terms' => $terms,
                'operator' => 'IN'
            );
        }
        break;

    case 'latest_by_reviews':
        $post_args['meta_query'] = array(
            'relation' => 'AND',
            array(
                'key' => 'enable_post_review',
                'value' => '1',
                'compare' => '='
            )
        );
        break;
        
endswitch;
endif;

if( $query_require_img ) {
    $post_args['meta_query'][] = array(
        'key' => '_thumbnail_id',
        'compare' => 'EXISTS'
    );
}

global $post;

$output = new WP_Query( $post_args );