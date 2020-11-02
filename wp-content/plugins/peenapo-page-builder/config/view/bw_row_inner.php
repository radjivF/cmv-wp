<?php
$a = shortcode_atts(array(
    'visibility'        => false,
    'padding_top'       => '',
    'padding_bottom'    => '',
    'align_vertically'  => false,
    'reveal_scrolling'  => false,
    'class'             => ''
), $atts );

if( $a['visibility'] == 'true' ) { return; }

$class  = $a['align_vertically'] ? ' bwpb-vertical-row-align' : '';
$class .= $a['reveal_scrolling'] ? ' reveal-scrolling' : '';

$style = '';
if( ! empty( $a['padding_top'] ) ) {
    $style .= substr( $a['padding_top'], -1 ) == '%' ? "padding-top:{$a['padding_top']};" : "padding-top:{$a['padding_top']}px;";
}
if( ! empty( $a['padding_bottom'] ) ) {
    $style .= substr( $a['padding_bottom'], -1 ) == '%' ? "padding-bottom:{$a['padding_bottom']};" : "padding-bottom:{$a['padding_bottom']}px;";
}

$output  = "<div class='bwpb-row-holder'><div class='bwpb-row {$a['class']}'><div class='bwpb-row-inner {$class}' style='{$style}'>";
$output .= do_shortcode( $content );
$output .= "</div></div></div>";

return $output;