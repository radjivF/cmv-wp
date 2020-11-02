<?php
/*--------------------------------------------*/
/* Peenapo Page Builder - Map Default Elements
/*--------------------------------------------*/

// background position options
$background_positions = array(
    'default' => 'Default',
    'left top' => 'Left Top',
    'left center' => 'Left Center',
    'left bottom' => 'Left Bottom',
    'center top' => 'Center Top',
    'center center' => 'Center Center',
    'center bottom' => 'Center Bottom',
    'right top' => 'Right Top',
    'right center' => 'Right Center',
    'right bottom' => 'Right Bottom',
);

// background type
$background_type_row = array(
    array(
        'type' => 'select',
        'heading' => __( 'Background type', PBTD ),
        'param_name' => 'background_type',
        'fields' => array(
            'none' => 'None',
            'color' => 'Color',
            'image' => 'Image',
            'moving' => 'Moving',
            'parallax' => 'Parallax',
            'multi_parallax' => 'Multi layered parallax',
            'video' => 'Video'
        ),
        'dependency' => array( 'element' => "content", 'value' => 'field_2', 'not_empty' => true ),
        'tab' => __( 'Background', PBTD )
    )
);
$background_type_col = $background_type_row;
unset( $background_type_col[0]['fields']['parallax'] );
unset( $background_type_col[0]['fields']['multi_parallax'] );

// background type options
$background_type = array(
    // background type - color
    array(
        'type' => 'colorpicker',
        'heading' => __( 'Background color', PBTD ),
        'param_name' => 'bg_color',
        'dependency' => array( 'element' => "background_type", 'value' => 'color' ),
        'tab' => __( 'Background', PBTD )
    ),
    // background type - image
    array(
        'type' => 'image',
        'heading' => __( 'Background image', PBTD ),
        'param_name' => 'bg_image',
        'dependency' => array( 'element' => "background_type", 'value' => 'image' ),
        'tab' => __( 'Background', PBTD )
    ),
    array(
        'type' => 'colorpicker',
        'heading' => __( 'Background color', PBTD ),
        'param_name' => 'bg_image_bg_color',
        'dependency' => array( 'element' => "background_type", 'value' => 'image' ),
        'tab' => __( 'Background', PBTD )
    ),
    array(
        'type' => 'colorpicker',
        'heading' => __( 'Background overlay', PBTD ),
        'param_name' => 'bg_image_overlay',
        'dependency' => array( 'element' => "background_type", 'value' => 'image' ),
        'tab' => __( 'Background', PBTD )
    ),
    array(
        'type' => 'select',
        'heading' => __( 'Image position', PBTD ),
        'param_name' => 'bg_image_position',
        'fields' => $background_positions,
        'dependency' => array( 'element' => "background_type", 'value' => 'image' ),
        'width' => 50,
        'tab' => __( 'Background', PBTD )
    ),
    array(
        'type' => 'select',
        'heading' => __( 'Image repeat', PBTD ),
        'param_name' => 'bg_image_repeat',
        'fields' => array(
            'no-repeat' => 'No repeat',
            'repeat' => 'Repeat all',
            'repeat-x' => 'Repeat horizontal',
            'repeat-y' => 'Repeat vertical',
        ),
        'dependency' => array( 'element' => "background_type", 'value' => 'image' ),
        'width' => 50,
        'tab' => __( 'Background', PBTD )
    ),
    array(
        'type' => 'true_false',
        'heading' => __( 'Enable fullscreen background', PBTD ),
        'param_name' => 'bg_image_fullscreen',
        'dependency' => array( 'element' => "background_type", 'value' => 'image' ),
        'tab' => __( 'Background', PBTD ),
        'width' => 50
    ),
    array(
        'type' => 'true_false',
        'param_name' => 'bg_image_fixed',
        'heading' => __( 'Fixed background position', PBTD ),
        'dependency' => array( 'element' => "background_type", 'value' => 'image' ),
        'tab' => __( 'Background', PBTD ),
        'width' => 50
    ),
    // background type - moving
    array(
        'type' => 'image',
        'heading' => __( 'Background image', PBTD ),
        'param_name' => 'bg_moving_image',
        'dependency' => array( 'element' => "background_type", 'value' => 'moving' ),
        'tab' => __( 'Background', PBTD )
    ),
    array(
        'type' => 'colorpicker',
        'heading' => __( 'Background color', PBTD ),
        'param_name' => 'bg_moving_bg_color',
        'dependency' => array( 'element' => "background_type", 'value' => 'moving' ),
        'tab' => __( 'Background', PBTD )
    ),
    array(
        'type' => 'select',
        'heading' => __( 'Animation direction', PBTD ),
        'param_name' => 'bg_moving_direction',
        'fields' => array(
            'horizontal' => 'Horizontal',
            'vertical' => 'Vertical',
            'diagonal' => 'Diagonal',
        ),
        'dependency' => array( 'element' => "background_type", 'value' => 'moving' ),
        'tab' => __( 'Background', PBTD )
    ),
    // background type - parallax
    array(
        'type' => 'colorpicker',
        'heading' => __( 'Parallax background color', PBTD ),
        'param_name' => "bg_parallax_bg_color",
        'dependency' => array( 'element' => "background_type", 'value' => 'parallax' ),
        'tab' => __( 'Background', PBTD ),
        'width' => 50
    ),
    array(
        'type' => 'colorpicker',
        'heading' => __( 'Parallax overlay color', PBTD ),
        'param_name' => "bg_parallax_overlay_color",
        'dependency' => array( 'element' => "background_type", 'value' => 'parallax' ),
        'tab' => __( 'Background', PBTD ),
        'width' => 50
    ),
    // background type - multi layered parallax
    array(
        'type' => 'colorpicker',
        'heading' => __( 'Parallax overlay color', PBTD ),
        'param_name' => "bg_multi_parallax_bg_color",
        'dependency' => array( 'element' => "background_type", 'value' => 'multi_parallax' ),
        'tab' => __( 'Background', PBTD ),
    ),
    array(
        'type' => 'image',
        'heading' => __( 'Mobile background placeholder', PBTD ),
        'param_name' => "bg_multi_mobile_placeholder",
        'dependency' => array( 'element' => "background_type", 'value' => 'multi_parallax' ),
        'tab' => __( 'Background', PBTD ),
    )
);

for( $i = 1; $i <= 6; $i++ ) {
    // parallax
    array_push( $background_type,
        array(
            'type' => 'true_false',
            'heading' => __( "Enable parallax layer {$i}", PBTD ),
            'param_name' => "bg_parallax_enable_{$i}",
            'dependency' => array( 'element' => "background_type", 'value' => 'parallax' ),
            'tab' => __( 'Background', PBTD )
        ),
        array(
            'type' => 'image',
            'heading' => __( "Layer {$i} background image", PBTD ),
            'param_name' => "bg_parallax_image_{$i}",
            'dependency' => array( 'element' => "bg_parallax_enable_{$i}", 'value' => '1' ),
            'tab' => __( 'Background', PBTD )
        ),
        array(
            'type' => 'select',
            'heading' => __( "Layer {$i} background position", PBTD ),
            'param_name' => "bg_parallax_position_{$i}",
            'fields' => array( 'center' => 'Center', 'left' => 'Left', 'right' => 'Right' ),
            'dependency' => array( 'element' => "bg_parallax_enable_{$i}", 'value' => '1' ),
            'tab' => __( 'Background', PBTD ),
            'width' => 50
        ),
        array(
            'type' => 'true_false',
            'heading' => __( "Layer {$i} enable fullwidth", PBTD ),
            'param_name' => "bg_parallax_fullwidth_{$i}",
            'dependency' => array( 'element' => "bg_parallax_enable_{$i}", 'value' => '1' ),
            'tab' => __( 'Background', PBTD ),
            'width' => 50
        ),
        array(
            'type' => 'number_slider',
            'heading' => __( "Layer {$i} animation speed", PBTD ),
            'param_name' => "bg_parallax_speed_{$i}",
            'min' => -2000,
            'max' => 2000,
            'step' => 50,
            'append_before' => '',
            'append_after' => 'pixels.',
            'description' => 'Speed between (-2000 to 2000)<br>Speed 0 - make background static<br>Speed Negative - scroll will be reverse of scroll',
            'dependency' => array( 'element' => "bg_parallax_enable_{$i}", 'value' => '1' ),
            'tab' => __( 'Background', PBTD )
        )
    );
}

for( $i = 1; $i <= 8; $i++ ) {
    // multi parallax
    array_push( $background_type,
        array(
            'type' => 'true_false',
            'heading' => __( "Enable parallax layer {$i}", PBTD ),
            'param_name' => "bg_multi_parallax_enable_{$i}",
            'dependency' => array( 'element' => "background_type", 'value' => 'multi_parallax' ),
            'tab' => __( 'Background', PBTD )
        ),
        array(
            'type' => 'image',
            'heading' => __( "Layer {$i} background image", PBTD ),
            'param_name' => "bg_multi_parallax_image_{$i}",
            'dependency' => array( 'element' => "bg_multi_parallax_enable_{$i}", 'value' => '1' ),
            'tab' => __( 'Background', PBTD )
        ),
        array(
            'type' => 'select',
            'heading' => __( "Layer {$i} background position", PBTD ),
            'param_name' => "bg_multi_parallax_position_{$i}",
            'fields' => array(
                'left top' => 'Left Top',
                'left center' => 'Left Center',
                'left bottom' => 'Left Bottom',
                'right top' => 'Right Top',
                'right center' => 'Right Center',
                'right bottom' => 'Right Bottom',
                'center top' => 'Center Top',
                'center center' => 'Center Center',
                'center bottom' => 'Center Bottom',
            ),
            'dependency' => array( 'element' => "bg_multi_parallax_enable_{$i}", 'value' => '1' ),
            'tab' => __( 'Background', PBTD ),
            'width' => 50
        ),
        array(
            'type' => 'true_false',
            'heading' => __( "Layer {$i} enable fullwidth", PBTD ),
            'param_name' => "bg_multi_parallax_fullwidth_{$i}",
            'dependency' => array( 'element' => "bg_multi_parallax_enable_{$i}", 'value' => '1' ),
            'tab' => __( 'Background', PBTD ),
            'width' => 50
        ),
        array(
            'type' => 'number_slider',
            'heading' => __( "Layer {$i} depth", PBTD ),
            'param_name' => "bg_multi_parallax_depth_{$i}",
            'min' => 0,
            'max' => 1.0,
            'step' => 0.05,
            'append_before' => '',
            'append_after' => '',
            'dependency' => array( 'element' => "bg_multi_parallax_enable_{$i}", 'value' => '1' ),
            'tab' => __( 'Background', PBTD )
        )
    );
}
array_push( $background_type,
    // background type - video
    array(
        'type' => 'attach_file',
        'heading' => __( 'File mp4', PBTD ),
        'param_name' => 'bg_video_file_mp4',
        'dependency' => array( 'element' => "background_type", 'value' => 'video' ),
        'tab' => __( 'Background', PBTD )
    ),
    array(
        'type' => 'attach_file',
        'heading' => __( 'File webm', PBTD ),
        'param_name' => 'bg_video_file_webm',
        'dependency' => array( 'element' => "background_type", 'value' => 'video' ),
        'tab' => __( 'Background', PBTD )
    ),
    array(
        'type' => 'attach_file',
        'heading' => __( 'File ogv', PBTD ),
        'param_name' => 'bg_video_file_ogv',
        'dependency' => array( 'element' => "background_type", 'value' => 'video' ),
        'tab' => __( 'Background', PBTD )
    ),
    array(
        'type' => 'image',
        'heading' => __( "Video preview image", PBTD ),
        'param_name' => "bg_video_preview",
        'dependency' => array( 'element' => "background_type", 'value' => 'video' ),
        'tab' => __( 'Background', PBTD )
    ),
    array(
        'type' => 'colorpicker',
        'heading' => __( "Video overlay color", PBTD ),
        'param_name' => "bg_video_overlay",
        'dependency' => array( 'element' => "background_type", 'value' => 'video' ),
        'tab' => __( 'Background', PBTD )
    )
);

