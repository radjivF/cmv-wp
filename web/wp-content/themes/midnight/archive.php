<?php
/**
 * The template for displaying Archive pages.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 */

get_header(); ?>

<div class="bw-container bw-row bw-has-sidebar">
    
    <div class="bw-row bw-page-title"><?php Bw::archive_title('<h1>', '</h1>'); ?></div>
    
    <div class="bw-content">
        
        <?php if ( have_posts() ) : ?>
            
            <div class="bw-blog-wide">
                <?php while ( have_posts() ) : the_post(); ?>
                    <?php get_template_part('templates/article-wide'); ?>
                <?php endwhile; ?>
            </div>
            
            <?php Bw::paging_nav(); ?>
            
        <?php else : ?>
            
            <?php get_template_part( 'templates/content/content', 'none' ); ?>
            
        <?php endif; ?>
        
    </div> <!-- .bw-content -->
    
    <?php get_sidebar(); ?>
    
</div>

<?php get_footer();