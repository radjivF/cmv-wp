<?php

extract(shortcode_atts(array(
    'items_per_row'     => 1,
    'text_color'        => '#222',
    'text_alignment'    => 'left',
    'decoration'        => '',
    'decoration_color'  => '',
    'class'             => '',
    // animation
    'animation'         => false,
    'animation_type'    => 'fadeIn',
    'animation_delay'   => 0,
), $atts));

$uid = 'bwpb-ulist-id-' . uniqid();

$style = $custom_css = $animation_data = '';

$w_item = 100;
switch( $items_per_row ) {
    case 2: $w_item = 50;       break;
    case 3: $w_item = 33.3332;  break;
    case 4: $w_item = 25;       break;
    case 5: $w_item = 20;       break;
    case 6: $w_item = 16.6665;  break;
}

$decoration_color = $decoration_color ? $decoration_color : $text_color;
$custom_css .= "<style>#{$uid} li {width:{$w_item}%} #{$uid} li .before {background-color:{$decoration_color}}</style>";

$style .= "text-align:{$text_alignment};color:{$text_color}";

$class .= " bwpb-ul-style{$decoration}";

// animation title
if( $animation and ! wp_is_mobile() ) {
    $class .= ' bwpb-waypoint-seq-wrap';
    $animation_data .= "data-animation='{$animation_type}'";
    $animation_data .= " data-animation-delay='{$animation_delay}'";
}

return "{$custom_css}<ul id='{$uid}' class='bwpb-unordered-list-wrapper {$class}' style='{$style}' {$animation_data}>
    " . do_shortcode( Bwpb::autop( $content ) ) . "
</ul>";