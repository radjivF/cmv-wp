<?php
/**
 * The Template for displaying all single posts.
 */

get_header();
$post_layout = Bw::get_meta('post_layout');
if( empty( $post_layout ) ) { $post_layout = 'sidebar'; }
$post_class = array();
if( $post_layout == 'sidebar' ) {
    $post_class[] = 'bw-has-sidebar';
}elseif( $post_layout == 'sidebar_left' ) {
    $post_class[] = 'bw-has-sidebar';
    $post_class[] = 'bw-sidebar-left';
}

?>

<div class="bw-container bw-row <?php echo implode(' ', $post_class ); ?>">
    
    <?php echo ( $post_layout == 'sidebar_left' ) ? get_sidebar() : ''; ?>
    
    <div class="bw-content">
        
        <?php while ( have_posts() ) : the_post(); ?>
            
            <?php get_template_part( 'templates/content/content', str_replace('bw_pt_', '', get_post_type() ) ); ?>

        <?php endwhile; ?>
        
    </div> <!-- .bw-content -->
    
    <?php echo ( $post_layout == 'sidebar' ) ? get_sidebar() : ''; ?>
    
</div>

<?php get_footer(); ?>