// background type options - column
$background_type_exclude_col = array(
    // background type - color
    array(
        'type' => 'colorpicker',
        'heading' => __( 'Background color', PBTD ),
        'param_name' => 'bg_color',
        'dependency' => array( 'element' => "background_type", 'value' => 'color' ),
        'tab' => __( 'Background', PBTD )
    ),
    // background type - image
    array(
        'type' => 'image',
        'heading' => __( 'Background image', PBTD ),
        'param_name' => 'bg_image',
        'dependency' => array( 'element' => "background_type", 'value' => 'image' ),
        'tab' => __( 'Background', PBTD )
    ),
    array(
        'type' => 'colorpicker',
        'heading' => __( 'Background color', PBTD ),
        'param_name' => 'bg_image_bg_color',
        'dependency' => array( 'element' => "background_type", 'value' => 'image' ),
        'tab' => __( 'Background', PBTD )
    ),
    array(
        'type' => 'colorpicker',
        'heading' => __( 'Background overlay', PBTD ),
        'param_name' => 'bg_image_overlay',
        'dependency' => array( 'element' => "background_type", 'value' => 'image' ),
        'tab' => __( 'Background', PBTD )
    ),
    array(
        'type' => 'select',
        'heading' => __( 'Image position', PBTD ),
        'param_name' => 'bg_image_position',
        'fields' => $background_positions,
        'dependency' => array( 'element' => "background_type", 'value' => 'image' ),
        'width' => 50,
        'tab' => __( 'Background', PBTD )
    ),
    array(
        'type' => 'select',
        'heading' => __( 'Image repeat', PBTD ),
        'param_name' => 'bg_image_repeat',
        'fields' => array(
            'no-repeat' => 'No repeat',
            'repeat' => 'Repeat all',
            'repeat-x' => 'Repeat horizontal',
            'repeat-y' => 'Repeat vertical',
        ),
        'dependency' => array( 'element' => "background_type", 'value' => 'image' ),
        'width' => 50,
        'tab' => __( 'Background', PBTD )
    ),
    array(
        'type' => 'true_false',
        'heading' => __( 'Enable fullscreen background', PBTD ),
        'param_name' => 'bg_image_fullscreen',
        'dependency' => array( 'element' => "background_type", 'value' => 'image' ),
        'tab' => __( 'Background', PBTD ),
        'width' => 50
    ),
    array(
        'type' => 'true_false',
        'param_name' => 'bg_image_fixed',
        'heading' => __( 'Fixed background position', PBTD ),
        'dependency' => array( 'element' => "background_type", 'value' => 'image' ),
        'tab' => __( 'Background', PBTD ),
        'width' => 50
    ),
    // background type - moving
    array(
        'type' => 'image',
        'heading' => __( 'Background image', PBTD ),
        'param_name' => 'bg_moving_image',
        'dependency' => array( 'element' => "background_type", 'value' => 'moving' ),
        'tab' => __( 'Background', PBTD )
    ),
    array(
        'type' => 'colorpicker',
        'heading' => __( 'Background color', PBTD ),
        'param_name' => 'bg_moving_bg_color',
        'dependency' => array( 'element' => "background_type", 'value' => 'moving' ),
        'tab' => __( 'Background', PBTD )
    ),
    array(
        'type' => 'select',
        'heading' => __( 'Animation direction', PBTD ),
        'param_name' => 'bg_moving_direction',
        'fields' => array(
            'horizontal' => 'Horizontal',
            'vertical' => 'Vertical',
            'diagonal' => 'Diagonal',
        ),
        'dependency' => array( 'element' => "background_type", 'value' => 'moving' ),
        'tab' => __( 'Background', PBTD )
    ),
    // background type - video
    array(
        'type' => 'attach_file',
        'heading' => __( 'File mp4', PBTD ),
        'param_name' => 'bg_video_file_mp4',
        'dependency' => array( 'element' => "background_type", 'value' => 'video' ),
        'tab' => __( 'Background', PBTD )
    ),
    array(
        'type' => 'attach_file',
        'heading' => __( 'File webm', PBTD ),
        'param_name' => 'bg_video_file_webm',
        'dependency' => array( 'element' => "background_type", 'value' => 'video' ),
        'tab' => __( 'Background', PBTD )
    ),
    array(
        'type' => 'attach_file',
        'heading' => __( 'File ogv', PBTD ),
        'param_name' => 'bg_video_file_ogv',
        'dependency' => array( 'element' => "background_type", 'value' => 'video' ),
        'tab' => __( 'Background', PBTD )
    ),
    array(
        'type' => 'image',
        'heading' => __( "Video preview image", PBTD ),
        'param_name' => "bg_video_preview",
        'dependency' => array( 'element' => "background_type", 'value' => 'video' ),
        'tab' => __( 'Background', PBTD )
    ),
    array(
        'type' => 'colorpicker',
        'heading' => __( "Video overlay color", PBTD ),
        'param_name' => "bg_video_overlay",
        'dependency' => array( 'element' => "background_type", 'value' => 'video' ),
        'tab' => __( 'Background', PBTD )
    )
);

$animation_effects = array(
    // fase
    'fadeIn'            => 'Fade in',
    'fadeInDown'        => 'Fade in down',
    'fadeInDownBig'     => 'Fade in down big',
    'fadeInLeft'        => 'Fade in left',
    'fadeInLeftBig'     => 'Fade in left big',
    'fadeInRight'       => 'Fade in right',
    'fadeInRightBig'    => 'Fade in right big',
    'fadeInUp'          => 'Fade in up',
    'fadeInUpBig'       => 'Fade in up big',
    // bounce
    'bounceIn'          => 'Bounce in',
    'bounceInDown'      => 'Bounce in down',
    'bounceInLeft'      => 'Bounce in left',
    'bounceInRight'     => 'Bounce in right',
    'bounceInUp'        => 'Bounce in up',
    // flip
    'flipInX'           => 'Flip in x',
    'flipInY'           => 'Flip in y',
    // speed
    'lightSpeedIn'      => 'Light speed in',
    // rotate
    'rotateIn'          => 'Rotate in',
    'rotateInDownLeft'  => 'Rotate in down left',
    'rotateInDownRight' => 'Rotate in down right',
    'rotateInUpLeft'    => 'Rotate in up left',
    'rotateInUpRight'   => 'Rotate in up right',
    // roll
    'rollIn'            => 'Roll in',
    // zoom
    'zoomIn'            => 'Zoom in',
    'zoomInDown'        => 'Zoom in down',
    'zoomInLeft'        => 'Zoom in left',
    'zoomInRight'       => 'Zoom in right',
    'zoomInUp'          => 'Zoom in up',
    // slide
    'slideInDown'       => 'Slide in down',
    'slideInLeft'       => 'Slide in left',
    'slideInRight'      => 'Slide in right',
    'slideInUp'         => 'Slide in up',
);

// animation
$animation = array(
    array(
        'type' => 'true_false',
        'heading' => __( 'Enable animation', PBTD ),
        'param_name' => 'animation',
        'tab' => __( 'Animation', PBTD )
    ),
    array(
        'type' => 'select',
        'heading' => __( 'Animation type', PBTD ),
        'param_name' => 'animation_type',
        'fields' => $animation_effects,
        'dependency' => array( 'element' => "animation", 'value' => '1' ),
        'tab' => __( 'Animation', PBTD )
    ),
    array(
        'type' => 'number_slider',
        'heading' => __( 'Animation delay', PBTD ),
        'param_name' => 'animation_delay',
        'min' => 0,
        'max' => 6000,
        'step' => 50,
        'append_before' => '',
        'append_after' => 'milliseconds.',
        'description' => '1 second = 1000 milliseconds.',
        'dependency' => array( 'element' => "animation", 'value' => '1' ),
        'tab' => __( 'Animation', PBTD )
    )
);

// params row
$row_params = array(
    array(
        'type' => 'true_false',
        'param_name' => 'visibility',
        'public' => false
    ),
    array(
        'type' => 'radio_image',
        'heading' => __( 'Row layout', PBTD ),
        'param_name' => 'row_layout',
        'fields' => array(
            array(
                'value' => 'full_width_background',
                'label' => 'Full width background',
                'image' => PB_ASSEST . 'img/__tmp/row_full_width_background.png'
            ),
            array(
                'value' => 'full_width_content',
                'label' => 'Full width content',
                'image' => PB_ASSEST . 'img/__tmp/row_full_width_content.png'
            ),
            array(
                'value' => 'in_container',
                'label' => 'In container',
                'image' => PB_ASSEST . 'img/__tmp/row_in_container.png'
            ),
        ),
        'value' => 'full_width_background',
    ),
    array(
        'type' => 'textfield',
        'heading' => __( 'Padding top', PBTD ),
        'param_name' => 'padding_top',
        'value' => 30,
        'description' => __( 'Don\'t include "px" in your string. e.g "40" - For perecent value "%" would be needed at the end e.g. "10%"', PBTD ),
        'width' => 50
    ),
    array(
        'type' => 'textfield',
        'heading' => __( 'Padding bottom', PBTD ),
        'param_name' => 'padding_bottom',
        'value' => 30,
        'description' => __( 'Don\'t include "px" in your string. e.g "40" - For perecent value "%" would be needed at the end e.g. "10%"', PBTD ),
        'width' => 50
    ),
    array(
        'type' => 'select',
        'heading' => __( 'Text color', PBTD ),
        'param_name' => 'text_color',
        'fields' => array( 'dark' => 'Dark', 'light' => 'Light', 'custom' => 'Custom' ),
        'width' => 50
    ),
    array(
        'type' => 'select',
        'heading' => __( 'Text alignment', PBTD ),
        'param_name' => 'text_alignment',
        'fields' => array( 'inherit' => 'Inherit', 'left' => 'Left', 'center' => 'Center', 'right' => 'Right' ),
        'width' => 50
    ),
    array(
        'type' => 'colorpicker',
        'heading' => __( "Custom text color", PBTD ),
        'param_name' => "text_custom_color",
        'dependency' => array( 'element' => "text_color", 'value' => 'custom' ),
    ),
    array(
        'type' => 'true_false',
        'heading' => __( 'Align content vertically', PBTD ),
        'param_name' => 'align_vertically'
    ),
    array(
        'type' => 'true_false',
        'heading' => __( 'Add static height', PBTD ),
        'param_name' => 'static_height'
    ),
    array(
        'type' => 'number_slider',
        'heading' => __( 'Window height', PBTD ),
        'param_name' => 'window_height',
        'min' => 50,
        'max' => 200,
        'step' => 1,
        'value' => 100,
        'append_before' => '',
        'append_after' => '%',
        'description' => '100% = full window height',
        'dependency' => array( 'element' => "static_height", 'value' => '1' ),
    ),
    array(
        'type' => 'textfield',
        'heading' => __( 'Anchor (ID)', PBTD ),
        'param_name' => 'anchor',
        'description' => __( 'Use this to option to add an ID. This can then be used as an anchor point to scroll.', PBTD ), // Use this to option to add an ID. This can then be used to target the row with CSS or as an anchor point to scroll to when the relevant link is clicked.
    ),
    array(
        'type' => 'textfield',
        'param_name' => 'class'
    )
);

// params column
$col_params = array(
    array(
        'type' => 'textfield',
        'param_name' => 'col_width',
        'value' => '100',
        'public' => false
    ),
    array(
        'type' => 'heading',
        'param_name' => 'col_padding_desc',
        'heading' => 'Column padding',
        'description' => 'Don\'t include "px" in your string. e.g "40" - For perecent value "%" would be needed at the end e.g. "10%"',
    ),
    array(
        'type' => 'textfield',
        'heading' => 'Top',
        'param_name' => 'pt',
        'width' => 25
    ),
    array(
        'type' => 'textfield',
        'heading' => 'Right',
        'param_name' => 'pr',
        'width' => 25
    ),
    array(
        'type' => 'textfield',
        'heading' => 'Bottom',
        'param_name' => 'pb',
        'width' => 25
    ),
    array(
        'type' => 'textfield',
        'heading' => 'Left',
        'param_name' => 'pl',
        'width' => 25
    ),
    array(
        'type' => 'colorpicker',
        'heading' => __( "Custom text color", PBTD ),
        'param_name' => "text_custom_color",
        'dependency' => array( 'element' => "text_color", 'value' => 'custom' )
    ),
    array(
        'type' => 'true_false',
        'heading' => __( 'Align content vertically', PBTD ),
        'param_name' => 'align_vertically',
        'width' => 50
    ),
    array(
        'type' => 'select',
        'heading' => __( 'Text alignment', PBTD ),
        'param_name' => 'text_alignment',
        'fields' => array( 'inherit' => 'Inherit', 'left' => 'Left', 'center' => 'Center', 'right' => 'Right' ),
        'width' => 50
    ),
    array(
        'type' => 'textfield',
        'heading' => __( 'Custom link', PBTD ),
        'param_name' => 'custom_link',
        'placeholder' => 'http://',
        'description' => 'Point this column to somewhere.',
        'width' => 50
    ),
    array(
        'type' => 'true_false',
        'heading' => __( 'New tab', PBTD ),
        'param_name' => 'custom_link_target',
        'description' => 'Open the custom link in a new window',
        'width' => 50
    ),
    array(
        'type' => 'textfield',
        'param_name' => 'class'
    )
);

$background_ribbon = array(
    array(
        'type' => 'true_false',
        'heading' => __( 'Enable top ribbon', PBTD ),
        'param_name' => 'enable_ribbon_top',
        'tab' => __( 'Background', PBTD )
    ),
    array(
        'type' => 'image',
        'heading' => __( 'Top ribbon image', PBTD ),
        'param_name' => 'ribbon_top_image',
        'tab' => __( 'Background', PBTD ),
        'dependency' => array( 'element' => "enable_ribbon_top", 'value' => '1' ),
    ),
    array(
        'type' => 'number_slider',
        'heading' => __( 'Top ribbon height', PBTD ),
        'param_name' => 'top_ribbon_height',
        'min' => 1,
        'max' => 100,
        'step' => 1,
        'value' => 20,
        'append_before' => '',
        'append_after' => 'pixels.',
        'tab' => __( 'Background', PBTD ),
        'dependency' => array( 'element' => "enable_ribbon_top", 'value' => '1' ),
    ),
    array(
        'type' => 'true_false',
        'heading' => __( 'Enable bottom ribbon', PBTD ),
        'param_name' => 'enable_ribbon_bottom',
        'tab' => __( 'Background', PBTD )
    ),
    array(
        'type' => 'image',
        'heading' => __( 'Bottom ribbon image', PBTD ),
        'param_name' => 'ribbon_bottom_image',
        'tab' => __( 'Background', PBTD ),
        'dependency' => array( 'element' => "enable_ribbon_bottom", 'value' => '1' ),
    ),
    array(
        'type' => 'number_slider',
        'heading' => __( 'Bottom ribbon height', PBTD ),
        'param_name' => 'bottom_ribbon_height',
        'min' => 1,
        'max' => 100,
        'step' => 1,
        'value' => 20,
        'append_before' => '',
        'append_after' => 'pixels.',
        'tab' => __( 'Background', PBTD ),
        'dependency' => array( 'element' => "enable_ribbon_bottom", 'value' => '1' ),
    ),
);

