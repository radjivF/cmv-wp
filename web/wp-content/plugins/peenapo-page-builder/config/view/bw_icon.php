<?php

$a = shortcode_atts(array(
    'icon'          => '',
    'color'         => '',
    'type'          => '',
    'bg_color'      => '',
    'size'          => 18,
    'text_alignment'=> 'left',
    'class'         => '',
), $atts );

$style  = $class = '';
$style .= $a['bg_color'] ? "background-color:{$a['bg_color']};border-color:{$a['bg_color']};" : '';
$style .= "width:" . ( $a['size'] * 3 ) . "px;font-size:{$a['size']}px;padding:{$a['size']}px 0;";
$style .= "color:{$a['color']};";
$style .= ( $a['type'] == 'out_circle' or $a['type'] == 'out_square' or $a['type'] == 'out_rounded' ) ? "line-height:" . ( $a['size'] - 4 ) . "px;" : "line-height:{$a['size']}px;";

$class .= $a['class'];
$class .= $a['type'] ? " bwpb-icon-type-{$a['type']}" : 'bwpb-icon-type-none';

return "<div class='bwpb-element-icon-wrap' style='text-align:{$a['text_alignment']}'><div class='bwpb-element-icon {$class}' style='{$style}'>
    <i class='" . Bwpb::get_icon( $a['icon'] ) . "'></i>
</div></div>";