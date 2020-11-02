<?php

extract(shortcode_atts(array(
    'text'          => '',
    'url'           => '#',
    'bg_color'      => '#9abf7f',
    'bg_color_hover'=> '',
    'text_color'    => '#fff',
    'enable_icon'   => false,
    'icon'          => '',
    'size'          => 'regular',
    'class'         => '',
), $atts));

$icon_output = $enable_icon ? "<i class='" . Bwpb::get_icon( $icon ) . "'></i>" : '';
$attr = "onmouseover='this.style.backgroundColor=\"{$bg_color_hover}\"' onmouseout='this.style.backgroundColor=\"{$bg_color}\"'";

$output = "<a style='background-color:{$bg_color};color:{$text_color}!important' href='{$url}' class='bwpb-button {$class} bwpb-btn{$size}' {$attr}>{$icon_output}{$text}</a>";

return $output;