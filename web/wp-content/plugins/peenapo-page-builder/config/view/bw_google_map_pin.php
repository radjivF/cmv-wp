<?php

extract(shortcode_atts(array(
    'popup'         => false,
    'title'         => '',
    'desc'          => '',
    'latitude'      => '0',
    'longitude'     => '0',
    'image'         => '',
), $atts));

return "<li data-lat='{$latitude}' data-lng='{$longitude}' data-popup='{$popup}' data-pin-img='{$image}'>
    <p><h6>{$title}</h6></p><p>{$desc}</p>
</li>";