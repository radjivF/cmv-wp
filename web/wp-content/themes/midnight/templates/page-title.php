
<?php if( function_exists( 'is_cart' ) and ( is_cart() or is_checkout() ) ): ?>
    
    <?php get_template_part('templates/page-title-cart'); ?>
    
<?php else: ?>

    <?php if( ! Bw::get_meta('hide_title') ): ?>
        <?php $sub_title = Bw::get_meta('sub_title'); ?>
        <div class="bw-row bw-page-title">
            <h1><?php the_title(); ?></h1>
            <?php if( ! empty( $sub_title ) ) { echo '<p>' . esc_html( $sub_title ) . '</p>'; } ?>
        </div>
    <?php endif; ?>

<?php endif; ?>