<?php

$atts = shortcode_atts(array(
    'items_per_row' => 3,
    'items_total'   => 8,
    'post_type'     => 'post',
    'layout'        => 'grid',
    'enable_cat'    => false,
    'enable_pag'    => false,
    'gap'           => 0,
    'left_right_space' => 0,
    'spec_cat'      => '',
    'class'         => ''
), $atts);

global $wp_query, $paged, $page;
$temp = $wp_query;

// discover current page number
$paged = Bwpb::current_page();

$post_types = array(
    'post' => array(
        'type'      => 'post',
        'taxonomy'  => 'category'
    ),
    /*'product' => array(
        'type'      => 'product',
        'taxonomy'  => 'product_cat'
    ),
    'portfolio' => array(
        'type'      => 'bw_pt_portfolio',
        'taxonomy'  => 'bw_tx_portfolio'
    ),
    'gallery' => array(
        'type'      => 'bw_pt_gallery',
        'taxonomy'  => 'bw_tx_gallery'
    ),*/
);

ob_start();

$spec_categories = ! empty( $atts['spec_cat'] ) ? explode( ',', $atts['spec_cat'] ) : array();

$q_post_type = isset( $post_types[$atts['post_type']]['type'] ) ? array( 'post_type' => $post_types[$atts['post_type']]['type'] ) : array( 'post_type' => 'post' );

$q_post_type['posts_per_page'] = $atts['items_total'];
$q_post_type['ignore_sticky_posts'] = 1;
$q_post_type['paged'] = max( $paged, $page );

$q_tax = ( ! empty( $atts['spec_cat'] ) and isset( $post_types[$atts['post_type']]['taxonomy'] ) ) ? array(
    'tax_query' => array(
        'relation' => 'AND',
        array(
            'taxonomy' => $post_types[$atts['post_type']]['taxonomy'],
            'field'    => 'slug',
            'terms'    => $spec_categories,
            'operator' => 'IN'
        )
    )
) : array();

$wp_query = new WP_Query( array_merge( $q_post_type, $q_tax ) );

echo "<div class='bwpb-grid-holder' style='padding:0 {$atts['left_right_space']}px;'>";

// filter
if ( $atts['enable_cat'] and $wp_query->have_posts() ) : ?>
    <div class="bwpb-grid-filter">
        <li class="active"><?php _e( 'All', PBTD ); ?></li>
        <?php $all_categories = isset( $post_types[$atts['post_type']]['taxonomy'] ) ? get_terms( $post_types[$atts['post_type']]['taxonomy'], array(
            'hide_empty' => false,
        ) ) : array();

        foreach( $all_categories as $category) : ?>
        <?php if( empty( $atts['spec_cat'] ) or in_array( $category->slug, $spec_categories ) ): ?>
        <li data-filter="bwpb-filter-<?php echo $category->slug; ?>"><?php echo $category->name; ?></li>
        <?php endif; ?>
        <?php endforeach; ?>
    </div>
<?php endif;

$grid_class  = '';
$grid_class .= $atts['layout'] == 'grid' ? 'bwpb-auto-adjust-image' : '';

echo "<div class='bwpb-section-load-more'>";
echo "<div class='bwpb-grid bwpb-grid-layout-{$atts['layout']} bwpb-section-append bwpb-grid-col-{$atts['items_per_row']} {$grid_class}' style='margin-right:-{$atts['gap']}px;'>";

if ( $wp_query->have_posts() ) {
    while ($wp_query->have_posts()) {
        $wp_query->the_post();
        Bwpb::include_template( "front/latest-posts-{$atts['layout']}", array( 'bwpb_gap' => $atts['gap'] ) );
    }
}

echo "</div>";

// pagination / load more
if( $atts['enable_pag'] and $wp_query->have_posts() ) :
    $next_link = get_next_posts_link();
    $next_url  = '';
    if (!empty($next_link)) {
        preg_match_all('/href="([^\s"]+)/', $next_link, $match);
        $next_url = $match[1][0];
    }
    if ( ! empty($next_url)) : ?>
        <div class="bwpb-grid-load-more">
            <div class="bwpb-load-more">
                <a href="<?php echo $next_url; ?>" class="bwpb-load-more-btn">
                    <i class="fa fa-refresh"></i>
                    <span class="bwpb-load-more-label"><?php _e('Load More', PBTD); ?></span>
                </a>
            </div>
        </div><?php
    endif;
endif;

echo "</div>";
echo "</div>";

$wp_query = $temp; wp_reset_postdata();

return ob_get_clean();