<?php

extract(shortcode_atts(array(
    'name'          => '',
    'decoration'    => '',
    'icon'          => '',
    'custom_class'  => '',
    'class'         => '',
), $atts));

$style = '';

switch( $decoration ) {
    case 'icon':
        $li = "<i class='bwpb-ui-icon-lib " . Bwpb::get_icon( $icon ) . "'></i>{$name}";
        break;
    case 'class':
        $li = "<div class='bwpb-ui-icon bwpb-table-cell'><i class='{$custom_class}'></i></div><div class='bwpb-ui-content bwpb-table-cell'>{$name}</div>";
        break;
    default:
        $li = "<span class='before'></span>{$name}";
}

return "<li class='bwpb-unordered-list-item bwpb-waypoint-seq {$class}'>{$li}</li>";