$background_path = array(
    /*array(
        'type' => 'true_false',
        'heading' => __( 'Enable bottom path', PBTD ),
        'param_name' => 'enable_path',
        'description' => __( 'This will add inclined plane background effect to your row. It is recommendable to choose the same background color as the background of the next row.', PBTD ),
        'tab' => __( 'Background', PBTD )
    ),
    array(
        'type' => 'number_slider',
        'heading' => __( 'Path height', PBTD ),
        'param_name' => 'path_height',
        'min' => 10,
        'max' => 200,
        'step' => 1,
        'value' => 70,
        'append_before' => '',
        'append_after' => 'pixels.',
        'tab' => __( 'Background', PBTD ),
        'dependency' => array( 'element' => "enable_path", 'value' => '1' ),
    ),
    array(
        'type' => 'colorpicker',
        'heading' => __( 'Path background color', PBTD ),
        'param_name' => 'path_color',
        'tab' => __( 'Background', PBTD ),
        'dependency' => array( 'element' => "enable_path", 'value' => '1' ),
    ),
    array(
        'type' => 'select',
        'heading' => __( 'Inclined to', PBTD ),
        'param_name' => 'path_inclined',
        'fields' => array( 'M0 0 L100 100 L0 100' => 'Left', 'M0 100 L100 0 L100 100' => 'Right' ),
        'tab' => __( 'Background', PBTD ),
        'dependency' => array( 'element' => "enable_path", 'value' => '1' ),
    ),*/
);

// row
Bwpb_map::map(array(
    'name' => __( 'Row', PBTD ),
    'base' => 'bw_row',
    'icon' => 'bwpb-icon-row',
    'description' => __( 'Place content elements inside the row', PBTD ),
    'category' => __( 'General', PBTD ),
    'params' => array_merge( $background_type_row, $row_params, $background_type, $background_ribbon, $background_path ),
    'view' => 'row'
));

// column
Bwpb_map::map(array(
    'name' => __( 'Column', PBTD ),
    'base' => 'bw_column',
    'icon' => 'bwpb-icon-row',
    'description' => __( 'Place content elements inside the column', PBTD ),
    'params' => array_merge( $background_type_col, $col_params, $background_type_exclude_col, $animation ),
    'view' => 'column'
));

$reveal_scrolling = array(
    array(
        'type' => 'true_false',
        'heading' => __( 'Reveal scrolling', PBTD ),
        'param_name' => 'reveal_scrolling',
        'tab' => __( 'Animation', PBTD ),
    )
);

// row inner
Bwpb_map::map(array(
    'name' => __( 'Row Inner', PBTD ),
    'base' => 'bw_row_inner',
    'icon' => 'bwpb-icon-row',
    'description' => __( 'Place content elements inside the row', PBTD ),
    'category' => __( 'General', PBTD ),
    'params' => array_merge(array(
        array(
            'type' => 'true_false',
            'param_name' => 'visibility',
            'public' => false
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Padding top', PBTD ),
            'param_name' => 'padding_top',
            'value' => 30,
            'description' => __( 'Don\'t include "px" in your string. e.g "40" - For perecent value "%" would be needed at the end e.g. "10%"', PBTD ),
            'width' => 50
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Padding bottom', PBTD ),
            'param_name' => 'padding_bottom',
            'value' => 30,
            'description' => __( 'Don\'t include "px" in your string. e.g "40" - For perecent value "%" would be needed at the end e.g. "10%"', PBTD ),
            'width' => 50
        ),
        array(
            'type' => 'true_false',
            'heading' => __( 'Align content vertically', PBTD ),
            'param_name' => 'align_vertically',
        ),
        array(
            'type' => 'textfield',
            'param_name' => 'class'
        )
    ), $reveal_scrolling ),
    'view' => 'row'
));

// column inner
Bwpb_map::map(array(
    'name' => __( 'Column Inner', PBTD ),
    'base' => 'bw_column_inner',
    'icon' => 'bwpb-icon-column',
    'description' => __( 'Place content elements inside the column', PBTD ),
    'params' => array_merge(array(
        array(
            'type' => 'textfield',
            'param_name' => 'col_width',
            'value' => '100',
            'public' => false
        ),
        array(
            'type' => 'heading',
            'param_name' => 'col_padding_desc',
            'heading' => 'Column padding',
            'description' => 'Don\'t include "px" in your string. e.g "40" - For perecent value "%" would be needed at the end e.g. "10%"',
        ),
        array(
            'type' => 'textfield',
            'heading' => 'Top',
            'param_name' => 'pt',
            'width' => 25
        ),
        array(
            'type' => 'textfield',
            'heading' => 'Right',
            'param_name' => 'pr',
            'width' => 25
        ),
        array(
            'type' => 'textfield',
            'heading' => 'Bottom',
            'param_name' => 'pb',
            'width' => 25
        ),
        array(
            'type' => 'textfield',
            'heading' => 'Left',
            'param_name' => 'pl',
            'width' => 25
        ),
        array(
            'type' => 'true_false',
            'heading' => __( 'Align content vertically', PBTD ),
            'param_name' => 'align_vertically',
            'width' => 50
        ),
        array(
            'type' => 'select',
            'heading' => __( 'Text alignment', PBTD ),
            'param_name' => 'text_alignment',
            'fields' => array( 'inherit' => 'Inherit', 'left' => 'Left', 'center' => 'Center', 'right' => 'Right' ),
            'width' => 50
        ),
        array(
            'type' => 'textfield',
            'param_name' => 'class'
        )
    ), $animation, $reveal_scrolling ),
    'view' => 'column'
));

# text
Bwpb_map::map(array(
    'name' => __( 'Text Block', PBTD ),
    'base' => 'bw_text',
    'icon' => 'bwpb-icon-text',
    'description' => __( 'Place text/HTML', PBTD ),
    'open_settings_on_create' => true,
    'category' => __( 'General', PBTD ),
    'params' => array(
        array(
            'type' => 'editor',
            'param_name' => 'content',
            'heading' => __( 'Text', PBTD ),
            'value' => 'Text block. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean et nisi euismod, aliquam risus et, tempus augue.',
            'holder' => '.bwpb-html-text',
            'is_content' => true,
        ),
        /*array(
            'type' => 'select2',
            'heading' => __( 'Field', PBTD ),
            'param_name' => 'field_select2',
            'description' => __( 'Some description.', PBTD ),
            'fields' => array( '' => 'Default', 'field_1' => 'Field one', 'field_2' => 'Field two', 'field_3' => 'Field three' ),
            //'value' => 'field_2',
            'dependency' => array( 'element' => "content", 'value' => 'field_2', 'not_empty' => true ),
        ),*/
        /*array(
            'type' => 'textfield',
            'heading' => __( 'Extra class name', PBTD ),
            'param_name' => 'class',
            'description' => __( 'Add classname to this element for additional styles.', PBTD ),
            'dependency' => array( 'element' => "field_radio_image", 'value' => array('one','two') ),
            //'width' => 50,
            //'tab' => __( 'Additional', PBTD ),
        ),*/
        /*array(
            'type' => 'number_slider',
            'heading' => __( 'Field', PBTD ),
            'param_name' => 'field_number_slider',
            'description' => __( 'Some description.', PBTD ),
            'min' => 0,
            'max' => 100,
            'step' => 1,
            'value' => 25,
            'append_before' => '',
            'append_after' => 'pixels.',
        ),*/
        /*array(
            'type' => 'taxonomies',
            'heading' => __( 'Field', PBTD ),
            'param_name' => 'field_post_types',
            'description' => __( 'Some description.', PBTD ),
            'tx_type' => 'post',
            'allow_empty' => true,
            'multiple' => false,
            'value' => array('post','page'),
        ),*/
        /*array(
            'type' => 'post_types',
            'heading' => __( 'Field', PBTD ),
            'param_name' => 'field_post_types',
            'description' => __( 'Some description.', PBTD ),
            'allow_empty' => true,
            'multiple' => false,
            'value' => array('post','page'),
        ),*/
        /*array(
            'type' => 'image',
            'heading' => __( 'Field Image', PBTD ),
            'param_name' => 'field_image',
            'description' => __( 'Some description.', PBTD ),
        ),*/
        /*array(
            'type' => 'attach_file',
            'heading' => __( 'Field File', PBTD ),
            'param_name' => 'field_file',
            'description' => __( 'Some description.', PBTD ),
        ),*/
        /*array(
            'type' => 'post_formats',
            'heading' => __( 'Field', PBTD ),
            'param_name' => 'field_post_formats',
            'description' => __( 'Some description.', PBTD ),
            'allow_empty' => true,
            'multiple' => false,
            //'value' => array('chat'),
            'push_standard' => true
        ),*/
        /*array(
            'type' => 'select',
            'heading' => __( 'Field', PBTD ),
            'param_name' => 'field_select',
            'description' => __( 'Some description.', PBTD ),
            'fields' => array( 'default' => '--', 'field_1' => 'Field one', 'field_2' => 'Field two', 'field_3' => 'Field three' ),
            //'value' => 'field_2'
        ),*/
        /*array(
            'type' => 'textarea',
            'heading' => __( 'Field', PBTD ),
            'param_name' => 'field_textarea',
            'description' => __( 'Some description.', PBTD ),
            'rows' => 10,
        ),*/
        /*array(
            'type' => 'radio_image',
            'heading' => __( 'Field', PBTD ),
            'param_name' => 'field_radio_image',
            'description' => __( 'Some description.', PBTD ),
            'fields' => array(
                array(
                    'value' => 'one',
                    'label' => 'Field one',
                    'image' => PB_ASSEST . 'img/__tmp/1.png'
                ),
                array(
                    'value' => 'two',
                    'label' => 'Field two',
                    'image' => PB_ASSEST . 'img/__tmp/2.png'
                ),
                array(
                    'value' => 'three',
                    'label' => 'Field three',
                    'image' => PB_ASSEST . 'img/__tmp/3.png'
                ),
            ),
            'value' => 'two',
        ),*/
        /*array(
            'type' => 'radio',
            'heading' => __( 'Field', PBTD ),
            'param_name' => 'field_radio',
            'description' => __( 'Some description.', PBTD ),
            'fields' => array( 'one' => 'Field one', 'two' => 'Field two', 'three' => 'Field three' ),
            'value' => 'two'
        ),*/
        /*array(
            'type' => 'checkbox',
            'heading' => __( 'Field', PBTD ),
            'param_name' => 'field_checkbox',
            'description' => __( 'Some description.', PBTD ),
            'fields' => array( 'one' => 'Field one' ),
            'value' => 'one'
        ),*/
        /*array(
            'type' => 'checkbox',
            'heading' => __( 'Field', PBTD ),
            'param_name' => 'field_checkbox',
            'description' => __( 'Some description.', PBTD ),
            'fields' => array( 'one' => 'Field one', 'two' => 'Field two', 'three' => 'Field three' ),
            'value' => array( 'one', 'three' )
        ),*/
        /*array(
            'type' => 'attach_file',
            'heading' => __( 'Field', PBTD ),
            'param_name' => 'field_attach_file',
            'description' => __( 'Some description.', PBTD ),
        ),*/
        /*array(
            'type' => 'true_false',
            'heading' => __( 'Field checkbox', PBTD ),
            'param_name' => 'field_true_false',
            'description' => __( 'Some description here', PBTD ),
            'value' => true
        ),*/
        /*array(
            'type' => 'colorpicker',
            'heading' => __( 'Field', PBTD ),
            'param_name' => 'field_colorpicker',
            'description' => __( 'Some description.', PBTD ),
        ),*/
    ),
));

# testimonials wrapper
/*Bwpb_map::map(array(
    'name' => __( 'Testimonials', PBTD ),
    'base' => 'bw_testimonials_wrapper',
    'icon' => 'bwpb-icon-testimonial-wrapper',
    'description' => __( 'Testimonials Wrapper', PBTD ),
    'category' => __( 'General', PBTD ),
    'params' => array(
        array(
            'type' => 'textfield',
            'heading' => __( 'Extra class name', PBTD ),
            'param_name' => 'class',
            'description' => __( 'Add classname to this element for additional styles.', PBTD ),
        ),
    ),
    'view' => 'listing',
    'container_child' => array( 'bw_testimonials_item_white', 'bw_testimonials_item_black' )
));

# testimonials item - white
Bwpb_map::map(array(
    'name' => __( 'Testimonials Item White', PBTD ),
    'base' => 'bw_testimonials_item_white',
    'icon' => 'bwpb-icon-testimonial-item-white',
    'description' => __( 'Testimonial Item White', PBTD ),
    'category' => __( 'General', PBTD ),
    'params' => array(
        array(
            'type' => 'textfield',
            'param_name' => 'name',
            'heading' => __( 'Testimonial name', PBTD ),
            'holder' => 'span'
        ),
        array(
            'type' => 'textfield',
            'param_name' => 'class',
            'heading' => __( 'Extra class name', PBTD ),
            'description' => __( 'Add classname to this element for additional styles', PBTD ),
        ),
    ),
    'view' => 'listing_item',
    'container_parent' => 'bw_testimonials_wrapper'
));

# testimonials item - black
Bwpb_map::map(array(
    'name' => __( 'Testimonials Item Black', PBTD ),
    'base' => 'bw_testimonials_item_black',
    'icon' => 'bwpb-icon-testimonial-item-black',
    'description' => __( 'Testimonial Item Black', PBTD ),
    'params' => array(
        array(
            'type' => 'textfield',
            'param_name' => 'name',
            'heading' => __( 'Testimonial name', PBTD ),
            'holder' => 'span'
        ),
        array(
            'type' => 'textfield',
            'param_name' => 'class',
            'heading' => __( 'Extra class name', PBTD ),
            'description' => __( 'Add classname to this element for additional styles', PBTD ),
        ),
    ),
    'view' => 'listing_item',
    'container_parent' => 'bw_testimonials_wrapper'
));*/

# bargraph wrapper
/*Bwpb_map::map(array(
    'name' => __( 'Bargraph', PBTD ),
    'base' => 'bw_bargraph_wrapper',
    'icon' => 'bwpb-icon-bargraph-wrapper',
    'description' => __( 'Bargraph Wrapper', PBTD ),
    'category' => __( 'General', PBTD ),
    'params' => array(
        array(
            'type' => 'textfield',
            'heading' => __( 'Extra class name', PBTD ),
            'param_name' => 'class',
            'description' => __( 'Add classname to this element for additional styles.', PBTD ),
        ),
    ),
    'view' => 'listing',
    'container_child' => 'bw_bargraph_item'
));*/

