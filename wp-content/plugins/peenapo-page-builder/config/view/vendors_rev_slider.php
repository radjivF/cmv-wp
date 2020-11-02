<?php

extract(shortcode_atts(array(
    'alias'         => ''
), $atts ));

return do_shortcode("[rev_slider {$alias}]");