<?php

$a = shortcode_atts(array(
    'title'         => 'Column',
    'price'         => '99',
    'currency'      => '',
    'interval'      => '',
    'summary'       => '',
    'highlight'     => false,
    'highlight_color' => '#222',
    'content'       => '',
    'class'         => ''
), $atts );

$class = $a['highlight'] ? 'bwpb-pc-highlight' : '';
$h_color = $a['highlight'] ? "style='background-color:{$a['highlight_color']}'" : '';

$output  = "<div class='bwpb-pc {$a['class']} {$class}'>";
$output .= "<div class='bwpb-pc-header'><h3 class='bwpb-pc-title' {$h_color}>{$a['title']}</h3>
    <div class='bwpb-pc-price' {$h_color}>
        <h4><span class='bwpb-pc-currency'>{$a['currency']}</span>{$a['price']}</h4>
        <div class='bwpb-pc-interval'>{$a['interval']}</div>
        " . ( $a['summary'] ? '<span>' . $a['summary'] . '</span>' : '' ) . "
    </div>
</div>";
$output .= "<div class='bwpb-pc-content'>";
$output .= do_shortcode( $content );
$output .= "</div></div>";

return $output;