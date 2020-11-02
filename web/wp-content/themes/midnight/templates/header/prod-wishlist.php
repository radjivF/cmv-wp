<?php global $yith_wcwl; ?>
<?php $yith_page_id = get_option( 'yith_wcwl_wishlist_page_id' ); ?>
<div class="bw-top-prods">
    <?php
        
		$token = is_user_logged_in() ? Bw_woo::$wishlist_token : '';
        $w_items = $yith_wcwl->get_products( array( 'wishlist_token' => $token ) );
        
        if( count( $w_items ) > 0 ) {
            echo '<ul>';
            foreach( array_reverse( $w_items ) as $key => $w_item ) {
                if( $key >= 4 ) { break; }
                $product = wc_get_product( $w_item['prod_id'] );
				
				if( is_object( $product ) ) {
					echo '<li class="bw-table">';
					echo '<div class="bw-cell bw-prod-img"><a class="bw-prod-title" href="' . get_permalink( $w_item['prod_id'] ) . '">';
					if( get_post_thumbnail_id( $w_item['prod_id'] ) ) {
						echo '' . $product->get_image() . '';
					}else{
						echo "<img src='" . Bw::empty_img('70x98') . "' alt=''>";
					}
					echo '</a></div>';
					echo '<div class="bw-cell bw-prod-content">';
					echo '<a class="bw-prod-title" href="' . get_permalink( $w_item['prod_id'] ) . '">' . esc_html( $product->post->post_title ) . '</a>';
					echo '<div class="bw-prod-price">' . $product->get_price_html() . '</div>';
					echo '</div>';
					echo '</li>';
				}
            }
            echo '</ul>';
            if( count( $w_items ) > 4 ) {
                echo '<span class="bw-prod-more">...</span>';
            }
			
			//d($w_items);
			
            if( ! empty( $yith_page_id ) ) {
                echo '<div class="bw-prod-conbox">'.
                    '<a class="bw-prod-button" href="' . get_permalink( $yith_page_id ) . '">' . esc_html__('View wishlist', 'midnight') . '</a>'.
                '</div>';
            }
        }else{
            echo '<p>' . esc_html__('No products in the wishlist', 'midnight') . '</p>';
        }
    ?>
</div>