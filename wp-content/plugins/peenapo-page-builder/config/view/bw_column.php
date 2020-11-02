<?php
$col_params = array(
    'col_width'             => '100',
    'pt'                    => 0,
    'pr'                    => 0,
    'pb'                    => 0,
    'pl'                    => 0,
    'text_custom_color'     => '',
    'align_vertically'      => false,
    'text_alignment'        => 'inherit',
    'custom_link'           => '',
    'custom_link_target'    => false,
    'class'                 => ''
);
$background_params = array(
    'background_type'           => 'none',
    // bg color
    'bg_color'                  => '',
    // bg image
    'bg_image_bg_color'         => '',
    'bg_image_overlay'          => '',
    'bg_image'                  => '',
    'bg_image_position'         => 'center center',
    'bg_image_repeat'           => 'no-repeat',
    'bg_image_fullscreen'       => false,
    'bg_image_fixed'            => false,
    // background type - moving
    'bg_moving_image'           => '',
    'bg_moving_bg_color'        => 'transparent',
    'bg_moving_direction'       => 'horizontal',
    // background type - video
    'bg_video_file_mp4'         => '',
    'bg_video_file_webm'        => '',
    'bg_video_file_ogv'         => '',
    'bg_video_preview'          => '',
    'bg_video_overlay'          => ''
);
$a = shortcode_atts( array_merge( $col_params, $background_params, Bwpb_front::get_animation_data() ), $atts );

$link_target = $a['custom_link_target'] ? "target='_blank'" : '';
$start = ! empty( $a['custom_link'] ) ? "<a href='{$a['custom_link']}' {$link_target}" : '<div';
$end = ! empty( $a['custom_link'] ) ? "a>" : 'div>';
$style = $style_inner = $class = '';

$style_inner .= 'padding:'.
    $a['pt'] . ( substr( $a['pt'] , -1 ) !== '%' ? 'px' : '' )." ".
    $a['pr'] . ( substr( $a['pr'] , -1 ) !== '%' ? 'px' : '' )." ".
    $a['pb'] . ( substr( $a['pb'] , -1 ) !== '%' ? 'px' : '' )." ".
    $a['pl'] . ( substr( $a['pl'] , -1 ) !== '%' ? 'px' : '' ).';';

$style .= $a['text_custom_color'] ? "color:{$a['text_custom_color']};" : '';

$bg = Bwpb_front::get_background_data( $a );
$style .= $bg['style'] . $bg['style_holder'];
$style .= "text-align:{$a['text_alignment']};";
$style .= "width:{$a['col_width']}%;";
$class .= $a['class'] . $bg['class'];
$class .= $a['align_vertically'] ? " bwpb-vertical-col-align" : '';

$colw = (int)$a['col_width'];
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

// animation
$animation_data = '';
if( $a['animation'] and ! wp_is_mobile() ) {
    $class .= ' bwpb-waypoint';
    $animation_data .= "data-animation='{$a['animation_type']}'";
    $animation_data .= " data-animation-delay='{$a['animation_delay']}'";
}

$output  = $start . " class='bwpb-column bwpb-video-holder {$class} {$bg['class_holder']}' style='{$style}' {$bg['data']} {$animation_data}>";

$output .= "{$bg['video']}{$bg['overlay']}";
$output .= "<div class='bwpb-column-inner' style='{$style_inner}'><div class='bwpb-table-cell'>";
$output .= do_shortcode( $content );
$output .= "</div></div>";

$output .= "</" . $end;

return $output;