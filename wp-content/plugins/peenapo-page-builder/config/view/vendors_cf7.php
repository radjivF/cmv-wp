<?php

extract(shortcode_atts(array(
    'form_id'       => ''
), $atts ));

return '<div class="bwpb-cf7">' . do_shortcode( '[contact-form-7 id="' . (int)$form_id . '"]' ) . '</div>';