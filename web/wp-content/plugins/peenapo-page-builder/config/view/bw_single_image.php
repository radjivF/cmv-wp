<?php

extract(shortcode_atts(array(
    'image'         => '',
    'size'          => 'thumbnail',
    'alignment'     => 'left',
    'style'         => 'none',
    'function'      => 'none',
    'new_tab'       => false,
    'class'         => '',
), $atts));

$image_id = Bwpb::get_image_id_from_url( $image );

$css = '';
switch( $style ) {
    case 'border':
        $css .= 'border:2px solid #eee;';
        break;
    case 'rounded':
        $css .= 'border-radius:4px;-moz-border-radius:4px;-webkit-border-radius:4px;';
        break;
    case 'circle':
        $css .= 'border-radius:50%;-moz-border-radius:50%;-webkit-border-radius:50%;';
        break;
}

$target = $new_tab ? 'target="_blank"' : '';

$output  = "<div class='{$class}' style='text-align:{$alignment};'>";
$output .= $function == 'link' ? "<a href='" . esc_url( $content ) . "' {$target}>" : '';
if( $function == 'lightbox' ) {
    $lightbox_img_data = wp_get_attachment_image_src( $image_id, 'bw_1920x1080' );
}
$output .= ( $function == 'lightbox' && isset( $lightbox_img_data[0] ) ) ? "<a class='bwpb-mp-item' href='" . $lightbox_img_data[0] . "'>" : '';
$output .= wp_get_attachment_image( $image_id, $size, false, array( 'style' => $css ) );
$output .= $function == 'link' ? "</a>" : '';
$output .= $function == 'lightbox' ? "</a>" : '';
$output .= "</div>";

return $output;