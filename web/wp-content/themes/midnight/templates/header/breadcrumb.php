<?php

if( is_front_page() ) { return; }

// global
$breadcrumb = Bw::get_option( 'breadcrumb' );
if( empty( $breadcrumb ) ) { $breadcrumb == 'enabled'; }

// post overwrite
$meta_breadcrumb = Bw::get_meta( 'breadcrumb' );
if( ! empty( $meta_breadcrumb ) and $meta_breadcrumb !== 'default' ) { $breadcrumb = $meta_breadcrumb; }
echo '<div class="bw-breadcrumb-holder">';

if( Bw::float_option('header_hv2_transparent') or Bw::float_option('header_hv3_transparent') ) {
    $breadcrumb = 'disabled';
}

if( $breadcrumb == 'enabled' ) {
if( ! ( Bw::$hver == 'v3' and Bw::get_option('header_hv3_transparent') and Bw::get_option('header_hv3_on_trans_page') == get_the_ID() ) ) { ?>
    
    <?php
    $brc_enable = Bw::get_meta('brc_enable_background_image');
    $brc_img = Bw::get_meta('brc_background_image');
    $brc_color = Bw::get_meta('brc_color');
    $brc_title = Bw::get_meta('brc_title');
    $brc_class = $brc_style = $brc_data = '';
    if( $brc_enable ) { $brc_class .= ' bw-image-enabled'; }
    if( ! empty( $brc_color ) ) { $brc_class .= ' bw-color-inherit'; $brc_style .= 'color:' . esc_attr( $brc_color ) . ';'; }
    if( ! empty( $brc_img ) ) { $brc_data .= ' data-bg_img="' . esc_url( Bw::get_image_attachment('bw_1920x1080_true', $brc_img) ) . '"'; }
    ?>
    
    <?php if( Bw::$hver == 'v1' ) { echo '<div class="bw-row">'; } ?>
        <div class="bw-breadcrumb<?php echo esc_attr( $brc_class ); ?>" style="<?php echo esc_attr( $brc_style ); ?>"<?php echo $brc_data; ?>>
            <?php if( ! empty( $brc_img ) ) { echo '<span class="brc-bg-image"></span>'; } ?>
            <?php if( $brc_enable and $brc_title ) { echo '<h2>' . get_the_title() . '</h2>'; } ?>
            <?php Bw::the_breadcrumb(); ?>
        </div>
    <?php if( Bw::$hver == 'v1' ) { echo '</div>'; } ?>
    
<?php }}
echo '</div>';