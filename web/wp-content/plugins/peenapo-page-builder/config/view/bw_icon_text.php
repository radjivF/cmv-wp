<?php

$a = shortcode_atts(array(
    'type'          => 'library',
    'image'         => '',
    'icon'          => '',
    'color'         => 'inherit',
    'text_color'    => 'inherit',
    'h'             => 'h4',
    'style'         => '',
    'bg_color'      => '',
    'size'          => 18,
    'text_alignment'=> 'left',
    'title'         => '',
    'class'         => '',
), $atts );

$style = $style_holder = $style_content = $class = '';
$class .= $a['class'];

$style_content .= ( $a['text_alignment'] == 'left' ? 'padding-left:30px;' : '' ) . ( $a['text_alignment'] == 'right' ? 'padding-right:30px;' : '' );
$style_content .= "color:{$a['text_color']};";
$class .= $a['style'] ? " bwpb-icon-style-{$a['style']}" : ' bwpb-icon-style-none';
$style .= "color:{$a['color']};";
$style .= ( $a['style'] == 'out_circle' or $a['style'] == 'out_square' or $a['style'] == 'out_rounded' ) ? "line-height:" . ( $a['size'] - 4 ) . "px;" : "line-height:{$a['size']}px;";
$style .= $a['bg_color'] ? "background-color:{$a['bg_color']};border-color:{$a['bg_color']};" : '';
$style_holder .= "text-align:{$a['text_alignment']}";

if( $a['type'] == 'library' ) {
    $icon_padding = $a['style'] ? "padding:" . $a['size'] * 0.5 . "px 0;" : 'padding-top:10px;';
    $style .= "width:" . ( $a['size'] * 2 ) . "px;{$icon_padding}font-size:{$a['size']}px;";
    $icon_output = "<div class='bwpb-element-icon-wrap'>
        <div class='bwpb-element-icon {$class}' style='{$style}'><i class='" . Bwpb::get_icon( $a['icon'] ) . "'></i></div>
    </div>";
}else{
    $icon_output = "<div class='bwpb-element-icon-wrap bwpb-element-is-image'>
        <img class='bwpb-element-icon {$class}' style='{$style}' src='{$a['image']}' alt=''>
    </div>";
}

return "<div class='bwpb-icon-text bwpb-icon-text-align-{$a['text_alignment']}' style='{$style_holder}'>
    " . ( ( $a['text_alignment'] == 'left' or $a['text_alignment'] == 'center' ) ? $icon_output : '' ) . "
    <div class='bwpb-icon-text-content' style='{$style_content}'>
        <{$a['h']}>{$a['title']}</{$a['h']}>
        " . do_shortcode( Bwpb::autop( $content ) ) . "
    </div>
    " . ( $a['text_alignment'] == 'right' ? $icon_output : '' ) . "
</div>";