# bargraph item
/*Bwpb_map::map(array(
    'name' => __( 'Bargraph Item', PBTD ),
    'base' => 'bw_bargraph_item',
    'icon' => 'bwpb-icon-bargraph-item',
    'description' => __( 'Bargraph Item', PBTD ),
    'category' => __( 'General', PBTD ),
    'params' => array(
        array(
            'type' => 'textfield',
            'param_name' => 'class',
            'heading' => __( 'Extra class name', PBTD ),
            'description' => __( 'Add classname to this element for additional styles', PBTD ),
        ),
    ),
    'view' => 'listing_item',
    'container_parent' => 'bw_bargraph_wrapper'
));*/

# tab wrapper
Bwpb_map::map(array(
    'name' => __( 'Tab', PBTD ),
    'base' => 'bw_tab_wrapper',
    'icon' => 'bwpb-icon-tab-wrapper',
    'description' => __( 'Tabbed Content', PBTD ),
    'category' => __( 'General', PBTD ),
    'params' => array(
        array(
            'type' => 'textfield',
            'param_name' => 'class'
        )
    ),
    'view' => 'tab',
    'max_tabs' => 10,
    'container_child' => 'bw_tab_item',
    //'tab_text' => __( 'Slide', PBTD )
));

# tab item
Bwpb_map::map(array(
    'name' => __( 'Tab Item', PBTD ),
    'base' => 'bw_tab_item',
    'icon' => 'bwpb-icon-tab-item',
    'description' => __( 'Tab section', PBTD ),
    'category' => __( 'General', PBTD ),
    'params' => array(
        array(
            'type' => 'textfield',
            'param_name' => 'title',
            'heading' => __( 'Title', PBTD ),
            'value' => 'Tab title',
            'holder' => 'h4'
        ),
        array(
            'type' => 'editor',
            'is_content' => true,
            'param_name' => 'content',
            'heading' => __( 'Content', PBTD ),
            'value' => 'I am a tab section. Lorem ipsum dolor sit amet, consectetur adipiscing elit',
        ),
        array(
            'type' => 'textfield',
            'param_name' => 'class'
        )
    ),
    'view' => 'tab_item',
    'container_parent' => 'bw_tab_wrapper',
));

# pricing table
Bwpb_map::map(array(
    'name' => __( 'Pricing Table', PBTD ),
    'base' => 'bw_pricing_table_wrapper',
    'icon' => 'bwpb-icon-pricing-table',
    'description' => __( 'Stylish Pricing tables', PBTD ),
    'category' => __( 'General', PBTD ),
    'params' => array(
        array(
            'type' => 'textfield',
            'param_name' => 'class'
        )
    ),
    'view' => 'tab',
    'max_tabs' => 5,
    'container_child' => 'bw_pricing_table_item',
    'tab_text' => __( 'Column', PBTD )
));

# pricing column
Bwpb_map::map(array(
    'name' => __( 'Pricing Column', PBTD ),
    'base' => 'bw_pricing_table_item',
    'icon' => 'bwpb-icon-pricing-column',
    'description' => __( 'Pricing table section', PBTD ),
    'category' => __( 'General', PBTD ),
    'params' => array(
        array(
            'type' => 'textfield',
            'param_name' => 'title',
            'heading' => __( 'Title', PBTD ),
            'value' => 'Column',
            'holder' => 'h4',
            'description' => 'Please enter a title for your pricing column.',
            'width' => 50
        ),
        array(
            'type' => 'textfield',
            'param_name' => 'price',
            'heading' => __( 'Price', PBTD ),
            'value' => '99',
            'holder' => 'span',
            'description' => 'Enter the price for your column.',
            'width' => 50
        ),
        array(
            'type' => 'textfield',
            'param_name' => 'currency',
            'heading' => __( 'Currency', PBTD ),
            'value' => '$',
            'holder' => 'span',
            'description' => 'Enter the currency symbol that will display for your price.',
            'width' => 50
        ),
        array(
            'type' => 'textfield',
            'param_name' => 'interval',
            'heading' => __( 'Interval', PBTD ),
            'value' => '/per year',
            'holder' => 'span',
            'description' => 'Enter the interval for your pricing e.g. "/year" or "/mo".',
            'width' => 50
        ),
        array(
            'type' => 'textfield',
            'param_name' => 'summary',
            'heading' => __( 'Summary', PBTD ),
            'value' => '',
            'holder' => 'span',
            'description' => '',
        ),
        array(
            'type' => 'true_false',
            'heading' => __( 'Highlight Column', PBTD ),
            'param_name' => 'highlight',
            'description' => 'Enable the option to focus on this column.'
        ),
        array(
            'type' => 'colorpicker',
            'param_name' => 'highlight_color',
            'heading' => __( 'Highlight Color', PBTD ),
            'value' => '#62dc82',
            'dependency' => array( 'element' => 'highlight', 'value' => '1' ),
        ),
        array(
            'type' => 'editor',
            'is_content' => true,
            'param_name' => 'content',
            'heading' => __( 'Content', PBTD ),
            'value' => '<ul class="bwpb-pricing-features" style="height: 219px;"><li>This is included</li><li>And this too</li><li>Maybe even this</li><li>Nevermind, it&rsquo;s not</li></ul><p><a style="margin:10px 0 40px 0;" class="bwpb-button large bwpb-button-light-green" href="#">Sign up now!</a></p>',
        ),
        array(
            'type' => 'textfield',
            'param_name' => 'class'
        )
    ),
    'view' => 'tab_item',
    'container_parent' => 'bw_pricing_table_wrapper',
));

# video player
Bwpb_map::map(array(
    'name' => __( 'Video Player', PBTD ),
    'base' => 'bw_video_player',
    'icon' => 'bwpb-icon-video-player',
    'description' => __( 'Embed video player.', PBTD ),
    'open_settings_on_create' => true,
    'category' => __( 'General', PBTD ),
    'params' => array(
        array(
            'type' => 'textfield',
            'heading' => __( 'Video link', PBTD ),
            'param_name' => 'video',
            'is_content' => true,
            'holder' => 'span',
            'description' => __( 'Link to the video. More about supported formats at <a target="_blank" href="http://codex.wordpress.org/Embeds#Okay.2C_So_What_Sites_Can_I_Embed_From.3F">WordPress codex page</a>.', PBTD ),
        ),
        array(
            'type' => 'textfield',
            'param_name' => 'class'
        )
    ),
));

# youtube / vimeo player
Bwpb_map::map(array(
    'name' => __( 'Cover Video Player', PBTD ),
    'base' => 'bw_embed_player',
    'icon' => 'bwpb-icon-video-embed',
    'description' => __( 'Player with cover image or lightbox.', PBTD ),
    'open_settings_on_create' => true,
    'category' => __( 'General', PBTD ),
    'params' => array(
        array(
            'type' => 'select',
            'heading' => __( 'Media source', PBTD ),
            'param_name' => 'media_source',
            'fields' => array(
                'youtube' => 'Youtube',
                'vimeo' => 'Vimeo',
            ),
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Video url', PBTD ),
            'param_name' => 'url',
            'is_content' => true
        ),
        array(
            'type' => 'true_false',
            'heading' => __( 'Enable video cover', PBTD ),
            'param_name' => 'enable_cover',
        ),
        array(
            'type' => 'image',
            'heading' => __( 'Cover image', PBTD ),
            'param_name' => 'cover_img',
            'dependency' => array( 'element' => "enable_cover", 'value' => '1' ),
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Cover text', PBTD ),
            'param_name' => 'cover_text',
            'value' => __( 'Watch the video', PBTD ),
            'dependency' => array( 'element' => "enable_cover", 'value' => '1' ),
        ),
        array(
            'type' => 'colorpicker',
            'heading' => __( 'Cover text color', PBTD ),
            'param_name' => 'cover_text_color',
            'dependency' => array( 'element' => "enable_cover", 'value' => '1' ),
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Video title', PBTD ),
            'param_name' => 'video_title',
            'dependency' => array( 'element' => "enable_cover", 'value' => '1' ),
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Video sub title', PBTD ),
            'param_name' => 'video_sub_title',
            'dependency' => array( 'element' => "enable_cover", 'value' => '1' ),
        ),
        array(
            'type' => 'textfield',
            'param_name' => 'class'
        )
    ),
));

# progress bar wrapper
Bwpb_map::map(array(
    'name' => __( 'Progress Bar', PBTD ),
    'base' => 'bw_progress_bar_wrapper',
    'icon' => 'bwpb-icon-progress-bar',
    'description' => __( 'Include a horizontal progress bar', PBTD ),
    'category' => __( 'General', PBTD ),
    'params' => array(
        array(
            'type' => 'textfield',
            'param_name' => 'class'
        )
    ),
    'view' => 'tab',
    'max_tabs' => 10,
    'container_child' => 'bw_progress_bar_item',
    'tab_text' => __( 'Bar', PBTD )
));

# progress bar item
Bwpb_map::map(array(
    'name' => __( 'Progress Bar Item', PBTD ),
    'base' => 'bw_progress_bar_item',
    'icon' => 'bwpb-icon-progress-bar-item',
    'description' => __( 'Progress bar item', PBTD ),
    'category' => __( 'General', PBTD ),
    'params' => array(
        array(
            'type' => 'textfield',
            'param_name' => 'title',
            'heading' => __( 'Title', PBTD ),
            'value' => 'Title',
            'holder' => 'h4'
        ),
        array(
            'type' => 'number_slider',
            'heading' => __( 'Percentage', PBTD ),
            'param_name' => 'percentage',
            'append_before' => '',
            'append_after' => '%',
            'value' => 50,
            'holder' => 'span'
        ),
        array(
            'type' => 'colorpicker',
            'heading' => __( 'Custom color', PBTD ),
            'param_name' => 'custom_color'
        ),
        array(
            'type' => 'true_false',
            'heading' => __( 'Enable counter', PBTD ),
            'param_name' => 'enable_counter',
            'value' => '1'
        ),
        array(
            'type' => 'textfield',
            'param_name' => 'more',
            'heading' => __( 'After counter text', PBTD ),
            'description' => __( 'Add some short info after the counter number, could be "%" too.', PBTD ),
            'holder' => 'span',
            'dependency' => array( 'element' => "enable_counter", 'value' => '1' ),
        ),
        array(
            'type' => 'textfield',
            'param_name' => 'class'
        )
    ),
    'view' => 'tab_item',
    'container_parent' => 'bw_progress_bar_wrapper',
));

# separator
Bwpb_map::map(array(
    'name' => __( 'Separator', PBTD ),
    'base' => 'bw_separator',
    'icon' => 'bwpb-icon-separator',
    'description' => __( 'Horizontal separator line', PBTD ),
    'category' => __( 'General', PBTD ),
    'params' => array(
        array(
            'type' => 'number_slider',
            'heading' => __( 'Margin top', PBTD ),
            'param_name' => 'margin_top',
            'min' => 0,
            'max' => 200,
            'step' => 1,
            'value' => 0,
            'append_before' => '',
            'append_after' => 'pixels.',
            'width' => 50
        ),
        array(
            'type' => 'number_slider',
            'heading' => __( 'Margin bottom', PBTD ),
            'param_name' => 'margin_bottom',
            'min' => 0,
            'max' => 200,
            'step' => 1,
            'value' => 0,
            'append_before' => '',
            'append_after' => 'pixels.',
            'width' => 50
        ),
        array(
            'type' => 'number_slider',
            'heading' => __( 'Separator height', PBTD ),
            'param_name' => 'height',
            'min' => 10,
            'max' => 200,
            'step' => 1,
            'value' => 10,
            'append_before' => '',
            'append_after' => 'pixels.',
        ),
        array(
            'type' => 'number_slider',
            'heading' => __( 'Separator width', PBTD ),
            'param_name' => 'width',
            'min' => 20,
            'max' => 100,
            'step' => 1,
            'value' => 100,
            'append_before' => '',
            'append_after' => '%',
        ),
        array(
            'type' => 'select',
            'heading' => __( 'Line type', PBTD ),
            'param_name' => 'line_type',
            'fields' => array(
                'solid' => 'Line',
                'dashed' => 'Dashed',
                'dotted' => 'Dotted',
                'double' => 'Double',
                'none' => 'None',
            ),
        ),
        array(
            'type' => 'colorpicker',
            'heading' => __( 'Custom border color', PBTD ),
            'param_name' => 'color',
        ),
        array(
            'type' => 'textfield',
            'param_name' => 'class'
        )
    ),
    'view' => 'separator'
));

# message
Bwpb_map::map(array(
    'name' => __( 'Message', PBTD ),
    'base' => 'bw_message',
    'icon' => 'bwpb-icon-message',
    'description' => __( 'Notification box', PBTD ),
    'open_settings_on_create' => true,
    'category' => __( 'General', PBTD ),
    'params' => array(
        array(
            'type' => 'select',
            'heading' => __( 'Message type', PBTD ),
            'param_name' => 'type',
            'fields' => array(
                'square' => 'Square',
                'rounded' => 'Rounded',
            ),
            'holder' => 'span',
            'description' => __( 'Add classname to this element for additional styles.', PBTD ),
        ),
        array(
            'type' => 'true_false',
            'heading' => __( 'Enable border', PBTD ),
            'param_name' => 'enable_border',
            'width' => 50
        ),
        array(
            'type' => 'true_false',
            'heading' => __( 'Enable icon', PBTD ),
            'param_name' => 'enable_icon',
            'width' => 50
        ),
        array(
            'type' => 'icon',
            'heading' => __( 'Icon', PBTD ),
            'param_name' => 'icon',
            'dependency' => array( 'element' => "enable_icon", 'value' => '1' ),
        ),
        array(
            'type' => 'colorpicker',
            'heading' => __( 'Message color', PBTD ),
            'param_name' => 'color',
        ),
        array(
            'type' => 'colorpicker',
            'heading' => __( 'Text / border color', PBTD ),
            'param_name' => 'text_color',
        ),
        array(
            'type' => 'editor',
            'param_name' => 'message',
            'heading' => __( 'Message', PBTD ),
            'value' => 'I am message. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean et nisi euismod, aliquam risus et, tempus augue.',
            'is_content' => true,
        ),
        array(
            'type' => 'textfield',
            'param_name' => 'class'
        )
    )
));

