<?php
/**
 * The template for displaying the footer.
 * Contains the closing of the .bw-wrapper div and all content after
 */
?>
<?php if( is_active_sidebar( 'footer_1' ) or is_active_sidebar( 'footer_2' ) or is_active_sidebar( 'footer_3' ) or is_active_sidebar( 'footer_4' )): ?>
    <div class="bw-footer bw-row bw-table">
        <div class="bw-col bw-cell">
            <?php if ( is_active_sidebar( 'footer_1' ) ) :  ?>
                <?php dynamic_sidebar( 'footer_1' ); ?>
            <?php endif; ?>
        </div>
        <div class="bw-col bw-cell">
            <?php if ( is_active_sidebar( 'footer_2' ) ) :  ?>
                <?php dynamic_sidebar( 'footer_2' ); ?>
            <?php endif; ?>
        </div>
        <div class="bw-col bw-cell">
            <?php if ( is_active_sidebar( 'footer_3' ) ) :  ?>
                <?php dynamic_sidebar( 'footer_3' ); ?>
            <?php endif; ?>
        </div>
        <div class="bw-col bw-cell">
            <?php if ( is_active_sidebar( 'footer_4' ) ) :  ?>
                <?php dynamic_sidebar( 'footer_4' ); ?>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>

<div class="bw-footer-copy bw-row">
    <?php if ( has_nav_menu( 'footer' ) ): ?>
        <?php wp_nav_menu( array( 'theme_location' => 'footer' ) ); ?>
    <?php endif; ?>
    <?php $footer_copy = Bw::get_option('footer_copy'); ?>
    <?php if( $footer_copy ): ?>
        <p><?php echo Bw::kses( $footer_copy ); // escape html except some tags like strong, a ?></p>
    <?php endif; ?>
</div>

</div> <!-- .bw-wrapper -->

<?php wp_footer(); ?>

</body>
</html>