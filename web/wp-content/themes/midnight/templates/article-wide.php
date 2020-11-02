<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php if( has_post_thumbnail() ) : ?>
    <a class="bw-image" href="<?php the_permalink(); ?>">
        <?php echo '<span class="bw-over"></span>'; ?>
        <?php the_post_thumbnail('bw_832x480_true'); ?>
    </a>
    <?php endif; ?>
    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
    <div class="bw-cats"><?php echo get_the_category_list(''); ?></div>
    <div class="bw-excerpt"><?php the_excerpt(); ?></div>
    <div class="bw-more"><a href="<?php the_permalink(); ?>"><?php esc_html_e('Read more', 'midnight');  ?></a></div>
</article> <!-- .article -->