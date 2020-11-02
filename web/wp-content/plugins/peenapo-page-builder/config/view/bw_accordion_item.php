<?php

extract(shortcode_atts(array(
    'title'         => '',
    'is_active'     => '',
    'enable_icon'   => false,
    'icon'          => '',
    'class'         => '',
), $atts));

$style = '';

$class .= $is_active ? ' bwpb-accordion-is-active' : '';
$style .= $is_active ? ' display:block' : '';
$icon_output = $enable_icon ? "<i class='" . Bwpb::get_icon( $icon ) . "'></i>" : '';

return "<div class='bwpb-accordion-item {$class}'>
    <div class='bwpb-accordion-label'>{$icon_output}{$title}</div>
    <div class='bwpb-accordion-content' style='{$style}'>" . do_shortcode( Bwpb::autop( $content ) ) . "</div>
</div>";