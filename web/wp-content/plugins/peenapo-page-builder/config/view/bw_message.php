<?php

$a = shortcode_atts(array(
    'type'          => 'rounded',
    'enable_border' => false,
    'enable_icon'   => false,
    'icon'          => '',
    'color'         => '#f3f2ab',
    'text_color'    => '',
    'class'         => '',
), $atts );

$class = $a['class'];
$style = $a['enable_border'] ? 'box-shadow:inset 0 0 0 2px rgba(0,0,0,0.05);-moz-box-shadow:inset 0 0 0 2px rgba(0,0,0,0.05);-webkit-box-shadow:inset 0 0 0 2px rgba(0,0,0,0.05);' : '';

if( $a['enable_border'] ) {
    $sc = $a['text_color'] ? $a['text_color'] : 'rgba(0,0,0,0.05)';
    $style .= "box-shadow:0 0 0 2px {$sc} inset;-moz-box-shadow:0 0 0 2px {$sc} inset;-webkit-box-shadow:0 0 0 2px {$sc} inset;";
}

$style .= "background-color:{$a['color']};";
$style .= $a['text_color'] ? "color:{$a['text_color']};" : '';

if( $a['type'] == 'rounded' ) {
    $style .= 'border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px;';
}

$icon = $a['enable_icon'] ? "<i class='bwpb-message-icon " . Bwpb::get_icon( $a['icon'] ) . "'></i>" : false;
$class .= $icon ? ' bwpb-message-with-icon' : '';

return "<div class='bwpb-message {$class}' style='{$style}'>{$icon}" . Bwpb::autop( $content ) . "</div>";