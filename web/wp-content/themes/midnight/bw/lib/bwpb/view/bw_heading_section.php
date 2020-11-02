<?php

extract(shortcode_atts(array(
    'title'                     => '',
    'margin_top'                => 0,
    'margin_bottom'             => 0,
    'h'                         => 'h2',
    'text_alignment'            => 'center',
    'text_color'                => '',
    // animation
    'animation_title'           => false,
    'animation_title_type'      => '',
    'animation_title_delay'     => '',
    'animation_content'         => false,
    'animation_content_type'    => '',
    'animation_content_delay'   => '',
    'class'                     => ''
), $atts ));

$style = $animation_title_data = $animation_content_data = $class_title = $class_content = '';
$style .= "text-align:" . esc_attr( $text_alignment ) . ";";
$style .= ! empty( $text_color ) ? "color:" . esc_attr( $text_color ) . ";" : '';
$style .= "margin-top:" . esc_attr( $margin_top ) . "px;margin-bottom:" . esc_attr( $margin_bottom ) . "px;";

// animation title
if( $animation_title and ! wp_is_mobile() ) {
    $class_title .= ' bwpb-waypoint';
    $animation_title_data .= "data-animation='" . esc_attr( $animation_title_type ) . "'";
    $animation_title_data .= " data-animation-delay='" . esc_attr( $animation_title_delay ) . "'";
}
// animation content
if( $animation_content and ! wp_is_mobile() ) {
    $class_content .= ' bwpb-waypoint';
    $animation_content_data .= "data-animation='" . esc_attr( $animation_content_type ) . "'";
    $animation_content_data .= " data-animation-delay='" . esc_attr( $animation_content_delay ) . "'";
}

$output  = "<div class='bwpb-heading-section bw-heading-align-{$text_alignment} " . esc_attr( $class ) . "' style='" . esc_attr( $style ) . "'>";
$output .= $text_alignment == 'center' ? '<div class="bw-table"><span class="bw-cell bwpb-heading-line bw-hl-left"></span>' : '';
$output .= "<" . esc_attr( $h ) . " class='bw-cell bwpb-heading-title {$class_title}' {$animation_title_data}>" . esc_html( $title ) . "</" . esc_attr( $h ) . ">";
$output .= $text_alignment == 'center' ? '<span class="bw-cell bwpb-heading-line bw-hl-right"></span></div>' : '';
$output .= "<div class='bwpb-heading-content {$class_content}' {$animation_content_data}>" . do_shortcode( Bwpb::autop( $content ) ) . '</div>';
$output .= "</div>";

return $output;