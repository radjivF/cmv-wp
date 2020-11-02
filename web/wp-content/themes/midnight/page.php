<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 */

get_header();

get_template_part('templates/scroller'); ?>

<div class="bw-container <?php echo esc_attr( Bw::container_class() ); ?>">
    
    <div class="bw-content">
        
        <?php while ( have_posts() ) : the_post(); ?>
            <?php get_template_part('templates/content-page'); ?>
        <?php endwhile; ?>
        
    </div> <!-- .bw-content -->
    
    <?php $page_layout = Bw::get_meta('page_layout'); ?>
    <?php if( ! ( $page_layout == 'full' or empty( $page_layout ) ) and ! Bw::bwpb_active() ) { get_sidebar(); } ?>
    
</div>

<?php get_footer();