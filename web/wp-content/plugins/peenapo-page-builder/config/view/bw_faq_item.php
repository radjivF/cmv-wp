<?php

extract(shortcode_atts(array(
    'title'         => '',
    'state'         => false,
    'style'         => 'none',
    'color'         => '#aaa',
    'class'         => ''
), $atts ));

$style_icon = '';
$style_icon .= "color:{$color};";
$class .= $state ? ' bwpb-faq-active' : ' ';

switch( $style ) {
    case 'circle':
        $style_icon .= "background-color:{$color};color:#fff;";
        break;
    case 'square':
        $style_icon .= "background-color:{$color};color:#fff;";
        break;
    case 'outlined':
        $style_icon .= "border-color:{$color};";
        break;
}

$output  = "<div class='bwpb-faq-item {$class}'>";
$output .= "<div class='bwpb-faq-title'>{$title}<i class='bwpb-entypo-icon-plus bwpb-faq-icon-{$style}' style='{$style_icon}'></i></div>";
$output .= "<div class='bwpb-faq-content'>";
$output .= do_shortcode( Bwpb::autop( $content ) );
$output .= "</div></div>";

return $output;