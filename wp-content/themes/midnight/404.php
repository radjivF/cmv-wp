<?php
/**
 * The template for displaying 404 pages (Not Found).
 * @package Bad Weather
 */

get_header(); ?>

<div class="bw-container bw-row">
    <div class="bw-content">
        <article class="bw-page-content">
            
            <div class="bw-404">
                
                <div class="bw-404-image"><img src="<?php echo BW_URI_ASSETS; ?>img/404.png"></div>
                
                <h2><?php esc_html_e('THIS IS NOT THE WEB PAGE YOU ARE LOOKING FOR', 'midnight'); ?></h2>
                
                <div class="bw-table">
                    <div class="bw-cell">
                        <?php esc_html_e('Please try one of the following pages', 'midnight'); ?>
                    </div>
                    <div class="bw-cell">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="bw-button"><?php esc_html_e('Home page', 'midnight'); ?></a>
                    </div>
                </div>
            
                <?php get_search_form(); ?>
                
            </div>
            
        </article> <!-- .bw-content -->
    </div> <!-- .bw-content -->
    
</div>

<?php get_footer();