# icon
Bwpb_map::map(array(
    'name' => __( 'Icon', PBTD ),
    'base' => 'bw_icon',
    'icon' => 'bwpb-icon-icon',
    'description' => __( 'Custom icon from libraries', PBTD ),
    'open_settings_on_create' => true,
    'category' => __( 'General', PBTD ),
    'params' => array(
        array(
            'type' => 'icon',
            'heading' => __( 'Icon', PBTD ),
            'param_name' => 'icon',
        ),
        array(
            'type' => 'colorpicker',
            'heading' => __( 'Icon color', PBTD ),
            'param_name' => 'color',
        ),
        array(
            'type' => 'select',
            'heading' => __( 'Icon type', PBTD ),
            'param_name' => 'type',
            'fields' => array(
                '' => 'None',
                'circle' => 'Circle',
                'square' => 'Square',
                'rounded' => 'Rounded',
                'out_circle' => 'Outline circle',
                'out_square' => 'Outline square',
                'out_rounded' => 'Outline rounded',
            ),
            'description' => __( 'Add classname to this element for additional styles.', PBTD ),
        ),
        array(
            'type' => 'colorpicker',
            'heading' => __( 'Icon background color', PBTD ),
            'param_name' => 'bg_color',
            'dependency' => array( 'element' => "type", 'not_empty' => true ),
        ),
        array(
            'type' => 'number_slider',
            'heading' => __( 'Font size', PBTD ),
            'param_name' => 'size',
            'min' => 12,
            'max' => 60,
            'step' => 1,
            'value' => 18,
            'append_before' => '',
            'append_after' => 'pixels.',
        ),
        array(
            'type' => 'select',
            'heading' => __( 'Text alignment', PBTD ),
            'param_name' => 'text_alignment',
            'fields' => array( 'left' => 'Left', 'center' => 'Center', 'right' => 'Right' ),
        ),
        array(
            'type' => 'textfield',
            'param_name' => 'class'
        )
    )
));

# icon with text
Bwpb_map::map(array(
    'name' => __( 'Icon with text', PBTD ),
    'base' => 'bw_icon_text',
    'icon' => 'bwpb-icon-icon-text',
    'description' => __( 'Custom icon from libraries with text', PBTD ),
    'open_settings_on_create' => true,
    'category' => __( 'General', PBTD ),
    'params' => array(
        array(
            'type' => 'select',
            'heading' => __( 'Icon type', PBTD ),
            'param_name' => 'type',
            'fields' => array(
                'library' => 'Icons from library',
                'image' => 'Upload your own image',
            ),
            'description' => __( 'Add classname to this element for additional styles.', PBTD ),
        ),
        array(
            'type' => 'image',
            'heading' => __( 'Image for icon', PBTD ),
            'param_name' => 'image',
            'description' => __( 'Maximum width of image: 80 pixels.', PBTD ),
            'dependency' => array( 'element' => "type", 'value' => 'image' ),
        ),
        array(
            'type' => 'icon',
            'heading' => __( 'Icon', PBTD ),
            'param_name' => 'icon',
            'dependency' => array( 'element' => "type", 'value' => 'library' ),
        ),
        array(
            'type' => 'colorpicker',
            'heading' => __( 'Icon color', PBTD ),
            'param_name' => 'color',
        ),
        array(
            'type' => 'colorpicker',
            'heading' => __( 'Text color', PBTD ),
            'param_name' => 'text_color',
        ),
        array(
            'type' => 'select',
            'heading' => __( 'Title tag', PBTD ),
            'param_name' => 'h',
            'fields' => array(
                'h2' => 'h2',
                'h3' => 'h3',
                'h4' => 'h4',
                'h5' => 'h5',
                'h6' => 'h6',
            ),
            'value' => 'h4',
            'width' => 50
        ),
        array(
            'type' => 'select',
            'heading' => __( 'Icon style', PBTD ),
            'param_name' => 'style',
            'fields' => array(
                '' => 'None',
                'circle' => 'Circle',
                'square' => 'Square',
                'rounded' => 'Rounded',
                'out_circle' => 'Outline circle',
                'out_square' => 'Outline square',
                'out_rounded' => 'Outline rounded',
            ),
            'width' => 50
        ),
        array(
            'type' => 'colorpicker',
            'heading' => __( 'Icon background / border color', PBTD ),
            'param_name' => 'bg_color',
            'dependency' => array( 'element' => "style", 'not_empty' => true ),
        ),
        array(
            'type' => 'number_slider',
            'heading' => __( 'Icon size', PBTD ),
            'param_name' => 'size',
            'min' => 12,
            'max' => 60,
            'step' => 1,
            'value' => 18,
            'append_before' => '',
            'append_after' => 'pixels.',
            'dependency' => array( 'element' => "type", 'value' => 'library' ),
        ),
        array(
            'type' => 'select',
            'heading' => __( 'Text alignment', PBTD ),
            'param_name' => 'text_alignment',
            'fields' => array( 'left' => 'Left', 'center' => 'Center', 'right' => 'Right' ),
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Title', PBTD ),
            'param_name' => 'title',
            'value' => __( 'Title', PBTD ),
            'holder' => 'span'
        ),
        array(
            'type' => 'editor',
            'param_name' => 'content',
            'heading' => __( 'Text', PBTD ),
            'value' => 'Icon text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean et nisi euismod, aliquam risus et, tempus augue.',
            'is_content' => true,
        ),
        array(
            'type' => 'textfield',
            'param_name' => 'class'
        )
    )
));

# facebook like box
Bwpb_map::map(array(
    'name' => __( 'Facebook like box', PBTD ),
    'base' => 'bw_fb_like',
    'icon' => 'bwpb-icon-fb-like',
    'category' => __( 'Social', PBTD ),
    'description' => __( 'Add your facebook like button', PBTD ),
    'open_settings_on_create' => true,
    'params' => array(
        array(
            'type' => 'select',
            'heading' => __( 'Button type', PBTD ),
            'param_name' => 'type',
            'fields' => array(
                'standard' => 'Standard',
                'button_count' => 'Button count',
                'box_count' => 'Box cound',
            ),
            'holder' => 'span',
            'description' => __( 'Select button type', PBTD ),
        ),
    )
));

# facebook comments
Bwpb_map::map(array(
    'name' => __( 'Facebook comments', PBTD ),
    'base' => 'bw_fb_comments',
    'icon' => 'bwpb-icon-fb-comments',
    'category' => __( 'Social', PBTD ),
    'description' => __( 'Fb comments for the current page.', PBTD ),
    'params' => array(
        array(
            'type' => 'number_slider',
            'heading' => __( 'Comments shown', PBTD ),
            'param_name' => 'comments_shown',
            'min' => 1,
            'max' => 20,
            'step' => 1,
            'value' => 5,
            'append_before' => '',
            'append_after' => 'comments shown.',
            'holder' => 'span'
        ),
    )
));

# twitter button
Bwpb_map::map(array(
    'name' => __( 'Twitter button', PBTD ),
    'base' => 'bw_twitter_button',
    'icon' => 'bwpb-icon-twitter-button',
    'category' => __( 'Social', PBTD ),
    'description' => __( 'Add Twitter share button', PBTD ),
    'open_settings_on_create' => true,
    'params' => array(
        array(
            'type' => 'select',
            'heading' => __( 'Button type', PBTD ),
            'param_name' => 'type',
            'fields' => array(
                'horizintal' => 'Horizintal',
                'vertical' => 'Vertical',
                'none' => 'None',
            ),
            'holder' => 'span',
            'description' => __( 'Select button type', PBTD ),
        ),
    )
));

# google+ button
Bwpb_map::map(array(
    'name' => __( 'Google+ button', PBTD ),
    'base' => 'bw_google_plus_button',
    'icon' => 'bwpb-icon-google-plus-button',
    'category' => __( 'Social', PBTD ),
    'description' => __( 'Add Google+ button', PBTD ),
    'open_settings_on_create' => true,
    'params' => array(
        array(
            'type' => 'select',
            'heading' => __( 'Button size', PBTD ),
            'param_name' => 'size',
            'fields' => array(
                '' => 'Standard',
                'small' => 'Small',
                'medium' => 'Medium',
                'tall' => 'Tall',
            ),
            'holder' => 'span',
            'description' => __( 'Select button size', PBTD ),
        ),
        array(
            'type' => 'select',
            'heading' => __( 'Button type', PBTD ),
            'param_name' => 'type',
            'fields' => array(
                'inline' => 'Inline',
                '' => 'Bubble',
                'none' => 'None',
            ),
            'value' => 'inline',
            'holder' => 'span',
            'description' => __( 'Select type of annotation', PBTD ),
        ),
    )
));

# pinterest button
Bwpb_map::map(array(
    'name' => __( 'Pinterest button', PBTD ),
    'base' => 'bw_pinterest_button',
    'icon' => 'bwpb-icon-pinterest-button',
    'category' => __( 'Social', PBTD ),
    'description' => __( 'Add Pinterest share button', PBTD ),
    'open_settings_on_create' => true,
    'params' => array(
        array(
            'type' => 'select',
            'heading' => __( 'Style', PBTD ),
            'param_name' => 'style',
            'fields' => array(
                '' => 'Gray',
                'red' => 'Red',
                'white' => 'White',
            ),
            'holder' => 'span',
            'description' => __( 'Select button style', PBTD ),
        ),
    )
));

# flickr widget
Bwpb_map::map(array(
    'name' => __( 'Flickr widget', PBTD ),
    'base' => 'bw_flickr',
    'icon' => 'bwpb-icon-flickr',
    'category' => __( 'Social', PBTD ),
    'description' => __( 'Add flickr widget', PBTD ),
    'open_settings_on_create' => true,
    'params' => array(
        array(
            'type' => 'textfield',
            'heading' => __( 'Flickr ID', PBTD ),
            'param_name' => 'flickr_id',
            'description' => 'To find your flickID visit <a target="_blank" href="http://idgettr.com/">idGettr</a>.',
            'holder' => 'span'
        ),
        array(
            'type' => 'select',
            'heading' => __( 'Image order', PBTD ),
            'param_name' => 'order',
            'fields' => array(
                'latest' => 'Latest',
                'random' => 'Random',
            ),
            'holder' => 'span'
        ),
        array(
            'type' => 'select',
            'heading' => __( 'Image size', PBTD ),
            'param_name' => 'size',
            'fields' => array(
                's' => 'Small square box',
                't' => 'Thumbnail size',
                'm' => 'Medium size',
            ),
            'holder' => 'span'
        ),
    )
));

# faq
Bwpb_map::map(array(
    'name' => __( 'Faq', PBTD ),
    'base' => 'bw_faq_wrapper',
    'icon' => 'bwpb-icon-faq-wrapper',
    'description' => __( 'Toggle element', PBTD ),
    'category' => __( 'General', PBTD ),
    'params' => array(
        array(
            'type' => 'textfield',
            'param_name' => 'class'
        )
    ),
    'view' => 'listing',
    'container_child' => 'bw_faq_item'
));

# faq item
Bwpb_map::map(array(
    'name' => __( 'Faq item', PBTD ),
    'base' => 'bw_faq_item',
    'icon' => 'bwpb-icon-faq-item',
    'description' => __( 'Faq toggle element', PBTD ),
    'category' => __( 'General', PBTD ),
    'params' => array(
        array(
            'type' => 'textfield',
            'param_name' => 'title',
            'heading' => __( 'Title', PBTD ),
            'value' => __( 'Toggle title', PBTD ),
            'holder' => 'span'
        ),
        array(
            'type' => 'true_false',
            'heading' => __( 'State', PBTD ),
            'param_name' => 'state',
        ),
        array(
            'type' => 'select',
            'heading' => __( 'Style', PBTD ),
            'param_name' => 'style',
            'fields' => array(
                'none' => 'None',
                'circle' => 'Circle',
                'square' => 'Square',
                'outlined' => 'Outlined',
            ),
            'holder' => 'span'
        ),
        array(
            'type' => 'colorpicker',
            'heading' => __( 'Color', PBTD ),
            'param_name' => 'color',
        ),
        array(
            'type' => 'editor',
            'param_name' => 'content',
            'heading' => __( 'Content', PBTD ),
            'value' => 'Toggle content. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean et nisi euismod, aliquam risus et, tempus augue.',
            'is_content' => true,
        ),
        array(
            'type' => 'textfield',
            'param_name' => 'class'
        )
    ),
    'view' => 'listing_item',
    'container_parent' => 'bw_faq_wrapper'
));

$thumbnail_sizes = array();
foreach( get_intermediate_image_sizes() as $thumbnail ) {
    $thumbnail_sizes[ $thumbnail ] = $thumbnail;
}
$thumbnail_sizes['full'] = 'full';


