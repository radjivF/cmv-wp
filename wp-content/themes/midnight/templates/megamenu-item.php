<?php
if( has_post_thumbnail() ) {
    $image = Bw::get_image_src( 'bw_300x200_true' );
}else{
    $image = BW_URI_ASSETS . 'img/empty/300x200.png';
}

if ( $image ) {
    $menu_post_image  = '<div class="article-thumb">';
    $menu_post_image .= '<div class="image-hide"><div class="image-wrap"><img src="' . esc_url( $image ) . '" alt=""></div></div>';
    $menu_post_image .= '</div>';
} else {
    $menu_post_image = '';
}
?>
<div class="item one-fourth bw-item-article">
    <article class="article">
        <a href="<?php the_permalink(); ?>">
            <?php echo $menu_post_image; ?>
            <div class="article-content">
                <h2 class="article-title">
                    <span><?php echo Bw::truncate( get_the_title(), 8 ); ?></span>
                </h2>
            </div>
        </a>
    </article>
</div>