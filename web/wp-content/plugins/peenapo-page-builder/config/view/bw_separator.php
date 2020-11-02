<?php

$a = shortcode_atts(array(
    'margin_top'    => 0,
    'margin_bottom' => 0,
    'height'        => 10,
    'width'         => 100,
    'line_type'     => 'solid',
    'color'         => '#ccc',
    'class'         => '',
), $atts );

$span_if_double = $a['line_type'] == 'double' ? 'border-width:4px;' : '';
$span_width = 'margin-left:-' . ( $a['width'] * 0.5 ) . '%';
$style  = "height:{$a['height']}px;";
$style .= $a['margin_top'] ? "margin-top:{$a['margin_top']}px;" : '';
$style .= $a['margin_bottom'] ? "margin-bottom:{$a['margin_bottom']}px;" : '';

$span = ( $a['line_type'] == 'none' ) ? '' : "<span style='width:{$a['width']}%;left:50%;border-bottom:1px {$a['line_type']} {$a['color']};{$span_if_double};{$span_width}'></span>";
return "<div class='bwpb-separator {$a['class']}' style='{$style}'>{$span}</div>";