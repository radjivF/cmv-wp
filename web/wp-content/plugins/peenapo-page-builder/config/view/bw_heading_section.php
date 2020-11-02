<?php

extract(shortcode_atts(array(
    'title'                     => '',
    'margin_top'                => 0,
    'margin_bottom'             => 0,
    'h'                         => 'h2',
    'text_alignment'            => 'center',
    'text_color'                => 'inherit',
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
$style .= "text-align:{$text_alignment};color:{$text_color};";
$style .= "margin-top:{$margin_top}px;margin-bottom:{$margin_bottom}px;";

// animation title
if( $animation_title and ! wp_is_mobile() ) {
    $class_title .= ' bwpb-waypoint';
    $animation_title_data .= "data-animation='{$animation_title_type}'";
    $animation_title_data .= " data-animation-delay='{$animation_title_delay}'";
}
// animation content
if( $animation_content and ! wp_is_mobile() ) {
    $class_content .= ' bwpb-waypoint';
    $animation_content_data .= "data-animation='{$animation_content_type}'";
    $animation_content_data .= " data-animation-delay='{$animation_content_delay}'";
}

$output  = "<div class='bwpb-heading-section {$class}' style='{$style}'>";
$output .= "<{$h} class='bwpb-heading-title {$class_title}' {$animation_title_data}>{$title}</{$h}>";
$output .= "<div class='bwpb-heading-content {$class_content}' {$animation_content_data}>" . do_shortcode( Bwpb::autop( $content ) ) . '</div>';
$output .= "</div>";

return $output;