<?php

$col_params = array(
    'col_width'         => '100',
    'reveal_scrolling'  => false,
    'pt'                => 0,
    'pr'                => 0,
    'pb'                => 0,
    'pl'                => 0,
    'align_vertically'  => false,
    'text_alignment'    => 'inherit',
    'class'             => ''
);
extract(shortcode_atts( array_merge( $col_params, Bwpb_front::get_animation_data() ), $atts ));

$style  = '';

// animation
$animation_data = '';
if( $animation and ! wp_is_mobile() ) {
    $class .= ' bwpb-waypoint';
    $animation_data .= "data-animation='{$animation_type}'";
    $animation_data .= " data-animation-delay='{$animation_delay}'";
}

$class .= $reveal_scrolling ? ' reveal-scrolling' : '';
$class .= $align_vertically ? ' bwpb-vertical-col-align' : '';

$style .= 'padding:'.
    $pt . ( substr( $pt , -1 ) !== '%' ? 'px' : '' )." ".
    $pr . ( substr( $pr , -1 ) !== '%' ? 'px' : '' )." ".
    $pb . ( substr( $pb , -1 ) !== '%' ? 'px' : '' )." ".
    $pl . ( substr( $pl , -1 ) !== '%' ? 'px' : '' ).';';

$colw = (int)$col_width;
switch( true ) {
    case $colw > 0 and $colw <= 20:
        $class .= ' bwpb-colwidth-1'; break;
    case $colw > 20 and $colw <= 50:
        $class .= ' bwpb-colwidth-2'; break;
    case $colw > 50 and $colw <= 75:
        $class .= ' bwpb-colwidth-3'; break;
    case $colw > 75 and $colw <= 100:
        $class .= ' bwpb-colwidth-4'; break;
}

$style .= "text-align:{$text_alignment};";
$style .= "width:{$col_width}%;";

$output  = "<div class='bwpb-column {$class}' style='{$style}' {$animation_data}><div class='bwpb-column-inner'><div class='bwpb-table-cell'>";
$output .= do_shortcode( $content );
$output .= "</div></div></div>";

return $output;