# single image
Bwpb_map::map(array(
    'name' => __( 'Single image', PBTD ),
    'base' => 'bw_single_image',
    'icon' => 'bwpb-icon-single-image',
    'description' => __( 'Add single image', PBTD ),
    'open_settings_on_create' => true,
    'category' => __( 'General', PBTD ),
    'params' => array(
        array(
            'type' => 'image',
            'heading' => __( 'Image', PBTD ),
            'param_name' => 'image',
        ),
        array(
            'type' => 'select',
            'heading' => __( 'Size', PBTD ),
            'param_name' => 'size',
            'fields' => $thumbnail_sizes,
            'holder' => 'span',
            'width' => 50
        ),
        array(
            'type' => 'select',
            'heading' => __( 'Alignment', PBTD ),
            'param_name' => 'alignment',
            'fields' => array( 'left' => 'Left', 'center' => 'Center', 'right' => 'Right' ),
            'width' => 50
        ),
        array(
            'type' => 'select',
            'heading' => __( 'Style', PBTD ),
            'param_name' => 'style',
            'fields' => array(
                'none' => 'None',
                'border' => 'Border',
                'rounded' => 'Rounded',
                'circle' => 'Circle'
            ),
            'holder' => 'span'
        ),
        array(
            'type' => 'select',
            'heading' => __( 'Function', PBTD ),
            'param_name' => 'function',
            'fields' => array(
                'none' => 'None',
                'link' => 'Link',
                'lightbox' => 'Lightbox',
            ),
            'holder' => 'span'
        ),
        array(
            'type' => 'textfield',
            'param_name' => 'link_url',
            'heading' => __( 'Link url', PBTD ),
            'placeholder' => 'http://',
            'dependency' => array( 'element' => "function", 'value' => 'link' ),
            'width' => 50,
            'is_content' => true
        ),
        array(
            'type' => 'true_false',
            'heading' => __( 'Open link in a new tab', PBTD ),
            'param_name' => 'new_tab',
            'dependency' => array( 'element' => "function", 'value' => 'link' ),
            'width' => 50
        ),
        array(
            'type' => 'textfield',
            'param_name' => 'class'
        )
    )
));


# sidebar
Bwpb_map::map(array(
    'name' => __( 'Sidebar', PBTD ),
    'base' => 'bw_sidebar',
    'icon' => 'bwpb-icon-sidebar',
    'description' => __( 'Place a sidebar', PBTD ),
    'open_settings_on_create' => true,
    'category' => __( 'General', PBTD ),
    'params' => array(
        array(
            'type' => 'textfield',
            'heading' => __( 'Title', PBTD ),
            'param_name' => 'title',
        ),
        array(
            'type' => 'sidebars',
            'heading' => __( 'Sidebar area', PBTD ),
            'param_name' => 'sidebar_id',
            'description' => 'Select which widget area output.',
        ),
        array(
            'type' => 'textfield',
            'param_name' => 'class'
        )
    )
));

# button
Bwpb_map::map(array(
    'name' => __( 'Button', PBTD ),
    'base' => 'bw_button',
    'icon' => 'bwpb-icon-button',
    'description' => __( 'Add simple button', PBTD ),
    'open_settings_on_create' => true,
    'category' => __( 'General', PBTD ),
    'params' => array(
        array(
            'type' => 'textfield',
            'heading' => __( 'Text on the button', PBTD ),
            'param_name' => 'text',
            'value' => 'This is a button',
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Url', PBTD ),
            'param_name' => 'url',
            'placeholder' => 'http://',
        ),
        array(
            'type' => 'colorpicker',
            'heading' => __( 'Background color', PBTD ),
            'param_name' => 'bg_color',
        ),
        array(
            'type' => 'colorpicker',
            'heading' => __( 'Background color on hover', PBTD ),
            'param_name' => 'bg_color_hover',
        ),
        array(
            'type' => 'colorpicker',
            'heading' => __( 'Text color', PBTD ),
            'param_name' => 'text_color',
            
        ),
        array(
            'type' => 'true_false',
            'heading' => __( 'Enable icon', PBTD ),
            'param_name' => 'enable_icon',
        ),
        array(
            'type' => 'icon',
            'heading' => __( 'Icon', PBTD ),
            'param_name' => 'icon',
            'dependency' => array( 'element' => "enable_icon", 'value' => '1' ),
        ),
        array(
            'type' => 'select',
            'heading' => __( 'Size', PBTD ),
            'param_name' => 'size',
            'fields' => array(
                'regular' => 'Regular',
                'large' => 'Large',
                'small' => 'Small',
                'mini' => 'Mini',
            ),
        ),
        array(
            'type' => 'textfield',
            'param_name' => 'class'
        )
    )
));


# pie chart
Bwpb_map::map(array(
    'name' => __( 'Pie chart', PBTD ),
    'base' => 'bw_pie',
    'icon' => 'bwpb-icon-pie',
    'description' => __( 'Animated pie chart', PBTD ),
    'open_settings_on_create' => true,
    'category' => __( 'General', PBTD ),
    'params' => array(
        array(
            'type' => 'textfield',
            'heading' => __( 'Title', PBTD ),
            'param_name' => 'title',
            'value' => 'Pie chart title',
            'holder' => 'span'
        ),
        array(
            'type' => 'number_slider',
            'heading' => __( 'Percent', PBTD ),
            'param_name' => 'percent',
            'min' => 0,
            'max' => 100,
            'step' => 1,
            'value' => 50,
            'append_before' => '',
            'append_after' => '%',
            'description' => 'Progress of the pie chart in percentage.',
            'width' => 50
        ),
        array(
            'type' => 'number_slider',
            'heading' => __( 'Line width', PBTD ),
            'param_name' => 'line_width',
            'min' => 1,
            'max' => 30,
            'step' => 1,
            'value' => 5,
            'append_before' => '',
            'append_after' => 'pixels.',
            'description' => 'Width of the bar.',
            'width' => 50
        ),
        array(
            'type' => 'number_slider',
            'heading' => __( 'Maximum pie width', PBTD ),
            'param_name' => 'size',
            'min' => 30,
            'max' => 400,
            'step' => 1,
            'value' => 150,
            'append_before' => '',
            'append_after' => 'pixels.'
        ),
        array(
            'type' => 'colorpicker',
            'heading' => __( 'Track color', PBTD ),
            'param_name' => 'track_color'
        ),
        array(
            'type' => 'colorpicker',
            'heading' => __( 'Bar and text color', PBTD ),
            'param_name' => 'bar_color'
        ),
        array(
            'type' => 'true_false',
            'heading' => __( 'Enable animation', PBTD ),
            'param_name' => 'enable_animation',
            'tab' => __( 'Animation', PBTD )
        ),
        array(
            'type' => 'number_slider',
            'heading' => __( 'Animation speed', PBTD ),
            'param_name' => 'animation_speed',
            'min' => 100,
            'max' => 5000,
            'step' => 50,
            'value' => 500,
            'append_before' => '',
            'append_after' => 'milliseconds.',
            'description' => '1 second = 1000 milliseconds.',
            'dependency' => array( 'element' => "enable_animation", 'value' => '1' ),
            'tab' => __( 'Animation', PBTD )
        ),
        array(
            'type' => 'number_slider',
            'heading' => __( 'Animation delay', PBTD ),
            'param_name' => 'animation_delay',
            'min' => 0,
            'max' => 6000,
            'step' => 50,
            'value' => 0,
            'append_before' => '',
            'append_after' => 'milliseconds.',
            'description' => '1 second = 1000 milliseconds.',
            'dependency' => array( 'element' => "enable_animation", 'value' => '1' ),
            'tab' => __( 'Animation', PBTD )
        ),
        array(
            'type' => 'select',
            'heading' => __( 'Style', PBTD ),
            'param_name' => 'line_cap',
            'fields' => array(
                'butt' => 'Butt',
                'round' => 'Round',
            ),
        ),
        array(
            'type' => 'textfield',
            'param_name' => 'class'
        )
    )
));


# number counter
Bwpb_map::map(array(
    'name' => __( 'Number counter', PBTD ),
    'base' => 'bw_number_counter',
    'icon' => 'bwpb-icon-number-counter',
    'description' => __( 'Animated number counter', PBTD ),
    'open_settings_on_create' => true,
    'category' => __( 'General', PBTD ),
    'params' => array(
        array(
            'type' => 'textfield',
            'heading' => __( 'Title', PBTD ),
            'param_name' => 'title',
            'value' => 'Animated number counter title',
            'holder' => 'span'
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Number', PBTD ),
            'param_name' => 'number',
            'value' => 50,
            'holder' => 'span',
            'placeholder' => '1234'
        ),
        array(
            'type' => 'select',
            'heading' => __( 'Text alignment', PBTD ),
            'param_name' => 'text_alignment',
            'fields' => array( 'left' => 'Left', 'center' => 'Center', 'right' => 'Right' ),
            'width' => 50
        ),
        array(
            'type' => 'colorpicker',
            'heading' => __( 'Color', PBTD ),
            'param_name' => 'color',
        ),
        array(
            'type' => 'true_false',
            'heading' => __( 'Enable icon', PBTD ),
            'param_name' => 'enable_icon'
        ),
        array(
            'type' => 'icon',
            'heading' => __( 'Icon', PBTD ),
            'param_name' => 'icon',
            'dependency' => array( 'element' => "enable_icon", 'value' => '1' ),
        ),
        array(
            'type' => 'true_false',
            'heading' => __( 'Enable animation', PBTD ),
            'param_name' => 'enable_animation',
            'tab' => __( 'Animation', PBTD )
        ),
        array(
            'type' => 'number_slider',
            'heading' => __( 'Animation speed', PBTD ),
            'param_name' => 'animation_speed',
            'min' => 500,
            'max' => 6000,
            'step' => 50,
            'value' => 500,
            'append_before' => '',
            'append_after' => 'milliseconds.',
            'description' => '1 second = 1000 milliseconds.',
            'dependency' => array( 'element' => 'enable_animation', 'value' => '1' ),
            'tab' => __( 'Animation', PBTD )
        ),
        array(
            'type' => 'number_slider',
            'heading' => __( 'Animation delay', PBTD ),
            'param_name' => 'animation_delay',
            'min' => 0,
            'max' => 6000,
            'step' => 50,
            'value' => 0,
            'append_before' => '',
            'append_after' => 'milliseconds.',
            'description' => '1 second = 1000 milliseconds.',
            'dependency' => array( 'element' => "enable_animation", 'value' => '1' ),
            'tab' => __( 'Animation', PBTD )
        ),
        array(
            'type' => 'textfield',
            'param_name' => 'class'
        )
    )
));


# latest posts
Bwpb_map::map(array(
    'name' => __( 'Latest posts', PBTD ),
    'base' => 'bw_latest_posts',
    'icon' => 'bwpb-icon-latest-posts',
    'description' => __( 'Latest post from any post format', PBTD ),
    'open_settings_on_create' => true,
    'category' => __( 'General', PBTD ),
    'params' => array(
        array(
            'type' => 'number_slider',
            'heading' => __( 'Items per row', PBTD ),
            'param_name' => 'items_per_row',
            'min' => 1,
            'max' => 6,
            'step' => 1,
            'value' => 3,
            'append_before' => '',
            'append_after' => '',
            'description' => 'The number of items per row.',
            'width' => 50
        ),
        array(
            'type' => 'number_slider',
            'heading' => __( 'Number of items', PBTD ),
            'param_name' => 'items_total',
            'min' => 1,
            'max' => 30,
            'step' => 1,
            'value' => 8,
            'append_before' => '',
            'append_after' => '',
            'description' => 'The total number of items per page.',
            //'dependency' => array( 'element' => "enable_animation", 'value' => '1' ),
            'width' => 50
        ),
        array(
            'type' => 'select',
            'heading' => __( 'Post type', PBTD ),
            'param_name' => 'post_type',
            'fields' => array(
                'post' => 'Post',
            ),
            'description' => __( 'Choose the post type you want to display.', PBTD ),
            'width' => 50
        ),
        array(
            'type' => 'select',
            'heading' => __( 'Layout type', PBTD ),
            'param_name' => 'layout',
            'fields' => array(
                'grid' => 'Grid',
                'masonry' => 'Masonry',
                'wall' => 'Wall',
            ),
            'description' => __( 'Style type of the grid.', PBTD ),
            'width' => 50
        ),
        array(
            'type' => 'true_false',
            'heading' => __( 'Enable category filter', PBTD ),
            'param_name' => 'enable_cat',
            'width' => 50
        ),
        array(
            'type' => 'true_false',
            'heading' => __( 'Enable pagination', PBTD ),
            'param_name' => 'enable_pag',
            'width' => 50
        ),
        array(
            'type' => 'number_slider',
            'heading' => __( 'Gap', PBTD ),
            'param_name' => 'gap',
            'min' => 0,
            'max' => 35,
            'step' => 1,
            'value' => 25,
            'append_before' => '',
            'append_after' => 'pixels.',
            'description' => 'Select gap between grid elements.',
            'width' => 50
        ),
        array(
            'type' => 'number_slider',
            'heading' => __( 'Left and right spacing', PBTD ),
            'param_name' => 'left_right_space',
            'min' => 0,
            'max' => 35,
            'step' => 1,
            'value' => 0,
            'append_before' => '',
            'append_after' => 'pixels.',
            'description' => 'Select left and right grid container spacing.',
            'width' => 50
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Only shows specified categori(es)', PBTD ),
            'param_name' => 'spec_cat',
            'description' => __( 'Comma separated SLUG of the categori(es).', PBTD ),
        ),
        array(
            'type' => 'textfield',
            'param_name' => 'class'
        )
    )
));

