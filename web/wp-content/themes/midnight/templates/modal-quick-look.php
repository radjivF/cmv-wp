<div class="bw-ql bw-table woocommerce">
<?php
$query_product = new WP_Query( array( 'post_type' => 'product', 'p' => (int)$_POST['prod_id'] ) );
if( $query_product->have_posts() ) {
    while ( $query_product->have_posts() ) { $query_product->the_post();
        global $product; ?>
        <div class="bw-ql-col bw-ql-col-left bw-cell">
            <?php do_action( 'bw_quick_look_image' ); ?>
        </div>
        <div class="bw-ql-col bw-ql-col-right bw-cell bw-product-type<?php echo ' bw-product-type-' . esc_attr( $product->product_type ); echo Bw_woo::is_product_in_cart( (int)$_POST['prod_id'] ) ? ' bw-product-is-in-cart' : '' ; ?>" data-type="<?php echo esc_attr( $product->product_type ); ?>">
            <h1 class="product_title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
            <?php do_action( 'bw_quick_look_content' ); ?>
        </div><?php
    }
    wp_reset_postdata();
}else{
    echo '<p>' . esc_html__('The product was not found', 'midnight') . '</p>';
}
?>
</div>
<span class="bw-modal-close"></span>