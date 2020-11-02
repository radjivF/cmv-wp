<?php

$hclass = array();
$header_dark = Bw::float_option('enable_hv2_dark');
$header_sticky = Bw::float_option('sticky_header');

if( Bw::get_option('enable_top_user_login') and ! is_user_logged_in() ) { get_template_part('templates/modal-profile'); }

if( $header_sticky ) { // STICKY header - allows BOTTOM header
    
    $hclass[] = 'bw-is-sticky';
    
    if( Bw::get_meta('overwrite_header_layout') ) {
        $header_bottom = Bw::get_meta('header_hv2_on_bottom');
        if( $header_bottom ) {
            $hclass[] = 'bw-is-bottom';
        }
    }
    
}else{ // STATIC header - allow TRANSPARENT header
    
    if( Bw::get_meta('overwrite_header_layout') ) {
        $header_transparent = Bw::get_meta('header_hv2_transparent');
        if( $header_transparent ) {
            $hclass[] = 'bw-is-transparent';
            if( Bw::get_meta('header_hv2_on_trans_page_dark_color') ) {
                $hclass[] = 'bw-is-header-color-dark';
            }
            $header_dark = false;
        }
    }
    
}

if( $header_dark ) {
    $hclass[] = 'bw-dark-header';
}

?>
<header class="bw-header bw-header-v2 <?php echo implode( ' ', $hclass ); ?>">
    
    <div class="bw-table">
    
        <div class="bw-logo bw-cell">
            <?php Bw::logo(); ?>
        </div>
        
        <?php Bw_megamenu::main_nav(); ?>
        
        <div class="bw-top-settings bw-cell" style="<?php echo esc_attr( Bw::top_settings_style() ); ?>">
            <div class="bw-table">
                <?php get_template_part('templates/header/settings-icons'); ?>
                <?php get_template_part('templates/header/shopping-icons'); ?>
            </div>
        </div>
    
    </div>
    
</header>