# google map wrapper
Bwpb_map::map(array(
    'name' => __( 'Google map', PBTD ),
    'base' => 'bw_google_map_wrapper',
    'icon' => 'bwpb-icon-google-map',
    'description' => __( 'Add advanced Google map with pins.', PBTD ),
    'category' => __( 'General', PBTD ),
    'params' => array(
        array(
            'type' => 'number_slider',
            'heading' => __( 'Map zoom', PBTD ),
            'param_name' => 'zoom',
            'min' => 1,
            'max' => 21,
            'step' => 1,
            'value' => 14,
            'append_before' => '',
            'append_after' => '',
            'description' => 'This scale represents the zoom of the map. It is ignored if you have more that one pin without additional map center.',
        ),
        array(
            'type' => 'true_false',
            'heading' => __( 'Enable map full height', PBTD ),
            'param_name' => 'fullheight',
        ),
        array(
            'type' => 'number_slider',
            'heading' => __( 'Map ratio', PBTD ),
            'param_name' => 'ratio',
            'min' => 0.1,
            'max' => 0.9,
            'step' => 0.1,
            'value' => 0.6,
            'append_before' => '',
            'append_after' => '',
            'description' => 'The height of the map.',
            'dependency' => array( 'element' => "fullheight", 'value' => 'false' ),
        ),
        array(
            'type' => 'true_false',
            'heading' => __( 'Enable map pin animation', PBTD ),
            'param_name' => 'pin_anim',
            'description' => '',
        ),
        array(
            'type' => 'true_false',
            'heading' => __( 'Enable infobox', PBTD ),
            'param_name' => 'infobox',
            'description' => '',
            'width' => 50,
        ),
        array(
            'type' => 'true_false',
            'heading' => __( 'Open first pin at start', PBTD ),
            'param_name' => 'first_pin',
            'description' => '',
            'width' => 50,
        ),
        array(
            'type' => 'true_false',
            'heading' => __( 'Set additional map center.', PBTD ),
            'param_name' => 'add_center',
            'description' => 'Leave unchecked to center the map between all the pins. Map zoom will be ignored if you have more that one pin and this option in unchecked.',
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Latitude', PBTD ),
            'param_name' => 'latitude',
            'dependency' => array( 'element' => "add_center", 'value' => '1' ),
            'width' => 50
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Longitude', PBTD ),
            'param_name' => 'longitude',
            'dependency' => array( 'element' => "add_center", 'value' => '1' ),
            'width' => 50
        ),
        array(
            'type' => 'base64',
            'heading' => __( 'Map additional styling ( advanced users ).', PBTD ),
            'param_name' => 'style',
            'description' => 'You can change the map style by adding Javascript style array, you can generate some <a target="_blank" href="https://snazzymaps.com/">here</a>.',
        ),
        array(
            'type' => 'textfield',
            'param_name' => 'class'
        )
    ),
    'view' => 'listing',
    'container_child' => 'bw_google_map_pin'
));

# google map pin
Bwpb_map::map(array(
    'name' => __( 'Google map pin', PBTD ),
    'base' => 'bw_google_map_pin',
    'icon' => 'bwpb-icon-google-map-pin',
    'description' => __( 'Add pin location for Google map.', PBTD ),
    'category' => __( 'General', PBTD ),
    'params' => array(
        array(
            'type' => 'textfield',
            'param_name' => 'title',
            'heading' => __( 'Pin title', PBTD ),
            'holder' => 'span',
        ),
        array(
            'type' => 'true_false',
            'heading' => __( 'Enable pin popup.', PBTD ),
            'param_name' => 'popup',
        ),
        array(
            'type' => 'textarea',
            'param_name' => 'desc',
            'heading' => __( 'Pin description', PBTD ),
            'dependency' => array( 'element' => "popup", 'value' => '1' )
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Latitude', PBTD ),
            'param_name' => 'latitude',
            'holder' => 'span'
        ),
        array(
            'type' => 'textfield',
            'heading' => __( 'Longitude', PBTD ),
            'param_name' => 'longitude',
            'holder' => 'span'
        ),
        array(
            'type' => 'image',
            'heading' => __( 'Pin image', PBTD ),
            'param_name' => 'image',
            'description' => __( 'Leave empty for default pin. 150px x 150px max.', PBTD ),
        ),
    ),
    'view' => 'listing_item',
    'container_parent' => 'bw_google_map_wrapper'
));

# client slider wrapper
Bwpb_map::map(array(
    'name' => __( 'Client slider', PBTD ),
    'base' => 'bw_client_slider_wrapper',
    'icon' => 'bwpb-icon-client-slider',
    'description' => __( 'Slider with list of clients', PBTD ),
    'category' => __( 'General', PBTD ),
    'params' => array(
        array(
            'type' => 'number_slider',
            'heading' => __( 'Number of clients', PBTD ),
            'param_name' => 'slides',
            'min' => 1,
            'max' => 10,
            'step' => 1,
            'value' => 3,
            'append_before' => '',
            'append_after' => 'slides.',
            'description' => 'The number of visible slides.',
        ),
        array(
            'type' => 'true_false',
            'heading' => __( 'Enable dot navigation', PBTD ),
            'param_name' => 'dots',
            'width' => 50
        ),
        array(
            'type' => 'true_false',
            'heading' => __( 'Autoheight', PBTD ),
            'param_name' => 'autoheight',
            //'description' => __( 'Change the slide height automatically.', PBTD ),
            'width' => 50
        ),
        array(
            'type' => 'true_false',
            'heading' => __( 'Autoplay', PBTD ),
            'param_name' => 'autoplay'
        ),
        array(
            'type' => 'number_slider',
            'heading' => __( 'Autoplay timeout', PBTD ),
            'param_name' => 'autoplay_timeout',
            'min' => 2000,
            'max' => 10000,
            'step' => 500,
            'value' => 5000,
            'append_before' => '',
            'append_after' => 'milliseconds.',
            'description' => '1 second = 1000 milliseconds.',
            'dependency' => array( 'element' => "autoplay", 'value' => '1' ),
        ),
        array(
            'type' => 'textfield',
            'param_name' => 'class'
        )
    ),
    'view' => 'tab',
    'max_tabs' => 30,
    'container_child' => 'bw_client_slider_item',
    'tab_text' => __( 'Slide', PBTD )
));

# client slider item
Bwpb_map::map(array(
    'name' => __( 'Client slide', PBTD ),
    'base' => 'bw_client_slider_item',
    'icon' => 'bwpb-icon-client-slider-item',
    'description' => __( 'Client slide', PBTD ),
    'category' => __( 'General', PBTD ),
    'params' => array(
        array(
            'type' => 'textfield',
            'param_name' => 'name',
            'heading' => __( 'Client name', PBTD ),
            'value' => 'Client slide',
            'holder' => 'h4'
        ),
        array(
            'type' => 'image',
            'heading' => __( 'Client image', PBTD ),
            'param_name' => 'image',
            'holder' => 'span'
        ),
        array(
            'type' => 'textfield',
            'param_name' => 'class'
        )
    ),
    'view' => 'tab_item',
    'container_parent' => 'bw_client_slider_wrapper',
));

# testimonial slider wrapper
Bwpb_map::map(array(
    'name' => __( 'Testimonial slider', PBTD ),
    'base' => 'bw_testimonial_slider_wrapper',
    'icon' => 'bwpb-icon-testimonial-slider',
    'description' => __( 'Slider with list of testimonials', PBTD ),
    'category' => __( 'General', PBTD ),
    'params' => array(
        array(
            'type' => 'true_false',
            'heading' => __( 'Enable dot navigation', PBTD ),
            'param_name' => 'dots',
            'width' => 50
        ),
        array(
            'type' => 'true_false',
            'heading' => __( 'Autoheight', PBTD ),
            'param_name' => 'autoheight',
            'width' => 50
        ),
        array(
            'type' => 'true_false',
            'heading' => __( 'Autoplay', PBTD ),
            'param_name' => 'autoplay'
        ),
        array(
            'type' => 'number_slider',
            'heading' => __( 'Autoplay timeout', PBTD ),
            'param_name' => 'autoplay_timeout',
            'min' => 2000,
            'max' => 10000,
            'step' => 500,
            'value' => 5000,
            'append_before' => '',
            'append_after' => 'milliseconds.',
            'description' => '1 second = 1000 milliseconds.',
            'dependency' => array( 'element' => "autoplay", 'value' => '1' ),
        ),
        array(
            'type' => 'colorpicker',
            'heading' => __( 'Text color', PBTD ),
            'param_name' => 'color'
        ),
        array(
            'type' => 'textfield',
            'param_name' => 'class'
        )
    ),
    'view' => 'tab',
    'max_tabs' => 15,
    'container_child' => 'bw_testimonial_slider_item',
    'tab_text' => __( 'Slide', PBTD )
));

# testimonial slider item
Bwpb_map::map(array(
    'name' => __( 'Testimonial slide', PBTD ),
    'base' => 'bw_testimonial_slider_item',
    'icon' => 'bwpb-icon-testimonial-slider-item',
    'description' => __( 'Testimonial slide', PBTD ),
    'category' => __( 'General', PBTD ),
    'params' => array(
        array(
            'type' => 'textfield',
            'param_name' => 'name',
            'heading' => __( 'Name', PBTD ),
            'value' => 'Testimonial name',
            'holder' => 'h4'
        ),
        array(
            'type' => 'textfield',
            'param_name' => 'position',
            'heading' => __( 'Position', PBTD ),
            'value' => 'Some position',
            'holder' => 'span'
        ),
        array(
            'type' => 'image',
            'heading' => __( 'Image', PBTD ),
            'param_name' => 'image',
        ),
        array(
            'type' => 'editor',
            'param_name' => 'content',
            'heading' => __( 'Text', PBTD ),
            'value' => 'Testimonial slider content. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean et nisi euismod, aliquam risus et, tempus augue.',
            'is_content' => true,
        ),
        array(
            'type' => 'textfield',
            'param_name' => 'class'
        )
    ),
    'view' => 'tab_item',
    'container_parent' => 'bw_testimonial_slider_wrapper',
));

# accordion wrapper
Bwpb_map::map(array(
    'name' => __( 'Accordion', PBTD ),
    'base' => 'bw_accordion_wrapper',
    'icon' => 'bwpb-icon-accordion-wrapper',
    'description' => __( 'Accordion', PBTD ),
    'category' => __( 'General', PBTD ),
    'params' => array(
        array(
            'type' => 'textfield',
            'param_name' => 'class'
        )
    ),
    'view' => 'listing',
    'container_child' => 'bw_accordion_item'
));

# accordion item
Bwpb_map::map(array(
    'name' => __( 'Accordion Tab', PBTD ),
    'base' => 'bw_accordion_item',
    'icon' => 'bwpb-icon-accordion-item',
    'description' => __( 'Accordion tab', PBTD ),
    'category' => __( 'General', PBTD ),
    'params' => array(
        array(
            'type' => 'textfield',
            'param_name' => 'title',
            'heading' => __( 'Title', PBTD ),
            'value' =>  __( 'Accordion title', PBTD ),
            'holder' => 'span'
        ),
        array(
            'type' => 'true_false',
            'heading' => __( 'Is active', PBTD ),
            'param_name' => 'is_active',
            'description' => __( 'Enable this options if you want to open this tab by default.', PBTD ),
        ),
        array(
            'type' => 'true_false',
            'heading' => __( 'Enable icon', PBTD ),
            'param_name' => 'enable_icon',
        ),
        array(
            'type' => 'icon',
            'heading' => __( 'Icon', PBTD ),
            'param_name' => 'icon',
            'dependency' => array( 'element' => "enable_icon", 'value' => '1' ),
        ),
        array(
            'type' => 'editor',
            'heading' => __( 'Content', PBTD ),
            'param_name' => 'content',
            'value' => 'Accordion tab. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean et nisi euismod, aliquam risus et, tempus augue.',
            'is_content' => true,
        ),
        array(
            'type' => 'textfield',
            'param_name' => 'class'
        )
    ),
    'view' => 'listing_item',
    'container_parent' => 'bw_accordion_wrapper'
));

# image sequence wrapper
Bwpb_map::map(array(
    'name' => __( 'Image Sequence', PBTD ),
    'base' => 'bw_image_sequence_wrapper',
    'icon' => 'bwpb-icon-image-sequence-wrapper',
    'description' => __( 'Display multiple images with different sequence.', PBTD ),
    'category' => __( 'General', PBTD ),
    'params' => array(
        array(
            'type' => 'image',
            'heading' => __( 'Image mobile', PBTD ),
            'description' => __( 'Upload image to appear on mobile devices.', PBTD ),
            'param_name' => 'mobile_image',
        ),
        array(
            'type' => 'textfield',
            'param_name' => 'class'
        )
    ),
    'view' => 'tab',
    'max_tabs' => 6,
    'container_child' => 'bw_image_sequence_item',
    'tab_text' => __( 'Image', PBTD )
));

# image sequence item
Bwpb_map::map(array(
    'name' => __( 'Image Sequence Layer', PBTD ),
    'base' => 'bw_image_sequence_item',
    'icon' => 'bwpb-icon-image-sequence-item',
    'description' => __( 'Image sequence layer', PBTD ),
    'category' => __( 'General', PBTD ),
    'params' => array(
        array(
            'type' => 'textfield',
            'heading' => __( 'Name', PBTD ),
            'param_name' => 'name',
            'value' => 'Image sequence layer',
            'holder' => 'h4'
        ),
        array(
            'type' => 'image',
            'heading' => __( 'Image', PBTD ),
            'param_name' => 'image',
            'holder' => 'span'
        ),
        array(
            'type' => 'number_slider',
            'heading' => __( 'Delay', PBTD ),
            'param_name' => 'delay',
            'min' => 0,
            'max' => 6000,
            'step' => 50,
            'value' => 300,
            'append_before' => '',
            'append_after' => 'milliseconds.',
            'description' => '1 second = 1000 milliseconds.',
        ),
        array(
            'type' => 'select',
            'heading' => __( 'Animation type', PBTD ),
            'param_name' => 'animation_type',
            'fields' => $animation_effects
        ),
        array(
            'type' => 'select',
            'heading' => __( 'Position', PBTD ),
            'param_name' => 'position',
            'fields' => array(
                'top:0;left:0' => 'Default ( Top Left )',
                'top:0;right:0' => 'Top Right',
                'left:0;bottom:0' => 'Left Bottom',
                'right:0;bottom:0' => 'Right Bottom'
            )
        ),
        array(
            'type' => 'textfield',
            'param_name' => 'class'
        )
    ),
    'view' => 'tab_item',
    'container_parent' => 'bw_image_sequence_wrapper',
));


