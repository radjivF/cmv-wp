<?php

$row_params = array(
    'visibility'                => false,
    'row_layout'                => 'full_width_background',
    'text_color'                => 'dark',
    'text_alignment'            => 'left',
    'text_custom_color'         => '#333',
    'align_vertically'          => false,
    'static_height'             => false,
    'window_height'             => '100',
    'padding_top'               => '',
    'padding_bottom'            => '',
    'anchor'                    => '',
    'class'                     => ''
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
    // background type - parallax
    'bg_parallax_bg_color'      => 'transparent',
    'bg_parallax_overlay_color' => '',
    // background type - multi parallax
    'bg_multi_parallax_bg_color' => 'transparent',
    'bg_multi_mobile_placeholder' => '',
    // background type - video
    'bg_video_file_mp4'         => '',
    'bg_video_file_webm'        => '',
    'bg_video_file_ogv'         => '',
    'bg_video_preview'          => '',
    'bg_video_overlay'          => '',
    // ribbon
    'enable_ribbon_top'         => false,
    'ribbon_top_image'          => '',
    'top_ribbon_height'         => 30,
    'enable_ribbon_bottom'      => false,
    'ribbon_bottom_image'       => '',
    'bottom_ribbon_height'      => 30,
    // path
    'enable_path'               => false,
    'path_height'               => 30,
    'path_color'                => 'translarent',
    'path_inclined'             => 'M0 0 L100 100 L0 100',
);
for( $i = 1; $i <= 8; $i++ ) {
    // parallax
    $background_params["bg_parallax_enable_{$i}"] = false;
    $background_params["bg_parallax_image_{$i}"] = '';
    $background_params["bg_parallax_position_{$i}"] = 'center';
    $background_params["bg_parallax_fullwidth_{$i}"] = false;
    $background_params["bg_parallax_speed_{$i}"] = 0;
    // multi parallax
    $background_params["bg_multi_parallax_enable_{$i}"] = false;
    $background_params["bg_multi_parallax_image_{$i}"] = '';
    $background_params["bg_multi_parallax_position_{$i}"] = 'center center';
    $background_params["bg_multi_parallax_fullwidth_{$i}"] = false;
    $background_params["bg_multi_parallax_depth_{$i}"] = 0;
}
$a = shortcode_atts( array_merge( $row_params, $background_params ), $atts );

if( $a['visibility'] == 'true' ) { return; }

$anchor = $a['anchor'] ? "id='{$a['anchor']}'" : '';
$style = $data_attr = '';

if( ! empty( $a['padding_top'] ) ) {
    $style .= substr( $a['padding_top'], -1 ) == '%' ? "padding-top:{$a['padding_top']};" : "padding-top:{$a['padding_top']}px;";
}
if( ! empty( $a['padding_bottom'] ) ) {
    $style .= substr( $a['padding_bottom'], -1 ) == '%' ? "padding-bottom:{$a['padding_bottom']};" : "padding-bottom:{$a['padding_bottom']}px;";
}

$palette = array( 'dark' => '#333', 'light' => '#fff' );
$style .= array_key_exists( $a['text_color'], $palette ) ? "color:{$palette[$a['text_color']]};" : "color:{$a['text_custom_color']};";
$style .= "text-align:{$a['text_alignment']};";

$class  = $a['align_vertically'] ? 'bwpb-vertical-row-align ' : '';
$class .= $a['class'];

if( $a['static_height'] ) {
    $class .= 'static-window-height ';
    $data_attr .= 'data-static-height="' . $a['window_height'] . '"';
}

$bg = Bwpb_front::get_background_data( $a );

$style .= $bg['style'];
$class .= $bg['class'];

$ribbon_top = $a['enable_ribbon_top'] ? "<div class='bwpb-ribbon bwpb-ribbon-top' style='height:{$a['top_ribbon_height']}px;background-image:url({$a['ribbon_top_image']})'></div>" : '';
$ribbon_bottom = $a['enable_ribbon_bottom'] ? "<div class='bwpb-ribbon bwpb-ribbon-bottom' style='height:{$a['bottom_ribbon_height']}px;background-image:url({$a['ribbon_bottom_image']})'></div>" : '';

$path = '';
if( $a['enable_path'] ) {
    $path = "<svg class='bwpb-row-path' style='fill:{$a['path_color']};height:{$a['path_height']}px' preserveAspectRatio='none' version='1.1' viewBox='0 0 100 100' width='100%' xmlns='http://www.w3.org/2000/svg'>
        <path d='{$a['path_inclined']}' stroke-width='0'></path>
    </svg>";
}

$output  = "<div class='bwpb-row-holder bwpb-video-holder bwpb-row-{$a['row_layout']} {$bg['class_holder']} {$class}' {$bg['data']} {$data_attr} style='{$bg['style_holder']}'>";
$output .= "{$path}{$bg['video']}{$bg['parallax']}{$bg['overlay']}{$bg['multi']}";
$output .= "<div class='bwpb-row'>";
$output .= "<div {$anchor} class='bwpb-row-inner' style='{$style}'>";
$output .= do_shortcode( $content );
$output .= "</div>";
$output .= "</div>{$ribbon_top}{$ribbon_bottom}";
$output .= "</div>";

return $output;