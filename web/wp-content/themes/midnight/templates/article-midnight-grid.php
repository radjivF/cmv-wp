<?php $img = has_post_thumbnail() ? Bw::get_image_src('bw_375x370_true') : Bw::empty_img('375x370'); ?>
<?php $class = ' class="' . ( ( $c ) % 3 == 0 ? 'bw-first"' : '' ) . ( ( $c + 1 ) % 3 == 0 ? 'bw-last"' : '' ) . '"'; ?>
<article style="background-image:url(<?php echo esc_url( $img ); ?>);"<?php echo $class; ?>>
    <a href="<?php the_permalink(); ?>">
        <span class="bw-overflow"></span>
        <span class="bw-shadow"></span>
        <div class="bw-swapping">
            <div class="bw-info"><span class="bw-date"><?php echo get_the_date(); ?></span></div>
            <h4><?php the_title(); ?></h4>
            <div class="bw-excerpt"><?php echo Bw::truncate( get_the_excerpt(), 18 ); ?></div>
            <div class="bw-more"><?php esc_html_e('Read more', 'midnight');  ?></div>
        </div>
    </a>
</article> <!-- .article -->