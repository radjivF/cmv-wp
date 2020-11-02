<?php
/**
 * Template Name: Journal page
 */

get_header();
$layout = Bw::get_meta('layout');

$blog_class = 'bw-blog-wide';
$blog_element = 'wide';
$get_sidebar = true;

switch( $layout ) {
    case 'list':
        $blog_class = 'bw-blog-list';
        $blog_element = 'list';
        $get_sidebar = false;
        break;
    case 'grid':
        $blog_class = 'bw-blog-grid';
        $blog_element = 'grid';
        $get_sidebar = false;
        break;
}
?>

<div class="bw-container bw-row<?php echo ( $get_sidebar ) ? ' bw-has-sidebar' : ''; ?>">
    <div class="bw-content">
        
        <?php get_template_part( 'templates/page-title' ); ?>
        
        <?php
        while ( have_posts() ) : the_post();
            the_content();
        endwhile;
        wp_reset_query();
        
        $number_of_posts = Bw::get_meta('number_of_posts');
        $query_category = Bw::get_meta('categories');
        if( ! empty( $query_category ) ) {
            $query_tax = array(array(
                'taxonomy' => 'category',
                'field' => 'id',
                'terms' => $query_category
            ));
        }
        
        require( BW_ROOT . 'templates/query-source.php' );
        
        if ( count( $output ) ) {
            
            ob_start();
            echo '<div class="' . $blog_class . '">';
            while ( $output->have_posts() ): $output->the_post();
                get_template_part('templates/article', $blog_element );
            endwhile;
            echo '</div>';
            
            if ( $output->max_num_pages > 1 ) {
                Bw::paging_nav( $output->max_num_pages );
            }
            
            wp_reset_postdata();
            echo ob_get_clean();
            
        }
        
        ?>
        
    </div> <!-- .bw-content -->
    
    <?php $get_sidebar ? get_sidebar() : false; ?>
    
</div>

<?php get_footer();