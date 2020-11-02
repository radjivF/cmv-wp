<?php
//$is_account_page = function_exists( 'is_account_page' ) ? is_account_page() : false;
//if( ! isset( $_COOKIE['bw_newsletter'] ) or ! Bw::get_option('newsletter_once') or $is_account_page ) {
    $nsl = Bw::get_option('newsletter');
    if( $nsl and ! wp_is_mobile() ) {
        $nsl_page = Bw::get_option('newsletter_page');
        //if( $nsl_page == get_the_ID() or $is_account_page ) : ?>
            <?php
            $nsl_once = Bw::get_option('newsletter_once');
            $nsl_bg = Bw::get_option('newsletter_bg');
            $nsl_content = Bw::get_option('newsletter_content');
            $nls_style  = '';
            $nls_style .= ! empty( $nsl_bg ) ? 'background-image:url(' . esc_url( $nsl_bg ) . ');' : '';
            $nsl_trigger = ! ( $nsl_page > 0 and $nsl_page == get_the_ID() ) ? ' bw-dont-trigger' : '';
            ?>
            <div id="bw-nsl" class="bw-modal<?php echo $nsl_trigger; ?>" style="<?php echo $nls_style; ?>">
                <?php echo do_shortcode( Bw::get_option( 'newsletter_content' ) ); ?>
                <span class="bw-modal-close"></span>
            </div>
        <?php //endif;
    }
//}