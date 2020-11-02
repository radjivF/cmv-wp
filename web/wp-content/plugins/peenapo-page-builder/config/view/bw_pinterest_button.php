<?php

extract(shortcode_atts(array(
    'style' => '', // red, gray, white
), $atts));

$params  = '';
$params .= $style !== '' ? " data-pin-color='{$style}'" : '';

return "<a href='//www.pinterest.com/pin/create/button/' data-pin-do='buttonBookmark' {$params}>
    <img src='//assets.pinterest.com/images/pidgets/pinit_fg_en_rect_red_20.png' />
</a>
<script type='text/javascript' async defer src='//assets.pinterest.com/js/pinit.js'></script>";