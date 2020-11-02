<?php

extract(shortcode_atts(array(
    'title'         => '',
    'sidebar_id'    => '',
    'class'         => '',
), $atts));

ob_start();
dynamic_sidebar( $sidebar_id );
$sidebar_value = ob_get_contents();
ob_end_clean();

$sidebar_value = trim( $sidebar_value );
$sidebar_value = ( substr( $sidebar_value, 0, 3 ) == '<li' ) ? '<ul>' . $sidebar_value . '</ul>' : $sidebar_value;

$output  = '';
$output .= "<div class='bwpb-sidebar {$class}'>";
$output .= "<div class='bwpb-sidebar-title'><h3>{$title}</h3></div>";
$output .= "<div class='bwpb-sidebar-content'>";
$output .= $sidebar_value;
$output .= "</div>";
$output .= "</div>";

return $output;