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
    
    <a class="bwpb-grid-image" href="<?php the_permalink(); ?>">
        <?php if( has_post_thumbnail() ): ?>
            <?php the_post_thumbnail('large'); ?>
        <?php else: ?>
            <img src="<?php echo Bwpb::empty_img('1024x1024'); ?>" alt="">
        <?php endif; ?>
    </a>
    
    <a class="overlay" href="<?php the_permalink(); ?>" style="right:<?php echo $bwpb_gap; ?>px;">
        <div class="bwpb-table">
            <div class="bwpb-table-cell">
                <h4><?php the_title(); ?></h4>
                <div class="wall-cat">
                    <?php
                        $categories = get_the_category();
                        $separator = ' ';
                        $output = '';
                        if( $categories ) {
                            foreach( $categories as $category ) {
                                $output .= '<span>'.$category->cat_name.'</span>'.$separator;
                            }
                            echo trim($output, $separator);
                        }
                    ?>
                </div>
                <span class="wall-separator"></span>
            </div>
        </div>
    </a>
    
</article>