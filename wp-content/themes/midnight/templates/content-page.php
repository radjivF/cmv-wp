<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Bad Weather
 */

$class = 'bw-page-content';
?>
<article <?php post_class( $class ); ?>>
    
    <?php if( ! Bw::get_meta('hide_title') ): ?>
    <?php get_template_part( 'templates/page-title' ); ?>
    <?php endif; ?>
    
    <?php the_content(); ?>
    
    <?php
    $comment_type = Bw::get_option( 'comment_type_page' );
    if( empty( $comment_type ) ) { $comment_type = 'default'; }
    if( $comment_type == 'facebook' ) {
        get_template_part( 'templates/comments/facebook' );
    }elseif( $comment_type == 'default' and ( comments_open() || get_comments_number() !== 0 ) ) {
        comments_template();
    }
    ?>

</article>