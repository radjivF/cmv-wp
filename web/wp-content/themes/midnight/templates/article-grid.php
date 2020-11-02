<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    
    <a class="bw-image" href="<?php the_permalink(); ?>">
    <?php if( has_post_thumbnail() ) : ?>
        <?php echo '<span class="bw-over"></span>'; ?>
        <?php the_post_thumbnail('bw_570x400_true'); ?>
    <?php else: ?>
        <?php echo "<img src='" . esc_url( Bw::empty_img('570x400') ) . "' alt=''>"; ?>
    <?php endif; ?>
    </a>
    
    <div class="bw-cont">
        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <div class="bw-cats"><?php echo get_the_category_list(''); ?></div>
        <div class="bw-excerpt"><?php echo Bw::truncate( get_the_excerpt(), 18 ); ?></div>
        <div class="bw-more"><a href="<?php the_permalink(); ?>"><?php esc_html_e('Read more', 'midnight');  ?></a></div>
    </div>
    
</article> <!-- .article -->