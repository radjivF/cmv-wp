<?php

extract(shortcode_atts(array(
    'size'          => '', // standard, small, medium, tall
    'annotation'    => ''  // bubble, inline, none
), $atts));

$params  = '';
$params .= $size !== '' ? " data-size='{$size}'" : '';
$params .= $annotation !== '' ? " data-annotation='{$annotation}'" : '';

return "<div class='bwpb-google-plus-button'>
<script src='https://apis.google.com/js/platform.js' async defer></script>
<div class='g-plusone' {$params}></div></div>";