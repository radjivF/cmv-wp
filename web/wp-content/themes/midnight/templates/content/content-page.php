<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Bad Weather
 */

$page_layout = Bw::get_meta('page_layout');

?>

<article <?php post_class( 'page-content' ); ?>>
    
    <?php
    echo '<div class="section' . ( ( class_exists( 'Bwpb' ) and Bwpb::bw_check_status() and $page_layout == 'sidebar' ) ? ' bw-row' : '' ) . '">';
        echo '<div class="column_contnr collumn ' . ( $page_layout == 'sidebar' ? 'left_parent' : '' ) . '">'; echo ( $page_layout == 'sidebar' ) ? '<div class="ver_separator"></div>' : '';
            the_content();
            wp_link_pages(array('before' => '<div class="bw-paged">' . esc_html__( 'Pages:', 'midnight' ),'after' => '</div>'));
        echo '</div>';
        if( $page_layout == 'sidebar' ) { get_sidebar(); }
    echo '</div>';
    ?>
    
</article>