# heading section
Bwpb_map::map(array(
    'name' => __( 'Heading Section', PBTD ),
    'base' => 'bw_heading_section',
    'icon' => 'bwpb-icon-heading',
    'description' => __( 'Add heading section with content.', PBTD ),
    'open_settings_on_create' => true,
    'category' => __( 'General', PBTD ),
    'params' => array(
        array(
            'type' => 'textfield',
            'heading' => __( 'Title', PBTD ),
            'param_name' => 'title',
            'value' => 'Title for heading section',
            'description' => __( 'Title for heading.', PBTD ),
        ),
        array(
            'type' => 'number_slider',
            'heading' => __( 'Margin top', PBTD ),
            'param_name' => 'margin_top',
            'min' => 0,
            'max' => 120,
            'step' => 1,
            'value' => 30,
            'append_before' => '',
            'append_after' => 'pixels.',
            'width' => 50
        ),
        array(
            'type' => 'number_slider',
            'heading' => __( 'Margin bottom', PBTD ),
            'param_name' => 'margin_bottom',
            'min' => 0,
            'max' => 120,
            'step' => 1,
            'value' => 30,
            'append_before' => '',
            'append_after' => 'pixels.',
            'width' => 50
        ),
        array(
            'type' => 'select',
            'heading' => __( 'Title tag', PBTD ),
            'param_name' => 'h',
            'fields' => array(
                'h1' => 'h1',
                'h2' => 'h2',
                'h3' => 'h3',
                'h4' => 'h4',
                'h5' => 'h5',
                'h6' => 'h6',
            ),
            'value' => 'h2',
            'width' => 50
        ),
        array(
            'type' => 'select',
            'heading' => __( 'Text alignment', PBTD ),
            'param_name' => 'text_alignment',
            'fields' => array( 'inherit' => 'Inherit', 'left' => 'Left', 'center' => 'Center', 'right' => 'Right' ),
            'value' => 'left',
            'width' => 50
        ),
        array(
            'type' => 'colorpicker',
            'heading' => __( "Text color", PBTD ),
            'param_name' => "text_color",
        ),
        array(
            'type' => 'editor',
            'heading' => __( 'Content', PBTD ),
            'param_name' => 'content',
            'value' => 'Heading content. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean et nisi euismod, aliquam risus et, tempus augue.',
            'is_content' => true,
        ),
        array(
            'type' => 'textfield',
            'param_name' => 'class'
        ),
        // animation title
        array(
            'type' => 'true_false',
            'heading' => __( 'Enable title animation', PBTD ),
            'param_name' => 'animation_title',
            'tab' => __( 'Animation', PBTD )
        ),
        array(
            'type' => 'select',
            'heading' => __( 'Title animation type', PBTD ),
            'param_name' => 'animation_title_type',
            'fields' => $animation_effects,
            'dependency' => array( 'element' => "animation_title", 'value' => '1' ),
            'tab' => __( 'Animation', PBTD )
        ),
        array(
            'type' => 'number_slider',
            'heading' => __( 'Title animation delay', PBTD ),
            'param_name' => 'animation_title_delay',
            'min' => 0,
            'max' => 6000,
            'step' => 50,
            'append_before' => '',
            'append_after' => 'milliseconds.',
            'description' => '1 second = 1000 milliseconds.',
            'dependency' => array( 'element' => "animation_title", 'value' => '1' ),
            'tab' => __( 'Animation', PBTD )
        ),
        // animation content
        array(
            'type' => 'true_false',
            'heading' => __( 'Enable content animation', PBTD ),
            'param_name' => 'animation_content',
            'tab' => __( 'Animation', PBTD )
        ),
        array(
            'type' => 'select',
            'heading' => __( 'Content animation type', PBTD ),
            'param_name' => 'animation_content_type',
            'fields' => $animation_effects,
            'dependency' => array( 'element' => "animation_content", 'value' => '1' ),
            'tab' => __( 'Animation', PBTD )
        ),
        array(
            'type' => 'number_slider',
            'heading' => __( 'Content animation delay', PBTD ),
            'param_name' => 'animation_content_delay',
            'min' => 0,
            'max' => 6000,
            'step' => 50,
            'append_before' => '',
            'append_after' => 'milliseconds.',
            'description' => '1 second = 1000 milliseconds.',
            'dependency' => array( 'element' => "animation_content", 'value' => '1' ),
            'tab' => __( 'Animation', PBTD )
        )
    )
));


# unordered list wrapper
Bwpb_map::map(array(
    'name' => __( 'Unordered List', PBTD ),
    'base' => 'bw_list_wrapper',
    'icon' => 'bwpb-icon-list-wrapper',
    'description' => __( 'Unordered list wrapper', PBTD ),
    'category' => __( 'General', PBTD ),
    'params' => array(
        array(
            'type' => 'number_slider',
            'heading' => __( 'List items per row', PBTD ),
            'param_name' => 'items_per_row',
            'min' => 1,
            'max' => 6,
            'step' => 1,
            'value' => 1,
            'append_before' => '',
            'append_after' => 'item(s)'
        ),
        array(
            'type' => 'colorpicker',
            'param_name' => 'text_color',
            'heading' => __( 'Text Color', PBTD ),
        ),
        array(
            'type' => 'select',
            'heading' => __( 'Text alignment', PBTD ),
            'param_name' => 'text_alignment',
            'fields' => array( 'left' => 'Left', 'center' => 'Center', 'right' => 'Right' ),
            'width' => 50
        ),
        array(
            'type' => 'select',
            'heading' => __( 'Decoration', PBTD ),
            'param_name' => 'decoration',
            'fields' => array(
                '' => 'None',
                'circle' => 'Circle',
                'circle-big' => 'Big circle',
                'square' => 'Square',
                'square-big' => 'Big square'
            ),
            'value' => 'circle',
            'width' => 50
        ),
        array(
            'type' => 'colorpicker',
            'param_name' => 'decoration_color',
            'heading' => __( 'Decoration Color', PBTD ),
            'dependency' => array( 'element' => "decoration", 'not_empty' => true ),
        ),
        // animation content
        array(
            'type' => 'true_false',
            'heading' => __( 'Enable animation', PBTD ),
            'param_name' => 'animation',
            'tab' => __( 'Animation', PBTD )
        ),
        array(
            'type' => 'select',
            'heading' => __( 'Animation type', PBTD ),
            'param_name' => 'animation_type',
            'fields' => $animation_effects,
            'dependency' => array( 'element' => "animation", 'value' => '1' ),
            'tab' => __( 'Animation', PBTD )
        ),
        array(
            'type' => 'number_slider',
            'heading' => __( 'Animation delay sequence', PBTD ),
            'param_name' => 'animation_delay',
            'min' => 0,
            'max' => 1000,
            'step' => 50,
            'append_before' => '',
            'append_after' => 'milliseconds.',
            'description' => '1 second = 1000 milliseconds. The animation delay between each list items.',
            'dependency' => array( 'element' => "animation", 'value' => '1' ),
            'tab' => __( 'Animation', PBTD )
        ),
        array(
            'type' => 'textfield',
            'param_name' => 'class'
        )
    ),
    'view' => 'listing',
    'container_child' => 'bw_list_item'
));

# unordered list item
Bwpb_map::map(array(
    'name' => __( 'Unordered List Item', PBTD ),
    'base' => 'bw_list_item',
    'icon' => 'bwpb-icon-list-item',
    'description' => __( 'Unordered list item', PBTD ),
    'category' => __( 'General', PBTD ),
    'params' => array(
        array(
            'type' => 'textfield',
            'param_name' => 'name',
            'heading' => __( 'Name', PBTD ),
            'value' => 'Unordered list item.',
            'holder' => 'span'
        ),
        array(
            'type' => 'select',
            'heading' => __( 'Decoration', PBTD ),
            'param_name' => 'decoration',
            'fields' => array(
                '' => 'Default',
                'icon' => 'Icon from library',
                'class' => 'Custom class',
            ),
        ),
        array(
            'type' => 'icon',
            'heading' => __( 'Icon', PBTD ),
            'param_name' => 'icon',
            'dependency' => array( 'element' => "decoration", 'value' => 'icon' ),
        ),
        array(
            'type' => 'textfield',
            'param_name' => 'custom_class',
            'heading' => __( 'Custom class', PBTD ),
            'description' => __( 'The class will affect only the decoration for this item.', PBTD ),
            'dependency' => array( 'element' => "decoration", 'value' => 'class' ),
        ),
        array(
            'type' => 'textfield',
            'param_name' => 'class'
        )
    ),
    'view' => 'listing_item',
    'container_parent' => 'bw_list_wrapper'
));

# image slider wrapper
Bwpb_map::map(array(
    'name' => __( 'Image slider', PBTD ),
    'base' => 'bw_slider_wrapper',
    'icon' => 'bwpb-icon-slider-wrapper',
    'description' => __( 'Slider with image content.', PBTD ),
    'category' => __( 'General', PBTD ),
    'params' => array(
        array(
            'type' => 'true_false',
            'heading' => __( 'Enable dot navigation', PBTD ),
            'param_name' => 'dots',
            'width' => 50
        ),
        array(
            'type' => 'true_false',
            'heading' => __( 'Autoheight', PBTD ),
            'param_name' => 'autoheight',
            'description' => __( 'Change the slide height automatically on the image height.', PBTD ),
            'width' => 50
        ),
        array(
            'type' => 'true_false',
            'heading' => __( 'Autoplay', PBTD ),
            'param_name' => 'autoplay'
        ),
        array(
            'type' => 'true_false',
            'heading' => __( 'Enable arrow navigation', PBTD ),
            'param_name' => 'nav',
        ),
        array(
            'type' => 'number_slider',
            'heading' => __( 'Autoplay timeout', PBTD ),
            'param_name' => 'autoplay_timeout',
            'min' => 2000,
            'max' => 10000,
            'step' => 500,
            'value' => 5000,
            'append_before' => '',
            'append_after' => 'milliseconds.',
            'description' => '1 second = 1000 milliseconds.',
            'dependency' => array( 'element' => "autoplay", 'value' => '1' ),
        ),
        array(
            'type' => 'textfield',
            'param_name' => 'class'
        )
    ),
    'view' => 'listing',
    'container_child' => 'bw_slider_item'
));

# slider item
Bwpb_map::map(array(
    'name' => __( 'Image slide', PBTD ),
    'base' => 'bw_slider_item',
    'icon' => 'bwpb-icon-slider-item',
    'description' => __( 'Slide with image', PBTD ),
    'category' => __( 'General', PBTD ),
    'params' => array(
        array(
            'type' => 'textfield',
            'param_name' => 'name',
            'heading' => __( 'Name', PBTD ),
            'value' => 'Slide name',
            'holder' => 'h4'
        ),
        array(
            'type' => 'image',
            'heading' => __( 'Image', PBTD ),
            'param_name' => 'image',
        ),
        array(
            'type' => 'textfield',
            'param_name' => 'class'
        )
    ),
    'view' => 'listing_item',
    'container_parent' => 'bw_slider_wrapper'
));

//if ( is_plugin_active( 'revslider/revslider.php' ) )
if( in_array( 'revslider/revslider.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {

    global $wpdb;
    
    $rs = $wpdb->get_results("SELECT id, title, alias FROM {$wpdb->prefix}revslider_sliders ORDER BY id ASC LIMIT 999");
    $revsliders = array();
    
    if( $rs ) {
        foreach ( $rs as $slider ) {
            $revsliders[$slider->alias] = $slider->title;
        }
    }else{
        $revsliders[0] = __( 'No sliders found', PBTD );
    }
    
    Bwpb_map::map(array(
        'name' => __( 'Revolution Slider', PBTD ),
        'base' => 'vendors_rev_slider',
        'icon' => 'bwpb-icon-rev-slider',
        'description' => __( 'Add image slider', PBTD ),
        'category' => __( 'General', PBTD ),
        'open_settings_on_create' => true,
        'params' => array(
            array(
                'type' => 'select',
                'param_name' => 'alias',
                'heading' => __( 'Select slider', PBTD ),
                'fields' => $revsliders,
                'holder' => 'h4'
            ),
        )
    ));
}

//if ( is_plugin_active( 'contact-form-7/wp-contact-form-7.php' ) )
if( in_array( 'contact-form-7/wp-contact-form-7.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    
    global $wpdb;
    
    $cf7s = $wpdb->get_results("SELECT $wpdb->posts.* 
    FROM $wpdb->posts, $wpdb->postmeta
    WHERE $wpdb->posts.ID = $wpdb->postmeta.post_id 
    AND $wpdb->postmeta.meta_key = '_form' 
    AND $wpdb->posts.post_status = 'publish' 
    AND $wpdb->posts.post_type = 'wpcf7_contact_form'
    ORDER BY $wpdb->posts.post_name DESC");
    $contact_form_7 = array();
    
    if( $cf7s ) {
        foreach ( $cf7s as $cf7form ) {
            $contact_form_7[ (int)$cf7form->ID ] = esc_attr( $cf7form->post_title );
        }
    }else{
        $contact_form_7[0] = __( 'No sliders found', PBTD );
    }
    
    Bwpb_map::map(array(
        'name' => __( 'Contact Form 7', PBTD ),
        'base' => 'vendors_cf7',
        'icon' => 'bwpb-icon-cf7',
        'description' => __( 'Add contact form', PBTD ),
        'category' => __( 'General', PBTD ),
        'open_settings_on_create' => true,
        'params' => array(
            array(
                'type' => 'select',
                'param_name' => 'form_id',
                'heading' => __( 'Select form', PBTD ),
                'fields' => $contact_form_7,
                'holder' => 'h4'
            ),
        )
    ));
}


