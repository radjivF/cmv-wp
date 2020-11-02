<?php
/**
 * @package Bad Weather
 */
?>

<?php
$classes = 'bw-single-post';
$post_format = get_post_format();
?>


<article id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>
    
    <?php if( ! $post_format or $post_format == 'image'): ?>
    <div class="bw-image">
        <?php if( has_post_thumbnail() ): ?>
            <?php the_post_thumbnail(); ?>
        <?php endif; ?>
    </div>
    <?php endif ?>
    
    <?php if( $post_format == 'video' ): ?>
    <div class="post-embed <?php if( Bw::get_meta('aspect_ratio') ) { echo 'aspect'; } ?>">
        <?php echo do_shortcode( Bw::get_meta('embed_code') ); ?>
    </div>
    <?php endif; ?>
    
    <?php if( $post_format == 'quote' ): ?>
        <blockquote>
            <?php echo esc_html( Bw::get_meta('quote_content') ); ?>
            <?php if( Bw::get_meta('quote_author') ) { echo '<br><br>— ' . esc_html( Bw::get_meta('quote_author') ); } ?>
        </blockquote>
    <?php endif ?>
    
    <?php if( $post_format == 'link' ): ?>
        <div class="post-link-holder">
            <a class="post-link" href="<?php echo esc_url( Bw::get_meta('link_url') ); ?>" <?php if( Bw::get_meta_checkbox('new_tab') ) { echo 'target="_blank"'; } ?>>
                <?php echo esc_html( Bw::get_meta('link_content') ); ?>
            </a>
        </div>
    <?php endif ?>
    
    <?php if( $post_format == 'gallery' ): ?>
        <?php
        $slider_options = '';
        if(  Bw::get_meta( 'auto_play' ) ) {    $slider_options .= ' data-autoplay'; }
        if(  Bw::get_meta( 'auto_height' ) ) {  $slider_options .= ' data-autoheight'; }
        if( !Bw::get_meta( 'hide_nav' ) ) {     $slider_options .= ' data-navigation'; }
        if( !Bw::get_meta( 'hide_pag' ) ) {     $slider_options .= ' data-pagination'; }
        ?>
        <div class="bw-slider" data-slides="1"<?php echo esc_attr( $slider_options ); ?>>
        <?php
        $gallery_data = Bw::get_meta( 'bw_gallery' );
        if( $gallery_data['ids'] ) {
            foreach( Bw::gallerize_by_id( $gallery_data['ids'], Bw::get_meta( 'auto_height' ) ? 'bw_1120' : 'bw_1120x600_true', true ) as $image ) {
                echo "<div class='bw-item' data-title=''><img src='" . esc_html( $image['thumb'][0] ) . "' alt=''></div>";
            }
        }
        ?>
        </div>
        
    <?php endif ?>
    
    <h2 class="bw-single-post-title"><?php the_title(); ?></h2>
    
    <div class="bw-cats">
        <?php echo get_the_category_list(', '); ?>
    </div>
    
    <?php the_content(); ?>
    
    <?php wp_link_pages(array('before' => '<div class="bw-paged">' . esc_html__( 'Pages:', 'midnight' ),'after' => '</div>')); ?>
        
    <div class="bw-table bw-alts">
        <?php echo get_the_tag_list('<div class="bw-tags bw-cell"><span>' . esc_html__('Tags:', 'midnight') . '</span> ',', ','</div>'); ?>
        <!--div class="bw-share bw-cell">
            <span><?php esc_html_e('Share this:', 'midnight'); ?></span>
            <ul>
                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                <li><a href="#"><i class="fa fa-pinterest"></i></a></li>
                <li><a href="#"><i class="fa fa-behance"></i></a></li>
                <li><a href="#"><i class="fa fa-dribbble"></i></a></li>
            </ul>
        </div-->
    </div>
    
    <?php if( Bw::get_option('single_author') ): ?>
        <?php $author_id = get_the_author_meta( 'ID' ); ?>
        <div class="bw-post-author bw-table">
            <div class="bw-thumb bw-cell">
                <?php echo Bw::avatar( 100, $author_id ); ?>
            </div>
            <div class="bw-cont bw-cell">
                <h4><?php the_author_posts_link(); ?></h4>
                <span><?php echo get_the_author_meta( 'first_name' ) . ' ' . get_the_author_meta( 'last_name' ); ?></span>
                <p><?php echo get_the_author_meta( 'description' ); ?></p>
            </div>
        </div>
    <?php endif ?>
    
    <?php
    $comment_type = Bw::get_option( 'comment_type_blog' );
    if( $comment_type == 'facebook' ) {
        get_template_part( 'templates/comments/facebook' );
    }elseif( $comment_type == 'default' and ( comments_open() || get_comments_number() !== 0 ) ) {
        comments_template();
    }
    ?>
    
</article> <!-- // article -->
