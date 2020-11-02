<?php
$filter_class = '';

$taxs = array(
    'post' => 'category',
    'product' => 'product_cat',
    'bw_pt_portfolio' => 'bw_tx_portfolio',
    'bw_pt_gallery' => 'bw_tx_gallery'
);

$post_type = get_post_type();

foreach( get_the_terms( get_the_ID(), $taxs[$post_type] ) as $category ) {
    $filter_class .= 'bwpb-filter-' . $category->slug . ' ';
}
?>

<article class="bwpb-grid-item <?php echo $filter_class; ?>" style='padding-right:<?php echo $bwpb_gap; ?>px;margin-bottom:<?php echo $bwpb_gap; ?>px;'>
    
    <?php if( has_post_thumbnail() ): ?>
        <a href="<?php the_permalink(); ?>">
            <?php the_post_thumbnail('large'); ?>
        </a>
    <?php endif; ?>
    
    <div class="summary">
        <?php
        $day = get_the_date('d');
        $month = get_the_date('M');
        if( $day and $month ) : ?>
            <div class="date">
                <?php echo $day; ?>
                <span><?php echo $month; ?></span>
            </div>
        <?php endif; ?>
        <div class="text <?php if( $day and $month ) { echo 'no-date'; } ?>">
            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <?php echo get_the_category_list(', '); ?>
        </div>
        <div class="excerpt">
            <?php echo wp_trim_words( get_the_excerpt(), 20, '..' ); ?>
        </div>
        <a class="read-more" href="<?php the_permalink(); ?>"><?php _e('Read More', PBTD); ?></a>
    </div>
    
</article>